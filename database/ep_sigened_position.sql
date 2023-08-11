/*
SQLyog Ultimate v11.11 (64 bit)
MySQL - 5.7.33 : Database - msh_test
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `ep_signed_position` */

DROP TABLE IF EXISTS `ep_signed_position`;

CREATE TABLE `ep_signed_position` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ayid` int(11) DEFAULT NULL,
  `principal` int(11) DEFAULT NULL,
  `curriculum` int(11) DEFAULT NULL,
  `studentaffair` int(11) DEFAULT NULL,
  `housemaster` int(11) DEFAULT NULL,
  `cby` int(11) DEFAULT NULL,
  `uby` int(11) DEFAULT NULL,
  `con` timestamp NULL DEFAULT NULL,
  `uon` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `ep_signed_position` */

insert  into `ep_signed_position`(`id`,`ayid`,`principal`,`curriculum`,`studentaffair`,`housemaster`,`cby`,`uby`,`con`,`uon`) values (1,1,7,10,22,31,1,1,'2022-11-28 17:11:33','2022-11-29 09:52:08'),(2,2,7,10,22,44,1,NULL,'2022-11-29 10:11:32','2022-11-29 10:11:32');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
