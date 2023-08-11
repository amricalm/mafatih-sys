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
/*Table structure for table `ms_configs` */

DROP TABLE IF EXISTS `ms_configs`;

CREATE TABLE `ms_configs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `config_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `config_value` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `aktif` tinyint(1) NOT NULL DEFAULT '1',
  `con` timestamp NULL DEFAULT NULL,
  `uon` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `ms_configs` */

insert  into `ms_configs`(`id`,`config_name`,`config_value`,`aktif`,`con`,`uon`) values 
(1,'id_thn_ajar_ppdb','1,2,3',1,NULL,NULL),
(2,'ppdb_range','2021-10-01,2021-12-31',1,NULL,NULL),
(3,'active_school','1',1,NULL,NULL),
(4,'active_academic_year','1',1,NULL,NULL),
(5,'active_term','1',1,NULL,NULL),
(6,'paging','50',1,NULL,NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
