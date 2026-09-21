@extends('layouts.app')

@section('title', 'Kelola Anggota')

@section('content')

<h1 class="h4 mb-3">Kelola Anggota</h1>

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
                    <form action="{{ route('admin.anggota.nonaktifkan', [$s->id]) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-sm btn-outline-secondary">Nonaktifkan</button>
                    </form>
                @elseif($s->status_keanggotaan === 'non_aktif')
                    <form action="{{ route('admin.anggota.aktifkan', [$s->id]) }}" method="POST" class="d-inline">
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