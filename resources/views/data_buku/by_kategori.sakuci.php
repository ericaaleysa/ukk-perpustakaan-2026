@extends('layouts.app')

@section('title', config('app.name') . ' -- ' . $kategori->nama_kategori)

@section('content')

    <section class="mb-4">
        <a href="{{ route('home') }}" class="text-decoration-none small">&larr; Kembali ke Beranda</a>
        <h1 class="h3 fw-bold mt-2 mb-0">{{ $kategori->nama_kategori }}</h1>
        <p class="text-secondary mb-0">{{ count($data_buku) }} buku tersedia pada kategori ini.</p>
    </section>

    @if(count($data_buku) === 0)
        <div class="text-center text-secondary py-5">
            Belum ada buku pada kategori ini.
        </div>
    @else
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
            @foreach($data_buku as $d)
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

@endsection