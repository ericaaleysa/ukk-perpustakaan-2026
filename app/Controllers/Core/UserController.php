<?php

namespace App\Controllers\Core;

use App\Models\Role;
use App\Models\User;
use App\Models\LogAktivitas;
use Sakuci\Controller;
use Sakuci\Mail\Mailer;
use Sakuci\Http\Request;
use App\Models\Peminjaman;

/** Halaman admin untuk menambah user dan menentukan role-nya. */
class UserController extends Controller
{
    /* Ini sengaja dibuat biar user.index rapih (ngurut pake filter) */
    public function index(Request $request)
    {
        $urut = $request->urut ?? 'role';
        if (! in_array($urut, ['role', 'terbaru', 'alfabet'], true)) {
            $urut = 'role';
        }
 
        $users = User::all();
        if (! is_array($users)) {
            $users = iterator_to_array($users, false);
        }
 
        usort($users, function ($a, $b) use ($urut) {
            if ($urut === 'terbaru') {
                return $b->id <=> $a->id;              // id terbesar = paling baru dibuat
            }
 
            if ($urut === 'alfabet') {
                return strcasecmp($a->username, $b->username);
            }
 
            // urut 'role': admin selalu paling atas, role lain A-Z, lalu nama A-Z
            $roleA = $a->role === 'admin' ? 0 : 1;
            $roleB = $b->role === 'admin' ? 0 : 1;
            if ($roleA !== $roleB) {
                return $roleA <=> $roleB;
            }
 
            $banding = strcasecmp($a->role, $b->role);
            return $banding !== 0 ? $banding : strcasecmp($a->username, $b->username);
        });

        $menunggu = array_values(array_filter($users, fn ($u) => ($u->status_akun ?? 'aktif') === 'menunggu'));
        $users    = array_values(array_filter($users, fn ($u) => ($u->status_akun ?? 'aktif') !== 'menunggu'));

        return view('core.admin.users.index', [
            'users' => $users,
            'roles' => Role::orderBy('name')->get(),
            'urut'  => $urut,
            'menunggu' => $menunggu,
        ]);
    }
 

    public function store(Request $request)
    {
        $data = $request->validate([
            'username' => 'required|min:3|max:50|alpha_dash|unique:users,username',
            'password' => 'required|min:6',
            'role'     => 'required|exists:roles,name',
        ]);

        User::create([
            'username' => $data['username'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'role'     => $data['role'],
        ]);

        LogAktivitas::catat('user', 'Menambahkan user "' . $data['username'] . '" dengan role ' . $data['role']);

        return back()->with('success', 'User "' . $data['username'] . '" berhasil ditambahkan.');
    }

    /*ini buat hapus user yas*/
    public function destroy($id_user)
    {
        $user    = User::findOrFail($id_user);
        $current = User::current();
 
        // Admin tidak boleh menghapus akunnya sendiri
        if ($current && $user->id == $current->id) {
            return redirect()->route('admin.users.index')->with('error', 'Akun yang sedang kamu pakai tidak bisa dihapus.');
        }
 
        // Selalu sisakan minimal satu admin
        if ($user->role === 'admin' && User::where('role', 'admin')->count() <= 1) {
            return redirect()->route('admin.users.index')->with('error', 'Admin terakhir tidak bisa dihapus.');
        }

        // Tidak boleh dihapus selama masih punya transaksi berlangsung (stok buku bisa bocor)
        $transaksiAktif = Peminjaman::where('id_user', $user->id)
            ->whereIn('status', ['menunggu_konfirmasi', 'dipinjam'])
            ->count();

        if ($transaksiAktif > 0) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Akun "' . $user->username . '" tidak bisa dihapus karena masih punya ' . $transaksiAktif . ' transaksi peminjaman berlangsung.');
        }
 
        $username = $user->username;
        $roleUser = $user->role;
        $user->delete();

        LogAktivitas::catat('user', 'Menghapus akun "' . $username . '" (role ' . $roleUser . ')');
 
        return redirect()->route('admin.users.index')->with('success', 'Akun "' . $username . '" berhasil dihapus.');
    }

    /* ini buat edit nama yas*/
    public function update(Request $request, $id_user)
    {
        $current = User::current();
        $user    = User::findOrFail($id_user);
 
        // Hanya boleh mengubah akun milik sendiri. Akun admin lain (atau akun siapa pun) ditolak.
        if (! $current || $user->id != $current->id) {
            abort(403, 'Kamu hanya bisa mengubah username akunmu sendiri.');
        }
 
        $data = $request->validate([
            'new_username' => 'required|min:3|max:50|alpha_dash',
        ]);
 
        $baru = $data['new_username'];
 
        // Cek username kembar secara manual (supaya username lama sendiri tidak dianggap kembar)
        if ($baru !== $user->username && User::firstWhere('username', $baru)) {
            return back()
                ->withErrors(['new_username' => 'Username "' . $baru . '" sudah dipakai.'])
                ->withInput();
        }
 
        $lama = $user->username;
        $user->update(['username' => $baru]);

        LogAktivitas::catat('user', 'Mengubah username dari "' . $lama . '" menjadi "' . $baru . '"');
 
        return redirect()->route('admin.users.index')->with('success', 'Username berhasil diubah menjadi "' . $baru . '".');
    }

    /* setujui akun hasil register mandiri */
    public function setujui($id_user)
    {
        $user = User::findOrFail($id_user);

        if (($user->status_akun ?? 'aktif') !== 'menunggu') {
            return redirect()->route('admin.users.index')->with('error', 'Akun ini tidak sedang menunggu persetujuan.');
        }

        $user->update(['status_akun' => 'aktif']);

        LogAktivitas::catat('user', 'Menyetujui pendaftaran akun "' . $user->username . '" (role ' . $user->role . ')');

        $pesan = 'Akun "' . $user->username . '" disetujui dan sekarang bisa login.';

        // Email gagal terkirim tidak boleh membatalkan persetujuan; admin cukup diberi tahu.
        if (empty($user->email)) {
            return redirect()->route('admin.users.index')
                ->with('success', $pesan . ' (Akun ini belum punya email, jadi notifikasi tidak dikirim.)');
        }

        if ($this->kirimEmailDisetujui($user)) {
            LogAktivitas::catat('user', 'Mengirim email persetujuan akun ke "' . $user->username . '"');

            return redirect()->route('admin.users.index')
                ->with('success', $pesan . ' Notifikasi email sudah dikirim ke ' . $user->email . '.');
        }

        LogAktivitas::catat('user', 'Email persetujuan akun "' . $user->username . '" gagal terkirim');

        return redirect()->route('admin.users.index')
            ->with('error', $pesan . ' Namun email notifikasi ke ' . $user->email . ' gagal dikirim. Periksa pengaturan MAIL_* di .env.');
    }

    /** Kirim email "akun disetujui" ke pendaftar. */
    protected function kirimEmailDisetujui(User $user): bool
    {
        $app   = (string) config('app.name', 'NEXLIB');
        $nama  = htmlspecialchars((string) $user->username, ENT_QUOTES, 'UTF-8');
        $login = url('/login');

        $html = '<div style="font-family:Arial,Helvetica,sans-serif;font-size:15px;line-height:1.6;color:#222">'
            . '<p>Halo <strong>' . $nama . '</strong>,</p>'
            . '<p>Kabar baik! Pendaftaran akunmu di <strong>' . htmlspecialchars($app, ENT_QUOTES, 'UTF-8') . '</strong> '
            . 'telah <strong>disetujui</strong> oleh admin. Sekarang kamu sudah bisa masuk menggunakan username dan password yang kamu daftarkan.</p>'
            . '<p><a href="' . htmlspecialchars($login, ENT_QUOTES, 'UTF-8') . '" '
            . 'style="display:inline-block;padding:10px 20px;background:#4f46e5;color:#fff;text-decoration:none;border-radius:6px">Masuk sekarang</a></p>'
            . '<p style="color:#666;font-size:13px">Atau buka tautan ini: ' . htmlspecialchars($login, ENT_QUOTES, 'UTF-8') . '</p>'
            . '<p style="color:#666;font-size:13px">Jika kamu tidak merasa mendaftar, abaikan email ini.</p>'
            . '</div>';

        $teks = "Halo {$user->username},\n\n"
            . "Pendaftaran akunmu di {$app} telah disetujui oleh admin. "
            . "Sekarang kamu bisa masuk dengan username dan password yang kamu daftarkan.\n\n"
            . "Masuk: {$login}\n\n"
            . "Jika kamu tidak merasa mendaftar, abaikan email ini.";

        return Mailer::send((string) $user->email, 'Akunmu di ' . $app . ' sudah disetujui', $html, $teks);
    }

    /* tolak pendaftaran: akun dihapus supaya username bisa dipakai lagi */
    public function tolak($id_user)
    {
        $user = User::findOrFail($id_user);

        if (($user->status_akun ?? 'aktif') !== 'menunggu') {
            return redirect()->route('admin.users.index')->with('error', 'Hanya akun yang menunggu persetujuan yang bisa ditolak.');
        }

        $username = $user->username;
        $user->delete();

        LogAktivitas::catat('user', 'Menolak pendaftaran akun "' . $username . '"');

        return redirect()->route('admin.users.index')->with('success', 'Pendaftaran akun "' . $username . '" ditolak.');
    }
    
}