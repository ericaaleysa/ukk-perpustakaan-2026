@extends('layouts.app')

@section('title', 'Riwayat Peminjaman')

@section('content')

@php
    $statusKelas = [
        'menunggu_konfirmasi' => 'st-tunggu',
        'dipinjam' => 'st-aman',
        'dikembalikan' => 'st-aman',
        'ditolak' => 'st-telat',
    ];
    $statusLabel = [
        'menunggu_konfirmasi' => 'Menunggu Admin',
        'dipinjam' => 'Dipinjam',
        'dikembalikan' => 'Dikembalikan',
        'ditolak' => 'Ditolak',
    ];
    $labelKondisi = [
        'baik' => 'Baik',
        'rusak_ringan' => 'Rusak ringan',
        'rusak_berat' => 'Rusak berat',
        'hilang' => 'Hilang',
    ];
@endphp

<div class="admin-page">

    <div class="d-flex flex-wrap align-items-end justify-content-between gap-3 mb-4">
        <div>
            <h1 class="h3 admin-title">Riwayat Peminjaman</h1>
            <p class="admin-subtitle">Semua pengajuan dan peminjaman bukumu.</p>
        </div>
        <a href="{{ route('dashboard') }}" class="btn btn-sm btn-outline-secondary px-3">&larr; Kembali</a>
    </div>

    <div class="card admin-panel no-hover-lift">
        @if(count($daftarPeminjaman) === 0)
            <div class="admin-empty">
                <strong>Belum ada riwayat</strong>
                Kamu belum pernah mengajukan peminjaman buku.
            </div>
        @else
        <div class="card-body p-4">
            <div class="riwayat-grid">
                @foreach($daftarPeminjaman as $p)
                    <div class="book-card">
                        {{-- Cover: klik untuk membuka popup detail buku --}}
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

                        {{-- Tanggal pinjam & wajib kembali baru terisi setelah admin menyetujui,
                             jadi setiap tanggal dicek dulu sebelum dipakai (strtotime(null) menyebabkan error) --}}
                        <div class="book-meta">
                            @if($p->status === 'dikembalikan' && $p->tanggal_dikembalikan)
                                Kembali {{ date('d M Y', strtotime($p->tanggal_dikembalikan)) }}
                            @elseif($p->status === 'dipinjam' && $p->tanggal_wajib_kembali)
                                Kembali {{ date('d M Y', strtotime($p->tanggal_wajib_kembali)) }}
                            @elseif($p->status === 'ditolak')
                                @if($p->tanggal_pinjam)
                                    Diajukan {{ date('d M Y', strtotime($p->tanggal_pinjam)) }}
                                @else
                                    Pengajuan ditolak
                                @endif
                            @elseif($p->status === 'menunggu_konfirmasi')
                                Belum disetujui
                            @else
                                -
                            @endif
                        </div>

                        @php
                            $hilang = $p->status === 'dikembalikan' && ($p->kondisi_kembali ?? '') === 'hilang';
                        @endphp
                        <div class="book-status {{ $hilang ? 'st-telat' : ($statusKelas[$p->status] ?? 'st-aman') }}">
                            {{ $hilang ? 'Hilang' : ($statusLabel[$p->status] ?? $p->status) }}
                        </div>

                        @if($p->status === 'dikembalikan' && !empty($p->kondisi_kembali) && !in_array($p->kondisi_kembali, ['baik', 'hilang']))
                            <div class="riwayat-catatan">Kondisi: {{ $labelKondisi[$p->kondisi_kembali] ?? $p->kondisi_kembali }}</div>
                        @endif

                        @if($p->denda > 0)
                            <div class="riwayat-denda">Denda Rp{{ number_format($p->denda, 0, ',', '.') }}</div>
                            @if($p->status === 'dikembalikan')
                                @if(($p->status_denda ?? '') === 'lunas')
                                    <div class="riwayat-catatan">{{ !empty($p->tanggal_bayar_denda) ? 'Lunas pada ' . date('d M Y', strtotime($p->tanggal_bayar_denda)) : 'Lunas' }}</div>
                                @else
                                    <div class="riwayat-catatan">Belum dibayar. Silakan bayar ke petugas perpustakaan.</div>
                                @endif
                            @endif
                            @if(($p->denda_telat ?? 0) > 0 && ($p->denda_kondisi ?? 0) > 0)
                                <div class="riwayat-catatan">Telat Rp{{ number_format($p->denda_telat, 0, ',', '.') }} &middot; Kerusakan Rp{{ number_format($p->denda_kondisi, 0, ',', '.') }}</div>
                            @endif
                        @endif

                        @if(!empty($p->catatan_kondisi))
                            <div class="riwayat-catatan">{{ $p->catatan_kondisi }}</div>
                        @endif

                        @if($p->status === 'ditolak' && $p->catatan_admin)
                            <div class="riwayat-catatan">{{ $p->catatan_admin }}</div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>

</div>

@include('partials.modal_buku')

@endsection