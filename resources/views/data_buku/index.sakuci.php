@extends('layouts.app')

@section('title', config('app.name'))

@section ('content')

<h1>Data Buku</h1>
<a href="{{ route('data_buku.create') }}" class="btn btn-primary btn-sm mb-3">Tambah Buku</a>

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