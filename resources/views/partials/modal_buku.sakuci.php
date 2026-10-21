{{-- Popup detail buku. Dipakai bersama: @include('partials.modal_buku')
     Pemicu: elemen apa pun dengan class "js-buku-detail" + atribut data-* (lihat contoh di halaman yang memakainya) --}}

<style>
    .js-buku-detail { cursor: pointer; }
    .detail-cover {
        width: 100%; aspect-ratio: 3 / 4; border-radius: 8px; overflow: hidden;
        display: flex; align-items: center; justify-content: center;
        background: var(--bs-tertiary-bg);
    }
    .detail-cover img { width: 100%; height: 100%; object-fit: cover; }
    /* Placeholder tanpa sampul: ikon buku garis di dalam kotak berbingkai */
    .detail-no-sampul {
        width: 100%; height: 100%;
        display: flex; align-items: center; justify-content: center;
        border: 1px solid var(--bs-border-color); border-radius: 8px;
        color: var(--bs-secondary-color);
    }
    .detail-sinopsis { min-height: 120px; max-height: 180px; overflow-y: auto; white-space: pre-line; }
</style>

<div class="modal fade" id="modalBuku" tabindex="-1" aria-labelledby="modalBukuJudul" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-body p-4">

                <div class="row g-4">
                    {{-- Kiri: cover --}}
                    <div class="col-12 col-md-5">
                        <div class="detail-cover">
                            <img id="modalBukuCover" src="" alt="" class="d-none">
                            <span id="modalBukuFallback" class="detail-no-sampul" title="Belum ada sampul" role="img" aria-label="Belum ada sampul"><svg width="56" height="56" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true"><path d="M1 2.828c.885-.37 2.154-.769 3.388-.893 1.33-.134 2.458.063 3.112.752v9.746c-.935-.53-2.12-.603-3.213-.493-1.18.12-2.37.461-3.287.811V2.828zm7.5-.141c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492V2.687zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783z"/></svg></span>
                        </div>
                    </div>

                    {{-- Kanan: judul, sinopsis, info --}}
                    <div class="col-12 col-md-7 d-flex flex-column gap-3">
                        <h2 class="h5 fw-bold text-center mb-0 pt-2" id="modalBukuJudul">Judul</h2>

                        <div class="border rounded-3 p-3 small detail-sinopsis" id="modalBukuSinopsis"></div>

                        <div class="border rounded-3 p-3 small">
                            <div id="modalBukuGenre" class="d-none"></div>
                            <div id="modalBukuPenulis"></div>
                            <div id="modalBukuPenerbit"></div>
                            <div id="modalBukuStok"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    (function () {
        var modalEl = document.getElementById('modalBuku');
        if (!modalEl) return;

        function isi(id, teks) { document.getElementById(id).textContent = teks; }

        function buka(el) {
            var d = el.dataset;
            isi('modalBukuJudul', d.judul || '-');
            isi('modalBukuSinopsis', d.sinopsis || 'Sinopsis belum tersedia.');
            isi('modalBukuPenulis', 'Penulis: ' + (d.penulis || '-'));
            isi('modalBukuPenerbit', 'Penerbit: ' + (d.penerbit || '-') + ' - ' + (d.tahun || '-'));
            // Genre hanya ada untuk buku Karya Fiksi; kalau kosong, barisnya disembunyikan
            var genreEl = document.getElementById('modalBukuGenre');
            if (d.genre) {
                genreEl.textContent = 'Genre: ' + d.genre;
                genreEl.classList.remove('d-none');
            } else {
                genreEl.textContent = '';
                genreEl.classList.add('d-none');
            }
            isi('modalBukuStok', 'Stok buku: ' + (d.stok !== undefined && d.stok !== '' ? d.stok : '-'));

            var img = document.getElementById('modalBukuCover');
            var fb = document.getElementById('modalBukuFallback');
            if (d.cover) {
                img.onerror = function () { img.classList.add('d-none'); fb.classList.remove('d-none'); };
                img.src = d.cover;
                img.alt = 'Cover ' + (d.judul || '');
                img.classList.remove('d-none');
                fb.classList.add('d-none');
            } else {
                img.classList.add('d-none');
                fb.classList.remove('d-none');
            }

            // Klik di luar popup otomatis menutup (perilaku bawaan Bootstrap modal)
            bootstrap.Modal.getOrCreateInstance(modalEl).show();
        }

        document.addEventListener('click', function (e) {
            var el = e.target.closest('.js-buku-detail');
            if (!el) return;
            e.preventDefault();
            buka(el);
        });

        // Bisa dibuka dengan keyboard (Enter / Spasi)
        document.addEventListener('keydown', function (e) {
            if (e.key !== 'Enter' && e.key !== ' ') return;
            var el = e.target.closest ? e.target.closest('.js-buku-detail') : null;
            if (!el) return;
            e.preventDefault();
            buka(el);
        });
    })();
</script>