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

TRUNCATE `aa_student`;

INSERT  INTO `aa_student`(`id`,`pid`,`nis`,`nisn`,`cby`,`uby`,`con`,`uon`) VALUES (1,42,'1200001','0082161850',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(2,43,'1200002','0073154074',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(3,44,'1200003','0084086409',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(4,45,'1200004','0072871047',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(5,46,'1200005','2089012479',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(6,47,'1200006','0088844069',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(7,48,'1200007','0083892124',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(8,49,'1200008','2085278705',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(9,50,'1200009','0076053629',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(10,51,'1200010','0077014153',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(11,52,'1200011','0077047077',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(12,53,'1200012','0082369658',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(13,54,'1200013','0063021410',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(14,55,'1200014','0083716756',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(15,56,'1200015','0086620379',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(16,57,'1200016','0088001442',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(17,58,'1200017','2096257323',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(18,59,'1200018','0087652578',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(19,60,'1200019','3062520813',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(20,61,'1200020','0056551790',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(21,62,'1200021','0074525467',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(22,63,'1200022','3096780171',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(23,64,'1200023','3087168557',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(24,65,'1200024','0074237790',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(25,66,'1200025','0063001331',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(26,67,'1200026','0084202594',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(27,68,'1200027','0088182965',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(28,69,'1200028','0072059874',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(29,70,'1200029','',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(30,71,'1200030','0074434115',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(31,72,'1200031','0071941394',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(32,73,'1200032','0073982722',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(33,74,'1200033','3081774204',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(34,75,'1200034','',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(35,76,'1200035','3088347277',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(36,77,'1200036','0079668807',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(37,78,'1200037','3077562378',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(38,79,'1200038','0083821844',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(39,80,'1200039','3085511312',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(40,81,'1200040','0075149616',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(41,82,'1200041','0087539708',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(42,83,'1200042','0089592982',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(43,84,'1200045','0075749002',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(44,85,'1200043','0082328483',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(45,86,'1200044','3091442932',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(46,87,'1200046','0072385883',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(47,88,'1200047','0076785422',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(48,89,'1200048','0082783772',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(49,90,'1200049','2077224511',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(50,91,'1200050','0084016018',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(51,92,'1200051','3278703284',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(52,93,'1200052','0088710356',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(53,94,'1200053','0075947117',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(54,95,'1200054','0078641583',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(55,96,'1200055','0087721144',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(56,97,'1200056','0097476277',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(57,98,'1200057','0089162536',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(58,99,'1200072','3078370358',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(59,100,'1200058','0083362828',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(60,101,'1200084','0081796022',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(61,102,'1200059','0071866340',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(62,103,'1200060','0084867047',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(63,104,'1200061','2081057079',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(64,105,'1200062','0088133850',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(65,106,'1200063','0085182724',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(66,107,'1200064','0076087805',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(67,108,'1200065','0075529359',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(68,109,'1200066','0071582157',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(69,110,'1200067','0083039309',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(70,111,'1200068','0071426958',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(71,112,'1200069','0088230952',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(72,113,'1200070','0086093379',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(73,114,'1200071','0071957798',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(74,115,'1200073','3074800734',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(75,116,'1200074','2088093635',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(76,117,'1200075','0085994820',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(77,118,'1200076','0085496804',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(78,119,'1200077','0081105251',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(79,120,'1200078','0089875523',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(80,121,'1200079','0089212620',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(81,122,'1200080','0085969989',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(82,123,'1200081','0078029695',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(83,124,'1200082','0078011871',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(84,125,'1200083','0083139048',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(85,126,'1200085','0082618991',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(86,127,'1200086','0073715775',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(87,128,'1200087','0082985916',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(88,129,'1200088','0088706890',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(89,130,'1200089','0065680268',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(90,131,'1200090','0082561395',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(91,132,'1200091','0077497173',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(92,133,'1200092','0089981510',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(93,134,'1200093','0088615595',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(94,135,'1200094','0088055950',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(95,136,'1200095','0072607500',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(96,137,'1200096','0093264916',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(97,138,'1200097','0084985219',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(98,139,'1200098','3084991550',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(99,140,'1200099','0084326129',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(100,141,'1200100','0079192863',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(101,142,'1200101','0071487022',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(102,143,'1200102','0078532782',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(103,144,'1200103','0086420832',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(104,145,'1200104','3071142122',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(105,146,'1200105','0082173093',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(106,147,'1200106','',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(107,148,'1200107','0075406637',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(108,149,'1200108','0085248218',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(109,150,'1200109','3073786560',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(110,151,'2210001','3085482109',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(111,152,'2210002','2089247467',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(112,153,'2210003','0091220579',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(113,154,'2210004','0083577910',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(114,155,'2210005','0099517347',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(115,156,'2210006','3093516496',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(116,157,'2210007','3099712024',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(117,158,'2210008','0082204001',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(118,159,'2210009','0099294630',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(119,160,'2210010','3075805988',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(120,161,'2210011','3098698683',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(121,162,'2210012','0094750760',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(122,163,'2210013','0095652321',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(123,164,'2210014','0095841173',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(124,165,'2210015','',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(125,166,'2210016','0082749898',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(126,167,'2210128','Tidak punya',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(127,168,'2210017','0092456621',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(128,169,'2210018','0099853524',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(129,170,'2210019','0095851014',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(130,171,'2210020','0093971936',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(131,172,'2210021','0082635545',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(132,173,'2210022','0087588708',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(133,174,'2210023','0081198309',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(134,175,'2210024','0089140046',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(135,176,'2210025','3091377788',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(136,177,'2210026','0081658659',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(137,178,'2210027','0091280461',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(138,179,'2210076','',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(139,180,'2210028','2081981682',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(140,181,'2210029','0081987718',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(141,182,'2210030','0082504142',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(142,183,'2210031','3092873056',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(143,184,'2210032','3096979557',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(144,185,'2210033','0086527411',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(145,186,'2210034','0099700019',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(146,187,'2210035','',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(147,188,'2210036','3088424097',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(148,189,'2210037','',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(149,190,'2210038','3107164225',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(150,191,'2210039','0089356871',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(151,192,'2210040','0091898777',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(152,193,'2210041','0097871011',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(153,194,'2210042','0097009374',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(154,195,'2210043','0085116954',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(155,196,'2210044','0083210414',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(156,197,'2210045','0086858152',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(157,198,'2210046','3098685914',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(158,199,'2210047','0099569634',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(159,200,'2210048','0092217166',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(160,201,'2210049','',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(161,202,'2210050','0086132908',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(162,203,'2210051','3087893802',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(163,204,'2210052','0087404387',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(164,205,'2210053','3099133957',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(165,206,'2210054','2096614914',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(166,207,'2210055','0099999774',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(167,208,'2210056','0095855897',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(168,209,'2210057','0079345715',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(169,210,'2210058','0093618835',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(170,211,'2210059','3095627099',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(171,212,'2210060','',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(172,213,'2210061','0099740965',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(173,214,'2210062','3092676383',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(174,215,'2210063','0095247526',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(175,216,'2210064','3094572314',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(176,217,'2210065','3088730375',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(177,218,'2210066','0097473531',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(178,219,'2210094','‘0098243045',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(179,220,'2210067','0083696694',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(180,221,'2210068','0095192270',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(181,222,'2210069','3095212524',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(182,223,'2210070','3081886823',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(183,224,'2210071','0099667647',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(184,225,'2210072','',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(185,226,'2210073','0086634569',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(186,227,'2210074','0098045702',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(187,228,'2210075','0086314530',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(188,229,'2210077','0082340612',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(189,230,'2210078','3099004680',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(190,231,'2210079','0094668362',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(191,232,'2210080','3084225184',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(192,233,'2210081','0071888166',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(193,234,'2210082','',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(194,235,'2210083','3097780072',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(195,236,'2210084','',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(196,237,'2210085','3085543448',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(197,238,'2210086','3092276216',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(198,239,'2210087','',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(199,240,'2210088','2094761992',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(200,241,'2210089','0095105896',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(201,242,'2210090','0091742407',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(202,243,'2210091','3091438317',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(203,244,'2210092','3083934873',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(204,245,'2210093','',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(205,246,'2210095','0099680319',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(206,247,'2210096','3084601016',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(207,248,'2210097','3080249206',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(208,249,'2210098','3091676282',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(209,250,'2210099','3080856003',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(210,251,'2210100','0087678543',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(211,252,'2210101','3095124494',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(212,253,'2210102','0081109947',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(213,254,'2210103','',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(214,255,'2210104','3092751722',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(215,256,'2210105','3081288289',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(216,257,'2210106','0085469617',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(217,258,'2210107','',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(218,259,'2210108','0085496513',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(219,260,'2210109','0094788625',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(220,261,'2210110','0086706046',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(221,262,'2210111','0096484769',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(222,263,'2210112','0081887673',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(223,264,'2210113','3095035002',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(224,265,'2210114','0099718187',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(225,266,'2210115','3083607959',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(226,267,'2210116','2095175430',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(227,268,'2210117','0082271409',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(228,269,'2210118','0099603040',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(229,270,'2210119','0097791889',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(230,271,'2210120','0093485502',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(231,272,'2210122','0017244506',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(232,273,'2210123','3097714610',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(233,274,'2210121','0083388929',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(234,275,'2210124','3091985634',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(235,276,'2210125','0091692609',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(236,277,'2210126','0087364648',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(237,278,'2210127','2087218719',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(238,279,'2210129','3090152220',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52'),(239,280,'2210130','3098433550',1,1,'2021-12-09 14:02:52','2021-12-09 14:02:52');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
