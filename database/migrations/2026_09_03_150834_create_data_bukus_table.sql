-- create_data_bukus_table

CREATE TABLE IF NOT EXISTS `data_buku` (
    id_buku         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    judul_buku       VARCHAR(255) NOT NULL,
    pengarang    VARCHAR(255) NOT NULL,
    penerbit    VARCHAR(255) NOT NULL,
    tahun_terbit    YEAR NOT NULL,
    kategori_buku    ENUM('Pelajaran Utama', 'Pelajaran Jurusan', 'Kamus', 'Latihan Soal', 'Karya Fiksi') NOT NULL,
    created_at DATETIME NULL,
    updated_at DATETIME NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
