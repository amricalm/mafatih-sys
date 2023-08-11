ALTER TABLE aa_person
ADD nik INT(50) AFTER `name_ar`,
ADD kk INT(50) AFTER `nik`,
ADD aktalahir VARCHAR(50) AFTER `kk`,
ADD blood VARCHAR(2) AFTER `weight`,
ADD disease VARCHAR(255) AFTER `hobbies`,
ADD traumatic VARCHAR(255) AFTER `disease`,
ADD disability VARCHAR(5) AFTER `traumatic`,
ADD disability_type VARCHAR(255) AFTER `disability`,
ADD email VARCHAR(50) AFTER `disability_type`,
ADD phone VARCHAR(20) AFTER `email`,
ADD relation VARCHAR(100) AFTER `phone`;

CREATE TABLE `aa_school_origin` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `pid` INT(11) UNSIGNED NOT NULL COMMENT 'person.id',
  `school_origin` VARCHAR(10) CHARACTER SET latin1 DEFAULT NULL COMMENT 'Asal Sekolah',
  `school_origin_name` VARCHAR(50) CHARACTER SET latin1 DEFAULT NULL COMMENT 'Nama Sekolah Asal',
  `diploma_number` VARCHAR(50) CHARACTER SET latin1 DEFAULT NULL COMMENT 'Nomor Ijazah',
  `diploma_year` DATE DEFAULT NULL COMMENT 'Tahun Ijazah',
  `exam_number` VARCHAR(50) CHARACTER SET latin1 DEFAULT NULL COMMENT 'Nomor Ujian',
  `skhu` VARCHAR(50) CHARACTER SET latin1 DEFAULT NULL COMMENT 'Nomor SKHU',
  `study_year` INT(2) DEFAULT NULL COMMENT 'Lama Belajar',
  `school_origin_tf` VARCHAR(50) CHARACTER SET latin1 DEFAULT NULL COMMENT 'Pindahan Dari Sekolah',
  `move_date` DATE DEFAULT NULL COMMENT 'Tanggal Pindah',
  `from_class` INT(2) DEFAULT NULL COMMENT 'Dari Kelas',
  `in_class` INT(2) DEFAULT NULL COMMENT 'Di Kelas',
  `received_date` DATE DEFAULT NULL COMMENT 'Tanggal Diterima',
  `cby` INT(11) NOT NULL COMMENT 'Created By = uid',
  `uby` INT(11) NOT NULL COMMENT 'Updated By = uid',
  `con` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Created On',
  `uon` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Updated On',
  PRIMARY KEY (`id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;


ALTER TABLE aa_student MODIFY nis VARCHAR(20) NULL;
ALTER TABLE aa_student MODIFY nisn VARCHAR(20) NULL;