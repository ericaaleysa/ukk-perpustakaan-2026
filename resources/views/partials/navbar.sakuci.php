<nav class="navbar navbar-expand bg-body border-bottom sticky-top">
    <div class="container-fluid px-3 px-lg-4 d-flex align-items-center justify-content-between">
        
        {{-- Sisi Kiri Navbar: Menu Sidebar, Icon Status DB (Buku Solid), & Brand --}}
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
                    title="Menu Sidebar" aria-label="Buka menu sidebar">
                <svg width="20" height="20" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M2.5 3.5A.5.5 0 0 1 3 3h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0 4.5A.5.5 0 0 1 3 7.5h10a.5.5 0 0 1 0 1H3A.5.5 0 0 1 2.5 8zm0 4.5a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
                </svg>
            </button>

            <a class="navbar-brand fw-semibold m-0 d-flex align-items-center gap-2" href="{{ route('home') }}"
               title="Status database: {{ $dbConnected ? 'terhubung' : 'tidak terhubung' }}">
               
                @if ($dbConnected)
                    <svg width="22" height="22" viewBox="0 0 16 16" fill="#db3cfb" aria-hidden="true">
                        <path d="M1 2.828c.885-.37 2.154-.769 3.388-.893 1.33-.134 2.458.063 3.112.752v9.746c-.935-.53-2.12-.603-3.213-.493-1.18.12-2.37.461-3.287.811V2.828zm7.5-.141c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v10.155c-.917-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492V2.687z"/>
                    </svg>
                @else
                    <svg width="22" height="22" viewBox="0 0 16 16" fill="rgba(255, 255, 255, 0.4)" aria-hidden="true">
                        <path d="M1 2.5A1.5 1.5 0 0 1 2.5 1h3A1.5 1.5 0 0 1 7 2.5v11A1.5 1.5 0 0 1 5.5 15h-3A1.5 1.5 0 0 1 1 13.5v-11zM8 1a2 2 0 0 1 2-2h3.5A1.5 1.5 0 0 1 15 0.5v11a1.5 1.5 0 0 1-1.5 1.5H10a2 2 0 0 1-2-2V1z"/>
                    </svg>
                @endif

                <div class="fw-semibold small">NEXLIB</div>
            </a>
        </div>

        {{-- Sisi Kanan Navbar: Button Theme Toggle --}}
        <div class="d-flex align-items-center">
            <button id="themeToggle" type="button" class="theme-toggle-btn"
                    aria-label="Ganti tema terang/gelap"
                    title="Mode Tema">
                <span class="theme-toggle-icon-wrapper">
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