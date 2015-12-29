-- MySQL dump 10.13  Distrib 5.6.27, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: guk_finance
-- ------------------------------------------------------
-- Server version	5.6.27-0ubuntu1

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
-- Table structure for table `fin_form`
--

DROP TABLE IF EXISTS `fin_form`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fin_form` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at_ts` int(11) NOT NULL DEFAULT '0',
  `created_by_user_id` int(11) NOT NULL DEFAULT '0',
  `comment` text NOT NULL,
  `is_current` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fin_form`
--

LOCK TABLES `fin_form` WRITE;
/*!40000 ALTER TABLE `fin_form` DISABLE KEYS */;
INSERT INTO `fin_form` VALUES (1,0,0,'Расчет потребностей 2015',0),(2,1451366501,0,'Расчет потребностей 2016 5',1);
/*!40000 ALTER TABLE `fin_form` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fin_form_cell`
--

DROP TABLE IF EXISTS `fin_form_cell`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fin_form_cell` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `col_id` int(11) NOT NULL,
  `row_id` int(11) NOT NULL,
  `value` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fin_form_cell`
--

LOCK TABLES `fin_form_cell` WRITE;
/*!40000 ALTER TABLE `fin_form_cell` DISABLE KEYS */;
INSERT INTO `fin_form_cell` VALUES (1,8,3,'310'),(2,10,3,'Увеличение стоимости основных средств'),(3,1,1,'1'),(4,1,2,'3'),(5,2,2,'44'),(6,6,3,'67'),(7,3,1,'5');
/*!40000 ALTER TABLE `fin_form_cell` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fin_form_col`
--

DROP TABLE IF EXISTS `fin_form_col`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fin_form_col` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `form_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL DEFAULT '',
  `weight` int(11) NOT NULL DEFAULT '0',
  `is_editable_by_vuz` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fin_form_col`
--

LOCK TABLES `fin_form_col` WRITE;
/*!40000 ALTER TABLE `fin_form_col` DISABLE KEYS */;
INSERT INTO `fin_form_col` VALUES (1,2,'Раздел',1,0),(2,2,'Подраздел',2,0),(3,2,'П (Н) НР',3,0),(4,2,'Подпрограмма',4,0),(5,2,'Основное мероприятие',5,0),(6,2,'Направление расходов',6,0),(7,2,'Вид расхода',8,0),(8,2,'КОСГУ',9,0),(9,2,'Статья расходов',10,0),(10,2,'Наименование расходов',11,0),(11,2,'Сумма (тыс.руб.)',12,1),(12,2,'Пункты финанасово экономического обоснования',13,1);
/*!40000 ALTER TABLE `fin_form_col` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fin_form_row`
--

DROP TABLE IF EXISTS `fin_form_row`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fin_form_row` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `form_id` int(11) NOT NULL,
  `weight` int(11) NOT NULL DEFAULT '0',
  `limit_int` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fin_form_row`
--

LOCK TABLES `fin_form_row` WRITE;
/*!40000 ALTER TABLE `fin_form_row` DISABLE KEYS */;
INSERT INTO `fin_form_row` VALUES (1,2,1,0),(2,2,2,0),(3,2,3,0),(4,2,4,0),(5,2,5,0);
/*!40000 ALTER TABLE `fin_form_row` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fin_request`
--

DROP TABLE IF EXISTS `fin_request`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fin_request` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at_ts` int(11) NOT NULL DEFAULT '0',
  `created_by_user_id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(250) NOT NULL DEFAULT '',
  `vuz_id` int(11) NOT NULL,
  `fin_form_id` int(11) NOT NULL,
  `status_code` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fin_request`
--

LOCK TABLES `fin_request` WRITE;
/*!40000 ALTER TABLE `fin_request` DISABLE KEYS */;
INSERT INTO `fin_request` VALUES (1,0,0,'Заявка на 2016 год 4545',1,2,0),(2,1451317117,0,'36456 345 3y45',1,2,0),(3,1451317182,0,'ityi8',1,2,0),(4,1451317251,0,'trheth e et',1,2,1),(5,1451318361,0,'ghjka askfb kj askjfhb',1,2,1);
/*!40000 ALTER TABLE `fin_request` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fin_request_cell`
--

DROP TABLE IF EXISTS `fin_request_cell`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fin_request_cell` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fin_request_id` int(11) NOT NULL,
  `col_id` int(11) NOT NULL,
  `row_id` int(11) NOT NULL,
  `value` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fin_request_cell`
--

LOCK TABLES `fin_request_cell` WRITE;
/*!40000 ALTER TABLE `fin_request_cell` DISABLE KEYS */;
INSERT INTO `fin_request_cell` VALUES (1,1,12,4,'tty'),(2,1,11,1,'123'),(3,1,11,2,'77ee'),(4,1,11,3,'6789ывпжр'),(5,1,12,1,'jhgsdkjfg '),(6,1,12,2,'wert'),(7,1,12,3,'455'),(8,1,11,4,'ttbdfghkdfjvbk jkdbv'),(9,1,11,5,'ttyy56'),(10,4,11,1,'700'),(11,4,11,2,'900'),(12,4,12,1,'п. 7.4'),(13,4,12,2,'п. 4.5'),(14,5,11,1,'1'),(15,5,11,2,'2'),(16,5,11,3,'55'),(17,5,11,4,'66');
/*!40000 ALTER TABLE `fin_request_cell` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vuz`
--

DROP TABLE IF EXISTS `vuz`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vuz` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at_ts` int(11) NOT NULL DEFAULT '0',
  `created_by_user_id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(250) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vuz`
--

LOCK TABLES `vuz` WRITE;
/*!40000 ALTER TABLE `vuz` DISABLE KEYS */;
INSERT INTO `vuz` VALUES (1,0,0,'Академия ракетных войск стратегического назначения');
/*!40000 ALTER TABLE `vuz` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-12-29  9:28:12
