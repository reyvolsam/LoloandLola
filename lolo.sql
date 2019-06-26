-- MySQL dump 10.13  Distrib 8.0.16, for Win64 (x86_64)
--
-- Host: localhost    Database: lolo
-- ------------------------------------------------------
-- Server version	5.7.26

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
 SET NAMES utf8 ;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `discounts`
--

DROP TABLE IF EXISTS `discounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `discounts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `discount` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `discounts`
--

LOCK TABLES `discounts` WRITE;
/*!40000 ALTER TABLE `discounts` DISABLE KEYS */;
INSERT INTO `discounts` VALUES (1,'5%',5,NULL,NULL),(2,'10%',10,NULL,NULL),(3,'15%',15,NULL,NULL),(4,'20%',20,NULL,NULL),(5,'25%',25,NULL,NULL),(6,'30%',30,NULL,NULL),(7,'35%',35,NULL,NULL),(8,'40%',40,NULL,NULL),(9,'50%',50,NULL,NULL),(10,'60%',60,NULL,NULL),(11,'80%',80,NULL,NULL),(12,'90%',90,NULL,NULL),(13,'100%',100,NULL,NULL);
/*!40000 ALTER TABLE `discounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `alias` varchar(255) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `groups`
--

LOCK TABLES `groups` WRITE;
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;
INSERT INTO `groups` VALUES (1,'root','root','2018-01-07 03:34:15','2018-01-07 03:34:15',NULL),(2,'administrator','Administrador','2018-01-07 03:34:15','2018-01-07 03:34:15',NULL),(3,'employee','Empleado',NULL,NULL,NULL),(4,'client','Cliente',NULL,NULL,NULL);
/*!40000 ALTER TABLE `groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment_types`
--

DROP TABLE IF EXISTS `payment_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `payment_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_types`
--

LOCK TABLES `payment_types` WRITE;
/*!40000 ALTER TABLE `payment_types` DISABLE KEYS */;
INSERT INTO `payment_types` VALUES (1,'Efectivo',NULL,NULL),(2,'Transferencia',NULL,NULL),(3,'Tarjeta de Débito/Crédito',NULL,NULL),(4,'Otro',NULL,NULL);
/*!40000 ALTER TABLE `payment_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `payments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `payment_type_id` int(11) DEFAULT NULL,
  `discount_id` int(11) DEFAULT NULL,
  `subtotal` decimal(20,2) DEFAULT NULL,
  `grand_total` decimal(20,2) DEFAULT NULL,
  `apply_advance_payment` tinyint(4) DEFAULT '0',
  `advance_payment` decimal(20,2) DEFAULT '0.00',
  `payments_list` json DEFAULT NULL,
  `delivery_date` date DEFAULT NULL,
  `payment_with` decimal(20,2) DEFAULT NULL,
  `exchange` decimal(20,2) DEFAULT NULL,
  `total_service` decimal(20,2) DEFAULT NULL,
  `total_product` decimal(20,2) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `phone` varchar(100) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `design_image` varchar(100) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `status_id` int(11) DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=44 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payments`
--

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
INSERT INTO `payments` VALUES (21,8,1,1,2264.50,2151.28,0,NULL,NULL,NULL,2200.00,-48.72,1244.50,1020.00,'Esau Perez','samuel43_7@hotmail.com',NULL,NULL,1,'2019-04-10 12:19:10','2019-04-10 12:19:10'),(22,10,1,1,2144.50,2037.28,0,NULL,NULL,NULL,2100.00,-62.72,1244.50,900.00,'Carolina Herrera','samuel43_7@hotmail.com',NULL,NULL,1,'2019-04-10 12:20:45','2019-04-10 12:20:45'),(23,4,2,1,2254.00,2141.30,0,NULL,NULL,NULL,2200.00,-58.70,1234.00,1020.00,'Esau Perez Munive','samuel43_7@hotmail.com',NULL,NULL,1,'2019-04-10 12:24:09','2019-04-10 12:24:09'),(24,10,1,1,2254.00,2141.30,0,NULL,NULL,NULL,2200.00,-58.70,1234.00,1020.00,'Carolina Herrera','samuel43_7@hotmail.com',NULL,NULL,1,'2019-04-10 12:24:43','2019-04-10 12:24:43'),(25,8,1,1,2144.50,2037.28,0,NULL,NULL,NULL,2100.00,-62.72,1244.50,900.00,'Esau Perez','samuel43_7@hotmail.com',NULL,NULL,1,'2019-04-10 12:25:09','2019-04-10 12:25:09'),(26,8,2,1,2254.00,2141.30,0,NULL,NULL,NULL,2200.00,-58.70,1234.00,1020.00,'Esau Perez','samuel43_7@hotmail.com',NULL,NULL,1,'2019-04-10 12:29:10','2019-04-10 12:29:10'),(27,10,2,1,2254.00,2141.30,0,NULL,NULL,NULL,2200.00,-58.70,1234.00,1020.00,'Carolina Herrera','samuel43_7@hotmail.com',NULL,NULL,1,'2019-04-10 12:30:23','2019-04-10 12:30:23'),(28,4,2,1,1244.50,1182.28,0,NULL,NULL,NULL,0.00,0.00,1244.50,0.00,'Esau Perez Munive','samuel43_7@hotmail.com',NULL,NULL,1,'2019-04-10 18:20:16','2019-04-10 18:20:16'),(29,NULL,2,NULL,1234.00,1234.00,0,NULL,NULL,NULL,0.00,0.00,1234.00,0.00,'adcda','samuel43_7@hotmail.com',NULL,NULL,1,'2019-04-10 18:21:56','2019-04-10 18:21:56'),(30,8,1,2,1234.00,1110.60,0,NULL,NULL,NULL,0.00,0.00,1234.00,0.00,'Esau Perez','samuel43_7@hotmail.com',NULL,NULL,1,'2019-04-10 18:27:51','2019-04-10 18:27:51'),(31,NULL,1,1,1234.00,1172.30,0,NULL,NULL,NULL,0.00,0.00,1234.00,0.00,'aqeeq','samuel43_7@hotmail.com',NULL,NULL,1,'2019-04-10 18:28:55','2019-04-10 18:28:55'),(32,NULL,1,1,1244.50,1182.28,0,NULL,NULL,NULL,0.00,0.00,1244.50,0.00,'scsdwc','samuel43_7@hotmail.com',NULL,NULL,1,'2019-04-10 18:30:47','2019-04-10 18:30:47'),(33,NULL,1,NULL,1244.50,1244.50,0,NULL,NULL,NULL,0.00,0.00,1244.50,0.00,'cdwewe','samuel43_7@hotmail.com',NULL,NULL,1,'2019-04-10 18:33:08','2019-04-10 18:33:08'),(34,NULL,2,2,1244.50,1120.05,0,NULL,NULL,NULL,0.00,0.00,1244.50,0.00,'sdsdcsdc','samuel43_7@hotmail.com',NULL,NULL,1,'2019-04-10 18:34:37','2019-04-10 18:34:37'),(35,NULL,1,NULL,1234.00,1234.00,0,NULL,NULL,NULL,0.00,0.00,1234.00,0.00,'dwcwewe','samuel43_7@hotmail.com',NULL,NULL,1,'2019-04-10 18:36:07','2019-04-10 18:36:07'),(36,NULL,1,NULL,1234.00,1234.00,0,NULL,NULL,NULL,0.00,0.00,1234.00,0.00,'dvdsdw efwefwf wef','samuel43_7@hotmail.com',NULL,NULL,1,'2019-04-10 18:37:49','2019-04-10 18:37:49'),(37,10,1,NULL,2254.00,2254.00,0,NULL,NULL,NULL,2300.00,-46.00,1234.00,1020.00,'Carolina Herrera','samuel43_7@hotmail.com',NULL,NULL,1,'2019-04-10 18:40:42','2019-04-10 18:40:42'),(38,8,2,NULL,2264.50,2264.50,0,NULL,NULL,NULL,2300.00,-35.50,1244.50,1020.00,'Esau Perez',NULL,NULL,NULL,1,'2019-04-10 18:41:05','2019-04-10 18:41:05'),(39,NULL,1,NULL,2144.50,2144.50,0,NULL,NULL,NULL,2200.00,-55.50,1244.50,900.00,'s<svsssdvsdvsdv','samuel43_7@hotmail.com',NULL,NULL,1,'2019-04-10 18:46:35','2019-04-10 18:46:35'),(40,4,2,NULL,2144.50,2144.50,0,NULL,NULL,NULL,2200.00,-55.50,1244.50,900.00,'Esau Perez Munive','samuel43_7@hotmail.com',NULL,NULL,1,'2019-04-10 18:47:01','2019-04-10 18:47:01'),(41,8,1,NULL,2144.50,2144.50,1,123456.00,NULL,NULL,2200.00,-55.50,1244.50,900.00,'Esau Perez','samuel43_7@hotmail.com',NULL,'191_1554940358.png',1,'2019-04-10 18:52:37','2019-04-10 18:52:38'),(42,10,1,4,2264.50,811.60,1,1000.00,NULL,'2019-06-30',0.00,0.00,1244.50,1020.00,'Carolina Herrera','filadelfiamedios604@gmail.com','9211334310',NULL,1,'2019-06-20 00:08:07','2019-06-20 00:08:07'),(43,14,1,1,2144.50,1037.28,1,1000.00,NULL,'2019-06-29',0.00,0.00,1244.50,900.00,'Colita Regino Placido','colita@lolo.mx','9212081923',NULL,1,'2019-06-22 10:51:55','2019-06-22 10:51:55');
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_payments`
--

DROP TABLE IF EXISTS `product_payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `product_payments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `payment_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `total` decimal(20,2) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_payments`
--

LOCK TABLES `product_payments` WRITE;
/*!40000 ALTER TABLE `product_payments` DISABLE KEYS */;
INSERT INTO `product_payments` VALUES (11,21,3,1,1020.00,'2019-04-10 12:19:10','2019-04-10 12:19:10'),(12,22,4,1,900.00,'2019-04-10 12:20:45','2019-04-10 12:20:45'),(13,23,3,1,1020.00,'2019-04-10 12:24:09','2019-04-10 12:24:09'),(14,24,3,1,1020.00,'2019-04-10 12:24:43','2019-04-10 12:24:43'),(15,25,4,1,900.00,'2019-04-10 12:25:09','2019-04-10 12:25:09'),(16,26,3,1,1020.00,'2019-04-10 12:29:10','2019-04-10 12:29:10'),(17,27,3,1,1020.00,'2019-04-10 12:30:23','2019-04-10 12:30:23'),(18,37,3,1,1020.00,'2019-04-10 18:40:42','2019-04-10 18:40:42'),(19,38,3,1,1020.00,'2019-04-10 18:41:05','2019-04-10 18:41:05'),(20,39,4,1,900.00,'2019-04-10 18:46:35','2019-04-10 18:46:35'),(21,40,4,1,900.00,'2019-04-10 18:47:01','2019-04-10 18:47:01'),(22,41,4,1,900.00,'2019-04-10 18:52:37','2019-04-10 18:52:37'),(23,42,3,1,1020.00,'2019-06-20 00:08:07','2019-06-20 00:08:07'),(24,43,4,1,900.00,'2019-06-22 10:51:55','2019-06-22 10:51:55');
/*!40000 ALTER TABLE `product_payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `products` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `price` decimal(20,2) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (3,'Producto 1',NULL,1020.00,2,'2019-02-26 17:22:47','2019-06-20 00:08:07'),(4,'Produto 2',NULL,900.00,5,'2019-02-26 17:22:55','2019-06-22 10:51:55');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `service_payments`
--

DROP TABLE IF EXISTS `service_payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `service_payments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `payment_id` int(11) DEFAULT NULL,
  `service_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `total` decimal(20,2) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=44 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `service_payments`
--

LOCK TABLES `service_payments` WRITE;
/*!40000 ALTER TABLE `service_payments` DISABLE KEYS */;
INSERT INTO `service_payments` VALUES (24,24,3,1,1234.00,'2019-04-10 12:24:43','2019-04-10 12:24:43'),(23,23,3,1,1234.00,'2019-04-10 12:24:09','2019-04-10 12:24:09'),(22,22,2,1,1244.50,'2019-04-10 12:20:45','2019-04-10 12:20:45'),(21,21,2,1,1244.50,'2019-04-10 12:19:10','2019-04-10 12:19:10'),(25,25,2,1,1244.50,'2019-04-10 12:25:09','2019-04-10 12:25:09'),(26,26,3,1,1234.00,'2019-04-10 12:29:10','2019-04-10 12:29:10'),(27,27,3,1,1234.00,'2019-04-10 12:30:23','2019-04-10 12:30:23'),(28,28,2,1,1244.50,'2019-04-10 18:20:16','2019-04-10 18:20:16'),(29,29,3,1,1234.00,'2019-04-10 18:21:56','2019-04-10 18:21:56'),(30,30,3,1,1234.00,'2019-04-10 18:27:51','2019-04-10 18:27:51'),(31,31,3,1,1234.00,'2019-04-10 18:28:55','2019-04-10 18:28:55'),(32,32,2,1,1244.50,'2019-04-10 18:30:47','2019-04-10 18:30:47'),(33,33,2,1,1244.50,'2019-04-10 18:33:08','2019-04-10 18:33:08'),(34,34,2,1,1244.50,'2019-04-10 18:34:37','2019-04-10 18:34:37'),(35,35,3,1,1234.00,'2019-04-10 18:36:07','2019-04-10 18:36:07'),(36,36,3,1,1234.00,'2019-04-10 18:37:49','2019-04-10 18:37:49'),(37,37,3,1,1234.00,'2019-04-10 18:40:42','2019-04-10 18:40:42'),(38,38,2,1,1244.50,'2019-04-10 18:41:05','2019-04-10 18:41:05'),(39,39,2,1,1244.50,'2019-04-10 18:46:35','2019-04-10 18:46:35'),(40,40,2,1,1244.50,'2019-04-10 18:47:01','2019-04-10 18:47:01'),(41,41,2,1,1244.50,'2019-04-10 18:52:37','2019-04-10 18:52:37'),(42,42,2,1,1244.50,'2019-06-20 00:08:07','2019-06-20 00:08:07'),(43,43,2,1,1244.50,'2019-06-22 10:51:55','2019-06-22 10:51:55');
/*!40000 ALTER TABLE `service_payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `services`
--

DROP TABLE IF EXISTS `services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `services` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `price` decimal(20,2) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `services`
--

LOCK TABLES `services` WRITE;
/*!40000 ALTER TABLE `services` DISABLE KEYS */;
INSERT INTO `services` VALUES (2,'Servicio 2',1244.50,'2019-01-12 01:58:59','2019-01-12 01:58:59'),(3,'Servicio 3',1234.00,'2019-01-12 02:06:07','2019-01-12 02:06:07');
/*!40000 ALTER TABLE `services` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `statuses`
--

DROP TABLE IF EXISTS `statuses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `statuses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `statuses`
--

LOCK TABLES `statuses` WRITE;
/*!40000 ALTER TABLE `statuses` DISABLE KEYS */;
INSERT INTO `statuses` VALUES (1,'Cerrado','2019-06-19 21:36:00','2019-06-19 21:36:00'),(2,'Abierto','2019-06-19 21:36:00','2019-06-19 21:36:00');
/*!40000 ALTER TABLE `statuses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `phone` varchar(100) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `group_id` varchar(11) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `remember_token` varchar(255) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `active` tinyint(4) DEFAULT NULL,
  `token` varchar(255) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Samuel','Region Placido','samuel43_7@hotmail.com',NULL,'$2y$10$l3db4YwLKRwHvAikhg9QN./on5wjKT2GSCLC4vIOijOtALROOO1.G','1','0Gz51KPNRRiIENwrEGP68CPqOllYoimuHDg0xw6OundUJQjmvsFwti1KtMJb',1,NULL,'avatar.png','2019-01-07 21:43:08','2019-04-10 19:29:31',NULL),(2,'Raquel','Hernandez Rodriguez','raquel.h@dpilady.com',NULL,'$2y$10$.HAsSbhV8mgibafLQqhNA.d0bZb1xWrA5m.Jivw5ugH/Z/zGtNti6','2','1SAWrNPpzt8liY3Nj0bCUwapAiAUdElrPSBl7z3Xj7S4lAOPmLwWdUFyh9LK',1,NULL,'avatar.png','2019-01-11 00:08:01','2019-04-10 19:33:57',NULL),(3,'Jose Abraham','Hernandez Rodriguez','jose.a@dpilady.com',NULL,'$2y$10$RrqQ5FLZWX0mHjOYyoMWxOWVYmrnFigOk99Cu/Ggke2BwDIIF003m','3',NULL,1,NULL,'avatar.png','2019-01-11 00:08:36','2019-01-11 00:08:36',NULL),(4,'Esau','Perez Munive','esau.minive@dpilady.com',NULL,'$2y$10$zU/ozNI1.5q5uebrfZSrYeGnmUlCHhpeaDbjC3suVcJ23wqrpJXq2','4',NULL,1,NULL,'avatar.png','2019-01-11 00:09:07','2019-01-11 00:09:07',NULL),(5,'Gomita','Regino Hernandez','gomita@dpilady.com',NULL,'$2y$10$m77WvbO0zulh/T7KzSbHfukhLAB3jaikxfuziam088YFSw50/zXtK','1',NULL,1,NULL,'avatar.png','2019-01-11 00:09:35','2019-01-11 00:09:35',NULL),(6,'Dara Fernanda','Regino Hernandez','dara.regino@dpilady.com',NULL,'$2y$10$Zd/o2x9p9JdpsFP2rHU9wOqDxi.dUoCpU0muKMgt85WwpVQFnCEaG','3','5HjqVoJWSgPIcBdssBN10sbkLlbd1WZm7yeF8LsJjeNJB1uVd86ZegZfWBlW',1,NULL,'avatar.png','2019-01-11 00:10:03','2019-01-11 00:10:03',NULL),(7,'sdckjslk','sdlckjckl','samsi@swdf.com',NULL,'$2y$10$cidwuZCOS3ddm6Ri2ybWReVJ29.RI1hJhWQkA6Pa5DreDgV/bED.6',NULL,NULL,1,NULL,'avatar.png','2019-01-11 00:16:18','2019-01-11 00:23:25','2019-01-11 00:23:25'),(8,'Esau','Perez','esaumunive@gmail.com',NULL,'$2y$10$YC4YurQOCZavwRL.fsqpLeSGF4pTfnikCjrjiS6/uo292yQ7DMPZC','4','l4hcMNjoJQRloZn2kGCrJ9Gkoy3QTHBgpL0qx1nv9ePhEQ43gp7QKrgwhN10',1,NULL,'avatar.png','2019-02-20 11:38:39','2019-02-20 11:38:39',NULL),(10,'Carolina','Herrera','carolina.herrera@gmail.com',NULL,'$2y$10$W3OZSEVBmljsHH/K8OPLqeiSqBdAbj8eTbnX5J7VV6OialmDr5lS.','4',NULL,1,NULL,'avatar.png','2019-03-08 14:09:15','2019-03-08 14:09:15',NULL),(11,'Helea','Dana','hela.dana@gmail.com','234234234','$2y$10$rMMlx/MA0IsoTn1U1kGMrO2LtaBC6lMYeH97jEDoUXKQSKgnr1SOi','2',NULL,1,NULL,'avatar.png','2019-03-08 14:11:20','2019-04-16 18:53:43',NULL),(12,'Ponchito','Gomez','ponchito_gomes@hotmail.com','123456789','$2y$10$FgD1Xmr8QcO39bV8lwArBOHRNSv02T/6MdV4gpk7SFDCFWOxFu67e',NULL,NULL,1,NULL,'avatar.png','2019-04-16 18:54:18','2019-04-16 18:54:25','2019-04-16 18:54:25'),(13,'Cliente','Ejemplo 1','filadelfiamedios604@gmail.com','9211334310','$2y$10$8D0i/MwMtXJ/aZLcfHw3Y.BTtbw2Pxbn4W15eBriBrhykxOHlSlp2','3','ZYUjg98EjWSY03MsKZFqGXOfg32l94IC9Ry7pCvKBrHiTQcf1IN5xSpXhK3w',1,NULL,'avatar.png','2019-04-16 19:00:34','2019-04-17 13:34:16',NULL),(14,'Colita','Regino Placido','colita@lolo.mx','9212081923','$2y$10$EqhrKcn6Z3YFdzz1a/90E.ySwMkdnv4cSfvK/RVhDlHVQ/XKtE91u','4',NULL,1,NULL,'avatar.png','2019-04-22 18:33:20','2019-04-22 18:33:20',NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-06-24 10:19:41
