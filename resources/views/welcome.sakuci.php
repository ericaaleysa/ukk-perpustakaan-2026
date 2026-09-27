@extends('layouts.app')

@section('title', 'NEXUS - Dashboard')

@section('content')
    {{-- Hero Section --}}
    <section class="hero-section text-center mb-5 py-4">
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

        <div class="hero-content">
            <h1 class="display-5 fw-extrabold mb-3">
                Selamat Datang di<br class="d-none d-md-inline">
                <span class="text-brand-dark">NEXUS DIGITAL LIBRARY</span>
            </h1>

            <p class="fs-6 text-secondary mx-auto mb-4" style="max-width: 700px;">
                Jelajahi koleksi buku yang tersedia di perpustakaan secara online.
            </p>

            <form method="GET" action="{{ route('home') }}" class="mx-auto" style="max-width: 480px;">
                <div class="input-group">
                    <input type="text" name="q" class="form-control" placeholder="Cari judul buku..." value="{{ $keyword }}">
                    <button type="submit" class="btn btn-brand d-inline-flex align-items-center justify-content-center" aria-label="Cari" title="Cari">
                        <svg width="18" height="18" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <circle cx="7" cy="7" r="5.5"/>
                            <path d="M11.5 11.5 15 15"/>
                        </svg>
                    </button>
                    @if($keyword)
                        <a href="{{ route('home') }}" class="btn btn-outline-secondary">Reset</a>
                    @endif
                </div>
            </form>
        </div>
    </section>

    @if($keyword)
        {{-- Hasil pencarian judul --}}
        <section class="mb-5">
            <h2 class="h5 fw-semibold mb-3">Hasil pencarian untuk "{{ $keyword }}"</h2>

            @if(count($hasilPencarian) === 0)
                <div class="text-center text-secondary py-5">
                    Tidak ada buku dengan judul yang cocok.
                </div>
            @else
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                    @foreach($hasilPencarian as $d)
                    <div class="col">
                        <div class="card border-0 shadow-sm h-100">
                            @if($d->thumbnail)
                                <img src="{{ $d->thumbnail }}" class="card-img-top" alt="{{ $d->judul_buku }}" style="height: 220px; object-fit: cover;">
                            @else
                                <div class="d-flex align-items-center justify-content-center bg-body-secondary" style="height: 220px;">
                                    <span style="font-size: 3rem;">📚</span>
                                </div>
                            @endif
                            <div class="card-body">
                                <h3 class="h6 fw-semibold mb-1">{{ $d->judul_buku }}</h3>
                                <p class="text-secondary small mb-1">{{ $d->pengarang }}</p>
                                <p class="text-secondary small mb-0">{{ $d->penerbit }} &middot; {{ $d->tahun_terbit }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </section>
    @else
        {{-- Konten sambutan halaman utama --}}
        <section class="mb-5">
            <div class="row row-cols-2 row-cols-md-4 g-3 text-center mb-5">
                <div class="col">
                    <div class="fw-bold fs-3 text-brand-dark">{{ count($data_buku) }}+</div>
                    <div class="text-secondary small">Buku Tersedia</div>
                </div>
                <div class="col">
                    <div class="fw-bold fs-3 text-brand-dark">{{ count($daftarKategori) }}</div>
                    <div class="text-secondary small">Kategori</div>
                </div>
                <div class="col">
                    <div class="fw-bold fs-3 text-brand-dark">24/7</div>
                    <div class="text-secondary small">Akses Online</div>
                </div>
                <div class="col">
                    <div class="fw-bold fs-3 text-brand-dark">Gratis</div>
                    <div class="text-secondary small">Untuk Anggota</div>
                </div>
            </div>

            <hr class="my-5">
            <br>

            <div class="text-center mb-5">
                <h2 class="h4 fw-bold mb-2">Kenapa Memilih NEXLIB?</h2>
                <p class="text-secondary mx-auto" style="max-width: 600px;">
                    Nikmati kemudahan mengakses ribuan koleksi buku, kapan saja dan di mana saja.
                </p>
            </div>

            <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-4">
                <div class="col">
                    <div class="card border-0 shadow-sm h-100 p-3">
                        <div class="feature-icon mb-3">
                            <svg width="20" height="20" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
                                <path d="M8 1.884c-1.545-.887-3.837-1.113-5.487-.573C1.923.42 1.5.904 1.5 1.5v10.5c0 .548.44.98.955.86 1.469-.34 3.618-.146 5.045.567V1.884zm1 11.543c1.427-.713 3.576-.907 5.045-.567.516.12.955-.312.955-.86V1.5c0-.596-.423-1.08-1.013-1.19C12.337.77 10.045.996 8.5 1.884v11.543z"/>
                            </svg>
                        </div>
                        <h3 class="h6 fw-semibold mb-1">Koleksi Lengkap</h3>
                        <p class="text-secondary small mb-0">Ribuan judul buku dari berbagai kategori, terus diperbarui secara berkala.</p>
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
                        <h3 class="h6 fw-semibold mb-1">Akses 24 Jam</h3>
                        <p class="text-secondary small mb-0">Jelajahi dan ajukan peminjaman buku kapan saja, tanpa perlu datang langsung.</p>
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
                        <h3 class="h6 fw-semibold mb-1">Aman &amp; Terpercaya</h3>
                        <p class="text-secondary small mb-0">Data anggota dan riwayat peminjamanmu tersimpan dengan aman.</p>
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
                        <h3 class="h6 fw-semibold mb-1">Untuk Semua Kalangan</h3>
                        <p class="text-secondary small mb-0">Cocok untuk pelajar, mahasiswa, dan siapa pun yang gemar membaca.</p>
                    </div>
                </div>
            </div>

            <div class="text-center mt-5">
                <button type="button" class="btn btn-outline-brand rounded-pill px-4"
                        data-bs-toggle="offcanvas" data-bs-target="#sidebarUtama" aria-controls="sidebarUtama">
                    &leftarrow; Jelajahi Perpustakaan
                </button>
            </div>
        </section>
    @endif

@endsection