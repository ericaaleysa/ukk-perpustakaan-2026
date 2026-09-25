@extends('layouts.app')

@section('title', 'NEX-LIB ADMIN -- Verifikasi Keanggotaan')

@section('content')

<div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h4 mb-0">Verif Keanggotaan</h1>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-outline-secondary">&larr; Kembali</a>
    </div>

@if(count($daftarPengajuan) === 0)
    <p class="text-secondary">Tidak ada pengajuan yang menunggu verifikasi.</p>
@else
<table class="table table-striped table-hover align-middle">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Lengkap</th>
            <th>Username</th>
            <th>NIS</th>
            <th>Kelas</th>
            <th>Tanggal Pengajuan</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @php $no = 1; @endphp
        @foreach($daftarPengajuan as $p)
        <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $p->nama_lengkap }}</td>
            <td>{{ $p->pemohon->username ?? '-' }}</td>
            <td>{{ $p->nis }}</td>
            <td>{{ $p->kelas }}</td>
            <td>{{ $p->tanggal_pengajuan }}</td>
            <td>
                <form action="{{ route('keanggotaan.approve', [$p->id_pengajuan]) }}" method="POST" class="d-inline">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-sm btn-success">Setujui</button>
                </form>

                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="collapse" data-bs-target="#tolak{{ $p->id_pengajuan }}">
                    Tolak
                </button>

                <div class="collapse mt-2" id="tolak{{ $p->id_pengajuan }}">
                    <form action="{{ route('keanggotaan.reject', [$p->id_pengajuan]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="input-group input-group-sm">
                            <input type="text" name="catatan_admin" class="form-control" placeholder="Alasan penolakan (opsional)">
                            <button type="submit" class="btn btn-outline-danger">Kirim Penolakan</button>
                        </div>
                    </form>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif

@endsection