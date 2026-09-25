-- create_data_bukus_table

CREATE TABLE IF NOT EXISTS `data_buku` (
    id_buku         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    judul_buku       VARCHAR(255) NOT NULL,
    pengarang    VARCHAR(255) NOT NULL,
    penerbit    VARCHAR(255) NOT NULL,
    tahun_terbit    YEAR NOT NULL,
    created_at DATETIME NULL,
    updated_at DATETIME NULL,
    
    id_kategori INT UNSIGNED,
    CONSTRAINT fk_buku_kategori
    FOREIGN KEY (id_kategori)
    REFERENCES kategori(id_kategori)
    ON DELETE SET NULL
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
