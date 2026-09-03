@extends('layouts.app')

@section('title', config('app.name')  .  ' -- Kerangka PHP Ringan')

@section ('content')

<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th>No</th>
            <th>ID Kategori</th>
            <th>Nama Kategori</th>
            <th>Keterangan</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @php $no = 1; @endphp
        @foreach($kategori as $d)
        <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $d->id_kategori }}</td>
            <td>{{ $d->nama_kategori }}</td>
            <td>{{ $d->keterangan }}</td>
            <td><button class="btn btn-sm btn-success">Edit</button>
                <button class="btn btn-sm btn-danger">Hapus</button></td>
        </tr>
        @endforeach
    </tbody>
</table>

{!! $kategori->links() !!}

@endsection