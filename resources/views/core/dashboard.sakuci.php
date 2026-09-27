@extends('layouts.app')

@section('title', 'Dashboard Siswa')

@section('content')

    {{-- Banner Selamat Datang & Status Keanggotaan --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4 d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
            <div>
                <div class="d-flex align-items-center gap-2 mb-3">
                    <span class="badge rounded-pill badge-brand px-3 py-1">
                        {{ ucfirst($user->role) }}
                    </span>
                    {{-- Validasi Status Keanggotaan dari User Model --}}
                    @if(($user->status_keanggotaan ?? 'non_aktif') === 'aktif')
                        <span class="badge rounded-pill bg-success-subtle text-success border border-success-subtle px-3 py-1">
                            ● Anggota Aktif
                        </span>
                    @else
                        <span class="badge rounded-pill bg-danger-subtle text-danger border border-danger-subtle px-3 py-1">
                            ● Anggota Non-Aktif
                        </span>
                    @endif
                </div>
                <h1 class="h3 fw-bold mb-2">
                    Selamat Datang, <span class="text-brand-dark">{{ $user->username }}</span>! 👋
                </h1>
                <p class="text-secondary mb-0 small">
                    Kelola dan pantau pengajuan pinjaman buku perpustakaan kamu di sini.
                </p>
            </div>
            
            <div class="d-flex gap-2">
                @if(($user->status_keanggotaan ?? 'non_aktif') === 'aktif')
                    <a href="{{ route('peminjaman.create') }}" class="btn btn-brand btn-sm rounded-pill px-3 d-inline-flex align-items-center gap-2">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                            <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                        </svg>
                        Pinjam Buku
                    </a>
                @else
                    <button class="btn btn-secondary btn-sm rounded-pill px-3" disabled title="Keanggotaan Anda Non-Aktif">
                        Pinjam Buku
                    </button>
                @endif
                <a href="{{ route('home') }}" class="btn btn-outline-brand btn-sm rounded-pill px-3">
                    Cari Koleksi
                </a>
            </div>
        </div>
    </div>

    {{-- Ringkasan Statistik Siswa --}}
    <div class="row row-cols-1 row-cols-sm-3 g-3 mb-4">
        {{-- Total Aktif Dipinjam / Menunggu --}}
        <div class="col">
            <div class="card border-0 shadow-sm p-3 h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="feature-icon">
                        <svg width="22" height="22" viewBox="0 0 16 16" fill="currentColor">
                            <path d="M8 1.884c-1.545-.887-3.837-1.113-5.487-.573C1.923.42 1.5.904 1.5 1.5v10.5c0 .548.44.98.955.86 1.469-.34 3.618-.146 5.045.567V1.884zm1 11.543c1.427-.713 3.576-.907 5.045-.567.516.12.955-.312.955-.86V1.5c0-.596-.423-1.08-1.013-1.19C12.337.77 10.045.996 8.5 1.884v11.543z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="fw-bold fs-5 text-brand-dark">
                            {{ isset($totalPinjamAktif) ? $totalPinjamAktif : 0 }} Buku
                        </div>
                        <div class="text-secondary small">Sedang Dipinjam / Menunggu</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Total Selesai Dipinjam --}}
        <div class="col">
            <div class="card border-0 shadow-sm p-3 h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="feature-icon">
                        <svg width="22" height="22" viewBox="0 0 16 16" fill="currentColor">
                            <path d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                            <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="fw-bold fs-5 text-brand-dark">
                            {{ isset($totalDikembalikan) ? $totalDikembalikan : 0 }} Buku
                        </div>
                        <div class="text-secondary small">Selesai Dikembalikan</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Total Denda --}}
        <div class="col">
            <div class="card border-0 shadow-sm p-3 h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="feature-icon">
                        <svg width="22" height="22" viewBox="0 0 16 16" fill="currentColor">
                            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z"/>
                            <path d="M8 3.5a.5.5 0 0 0-.5.5v4a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8.5 7.71V4a.5.5 0 0 0-.5-.5z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="fw-bold fs-5 text-brand-dark">
                            Rp {{ number_format($totalDenda ?? 0, 0, ',', '.') }}
                        </div>
                        <div class="text-secondary small">Total Denda Terpilih</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        {{-- Kolom Kiri: Buku Yang Sedang Dipinjam / Menunggu --}}
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
                    <h2 class="h6 fw-bold mb-0 text-brand-dark d-flex align-items-center gap-2">
                        <span>📚</span> Buku Yang Sedang Dipinjam
                    </h2>
                    <a href="{{ route('peminjaman.riwayat') }}" class="small text-decoration-none text-brand-dark fw-semibold">Lihat Semua</a>
                </div>
                
                <div class="card-body p-4">
                    @if(isset($bukuSedangDipinjam) && count($bukuSedangDipinjam) > 0)
                        @foreach($bukuSedangDipinjam as $p)
                            <div class="p-3 border rounded-3 bg-body-tertiary mb-3">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <h3 class="h6 fw-bold mb-1">{{ $p->buku->judul_buku ?? 'Judul Buku' }}</h3>
                                        <p class="text-secondary small mb-0">
                                            {{ $p->buku->pengarang ?? '-' }} &middot; {{ $p->buku->penerbit ?? '-' }}
                                        </p>
                                    </div>
                                    @if($p->status === 'menunggu_konfirmasi')
                                        <span class="badge bg-warning text-dark rounded-pill small">Menunggu Admin</span>
                                    @elseif($p->status === 'dipinjam')
                                        <span class="badge bg-primary rounded-pill small">Sedang Dipinjam</span>
                                    @endif
                                </div>
                                <hr class="my-2 border-secondary-subtle">
                                <div class="d-flex justify-content-between text-secondary small">
                                    <span>Tgl Pinjam: <strong>{{ date('d M Y', strtotime($p->tanggal_pinjam)) }}</strong></span>
                                    <span>Wajib Kembali: <strong>{{ date('d M Y', strtotime($p->tanggal_wajib_kembali)) }}</strong></span>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-4 text-secondary">
                            <p class="mb-2">Belum ada buku yang sedang dipinjam.</p>
                            @if(($user->status_keanggotaan ?? 'non_aktif') === 'aktif')
                                <a href="{{ route('peminjaman.create') }}" class="btn btn-sm btn-outline-brand rounded-pill">Mulai Pinjam Buku</a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Riwayat Terakhir --}}
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
                    <h2 class="h6 fw-bold mb-0 text-brand-dark d-flex align-items-center gap-2">
                        <span>🕒</span> Riwayat Terakhir
                    </h2>
                </div>

                <div class="card-body p-4">
                    @if(isset($riwayatTerakhir) && count($riwayatTerakhir) > 0)
                        <ul class="list-group list-group-flush small">
                            @foreach($riwayatTerakhir as $r)
                                <li class="list-group-item bg-transparent px-0 py-2 d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="fw-semibold">{{ $r->buku->judul_buku ?? 'Buku' }}</div>
                                        <div class="text-secondary opacity-75" style="font-size: 12px;">
                                            @if($r->status === 'dikembalikan')
                                                Selesai: {{ date('d M Y', strtotime($r->tanggal_dikembalikan)) }}
                                            @elseif($r->status === 'ditolak')
                                                Ditolak: {{ $r->catatan_admin ?? 'Tidak disetujui' }}
                                            @endif
                                        </div>
                                    </div>
                                    @if($r->status === 'dikembalikan')
                                        <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">Dikembalikan</span>
                                    @elseif($r->status === 'ditolak')
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill">Ditolak</span>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-secondary small text-center my-3">Belum ada riwayat transaksi peminjaman.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection