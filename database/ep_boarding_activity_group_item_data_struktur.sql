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

/*Table structure for table `ep_boarding_activity` */

DROP TABLE IF EXISTS `ep_boarding_activity`;

CREATE TABLE `ep_boarding_activity` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` int(11) DEFAULT NULL COMMENT 'Boarding Activity Group ID',
  `name` varchar(50) NOT NULL,
  `name_ar` varchar(50) CHARACTER SET utf16 NOT NULL,
  `cby` int(11) NOT NULL COMMENT 'Created By = uid',
  `uby` int(11) NOT NULL COMMENT 'Updated By = uid',
  `con` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Created On',
  `uon` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Updated On',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;

/*Data for the table `ep_boarding_activity` */

insert  into `ep_boarding_activity`(`id`,`group_id`,`name`,`name_ar`,`cby`,`uby`,`con`,`uon`) values (1,1,'Sholat fardhu berjamaah','صلوات الفرض مع الجماعة',1,1,'2021-12-09 16:54:23','2021-12-15 17:45:38'),(2,1,'Sholat dan puasa sunnah','صلوات وصيام النوافل',1,1,'2021-12-09 16:55:47','2021-12-13 16:24:01'),(3,2,'Tilawatul Quran','التلاوة',1,1,'2021-12-09 16:58:22','2021-12-09 17:12:04'),(4,2,'Muraja’ah','المراجعة',1,1,'2021-12-09 16:59:38','2021-12-09 17:12:06'),(5,2,'Mempersiapkan dan membaca hafalan baru','تحضير وتسميع الحفظ الجديد',1,1,'2021-12-09 17:01:19','2021-12-14 15:17:21'),(6,3,'Tingkat kehadiran','نسبة الحضور',1,1,'2021-12-09 17:02:17','2021-12-09 17:12:16'),(7,3,'Adab dalam majlis','أدب المجلس',1,1,'2021-12-09 17:02:59','2021-12-09 17:21:16'),(8,4,'Tingkat kehadiran','نسبة الحضور',1,1,'2021-12-09 17:03:09','2021-12-09 17:22:47'),(9,4,'Persiapan pidato','إعداد الخطابة',1,1,'2021-12-09 17:03:30','2021-12-15 18:11:32'),(10,4,'Penampilan','الأداء',1,1,'2021-12-09 17:03:35','2021-12-09 17:50:24'),(11,5,'Bahasa Arab','اللغة العربية',1,1,'2021-12-16 17:37:48','2021-12-16 17:38:39'),(12,5,'Bahasa Inggris','اللغة الإنجليزية',1,1,'2021-12-16 17:38:02','2021-12-16 17:38:41'),(13,6,'Tingkat kehadiran','نسبة الحضور',1,1,'2021-12-09 17:03:52','2021-12-09 17:51:57'),(14,6,'Aktivitas dan kekuatan','النشاط والهمة',1,1,'2021-12-16 17:39:43','2021-12-16 17:39:52'),(15,6,'Kekuatan dan kinerja','القدرة والأداء',1,1,'2021-12-09 17:04:04','2021-12-16 17:40:10'),(16,7,'Asosiasi Pembaca dan Pelestarian','جمعية القراء والحفاظ',1,1,'2021-12-09 17:04:09','2021-12-09 17:53:03'),(17,7,'Asosiasi Pelapor','جمعية المبلغين',1,1,'2021-12-09 17:04:15','2021-12-09 17:53:09'),(18,7,'Asosiasi Perencana','جمعية الخططين',1,1,'2021-12-09 17:04:20','2021-12-16 17:41:41'),(19,7,'Asosiasi Lagu Kebangsaan','جمعية النشيد',1,1,'2021-12-09 17:04:26','2021-12-16 17:41:42'),(20,8,'Tingkat kehadiran','نسبة الحضور',1,1,'2021-12-09 17:04:31','2021-12-09 17:53:28'),(21,9,'Pelanggaran serius','المخالفة الخطيرة',1,1,'2021-12-09 17:04:36','2021-12-09 17:53:34'),(22,9,'pelanggaran rata-rata','المخالفة المتوسطة',1,1,'2021-12-09 17:04:43','2021-12-09 17:53:39'),(23,9,'Pelanggaran kecil','المخالفة الطفيفة',1,1,'2021-12-09 17:04:48','2021-12-09 17:53:46'),(24,10,'keseriusan dalam belajar','الجدية في المذاكرة',1,1,'2021-12-09 17:04:52','2021-12-09 17:53:52'),(25,10,'kesehatan','مراعة الصحة',1,1,'2021-12-09 17:04:58','2021-12-09 17:53:58'),(26,10,'Perhatikan kebersihan institut','مراعة نظافة المعهد',1,1,'2021-12-09 17:05:02','2021-12-16 17:42:03'),(27,10,'Ketekunan dan awal','المواظبة والتبكير',1,1,'2021-12-09 17:05:07','2021-12-16 17:42:06'),(28,10,'Tanggung jawab','المسؤولية',1,1,'2021-12-09 17:05:09','2021-12-16 17:42:08');

/*Table structure for table `ep_boarding_activity_group` */

DROP TABLE IF EXISTS `ep_boarding_activity_group`;

CREATE TABLE `ep_boarding_activity_group` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `name_ar` varchar(50) CHARACTER SET utf16 NOT NULL,
  `cby` int(11) DEFAULT NULL COMMENT 'created_by - uid',
  `uby` int(11) DEFAULT NULL COMMENT 'updated_by - uid',
  `con` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'created_on ',
  `uon` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'updated_on',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

/*Data for the table `ep_boarding_activity_group` */

insert  into `ep_boarding_activity_group`(`id`,`name`,`name_ar`,`cby`,`uby`,`con`,`uon`) values (1,'Ibadah Wajib & Nawafil','العبادة والنوافل',1,1,'2021-12-07 09:27:33','2021-12-13 16:24:01'),(2,'Ikrar Al-Qur\'an','تعاهد القرآن',1,1,'2021-12-07 09:28:43','2021-12-08 16:23:34'),(3,'Pelajaran masjid','دروس المسجد',1,1,'2021-12-07 09:41:07','2021-12-08 16:40:38'),(4,'Pelatihan berbicara di depan umum','التدريب على الخطابة',1,1,'2021-12-09 16:34:41','2021-12-09 18:11:10'),(5,'Latihan bahasa','ممارسة اللغة\r\n\r\n',1,1,'2021-12-09 16:34:49','2021-12-09 18:11:25'),(6,'Pramuka','الكشافة',1,1,'2021-12-09 16:34:58','2021-12-09 18:11:32'),(7,'Kegiatan ekstrakurikuler yang dipilih','الأنشطة اللامنهجية المختارة',1,1,'2021-12-09 16:35:05','2021-12-09 18:11:34'),(8,'Menghadiri di dalam ruangan','الحضور في الغرفة',1,1,'2021-12-09 16:35:12','2021-12-09 18:11:52'),(9,'Pelanggaran sistem','مخالفة النظام',1,1,'2021-12-09 16:35:18','2021-12-09 18:12:01'),(10,'Catatan Pengawas dan Pengurus Rumah Tangga','ملاحظات المشرف والمدبر',1,1,'2021-12-09 16:35:25','2021-12-09 18:12:03');

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

/*Data for the table `ep_boarding_activity_item` */

insert  into `ep_boarding_activity_item`(`id`,`name`,`name_ar`,`activity_id`,`cby`,`uby`,`con`,`uon`) values (1,'Shalat Dhuhur berjamaah','',1,1,1,'2021-12-13 00:00:00','2021-12-15 17:45:38'),(2,'Shalat Ashar Berjamaah','',1,1,1,'2021-12-13 00:00:00','2021-12-15 17:45:38'),(3,'Shalat Isya’ berjamaah','',1,1,1,'2021-12-13 00:00:00','2021-12-15 17:45:38'),(4,'Shalat Subuh Berjamaah','',1,1,1,'2021-12-13 00:00:00','2021-12-15 17:45:38'),(5,'Shalat Maghrib berjamaah','',1,1,1,'2021-12-13 00:00:00','2021-12-15 17:45:38'),(6,'Qiyam al-Lail Berjamaah ','',1,1,1,'2021-12-13 00:00:00','2021-12-15 17:45:38'),(7,'Shalat Syuruq','',2,1,1,'2021-12-13 00:00:00','2021-12-13 00:00:00'),(8,'Shalat Dhuha','',2,1,1,'2021-12-13 00:00:00','2021-12-13 00:00:00'),(9,'Shaum Sunnah ','',2,1,1,'2021-12-13 00:00:00','2021-12-13 00:00:00'),(10,'Tilawatul Quran 1 juz perhari','',3,1,1,'2021-12-13 00:00:00','2021-12-13 00:00:00'),(11,'Muraja’ah jelang asar','',4,1,1,'2021-12-13 00:00:00','2021-12-13 00:00:00'),(12,'Persiapan Hafalan Halaman Baru Setelah Tahajjud','',5,1,1,'2021-12-13 00:00:00','2021-12-14 15:17:21'),(13,'Setoran Hapalan baru','',5,1,1,'2021-12-13 00:00:00','2021-12-14 15:17:21'),(14,'Talaqqi Kitab (Durus al-Masajid) ','',7,1,1,'2021-12-13 00:00:00','2021-12-14 15:17:21'),(15,'Talaqqi Kitab (Durus al-Masajid) hingga Syuruq','',7,1,1,'2021-12-13 00:00:00','2021-12-13 00:00:00'),(16,'Hadir  Talaqqy mutun dan Kultum Thullab','',6,1,1,'2021-12-13 00:00:00','2021-12-13 00:00:00'),(17,'Hadir mendengarkan kultum ','',8,1,1,'2021-12-13 00:00:00','2021-12-13 00:00:00'),(18,'Aktivitas Ekstrakurikuler / Organisasi Santri','',NULL,1,1,'2021-12-13 00:00:00','2021-12-13 00:00:00'),(19,'Kegitan munaqasyah pekanan','',NULL,1,1,'2021-12-13 00:00:00','2021-12-13 00:00:00'),(20,'Kunjungan Musyrif Fashl. ','',NULL,1,1,'2021-12-13 00:00:00','2021-12-13 00:00:00'),(21,'Belajar Mandiri ','',NULL,1,1,'2021-12-13 00:00:00','2021-12-15 18:11:25'),(22,'Tidur Jelang Subuh','',NULL,1,1,'2021-12-13 00:00:00','2021-12-13 00:00:00'),(23,'Sarapan pagi/ sahur','',NULL,1,1,'2021-12-13 00:00:00','2021-12-16 14:20:02'),(24,'Qailulah ','',NULL,1,1,'2021-12-13 00:00:00','2021-12-16 14:20:02'),(25,'Makan Siang','',NULL,1,1,'2021-12-13 00:00:00','2021-12-13 00:00:00'),(26,'Mandi sore','',NULL,1,1,'2021-12-13 00:00:00','2021-12-13 00:00:00'),(27,'Makan Sore/buka','',NULL,1,1,'2021-12-13 00:00:00','2021-12-13 00:00:00'),(28,'Olahraga','',NULL,1,1,'2021-12-13 00:00:00','2021-12-13 00:00:00'),(29,'Piket  Asrama','',NULL,1,1,'2021-12-13 00:00:00','2021-12-13 00:00:00'),(30,'Piket Mushala/Aula','',NULL,1,1,'2021-12-13 00:00:00','2021-12-13 00:00:00'),(31,'Piket Kelas','',NULL,1,1,'2021-12-13 00:00:00','2021-12-13 00:00:00'),(32,'Piket KM','',NULL,1,1,'2021-12-13 00:00:00','2021-12-13 00:00:00'),(33,'Bangun tidur tepat waktu','',NULL,1,1,'2021-12-13 00:00:00','2021-12-16 14:10:57'),(34,'Mandi sebelum shalat malam','',NULL,1,1,'2021-12-13 00:00:00','2021-12-16 14:15:19'),(35,'Tidur tepat waktu','',NULL,1,1,'2021-12-13 00:00:00','2021-12-16 14:15:19');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
