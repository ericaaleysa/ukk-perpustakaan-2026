<?php

namespace App\Controllers;

use Sakuci\Controller;
use Sakuci\Http\Request;
use App\Models\Peminjaman;
use App\Models\DataBuku;
use App\Models\User;

class PeminjamanController extends Controller
{
    public function create(Request $request) //form ajukan peminjaman (siswa)
    {
        $currentUser = User::current();

        if ($currentUser->status_keanggotaan !== 'aktif') {
            return view('peminjaman.create', [
                'currentUser' => $currentUser,
                'daftarBukuTersedia' => [],
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

        $daftarBukuTersedia = [];
        foreach (DataBuku::all() as $b) {
            if (!in_array($b->id_buku, $sedangDipinjam)) {
                $daftarBukuTersedia[] = $b;
            }
        }

        return view('peminjaman.create', compact('currentUser', 'daftarBukuTersedia'));
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
        $daftarPeminjaman = Peminjaman::orderBy('id_peminjaman', 'desc')->get();

        foreach ($daftarPeminjaman as $p) {
            $p->peminjam = User::find($p->id_user);
            $p->buku = DataBuku::find($p->id_buku);
        }

        return view('peminjaman.index', compact('daftarPeminjaman'));
    }

    public function approve(Request $request, $id_peminjaman) //setujui pengajuan (admin)
    {
        $peminjaman = Peminjaman::findOrFail($id_peminjaman);
        $peminjaman->update(['status' => 'dipinjam']);

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