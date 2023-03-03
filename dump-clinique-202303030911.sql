-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: localhost    Database: clinique
-- ------------------------------------------------------
-- Server version	5.7.36

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
  `Téléphone` bigint(20) DEFAULT NULL,
  `Adresse` varchar(50) DEFAULT NULL,
  `code_contact` bigint(20) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`code_contact`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact`
--

LOCK TABLES `contact` WRITE;
/*!40000 ALTER TABLE `contact` DISABLE KEYS */;
INSERT INTO `contact` VALUES ('deloge','hugo',6666666666,'neuville',1),('moulin','jf',707070707,'neuville',2),('ouillade','bernard',9999999999,'neuville',3);
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
  `Pre_admission` varchar(50) DEFAULT NULL,
  `Heure_intervention` varchar(18) DEFAULT NULL,
  `code_personnel` int(11) DEFAULT NULL,
  `Num_secu` bigint(20) DEFAULT NULL,
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `Hospitalisation_FK` (`Num_secu`),
  KEY `Hospitalisation_FK_1` (`code_personnel`),
  CONSTRAINT `Hospitalisation_FK` FOREIGN KEY (`Num_secu`) REFERENCES `patient` (`Num_secu`),
  CONSTRAINT `hospitalisation_FK_1` FOREIGN KEY (`code_personnel`) REFERENCES `personnel` (`Code_personnel`)
) ENGINE=InnoDB AUTO_INCREMENT=160 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hospitalisation`
--

LOCK TABLES `hospitalisation` WRITE;
/*!40000 ALTER TABLE `hospitalisation` DISABLE KEYS */;
/*!40000 ALTER TABLE `hospitalisation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `patient`
--

DROP TABLE IF EXISTS `patient`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `patient` (
  `Num_secu` bigint(20) NOT NULL,
  `Civilité` varchar(50) DEFAULT NULL,
  `Nom_Naissance` varchar(50) DEFAULT NULL,
  `Nom_Epouse` varchar(50) DEFAULT NULL,
  `Prenom` varchar(50) DEFAULT NULL,
  `Date_naissance` varchar(19) DEFAULT NULL,
  `Adresse` varchar(50) DEFAULT NULL,
  `Code_postal` int(11) DEFAULT NULL,
  `Téléphone` bigint(20) DEFAULT NULL,
  `Ville` varchar(50) DEFAULT NULL,
  `Email` varchar(50) DEFAULT NULL,
  `Mineur` tinyint(1) DEFAULT NULL,
  `code_prevenir` bigint(20) DEFAULT NULL,
  `code_confiance` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`Num_secu`),
  KEY `Patient_FK` (`code_prevenir`),
  KEY `Patient_FK_1` (`code_confiance`),
  CONSTRAINT `Patient_FK` FOREIGN KEY (`code_prevenir`) REFERENCES `contact` (`code_contact`),
  CONSTRAINT `Patient_FK_1` FOREIGN KEY (`code_confiance`) REFERENCES `contact` (`code_contact`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `patient`
--

LOCK TABLES `patient` WRITE;
/*!40000 ALTER TABLE `patient` DISABLE KEYS */;
INSERT INTO `patient` VALUES (185087666666666,'Homme','bourst','','arthur','2003-11-17','42 rue des colombes',59554,782900156,'neuville','arthur.bourst@proton.me',0,3,2);
/*!40000 ALTER TABLE `patient` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personnel`
--

DROP TABLE IF EXISTS `personnel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personnel` (
  `Code_personnel` int(11) NOT NULL AUTO_INCREMENT,
  `Nom` varchar(50) DEFAULT NULL,
  `Prenom` varchar(50) DEFAULT NULL,
  `Identifiant` varchar(100) DEFAULT NULL,
  `Mot_de_passe` varchar(100) DEFAULT NULL,
  `Service` int(11) DEFAULT NULL,
  `role` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`Code_personnel`),
  KEY `personnel_FK` (`Service`),
  CONSTRAINT `personnel_FK` FOREIGN KEY (`Service`) REFERENCES `service` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personnel`
--

LOCK TABLES `personnel` WRITE;
/*!40000 ALTER TABLE `personnel` DISABLE KEYS */;
INSERT INTO `personnel` VALUES (1,'ledieu','alexandre','alexandre','$argon2id$v=19$m=65536,t=4,p=1$UU1JWE5YdjRMaWNTLkNQcg$Tqat4ijOwE088pm+iVsOyagRVRvbmEuM5JefbZJzb0c',5,'Secrétaire'),(2,'françois','robyn','robyn','$argon2id$v=19$m=65536,t=4,p=1$UU1JWE5YdjRMaWNTLkNQcg$Tqat4ijOwE088pm+iVsOyagRVRvbmEuM5JefbZJzb0c',6,'Médecin'),(3,'wustenberghs','theo','theo','$argon2id$v=19$m=65536,t=4,p=1$UU1JWE5YdjRMaWNTLkNQcg$Tqat4ijOwE088pm+iVsOyagRVRvbmEuM5JefbZJzb0c',7,'Administrateur'),(4,'bourst','arthur','bourst','$argon2id$v=19$m=65536,t=4,p=1$UU1JWE5YdjRMaWNTLkNQcg$Tqat4ijOwE088pm+iVsOyagRVRvbmEuM5JefbZJzb0c',5,'Médecin'),(5,'moulin','jf','jf','$argon2id$v=19$m=65536,t=4,p=1$VzBVNlVKUHlwTjNWVzQyMQ$hnDnb0Ve3a1RAGBpTpVIRxxqM7rPG1zCwmLoU0bHgi0',6,'Médecin'),(6,'telle','maxens','maxens','$argon2id$v=19$m=65536,t=4,p=1$MmpBdVpHVzFxcWphTGc0RA$F2vMLE8zKl1Qj561QfVCIVhynIVxEDGcMgt7rtFbILQ',7,'Médecin');
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
  `Num_secu` bigint(20) NOT NULL,
  PRIMARY KEY (`Num_secu`),
  KEY `Piece_jointe_FK` (`Num_secu`),
  CONSTRAINT `Piece_jointe_FK` FOREIGN KEY (`Num_secu`) REFERENCES `patient` (`Num_secu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
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
  `Num_secu` bigint(20) NOT NULL,
  `organisme` varchar(50) DEFAULT NULL,
  `assure` varchar(3) DEFAULT NULL,
  `Ald` varchar(3) DEFAULT NULL,
  `Nom_mutuelle` varchar(50) DEFAULT NULL,
  `num_adherent` int(11) NOT NULL,
  `chambre_particuliere` varchar(3) DEFAULT NULL,
  KEY `Renseignements_FK` (`Num_secu`),
  CONSTRAINT `Renseignements_FK` FOREIGN KEY (`Num_secu`) REFERENCES `patient` (`Num_secu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `secu`
--

LOCK TABLES `secu` WRITE;
/*!40000 ALTER TABLE `secu` DISABLE KEYS */;
INSERT INTO `secu` VALUES (185087666666666,'stelantis','Oui','Non','viamedis',333,'1');
/*!40000 ALTER TABLE `secu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `service`
--

DROP TABLE IF EXISTS `service`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `service` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;
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

-- Dump completed on 2023-03-03  9:11:08
