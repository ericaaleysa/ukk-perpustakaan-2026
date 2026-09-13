@extends('layouts.app')

@section('title', config('app.name') . ' -- Perpustakaan')

@section('content')

    {{-- Hero --}}
    <section class="text-center py-4 py-lg-5">
        <h1 class="display-5 fw-bold mb-3">
            Selamat Datang di<br class="d-none d-md-inline">
            <span class="text-brand-dark">Perpustakaan Kita</span>
        </h1>

        <p class="lead text-secondary mx-auto mb-0" style="max-width: 620px;">
            Jelajahi koleksi buku yang tersedia di perpustakaan secara online.
        </p>
    </section>

    {{-- Daftar Buku per Kategori --}}
    @if($data_buku->count() === 0)
        <div class="text-center text-secondary py-5">
            Belum ada buku yang tersedia saat ini.
        </div>
    @else
        @foreach($daftarKategori as $kat)
            @php
                $bukuKategori = [];
                foreach ($data_buku as $d) {
                    if ($d->id_kategori == $kat->id_kategori) {
                        $bukuKategori[] = $d;
                    }
                }
            @endphp

            @if(count($bukuKategori) > 0)
            <section class="mb-5">
                <h2 class="h5 fw-semibold mb-3">{{ $kat->nama_kategori }}</h2>

                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                    @foreach($bukuKategori as $d)
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
            @endif
        @endforeach

        {{-- Buku tanpa kategori (id_kategori kosong/null) --}}
        @php
            $bukuTanpaKategori = [];
            foreach ($data_buku as $d) {
                if (empty($d->id_kategori)) {
                    $bukuTanpaKategori[] = $d;
                }
            }
        @endphp

        @if(count($bukuTanpaKategori) > 0)
        <section class="mb-5">
            <h2 class="h5 fw-semibold mb-3">Tanpa Kategori</h2>

            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                @foreach($bukuTanpaKategori as $d)
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
        @endif
    @endif

@endsection