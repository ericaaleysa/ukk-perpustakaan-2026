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
                            <span id="modalBukuFallback" style="font-size: 3rem;">📚</span>
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