-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: dplady
-- ------------------------------------------------------
-- Server version	5.7.23

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
-- Table structure for table `collection_list`
--

DROP TABLE IF EXISTS `collection_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `collection_list` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_slot_id` int(11) DEFAULT NULL,
  `payment_type_id` int(11) DEFAULT NULL,
  `discount_id` int(11) DEFAULT NULL,
  `service_list` text COLLATE utf8_spanish2_ci,
  `total` decimal(20,2) DEFAULT NULL,
  `grand_total` decimal(20,2) DEFAULT NULL,
  `payment_with` decimal(20,2) DEFAULT NULL,
  `exchange` decimal(20,2) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `collection_list`
--

LOCK TABLES `collection_list` WRITE;
/*!40000 ALTER TABLE `collection_list` DISABLE KEYS */;
/*!40000 ALTER TABLE `collection_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `date_exceptions`
--

DROP TABLE IF EXISTS `date_exceptions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `date_exceptions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `date` date DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `date_exceptions`
--

LOCK TABLES `date_exceptions` WRITE;
/*!40000 ALTER TABLE `date_exceptions` DISABLE KEYS */;
INSERT INTO `date_exceptions` VALUES (12,'2019-02-01','2019-01-30 17:51:46','2019-01-30 17:51:46'),(13,'2019-02-06','2019-02-05 14:28:32','2019-02-05 14:28:32');
/*!40000 ALTER TABLE `date_exceptions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `days`
--

DROP TABLE IF EXISTS `days`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `days` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) COLLATE utf8_spanish2_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `days`
--

LOCK TABLES `days` WRITE;
/*!40000 ALTER TABLE `days` DISABLE KEYS */;
INSERT INTO `days` VALUES (1,'Lunes'),(2,'Martes'),(3,'Miercoles'),(4,'Jueves'),(5,'Viernes'),(6,'Sabado'),(7,'Domingo');
/*!40000 ALTER TABLE `days` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `days_slots`
--

DROP TABLE IF EXISTS `days_slots`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `days_slots` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `day_id` int(11) NOT NULL,
  `init_slot` varchar(45) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `final_slot` varchar(45) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `days_slots`
--

LOCK TABLES `days_slots` WRITE;
/*!40000 ALTER TABLE `days_slots` DISABLE KEYS */;
INSERT INTO `days_slots` VALUES (3,1,'2:17','2:17','2019-01-16 02:17:21','2019-01-16 02:17:21'),(4,1,'2:49','4:0','2019-01-16 02:49:20','2019-01-16 02:49:20'),(5,1,'2:49','16:0','2019-01-16 02:49:45','2019-01-16 02:49:45'),(6,2,'18:0','18:30','2019-01-17 18:05:12','2019-01-17 18:05:12'),(7,3,'18:10','18:10','2019-01-17 18:11:00','2019-01-17 18:11:00'),(8,3,'18:14','18:14','2019-01-17 18:14:53','2019-01-17 18:14:53'),(9,4,'18:14','18:14','2019-01-17 18:14:59','2019-01-17 18:14:59'),(10,5,'18:15','18:15','2019-01-17 18:16:07','2019-01-17 18:16:07'),(11,6,'18:19','18:19','2019-01-17 18:19:27','2019-01-17 18:19:27'),(12,7,'18:19','18:19','2019-01-17 18:20:00','2019-01-17 18:20:00'),(13,4,'18:21','18:21','2019-01-17 18:21:45','2019-01-17 18:21:45'),(14,7,'18:23','18:23','2019-01-17 18:24:03','2019-01-17 18:24:03'),(15,7,'18:24','18:24','2019-01-17 18:24:54','2019-01-17 18:24:54'),(16,2,'17:5','17:5','2019-02-15 17:05:15','2019-02-15 17:05:15'),(17,1,'16:9','17:9','2019-02-20 15:09:47','2019-02-20 15:09:47');
/*!40000 ALTER TABLE `days_slots` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `discounts_list`
--

DROP TABLE IF EXISTS `discounts_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `discounts_list` (
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
-- Dumping data for table `discounts_list`
--

LOCK TABLES `discounts_list` WRITE;
/*!40000 ALTER TABLE `discounts_list` DISABLE KEYS */;
INSERT INTO `discounts_list` VALUES (1,'5%',5,NULL,NULL),(2,'10%',10,NULL,NULL),(3,'15%',15,NULL,NULL),(4,'20%',20,NULL,NULL),(5,'25%',25,NULL,NULL),(6,'30%',30,NULL,NULL),(7,'35%',35,NULL,NULL),(8,'40%',40,NULL,NULL),(9,'50%',50,NULL,NULL),(10,'60%',60,NULL,NULL),(11,'80%',80,NULL,NULL),(12,'90%',90,NULL,NULL),(13,'100%',100,NULL,NULL);
/*!40000 ALTER TABLE `discounts_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = utf8 */;
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
-- Table structure for table `services`
--

DROP TABLE IF EXISTS `services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
-- Table structure for table `services_list_collection`
--

DROP TABLE IF EXISTS `services_list_collection`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `services_list_collection` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `collection_list_id` int(11) DEFAULT NULL,
  `service_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `total` decimal(20,2) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `services_list_collection`
--

LOCK TABLES `services_list_collection` WRITE;
/*!40000 ALTER TABLE `services_list_collection` DISABLE KEYS */;
/*!40000 ALTER TABLE `services_list_collection` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_spanish2_ci DEFAULT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Samuel','Region Placido','samuel43_7@hotmail.com','$2y$10$ugL88cxVDNOCf9EgNnOgk.HruIqb4MZ3agZZnqWHhCmhKgBo.o3zq','1','h1ultLVHtuGba5GQXemyp8lGFV0dmtS4mf34yC7qjfbs3YCFl5VjpVD4KUNp',1,NULL,'avatar.png','2019-01-07 21:43:08','2019-01-07 21:43:08',NULL),(2,'Raquel','Hernandez Rodriguez','raquel.h@dpilady.com','$2y$10$kSyiUmjcQXjTf4jIAbO17OhkuoJz24oXhSNG2Q.mFxxAaVAcavJNe','2',NULL,1,NULL,'avatar.png','2019-01-11 00:08:01','2019-01-11 00:08:01',NULL),(3,'Jose Abraham','Hernandez Rodriguez','jose.a@dpilady.com','$2y$10$RrqQ5FLZWX0mHjOYyoMWxOWVYmrnFigOk99Cu/Ggke2BwDIIF003m','3',NULL,1,NULL,'avatar.png','2019-01-11 00:08:36','2019-01-11 00:08:36',NULL),(4,'Esau','Perez Munive','esau.minive@dpilady.com','$2y$10$zU/ozNI1.5q5uebrfZSrYeGnmUlCHhpeaDbjC3suVcJ23wqrpJXq2','4',NULL,1,NULL,'avatar.png','2019-01-11 00:09:07','2019-01-11 00:09:07',NULL),(5,'Gomita','Regino Hernandez','gomita@dpilady.com','$2y$10$m77WvbO0zulh/T7KzSbHfukhLAB3jaikxfuziam088YFSw50/zXtK','1',NULL,1,NULL,'avatar.png','2019-01-11 00:09:35','2019-01-11 00:09:35',NULL),(6,'Dara Fernanda','Regino Hernandez','dara.regino@dpilady.com','$2y$10$Zd/o2x9p9JdpsFP2rHU9wOqDxi.dUoCpU0muKMgt85WwpVQFnCEaG','3',NULL,1,NULL,'avatar.png','2019-01-11 00:10:03','2019-01-11 00:10:03',NULL),(7,'sdckjslk','sdlckjckl','samsi@swdf.com','$2y$10$cidwuZCOS3ddm6Ri2ybWReVJ29.RI1hJhWQkA6Pa5DreDgV/bED.6',NULL,NULL,1,NULL,'avatar.png','2019-01-11 00:16:18','2019-01-11 00:23:25','2019-01-11 00:23:25'),(8,'Esau','Perez','esaumunive@gmail.com','$2y$10$YC4YurQOCZavwRL.fsqpLeSGF4pTfnikCjrjiS6/uo292yQ7DMPZC','4',NULL,1,NULL,'avatar.png','2019-02-20 11:38:39','2019-02-20 11:38:39',NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users_slots`
--

DROP TABLE IF EXISTS `users_slots`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users_slots` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `date` date NOT NULL,
  `day_id` int(11) DEFAULT NULL,
  `day_slot_id` int(11) DEFAULT NULL,
  `init_slot` varchar(45) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `final_slot` varchar(45) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `phone` varchar(45) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users_slots`
--

LOCK TABLES `users_slots` WRITE;
/*!40000 ALTER TABLE `users_slots` DISABLE KEYS */;
INSERT INTO `users_slots` VALUES (1,1,'2019-02-11',1,3,'2:17AM','2:17AM','Samuel Region Placido',NULL,'2019-02-05 16:41:55','2019-02-05 16:41:55'),(2,1,'2019-02-12',2,6,'6:00PM','6:30PM','Samuel Region Placido',NULL,'2019-02-11 11:19:54','2019-02-11 11:19:54'),(3,1,'2019-02-21',4,9,'6:14PM','6:14PM','Samuel Region Placido',NULL,'2019-02-20 12:22:20','2019-02-20 12:22:20'),(4,1,'2019-02-28',4,9,'6:14PM','6:14PM','Samuel Region Placido',NULL,'2019-02-20 12:27:52','2019-02-20 12:27:52');
/*!40000 ALTER TABLE `users_slots` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-02-22 19:42:46
