@extends('layouts.app')

@section('title', 'Ajukan Peminjaman')

@section('content')

@php
    // Kelompokkan buku per huruf awal (urutan A-Z seperti kamus), tanpa kategori
    $kelompokHuruf = [];
    foreach ($daftarBukuTampil as $b) {
        $huruf = strtoupper(substr(trim($b->judul_buku), 0, 1));
        if (!preg_match('/[A-Z]/', $huruf)) {
            $huruf = '#';
        }
        $kelompokHuruf[$huruf][] = $b;
    }
    $idDipilih = $bukuDipilih ? $bukuDipilih->id_buku : '';
@endphp

<style>
    .pick-list { max-height: 480px; overflow-y: auto; }
    .pick-letter {
        position: sticky; top: 0; z-index: 1;
        padding: .25rem 1rem; font-size: .75rem; font-weight: 700; letter-spacing: .08em;
        color: var(--brand-dark); background: var(--brand-subtle);
    }
    .pick-item {
        display: flex; align-items: center; gap: .75rem;
        padding: .6rem 1rem; color: inherit; text-decoration: none;
        border-left: 3px solid transparent;
    }
    .pick-item:hover { color: inherit; background: color-mix(in srgb, var(--brand) 8%, transparent); }
    .pick-item.selected {
        background: color-mix(in srgb, var(--brand) 15%, transparent);
        border-left-color: var(--brand);
    }
    .pick-cover {
        width: 40px; height: 56px; object-fit: cover; border-radius: 4px; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
        background: var(--bs-tertiary-bg);
    }
    .pick-preview-cover {
        width: 96px; height: 136px; object-fit: cover; border-radius: 8px; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
        background: var(--bs-tertiary-bg); font-size: 2rem;
    }
</style>

<div class="admin-page">

    <div class="mb-4">
        <h1 class="h3 admin-title">Ajukan Peminjaman</h1>
        <p class="admin-subtitle">Cari buku di daftar, lalu pilih untuk dipinjam.</p>
    </div>

    @if($currentUser->status_keanggotaan !== 'aktif')
        <div style="max-width: 640px;">
            <div class="notice">
                <strong>Kamu belum menjadi anggota aktif.</strong>
                Jadi anggota aktif dulu untuk bisa meminjam buku.
                <a href="{{ route('keanggotaan.create') }}">Ajukan keanggotaan</a>
            </div>
        </div>
    @elseif(count($daftarBukuTersedia) === 0)
        <div style="max-width: 640px;">
            <div class="card admin-panel no-hover-lift">
                <div class="admin-empty">
                    <strong>Belum ada buku yang tersedia</strong>
                    Semua buku sedang dipinjam. Coba lagi nanti.
                </div>
            </div>
        </div>
    @else
        <div class="row g-4 align-items-start">

            {{-- Kiri: buku yang dipilih + tombol ajukan --}}
            <div class="col-12 col-lg-5">
                <div class="card admin-panel no-hover-lift sticky-lg-top" style="top: 1rem;">
                    <div class="card-body p-4">
                        <form action="{{ route('peminjaman.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id_buku" value="{{ $idDipilih }}">

                            <label class="form-label admin-label">Buku yang dipilih</label>

                            @if($bukuDipilih)
                                <div class="border rounded-3 p-3 mb-2">
                                    <div class="d-flex gap-3">
                                        @if($bukuDipilih->thumbnail)
                                            <img src="{{ $bukuDipilih->thumbnail }}" alt="Sampul {{ $bukuDipilih->judul_buku }}" class="pick-preview-cover">
                                        @else
                                            <div class="pick-preview-cover">📚</div>
                                        @endif
                                        <div>
                                            <div class="fw-semibold mb-1">{{ $bukuDipilih->judul_buku }}</div>
                                            <div class="text-secondary small">{{ $bukuDipilih->pengarang }}</div>
                                            <div class="text-secondary small">{{ $bukuDipilih->penerbit }} &middot; {{ $bukuDipilih->tahun_terbit }}</div>
                                            <a href="{{ route('peminjaman.create') }}{{ $keyword !== '' ? '?q=' . urlencode($keyword) : '' }}" class="btn btn-sm btn-link text-secondary p-0 mt-2">Ganti pilihan</a>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="border rounded-3 text-center text-secondary py-5 px-3 mb-2">
                                    <div style="font-size: 2rem;">📚</div>
                                    <div class="small">Belum ada buku dipilih.<br>Pilih dari daftar buku di sebelah kanan.</div>
                                </div>
                            @endif

                            <p class="admin-hint mb-4">Masa pinjam 7 hari sejak pengajuan disetujui admin.</p>
                            <div class="d-flex flex-wrap gap-2">
                                <button type="submit" class="btn btn-brand rounded-pill px-4" {{ $bukuDipilih ? '' : 'disabled' }}>Ajukan peminjaman</button>
                                <a href="{{ route('peminjaman.riwayat') }}" class="btn btn-outline-secondary rounded-pill px-4">Lihat riwayat</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Kanan: daftar semua buku A-Z + pencarian --}}
            <div class="col-12 col-lg-7">
                <div class="card admin-panel no-hover-lift">
                    <div class="card-body pb-2">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="form-label admin-label mb-0">Pilih buku</span>
                            <span class="text-secondary small">{{ count($daftarBukuTampil) }} buku</span>
                        </div>

                        <form method="GET" action="{{ route('peminjaman.create') }}" class="d-flex flex-wrap align-items-center gap-2">
                            <input type="hidden" name="pilih" value="{{ $idDipilih }}">
                            <input type="text" name="q" value="{{ $keyword }}"
                                   class="form-control form-control-sm w-auto flex-grow-1" style="min-width: 200px;"
                                   placeholder="Cari judul, pengarang, atau penerbit...">
                            <button type="submit" class="btn btn-sm btn-brand rounded-pill px-3">Cari</button>
                            @if($keyword !== '')
                                <a href="{{ route('peminjaman.create') }}{{ $idDipilih ? '?pilih=' . $idDipilih : '' }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">Reset</a>
                            @endif
                        </form>
                    </div>

                    <div class="pick-list mt-2">
                        @forelse($kelompokHuruf as $huruf => $daftar)
                            <div class="pick-letter">{{ $huruf }}</div>
                            @foreach($daftar as $b)
                                <a id="buku-{{ $b->id_buku }}"
                                   href="{{ route('peminjaman.create') }}?{{ http_build_query(['pilih' => $b->id_buku, 'q' => $keyword]) }}#buku-{{ $b->id_buku }}"
                                   class="pick-item {{ $idDipilih == $b->id_buku ? 'selected' : '' }}">
                                    @if($b->thumbnail)
                                        <img src="{{ $b->thumbnail }}" alt="" class="pick-cover">
                                    @else
                                        <span class="pick-cover">📚</span>
                                    @endif
                                    <span>
                                        <span class="d-block fw-semibold">{{ $b->judul_buku }}</span>
                                        <span class="d-block text-secondary small">{{ $b->pengarang }} &middot; {{ $b->penerbit }}</span>
                                    </span>
                                </a>
                            @endforeach
                        @empty
                            <div class="admin-empty">
                                <strong>Buku tidak ditemukan</strong>
                                Coba kata kunci lain.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    @endif

</div>

@endsection 