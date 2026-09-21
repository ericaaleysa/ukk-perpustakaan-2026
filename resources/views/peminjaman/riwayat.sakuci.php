@extends('layouts.app')

@section('title', 'Riwayat Peminjaman')

@section('content')

<h1 class="h4 mb-3">Riwayat Peminjaman Saya</h1>

@if(count($daftarPeminjaman) === 0)
    <p class="text-secondary">Anda belum pernah mengajukan peminjaman buku.</p>
@else
<table class="table table-striped table-hover align-middle">
    <thead>
        <tr>
            <th>No</th>
            <th>Judul Buku</th>
            <th>Tanggal Pinjam</th>
            <th>Wajib Kembali</th>
            <th>Status</th>
            <th>Denda</th>
        </tr>
    </thead>
    <tbody>
        @php $no = 1; @endphp
        @foreach($daftarPeminjaman as $p)
        <tr>
            <td>{{ $no++ }}</td>
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
        </tr>
        @endforeach
    </tbody>
</table>
@endif

@endsection