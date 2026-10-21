@extends('layouts.app')

@section('title', 'Edit Buku')

@section('content')

<div class="admin-page">

    <div class="mb-4">
        <h1 class="h3 admin-title">Edit Buku</h1>
        <p class="admin-subtitle">Perbarui data buku yang sudah ada di koleksi.</p>
    </div>

    <form action="{{ route('data_buku.update', [$data_buku->id_buku]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Penanda: sinopsis/genre hanya diperbarui kalau kolomnya benar-benar diubah --}}
        <input type="hidden" name="sinopsis_diubah" id="sinopsis_diubah" value="0">
        <input type="hidden" name="genre_diubah" id="genre_diubah" value="0">

        <div class="row g-4 align-items-start">

            {{-- Kiri: data buku --}}
            <div class="col-12 col-lg-8">
                <div class="card admin-panel no-hover-lift">
                    <div class="card-body p-4">

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

                        {{-- Genre: hanya muncul kalau kategori yang dipilih "Karya Fiksi" --}}
                        <div class="mb-3 d-none" id="genreWrap">
                            <label for="genre" class="form-label admin-label">Genre <span class="admin-hint">(khusus Karya Fiksi)</span></label>
                            <input type="text" name="genre" id="genre" list="daftarGenre" maxlength="100" class="form-control"
                                   placeholder="Pilih saran atau ketik genre sendiri" value="{{ old('genre') !== null && old('genre') !== '' ? old('genre') : ($data_buku->genre ?? '') }}">
                            <datalist id="daftarGenre">
                                <option value="Fantasi"></option>
                                <option value="Romantis"></option>
                                <option value="Misteri"></option>
                                <option value="Horor"></option>
                                <option value="Petualangan"></option>
                                <option value="Fiksi Ilmiah"></option>
                                <option value="Komedi"></option>
                                <option value="Drama"></option>
                                <option value="Thriller"></option>
                                <option value="Sejarah"></option>
                                <option value="Slice of Life"></option>
                            </datalist>
                            <div class="admin-hint mt-1">Ditampilkan di popup informasi buku. Bisa diketik bebas.</div>
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

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="tahun_terbit" class="form-label admin-label">Tahun terbit</label>
                                <input type="text" name="tahun_terbit" id="tahun_terbit" class="form-control" inputmode="numeric" maxlength="4" value="{{ $data_buku->tahun_terbit }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="stok" class="form-label admin-label">Stok</label>
                                <input type="number" name="stok" id="stok" min="0" max="9999"
                                        value="{{ old('stok') !== null && old('stok') !== ''
                                        ? old('stok') : (int) $data_buku->stok }}"
                                        class="form-control {{ errors()->has('stok') ? 'is-invalid' : '' }}" required>
                                @error('stok') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="sinopsis" class="form-label admin-label">Sinopsis <span class="admin-hint">(opsional)</span></label>
                            <textarea name="sinopsis" id="sinopsis" rows="4" maxlength="2000" class="form-control" placeholder="Ringkasan isi buku...">{{ old('sinopsis') !== null && old('sinopsis') !== '' ? old('sinopsis') : ($data_buku->sinopsis ?? '') }}</textarea>
                            <div class="admin-hint mt-1">Maksimal 2000 karakter. Ditampilkan di popup informasi buku.</div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-brand px-4">Simpan perubahan</button>
                            <a href="{{ route('data_buku.index') }}" class="btn btn-outline-secondary px-4">Batal</a>
                        </div>

                    </div>
                </div>
            </div>

            {{-- Kanan: sampul + pratinjau --}}
            <div class="col-12 col-lg-4">
                <div class="card admin-panel no-hover-lift sampul-sticky">
                    <div class="card-body p-4">

                        <div class="sampul-frame" id="sampulFrame" data-asli="{{ $data_buku->thumbnail ?? '' }}">
                            <img id="previewSampul" src="{{ $data_buku->thumbnail ?? '' }}" alt="Pratinjau sampul" class="{{ $data_buku->thumbnail ? '' : 'd-none' }}">
                            <div id="sampulKosong" class="sampul-kosong {{ $data_buku->thumbnail ? 'd-none' : '' }}" title="Belum ada sampul" role="img" aria-label="Belum ada sampul">
                                <svg width="56" height="56" viewBox="0 0 16 16" fill="currentColor" class="d-block mx-auto" aria-hidden="true"><path d="M1 2.828c.885-.37 2.154-.769 3.388-.893 1.33-.134 2.458.063 3.112.752v9.746c-.935-.53-2.12-.603-3.213-.493-1.18.12-2.37.461-3.287.811V2.828zm7.5-.141c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492V2.687zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783z"/></svg>
                            </div>
                        </div> <hr>

                        <input type="file" name="thumbnail" id="thumbnail" class="form-control mt-3" accept="image/jpeg,image/png,image/webp" onchange="previewSampul(this)">
                        <div class="admin-hint mt-1">Pilih file baru untuk mengganti. JPG, PNG, atau WEBP, maksimal 2 MB.</div>
                        @if($data_buku->thumbnail)
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="checkbox" name="hapus_thumbnail" value="1" id="hapus_thumbnail">
                                <label class="form-check-label admin-hint" for="hapus_thumbnail">Hapus sampul saat ini</label>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </form>

</div>

<script>
// Menampilkan pratinjau sampul yang baru dipilih di kotak sebelah kanan
function previewSampul(input) {
    var frame = document.getElementById('sampulFrame');
    var img = document.getElementById('previewSampul');
    var kosong = document.getElementById('sampulKosong');
    var keterangan = document.getElementById('sampulKeterangan');
    var asli = frame.getAttribute('data-asli'); // alamat sampul yang sudah tersimpan (kosong kalau belum ada)

    if (input.files && input.files[0]) {
        // ada file baru dipilih: tampilkan pratinjaunya
        img.src = URL.createObjectURL(input.files[0]);
        img.classList.remove('d-none');
        kosong.classList.add('d-none');
        if (keterangan) keterangan.textContent = 'Pratinjau sampul baru';
    } else if (asli) {
        // pilihan dibatalkan: kembali ke sampul yang tersimpan
        img.src = asli;
        img.classList.remove('d-none');
        kosong.classList.add('d-none');
        if (keterangan) keterangan.textContent = 'Sampul saat ini';
    } else {
        // belum ada sampul sama sekali
        img.classList.add('d-none');
        kosong.classList.remove('d-none');
        if (keterangan) keterangan.textContent = 'Pratinjau akan muncul di sini';
    }
}

// Genre hanya tampil kalau kategori yang dipilih adalah "Karya Fiksi"
var ID_KATEGORI_FIKSI = '{{ $idKategoriFiksi ?? '' }}';
function aturGenre() {
    var pilih = document.getElementById('id_kategori');
    var wrap = document.getElementById('genreWrap');
    var input = document.getElementById('genre');
    var tampil = ID_KATEGORI_FIKSI !== '' && pilih.value === ID_KATEGORI_FIKSI;
    wrap.classList.toggle('d-none', !tampil);
    input.disabled = !tampil; // kalau disembunyikan, tidak ikut terkirim
}
document.getElementById('id_kategori').addEventListener('change', aturGenre);
aturGenre();

// Tandai kolom yang benar-benar diubah admin (selain itu, isi lama di database dibiarkan)
document.getElementById('sinopsis').addEventListener('input', function () {
    document.getElementById('sinopsis_diubah').value = '1';
});
document.getElementById('genre').addEventListener('input', function () {
    document.getElementById('genre_diubah').value = '1';
});
</script>

@endsection