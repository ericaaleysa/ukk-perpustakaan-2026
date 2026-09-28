@extends('layouts.app')

@section('title', 'NEX-LIB - Cari Buku')

@section('content')

    {{-- Banner pencarian --}}
    <div class="card border-0 shadow-sm mb-4 no-hover-lift">
        <div class="card-body p-4">
            <h1 class="h3 fw-bold mb-2">
                Cari buku yang kamu mau <span class="text-brand-dark">di sini</span>
            </h1>
            <p class="text-secondary small mb-4">
                Ketik judul, pengarang, atau penerbit. Pilih kategori kalau ingin hasil yang lebih spesifik.
            </p>

            <form method="GET" action="{{ route('buku.cari') }}">
                <div class="row g-2">
                    <div class="col-12 col-md">
                        <input type="text" name="q" class="form-control" placeholder="Cari judul, pengarang, atau penerbit..." value="{{ $keyword }}">
                    </div>
                    <div class="col-12 col-md-4 col-lg-3">
                        <select name="id_kategori" class="form-select" aria-label="Filter kategori">
                            <option value="">Semua kategori</option>
                            @foreach($daftarKategori as $kat)
                                <option value="{{ $kat->id_kategori }}" {{ $id_kategori == $kat->id_kategori ? 'selected' : '' }}>{{ $kat->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-auto d-flex gap-2">
                        <button type="submit" class="btn btn-brand px-3 d-inline-flex align-items-center justify-content-center flex-fill" aria-label="Cari" title="Cari">
                            <svg width="18" height="18" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <circle cx="7" cy="7" r="5.5"/>
                                <path d="M11.5 11.5 15 15"/>
                            </svg>
                        </button>
                        @if($sedangMencari)
                            <a href="{{ route('buku.cari') }}" class="btn btn-outline-secondary">Reset</a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Ringkasan hasil --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="h6 fw-bold mb-0">
            @if($sedangMencari)
                Hasil pencarian
            @else
                Semua Koleksi
            @endif
        </h2>
    </div>

    {{-- Daftar buku, dikelompokkan per kategori --}}
    @forelse($kelompok as $g)
        <section class="mb-5" id="kategori-{{ $g['id'] }}">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="h5 fw-semibold mb-0">{{ $g['nama'] }}</h2>
                <span class="text-secondary small">{{ count($g['buku']) }} buku</span>
            </div>

            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                @foreach($g['buku'] as $d)
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
        </section>
    @empty
        <div class="card border-0 shadow-sm no-hover-lift">
            <div class="card-body text-center text-secondary py-5">
                @if($sedangMencari)
                    Tidak ada buku yang cocok dengan pencarianmu.
                @else
                    Belum ada buku yang tersedia saat ini.
                @endif
            </div>
        </div>
    @endforelse

@endsection