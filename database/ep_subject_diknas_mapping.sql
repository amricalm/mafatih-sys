ALTER TABLE ep_subject_diknas RENAME ep_subject_diknas_mapping;


CREATE TABLE `ep_subject_diknas` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) DEFAULT NULL,
  `cby` INT(11) DEFAULT NULL,
  `uby` INT(11) DEFAULT NULL,
  `con` TIMESTAMP NULL DEFAULT NULL,
  `uon` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=INNODB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

INSERT  INTO `ep_subject_diknas`(`id`,`name`,`cby`,`uby`,`con`,`uon`) VALUES (1,'Pendidikan Agama dan Budipekerti',1,1,'2023-01-13 17:17:01','2023-01-13 18:20:51'),(2,'Pendidikan Pancasila dan Kewarganegaraan',1,1,'2023-01-13 17:17:01','2023-01-13 17:17:01'),(3,'Bahasa Indonesia',1,1,'2023-01-13 17:17:01','2023-01-13 17:17:01'),(4,'Matematika',1,1,'2023-01-13 17:17:01','2023-01-13 17:17:01'),(5,'Ilmu Pengetahuan Alam',1,1,'2023-01-13 17:17:01','2023-01-13 17:17:01'),(6,'Ilmu Pengetahuan Sosial',1,1,'2023-01-13 17:17:01','2023-01-13 17:17:01'),(7,'Bahasa Inggris',1,1,'2023-01-13 17:17:01','2023-01-13 17:17:01'),(8,'Seni Budaya',1,1,'2023-01-13 17:17:01','2023-01-13 17:17:01'),(9,'Pendidikan Jasmani, Olah Raga, dan Kesehatan',1,1,'2023-01-13 17:17:01','2023-01-13 17:17:01'),(10,'Prakarya',1,1,'2023-01-13 17:17:01','2023-01-13 17:17:01');

