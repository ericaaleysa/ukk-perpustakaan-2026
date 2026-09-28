@extends('layouts.app')

@section('title', 'Tambah Buku')

@section('content')

<div class="admin-page">

    <div class="mb-4">
        <h1 class="h3 admin-title">Tambah Buku</h1>
        <p class="admin-subtitle">Lengkapi data buku yang akan masuk ke koleksi.</p>
    </div>

    <div class="card admin-panel no-hover-lift" style="max-width: 720px;">
        <div class="card-body p-4">
            <form action="{{ route('data_buku.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="id_kategori" class="form-label admin-label">Kategori</label>
                    <select name="id_kategori" id="id_kategori" class="form-select" required>
                        <option value="">Pilih kategori buku</option>
                        @foreach($daftarKategori as $kat)
                            <option value="{{ $kat->id_kategori }}">{{ $kat->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="judul_buku" class="form-label admin-label">Judul buku</label>
                    <input type="text" name="judul_buku" id="judul_buku" class="form-control" required>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="pengarang" class="form-label admin-label">Pengarang</label>
                        <input type="text" name="pengarang" id="pengarang" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="penerbit" class="form-label admin-label">Penerbit</label>
                        <input type="text" name="penerbit" id="penerbit" class="form-control" required>
                    </div>
                </div>

                <div class="mb-3" style="max-width: 200px;">
                    <label for="tahun_terbit" class="form-label admin-label">Tahun terbit</label>
                    <input type="text" name="tahun_terbit" id="tahun_terbit" class="form-control" inputmode="numeric" maxlength="4" required>
                </div>

                <div class="mb-4">
                    <label for="thumbnail" class="form-label admin-label">Sampul buku <span class="admin-hint">(opsional)</span></label>
                    <input type="file" name="thumbnail" id="thumbnail" class="form-control" accept="image/jpeg,image/png,image/webp" onchange="previewSampul(this)">
                    <div class="admin-hint mt-1">JPG, PNG, atau WEBP. Maksimal 2 MB.</div>
                    <img id="previewSampul" class="admin-cover mt-2 d-none" alt="Pratinjau sampul">
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-brand rounded-pill px-4">Simpan buku</button>
                    <a href="{{ route('data_buku.index') }}" class="btn btn-outline-secondary rounded-pill px-4">Batal</a>
                </div>
            </form>
        </div>
    </div>

</div>

<script>
function previewSampul(input) {
    var img = document.getElementById('previewSampul');
    if (input.files && input.files[0]) {
        img.src = URL.createObjectURL(input.files[0]);
        img.classList.remove('d-none');
    } else {
        img.classList.add('d-none');
    }
}
</script>

@endsection