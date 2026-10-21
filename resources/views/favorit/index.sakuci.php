@extends('layouts.app')

@section('title', 'Buku Favorit')

@section('content')

<div class="admin-page">

    <div class="d-flex flex-wrap align-items-end justify-content-between gap-3 mb-4">
        <div>
            <h1 class="h3 admin-title">Buku Favorit</h1>
            <p class="admin-subtitle">Koleksi buku yang kamu sukai.</p>
        </div>
        <a href="{{ route('dashboard') }}" class="btn btn-sm btn-outline-secondary px-3">&larr; Kembali</a>
    </div>

    <div class="card admin-panel no-hover-lift">
        <div class="admin-empty">
            <strong>Fitur segera hadir</strong>
            Halaman buku favorit sedang disiapkan.
        </div>
    </div>

</div>

@endsection