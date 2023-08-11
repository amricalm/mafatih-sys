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
/*Table structure for table `rf_level_class` */

DROP TABLE IF EXISTS `rf_level_class`;

CREATE TABLE `rf_level_class` (
  `level` int(11) NOT NULL,
  `desc` text,
  `desc_ar` text,
  PRIMARY KEY (`level`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `rf_level_class` */

insert  into `rf_level_class`(`level`,`desc`,`desc_ar`) values (1,NULL,'الأول'),(2,NULL,'الثاني'),(3,NULL,'الثالث'),(4,NULL,'الرابع'),(5,NULL,'الخامس'),(6,NULL,'السادس');

/*Table structure for table `rf_level_class_dtl` */

DROP TABLE IF EXISTS `rf_level_class_dtl`;

CREATE TABLE `rf_level_class_dtl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `level` int(11) DEFAULT NULL,
  `tid` int(11) DEFAULT NULL COMMENT 'Term ID',
  `desc` text,
  `desc_ar` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

/*Data for the table `rf_level_class_dtl` */

insert  into `rf_level_class_dtl`(`id`,`level`,`tid`,`desc`,`desc_ar`) values (1,1,1,NULL,'المستوى الأول'),(2,1,2,NULL,'المستوى الثاني'),(3,2,1,NULL,'المستوى الثالث'),(4,2,2,NULL,'المستوى الرابع'),(5,3,1,NULL,'المستوى الخامس'),(6,3,2,NULL,'المستوى السادس'),(7,4,1,NULL,'المستوى السابع'),(8,4,2,NULL,'المستوى الثامن'),(9,5,1,NULL,'المستوى التاسع'),(10,5,2,NULL,'المستوى العاشر'),(11,6,1,NULL,'المستوى الحادي عشر'),(12,6,2,NULL,'المستوى الثاني عشر');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
