/*
SQLyog Professional v13.1.1 (64 bit)
MySQL - 5.7.24 : Database - msh-sys
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `ep_final_grade` */

DROP TABLE IF EXISTS `ep_final_grade`;

CREATE TABLE `ep_final_grade` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `format_code` varchar(50) NOT NULL DEFAULT '0' COMMENT 'kode format rapor',
  `reg_no` varchar(50) NOT NULL DEFAULT '0' COMMENT 'no registrasi (unik)',
  `qr_code` varchar(50) NOT NULL DEFAULT '0' COMMENT 'nomor qr code',
  `published` bit(1) NOT NULL DEFAULT b'0' COMMENT 'status publikasi',
  `ayid` int(11) unsigned NOT NULL COMMENT 'academic_year.id',
  `tid` int(11) unsigned NOT NULL COMMENT 'rf_term.id',
  `subject_id` int(11) unsigned NOT NULL COMMENT 'subject.id',
  `subject_seq_no` int(11) unsigned NOT NULL COMMENT 'no urut tampilan',
  `sid` int(11) unsigned NOT NULL COMMENT 'student.id',
  `formative_val` int(11) unsigned DEFAULT NULL,
  `mid_exam` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'uts',
  `final_exam` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'uas',
  `final_grade` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'na',
  `lesson_hours` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'jam pelajaran/pekan',
  `weighted_grade` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'bobot jp = jpxna',
  `class_avg` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'rata-rata per kelas',
  `sum_weighted_grade` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'jumlah bobot jp',
  `sum_lesson_hours` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'jumlah jp/pekan',
  `ips` int(11) unsigned NOT NULL DEFAULT '0',
  `gpa_prev` int(11) unsigned NOT NULL DEFAULT '0',
  `gpa` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'ipk = grade point average',
  `result` varchar(50) NOT NULL DEFAULT '0' COMMENT 'kesimpulan naik kelas',
  `letter_grade` varchar(50) NOT NULL DEFAULT '0' COMMENT 'nilai huruf',
  `subject_remedy` int(11) unsigned NOT NULL DEFAULT '0',
  `cleanliness` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'kebersihan',
  `discipline` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'kedisiplinan',
  `behavior` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'akhlaq',
  `absent_a` int(11) unsigned NOT NULL DEFAULT '0',
  `absent_s` int(11) NOT NULL,
  `absent_i` int(11) NOT NULL,
  `memorizing_quran` varchar(50) CHARACTER SET utf8mb4 DEFAULT NULL,
  `activities_parent` varchar(50) CHARACTER SET utf8mb4 DEFAULT NULL,
  `note_from_student_affairs` varchar(50) CHARACTER SET utf8mb4 DEFAULT NULL,
  `form_teacher` varchar(50) NOT NULL DEFAULT '' COMMENT 'walikelas',
  `principal` varchar(50) NOT NULL DEFAULT '' COMMENT 'kepala sekolah',
  `date_legization` varchar(50) NOT NULL DEFAULT '',
  `hijri_date_legization` varchar(50) NOT NULL,
  `cby` int(11) NOT NULL COMMENT 'Created By = uid',
  `uby` int(11) NOT NULL COMMENT 'Updated By = uid',
  `con` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Created On',
  `uon` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Updated On',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `ep_final_grade_dtl` */

DROP TABLE IF EXISTS `ep_final_grade_dtl`;

CREATE TABLE `ep_final_grade_dtl` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `format_code` varchar(50) NOT NULL DEFAULT '0' COMMENT 'kode format rapor',
  `reg_no` varchar(50) NOT NULL DEFAULT '0' COMMENT 'no registrasi (unik)',
  `qr_code` varchar(50) NOT NULL DEFAULT '0' COMMENT 'nomor qr code',
  `published` bit(1) NOT NULL DEFAULT b'0' COMMENT 'status publikasi',
  `ayid` int(11) unsigned NOT NULL COMMENT 'academic_year.id',
  `tid` int(11) unsigned NOT NULL COMMENT 'rf_term.id',
  `subject_id` int(11) unsigned NOT NULL COMMENT 'subject.id',
  `subject_seq_no` int(11) unsigned NOT NULL COMMENT 'no urut tampilan',
  `sid` int(11) unsigned NOT NULL COMMENT 'student.id',
  `formative_val` int(11) unsigned DEFAULT NULL,
  `mid_exam` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'uts',
  `final_exam` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'uas',
  `final_grade` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'na',
  `lesson_hours` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'jam pelajaran/pekan',
  `weighted_grade` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'bobot jp = jpxna',
  `class_avg` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'rata-rata per kelas',
  `sum_weighted_grade` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'jumlah bobot jp',
  `sum_lesson_hours` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'jumlah jp/pekan',
  `ips` int(11) unsigned NOT NULL DEFAULT '0',
  `gpa_prev` int(11) unsigned NOT NULL DEFAULT '0',
  `gpa` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'ipk = grade point average',
  `result` varchar(50) NOT NULL DEFAULT '0' COMMENT 'kesimpulan naik kelas',
  `letter_grade` varchar(50) NOT NULL DEFAULT '0' COMMENT 'nilai huruf',
  `subject_remedy` int(11) unsigned NOT NULL DEFAULT '0',
  `cleanliness` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'kebersihan',
  `discipline` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'kedisiplinan',
  `behavior` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'akhlaq',
  `absent_a` int(11) unsigned NOT NULL DEFAULT '0',
  `absent_s` int(11) NOT NULL,
  `absent_i` int(11) NOT NULL,
  `memorizing_quran` varchar(50) CHARACTER SET utf8mb4 DEFAULT NULL,
  `activities_parent` varchar(50) CHARACTER SET utf8mb4 DEFAULT NULL,
  `note_from_student_affairs` varchar(50) CHARACTER SET utf8mb4 DEFAULT NULL,
  `form_teacher` varchar(50) NOT NULL DEFAULT '' COMMENT 'walikelas',
  `principal` varchar(50) NOT NULL DEFAULT '' COMMENT 'kepala sekolah',
  `date_legization` varchar(50) NOT NULL DEFAULT '',
  `hijri_date_legization` varchar(50) NOT NULL,
  `cby` int(11) NOT NULL COMMENT 'Created By = uid',
  `uby` int(11) NOT NULL COMMENT 'Updated By = uid',
  `con` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Created On',
  `uon` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Updated On',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
