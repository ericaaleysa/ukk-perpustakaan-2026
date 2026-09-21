@extends('layouts.app')

@section('title', 'Kelola Transaksi Peminjaman')

@section('content')

<h1 class="h4 mb-3">Kelola Transaksi Peminjaman</h1>

@if(count($daftarPeminjaman) === 0)
    <p class="text-secondary">Belum ada transaksi peminjaman.</p>
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