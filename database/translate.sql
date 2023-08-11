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
/*Table structure for table `rf_translate` */

DROP TABLE IF EXISTS `rf_translate`;

CREATE TABLE `rf_translate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `original` text,
  `arabic` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

/*Data for the table `rf_translate` */

insert  into `rf_translate`(`id`,`original`,`arabic`) values 
(1,'Bogor','بوغور'),
(2,'Januari','يَنَايِرْ'),
(3,'Februari','فِبْرَايِرْ'),
(4,'Maret','مَارِسْ'),
(5,'April','أَبْرِيلْ'),
(6,'Mei','مَايُو'),
(7,'Juni','يُوْنِيُوْ	'),
(8,'Juli','يُوْلِيُوْ'),
(9,'Agustus','أَغُسْطُسْ'),
(10,'September','سبْتَمْبِرْ'),
(11,'Oktober','أُكْتُوْبِرْ'),
(12,'November','نُوْفَمْبِرْ '),
(13,'Desember','دِيْسَمْبِرْ');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
