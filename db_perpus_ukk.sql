-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 17, 2026 at 10:18 AM
-- Server version: 8.0.35
-- PHP Version: 8.3.36

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_perpus_ukk`
--

-- --------------------------------------------------------

--
-- Table structure for table `data_buku`
--

CREATE TABLE `data_buku` (
  `id_buku` int UNSIGNED NOT NULL,
  `judul_buku` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `pengarang` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `penerbit` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `tahun_terbit` year NOT NULL,
  `sinopsis` text COLLATE utf8mb4_general_ci,
  `thumbnail` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `stok` int UNSIGNED NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `id_kategori` int UNSIGNED DEFAULT NULL,
  `genre` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `data_buku`
--

INSERT INTO `data_buku` (`id_buku`, `judul_buku`, `pengarang`, `penerbit`, `tahun_terbit`, `sinopsis`, `thumbnail`, `stok`, `created_at`, `updated_at`, `id_kategori`, `genre`) VALUES
(1, 'Bahasa Indonesia untuk SMK/MAK Kelas XII', 'Suparman & Sumarlam', 'Yrama Widya', '2021', NULL, '/uploads/buku/buku_6c96ae742e6b29f0.jpg', 35, '2026-09-21 10:52:02', '2026-11-13 19:51:23', 1, NULL),
(2, 'Fisika: Fenomena Gelombang, Kelistrikan, dan Fisika Modern SMK/MAK Kelas XII', 'Kasmina & Toali', 'Erlangga', '2022', NULL, '/uploads/buku/buku_95fc11b8ab0dc14a.jpg', 31, '2026-09-21 10:54:43', '2026-10-21 10:38:27', 1, NULL),
(3, 'Pendidikan Pancasila dan Kewarganegaraan SMK/MAK Kelas X', 'T. May Rudy', 'Erlangga', '2020', NULL, '/uploads/buku/buku_6c7a377762d920fc.jpg', 30, '2026-09-21 10:55:33', '2026-10-21 07:01:27', 1, NULL),
(4, 'Bahasa Inggris: English for Skilled Workers SMK/MAK Kelas XII', 'M. Nur Gholib', 'Yudhistira', '2021', NULL, '/uploads/buku/buku_c13ca0326352cc9b.jpg', 30, '2026-09-21 10:56:31', '2026-10-21 07:02:34', 1, NULL),
(5, 'Sejarah: Perjuangan Mempertahankan Kemerdekaan hingga Indonesia Modern SMK/MAK Kelas XII', 'Ratna Hapsari & M. Adil', 'Erlangga', '2021', NULL, '/uploads/buku/buku_00e17074d9f3f32f.jpg', 30, '2026-09-21 10:57:34', '2026-10-21 06:57:29', 1, NULL),
(6, 'Geografi: Tata Ruang Wilayah, Penginderaan Jauh, dan Interaksi Desa-Kota SMK/MAK Kelas XII ', 'Nelty Khairiyah', 'Yrama Widya', '2022', NULL, '/uploads/buku/buku_468bd036fd728525.jpg', 30, '2026-09-21 10:58:25', '2026-10-21 07:00:56', 1, NULL),
(7, 'Informatika: Sistem Komputasi dan Algoritma Lanjut untuk SMK/MAK Kelas XII', 'Henry Pandia', 'Erlangga', '2022', NULL, '/uploads/buku/buku_a6aae52fe87be7f4.jpg', 30, '2026-09-21 10:58:57', '2026-10-21 06:59:29', 1, NULL),
(8, 'Dasar-Dasar Teknik Otomotif Kelas X', 'Bagus Fatkhur Rahman', 'Kementerian Pendidikan dan Kebudayaan', '2020', NULL, '', 30, '2026-09-21 11:01:12', '2026-11-16 16:02:32', 2, NULL),
(9, 'Dasar-Dasar Teknik Jaringan Komputer dan Telekomunikas', 'Supriyanto', 'Yudhistira', '2020', NULL, '', 1, '2026-09-21 11:01:46', '2026-09-21 11:01:46', 2, NULL),
(10, 'Dasar-Dasar Akuntansi dan Keuangan Lembaga', 'Dwi Priyata', 'Erlangga', '2020', NULL, '', 30, '2026-09-21 11:02:48', '2026-11-16 16:01:27', 2, NULL),
(11, 'Teknik Pemesinan NC/CNC dan CAM Kelas XI', 'Arsel S.', 'Yudhistira', '2020', NULL, '', 1, '2026-09-21 11:03:38', '2026-09-21 11:03:38', 2, NULL),
(12, 'Tata Boga & Kuliner Dasar untuk SMK Kelas X', 'Susi Valentin', 'Yrama Widya', '2022', NULL, '', 30, '2026-09-21 11:04:40', '2026-11-16 16:02:11', 2, NULL),
(13, 'Dasar-Dasar Pengembangan Perangkat Lunak dan Gim ', 'Dorothy L.', 'Graha Ilmu', '2021', NULL, '', 30, '2026-09-21 11:06:15', '2026-11-16 16:01:50', 2, NULL),
(14, 'Dasar-Dasar Administrasi & Kearsipan Kelas X', 'Prill Asmarandana', 'Graha Ilmu', '2020', NULL, '', 29, '2026-09-21 11:07:51', '2026-11-09 17:04:29', 2, NULL),
(15, 'Modul Pratikum Pemrograman Web Dasar (HTML, CSS, JS)', 'Budi Raharjo', 'Informatika Bandung', '2021', NULL, '', 1, '2026-09-21 11:09:23', '2026-09-21 11:09:23', 3, NULL),
(16, 'Modul Pembelajaran Keselamatan dan Kesehatan Kerja (K3LH)', 'Bambang Suhardi', 'UNS Press', '2022', NULL, '', 1, '2026-09-21 11:10:27', '2026-09-21 11:10:27', 3, NULL),
(17, 'Modul Praktis Kewirausahaan dan Bisnis Digital', 'Maya Safitri', 'UNS Press', '2022', NULL, '', 1, '2026-09-21 11:13:21', '2026-09-21 11:13:21', 3, NULL),
(18, 'Modul Aplikasi Perkantoran & Otomatisasi Administrasi', 'Warniati Hassarun', 'Yudhistira', '2021', NULL, '', 1, '2026-09-21 11:19:06', '2026-09-21 11:19:06', 3, NULL),
(19, 'Modul Gambar Teknik Manufaktur dengan Autocad', 'Eko Nurcahyo', 'Takula', '2020', NULL, '', 0, '2026-09-21 11:19:52', '2026-11-13 20:43:01', 3, NULL),
(20, 'Modul Praktikum Kelistrikan Otomotif Dasar', 'Supriyadi', 'Pustaka Pelajar', '2021', NULL, '', 1, '2026-09-21 11:20:17', '2026-09-21 11:20:17', 3, NULL),
(21, 'Modul Panduan Desain Grafis untuk Pemula', 'Kuina B.', 'Takula', '2022', NULL, '', 1, '2026-09-21 11:21:32', '2026-09-21 11:21:32', 3, NULL),
(22, 'Pedoman Umum Ejaan Bahasa Indonesia (PUEBI) Edisi Terbaru', 'Tim Pembina Bahasa', 'Balai Pustaka', '2022', NULL, '', 15, '2026-09-21 11:22:33', '2026-10-21 10:21:23', 4, NULL),
(23, 'Buku Panduan Pertolongan Pertama (First Aid Hand Book)', 'Dr. S. Ahmad', 'Balai Pustaka', '2021', NULL, '', 12, '2026-09-21 11:23:22', '2026-10-21 10:21:42', 4, NULL),
(24, 'Atlas Digital Indonesia dan Dunia', 'Tim Kartogarfi', 'Balai Pustaka', '2022', NULL, '', 15, '2026-09-21 11:24:46', '2026-10-04 21:18:08', 4, NULL),
(25, 'Kamus Istilah Ekonomi dan Bisnis Modern', 'Hendra M.', 'Balai Pustaka', '2020', NULL, '', 9, '2026-09-21 11:25:39', '2026-10-21 10:22:03', 4, NULL),
(27, 'Kimia: Sifat Koligatif, Elektrokimia, dan Senyawa Karbon SMK/MAK Kelas XII', 'Sasha Asmarawati', 'Erlangga', '2021', NULL, '/uploads/buku/buku_852d3f3dae5e4faa.jpg', 31, '2026-09-30 11:27:30', '2026-10-21 10:38:29', 1, NULL),
(28, 'Sosiologi: Perubahan Sosial, Modernisasi, dan Globalisasi SMK/MAK Kelas XII', 'Luis Kurniawan', 'Nuansa Pustaka', '2020', NULL, '/uploads/buku/buku_91276cbc1762dd80.jpg', 30, '2026-09-30 11:29:10', '2026-10-21 06:58:32', 1, NULL),
(29, 'Pendidikan Jasmani, Olahraga dan Kesehatan SMK/MAK Kelas XI', 'Wiluna N.', 'Graha Ilmu', '2022', NULL, '/uploads/buku/buku_2500a338d6064c0b.jpg', 30, '2026-09-30 11:39:49', '2026-10-21 06:58:00', 1, NULL),
(30, 'Chainsaw Man ', 'Tatsuki Fujimoto', 'Shueisha', '2018', 'Denji adalah seorang remaja miskin yang terpaksa menjadi pemburu iblis demi melunasi utang raksasa mendiang ayahnya kepada Yakuza. Ia ditemani oleh Pochita, iblis berbentuk anjing kecil dengan gergaji mesin di kepalanya. Setelah dikhianati dan dibunuh oleh Yakuza, Pochita mengorbankan dirinya dan bersatu dengan jantung Denji. Denji bangkit kembali sebagai Chainsaw Man, manusia setengah iblis, dan direkrut oleh organisasi Pemburu Iblis Keamanan Publik.', '/uploads/buku/buku_0cb21263c86868e0.jpg', 2, '2026-10-20 11:22:28', '2026-10-23 16:59:42', 7, 'Action, Dark Fantasy, Comedy Horror, Gore'),
(31, 'Kimetsu No Yaiba', 'Koyoharu Gotouge', 'Shueisha', '2016', 'Di Jepang era Taisho, Tanjiro Kamado adalah anak laki-laki baik hati yang hidup sederhana dengan menjual arang. Suatu hari, keluarganya dibantai oleh iblis saat ia sedang pergi, dan hanya adiknya, Nezuko, yang selamat namun telah berubah menjadi iblis. Meskipun berubah menjadi iblis, Nezuko masih menunjukkan tanda-tanda emosi manusia. Tanjiro kemudian bergabung dengan Korps Pemburu Iblis untuk mencari obat demi mengembalikan Nezuko menjadi manusia dan membalaskan dendam keluarganya.', '/uploads/buku/buku_33717c89f551cd1e.jpg', 5, '2026-10-20 11:23:54', '2026-11-11 21:43:35', 7, 'Action, Dark Fantasy, Historical, Supernatural'),
(32, 'Jujutsu Kaisen', 'Gege Akutami', 'Shueisha', '2018', 'Yuji Itadori adalah seorang siswa SMA dengan kemampuan fisik luar biasa yang tidak sengaja terlibat dengan Klub Penelitian Gaib di sekolahnya. Untuk menyelamatkan teman-temannya dari serangan kutukan (makhluk gaib manifestasi emosi negatif manusia), Yuji menelan benda kutukan tingkat tinggi: jari kering milik Ryomen Sukuna, Raja Kutukan. Yuji menjadi wadah bagi Sukuna dan dipaksa masuk ke sekolah Penyihir Jujutsu demi mengumpulkan sisa jari Sukuna sebelum ia dieksekusi.', '/uploads/buku/buku_49b25fefc223797f.jpg', 10, '2026-10-20 11:24:44', '2026-11-11 21:43:25', 7, 'Action, Dark Fantasy, Supernatural'),
(33, 'Attack on Titan', 'Hajime Isayama', 'Kodansha', '2009', 'Manusia hidup terkurung di dalam tiga lapis tembok raksasa untuk melindungi diri dari Titan, makhluk raksasa pemakan manusia. Kedamaian selama seratus tahun hancur ketika seekor Titan Kolosal menghancurkan tembok terluar. Setelah menyaksikan ibunya dimakan hidup-hidup oleh Titan, Eren Yeager bersumpah untuk membasmi setiap Titan yang ada di dunia dan bergabung dengan Survey Corps, pasukan elit militer yang bertugas menjelajah ke luar tembok.', '/uploads/buku/buku_3db2cce1354b34b6.jpg', 10, '2026-10-20 11:30:06', '2026-11-16 20:05:05', 7, 'Action, Dark Fantasy, Post-apocalyptic, Military, Mystery'),
(34, 'Tokyo Ghoul', 'Sui Ishida', 'Shueisha', '2011', 'Ken Kaneki adalah seorang mahasiswa biasa yang gemar membaca buku. Hidupnya berubah drastis setelah ia diserang oleh Rize Kamishiro, seorang Ghoul—makhluk mirip manusia yang bertahan hidup dengan memakan daging manusia. Kaneki berhasil selamat setelah kecelakaan menimpa Rize, namun organ tubuh Rize dicangkokkan ke dalam dirinya. Kaneki pun berubah menjadi setengah manusia, setengah ghoul, dan harus belajar beradaptasi di dunia bawah tanah yang kelam.', '/uploads/buku/buku_17ac96e4332585ba.jpg', 5, '2026-10-20 11:32:11', '2026-11-11 21:42:17', 7, 'Dark Fantasy, Horror, Psychological Thriller, Action'),
(35, 'My Hero Academia', 'Kohei Horikoshi', 'Shueisha', '2014', 'Di dunia tempat hampir semua orang lahir dengan kekuatan super bernama Quirk, seorang anak laki-laki bernama Izuku Midoriya justru lahir tanpa kekuatan sama sekali. Meski begitu, ia tetap bermimpi menjadi pahlawan super. Hidupnya berubah total setelah ia bertemu dengan pahlawan nomor satu dunia, All Might, yang memilih Midoriya sebagai pewaris kekuatannya yang legendaris, One For All, untuk bersekolah di SMA pahlawan, U.A. High School.', '/uploads/buku/buku_828cbbc1e6cea2a0.jpg', 10, '2026-10-20 11:33:11', '2026-11-11 21:43:16', 7, 'Action, Superhero, Science Fantasy, School'),
(36, 'The Fragrant Flower Blooms with Dignity', 'Saka Mikami', 'Kodansha', '2021', 'Kisah romansa sekolah antara Rintaro Tsumugi, siswa dari SMA Chidori yang berisi murid-murid berandalan dengan reputasi buruk, dan Kaoruko Wakuri, siswi dari SMA Gadis Kikyo, sekolah elit khusus perempuan yang sangat terpandang. Kedua sekolah ini bertetangga namun saling membenci. Hubungan Rintaro dan Kaoruko yang tulus mulai mendobrak prasangka dan dinding pembatas di antara lingkungan mereka.', '/uploads/buku/buku_4808b0559e6ad2b8.jpg', 6, '2026-10-20 11:34:01', '2026-11-11 21:43:07', 7, 'Romance, Drama, School, Slice of Life'),
(37, 'Gachiakuta', 'Kei Urana', 'Kodansha', '2022', 'Mengisahkan Rudo, seorang remaja yang tinggal di daerah kumuh sebuah kota metropolitan yang terbagi dua status sosial. Penduduk kota membuang semua sampah mereka ke sebuah jurang raksasa yang disebut The Abyss. Suatu hari, Rudo difitnah atas pembunuhan ayah angkatnya dan dijatuhkan ke dalam jurang tersebut. Di dasar Abyss yang berbahaya, Rudo bertahan hidup dan menyadari bahwa ia memiliki kemampuan untuk memanipulasi jiwa dari benda-benda yang dianggap sampah. Ia pun bertekad membalas dendam kepada orang-orang di atas kota.', '/uploads/buku/buku_4c49fb7bcaa49a29.jpg', 5, '2026-10-20 11:34:38', '2026-11-11 21:42:59', 7, 'Action, Dark Fantasy, Post-apocalyptic'),
(38, 'Horimiya', 'HERO, Daisuke Hagiwara', 'Square Enix', '2011', 'Cerita ini berpusat pada Kyouko Hori, siswi SMA populer yang pintar, dan Izumi Miyamura, cowok pendiam yang tampak seperti kutu buku kusam. Di luar sekolah, keduanya memiliki rahasia: Hori sebenarnya adalah gadis rumahan yang sibuk mengurus rumah dan adiknya, sementara Miyamura adalah cowok bertato dan bertindik dengan penampilan punk. Setelah tidak sengaja menemukan rahasia satu sama lain, mereka mulai dekat dan berbagi sisi asli diri mereka.', '/uploads/buku/buku_ca56c1107bc760bf.jpg', 4, '2026-10-20 11:37:07', '2026-10-21 10:17:14', 7, 'Romance, Slice of Life, Comedy, School'),
(39, 'One Piece', 'Eichiro Oda', 'Shueisha', '1999', 'Cerita epik tentang Monkey D. Luffy, seorang remaja yang tubuhnya menjadi elastis seperti karet setelah tidak sengaja memakan Buah Iblis. Terinspirasi oleh idola masa kecilnya, Luffy membentuk kelompok Bajak Laut Topi Jerami. Bersama kru setianya, mereka mengarungi lautan berbahaya Grand Line untuk menemukan harta karun legendaris bernama One Piece demi mewujudkan impian Luffy menjadi Raja Bajak Laut.', '/uploads/buku/buku_9fb58e4648227250.jpg', 5, '2026-10-21 08:37:32', '2026-11-11 21:42:37', 7, 'Action, Adventure, Fantasy'),
(40, 'That Time I Got Reincarnated as a Slime', 'Fuse, Taiki Kawakami', 'Kodansha', '2015', 'Satoru Mikami, seorang pekerja kantoran berusia 37 tahun, tewas ditikam oleh perampok di jalanan. Bukannya masuk surga, ia justru bereinkarnasi di dunia fantasi sebagai makhluk monster paling lemah: seekor Slime. Di dunia baru ini, ia berteman dengan Naga Badai bernama Veldora dan mengganti namanya menjadi Rimuru Tempest. Dengan skill unik bawaannya, Predator dan Great Sage, Rimuru menyerap berbagai kekuatan kuat dan membangun sebuah negara tempat monster dan manusia bisa hidup berdampingan secara damai.', '/uploads/buku/buku_bb9084a978bc236a.jpg', 5, '2026-10-21 08:39:01', '2026-11-13 20:31:24', 7, 'Isekai, Fantasy, Action, Adventure, City Building'),
(41, 'Death Note', 'Tsugumi Ohba, Takeshi Obata', 'Shueisha', '2003', 'Light Yagami adalah seorang siswa genius yang merasa bosan dengan dunianya yang penuh kriminalitas. Suatu hari, ia menemukan sebuah buku catatan misterius bernama Death Note milik Shinigami (dewa kematian) bernama Ryuk. Buku tersebut memiliki kemampuan membunuh siapa saja yang namanya ditulis di dalamnya. Light memutuskan menggunakan buku itu untuk membasmi semua penjahat di dunia dan menjadi \"Tuhan\" baru, namun ia harus berhadapan dengan detektif paling genius di dunia yang dikenal dengan inisial L.', '/uploads/buku/buku_32bf92f6067d6ff3.jpg', 5, '2026-10-21 08:43:15', '2026-11-11 21:42:25', 7, 'Psychological Thriller, Mystery, Supernatural');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int UNSIGNED NOT NULL,
  `nama_kategori` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`, `created_at`, `updated_at`) VALUES
(1, 'Pelajaran Umum', '2026-09-17 15:18:10', '2026-09-17 15:18:10'),
(2, 'Pelajaran Kejuruan', '2026-09-17 15:18:19', '2026-09-17 15:18:19'),
(3, 'Modul Belajar', '2026-09-17 15:18:40', '2026-09-17 15:18:40'),
(4, 'Buku Referensi', '2026-09-17 15:22:45', '2026-09-17 15:22:45'),
(5, 'Pengembangan Diri', '2026-09-17 15:22:57', '2026-09-17 15:22:57'),
(6, 'Karya Non-Fiksi', '2026-09-17 15:23:17', '2026-09-17 15:23:17'),
(7, 'Karya Fiksi', '2026-09-17 15:23:26', '2026-09-17 15:23:26');

-- --------------------------------------------------------

--
-- Table structure for table `log_aktivitas`
--

CREATE TABLE `log_aktivitas` (
  `id_log` int UNSIGNED NOT NULL,
  `id_user` int UNSIGNED DEFAULT NULL,
  `username` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `role` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `kategori` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `deskripsi` varchar(500) COLLATE utf8mb4_general_ci NOT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `log_aktivitas`
--

INSERT INTO `log_aktivitas` (`id_log`, `id_user`, `username`, `role`, `kategori`, `deskripsi`, `ip_address`, `created_at`) VALUES
(1, 1, 'Yvonne', 'admin', 'sistem', 'Mengunduh backup database (sakuci-2026-10-20_093957.sql)', '127.0.0.1', '2026-10-20 09:39:57'),
(2, 1, 'Yvonne', 'admin', 'buku', 'Menambahkan buku \"Chainsaw Man \" (stok 2)', '127.0.0.1', '2026-10-20 11:22:29'),
(3, 1, 'Yvonne', 'admin', 'buku', 'Menambahkan buku \"Kimetsu No Yaiba\" (stok 1)', '127.0.0.1', '2026-10-20 11:23:54'),
(4, 1, 'Yvonne', 'admin', 'buku', 'Menambahkan buku \"Jujutsu Kaisen\" (stok 1)', '127.0.0.1', '2026-10-20 11:24:44'),
(5, 1, 'Yvonne', 'admin', 'buku', 'Mengubah data buku \"Jujutsu Kaisen\"', '127.0.0.1', '2026-10-20 11:28:11'),
(6, 1, 'Yvonne', 'admin', 'buku', 'Menambahkan buku \"Attack on Titan\" (stok 4)', '127.0.0.1', '2026-10-20 11:30:06'),
(7, 1, 'Yvonne', 'admin', 'buku', 'Menambahkan buku \"Tokyo Ghoul\" (stok 1)', '127.0.0.1', '2026-10-20 11:32:11'),
(8, 1, 'Yvonne', 'admin', 'buku', 'Menambahkan buku \"My Hero Academia\" (stok 3)', '127.0.0.1', '2026-10-20 11:33:11'),
(9, 1, 'Yvonne', 'admin', 'buku', 'Menambahkan buku \"The Fragrant Flower Blooms with Dignity\" (stok 1)', '127.0.0.1', '2026-10-20 11:34:01'),
(10, 1, 'Yvonne', 'admin', 'buku', 'Menambahkan buku \"Gachiakuta\" (stok 2)', '127.0.0.1', '2026-10-20 11:34:38'),
(11, 1, 'Yvonne', 'admin', 'buku', 'Menambahkan buku \"Horimiya\" (stok 4)', '127.0.0.1', '2026-10-20 11:37:07'),
(12, 1, 'Yvonne', 'admin', 'peminjaman', 'Menyetujui peminjaman buku \"Kimia: Sifat Koligatif, Elektrokimia, dan Senyawa Karbon SMK/MAK Kelas XII\" oleh Reksa', '127.0.0.1', '2026-10-20 11:43:13'),
(13, 1, 'Yvonne', 'admin', 'peminjaman', 'Menyetujui peminjaman buku \"Fisika: Fenomena Gelombang, Kelistrikan, dan Fisika Modern SMK/MAK Kelas XII\" oleh Reksa', '127.0.0.1', '2026-10-20 11:43:14'),
(14, 1, 'Yvonne', 'admin', 'peminjaman', 'Menyetujui peminjaman buku \"Bahasa Indonesia untuk SMK/MAK Kelas XII\" oleh Reksa', '127.0.0.1', '2026-10-20 11:43:16'),
(15, 1, 'Yvonne', 'admin', 'buku', 'Mengubah data buku \"Horimiya\"', '127.0.0.1', '2026-10-20 12:52:12'),
(16, 1, 'Yvonne', 'admin', 'buku', 'Mengubah data buku \"Gachiakuta\"', '127.0.0.1', '2026-10-20 12:52:41'),
(17, 1, 'Yvonne', 'admin', 'buku', 'Mengubah data buku \"The Fragrant Flower Blooms with Dignity\"', '127.0.0.1', '2026-10-20 12:53:06'),
(18, 1, 'Yvonne', 'admin', 'buku', 'Mengubah data buku \"My Hero Academia\"', '127.0.0.1', '2026-10-20 12:53:35'),
(19, 1, 'Yvonne', 'admin', 'buku', 'Mengubah data buku \"Tokyo Ghoul\"', '127.0.0.1', '2026-10-20 12:53:57'),
(20, 1, 'Yvonne', 'admin', 'buku', 'Mengubah data buku \"Attack on Titan\"', '127.0.0.1', '2026-10-20 12:54:19'),
(21, 1, 'Yvonne', 'admin', 'buku', 'Mengubah data buku \"Jujutsu Kaisen\"', '127.0.0.1', '2026-10-20 12:54:44'),
(22, 1, 'Yvonne', 'admin', 'buku', 'Mengubah data buku \"Sejarah: Perjuangan Mempertahankan Kemerdekaan hingga Indonesia Modern SMK/MAK Kelas XII\" (stok 1 menjadi 30)', '127.0.0.1', '2026-10-21 06:57:30'),
(23, 1, 'Yvonne', 'admin', 'buku', 'Mengubah data buku \"Pendidikan Jasmani, Olahraga dan Kesehatan SMK/MAK Kelas XI\" (stok 1 menjadi 30)', '127.0.0.1', '2026-10-21 06:58:00'),
(24, 1, 'Yvonne', 'admin', 'buku', 'Mengubah data buku \"Sosiologi: Perubahan Sosial, Modernisasi, dan Globalisasi SMK/MAK Kelas XII\" (stok 1 menjadi 30)', '127.0.0.1', '2026-10-21 06:58:32'),
(25, 1, 'Yvonne', 'admin', 'buku', 'Mengubah data buku \"Kimia: Sifat Koligatif, Elektrokimia, dan Senyawa Karbon SMK/MAK Kelas XII\" (stok 1 menjadi 30)', '127.0.0.1', '2026-10-21 06:59:13'),
(26, 1, 'Yvonne', 'admin', 'buku', 'Mengubah data buku \"Informatika: Sistem Komputasi dan Algoritma Lanjut untuk SMK/MAK Kelas XII\" (stok 1 menjadi 30)', '127.0.0.1', '2026-10-21 06:59:29'),
(27, 1, 'Yvonne', 'admin', 'buku', 'Mengubah data buku \"Fisika: Fenomena Gelombang, Kelistrikan, dan Fisika Modern SMK/MAK Kelas XII\" (stok 1 menjadi 30)', '127.0.0.1', '2026-10-21 07:00:42'),
(28, 1, 'Yvonne', 'admin', 'buku', 'Mengubah data buku \"Geografi: Tata Ruang Wilayah, Penginderaan Jauh, dan Interaksi Desa-Kota SMK/MAK Kelas XII \" (stok 1 menjadi 30)', '127.0.0.1', '2026-10-21 07:00:56'),
(29, 1, 'Yvonne', 'admin', 'buku', 'Mengubah data buku \"Pendidikan Pancasila dan Kewarganegaraan SMK/MAK Kelas X\" (stok 1 menjadi 30)', '127.0.0.1', '2026-10-21 07:01:27'),
(30, 1, 'Yvonne', 'admin', 'buku', 'Mengubah data buku \"Bahasa Inggris: English for Skilled Workers SMK/MAK Kelas XII\" (stok 1 menjadi 30)', '127.0.0.1', '2026-10-21 07:02:34'),
(31, 1, 'Yvonne', 'admin', 'buku', 'Mengubah data buku \"Gachiakuta\" (stok 2 menjadi 1)', '127.0.0.1', '2026-10-21 07:03:02'),
(32, 1, 'Yvonne', 'admin', 'buku', 'Mengubah data buku \"My Hero Academia\" (stok 3 menjadi 2)', '127.0.0.1', '2026-10-21 07:03:12'),
(33, 1, 'Yvonne', 'admin', 'anggota', 'Menonaktifkan keanggotaan Isvette_', '127.0.0.1', '2026-10-21 07:08:57'),
(34, 1, 'Yvonne', 'admin', 'sistem', 'Mencetak laporan transaksi peminjaman', '127.0.0.1', '2026-10-21 07:25:04'),
(35, 1, 'Yvonne', 'admin', 'sistem', 'Mencetak laporan transaksi peminjaman', '127.0.0.1', '2026-10-21 07:25:34'),
(36, 6, 'Valentin', 'admin', 'buku', 'Menambahkan buku \"One Piece\" (stok 1)', '127.0.0.1', '2026-10-21 08:37:32'),
(37, 6, 'Valentin', 'admin', 'buku', 'Menambahkan buku \"That Time I Got Reincarnated as a Slime\" (stok 1)', '127.0.0.1', '2026-10-21 08:39:01'),
(38, 6, 'Valentin', 'admin', 'buku', 'Mengubah data buku \"Chainsaw Man \"', '127.0.0.1', '2026-10-21 08:39:32'),
(39, 6, 'Valentin', 'admin', 'buku', 'Mengubah data buku \"Kimetsu No Yaiba\"', '127.0.0.1', '2026-10-21 08:39:51'),
(40, 6, 'Valentin', 'admin', 'buku', 'Mengubah data buku \"Jujutsu Kaisen\"', '127.0.0.1', '2026-10-21 08:40:20'),
(41, 6, 'Valentin', 'admin', 'buku', 'Mengubah data buku \"Attack on Titan\"', '127.0.0.1', '2026-10-21 08:40:36'),
(42, 6, 'Valentin', 'admin', 'buku', 'Mengubah data buku \"Tokyo Ghoul\"', '127.0.0.1', '2026-10-21 08:40:52'),
(43, 6, 'Valentin', 'admin', 'buku', 'Mengubah data buku \"My Hero Academia\"', '127.0.0.1', '2026-10-21 08:41:14'),
(44, 6, 'Valentin', 'admin', 'buku', 'Mengubah data buku \"The Fragrant Flower Blooms with Dignity\"', '127.0.0.1', '2026-10-21 08:41:30'),
(45, 6, 'Valentin', 'admin', 'buku', 'Mengubah data buku \"Gachiakuta\"', '127.0.0.1', '2026-10-21 08:41:48'),
(46, 6, 'Valentin', 'admin', 'buku', 'Mengubah data buku \"Horimiya\"', '127.0.0.1', '2026-10-21 08:42:05'),
(47, 6, 'Valentin', 'admin', 'buku', 'Menambahkan buku \"Death Note\" (stok 1)', '127.0.0.1', '2026-10-21 08:43:15'),
(48, 1, 'Yvonne', 'admin', 'buku', 'Mengubah data buku \"Death Note\"', '127.0.0.1', '2026-10-21 08:49:52'),
(49, 1, 'Yvonne', 'admin', 'buku', 'Mengubah data buku \"Death Note\"', '127.0.0.1', '2026-10-21 08:50:06'),
(50, 1, 'Yvonne', 'admin', 'buku', 'Mengubah data buku \"Chainsaw Man \"', '127.0.0.1', '2026-10-21 09:23:38'),
(51, 1, 'Yvonne', 'admin', 'buku', 'Mengubah data buku \"Kimetsu No Yaiba\"', '127.0.0.1', '2026-10-21 09:23:58'),
(52, 1, 'Yvonne', 'admin', 'buku', 'Mengubah data buku \"Jujutsu Kaisen\"', '127.0.0.1', '2026-10-21 09:24:18'),
(53, 1, 'Yvonne', 'admin', 'buku', 'Mengubah data buku \"Attack on Titan\"', '127.0.0.1', '2026-10-21 09:24:34'),
(54, 1, 'Yvonne', 'admin', 'buku', 'Mengubah data buku \"Tokyo Ghoul\"', '127.0.0.1', '2026-10-21 09:24:53'),
(55, 1, 'Yvonne', 'admin', 'buku', 'Mengubah data buku \"My Hero Academia\"', '127.0.0.1', '2026-10-21 09:25:11'),
(56, 1, 'Yvonne', 'admin', 'buku', 'Mengubah data buku \"The Fragrant Flower Blooms with Dignity\"', '127.0.0.1', '2026-10-21 09:25:29'),
(57, 1, 'Yvonne', 'admin', 'buku', 'Mengubah data buku \"Gachiakuta\"', '127.0.0.1', '2026-10-21 09:25:50'),
(58, 1, 'Yvonne', 'admin', 'buku', 'Mengubah data buku \"Horimiya\"', '127.0.0.1', '2026-10-21 09:26:03'),
(59, 1, 'Yvonne', 'admin', 'buku', 'Mengubah data buku \"One Piece\"', '127.0.0.1', '2026-10-21 09:26:20'),
(60, 1, 'Yvonne', 'admin', 'buku', 'Mengubah data buku \"That Time I Got Reincarnated as a Slime\"', '127.0.0.1', '2026-10-21 09:26:41'),
(61, 1, 'Yvonne', 'admin', 'buku', 'Mengubah data buku \"Death Note\"', '127.0.0.1', '2026-10-21 09:26:55'),
(62, 1, 'Yvonne', 'admin', 'buku', 'Mengubah data buku \"Death Note\"', '127.0.0.1', '2026-10-21 10:01:49'),
(63, 1, 'Yvonne', 'admin', 'buku', 'Mengubah data buku \"That Time I Got Reincarnated as a Slime\"', '127.0.0.1', '2026-10-21 10:02:24'),
(64, 6, 'Valentin', 'admin', 'buku', 'Mengubah data buku \"That Time I Got Reincarnated as a Slime\"', '127.0.0.1', '2026-10-21 10:07:00'),
(65, 6, 'Valentin', 'admin', 'buku', 'Mengubah data buku \"Death Note\"', '127.0.0.1', '2026-10-21 10:07:30'),
(66, 6, 'Valentin', 'admin', 'buku', 'Mengubah data buku \"One Piece\"', '127.0.0.1', '2026-10-21 10:16:58'),
(67, 6, 'Valentin', 'admin', 'buku', 'Mengubah data buku \"Horimiya\"', '127.0.0.1', '2026-10-21 10:17:14'),
(68, 6, 'Valentin', 'admin', 'buku', 'Mengubah data buku \"Gachiakuta\"', '127.0.0.1', '2026-10-21 10:17:35'),
(69, 6, 'Valentin', 'admin', 'buku', 'Mengubah data buku \"The Fragrant Flower Blooms with Dignity\"', '127.0.0.1', '2026-10-21 10:17:50'),
(70, 6, 'Valentin', 'admin', 'buku', 'Mengubah data buku \"My Hero Academia\"', '127.0.0.1', '2026-10-21 10:18:15'),
(71, 6, 'Valentin', 'admin', 'buku', 'Mengubah data buku \"Tokyo Ghoul\"', '127.0.0.1', '2026-10-21 10:18:30'),
(72, 6, 'Valentin', 'admin', 'buku', 'Mengubah data buku \"Attack on Titan\"', '127.0.0.1', '2026-10-21 10:18:48'),
(73, 6, 'Valentin', 'admin', 'buku', 'Mengubah data buku \"Jujutsu Kaisen\"', '127.0.0.1', '2026-10-21 10:19:05'),
(74, 6, 'Valentin', 'admin', 'buku', 'Mengubah data buku \"Kimetsu No Yaiba\"', '127.0.0.1', '2026-10-21 10:19:22'),
(75, 6, 'Valentin', 'admin', 'buku', 'Mengubah data buku \"Chainsaw Man \"', '127.0.0.1', '2026-10-21 10:19:55'),
(76, 6, 'Valentin', 'admin', 'buku', 'Mengubah data buku \"Dasar-Dasar Administrasi & Kearsipan Kelas X\" (stok 1 menjadi 30)', '127.0.0.1', '2026-10-21 10:20:52'),
(77, 6, 'Valentin', 'admin', 'buku', 'Mengubah data buku \"Pedoman Umum Ejaan Bahasa Indonesia (PUEBI) Edisi Terbaru\" (stok 1 menjadi 15)', '127.0.0.1', '2026-10-21 10:21:24'),
(78, 6, 'Valentin', 'admin', 'buku', 'Mengubah data buku \"Buku Panduan Pertolongan Pertama (First Aid Hand Book)\" (stok 1 menjadi 12)', '127.0.0.1', '2026-10-21 10:21:42'),
(79, 6, 'Valentin', 'admin', 'buku', 'Mengubah data buku \"Kamus Istilah Ekonomi dan Bisnis Modern\" (stok 1 menjadi 9)', '127.0.0.1', '2026-10-21 10:22:03'),
(80, 6, 'Valentin', 'admin', 'buku', 'Menghapus buku \"Kamus Istilah Ekonomi dan Bisnis Modern\"', '127.0.0.1', '2026-10-21 10:22:17'),
(81, 6, 'Valentin', 'admin', 'peminjaman', 'Mengonfirmasi pengembalian buku \"Bahasa Indonesia untuk SMK/MAK Kelas XII\" dari Reksa (kondisi: Baik)', '127.0.0.1', '2026-10-21 10:37:47'),
(82, 6, 'Valentin', 'admin', 'peminjaman', 'Mengonfirmasi pengembalian buku \"Fisika: Fenomena Gelombang, Kelistrikan, dan Fisika Modern SMK/MAK Kelas XII\" dari Reksa (kondisi: Baik)', '127.0.0.1', '2026-10-21 10:38:27'),
(83, 6, 'Valentin', 'admin', 'peminjaman', 'Mengonfirmasi pengembalian buku \"Kimia: Sifat Koligatif, Elektrokimia, dan Senyawa Karbon SMK/MAK Kelas XII\" dari Reksa (kondisi: Baik)', '127.0.0.1', '2026-10-21 10:38:29'),
(84, 9, 'Ezekiel', 'pengguna', 'peminjaman', 'Mengajukan peminjaman buku \"Jujutsu Kaisen\"', '127.0.0.1', '2026-10-21 10:39:42'),
(85, 6, 'Valentin', 'admin', 'peminjaman', 'Menyetujui peminjaman buku \"Jujutsu Kaisen\" oleh Ezekiel', '127.0.0.1', '2026-10-21 10:40:07'),
(86, 6, 'Valentin', 'admin', 'sistem', 'Mencetak laporan transaksi peminjaman', '127.0.0.1', '2026-10-21 10:41:39'),
(87, 1, 'Yvonne', 'admin', 'sistem', 'Mengunduh backup database (sakuci-2026-10-21_111847.sql)', '127.0.0.1', '2026-10-21 11:18:47'),
(88, 14, 'Pengguna', 'pengguna', 'keanggotaan', 'Mengajukan keanggotaan perpustakaan atas nama Erica Aleysa Putri Wiganda (kelas 12 RPL 3)', '127.0.0.1', '2026-10-23 16:42:02'),
(89, 1, 'Yvonne', 'admin', 'keanggotaan', 'Menyetujui pengajuan keanggotaan Pengguna', '127.0.0.1', '2026-10-23 16:42:40'),
(90, 14, 'Pengguna', 'pengguna', 'peminjaman', 'Mengajukan peminjaman buku \"Chainsaw Man \"', '127.0.0.1', '2026-10-23 16:43:55'),
(91, 1, 'Yvonne', 'admin', 'peminjaman', 'Mengonfirmasi pengembalian buku \"Jujutsu Kaisen\" dari Ezekiel (kondisi: Baik)', '127.0.0.1', '2026-10-23 16:44:26'),
(92, 1, 'Yvonne', 'admin', 'peminjaman', 'Menyetujui peminjaman buku \"Chainsaw Man \" oleh Pengguna', '127.0.0.1', '2026-10-23 16:44:37'),
(93, 1, 'Yvonne', 'admin', 'anggota', 'Mengaktifkan kembali keanggotaan Isvette_', '127.0.0.1', '2026-10-23 16:55:29'),
(94, 1, 'Yvonne', 'admin', 'user', 'Menghapus akun \"Javelyn\" (role pengguna)', '127.0.0.1', '2026-10-23 16:56:03'),
(95, 1, 'Yvonne', 'admin', 'user', 'Menghapus akun \"Lenoire\" (role pengguna)', '127.0.0.1', '2026-10-23 16:56:06'),
(96, 1, 'Yvonne', 'admin', 'user', 'Menghapus akun \"Winston\" (role pengguna)', '127.0.0.1', '2026-10-23 16:56:11'),
(97, 1, 'Yvonne', 'admin', 'user', 'Menghapus akun \"Yuteia\" (role pengguna)', '127.0.0.1', '2026-10-23 16:56:14'),
(98, 1, 'Yvonne', 'admin', 'peminjaman', 'Mengonfirmasi pengembalian buku \"Chainsaw Man \" dari Pengguna (kondisi: Baik)', '127.0.0.1', '2026-10-23 16:59:42'),
(99, 1, 'Yvonne', 'admin', 'sistem', 'Mengunduh backup database (sakuci-2026-10-23_165953.sql)', '127.0.0.1', '2026-10-23 16:59:53'),
(100, 1, 'Yvonne', 'admin', 'sistem', 'Mencetak laporan transaksi peminjaman', '127.0.0.1', '2026-10-23 16:59:57'),
(101, 1, 'Yvonne', 'admin', 'sistem', 'Mencetak laporan transaksi peminjaman periode 2026-10-22 s/d 2026-10-23', '127.0.0.1', '2026-10-23 17:00:08'),
(102, 7, 'Reksa', 'pengguna', 'peminjaman', 'Mengajukan peminjaman buku \"Dasar-Dasar Administrasi & Kearsipan Kelas X\"', '127.0.0.1', '2026-11-09 17:04:29'),
(103, 1, 'Yvonne', 'admin', 'sistem', 'Mencetak laporan transaksi peminjaman', '127.0.0.1', '2026-11-10 08:00:58'),
(104, 1, 'Yvonne', 'admin', 'peminjaman', 'Menyetujui peminjaman buku \"Dasar-Dasar Administrasi & Kearsipan Kelas X\" oleh Reksa', '127.0.0.1', '2026-11-10 08:04:37'),
(105, 1, 'Yvonne', 'admin', 'peminjaman', 'Mencatat buku \"Dasar-Dasar Administrasi & Kearsipan Kelas X\" dari Reksa sebagai HILANG', '127.0.0.1', '2026-11-10 08:05:08'),
(106, 15, 'Lala', 'pengguna', 'akun', 'Mendaftar akun baru \"Lala\" (menunggu persetujuan admin)', '127.0.0.1', '2026-11-11 17:57:47'),
(107, 1, 'Yvonne', 'admin', 'sistem', 'Mencetak laporan transaksi peminjaman periode 2026-11-10 s/d 2026-11-11', '127.0.0.1', '2026-11-11 19:45:54'),
(108, 1, 'Yvonne', 'admin', 'sistem', 'Mencetak laporan transaksi peminjaman', '127.0.0.1', '2026-11-11 19:46:01'),
(109, 1, 'Yvonne', 'admin', 'sistem', 'Mencetak laporan transaksi peminjaman', '127.0.0.1', '2026-11-11 19:46:34'),
(110, 1, 'Yvonne', 'admin', 'sistem', 'Mencetak laporan transaksi peminjaman periode 2026-11-08 s/d 2026-11-11', '127.0.0.1', '2026-11-11 19:47:05'),
(111, 1, 'Yvonne', 'admin', 'user', 'Menolak pendaftaran akun \"Lala\"', '127.0.0.1', '2026-11-11 20:28:42'),
(112, 6, 'Valentin', 'admin', 'user', 'Menghapus akun \"Reksa\" (role pengguna)', '127.0.0.1', '2026-11-11 20:35:52'),
(113, 6, 'Valentin', 'admin', 'user', 'Menghapus akun \"Pengguna\" (role pengguna)', '127.0.0.1', '2026-11-11 20:35:56'),
(114, 6, 'Valentin', 'admin', 'user', 'Menghapus akun \"Isvette_\" (role pengguna)', '127.0.0.1', '2026-11-11 20:35:59'),
(115, 6, 'Valentin', 'admin', 'user', 'Menghapus akun \"Ezekiel\" (role pengguna)', '127.0.0.1', '2026-11-11 20:36:03'),
(116, 6, 'Valentin', 'admin', 'user', 'Menambahkan user \"Ezekiel\" dengan role pengguna', '127.0.0.1', '2026-11-11 20:36:25'),
(117, 6, 'Valentin', 'admin', 'user', 'Menambahkan user \"Reksa\" dengan role admin', '127.0.0.1', '2026-11-11 20:36:34'),
(118, 6, 'Valentin', 'admin', 'user', 'Menghapus akun \"Reksa\" (role admin)', '127.0.0.1', '2026-11-11 20:36:43'),
(119, 6, 'Valentin', 'admin', 'user', 'Menambahkan user \"Reksa\" dengan role pengguna', '127.0.0.1', '2026-11-11 20:37:08'),
(120, 1, 'Yvonne', 'admin', 'buku', 'Mengubah data buku \"Tokyo Ghoul\" (stok 1 menjadi 5)', '114.122.109.62', '2026-11-11 21:42:17'),
(121, 1, 'Yvonne', 'admin', 'buku', 'Mengubah data buku \"Death Note\" (stok 1 menjadi 5)', '114.122.109.62', '2026-11-11 21:42:25'),
(122, 1, 'Yvonne', 'admin', 'buku', 'Mengubah data buku \"That Time I Got Reincarnated as a Slime\" (stok 1 menjadi 5)', '114.122.109.62', '2026-11-11 21:42:31'),
(123, 1, 'Yvonne', 'admin', 'buku', 'Mengubah data buku \"One Piece\" (stok 1 menjadi 5)', '114.122.109.62', '2026-11-11 21:42:37'),
(124, 1, 'Yvonne', 'admin', 'buku', 'Mengubah data buku \"Gachiakuta\" (stok 1 menjadi 5)', '114.122.109.62', '2026-11-11 21:42:59'),
(125, 1, 'Yvonne', 'admin', 'buku', 'Mengubah data buku \"The Fragrant Flower Blooms with Dignity\" (stok 1 menjadi 6)', '114.122.109.62', '2026-11-11 21:43:07'),
(126, 1, 'Yvonne', 'admin', 'buku', 'Mengubah data buku \"My Hero Academia\" (stok 2 menjadi 10)', '114.122.109.62', '2026-11-11 21:43:16'),
(127, 1, 'Yvonne', 'admin', 'buku', 'Mengubah data buku \"Jujutsu Kaisen\" (stok 1 menjadi 10)', '114.122.109.62', '2026-11-11 21:43:25'),
(128, 1, 'Yvonne', 'admin', 'buku', 'Mengubah data buku \"Kimetsu No Yaiba\" (stok 1 menjadi 5)', '114.122.109.62', '2026-11-11 21:43:35'),
(129, 19, 'ericaaleys', 'pengguna', 'akun', 'Mendaftar akun baru \"ericaaleys\" (menunggu persetujuan admin)', '114.122.78.115', '2026-11-13 19:38:55'),
(130, 1, 'Yvonne', 'admin', 'user', 'Menyetujui pendaftaran akun \"ericaaleys\" (role pengguna)', '114.122.78.115', '2026-11-13 19:40:27'),
(131, 19, 'ericaaleys', 'pengguna', 'keanggotaan', 'Mengajukan keanggotaan perpustakaan atas nama Erica Aleysa Putri Wiganda (kelas 12 RPL 3)', '114.122.78.115', '2026-11-13 19:42:46'),
(132, 1, 'Yvonne', 'admin', 'keanggotaan', 'Menyetujui pengajuan keanggotaan ericaaleys', '114.122.78.115', '2026-11-13 19:43:23'),
(133, 19, 'ericaaleys', 'pengguna', 'peminjaman', 'Mengajukan peminjaman buku \"That Time I Got Reincarnated as a Slime\"', '114.122.78.115', '2026-11-13 19:46:36'),
(134, 1, 'Yvonne', 'admin', 'peminjaman', 'Menyetujui peminjaman buku \"That Time I Got Reincarnated as a Slime\" oleh ericaaleys', '114.122.78.115', '2026-11-13 19:47:14'),
(135, 1, 'Yvonne', 'admin', 'buku', 'Mengubah data buku \"Bahasa Indonesia untuk SMK/MAK Kelas XII\" (stok 31 menjadi 35)', '114.122.78.115', '2026-11-13 19:51:24'),
(136, 1, 'Yvonne', 'admin', 'peminjaman', 'Mengonfirmasi pengembalian buku \"That Time I Got Reincarnated as a Slime\" dari ericaaleys (kondisi: Baik)', '114.122.78.115', '2026-11-13 19:56:34'),
(137, 1, 'Yvonne', 'admin', 'anggota', 'Menonaktifkan keanggotaan ericaaleys', '114.122.78.115', '2026-11-13 20:03:47'),
(138, 1, 'Yvonne', 'admin', 'anggota', 'Mengaktifkan kembali keanggotaan ericaaleys', '114.122.78.115', '2026-11-13 20:29:32'),
(139, 19, 'ericaaleys', 'pengguna', 'peminjaman', 'Mengajukan peminjaman buku \"That Time I Got Reincarnated as a Slime\"', '114.122.78.115', '2026-11-13 20:29:51'),
(140, 1, 'Yvonne', 'admin', 'peminjaman', 'Menyetujui peminjaman buku \"That Time I Got Reincarnated as a Slime\" oleh ericaaleys', '114.122.78.115', '2026-11-13 20:30:12'),
(141, 1, 'Yvonne', 'admin', 'peminjaman', 'Mengonfirmasi pengembalian buku \"That Time I Got Reincarnated as a Slime\" dari ericaaleys (kondisi: Baik)', '114.122.78.115', '2026-11-13 20:31:24'),
(142, 1, 'Yvonne', 'admin', 'buku', 'Mengubah data buku \"Attack on Titan\" (stok 4 menjadi 10)', '114.122.78.115', '2026-11-13 20:42:15'),
(143, 1, 'Yvonne', 'admin', 'buku', 'Mengubah data buku \"Modul Gambar Teknik Manufaktur dengan Autocad\" (stok 1 menjadi 0)', '114.122.78.115', '2026-11-13 20:43:01'),
(144, 1, 'Yvonne', 'admin', 'sistem', 'Mencetak laporan transaksi peminjaman periode 2026-11-12 s/d 2026-11-13', '114.122.78.115', '2026-11-13 20:51:36'),
(145, 16, 'Ezekiel', 'pengguna', 'keanggotaan', 'Mengajukan keanggotaan perpustakaan atas nama Ezekiel Gavin Kavindra (kelas 12 TKJ 2)', '114.122.78.115', '2026-11-13 21:51:14'),
(146, 1, 'Yvonne', 'admin', 'keanggotaan', 'Menyetujui pengajuan keanggotaan Ezekiel', '114.122.78.115', '2026-11-13 21:51:36'),
(147, 16, 'Ezekiel', 'pengguna', 'peminjaman', 'Mengajukan peminjaman buku \"Attack on Titan\"', '114.122.78.115', '2026-11-13 21:51:51'),
(148, 1, 'Yvonne', 'admin', 'peminjaman', 'Menyetujui peminjaman buku \"Attack on Titan\" oleh Ezekiel', '114.122.78.115', '2026-11-13 21:52:25'),
(149, 20, 'vlad', 'pengguna', 'akun', 'Mendaftar akun baru \"vlad\" (menunggu persetujuan admin)', '182.253.36.150', '2026-11-16 15:47:29'),
(150, 21, 'scarlette', 'pengguna', 'akun', 'Mendaftar akun baru \"scarlette\" (menunggu persetujuan admin)', '114.122.82.52', '2026-11-16 15:48:01'),
(151, 1, 'Yvonne', 'admin', 'user', 'Menyetujui pendaftaran akun \"vlad\" (role pengguna)', '114.122.82.52', '2026-11-16 15:54:30'),
(152, 1, 'Yvonne', 'admin', 'user', 'Menyetujui pendaftaran akun \"scarlette\" (role pengguna)', '114.122.82.52', '2026-11-16 15:54:32'),
(153, 20, 'vlad', 'pengguna', 'keanggotaan', 'Mengajukan keanggotaan perpustakaan atas nama mbut karembut (kelas 13 rpl 6)', '182.253.36.150', '2026-11-16 15:58:05'),
(154, 1, 'Yvonne', 'admin', 'keanggotaan', 'Menyetujui pengajuan keanggotaan vlad', '114.122.82.52', '2026-11-16 15:59:25'),
(155, 1, 'Yvonne', 'admin', 'buku', 'Mengubah data buku \"Dasar-Dasar Akuntansi dan Keuangan Lembaga\" (stok 1 menjadi 30)', '114.122.82.52', '2026-11-16 16:01:27'),
(156, 1, 'Yvonne', 'admin', 'buku', 'Mengubah data buku \"Dasar-Dasar Pengembangan Perangkat Lunak dan Gim \" (stok 1 menjadi 30)', '114.122.82.52', '2026-11-16 16:01:50'),
(157, 1, 'Yvonne', 'admin', 'buku', 'Mengubah data buku \"Tata Boga & Kuliner Dasar untuk SMK Kelas X\" (stok 1 menjadi 30)', '114.122.82.52', '2026-11-16 16:02:12'),
(158, 1, 'Yvonne', 'admin', 'buku', 'Mengubah data buku \"Dasar-Dasar Teknik Otomotif Kelas X\" (stok 1 menjadi 30)', '114.122.82.52', '2026-11-16 16:02:32'),
(159, 18, 'Reksa', 'pengguna', 'keanggotaan', 'Mengajukan keanggotaan perpustakaan atas nama Nirmala Areksa Jenggala (kelas 12 MM 2)', '114.122.82.52', '2026-11-16 18:08:02'),
(160, 22, 'Yuteia', 'pengguna', 'akun', 'Mendaftar akun baru \"Yuteia\" (menunggu persetujuan admin)', '114.122.82.52', '2026-11-16 18:09:02'),
(161, 1, 'Yvonne', 'admin', 'user', 'Menyetujui pendaftaran akun \"Yuteia\" (role pengguna)', '114.122.82.52', '2026-11-16 18:09:20'),
(162, 1, 'Yvonne', 'admin', 'anggota', 'Menonaktifkan keanggotaan vlad', '114.122.82.52', '2026-11-16 18:16:34'),
(163, 1, 'Yvonne', 'admin', 'keanggotaan', 'Menyetujui pengajuan keanggotaan Reksa', '114.122.82.52', '2026-11-16 19:59:03'),
(164, 1, 'Yvonne', 'admin', 'peminjaman', 'Mengonfirmasi pengembalian buku \"Attack on Titan\" dari Ezekiel (kondisi: Rusak ringan)', '114.122.82.52', '2026-11-16 20:05:05'),
(165, 1, 'Yvonne', 'admin', 'user', 'Mengubah username dari \"Yvonne\" menjadi \"yvonne_1\"', '114.122.82.52', '2026-11-16 20:26:15'),
(166, 1, 'yvonne_1', 'admin', 'user', 'Mengubah username dari \"yvonne_1\" menjadi \"yvonne\"', '114.122.82.52', '2026-11-16 20:31:17'),
(167, 6, 'Valentin', 'admin', 'user', 'Mengubah username dari \"Valentin\" menjadi \"vaaalentin\"', '114.122.82.52', '2026-11-16 20:34:22');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ran_at` varchar(32) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `ran_at`) VALUES
(1, '2026_08_20_090000_create_users_table.sql', '2026-09-17 14:51:34'),
(2, '2026_08_21_090000_create_roles_table.sql', '2026-09-17 14:51:35'),
(3, '2026_08_23_100000_add_can_register_to_roles_table.sql', '2026-09-17 14:51:35'),
(4, '2026_09_08_073542_create_kategoris_table.sql', '2026-09-17 14:51:35'),
(5, '2026_09_11_184333_create_data_bukus_table.sql', '2026-09-17 14:51:35'),
(6, '2026_09_14_150147_create_peminjamans_table.sql', '2026-09-17 14:51:36'),
(7, '2026_09_17_151433_create_peminjamans_table.sql', '2026-09-17 15:16:19'),
(8, '2026_09_17_155233_create_pengajuan_keanggotaans_table.sql', '2026-09-21 09:26:11'),
(9, '2026_09_15_124659_create_pengajuan_keanggotaans_table.sql', '2026-11-11 17:39:09'),
(10, '2026_11_11_173817_create_pengaturan_denda_table.sql', '2026-11-11 17:39:10'),
(11, '2026_11_11_174838_add_status_akun_to_users_table.sql', '2026-11-11 17:49:02');

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id_peminjaman` int UNSIGNED NOT NULL,
  `id_user` int UNSIGNED NOT NULL,
  `id_buku` int UNSIGNED NOT NULL,
  `tanggal_pinjam` date DEFAULT NULL,
  `tanggal_wajib_kembali` date DEFAULT NULL,
  `tanggal_dikembalikan` date DEFAULT NULL,
  `status` enum('menunggu_konfirmasi','dipinjam','ditolak','dikembalikan') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'menunggu_konfirmasi',
  `kondisi_kembali` enum('baik','rusak_ringan','rusak_berat','hilang') COLLATE utf8mb4_general_ci DEFAULT NULL,
  `denda` int UNSIGNED NOT NULL DEFAULT '0',
  `denda_telat` int UNSIGNED NOT NULL DEFAULT '0',
  `denda_kondisi` int UNSIGNED NOT NULL DEFAULT '0',
  `catatan_admin` text COLLATE utf8mb4_general_ci,
  `catatan_kondisi` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status_denda` enum('tidak_ada','belum_lunas','lunas') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'tidak_ada',
  `tanggal_bayar_denda` date DEFAULT NULL,
  `catatan_bayar` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `peminjaman`
--

INSERT INTO `peminjaman` (`id_peminjaman`, `id_user`, `id_buku`, `tanggal_pinjam`, `tanggal_wajib_kembali`, `tanggal_dikembalikan`, `status`, `kondisi_kembali`, `denda`, `denda_telat`, `denda_kondisi`, `catatan_admin`, `catatan_kondisi`, `created_at`, `updated_at`, `status_denda`, `tanggal_bayar_denda`, `catatan_bayar`) VALUES
(10, 19, 40, '2026-11-13', '2026-11-20', '2026-11-13', 'dikembalikan', 'baik', 0, 0, 0, NULL, NULL, '2026-11-13 19:46:36', '2026-11-13 19:56:34', 'tidak_ada', NULL, NULL),
(11, 19, 40, '2026-11-13', '2026-11-20', '2026-11-13', 'dikembalikan', 'baik', 0, 0, 0, NULL, NULL, '2026-11-13 20:29:51', '2026-11-13 20:31:24', 'tidak_ada', NULL, NULL),
(12, 16, 33, '2026-11-13', '2026-11-20', '2026-11-16', 'dikembalikan', 'rusak_ringan', 5000, 0, 5000, NULL, 'Kertas dilipat', '2026-11-13 21:51:50', '2026-11-16 20:05:05', 'belum_lunas', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pengajuan_keanggotaan`
--

CREATE TABLE `pengajuan_keanggotaan` (
  `id_pengajuan` int UNSIGNED NOT NULL,
  `id_user` int UNSIGNED NOT NULL,
  `nama_lengkap` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `nis` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `kelas` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `status` enum('menunggu','disetujui','ditolak') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'menunggu',
  `catatan_admin` text COLLATE utf8mb4_general_ci,
  `tanggal_pengajuan` datetime NOT NULL,
  `tanggal_verifikasi` datetime DEFAULT NULL,
  `diverifikasi_oleh` int UNSIGNED DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengajuan_keanggotaan`
--

INSERT INTO `pengajuan_keanggotaan` (`id_pengajuan`, `id_user`, `nama_lengkap`, `nis`, `kelas`, `status`, `catatan_admin`, `tanggal_pengajuan`, `tanggal_verifikasi`, `diverifikasi_oleh`, `created_at`, `updated_at`) VALUES
(10, 19, 'Erica Aleysa Putri Wiganda', '0088256872', '12 RPL 3', 'disetujui', NULL, '2026-11-13 19:42:46', '2026-11-13 19:43:23', 1, '2026-11-13 19:42:46', '2026-11-13 19:43:23'),
(11, 16, 'Ezekiel Gavin Kavindra', '0081989282', '12 TKJ 2', 'disetujui', NULL, '2026-11-13 21:51:14', '2026-11-13 21:51:36', 1, '2026-11-13 21:51:14', '2026-11-13 21:51:36'),
(13, 18, 'Nirmala Areksa Jenggala', '0082123612', '12 MM 2', 'disetujui', NULL, '2026-11-16 18:08:02', '2026-11-16 19:59:03', 1, '2026-11-16 18:08:02', '2026-11-16 19:59:03');

-- --------------------------------------------------------

--
-- Table structure for table `pengaturan_denda`
--

CREATE TABLE `pengaturan_denda` (
  `id` int UNSIGNED NOT NULL,
  `kode` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `label` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `nominal` int UNSIGNED NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengaturan_denda`
--

INSERT INTO `pengaturan_denda` (`id`, `kode`, `label`, `nominal`, `created_at`, `updated_at`) VALUES
(1, 'telat_per_hari', 'Denda telat per hari', 1000, '2026-11-11 17:39:09', '2026-11-11 17:39:09'),
(2, 'baik', 'Kondisi baik', 0, '2026-11-11 17:39:09', '2026-11-11 17:39:09'),
(3, 'rusak_ringan', 'Kondisi rusak ringan', 5000, '2026-11-11 17:39:09', '2026-11-11 17:39:09'),
(4, 'rusak_berat', 'Kondisi rusak berat', 25000, '2026-11-11 17:39:09', '2026-11-11 17:39:09'),
(5, 'hilang', 'Buku hilang', 50000, '2026-11-11 17:39:09', '2026-11-11 17:39:09');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `can_register` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`, `can_register`) VALUES
(1, 'admin', '2026-09-17 14:51:35', '2026-09-17 14:51:35', 0),
(2, 'pengguna', '2026-10-02 08:17:12', '2026-10-02 08:17:12', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `role` varchar(50) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'user',
  `status_akun` enum('aktif','menunggu') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'aktif',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status_keanggotaan` enum('non_anggota','menunggu_verifikasi','aktif','non_aktif') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'non_anggota'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `status_akun`, `created_at`, `updated_at`, `status_keanggotaan`) VALUES
(1, 'yvonne', '$2y$10$XVlrmFkFzZxRQKfAXKG7Zew/nz.larifWE8rWEhoA3Yxw79LmTdym', 'admin', 'aktif', '2026-09-17 14:51:34', '2026-11-16 20:31:17', 'non_anggota'),
(6, 'vaaalentin', '$2y$10$XVlrmFkFzZxRQKfAXKG7Zew/nz.larifWE8rWEhoA3Yxw79LmTdym', 'admin', 'aktif', '2026-10-02 08:56:16', '2026-11-16 20:34:22', 'non_anggota'),
(16, 'Ezekiel', '$2y$10$JajM6MdhOyRHAyjBu9AlgeogFa3I1Jl.4QOqvPUnq7CNSOt/knhLq', 'pengguna', 'aktif', '2026-11-11 20:36:25', '2026-11-13 21:51:36', 'aktif'),
(18, 'Reksa', '$2y$10$oxFSXk0IX6t27VyBBJF5PO3AXhIGP0TGGxEiYykRC/lhApz3wFgN.', 'pengguna', 'aktif', '2026-11-11 20:37:08', '2026-11-16 19:59:03', 'aktif'),
(19, 'ericaaleys', '$2y$10$aEijohefaDbAbPH/eIwOHOfOlnJ0OhxoRtjTd0B164qNMdypFr6ki', 'pengguna', 'aktif', '2026-11-13 19:38:55', '2026-11-13 20:29:32', 'aktif'),
(20, 'vlad', '$2y$10$CwCz.Iyx/XsgbaiFxvAPE.qM7ZNrI6614n8EMxGw03nPcLwOD6cb6', 'pengguna', 'aktif', '2026-11-16 15:47:29', '2026-11-16 18:16:34', 'non_aktif'),
(21, 'scarlette', '$2y$10$La77fR8fMX61CIj2D1Sg/eAr3MU0NfpbfQoNX3F3QbABaBkKkq9c.', 'pengguna', 'aktif', '2026-11-16 15:48:00', '2026-11-16 15:54:32', 'non_anggota'),
(22, 'Yuteia', '$2y$10$cWB7.fuOHmyJouO3K2gXG.RK4P33Up7nVYMBGDA93BWJAYGfpYYCm', 'pengguna', 'aktif', '2026-11-16 18:09:02', '2026-11-16 18:09:20', 'non_anggota');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `data_buku`
--
ALTER TABLE `data_buku`
  ADD PRIMARY KEY (`id_buku`),
  ADD KEY `fk_buku_kategori` (`id_kategori`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  ADD PRIMARY KEY (`id_log`),
  ADD KEY `idx_log_created` (`created_at`),
  ADD KEY `idx_log_kategori` (`kategori`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id_peminjaman`),
  ADD KEY `fk_peminjaman_user` (`id_user`),
  ADD KEY `fk_peminjaman_buku` (`id_buku`);

--
-- Indexes for table `pengajuan_keanggotaan`
--
ALTER TABLE `pengajuan_keanggotaan`
  ADD PRIMARY KEY (`id_pengajuan`),
  ADD KEY `fk_pengajuan_user` (`id_user`),
  ADD KEY `fk_pengajuan_verifikator` (`diverifikasi_oleh`);

--
-- Indexes for table `pengaturan_denda`
--
ALTER TABLE `pengaturan_denda`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode` (`kode`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `data_buku`
--
ALTER TABLE `data_buku`
  MODIFY `id_buku` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  MODIFY `id_log` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=168;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id_peminjaman` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `pengajuan_keanggotaan`
--
ALTER TABLE `pengajuan_keanggotaan`
  MODIFY `id_pengajuan` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `pengaturan_denda`
--
ALTER TABLE `pengaturan_denda`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `data_buku`
--
ALTER TABLE `data_buku`
  ADD CONSTRAINT `fk_buku_kategori` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `fk_peminjaman_buku` FOREIGN KEY (`id_buku`) REFERENCES `data_buku` (`id_buku`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_peminjaman_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pengajuan_keanggotaan`
--
ALTER TABLE `pengajuan_keanggotaan`
  ADD CONSTRAINT `fk_pengajuan_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pengajuan_verifikator` FOREIGN KEY (`diverifikasi_oleh`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
