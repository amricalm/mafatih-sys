/*
SQLyog Ultimate v13.1.1 (64 bit)
MySQL - 5.7.24 : Database - msh-sys
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `ep_course_subject` */

DROP TABLE IF EXISTS `ep_course_subject`;

CREATE TABLE `ep_course_subject` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `level` int(11) NOT NULL COMMENT 'level',
  `subject_id` int(11) NOT NULL COMMENT 'subject.id',
  `eid` int(11) NOT NULL COMMENT 'employe.id = teacher',
  `tid` int(11) DEFAULT NULL,
  `grade_pass` int(11) NOT NULL COMMENT 'kkm',
  `week_duration` int(11) DEFAULT NULL,
  `cby` int(11) NOT NULL COMMENT 'Created By = uid',
  `uby` int(11) NOT NULL COMMENT 'Updated By = uid',
  `con` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Created On',
  `uon` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Updated On',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

/*Data for the table `ep_course_subject` */

insert  into `ep_course_subject`(`id`,`level`,`subject_id`,`eid`,`tid`,`grade_pass`,`week_duration`,`cby`,`uby`,`con`,`uon`) values 
(1,1,6,0,1,60,5,1,1,'2022-01-12 09:19:41','2022-01-12 11:25:06'),
(2,1,1,0,1,50,8,1,1,'2022-01-12 09:38:07','2022-01-12 09:38:07'),
(3,1,16,0,1,90,8,1,1,'2022-01-12 10:13:47','2022-01-12 10:13:47'),
(4,1,8,0,1,90,7,1,1,'2022-01-12 10:14:26','2022-01-12 10:14:26'),
(5,1,17,0,1,50,4,1,1,'2022-01-12 10:50:31','2022-01-12 10:50:39'),
(6,2,6,0,1,79,9,1,1,'2022-01-12 10:57:55','2022-01-12 10:57:55'),
(7,4,3,0,1,60,9,1,1,'2022-01-12 10:58:04','2022-01-12 10:58:04'),
(8,6,9,0,1,70,6,1,1,'2022-01-12 10:58:20','2022-01-12 10:58:20'),
(9,3,11,0,1,34,5,1,1,'2022-01-12 13:44:43','2022-01-12 13:44:43');

/*Table structure for table `ep_course_subject_teacher` */

DROP TABLE IF EXISTS `ep_course_subject_teacher`;

CREATE TABLE `ep_course_subject_teacher` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `level` int(11) DEFAULT NULL COMMENT 'level',
  `subject_id` int(11) DEFAULT NULL COMMENT 'subject.id',
  `ayid` int(11) DEFAULT NULL COMMENT 'academicyear',
  `tid` int(11) DEFAULT NULL COMMENT 'termid',
  `ccid` int(11) DEFAULT NULL COMMENT 'classid',
  `eid` int(11) DEFAULT NULL COMMENT 'employe.id = teacher',
  `cby` int(11) NOT NULL COMMENT 'Created By = uid',
  `uby` int(11) NOT NULL COMMENT 'Updated By = uid',
  `con` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Created On',
  `uon` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Updated On',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `ep_course_subject_teacher` */

insert  into `ep_course_subject_teacher`(`id`,`level`,`subject_id`,`ayid`,`tid`,`ccid`,`eid`,`cby`,`uby`,`con`,`uon`) values 
(1,1,6,1,1,1,1,1,1,'2022-01-13 08:39:29','2022-01-13 08:39:29'),
(2,1,6,1,1,2,9,1,1,'2022-01-13 08:43:42','2022-01-13 08:43:42');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
