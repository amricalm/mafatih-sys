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

/*Data for the table `ep_course_class_dtl` */

TRUNCATE `ep_course_class_dtl`;

INSERT  INTO `ep_course_class_dtl`(`ccid`,`sid`,`cby`,`uby`,`con`,`uon`) VALUES (1,112,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(1,115,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(1,118,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(1,121,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(1,123,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(1,124,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(1,126,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(1,130,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(1,139,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(1,140,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(1,141,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(1,144,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(1,146,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(1,150,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(1,155,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(1,157,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(1,158,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(1,166,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(1,178,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(1,183,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(1,184,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(1,185,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(1,186,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(1,188,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(1,191,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(1,195,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(1,200,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(1,201,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(1,203,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(1,205,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(1,219,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(1,226,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(1,232,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(1,238,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(1,239,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(2,110,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(2,111,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(2,113,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(2,114,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(2,117,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(2,119,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(2,120,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(2,135,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(2,138,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(2,143,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(2,151,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(2,159,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(2,163,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(2,167,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(2,173,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(2,174,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(2,177,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(2,182,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(2,187,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(2,189,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(2,190,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(2,192,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(2,193,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(2,194,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(2,196,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(2,197,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(2,198,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(2,199,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(2,202,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(2,204,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(2,206,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(2,222,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(2,227,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(2,237,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(3,116,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(3,129,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(3,131,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(3,132,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(3,134,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(3,147,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(3,152,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(3,161,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(3,165,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(3,168,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(3,169,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(3,175,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(3,180,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(3,181,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(3,207,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(3,208,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(3,209,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(3,210,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(3,212,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(3,213,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(3,215,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(3,216,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(3,218,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(3,223,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(3,225,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(3,228,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(3,229,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(3,233,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(3,234,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(3,235,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(3,236,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(4,122,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(4,125,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(4,127,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(4,128,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(4,133,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(4,136,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(4,137,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(4,142,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(4,145,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(4,148,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(4,149,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(4,153,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(4,154,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(4,156,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(4,160,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(4,162,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(4,164,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(4,170,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(4,171,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(4,172,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(4,176,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(4,179,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(4,211,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(4,214,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(4,217,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(4,220,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(4,221,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(4,224,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(4,230,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(4,231,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(5,1,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(5,4,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(5,9,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(5,15,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(5,21,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(5,24,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(5,26,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(5,29,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(5,31,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(5,32,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(5,33,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(5,44,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(5,46,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(5,50,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(5,58,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(5,60,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(5,61,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(5,62,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(5,63,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(5,64,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(5,65,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(5,67,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(5,69,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(5,73,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(5,74,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(5,77,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(5,78,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(5,82,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(5,95,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(5,97,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(5,104,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(6,25,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(6,27,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(6,28,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(6,30,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(6,34,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(6,40,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(6,42,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(6,43,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(6,45,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(6,49,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(6,54,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(6,59,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(6,66,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(6,70,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(6,71,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(6,72,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(6,75,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(6,76,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(6,79,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(6,80,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(6,81,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(6,83,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(6,84,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(6,85,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(6,98,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(6,100,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(6,105,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(6,106,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(6,107,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(6,108,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(6,109,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(7,2,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(7,3,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(7,5,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(7,7,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(7,11,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(7,13,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(7,18,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(7,22,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(7,35,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(7,37,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(7,38,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(7,39,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(7,47,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(7,48,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(7,53,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(7,86,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(7,89,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(7,90,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(7,91,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(7,93,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(7,94,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(7,99,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(7,102,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(8,6,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(8,8,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(8,10,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(8,12,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(8,14,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(8,16,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(8,17,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(8,19,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(8,20,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(8,23,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(8,36,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(8,41,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(8,51,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(8,52,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(8,55,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(8,56,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(8,57,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(8,87,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(8,88,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(8,92,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(8,96,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(8,101,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14'),(8,103,1,1,'2021-12-09 14:58:14','2021-12-09 14:58:14');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
