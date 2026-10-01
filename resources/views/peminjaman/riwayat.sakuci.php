@extends('layouts.app')

@section('title', 'Riwayat Peminjaman')

@section('content')

@php
    $statusKelas = [
        'menunggu_konfirmasi' => 'status-menunggu',
        'dipinjam' => 'status-aktif',
        'dikembalikan' => 'status-selesai',
        'ditolak' => 'status-nonaktif',
    ];
    $statusLabel = [
        'menunggu_konfirmasi' => 'Menunggu konfirmasi',
        'dipinjam' => 'Dipinjam',
        'dikembalikan' => 'Dikembalikan',
        'ditolak' => 'Ditolak',
    ];
    $no = 1;
@endphp

<div class="admin-page">

    <div class="d-flex flex-wrap align-items-end justify-content-between gap-3 mb-4">
        <div>
            <h1 class="h3 admin-title">Riwayat Peminjaman</h1>
            <p class="admin-subtitle">Semua pengajuan dan peminjaman bukumu.</p>
        </div>
    </div>

    <div class="card admin-panel no-hover-lift">
        @if(count($daftarPeminjaman) === 0)
            <div class="admin-empty">
                <strong>Belum ada riwayat</strong>
                Kamu belum pernah mengajukan peminjaman buku.
            </div>
        @else
        <div class="table-responsive">
            <table class="table admin-table table-hover align-middle">
                <thead>
                    <tr>
                        <th style="width: 60px;">No</th>
                        <th>Judul buku</th>
                        <th>Tanggal pinjam</th>
                        <th>Wajib kembali</th>
                        <th>Status</th>
                        <th>Denda</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($daftarPeminjaman as $p)
                    <tr>
                        <td class="cell-meta">{{ $no++ }}</td>
                        <td class="cell-main">{{ $p->buku->judul_buku ?? '-' }}</td>
                        <td class="cell-meta">{{ $p->tanggal_pinjam ?: '-' }}</td>
                        <td class="cell-meta">{{ $p->tanggal_wajib_kembali ?: '-' }}</td>
                        <td>
                            <span class="status-pill {{ $statusKelas[$p->status] ?? 'status-kosong' }}">{{ $statusLabel[$p->status] ?? $p->status }}</span>
                            @if($p->status === 'ditolak' && $p->catatan_admin)
                                <div class="cell-meta mt-1">{{ $p->catatan_admin }}</div>
                            @endif
                        </td>
                        <td class="{{ $p->denda > 0 ? 'cell-main' : 'cell-meta' }}">{{ $p->denda > 0 ? 'Rp' . number_format($p->denda, 0, ',', '.') : '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>

</div>

@endsection