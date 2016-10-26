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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `s_host`
--

LOCK TABLES `s_host` WRITE;
/*!40000 ALTER TABLE `s_host` DISABLE KEYS */;
INSERT INTO `s_host` VALUES (1,'128.199.185.239','日本','1');
/*!40000 ALTER TABLE `s_host` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `s_orderlist`
--

DROP TABLE IF EXISTS `s_orderlist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `s_orderlist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `ordid` varchar(255) DEFAULT NULL,
  `ordtime` int(11) DEFAULT NULL,
  `productid` int(11) DEFAULT NULL,
  `ordtitle` varchar(255) DEFAULT NULL,
  `ordbuynum` int(11) DEFAULT '0',
  `ordprice` float(10,2) DEFAULT '0.00',
  `ordfee` float(10,2) DEFAULT '0.00',
  `ordstatus` int(11) DEFAULT '0',
  `payment_type` varchar(255) DEFAULT NULL,
  `payment_trade_no` varchar(255) DEFAULT NULL,
  `payment_trade_status` varchar(255) DEFAULT NULL,
  `payment_notify_id` varchar(255) DEFAULT NULL,
  `payment_notify_time` varchar(255) DEFAULT NULL,
  `payment_buyer_email` varchar(255) DEFAULT NULL,
  `ordcode` varchar(255) DEFAULT NULL,
  `isused` int(11) DEFAULT '0',
  `usetime` int(11) DEFAULT NULL,
  `checkuser` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `s_orderlist`
--

LOCK TABLES `s_orderlist` WRITE;
/*!40000 ALTER TABLE `s_orderlist` DISABLE KEYS */;
/*!40000 ALTER TABLE `s_orderlist` ENABLE KEYS */;
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
INSERT INTO `s_records` VALUES (21,'hack@qq.com',0,1,1477234802,7);
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `s_settings`
--

LOCK TABLES `s_settings` WRITE;
/*!40000 ALTER TABLE `s_settings` DISABLE KEYS */;
INSERT INTO `s_settings` VALUES (1,7);
/*!40000 ALTER TABLE `s_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `s_user`
--

DROP TABLE IF EXISTS `s_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `s_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `invitecode` char(32) DEFAULT NULL,
  `balance` float DEFAULT '0',
  `created_at` int(11) NOT NULL,
  `buytime` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `s_user`
--

LOCK TABLES `s_user` WRITE;
/*!40000 ALTER TABLE `s_user` DISABLE KEYS */;
INSERT INTO `s_user` VALUES (8,'hack@qq.com','1e38de0a85d4178ac353e165aabba0ab','hack@qq.com','',0,1477126555,0);
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

-- Dump completed on 2016-10-25 20:36:36
