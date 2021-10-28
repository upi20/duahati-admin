-- Mebuat Tabel baru di database
CREATE TABLE `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `publisher` (`publisher`),
  KEY `created_by` (`created_by`),
  KEY `updated_by` (`updated_by`),
  KEY `deleted_by` (`deleted_by`),
  CONSTRAINT `news_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `news_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `news_ibfk_3` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `news_ibfk_4` FOREIGN KEY (`publisher`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4


CREATE TABLE `news_komentar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `news_id` int(11) DEFAULT NULL,
  `member_id` int(11) DEFAULT NULL,
  `komentar` text NOT NULL,
  `status` int(11) DEFAULT NULL COMMENT '0 = dibuat, 1 = aktif, 2 = tidak aktif, 99 = dihapus',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `news_id` (`news_id`),
  KEY `member_id` (`member_id`),
  CONSTRAINT `news_komentar_ibfk_1` FOREIGN KEY (`news_id`) REFERENCES `news` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `news_komentar_ibfk_2` FOREIGN KEY (`member_id`) REFERENCES `member` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4

-- Membuat tampilan Menu baru
INSERT INTO `menu` (`menu_menu_id`, `menu_nama`, `menu_index`, `menu_icon`, `menu_url`, `menu_keterangan`, `menu_status`) VALUES ('', 'News', '5', 'fa fa-newspaper', '#', '-', 'Aktif');
INSERT INTO `menu` (`menu_menu_id`, `menu_nama`, `menu_index`, `menu_icon`, `menu_url`, `menu_keterangan`, `menu_status`) VALUES ('121', 'Data News', '1', 'fa fa-newspaper', 'news/master', '-', 'Aktif');
INSERT INTO `menu` (`menu_menu_id`, `menu_nama`, `menu_index`, `menu_icon`, `menu_url`, `menu_keterangan`, `menu_status`) VALUES ('121', 'Komentar', '2', 'far fa-circle', 'news/komentar', '-', 'Aktif');
INSERT INTO `role_aplikasi` (`rola_menu_id`, `rola_lev_id`) VALUES ('121', '1');
INSERT INTO `role_aplikasi` (`rola_menu_id`, `rola_lev_id`) VALUES ('122', '1');
INSERT INTO `role_aplikasi` (`rola_menu_id`, `rola_lev_id`) VALUES ('123', '1');