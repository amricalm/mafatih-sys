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

/*Data for the table `ep_boarding_activity` */

TRUNCATE `ep_boarding_activity`;

INSERT  INTO `ep_boarding_activity`(`id`,`group_id`,`name`,`name_ar`,`point`,`cby`,`uby`,`con`,`uon`) VALUES (1,1,'Sholat fardhu berjamaah','صلوات الفرض مع الجماعة',NULL,1,1,'2021-12-09 16:54:23','2021-12-09 17:11:55'),(2,1,'Sholat dan puasa sunnah','صلوات وصيام النوافل',NULL,1,1,'2021-12-09 16:55:47','2021-12-09 17:11:56'),(3,2,'Tilawatul Quran','التلاوة',NULL,1,1,'2021-12-09 16:58:22','2021-12-09 17:12:04'),(4,2,'Muraja’ah','المراجعة',NULL,1,1,'2021-12-09 16:59:38','2021-12-09 17:12:06'),(5,2,'Mempersiapkan dan membaca hafalan baru','تحضير وتسميع الحفظ الجديد',NULL,1,1,'2021-12-09 17:01:19','2021-12-09 17:12:07'),(6,3,'Tingkat kehadiran','نسبة الحضور',NULL,1,1,'2021-12-09 17:02:17','2021-12-09 17:12:16'),(7,3,'Adab dalam majlis','أدب المجلس',NULL,1,1,'2021-12-09 17:02:59','2021-12-09 17:21:16'),(8,4,'Tingkat kehadiran','نسبة الحضور',NULL,1,1,'2021-12-09 17:03:09','2021-12-09 17:22:47'),(9,4,'Persiapan pidato','إعداد الخطابة',NULL,1,1,'2021-12-09 17:03:30','2021-12-09 17:50:18'),(10,4,'Penampilan','الأداء',NULL,1,1,'2021-12-09 17:03:35','2021-12-09 17:50:24'),(11,5,'Bahasa Arab','اللغة العربية',NULL,1,1,'2021-12-09 17:03:41','2021-12-09 17:51:25'),(12,5,'Bahasa Inggris','اللغة الإنجليزية',NULL,1,1,'2021-12-09 17:03:46','2021-12-09 17:51:55'),(13,6,'Tingkat kehadiran','نسبة الحضور',NULL,1,1,'2021-12-09 17:03:52','2021-12-09 17:51:57'),(14,6,'Aktivitas dan kekuatan','النشاط والهمة',NULL,1,1,'2021-12-09 17:03:58','2021-12-09 17:52:50'),(15,6,'kekuatan dan kinerja','القدرة والأداء',NULL,1,1,'2021-12-09 17:04:04','2021-12-09 17:52:57'),(16,7,'Asosiasi Pembaca dan Pelestarian','جمعية القراء والحفاظ',NULL,1,1,'2021-12-09 17:04:09','2021-12-09 17:53:03'),(17,7,'Asosiasi Pelapor','جمعية المبلغين',NULL,1,1,'2021-12-09 17:04:15','2021-12-09 17:53:09'),(18,7,'Asosiasi Perencana','جمعية الخططين',NULL,1,1,'2021-12-09 17:04:20','2021-12-09 17:53:15'),(19,7,'Asosiasi Lagu Kebangsaan','جمعية النشيد',NULL,1,1,'2021-12-09 17:04:26','2021-12-09 17:53:20'),(20,8,'Tingkat kehadiran','نسبة الحضور',NULL,1,1,'2021-12-09 17:04:31','2021-12-09 17:53:28'),(21,9,'Pelanggaran serius','المخالفة الخطيرة',NULL,1,1,'2021-12-09 17:04:36','2021-12-09 17:53:34'),(22,9,'pelanggaran rata-rata','المخالفة المتوسطة',NULL,1,1,'2021-12-09 17:04:43','2021-12-09 17:53:39'),(23,9,'Pelanggaran kecil','المخالفة الطفيفة',NULL,1,1,'2021-12-09 17:04:48','2021-12-09 17:53:46'),(24,10,'keseriusan dalam belajar','الجدية في المذاكرة',NULL,1,1,'2021-12-09 17:04:52','2021-12-09 17:53:52'),(25,10,'kesehatan','مراعة الصحة',NULL,1,1,'2021-12-09 17:04:58','2021-12-09 17:53:58'),(26,10,'Perhatikan kebersihan institut','مراعة نظافة المعهد',NULL,1,1,'2021-12-09 17:05:02','2021-12-09 17:54:04'),(27,10,'Ketekunan dan awal','المواظبة والتبكير',NULL,1,1,'2021-12-09 17:05:07','2021-12-09 17:54:10'),(28,10,'Tanggung jawab','المسؤولية',NULL,1,1,'2021-12-09 17:05:09','2021-12-09 17:54:12');

/*Data for the table `ep_boarding_activity_group` */

TRUNCATE `ep_boarding_activity_group`;

INSERT  INTO `ep_boarding_activity_group`(`id`,`name`,`name_ar`,`cby`,`uby`,`con`,`uon`) VALUES (1,'Ibadah Wajib & Nafafil','العبادة والنوافل',1,1,'2021-12-07 09:27:33','2021-12-09 16:38:46'),(2,'Ikrar Al-Qur\'an','تعاهد القرآن',1,1,'2021-12-07 09:28:43','2021-12-08 16:23:34'),(3,'Pelajaran masjid','دروس المسجد',1,1,'2021-12-07 09:41:07','2021-12-08 16:40:38'),(4,'Pelatihan berbicara di depan umum','التدريب على الخطابة',1,1,'2021-12-09 16:34:41','2021-12-09 18:11:10'),(5,'Latihan bahasa','ممارسة اللغة\r\n\r\n',1,1,'2021-12-09 16:34:49','2021-12-09 18:11:25'),(6,'Pramuka','الكشافة',1,1,'2021-12-09 16:34:58','2021-12-09 18:11:32'),(7,'Kegiatan ekstrakurikuler yang dipilih','الأنشطة اللامنهجية المختارة',1,1,'2021-12-09 16:35:05','2021-12-09 18:11:34'),(8,'Menghadiri di dalam ruangan','الحضور في الغرفة',1,1,'2021-12-09 16:35:12','2021-12-09 18:11:52'),(9,'Pelanggaran sistem','مخالفة النظام',1,1,'2021-12-09 16:35:18','2021-12-09 18:12:01'),(10,'Catatan Pengawas dan Pengurus Rumah Tangga','ملاحظات المشرف والمدبر',1,1,'2021-12-09 16:35:25','2021-12-09 18:12:03');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
