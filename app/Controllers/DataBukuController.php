<?php

namespace App\Controllers;

use Sakuci\Controller;
use Sakuci\Http\Request;
use App\Models\DataBuku;
use App\Models\Kategori;

class DataBukuController extends Controller
{
    public function index(Request $request)
    {
        $data_buku = DataBuku::orderBy('id_buku', 'desc')
        
        ->paginate(5);
        return view('data_buku.index', compact('data_buku'));
    }

    public function create(Request $request)
    {
        $daftarKategori = Kategori::all();
        return view('data_buku.create', compact('daftarKategori'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_kategori' => 'required|integer|exists:kategori,id_kategori',
            'judul_buku' => 'required|string|max:255',
            'pengarang' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'tahun_terbit' => 'required|integer|digits:4',
        ]);

        DataBuku::create($validatedData);

        return redirect()->route('data_buku.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    public function edit($id_buku) //bagian edit
    {
        $data_buku = DataBuku::findOrFail($id_buku);
        $daftarKategori = Kategori::all();
        return view('data_buku.edit', compact('data_buku', 'daftarKategori'));
    }

    public function update(Request $request, $id_buku) //bagian update
    {
        $request->validate([
            'id_kategori' => 'required|integer|exists:kategori,id_kategori',
            'judul_buku' => 'required|string|max:255',
            'pengarang' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'tahun_terbit' => 'required|integer|digits:4',
        ]);

        $data_buku = DataBuku::findOrFail($id_buku);
        $data_buku->update([
            'id_kategori' => $request->id_kategori,
            'judul_buku' => $request->judul_buku,
            'pengarang' => $request->pengarang,
            'penerbit' => $request->penerbit,
            'tahun_terbit' => $request->tahun_terbit,
        ]);

        return redirect()->route('data_buku.index')->with('success', 'Data Buku berhasil diperbarui.');
    }

    public function destroy(Request $request, $id_buku) //bagian hapus
    {
        $data_buku = DataBuku::findOrFail($id_buku);
        $data_buku->delete();

        return redirect()->route('data_buku.index')->with('success', 'Buku berhasil dihapus.');
    }

}
