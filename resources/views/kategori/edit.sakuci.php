@extends('layouts.app')

@section('title', 'Edit Kategori')

@section('content')

<div class="admin-page">

    <div class="mb-4">
        <h1 class="h3 admin-title">Edit Kategori</h1>
        <p class="admin-subtitle">Ubah nama kategori. Buku di dalamnya tetap tersambung.</p>
    </div>

    <div class="card admin-panel no-hover-lift" style="max-width: 560px;">
        <div class="card-body p-4">
            <form action="{{ route('kategori.update', ['id_kategori' => $kategori->id_kategori]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="nama_kategori" class="form-label admin-label">Nama kategori</label>
                    <input type="text" name="nama_kategori" id="nama_kategori" class="form-control" value="{{ $kategori->nama_kategori }}" required>
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-brand rounded-pill px-4">Simpan perubahan</button>
                    <a href="{{ route('kategori.index') }}" class="btn btn-outline-secondary rounded-pill px-4">Batal</a>
                </div>
            </form>
        </div>
    </div>

</div>

@endsection