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
    $no = 1;
@endphp

<div class="admin-page">

    <div class="d-flex flex-wrap align-items-end justify-content-between gap-3 mb-4">
        <div>
            <h1 class="h3 admin-title">Transaksi Peminjaman</h1>
            <p class="admin-subtitle">Setujui pengajuan dan konfirmasi pengembalian buku.</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">&larr; Kembali</a>
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
                    <button type="submit" class="btn btn-sm btn-brand rounded-pill px-3">Terapkan</button>
                    @if($tanggalDari || $tanggalSampai)
                        <a href="{{ route('peminjaman.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">Reset</a>
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
                        <th class="text-end">Aksi</th>
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
                        <td><span class="status-pill {{ $statusKelas[$p->status] ?? 'status-kosong' }}">{{ $statusLabel[$p->status] ?? $p->status }}</span></td>
                        <td class="{{ $p->denda > 0 ? 'cell-main' : 'cell-meta' }}">{{ $p->denda > 0 ? 'Rp' . number_format($p->denda, 0, ',', '.') : '-' }}</td>
                        <td class="text-end">
                            @if($p->status === 'menunggu_konfirmasi')
                                <div class="text-nowrap">
                                    <form action="{{ route('peminjaman.setujui', [$p->id_peminjaman]) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-sm btn-brand rounded-pill px-3">Setujui</button>
                                    </form>
                                    <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3" data-bs-toggle="collapse" data-bs-target="#tolak{{ $p->id_peminjaman }}">Tolak</button>
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
                                <form action="{{ route('peminjaman.kembali', [$p->id_peminjaman]) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-sm btn-outline-brand rounded-pill px-3">Konfirmasi kembali</button>
                                </form>
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

@endsection