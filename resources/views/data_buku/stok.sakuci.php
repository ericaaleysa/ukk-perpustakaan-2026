@extends('layouts.app')

@section('title', 'NEX-LIB ADMIN -- Stok Buku')

@section('content')

@php $no = 1; @endphp

<div class="admin-page">

    <div class="d-flex flex-wrap align-items-end justify-content-between gap-3 mb-4">
        <div>
            <h1 class="h3 admin-title">Stok Buku</h1>
            <p class="admin-subtitle">Stok berkurang saat buku dipinjam, dan bertambah lagi setelah pengembalian dikonfirmasi.</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-outline-secondary px-3">&larr; Kembali</a>
    </div>

    {{-- Ringkasan --}}
    <div class="row g-3 mb-4">
        <div class="col-12 col-sm-4">
            <div class="card admin-panel no-hover-lift p-3">
                <div class="admin-hint">Judul buku</div>
                <div class="h4 mb-0 fw-bold">{{ count($daftarBuku) }}</div>
            </div>
        </div>
        <div class="col-12 col-sm-4">
            <div class="card admin-panel no-hover-lift p-3">
                <div class="admin-hint">Total stok tersedia</div>
                <div class="h4 mb-0 fw-bold">{{ $totalStok }}</div>
            </div>
        </div>
        <div class="col-12 col-sm-4">
            <div class="card admin-panel no-hover-lift p-3">
                <div class="admin-hint">Judul dengan stok habis</div>
                <div class="h4 mb-0 fw-bold">{{ $totalHabis }}</div>
            </div>
        </div>
    </div>

    <div class="card admin-panel no-hover-lift">

        <div class="card-body pb-2">
            <form method="GET" action="{{ route('stok.index') }}" class="d-flex flex-wrap align-items-center gap-2">
                <input type="text" name="q" value="{{ $keyword }}"
                       class="form-control form-control-sm w-auto flex-grow-1 input-cari"
                       placeholder="Cari judul, pengarang, atau penerbit...">
                <button type="submit" class="btn btn-sm btn-brand px-3">Cari</button>
                @if($keyword !== '')
                    <a href="{{ route('stok.index') }}" class="btn btn-sm btn-outline-secondary px-3">Reset</a>
                @endif
            </form>
        </div>

        @if(count($daftarBuku) === 0)
            <div class="admin-empty">
                <strong>Buku tidak ditemukan</strong>
                Belum ada buku yang cocok dengan pencarian ini.
            </div>
        @else
        <div class="table-responsive">
            <table class="table admin-table table-hover align-middle">
                <thead>
                    <tr>
                        <th class="col-no">No</th>
                        <th>Judul buku</th>
                        <th>Kategori</th>
                        <th>Pengarang</th>
                        <th class="text-center">Dipinjam / diajukan</th>
                        <th class="text-center">Stok tersedia</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($daftarBuku as $b)
                    <tr>
                        <td class="cell-meta">{{ $no++ }}</td>
                        <td class="cell-main">{{ $b->judul_buku }}</td>
                        <td class="cell-meta">{{ $namaKategori[$b->id_kategori] ?? '-' }}</td>
                        <td class="cell-meta">{{ $b->pengarang }}</td>
                        <td class="text-center">{{ $sedangDipinjam[$b->id_buku] ?? 0 }}</td>
                        <td class="text-center">
                            @if((int) $b->stok > 0)
                                <span class="status-pill status-aktif">{{ (int) $b->stok }}</span>
                            @else
                                <span class="status-pill status-nonaktif">Habis</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <a href="{{ route('data_buku.edit', [$b->id_buku]) }}" class="btn btn-sm btn-outline-secondary px-3">Ubah stok</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>

</div>

@endsection