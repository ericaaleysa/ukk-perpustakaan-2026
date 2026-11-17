-- add_email_to_users_table
-- Email dipakai untuk mengirim notifikasi saat akun disetujui admin.
-- Kolom boleh NULL karena akun lama belum punya email, dan UNIQUE tetap menerima banyak NULL.

ALTER TABLE `users` ADD COLUMN email VARCHAR(255) NULL AFTER username;

ALTER TABLE `users` ADD UNIQUE KEY users_email_unique (email);