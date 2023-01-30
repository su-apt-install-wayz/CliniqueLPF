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
) ENGINE=InnoDB AUTO_INCREMENT=84 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact`
--

LOCK TABLES `contact` WRITE;
/*!40000 ALTER TABLE `contact` DISABLE KEYS */;
INSERT INTO `contact` VALUES ('bourst','arthur',2222222222,'neuville',72),('moulin','jf',7878978978,'neuville',73),('boufflers','alexandre',9999999999,'neuville',75),('telle','maxens',2222222222,'neuville',77),('deloge','hugo',6666666666,'neuville',78),('catteuw','amaury',8888888888,'neuville',79),('mora','florian',3333333333,'neuville',81),('wustenberghs','theo',640544398,'wasnes',82),('moi','pas toi',888888888,'8 rue de la bastille',83);
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
  `Pre_admission` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Heure_intervention` varchar(18) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `code_personnel` int DEFAULT NULL,
  `Num_secu` bigint DEFAULT NULL,
  KEY `Hospitalisation_FK` (`Num_secu`),
  KEY `Hospitalisation_FK_1` (`code_personnel`),
  CONSTRAINT `Hospitalisation_FK` FOREIGN KEY (`Num_secu`) REFERENCES `patient` (`Num_secu`),
  CONSTRAINT `hospitalisation_FK_1` FOREIGN KEY (`code_personnel`) REFERENCES `personnel` (`Code_personnel`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hospitalisation`
--

LOCK TABLES `hospitalisation` WRITE;
/*!40000 ALTER TABLE `hospitalisation` DISABLE KEYS */;
INSERT INTO `hospitalisation` VALUES ('2031-06-27','Hospitalisation','01:03',5,283127599910792);
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `patient`
--

LOCK TABLES `patient` WRITE;
/*!40000 ALTER TABLE `patient` DISABLE KEYS */;
INSERT INTO `patient` VALUES (283127599910792,'Homme','bosc--oliveau','','lauriane','2008-01-16','9 rue de la bastille',34882,842540199,'paris','laulaudu34@gpas2mail.gouv',1,82,83);
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
  `Prenom` varchar(50) DEFAULT NULL,
  `Identifiant` varchar(100) DEFAULT NULL,
  `Mot_de_passe` varchar(100) DEFAULT NULL,
  `Service` int DEFAULT NULL,
  `role` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`Code_personnel`),
  KEY `personnel_FK` (`Service`),
  CONSTRAINT `personnel_FK` FOREIGN KEY (`Service`) REFERENCES `service` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personnel`
--

LOCK TABLES `personnel` WRITE;
/*!40000 ALTER TABLE `personnel` DISABLE KEYS */;
INSERT INTO `personnel` VALUES (1,'ledieu','alexandre','alexandre','$argon2id$v=19$m=65536,t=4,p=1$UU1JWE5YdjRMaWNTLkNQcg$Tqat4ijOwE088pm+iVsOyagRVRvbmEuM5JefbZJzb0c',5,'secretaire'),(2,'françois','robyn','robyn','$argon2id$v=19$m=65536,t=4,p=1$UU1JWE5YdjRMaWNTLkNQcg$Tqat4ijOwE088pm+iVsOyagRVRvbmEuM5JefbZJzb0c',6,'medecin'),(3,'wustenberghs','theo','theo','$argon2id$v=19$m=65536,t=4,p=1$UU1JWE5YdjRMaWNTLkNQcg$Tqat4ijOwE088pm+iVsOyagRVRvbmEuM5JefbZJzb0c',7,'admin'),(4,'bourst','arthur','bourst','$argon2id$v=19$m=65536,t=4,p=1$UU1JWE5YdjRMaWNTLkNQcg$Tqat4ijOwE088pm+iVsOyagRVRvbmEuM5JefbZJzb0c',5,'medecin'),(5,'moulin','jf','jf','$argon2id$v=19$m=65536,t=4,p=1$VzBVNlVKUHlwTjNWVzQyMQ$hnDnb0Ve3a1RAGBpTpVIRxxqM7rPG1zCwmLoU0bHgi0',6,'medecin'),(6,'telle','maxens','maxens','$argon2id$v=19$m=65536,t=4,p=1$MmpBdVpHVzFxcWphTGc0RA$F2vMLE8zKl1Qj561QfVCIVhynIVxEDGcMgt7rtFbILQ',7,'medecin'),(15,'bosc--oliveau','lauriane','lauriane','$argon2id$v=19$m=65536,t=4,p=1$TDdHTnd2L1RzbUViaElBbw$pBRaub12pmqpU2wq7ytuo8okEBJ/FMmR+ZR1CnUAauA',5,'medecin');
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `piece_jointe`
--

LOCK TABLES `piece_jointe` WRITE;
/*!40000 ALTER TABLE `piece_jointe` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `secu`
--

LOCK TABLES `secu` WRITE;
/*!40000 ALTER TABLE `secu` DISABLE KEYS */;
INSERT INTO `secu` VALUES (283127599910792,'mma','Non','Non','0 traqua',1234,'1');
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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `service`
--

LOCK TABLES `service` WRITE;
/*!40000 ALTER TABLE `service` DISABLE KEYS */;
INSERT INTO `service` VALUES (5,'Chirurgie'),(6,'Neurologie'),(7,'Radiologie'),(13,'Gogologie');
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

-- Dump completed on 2023-01-28 20:39:57
