-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 29, 2021 at 10:23 AM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 7.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `duahati`
--

-- --------------------------------------------------------

--
-- Table structure for table `harga_pendaftaran`
--

CREATE TABLE `harga_pendaftaran` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `jumlah_pembayaran` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '0 tidak aktif | 1 aktif',
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `home_slider`
--

CREATE TABLE `home_slider` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `keterangan` text NOT NULL,
  `foto` varchar(255) NOT NULL,
  `status` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `home_slider`
--

INSERT INTO `home_slider` (`id`, `nama`, `keterangan`, `foto`, `status`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(5, 'Slider 1', 'Keterangan Slider 1', 'd99312b8a730e6c274eafcb876d593fc.png', 1, 1, 1, NULL, '2021-10-21 17:36:21', '2021-10-21 17:36:29', NULL),
(6, 'Slider 2', 'Keterangan Slider 2', 'aae710740d537620922acecc25bcbf14.png', 1, 1, NULL, NULL, '2021-10-21 17:36:47', NULL, NULL),
(7, 'Slider 3', 'Keterangan Slider 3', 'c4f70ac52686d3af8c5a4e6dd8ef8409.jpg', 1, 1, NULL, NULL, '2021-10-21 17:37:14', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE `kelas` (
  `id` int(11) NOT NULL,
  `kategori_id` int(11) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `keterangan` text NOT NULL,
  `foto` varchar(255) NOT NULL,
  `tipe` int(11) NOT NULL DEFAULT 1 COMMENT '1 Premium | 2 VIP',
  `status` int(11) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kelas`
--

INSERT INTO `kelas` (`id`, `kategori_id`, `nama`, `keterangan`, `foto`, `tipe`, `status`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 3, 'Pra Nikah (VIP)', 'Keterangan', '8244068289ba0be186962db6a2530d7f.png', 2, 1, 1, 1, NULL, '2021-10-21 07:59:52', '2021-10-22 12:33:04', NULL),
(2, 3, 'Pasca Nikah', 'Ket 2', 'df3e865f96693e30cc47cfc4dafba0dd.png', 1, 1, 1, 1, NULL, '2021-10-21 08:01:10', '2021-10-21 13:50:50', NULL),
(3, 5, 'Belajar Tahsin', 'Serial Belajar Tahsin Yufid.tv', '02a8edb6d1061e88ea069f8454f8780d.jpg', 2, 1, 1, 1, NULL, '2021-10-22 00:15:28', '2021-10-22 13:01:48', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `kelas_kategori`
--

CREATE TABLE `kelas_kategori` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `keterangan` text NOT NULL,
  `foto` varchar(255) NOT NULL,
  `status` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kelas_kategori`
--

INSERT INTO `kelas_kategori` (`id`, `nama`, `keterangan`, `foto`, `status`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Isep Lutpi Nur', 'keterangan', 'f4fdb45a2d0449b1fc49644b35c6146e.png', 3, 1, 1, 1, '2021-10-21 07:09:27', '2021-10-21 07:38:32', '2021-10-21 07:38:32'),
(2, NULL, 'null', 'Kelas Premium', 3, 1, 1, 1, '2021-10-21 07:20:26', '2021-10-21 13:48:49', '2021-10-21 13:48:49'),
(3, 'Premium', 'Premium', '8e2a33b035453798209c969209756cff.png', 1, 1, 1, NULL, '2021-10-21 13:45:01', '2021-10-21 13:50:02', NULL),
(4, 'Gratis', 'Kelas Gratis', '', 1, 1, NULL, NULL, '2021-10-21 13:50:15', NULL, NULL),
(5, 'Tahsin', 'Keterangan', '', 1, 1, 1, NULL, '2021-10-22 00:13:52', '2021-10-22 12:17:21', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `kelas_materi`
--

CREATE TABLE `kelas_materi` (
  `id` int(11) NOT NULL,
  `kelas_id` int(11) DEFAULT NULL,
  `no_urut` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kelas_materi`
--

INSERT INTO `kelas_materi` (`id`, `kelas_id`, `no_urut`, `nama`, `url`, `keterangan`, `created_by`, `updated_by`, `deleted_by`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 3, 1, 'Kewajiban Belajar Tajwid - Ustadz Ulin Nuha', 'https://www.youtube.com/watch?v=qF_HuLMI-B4&list=PLUuYlj8dcEXbyJzGAUYTSCfYr5EqLo0dy&index=1', 'Keterangan video\r\n', 1, 1, NULL, 1, '2021-10-22 00:17:45', '2021-10-22 08:15:38', NULL),
(2, 3, 2, 'Tujuan Mempelajari Ilmu Tajwid - Ustadz M. Ulin Nuha', 'https://www.youtube.com/watch?v=ztfrZn7jBx4&list=PLUuYlj8dcEXbyJzGAUYTSCfYr5EqLo0dy&index=2', '', 1, NULL, NULL, 1, '2021-10-22 00:17:45', '2021-10-22 06:05:07', NULL),
(3, 3, 3, 'Adab-Adab Membaca Al-Quran - Ustadz M. Ulin Nuha', 'https://www.youtube.com/watch?v=KDt7qcbfb_g&list=PLUuYlj8dcEXbyJzGAUYTSCfYr5EqLo0dy&index=3', '', 1, NULL, NULL, 1, '2021-10-22 00:17:45', '2021-10-22 06:05:10', NULL),
(4, 3, 4, 'Tingkatan Bacaan Al-Qur\'an', 'https://www.youtube.com/watch?v=6H9T2QvxDCg&list=PLUuYlj8dcEXbyJzGAUYTSCfYr5EqLo0dy&index=4', '', 1, NULL, NULL, 1, '2021-10-22 00:17:45', '2021-10-22 06:05:13', NULL),
(5, 3, 5, 'Bacaan Ta\'awudz Di Awal Surat - Ustadz M. Ulin Nuha - Serial Pelajaran Tahsin (05)', 'https://www.youtube.com/watch?v=rKtGi3CrWZw&list=PLUuYlj8dcEXbyJzGAUYTSCfYr5EqLo0dy&index=5', '', 1, NULL, NULL, 1, '2021-10-22 00:17:45', '2021-10-22 06:05:16', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `level`
--

CREATE TABLE `level` (
  `lev_id` int(11) NOT NULL,
  `lev_nama` varchar(50) NOT NULL,
  `lev_keterangan` text NOT NULL,
  `lev_status` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `level`
--

INSERT INTO `level` (`lev_id`, `lev_nama`, `lev_keterangan`, `lev_status`, `created_at`) VALUES
(1, 'Administrator', 'Super Administrator', 'Aktif', '2020-06-18 02:40:31'),
(2, 'Mentor', 'Mentor Konsultasi', 'Aktif', '2021-10-20 11:46:32');

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `id` int(11) NOT NULL,
  `mentor_id` int(11) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `no_telepon` varchar(255) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` varchar(255) DEFAULT NULL,
  `alamat` text NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `foto` varchar(255) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `parrent_id` int(11) DEFAULT NULL,
  `kode_referral` varchar(255) NOT NULL,
  `status` int(11) DEFAULT NULL COMMENT '0 Tidak Aktif | 1 Aktif | 2 Menunggu Pembayaran',
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`id`, `mentor_id`, `nama`, `no_telepon`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `password`, `email`, `foto`, `token`, `parrent_id`, `kode_referral`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 6, 'Eska Yulinda Rahayu', '085798132505', NULL, NULL, 'Cianjur', '$2y$10$NXyctYJcxQTOVH0qJSgPX.d6W8IowPywTZ0JK08OQs/1jMfk11lCe', 'eskayr@gmail.com', '5a93fd88386b9bb7b9c194a31fd7172b.png', 'duahati202110211058496170e57995b5f', NULL, 'UMJYG7P', 1, 1, 1, '2021-10-21 10:58:49', '2021-10-28 12:48:10', NULL),
(3, 6, 'Member 2', '085798132505', NULL, NULL, '', '$2y$10$6.3PXYQx5KKVWQJ5C9cYqeJ5HiyQH9sOSfw2HdyTuEgeX4tUj/gkC', '2@gmail.com', 'f3fcbb4ac7377f576efebf18050e2b11.png', 'duahati202110211106436170e753c600c', NULL, 'FHECNLZ', 1, 1, 1, '2021-10-21 11:06:43', '2021-10-28 12:09:11', NULL),
(4, 6, 'Member 3', '085798132505', NULL, NULL, 'Cianjur', '$2y$10$NZaMXT1ZhSJIA245iQoxk.wUfV7j2NZ3CY9sebJaufLQKE1HRBX02', 'member3@gmail.com', '', 'duahati202110270151266178f6ee1b17a', NULL, '123', 1, 1, 1, '2021-10-27 13:51:26', '2021-10-28 12:48:26', NULL),
(5, 24, 'Member 7', '+6285798132505', NULL, NULL, 'Alamat', '$2y$10$twC1snL5xVas0JeZWeKIX.KftU7cHK0/Qs4Hh.1m.qmyT1cbbe8Ua', 'member7@gmail.com', '190b014bbef8397dfbc40b956b4a8863.png', 'duahati20211028115555617a2d5b0e3fa', NULL, '6R1ECOB', 1, 1, 1, '2021-10-28 11:55:55', '2021-10-28 12:47:48', NULL),
(8, 24, 'Isep Lutpi Nur', '+6285798132505', NULL, NULL, '', '$2y$10$NXyctYJcxQTOVH0qJSgPX.d6W8IowPywTZ0JK08OQs/1jMfk11lCe', 'iseplutpi1@gmail.com', '', 'duahati20211028125454617a3b2ee7b3a', 3, '9AZO8K7', 2, NULL, NULL, '2021-10-28 12:54:54', '2021-10-28 13:18:23', NULL),
(9, 24, 'Isep Lutpi Nur', '+6285798132505', NULL, NULL, '', '$2y$10$vbTXAfAJ2qeW0XRB0dA4muQxKGrNuh3LN5HcmF4DYzcgVrcbgAosW', 'isep@gmail.com', '', 'duahati20211028052036617a79747b352', NULL, 'SO8B62V', 2, NULL, NULL, '2021-10-28 05:20:36', NULL, NULL),
(10, 24, 'Isep Lutpi Nur', '+6285798132505', NULL, NULL, '', '$2y$10$t0J84ZqXDiX51do.GIahs.mIht8oINwqAZN/bkPM2yVu.X5/9EzMW', 'member123@gmail.com', '', 'duahati20211028052123617a79a3ab072', NULL, 'C4SQA86', 2, NULL, NULL, '2021-10-28 05:21:23', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `member_kelas`
--

CREATE TABLE `member_kelas` (
  `id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `kelas_id` int(11) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `member_kelas`
--

INSERT INTO `member_kelas` (`id`, `member_id`, `kelas_id`, `created_by`, `updated_by`, `deleted_by`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(12, 2, 1, 1, NULL, 1, 3, '2021-10-27 03:05:20', '2021-10-27 03:05:27', '2021-10-27 03:05:27'),
(13, 2, 3, 1, NULL, 1, 3, '2021-10-27 03:05:35', '2021-10-27 03:05:50', '2021-10-27 03:05:50'),
(14, 2, 1, 1, NULL, 1, 3, '2021-10-27 03:05:43', '2021-10-27 03:05:52', '2021-10-27 03:05:52'),
(15, 2, 3, 1, NULL, NULL, 1, '2021-10-27 03:26:38', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `member_materi_tonton`
--

CREATE TABLE `member_materi_tonton` (
  `id` int(11) NOT NULL,
  `member_id` int(11) DEFAULT NULL,
  `kelas_id` int(11) NOT NULL,
  `kelas_materi_id` int(11) NOT NULL,
  `materi_feedback_nilai` int(11) NOT NULL,
  `materi_feedback_keterangan` text NOT NULL,
  `mentor_feedback_nilai` int(11) NOT NULL,
  `mentor_feedback_keterangan` text NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `member_materi_tonton`
--

INSERT INTO `member_materi_tonton` (`id`, `member_id`, `kelas_id`, `kelas_materi_id`, `materi_feedback_nilai`, `materi_feedback_keterangan`, `mentor_feedback_nilai`, `mentor_feedback_keterangan`, `created_by`, `updated_by`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(5, 2, 3, 1, 4, 'Feedback kedua', 4, 'Feedback pertama', NULL, NULL, 1, '2021-10-22 10:52:17', NULL, NULL),
(6, 3, 3, 1, 5, 'Member 2', 4, 'Member 2', NULL, NULL, 1, '2021-10-22 10:55:27', NULL, NULL),
(7, 3, 3, 2, 4, '', 4, '', NULL, NULL, 1, '2021-10-22 11:09:24', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `menu_id` int(11) NOT NULL,
  `menu_menu_id` int(11) NOT NULL,
  `menu_nama` varchar(50) NOT NULL,
  `menu_keterangan` text NOT NULL,
  `menu_index` int(11) NOT NULL,
  `menu_icon` varchar(50) NOT NULL,
  `menu_url` varchar(100) NOT NULL,
  `menu_status` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`menu_id`, `menu_menu_id`, `menu_nama`, `menu_keterangan`, `menu_index`, `menu_icon`, `menu_url`, `menu_status`, `created_at`) VALUES
(1, 0, 'Dashboard', '-', 1, 'fa fa-suitcase', 'dashboard', 'Aktif', '2020-06-17 19:40:07'),
(2, 0, 'Pengaturan', '-', 11, 'fa fa-cogs', '#', 'Aktif', '2020-06-17 19:40:07'),
(3, 2, 'Hak Akses', '-', 5, 'far fa-circle', 'pengaturan/hakAkses', 'Aktif', '2020-06-17 19:40:07'),
(4, 2, 'Menu', '-', 4, 'far fa-circle', 'pengaturan/menu', 'Aktif', '2020-06-17 19:40:07'),
(5, 2, 'Level', '-', 3, 'far fa-circle', 'pengaturan/level', 'Aktif', '2020-06-17 19:40:07'),
(6, 2, 'Pengguna', '-', 5, 'far fa-circle', 'pengaturan/pengguna', 'Aktif', '2020-06-17 19:40:07'),
(7, 0, 'Ganti Password', 'Ganti password', 99, 'fa fa-key', 'pengaturan/password', 'Aktif', '2021-06-28 01:34:14'),
(82, 0, 'Kelas', '-', 4, 'fas fa-book', '#', 'Aktif', '2021-08-25 02:03:41'),
(97, 2, 'Backup & Reset', '-', 6, 'fa fa-download', 'pengaturan/backupReset', 'Aktif', '2021-10-06 00:41:32'),
(104, 0, 'Member', '-', 3, 'fa fa-users', 'member/data', 'Aktif', '2021-10-12 11:56:14'),
(105, 0, 'Pertandingan', '-', 3, 'fas fa-list', 'pertandingan/#', 'Aktif', '2021-10-12 11:58:59'),
(106, 105, 'Master  ', '-', 1, 'far fa-circle', 'pertandingan/jadwal', 'Aktif', '2021-10-12 12:01:09'),
(107, 105, 'Tebak Score', '-', 2, 'far fa-circle', 'pertandingan/tebakScore', 'Aktif', '2021-10-12 12:01:37'),
(108, 105, 'Tebak Man Of The Match', '-', 3, 'far fa-circle', 'pertandingan/tebakMOTM', 'Aktif', '2021-10-12 12:02:26'),
(109, 105, 'Kursi Berhadiah', '-', 4, 'far fa-circle', 'pertandingan/kursiBerhadiah', 'Aktif', '2021-10-12 12:03:01'),
(110, 82, 'Team', '-', 1, 'far fa-circle', 'master/team', 'Aktif', '2021-10-12 12:03:46'),
(111, 82, 'Pemain', '-', 4, 'far fa-circle', 'master/pemain', 'Aktif', '2021-10-12 12:04:04'),
(112, 82, 'Stadion', '-', 2, 'far fa-circle', 'master/stadion', 'Aktif', '2021-10-12 12:04:25'),
(113, 82, 'Posisi', '-', 3, 'far fa-circle', 'master/posisi', 'Aktif', '2021-10-12 14:16:32'),
(114, 82, 'Kategori Kursi', '-', 5, 'far fa-circle', 'master/kategoriKursi', 'Aktif', '2021-10-13 09:01:24'),
(115, 82, 'Iklan', 'iklan', 1, 'far fa-circle', 'master/iklan', 'Aktif', '2021-10-19 17:47:24'),
(116, 0, 'Mentor', 'Menu Mentor', 3, 'fas fa-fw fa-user', 'mentor/data', 'Aktif', '2021-10-20 12:17:22'),
(117, 82, 'Data Kelas', '-', 1, 'far fa-circle', 'kelas/master', 'Aktif', '2021-10-20 12:22:56'),
(118, 82, 'Kategori', '-', 3, 'far fa-circle', 'kelas/kategori', 'Aktif', '2021-10-20 12:23:20'),
(119, 82, 'Materi', 'Materi Kelas', 2, 'far fa-circle', 'kelas/materi', 'Aktif', '2021-10-21 01:04:35'),
(120, 0, 'Slider', 'Silder di menu home', 2, 'far fa-image', 'slider/data', 'Aktif', '2021-10-21 10:26:49'),
(121, 0, 'News', '-', 5, 'fa fa-newspaper', '#', 'Aktif', '2021-10-28 10:23:58'),
(122, 121, 'Data News', '-', 1, 'fa fa-newspaper', 'news/master', 'Aktif', '2021-10-28 10:23:58'),
(123, 121, 'Komentar', '-', 2, 'far fa-circle', 'news/komentar', 'Aktif', '2021-10-28 10:23:58'),
(124, 2, 'Rekening', 'Rekening untuk registrasi invoice\n', 1, 'far fa-circle', 'pengaturan/rekening', 'Aktif', '2021-10-28 10:32:55');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `tanggal_terbit` datetime DEFAULT NULL,
  `status` int(11) NOT NULL COMMENT '0 = dibuat, 1 = disimpan, 2 = diterbitkan, 3 = tidak aktif, 99 = dihapus',
  `publisher` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `news_komentar`
--

CREATE TABLE `news_komentar` (
  `id` int(11) NOT NULL,
  `news_id` int(11) DEFAULT NULL,
  `member_id` int(11) DEFAULT NULL,
  `komentar` text NOT NULL,
  `status` int(11) DEFAULT NULL COMMENT '0 = dibuat, 1 = aktif, 2 = tidak aktif, 99 = dihapus',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `kode` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `kelas_id` int(11) DEFAULT NULL,
  `bank_nama` varchar(255) DEFAULT NULL,
  `no_rekening` varchar(255) DEFAULT NULL,
  `atas_nama` varchar(255) NOT NULL,
  `tanggal` date DEFAULT current_timestamp(),
  `jumlah_pembayaran` int(11) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `jenis` int(11) NOT NULL DEFAULT 1 COMMENT '1 pembayaran pendaftaran',
  `tipe` int(11) NOT NULL DEFAULT 1 COMMENT '1 Transfer Bank',
  `catatan` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '0 diajukan | 1 terima | 2 tolak',
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`kode`, `member_id`, `kelas_id`, `bank_nama`, `no_rekening`, `atas_nama`, `tanggal`, `jumlah_pembayaran`, `foto`, `jenis`, `tipe`, `catatan`, `status`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 2, 3, '123', '123', 'Isep Lutpi Nur', '2021-10-28', 10000, 'aae710740d537620922acecc25bcbf14.png', 1, 1, '', 0, NULL, NULL, NULL, '2021-10-28 14:40:43', '2021-10-28 15:32:28', '2021-10-28 09:40:23');

-- --------------------------------------------------------

--
-- Table structure for table `rekening`
--

CREATE TABLE `rekening` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `nama_bank` varchar(255) DEFAULT NULL,
  `no_rekening` varchar(255) NOT NULL,
  `atas_nama` varchar(255) NOT NULL,
  `keterangan` text NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL COMMENT '0 = tidak aktif, 1 = aktif',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rekening`
--

INSERT INTO `rekening` (`id`, `nama`, `nama_bank`, `no_rekening`, `atas_nama`, `keterangan`, `created_by`, `updated_by`, `deleted_by`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(16, 'Rekening Utama Kantor', 'Bank Rakyat Indonesia', '444 444 444 444', 'Isep Lutpi Nur', '1', 1, 1, 1, 3, '2021-10-28 17:51:57', '2021-10-28 17:53:05', '2021-10-28 17:53:05'),
(17, 'Rekening Utama Kantor', 'Bank Rakyat Indonesia', '444 444 444 444', 'Isep Lutpi Nur', '123', 1, NULL, NULL, 1, '2021-10-28 17:53:21', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role_aplikasi`
--

CREATE TABLE `role_aplikasi` (
  `rola_id` int(11) NOT NULL,
  `rola_menu_id` int(11) NOT NULL,
  `rola_lev_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `role_aplikasi`
--

INSERT INTO `role_aplikasi` (`rola_id`, `rola_menu_id`, `rola_lev_id`, `created_at`) VALUES
(1, 1, 1, '2021-10-20 11:49:31'),
(2, 82, 1, '2021-10-20 11:49:35'),
(9, 2, 1, '2021-10-20 12:15:21'),
(10, 3, 1, '2021-10-20 12:15:22'),
(11, 4, 1, '2021-10-20 12:15:23'),
(12, 5, 1, '2021-10-20 12:15:24'),
(13, 6, 1, '2021-10-20 12:15:27'),
(14, 97, 1, '2021-10-20 12:15:27'),
(15, 106, 1, '2021-10-20 12:15:29'),
(16, 107, 1, '2021-10-20 12:15:30'),
(17, 108, 1, '2021-10-20 12:15:30'),
(18, 109, 1, '2021-10-20 12:15:31'),
(19, 104, 1, '2021-10-20 12:15:32'),
(21, 7, 1, '2021-10-20 12:15:35'),
(22, 116, 1, '2021-10-20 12:17:30'),
(23, 117, 1, '2021-10-20 12:23:57'),
(24, 118, 1, '2021-10-20 12:24:27'),
(25, 119, 1, '2021-10-21 01:16:17'),
(26, 120, 1, '2021-10-21 10:27:08'),
(27, 121, 1, '2021-10-28 10:23:58'),
(28, 122, 1, '2021-10-28 10:23:58'),
(29, 123, 1, '2021-10-28 10:23:58'),
(30, 124, 1, '2021-10-28 10:33:13');

-- --------------------------------------------------------

--
-- Table structure for table `role_users`
--

CREATE TABLE `role_users` (
  `role_id` int(11) NOT NULL,
  `role_user_id` int(11) NOT NULL,
  `role_lev_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `role_users`
--

INSERT INTO `role_users` (`role_id`, `role_user_id`, `role_lev_id`, `created_at`) VALUES
(1, 1, 1, '2020-06-18 02:39:26'),
(59, 6, 2, '2021-10-20 22:21:07'),
(61, 8, 2, '2021-10-20 22:34:19'),
(66, 13, 1, '2021-10-20 22:43:44'),
(67, 14, 1, '2021-10-20 22:44:07'),
(68, 15, 1, '2021-10-20 22:44:17'),
(69, 16, 1, '2021-10-20 22:46:29'),
(70, 17, 1, '2021-10-20 22:46:55'),
(71, 18, 1, '2021-10-20 22:47:24'),
(72, 19, 1, '2021-10-20 22:47:42'),
(73, 20, 1, '2021-10-20 22:48:12'),
(74, 21, 1, '2021-10-20 22:49:39'),
(75, 22, 1, '2021-10-20 22:50:01'),
(76, 23, 1, '2021-10-20 22:51:04'),
(77, 24, 2, '2021-10-28 05:46:11');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_nama` varchar(50) NOT NULL,
  `user_tgl_lahir` date DEFAULT NULL,
  `user_jk` enum('Laki-Laki','Perempuan') DEFAULT NULL COMMENT 'Jenis Kelamin',
  `user_password` varchar(100) NOT NULL,
  `user_email` varchar(50) NOT NULL,
  `user_phone` varchar(15) NOT NULL,
  `user_foto` varchar(255) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `user_status` int(1) NOT NULL DEFAULT 0 COMMENT '0 Tidak Aktif | 1 Aktif | 2 Pendding',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_nama`, `user_tgl_lahir`, `user_jk`, `user_password`, `user_email`, `user_phone`, `user_foto`, `alamat`, `user_status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Soni Setiawan', NULL, NULL, '$2y$10$7XCVzUlzjXOTMq0s90XfMO6bR7Tb2xZB5LgxL1Lw6o2KqoeAi8Vjq', 'administrator@gmail.com', '08123123', NULL, '', 1, '2020-06-18 02:39:08', '2020-06-18 02:39:08', NULL),
(6, 'Isep Lutpi Nur', '2000-08-10', 'Laki-Laki', '$2y$10$Qg6RtVNkbkHfqq5qtXT/huWM2p4h5qyAo1aeOxMWJkj5jrlTsjVTC', 'iseplutpi@gmail.com', '+6285798132505', '26024ff4a1f5ebcb8998ece4b2dffcf0.png', 'Alamat', 1, '2021-10-20 22:21:07', '2021-10-26 18:51:11', NULL),
(8, 'Mentor 3', '2000-10-08', 'Laki-Laki', '$2y$10$VCMLcYbOuQF3ySRpK2DF5.z.ao7VYme7IwC5IyKBwOH8aHjFQJSWe', 'iseplutpi1008@gmail.com', '085798132505', '', 'Alamat', 3, '2021-10-20 22:34:19', NULL, '2021-10-20 22:39:54'),
(24, 'Mentor 2', '2021-10-28', 'Laki-Laki', '$2y$10$4KKQ6eINupd7PuKGIwSMr.NDAyxWjpvMq36vnoCMWk48GrMvx04FO', 'sales@gmail.com', '+6285798132505', '', 'dsfasdf', 1, '2021-10-28 05:46:11', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `harga_pendaftaran`
--
ALTER TABLE `harga_pendaftaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`),
  ADD KEY `deleted_by` (`deleted_by`);

--
-- Indexes for table `home_slider`
--
ALTER TABLE `home_slider`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`),
  ADD KEY `deleted_by` (`deleted_by`);

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_kategori` (`kategori_id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`),
  ADD KEY `deleted_by` (`deleted_by`);

--
-- Indexes for table `kelas_kategori`
--
ALTER TABLE `kelas_kategori`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`),
  ADD KEY `deleted_by` (`deleted_by`);

--
-- Indexes for table `kelas_materi`
--
ALTER TABLE `kelas_materi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kelas_id` (`kelas_id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`),
  ADD KEY `deleted_by` (`deleted_by`);

--
-- Indexes for table `level`
--
ALTER TABLE `level`
  ADD PRIMARY KEY (`lev_id`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parrent_id` (`parrent_id`),
  ADD KEY `mentor_id` (`mentor_id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `member_kelas`
--
ALTER TABLE `member_kelas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `member_id` (`member_id`),
  ADD KEY `kelas_id` (`kelas_id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`),
  ADD KEY `deleted_by` (`deleted_by`);

--
-- Indexes for table `member_materi_tonton`
--
ALTER TABLE `member_materi_tonton`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kelas_id` (`kelas_id`),
  ADD KEY `member_id` (`member_id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`),
  ADD KEY `kelas_materi_id` (`kelas_materi_id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`menu_id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`),
  ADD KEY `publisher` (`publisher`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`),
  ADD KEY `deleted_by` (`deleted_by`);

--
-- Indexes for table `news_komentar`
--
ALTER TABLE `news_komentar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `news_id` (`news_id`),
  ADD KEY `member_id` (`member_id`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`kode`),
  ADD KEY `member_id` (`member_id`),
  ADD KEY `kelas_id` (`kelas_id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`),
  ADD KEY `deleted_by` (`deleted_by`);

--
-- Indexes for table `rekening`
--
ALTER TABLE `rekening`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`),
  ADD KEY `deleted_by` (`deleted_by`);

--
-- Indexes for table `role_aplikasi`
--
ALTER TABLE `role_aplikasi`
  ADD PRIMARY KEY (`rola_id`),
  ADD KEY `rola_lev_id` (`rola_lev_id`),
  ADD KEY `rola_menu_id` (`rola_menu_id`);

--
-- Indexes for table `role_users`
--
ALTER TABLE `role_users`
  ADD PRIMARY KEY (`role_id`),
  ADD KEY `role_lev_id` (`role_lev_id`),
  ADD KEY `role_user_id` (`role_user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `harga_pendaftaran`
--
ALTER TABLE `harga_pendaftaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `home_slider`
--
ALTER TABLE `home_slider`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `kelas_kategori`
--
ALTER TABLE `kelas_kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `kelas_materi`
--
ALTER TABLE `kelas_materi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `level`
--
ALTER TABLE `level`
  MODIFY `lev_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `member_kelas`
--
ALTER TABLE `member_kelas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `member_materi_tonton`
--
ALTER TABLE `member_materi_tonton`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `menu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `news_komentar`
--
ALTER TABLE `news_komentar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `kode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `rekening`
--
ALTER TABLE `rekening`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `role_aplikasi`
--
ALTER TABLE `role_aplikasi`
  MODIFY `rola_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `role_users`
--
ALTER TABLE `role_users`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `harga_pendaftaran`
--
ALTER TABLE `harga_pendaftaran`
  ADD CONSTRAINT `harga_pendaftaran_ibfk_3` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `harga_pendaftaran_ibfk_4` FOREIGN KEY (`updated_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `harga_pendaftaran_ibfk_5` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `kelas`
--
ALTER TABLE `kelas`
  ADD CONSTRAINT `kelas_ibfk_1` FOREIGN KEY (`kategori_id`) REFERENCES `kelas_kategori` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `kelas_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `kelas_ibfk_3` FOREIGN KEY (`updated_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `kelas_ibfk_4` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `kelas_kategori`
--
ALTER TABLE `kelas_kategori`
  ADD CONSTRAINT `kelas_kategori_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `kelas_kategori_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `kelas_kategori_ibfk_3` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `kelas_materi`
--
ALTER TABLE `kelas_materi`
  ADD CONSTRAINT `kelas_materi_ibfk_1` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `kelas_materi_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `kelas_materi_ibfk_3` FOREIGN KEY (`updated_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `kelas_materi_ibfk_4` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `member`
--
ALTER TABLE `member`
  ADD CONSTRAINT `member_ibfk_1` FOREIGN KEY (`parrent_id`) REFERENCES `member` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `member_ibfk_2` FOREIGN KEY (`mentor_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `member_ibfk_3` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `member_ibfk_4` FOREIGN KEY (`updated_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `member_kelas`
--
ALTER TABLE `member_kelas`
  ADD CONSTRAINT `member_kelas_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `member` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `member_kelas_ibfk_2` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `member_kelas_ibfk_3` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `member_kelas_ibfk_4` FOREIGN KEY (`updated_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `member_kelas_ibfk_5` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `member_materi_tonton`
--
ALTER TABLE `member_materi_tonton`
  ADD CONSTRAINT `member_materi_tonton_ibfk_1` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `member_materi_tonton_ibfk_2` FOREIGN KEY (`member_id`) REFERENCES `member` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `member_materi_tonton_ibfk_3` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `member_materi_tonton_ibfk_4` FOREIGN KEY (`updated_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `member_materi_tonton_ibfk_5` FOREIGN KEY (`kelas_materi_id`) REFERENCES `kelas_materi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `news_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `news_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `news_ibfk_3` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `news_ibfk_4` FOREIGN KEY (`publisher`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `news_komentar`
--
ALTER TABLE `news_komentar`
  ADD CONSTRAINT `news_komentar_ibfk_1` FOREIGN KEY (`news_id`) REFERENCES `news` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `news_komentar_ibfk_2` FOREIGN KEY (`member_id`) REFERENCES `member` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `member` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pembayaran_ibfk_2` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `pembayaran_ibfk_3` FOREIGN KEY (`created_by`) REFERENCES `member` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `pembayaran_ibfk_4` FOREIGN KEY (`updated_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `pembayaran_ibfk_5` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `rekening`
--
ALTER TABLE `rekening`
  ADD CONSTRAINT `rekening_ibfk_3` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `rekening_ibfk_4` FOREIGN KEY (`updated_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `rekening_ibfk_5` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;
