<?php

namespace App\Controllers;

use Sakuci\Controller;
use Sakuci\Http\Request;
use App\Models\PengajuanKeanggotaan;
use App\Models\User;

class PengajuanKeanggotaanController extends Controller
{
    public function create(Request $request) //form pengajuan (siswa)
    {
        $currentUser = User::current();

        $riwayatPengajuan = PengajuanKeanggotaan::where('id_user', $currentUser->id)
            ->orderBy('id_pengajuan', 'desc')
            ->get();

        $pengajuanTerakhir = count($riwayatPengajuan) > 0 ? $riwayatPengajuan[0] : null;

        return view('keanggotaan.create', compact('currentUser', 'pengajuanTerakhir'));
    }

    public function store(Request $request) //simpan pengajuan (siswa)
    {
        $currentUser = User::current();

        $validatedData = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nis' => 'required|string',
            'kelas' => 'required|string|max:50',
        ]);

        PengajuanKeanggotaan::create([
            'id_user' => $currentUser->id,
            'nama_lengkap' => $validatedData['nama_lengkap'],
            'nis' => $validatedData['nis'],
            'kelas' => $validatedData['kelas'],
            'status' => 'menunggu',
            'tanggal_pengajuan' => date('Y-m-d H:i:s'),
        ]);

        $currentUser->update(['status_keanggotaan' => 'menunggu_verifikasi']);

        return redirect()->route('keanggotaan.create')->with('success', 'Pengajuan keanggotaan berhasil dikirim, mohon tunggu verifikasi admin.');
    }

    public function index(Request $request) //daftar pengajuan menunggu (admin)
    {
        $daftarPengajuan = PengajuanKeanggotaan::where('status', 'menunggu')
            ->orderBy('id_pengajuan', 'desc')
            ->get();

        foreach ($daftarPengajuan as $p) {
            $p->pemohon = User::find($p->id_user);
        }

        return view('keanggotaan.index', compact('daftarPengajuan'));
    }

    public function approve(Request $request, $id_pengajuan) //setujui (admin)
    {
        $admin = User::current();
        $pengajuan = PengajuanKeanggotaan::findOrFail($id_pengajuan);

        $pengajuan->update([
            'status' => 'disetujui',
            'tanggal_verifikasi' => date('Y-m-d H:i:s'),
            'diverifikasi_oleh' => $admin->id,
        ]);

        $pemohon = User::findOrFail($pengajuan->id_user);
        $pemohon->update(['status_keanggotaan' => 'aktif']);

        return redirect()->route('keanggotaan.index')->with('success', 'Pengajuan disetujui, siswa sekarang berstatus Anggota.');
    }

    public function reject(Request $request, $id_pengajuan) //tolak (admin)
    {
        $admin = User::current();
        $pengajuan = PengajuanKeanggotaan::findOrFail($id_pengajuan);

        $validatedData = $request->validate([
            'catatan_admin' => 'nullable|string|max:255',
        ]);

        $pengajuan->update([
            'status' => 'ditolak',
            'catatan_admin' => $validatedData['catatan_admin'] ?? null,
            'tanggal_verifikasi' => date('Y-m-d H:i:s'),
            'diverifikasi_oleh' => $admin->id,
        ]);

        $pemohon = User::findOrFail($pengajuan->id_user);
        $pemohon->update(['status_keanggotaan' => 'non_anggota']);

        return redirect()->route('keanggotaan.index')->with('success', 'Pengajuan ditolak.');
    }
}