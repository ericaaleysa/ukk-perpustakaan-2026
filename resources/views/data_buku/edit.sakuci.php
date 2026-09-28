@extends('layouts.app')

@section('title', 'Edit Buku')

@section('content')

<div class="admin-page">

    <div class="mb-4">
        <h1 class="h3 admin-title">Edit Buku</h1>
        <p class="admin-subtitle">Perbarui data buku yang sudah ada di koleksi.</p>
    </div>

    <div class="card admin-panel no-hover-lift" style="max-width: 720px;">
        <div class="card-body p-4">
            <form action="{{ route('data_buku.update', [$data_buku->id_buku]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="id_kategori" class="form-label admin-label">Kategori</label>
                    <select name="id_kategori" id="id_kategori" class="form-select" required>
                        <option value="">Pilih kategori buku</option>
                        @foreach($daftarKategori as $kat)
                            <option value="{{ $kat->id_kategori }}" {{ $data_buku->id_kategori == $kat->id_kategori ? 'selected' : '' }}>
                                {{ $kat->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="judul_buku" class="form-label admin-label">Judul buku</label>
                    <input type="text" name="judul_buku" id="judul_buku" class="form-control" value="{{ $data_buku->judul_buku }}" required>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="pengarang" class="form-label admin-label">Pengarang</label>
                        <input type="text" name="pengarang" id="pengarang" class="form-control" value="{{ $data_buku->pengarang }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="penerbit" class="form-label admin-label">Penerbit</label>
                        <input type="text" name="penerbit" id="penerbit" class="form-control" value="{{ $data_buku->penerbit }}" required>
                    </div>
                </div>

                <div class="mb-3" style="max-width: 200px;">
                    <label for="tahun_terbit" class="form-label admin-label">Tahun terbit</label>
                    <input type="text" name="tahun_terbit" id="tahun_terbit" class="form-control" inputmode="numeric" maxlength="4" value="{{ $data_buku->tahun_terbit }}" required>
                </div>

                <div class="mb-4">
                    <label for="thumbnail" class="form-label admin-label">Sampul buku <span class="admin-hint">(opsional)</span></label>
                    @if($data_buku->thumbnail)
                        <div class="mb-2">
                            <img src="{{ $data_buku->thumbnail }}" alt="Sampul saat ini" class="admin-cover">
                        </div>
                    @endif
                    <input type="file" name="thumbnail" id="thumbnail" class="form-control" accept="image/jpeg,image/png,image/webp" onchange="previewSampul(this)">
                    <div class="admin-hint mt-1">Pilih file baru untuk mengganti. JPG, PNG, atau WEBP, maksimal 2 MB.</div>
                    <img id="previewSampul" class="admin-cover mt-2 d-none" alt="Pratinjau sampul baru">
                    @if($data_buku->thumbnail)
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" name="hapus_thumbnail" value="1" id="hapus_thumbnail">
                            <label class="form-check-label admin-hint" for="hapus_thumbnail">Hapus sampul saat ini</label>
                        </div>
                    @endif
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-brand rounded-pill px-4">Simpan perubahan</button>
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