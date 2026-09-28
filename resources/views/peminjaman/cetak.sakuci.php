<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Transaksi Peminjaman</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; color: #000; margin: 24px; }
        h1 { font-size: 18px; margin: 0; text-align: center; }
        .sub { text-align: center; margin: 4px 0 16px; color: #555; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #333; padding: 6px 8px; text-align: left; }
        th { background: #eee; }
        .ringkasan { margin: 12px 0; }
        .ttd { margin-top: 40px; float: right; text-align: center; width: 200px; }
        .toolbar { margin-bottom: 16px; padding: 10px; background: #f5f5f5; border: 1px solid #ddd; }
        .toolbar input, .toolbar button, .toolbar a { font-size: 12px; padding: 4px 8px; }
        @media print { .toolbar { display: none; } body { margin: 0; } }
    </style>
</head>
<body>

    {{-- Toolbar (tidak ikut tercetak) --}}
    <div class="toolbar">
        <form method="GET" action="{{ route('peminjaman.cetak') }}" style="display:inline;">
            Dari: <input type="date" name="tanggal_dari" value="{{ $tanggalDari }}">
            Sampai: <input type="date" name="tanggal_sampai" value="{{ $tanggalSampai }}">
            <button type="submit">Terapkan</button>
        </form>
        <button type="button" onclick="window.print()">Cetak / Simpan PDF</button>
        <a href="{{ route('admin.dashboard') }}">&larr; Kembali</a>
    </div>

    <h1>LAPORAN TRANSAKSI PEMINJAMAN BUKU</h1>
    <p class="sub">
        NEX-LIB Perpustakaan<br>
        @if($tanggalDari || $tanggalSampai)
            Periode: {{ $tanggalDari ?: 'awal' }} s/d {{ $tanggalSampai ?: 'sekarang' }}
        @else
            Periode: Semua transaksi
        @endif
    </p>

    <div class="ringkasan">
        Total transaksi: <strong>{{ count($daftarPeminjaman) }}</strong> &nbsp;|&nbsp;
        Total denda: <strong>Rp{{ number_format($totalDenda, 0, ',', '.') }}</strong>
    </div>

    @if(count($daftarPeminjaman) === 0)
        <p>Tidak ada transaksi pada periode ini.</p>
    @else
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Peminjam</th>
                <th>Judul Buku</th>
                <th>Tgl Pinjam</th>
                <th>Wajib Kembali</th>
                <th>Tgl Dikembalikan</th>
                <th>Status</th>
                <th>Denda</th>
            </tr>
        </thead>
        <tbody>
            @php
                $no = 1;
                $labelStatus = [
                    'menunggu_konfirmasi' => 'Menunggu Konfirmasi',
                    'dipinjam' => 'Dipinjam',
                    'ditolak' => 'Ditolak',
                    'dikembalikan' => 'Dikembalikan',
                ];
            @endphp
            @foreach($daftarPeminjaman as $p)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $p->peminjam->username ?? '-' }}</td>
                <td>{{ $p->buku->judul_buku ?? '-' }}</td>
                <td>{{ $p->tanggal_pinjam }}</td>
                <td>{{ $p->tanggal_wajib_kembali }}</td>
                <td>{{ $p->tanggal_dikembalikan ?? '-' }}</td>
                <td>{{ $labelStatus[$p->status] ?? $p->status }}</td>
                <td>{{ $p->denda > 0 ? 'Rp' . number_format($p->denda, 0, ',', '.') : '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    <div class="ttd">
        <p>Dicetak pada {{ date('d-m-Y') }}</p>
        <br><br><br>
        <p>( Admin Perpustakaan )</p>
    </div>

</body>
</html>