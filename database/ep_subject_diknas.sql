/*
SQLyog Community v13.2.0 (64 bit)
MySQL - 5.7.33 : Database - msh_dev
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `ep_subject_diknas` */

DROP TABLE IF EXISTS `ep_subject_diknas`;

CREATE TABLE `ep_subject_diknas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `short_name` varchar(10) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `cby` int(11) DEFAULT NULL,
  `uby` int(11) DEFAULT NULL,
  `con` timestamp NULL DEFAULT NULL,
  `uon` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

/*Data for the table `ep_subject_diknas` */

insert  into `ep_subject_diknas`(`id`,`short_name`,`name`,`cby`,`uby`,`con`,`uon`) values 
(1,'PAI','Pendidikan Agama dan Budipekerti',1,1,'2023-01-14 07:17:01','2023-01-14 08:20:51'),
(2,'PPKn','Pendidikan Pancasila dan Kewarganegaraan',1,1,'2023-01-14 07:17:01','2023-01-14 07:17:01'),
(3,'BIND','Bahasa Indonesia',1,1,'2023-01-14 07:17:01','2023-01-14 07:17:01'),
(4,'MTK','Matematika',1,1,'2023-01-14 07:17:01','2023-01-14 07:17:01'),
(5,'IPA','Ilmu Pengetahuan Alam',1,1,'2023-01-14 07:17:01','2023-01-14 07:17:01'),
(6,'IPS','Ilmu Pengetahuan Sosial',1,1,'2023-01-14 07:17:01','2023-01-14 07:17:01'),
(7,'BING','Bahasa Inggris',1,1,'2023-01-14 07:17:01','2023-01-14 07:17:01'),
(8,'SBD','Seni Budaya',1,1,'2023-01-14 07:17:01','2023-01-14 07:17:01'),
(9,'PJOK','Pendidikan Jasmani, Olah Raga, dan Kesehatan',1,1,'2023-01-14 07:17:01','2023-01-14 07:17:01'),
(10,'PRAK','Prakarya',1,1,'2023-01-14 07:17:01','2023-01-14 07:17:01'),
(11,'BSUN','Bahasa Sunda',1,1,'2023-02-01 22:06:31','2023-02-01 22:06:31'),
(12,'AKH','Akidah Akhlak',1,1,'2023-02-01 22:07:17','2023-02-01 22:07:17');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
