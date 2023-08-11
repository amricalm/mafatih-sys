/*
SQLyog Ultimate v11.11 (64 bit)
MySQL - 5.7.33 : Database - msh_prod
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `ep_boarding_activity_nonactive` */

DROP TABLE IF EXISTS `ep_boarding_activity_nonactive`;

CREATE TABLE `ep_boarding_activity_nonactive` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ayid` int(11) DEFAULT NULL,
  `tid` int(11) DEFAULT NULL,
  `activity_id` int(11) DEFAULT NULL,
  `desc` varchar(50) DEFAULT NULL,
  `cby` int(11) DEFAULT NULL,
  `uby` int(11) DEFAULT NULL,
  `con` timestamp NULL DEFAULT NULL,
  `uon` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
