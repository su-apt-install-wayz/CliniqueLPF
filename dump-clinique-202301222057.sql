-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: localhost    Database: clinique
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
-- Table structure for table `contact`
--

DROP TABLE IF EXISTS `contact`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contact` (
  `Nom` varchar(50) DEFAULT NULL,
  `Prenom` varchar(50) DEFAULT NULL,
  `Téléphone` bigint DEFAULT NULL,
  `Adresse` varchar(50) DEFAULT NULL,
  `code_contact` bigint NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`code_contact`)
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact`
--

LOCK TABLES `contact` WRITE;
/*!40000 ALTER TABLE `contact` DISABLE KEYS */;
INSERT INTO `contact` VALUES ('boubou','bozo',5555555555,'neuville aussi',68),('moi','aussi',4586415215,'là',69);
/*!40000 ALTER TABLE `contact` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hospitalisation`
--

DROP TABLE IF EXISTS `hospitalisation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `hospitalisation` (
  `Date_hospitalisation` date NOT NULL,
  `Pre_admission` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_german2_ci DEFAULT NULL,
  `Heure_intervention` varchar(18) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `code_personnel` int DEFAULT NULL,
  `Num_secu` bigint DEFAULT NULL,
  KEY `Hospitalisation_FK` (`Num_secu`),
  KEY `Hospitalisation_FK_1` (`code_personnel`),
  CONSTRAINT `Hospitalisation_FK` FOREIGN KEY (`Num_secu`) REFERENCES `patient` (`Num_secu`),
  CONSTRAINT `hospitalisation_FK_1` FOREIGN KEY (`code_personnel`) REFERENCES `personnel` (`Code_personnel`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_german2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hospitalisation`
--

LOCK TABLES `hospitalisation` WRITE;
/*!40000 ALTER TABLE `hospitalisation` DISABLE KEYS */;
INSERT INTO `hospitalisation` VALUES ('2023-01-11','Hospitalisation','15:18',2,1),('2023-01-12','Ambulatoire','15:26',2,1),('2023-01-19','Hospitalisation','20:18',2,1),('2022-12-29','Hospitalisation','20:37',2,1),('2022-12-29','Hospitalisation','20:37',2,1);
/*!40000 ALTER TABLE `hospitalisation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `patient`
--

DROP TABLE IF EXISTS `patient`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `patient` (
  `Num_secu` bigint NOT NULL,
  `Civilité` varchar(50) DEFAULT NULL,
  `Nom_Naissance` varchar(50) DEFAULT NULL,
  `Nom_Epouse` varchar(50) DEFAULT NULL,
  `Prenom` varchar(50) DEFAULT NULL,
  `Date_naissance` varchar(19) DEFAULT NULL,
  `Adresse` varchar(50) DEFAULT NULL,
  `Code_postal` int DEFAULT NULL,
  `Téléphone` bigint DEFAULT NULL,
  `Ville` varchar(50) DEFAULT NULL,
  `Email` varchar(50) DEFAULT NULL,
  `Mineur` tinyint(1) DEFAULT NULL,
  `code_prevenir` bigint DEFAULT NULL,
  `code_confiance` bigint DEFAULT NULL,
  PRIMARY KEY (`Num_secu`),
  KEY `Patient_FK` (`code_prevenir`),
  KEY `Patient_FK_1` (`code_confiance`),
  CONSTRAINT `Patient_FK` FOREIGN KEY (`code_prevenir`) REFERENCES `contact` (`code_contact`),
  CONSTRAINT `Patient_FK_1` FOREIGN KEY (`code_confiance`) REFERENCES `contact` (`code_contact`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `patient`
--

LOCK TABLES `patient` WRITE;
/*!40000 ALTER TABLE `patient` DISABLE KEYS */;
INSERT INTO `patient` VALUES (1,'Homme','bourst','rien','arthur','2023-01-02','42 rue des colombes',59554,782900156,'neuville st remy','arthur.bourst@gpamail.com',0,NULL,NULL);
/*!40000 ALTER TABLE `patient` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personnel`
--

DROP TABLE IF EXISTS `personnel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personnel` (
  `Code_personnel` int NOT NULL AUTO_INCREMENT,
  `Nom` varchar(50) DEFAULT NULL,
  `Identifiant` varchar(100) DEFAULT NULL,
  `Mot_de_passe` varchar(100) DEFAULT NULL,
  `Service` int DEFAULT NULL,
  `role` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`Code_personnel`),
  KEY `Personnel_FK` (`Service`),
  CONSTRAINT `Personnel_FK` FOREIGN KEY (`Service`) REFERENCES `service` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personnel`
--

LOCK TABLES `personnel` WRITE;
/*!40000 ALTER TABLE `personnel` DISABLE KEYS */;
INSERT INTO `personnel` VALUES (1,'alexandre','alexandre','$argon2id$v=19$m=65536,t=4,p=1$d1dvcjhjam9yeW9janpjcg$UOjZ0zYLzKlfgY7QDKEc4W1793VbklDPiy+2MJ2T/5o',NULL,'secretaire'),(2,'robyn','robyn','$argon2id$v=19$m=65536,t=4,p=1$Zy9JQ0xaOG05YUdKamZSbA$PCaKj7RnOjiPrD5fTRAMto9IWoM64Y65rYFp7aJu/es',NULL,'medecin'),(3,'theo','theo','$argon2id$v=19$m=65536,t=4,p=1$dUEwamJIRE1tTGpKY0hxcA$iyZlwXbQXify6GxQ0mmyrTkbpUn2r6Y+aF2YP32XhK0',NULL,'admin');
/*!40000 ALTER TABLE `personnel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `piece_jointe`
--

DROP TABLE IF EXISTS `piece_jointe`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `piece_jointe` (
  `Carte_identité` varchar(50) DEFAULT NULL,
  `Carte_vitale` varchar(50) DEFAULT NULL,
  `Carte_mutuelle` varchar(50) DEFAULT NULL,
  `Livret_de_famille` varchar(50) DEFAULT NULL,
  `Num_secu` bigint NOT NULL,
  PRIMARY KEY (`Num_secu`),
  KEY `Piece_jointe_FK` (`Num_secu`),
  CONSTRAINT `Piece_jointe_FK` FOREIGN KEY (`Num_secu`) REFERENCES `patient` (`Num_secu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `piece_jointe`
--

LOCK TABLES `piece_jointe` WRITE;
/*!40000 ALTER TABLE `piece_jointe` DISABLE KEYS */;
INSERT INTO `piece_jointe` VALUES ('1_cni.png','1_cv.png','1_cm.png',NULL,1);
/*!40000 ALTER TABLE `piece_jointe` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `preadmission`
--

DROP TABLE IF EXISTS `preadmission`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `preadmission` (
  `choix` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `preadmission`
--

LOCK TABLES `preadmission` WRITE;
/*!40000 ALTER TABLE `preadmission` DISABLE KEYS */;
INSERT INTO `preadmission` VALUES ('Ambulatoire'),('Hospitalisation');
/*!40000 ALTER TABLE `preadmission` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `secu`
--

DROP TABLE IF EXISTS `secu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `secu` (
  `Num_secu` bigint NOT NULL,
  `organisme` varchar(50) DEFAULT NULL,
  `assure` varchar(3) DEFAULT NULL,
  `Ald` varchar(3) DEFAULT NULL,
  `Nom_mutuelle` varchar(50) DEFAULT NULL,
  `num_adherent` int NOT NULL,
  `chambre_particuliere` varchar(3) DEFAULT NULL,
  KEY `Renseignements_FK` (`Num_secu`),
  CONSTRAINT `Renseignements_FK` FOREIGN KEY (`Num_secu`) REFERENCES `patient` (`Num_secu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `secu`
--

LOCK TABLES `secu` WRITE;
/*!40000 ALTER TABLE `secu` DISABLE KEYS */;
INSERT INTO `secu` VALUES (1,'mma','oui','non','0 traqua',1,'non'),(1,'aaaa','oui','non','eazeaz',5,'non');
/*!40000 ALTER TABLE `secu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `service`
--

DROP TABLE IF EXISTS `service`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `service` (
  `id` int NOT NULL AUTO_INCREMENT,
  `libelle` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `service`
--

LOCK TABLES `service` WRITE;
/*!40000 ALTER TABLE `service` DISABLE KEYS */;
INSERT INTO `service` VALUES (5,'Chirurgie'),(6,'Neurologie'),(7,'Radiologie');
/*!40000 ALTER TABLE `service` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'clinique'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-01-22 20:57:15
