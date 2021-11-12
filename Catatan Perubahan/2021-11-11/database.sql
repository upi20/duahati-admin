
START TRANSACTION;
ALTER TABLE `kelas_materi` ADD `submateri` INT(1) NOT NULL DEFAULT '0' AFTER `keterangan`;


--
CREATE TABLE `duahati`.`kelas_materi_sub` (
  `id` int(11) NOT NULL,
  `kelas_id` int(11) DEFAULT NULL,
  `no_urut` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `submateri` int(1) NOT NULL DEFAULT 0,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
ALTER TABLE `kelas_materi_sub` ADD PRIMARY KEY (`id`), ADD KEY `kelas_id` (`kelas_id`), ADD KEY `created_by` (`created_by`), ADD KEY `updated_by` (`updated_by`), ADD KEY `deleted_by` (`deleted_by`);
ALTER TABLE `kelas_materi_sub` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

-- tambah baru
ALTER TABLE `kelas_materi_sub` ADD `materi_id` INT NULL DEFAULT NULL AFTER `kelas_id`;
ALTER TABLE `kelas_materi_sub` ADD FOREIGN KEY (`materi_id`) REFERENCES `kelas_materi`(`id`) ON DELETE SET NULL ON UPDATE CASCADE;
ALTER TABLE `kelas_materi_sub` ADD FOREIGN KEY (`created_by`) REFERENCES `users`(`user_id`) ON DELETE SET NULL ON UPDATE CASCADE;
ALTER TABLE `kelas_materi_sub` ADD FOREIGN KEY (`updated_by`) REFERENCES `users`(`user_id`) ON DELETE SET NULL ON UPDATE CASCADE;
ALTER TABLE `kelas_materi_sub` ADD FOREIGN KEY (`deleted_by`) REFERENCES `users`(`user_id`) ON DELETE SET NULL ON UPDATE CASCADE;

-- baru
ALTER TABLE `kelas_materi` ADD `selesai` INT(1) NOT NULL DEFAULT '0' AFTER `submateri`;
ALTER TABLE `kelas_materi_sub` ADD `selesai` INT(1) NULL DEFAULT '0' AFTER `keterangan`;

-- status
ALTER TABLE `kelas_materi` CHANGE `submateri` `submateri` INT(1) NOT NULL DEFAULT '0' COMMENT '0 Tidak ada, 1 Ada';
ALTER TABLE `kelas_materi_sub` CHANGE `submateri` `submateri` INT(1) NOT NULL DEFAULT '0' COMMENT '0 Tidak ada, 1 Ada';

CREATE TABLE `member_materi_tonton_sub` (
  `id` int(11) NOT NULL,
  `member_id` int(11) DEFAULT NULL,
  `kelas_id` int(11) NOT NULL,
  `kelas_materi_sub_id` int(11) NOT NULL,
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

ALTER TABLE `member_materi_tonton_sub`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kelas_id` (`kelas_id`),
  ADD KEY `member_id` (`member_id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`),
  ADD KEY `kelas_materi_id` (`kelas_materi_sub_id`);

ALTER TABLE `member_materi_tonton_sub`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `member_materi_tonton_sub`
  ADD CONSTRAINT `member_materi_tonton_sub_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `member_materi_tonton_sub_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `member_materi_tonton_sub_ibfk_3` FOREIGN KEY (`kelas_materi_sub_id`) REFERENCES `kelas_materi_sub` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `member_materi_tonton_sub_ibfk_4` FOREIGN KEY (`member_id`) REFERENCES `member` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `member_materi_tonton_sub_ibfk_5` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;
