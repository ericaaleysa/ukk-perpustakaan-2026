<div class="offcanvas offcanvas-start" tabindex="-1" id="sidebarUtama" aria-labelledby="sidebarUtamaLabel">
    @php
        $sidebarUser = \App\Models\User::current();
        $sidebarIsAdmin = $sidebarUser && $sidebarUser->role === 'admin';
        
        $dbConnected = false;
        try {
            \Sakuci\Database\Connection::pdo();
            $dbConnected = true;
        } catch (\Throwable $e) {
            $dbConnected = false;
        }
    @endphp

    <div class="flex-grow-1 d-flex flex-column justify-content-between" style="overflow-y: auto;">
        <div>
            @if ($sidebarIsAdmin)
                {{-- Admin login --}}
                <div class="sidebar-section-title">Fitur Admin</div>
                <ul class="nav nav-pills flex-column p-2 gap-1">
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-2 {{ is_route('home') ? 'active' : '' }}" href="{{ route('home') }}">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" class="flex-shrink-0">
                                <path d="M8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5v-4h3v4a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L8.354 1.146z"/>
                            </svg>
                            Beranda
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-2 {{ is_route('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" class="flex-shrink-0">
                                <path d="M1 2.5A1.5 1.5 0 0 1 2.5 1h3A1.5 1.5 0 0 1 7 2.5v3A1.5 1.5 0 0 1 5.5 7h-3A1.5 1.5 0 0 1 1 5.5v-3zm8 0A1.5 1.5 0 0 1 10.5 1h3A1.5 1.5 0 0 1 15 2.5v3A1.5 1.5 0 0 1 13.5 7h-3A1.5 1.5 0 0 1 9 5.5v-3zm-8 8A1.5 1.5 0 0 1 2.5 9h3A1.5 1.5 0 0 1 7 10.5v3A1.5 1.5 0 0 1 5.5 15h-3A1.5 1.5 0 0 1 1 13.5v-3zm8 0A1.5 1.5 0 0 1 10.5 9h3a1.5 1.5 0 0 1 1.5 1.5v3a1.5 1.5 0 0 1-1.5 1.5h-3A1.5 1.5 0 0 1 9 13.5v-3z"/>
                            </svg>
                            Kelola Perpustakaan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-2 {{ is_route('keanggotaan.index') ? 'active' : '' }}" href="{{ route('keanggotaan.index') }}">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" class="flex-shrink-0">
                                <path d="M8 0a.5.5 0 0 1 .146.021l6 2A.5.5 0 0 1 14.5 2.5v4.243c0 4.248-2.937 7.634-6.234 8.716a.5.5 0 0 1-.532 0C4.437 14.377 1.5 10.991 1.5 6.743V2.5a.5.5 0 0 1 .354-.479l6-2A.5.5 0 0 1 8 0z"/>
                                <path d="M10.03 5.22a.75.75 0 0 1 0 1.06L7.53 8.78a.75.75 0 0 1-1.06 0L5.22 7.53a.75.75 0 1 1 1.06-1.06L7 7.19l2.97-2.97a.75.75 0 0 1 1.06 0z"/>
                            </svg>
                            Verifikasi Keanggotaan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-2 {{ is_route('kategori.index') ? 'active' : '' }}" href="{{ route('kategori.index') }}">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" class="flex-shrink-0">
                                <path d="M2 2.5A1.5 1.5 0 0 1 3.5 1h4.086a1.5 1.5 0 0 1 1.06.44l5.914 5.914a1.5 1.5 0 0 1 0 2.12l-4.086 4.086a1.5 1.5 0 0 1-2.12 0L2.44 7.646A1.5 1.5 0 0 1 2 6.586V2.5zM5 5a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
                            </svg>
                            Kategori Buku
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-2 {{ is_route('data_buku.index') ? 'active' : '' }}" href="{{ route('data_buku.index') }}">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" class="flex-shrink-0">
                                <path d="M8 1.884c-1.545-.887-3.837-1.113-5.487-.573C1.923.42 1.5.904 1.5 1.5v10.5c0 .548.44.98.955.86 1.469-.34 3.618-.146 5.045.567V1.884zm1 11.543c1.427-.713 3.576-.907 5.045-.567.516.12.955-.312.955-.86V1.5c0-.596-.423-1.08-1.013-1.19C12.337.77 10.045.996 8.5 1.884v11.543z"/>
                            </svg>
                            Data Buku
                        </a>
                    </li>
                </ul>
            @else
                {{-- Pengguna biasa / Publik --}}
                <div class="sidebar-section-title">Fitur Utama</div>
                <ul class="nav nav-pills flex-column p-2 gap-1">
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-2 {{ is_route('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" class="flex-shrink-0">
                                <path d="M8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5v-4h3v4a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L8.354 1.146z"/>
                            </svg>
                            Beranda
                        </a>
                    </li>

                    <li class="nav-item">
                        <button class="nav-link w-100 text-start d-flex align-items-center justify-content-between" type="button"
                                data-bs-toggle="collapse" data-bs-target="#sidebarKategoriList"
                                aria-expanded="false" aria-controls="sidebarKategoriList">
                            <span class="d-flex align-items-center gap-2">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" class="flex-shrink-0">
                                    <path d="M2 2.5A1.5 1.5 0 0 1 3.5 1h4.086a1.5 1.5 0 0 1 1.06.44l5.914 5.914a1.5 1.5 0 0 1 0 2.12l-4.086 4.086a1.5 1.5 0 0 1-2.12 0L2.44 7.646A1.5 1.5 0 0 1 2 6.586V2.5zM5 5a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
                                </svg>
                                Kategori Buku
                            </span>
                            <svg width="12" height="12" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" class="flex-shrink-0">
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
                        <button class="nav-link w-100 text-start d-flex align-items-center justify-content-between" type="button"
                                data-bs-toggle="collapse" data-bs-target="#sidebarPeminjamanList"
                                aria-expanded="false" aria-controls="sidebarPeminjamanList">
                            <span class="d-flex align-items-center gap-2">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" class="flex-shrink-0">
                                    <path fill-rule="evenodd" d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z"/>
                                    <path d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7h-1.017A5.002 5.002 0 0 0 8 3zm-3.917 6A5.002 5.002 0 0 0 8 13c1.552 0 2.94-.707 3.857-1.818a.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9h1.017z"/>
                                </svg>
                                Peminjaman Buku
                            </span>
                            <svg width="12" height="12" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" class="flex-shrink-0">
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
                        <a class="nav-link d-flex align-items-center gap-2 {{ is_route('keanggotaan.create') ? 'active' : '' }}" href="{{ route('keanggotaan.create') }}">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" class="flex-shrink-0">
                                <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2 1c-2.67 0-5.5 1.34-5.5 3v1h8.256A4.5 4.5 0 0 1 10 10.5c0-.827.224-1.6.614-2.264A8.99 8.99 0 0 0 8 9z"/>
                                <path fill-rule="evenodd" d="M13.5 7a.5.5 0 0 1 .5.5V9h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V10h-1.5a.5.5 0 0 1 0-1H13V7.5a.5.5 0 0 1 .5-.5z"/>
                            </svg>
                            Ajukan Keanggotaan
                        </a>
                    </li>
                </ul>
            @endif
        </div>

        {{-- Section Login/Logout & Akun di bawah Menu Sidebar --}}
        <div class="p-3 border-top mt-auto">
            @if ($sidebarUser)
                <div class="d-flex align-items-center justify-content-between gap-2 mb-2">
                    <div class="text-truncate">
                        <div class="fw-semibold small text-truncate">{{ $sidebarUser->username }}</div>
                        <div class="text-secondary opacity-75" style="font-size: 0.75rem;">{{ ucfirst($sidebarUser->role) }}</div>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-secondary w-100 d-flex align-items-center justify-content-center gap-2">
                        <svg width="14" height="14" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z"/>
                            <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
                        </svg>
                        Logout
                    </button>
                </form>
            @else
                @php
                    $canRegister = false;
                    if ($dbConnected) {
                        try {
                            $canRegister = \App\Models\Role::where('can_register', 1)->exists();
                        } catch (\Throwable $e) {
                            $canRegister = false;
                        }
                    }
                @endphp
                <div class="d-grid gap-2">
                    <a class="btn btn-sm btn-brand rounded-pill px-3 d-flex align-items-center justify-content-center gap-2" href="{{ route('login') }}">
                        <svg width="14" height="14" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <circle cx="8" cy="5" r="3" fill="currentColor" stroke="none"/>
                            <path d="M2.5 14c0-3.6 2.9-5.8 5.5-5.8s5.5 2.2 5.5 5.8"/>
                        </svg>
                        Masuk
                    </a>
                    @if ($canRegister)
                        <a class="btn btn-sm btn-outline-secondary rounded-pill px-3 text-center" href="{{ route('register') }}">
                            <svg width="14" height="14" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <circle cx="8" cy="5" r="3" fill="currentColor" stroke="none"/>
                                <path d="M2.5 14c0-3.6 2.9-5.8 5.5-5.8s5.5 2.2 5.5 5.8"/>
                            </svg>
                            Daftar
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>

    {{-- Footer Sidebar --}}
    <div class="p-3 border-top text-center flex-shrink-0">
        <div class="fw-semibold small">NEXUS DIGITAL LIBRARY</div>
        <div class="text-secondary" style="font-size: 0.7rem;">Akselerasi Literasi, Memicu Energi Vokasi</div>
    </div>
</div>