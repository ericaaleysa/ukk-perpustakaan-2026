<?php

namespace App\Controllers;

use Sakuci\Controller;
use Sakuci\Http\Request;
use App\Models\DataBuku;
use App\Models\Kategori;
use App\Models\User;

class DataBukuController extends Controller
{
    public function beranda(Request $request) //halaman sambutan (khusus tamu)
    {
        // Pengguna yang sudah login langsung diarahkan ke dashboard sesuai role-nya
        $user = User::current();
        if ($user) {
            return redirect()->route($user->role === 'admin' ? 'admin.dashboard' : 'dashboard');
        }

        return view('welcome');
    }

    public function cari(Request $request) //halaman pencarian buku (pengguna/siswa)
    {
        $user = User::current();
        if ($user && $user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        $keyword = trim((string) ($request->q ?? ''));
        $id_kategori = $request->id_kategori ?? null;
        if ($id_kategori === '') {
            $id_kategori = null;
        }

        $daftarKategori = Kategori::orderBy('nama_kategori', 'asc')->get();
        $semuaBuku = DataBuku::orderBy('judul_buku', 'asc')->get();

        // Filter: kategori + kata kunci (judul / pengarang / penerbit)
        $hasil = [];
        foreach ($semuaBuku as $b) {
            if ($id_kategori && $b->id_kategori != $id_kategori) {
                continue;
            }
            if ($keyword !== '') {
                $cocok = stripos($b->judul_buku, $keyword) !== false
                    || stripos($b->pengarang, $keyword) !== false
                    || stripos($b->penerbit, $keyword) !== false;
                if (!$cocok) {
                    continue;
                }
            }
            $hasil[] = $b;
        }

        // Kelompokkan hasil per kategori (urut nama kategori), buku tanpa kategori di akhir
        $kelompok = [];
        foreach ($daftarKategori as $kat) {
            $buku = [];
            foreach ($hasil as $b) {
                if ($b->id_kategori == $kat->id_kategori) {
                    $buku[] = $b;
                }
            }
            if (count($buku) > 0) {
                $kelompok[] = ['id' => $kat->id_kategori, 'nama' => $kat->nama_kategori, 'buku' => $buku];
            }
        }

        $tanpaKategori = [];
        foreach ($hasil as $b) {
            if (empty($b->id_kategori)) {
                $tanpaKategori[] = $b;
            }
        }
        if (count($tanpaKategori) > 0) {
            $kelompok[] = ['id' => 'lain', 'nama' => 'Tanpa Kategori', 'buku' => $tanpaKategori];
        }

        return view('data_buku.cari', [
            'keyword' => $keyword,
            'id_kategori' => $id_kategori,
            'daftarKategori' => $daftarKategori,
            'kelompok' => $kelompok,
            'totalBuku' => count($hasil),
            'sedangMencari' => ($keyword !== '' || $id_kategori),
        ]);
    }

    public function byKategori($id_kategori) //halaman buku per kategori
    {
        $kategori = Kategori::findOrFail($id_kategori);
        $data_buku = DataBuku::where('id_kategori', $id_kategori)->orderBy('id_buku', 'desc')->get();
        return view('data_buku.by_kategori', compact('kategori', 'data_buku'));
    }

    public function index(Request $request)
    {
        $id_kategori = $request->id_kategori ?? null;

        if ($id_kategori) {
            $data_buku = DataBuku::where('id_kategori', $id_kategori)->orderBy('id_buku', 'desc')->paginate(5);
        } else {
            $data_buku = DataBuku::orderBy('id_buku', 'desc')->paginate(5);
        }

        $daftarKategori = Kategori::all();

        return view('data_buku.index', compact('data_buku', 'daftarKategori', 'id_kategori'));
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

        //sampul diunggah sebagai file (opsional)
        [$thumbnail, $error] = $this->uploadThumbnail();
        if ($error) {
            return redirect()->route('data_buku.create')->with('error', $error);
        }
        $validatedData['thumbnail'] = $thumbnail;

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

        [$thumbnailBaru, $error] = $this->uploadThumbnail();
        if ($error) {
            return redirect()->route('data_buku.edit', [$id_buku])->with('error', $error);
        }

        $thumbnail = $data_buku->thumbnail;
        if ($thumbnailBaru) {
            //ganti sampul: hapus file lama kalau berasal dari upload
            $this->hapusThumbnailLokal($thumbnail);
            $thumbnail = $thumbnailBaru;
        } elseif ($request->hapus_thumbnail) {
            $this->hapusThumbnailLokal($thumbnail);
            $thumbnail = null;
        }

        $data_buku->update([
            'id_kategori' => $request->id_kategori,
            'judul_buku' => $request->judul_buku,
            'pengarang' => $request->pengarang,
            'penerbit' => $request->penerbit,
            'tahun_terbit' => $request->tahun_terbit,
            'thumbnail' => $thumbnail,
        ]);

        return redirect()->route('data_buku.index')->with('success', 'Data Buku berhasil diperbarui.');
    }

    public function destroy(Request $request, $id_buku) //bagian hapus
    {
        $data_buku = DataBuku::findOrFail($id_buku);
        $this->hapusThumbnailLokal($data_buku->thumbnail);
        $data_buku->delete();

        return redirect()->route('data_buku.index')->with('success', 'Buku berhasil dihapus.');
    }

    /**
     * Simpan file sampul dari $_FILES['thumbnail'] ke public/uploads/buku.
     * Mengembalikan [path, pesanError]. Path berupa "/uploads/buku/nama.jpg".
     * Kalau tidak ada file yang dipilih, hasilnya [null, null].
     */
    private function uploadThumbnail()
    {
        if (!isset($_FILES['thumbnail']) || $_FILES['thumbnail']['error'] === UPLOAD_ERR_NO_FILE) {
            return [null, null];
        }

        $file = $_FILES['thumbnail'];

        if ($file['error'] === UPLOAD_ERR_INI_SIZE || $file['error'] === UPLOAD_ERR_FORM_SIZE || $file['size'] > 2 * 1024 * 1024) {
            return [null, 'Ukuran sampul maksimal 2 MB.'];
        }
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return [null, 'Upload sampul gagal. Coba lagi.'];
        }

        //cek isi file yang sebenarnya, bukan ekstensi bawaan nama file
        $info = @getimagesize($file['tmp_name']);
        $izin = [IMAGETYPE_JPEG => 'jpg', IMAGETYPE_PNG => 'png', IMAGETYPE_WEBP => 'webp'];
        if (!$info || !isset($izin[$info[2]])) {
            return [null, 'Sampul harus berupa gambar JPG, PNG, atau WEBP.'];
        }

        $folder = rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . '/uploads/buku';
        if (!is_dir($folder) && !mkdir($folder, 0755, true)) {
            return [null, 'Folder penyimpanan sampul tidak bisa dibuat.'];
        }

        $nama = 'buku_' . bin2hex(random_bytes(8)) . '.' . $izin[$info[2]];
        if (!move_uploaded_file($file['tmp_name'], $folder . '/' . $nama)) {
            return [null, 'Sampul gagal disimpan.'];
        }

        return ['/uploads/buku/' . $nama, null];
    }

    /** Hapus file sampul hasil upload (URL luar tidak disentuh). */
    private function hapusThumbnailLokal($path)
    {
        if ($path && strpos($path, '/uploads/buku/') === 0) {
            $file = rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . '/uploads/buku/' . basename($path);
            if (is_file($file)) {
                @unlink($file);
            }
        }
    }

}