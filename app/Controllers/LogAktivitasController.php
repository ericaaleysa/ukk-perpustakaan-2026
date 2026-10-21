<?php

namespace App\Controllers;

use Sakuci\Controller;
use Sakuci\Http\Request;
use App\Models\LogAktivitas;

class LogAktivitasController extends Controller
{
    public function index(Request $request) //daftar log aktivitas (khusus admin, lewat grup route admin)
    {
        $filter = [
            'q' => trim((string) ($request->q ?? '')),
            'kategori' => (string) ($request->kategori ?? ''),
            'tanggal_dari' => (string) ($request->tanggal_dari ?? ''),
            'tanggal_sampai' => (string) ($request->tanggal_sampai ?? ''),
        ];

        $perHalaman = 20;
        $hasil = LogAktivitas::cari($filter, (int) ($request->page ?? 1), $perHalaman);

        return view('log.index', [
            'daftarLog' => $hasil['data'],
            'total' => $hasil['total'],
            'halaman' => $hasil['halaman'],
            'totalHalaman' => $hasil['totalHalaman'],
            'galat' => $hasil['galat'],
            'perHalaman' => $perHalaman,
            'filter' => $filter,
            'daftarKategori' => LogAktivitas::KATEGORI,
        ]);
    }
}