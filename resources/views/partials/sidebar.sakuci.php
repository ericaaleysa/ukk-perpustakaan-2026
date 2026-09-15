{{-- Sidebar utama, dibuka lewat tombol di navbar. Perlu di-@include sekali di layouts.app --}}

<div class="offcanvas offcanvas-start" tabindex="-1" id="sidebarUtama" aria-labelledby="sidebarUtamaLabel">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title fw-semibold" id="sidebarUtamaLabel">Menu</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Tutup"></button>
    </div>
    <div class="offcanvas-body p-0 d-flex flex-column h-100" style="overflow: hidden;">
        <div class="flex-grow-1" style="overflow-y: auto;">
            <ul class="nav nav-pills flex-column p-2 gap-1">
                <li class="nav-item">
                    <a class="nav-link {{ is_route('home') ? 'active' : '' }}" href="{{ route('home') }}">Beranda</a>
                </li>

                <li class="nav-item">
                    <button class="nav-link w-100 text-start d-flex justify-content-between align-items-center" type="button"
                            data-bs-toggle="collapse" data-bs-target="#sidebarKategoriList"
                            aria-expanded="false" aria-controls="sidebarKategoriList">
                        Kategori
                        <svg width="12" height="12" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
                            <path d="M4 6l4 4 4-4H4z"/>
                        </svg>
                    </button>
                    <div class="collapse" id="sidebarKategoriList">
                        @php
                            $sidebarKategori = [];
                            try {
                                $sidebarKategori = \App\Models\Kategori::all();
                            } catch (\Throwable $e) {
                                $sidebarKategori = [];
                            }
                        @endphp

                        <ul class="nav flex-column ms-3 mt-1">
                            @forelse($sidebarKategori as $kat)
                                <li class="nav-item">
                                    <a class="nav-link py-1" href="{{ route('kategori.show', [$kat->id_kategori]) }}">
                                        {{ $kat->nama_kategori }}
                                    </a>
                                </li>
                            @empty
                                <li class="nav-item">
                                    <span class="nav-link py-1 text-secondary small">Belum ada kategori</span>
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    {{-- TODO: ganti href="#" dengan route('peminjaman.index') setelah fitur peminjaman dibuat --}}
                    <a class="nav-link" href="#">Peminjaman Buku</a>
                </li>
            </ul>
        </div>

        <div class="p-3 border-top text-center flex-shrink-0">
            <div class="fw-semibold small">DigiLib <span class="text-brand ">Vokasi Quanta</span></div>
            <div class="text-secondary" style="font-size: 0.7rem;">Akselerasi Literasi, Memicu Energi Vokasi</div>
        </div>
    </div>
</div>