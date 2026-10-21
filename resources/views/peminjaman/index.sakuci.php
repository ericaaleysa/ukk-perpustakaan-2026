@extends('layouts.app')

@section('title', 'Kelola Transaksi Peminjaman')

@section('content')

@php
    $statusKelas = [
        'menunggu_konfirmasi' => 'status-menunggu',
        'dipinjam' => 'status-aktif',
        'dikembalikan' => 'status-selesai',
        'ditolak' => 'status-nonaktif',
    ];
    $statusLabel = [
        'menunggu_konfirmasi' => 'Menunggu konfirmasi',
        'dipinjam' => 'Dipinjam',
        'dikembalikan' => 'Dikembalikan',
        'ditolak' => 'Ditolak',
    ];
    $labelKondisi = [
        'baik' => 'Baik',
        'rusak_ringan' => 'Rusak ringan',
        'rusak_berat' => 'Rusak berat',
        'hilang' => 'Hilang',
    ];
    $no = 1;
@endphp

<div class="admin-page">

    <div class="d-flex flex-wrap align-items-end justify-content-between gap-3 mb-4">
        <div>
            <h1 class="h3 admin-title">Transaksi Peminjaman</h1>
            <p class="admin-subtitle">Setujui pengajuan dan konfirmasi pengembalian buku.</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-outline-secondary px-3">&larr; Kembali</a>
    </div>

    <div class="card admin-panel no-hover-lift">

        <div class="card-body pb-2">
            <form method="GET" action="{{ route('peminjaman.index') }}" class="row g-2 align-items-end">
                <div class="col-auto">
                    <label class="form-label admin-label small mb-1">Dari tanggal pinjam</label>
                    <input type="date" name="tanggal_dari" class="form-control form-control-sm" value="{{ $tanggalDari }}">
                </div>
                <div class="col-auto">
                    <label class="form-label admin-label small mb-1">Sampai tanggal pinjam</label>
                    <input type="date" name="tanggal_sampai" class="form-control form-control-sm" value="{{ $tanggalSampai }}">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-sm btn-brand px-3">Terapkan</button>
                    @if($tanggalDari || $tanggalSampai)
                        <a href="{{ route('peminjaman.index') }}" class="btn btn-sm btn-outline-secondary px-3">Reset</a>
                    @endif
                </div>
            </form>
        </div>

        @if(count($daftarPeminjaman) === 0)
            <div class="admin-empty">
                <strong>Tidak ada transaksi</strong>
                Belum ada peminjaman yang cocok dengan filter ini.
            </div>
        @else
        <div class="table-responsive">
            <table class="table admin-table table-hover align-middle">
                <thead>
                    <tr>
                        <th style="width: 60px;">No</th>
                        <th>Peminjam</th>
                        <th>Judul buku</th>
                        <th>Tanggal pinjam</th>
                        <th>Wajib kembali</th>
                        <th>Status</th>
                        <th>Denda</th>
                        <th class="text-end" style="width: 290px; min-width: 290px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($daftarPeminjaman as $p)
                    <tr>
                        <td class="cell-meta">{{ $no++ }}</td>
                        <td class="cell-main">{{ $p->peminjam->username ?? '-' }}</td>
                        <td>{{ $p->buku->judul_buku ?? '-' }}</td>
                        <td class="cell-meta">{{ $p->tanggal_pinjam ?: '-' }}</td>
                        <td class="cell-meta">{{ $p->tanggal_wajib_kembali ?: '-' }}</td>
                        <td>
                            @if($p->status === 'dikembalikan' && ($p->kondisi_kembali ?? '') === 'hilang')
                                <span class="status-pill status-nonaktif">Hilang</span>
                            @else
                                <span class="status-pill {{ $statusKelas[$p->status] ?? 'status-kosong' }}">{{ $statusLabel[$p->status] ?? $p->status }}</span>
                            @endif
                            @if($p->status === 'dikembalikan' && !empty($p->kondisi_kembali) && !in_array($p->kondisi_kembali, ['baik', 'hilang']))
                                <div class="cell-meta mt-1">Kondisi: {{ $labelKondisi[$p->kondisi_kembali] ?? $p->kondisi_kembali }}</div>
                            @endif
                            @if(!empty($p->catatan_kondisi))
                                <div class="cell-meta mt-1">{{ $p->catatan_kondisi }}</div>
                            @endif
                        </td>
                        <td class="{{ $p->denda > 0 ? 'cell-main' : 'cell-meta' }}">
                            {{ $p->denda > 0 ? 'Rp' . number_format($p->denda, 0, ',', '.') : '-' }}
                            @if(($p->denda_telat ?? 0) > 0 && ($p->denda_kondisi ?? 0) > 0)
                                <div class="cell-meta">Telat Rp{{ number_format($p->denda_telat, 0, ',', '.') }} &middot; Kondisi Rp{{ number_format($p->denda_kondisi, 0, ',', '.') }}</div>
                            @endif
                            @if($p->denda > 0 && $p->status === 'dikembalikan')
                                @if(($p->status_denda ?? '') === 'lunas')
                                    <div class="mt-1"><span class="status-pill status-selesai">Lunas</span></div>
                                    @if(!empty($p->tanggal_bayar_denda))
                                        <div class="cell-meta">{{ date('d M Y', strtotime($p->tanggal_bayar_denda)) }}</div>
                                    @endif
                                    @if(!empty($p->catatan_bayar))
                                        <div class="cell-meta">{{ $p->catatan_bayar }}</div>
                                    @endif
                                @else
                                    <div class="mt-1"><span class="status-pill status-menunggu">Belum dibayar</span></div>
                                @endif
                            @endif
                        </td>
                        <td class="text-end">
                            @if($p->status === 'menunggu_konfirmasi')
                                <div class="text-nowrap">
                                    <form action="{{ route('peminjaman.setujui', [$p->id_peminjaman]) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-sm btn-brand px-3">Setujui</button>
                                    </form>
                                    <button type="button" class="btn btn-sm btn-outline-secondary px-3" data-bs-toggle="collapse" data-bs-target="#tolak{{ $p->id_peminjaman }}">Tolak</button>
                                </div>
                                <div class="collapse mt-2" id="tolak{{ $p->id_peminjaman }}">
                                    <form action="{{ route('peminjaman.tolak', [$p->id_peminjaman]) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="input-group input-group-sm">
                                            <input type="text" name="catatan_admin" class="form-control" placeholder="Alasan (opsional)">
                                            <button type="submit" class="btn btn-outline-secondary">Kirim</button>
                                        </div>
                                    </form>
                                </div>
                            @elseif($p->status === 'dipinjam')
                                <button type="button" class="btn btn-sm btn-outline-brand px-3" data-bs-toggle="collapse" data-bs-target="#kembali{{ $p->id_peminjaman }}">Konfirmasi kembali</button>
                                <div class="collapse mt-2" id="kembali{{ $p->id_peminjaman }}">
                                    <form action="{{ route('peminjaman.kembali', [$p->id_peminjaman]) }}" method="POST" class="text-start" style="width: 100%;">
                                        @csrf
                                        @method('PUT')
                                        <label class="form-label admin-label small mb-1">Kondisi buku</label>
                                        <select name="kondisi_kembali" class="form-select form-select-sm mb-2" onchange="isiDendaKondisi(this)">
                                            @foreach($labelKondisi as $kode => $label)
                                                <option value="{{ $kode }}" data-denda="{{ $dendaKondisiDefault[$kode] ?? 0 }}">{{ $label }}</option>
                                            @endforeach
                                        </select>
                                        <label class="form-label admin-label small mb-1">Denda kondisi (Rp)</label>
                                        <input type="number" name="denda_kondisi" min="0" step="1000" value="0" class="form-control form-control-sm mb-1">
                                        <div class="admin-hint small mb-2">Denda telat dihitung otomatis. Nominal di atas boleh diubah (misalnya sesuai harga buku yang hilang).</div>
                                        <input type="text" name="catatan_kondisi" maxlength="255" class="form-control form-control-sm mb-2" placeholder="Catatan kondisi (opsional)">
                                        <button type="submit" class="btn btn-sm btn-brand w-100">Konfirmasi pengembalian</button>
                                    </form>
                                </div>
                            @elseif($p->status === 'dikembalikan' && $p->denda > 0 && ($p->status_denda ?? '') !== 'lunas')
                                <button type="button" class="btn btn-sm btn-outline-brand px-3" data-bs-toggle="collapse" data-bs-target="#bayar{{ $p->id_peminjaman }}">Catat pembayaran</button>
                                <div class="collapse mt-2" id="bayar{{ $p->id_peminjaman }}">
                                    <form action="{{ route('peminjaman.bayar_denda', [$p->id_peminjaman]) }}" method="POST" class="text-start" style="width: 100%;"
                                          onsubmit="return confirm('Tandai denda Rp{{ number_format($p->denda, 0, ',', '.') }} sebagai sudah dibayar?')">
                                        @csrf
                                        @method('PUT')
                                        <div class="admin-hint small mb-2">Denda yang harus dibayar: <strong>Rp{{ number_format($p->denda, 0, ',', '.') }}</strong></div>
                                        <input type="text" name="catatan_bayar" maxlength="255" class="form-control form-control-sm mb-2" placeholder="Catatan (opsional), mis. dibayar tunai">
                                        <button type="submit" class="btn btn-sm btn-brand w-100">Tandai sudah dibayar</button>
                                    </form>
                                </div>
                            @else
                                <span class="cell-meta">-</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>

</div>

<script>
    // Isi otomatis nominal denda sesuai kondisi yang dipilih (tetap bisa diubah admin)
    function isiDendaKondisi(select) {
        var form = select.closest('form');
        var input = form.querySelector('[name="denda_kondisi"]');
        input.value = select.options[select.selectedIndex].getAttribute('data-denda');
    }
</script>

@endsection