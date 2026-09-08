@extends('layouts.app')

@section('title', config('app.name')  .  ' -- Kerangka PHP Ringan')

@section ('content')

<h1>Kategori</h1>
<a href="{{ route('kategori.create') }}" class="btn btn-primary btn-sm mb-3">Tambah Kategori</a>

<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Kategori</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @php $no = 1; @endphp
        @foreach($kategori as $d)
        <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $d->nama_kategori }}</td>
            <td><a href="{{ route('kategori.edit', ['id_kategori' => $d->id_kategori]) }}" class="btn btn-sm btn-success">Edit</a>
                <form action="{{ route('kategori.destroy', ['id_kategori' => $d->id_kategori]) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{!! $kategori->links() !!}

@endsection