<?php

namespace App\Controllers;

use Sakuci\Controller;
use Sakuci\Http\Request;
use App\Models\Peminjaman;
use App\Models\DataBuku;
use App\Models\User;
use App\Models\LogAktivitas;

class PeminjamanController extends Controller
{
    //tarif denda (ubah angkanya di sini)
    private const DENDA_TELAT_PER_HARI = 1000;
    private const DENDA_KONDISI = [
        'baik' => 0,
        'rusak_ringan' => 5000,
        'rusak_berat' => 25000,
        'hilang' => 50000,
    ];
    private const LABEL_KONDISI = [
        'baik' => 'Baik',
        'rusak_ringan' => 'Rusak ringan',
        'rusak_berat' => 'Rusak berat',
        'hilang' => 'Hilang',
    ];
    //kondisi yang membuat buku TIDAK masuk stok lagi
    private const KONDISI_TIDAK_KEMBALI_KE_STOK = ['rusak_berat', 'hilang'];

    public function cetak(Request $request) //cetak laporan transaksi peminjaman (admin)
    {
        $tanggalDari = $request->tanggal_dari ?? null;
        $tanggalSampai = $request->tanggal_sampai ?? null;

        $semuaPeminjaman = Peminjaman::orderBy('id_peminjaman', 'desc')->get();

        $daftarPeminjaman = [];
        $totalDenda = 0;
        $totalDendaTelat = 0;
        $totalDendaKondisi = 0;
        foreach ($semuaPeminjaman as $p) {
            if ($tanggalDari && $p->tanggal_pinjam < $tanggalDari) {
                continue;
            }
            if ($tanggalSampai && $p->tanggal_pinjam > $tanggalSampai) {
                continue;
            }

            $p->peminjam = User::find($p->id_user);
            $p->buku = DataBuku::find($p->id_buku);
            $totalDenda += $p->denda;
            $totalDendaTelat += (int) ($p->denda_telat ?? 0);
            $totalDendaKondisi += (int) ($p->denda_kondisi ?? 0);
            $daftarPeminjaman[] = $p;
        }

        $periode = ($tanggalDari || $tanggalSampai)
            ? ' periode ' . ($tanggalDari ?: 'awal') . ' s/d ' . ($tanggalSampai ?: 'sekarang')
            : '';
        LogAktivitas::catat('sistem', 'Mencetak laporan transaksi peminjaman' . $periode);

        return view('peminjaman.cetak', compact('daftarPeminjaman', 'tanggalDari', 'tanggalSampai', 'totalDenda', 'totalDendaTelat', 'totalDendaKondisi'));
    }

    public function create(Request $request) //form ajukan peminjaman (siswa)
    {
        $currentUser = User::current();

        $keyword = trim((string) ($request->q ?? ''));
        $idPilih = $request->pilih ?? null;

        if ($currentUser->status_keanggotaan !== 'aktif') {
            return view('peminjaman.create', [
                'currentUser' => $currentUser,
                'daftarBukuTersedia' => [],
                'daftarBukuTampil' => [],
                'bukuDipilih' => null,
                'keyword' => $keyword,
            ]);
        }

        //hanya buku yang stoknya masih ada yang ditawarkan, urut A-Z seperti kamus
        $daftarBukuTersedia = [];
        foreach (DataBuku::orderBy('judul_buku', 'asc')->get() as $b) {
            if ((int) $b->stok > 0) {
                $daftarBukuTersedia[] = $b;
            }
        }

        //buku yang dipilih (harus termasuk buku yang tersedia)
        $bukuDipilih = null;
        foreach ($daftarBukuTersedia as $b) {
            if ($idPilih && $b->id_buku == $idPilih) {
                $bukuDipilih = $b;
            }
        }

        //saring daftar dengan kata kunci (judul / pengarang / penerbit)
        $daftarBukuTampil = [];
        foreach ($daftarBukuTersedia as $b) {
            if ($keyword !== '') {
                $cocok = stripos($b->judul_buku, $keyword) !== false
                    || stripos($b->pengarang, $keyword) !== false
                    || stripos($b->penerbit, $keyword) !== false;
                if (!$cocok) {
                    continue;
                }
            }
            $daftarBukuTampil[] = $b;
        }

        return view('peminjaman.create', compact('currentUser', 'daftarBukuTersedia', 'daftarBukuTampil', 'bukuDipilih', 'keyword'));
    }

    public function store(Request $request) //simpan pengajuan (siswa)
    {
        $currentUser = User::current();

        if ($currentUser->status_keanggotaan !== 'aktif') {
            return redirect()->route('peminjaman.create')->with('error', 'Anda harus menjadi Anggota Aktif untuk bisa meminjam buku.');
        }

        $validatedData = $request->validate([
            'id_buku' => 'required|integer|exists:data_buku,id_buku',
        ]);

        //pastikan stok buku masih ada
        $buku = DataBuku::findOrFail($validatedData['id_buku']);
        if ((int) $buku->stok < 1) {
            return redirect()->route('peminjaman.create')->with('error', 'Maaf, stok buku ini sedang habis.');
        }

        $tanggalPinjam = date('Y-m-d');
        $tanggalWajibKembali = date('Y-m-d', strtotime('+7 days'));

        Peminjaman::create([
            'id_user' => $currentUser->id,
            'id_buku' => $validatedData['id_buku'],
            'tanggal_pinjam' => $tanggalPinjam,
            'tanggal_wajib_kembali' => $tanggalWajibKembali,
            'status' => 'menunggu_konfirmasi',
            'denda' => 0,
        ]);

        //stok berkurang begitu buku dipinjam/diajukan
        $this->ubahStok($validatedData['id_buku'], -1);

        LogAktivitas::catat('peminjaman', 'Mengajukan peminjaman buku "' . $buku->judul_buku . '"');

        return redirect()->route('peminjaman.riwayat')->with('success', 'Pengajuan peminjaman berhasil dikirim, mohon tunggu konfirmasi admin.');
    }

    public function riwayat(Request $request) //riwayat peminjaman milik sendiri (siswa)
    {
        $currentUser = User::current();

        $daftarPeminjaman = Peminjaman::where('id_user', $currentUser->id)
            ->orderBy('id_peminjaman', 'desc')
            ->get();

        foreach ($daftarPeminjaman as $p) {
            $p->buku = DataBuku::find($p->id_buku);
        }

        return view('peminjaman.riwayat', compact('daftarPeminjaman'));
    }

    public function index(Request $request) //semua transaksi peminjaman (admin)
    {
        $tanggalDari = $request->tanggal_dari ?? null;
        $tanggalSampai = $request->tanggal_sampai ?? null;

        $semuaPeminjaman = Peminjaman::orderBy('id_peminjaman', 'desc')->get();

        $daftarPeminjaman = [];
        foreach ($semuaPeminjaman as $p) {
            $cocok = true;

            if ($tanggalDari && $p->tanggal_pinjam < $tanggalDari) {
                $cocok = false;
            }
            if ($tanggalSampai && $p->tanggal_pinjam > $tanggalSampai) {
                $cocok = false;
            }

            if ($cocok) {
                $daftarPeminjaman[] = $p;
            }
        }

        foreach ($daftarPeminjaman as $p) {
            $p->peminjam = User::find($p->id_user);
            $p->buku = DataBuku::find($p->id_buku);
        }

        $dendaKondisiDefault = self::DENDA_KONDISI;

        return view('peminjaman.index', compact('daftarPeminjaman', 'tanggalDari', 'tanggalSampai', 'dendaKondisiDefault'));
    }

    public function approve(Request $request, $id_peminjaman) //setujui pengajuan (admin)
    {
        $peminjaman = Peminjaman::findOrFail($id_peminjaman);

        if ($peminjaman->status !== 'menunggu_konfirmasi') {
            return redirect()->route('peminjaman.index')->with('error', 'Pengajuan ini sudah diproses sebelumnya.');
        }

        $peminjaman->update(['status' => 'dipinjam']);

        [$peminjam, $judul] = $this->infoPeminjaman($peminjaman);
        LogAktivitas::catat('peminjaman', 'Menyetujui peminjaman buku "' . $judul . '" oleh ' . $peminjam);

        return redirect()->route('peminjaman.index')->with('success', 'Pengajuan peminjaman disetujui.');
    }

    public function reject(Request $request, $id_peminjaman) //tolak pengajuan (admin)
    {
        $peminjaman = Peminjaman::findOrFail($id_peminjaman);

        if ($peminjaman->status !== 'menunggu_konfirmasi') {
            return redirect()->route('peminjaman.index')->with('error', 'Pengajuan ini sudah diproses sebelumnya.');
        }

        $validatedData = $request->validate([
            'catatan_admin' => 'nullable|string|max:255',
        ]);

        $peminjaman->update([
            'status' => 'ditolak',
            'catatan_admin' => $validatedData['catatan_admin'] ?? null,
        ]);

        //pengajuan ditolak: stok yang tadi dipesan dikembalikan
        $this->ubahStok($peminjaman->id_buku, +1);

        [$peminjam, $judul] = $this->infoPeminjaman($peminjaman);
        $alasan = $validatedData['catatan_admin'] ?? null;
        LogAktivitas::catat('peminjaman', 'Menolak peminjaman buku "' . $judul . '" oleh ' . $peminjam . ($alasan ? ' (alasan: ' . $alasan . ')' : ''));

        return redirect()->route('peminjaman.index')->with('success', 'Pengajuan peminjaman ditolak.');
    }

    public function konfirmasiKembali(Request $request, $id_peminjaman) //konfirmasi pengembalian (admin)
    {
        $peminjaman = Peminjaman::findOrFail($id_peminjaman);

        if ($peminjaman->status !== 'dipinjam') {
            return redirect()->route('peminjaman.index')->with('error', 'Buku ini tidak sedang berstatus dipinjam.');
        }

        $validatedData = $request->validate([
            'catatan_kondisi' => 'nullable|string|max:255',
        ]);

        //kondisi buku saat kembali (dicek manual terhadap daftar kondisi yang diizinkan)
        $kondisi = (string) ($request->kondisi_kembali ?? 'baik');
        if (!array_key_exists($kondisi, self::DENDA_KONDISI)) {
            return redirect()->route('peminjaman.index')->with('error', 'Kondisi buku tidak valid.');
        }

        //denda kondisi: pakai isian admin kalau ada, kalau kosong pakai tarif bawaan
        $inputDenda = trim((string) ($request->denda_kondisi ?? ''));
        if ($kondisi === 'baik') {
            $dendaKondisi = 0;
        } elseif ($inputDenda === '') {
            $dendaKondisi = self::DENDA_KONDISI[$kondisi];
        } elseif (ctype_digit($inputDenda) && (int) $inputDenda <= 10000000) {
            $dendaKondisi = (int) $inputDenda;
        } else {
            return redirect()->route('peminjaman.index')->with('error', 'Nominal denda kondisi harus berupa angka bulat (maksimal Rp10.000.000).');
        }

        $hariIni = date('Y-m-d');

        //denda telat Rp1.000 per hari (lihat konstanta di atas). Buku hilang tidak dikenai denda telat,
        //karena yang ditagih adalah penggantiannya.
        $dendaTelat = 0;
        if ($kondisi !== 'hilang' && $peminjaman->tanggal_wajib_kembali) {
            $telatHari = (int) round((strtotime($hariIni) - strtotime($peminjaman->tanggal_wajib_kembali)) / 86400);
            if ($telatHari > 0) {
                $dendaTelat = $telatHari * self::DENDA_TELAT_PER_HARI;
            }
        }

        $denda = $dendaTelat + $dendaKondisi;

        $peminjaman->update([
            'tanggal_dikembalikan' => $hariIni,
            'status' => 'dikembalikan',
            'kondisi_kembali' => $kondisi,
            'denda' => $denda,
            'denda_telat' => $dendaTelat,
            'denda_kondisi' => $dendaKondisi,
            'catatan_kondisi' => $validatedData['catatan_kondisi'] ?? null,
            'status_denda' => $denda > 0 ? 'belum_lunas' : 'tidak_ada',
            'tanggal_bayar_denda' => null,
            'catatan_bayar' => null,
        ]);

        //stok bertambah lagi hanya kalau buku masih layak dipinjam (baik / rusak ringan)
        if (!in_array($kondisi, self::KONDISI_TIDAK_KEMBALI_KE_STOK, true)) {
            $this->ubahStok($peminjaman->id_buku, +1);
        }

        [$peminjam, $judul] = $this->infoPeminjaman($peminjaman);
        if ($kondisi === 'hilang') {
            LogAktivitas::catat('peminjaman', 'Mencatat buku "' . $judul . '" dari ' . $peminjam . ' sebagai HILANG');
        } else {
            LogAktivitas::catat('peminjaman', 'Mengonfirmasi pengembalian buku "' . $judul . '" dari ' . $peminjam . ' (kondisi: ' . self::LABEL_KONDISI[$kondisi] . ')');
        }

        //catatan denda ke log dibuat saat admin mencatat pembayarannya (lihat bayarDenda),
        //jadi denda yang baru dikenakan sengaja belum dicatat di sini

        $pesan = $kondisi === 'hilang'
            ? 'Buku dicatat hilang. Stok tidak ditambahkan.'
            : 'Pengembalian buku berhasil dikonfirmasi.';

        if ($denda > 0) {
            $pesan .= ' Denda Rp' . number_format($denda, 0, ',', '.') . ' belum dibayar, catat pembayarannya setelah siswa membayar.';
        }

        return redirect()->route('peminjaman.index')->with('success', $pesan);
    }

    public function bayarDenda(Request $request, $id_peminjaman) //catat pembayaran denda (admin)
    {
        $peminjaman = Peminjaman::findOrFail($id_peminjaman);

        if ($peminjaman->status !== 'dikembalikan' || (int) $peminjaman->denda < 1) {
            return redirect()->route('peminjaman.index')->with('error', 'Transaksi ini tidak memiliki denda yang perlu dibayar.');
        }

        if (($peminjaman->status_denda ?? '') === 'lunas') {
            return redirect()->route('peminjaman.index')->with('error', 'Denda ini sudah tercatat lunas sebelumnya.');
        }

        $validatedData = $request->validate([
            'catatan_bayar' => 'nullable|string|max:255',
        ]);

        $peminjaman->update([
            'status_denda' => 'lunas',
            'tanggal_bayar_denda' => date('Y-m-d'),
            'catatan_bayar' => $validatedData['catatan_bayar'] ?? null,
        ]);

        [$peminjam, $judul] = $this->infoPeminjaman($peminjaman);
        $denda = (int) $peminjaman->denda;

        $rincian = [];
        if ((int) $peminjaman->denda_telat > 0) {
            $rincian[] = 'telat Rp' . number_format((int) $peminjaman->denda_telat, 0, ',', '.');
        }
        if ((int) $peminjaman->denda_kondisi > 0) {
            $rincian[] = (($peminjaman->kondisi_kembali ?? '') === 'hilang' ? 'penggantian' : 'kerusakan') . ' Rp' . number_format((int) $peminjaman->denda_kondisi, 0, ',', '.');
        }
        $keterangan = count($rincian) > 0 ? ' (' . implode(', ', $rincian) . ')' : '';

        LogAktivitas::catat('denda', 'Denda Rp' . number_format($denda, 0, ',', '.') . $keterangan . ' dari ' . $peminjam . ' atas buku "' . $judul . '" dilunasi');

        return redirect()->route('peminjaman.index')->with('success', 'Pembayaran denda Rp' . number_format($denda, 0, ',', '.') . ' berhasil dicatat.');
    }

    /** Tambah/kurangi stok buku. $selisih: -1 saat dipinjam, +1 saat kembali/ditolak. */
    private function ubahStok($id_buku, $selisih)
    {
        $buku = DataBuku::find($id_buku);
        if (!$buku) {
            return;
        }

        $stokBaru = max(0, (int) $buku->stok + $selisih);
        $buku->update(['stok' => $stokBaru]);
    }

    /** Ambil nama peminjam & judul buku dari satu transaksi (untuk kalimat log). */
    private function infoPeminjaman($peminjaman)
    {
        $user = User::find($peminjaman->id_user);
        $buku = DataBuku::find($peminjaman->id_buku);

        return [
            $user ? $user->username : 'user #' . $peminjaman->id_user,
            $buku ? $buku->judul_buku : 'buku #' . $peminjaman->id_buku,
        ];
    }
}