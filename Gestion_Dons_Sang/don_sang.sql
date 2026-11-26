/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19-11.8.6-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: don_sang
-- ------------------------------------------------------
-- Server version	11.8.6-MariaDB-5ubuntu0.1 from Ubuntu

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*M!100616 SET @OLD_NOTE_VERBOSITY=@@NOTE_VERBOSITY, NOTE_VERBOSITY=0 */;

--
-- Current Database: `don_sang`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `don_sang` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_uca1400_ai_ci */;

USE `don_sang`;

--
-- Table structure for table `besoins`
--

DROP TABLE IF EXISTS `besoins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `besoins` (
  `id_besoin` int(11) NOT NULL AUTO_INCREMENT,
  `groupe_sanguin` enum('A','B','AB','O') NOT NULL,
  `rhesus` enum('-','+') NOT NULL,
  `niveau_alerte` enum('URGENT','CRITIQUE','NORMALE') NOT NULL,
  PRIMARY KEY (`id_besoin`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `besoins`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `besoins` WRITE;
/*!40000 ALTER TABLE `besoins` DISABLE KEYS */;
INSERT INTO `besoins` VALUES
(1,'O','-','URGENT');
/*!40000 ALTER TABLE `besoins` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `centres_collecte`
--

DROP TABLE IF EXISTS `centres_collecte`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `centres_collecte` (
  `id_centre` int(11) NOT NULL AUTO_INCREMENT,
  `nom_centre` varchar(100) NOT NULL,
  `ville` varchar(55) NOT NULL,
  PRIMARY KEY (`id_centre`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `centres_collecte`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `centres_collecte` WRITE;
/*!40000 ALTER TABLE `centres_collecte` DISABLE KEYS */;
INSERT INTO `centres_collecte` VALUES
(1,'Centre Sousse','Sousse');
/*!40000 ALTER TABLE `centres_collecte` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `donneurs`
--

DROP TABLE IF EXISTS `donneurs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `donneurs` (
  `id_donneur` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `cin` varchar(50) NOT NULL,
  `groupe_sanguin` enum('A','B','AB','O') NOT NULL,
  `rhesus` enum('-','+') NOT NULL,
  `ville` varchar(55) DEFAULT NULL,
  PRIMARY KEY (`id_donneur`),
  UNIQUE KEY `cin` (`cin`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `donneurs`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `donneurs` WRITE;
/*!40000 ALTER TABLE `donneurs` DISABLE KEYS */;
INSERT INTO `donneurs` VALUES
(1,'salim','12909','A','+','Sousse'),
(2,'hama','1223232','A','+','Sousse'),
(3,'hamza','12232312','A','+','Sousse');
/*!40000 ALTER TABLE `donneurs` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `dons`
--

DROP TABLE IF EXISTS `dons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `dons` (
  `id_don` int(11) NOT NULL AUTO_INCREMENT,
  `id_donneur` int(11) NOT NULL,
  `id_centre` int(11) NOT NULL,
  `status` enum('EN STOCK','UTILISÉ','REJETÉ','VALIDE') NOT NULL DEFAULT 'EN STOCK',
  `date` date NOT NULL,
  PRIMARY KEY (`id_don`),
  KEY `id_donneur` (`id_donneur`),
  KEY `id_centre` (`id_centre`),
  CONSTRAINT `dons_ibfk_1` FOREIGN KEY (`id_donneur`) REFERENCES `donneurs` (`id_donneur`),
  CONSTRAINT `dons_ibfk_2` FOREIGN KEY (`id_centre`) REFERENCES `centres_collecte` (`id_centre`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dons`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `dons` WRITE;
/*!40000 ALTER TABLE `dons` DISABLE KEYS */;
INSERT INTO `dons` VALUES
(1,1,1,'UTILISÉ','2027-01-01'),
(2,2,1,'UTILISÉ','2027-01-01'),
(3,3,1,'EN STOCK','2028-01-01');
/*!40000 ALTER TABLE `dons` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `tests_don`
--

DROP TABLE IF EXISTS `tests_don`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `tests_don` (
  `id_test` int(11) NOT NULL AUTO_INCREMENT,
  `id_don` int(11) NOT NULL,
  `est_conforme` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_test`),
  UNIQUE KEY `id_don` (`id_don`),
  CONSTRAINT `tests_don_ibfk_1` FOREIGN KEY (`id_don`) REFERENCES `dons` (`id_don`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tests_don`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `tests_don` WRITE;
/*!40000 ALTER TABLE `tests_don` DISABLE KEYS */;
INSERT INTO `tests_don` VALUES
(1,1,1),
(3,2,1);
/*!40000 ALTER TABLE `tests_don` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `transfusions`
--

DROP TABLE IF EXISTS `transfusions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `transfusions` (
  `id_transfusion` int(11) NOT NULL AUTO_INCREMENT,
  `id_don` int(11) NOT NULL,
  `date_transfusion` date NOT NULL,
  `hopital_recepteur` varchar(150) NOT NULL,
  PRIMARY KEY (`id_transfusion`),
  UNIQUE KEY `id_don` (`id_don`),
  CONSTRAINT `transfusions_ibfk_1` FOREIGN KEY (`id_don`) REFERENCES `dons` (`id_don`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transfusions`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `transfusions` WRITE;
/*!40000 ALTER TABLE `transfusions` DISABLE KEYS */;
INSERT INTO `transfusions` VALUES
(1,1,'2027-01-02','HopitalSahloul'),
(3,2,'2026-11-26','HopitalSahloul');
/*!40000 ALTER TABLE `transfusions` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `utilisateurs` (
  `id_utilisateur` int(11) NOT NULL AUTO_INCREMENT,
  `role` enum('Admin','Médecin','Secrétaire') NOT NULL,
  `nom_utilisateur` varchar(55) NOT NULL,
  `id_centre` int(11) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id_utilisateur`),
  KEY `id_centre` (`id_centre`),
  CONSTRAINT `utilisateurs_ibfk_1` FOREIGN KEY (`id_centre`) REFERENCES `centres_collecte` (`id_centre`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `utilisateurs`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `utilisateurs` WRITE;
/*!40000 ALTER TABLE `utilisateurs` DISABLE KEYS */;
INSERT INTO `utilisateurs` VALUES
(1,'Admin','megdich',1,'$2y$12$BdP5jY/z2jB3Fxgd1Cx/0OFYb1B9U5xPcT2hSIj1V35jLdio9u7qa'),
(2,'Médecin','mei',1,'$2y$12$pqG8H4h8MeaG7lJ6OKVNu.Xr5DJxkmZdw5GPNMSPBi5R6yB2pvK42'),
(3,'Secrétaire','tayeb',1,'$2y$12$BpcJ184DXaO0tS/czZfBq.Xo7T9h4I4tuhByF7H4VU6P/A9Z3tB1e'),
(4,'Secrétaire','omar',1,'$2y$12$7ZB9B//NSPcRMfksqDoGmeJgNvmzKqNkG.MX5uF5uEGl38XLuPtPG');
/*!40000 ALTER TABLE `utilisateurs` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*M!100616 SET NOTE_VERBOSITY=@OLD_NOTE_VERBOSITY */;

-- Dump completed on 2026-11-26 21:43:50
