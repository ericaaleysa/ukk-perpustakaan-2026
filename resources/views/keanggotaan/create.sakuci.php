@extends('layouts.app')

@section('title', 'Pengajuan Keanggotaan')

@section('content')

<div class="admin-page">

    <div class="mb-4">
        <h1 class="h3 admin-title">Pengajuan Keanggotaan</h1>
        <p class="admin-subtitle">Jadi anggota aktif untuk mulai meminjam buku perpustakaan.</p>
    </div>

    <div style="max-width: 640px;">

    @if($currentUser->status_keanggotaan === 'aktif')
        <div class="notice">
            <strong>Anda sudah menjadi anggota aktif.</strong>
            Silakan lanjut ke menu Peminjaman Buku.
        </div>
    @elseif($currentUser->status_keanggotaan === 'menunggu_verifikasi')
        <div class="notice">
            <strong>Pengajuan sedang diverifikasi.</strong>
            Tunggu konfirmasi dari admin atau petugas perpustakaan.
        </div>
    @elseif($currentUser->status_keanggotaan === 'non_aktif')
        <div class="notice notice-muted">
            <strong>Keanggotaan Anda dinonaktifkan.</strong>
            Hubungi admin atau petugas perpustakaan secara langsung untuk mengaktifkannya kembali.
        </div>
    @else
        @if($pengajuanTerakhir && $pengajuanTerakhir->status === 'ditolak')
            <div class="notice notice-muted mb-4">
                <strong>Pengajuan sebelumnya ditolak.</strong>
                @if($pengajuanTerakhir->catatan_admin)
                    Catatan admin: {{ $pengajuanTerakhir->catatan_admin }}.
                @endif
                Perbaiki data, lalu ajukan kembali.
            </div>
        @endif

        <div class="card admin-panel no-hover-lift">
            <div class="card-body p-4">
                <form action="{{ route('keanggotaan.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="nama_lengkap" class="form-label admin-label">Nama lengkap</label>
                        <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control" required>
                    </div>
                    <div class="row g-3 mb-4">
                        <div class="col-md-7">
                            <label for="nis" class="form-label admin-label">NIS <span class="admin-hint">(Nomor Induk Siswa)</span></label>
                            <input type="text" name="nis" id="nis" class="form-control" inputmode="numeric" required>
                        </div>
                        <div class="col-md-5">
                            <label for="kelas" class="form-label admin-label">Kelas</label>
                            <input type="text" name="kelas" id="kelas" class="form-control" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-brand rounded-pill px-4">Ajukan keanggotaan</button>
                </form>
            </div>
        </div>
    @endif

    </div>

</div>

@endsection