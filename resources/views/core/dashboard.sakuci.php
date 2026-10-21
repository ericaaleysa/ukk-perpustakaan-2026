@extends('layouts.app')

@section('title', 'NEX-LIB - Pengguna')

@section('content')

    {{-- Banner Selamat Datang & Status Keanggotaan --}}
    <div class="card border-0 shadow-sm no-hover-lift mb-4">
        <div class="card-body p-4 d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
            <div>
                <div class="d-flex align-items-center gap-2 mb-3">
                    <span class="badge badge-ukk px-3 py-1">
                        {{ ucfirst($user->role) }}
                    </span>
                    {{-- Validasi Status Keanggotaan dari User Model --}}
                    @if(($user->status_keanggotaan ?? 'non_aktif') === 'aktif')
                        <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-1">
                            ● Anggota Aktif
                        </span>
                    @else
                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-1">
                            ● Belum Mengajukan Keanggotaan
                        </span>
                    @endif
                </div>
                <h1 class="h3 fw-bold mb-2">
                    Selamat Datang, <span class="text-brand-dark">{{ $user->username }} </span>👋
                </h1>
                <p class="text-secondary mb-0 small">
                    {{ ($user->status_keanggotaan ?? 'non_aktif') === 'aktif' ? 
                        'Pantau aktivitas peminjaman buku dan buku favoritmu di sini.' : 
                        'Kamu belum mengajukan keanggotaan. Silakan ajukan keanggotaan agar dapat meminjam buku.'
                    }}
                </p>
            </div>

            {{-- Sisi kanan: tombol ajukan keanggotaan (pindahan dari sidebar) --}}
            <div class="d-grid gap-2">
                <a href="{{ route('keanggotaan.create') }}" class="btn btn-brand px-4 d-inline-flex align-items-center justify-content-center gap-2">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
                        <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2 1c-2.67 0-5.5 1.34-5.5 3v1h8.256A4.5 4.5 0 0 1 10 10.5c0-.827.224-1.6.614-2.264A8.99 8.99 0 0 0 8 9z"/>
                        <path fill-rule="evenodd" d="M13.5 7a.5.5 0 0 1 .5.5V9h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V10h-1.5a.5.5 0 0 1 0-1H13V7.5a.5.5 0 0 1 .5-.5z"/>
                    </svg>
                    Ajukan Keanggotaan
                </a>

                {{-- Tombol sekunder: buka sidebar lalu lompat ke Kategori Buku --}}
                <button type="button" id="btnCariKoleksi" class="btn btn-outline-secondary px-4 d-inline-flex align-items-center justify-content-center gap-2"
                        aria-controls="sidebarUtama">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                    </svg>
                    Cari Koleksi
                </button>
            </div>
        </div>
    </div>

    {{-- Tiga kartu pintasan (semuanya bisa diklik) --}}
    <div class="row row-cols-1 row-cols-sm-3 g-3 mb-4">

        {{-- Kartu 1: Buku Favorit --}}
        <div class="col">
            <a href="{{ route('favorit.index') }}" class="card border-0 shadow-sm p-3 h-100 text-decoration-none text-reset">
                <div class="d-flex align-items-center gap-3">
                    <div class="feature-icon">
                        <svg width="22" height="22" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
                            <path d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="fw-bold fs-5 text-brand-dark">Buku Favorit</div>
                        <div class="text-secondary small">Koleksi buku yang kamu sukai</div>
                    </div>
                </div>
            </a>
        </div>

        {{-- Kartu 2: Buku yang dipinjam (klik untuk lompat ke daftar di bawah) --}}
        <div class="col">
            <a href="#panelDipinjam"
               class="card border-0 shadow-sm p-3 h-100 text-decoration-none text-reset">
                <div class="d-flex align-items-center gap-3">
                    <div class="feature-icon">
                        <svg width="22" height="22" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
                            <path d="M8 1.884c-1.545-.887-3.837-1.113-5.487-.573C1.923.42 1.5.904 1.5 1.5v10.5c0 .548.44.98.955.86 1.469-.34 3.618-.146 5.045.567V1.884zm1 11.543c1.427-.713 3.576-.907 5.045-.567.516.12.955-.312.955-.86V1.5c0-.596-.423-1.08-1.013-1.19C12.337.77 10.045.996 8.5 1.884v11.543z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="fw-bold fs-5 text-brand-dark">
                            {{ isset($totalPinjamAktif) ? $totalPinjamAktif : 0 }} Buku
                        </div>
                        <div class="text-secondary small">Sedang Dipinjam</div>
                        @if(($jumlahPeringatan ?? 0) > 0)
                            <div class="text-danger small fw-semibold">&#9888; {{ $jumlahPeringatan }} perlu perhatian</div>
                        @endif
                    </div>
                </div>
            </a>
        </div>

        {{-- Kartu 3: Ajukan Peminjaman (pindahan dari sidebar) --}}
        <div class="col">
            <a href="{{ route('peminjaman.create') }}" class="card border-0 shadow-sm p-3 h-100 text-decoration-none text-reset">
                <div class="d-flex align-items-center gap-3">
                    <div class="feature-icon">
                        <svg width="22" height="22" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                            <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="fw-bold fs-5 text-brand-dark">Ajukan Peminjaman</div>
                        <div class="text-secondary small">
                            @if(($user->status_keanggotaan ?? 'non_aktif') === 'aktif')
                                Pilih buku yang ingin dipinjam
                            @else
                                Perlu keanggotaan aktif
                            @endif
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <style>
        #panelDipinjam { scroll-margin-top: calc(var(--navbar-height, 57px) + 1rem); }
    </style>

    {{-- Panel Buku Yang Sedang Dipinjam: selebar halaman, bisa ganti tampilan list / cover --}}
    <div class="card border-0 shadow-sm no-hover-lift" id="panelDipinjam">
        <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0 d-flex flex-wrap justify-content-between align-items-center gap-2">
            <h2 class="h6 fw-bold mb-0 text-brand-dark d-flex align-items-center gap-2">
                Buku Yang Sedang Dipinjam
                <span class="badge text-bg-secondary">{{ count($bukuSedangDipinjam ?? []) }}</span>
            </h2>
            <div class="d-flex align-items-center gap-3">
                {{-- Pengganti tampilan --}}
                <div class="btn-group btn-group-sm view-toggle" role="group" aria-label="Pilih tampilan">
                    <button type="button" class="btn btn-outline-secondary active" data-view-btn="grid" title="Tampilan cover">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true"><path d="M1 2.5A1.5 1.5 0 0 1 2.5 1h3A1.5 1.5 0 0 1 7 2.5v3A1.5 1.5 0 0 1 5.5 7h-3A1.5 1.5 0 0 1 1 5.5v-3zm8 0A1.5 1.5 0 0 1 10.5 1h3A1.5 1.5 0 0 1 15 2.5v3A1.5 1.5 0 0 1 13.5 7h-3A1.5 1.5 0 0 1 9 5.5v-3zm-8 8A1.5 1.5 0 0 1 2.5 9h3A1.5 1.5 0 0 1 7 10.5v3A1.5 1.5 0 0 1 5.5 15h-3A1.5 1.5 0 0 1 1 13.5v-3zm8 0A1.5 1.5 0 0 1 10.5 9h3a1.5 1.5 0 0 1 1.5 1.5v3a1.5 1.5 0 0 1-1.5 1.5h-3A1.5 1.5 0 0 1 9 13.5v-3z"/></svg>
                    </button>
                    <button type="button" class="btn btn-outline-secondary" data-view-btn="list" title="Tampilan daftar">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/></svg>
                    </button>
                </div>
                <a href="{{ route('peminjaman.riwayat') }}" class="btn btn-sm btn-outline-brand px-3">Lihat Semua</a>
            </div>
        </div>

        <div class="card-body p-4">
            @if(isset($bukuSedangDipinjam) && count($bukuSedangDipinjam) > 0)

                <div class="dipinjam-wrap" id="dipinjamWrap" data-view="grid">

                    {{-- ============ TAMPILAN COVER: baris cover yang bisa digeser ke samping ============ --}}
                    <div class="view-grid book-scroller">
                        <div class="book-track" id="bookTrack">
                            @foreach($bukuSedangDipinjam as $p)
                                <div class="book-card">
                                    <div class="book-cover js-buku-detail" role="button" tabindex="0"
                                         data-judul="{{ $p->buku->judul_buku ?? '' }}"
                                         data-sinopsis="{{ $p->buku->sinopsis ?? '' }}"
                                         data-penulis="{{ $p->buku->pengarang ?? '' }}"
                                         data-penerbit="{{ $p->buku->penerbit ?? '' }}"
                                         data-tahun="{{ $p->buku->tahun_terbit ?? '' }}"
                                         data-halaman="{{ $p->buku->jumlah_halaman ?? '' }}"
                                         data-stok="{{ $p->buku->stok ?? '' }}"
                                         data-cover="{{ $p->buku->thumbnail ?? '' }}">
                                        <div class="book-cover-fallback"><span>{{ $p->buku->judul_buku ?? 'Buku' }}</span></div>
                                        @if(!empty($p->buku->thumbnail))
                                            <img src="{{ $p->buku->thumbnail }}" alt="Cover {{ $p->buku->judul_buku ?? '' }}" loading="lazy" onerror="this.remove()">
                                        @endif
                                    </div>
                                    <div class="book-title" title="{{ $p->buku->judul_buku ?? '' }}">{{ $p->buku->judul_buku ?? 'Judul Buku' }}</div>
                                    <div class="book-meta">
                                        @if($p->tanggal_pinjam)
                                            Kembali {{ date('d M Y', strtotime($p->tanggal_wajib_kembali)) }}
                                        @else
                                            Belum disetujui
                                        @endif
                                    </div>
                                    @if($p->status === 'menunggu_konfirmasi')
                                        <div class="book-status st-tunggu">Menunggu Admin</div>
                                    @elseif(($p->peringatan ?? '') === 'telat')
                                        <div class="book-status st-telat">Telat {{ $p->telat_hari }} hari</div>
                                    @elseif(($p->peringatan ?? '') === 'segera')
                                        <div class="book-status st-segera">{{ $p->sisa_hari == 0 ? 'Jatuh tempo hari ini' : $p->sisa_hari . ' hari lagi' }}</div>
                                    @else
                                        <div class="book-status st-aman">{{ isset($p->sisa_hari) ? $p->sisa_hari . ' hari lagi' : 'Dipinjam' }}</div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        <button type="button" class="book-nav book-nav-prev" id="bookPrev" aria-label="Geser ke kiri">&lsaquo;</button>
                        <button type="button" class="book-nav book-nav-next" id="bookNext" aria-label="Geser ke kanan">&rsaquo;</button>
                    </div>

                    {{-- ============ TAMPILAN LIST: cover di kiri, rincian di kanan ============ --}}
                    <div class="view-list book-list">
                        @foreach($bukuSedangDipinjam as $p)
                            <div class="book-row">
                                <div class="book-row-thumb js-buku-detail" role="button" tabindex="0"
                                     data-judul="{{ $p->buku->judul_buku ?? '' }}"
                                     data-sinopsis="{{ $p->buku->sinopsis ?? '' }}"
                                     data-penulis="{{ $p->buku->pengarang ?? '' }}"
                                     data-penerbit="{{ $p->buku->penerbit ?? '' }}"
                                     data-tahun="{{ $p->buku->tahun_terbit ?? '' }}"
                                     data-halaman="{{ $p->buku->jumlah_halaman ?? '' }}"
                                     data-stok="{{ $p->buku->stok ?? '' }}"
                                     data-cover="{{ $p->buku->thumbnail ?? '' }}">
                                    <div class="book-cover-fallback"><span>{{ $p->buku->judul_buku ?? 'Buku' }}</span></div>
                                    @if(!empty($p->buku->thumbnail))
                                        <img src="{{ $p->buku->thumbnail }}" alt="" loading="lazy" onerror="this.remove()">
                                    @endif
                                </div>
                                <div class="book-row-body">
                                    <div class="book-row-title">{{ $p->buku->judul_buku ?? 'Judul Buku' }}</div>
                                    <div class="book-row-sub">{{ $p->buku->pengarang ?? '-' }} &middot; {{ $p->buku->penerbit ?? '-' }}</div>

                                    @if($p->tanggal_pinjam)
                                        <div class="book-line"><span>Tgl pinjam</span><span class="time">{{ date('d M Y', strtotime($p->tanggal_pinjam)) }}</span></div>
                                        <div class="book-line"><span>Wajib kembali</span><span class="time">{{ date('d M Y', strtotime($p->tanggal_wajib_kembali)) }}</span></div>
                                    @else
                                        <div class="book-line"><span>Masa pinjam ditentukan setelah disetujui admin</span></div>
                                    @endif

                                    @if($p->status === 'menunggu_konfirmasi')
                                        <div class="book-line st-tunggu"><span>Menunggu Admin</span></div>
                                    @elseif(($p->peringatan ?? '') === 'telat')
                                        <div class="book-line st-telat"><span>Telat {{ $p->telat_hari }} hari</span><span class="time">Denda Rp {{ number_format($p->denda_berjalan, 0, ',', '.') }}</span></div>
                                    @elseif(($p->peringatan ?? '') === 'segera')
                                        <div class="book-line st-segera"><span>{{ $p->sisa_hari == 0 ? 'Jatuh tempo hari ini' : $p->sisa_hari . ' hari lagi' }}</span></div>
                                    @else
                                        <div class="book-line st-aman"><span>{{ isset($p->sisa_hari) ? $p->sisa_hari . ' hari lagi' : 'Sedang dipinjam' }}</span></div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>

            @else
                <div class="text-center py-5 text-secondary">
                    <p class="mb-2">Belum ada buku yang sedang dipinjam.</p>
                    @if(($user->status_keanggotaan ?? 'non_aktif') === 'aktif')
                        <a href="{{ route('peminjaman.create') }}" class="btn btn-sm btn-outline-secondary">Mulai Pinjam Buku</a>
                    @endif
                </div>
            @endif
        </div>
    </div>

    <script>
        // "Cari Koleksi": buka sidebar, lalu buka daftar Kategori Buku dan gulir ke sana
        (function () {
            var tombol = document.getElementById('btnCariKoleksi');
            if (!tombol) return;

            tombol.addEventListener('click', function () {
                var sidebar = document.getElementById('sidebarUtama');
                if (!sidebar) return;
                var offcanvas = bootstrap.Offcanvas.getOrCreateInstance(sidebar);

                function bukaKategori() {
                    var daftar = document.getElementById('sidebarKategoriList');
                    if (!daftar) return;
                    bootstrap.Collapse.getOrCreateInstance(daftar, { toggle: false }).show();
                    var pemicu = document.querySelector('[data-bs-target="#sidebarKategoriList"]');
                    if (pemicu) {
                        pemicu.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        pemicu.focus({ preventScroll: true });
                    }
                }

                if (sidebar.classList.contains('show')) {
                    bukaKategori();
                } else {
                    sidebar.addEventListener('shown.bs.offcanvas', bukaKategori, { once: true });
                    offcanvas.show();
                }
            });
        })();
    </script>

    <script>
        // Panah geser untuk baris cover
        (function () {
            var track = document.getElementById('bookTrack');
            if (!track) return;
            var prev = document.getElementById('bookPrev');
            var next = document.getElementById('bookNext');

            function perbarui() {
                var bisaGeser = track.scrollWidth > track.clientWidth + 2;
                prev.style.display = bisaGeser && track.scrollLeft > 4 ? 'block' : 'none';
                next.style.display = bisaGeser && track.scrollLeft + track.clientWidth < track.scrollWidth - 4 ? 'block' : 'none';
            }
            function geser(arah) {
                track.scrollBy({ left: arah * track.clientWidth * 0.8, behavior: 'smooth' });
            }

            prev.addEventListener('click', function () { geser(-1); });
            next.addEventListener('click', function () { geser(1); });
            track.addEventListener('scroll', perbarui);
            window.addEventListener('resize', perbarui);
            perbarui();

            // hitung ulang saat pindah ke tampilan cover
            document.querySelectorAll('[data-view-btn]').forEach(function (b) {
                b.addEventListener('click', function () { setTimeout(perbarui, 50); });
            });
        })();
    </script>

    <script>
        // Simpan pilihan tampilan (cover / list) di browser supaya diingat saat halaman dibuka lagi
        (function () {
            var wrap = document.getElementById('dipinjamWrap');
            if (!wrap) return;
            var tombol = document.querySelectorAll('[data-view-btn]');

            function pakai(mode) {
                wrap.setAttribute('data-view', mode);
                tombol.forEach(function (b) {
                    b.classList.toggle('active', b.getAttribute('data-view-btn') === mode);
                });
            }

            var tersimpan = null;
            try { tersimpan = localStorage.getItem('nexlib_view_dipinjam'); } catch (e) {}
            pakai(tersimpan === 'list' ? 'list' : 'grid');

            tombol.forEach(function (b) {
                b.addEventListener('click', function () {
                    var mode = b.getAttribute('data-view-btn');
                    pakai(mode);
                    try { localStorage.setItem('nexlib_view_dipinjam', mode); } catch (e) {}
                });
            });
        })();
    </script>

@include('partials.modal_buku')

@endsection