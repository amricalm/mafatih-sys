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
  `timestamp` datetime DEFAULT CURRENT_TIMESTAMP,
  `nama_login` varchar(50) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `detail` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `log` */

insert  into `log`(`id`,`ip`,`country_code`,`country_name`,`region_code`,`region_name`,`city`,`time_zone`,`latitude`,`longitude`,`org`,`timestamp`,`nama_login`,`role_id`,`detail`) values 
(1,'127.0.0.1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'ade@msh.com',3,'Ade Sudiana absen.');

/*Table structure for table `menu_modul` */

DROP TABLE IF EXISTS `menu_modul`;

CREATE TABLE `menu_modul` (
  `modul_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `seq` int(11) DEFAULT NULL,
  PRIMARY KEY (`menu_id`,`modul_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `menu_modul` */

insert  into `menu_modul`(`modul_id`,`menu_id`,`seq`) values 
(2,8,2),
(2,10,11),
(2,11,1),
(1,12,1),
(2,14,3),
(2,15,4),
(2,16,10),
(2,18,7),
(1,25,2),
(2,25,8),
(1,26,4),
(2,26,5),
(1,28,3),
(1,29,6),
(2,29,6),
(1,32,5),
(2,32,9);

/*Table structure for table `rf_modul` */

DROP TABLE IF EXISTS `rf_modul`;

CREATE TABLE `rf_modul` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) DEFAULT NULL,
  `desc` text,
  `is_publish` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `rf_modul` */

insert  into `rf_modul`(`id`,`name`,`desc`,`is_publish`) values 
(1,'Pengasuhan','Modul Pengasuhan',1),
(2,'Nilai Akademik','Modul Akademik',1);

/*Table structure for table `users_modul` */

DROP TABLE IF EXISTS `users_modul`;

CREATE TABLE `users_modul` (
  `uid` int(11) NOT NULL,
  `modul_id` int(11) NOT NULL,
  PRIMARY KEY (`uid`,`modul_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `users_modul` */

insert  into `users_modul`(`uid`,`modul_id`) values 
(27,2),
(85,1),
(89,1),
(89,2);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
