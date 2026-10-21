@extends('layouts.app')

@section('title', 'Kategori Buku')

@section('content')

<div class="admin-page">

    <div class="d-flex flex-wrap align-items-end justify-content-between gap-3 mb-4">
        <div>
            <h1 class="h3 admin-title">Kategori Buku</h1>
            <p class="admin-subtitle">Kelompokkan buku agar siswa mudah menemukannya.</p>
        </div>
        <div class="d-flex flex-wrap align-items-center gap-2">
            <a href="{{ route('kategori.create') }}" class="btn btn-sm btn-brand px-3">Tambah kategori</a>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-outline-secondary px-3">&larr; Kembali</a>
        </div>
    </div>

    <div class="card admin-panel no-hover-lift">
        <div class="table-responsive">
            <table class="table admin-table align-middle">
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
                            <a href="{{ route('kategori.edit', ['id_kategori' => $d->id_kategori]) }}" class="btn btn-sm btn-outline-brand btn-icon" title="Edit" aria-label="Edit {{ $d->nama_kategori }}">
                                <svg width="14" height="14" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true"><path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/></svg>
                            </a>
                            <form action="{{ route('kategori.destroy', ['id_kategori' => $d->id_kategori]) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Hapus kategori ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-secondary px-3">Hapus</button>
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

        @php $tautan = trim((string) $kategori->links()); @endphp
        @if($tautan !== '')
        <div class="card-footer bg-transparent">
            {!! $tautan !!}
        </div>
        @endif
    </div>

</div>

@endsection