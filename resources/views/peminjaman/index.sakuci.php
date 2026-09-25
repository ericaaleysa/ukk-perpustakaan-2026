@extends('layouts.app')

@section('title', 'Kelola Transaksi Peminjaman')

@section('content')

<div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h4 mb-0">Manage Transaksi Peminjaman</h1>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-outline-secondary">&larr; Kembali</a>
    </div>

<form method="GET" action="{{ route('peminjaman.index') }}" class="row g-2 align-items-end mb-3">
    <div class="col-auto">
        <label class="form-label small mb-0">Dari Tanggal Pinjam</label>
        <input type="date" name="tanggal_dari" class="form-control form-control-sm" value="{{ $tanggalDari }}">
    </div>
    <div class="col-auto">
        <label class="form-label small mb-0">Sampai Tanggal Pinjam</label>
        <input type="date" name="tanggal_sampai" class="form-control form-control-sm" value="{{ $tanggalSampai }}">
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-sm btn-primary">Cari</button>
        @if($tanggalDari || $tanggalSampai)
            <a href="{{ route('peminjaman.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
        @endif
    </div>
</form>

@if(count($daftarPeminjaman) === 0)
    <p class="text-secondary">Tidak ada transaksi peminjaman yang cocok.</p>
@else
<table class="table table-striped table-hover align-middle">
    <thead>
        <tr>
            <th>No</th>
            <th>Peminjam</th>
            <th>Judul Buku</th>
            <th>Tanggal Pinjam</th>
            <th>Wajib Kembali</th>
            <th>Status</th>
            <th>Denda</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @php $no = 1; @endphp
        @foreach($daftarPeminjaman as $p)
        <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $p->peminjam->username ?? '-' }}</td>
            <td>{{ $p->buku->judul_buku ?? '-' }}</td>
            <td>{{ $p->tanggal_pinjam }}</td>
            <td>{{ $p->tanggal_wajib_kembali }}</td>
            <td>
                @if($p->status === 'menunggu_konfirmasi')
                    <span class="badge bg-warning text-dark">Menunggu Konfirmasi</span>
                @elseif($p->status === 'dipinjam')
                    <span class="badge bg-primary">Dipinjam</span>
                @elseif($p->status === 'ditolak')
                    <span class="badge bg-danger">Ditolak</span>
                @elseif($p->status === 'dikembalikan')
                    <span class="badge bg-success">Dikembalikan</span>
                @endif
            </td>
            <td>{{ $p->denda > 0 ? 'Rp' . number_format($p->denda, 0, ',', '.') : '-' }}</td>
            <td>
                @if($p->status === 'menunggu_konfirmasi')
                    <form action="{{ route('peminjaman.setujui', [$p->id_peminjaman]) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-sm btn-success">Setujui</button>
                    </form>
                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="collapse" data-bs-target="#tolak{{ $p->id_peminjaman }}">Tolak</button>
                    <div class="collapse mt-2" id="tolak{{ $p->id_peminjaman }}">
                        <form action="{{ route('peminjaman.tolak', [$p->id_peminjaman]) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="input-group input-group-sm">
                                <input type="text" name="catatan_admin" class="form-control" placeholder="Alasan (opsional)">
                                <button type="submit" class="btn btn-outline-danger">Kirim</button>
                            </div>
                        </form>
                    </div>
                @elseif($p->status === 'dipinjam')
                    <form action="{{ route('peminjaman.kembali', [$p->id_peminjaman]) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-sm btn-outline-primary">Konfirmasi Kembali</button>
                    </form>
                @else
                    <span class="text-secondary small">-</span>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif

@endsection