/*
SQLyog Ultimate v13.1.1 (64 bit)
MySQL - 5.7.24 : Database - msh-sys-live
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
  PRIMARY KEY (`level`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `rf_level_class` */

insert  into `rf_level_class`(`level`,`desc`,`desc_ar`) values 
(1,NULL,'المستوى الأول'),
(2,NULL,'المستوى الثاني'),
(3,NULL,'المستوى الثالث'),
(4,NULL,'المستوى الرابع'),
(5,NULL,'المستوى الخامس'),
(6,NULL,'المستوى السادس');

/*Table structure for table `rf_term` */

DROP TABLE IF EXISTS `rf_term`;

CREATE TABLE `rf_term` (
  `id` tinyint(4) NOT NULL,
  `desc` varchar(50) NOT NULL,
  `desc_ar` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `rf_term` */

insert  into `rf_term`(`id`,`desc`,`desc_ar`) values 
(1,'Semester 1','الأول'),
(2,'Semester 2','الثاني'),
(3,'Semester 3','الثالث'),
(4,'Semester 4','الرابع'),
(5,'Semester 5','الخامس'),
(6,'Semester 6','السادس');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
