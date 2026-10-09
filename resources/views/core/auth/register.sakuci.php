@extends('layouts.app')

@section('title', 'Daftar')

@section('content')

    <section class="hero-section hero-section-landing text-center">
        <div class="hero-bg" aria-hidden="true">
            <span class="hero-blob hero-blob-1"></span>
            <span class="hero-blob hero-blob-2"></span>
            <span class="hero-blob hero-blob-3"></span>
        </div>

        <div class="hero-stars" aria-hidden="true">
            <svg class="star-icon star-1" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0L14.59 9.41L24 12L14.59 14.59L12 24L9.41 14.59L0 12L9.41 9.41L12 0Z"/></svg>
            <svg class="star-icon star-2" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0L14.59 9.41L24 12L14.59 14.59L12 24L9.41 14.59L0 12L9.41 9.41L12 0Z"/></svg>
            <svg class="star-icon star-3" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0L14.59 9.41L24 12L14.59 14.59L12 24L9.41 14.59L0 12L9.41 9.41L12 0Z"/></svg>
            <svg class="star-icon star-4" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0L14.59 9.41L24 12L14.59 14.59L12 24L9.41 14.59L0 12L9.41 9.41L12 0Z"/></svg>
        </div>

        {{-- Toggle tema (sama seperti di halaman welcome) --}}
        <button id="themeToggle" type="button" class="theme-toggle-btn hero-theme-toggle"
                aria-label="Ganti tema terang/gelap" title="Mode Tema">
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
                <svg class="theme-icon icon-moon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
                </svg>
            </span>
        </button>

        <div class="hero-content w-100">
            <h1 class="display-6 fw-extrabold mb-4">
                REGISTER
            </h1>

            <div class="card hero-feature-card border-0 shadow-sm no-hover-lift auth-card">
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('register.attempt') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label" for="username">Username</label>
                            <input type="text" id="username" name="username" value="{{ old('username') }}" class="form-control {{ errors()->has('username') ? 'is-invalid' : '' }}" autofocus>
                            @error('username') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="password">Password</label>
                            <div class="password-field">
                                <input type="password" id="password" name="password" class="form-control {{ errors()->has('password') ? 'is-invalid' : '' }}">
                                <button type="button" class="password-toggle" aria-label="Tampilkan password" aria-pressed="false">
                                <svg class="icon-eye" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
                                    <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                                    <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                                </svg>
                                <svg class="icon-eye-off" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
                                    <path d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7.028 7.028 0 0 0-2.79.588l.77.771A5.944 5.944 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.134 13.134 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755-.165.165-.337.328-.517.486l.708.709z"/>
                                    <path d="M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.829 2.829l.822.822zm-2.943 1.299.822.822a3.5 3.5 0 0 1-4.474-4.474l.823.823a2.5 2.5 0 0 0 2.829 2.829z"/>
                                    <path d="M3.35 5.47c-.18.16-.353.322-.518.487A13.134 13.134 0 0 0 1.172 8l.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7.029 7.029 0 0 1 8 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.709zm10.296 8.884-12-12 .708-.708 12 12-.708.708z"/>
                                </svg>
                            </button>
                                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="password_confirmation">Konfirmasi password</label>
                            <div class="password-field">
                                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control">
                                <button type="button" class="password-toggle" aria-label="Tampilkan password" aria-pressed="false">
                                <svg class="icon-eye" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
                                    <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                                    <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                                </svg>
                                <svg class="icon-eye-off" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
                                    <path d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7.028 7.028 0 0 0-2.79.588l.77.771A5.944 5.944 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.134 13.134 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755-.165.165-.337.328-.517.486l.708.709z"/>
                                    <path d="M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.829 2.829l.822.822zm-2.943 1.299.822.822a3.5 3.5 0 0 1-4.474-4.474l.823.823a2.5 2.5 0 0 0 2.829 2.829z"/>
                                    <path d="M3.35 5.47c-.18.16-.353.322-.518.487A13.134 13.134 0 0 0 1.172 8l.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7.029 7.029 0 0 1 8 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.709zm10.296 8.884-12-12 .708-.708 12 12-.708.708z"/>
                                </svg>
                            </button>
                            </div>
                        </div>

                        @if (count($roles) > 1)
                            <div class="mb-3">
                                <label class="form-label" for="role">Daftar sebagai</label>
                                <select id="role" name="role" class="form-select {{ errors()->has('role') ? 'is-invalid' : '' }}">
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->name }}" {{ old('role') === $role->name ? 'selected' : '' }}>{{ $role->name }}</option>
                                    @endforeach
                                </select>
                                @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        @else
                            <input type="hidden" name="role" value="{{ $roles[0]->name }}">
                        @endif

                        <button class="btn btn-brand w-100 py-2 fw-semibold mt-2" type="submit">Daftar</button>
                    </form>

                    <p class="text-secondary small text-center mt-3 mb-0">Sudah punya akun? <a href="{{ route('login') }}" class="fw-semibold">Masuk di sini</a></p>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('home') }}" class="btn btn-sm btn-outline-secondary px-3">&larr;</a>
            </div>
        </div>
    </section>

@endsection

@section('scripts')
    <script src="{{ asset('js/password-toggle.js') }}"></script>
@endsection