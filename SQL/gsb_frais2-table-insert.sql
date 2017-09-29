-- MySQL dump 10.13  Distrib 5.5.53, for debian-linux-gnu (x86_64)
--
-- Host: 0.0.0.0    Database: gsb_frais2
-- ------------------------------------------------------
-- Server version	5.5.53-0ubuntu0.14.04.1

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
-- Table structure for table `Etat`
--

DROP TABLE IF EXISTS `Etat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Etat` (
  `id` char(2) NOT NULL,
  `libelle` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Etat`
--

LOCK TABLES `Etat` WRITE;
/*!40000 ALTER TABLE `Etat` DISABLE KEYS */;
INSERT INTO `Etat` VALUES ('CL','Saisie clôturée'),('CR','Fiche créée, saisie en cours'),('RB','Remboursée'),('VA','Validée et mise en paiement');
/*!40000 ALTER TABLE `Etat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `FicheFrais`
--

DROP TABLE IF EXISTS `FicheFrais`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `FicheFrais` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idVisiteur` char(4) NOT NULL,
  `mois` tinyint(3) unsigned NOT NULL,
  `annee` smallint(5) unsigned NOT NULL,
  `nbJustificatifs` int(11) DEFAULT NULL,
  `montantValide` decimal(10,2) DEFAULT NULL,
  `dateModif` date DEFAULT NULL,
  `idEtat` char(2) DEFAULT 'CR',
  PRIMARY KEY (`id`,`idVisiteur`,`mois`),
  KEY `idEtat` (`idEtat`),
  KEY `idVisiteur` (`idVisiteur`),
  CONSTRAINT `FicheFrais_ibfk_1` FOREIGN KEY (`idEtat`) REFERENCES `Etat` (`id`),
  CONSTRAINT `FicheFrais_ibfk_2` FOREIGN KEY (`idVisiteur`) REFERENCES `Visiteur` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `FicheFrais`
--

LOCK TABLES `FicheFrais` WRITE;
/*!40000 ALTER TABLE `FicheFrais` DISABLE KEYS */;
INSERT INTO `FicheFrais` VALUES (6,'BP',4,2017,NULL,1513.10,'0000-00-00','CR'),(7,'FM',4,2017,NULL,744.60,'2017-05-11','RB'),(10,'FM',5,2017,NULL,310.00,NULL,'CR'),(11,'FM',5,2017,NULL,1932.40,'2017-05-11','CR');
/*!40000 ALTER TABLE `FicheFrais` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Forfait`
--

DROP TABLE IF EXISTS `Forfait`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Forfait` (
  `id` char(3) NOT NULL,
  `libelle` char(20) DEFAULT NULL,
  `montant` decimal(5,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Forfait`
--

LOCK TABLES `Forfait` WRITE;
/*!40000 ALTER TABLE `Forfait` DISABLE KEYS */;
INSERT INTO `Forfait` VALUES ('ETP','Forfait Etape',110.00),('KM','Frais Kilométrique',0.62),('NUI','Nuitée Hôtel',40.00),('REP','Repas Restaurant',25.00);
/*!40000 ALTER TABLE `Forfait` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `LigneFraisForfait`
--

DROP TABLE IF EXISTS `LigneFraisForfait`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `LigneFraisForfait` (
  `idFicheForfait` int(11) NOT NULL,
  `idForfait` char(3) NOT NULL,
  `quantite` int(11) DEFAULT NULL,
  PRIMARY KEY (`idForfait`,`idFicheForfait`),
  KEY `idFicheForfait` (`idFicheForfait`),
  CONSTRAINT `LigneFraisForfait_ibfk_1` FOREIGN KEY (`idForfait`) REFERENCES `Forfait` (`id`),
  CONSTRAINT `LigneFraisForfait_ibfk_2` FOREIGN KEY (`idFicheForfait`) REFERENCES `FicheFrais` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `LigneFraisForfait`
--

LOCK TABLES `LigneFraisForfait` WRITE;
/*!40000 ALTER TABLE `LigneFraisForfait` DISABLE KEYS */;
INSERT INTO `LigneFraisForfait` VALUES (6,'ETP',8),(7,'ETP',3),(11,'ETP',4),(6,'KM',5),(7,'KM',80),(11,'KM',20),(6,'NUI',6),(7,'NUI',3),(11,'NUI',17),(6,'REP',6),(7,'REP',5),(10,'REP',8),(11,'REP',32);
/*!40000 ALTER TABLE `LigneFraisForfait` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `LigneFraisHorsForfait`
--

DROP TABLE IF EXISTS `LigneFraisHorsForfait`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `LigneFraisHorsForfait` (
  `idFraisHF` int(11) NOT NULL AUTO_INCREMENT,
  `idFicheFrais` int(11) NOT NULL,
  `dteFraisHF` date DEFAULT NULL,
  `libFraisHF` varchar(60) DEFAULT NULL,
  `quantite` smallint(5) unsigned DEFAULT NULL,
  PRIMARY KEY (`idFraisHF`),
  KEY `idFicheFrais` (`idFicheFrais`),
  CONSTRAINT `LigneFraisHorsForfait_ibfk_1` FOREIGN KEY (`idFicheFrais`) REFERENCES `FicheFrais` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `LigneFraisHorsForfait`
--

LOCK TABLES `LigneFraisHorsForfait` WRITE;
/*!40000 ALTER TABLE `LigneFraisHorsForfait` DISABLE KEYS */;
/*!40000 ALTER TABLE `LigneFraisHorsForfait` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Visiteur`
--

DROP TABLE IF EXISTS `Visiteur`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Visiteur` (
  `id` char(4) NOT NULL,
  `nom` char(30) DEFAULT NULL,
  `prenom` char(30) DEFAULT NULL,
  `adresse` char(30) DEFAULT NULL,
  `cp` char(5) DEFAULT NULL,
  `ville` char(30) DEFAULT NULL,
  `dateEmbauche` date DEFAULT NULL,
  `login` char(60) DEFAULT NULL,
  `pwd` char(60) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Visiteur`
--

LOCK TABLES `Visiteur` WRITE;
/*!40000 ALTER TABLE `Visiteur` DISABLE KEYS */;
INSERT INTO `Visiteur` VALUES ('BP','BERNARDO','Pivot','55 rue jean jaures','29200','BREST','2016-03-18','Pbernardo','4bc0fefee6c5024f6db2a95b1c8516b9'),('FM','FLOCH','Marie','32 rue de siam','29200','BREST','2002-01-05','Mfloch','ee5d982aa9b66984e1fc85807ca791f8'),('PM','PAGNOL','Marcel','1, rue des oliviers','29200','BREST','2015-03-05','Mpagnol','72e8c09bed4354fe549de8f4686813b2');
/*!40000 ALTER TABLE `Visiteur` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-09-22 15:59:49
