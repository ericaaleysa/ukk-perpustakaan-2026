@extends('layouts.app')

@section('title', 'Data Buku')

@section('content')

@php
    // Ubah id_kategori menjadi nama kategori (tanpa perlu mengubah controller)
    $namaKategori = [];
    foreach ($daftarKategori as $k) {
        $namaKategori[$k->id_kategori] = $k->nama_kategori;
    }
    $no = 1;
    $kosong = true;
@endphp

<div class="admin-page">

    <div class="d-flex flex-wrap align-items-end justify-content-between gap-3 mb-4">
        <div>
            <h1 class="h3 admin-title">Data Buku</h1>
            <p class="admin-subtitle">Kelola koleksi buku perpustakaan.</p>
        </div>
        <a href="{{ route('data_buku.create') }}" class="btn btn-brand rounded-pill px-3">Tambah buku</a>
    </div>

    <div class="card admin-panel no-hover-lift">

        <div class="card-body pb-2">
            <form method="GET" action="{{ route('data_buku.index') }}" class="d-flex flex-wrap align-items-center gap-2">
                <input type="text" name="q" value="{{ $keyword }}"
                       class="form-control form-control-sm w-auto flex-grow-1" style="min-width: 220px; max-width: 360px;"
                       placeholder="Cari judul, pengarang, atau penerbit...">

                <select name="id_kategori" class="form-select form-select-sm w-auto" onchange="this.form.submit()">
                    <option value="">Semua kategori</option>
                    @foreach($daftarKategori as $kat)
                        <option value="{{ $kat->id_kategori }}" {{ ($id_kategori == $kat->id_kategori) ? 'selected' : '' }}>{{ $kat->nama_kategori }}</option>
                    @endforeach
                </select>

                <button type="submit" class="btn btn-sm btn-brand rounded-pill px-3">Cari</button>

                @if($id_kategori || $keyword !== '')
                    <a href="{{ route('data_buku.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">Reset</a>
                @endif
            </form>
        </div>

        <div class="table-responsive">
            <table class="table admin-table table-hover align-middle">
                <thead>
                    <tr>
                        <th style="width: 60px;">No</th>
                        <th>Sampul</th>
                        <th>Judul buku</th>
                        <th>Kategori</th>
                        <th>Penerbit</th>
                        <th>Tahun</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data_buku as $d)
                    @php $kosong = false; @endphp
                    <tr>
                        <td class="cell-meta">{{ $no++ }}</td>
                        <td>
                            @if($d->thumbnail)
                                <img src="{{ $d->thumbnail }}" alt="Sampul {{ $d->judul_buku }}" class="admin-cover">
                            @else
                                <span class="admin-cover-empty" title="Belum ada sampul">
                                    <svg width="18" height="18" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
                                        <path d="M1 2.828c.885-.37 2.154-.769 3.388-.893 1.33-.134 2.458.063 3.112.752v9.746c-.935-.53-2.12-.603-3.213-.493-1.18.12-2.37.461-3.287.811V2.828zm7.5-.141c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492V2.687zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783z"/>
                                    </svg>
                                </span>
                            @endif
                        </td>
                        <td>
                            <div class="cell-main">{{ $d->judul_buku }}</div>
                            <div class="cell-meta">{{ $d->pengarang }}</div>
                        </td>
                        <td><span class="admin-pill">{{ $namaKategori[$d->id_kategori] ?? '-' }}</span></td>
                        <td>{{ $d->penerbit }}</td>
                        <td class="cell-meta">{{ $d->tahun_terbit }}</td>
                        <td class="text-end text-nowrap">
                            <a href="{{ route('data_buku.edit', [$d->id_buku]) }}" class="btn btn-sm btn-outline-brand rounded-pill px-3">Edit</a>
                            <form action="{{ route('data_buku.destroy', [$d->id_buku]) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Hapus buku ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-secondary rounded-pill px-3">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    @if($kosong)
                    <tr>
                        <td colspan="7">
                            <div class="admin-empty">
                                <strong>Belum ada buku</strong>
                                {{ ($id_kategori || $keyword !== '') ? 'Tidak ada buku yang cocok dengan pencarianmu.' : 'Tambahkan buku pertama untuk mengisi koleksi.' }}
                            </div>
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <div class="card-footer bg-transparent d-flex flex-wrap align-items-center justify-content-between gap-2">
            <div>{!! $data_buku->links() !!}</div>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">&larr; Kembali</a>
        </div>
    </div>

</div>

@endsection