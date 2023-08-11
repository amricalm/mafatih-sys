/*
SQLyog Ultimate v12.5.1 (64 bit)
MySQL - 5.7.24 : Database - msh-sys
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `aa_academic_year_detail` */

DROP TABLE IF EXISTS `aa_academic_year_detail`;

CREATE TABLE `aa_academic_year_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ayid` int(11) DEFAULT NULL COMMENT 'academic_year_id',
  `tid` int(11) DEFAULT NULL COMMENT 'term_id',
  `mid_exam_date` date DEFAULT NULL COMMENT 'tanggal uts',
  `publish_mid_exam` tinyint(4) DEFAULT NULL COMMENT 'publikasikan uts nggak?',
  `final_exam_date` date DEFAULT NULL COMMENT 'tanggal uas',
  `publish_final_exam` tinyint(4) DEFAULT NULL COMMENT 'publikasikan uas nggak?',
  `cby` int(11) DEFAULT NULL,
  `con` timestamp NULL DEFAULT NULL,
  `uby` int(11) DEFAULT NULL,
  `uon` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
