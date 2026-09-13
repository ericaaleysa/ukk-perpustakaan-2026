@extends('layouts.app')

@section('content')

<h1>Edit Buku</h1>
<form action="{{ route('data_buku.update', [$data_buku->id_buku]) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="form-group mb-3">
        <select name="id_kategori" id="id_kategori" class="form-control" required>
            <option value="">Pilih Kategori Buku</option>

            @foreach($daftarKategori as $kat)
                <option value="{{ $kat->id_kategori }}" {{ $data_buku->id_kategori == $kat->id_kategori ? 'selected' : '' }}>
                    {{ $kat->nama_kategori }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group mb-3">
        <label for="judul_buku">Judul Buku</label>
        <input type="text" name="judul_buku" id="judul_buku" class="form-control" value="{{ $data_buku->judul_buku }}" required>
    </div>
    <div class="form-group mb-3">
        <label for="pengarang">Pengarang</label>
        <input type="text" name="pengarang" id="pengarang" class="form-control" value="{{ $data_buku->pengarang }}" required>
    </div>
    <div class="form-group mb-3">
        <label for="penerbit">Penerbit</label>
        <input type="text" name="penerbit" id="penerbit" class="form-control" value="{{ $data_buku->penerbit }}" required>
    </div>
    <div class="form-group mb-3">
        <label for="tahun_terbit">Tahun Terbit</label>
        <input type="text" name="tahun_terbit" id="tahun_terbit" class="form-control" value="{{ $data_buku->tahun_terbit }}" required>
    </div>

    <div class="form-group mb-3">
        <label for="thumbnail">URL Thumbnail (Opsional)</label>
        <input type="url" name="thumbnail" id="thumbnail" class="form-control" value="{{ $data_buku->thumbnail }}" placeholder="https://contoh.com/gambar-buku.jpg">
        <small class="text-secondary">Tempel link gambar sampul buku dari internet.</small>
    </div>

    <button type="submit" class="btn btn-primary">Update</button>
    <a href="{{ route('data_buku.index') }}" class="btn btn-secondary">Batal</a>
</form>

@endsection