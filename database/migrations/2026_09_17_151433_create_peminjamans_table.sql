-- create_peminjaman_table

CREATE TABLE IF NOT EXISTS `peminjaman` (
    id_peminjaman           INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_user                 INT UNSIGNED NOT NULL,
    id_buku                 INT UNSIGNED NOT NULL,
    tanggal_pinjam          DATE NOT NULL,
    tanggal_wajib_kembali   DATE NOT NULL,
    tanggal_dikembalikan    DATE NULL,
    status                  ENUM('menunggu_konfirmasi', 'dipinjam', 'ditolak', 'dikembalikan') NOT NULL DEFAULT 'menunggu_konfirmasi',
    denda                   INT UNSIGNED NOT NULL DEFAULT 0,
    catatan_admin           TEXT NULL,
    created_at              DATETIME NULL,
    updated_at              DATETIME NULL,
    CONSTRAINT fk_peminjaman_user
        FOREIGN KEY (id_user) REFERENCES users(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    CONSTRAINT fk_peminjaman_buku
        FOREIGN KEY (id_buku) REFERENCES data_buku(id_buku)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;