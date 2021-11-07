-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 07, 2021 at 09:00 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.4.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `duahati`
--

-- --------------------------------------------------------

--
-- Table structure for table `biaya_pendaftaran`
--

CREATE TABLE `biaya_pendaftaran` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `nominal` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '0 tidak aktif | 1 aktif',
  `keterangan` text DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `biaya_pendaftaran`
--

INSERT INTO `biaya_pendaftaran` (`id`, `nama`, `nominal`, `status`, `keterangan`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Pendaftaran', 80000, 0, 'Registrasi Pertama', 1, 1, NULL, '2021-11-05 20:26:22', '2021-11-05 22:38:56', NULL),
(2, 'Promo 80%', 70000, 1, 'Promosi 2022', 1, 1, NULL, '2021-11-05 20:28:13', '2021-11-05 22:38:56', NULL),
(3, 'Promo 50%', 40000, 0, 'Promosi bulan desember 2021', 1, 1, NULL, '2021-11-05 20:39:25', '2021-11-05 20:57:53', NULL),
(4, 'Diskon 10%', 72000, 0, 'Diskon terbaru', 1, 1, NULL, '2021-11-05 20:57:51', '2021-11-05 22:27:16', NULL);

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
  `biaya_pendaftaran` int(11) NOT NULL DEFAULT 0,
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

INSERT INTO `member` (`id`, `mentor_id`, `nama`, `no_telepon`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `password`, `email`, `foto`, `token`, `parrent_id`, `kode_referral`, `biaya_pendaftaran`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 6, 'Eska Yulinda Rahayu', '+6285798132505', NULL, NULL, 'Cianjur', '$2y$10$NXyctYJcxQTOVH0qJSgPX.d6W8IowPywTZ0JK08OQs/1jMfk11lCe', 'eskayr@gmail.com', '5a93fd88386b9bb7b9c194a31fd7172b.png', 'duahati202110211058496170e57995b5f', NULL, 'UMJYG7P', 80000, 1, 1, 1, '2021-10-21 10:58:49', '2021-11-08 00:43:14', NULL),
(3, 6, 'Member 2', '+6285798132505', NULL, NULL, '', '$2y$10$6.3PXYQx5KKVWQJ5C9cYqeJ5HiyQH9sOSfw2HdyTuEgeX4tUj/gkC', '2@gmail.com', 'f3fcbb4ac7377f576efebf18050e2b11.png', 'duahati202110211106436170e753c600c', NULL, 'FHECNLZ', 80000, 1, 1, 1, '2021-10-21 11:06:43', '2021-11-08 00:43:14', NULL),
(4, 6, 'Member 3', '+6285798132505', NULL, NULL, 'Cianjur', '$2y$10$NZaMXT1ZhSJIA245iQoxk.wUfV7j2NZ3CY9sebJaufLQKE1HRBX02', 'member3@gmail.com', '', 'duahati202110270151266178f6ee1b17a', NULL, '123', 80000, 1, 1, 1, '2021-10-27 13:51:26', '2021-11-08 00:43:14', NULL),
(5, 24, 'Member 7', '+6285798132505', NULL, NULL, 'Alamat', '$2y$10$twC1snL5xVas0JeZWeKIX.KftU7cHK0/Qs4Hh.1m.qmyT1cbbe8Ua', 'member7@gmail.com', '190b014bbef8397dfbc40b956b4a8863.png', 'duahati20211028115555617a2d5b0e3fa', NULL, '6R1ECOB', 80000, 1, 1, 1, '2021-10-28 11:55:55', '2021-11-08 00:43:14', NULL),
(19, 24, 'Member 1', '+6285798132505', NULL, NULL, '', '$2y$10$DA8x/kDIPpcweRy4C93OY.Gsm3JWOP8FxxnmcBfGWqRTQkaGnniee', 'member1@gmail.com', '', 'duahati20211030023630617c4d3e39688', NULL, 'V978EO5', 80000, 1, NULL, NULL, '2021-10-30 02:36:30', '2021-11-08 00:43:05', NULL),
(20, 24, 'Member BAru 3', '+6285798132505', NULL, NULL, '', '$2y$10$AA/tS2bTAPPn4Hy1KJPsEOYm164WbWPdDYojtxig0VJbXboFbOeHa', 'baru3@gmail.com', '', 'duahati20211030032316617c58342b8a4', 2, 'NGUWRIC', 80000, 1, NULL, NULL, '2021-10-30 03:23:16', '2021-11-08 00:48:58', NULL),
(24, 6, 'Isep Lutpi Nur', '+6285798132505', NULL, NULL, '', '$2y$10$JkLJFKoF14AJ0XxbEBI7wu4EA3ks5lvAXL9ifPig0xxk6cvvGSaZm', 'administrator@gmail.com', '', 'duahati20211105100338618547ca73f76', 2, 'L6NR4ZK', 80000, 1, NULL, NULL, '2021-11-05 10:03:38', '2021-11-08 00:48:38', NULL),
(26, 24, 'Isep Lutpi Nur 1', '+6285798132505', NULL, NULL, '', '$2y$10$cfhGGL0Hy3aQ30KPrf.03OlQn78TvEWjQeXSW1tw9uSmSqCjUINjW', 'isep@gmail.com', '', 'duahati2021110510274161854d6d0bec8', NULL, 'KD175JB', 80000, 1, NULL, NULL, '2021-11-05 10:27:41', '2021-11-08 00:56:05', NULL);

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
(124, 2, 'Rekening', 'Rekening untuk registrasi invoice\n', 1, 'far fa-circle', 'pengaturan/rekening', 'Aktif', '2021-10-28 10:32:55'),
(125, 0, 'Tutorial', 'Tutorial', 5, 'far fa-lightbulb', 'tutorial/master', 'Aktif', '2021-11-02 07:55:41'),
(126, 2, 'Biaya Pendaftaran', 'Biaya pendaftaran', 2, ' far fa-circle', 'pengaturan/BiayaPendaftaran', 'Aktif', '2021-11-05 12:34:20'),
(127, 2, 'Referral Nominal Reward', 'Nominal referral reward', 2, ' far fa-circle', 'pengaturan/referralReward', 'Aktif', '2021-11-06 12:46:24'),
(128, 0, 'Referral', '-', 5, 'fas fa-dollar-sign', '#', 'Aktif', '2021-11-07 18:47:42'),
(129, 128, 'Pencairan', '-', 1, ' far fa-circle', 'referral/pencairan', 'Aktif', '2021-11-07 18:48:11');

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

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `judul`, `foto`, `deskripsi`, `tanggal_terbit`, `status`, `publisher`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '2.000 Pesantren Jawa Barat Sudah Miliki Unit Bisnis, Kang Emil: Pesantren Diharapkan Mandiri', '4319fcef1a7937f33811220f0ac2246a.jpg', '<p xss=removed><span xss=removed>JURNAL SOREANG</span>– Sebanyak 2.000 pesantren di Jawa Barat sudah memiliki unit bisnis melalui program One Pesantren One Product (OPOP).</p><p xss=removed>Upaya ini sebagai jalan kemandirian bagi pihak pesantren dan pemberdayaan masyarakat sekitarnya.</p><p xss=removed>“Pemprov Jabar mengalokasikan anggaran bisnis pesantren ini. Semuanya agar pesantren bisa lebih mandiri,” kata Gubernurnya Jabar, H. Ridwan Kamil atau <a href=\"https://jurnalsoreang.pikiran-rakyat.com/tag/Kang Emil\">Kang Emil</a> saat silaturahmi dengan jajaran <a href=\"https://jurnalsoreang.pikiran-rakyat.com/tag/MUI Jabar\">MUI Jabar</a> di kantor <a href=\"https://jurnalsoreang.pikiran-rakyat.com/tag/MUI Jabar\">MUI Jabar</a>, Rabu, 18 Agustus 2021.</p><p xss=removed>Acara dihadiri Ketua Umum <a href=\"https://jurnalsoreang.pikiran-rakyat.com/tag/MUI Jabar\">MUI Jabar</a>, Prof. KH. Rachmat Sjafei, Sekum <a href=\"https://jurnalsoreang.pikiran-rakyat.com/tag/MUI Jabar\">MUI Jabar</a>, KH. Rafani Achyar, ketua Dewan Pertimbangan <a href=\"https://jurnalsoreang.pikiran-rakyat.com/tag/MUI Jabar\">MUI Jabar</a> KH. Miftah Faridl, perwakilan Kodam III/Siliwangi dan Kanwil Kemenag Jabar serta Ustaz Adi Hidayat.</p><p xss=removed>Ratusan pengurus MUI kabur/kota se-Jawa Barat juga ikut dalam acara melalui aplikasi zoom. Para peserta Pendidikan Kader Ulama (PKU) juga ikut dalam acara secara virtual.</p><p xss=removed>Dalam kesempatan itu, Ustaz Adi Hidayat memberikan bantuan.paket imunitas untuk Covid-19 untuk warga Jawa Barat yang terdampak pandemi.</p><p xss=removed>Lebih jauh, <a href=\"https://jurnalsoreang.pikiran-rakyat.com/tag/Kang Emil\">Kang Emil</a> menyatakan, lembaga keagamaan dan pendidikan bisa jadi agen perubahan dan pemberdayaan masyarakat.</p><p xss=removed>“Selain membantu unit usaha pesantren, Pemprov Jabar juga membantu dalam pengiriman satu desa satu hafiz Alquran, English for ulama dan mengirimkan ulama ke luar negeri,” ujarnya.</p><p xss=removed>Mengenai pembukaan masjid maupun kegiatan keagamaan, <a href=\"https://jurnalsoreang.pikiran-rakyat.com/tag/Kang Emil\">Kang Emil</a> menyatakan, bisa dilakukan kalau masyarakat disiplin protokol kesehatan.</p><p xss=removed>“Minimal dengan memakai masker karena bisa menekan penyebaran Covid-19. Selain itu, 70 persen warga sudah menjalani vaksinasi sehingga sudah ada kekebalan komunal,” katanya.</p><p xss=removed>Gubernur merasa optimistis merdeka dari Covid-19 bisa terjadi tahun depan kalau usaha vaksinasi dan protokol kesehatan berjalan optimal.</p><p xss=removed>“Semoga pak presiden nantinya menyatakan Indonesia merdeka dari Covid-19. Kalau sudah begitu membuat warga bisa bebas untuk aktivitas seperti biasanya,” katanya.***</p>', '2021-10-30 03:28:00', 2, 1, 1, 1, NULL, '2021-10-30 03:32:02', '2021-11-01 13:11:56', NULL),
(2, 'Ulama dan Umara Tentukan Kebaikan Umat, Forpimda Jabar Sambangi MUI Jabar', '9b0732dc600c01f49a88da3c3045121d.jpg', '<p xss=removed><span xss=removed>JURNAL SOREANG</span>– Memperingati kemerdekaan RI, hari jadi Jabar dan tahun baru Islam, <a href=\"https://jurnalsoreang.pikiran-rakyat.com/tag/MUI Jabar\" xss=removed>MUI Jabar</a> menggelar <a href=\"https://jurnalsoreang.pikiran-rakyat.com/tag/silaturahmi\" xss=removed>silaturahmi</a> dengan Forum Pimpinan Daerah (<a href=\"https://jurnalsoreang.pikiran-rakyat.com/tag/Forpimda\" xss=removed>Forpimda</a>) Jabar, Rabu, 18 Agustus 2021.</p><p xss=removed>Silaturahmi itu sebagai upaya menjalin kerja sama antara alim ulama dan umara (pemerintah) karena menentukan kebaikan umat.</p><p xss=removed>Hal itu dikatakan Ketua Umum <a href=\"https://jurnalsoreang.pikiran-rakyat.com/tag/MUI Jabar\" xss=removed>MUI Jabar</a>, Prof. KH. Rachmat Sjafei didampingi Sekum <a href=\"https://jurnalsoreang.pikiran-rakyat.com/tag/MUI Jabar\" xss=removed>MUI Jabar</a>, KH. Rafani Achyar.</p><p xss=removed>Hadir dalam <a href=\"https://jurnalsoreang.pikiran-rakyat.com/tag/silaturahmi\" xss=removed>silaturahmi</a> di antaranya Gubernur Jabar Dr. H. Ridwan Kamil, ST. Mud, ketua Dewan Pertimbangan <a href=\"https://jurnalsoreang.pikiran-rakyat.com/tag/MUI Jabar\" xss=removed>MUI Jabar</a> KH. Miftah Faridl, perwakilan Kodam III/Siliwangi, Polda Jabar, dan Kanwil Kemenag Jabar serta Ustaz Adi Hidayat.</p><p xss=removed>Lebih jauh Kiai Rachmat Sjafei mengatakan, kerja sama yang baik bisa dijamin dari <a href=\"https://jurnalsoreang.pikiran-rakyat.com/tag/silaturahmi\" xss=removed>silaturahmi</a> ini.</p><p xss=removed>“Apalagi dalam situasi pandemi ini membuat MUI menjadi rujukan masyarakat dalam bertanya soal ibadah. Misalnya, bagaimana hukum ibadah shalat dan ibadah lainnya saat pandemi ini,” ujarnya dalam acara dihadiri para pengurus MUI kabupaten/kota se-Jawa Barat secara virtual.</p><p xss=removed>Demikian juga dengan banyaknya <a href=\"https://jurnalsoreang.pikiran-rakyat.com/tag/fatwa\" xss=removed>fatwa</a> yang sudah dikeluarkan MUI berkaitan dengan ibadah saat pandemi maupun <a href=\"https://jurnalsoreang.pikiran-rakyat.com/tag/vaksinasi\" xss=removed>vaksinasi</a> dan lain-lainnya.</p><p xss=removed>“Kami mohon agar masjid-masjid dijadikan sentra <a href=\"https://jurnalsoreang.pikiran-rakyat.com/tag/vaksinasi\" xss=removed>vaksinasi</a> agar bisa mempercepat tercapainya kekebalan komunal. Kalau pesantren sudah mulai mengikuti <a href=\"https://jurnalsoreang.pikiran-rakyat.com/tag/vaksinasi\" xss=removed>vaksinasi</a> dengan target 3 juta santri,” katanya.</p><p xss=removed>Sedangkan Ridwan Kamil menyatakan, masyarakat harus tetap bersyukur di saat pandemi karena masih diberi kesehatan.</p><p xss=removed>“Karena dari 605 ulama yang meninggal dunia akibat Covid-19, maka sebanyak 200 ulama berasal dari Jawa Barat. Semoga pandemi ini segera bisa dikendalikan bahkan diakhiri,” ujarnya.</p><p xss=removed>Demikian juga dengan nikmat bisa bertemu tatap muka karena saat pandemi semuanya dibatasi.</p><p xss=removed>“Tenyata nikmat bertemu dan bicara tatap muka ini sangat mahal harganya. Saat PPKM ini banyak warga yang berupaya dengan cara apa pun agar bisa bertemu dengan keluarganya di kampung,” katanya.</p><p xss=removed>Bahkan, nikmat kemerdekaan juga sangat besar sebab sudah banyak negara yang bubar akibat peperangan seperti Yugoslavia dan Uni Soviet.</p><p xss=removed>“Betapa hebatnya Yugoslavia dan Uni Soviet pada masa lalu, tapi kini tak ada lagi kedua negara itu,” katanya.***</p>', '2021-10-30 03:33:00', 2, 1, 1, 1, NULL, '2021-10-30 03:34:02', '2021-11-01 13:13:09', NULL),
(3, 'MUI Jabar Minta Masyarakat Tenang Sikapi Puisi Sukmawati', 'c70eedd2c00d763bd7a5a3583f891afd.jpg', '<p xss=removed>Majelis Ulama Indonesia (MUI) Jawa Barat meminta seluruh masyarakat tetap tenang dan tidak bertindak berlebihan menyikapi puisi berjudul Ibu Indonesia karya Sukmawati Soekarnoputri. Menurut Ketua MUI Jawa Barat, Rachmat Syafei, ia berharap permasalahan ini tak merusak kondusifitas yang sudah terjaga.</p><div id=\"div-gpt-ad-1513840706181-0\" class=\"ads detail_text\" xss=removed></div><p xss=removed>Rachmat Syafei mengatakan, bahwa perdamaian tetap harus dikedepankan sebagai prinsip kehidupan bernegara. Apalagi, yang bersangkutan sudah meminta maaf dan mengaku tidak ada maksud untuk menghina agama islam.</p><p xss=removed>“(Sukmawati) sudah meminta maaf dan akan memperbaiki karena ketidaktahuannya. Maafkan saja, pandangan (memaafkan) itu juga berdasarkan agama,” ujar Rachmat saat ditemui di Kantor MUI Jawa Barat, Kota Bandung, Jumat (5/4).</p><p xss=removed>Rachmat berharap, masyarakat pun tak sampai menghakimi di luar batasan agama. Sebab, jika berlebihan sama saja telah berbuat dzalim. Rachmat pun mempersilahkan jika ada ormas islam atau masyarakat yang ingin melakukan unjuk rasa. Namun, semua harus dalam koridor aturan yang berlaku. Selebihnya, MUI Jabar akan manut dengan sikap MUI pusat.</p><p xss=removed>Kalau demo, silahkan karena itu hak yang dilindungi undang undang. Tapi jangan membuat kemudaratan (merugikan),” kata Rachmat serayab mempersilakan kalau ada masyarakat yang memilki pandangan tapi tetap harus mengingat bahwa kemaslahatan harus didahulukan.</p><p xss=removed>Seperti diketahui, puisi yang dibacakan Sukmawati dalam acara 29 tahun Anne Avantie berkarya, Rabu (28/3) lalu mendapat respon dari masyarakat. Bahkan diantaranya berujung pada pelaporan kepada kepolisian.</p><p xss=removed>Tercatat, sudah ada dua laporan yang diterima Polda Metro Jaya terkait puisi tersebut. Kedua pelapor adalah pengacara bernama Denny Adrian Kushidayat dan politikus Partai Hanura, Amron Asyhari yang mendatangi Markas Polda Metro Jaya, Selasa (3/4/2018).</p><p xss=removed>Laporan Denny bernomor LP/1782/IV/2018/PMJ/Dit.Reskrimum atas dugaan Penistaan Agama Islam sebagaimana diatur dalam Pasal 156 A KUHP dan atau Pasal 16 UU Nomor 40 tahun 2008 tentang penghapusan diskriminasi Ras dan Etnis.</p><p xss=removed>Sedangkan laporan Amron bernomor LP/1785/IV/2018/PMJ/Dit.Reskrimum dengan dugaan Penistaan Agama Islam sebagaimana diatur dalam Pasal 156 A KUHP. Amron berharap polisi bertindak tegas dan profesional dalam mengusut laporan ini.</p><p xss=removed>Tak hanya ke Polda Metro Jaya, Sukmawati Soekarnoputri juga akan dilaporkan ke Bareskrim Polri. Laporan itu akan dilayangkan Forum Umat Islam Bersatu (FUIB) pada Kamis 4 April. Selain itu, sejumlah ormas pun melakukan unjuk rasa meminta pihak berwajib melanjutkan proses hokum untuk puteri presiden pertama Indonesia, Soekarno tersebut.</p><p xss=removed>(REPUBLIKA.CO.ID, BANDUNG)</p>', '2021-10-30 03:34:00', 2, 1, 1, 1, NULL, '2021-10-30 03:34:53', '2021-10-30 03:42:48', NULL),
(4, 'MUI Jabar Kecam Pernyataan Kontroversial Trump Soal Yerusalem Ibu Kota Israel', '8d3bae9bfc29f583ec4faa3fd0fb93ac.jpg', '<div dir=\"auto\" xss=removed>Majelis Ulama Indonesia (MUI) Jawa Barat mengecam pernyataan Presiden Amerika Serikat, Donald Trump, yang secara menyebut Yerusalem sebagai ibu kota Israel.</div><div dir=\"auto\" xss=removed>“Nanti wilayah Palestina habis tidak tersisa lagi kalau Yerusalem jadi ibu kota Israel,” kata Sekretaris Umum MUI Jawa Barat, Drs HM Rafani Akhyar M Si, Jumat (8/12/2017).</div><div dir=\"auto\" xss=removed>Ia mengatakan, sejak dulu Amerika Serikat sudah menerapkan kebijakan dua kaki terkait Israel dan Palestina.</div><div dir=\"auto\" xss=removed>Di satu sisi membela Hak Asasi Manusia (HAM) dan di sisi lain tak hentinya menyokong kekuatan kepada Israel.</div><div dir=\"auto\" xss=removed>“Israel sudah kuat didukung terus, Palestina yang lemah jadi semakin tertindas,” ujar Rafani Akhyar saat ditemui di kantor MUI Jawa Barat, Jalan RE Martadinata, Kota Bandung.</div><div dir=\"auto\" xss=removed></div><div dir=\"auto\" xss=removed>Amerika Serikat harus menyadari kekuatannya sebagai negara super power telah menurun.</div><div dir=\"auto\" xss=removed>Rafani yang saat ditemui mengenakan batik cokelat itu menilai, banyaknya permasalahan di Amerika Serikat membuat  Trump mencoba mengalihkan isu dengan mengatakan hal demikian.</div><div dir=\"auto\" xss=removed>Sepanjang sejarah Amerika Serikat, kata dia, baru kali ini rakyatnya berdemonstrasi meminta presidennya turun.</div><div dir=\"auto\" xss=removed>“Donald Trump sebagai presiden harus membaca keadaan negara yang dipimpinnya. Bukan malah seenaknya mendikte Palestina dan menetapkan Yerusalem sebagai ibu kota Israel. Super powernya sudah menurun. Korea Utara baru uji coba nuklir saja sudah ketar-ketir,” kata Rafani Akhyar.</div><div dir=\"auto\" xss=removed>(dilansir dari tribun jabar jumat 8 desember 2017)</div>', '2021-10-30 03:35:00', 2, 1, 1, 1, NULL, '2021-10-30 03:35:30', '2021-11-01 13:14:16', NULL),
(5, 'Ustaz Adi Hidayat: Berbanggalah Jadi Warga Indonesia Sebab Keturunan Langsung Nabi Ibrahim', '4fea0582c8e2f3ac5e331aa750686d39.jpg', '<p xss=removed><span xss=removed>JURNAL SOREANG</span>–<a href=\"https://jurnalsoreang.pikiran-rakyat.com/tag/Ustaz Adi Hidayat\">Ustaz Adi Hidayat</a> mengajak masyarakat Indonesia untuk bersyukur karena hidup di Indonesia yang alamnya subur.</p><p xss=removed>Selain itu, <a href=\"https://jurnalsoreang.pikiran-rakyat.com/tag/warga Indonesia\">warga Indonesia</a> juga masih <a href=\"https://jurnalsoreang.pikiran-rakyat.com/tag/keturunan\">keturunan</a> langsung dari <a href=\"https://jurnalsoreang.pikiran-rakyat.com/tag/Nabi Ibrahim\">Nabi Ibrahim</a> dari jalur ketiga.</p><p xss=removed>“Ternyata istri <a href=\"https://jurnalsoreang.pikiran-rakyat.com/tag/Nabi Ibrahim\">Nabi Ibrahim</a> ada empat yakni Siti Sarah, Siti Hajar, Qantarah binti Alyakfan dan Aminah. Istri ketiga ini yang menjadi silsilah bagi <a href=\"https://jurnalsoreang.pikiran-rakyat.com/tag/keturunan\">keturunan</a> ke Asia Tenggara termasuk Indonesia,” kata <a href=\"https://jurnalsoreang.pikiran-rakyat.com/tag/Ustaz Adi Hidayat\">Ustaz Adi Hidayat</a> dalam silaturahmi MUI Jabar di kantor MUI Jabar, Rabu 18 Agustus 2021.</p><p xss=removed>Acara dihadiri Gubernur Jabar H. Ridwan Kamil, Ketua Umum MUI Jabar, Prof. KH. Rachmat Sjafei, Sekum MUI Jabar, KH. Rafani Achyar, ketua Dewan Pertimbangan MUI Jabar KH. Miftah Faridl, perwakilan Kodam III/Siliwangi dan Kanwil Kemenag Jabar.</p><p xss=removed>Ratusan pengurus MUI kabur/kota se-Jawa Barat juga ikut dalam acara melalui aplikasi zoom. Para peserta Pendidikan Kader Ulama (PKU) juga ikut dalam acara secara virtual.</p><p xss=removed>Dalam kesempatan itu, <a href=\"https://jurnalsoreang.pikiran-rakyat.com/tag/Ustaz Adi Hidayat\">Ustaz Adi Hidayat</a> memberikan bantuan.paket suplemen memperkuat imunitas untuk warga Jawa Barat yang terdampak pandemi.</p><p xss=removed>Lebih jauh Ustaz Adi mengatakan, Indonesia merupakan negara yang sangat strategis dari sisi apa pun.</p><p xss=removed>“Saya senang melakukan riset terhadap Indonesia dan subhanallah betapa hebatnya Indonesia,” katanya.</p><p xss=removed>Mengenai pandemi Covid-19, <a href=\"https://jurnalsoreang.pikiran-rakyat.com/tag/Ustaz Adi Hidayat\">Ustaz Adi Hidayat</a> menyatakan, sudah 13 abad lalu alim ulama sudah menyatakan soal penanganan wabah ini.</p><p xss=removed>“Alim ulama dengan merujuk kepada Al-Qur’an dan hadis ternyata sudah memiliki banyak iatilah baik lockdown, PPKM dan lain-lain. Intinya wabah dari virus adalah tak nampak sehingga harus dihadapi dengan kekuatan terbaik dari semua kalangan,” katanya.</p><p xss=removed>Demikian pula dengan kasus hoaks saat pandemi juga sudah terjadi sejak lama misalnya saat wabah kolera ketika kepemimpinan Khalifah Umar bin Khattab.</p><p xss=removed>“Saat itu warga sangat gelisah dengan maraknya hoaks. Akhirnya semua kalangan baik ulama dan tenaga kesehatan memberikan penjelasan agar warga tenang kembali,” katanya.</p><p xss=removed><a href=\"https://jurnalsoreang.pikiran-rakyat.com/tag/Ustaz Adi Hidayat\">Ustaz Adi Hidayat</a> mengimbau agar semua komponen bangsa bisa bersatu menghadapi semua ancaman.</p><p xss=removed>“Jangan sampai Indonesia terpecah belah karena fitnah maupun hoaks. TNI dan Polri harus diperkuat untuk menghadapi ancaman,” katanya.***</p><div><br></div><div class=\"blog-share text-center\" xss=removed></div>', '2021-10-30 05:01:00', 2, 1, 1, 1, NULL, '2021-10-30 05:01:33', '2021-11-01 13:14:27', NULL);

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

--
-- Dumping data for table `news_komentar`
--

INSERT INTO `news_komentar` (`id`, `news_id`, `member_id`, `komentar`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 5, 19, 'Testing komentar', 1, '2021-11-01 13:37:39', NULL, NULL),
(2, 5, 19, 'Testing komentar', 1, '2021-11-01 13:38:56', NULL, NULL),
(3, 5, 19, 'dsafsadfsdf', 1, '2021-11-02 08:33:39', NULL, NULL),
(4, 5, 19, 'Testing Komentar wkwk', 1, '2021-11-02 09:01:21', NULL, NULL),
(5, 5, 19, 'Testing Komentar wkwk', 1, '2021-11-02 09:01:37', NULL, NULL),
(6, 5, 19, 'Komentar 5 GAnti', 1, '2021-11-02 09:02:30', NULL, NULL),
(7, 4, 19, 'Komentar baru', 1, '2021-11-02 09:03:18', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id` int(11) NOT NULL,
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

INSERT INTO `pembayaran` (`id`, `member_id`, `kelas_id`, `bank_nama`, `no_rekening`, `atas_nama`, `tanggal`, `jumlah_pembayaran`, `foto`, `jenis`, `tipe`, `catatan`, `status`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(12, 19, NULL, 'Bank BRI', '12345679', 'Isep Lutpi Nur', '2021-10-30', NULL, '585e5e758c05904453754a61ed8fab00.png', 1, 1, 'Tolak Bukti tidak valid', 2, NULL, 1, NULL, '2021-10-30 02:36:59', '2021-10-30 03:17:07', NULL),
(14, 19, NULL, 'Bank BRI', '123', 'Isep Lutpi Nur', '2021-10-23', 80000, '7e5529d0057fcc3cc89a2ba664018771.jpeg', 1, 1, 'Bukti Valid', 1, NULL, 1, NULL, '2021-10-30 02:46:51', '2021-10-30 03:17:23', NULL),
(15, 20, NULL, 'Bank BRI', '798562456', 'Member 3', '2021-10-23', 80000, '1cca08b3c1cea472f5a0818c67eec9c8.jpg', 1, 1, '', 1, NULL, 1, NULL, '2021-10-30 03:23:46', '2021-11-08 01:17:19', NULL),
(19, 24, NULL, 'Bank Rakyat Indonesia', '123', 'Isep Lutpi Nur', '2021-11-06', 80000, '2be09357c5ff6a65a5c118eeee61dee7.png', 1, 1, 'Bukti tidak valid', 2, NULL, 1, NULL, '2021-11-06 13:41:38', '2021-11-08 00:44:27', NULL),
(20, 24, NULL, 'Bank Rakyat Indonesia', '1234', 'Isep Lutpi Nur', '2021-11-08', 80000, '788d29b6bc209e54a1bf092da66882a0.png', 1, 1, '', 1, NULL, 1, NULL, '2021-11-08 00:47:14', '2021-11-08 01:16:44', NULL),
(21, 26, NULL, 'Bank Rakyat Indonesia', '1234', 'isep@gmail.com', '2021-11-08', 80000, '678e6581ad5000ad4bc4c15de34bd527.png', 1, 1, '', 1, NULL, 1, NULL, '2021-11-08 00:54:41', '2021-11-08 01:16:26', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `referral`
--

CREATE TABLE `referral` (
  `id` int(11) NOT NULL,
  `member_id` int(11) DEFAULT NULL,
  `total_pendapatan` int(11) DEFAULT 0,
  `dicairkan` int(11) DEFAULT 0,
  `belum_dicairkan` int(11) DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '0 tidak aktif, 1 aktif',
  `catatan` text DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `referral`
--

INSERT INTO `referral` (`id`, `member_id`, `total_pendapatan`, `dicairkan`, `belum_dicairkan`, `status`, `catatan`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(9, 2, 80000, 0, 30000, 1, NULL, NULL, NULL, NULL, '2021-11-07 13:37:50', '2021-11-08 02:51:02', NULL),
(10, 3, 0, 0, 0, 1, NULL, NULL, NULL, NULL, '2021-11-07 13:37:50', '2021-11-08 00:37:34', NULL),
(11, 4, 0, 0, 0, 1, NULL, NULL, NULL, NULL, '2021-11-07 13:37:50', '2021-11-08 00:37:34', NULL),
(12, 5, 0, 0, 0, 1, NULL, NULL, NULL, NULL, '2021-11-07 13:37:50', '2021-11-08 00:37:34', NULL),
(13, 19, 0, 0, 0, 1, NULL, NULL, NULL, NULL, '2021-11-07 13:37:50', '2021-11-08 00:37:34', NULL),
(14, 20, 0, 0, 0, 1, NULL, NULL, NULL, NULL, '2021-11-07 13:37:50', '2021-11-08 00:37:34', NULL),
(15, 24, 0, 0, 0, 1, NULL, NULL, NULL, NULL, '2021-11-07 13:37:50', '2021-11-08 00:37:34', NULL),
(22, 26, 0, 0, 0, 1, NULL, NULL, NULL, NULL, '2021-11-08 01:02:47', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `referral_nominal`
--

CREATE TABLE `referral_nominal` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `nominal` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '0 tidak aktif | 1 aktif',
  `keterangan` text DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `referral_nominal`
--

INSERT INTO `referral_nominal` (`id`, `nama`, `nominal`, `status`, `keterangan`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Promo Referral', 80000, 0, 'Registrasi Pertama', 1, 1, NULL, '2021-11-05 20:26:22', '2021-11-08 00:48:25', NULL),
(2, 'Promo 80%', 70000, 0, 'Promosi 2022', 1, 1, NULL, '2021-11-05 20:28:13', '2021-11-06 19:53:15', NULL),
(3, 'Promo 50%', 40000, 1, 'Promosi bulan desember 2021', 1, 1, NULL, '2021-11-05 20:39:25', '2021-11-08 00:48:25', NULL),
(4, 'Diskon 10%', 72000, 0, 'Diskon terbaru', 1, 1, NULL, '2021-11-05 20:57:51', '2021-11-05 22:27:16', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `referral_pencairan`
--

CREATE TABLE `referral_pencairan` (
  `id` int(11) NOT NULL,
  `member_id` int(11) DEFAULT NULL,
  `atas_nama` varchar(255) DEFAULT NULL,
  `nama_bank` varchar(255) DEFAULT NULL,
  `no_rekening` varchar(255) DEFAULT NULL,
  `jumlah_dana` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '0 diajukan | 1 dicairkan | 2 tolak | 3 dibatalkan',
  `catatan` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `tanggal_respon` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `referral_pencairan`
--

INSERT INTO `referral_pencairan` (`id`, `member_id`, `atas_nama`, `nama_bank`, `no_rekening`, `jumlah_dana`, `status`, `catatan`, `foto`, `tanggal_respon`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(7, 2, 'Isep Lutpi Nur', 'Bank Rakyat Indonesia', '3263201008000006', 50000, 1, 'Bukti terlampir', 'cd3310b94f0b22307c436785f2f30f69.png', '2021-11-08 02:51:02', NULL, 1, NULL, '2021-11-08 01:52:40', '2021-11-08 02:51:02', NULL),
(8, 2, 'Member 3', 'Bank Rakyat Indonesia', '123', 30000, 0, NULL, NULL, NULL, NULL, NULL, NULL, '2021-11-08 02:58:37', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `referral_transaksi`
--

CREATE TABLE `referral_transaksi` (
  `id` int(11) NOT NULL,
  `member_id` int(11) DEFAULT NULL,
  `jumlah_dana` int(11) DEFAULT NULL,
  `jenis` int(11) NOT NULL DEFAULT 0 COMMENT '0 keluar | 1 masuk',
  `dari_member_id` int(11) DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `referral_transaksi`
--

INSERT INTO `referral_transaksi` (`id`, `member_id`, `jumlah_dana`, `jenis`, `dari_member_id`, `catatan`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(5, 2, 40000, 1, 24, NULL, NULL, NULL, NULL, '2021-11-08 01:16:44', NULL, NULL),
(6, 2, 40000, 1, 20, NULL, NULL, NULL, NULL, '2021-11-08 01:17:19', NULL, NULL),
(10, 2, 50000, 0, NULL, NULL, NULL, NULL, NULL, '2021-11-08 02:51:02', NULL, NULL);

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
(11, 4, 1, '2021-10-20 12:15:23'),
(12, 5, 1, '2021-10-20 12:15:24'),
(13, 6, 1, '2021-10-20 12:15:27'),
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
(30, 124, 1, '2021-10-28 10:33:13'),
(31, 125, 1, '2021-11-02 07:56:03'),
(32, 126, 1, '2021-11-05 12:34:33'),
(33, 127, 1, '2021-11-06 12:46:33'),
(34, 128, 1, '2021-11-07 18:48:21'),
(35, 129, 1, '2021-11-07 18:48:22');

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
-- Table structure for table `tutorial`
--

CREATE TABLE `tutorial` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `url` varchar(255) NOT NULL,
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
-- Dumping data for table `tutorial`
--

INSERT INTO `tutorial` (`id`, `nama`, `url`, `keterangan`, `foto`, `status`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(6, 'Tutorial 1', 'https://www.youtube.com/watch?v=N9oKp6orIQQ', '123', '9eb2cefa70d7c09097db0cee991ff135.jpeg', 1, 1, 1, NULL, '2021-11-02 15:25:04', '2021-11-02 17:10:54', NULL);

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
-- Indexes for table `biaya_pendaftaran`
--
ALTER TABLE `biaya_pendaftaran`
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
  ADD PRIMARY KEY (`id`),
  ADD KEY `member_id` (`member_id`),
  ADD KEY `kelas_id` (`kelas_id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`),
  ADD KEY `deleted_by` (`deleted_by`);

--
-- Indexes for table `referral`
--
ALTER TABLE `referral`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `member_id_2` (`member_id`,`status`),
  ADD KEY `member_id` (`member_id`),
  ADD KEY `deleted_by` (`deleted_by`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `referral_nominal`
--
ALTER TABLE `referral_nominal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`),
  ADD KEY `deleted_by` (`deleted_by`);

--
-- Indexes for table `referral_pencairan`
--
ALTER TABLE `referral_pencairan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `member_id` (`member_id`),
  ADD KEY `deleted_by` (`deleted_by`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `referral_transaksi`
--
ALTER TABLE `referral_transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `member_id` (`member_id`),
  ADD KEY `deleted_by` (`deleted_by`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`),
  ADD KEY `dari_member_id` (`dari_member_id`);

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
-- Indexes for table `tutorial`
--
ALTER TABLE `tutorial`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`),
  ADD KEY `deleted_by` (`deleted_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `biaya_pendaftaran`
--
ALTER TABLE `biaya_pendaftaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

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
  MODIFY `menu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `news_komentar`
--
ALTER TABLE `news_komentar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `referral`
--
ALTER TABLE `referral`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `referral_nominal`
--
ALTER TABLE `referral_nominal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `referral_pencairan`
--
ALTER TABLE `referral_pencairan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `referral_transaksi`
--
ALTER TABLE `referral_transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `rekening`
--
ALTER TABLE `rekening`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `role_aplikasi`
--
ALTER TABLE `role_aplikasi`
  MODIFY `rola_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `role_users`
--
ALTER TABLE `role_users`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `tutorial`
--
ALTER TABLE `tutorial`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `biaya_pendaftaran`
--
ALTER TABLE `biaya_pendaftaran`
  ADD CONSTRAINT `biaya_pendaftaran_ibfk_3` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `biaya_pendaftaran_ibfk_4` FOREIGN KEY (`updated_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `biaya_pendaftaran_ibfk_5` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE;

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
-- Constraints for table `referral`
--
ALTER TABLE `referral`
  ADD CONSTRAINT `referral_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `member` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `referral_ibfk_2` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `referral_ibfk_3` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `referral_ibfk_4` FOREIGN KEY (`updated_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `referral_pencairan`
--
ALTER TABLE `referral_pencairan`
  ADD CONSTRAINT `referral_pencairan_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `member` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `referral_pencairan_ibfk_2` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `referral_pencairan_ibfk_3` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `referral_pencairan_ibfk_4` FOREIGN KEY (`updated_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `referral_transaksi`
--
ALTER TABLE `referral_transaksi`
  ADD CONSTRAINT `referral_transaksi_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `member` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `referral_transaksi_ibfk_2` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `referral_transaksi_ibfk_3` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `referral_transaksi_ibfk_4` FOREIGN KEY (`updated_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `referral_transaksi_ibfk_6` FOREIGN KEY (`dari_member_id`) REFERENCES `member` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `rekening`
--
ALTER TABLE `rekening`
  ADD CONSTRAINT `rekening_ibfk_3` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `rekening_ibfk_4` FOREIGN KEY (`updated_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `rekening_ibfk_5` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;
