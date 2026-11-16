@extends('layouts.app')

@section('title', 'Tentang NEXLIB')

@section('content')

<div class="d-flex flex-wrap align-items-end justify-content-between gap-3 mb-4">
    <div>
        <h2 class="h6 mb-0">
            <span class="badge badge-ukk px-3 py-2">NEXLIB PROJECT '26</span>
        </h2>
    </div>
    <a href="{{ route('home') }}" class="btn btn-sm btn-outline-secondary px-3">&larr; Kembali</a>
</div>

    {{-- Apa itu NEXLIB --}}
    <div class="card border-0 shadow-sm no-hover-lift mb-4">
        <div class="card-body p-4">
            <h1 class="h3 fw-bold mt-2 mb-1">Apa itu <span class="text-brand-dark">NEXLIB</span> ?</h1>
            <p class="text-secondary mb-0">
                Nexus Digital Library adalah pengembangan sistem Peminjaman Buku perpustakaan digital berbasis verifikasi Keanggotaan.<br>
                Siswa wajib mendaftar akun, mengajukan keanggotaan, dan diverifikasi petugas hingga berstatus anggota aktif sebelum dapat mengajukan peminjaman buku.
                Pengajuan peminjaman kemudian dikonfirmasi petugas, dan pengembalian buku dicatat lengkap dengan denda bila terlambat.
            </p>
        </div>
    </div>

    {{-- Tips singkat --}}
    <h2 class="h5 fw-semibold mb-3">Tips singkat</h2>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-3 mb-4">
        <div class="col">
            <div class="card border-0 shadow-sm no-hover-lift h-100 p-3">
                <div class="feature-icon mb-3">
                    <svg width="20" height="20" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
                        <path d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z"/>
                        <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.502a.552.552 0 0 1-1.1 0L7.1 4.995z"/>
                    </svg>
                </div>
                <h3 class="h6 fw-semibold mb-1">Lunasi denda</h3>
                <p class="text-secondary small mb-0">Jika denda tidak dilunasi, keanggotaan dapat dinonaktifkan dan kamu tidak bisa meminjam lagi.</p>
            </div>
        </div>
        <div class="col">
            <div class="card border-0 shadow-sm no-hover-lift h-100 p-3">
                <div class="feature-icon mb-3">
                    <svg width="20" height="20" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
                        <path d="M8 1.884c-1.545-.887-3.837-1.113-5.487-.573C1.923.42 1.5.904 1.5 1.5v10.5c0 .548.44.98.955.86 1.469-.34 3.618-.146 5.045.567V1.884zm1 11.543c1.427-.713 3.576-.907 5.045-.567.516.12.955-.312.955-.86V1.5c0-.596-.423-1.08-1.013-1.19C12.337.77 10.045.996 8.5 1.884v11.543z"/>
                    </svg>
                </div>
                <h3 class="h6 fw-semibold mb-1">Pinjam lewat NEXLIB</h3>
                <p class="text-secondary small mb-0">Siswa dilarang meminjam langsung ke perpustakaan, kecuali untuk kebutuhan buku pada jam pelajaran.</p>
            </div>
        </div>
        <div class="col">
            <div class="card border-0 shadow-sm no-hover-lift h-100 p-3">
                <div class="feature-icon mb-3">
                    <svg width="20" height="20" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
                        <path d="M8 3.5a.5.5 0 0 1 .5.5v4.09l2.79 1.613a.5.5 0 1 1-.5.866l-3-1.732A.5.5 0 0 1 7.5 8V4a.5.5 0 0 1 .5-.5z"/>
                        <path d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z"/>
                    </svg>
                </div>
                <h3 class="h6 fw-semibold mb-1">Cek tanggal kembali</h3>
                <p class="text-secondary small mb-0">Lihat batas pengembalian di menu Riwayat agar tidak terkena denda telat.</p>
            </div>
        </div>
        <div class="col">
            <div class="card border-0 shadow-sm no-hover-lift h-100 p-3">
                <div class="feature-icon mb-3">
                    <svg width="20" height="20" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
                        <path d="M8 0a.5.5 0 0 1 .146.021l6 2A.5.5 0 0 1 14.5 2.5v4.243c0 4.248-2.937 7.634-6.234 8.716a.5.5 0 0 1-.532 0C4.437 14.377 1.5 10.991 1.5 6.743V2.5a.5.5 0 0 1 .354-.479l6-2A.5.5 0 0 1 8 0z"/>
                        <path d="M10.03 5.22a.75.75 0 0 1 0 1.06L7.53 8.78a.75.75 0 0 1-1.06 0L5.22 7.53a.75.75 0 1 1 1.06-1.06L7 7.19l2.97-2.97a.75.75 0 0 1 1.06 0z"/>
                    </svg>
                </div>
                <h3 class="h6 fw-semibold mb-1">Jaga kondisi buku</h3>
                <p class="text-secondary small mb-0">Buku yang rusak atau hilang dikenai denda sesuai tingkat kerusakannya.</p>
            </div>
        </div>
    </div>

    {{-- Cara meminjam --}}
    <div class="card border-0 shadow-sm no-hover-lift mb-4">
        <div class="card-body p-4">
            <h2 class="h5 fw-semibold mb-3">Cara Meminjam Buku</h2>

            <ul class="list-unstyled d-grid gap-3 mb-0">
                <li class="d-flex gap-3">
                    <span class="step-number rounded">1</span>
                    <div>
                        <div class="fw-medium">Daftar dan masuk</div>
                        <div class="text-secondary small">Buat akun, lalu masuk ke NEXLIB.</div>
                    </div>
                </li>
                <li class="d-flex gap-3">
                    <span class="step-number rounded">2</span>
                    <div>
                        <div class="fw-medium">Ajukan keanggotaan</div>
                        <div class="text-secondary small">Isi nama lengkap, NISN (10 digit angka), dan kelas, lalu tunggu verifikasi dari petugas. Jika ditolak, perbaiki datanya dan ajukan kembali.</div>
                    </div>
                </li>
                <li class="d-flex gap-3">
                    <span class="step-number rounded">3</span>
                    <div>
                        <div class="fw-medium">Ajukan peminjaman</div>
                        <div class="text-secondary small">Setelah menjadi anggota aktif, pilih buku yang stoknya tersedia lalu ajukan peminjaman. Stok buku langsung dipesan untukmu.</div>
                    </div>
                </li>
                <li class="d-flex gap-3">
                    <span class="step-number rounded">4</span>
                    <div>
                        <div class="fw-medium">Tunggu persetujuan petugas</div>
                        <div class="text-secondary small">Pantau statusnya di menu Riwayat. Jika pengajuan ditolak, stok dikembalikan dan kamu bisa memilih buku lain.</div>
                    </div>
                </li>
                <li class="d-flex gap-3">
                    <span class="step-number rounded">5</span>
                    <div>
                        <div class="fw-medium">Pinjam selama 7 hari</div>
                        <div class="text-secondary small">Masa pinjam dihitung sejak pengajuan disetujui. Tanggal wajib kembali tercantum di Riwayat.</div>
                    </div>
                </li>
                <li class="d-flex gap-3">
                    <span class="step-number rounded">6</span>
                    <div>
                        <div class="fw-medium">Kembalikan buku</div>
                        <div class="text-secondary small">Serahkan buku ke perpustakaan, petugas akan mengonfirmasi pengembalian dan mencatat kondisi bukunya.</div>
                    </div>
                </li>
                <li class="d-flex gap-3">
                    <span class="step-number rounded">7</span>
                    <div>
                        <div class="fw-medium">Lunasi denda bila ada</div>
                        <div class="text-secondary small">Bayar denda langsung ke petugas perpustakaan. Selama denda belum lunas, kamu tidak bisa mengajukan peminjaman baru.</div>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <div class="row g-3 mb-4">
        {{-- Aturan peminjaman --}}
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm no-hover-lift h-100">
                <div class="card-body p-4">
                    <h2 class="h5 fw-semibold mb-3">Aturan Peminjaman</h2>
                    <ul class="text-secondary small mb-0 d-grid gap-2">
                        <li>Hanya anggota berstatus <strong>aktif</strong> yang dapat meminjam buku.</li>
                        <li>Maksimal <strong>3 buku</strong> dalam satu waktu, termasuk pengajuan yang masih menunggu konfirmasi.</li>
                        <li>Masa pinjam <strong>7 hari</strong> sejak disetujui petugas.</li>
                        <li>Buku yang sama tidak dapat diajukan lagi sebelum dikembalikan.</li>
                        <li>Tidak dapat meminjam bila masih ada buku yang melewati batas pengembalian.</li>
                        <li>Tidak dapat meminjam bila masih ada denda yang belum dilunasi.</li>
                        <li>Peminjaman langsung ke perpustakaan tidak dilayani, kecuali untuk kebutuhan buku pada jam pelajaran.</li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Denda --}}
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm no-hover-lift h-100">
                <div class="card-body p-4">
                    <h2 class="h5 fw-semibold mb-3">Denda</h2>
                    <table class="table table-sm align-middle mb-2">
                        <tbody>
                            <tr>
                                <td class="text-secondary small">Terlambat</td>
                                <td class="text-end fw-medium">Rp1.000 / hari</td>
                            </tr>
                            <tr>
                                <td class="text-secondary small">Rusak ringan</td>
                                <td class="text-end fw-medium">Rp5.000</td>
                            </tr>
                            <tr>
                                <td class="text-secondary small">Rusak berat</td>
                                <td class="text-end fw-medium">Rp25.000</td>
                            </tr>
                            <tr>
                                <td class="text-secondary small">Hilang</td>
                                <td class="text-end fw-medium">Rp50.000</td>
                            </tr>
                        </tbody>
                    </table>
                    <p class="text-secondary small mb-0">
                        Buku yang hilang tidak dikenai denda telat karena yang ditagih adalah penggantiannya.
                        Petugas dapat menyesuaikan nominal denda kondisi, misalnya sesuai harga buku.
                    </p>
                </div>
            </div>
        </div>
    </div>

@endsection