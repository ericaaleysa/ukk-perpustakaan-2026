<?php

namespace App\Controllers\Core;

use App\Models\User;
use App\Models\Peminjaman;
use App\Models\DataBuku;
use Sakuci\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $user = User::current();

        // Buku yang sedang dipinjam atau menunggu konfirmasi
        $bukuSedangDipinjam = Peminjaman::where('id_user', $user->id)
            ->whereIn('status', ['menunggu_konfirmasi', 'dipinjam'])
            ->get();
        foreach ($bukuSedangDipinjam as $p) {
            $p->buku = DataBuku::find($p->id_buku);
        }

        // Riwayat transaksi selesai / ditolak (5 terakhir)
        $riwayatTerakhir = Peminjaman::where('id_user', $user->id)
            ->whereIn('status', ['dikembalikan', 'ditolak'])
            ->orderBy('id_peminjaman', 'desc')
            ->take(5)
            ->get();
        foreach ($riwayatTerakhir as $r) {
            $r->buku = DataBuku::find($r->id_buku);
        }

        // Ringkasan statistik
        $totalPinjamAktif = count($bukuSedangDipinjam);
        $totalDikembalikan = Peminjaman::where('id_user', $user->id)->where('status', 'dikembalikan')->count();

        $totalDenda = 0;
        foreach (Peminjaman::where('id_user', $user->id)->get() as $p) {
            $totalDenda += $p->denda;
        }

        return view('core.dashboard', [
            'user' => $user,
            'bukuSedangDipinjam' => $bukuSedangDipinjam,
            'riwayatTerakhir' => $riwayatTerakhir,
            'totalPinjamAktif' => $totalPinjamAktif,
            'totalDikembalikan' => $totalDikembalikan,
            'totalDenda' => $totalDenda,
        ]);
    }

    public function admin()
    {
        return view('core.admin.dashboard', ['user' => User::current()]);
    }
}