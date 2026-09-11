@extends('layouts.app')

@section('content')

<h1>Tambah Buku</h1>
<form action="{{ route('data_buku.store') }}" method="POST">
    @csrf
    <div class="form-group mb-3">
        <select name="id_kategori" id="id_kategori" class="form-control" required>
            <option value="">Pilih Kategori Buku</option>

            @foreach($daftarKategori as $kat)
                <option value="{{ $kat->id_kategori }}">{{ $kat->nama_kategori }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group mb-3">
        <label for="judul_buku">Judul Buku</label>
        <input type="text" name="judul_buku" id="judul_buku" class="form-control" required>
    </div>
    <div class="form-group mb-3">
        <label for="pengarang">Pengarang</label>
        <input type="text" name="pengarang" id="pengarang" class="form-control" required>
    </div>
    <div class="form-group mb-3">
        <label for="penerbit">Penerbit</label>
        <input type="text" name="penerbit" id="penerbit" class="form-control" required>
    </div>
    <div class="form-group mb-3">
        <label for="tahun_terbit">Tahun Terbit</label>
        <input type="text" name="tahun_terbit" id="tahun_terbit" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
</form>

@endsection