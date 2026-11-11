-- add_status_akun_to_users_table
-- Akun hasil register mandiri berstatus 'menunggu' sampai disetujui admin.

ALTER TABLE `users` ADD COLUMN status_akun ENUM('aktif', 'menunggu') NOT NULL DEFAULT 'aktif' AFTER role;