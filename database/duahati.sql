-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 20, 2021 at 01:48 PM
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
-- Table structure for table `kelas`
--

CREATE TABLE `kelas` (
  `id` int(11) NOT NULL,
  `id_kategori` int(11) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `kelas_kategori`
--

CREATE TABLE `kelas_kategori` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `kelas_materi`
--

CREATE TABLE `kelas_materi` (
  `id` int(11) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `mentor_id` int(11) NOT NULL,
  `nik` varchar(255) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `no_telepon` varchar(255) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `parrent_id` int(11) NOT NULL,
  `kode_refeal` varchar(255) NOT NULL,
  `status` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `member_materi_tonton`
--

CREATE TABLE `member_materi_tonton` (
  `id` int(11) NOT NULL,
  `member_id` int(11) DEFAULT NULL,
  `kelas_id` int(11) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
(82, 0, 'Master', '-', 4, 'fas fa-database', '#', 'Aktif', '2021-08-25 02:03:41'),
(97, 2, 'Backup & Reset', '-', 6, 'fa fa-download', 'pengaturan/backupReset', 'Aktif', '2021-10-06 00:41:32'),
(104, 0, 'Member', '-', 2, 'fa fa-users', 'member/dataMember', 'Aktif', '2021-10-12 11:56:14'),
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
(115, 82, 'Iklan', 'iklan', 1, 'far fa-circle', 'master/iklan', 'Aktif', '2021-10-19 17:47:24');

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
(1, 1, 1, '2021-07-14 05:27:04'),
(3, 4, 1, '2021-07-14 05:27:17'),
(4, 5, 1, '2021-07-14 05:27:25'),
(5, 6, 1, '2021-07-14 05:27:31'),
(6, 7, 1, '2021-07-14 05:27:37'),
(7, 2, 1, '2021-07-14 05:27:48'),
(83, 52, 1, '2021-08-14 09:00:46'),
(94, 63, 1, '2021-08-14 09:09:44'),
(95, 64, 1, '2021-08-14 09:09:50'),
(96, 65, 1, '2021-08-14 09:10:00'),
(97, 66, 1, '2021-08-14 09:10:09'),
(98, 67, 1, '2021-08-14 09:10:18'),
(113, 3, 1, '2021-08-25 02:01:35'),
(114, 82, 1, '2021-08-25 02:04:08'),
(141, 93, 1, '2021-09-16 20:49:15'),
(151, 99, 1, '2021-10-06 00:41:32'),
(152, 100, 1, '2021-10-06 00:41:32'),
(153, 101, 1, '2021-10-06 00:42:54'),
(154, 101, 1, '2021-10-06 00:43:26'),
(155, 111, 1, '2021-10-12 12:05:14'),
(156, 112, 1, '2021-10-12 12:05:15'),
(157, 106, 1, '2021-10-12 12:05:23'),
(158, 107, 1, '2021-10-12 12:05:24'),
(159, 108, 1, '2021-10-12 12:05:25'),
(160, 109, 1, '2021-10-12 12:05:27'),
(162, 104, 1, '2021-10-12 12:05:44'),
(163, 110, 1, '2021-10-12 12:05:45'),
(167, 105, 1, '2021-10-12 12:06:56'),
(169, 113, 1, '2021-10-12 14:16:47'),
(170, 114, 1, '2021-10-13 09:01:33'),
(171, 115, 1, '2021-10-19 17:47:41');

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
(1, 1, 1, '2020-06-18 02:39:26');

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
  `user_status` int(1) NOT NULL DEFAULT 0 COMMENT '0 Tidak Aktif | 1 Aktif | 2 Pendding',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_nama`, `user_tgl_lahir`, `user_jk`, `user_password`, `user_email`, `user_phone`, `user_foto`, `user_status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Soni Setiawan', NULL, NULL, '$2y$10$7XCVzUlzjXOTMq0s90XfMO6bR7Tb2xZB5LgxL1Lw6o2KqoeAi8Vjq', 'administrator@gmail.com', '08123123', NULL, 1, '2020-06-18 02:39:08', '2020-06-18 02:39:08', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kelas_kategori`
--
ALTER TABLE `kelas_kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kelas_materi`
--
ALTER TABLE `kelas_materi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `level`
--
ALTER TABLE `level`
  ADD PRIMARY KEY (`lev_id`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `member_materi_tonton`
--
ALTER TABLE `member_materi_tonton`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`menu_id`);

--
-- Indexes for table `role_aplikasi`
--
ALTER TABLE `role_aplikasi`
  ADD PRIMARY KEY (`rola_id`);

--
-- Indexes for table `role_users`
--
ALTER TABLE `role_users`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_email` (`user_email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kelas_kategori`
--
ALTER TABLE `kelas_kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kelas_materi`
--
ALTER TABLE `kelas_materi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `level`
--
ALTER TABLE `level`
  MODIFY `lev_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `member_materi_tonton`
--
ALTER TABLE `member_materi_tonton`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `menu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT for table `role_aplikasi`
--
ALTER TABLE `role_aplikasi`
  MODIFY `rola_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=172;

--
-- AUTO_INCREMENT for table `role_users`
--
ALTER TABLE `role_users`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

