<nav class="navbar navbar-expand-lg bg-body border-bottom sticky-top">
    <div class="container">
        <div class="d-flex align-items-center gap-2">
            <button id="sidebarToggle" type="button" class="btn btn-sm btn-outline-secondary border-0 px-2"
                    data-bs-toggle="offcanvas" data-bs-target="#sidebarUtama" aria-controls="sidebarUtama"
                    aria-label="Buka menu sidebar" title="Buka menu">
                <svg width="20" height="20" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M2.5 3a.5.5 0 0 0 0 1h11a.5.5 0 0 0 0-1h-11zm0 4a.5.5 0 0 0 0 1h11a.5.5 0 0 0 0-1h-11zm0 4a.5.5 0 0 0 0 1h11a.5.5 0 0 0 0-1h-11z"/>
                </svg>
            </button>

            @php
                $dbConnected = false;
                try {
                    \Sakuci\Database\Connection::pdo();
                    $dbConnected = true;
                } catch (\Throwable $e) {
                    $dbConnected = false;
                }
            @endphp
            <button id="themeToggle" type="button" class="logo-toggle"
                    aria-label="Ganti tema terang/gelap (status database: {{ $dbConnected ? 'terhubung' : 'tidak terhubung' }})"
                    title="Ganti tema terang/gelap">
                <svg width="28" height="28" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" style="display: block;" aria-hidden="true">
                    <circle class="logo-ring" cx="16" cy="16" r="15"/>
                    <circle cx="16" cy="16" r="9" fill="{{ $dbConnected ? '#28a745' : '#dc3545' }}"/>
                </svg>
            </button>
            <a class="navbar-brand fw-semibold m-0" href="{{ route('home') }}">Perpustakaan Online</a>
        </div>

        <button class="navbar-toggler border-0" type="button"
                data-bs-toggle="collapse" data-bs-target="#menuUtama"
                aria-controls="menuUtama" aria-expanded="false" aria-label="Buka menu">
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- Tambahkan menu aplikasi Anda di sini --}}
        <div class="collapse navbar-collapse" id="menuUtama">
            @php
                $currentUser = \App\Models\User::current();
                $isAdmin = $currentUser && $currentUser->role === 'admin';
            @endphp

            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1">

                @if ($isAdmin)
                    <li class="nav-item">
                        <a class="nav-link {{ is_route('kategori.index') ? 'active' : '' }}" href="{{ route('kategori.index') }}">Kategori</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ is_route('data_buku.index') ? 'active' : '' }}" href="{{ route('data_buku.index') }}">Data Buku</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ is_route('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}" class="d-lg-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-secondary w-100 mt-2 mt-lg-0">Logout ({{ $currentUser->username }})</button>
                        </form>
                    </li>
                @elseif ($currentUser)
                    {{-- Pengguna login tapi bukan admin (misal role siswa) --}}
                    <li class="nav-item">
                        <a class="nav-link {{ is_route('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}" class="d-lg-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-secondary w-100 mt-2 mt-lg-0">Logout ({{ $currentUser->username }})</button>
                        </form>
                    </li>
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
                    @if ($canRegister)
                        <li class="nav-item">
                            <a class="nav-link {{ is_route('register') ? 'active' : '' }}" href="{{ route('register') }}">Daftar</a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a class="btn btn-sm btn-brand rounded-pill px-3 d-inline-flex align-items-center gap-2 mt-2 mt-lg-0" href="{{ route('login') }}">
                            <svg width="14" height="14" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <circle cx="8" cy="5" r="3" fill="currentColor" stroke="none"/>
                                <path d="M2.5 14c0-3.6 2.9-5.8 5.5-5.8s5.5 2.2 5.5 5.8"/>
                            </svg>
                            Masuk
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>