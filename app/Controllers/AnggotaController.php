<?php

namespace App\Controllers;

use Sakuci\Controller;
use Sakuci\Http\Request;
use App\Models\User;

class AnggotaController extends Controller
{
    public function index(Request $request) //daftar seluruh siswa & status keanggotaannya (admin)
    {
        $daftarSiswa = User::where('role', 'siswa')->orderBy('username', 'asc')->get();
        return view('anggota.index', compact('daftarSiswa'));
    }

    public function aktifkan(Request $request, $id_user) //admin mengaktifkan kembali anggota non-aktif
    {
        $siswa = User::findOrFail($id_user);
        $siswa->update(['status_keanggotaan' => 'aktif']);

        return redirect()->route('admin.anggota.index')->with('success', 'Keanggotaan siswa berhasil diaktifkan kembali.');
    }

    public function nonaktifkan(Request $request, $id_user) //admin menonaktifkan anggota
    {
        $siswa = User::findOrFail($id_user);
        $siswa->update(['status_keanggotaan' => 'non_aktif']);

        return redirect()->route('admin.anggota.index')->with('success', 'Keanggotaan siswa berhasil dinonaktifkan.');
    }
}