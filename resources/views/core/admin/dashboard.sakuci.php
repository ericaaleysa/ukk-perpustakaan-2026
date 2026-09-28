@extends('layouts.app')

@section('title', 'NEX-LIB - Admin')

@section('content')

    {{-- Banner Selamat Datang --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4 d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
            <div>
                <span class="badge rounded-pill badge-ukk px-3 py-2 mb-3">
                    {{ ucfirst($user->role) }}
                </span>
                <h1 class="h3 fw-bold mb-2">
                    Selamat Datang, <span class="text-brand-dark">Admin Nexus </span>!
                </h1>
                <p class="text-secondary mb-0 small">
                    Kelola koleksi buku, kategori, peminjaman, serta hak akses pengguna di panel kontrol perpustakaan.
                </p>
            </div>
        </div>
    </div>

    {{-- Fitur & Navigasi Utama Admin --}}
    <section class="mb-4">

        <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-3">
            
            {{-- Kartu 1: Peminjaman Buku --}}
            <div class="col">
                <div class="card border-0 shadow-sm h-100 p-3">
                    <div class="feature-icon mb-3">
                        <svg width="22" height="22" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
                            <path d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                            <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
                        </svg>
                    </div>
                    <h3 class="h6 fw-semibold mb-1">Peminjaman</h3>
                    <p class="text-secondary small mb-3">Pantau dan kelola riwayat peminjaman serta pengembalian buku.</p>
                    <a href="{{ route('peminjaman.index') }}" class="btn btn-sm btn-outline-brand rounded-pill mt-auto">Kelola Peminjaman</a>
                </div>
            </div>

            {{-- Kartu 2: Anggota --}}
            <div class="col">
                <div class="card border-0 shadow-sm h-100 p-3">
                    <div class="feature-icon mb-3">
                        <svg width="22" height="22" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
                            <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                            <path fill-rule="evenodd" d="M5.216 14A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216z"/>
                            <path d="M4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"/>
                        </svg>
                    </div>
                    <h3 class="h6 fw-semibold mb-1">Anggota</h3>
                    <p class="text-secondary small mb-3">Lihat dan atur status keaktifan anggota perpustakaan.</p>
                    <a href="{{ route('anggota.index') }}" class="btn btn-sm btn-outline-brand rounded-pill mt-auto">Kelola Anggota</a>
                </div>
            </div>

            {{-- Kartu 3: Download / Backup Database --}}
            <div class="col">
                <div class="card border-0 shadow-sm h-100 p-3">
                    <div class="feature-icon mb-3">
                        <svg width="22" height="22" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
                            <path d="M4.25 12c0 .552 1.679 1 3.75 1s3.75-.448 3.75-1-.157-.294-.436-.436l-.744.744a4.48 4.48 0 0 1-2.57.692 4.48 4.48 0 0 1-2.57-.692l-.744-.744c-.279.142-.436.284-.436.436z"/>
                            <path d="M12 4.09c0 .552-1.679 1-3.75 1S4.5 4.642 4.5 4.09 6.179 3.09 8.25 3.09 12 3.538 12 4.09z"/>
                            <path d="M12.5 6.09c0 .416-1.077.808-2.614.958l-.832-.832c.319-.04.629-.092.919-.153l.36-.36c1.171-.137 2.167-.423 2.167-.703v1.09z"/>
                            <path d="M12 1h-1v1h1a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1h1V1H4a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2z"/>
                            <path d="M8.5 1.5a.5.5 0 0 0-1 0v5.793L6.354 6.146a.5.5 0 1 0-.708.708l2 2a.5.5 0 0 0 .708 0l2-2a.5.5 0 0 0-.708-.708L8.5 7.293V1.5z"/>
                        </svg>
                    </div>
                    <h3 class="h6 fw-semibold mb-1">Backup Database</h3>
                    <p class="text-secondary small mb-3">Unduh cadangan basis data (.sql) untuk mengamankan data sistem.</p>
                    <a href="{{ route('admin.database.export') }}" class="btn btn-sm btn-brand rounded-pill mt-auto d-inline-flex align-items-center justify-content-center gap-1">
                        <svg width="14" height="14" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
                            <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                            <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/>
                        </svg>
                        Download DB
                    </a>
                </div>
            </div>

            {{-- Kartu 4: Cetak Transaksi Peminjaman --}}
            <div class="col">
                <div class="card border-0 shadow-sm h-100 p-3">
                    <div class="feature-icon mb-3">
                        <svg width="22" height="22" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
                            <path d="M4 1.5A1.5 1.5 0 0 1 5.5 0h5A1.5 1.5 0 0 1 12 1.5V4H4V1.5z"/>
                            <path d="M2 5a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h2v-2h8v2h2a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H2z"/>
                            <path d="M5 11h6v4.5a.5.5 0 0 1-.5.5h-5a.5.5 0 0 1-.5-.5V11z"/>
                        </svg>
                    </div>
                    <h3 class="h6 fw-semibold mb-1">Cetak Transaksi Peminjaman</h3>
                    <p class="text-secondary small mb-3">Unduh laporan transaksi peminjaman buku untuk keperluan administrasi.</p>
                    <a href="{{ route('peminjaman.cetak') }}" target="_blank" class="btn btn-sm btn-brand rounded-pill mt-auto">Cetak Laporan</a>
                </div>
            </div>
        </div>
    </section>

@endsection