{{-- Sidebar utama, dibuka lewat tombol di navbar. Perlu di-@include sekali di layouts.app --}}

<div class="offcanvas offcanvas-start" tabindex="-1" id="sidebarUtama" aria-labelledby="sidebarUtamaLabel">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title fw-semibold" id="sidebarUtamaLabel">Menu</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Tutup"></button>
    </div>
    <div class="offcanvas-body p-0 d-flex flex-column h-100" style="overflow: hidden;">
        @php
            $sidebarUser = \App\Models\User::current();
            $sidebarIsAdmin = $sidebarUser && $sidebarUser->role === 'admin';
        @endphp
        <div class="flex-grow-1" style="overflow-y: auto;">
            <div class="sidebar-section-title">Fitur Utama</div>
            <ul class="nav nav-pills flex-column p-2 gap-1">
                <li class="nav-item">
                    <a class="nav-link {{ is_route('home') ? 'active' : '' }}" href="{{ route('home') }}">Beranda</a>
                </li>

                <li class="nav-item">
                    <button class="nav-link w-100 text-start d-flex justify-content-between align-items-center" type="button"
                            data-bs-toggle="collapse" data-bs-target="#sidebarKategoriList"
                            aria-expanded="false" aria-controls="sidebarKategoriList">
                        Kategori Buku
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
                    <button class="nav-link w-100 text-start d-flex justify-content-between align-items-center" type="button"
                            data-bs-toggle="collapse" data-bs-target="#sidebarPeminjamanList"
                            aria-expanded="false" aria-controls="sidebarPeminjamanList">
                        Peminjaman Buku
                        <svg width="12" height="12" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
                            <path d="M4 6l4 4 4-4H4z"/>
                        </svg>
                    </button>
                    <div class="collapse" id="sidebarPeminjamanList">
                        <ul class="nav flex-column ms-3 mt-1">
                            <li class="nav-item">
                                <a class="nav-link py-1 {{ is_route('peminjaman.create') ? 'active' : '' }}" href="{{ route('peminjaman.create') }}">Ajukan Peminjaman</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link py-1 {{ is_route('peminjaman.riwayat') ? 'active' : '' }}" href="{{ route('peminjaman.riwayat') }}">Riwayat Peminjaman</a>
                            </li>
                        </ul>
                    </div>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link {{ is_route('keanggotaan.create') ? 'active' : '' }}" href="{{ route('keanggotaan.create') }}">Ajukan Keanggotaan</a>
                </li>
            </ul>

            @if ($sidebarIsAdmin)
                <div class="sidebar-section-title">Kelola</div>
                <ul class="nav nav-pills flex-column p-2 gap-1">
                    <li class="nav-item">
                        <a class="nav-link {{ is_route('kategori.index') ? 'active' : '' }}" href="{{ route('kategori.index') }}">Kategori</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ is_route('data_buku.index') ? 'active' : '' }}" href="{{ route('data_buku.index') }}">Data Buku</a>
                    </li>
                    <li><hr class="sidebar-divider"></li>
                    <li class="nav-item">
                        <a class="nav-link {{ is_route('keanggotaan.index') ? 'active' : '' }}" href="{{ route('keanggotaan.index') }}">Verifikasi Keanggotaan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ is_route('anggota.index') ? 'active' : '' }}" href="{{ route('anggota.index') }}">Kelola Anggota</a>
                    </li>
                    <li><hr class="sidebar-divider"></li>
                    <li class="nav-item">
                        <a class="nav-link {{ is_route('peminjaman.index') ? 'active' : '' }}" href="{{ route('peminjaman.index') }}">Kelola Peminjaman</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ is_route('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">Dashboard</a>
                    </li>
                </ul>
            @endif
        </div>

        <div class="p-3 border-top text-center flex-shrink-0">
            <div class="fw-semibold small"><span class="text-brand ">NEXUS</span>-LIBRARY</div>
            <div class="text-secondary" style="font-size: 0.7rem;">Akselerasi Literasi, Memicu Energi Vokasi</div>
        </div>
    </div>
</div>