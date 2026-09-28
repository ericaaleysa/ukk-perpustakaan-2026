@extends('layouts.app')

@section('title', 'Ajukan Peminjaman')

@section('content')

<div class="admin-page">

    <div class="mb-4">
        <h1 class="h3 admin-title">Ajukan Peminjaman</h1>
        <p class="admin-subtitle">Pilih buku yang ingin kamu pinjam.</p>
    </div>

    <div style="max-width: 640px;">

    @if($currentUser->status_keanggotaan !== 'aktif')
        <div class="notice">
            <strong>Kamu belum menjadi anggota aktif.</strong>
            Jadi anggota aktif dulu untuk bisa meminjam buku.
            <a href="{{ route('keanggotaan.create') }}">Ajukan keanggotaan</a>
        </div>
    @elseif(count($daftarBukuTersedia) === 0)
        <div class="card admin-panel no-hover-lift">
            <div class="admin-empty">
                <strong>Belum ada buku yang tersedia</strong>
                Semua buku sedang dipinjam. Coba lagi nanti.
            </div>
        </div>
    @else
        <div class="card admin-panel no-hover-lift">
            <div class="card-body p-4">
                <form action="{{ route('peminjaman.store') }}" method="POST">
                    @csrf
                    <div class="mb-2">
                        <label for="id_buku" class="form-label admin-label">Pilih buku</label>
                        <select name="id_buku" id="id_buku" class="form-select" required>
                            <option value="">Pilih buku</option>
                            @foreach($daftarBukuTersedia as $b)
                                <option value="{{ $b->id_buku }}">{{ $b->judul_buku }} ({{ $b->pengarang }})</option>
                            @endforeach
                        </select>
                    </div>
                    <p class="admin-hint mb-4">Masa pinjam 7 hari sejak pengajuan disetujui admin.</p>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-brand rounded-pill px-4">Ajukan peminjaman</button>
                        <a href="{{ route('peminjaman.riwayat') }}" class="btn btn-outline-secondary rounded-pill px-4">Lihat riwayat</a>
                    </div>
                </form>
            </div>
        </div>
    @endif

    </div>

</div>

@endsection