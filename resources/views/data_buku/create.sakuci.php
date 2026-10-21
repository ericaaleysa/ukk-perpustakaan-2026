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
    /* Placeholder buku tanpa sampul: ikon buku garis di dalam kotak berbingkai */
    .pick-no-sampul {
        border: 1px solid var(--bs-border-color);
        background: var(--bs-tertiary-bg);
        color: var(--bs-secondary-color);
    }
</style>

<div class="admin-page">

    <div class="d-flex flex-wrap align-items-end justify-content-between gap-3 mb-4">
        <div>
            <h1 class="h3 admin-title">Ajukan Peminjaman</h1>
            <p class="admin-subtitle">Cari buku di daftar, lalu pilih untuk dipinjam.</p>
        </div>
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
                <div class="card admin-panel no-hover-lift pick-sticky">
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
                                            <div class="pick-preview-cover pick-no-sampul" title="Belum ada sampul" role="img" aria-label="Belum ada sampul"><svg width="36" height="36" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true"><path d="M1 2.828c.885-.37 2.154-.769 3.388-.893 1.33-.134 2.458.063 3.112.752v9.746c-.935-.53-2.12-.603-3.213-.493-1.18.12-2.37.461-3.287.811V2.828zm7.5-.141c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492V2.687zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783z"/></svg></div>
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
                                <button type="submit" class="btn btn-brand px-4" {{ $bukuDipilih ? '' : 'disabled' }}>Ajukan peminjaman</button>
                                <a href="{{ route('peminjaman.riwayat') }}" class="btn btn-outline-secondary px-4">Lihat riwayat</a>
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
                            <button type="submit" class="btn btn-sm btn-brand px-3">Cari</button>
                            @if($keyword !== '')
                                <a href="{{ route('peminjaman.create') }}{{ $idDipilih ? '?pilih=' . $idDipilih : '' }}" class="btn btn-sm btn-outline-secondary px-3">Reset</a>
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
                                        <span class="pick-cover pick-no-sampul" title="Belum ada sampul" role="img" aria-label="Belum ada sampul"><svg width="18" height="18" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true"><path d="M1 2.828c.885-.37 2.154-.769 3.388-.893 1.33-.134 2.458.063 3.112.752v9.746c-.935-.53-2.12-.603-3.213-.493-1.18.12-2.37.461-3.287.811V2.828zm7.5-.141c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492V2.687zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783z"/></svg></span>
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