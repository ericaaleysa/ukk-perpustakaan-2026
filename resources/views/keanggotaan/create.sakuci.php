@extends('layouts.app')

@section('title', 'Pengajuan Keanggotaan')

@section('content')

<h1 class="h4 mb-3">Pengajuan Keanggotaan Perpustakaan</h1>

@if($currentUser->status_keanggotaan === 'aktif')
    <div class="alert alert-success">
        Anda sudah terdaftar sebagai <strong>Anggota Aktif</strong> perpustakaan. Silakan lanjut ke menu Peminjaman Buku.
    </div>
@elseif($currentUser->status_keanggotaan === 'menunggu_verifikasi')
    <div class="alert alert-warning">
        Pengajuan Anda sedang <strong>menunggu verifikasi</strong> dari admin/petugas perpustakaan. Silakan tunggu konfirmasi selanjutnya.
    </div>
@elseif($currentUser->status_keanggotaan === 'non_aktif')
    <div class="alert alert-secondary">
        Keanggotaan Anda saat ini <strong>dinonaktifkan</strong> oleh admin/petugas perpustakaan.
        Silakan hubungi admin/petugas perpustakaan secara langsung untuk mengaktifkan kembali keanggotaan Anda.
    </div>
@else
    @if($pengajuanTerakhir && $pengajuanTerakhir->status === 'ditolak')
        <div class="alert alert-danger">
            Pengajuan sebelumnya <strong>ditolak</strong>.
            @if($pengajuanTerakhir->catatan_admin)
                Catatan admin: {{ $pengajuanTerakhir->catatan_admin }}.
            @endif
            Silakan ajukan kembali di bawah ini.
        </div>
    @endif

    <form action="{{ route('keanggotaan.store') }}" method="POST">
        @csrf
        <div class="form-group mb-3">
            <label for="nama_lengkap">Nama Lengkap</label>
            <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control" required>
        </div>
        <div class="form-group mb-3">
            <label for="nis">NIS (Nomor Induk Siswa)</label>
            <input type="text" name="nis" id="nis" class="form-control" required>
        </div>
        <div class="form-group mb-3">
            <label for="kelas">Kelas</label>
            <input type="text" name="kelas" id="kelas" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Ajukan Keanggotaan</button>
    </form>
@endif

@endsection