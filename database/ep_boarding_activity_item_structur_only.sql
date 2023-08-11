/*
SQLyog Ultimate v11.11 (64 bit)
MySQL - 5.7.33 : Database - msh
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`msh` /*!40100 DEFAULT CHARACTER SET latin1 */;

/*Table structure for table `ep_boarding_activity_item` */

DROP TABLE IF EXISTS `ep_boarding_activity_item`;

CREATE TABLE `ep_boarding_activity_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `name_ar` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `activity_id` int(11) DEFAULT NULL COMMENT 'Boarding Activity ID',
  `cby` int(11) DEFAULT NULL COMMENT 'Created By = uid',
  `uby` int(11) DEFAULT NULL COMMENT 'Updated By = uid',
  `con` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Created On',
  `uon` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Updated On',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
