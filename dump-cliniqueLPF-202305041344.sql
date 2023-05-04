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
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact`
--

LOCK TABLES `contact` WRITE;
/*!40000 ALTER TABLE `contact` DISABLE KEYS */;
INSERT INTO `contact` VALUES ('Lavande','Theo',744178936,'12 rue des cafetiers',14),('Totau','Nathan',788899654,'5 rue des chossures',21),('aaa','aaa',2222222222,'222ea',22),('bb','bb',3333333333,'bbbb',23);
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
  `statut` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Hospitalisation_FK` (`Num_secu`),
  KEY `Hospitalisation_FK_1` (`code_personnel`),
  CONSTRAINT `Hospitalisation_FK` FOREIGN KEY (`Num_secu`) REFERENCES `patient` (`Num_secu`),
  CONSTRAINT `hospitalisation_FK_1` FOREIGN KEY (`code_personnel`) REFERENCES `personnel` (`Code_personnel`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hospitalisation`
--

LOCK TABLES `hospitalisation` WRITE;
/*!40000 ALTER TABLE `hospitalisation` DISABLE KEYS */;
INSERT INTO `hospitalisation` VALUES ('2024-04-07','Ambulatoire','15:15',7,185087666666666,23,'A faire'),('2024-04-08','Ambulatoire','20:25',7,111122222222222,31,'A faire'),('2024-04-07','Ambulatoire','12:34',8,121121211111111,32,'A faire');
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
INSERT INTO `patient` VALUES (111122222222222,'Homme','Francois','','Robert','2003-05-22','5 rue des bijoutiers',62860,755363658,'Bourlon','roro@gmail.com',0,21,21),(121121211111111,'Homme','test','','test','2023-04-03','aaa',21212,1312322222,'test','aaa@gmail.com',1,22,23),(185087666666666,'Homme','Dupont','','Alexandre','2008-04-12','5 rue des cocotiers',59860,788569635,'Cambrai','boubou@gmail.com',1,14,14);
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
  `date_naissance` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`Code_personnel`),
  KEY `personnel_FK` (`Service`),
  CONSTRAINT `personnel_FK` FOREIGN KEY (`Service`) REFERENCES `service` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personnel`
--

LOCK TABLES `personnel` WRITE;
/*!40000 ALTER TABLE `personnel` DISABLE KEYS */;
INSERT INTO `personnel` VALUES (7,'Faure','Hugues','h.faure','$argon2id$v=19$m=65536,t=4,p=1$ZFFkOGpROGQ5SnJWOWFTNg$xPJU0AmQAe+91UvYzTb85PXWN1fOQ/EGzoXaJVSPEjI',6,'Médecin','1969-11-03'),(8,'Marquis','Françoise','f.marquis','$argon2id$v=19$m=65536,t=4,p=1$Q2QyUzE4aG5WSzlrdjl1WA$vD3p+0mihgbrPzRIWLGUJfoAloSBdbE4tRxMUmVSCCE',7,'Médecin','1969-11-04'),(9,'Covillon','Alexandre','a.covillon','$argon2id$v=19$m=65536,t=4,p=1$Y0ZrV29DbHJPM3ZsUFBVZw$HIRBx446K8ny9exY1XGJVyoQNPaW/8x+Vxdec0aI9dM',5,'Médecin','1969-11-05'),(10,'Huppe','Victor','v.huppe','$argon2id$v=19$m=65536,t=4,p=1$R0dadFgyOFVNaU82WWFjZg$qF4mmkoY3ySWWBuuC4vgZONBLe166LGPCxDIgn/UZ40',5,'Administrateur','1969-11-06'),(11,'Pouchon','Sylvie','s.pouchon','$argon2id$v=19$m=65536,t=4,p=1$LzM1cE5sMkxsWlBkd3Y5eQ$emzfvt1oey2ue307lT1AsPowFBRQEmm8n6u3kncm4iQ',5,'Secrétaire','1969-11-07');
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
INSERT INTO `piece_jointe` VALUES ('111122222222222_cni.png','111122222222222_cv.png','111122222222222_cm.png','none',111122222222222),('121121211111111_cni.png','121121211111111_cv.png','121121211111111_cm.png','121121211111111_livret.png',121121211111111),('185087666666666_cni.png','185087666666666_cv.png','185087666666666_cm.png','185087666666666_livret.png',185087666666666);
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
INSERT INTO `secu` VALUES (185087666666666,'AXA','Oui','Non','MMA',1,'1'),(111122222222222,'MMA','Oui','Non','AXA',12,'1'),(121121211111111,'aaa','Oui','Non','aaa',313,'1');
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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `service`
--

LOCK TABLES `service` WRITE;
/*!40000 ALTER TABLE `service` DISABLE KEYS */;
INSERT INTO `service` VALUES (5,'Chirurgie'),(6,'Neurologie'),(7,'Radiologie'),(8,'pneumologie'),(9,'cardiologie');
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

-- Dump completed on 2023-05-04 13:44:18
