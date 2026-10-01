<?php

namespace App\Controllers;

use Sakuci\Controller;
use Sakuci\Http\Request;
use App\Models\Peminjaman;
use App\Models\DataBuku;
use App\Models\User;

class PeminjamanController extends Controller
{
    //lama masa pinjam (hari), dihitung sejak admin menyetujui pengajuan
    const MASA_PINJAM_HARI = 7;

    public function dashboardSiswa(Request $request) //dashboard siswa
    {
        $currentUser = User::current();

        //admin punya dashboard sendiri
        if ($currentUser->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        //ambil semua peminjaman milik siswa ini (terbaru dulu), lalu dipisah di PHP
        $semuaPeminjaman = Peminjaman::where('id_user', $currentUser->id)
            ->orderBy('id_peminjaman', 'desc')
            ->get();

        $bukuSedangDipinjam = []; //menunggu konfirmasi / sedang dipinjam
        $riwayatTerakhir = [];    //selesai / ditolak (maks. 5 terbaru)
        $totalDikembalikan = 0;
        $totalDenda = 0;

        foreach ($semuaPeminjaman as $p) {
            $p->buku = DataBuku::find($p->id_buku);
            $totalDenda += $p->denda;

            if ($p->status === 'menunggu_konfirmasi' || $p->status === 'dipinjam') {
                $bukuSedangDipinjam[] = $p;
            } else {
                if ($p->status === 'dikembalikan') {
                    $totalDikembalikan++;
                }
                if (count($riwayatTerakhir) < 5) {
                    $riwayatTerakhir[] = $p;
                }
            }
        }

        return view('dashboard', [
            'user' => $currentUser,
            'bukuSedangDipinjam' => $bukuSedangDipinjam,
            'riwayatTerakhir' => $riwayatTerakhir,
            'totalPinjamAktif' => count($bukuSedangDipinjam),
            'totalDikembalikan' => $totalDikembalikan,
            'totalDenda' => $totalDenda,
        ]);
    }

    public function cetak(Request $request) //cetak laporan transaksi peminjaman (admin)
    {
        $tanggalDari = $request->tanggal_dari ?? null;
        $tanggalSampai = $request->tanggal_sampai ?? null;

        $semuaPeminjaman = Peminjaman::orderBy('id_peminjaman', 'desc')->get();

        $daftarPeminjaman = [];
        $totalDenda = 0;
        foreach ($semuaPeminjaman as $p) {
            //pengajuan yang belum disetujui belum punya tanggal pinjam
            if (($tanggalDari || $tanggalSampai) && empty($p->tanggal_pinjam)) {
                continue;
            }
            if ($tanggalDari && $p->tanggal_pinjam < $tanggalDari) {
                continue;
            }
            if ($tanggalSampai && $p->tanggal_pinjam > $tanggalSampai) {
                continue;
            }

            $p->peminjam = User::find($p->id_user);
            $p->buku = DataBuku::find($p->id_buku);
            $totalDenda += $p->denda;
            $daftarPeminjaman[] = $p;
        }

        return view('peminjaman.cetak', compact('daftarPeminjaman', 'tanggalDari', 'tanggalSampai', 'totalDenda'));
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

        //cari buku yang sedang dipinjam/menunggu, supaya tidak ditawarkan lagi
        $sedangDipinjam = [];
        foreach (Peminjaman::where('status', 'menunggu_konfirmasi')->get() as $p) {
            $sedangDipinjam[] = $p->id_buku;
        }
        foreach (Peminjaman::where('status', 'dipinjam')->get() as $p) {
            $sedangDipinjam[] = $p->id_buku;
        }

        //semua buku yang tersedia, urut A-Z seperti kamus
        $daftarBukuTersedia = [];
        foreach (DataBuku::orderBy('judul_buku', 'asc')->get() as $b) {
            if (!in_array($b->id_buku, $sedangDipinjam)) {
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

        //tanggal pinjam & tanggal wajib kembali sengaja dikosongkan,
        //baru ditentukan sistem saat admin menyetujui pengajuan (lihat approve)
        Peminjaman::create([
            'id_user' => $currentUser->id,
            'id_buku' => $validatedData['id_buku'],
            'tanggal_pinjam' => null,
            'tanggal_wajib_kembali' => null,
            'status' => 'menunggu_konfirmasi',
            'denda' => 0,
        ]);

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

            //pengajuan yang belum disetujui belum punya tanggal pinjam
            if (($tanggalDari || $tanggalSampai) && empty($p->tanggal_pinjam)) {
                $cocok = false;
            }
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

        return view('peminjaman.index', compact('daftarPeminjaman', 'tanggalDari', 'tanggalSampai'));
    }

    public function approve(Request $request, $id_peminjaman) //setujui pengajuan (admin)
    {
        $peminjaman = Peminjaman::findOrFail($id_peminjaman);

        //hanya pengajuan yang masih menunggu yang bisa disetujui (mencegah tanggal tertimpa)
        if ($peminjaman->status !== 'menunggu_konfirmasi') {
            return redirect()->route('peminjaman.index')->with('error', 'Pengajuan ini sudah diproses sebelumnya.');
        }

        //masa pinjam dimulai hari ini, saat admin menyetujui
        $tanggalPinjam = date('Y-m-d');
        $tanggalWajibKembali = date('Y-m-d', strtotime('+' . self::MASA_PINJAM_HARI . ' days'));

        $peminjaman->update([
            'status' => 'dipinjam',
            'tanggal_pinjam' => $tanggalPinjam,
            'tanggal_wajib_kembali' => $tanggalWajibKembali,
        ]);

        return redirect()->route('peminjaman.index')->with('success', 'Pengajuan peminjaman disetujui.');
    }

    public function reject(Request $request, $id_peminjaman) //tolak pengajuan (admin)
    {
        $peminjaman = Peminjaman::findOrFail($id_peminjaman);

        $validatedData = $request->validate([
            'catatan_admin' => 'nullable|string|max:255',
        ]);

        $peminjaman->update([
            'status' => 'ditolak',
            'catatan_admin' => $validatedData['catatan_admin'] ?? null,
        ]);

        return redirect()->route('peminjaman.index')->with('success', 'Pengajuan peminjaman ditolak.');
    }

    public function konfirmasiKembali(Request $request, $id_peminjaman) //konfirmasi pengembalian (admin)
    {
        $peminjaman = Peminjaman::findOrFail($id_peminjaman);

        $hariIni = date('Y-m-d');
        $denda = 0;

        //hitung denda kalau lewat tanggal wajib kembali (Rp1.000 per hari telat, sesuaikan kalau perlu)
        $telatHari = (strtotime($hariIni) - strtotime($peminjaman->tanggal_wajib_kembali)) / 86400;
        if ($telatHari > 0) {
            $denda = $telatHari * 1000;
        }

        $peminjaman->update([
            'tanggal_dikembalikan' => $hariIni,
            'status' => 'dikembalikan',
            'denda' => $denda,
        ]);

        return redirect()->route('peminjaman.index')->with('success', 'Pengembalian buku berhasil dikonfirmasi.');
    }
}