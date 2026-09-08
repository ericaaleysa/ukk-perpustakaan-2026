-- create_kategoris_table

CREATE TABLE IF NOT EXISTS `kategori` (
    id_kategori         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nama_kategori       VARCHAR(100) NOT NULL,
    created_at DATETIME NULL,
    updated_at DATETIME NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
