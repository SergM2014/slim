-- MySQL dump 10.13  Distrib 8.0.31, for Linux (x86_64)
--
-- Host: localhost    Database: slim
-- ------------------------------------------------------
-- Server version	8.0.31

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `session_id` varchar(255) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `browser` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES (1,'3577777777777777777774444','5643.7876.07875.55','germany','safari'),(2,'98767656f6575r5e43','978876.875645.563.66','poland','opera'),(3,'i4wiy7co94y5rt','986574.665644.235.43','sweden','chrom'),(4,'n27935th7oybvo274gh','3254.63457.3457347.','England','chrom'),(5,'xfgnwqerr5q vq45','245.56789.5466.','italy','mozila');
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_timestamp` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (5,'admin','weisse011@gmail.com','$2y$10$1yTXtkdtoACe.ieNKRT6DuIOFWoiNK8jCKO1dC8KK9foniKlwJmyC','e705cd7b59a4a6ccee6a44baccf85091',1667927606),(6,'qwerty','weee@qqq.qq','$2y$10$sxUsNX3qUhyA/en8qBL3MOxzVqtqqwFoSHZ0DMaCAIAV0sbyyMpoG',NULL,NULL),(7,'admin2','weisse011@gmail.com2','$2y$10$SFrjMCduwAm49wpkcIsX1ens7Nydvpxx2GXZzg0OJGRc/qeUcVDwe',NULL,NULL),(8,'admin2','weisse011@gmail.com22','$2y$10$fHNeJ9uexWDNmCMQ55NZKe9o0W86c/FACEQQ.gOSIjQUKD5D1RhFm',NULL,NULL),(9,'admin2','weisse011@gmail.com223','$2y$10$6lgZKtmXvScPJxDjkuKCB.sICRTibPn5DMtS9XuUZ/XnCsfqPVSvu',NULL,NULL),(10,'sssssssss','qqq@nhdt.nh','$2y$10$UXKTedRvPepftR1Vd7fFju5Fu5pcpcCjoEy278yscOcb7H7Sw9gMK',NULL,NULL),(11,'admin','qaqa@qq.qq','$2y$10$fPBgY4mEthXiwTtdGYGaHeUa0y/gpJwG9IsABnDgO2FPX0fztY4pW',NULL,NULL);
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

-- Dump completed on 2022-11-09  7:52:06
