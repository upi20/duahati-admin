-- biaya pendaftaran member
ALTER TABLE `member` ADD `biaya_pendaftaran` INT NOT NULL DEFAULT '0' AFTER `kode_referral`;