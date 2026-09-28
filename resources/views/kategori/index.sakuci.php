@extends('layouts.app')

@section('title', 'Kategori Buku')

@section('content')

<div class="admin-page">

    <div class="d-flex flex-wrap align-items-end justify-content-between gap-3 mb-4">
        <div>
            <h1 class="h3 admin-title">Kategori Buku</h1>
            <p class="admin-subtitle">Kelompokkan buku agar siswa mudah menemukannya.</p>
        </div>
        <a href="{{ route('kategori.create') }}" class="btn btn-brand rounded-pill px-3">Tambah kategori</a>
    </div>

    <div class="card admin-panel no-hover-lift">
        <div class="table-responsive">
            <table class="table admin-table table-hover align-middle">
                <thead>
                    <tr>
                        <th style="width: 70px;">No</th>
                        <th>Nama kategori</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; $kosong = true; @endphp
                    @foreach($kategori as $d)
                    @php $kosong = false; @endphp
                    <tr>
                        <td class="cell-meta">{{ $no++ }}</td>
                        <td class="cell-main">{{ $d->nama_kategori }}</td>
                        <td class="text-end text-nowrap">
                            <a href="{{ route('kategori.edit', ['id_kategori' => $d->id_kategori]) }}" class="btn btn-sm btn-outline-brand rounded-pill px-3">Edit</a>
                            <form action="{{ route('kategori.destroy', ['id_kategori' => $d->id_kategori]) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Hapus kategori ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-secondary rounded-pill px-3">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    @if($kosong)
                    <tr>
                        <td colspan="3">
                            <div class="admin-empty">
                                <strong>Belum ada kategori</strong>
                                Tambahkan kategori pertama untuk mulai mengelompokkan buku.
                            </div>
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <div class="card-footer bg-transparent d-flex flex-wrap align-items-center justify-content-between gap-2">
            <div>{!! $kategori->links() !!}</div>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">&larr; Kembali</a>
        </div>
    </div>

</div>

@endsection