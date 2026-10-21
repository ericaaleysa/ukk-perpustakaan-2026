<?php

namespace App\Models;

use Sakuci\Database\Connection;

/**
 * Pencatat & pembaca log aktivitas.
 *
 * Mencatat : LogAktivitas::catat('buku', 'Menambahkan buku "Laskar Pelangi"');
 * Membaca  : LogAktivitas::cari($filter, $halaman, $perHalaman);
 */
class LogAktivitas
{
    /** kode kategori => label yang tampil di halaman log */
    public const KATEGORI = [
        'akun'        => 'Akun',
        'keanggotaan' => 'Keanggotaan',
        'anggota'     => 'Anggota',
        'kategori'    => 'Kategori',
        'buku'        => 'Buku',
        'peminjaman'  => 'Peminjaman',
        'denda'       => 'Denda',
        'user'        => 'User',
        'role'        => 'Role',
        'sistem'      => 'Sistem',
    ];

    /**
     * Simpan satu baris log.
     * $pelaku  : user yang melakukan; kalau kosong dipakai user yang sedang login.
     * Kegagalan mencatat TIDAK boleh merusak aksi utama, jadi error sengaja ditelan.
     */
    public static function catat(string $kategori, string $deskripsi, $pelaku = null): void
    {
        try {
            if ($pelaku === null) {
                $pelaku = User::current();
            }

            if (function_exists('mb_substr')) {
                $deskripsi = mb_substr($deskripsi, 0, 500);
            } else {
                $deskripsi = substr($deskripsi, 0, 500);
            }

            $stmt = Connection::pdo()->prepare(
                'INSERT INTO log_aktivitas (id_user, username, role, kategori, deskripsi, ip_address, created_at)
                 VALUES (?, ?, ?, ?, ?, ?, ?)'
            );
            $stmt->execute([
                $pelaku ? $pelaku->id : null,
                $pelaku ? $pelaku->username : null,
                $pelaku ? $pelaku->role : null,
                $kategori,
                $deskripsi,
                $_SERVER['REMOTE_ADDR'] ?? null,
                date('Y-m-d H:i:s'),
            ]);
        } catch (\Throwable $e) {
            // sengaja kosong
        }
    }

    /**
     * Ambil log dengan filter + paginasi.
     * $filter: q, kategori, tanggal_dari, tanggal_sampai
     */
    public static function cari(array $filter, int $halaman, int $perHalaman): array
    {
        try {
            $where  = [];
            $params = [];

            if ($filter['kategori'] !== '' && isset(self::KATEGORI[$filter['kategori']])) {
                $where[]  = 'kategori = ?';
                $params[] = $filter['kategori'];
            }
            if ($filter['q'] !== '') {
                $where[]  = '(deskripsi LIKE ? OR username LIKE ?)';
                $params[] = '%' . $filter['q'] . '%';
                $params[] = '%' . $filter['q'] . '%';
            }
            if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $filter['tanggal_dari'])) {
                $where[]  = 'created_at >= ?';
                $params[] = $filter['tanggal_dari'] . ' 00:00:00';
            }
            if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $filter['tanggal_sampai'])) {
                $where[]  = 'created_at <= ?';
                $params[] = $filter['tanggal_sampai'] . ' 23:59:59';
            }
            $sql = $where ? ' WHERE ' . implode(' AND ', $where) : '';

            $pdo = Connection::pdo();

            $stmt = $pdo->prepare('SELECT COUNT(*) FROM log_aktivitas' . $sql);
            $stmt->execute($params);
            $total = (int) $stmt->fetchColumn();

            $totalHalaman = max(1, (int) ceil($total / $perHalaman));
            $halaman      = min(max(1, $halaman), $totalHalaman);
            $offset       = ($halaman - 1) * $perHalaman;

            $stmt = $pdo->prepare(
                'SELECT * FROM log_aktivitas' . $sql .
                ' ORDER BY id_log DESC LIMIT ' . (int) $perHalaman . ' OFFSET ' . (int) $offset
            );
            $stmt->execute($params);

            return [
                'data'         => $stmt->fetchAll(\PDO::FETCH_ASSOC),
                'total'        => $total,
                'halaman'      => $halaman,
                'totalHalaman' => $totalHalaman,
                'galat'        => false,
            ];
        } catch (\Throwable $e) {
            // biasanya: tabel log_aktivitas belum dibuat
            return ['data' => [], 'total' => 0, 'halaman' => 1, 'totalHalaman' => 1, 'galat' => true];
        }
    }
}