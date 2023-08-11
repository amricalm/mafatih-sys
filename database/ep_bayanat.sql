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
/*Table structure for table `ep_bayanat_class` */

DROP TABLE IF EXISTS `ep_bayanat_class`;

CREATE TABLE `ep_bayanat_class` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ayid` int(11) unsigned NOT NULL COMMENT 'Academic Year ID',
  `name` varchar(50) NOT NULL,
  `name_ar` varchar(50) CHARACTER SET utf16 COLLATE utf16_unicode_ci DEFAULT NULL,
  `name_en` varchar(50) DEFAULT NULL,
  `level` int(11) DEFAULT NULL COMMENT 'Tingkat',
  `cby` int(11) NOT NULL COMMENT 'Created By = uid',
  `uby` int(11) NOT NULL COMMENT 'Updated By = uid',
  `con` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Created On',
  `uon` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Updated On',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `ep_bayanat_class_dtl` */

DROP TABLE IF EXISTS `ep_bayanat_class_dtl`;

CREATE TABLE `ep_bayanat_class_dtl` (
  `ccid` int(11) unsigned NOT NULL,
  `sid` int(10) unsigned NOT NULL COMMENT 'student.id',
  `ayid` int(11) DEFAULT NULL,
  `tid` int(11) DEFAULT NULL,
  `cby` int(11) NOT NULL COMMENT 'Created By = uid',
  `uby` int(11) NOT NULL COMMENT 'Updated By = uid',
  `con` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Created On',
  `uon` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Updated On',
  PRIMARY KEY (`ccid`,`sid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `ep_bayanat_result` */

DROP TABLE IF EXISTS `ep_bayanat_result`;

CREATE TABLE `ep_bayanat_result` (
  `pid` int(11) NOT NULL COMMENT 'person id',
  `eid` int(11) NOT NULL COMMENT 'employe id',
  `ayid` int(11) NOT NULL COMMENT 'academic year id',
  `tid` int(11) NOT NULL COMMENT 'term id - semester',
  `cqid` int(11) NOT NULL COMMENT 'kelas quran id',
  `juz_not_tasmik` text COMMENT 'juz yang belum di tasmi',
  `juz_is_study` text,
  `result_halqah` int(11) DEFAULT NULL,
  `result_level_halqah` int(11) DEFAULT NULL,
  `result_eloquence` int(11) DEFAULT NULL,
  `result_fluency` int(11) DEFAULT NULL,
  `result_balance` int(11) DEFAULT NULL,
  `result_written_test` int(11) DEFAULT NULL,
  `result_notes` text,
  `result_set` int(11) DEFAULT NULL,
  `result_decision_set` varchar(30) DEFAULT NULL,
  `cby` int(11) DEFAULT NULL,
  `uby` int(11) DEFAULT NULL,
  `con` timestamp NULL DEFAULT NULL,
  `uon` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `ep_bayanat_result_dtl` */

DROP TABLE IF EXISTS `ep_bayanat_result_dtl`;

CREATE TABLE `ep_bayanat_result_dtl` (
  `hid` int(11) NOT NULL COMMENT 'header id',
  `id_evaluation` int(11) DEFAULT NULL,
  `result_evaluation` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
