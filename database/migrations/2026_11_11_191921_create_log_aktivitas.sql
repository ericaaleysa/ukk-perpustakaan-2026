-- create_log_aktivitas_table

CREATE TABLE IF NOT EXISTS `log_aktivitas` (
    id_log      INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_user     INT UNSIGNED NULL,
    username    VARCHAR(50) NULL,
    role        VARCHAR(50) NULL,
    kategori    VARCHAR(30) NOT NULL,
    deskripsi   VARCHAR(500) NOT NULL,
    ip_address  VARCHAR(45) NULL,
    created_at  DATETIME NOT NULL,
    KEY idx_log_created (created_at),
    KEY idx_log_kategori (kategori)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;