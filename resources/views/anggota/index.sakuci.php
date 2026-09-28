@extends('layouts.app')

@section('title', 'NEX-LIB ADMIN -- Kelola Anggota')

@section('content')

<div class="admin-page">

    <div class="d-flex flex-wrap align-items-end justify-content-between gap-3 mb-4">
        <div>
            <h1 class="h3 admin-title">Kelola Anggota</h1>
            <p class="admin-subtitle">Atur status keaktifan anggota perpustakaan.</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">&larr; Kembali</a>
    </div>

    <div class="card admin-panel no-hover-lift">
        @if(count($daftarSiswa) === 0)
            <div class="admin-empty">
                <strong>Belum ada akun siswa</strong>
                Akun siswa akan muncul di sini setelah mereka mendaftar.
            </div>
        @else
        <div class="table-responsive">
            <table class="table admin-table table-hover align-middle">
                <thead>
                    <tr>
                        <th style="width: 60px;">No</th>
                        <th>Username</th>
                        <th>Status keanggotaan</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @foreach($daftarSiswa as $s)
                    <tr>
                        <td class="cell-meta">{{ $no++ }}</td>
                        <td class="cell-main">{{ $s->username }}</td>
                        <td>
                            @if($s->status_keanggotaan === 'aktif')
                                <span class="status-pill status-aktif">Aktif</span>
                            @elseif($s->status_keanggotaan === 'non_aktif')
                                <span class="status-pill status-nonaktif">Non-aktif</span>
                            @elseif($s->status_keanggotaan === 'menunggu_verifikasi')
                                <span class="status-pill status-menunggu">Menunggu verifikasi</span>
                            @else
                                <span class="status-pill status-kosong">Non-anggota</span>
                            @endif
                        </td>
                        <td class="text-end text-nowrap">
                            @if($s->status_keanggotaan === 'aktif')
                                <form action="{{ route('anggota.nonaktifkan', [$s->id]) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Nonaktifkan anggota ini?')">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-sm btn-outline-secondary rounded-pill px-3">Nonaktifkan</button>
                                </form>
                            @elseif($s->status_keanggotaan === 'non_aktif')
                                <form action="{{ route('anggota.aktifkan', [$s->id]) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-sm btn-brand rounded-pill px-3">Aktifkan kembali</button>
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