# ************************************************************
# Antares - SQL Client
# Version 0.6.0
# 
# https://antares-sql.app/
# https://github.com/antares-sql/antares
# 
# Host: 127.0.0.1 ((Ubuntu) 5.7.40)
# Database: msh
# Generation time: 2022-11-29T11:45:57+07:00
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
SET NAMES utf8mb4;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table ep_bayanat_result
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ep_bayanat_result`;

CREATE TABLE `ep_bayanat_result` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
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
  `uon` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `INDEX_0QRQ` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4;



# Dump of table ep_bayanat_result_dtl
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ep_bayanat_result_dtl`;

CREATE TABLE `ep_bayanat_result_dtl` (
  `hid` int(11) NOT NULL COMMENT 'header id',
  `id_evaluation` int(11) DEFAULT NULL,
  `weight_evaluation` int(10) DEFAULT NULL,
  `result_evaluation` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

# Dump completed on 2022-11-29T11:45:58+07:00
