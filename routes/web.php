<?php

use App\Controllers\Core\AuthController;
use App\Controllers\Core\DashboardController;
use App\Controllers\Core\DatabaseController;
use App\Controllers\Core\DocsController;
use App\Controllers\Core\RoleController;
use App\Controllers\Core\UserController;
use App\Controllers\KategoriController;
use App\Controllers\DataBukuController;
use App\Controllers\PengajuanKeanggotaanController;
use App\Controllers\AnggotaController;
use App\Controllers\PeminjamanController;
use Sakuci\Route;

/*
|--------------------------------------------------------------------------
| Route Web
|--------------------------------------------------------------------------
| Daftarkan seluruh route aplikasi di sini.
|
| Cara menulis action:
|   [HomeController::class, 'index']   -> disarankan
|   'HomeController@index'             -> namespace App\Controllers otomatis
|   function () { ... }                -> closure
*/

Route::get('/', [DataBukuController::class, 'beranda'])->name('home');

Route::get('/kategori/{id_kategori}', [DataBukuController::class, 'byKategori'])->name('kategori.show');

Route::get('/docs', [DocsController::class, 'index'])->name('docs');

/*
|--------------------------------------------------------------------------
| Login multi-role
|--------------------------------------------------------------------------
| Lihat /docs untuk penjelasan lengkap langkah demi langkah.
*/

Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->name('login.attempt')->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register')->middleware('guest');
Route::post('/register', [AuthController::class, 'register'])->name('register.attempt')->middleware('guest');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

Route::get('/keanggotaan/ajukan', [PengajuanKeanggotaanController::class, 'create'])->name('keanggotaan.create')->middleware('auth');
Route::post('/keanggotaan/ajukan', [PengajuanKeanggotaanController::class, 'store'])->name('keanggotaan.store')->middleware('auth');

Route::get('/peminjaman/ajukan', [PeminjamanController::class, 'create'])->name('peminjaman.create')->middleware('auth');
Route::post('/peminjaman/ajukan', [PeminjamanController::class, 'store'])->name('peminjaman.store')->middleware('auth');
Route::get('/peminjaman/riwayat', [PeminjamanController::class, 'riwayat'])->name('peminjaman.riwayat')->middleware('auth');


Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {
    Route::get('/', [DashboardController::class, 'admin'])->name('admin.dashboard');

    Route::get('/roles', [RoleController::class, 'index'])->name('admin.roles.index');
    Route::post('/roles', [RoleController::class, 'store'])->name('admin.roles.store');
    Route::put('/roles/{role}', [RoleController::class, 'update'])->name('admin.roles.update');
    Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->name('admin.roles.destroy');

    Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::post('/users', [UserController::class, 'store'])->name('admin.users.store');

    Route::get('/database/export', [DatabaseController::class, 'export'])->name('admin.database.export');

    //Kategori
    Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
    Route::get('/kategori/create', [KategoriController::class, 'create'])->name('kategori.create');
    Route::post('/kategori', [KategoriController::class, 'store'])->name('kategori.store');
    Route::get('/kategori/{id_kategori}/edit', [KategoriController::class, 'edit'])->name('kategori.edit');
    Route::put('/kategori/{id_kategori}', [KategoriController::class, 'update'])->name('kategori.update');
    Route::delete('/kategori/{id_kategori}', [KategoriController::class, 'destroy'])->name('kategori.destroy');

    //Data Buku disini
    Route::get('/data_buku', [DataBukuController::class, 'index'])->name('data_buku.index');
    Route::get('/data_buku/create', [DataBukuController::class, 'create'])->name('data_buku.create');
    Route::post('/data_buku', [DataBukuController::class, 'store'])->name('data_buku.store');
    Route::get('data_buku/{id_buku}/edit', [DataBukuController::class, 'edit'])->name('data_buku.edit');
    Route::put('data_buku/{id_buku}', [DataBukuController::class, 'update'])->name('data_buku.update');
    Route::delete('data_buku/{id_buku}', [DataBukuController::class, 'destroy'])->name('data_buku.destroy');

    Route::get('/keanggotaan', [PengajuanKeanggotaanController::class, 'index'])->name('keanggotaan.index');
    Route::put('/keanggotaan/{id_pengajuan}/setujui', [PengajuanKeanggotaanController::class, 'approve'])->name('keanggotaan.approve');
    Route::put('/keanggotaan/{id_pengajuan}/tolak', [PengajuanKeanggotaanController::class, 'reject'])->name('keanggotaan.reject');

    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::put('/peminjaman/{id_peminjaman}/setujui', [PeminjamanController::class, 'approve'])->name('peminjaman.setujui');
    Route::put('/peminjaman/{id_peminjaman}/tolak', [PeminjamanController::class, 'reject'])->name('peminjaman.tolak');
    Route::put('/peminjaman/{id_peminjaman}/kembali', [PeminjamanController::class, 'konfirmasiKembali'])->name('peminjaman.kembali');

});

/*
|--------------------------------------------------------------------------
| Route role dinamis
|--------------------------------------------------------------------------
| Blok di bawah ini dikelola otomatis oleh RoleController saat admin
| menambah, mengganti nama, atau menghapus role lewat /admin/roles.
| Jangan diedit manual -- perubahan bisa tertimpa.
*/
// @generated-roles:start

// @role:siswa:start
Route::group(['prefix' => 'siswa', 'middleware' => 'siswa'], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('siswa.dashboard');
});
// @role:siswa:end
// @generated-roles:end

/*
|--------------------------------------------------------------------------
| Contoh (hapus/ubah sesuai kebutuhan)
|--------------------------------------------------------------------------
|
| use App\Controllers\BukuController;
|
| Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');
|
| // Tujuh route CRUD sekaligus: index, create, store, show, edit, update, destroy
| // Route::resource
|
| // Group dengan prefix dan middleware bersama
| Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {
|     Route::get('/dashboard', [DashboardController::class, 'index']);
| });
*/

