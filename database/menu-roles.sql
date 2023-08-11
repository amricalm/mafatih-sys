/*
SQLyog Professional v13.1.1 (64 bit)
MySQL - 5.7.24 : Database - msh-sys
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `log` */

DROP TABLE IF EXISTS `log`;

CREATE TABLE `log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(25) DEFAULT NULL,
  `country_code` varchar(5) DEFAULT NULL,
  `country_name` varchar(50) DEFAULT NULL,
  `region_code` varchar(5) DEFAULT NULL,
  `region_name` varchar(50) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `time_zone` varchar(50) DEFAULT NULL,
  `latitude` varchar(10) DEFAULT NULL,
  `longitude` varchar(10) DEFAULT NULL,
  `org` varchar(100) DEFAULT NULL,
  `timestamp` datetime DEFAULT NULL,
  `nama_login` varchar(50) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `detail` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `log` */

/*Table structure for table `menu` */

DROP TABLE IF EXISTS `menu`;

CREATE TABLE `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `urutan` int(11) DEFAULT NULL,
  `menu` varchar(100) DEFAULT NULL,
  `slug` varchar(50) DEFAULT NULL,
  `menu_parent` int(11) DEFAULT NULL,
  `menu_level` int(11) DEFAULT NULL,
  `menu_icon` varchar(30) DEFAULT NULL,
  `menu_turunan` int(11) DEFAULT '0',
  `menu_top` tinyint(11) DEFAULT NULL,
  `is_publish` int(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

/*Data for the table `menu` */

insert  into `menu`(`id`,`urutan`,`menu`,`slug`,`menu_parent`,`menu_level`,`menu_icon`,`menu_turunan`,`menu_top`,`is_publish`) values 
(1,0,'Master','#',0,1,'fa fa-thumbtack',0,NULL,1),
(2,1,'Transaksi','#',0,1,'far fa-handshake',0,NULL,1),
(3,2,'Laporan','#',0,1,'fa fa-print',0,NULL,1),
(4,3,'Setting','#',0,1,'fa fa-cogs',0,NULL,1),
(5,0,'Tahun Ajaran','tahunajaran',1,2,'fa fa-calendar-day',1,NULL,1),
(6,1,'Siswa','siswa',1,2,'fa fa-chalkboard-teacher',1,NULL,1),
(7,2,'Guru/Karyawan','karyawan',1,2,'fa fa-business-time',1,NULL,1),
(8,3,'Kelas','kelas',1,2,'fa fa-chalkboard',1,NULL,1),
(9,4,'Walikelas','walikelas',1,2,'fa fa-user-tie',1,NULL,1),
(10,5,'Rombel','rombel',1,2,'fa fa-laptop-code',1,NULL,1),
(11,6,'Mata Pelajaran','matapelajaran',1,2,'fa fa-file-medical',1,NULL,1),
(12,7,'Kegiatan Siswa','kegiatan-siswa',1,2,'fa fa-hiking',1,NULL,1),
(13,8,'Tupoksi','tupoksi',1,2,'fa fa-pencil-ruler',1,NULL,1),
(14,0,'Grup Mapel','muatanpelajaran',2,2,'fa fa-hashtag',1,NULL,1),
(15,1,'Pemetaan Mapel','pemetaanpelajaran',2,2,'fa fa-tags',1,NULL,1),
(16,2,'Input Nilai','inputnilai',2,2,'fa fa-user-check',1,NULL,1),
(17,3,'Kinerja Pegawai','kinerjapegawai',2,2,'fa fa-thumbs-up',1,NULL,1),
(18,0,'Raport','raport',3,2,'fas fa-paste',1,NULL,1),
(19,1,'Kinerja Pegawai','report-pegawai',3,2,'fas fa-flag-checkered',1,NULL,1),
(20,0,'Pengguna','user',4,2,'fas fa-user-shield',1,NULL,1),
(21,1,'Konfigurasi','konfigurasi',4,2,'fas fa-sliders-h',1,NULL,1),
(22,0,'Input Nilai','inputnilai',0,1,'fa fa-user-check',1,NULL,1),
(23,2,'Proses Nilai','prosesnilai',2,2,'fa fa-industry',1,NULL,1);

/*Table structure for table `menu_role` */

DROP TABLE IF EXISTS `menu_role`;

CREATE TABLE `menu_role` (
  `menu_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  PRIMARY KEY (`menu_id`,`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `menu_role` */

insert  into `menu_role`(`menu_id`,`role_id`) values 
(1,1),
(2,1),
(3,1),
(4,1),
(5,1),
(6,1),
(7,1),
(8,1),
(9,1),
(10,1),
(11,1),
(12,1),
(13,1),
(14,1),
(15,1),
(16,1),
(17,1),
(18,1),
(19,1),
(20,1),
(21,1),
(22,3),
(23,1);

/*Table structure for table `roles` */

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `desc` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `roles` */

insert  into `roles`(`id`,`name`,`desc`,`created_at`,`updated_at`) values 
(1,'Admin','','2021-10-05 16:29:33','2021-10-05 16:29:33'),
(2,'Orang Tua','','2021-10-05 16:29:33','2021-10-05 16:29:33'),
(3,'Guru','','2021-10-05 16:29:33','2021-10-05 16:29:33'),
(4,'Yayasan','','2021-10-05 16:29:33','2021-10-05 16:29:33');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `handphone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` int(11) NOT NULL DEFAULT '2',
  `pid` int(11) DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`name`,`email`,`email_verified_at`,`password`,`handphone`,`role`,`pid`,`remember_token`,`created_at`,`updated_at`) values 
(1,'Administrator','admin@msh.com','2021-09-28 13:36:03','$2y$10$M/AAJ.GF6AeV9FM1C3LRoeSV/INi0UNHnOCttnoXJ87yQnWEe4PDK',NULL,1,NULL,NULL,'2021-09-28 13:36:03','2021-09-28 13:36:03'),
(20,'Ginanjar','Gins327@belanabi.com',NULL,'$2y$10$5YBmFQl2MnxKF4L80afNeuwttm6Li0KlSHQtdlR62svdp9IU1vruS','8561757416',2,NULL,NULL,'2021-10-18 01:51:20','2021-10-28 01:22:35'),
(24,'Muhammad Ginanjar','yuriybasayef@gmail.com',NULL,'$2y$10$dB3A038/nUZi0JjzDXLPoOUCY6nkTEDqtTJ.i6h1JrFNezVn4HqG.','8561757416',2,NULL,NULL,'2021-10-28 08:15:18','2021-10-28 08:15:34'),
(27,'Ade Sudiana','ade@msh.com',NULL,'$2y$10$Uo15RE04ZAlKsQlgCUS/ieH.6ouvYOxXjX4e4g2GtdiMdiz3xzPCG',NULL,3,9,NULL,'2021-12-14 02:52:53','2021-12-14 02:52:53');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
