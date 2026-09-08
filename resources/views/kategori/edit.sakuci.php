@extends('layouts.app')

@section('content')

<h1>Edit Kategori</h1>
<form action="{{ route('kategori.update', ['id_kategori' => $kategori->id_kategori]) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="form-group mb-3">
        <label for="nama_kategori">Nama Kategori</label>
        <input type="text" name="nama_kategori" id="nama_kategori" class="form-control" value="{{ $kategori->nama_kategori }}" required>
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
    <button type="button" class="btn btn-secondary" onclick="window.history.back()">Batal</button>
</form>

@endsection

