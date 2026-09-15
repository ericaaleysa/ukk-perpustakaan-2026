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

@endsection