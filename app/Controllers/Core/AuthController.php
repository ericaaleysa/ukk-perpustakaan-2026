<?php

namespace App\Controllers\Core;

use App\Models\LogAktivitas;
use App\Models\Role;
use App\Models\User;
use Sakuci\Controller;
use Sakuci\Database\Connection;
use Sakuci\Http\Request;
use Sakuci\Session;

class AuthController extends Controller
{
    /** Login dikunci sementara setelah sekian kali gagal (per username + IP). */
    protected const MAKS_GAGAL = 5;
    protected const JEDA_MENIT = 15;

    public function showLogin()
    {
        return view('core.auth.login');
    }

    public function showRegister()
    {
        $roles = Role::where('can_register', 1)->orderBy('name')->get();

        if ($roles === []) {
            return redirect('/login')->with('error', 'Pendaftaran belum dibuka.');
        }

        return view('core.auth.register', ['roles' => $roles]);
    }

    public function register(Request $request)
    {
        $allowed = Role::where('can_register', 1)->pluck('name');

        if ($allowed === []) {
            return redirect('/login')->with('error', 'Pendaftaran belum dibuka.');
        }

        $data = $request->validate([
            'username' => 'required|min:3|max:50|alpha_dash|unique:users,username',
            'password' => 'required|min:6|confirmed',
            'role'     => 'required|in:' . implode(',', $allowed),
        ]);

        $user = User::create([
            'username'    => $data['username'],
            'password'    => password_hash($data['password'], PASSWORD_DEFAULT),
            'role'        => $data['role'],
            'status_akun' => 'menunggu',
        ]);

        LogAktivitas::catat('akun', 'Mendaftar akun baru "' . $user->username . '" (menunggu persetujuan admin)', $user);

        // Tidak langsung login: tunggu persetujuan admin
        return redirect('/login')->with('success', 'Pendaftaran berhasil. Akunmu menunggu persetujuan admin, kamu bisa login setelah disetujui.');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $ip = $request->ip();

        if ($this->terkunci($data['username'], $ip)) {
            return back()
                ->withErrors(['username' => 'Terlalu banyak percobaan login yang gagal. Coba lagi dalam ' . self::JEDA_MENIT . ' menit.'])
                ->withInput(['username' => $data['username']]);
        }

        $user = User::firstWhere('username', $data['username']);

        if (! $user || ! password_verify($data['password'], $user->password)) {
            $this->catatGagal($data['username'], $ip);

            // withInput hanya membawa username (jangan menyimpan password di session)
            return back()
                ->withErrors(['username' => 'Username atau password salah.'])
                ->withInput(['username' => $data['username']]);
        }

        if (($user->status_akun ?? 'aktif') === 'menunggu') {
            return back()
                ->withErrors(['username' => 'Akun kamu masih menunggu persetujuan admin.'])
                ->withInput(['username' => $data['username']]);
        }

        $this->bersihkanGagal($data['username']);

        // Cegah session fixation: ganti ID session & token CSRF setelah login berhasil
        session_regenerate_id(true);
        Session::put('_token', bin2hex(random_bytes(32)));
        Session::put('user_id', $user->id);

        return redirect($user->role === 'admin' ? '/admin' : '/dashboard')
            ->with('success', 'Selamat datang, ' . $user->username . '.');
    }

    public function logout()
    {
        Session::forget('user_id');

        session_regenerate_id(true);
        Session::put('_token', bin2hex(random_bytes(32)));

        return redirect('/login')->with('success', 'Berhasil logout.');
    }

    /*
    |----------------------------------------------------------------------
    | Pembatasan percobaan login
    |----------------------------------------------------------------------
    | Kegagalan mencatat tidak boleh merusak proses login, jadi semua error
    | database di bagian ini sengaja ditelan.
    */

    protected function terkunci(string $username, string $ip): bool
    {
        try {
            $batas = date('Y-m-d H:i:s', time() - self::JEDA_MENIT * 60);
            $row = Connection::selectOne(
                'SELECT COUNT(*) AS total FROM login_percobaan WHERE created_at >= ? AND username = ? AND ip_address = ?',
                [$batas, $username, $ip]
            );

            return (int) ($row['total'] ?? 0) >= self::MAKS_GAGAL;
        } catch (\Throwable $e) {
            return false;
        }
    }

    protected function catatGagal(string $username, string $ip): void
    {
        try {
            Connection::statement(
                'INSERT INTO login_percobaan (username, ip_address, created_at) VALUES (?, ?, ?)',
                [$username, $ip, date('Y-m-d H:i:s')]
            );
        } catch (\Throwable $e) {
            // sengaja kosong
        }
    }

    protected function bersihkanGagal(string $username): void
    {
        try {
            Connection::statement('DELETE FROM login_percobaan WHERE username = ?', [$username]);
            Connection::statement(
                'DELETE FROM login_percobaan WHERE created_at < ?',
                [date('Y-m-d H:i:s', time() - 86400)]
            );
        } catch (\Throwable $e) {
            // sengaja kosong
        }
    }
}