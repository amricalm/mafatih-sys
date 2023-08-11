# ************************************************************
# Antares - SQL Client
# Version 0.7.2
# 
# https://antares-sql.app/
# https://github.com/antares-sql/antares
# 
# Host: 127.0.0.1 ((Ubuntu) 5.7.40)
# Database: msh-temp2
# Generation time: 2023-01-28T16:37:29+07:00
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
SET NAMES utf8mb4;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table ms_notif
# ------------------------------------------------------------

CREATE TABLE `ms_notif` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `notif_title` varchar(100) NOT NULL,
  `notif_message` text NOT NULL,
  `notif_image` varchar(100) CHARACTER SET latin1 NOT NULL,
  `notif_url` varchar(100) CHARACTER SET latin1 NOT NULL,
  `notif_respond` text NOT NULL,
  `notif_datetime` datetime DEFAULT NULL,
  `notif_hit` int(10) unsigned zerofill NOT NULL,
  `id_respond` tinyint(30) NOT NULL,
  `cby` int(10) DEFAULT NULL,
  `uby` int(10) DEFAULT NULL,
  `con` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `uon` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `INDEX_991H` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COMMENT='Notif';



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

# Dump completed on 2023-01-28T16:37:29+07:00
