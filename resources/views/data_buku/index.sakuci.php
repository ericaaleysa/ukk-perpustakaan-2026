@extends('layouts.app')

@section('title', config('app.name'))

@section ('content')

<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h4 mb-0">Manage User</h1>
    </div>
    <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-outline-secondary">&larr; Kembali</a>
</div>

<form method="GET" action="{{ route('data_buku.index') }}" class="row g-2 align-items-center mb-3">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div class="col-auto">
            <select name="id_kategori" class="form-control" onchange="this.form.submit()">
                <option value="">Semua Kategori</option>
                @foreach($daftarKategori as $kat)
                    <option value="{{ $kat->id_kategori }}" {{ ($id_kategori == $kat->id_kategori) ? 'selected' : '' }}>{{ $kat->nama_kategori }}</option>
                @endforeach
            </select>
        </div>
        @if($id_kategori)
            <div class="col-auto">
                <a href="{{ route('data_buku.index') }}" class="btn btn-sm btn-outline-secondary">Reset Filter</a>
            </div>
        @endif
        <a href="{{ route('data_buku.create') }}" class="btn btn-primary btn-sm mb-3">Tambah Buku</a>
    </div>
</form>

<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th>No</th>
            <th>Thumbnail</th>
            <th>Kategori</th>
            <th>Judul Buku</th>
            <th>Pengarang</th>
            <th>Penerbit</th>
            <th>Tahun Terbit</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @php $no = 1; @endphp
        @foreach($data_buku as $d)
        <tr>
            <td>{{ $no++ }}</td>
            <td>
                @if($d->thumbnail)
                    <img src="{{ $d->thumbnail }}" alt="Thumbnail" style="width: 45px; height: 60px; object-fit: cover; border-radius: 4px;">
                @else
                    <span class="text-secondary small">Tidak ada thumbnail</span>
                @endif
            <td>{{ $d->id_kategori }}</td>
            <td>{{ $d->judul_buku }}</td>
            <td>{{ $d->pengarang }}</td>
            <td>{{ $d->penerbit }}</td>
            <td>{{ $d->tahun_terbit }}</td>
            <td>
                <a href=" {{ route('data_buku.edit', [$d->id_buku]) }}" class="btn btn-sm btn-success">Edit</a>
                <form action="{{ route('data_buku.destroy', [$d->id_buku]) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{!! $data_buku->links() !!}

@endsection