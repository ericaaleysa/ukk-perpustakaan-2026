@extends('layouts.app')

@section('title', 'NEX-LIB ADMIN -- Verifikasi Keanggotaan')

@section('content')

<div class="admin-page">

    <div class="d-flex flex-wrap align-items-end justify-content-between gap-3 mb-4">
        <div>
            <h1 class="h3 admin-title">Verifikasi Keanggotaan</h1>
            <p class="admin-subtitle">Periksa pengajuan siswa, lalu setujui atau tolak.</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">&larr; Kembali</a>
    </div>

    <div class="card admin-panel no-hover-lift">
        @if(count($daftarPengajuan) === 0)
            <div class="admin-empty">
                <strong>Tidak ada pengajuan</strong>
                Semua pengajuan keanggotaan sudah diproses.
            </div>
        @else
        <div class="table-responsive">
            <table class="table admin-table table-hover align-middle">
                <thead>
                    <tr>
                        <th style="width: 60px;">No</th>
                        <th>Nama lengkap</th>
                        <th>NIS</th>
                        <th>Kelas</th>
                        <th>Tanggal pengajuan</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @foreach($daftarPengajuan as $p)
                    <tr>
                        <td class="cell-meta">{{ $no++ }}</td>
                        <td>
                            <div class="cell-main">{{ $p->nama_lengkap }}</div>
                            <div class="cell-meta">{{ $p->pemohon->username ?? '-' }}</div>
                        </td>
                        <td>{{ $p->nis }}</td>
                        <td>{{ $p->kelas }}</td>
                        <td class="cell-meta">{{ $p->tanggal_pengajuan }}</td>
                        <td class="text-end">
                            <div class="text-nowrap">
                                <form action="{{ route('keanggotaan.approve', [$p->id_pengajuan]) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-sm btn-brand rounded-pill px-3">Setujui</button>
                                </form>
                                <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3" data-bs-toggle="collapse" data-bs-target="#tolak{{ $p->id_pengajuan }}">Tolak</button>
                            </div>
                            <div class="collapse mt-2" id="tolak{{ $p->id_pengajuan }}">
                                <form action="{{ route('keanggotaan.reject', [$p->id_pengajuan]) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="input-group input-group-sm">
                                        <input type="text" name="catatan_admin" class="form-control" placeholder="Alasan penolakan (opsional)">
                                        <button type="submit" class="btn btn-outline-secondary">Kirim penolakan</button>
                                    </div>
                                </form>
                            </div>
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