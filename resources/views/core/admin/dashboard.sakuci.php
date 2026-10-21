@extends('layouts.app')

@section('title', 'NEX-LIB - Admin')

@section('content')

    {{-- Banner Selamat Datang --}}
    <div class="card border-0 shadow-sm no-hover-lift mb-4">
        <div class="card-body p-4 d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
            <div>
                <span class="badge rounded-pill badge-ukk px-3 py-1 mb-3">
                    {{ ucfirst($user->role) }}
                </span>
                <h1 class="h3 fw-bold mb-2">
                    Selamat Datang, <span class="text-brand-dark">Admin {{ $user->username }} </span>👋
                </h1>
                <p class="text-secondary mb-0 small">
                    Kelola koleksi buku, kategori, peminjaman, serta hak akses pengguna di panel kontrol perpustakaan.
                </p>
            </div>

            <div class="d-grid gap-2">
                <a href="{{ route('keanggotaan.index') }}" class="btn btn-brand px-4 d-inline-flex align-items-center gap-2">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" class="flex-shrink-0">
                        <path fill-rule="evenodd" d="M8 0a.5.5 0 0 1 .146.021l6 2A.5.5 0 0 1 14.5 2.5v4.243c0 4.248-2.937 7.634-6.234 8.716a.5.5 0 0 1-.532 0C4.437 14.377 1.5 10.991 1.5 6.743V2.5a.5.5 0 0 1 .354-.479l6-2A.5.5 0 0 1 8 0zM10.03 5.22a.75.75 0 0 1 0 1.06L7.53 8.78a.75.75 0 0 1-1.06 0L5.22 7.53a.75.75 0 1 1 1.06-1.06L7 7.19l2.97-2.97a.75.75 0 0 1 1.06 0z"/>
                    </svg>
                    Verifikasi Keanggotaan
                </a>
                
                <a href="{{ route('stok.index') }}" class="btn btn-brand px-4 d-inline-flex align-items-center gap-2">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
                        <path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5l2.404.961L10.404 2l-2.218-.887zm3.564 1.426L5.596 5 8 5.961 14.154 3.5l-2.404-.961zm3.25 1.7-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923l6.5 2.6zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464L7.443.184z"/>
                    </svg>
                    Lihat Stok Buku
                </a>
            </div>
        </div>
    </div>

    {{-- Pintasan fitur admin (kartu klik, gaya sama seperti dashboard siswa) --}}
    <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-3 mb-4">
        <div class="col">
            <a href="{{ route('kategori.index') }}" class="text-decoration-none d-block h-100">
                <div class="card border-0 shadow-sm p-3 h-100">
                    <div class="d-flex align-items-center gap-4 mt-1">
                        <div class="feature-icon flex-shrink-0">
                            <svg width="22" height="22" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
                                <path d="M2 2.5A1.5 1.5 0 0 1 3.5 1h4.086a1.5 1.5 0 0 1 1.06.44l5.914 5.914a1.5 1.5 0 0 1 0 2.12l-4.086 4.086a1.5 1.5 0 0 1-2.12 0L2.44 7.646A1.5 1.5 0 0 1 2 6.586V2.5zM5 5a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="fw-bold fs-6">Kategori Buku</div>
                            <div class="text-secondary small mb-2">Kelompokkan bacaan</div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col">
            <a href="{{ route('data_buku.index') }}" class="text-decoration-none d-block h-100">
                <div class="card border-0 shadow-sm p-3 h-100">
                    <div class="d-flex align-items-center gap-4 mt-1">
                        <div class="feature-icon flex-shrink-0">
                            <svg width="22" height="22" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
                                <path d="M8 1.884c-1.545-.887-3.837-1.113-5.487-.573C1.923.42 1.5.904 1.5 1.5v10.5c0 .548.44.98.955.86 1.469-.34 3.618-.146 5.045.567V1.884zm1 11.543c1.427-.713 3.576-.907 5.045-.567.516.12.955-.312.955-.86V1.5c0-.596-.423-1.08-1.013-1.19C12.337.77 10.045.996 8.5 1.884v11.543z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="fw-bold fs-6">Data Buku</div>
                            <div class="text-secondary small mb-2">Kelola koleksi &amp; sampul</div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col">
            <a href="{{ route('admin.users.index') }}" class="text-decoration-none d-block h-100">
                <div class="card border-0 shadow-sm p-3 h-100">
                    <div class="d-flex align-items-center gap-4 mt-1">
                        <div class="feature-icon flex-shrink-0">
                            <svg width="22" height="22" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
                                <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="fw-bold fs-6">Kelola User</div>
                            <div class="text-secondary small mb-2">Kelola Akun, Hak akses</div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col">
            <a href="{{ route('log.index') }}" class="text-decoration-none d-block h-100">
                <div class="card border-0 shadow-sm p-3 h-100">
                    <div class="d-flex align-items-center gap-4 mt-1">
                        <div class="feature-icon flex-shrink-0">
                            <svg width="22" height="22" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
                                <rect x="2" y="3" width="2" height="2" rx="0.5"/>
                                <rect x="5.5" y="3.5" width="8.5" height="1" rx="0.5"/>
                                <rect x="2" y="7" width="2" height="2" rx="0.5"/>
                                <rect x="5.5" y="7.5" width="8.5" height="1" rx="0.5"/>
                                <rect x="2" y="11" width="2" height="2" rx="0.5"/>
                                <rect x="5.5" y="11.5" width="8.5" height="1" rx="0.5"/>
                            </svg>
                        </div>
                        <div>
                            <div class="fw-bold fs-6">Log Aktivitas</div>
                            <div class="text-secondary small">Rekam jejak sistem</div>
                        </div>
                    </div>
                </div>
            </a>
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
                    <a href="{{ route('peminjaman.index') }}" class="btn btn-sm btn-outline-brand mt-auto">Kelola Peminjaman</a>
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
                    <a href="{{ route('anggota.index') }}" class="btn btn-sm btn-outline-brand mt-auto">Kelola Anggota</a>
                </div>
            </div>

            {{-- Kartu 3: Cetak Transaksi Peminjaman --}}
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
                    <a href="{{ route('peminjaman.cetak') }}" target="_blank" class="btn btn-sm btn-brand mt-auto">Cetak Laporan</a>
                </div>
            </div>

            {{-- Kartu 4: Download / Backup Database --}}
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
                    <a href="{{ route('admin.database.export') }}" class="btn btn-sm btn-brand mt-auto d-inline-flex align-items-center justify-content-center gap-1">
                        <svg width="14" height="14" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
                            <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                            <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/>
                        </svg>
                        Download DB
                    </a>
                </div>
            </div>
        </div>
    </section>

@endsection