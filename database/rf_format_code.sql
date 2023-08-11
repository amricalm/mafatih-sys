CREATE TABLE `rf_format_code` (
  `code` CHAR(3) NOT NULL,
  `desc` VARCHAR(50) DEFAULT NULL,
  PRIMARY KEY (`code`)
) ENGINE=INNODB DEFAULT CHARSET=latin1;

INSERT  INTO `rf_format_code`(`code`,`desc`) VALUES ('0','Raport Akademik'),('1','Raport Pengasuhan'),('2','Raport Diknas');

ALTER TABLE ep_grade
ADD `format_code` INT(1) NOT NULL DEFAULT '0' AFTER `id`;

ALTER TABLE ep_final_grade_dtl
ADD `knowledge_desc` TEXT AFTER `letter_grade`,
ADD `skill_desc` TEXT AFTER `knowledge_desc`;

/*
SQLyog Ultimate v11.11 (64 bit)
MySQL - 5.7.33 : Database - msh
*********************************************************************
*/

CREATE TABLE `ep_subject_diknas` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL,
  `group` INT(1) DEFAULT NULL,
  `seq` INT(2) DEFAULT NULL,
  `cby` INT(11) NOT NULL COMMENT 'Created By = uid',
  `uby` INT(11) NOT NULL COMMENT 'Updated By = uid',
  `con` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Created On',
  `uon` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Updated On',
  PRIMARY KEY (`id`)
) ENGINE=INNODB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;