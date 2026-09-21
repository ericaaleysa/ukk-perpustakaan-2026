@extends('layouts.app')

@section('title', 'Ajukan Peminjaman')

@section('content')

<h1 class="h4 mb-3">Ajukan Peminjaman Buku</h1>

@if($currentUser->status_keanggotaan !== 'aktif')
    <div class="alert alert-warning">
        Anda harus menjadi <strong>Anggota Aktif</strong> terlebih dahulu untuk bisa meminjam buku.
        <a href="{{ route('keanggotaan.create') }}">Ajukan keanggotaan di sini</a>.
    </div>
@else
    @if(count($daftarBukuTersedia) === 0)
        <p class="text-secondary">Belum ada buku yang tersedia untuk dipinjam saat ini.</p>
    @else
        <form action="{{ route('peminjaman.store') }}" method="POST">
            @csrf
            <div class="form-group mb-3">
                <label for="id_buku">Pilih Buku</label>
                <select name="id_buku" id="id_buku" class="form-control" required>
                    <option value="">-- Pilih Buku --</option>
                    @foreach($daftarBukuTersedia as $b)
                        <option value="{{ $b->id_buku }}">{{ $b->judul_buku }} ({{ $b->pengarang }})</option>
                    @endforeach
                </select>
            </div>
            <p class="text-secondary small">Masa pinjam 7 hari sejak pengajuan disetujui admin.</p>
            <button type="submit" class="btn btn-primary">Ajukan Peminjaman</button>
        </form>
    @endif
@endif

@endsection