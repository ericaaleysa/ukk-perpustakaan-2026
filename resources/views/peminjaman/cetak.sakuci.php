<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Transaksi Peminjaman</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="cetak-page">

@php
    $petugas = \App\Models\User::current();
    $labelStatus = [
        'menunggu_konfirmasi' => 'Menunggu Konfirmasi',
        'dipinjam'            => 'Dipinjam',
        'ditolak'             => 'Ditolak',
        'dikembalikan'        => 'Dikembalikan',
    ];
    $no = 1;
@endphp

    {{-- Toolbar (tidak ikut tercetak) --}}
    <div class="toolbar">
        <form method="GET" action="{{ route('peminjaman.cetak') }}">
            <label for="tanggal_dari">Dari</label>
            <input type="date" name="tanggal_dari" id="tanggal_dari" value="{{ $tanggalDari }}">
            <label for="tanggal_sampai">Sampai</label>
            <input type="date" name="tanggal_sampai" id="tanggal_sampai" value="{{ $tanggalSampai }}">
            <button type="submit">Terapkan</button>
            @if($tanggalDari || $tanggalSampai)
                <a href="{{ route('peminjaman.cetak') }}">Reset</a>
            @endif
        </form>

        <span class="spacer"></span>
        <span class="hint">Di jendela cetak, pilih Printer atau "Simpan sebagai PDF"</span>
        <button type="button" class="btn-print" onclick="window.print()">🖨 Cetak</button>
        <a href="{{ route('peminjaman.index') }}">&larr; Kembali</a>
    </div>

    <div class="lembar">

        <div class="kop">
            <div class="instansi">NEXUS DIGITAL LIBRARY</div>
            <h1>LAPORAN TRANSAKSI PEMINJAMAN BUKU</h1>
            <div class="periode">
                @if($tanggalDari || $tanggalSampai)
                    Periode: {{ $tanggalDari ?: 'awal' }} s/d {{ $tanggalSampai ?: 'sekarang' }}
                @else
                    Periode: Semua transaksi
                @endif
            </div>
        </div>

        <div class="ringkasan">
            <div class="kotak">
                <div class="label">Total transaksi</div>
                <div class="nilai">{{ count($daftarPeminjaman) }}</div>
            </div>
            <div class="kotak">
                <div class="label">Total denda</div>
                <div class="nilai">Rp{{ number_format($totalDenda, 0, ',', '.') }}</div>
            </div>
        </div>

        @if(count($daftarPeminjaman) === 0)
            <div class="kosong">Tidak ada transaksi pada periode ini.</div>
        @else
        <table>
            <thead>
                <tr>
                    <th class="c" style="width: 36px;">No</th>
                    <th>Peminjam</th>
                    <th>Judul Buku</th>
                    <th class="c">Tgl Pinjam</th>
                    <th class="c">Wajib Kembali</th>
                    <th class="c">Tgl Dikembalikan</th>
                    <th>Status</th>
                    <th class="r">Denda</th>
                </tr>
            </thead>
            <tbody>
                @foreach($daftarPeminjaman as $p)
                <tr>
                    <td class="c">{{ $no++ }}</td>
                    <td>{{ $p->peminjam->username ?? '-' }}</td>
                    <td>{{ $p->buku->judul_buku ?? '-' }}</td>
                    <td class="c nowrap">{{ $p->tanggal_pinjam }}</td>
                    <td class="c nowrap">{{ $p->tanggal_wajib_kembali }}</td>
                    <td class="c nowrap">{{ $p->tanggal_dikembalikan ?? '-' }}</td>
                    <td class="nowrap">{{ $labelStatus[$p->status] ?? $p->status }}</td>
                    <td class="r">{{ $p->denda > 0 ? 'Rp' . number_format($p->denda, 0, ',', '.') : '-' }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="7" class="r">Total denda</td>
                    <td class="r">Rp{{ number_format($totalDenda, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>
        @endif

        <div class="ttd-wrap">
            <div class="ttd">
                <div>Dicetak pada {{ date('d-m-Y') }}</div>
                <div class="ruang"></div>
                <div class="nama">( {{ $petugas->username ?? 'Admin Perpustakaan' }} )</div>
                <div>Admin Perpustakaan</div>
            </div>
        </div>

        <div class="catatan-cetak">Dokumen ini dibuat otomatis oleh sistem NEXLIB pada {{ date('d-m-Y H:i') }}.</div>

    </div>

</body>
</html>