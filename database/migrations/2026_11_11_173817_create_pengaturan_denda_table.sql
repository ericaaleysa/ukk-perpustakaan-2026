-- create_pengaturan_denda_table
-- Tarif denda (telat per hari & nominal per kondisi buku) disimpan di database.

CREATE TABLE IF NOT EXISTS `pengaturan_denda` (
    id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    kode       VARCHAR(30)  NOT NULL UNIQUE,
    label      VARCHAR(100) NOT NULL,
    nominal    INT UNSIGNED NOT NULL DEFAULT 0,
    created_at DATETIME NULL,
    updated_at DATETIME NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `pengaturan_denda` (kode, label, nominal, created_at, updated_at) VALUES
('telat_per_hari', 'Denda telat per hari', 1000,  NOW(), NOW()),
('baik',           'Kondisi baik',         0,     NOW(), NOW()),
('rusak_ringan',   'Kondisi rusak ringan', 5000,  NOW(), NOW()),
('rusak_berat',    'Kondisi rusak berat',  25000, NOW(), NOW()),
('hilang',         'Buku hilang',          50000, NOW(), NOW());