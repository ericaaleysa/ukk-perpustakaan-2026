@extends('layouts.app')

@section('title', 'Tentang NEXLIB')

@section('content')

    <section class="mb-4">
        <a href="{{ route('home') }}" class="text-decoration-none small">&larr; Kembali</a>
        <h1 class="h3 fw-bold mt-2 mb-1">Tentang <span class="text-brand-dark">NEXLIB</span></h1>
        <p class="text-secondary mb-0">Akselerasi Literasi, Memicu Energi Vokasi</p>
    </section>

    {{-- Apa itu NEXLIB --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <h2 class="h5 fw-semibold mb-2">Apa itu NEXLIB?</h2>
            <p class="text-secondary mb-0">
                Nexus Digital Library adalah pengembangan sistem Peminjaman Buku perpustakaan digital berbasis verifikasi Keanggotaan.<br> 
                Siswa wajib mendaftar akun, mengajukan keanggotaan, dan diverifikasi petugas hingga berstatus anggota aktif sebelum dapat mengajukan peminjaman buku. 
                Pengajuan peminjaman kemudian dikonfirmasi petugas, dan pengembalian buku dicatat lengkap dengan denda bila terlambat.
            </p><br>

            <h2 class="h6 fw-semibold mb-2 mt-3">Tujuan Pembuatan</h2>
            <p class="text-secondary mb-0">
                Web ini dibuat untuk memenuhi tugas besar akhir berupa Uji Kompetensi Keahlian (UKK), 
                sebagai penerapan kompetensi yang telah dipelajari selama tiga tahun belajar di jurusan Rekayasa Perangkat Lunak (RPL) SMK Sangkuriang 1 Cimahi.
            </p><br>
        </div>
    </div>

    {{-- Fitur utama --}}
    <h2 class="h5 fw-semibold mb-3">Fitur utama</h2>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-3 mb-4">
        <div class="col">
            <div class="card border-0 shadow-sm h-100 p-3">
                <div class="feature-icon mb-3">
                    <svg width="20" height="20" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
                        <path d="M8 1.884c-1.545-.887-3.837-1.113-5.487-.573C1.923.42 1.5.904 1.5 1.5v10.5c0 .548.44.98.955.86 1.469-.34 3.618-.146 5.045.567V1.884zm1 11.543c1.427-.713 3.576-.907 5.045-.567.516.12.955-.312.955-.86V1.5c0-.596-.423-1.08-1.013-1.19C12.337.77 10.045.996 8.5 1.884v11.543z"/>
                    </svg>
                </div>
                <h3 class="h6 fw-semibold mb-1">Katalog Buku</h3>
                <p class="text-secondary small mb-0">Buku dikelompokkan per kategori agar mudah dicari.</p>
            </div>
        </div>
        <div class="col">
            <div class="card border-0 shadow-sm h-100 p-3">
                <div class="feature-icon mb-3">
                    <svg width="20" height="20" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
                        <path d="M8 0a.5.5 0 0 1 .146.021l6 2A.5.5 0 0 1 14.5 2.5v4.243c0 4.248-2.937 7.634-6.234 8.716a.5.5 0 0 1-.532 0C4.437 14.377 1.5 10.991 1.5 6.743V2.5a.5.5 0 0 1 .354-.479l6-2A.5.5 0 0 1 8 0z"/>
                        <path d="M10.03 5.22a.75.75 0 0 1 0 1.06L7.53 8.78a.75.75 0 0 1-1.06 0L5.22 7.53a.75.75 0 1 1 1.06-1.06L7 7.19l2.97-2.97a.75.75 0 0 1 1.06 0z"/>
                    </svg>
                </div>
                <h3 class="h6 fw-semibold mb-1">Keanggotaan</h3>
                <p class="text-secondary small mb-0">Pengajuan anggota diverifikasi oleh petugas perpustakaan.</p>
            </div>
        </div>
        <div class="col">
            <div class="card border-0 shadow-sm h-100 p-3">
                <div class="feature-icon mb-3">
                    <svg width="20" height="20" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
                        <path d="M8 3.5a.5.5 0 0 1 .5.5v4.09l2.79 1.613a.5.5 0 1 1-.5.866l-3-1.732A.5.5 0 0 1 7.5 8V4a.5.5 0 0 1 .5-.5z"/>
                        <path d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z"/>
                    </svg>
                </div>
                <h3 class="h6 fw-semibold mb-1">Peminjaman Online</h3>
                <p class="text-secondary small mb-0">Ajukan peminjaman, lalu pantau statusnya di riwayat.</p>
            </div>
        </div>
        <div class="col">
            <div class="card border-0 shadow-sm h-100 p-3">
                <div class="feature-icon mb-3">
                    <svg width="20" height="20" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
                        <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm5.5 0a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"/>
                        <path d="M0 14c0-2.35 2.42-4.5 6-4.5 1.06 0 2.05.18 2.93.51C9.86 9.7 10.99 9 12.5 9 14.5 9 16 10.5 16 12v1H0v.5V14z" opacity=".9"/>
                    </svg>
                </div>
                <h3 class="h6 fw-semibold mb-1">Panel Petugas</h3>
                <p class="text-secondary small mb-0">Kelola buku, kategori, anggota, dan transaksi.</p>
            </div>
        </div>
    </div>

    {{-- Cara meminjam --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <h2 class="h5 fw-semibold mb-3">Cara meminjam buku</h2>

            <ul class="list-unstyled d-grid gap-3 mb-0">
                <li class="d-flex gap-3">
                    <span class="step-number">1</span>
                    <div>
                        <div class="fw-medium">Daftar dan masuk</div>
                        <div class="text-secondary small">Buat akun, lalu masuk ke NEXLIB.</div>
                    </div>
                </li>
                <li class="d-flex gap-3">
                    <span class="step-number">2</span>
                    <div>
                        <div class="fw-medium">Ajukan keanggotaan</div>
                        <div class="text-secondary small">Isi data diri, lalu tunggu verifikasi dari petugas.</div>
                    </div>
                </li>
                <li class="d-flex gap-3">
                    <span class="step-number">3</span>
                    <div>
                        <div class="fw-medium">Ajukan peminjaman</div>
                        <div class="text-secondary small">Setelah menjadi anggota aktif, pilih buku yang tersedia dan ajukan peminjaman.</div>
                    </div>
                </li>
                <li class="d-flex gap-3">
                    <span class="step-number">4</span>
                    <div>
                        <div class="fw-medium">Kembalikan buku</div>
                        <div class="text-secondary small">Serahkan buku ke perpustakaan, petugas akan mengonfirmasi pengembaliannya.</div>
                    </div>
                </li>
            </ul>
        </div>
    </div>

@endsection