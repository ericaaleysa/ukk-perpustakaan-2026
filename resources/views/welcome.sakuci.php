@extends('layouts.app')

@section('title', 'NEXUS - Selamat Datang')

@section('content')
    @php
        $welcomeUser = \App\Models\User::current();
        $dashboardRoute = ($welcomeUser && $welcomeUser->role === 'admin') ? 'admin.dashboard' : 'dashboard';

        $canRegister = false;
        if (!$welcomeUser) {
            try {
                $canRegister = \App\Models\Role::where('can_register', 1)->exists();
            } catch (\Throwable $e) {
                $canRegister = false;
            }
        }
    @endphp

    {{-- Halaman sambutan: hanya hero + footer. Navbar & sidebar disembunyikan
         oleh layouts.app untuk pengunjung yang belum login. --}}
    <section class="hero-section hero-section-landing text-center">
        <div class="hero-bg" aria-hidden="true">
            <span class="hero-blob hero-blob-1"></span>
            <span class="hero-blob hero-blob-2"></span>
            <span class="hero-blob hero-blob-3"></span>
        </div>

        {{-- Bintang Dekoratif (Muncul & Berkelip Saat Hover Hero) --}}
        <div class="hero-stars" aria-hidden="true">
            <svg class="star-icon star-1" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 0L14.59 9.41L24 12L14.59 14.59L12 24L9.41 14.59L0 12L9.41 9.41L12 0Z"/>
            </svg>
            <svg class="star-icon star-2" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 0L14.59 9.41L24 12L14.59 14.59L12 24L9.41 14.59L0 12L9.41 9.41L12 0Z"/>
            </svg>
            <svg class="star-icon star-3" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 0L14.59 9.41L24 12L14.59 14.59L12 24L9.41 14.59L0 12L9.41 9.41L12 0Z"/>
            </svg>
            <svg class="star-icon star-4" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 0L14.59 9.41L24 12L14.59 14.59L12 24L9.41 14.59L0 12L9.41 9.41L12 0Z"/>
            </svg>
        </div>

        {{-- Toggle tema (navbar tidak tampil di halaman ini). Pakai id yang sama
             dengan di navbar supaya theme.js otomatis terpasang. --}}
        <button id="themeToggle" type="button" class="theme-toggle-btn hero-theme-toggle"
                aria-label="Ganti tema terang/gelap" title="Mode Tema">
            <span class="theme-toggle-icon-wrapper">
                <svg class="theme-icon icon-sun" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <circle cx="12" cy="12" r="5"></circle>
                    <line x1="12" y1="1" x2="12" y2="3"></line>
                    <line x1="12" y1="21" x2="12" y2="23"></line>
                    <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
                    <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
                    <line x1="1" y1="12" x2="3" y2="12"></line>
                    <line x1="21" y1="12" x2="23" y2="12"></line>
                    <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
                    <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
                </svg>
                <svg class="theme-icon icon-moon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
                </svg>
            </span>
        </button>

        <div class="hero-content">
            <h1 class="display-5 fw-extrabold mb-3">
                Selamat Datang di<br class="d-none d-md-inline">
                <span class="text-brand-dark">NEXUS DIGITAL LIBRARY</span>
            </h1>

            <p class="fs-6 text-secondary mx-auto mb-4" style="max-width: 700px;">
                Jelajahi koleksi buku yang tersedia di perpustakaan secara online.
            </p>

            {{-- Tombol masuk / daftar (menggantikan kolom pencarian) --}}
            <div class="d-flex flex-wrap justify-content-center gap-2 mb-5">
                @if ($welcomeUser)
                    {{-- Cadangan: pengguna yang sudah login tidak perlu Masuk/Daftar lagi --}}
                    <a href="{{ route($dashboardRoute) }}" class="btn btn-brand rounded-pill px-4">Buka Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-brand rounded-pill px-4 d-inline-flex align-items-center gap-2">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <circle cx="8" cy="5" r="3" fill="currentColor" stroke="none"/>
                            <path d="M2.5 14c0-3.6 2.9-5.8 5.5-5.8s5.5 2.2 5.5 5.8"/>
                        </svg>
                        Masuk
                    </a>
                    @if ($canRegister)
                        <a href="{{ route('register') }}" class="btn btn-outline-brand rounded-pill px-4">Daftar</a>
                    @endif
                @endif
            </div>

            {{-- Kartu fitur (dipindah ke dalam hero, deskripsi dipersingkat) --}}
            <h2 class="h6 fw-bold text-uppercase text-secondary mb-3">Kenapa Memilih NEXLIB?</h2>

            <div class="mx-auto" style="max-width: 960px;">
                <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-3">
                    <div class="col">
                        <div class="card hero-feature-card border-0 shadow-sm h-100 p-3">
                            <div class="feature-icon mx-auto mb-2">
                                <svg width="20" height="20" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
                                    <path d="M8 1.884c-1.545-.887-3.837-1.113-5.487-.573C1.923.42 1.5.904 1.5 1.5v10.5c0 .548.44.98.955.86 1.469-.34 3.618-.146 5.045.567V1.884zm1 11.543c1.427-.713 3.576-.907 5.045-.567.516.12.955-.312.955-.86V1.5c0-.596-.423-1.08-1.013-1.19C12.337.77 10.045.996 8.5 1.884v11.543z"/>
                                </svg>
                            </div>
                            <h3 class="h6 fw-semibold mb-1">Koleksi Lengkap</h3>
                            <p class="text-secondary small mb-0">Beragam judul dari banyak kategori.</p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card hero-feature-card border-0 shadow-sm h-100 p-3">
                            <div class="feature-icon mx-auto mb-2">
                                <svg width="20" height="20" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
                                    <path d="M8 3.5a.5.5 0 0 1 .5.5v4.09l2.79 1.613a.5.5 0 1 1-.5.866l-3-1.732A.5.5 0 0 1 7.5 8V4a.5.5 0 0 1 .5-.5z"/>
                                    <path d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z"/>
                                </svg>
                            </div>
                            <h3 class="h6 fw-semibold mb-1">Akses 24 Jam</h3>
                            <p class="text-secondary small mb-0">Ajukan peminjaman kapan saja.</p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card hero-feature-card border-0 shadow-sm h-100 p-3">
                            <div class="feature-icon mx-auto mb-2">
                                <svg width="20" height="20" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M8 0a.5.5 0 0 1 .146.021l6 2A.5.5 0 0 1 14.5 2.5v4.243c0 4.248-2.937 7.634-6.234 8.716a.5.5 0 0 1-.532 0C4.437 14.377 1.5 10.991 1.5 6.743V2.5a.5.5 0 0 1 .354-.479l6-2A.5.5 0 0 1 8 0zM10.03 5.22a.75.75 0 0 1 0 1.06L7.53 8.78a.75.75 0 0 1-1.06 0L5.22 7.53a.75.75 0 1 1 1.06-1.06L7 7.19l2.97-2.97a.75.75 0 0 1 1.06 0z"/>
                                </svg>
                            </div>
                            <h3 class="h6 fw-semibold mb-1">Aman &amp; Terpercaya</h3>
                            <p class="text-secondary small mb-0">Data dan riwayatmu tersimpan aman.</p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card hero-feature-card border-0 shadow-sm h-100 p-3">
                            <div class="feature-icon mx-auto mb-2">
                                <svg width="20" height="20" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
                                    <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm5.5 0a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"/>
                                    <path d="M0 14c0-2.35 2.42-4.5 6-4.5 1.06 0 2.05.18 2.93.51C9.86 9.7 10.99 9 12.5 9 14.5 9 16 10.5 16 12v1H0v.5V14z" opacity=".9"/>
                                </svg>
                            </div>
                            <h3 class="h6 fw-semibold mb-1">Untuk Semua Kalangan</h3>
                            <p class="text-secondary small mb-0">Cocok untuk pelajar dan pencinta buku.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection