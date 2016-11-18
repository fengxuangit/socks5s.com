-- MySQL dump 10.13  Distrib 5.7.9, for osx10.9 (x86_64)
--
-- Host: localhost    Database: shadow
-- ------------------------------------------------------
-- Server version	5.7.10

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
-- Table structure for table `s_cardpass`
--

DROP TABLE IF EXISTS `s_cardpass`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `s_cardpass` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cardnum` char(32) NOT NULL,
  `cardpass` char(32) DEFAULT NULL,
  `status` int(11) DEFAULT '-1',
  `user` varchar(200) DEFAULT NULL,
  `money` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `i_cardnum` (`cardnum`),
  KEY `i_cardpass` (`cardpass`),
  KEY `i_status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=201 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `s_cardpass`
--

LOCK TABLES `s_cardpass` WRITE;
/*!40000 ALTER TABLE `s_cardpass` DISABLE KEYS */;
/*!40000 ALTER TABLE `s_cardpass` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `s_host`
--

DROP TABLE IF EXISTS `s_host`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `s_host` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hostip` varchar(16) NOT NULL,
  `address` varchar(100) DEFAULT NULL,
  `usage` varchar(45) DEFAULT NULL,
  `port` int(11) NOT NULL DEFAULT '20000',
  `zone` varchar(45) DEFAULT NULL,
  `domain` varchar(200) DEFAULT NULL,
  `hoststatus` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `i_hostip` (`hostip`),
  KEY `i_zone` (`zone`),
  KEY `i_port` (`port`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `s_host`
--

LOCK TABLES `s_host` WRITE;
/*!40000 ALTER TABLE `s_host` DISABLE KEYS */;
INSERT INTO `s_host` VALUES (1,'45.76.213.246','日本',NULL,10000,'fuck01','sp1.evalshell.com','nice');
/*!40000 ALTER TABLE `s_host` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `s_recharge`
--

DROP TABLE IF EXISTS `s_recharge`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `s_recharge` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(200) DEFAULT NULL,
  `money` varchar(45) DEFAULT NULL,
  `ssid` varchar(45) DEFAULT NULL,
  `create_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `i_user` (`user`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `s_recharge`
--

LOCK TABLES `s_recharge` WRITE;
/*!40000 ALTER TABLE `s_recharge` DISABLE KEYS */;
/*!40000 ALTER TABLE `s_recharge` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `s_records`
--

DROP TABLE IF EXISTS `s_records`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `s_records` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(100) NOT NULL,
  `ispay` int(11) NOT NULL DEFAULT '0',
  `buytime` int(11) DEFAULT NULL,
  `time` int(11) NOT NULL,
  `money` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `s_records`
--

LOCK TABLES `s_records` WRITE;
/*!40000 ALTER TABLE `s_records` DISABLE KEYS */;
INSERT INTO `s_records` VALUES (8,'hacktext@163.com',1,30,1479447589,10),(9,'hacktext@163.com',1,30,1479447616,10),(10,'hacktext@163.com',1,30,1479447838,10),(11,'hacktext@163.com',1,360,1479449756,100),(12,'hacktext@163.com',1,30,1479449823,10),(13,'hacktext@163.com',1,360,1479450082,100),(14,'hacktext@163.com',1,360,1479450141,100),(15,'hacktext@163.com',1,30,1479450354,10),(16,'hacktext@163.com',1,30,1479450391,10),(17,'hacktext@163.com',1,30,1479450493,10),(18,'hacktext@163.com',1,30,1479457455,10),(19,'hacktext@163.com',1,30,1479462220,10),(20,'978348306@qq.com',1,30,1479469085,10),(21,'978348306@qq.com',1,30,1479469159,10);
/*!40000 ALTER TABLE `s_records` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `s_settings`
--

DROP TABLE IF EXISTS `s_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `s_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `price` int(11) DEFAULT NULL,
  `buylink` varchar(200) DEFAULT NULL,
  `allzone` varchar(45) DEFAULT NULL,
  `encrypt` varchar(45) DEFAULT 'aes-256-cfb',
  PRIMARY KEY (`id`),
  KEY `i_buylink` (`buylink`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `s_settings`
--

LOCK TABLES `s_settings` WRITE;
/*!40000 ALTER TABLE `s_settings` DISABLE KEYS */;
INSERT INTO `s_settings` VALUES (1,10,'a:2:{i:7;s:19:\"http://t.cn/RffKOgP\";i:70;s:19:\"http://t.cn/RfMxowQ\";}','fuck01,','rc4-md5');
/*!40000 ALTER TABLE `s_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `s_ssaccount`
--

DROP TABLE IF EXISTS `s_ssaccount`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `s_ssaccount` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `port` int(11) DEFAULT NULL,
  `pass` varchar(45) DEFAULT NULL,
  `status` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `i_port` (`port`),
  KEY `i_pass` (`pass`)
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `s_ssaccount`
--

LOCK TABLES `s_ssaccount` WRITE;
/*!40000 ALTER TABLE `s_ssaccount` DISABLE KEYS */;
/*!40000 ALTER TABLE `s_user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-11-19 11:13:20
