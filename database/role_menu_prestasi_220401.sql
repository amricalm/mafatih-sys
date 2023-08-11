INSERT  INTO `menu`(`id`,`urutan`,`menu`,`slug`,`menu_parent`,`menu_level`,`menu_icon`,`menu_turunan`,`menu_top`,`is_publish`) VALUES 
(34,15,'Prestasi','prestasi',2,2,'fa fa-trophy',1,NULL,1),
(35,16,'Pelanggaran','pelanggaran',2,2,'fa fa-balance-scale',1,NULL,1),
(35,16,'Bimbingan Konseling','konseling',2,2,'fa fa-comments',1,NULL,1);

INSERT  INTO `menu_role`(`menu_id`,`role_id`) VALUES (34,1),(35,1),(36,1);

CREATE TABLE `ep_counselling` (
  `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `pid` INT(11) NOT NULL,
  `name` TEXT COLLATE utf8mb4_unicode_ci,
  `year` INT(11) DEFAULT NULL,
  `date` DATE DEFAULT NULL,
  `desc` TEXT COLLATE utf8mb4_unicode_ci,
  `cby` INT(11) DEFAULT NULL,
  `uby` INT(11) DEFAULT NULL,
  `con` TIMESTAMP NULL DEFAULT NULL,
  `uon` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=INNODB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `ep_punishment` (
  `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `pid` INT(11) NOT NULL,
  `name` VARCHAR(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `year` INT(11) DEFAULT NULL,
  `date` DATE DEFAULT NULL,
  `desc` VARCHAR(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cby` INT(11) DEFAULT NULL,
  `uby` INT(11) DEFAULT NULL,
  `con` TIMESTAMP NULL DEFAULT NULL,
  `uon` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=INNODB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
