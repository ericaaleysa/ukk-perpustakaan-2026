@extends('layouts.app')

@section('title', 'NEX-LIB ADMIN -- Kelola Anggota')

@section('content')

<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h4 mb-0">Manage Anggota</h1>
    </div>
    <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-outline-secondary">&larr; Kembali</a>
</div>

@if(count($daftarSiswa) === 0)
    <p class="text-secondary">Belum ada akun siswa terdaftar.</p>
@else
<table class="table table-striped table-hover align-middle">
    <thead>
        <tr>
            <th>No</th>
            <th>Username</th>
            <th>Status Keanggotaan</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @php $no = 1; @endphp
        @foreach($daftarSiswa as $s)
        <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $s->username }}</td>
            <td>
                @if($s->status_keanggotaan === 'aktif')
                    <span class="badge bg-success">Aktif</span>
                @elseif($s->status_keanggotaan === 'non_aktif')
                    <span class="badge bg-secondary">Non-Aktif</span>
                @elseif($s->status_keanggotaan === 'menunggu_verifikasi')
                    <span class="badge bg-warning text-dark">Menunggu Verifikasi</span>
                @else
                    <span class="badge bg-light text-dark border">Non-Anggota</span>
                @endif
            </td>
            <td>
                @if($s->status_keanggotaan === 'aktif')
                    <form action="{{ route('anggota.nonaktifkan', [$s->id]) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-sm btn-outline-secondary">Nonaktifkan</button>
                    </form>
                @elseif($s->status_keanggotaan === 'non_aktif')
                    <form action="{{ route('anggota.aktifkan', [$s->id]) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-sm btn-success">Aktifkan Kembali</button>
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