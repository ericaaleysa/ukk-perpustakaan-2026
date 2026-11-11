-- create_login_percobaan_table
-- Mencatat percobaan login yang gagal untuk membatasi tebak-tebakan password.

CREATE TABLE IF NOT EXISTS `login_percobaan` (
    id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username   VARCHAR(255) NOT NULL,
    ip_address VARCHAR(45) NULL,
    created_at DATETIME NOT NULL,
    KEY idx_login_username (username),
    KEY idx_login_created (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;