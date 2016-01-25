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
-- Table structure for table `detail_cell`
--

DROP TABLE IF EXISTS `detail_cell`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detail_cell` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `detail_column_id` int(11) NOT NULL,
  `detail_row_id` int(11) NOT NULL,
  `value` varchar(1024) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detail_cell`
--

LOCK TABLES `detail_cell` WRITE;
/*!40000 ALTER TABLE `detail_cell` DISABLE KEYS */;
INSERT INTO `detail_cell` VALUES (1,4,1,'1010'),(2,6,1,'Плата за предоставление доступа и пользования линий связи и каналов связи'),(3,5,1,'4040'),(4,1,1,'Плата за предоставление доступа и пользования линий связи и каналов связи'),(5,2,1,'ед.'),(6,3,1,'4'),(7,6,2,'Регистрация телефонного номера и факса, кототорые используются для обучения ИВС.'),(8,1,2,'Плата за регистрацию сокращенного телефонного номера'),(9,2,2,'ед.'),(10,3,2,'7'),(11,4,2,'1'),(12,5,2,'7'),(13,1,3,'Приобретение расходных материалов для оргтехники'),(14,2,3,'к-т'),(15,5,3,'230'),(16,4,3,'23'),(17,3,3,'10'),(18,6,3,'Оргтехника обеспечена расходными материалами.'),(19,1,5,'Приобретение материалов для модернизации охранной сигнализации'),(20,2,5,'к-т'),(21,3,5,'10'),(22,4,5,'56'),(23,5,5,'560'),(24,6,5,'Модернизированная система пожарно-охранной сигнализации здания №1'),(25,1,6,'Работы по убслуживанию телевизоров, холодильников, кондиционеров'),(26,5,6,'200'),(27,4,6,'20'),(28,3,6,'10'),(29,2,6,'шт.'),(30,6,6,'Устранение неисправностей холодильников, телевизоров. Регламентное обслуживание и ремонт кондиционеров.'),(31,6,4,'Основные виды работ: замена окон, дверей, полов.'),(32,1,4,'Проведение текущего ремонта учебных аудиторий корпуса №41 для обучения иностранных специалистов'),(33,3,4,'1500'),(34,4,4,'7'),(35,5,4,'9500');
/*!40000 ALTER TABLE `detail_cell` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detail_columns`
--

DROP TABLE IF EXISTS `detail_columns`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detail_columns` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `is_requested_sum` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detail_columns`
--

LOCK TABLES `detail_columns` WRITE;
/*!40000 ALTER TABLE `detail_columns` DISABLE KEYS */;
INSERT INTO `detail_columns` VALUES (1,'Наименование расходов (услуги, закупки, работы)',0),(2,'Ед. изм.',0),(3,'Потребность',0),(4,'Примерная стоимость за единицу (тыс. руб.)',0),(5,'Общая стоимость (тыс. руб.)',1),(6,'Ожидаемый результат и краткое обоснование',0);
/*!40000 ALTER TABLE `detail_columns` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detail_rows`
--

DROP TABLE IF EXISTS `detail_rows`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detail_rows` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `request_id` int(11) NOT NULL,
  `form_row_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detail_rows`
--

LOCK TABLES `detail_rows` WRITE;
/*!40000 ALTER TABLE `detail_rows` DISABLE KEYS */;
INSERT INTO `detail_rows` VALUES (1,9,1),(2,9,1),(3,9,4),(4,9,5),(5,9,2),(6,9,2);
/*!40000 ALTER TABLE `detail_rows` ENABLE KEYS */;
UNLOCK TABLES;

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
  `is_hidden` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fin_form`
--

LOCK TABLES `fin_form` WRITE;
/*!40000 ALTER TABLE `fin_form` DISABLE KEYS */;
INSERT INTO `fin_form` VALUES (1,0,0,'Расчет потребностей 2015',0,1),(2,1451366501,0,'Расчет потребностей 2016',1,0),(3,0,0,'новая форма ',0,1),(4,1451384600,0,'проверка создания формы',0,1),(5,1451408583,0,'Расчет потребностей 2017',0,0);
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
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fin_form_cell`
--

LOCK TABLES `fin_form_cell` WRITE;
/*!40000 ALTER TABLE `fin_form_cell` DISABLE KEYS */;
INSERT INTO `fin_form_cell` VALUES (1,8,3,'310'),(2,10,3,'Увеличение стоимости основных средств'),(3,1,1,'02'),(4,1,2,'02'),(5,2,2,'07'),(6,6,3,'27980'),(7,3,1,'41'),(8,4,1,'1'),(9,4,4,'1'),(10,13,8,'56'),(11,14,8,'64456'),(12,14,9,'55'),(13,1,3,'02'),(14,1,4,'02'),(15,1,5,'02'),(16,2,1,'07'),(17,2,3,'07'),(18,2,4,'07'),(19,2,5,'07'),(20,3,2,'41'),(21,3,3,'41'),(22,3,4,'41'),(23,3,5,'41'),(24,4,2,'1'),(25,4,3,'1'),(26,4,5,'1'),(27,5,1,'11'),(28,5,2,'11'),(29,5,3,'11'),(30,5,4,'11'),(31,5,5,'11'),(32,6,1,'27980'),(33,6,2,'27980'),(34,6,4,'27980'),(35,6,5,'27980'),(36,7,1,'242'),(37,7,2,'242'),(38,7,3,'242'),(39,7,4,'242'),(40,7,5,'244'),(41,8,1,'221'),(42,8,2,'226'),(43,8,4,'340'),(44,8,5,'225'),(45,9,1,'7345(16)'),(46,9,2,'7345(16)'),(47,9,3,'7345(16)'),(48,9,4,'7345(16)'),(49,9,5,'7345(16)'),(50,10,1,'Услуги связи'),(51,10,2,'Прочие услуги'),(52,10,4,'Увеличение стоимости материальных запасов'),(53,10,5,'Услуги по содержанию имущества'),(54,17,14,'2-3-4-5-6-7-8'),(55,17,16,'4499');
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
  `is_requested_sum` tinyint(1) NOT NULL DEFAULT '0',
  `vocabulary_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fin_form_col`
--

LOCK TABLES `fin_form_col` WRITE;
/*!40000 ALTER TABLE `fin_form_col` DISABLE KEYS */;
INSERT INTO `fin_form_col` VALUES (1,2,'Раздел',1,0,0,0),(2,2,'Подраздел',2,0,0,0),(3,2,'П (Н) НР',3,0,0,0),(4,2,'Подпрограмма',4,0,0,0),(5,2,'Основное мероприятие',5,0,0,0),(6,2,'Направление расходов',6,0,0,0),(7,2,'Вид расхода',8,0,0,0),(8,2,'КОСГУ',9,0,0,0),(9,2,'Статья расходов',10,0,0,0),(10,2,'Наименование расходов',11,0,0,0),(11,2,'Сумма (тыс.руб.)',12,1,1,0),(12,2,'Пункты финанасово экономического обоснования',13,1,0,0),(13,1,'weg ewgr',1,0,0,0),(14,1,'wgegw gwew45rtg',2,0,0,0),(15,3,'цуке еуцекец',1,1,0,0),(16,5,'Сумма (тыс.руб.) 9993344',23,1,1,14),(17,5,'КБК',1,0,0,0),(18,4,'123',1,0,0,0),(19,5,'7777',3,0,0,12),(20,5,'КОСГУ',24,0,0,14);
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
  `kbk` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fin_form_row`
--

LOCK TABLES `fin_form_row` WRITE;
/*!40000 ALTER TABLE `fin_form_row` DISABLE KEYS */;
INSERT INTO `fin_form_row` VALUES (1,2,1,100000,'02-07-41-1-11-27980-242-221-7345(16)'),(2,2,2,500000,''),(3,2,3,300000,''),(4,2,4,700000,''),(5,2,5,0,''),(6,4,1,0,''),(7,4,2,0,''),(8,1,1,0,'КОСГУ 212'),(9,1,2,0,''),(10,1,3,567,''),(11,1,4,34567,''),(12,1,5,0,''),(13,3,1,500000,''),(14,5,1,50000045,'1-2-3-4-5-7'),(15,4,3,0,''),(16,5,2,0,'');
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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fin_request`
--

LOCK TABLES `fin_request` WRITE;
/*!40000 ALTER TABLE `fin_request` DISABLE KEYS */;
INSERT INTO `fin_request` VALUES (1,0,0,'Заявка на 2016 год 4545',1,2,0),(2,1451317117,0,'36456 345 3y45',1,2,0),(3,1451317182,0,'ityi8',1,2,0),(4,1451317251,0,'trheth e et',1,2,5),(5,1451318361,0,'тестовая заявка на 2016 год',1,2,2),(6,1451388752,0,'проверка создания заявки на 2016 год - 3',1,2,2),(7,1451389377,0,'проверка создания заявки на 2016 год - 55',1,2,5),(8,1451389417,0,'проверка создания заявки на 2016 год - 6',1,2,4),(9,1453373406,0,'Заявка на 2016 год с детализацией',1,2,2);
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
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fin_request_cell`
--

LOCK TABLES `fin_request_cell` WRITE;
/*!40000 ALTER TABLE `fin_request_cell` DISABLE KEYS */;
INSERT INTO `fin_request_cell` VALUES (1,1,12,4,'tty'),(2,1,11,1,'123'),(3,1,11,2,'77ee'),(4,1,11,3,'6789ывпжр'),(5,1,12,1,'jhgsdkjfg '),(6,1,12,2,'wert'),(7,1,12,3,'455'),(8,1,11,4,'ttbdfghkdfjvbk jkdbv'),(9,1,11,5,'ttyy56'),(10,4,11,1,'700'),(11,4,11,2,'900'),(12,4,12,1,'п. 7.4'),(13,4,12,2,'п. 4.5'),(14,5,11,1,'5'),(15,5,11,2,'2'),(16,5,11,3,'5555'),(17,5,11,4,'77'),(18,5,12,1,'Неубедительное обоснование.'),(19,6,11,1,'123'),(20,6,11,2,'234'),(21,6,11,3,'345'),(22,6,11,4,'456'),(23,6,11,5,'0'),(24,8,11,1,'900'),(25,8,11,2,'890'),(26,8,11,3,'332'),(27,9,11,1,'4047'),(28,9,12,1,''),(29,9,11,2,'760'),(30,9,11,3,'0'),(31,9,11,4,'230'),(32,9,11,5,'9500');
/*!40000 ALTER TABLE `fin_request_cell` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fin_request_log`
--

DROP TABLE IF EXISTS `fin_request_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fin_request_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `request_id` int(11) NOT NULL,
  `created_at_ts` int(11) NOT NULL,
  `author_user_id` int(11) NOT NULL,
  `comment` varchar(1024) DEFAULT NULL,
  `change_info` varchar(1024) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fin_request_log`
--

LOCK TABLES `fin_request_log` WRITE;
/*!40000 ALTER TABLE `fin_request_log` DISABLE KEYS */;
INSERT INTO `fin_request_log` VALUES (1,6,1451393626,0,'','ВУЗ изменил статус заявки с \"черновик\" на \"черновик\"\".'),(2,8,1451393662,0,'','ВУЗ изменил статус заявки с \"черновик\" на \"на утверждении в ГУК\"\".'),(3,8,1451393866,0,'','ВУЗ изменил статус заявки с \"на утверждении в ГУК\" на \"на утверждении в ГУК\"\".'),(4,8,1451393913,0,'','ВУЗ изменил статус заявки с \"на утверждении в ГУК\" на \"на утверждении в ГУК\"\".'),(5,4,1451394325,0,'','ВУЗ изменил статус заявки с \"черновик\" на \"отклонена ВУЗом\"\".'),(6,8,1451397185,0,'Ерунда!','ГУК изменил статус заявки с \"на утверждении в ГУК\" на \"отклонена ГУК\"\".'),(7,6,1451397545,0,'Отличная заявка!','ГУК изменил статус заявки с \"на утверждении в ГУК\" на \"утверждена ГУК\"\".'),(8,5,1451399840,0,NULL,'ГУК изменил значение поля заявки с \"55\" на \"увеличили\"\" в строке \"3\".'),(9,5,1451399875,0,'Слишком большие суммы заявки','ГУК изменил значение поля заявки с \"увеличили\" на \"5555\"\" в строке \"3\".'),(10,5,1451399914,0,'Одной тысяци не хватит.','ГУК изменил значение поля заявки с \"1\" на \"5\"\" в строке \"1\".'),(11,5,1451400021,0,'','ГУК изменил значение поля заявки с \"накер рварп\" на \"Неубедительное обоснование.\"\" в строке \"1\".'),(12,6,1451405845,0,'Нет бюджета','ГУК изменил значение поля заявки с \"567\" на \"0\"\" в строке \"5\".'),(13,5,1451406032,0,'','ГУК изменил значение поля заявки с \"66\" на \"77\"\" в строке \"4\".'),(14,5,1451406053,0,'','ГУК изменил значение поля заявки с \"77\" на \"77\"\" в строке \"4\".'),(15,8,1453136814,0,'','ГУК изменил значение поля заявки с \"900\" на \"900\"\" в строке \"1\".'),(16,8,1453136817,0,'','ГУК изменил значение поля заявки с \"332\" на \"332\"\" в строке \"3\".'),(17,9,1453394447,0,'','ВУЗ изменил статус заявки с \"черновик\" на \"на утверждении в ГУК\"\".'),(18,9,1453394500,0,'нет сумм','ГУК изменил статус заявки с \"на утверждении в ГУК\" на \"отклонена ГУК\"\".'),(19,9,1453394510,0,'','ВУЗ изменил статус заявки с \"отклонена ГУК\" на \"на утверждении в ГУК\"\".'),(20,9,1453394603,0,'нет сумм','ГУК изменил статус заявки с \"на утверждении в ГУК\" на \"отклонена ГУК\"\".'),(21,9,1453394775,0,'','ВУЗ изменил статус заявки с \"отклонена ГУК\" на \"на утверждении в ГУК\"\".'),(22,9,1453395488,0,'Мало','ГУК изменил значение поля заявки с \"4047\" на \"40475\"\" в строке \"1\".'),(23,9,1453395491,0,'Мало','ГУК изменил значение поля заявки с \"40475\" на \"40475\"\" в строке \"1\".'),(24,9,1453395501,0,'Ошибка','ГУК изменил значение поля заявки с \"40475\" на \"4047\"\" в строке \"1\".'),(25,9,1453395517,0,'Ошибка','ГУК изменил значение поля заявки с \"4047\" на \"4047\"\" в строке \"1\".');
/*!40000 ALTER TABLE `fin_request_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `form_row_term_id`
--

DROP TABLE IF EXISTS `form_row_term_id`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `form_row_term_id` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `form_row_id` int(11) NOT NULL,
  `term_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `form_row_id` (`form_row_id`,`term_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `form_row_term_id`
--

LOCK TABLES `form_row_term_id` WRITE;
/*!40000 ALTER TABLE `form_row_term_id` DISABLE KEYS */;
INSERT INTO `form_row_term_id` VALUES (4,14,2),(1,14,3),(10,16,2);
/*!40000 ALTER TABLE `form_row_term_id` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `term`
--

DROP TABLE IF EXISTS `term`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `term` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at_ts` int(11) NOT NULL DEFAULT '0',
  `created_by_user_id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(250) NOT NULL DEFAULT '',
  `vocabulary_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `term`
--

LOCK TABLES `term` WRITE;
/*!40000 ALTER TABLE `term` DISABLE KEYS */;
INSERT INTO `term` VALUES (1,0,0,'7788789',10),(2,0,0,'221',14),(3,0,0,'225',14);
/*!40000 ALTER TABLE `term` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vocabulary`
--

DROP TABLE IF EXISTS `vocabulary`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vocabulary` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at_ts` int(11) NOT NULL DEFAULT '0',
  `created_by_user_id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(250) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vocabulary`
--

LOCK TABLES `vocabulary` WRITE;
/*!40000 ALTER TABLE `vocabulary` DISABLE KEYS */;
INSERT INTO `vocabulary` VALUES (1,0,0,'wertyy5'),(2,0,0,'wertyy5'),(3,0,0,'wertyy5sdfg'),(4,0,0,'yeyry'),(5,0,0,'weggte'),(6,0,0,'проверка сощзд'),(7,0,0,'ehryhej'),(8,0,0,'6546'),(9,0,0,'6667'),(10,0,0,'222'),(11,0,0,'ddd'),(12,0,0,'444'),(13,0,0,'5555'),(14,0,0,'КОСГУ 2016');
/*!40000 ALTER TABLE `vocabulary` ENABLE KEYS */;
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

--
-- Table structure for table `vuz_payment`
--

DROP TABLE IF EXISTS `vuz_payment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vuz_payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at_ts` int(11) NOT NULL DEFAULT '0',
  `created_by_user_id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(250) NOT NULL DEFAULT '',
  `amount_rub` int(11) DEFAULT NULL,
  `fin_request_id` int(11) NOT NULL,
  `vuz_id` int(11) NOT NULL,
  `status_code` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vuz_payment`
--

LOCK TABLES `vuz_payment` WRITE;
/*!40000 ALTER TABLE `vuz_payment` DISABLE KEYS */;
INSERT INTO `vuz_payment` VALUES (6,1453182199,0,'Оплата для академии РВСН по заявке 563',8000009,6,1,3),(7,1453366873,0,'Новый платеж 456',0,6,1,3);
/*!40000 ALTER TABLE `vuz_payment` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-01-25 19:38:14