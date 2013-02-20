-- MySQL dump 10.13  Distrib 5.5.29, for osx10.8 (i386)
--
-- Host: 127.0.0.1    Database: moodreader
-- ------------------------------------------------------
-- Server version	5.5.27

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `tag_category`
--

DROP TABLE IF EXISTS `tag_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tag_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tag_category`
--

LOCK TABLES `tag_category` WRITE;
/*!40000 ALTER TABLE `tag_category` DISABLE KEYS */;
INSERT INTO `tag_category` VALUES (1,'geo'),(2,'generic');
/*!40000 ALTER TABLE `tag_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tags`
--

DROP TABLE IF EXISTS `tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `cats` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tags`
--

LOCK TABLES `tags` WRITE;
/*!40000 ALTER TABLE `tags` DISABLE KEYS */;
INSERT INTO `tags` VALUES (3,NULL,'iPhone','2'),(4,NULL,'apple','2'),(5,NULL,'gaming','2'),(6,NULL,'technology','2'),(7,NULL,'movies','2'),(8,NULL,'series','2'),(9,NULL,'japan','2'),(10,NULL,'travel','2'),(11,NULL,'food','2'),(12,NULL,'tv','2'),(13,NULL,'animation','2'),(14,NULL,'education','2'),(15,NULL,'sports','2');
/*!40000 ALTER TABLE `tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_tags`
--

DROP TABLE IF EXISTS `user_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tag_id` int(11) NOT NULL,
  `vdna_user_id` varchar(36) NOT NULL,
  `score` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_tags`
--

LOCK TABLES `user_tags` WRITE;
/*!40000 ALTER TABLE `user_tags` DISABLE KEYS */;
INSERT INTO `user_tags` VALUES (16,3,'a57a3563-e8d7-42cb-870c-df92ddeb8618',0.2),(17,4,'a57a3563-e8d7-42cb-870c-df92ddeb8618',0.3),(18,9,'a57a3563-e8d7-42cb-870c-df92ddeb8618',0.1),(19,5,'a57a3563-e8d7-42cb-870c-df92ddeb8618',0.18),(20,6,'a57a3563-e8d7-42cb-870c-df92ddeb8618',0.18),(21,7,'a57a3563-e8d7-42cb-870c-df92ddeb8618',0.6),(22,8,'a57a3563-e8d7sel-42cb-870c-df92ddeb8',0.35),(23,10,'a57a3563-e8d7sel-42cb-870c-df92ddeb8',0.38),(24,11,'a57a3563-e8d7sel-42cb-870c-df92ddeb8',0.9),(25,12,'a57a3563-e8d7sel-42cb-870c-df92ddeb8',0.1),(26,13,'a57a3563-e8d7sel-42cb-870c-df92ddeb8',0.67),(27,14,'a57a3563-e8d7sel-42cb-870c-df92ddeb8',0.61),(28,15,'a57a3563-e8d7sel-42cb-870c-df92ddeb8',0.11);
/*!40000 ALTER TABLE `user_tags` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-02-20 11:06:16
