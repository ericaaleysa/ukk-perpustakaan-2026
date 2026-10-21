@extends('layouts.app')

@section('title', 'NEX-LIB ADMIN -- Log Aktivitas')

@section('content')

@php
    $no = ($halaman - 1) * $perHalaman + 1;
    $filterAktif = array_filter($filter, 'strlen');
    $urlSebelumnya = route('log.index') . '?' . http_build_query(array_merge($filterAktif, ['page' => $halaman - 1]));
    $urlBerikutnya = route('log.index') . '?' . http_build_query(array_merge($filterAktif, ['page' => $halaman + 1]));
@endphp

<div class="admin-page">

    <div class="d-flex flex-wrap align-items-end justify-content-between gap-3 mb-4">
        <div>
            <h1 class="h3 admin-title">Log Aktivitas</h1>
            <p class="admin-subtitle">Rekam jejak aktivitas di sistem. Halaman ini hanya bisa dilihat admin.</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-outline-secondary px-3">&larr; Kembali</a>
    </div>

    <div class="card admin-panel no-hover-lift">

        <div class="card-body pb-2">
            <form method="GET" action="{{ route('log.index') }}" class="row g-2 align-items-end">
                <div class="col-12 col-md">
                    <label class="form-label admin-label small mb-1">Cari</label>
                    <input type="text" name="q" value="{{ $filter['q'] }}" class="form-control form-control-sm" placeholder="Nama pengguna atau isi aktivitas...">
                </div>
                <div class="col-auto">
                    <label class="form-label admin-label small mb-1">Kategori</label>
                    <select name="kategori" class="form-select form-select-sm">
                        <option value="">Semua kategori</option>
                        @foreach($daftarKategori as $kode => $label)
                            <option value="{{ $kode }}" {{ $filter['kategori'] === $kode ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-auto">
                    <label class="form-label admin-label small mb-1">Dari tanggal</label>
                    <input type="date" name="tanggal_dari" value="{{ $filter['tanggal_dari'] }}" class="form-control form-control-sm">
                </div>
                <div class="col-auto">
                    <label class="form-label admin-label small mb-1">Sampai tanggal</label>
                    <input type="date" name="tanggal_sampai" value="{{ $filter['tanggal_sampai'] }}" class="form-control form-control-sm">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-sm btn-brand px-3">Terapkan</button>
                    @if(count($filterAktif) > 0)
                        <a href="{{ route('log.index') }}" class="btn btn-sm btn-outline-secondary px-3">Reset</a>
                    @endif
                </div>
            </form>
        </div>

        @if($galat)
            <div class="p-3">
                <div class="notice notice-muted">
                    <strong>Tabel log belum siap.</strong>
                    Jalankan file <code>log_aktivitas.sql</code> di database, lalu muat ulang halaman ini.
                </div>
            </div>
        @elseif(count($daftarLog) === 0)
            <div class="admin-empty">
                <strong>Belum ada aktivitas</strong>
                {{ count($filterAktif) > 0 ? 'Tidak ada aktivitas yang cocok dengan filter ini.' : 'Aktivitas akan muncul di sini setelah ada yang tercatat.' }}
            </div>
        @else
        <div class="table-responsive">
            <table class="table admin-table table-hover align-middle">
                <thead>
                    <tr>
                        <th style="width: 60px;">No</th>
                        <th>Waktu</th>
                        <th>Pengguna</th>
                        <th>Kategori</th>
                        <th>Aktivitas</th>
                        <th>IP</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($daftarLog as $l)
                    <tr>
                        <td class="cell-meta">{{ $no++ }}</td>
                        <td class="cell-meta text-nowrap">{{ date('d-m-Y H:i', strtotime($l['created_at'])) }}</td>
                        <td>
                            <div class="cell-main">{{ $l['username'] ?? 'Tamu' }}</div>
                            <div class="cell-meta">{{ $l['role'] ?? '-' }}</div>
                        </td>
                        <td><span class="admin-pill">{{ $daftarKategori[$l['kategori']] ?? $l['kategori'] }}</span></td>
                        <td>{{ $l['deskripsi'] }}</td>
                        <td class="cell-meta">{{ $l['ip_address'] ?? '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="card-footer bg-transparent d-flex flex-wrap align-items-center justify-content-between gap-2">
            <span class="cell-meta">{{ $total }} aktivitas  &middot;  {{ $halaman }} dari {{ $totalHalaman }} halaman</span>
            <div class="d-flex gap-2">
                @if($halaman > 1)
                    <a href="{{ $urlSebelumnya }}" class="btn btn-sm btn-outline-secondary px-3">&larr; Sebelumnya</a>
                @endif
                @if($halaman < $totalHalaman)
                    <a href="{{ $urlBerikutnya }}" class="btn btn-sm btn-outline-secondary px-3">Berikutnya &rarr;</a>
                @endif
            </div>
        </div>
        @endif
    </div>

</div>

@endsection