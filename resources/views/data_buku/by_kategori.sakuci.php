@extends('layouts.app')

@section('title', 'NEXLIB ' . '- ' . $kategori->nama_kategori)

@section('content')

    <div class="d-flex flex-wrap align-items-end justify-content-between gap-3 mb-4">
        <div>
            <h1 class="h3 fw-bold mt-2 mb-0">{{ $kategori->nama_kategori }}</h1>
            <p class="text-secondary mb-0">{{ count($data_buku) }} buku tersedia pada kategori ini.</p>
        </div>
        <a href="{{ route('dashboard') }}" class="btn btn-sm btn-outline-secondary px-3">&larr; Kembali</a>
    </div>

    @if(count($data_buku) === 0)
        <div class="text-center text-secondary py-5">
            Belum ada buku pada kategori ini.
        </div>
    @else
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
            @foreach($data_buku as $d)
            <div class="col">
                <div class="card border-0 shadow-sm h-100">
                    {{-- Cover: klik untuk membuka popup detail buku --}}
                    <div class="js-buku-detail" role="button" tabindex="0"
                         data-judul="{{ $d->judul_buku }}"
                         data-sinopsis="{{ $d->sinopsis ?? '' }}"
                         data-penulis="{{ $d->pengarang }}"
                         data-penerbit="{{ $d->penerbit }}"
                         data-tahun="{{ $d->tahun_terbit }}"
                         data-halaman="{{ $d->jumlah_halaman ?? '' }}"
                         data-stok="{{ $d->stok ?? '' }}"
                         data-cover="{{ $d->thumbnail ?? '' }}"
                         data-genre="{{ $d->genre ?? '' }}">
                        @if($d->thumbnail)
                            <img src="{{ $d->thumbnail }}" class="card-img-top" alt="{{ $d->judul_buku }}" style="height: 220px; object-fit: cover;">
                        @else
                            <div class="d-flex align-items-center justify-content-center bg-body-tertiary text-secondary border rounded-top" style="height: 220px;" title="Belum ada sampul" role="img" aria-label="Belum ada sampul">
                                <svg width="56" height="56" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true"><path d="M1 2.828c.885-.37 2.154-.769 3.388-.893 1.33-.134 2.458.063 3.112.752v9.746c-.935-.53-2.12-.603-3.213-.493-1.18.12-2.37.461-3.287.811V2.828zm7.5-.141c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492V2.687zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783z"/></svg>
                            </div>
                        @endif
                    </div>
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

    @include('partials.modal_buku')

@endsection