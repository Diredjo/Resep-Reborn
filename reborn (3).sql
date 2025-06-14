-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 13, 2025 at 02:02 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `reborn`
--

-- --------------------------------------------------------

--
-- Table structure for table `laporan_profil`
--

CREATE TABLE `laporan_profil` (
  `id` int(11) NOT NULL,
  `id_pelapor` int(11) NOT NULL,
  `id_dilaporkan` int(11) NOT NULL,
  `alasan` enum('Spam','Konten Tidak Pantas','Penipuan','Pelecehan','Lainnya') NOT NULL,
  `alasan_tambahan` text DEFAULT NULL,
  `status` enum('dikirim','ditolak','diterima') DEFAULT 'dikirim',
  `tanggal_lapor` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `laporan_profil`
--

INSERT INTO `laporan_profil` (`id`, `id_pelapor`, `id_dilaporkan`, `alasan`, `alasan_tambahan`, `status`, `tanggal_lapor`) VALUES
(1, 0, 0, 'Spam', 'tes4', 'dikirim', '2025-06-13 04:44:45'),
(2, 0, 0, 'Konten Tidak Pantas', 'Te5s', 'dikirim', '2025-06-13 04:46:27'),
(3, 0, 0, 'Spam', 'Tes6', 'dikirim', '2025-06-13 04:47:18'),
(4, 24, 0, 'Konten Tidak Pantas', 'Tes7', 'dikirim', '2025-06-13 04:47:35'),
(5, 24, 15, 'Penipuan', 'Tes7', 'ditolak', '2025-06-13 04:52:20'),
(6, 24, 23, 'Spam', 'Spam', 'ditolak', '2025-06-13 05:16:09'),
(7, 24, 18, 'Konten Tidak Pantas', 'tes9', 'diterima', '2025-06-13 06:22:21'),
(8, 24, 26, 'Konten Tidak Pantas', NULL, 'diterima', '2025-06-13 07:41:56'),
(9, 24, 30, 'Konten Tidak Pantas', 'rt', 'diterima', '2025-06-13 09:54:36'),
(10, 24, 26, 'Pelecehan', 'Pelecehan website', 'diterima', '2025-06-13 10:00:57'),
(11, 24, 26, 'Pelecehan', '5', 'ditolak', '2025-06-13 10:28:28'),
(12, 24, 26, 'Konten Tidak Pantas', 'gg', 'diterima', '2025-06-13 10:38:50'),
(13, 24, 26, 'Konten Tidak Pantas', 'rr', 'ditolak', '2025-06-13 10:41:37'),
(14, 34, 26, 'Pelecehan', 'membuatsaya tidak seera makan', 'diterima', '2025-06-13 10:53:14'),
(15, 24, 31, 'Penipuan', NULL, 'diterima', '2025-06-13 11:21:04'),
(16, 24, 26, 'Konten Tidak Pantas', 'ddd', 'dikirim', '2025-06-13 13:41:00'),
(17, 24, 26, 'Konten Tidak Pantas', 'Konten bengkel tidak sesuai', 'diterima', '2025-06-13 15:42:56');

-- --------------------------------------------------------

--
-- Table structure for table `tabel_bookmark`
--

CREATE TABLE `tabel_bookmark` (
  `id_bookmark` int(11) NOT NULL,
  `id_resep` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tabel_bookmark`
--

INSERT INTO `tabel_bookmark` (`id_bookmark`, `id_resep`, `id_user`, `tanggal`) VALUES
(29, 47, 15, '2025-06-10 03:18:12'),
(30, 50, 24, '2025-06-10 08:59:44'),
(31, 51, 15, '2025-06-11 01:32:52'),
(32, 52, 28, '2025-06-11 07:07:12'),
(33, 52, 24, '2025-06-13 00:13:07'),
(37, 58, 24, '2025-06-13 04:32:21');

-- --------------------------------------------------------

--
-- Table structure for table `tabel_follow`
--

CREATE TABLE `tabel_follow` (
  `id_follow` int(11) NOT NULL,
  `id_pengikut` int(11) NOT NULL,
  `id_diikuti` int(11) NOT NULL,
  `waktu_follow` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tabel_follow`
--

INSERT INTO `tabel_follow` (`id_follow`, `id_pengikut`, `id_diikuti`, `waktu_follow`) VALUES
(52, 15, 24, '2025-06-10 10:18:37'),
(54, 25, 24, '2025-06-10 15:53:55'),
(55, 24, 13, '2025-06-10 16:01:54'),
(58, 24, 16, '2025-06-11 09:53:52'),
(59, 26, 24, '2025-06-11 10:48:39'),
(60, 28, 26, '2025-06-11 14:08:20'),
(63, 24, 26, '2025-06-13 07:12:46'),
(66, 24, 30, '2025-06-13 09:54:31'),
(67, 24, 34, '2025-06-13 11:00:42'),
(69, 24, 31, '2025-06-13 11:30:47');

-- --------------------------------------------------------

--
-- Table structure for table `tabel_highlight`
--

CREATE TABLE `tabel_highlight` (
  `id_highlight` int(11) NOT NULL,
  `label` varchar(100) NOT NULL,
  `icon` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tabel_highlight`
--

INSERT INTO `tabel_highlight` (`id_highlight`, `label`, `icon`) VALUES
(1, 'TOP', '🌟'),
(2, 'VERIFIED', '✔️'),
(3, 'RECOMMENDED', '🔥'),
(6, 'Halal', '☪️'),
(11, 'FYP', '😻'),
(13, 'kentang', '');

-- --------------------------------------------------------

--
-- Table structure for table `tabel_komentar`
--

CREATE TABLE `tabel_komentar` (
  `id_komentar` int(11) NOT NULL,
  `id_resep` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `komentar` text NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tabel_komentar`
--

INSERT INTO `tabel_komentar` (`id_komentar`, `id_resep`, `id_user`, `komentar`, `tanggal`) VALUES
(24, 47, 15, 'nice resep', '2025-06-10 03:19:05'),
(25, 48, 23, 'Seger apalagi diminum di siang hari kayak gini 😋🤤🤤', '2025-06-10 06:46:10'),
(26, 50, 24, 'Enak banget mas aku jadi sayang 😂', '2025-06-10 09:00:23'),
(27, 51, 15, 'Enak banget!', '2025-06-11 01:33:01'),
(28, 53, 24, 'Bagasnya mana', '2025-06-11 04:14:25'),
(30, 48, 30, 'wah enak banget tuh es nya seger deh', '2025-06-13 00:30:22'),
(31, 47, 24, 'wowwww', '2025-06-13 03:10:02'),
(33, 50, 24, 'jun, masak yang enak saya lapar', '2025-06-13 03:37:51'),
(34, 47, 24, 'wow, hebat👍', '2025-06-13 04:01:36');

-- --------------------------------------------------------

--
-- Table structure for table `tabel_resep`
--

CREATE TABLE `tabel_resep` (
  `id_resep` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `judul` varchar(50) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `bahan` varchar(255) NOT NULL,
  `langkah` text NOT NULL,
  `tanggal_posting` date NOT NULL DEFAULT current_timestamp(),
  `foto` varchar(255) NOT NULL,
  `video` varchar(255) DEFAULT NULL,
  `tipe` enum('makanan','minuman','camilan') NOT NULL,
  `id_highlight` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tabel_resep`
--

INSERT INTO `tabel_resep` (`id_resep`, `id_user`, `judul`, `deskripsi`, `bahan`, `langkah`, `tanggal_posting`, `foto`, `video`, `tipe`, `id_highlight`) VALUES
(46, 24, 'Roti Gandum', 'Deskripsi iiiiiiiiiiiiiiiiiiii', 'Tepung, Gandum\n\nAlat: Tangan', 'Tes1\nTes 2', '2025-06-10', 'alasan-mengonsumsi-roti-gandum-dan-tips-memilihnya.jpg', 'https://youtu.be/Mg6Kf3hcsIg?si=4pMTypIkNWx_kPNu', 'makanan', NULL),
(47, 24, 'JASUKE', 'Deskripsi Jasuke Tes', 'Jagung, Susu, Keju\n\nAlat: Wadah Cup', 'Campur\nAduk\nSajikan', '2025-06-10', '654aca1330ade.jpeg', '', 'makanan', 1),
(48, 24, 'Jus Susu Semangka', 'Jus Semangka susu enak simpel mudah olahan dari bahan semangka fresh dari ternak', 'Semngka, Susu, Gula\n\nAlat: Blender, Gelas', 'Campurkan bahan\r\nBlender\r\nAduk\r\nSajikan', '2025-06-10', 'sddefault.jpg', 'https://youtu.be/fkUzEksR5rQ?si=yKLNQFUbjJfBIPXl', 'makanan', 3),
(49, 24, 'Resep Sate Kurban', 'Sate daging kurban enak gurih lembut', 'Daging, Bumbu\n\nAlat: Panggangan', 'Siapkan temat\nBakar\nMakan', '2025-06-10', '649d02beb32d7.jpg', 'https://youtu.be/dY6TFSwgWRk?si=GzD0BOyShHzsTRur', 'makanan', NULL),
(50, 25, 'Telur Asin', 'Telur Asin', 'Telur, Asin\n\nAlat: Tangan', 'Langkah pertama\nMakan', '2025-06-10', 'tu0y99cf421if8p.jpeg', 'https://youtu.be/RwblSpjDa5g?si=OoVPkIsDr47QDThE', 'makanan', NULL),
(51, 24, 'Keripik Pisang', 'Keripik pisag simpel kriuk enak mudah dibuat', 'Pisang kepok mentah – 1 sisir\r\n\r\nAir kapur sirih – secukupnya\r\n\r\nGaram – 1 sdt\r\n\r\nMinyak goreng – secukupnya\n\nAlat: Pisau/alat pemotong tipis\r\n\r\nWadah rendaman\r\n\r\nWajan\r\n\r\nKompor\r\n\r\nSaringan/minyak peniris', 'Kupas\nRendam\nTiris\nAngkat', '2025-06-11', 'keripik_pisang_caramel_21468_20230522120920.jpg', '', 'makanan', 1),
(52, 15, 'Resep Kedelai menjadi Tempe', 'Tempe rumahan (Tips hemat)', 'Kedelai – 1 kg\r\n\r\nRagi tempe – 1 sdt\n\nAlat: Panci\r\n\r\nTampah/nampan\r\n\r\nPlastik berlubang/daun pisang\r\n\r\nKain bersih\r\n\r\nDandang kukus', 'Rendam\nKukus\nCampur\nAduk\nFerentasi', '2025-06-11', 'd4e86393-78a7-4547-9b27-1b858e29b379_fs2.jpg', '', 'makanan', NULL),
(53, 16, 'Abon Sapi', 'Abon sapi ala chef Juna', 'Daging sapi tanpa lemak – 1 kg\r\n\r\nSantan – 500 ml\r\n\r\nBawang merah & putih – 10 siung\r\n\r\nKetumbar, lengkuas, daun salam, gula, garam – secukupnya\n\nAlat: Panci presto / panci biasa\r\n\r\nWajan besar\r\n\r\nSaringan\r\n\r\nSerutan daging / garpu', 'Rebus\r\nTumis\r\nMasak\r\nAngkat', '2025-06-11', 'images.jpg', 'https://youtu.be/k1t3ybDjQWc?si=67dq9Xa7liqLyEA-', 'makanan', 6),
(54, 26, 'Resep Bubut Logam', 'Dengan mengikuti tutorial ini, maka kamu akan mampu membuka jasa bubut dan akan sejago buat bubut seperti Bengkel Wahyu Putra.', 'Material Logam 3 Dimensi\n\nAlat: Mesin Bubut\r\nMesin Milling\r\nMesin EDM\r\nRestu Ibu', 'Nyalakan mesin\nTempatkan material ke dalam mesin\nJalankan mesin dan mulai pemotongan\nTunggu hingga selesai\nPeriksa kembali hasil dan lakukan perbaikan jika diperlukan', '2025-06-11', 'bubut.png', 'https://youtu.be/rf7qjuusRbc?si=K6f56pwtwXX8UVwQ', 'makanan', 2),
(56, 28, 'Pisang goreng', 'Deskripsiiiiiiiiiii', 'Alat\n\nAlat: BAhan', 'Beli pisag\nMakan', '2025-06-11', '62d8ed0d485d4.jpg', 'https://youtu.be/Mg6Kf3hcsIg?si=4pMTypIkNWx_kPNu', 'makanan', 11),
(58, 31, 'Bika Ambon', 'OKe acece', 'JUJUR\n\nAlat: gunting', 'oke', '2025-06-13', 'bika ambon.png', '', 'makanan', 6),
(59, 24, 'kangkung recycle', 'ini adalah kangkung khas recycle', 'kangkung\r\nsistem pencernaan\n\nAlat: tangan', 'makan kangkung nya\ngunakan sistem pencernaan\nsetelah keluar dari sistem pencernaan maka bisa langsung disajikan', '2025-06-13', '5-manfaat-kangkung-yang-sayang-dilewatkan.jpg', '', 'makanan', 13),
(60, 24, 'kentang goreng keju pak slamet', 'kentang goreng enak dengan keju yang melimpah', 'kentang keju\n\nAlat: doa ibu tangan spatula ', 'makan', '2025-06-13', 'download (1).jpg', '', 'makanan', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tabel_suka`
--

CREATE TABLE `tabel_suka` (
  `id_suka` int(11) NOT NULL,
  `id_resep` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tabel_suka`
--

INSERT INTO `tabel_suka` (`id_suka`, `id_resep`, `id_user`, `tanggal`) VALUES
(72, 47, 15, '2025-06-10 03:18:13'),
(73, 48, 23, '2025-06-10 06:46:28'),
(74, 47, 25, '2025-06-10 08:56:23'),
(75, 50, 24, '2025-06-10 08:59:43'),
(76, 51, 15, '2025-06-11 01:32:51'),
(77, 53, 24, '2025-06-11 04:14:07'),
(78, 52, 28, '2025-06-11 07:07:10'),
(79, 54, 24, '2025-06-11 07:28:18'),
(80, 48, 30, '2025-06-13 00:29:58'),
(81, 54, 30, '2025-06-13 00:35:21'),
(83, 54, 34, '2025-06-13 03:51:21');

-- --------------------------------------------------------

--
-- Table structure for table `tabel_user`
--

CREATE TABLE `tabel_user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `tanggal_daftar` timestamp NOT NULL DEFAULT current_timestamp(),
  `kategori` enum('admin','user') NOT NULL DEFAULT 'user',
  `fotoprofil` varchar(255) NOT NULL,
  `bio` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tabel_user`
--

INSERT INTO `tabel_user` (`id_user`, `username`, `email`, `password`, `tanggal_daftar`, `kategori`, `fotoprofil`, `bio`) VALUES
(11, 'usertamu', 'a@gmail.com', '$2y$10$HUQsqS5A3.ouaMp5.9993uzgeT7l.B0UAo2VB4ZecPV2yjXN4ydSa', '2025-05-06 01:04:41', 'user', '', ''),
(13, 'Evan', 'Evan@gmail.com', '$2y$10$sfkDFkaKW/Y10dKzEBOthu6Tv.AlkNby9EYxHY7i1IngD/UatAbnO', '2025-05-14 09:24:52', 'user', '', ''),
(15, 'Yudha', 'r@gmail.com', '$2y$10$Nw/4hcJniA78mzJV042rp.UY3tql1GFfSqImY2vYeoTGLWMeHtlAW', '2025-05-30 18:44:03', '', 'pp_yudha_20250608_150227.jpg', 'Cihuy'),
(16, 'Chef Juna', 'Jun@gmail.com', '$2y$10$ZEnZMSHo/WYO0IYwdZhNmOG7HVHlcjLSAudpa76LdJNB1wKXrk5zS', '2025-05-31 04:08:57', 'user', '', ''),
(17, 'Chef Bobon', 'Bobon@gmail.com', '$2y$10$P75WTEhywHTGL6Ub543I8eXqrOboFc3wAwUwRI1A8lVXmIAdBT/Aa', '2025-05-31 15:48:35', 'user', '', ''),
(18, 'Atha', 'At@gmail.com', '$2y$10$myM3.blyD8DoroVmbt4bUO/Lm3hxW7ZMmn.AnW/e1DWGAgcHLdRlu', '2025-06-01 11:21:59', 'user', '', 'Bombaclaat'),
(19, 'Kepin', 'Keopin@gmail.com', '$2y$10$X34FybUGbjfEeS10GeyRjOLV3Ep.WZdbeiyamqUzd8Grp3kU.jL0e', '2025-06-02 04:39:46', 'user', '', ''),
(23, 'Naufal Rafa', 'naufal@gmail.com', '$2y$10$99O22K0u5zRy.KzxRCKsl.gc40YLZSi5AxhaaByRjX0e2EY8u17Am', '2025-06-10 01:49:36', 'admin', '', ''),
(24, 'Resya', '1@gmail.com', '$2y$10$iaq0Fe/D4vngqPV5U9CILuM0rOkPx623180becaHXY/7B7wlxrob.', '2024-11-10 02:08:55', 'admin', 'pp_resya_20250613_010948.jpg', 'Cihuyyy'),
(25, 'Admin Coinomy', 'C@gmail.com', '$2y$10$eGiUTuqmtt38eGyzfasUCOhXmBlVWu2j7jU6iUONmFgtKMipnN.E.', '2025-06-10 08:53:25', 'user', '', 'BELAJAR AKTIF DAN GIAT DI COINOMY'),
(26, 'Admin Bengkel Wahyu Putra', 'jasabengkelwahyuputra@gmail.com', '$2y$10$hNiEySMJgCBYkqSsOh2yiuiKwMEZleeiHQSSh8TfpkoXEn7/KY9G.', '2025-06-11 03:39:52', 'user', 'pp_adminbengkelwahyuputra_20250611_054830.png', ''),
(27, 'Bagas_SDMTinggi', 'NOSDMRENDAH@gmail.com', '$2y$10$nV7TJ0BiRt71SVcBHPQkb.QLIKlS3f/Rhy32QiIrPIPa//dTxZV1C', '2025-06-11 04:16:48', 'user', '', 'Anda sopan, saya bagas.'),
(28, 'Bawhe', '123@gmail.com', '$2y$10$kzlSlGIXTlOyk4HNWSjfE.rswz/cNGdL2qRtR5q./8NOvcMeMEdHW', '2025-06-11 07:01:40', 'user', '', ''),
(29, 'Khanza Dyas R', 'khanza321@gmail.com', '$2y$10$PtCT5eTc8pTXxDyG3tm9/e/Yrj8AcNOuSQHEF1Nl69pAY7Mih/7SW', '2025-06-13 00:27:52', 'user', '', ''),
(30, 'Andika', 'san@gmail.com', '$2y$10$u002VbiaDZpkDJeKBlGl0uIDkJFenFF0lRiKlwzsuk2I/mdbyxkoC', '2025-06-13 00:29:18', 'user', '', 'Anda Sopan Kami Bonek'),
(31, 'Revanooo', 'satya@gmail.com', '$2y$10$vkJ4HyvUYaKeeasfsapxMu26e4FdnjT70YCXjibFmrnFtmGPBphPS', '2025-06-13 03:30:21', 'user', 'pp_revanooo_20250613_053212.jpg', ''),
(32, 'nyadineee', 'anjaykelas@gmail.com', '$2y$10$.jQkolC7GsfgcA77HpGtges/t/V80tdFnJNd86zqpNFDaY3pVUdki', '2025-06-13 03:46:39', 'user', '', ''),
(33, 'SatrioARNF09', 'satrio.rnf@gmail.com', '$2y$10$H0WOuKKN0Psan3tKg0RJ6.lxqewjlbLUdFS7zj/tBBhppKU8rcYDe', '2025-06-13 03:48:34', 'user', '', ''),
(34, 'SatrioARNF', 'arnfsatrio@gmail.com', '$2y$10$lBqbhwLwHbA7OXJ3nrx5yO/SYnoAM3qPWThNgvLQXql1tC1IKCCY2', '2025-06-13 03:50:15', 'admin', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `laporan_profil`
--
ALTER TABLE `laporan_profil`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tabel_bookmark`
--
ALTER TABLE `tabel_bookmark`
  ADD PRIMARY KEY (`id_bookmark`),
  ADD KEY `id_resep` (`id_resep`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_user_2` (`id_user`,`id_resep`);

--
-- Indexes for table `tabel_follow`
--
ALTER TABLE `tabel_follow`
  ADD PRIMARY KEY (`id_follow`),
  ADD UNIQUE KEY `unik_follow` (`id_pengikut`,`id_diikuti`),
  ADD KEY `id_diikuti` (`id_diikuti`);

--
-- Indexes for table `tabel_highlight`
--
ALTER TABLE `tabel_highlight`
  ADD PRIMARY KEY (`id_highlight`);

--
-- Indexes for table `tabel_komentar`
--
ALTER TABLE `tabel_komentar`
  ADD PRIMARY KEY (`id_komentar`),
  ADD KEY `id_resep` (`id_resep`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `tabel_resep`
--
ALTER TABLE `tabel_resep`
  ADD PRIMARY KEY (`id_resep`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_user_2` (`id_user`),
  ADD KEY `fk_highlight` (`id_highlight`);

--
-- Indexes for table `tabel_suka`
--
ALTER TABLE `tabel_suka`
  ADD PRIMARY KEY (`id_suka`),
  ADD KEY `id_resep` (`id_resep`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_user_2` (`id_user`,`id_resep`);

--
-- Indexes for table `tabel_user`
--
ALTER TABLE `tabel_user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `laporan_profil`
--
ALTER TABLE `laporan_profil`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `tabel_bookmark`
--
ALTER TABLE `tabel_bookmark`
  MODIFY `id_bookmark` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `tabel_follow`
--
ALTER TABLE `tabel_follow`
  MODIFY `id_follow` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `tabel_highlight`
--
ALTER TABLE `tabel_highlight`
  MODIFY `id_highlight` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tabel_komentar`
--
ALTER TABLE `tabel_komentar`
  MODIFY `id_komentar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `tabel_resep`
--
ALTER TABLE `tabel_resep`
  MODIFY `id_resep` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `tabel_suka`
--
ALTER TABLE `tabel_suka`
  MODIFY `id_suka` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT for table `tabel_user`
--
ALTER TABLE `tabel_user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tabel_bookmark`
--
ALTER TABLE `tabel_bookmark`
  ADD CONSTRAINT `tabel_bookmark_ibfk_1` FOREIGN KEY (`id_resep`) REFERENCES `tabel_resep` (`id_resep`) ON DELETE CASCADE,
  ADD CONSTRAINT `tabel_bookmark_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `tabel_user` (`id_user`) ON DELETE CASCADE;

--
-- Constraints for table `tabel_follow`
--
ALTER TABLE `tabel_follow`
  ADD CONSTRAINT `tabel_follow_ibfk_1` FOREIGN KEY (`id_pengikut`) REFERENCES `tabel_user` (`id_user`) ON DELETE CASCADE,
  ADD CONSTRAINT `tabel_follow_ibfk_2` FOREIGN KEY (`id_diikuti`) REFERENCES `tabel_user` (`id_user`) ON DELETE CASCADE;

--
-- Constraints for table `tabel_komentar`
--
ALTER TABLE `tabel_komentar`
  ADD CONSTRAINT `tabel_komentar_ibfk_1` FOREIGN KEY (`id_resep`) REFERENCES `tabel_resep` (`id_resep`) ON DELETE CASCADE,
  ADD CONSTRAINT `tabel_komentar_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `tabel_user` (`id_user`) ON DELETE CASCADE;

--
-- Constraints for table `tabel_resep`
--
ALTER TABLE `tabel_resep`
  ADD CONSTRAINT `fk_highlight` FOREIGN KEY (`id_highlight`) REFERENCES `tabel_highlight` (`id_highlight`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `tabel_resep_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `tabel_user` (`id_user`) ON DELETE CASCADE;

--
-- Constraints for table `tabel_suka`
--
ALTER TABLE `tabel_suka`
  ADD CONSTRAINT `tabel_suka_ibfk_1` FOREIGN KEY (`id_resep`) REFERENCES `tabel_resep` (`id_resep`) ON DELETE CASCADE,
  ADD CONSTRAINT `tabel_suka_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `tabel_user` (`id_user`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
