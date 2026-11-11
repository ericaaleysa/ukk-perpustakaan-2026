<?php

namespace App\Controllers;

use Sakuci\Controller;
use Sakuci\Http\Request;
use App\Models\Kategori;
use App\Models\DataBuku;
use App\Models\LogAktivitas;

class KategoriController extends Controller
{
    /** Fitur genre buku mencari kategori ini lewat namanya, jadi namanya dikunci. */
    private const KATEGORI_FIKSI = 'karya fiksi';

    public function index(Request $request)
    {
        $kategori = Kategori::orderBy('id_kategori', 'desc')
            ->paginate(5);
        return view('kategori.index', compact('kategori'));
    }

    public function create(Request $request) //bagian tampilan
    {
        return view('kategori.create');
    }

    public function store(Request $request) //bagian menyimpan
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:100',
        ]);

        $nama = trim((string) $request->nama_kategori);

        if ($this->namaSudahAda($nama)) {
            return redirect()->route('kategori.create')->with('error', 'Kategori "' . $nama . '" sudah ada.');
        }

        Kategori::create([
            'nama_kategori' => $nama,
        ]);

        LogAktivitas::catat('kategori', 'Menambahkan kategori "' . $nama . '"');

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Request $request, $id_kategori) //bagian edit
    {
        $kategori = Kategori::findOrFail($id_kategori);
        return view('kategori.edit', compact('kategori'));
    }

    public function update(Request $request, $id_kategori) //bagian update
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:100',
        ]);

        $kategori = Kategori::findOrFail($id_kategori);
        $namaLama = $kategori->nama_kategori;
        $namaBaru = trim((string) $request->nama_kategori);

        if ($this->kategoriFiksi($namaLama) && !$this->kategoriFiksi($namaBaru)) {
            return redirect()->route('kategori.index')
                ->with('error', 'Kategori "Karya Fiksi" tidak bisa diganti namanya karena fitur genre buku bergantung pada nama ini.');
        }

        if ($this->namaSudahAda($namaBaru, $kategori->id_kategori)) {
            return redirect()->route('kategori.index')->with('error', 'Kategori "' . $namaBaru . '" sudah ada.');
        }

        $kategori->update([
            'nama_kategori' => $namaBaru,
        ]);

        LogAktivitas::catat('kategori', 'Mengubah nama kategori "' . $namaLama . '" menjadi "' . $namaBaru . '"');

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Request $request, $id_kategori) //bagian hapus
    {
        $kategori = Kategori::findOrFail($id_kategori);
        $nama = $kategori->nama_kategori;

        if ($this->kategoriFiksi($nama)) {
            return redirect()->route('kategori.index')
                ->with('error', 'Kategori "Karya Fiksi" tidak bisa dihapus karena fitur genre buku bergantung pada kategori ini.');
        }

        //kategori yang masih berisi buku tidak boleh dihapus
        $jumlahBuku = DataBuku::where('id_kategori', $kategori->id_kategori)->count();
        if ($jumlahBuku > 0) {
            return redirect()->route('kategori.index')
                ->with('error', 'Kategori "' . $nama . '" tidak bisa dihapus karena masih berisi ' . $jumlahBuku . ' buku. Pindahkan atau hapus bukunya dulu.');
        }

        $kategori->delete();

        LogAktivitas::catat('kategori', 'Menghapus kategori "' . $nama . '"');

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }

    private function kategoriFiksi($nama)
    {
        return strtolower(trim((string) $nama)) === self::KATEGORI_FIKSI;
    }

    /** Cek nama kembar (tanpa membedakan huruf besar/kecil), $kecualiId = kategori yang sedang diedit. */
    private function namaSudahAda($nama, $kecualiId = null)
    {
        foreach (Kategori::all() as $k) {
            if ($kecualiId !== null && $k->id_kategori == $kecualiId) {
                continue;
            }
            if (strtolower(trim($k->nama_kategori)) === strtolower(trim($nama))) {
                return true;
            }
        }
        return false;
    }
}