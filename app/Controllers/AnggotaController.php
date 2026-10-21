<?php

namespace App\Controllers;

use Sakuci\Controller;
use Sakuci\Http\Request;
use App\Models\User;
use App\Models\LogAktivitas;

class AnggotaController extends Controller
{
    public function index(Request $request) //daftar seluruh pengguna & status keanggotaannya (admin)
    {
        // Nama variabel $daftarSiswa sengaja dipertahankan agar view anggota.index tidak perlu diubah
        $daftarSiswa = User::where('role', 'pengguna')->orderBy('username', 'asc')->get();
        return view('anggota.index', compact('daftarSiswa'));
    }

    public function aktifkan(Request $request, $id_user) //admin mengaktifkan kembali anggota non-aktif
    {
        $pengguna = User::findOrFail($id_user);
        $pengguna->update(['status_keanggotaan' => 'aktif']);

        LogAktivitas::catat('anggota', 'Mengaktifkan kembali keanggotaan ' . $pengguna->username);

        return redirect()->route('anggota.index')->with('success', 'Keanggotaan pengguna berhasil diaktifkan kembali.');
    }

    public function nonaktifkan(Request $request, $id_user) //admin menonaktifkan anggota
    {
        $pengguna = User::findOrFail($id_user);
        $pengguna->update(['status_keanggotaan' => 'non_aktif']);

        LogAktivitas::catat('anggota', 'Menonaktifkan keanggotaan ' . $pengguna->username);

        return redirect()->route('anggota.index')->with('success', 'Keanggotaan pengguna berhasil dinonaktifkan.');
    }
}