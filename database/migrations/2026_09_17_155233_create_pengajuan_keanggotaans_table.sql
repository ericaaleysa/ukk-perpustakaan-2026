-- create_pengajuan_keanggotaan_table

CREATE TABLE IF NOT EXISTS `pengajuan_keanggotaan` (
    id_pengajuan        INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_user             INT UNSIGNED NOT NULL,
    nama_lengkap        VARCHAR(255) NOT NULL,
    nis                 VARCHAR(50) NOT NULL,
    kelas               VARCHAR(50) NOT NULL,
    status              ENUM('menunggu', 'disetujui', 'ditolak') NOT NULL DEFAULT 'menunggu',
    catatan_admin       TEXT NULL,
    tanggal_pengajuan   DATETIME NOT NULL,
    tanggal_verifikasi  DATETIME NULL,
    diverifikasi_oleh   INT UNSIGNED NULL,
    created_at          DATETIME NULL,
    updated_at          DATETIME NULL,
    CONSTRAINT fk_pengajuan_user
        FOREIGN KEY (id_user) REFERENCES users(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    CONSTRAINT fk_pengajuan_verifikator
        FOREIGN KEY (diverifikasi_oleh) REFERENCES users(id)
        ON DELETE SET NULL
        ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;