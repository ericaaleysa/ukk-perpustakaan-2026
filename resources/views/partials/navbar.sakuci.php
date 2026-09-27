<nav class="navbar navbar-expand bg-body border-bottom sticky-top">
    <div class="container-fluid px-3 px-lg-4 d-flex align-items-center justify-content-between">
        
        {{-- Sisi Kiri Navbar: Menu Sidebar, Icon Status DB (Buku), & Brand --}}
        <div class="d-flex align-items-center gap-2">
            @php
                $dbConnected = false;
                try {
                    \Sakuci\Database\Connection::pdo();
                    $dbConnected = true;
                } catch (\Throwable $e) {
                    $dbConnected = false;
                }
            @endphp

            {{-- Tombol Offcanvas Sidebar --}}
            <button type="button" class="nav-link d-flex align-items-center gap-1 p-0 border-0 bg-transparent me-1"
                    data-bs-toggle="offcanvas" data-bs-target="#sidebarUtama" aria-controls="sidebarUtama"
                    title="Menu Lainnya" aria-label="Buka menu lainnya">
                <svg width="20" height="20" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M2.5 3.5A.5.5 0 0 1 3 3h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0 4.5A.5.5 0 0 1 3 7.5h10a.5.5 0 0 1 0 1H3A.5.5 0 0 1 2.5 8zm0 4.5a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
                </svg>
            </button>

            {{-- Brand Link + Icon Buku Status Database --}}
            <a class="navbar-brand fw-semibold m-0 d-flex align-items-center gap-2" href="{{ route('home') }}"
               title="Status database: {{ $dbConnected ? 'terhubung' : 'tidak terhubung' }}">
               
                @if ($dbConnected)
                    {{-- Icon Buku Terbuka (Database Terhubung - Hijau) --}}
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#28a745" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                        <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
                    </svg>
                @else
                    {{-- Icon Buku Tertutup (Database Terputus - Merah) --}}
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#dc3545" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                        <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                    </svg>
                @endif

                <span>NEX-LIB</span>
            </a>
        </div>

        {{-- Sisi Kanan Navbar: Button Theme Toggle --}}
        <div class="d-flex align-items-center">
            <button id="themeToggle" type="button" class="theme-toggle-btn"
                    aria-label="Ganti tema terang/gelap"
                    title="Ganti tema terang/gelap">
                <span class="theme-toggle-icon-wrapper">
                    {{-- Ikon Matahari (Mode Terang) --}}
                    <svg class="theme-icon icon-sun" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <circle cx="12" cy="12" r="5"></circle>
                        <line x1="12" y1="1" x2="12" y2="3"></line>
                        <line x1="12" y1="21" x2="12" y2="23"></line>
                        <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
                        <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
                        <line x1="1" y1="12" x2="3" y2="12"></line>
                        <line x1="21" y1="12" x2="23" y2="12"></line>
                        <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
                        <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
                    </svg>

                    {{-- Ikon Bulan Sabit (Mode Gelap) --}}
                    <svg class="theme-icon icon-moon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
                    </svg>
                </span>
            </button>
        </div>

    </div>
</nav>

{{-- Mengukur tinggi navbar secara dinamis --}}
<script>
    (function () {
        function setNavbarHeightVar() {
            var navbar = document.querySelector('.navbar');
            if (navbar) {
                document.documentElement.style.setProperty('--navbar-height', navbar.offsetHeight + 'px');
            }
        }
        setNavbarHeightVar();
        window.addEventListener('resize', setNavbarHeightVar);
    })();
</script>