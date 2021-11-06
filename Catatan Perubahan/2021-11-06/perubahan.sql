START TRANSACTION;

CREATE TABLE `referral_transaksi` (
  `id` int(11) NOT NULL,
  `member_id` int(11) DEFAULT NULL,
  `referral_id` int(11) DEFAULT NULL,
  `jumlah_dana` int(11) DEFAULT NULL,
  `jenis` int(11) NOT NULL DEFAULT 0 COMMENT '0 keluar | 1 masuk',
  `catatan` text DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `referral_transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `member_id` (`member_id`),
  ADD KEY `referral_id` (`referral_id`),
  ADD KEY `deleted_by` (`deleted_by`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`);

ALTER TABLE `referral_transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `referral_transaksi`
  ADD CONSTRAINT `referral_transaksi_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `member` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `referral_transaksi_ibfk_2` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `referral_transaksi_ibfk_3` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `referral_transaksi_ibfk_4` FOREIGN KEY (`updated_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE;
  ADD CONSTRAINT `referral_transaksi_ibfk_6` FOREIGN KEY (`referral_id`) REFERENCES `referral` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;
