<?php

namespace App\Controllers\Core;

use App\Models\Role;
use App\Models\User;
use App\Models\LogAktivitas;
use Sakuci\Controller;
use Sakuci\Http\Request;

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
 
        return view('core.admin.users.index', [
            'users' => $users,
            'roles' => Role::orderBy('name')->get(),
            'urut'  => $urut,
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
 
}