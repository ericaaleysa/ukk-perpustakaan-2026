@extends('layouts.app')

@section('title', 'Tambah Kategori')

@section('content')

<div class="admin-page">

    <div class="mb-4">
        <h1 class="h3 admin-title">Tambah Kategori</h1>
        <p class="admin-subtitle">Buat kelompok baru untuk koleksi buku.</p>
    </div>

    <div class="card admin-panel no-hover-lift" style="max-width: 560px;">
        <div class="card-body p-4">
            <form action="{{ route('kategori.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="nama_kategori" class="form-label admin-label">Nama kategori</label>
                    <input type="text" name="nama_kategori" id="nama_kategori" class="form-control" required autofocus>
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-brand rounded-pill px-4">Simpan kategori</button>
                    <a href="{{ route('kategori.index') }}" class="btn btn-outline-secondary rounded-pill px-4">Batal</a>
                </div>
            </form>
        </div>
    </div>

</div>

@endsection