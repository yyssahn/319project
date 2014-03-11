CREATE DATABASE  IF NOT EXISTS `cbel_db` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `cbel_db`;
-- MySQL dump 10.13  Distrib 5.6.13, for Win32 (x86)
--
-- Host: 127.0.0.1    Database: cbel_db
-- ------------------------------------------------------
-- Server version	5.6.16

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
-- Table structure for table `categoryoptions`
--

DROP TABLE IF EXISTS `categoryoptions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categoryoptions` (
  `iid` int(11) NOT NULL AUTO_INCREMENT,
  `idea_type` varchar(45) DEFAULT NULL,
  `referral` varchar(45) DEFAULT NULL,
  `mandate` varchar(45) DEFAULT NULL,
  `focus` varchar(45) DEFAULT NULL,
  `main_activities` varchar(45) DEFAULT NULL,
  `location` varchar(45) DEFAULT NULL,
  `disciplines` varchar(45) DEFAULT NULL,
  `timeframe` varchar(45) DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`iid`),
  UNIQUE KEY `iid_UNIQUE` (`iid`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categoryoptions`
--

LOCK TABLES `categoryoptions` WRITE;
/*!40000 ALTER TABLE `categoryoptions` DISABLE KEYS */;
INSERT INTO `categoryoptions` VALUES (1,'One-Time Project','Course-Based Opportunity','Aboriginal Engagement','Aboriginal Engagement','Consultation',NULL,NULL,NULL,'Initial Idea Inputted'),(2,'Recurring Project','Trek Program','Arts - Culture - Heritage','Arts - Culture - Heritage','Curriculum Development',NULL,NULL,NULL,'Assigned Ownership'),(3,'Part of a Multi-Phase Project','Reading Week Project','Civic Participation - Politics - Democracy','Civic Participation - Politics - Democracy','Data Gathering and Mapping',NULL,NULL,NULL,'Active Development'),(4,'On-Going Activity','Community Projects','Community and Economic Development','Community and Economic Development','Direct service delivery',NULL,NULL,NULL,'Project request form sent'),(5,NULL,'Community-Based Research','Education - Research','Education - Research','Event',NULL,NULL,NULL,'Referred to partner information session'),(6,NULL,'ISL Pre-Departure','Health - Human Services','Health - Human Services','Fund Development',NULL,NULL,NULL,'Referred to partner scoping session'),(7,NULL,'BEd. Community Field Study','Inclusion - Diversity','Inclusion - Diversity','IT',NULL,NULL,NULL,'In discussions'),(8,NULL,'Arts Internship Program','International','International','Marketing and Communications',NULL,NULL,NULL,'Idea Referred (Pending Confirmation)'),(9,NULL,'Hackathon','IT - Media - Communication','IT - Media - Communication','Program Development',NULL,NULL,NULL,'Referral Confirmed'),(10,NULL,NULL,'Legal - Justice - Human Rights','Legal - Justice - Human Rights','Research - Evaluation and Assessment',NULL,NULL,NULL,'Project/Placement Being Implemented'),(11,NULL,NULL,'Recreation - Sport','Recreation - Sport','Research - Literature Review',NULL,NULL,NULL,'Project/Placement Completed (Ready for Archiv'),(12,NULL,NULL,'Social Services','Social Services','Research - More formalized data collection',NULL,NULL,NULL,'Archived'),(13,NULL,NULL,'Sustainability - Environment - Animals','Sustainability - Environment - Animals',NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `categoryoptions` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-03-11 16:19:56
