/*
SQLyog Community v13.2.0 (64 bit)
MySQL - 5.7.33 : Database - msh_prod
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `rf_level_class` */

DROP TABLE IF EXISTS `rf_level_class`;

CREATE TABLE `rf_level_class` (
  `level` int(11) NOT NULL,
  `desc` text,
  `desc_ar` text,
  `school_type` int(1) DEFAULT NULL,
  PRIMARY KEY (`level`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `rf_level_class` */

insert  into `rf_level_class`(`level`,`desc`,`desc_ar`,`school_type`) values 
(1,NULL,'الأول',2),
(2,NULL,'الثاني',2),
(3,NULL,'الثالث',2),
(4,NULL,'الرابع',3),
(5,NULL,'الخامس',3),
(6,NULL,'السادس',3);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
