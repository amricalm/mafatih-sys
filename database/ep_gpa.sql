# ************************************************************
# Antares - SQL Client
# Version 0.7.1
# 
# https://antares-sql.app/
# https://github.com/antares-sql/antares
# 
# Host: 127.0.0.1 ((Ubuntu) 5.7.40)
# Database: msh-temp2
# Generation time: 2023-01-06T01:36:54+07:00
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
SET NAMES utf8mb4;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table ep_gpa
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ep_gpa`;

CREATE TABLE `ep_gpa` (
  `ayid` int(10) NOT NULL,
  `tid` int(10) NOT NULL,
  `sid` int(10) NOT NULL,
  `gpa` decimal(10,2) NOT NULL,
  KEY `INDEX_SR17` (`ayid`,`tid`,`sid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Kumpulan IPK';



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

# Dump completed on 2023-01-06T01:36:54+07:00
