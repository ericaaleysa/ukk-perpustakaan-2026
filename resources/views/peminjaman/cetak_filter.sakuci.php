@extends('layouts.app')

@section('title', 'Cetak Laporan Peminjaman')

@section('content')

<div class="admin-page">

    <div class="d-flex flex-wrap align-items-end justify-content-between gap-3 mb-4">
        <div>
            <h1 class="h3 admin-title">Cetak Laporan Peminjaman</h1>
            <p class="admin-subtitle">Pilih periode laporan terlebih dahulu. Kosongkan tanggal untuk mencetak semua transaksi.</p>
        </div>
    </div>

    <div class="card admin-panel no-hover-lift" style="max-width: 560px;">
        <div class="card-body p-4">
            <form method="GET" action="{{ route('peminjaman.cetak') }}" target="_blank">
                <div class="row g-3 mb-4">
                    <div class="col-12 col-md-6">
                        <label for="tanggal_dari" class="form-label admin-label">Dari tanggal pinjam</label>
                        <input type="date" name="tanggal_dari" id="tanggal_dari" class="form-control">
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="tanggal_sampai" class="form-label admin-label">Sampai tanggal pinjam</label>
                        <input type="date" name="tanggal_sampai" id="tanggal_sampai" class="form-control">
                    </div>
                </div>

                <div class="d-flex flex-wrap gap-2">
                    <button type="submit" class="btn btn-brand px-4">Tampilkan laporan</button>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary px-4">Batal</a>
                </div>
            </form>
        </div>
    </div>

</div>

<script>
    // Tanggal "sampai" tidak boleh lebih awal dari tanggal "dari"
    var dari = document.getElementById('tanggal_dari');
    var sampai = document.getElementById('tanggal_sampai');
    dari.addEventListener('change', function () { sampai.min = dari.value; });
    sampai.addEventListener('change', function () { dari.max = sampai.value; });
</script>

@endsection