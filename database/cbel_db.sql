CREATE DATABASE  IF NOT EXISTS `cbel_db` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `cbel_db`;
-- MySQL dump 10.13  Distrib 5.6.13, for osx10.6 (i386)
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
INSERT INTO `categoryoptions` VALUES (1,'One-Time Project','Course-Based Opportunity','Aboriginal Engagement','Aboriginal Engagement','Consultation',NULL,NULL,NULL,'Initial Idea Inputted'),(2,'Recurring Project','Trek Program','Arts - Culture - Heritage','Arts - Culture - Heritage','Curriculum Development',NULL,NULL,NULL,'Assigned Ownership'),(3,'Part of a Multi-Phase Project','Reading Week Project','Civic Participation - Politics - Democracy','Civic Participation - Politics - Democracy','Data Gathering and Mapping',NULL,NULL,NULL,'Active Development'),(4,'On-Going Activity','Community Projects','Community and Economic Development','Community and Economic Development','Direct service delivery',NULL,NULL,NULL,'Project request form sent'),(5,NULL,'Community-Based Research','Education - Research','Education - Research','Event',NULL,NULL,NULL,'Referred to partner information session'),(6,NULL,'ISL Pre-Departure','Health - Human Services','Health - Human Services','Fund Development',NULL,NULL,NULL,'Referred to partner scoping session'),(7,NULL,'BEd. Community Field Study','Inclusion - Diversity','Inclusion - Diversity','IT',NULL,NULL,NULL,'In discussions'),(8,NULL,'Arts Internship Program','International','International','Marketing and Communications',NULL,NULL,NULL,'Idea Referred (Pending Confirmation)'),(9,NULL,'Hackathon','IT - Media - Communication','IT - Media - Communication','Program Development',NULL,NULL,NULL,'Referral Confirmed'),(10,NULL,NULL,'Legal - Justice - Human Rights','Legal - Justice - Human Rights','Research - Evaluation and Assessment',NULL,NULL,NULL,'Project/Placement Being Implemented'),(11,NULL,NULL,'Recreation - Sport','Recreation - Sport','Research - Literature Review',NULL,NULL,NULL,'Project/Placement Completed (Ready for Archiv'),(12,NULL,NULL,'Social Services','Social Services','Research - More formalized data collection',NULL,NULL,NULL,'Archived'),(13,NULL,NULL,'Sustainability - Environment - Animals','Sustainability - Environment - Animals',NULL,NULL,NULL,NULL,'Project Dropped');
/*!40000 ALTER TABLE `categoryoptions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cbel_lead`
--

DROP TABLE IF EXISTS `cbel_lead`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cbel_lead` (
  `lid` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL,
  `lead_name` varchar(45) NOT NULL,
  `description` varchar(250) DEFAULT NULL,
  `idea_type` varchar(45) DEFAULT NULL,
  `referral` varchar(200) DEFAULT NULL,
  `mandate` varchar(200) DEFAULT NULL,
  `focus` varchar(200) DEFAULT NULL,
  `main_activities` varchar(200) DEFAULT NULL,
  `location` varchar(45) DEFAULT NULL,
  `disciplines` varchar(45) DEFAULT NULL,
  `timeframe` varchar(45) DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`lid`,`pid`),
  UNIQUE KEY `lid_UNIQUE` (`lid`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cbel_lead`
--

LOCK TABLES `cbel_lead` WRITE;
/*!40000 ALTER TABLE `cbel_lead` DISABLE KEYS */;
INSERT INTO `cbel_lead` VALUES (1,1,'Rebel Against Aerys Targaryen','The Mad King must die','One-Time Project','Hackathon','Civic Participation - Politics - Democracy, L','Civic Participation - Politics - Democracy, L','Event',NULL,NULL,NULL,'Archived'),(2,2,'Behead Eddard Stark','I am the king! I do what I want.','One-Time Project','Hackathon',NULL,NULL,'Event',NULL,NULL,NULL,'Project/Placement Completed (Ready for Archiv'),(16,2,'','','','Course-Based Opportunity, Reading Week Project, Community-Based Research','Arts - Culture - Heritage, Civic Participation - Politics - Democracy, Community and Economic Development','Aboriginal Engagement, Arts - Culture - Heritage, Education - Research','Curriculum Development, Data Gathering and Mapping, Event',NULL,NULL,NULL,''),(17,2,'fjasl;','fjal;ksjfkl;sdaj','One-Time Project','Trek Program, Community Projects','Arts - Culture - Heritage, Education - Research','Civic Participation - Politics - Democracy, Community and Economic Development','Curriculum Development, Direct service delivery',NULL,NULL,NULL,'Project Dropped'),(18,2,'fjasl;','fjal;ksjfkl;sdaj','One-Time Project','Trek Program, Community Projects','Arts - Culture - Heritage, Education - Research','Civic Participation - Politics - Democracy, Community and Economic Development','Curriculum Development, Direct service delivery',NULL,NULL,NULL,'Referred to partner information session'),(19,1,'Marry Dead Brother\'s Betrothed','Brandon is dead. I must marry Catelyn instead.','One-Time Project','Community Projects','Arts - Culture - Heritage, Civic Participation - Politics - Democracy','Arts - Culture - Heritage, Civic Participation - Politics - Democracy','Consultation, Event',NULL,NULL,NULL,'Idea Referred (Pending Confirmation)'),(21,11,'Run Away With Lyanna Stark','I want to fuck her. It shall be done.','One-Time Project','Trek Program','Arts - Culture - Heritage, Civic Participation - Politics - Democracy','Arts - Culture - Heritage, Civic Participation - Politics - Democracy','Data Gathering and Mapping, Event',NULL,NULL,NULL,'Referral Confirmed'),(22,2,'Be Stupid','I am a horrible and delusional little shit.','On-Going Activity','Arts Internship Program','Community and Economic Development, Education - Research, Health - Human Services, Inclusion - Diversity','Arts - Culture - Heritage, Civic Participation - Politics - Democracy, Community and Economic Development, Education - Research','Curriculum Development, Direct service delivery, Event',NULL,NULL,NULL,'Referred to partner scoping session');
/*!40000 ALTER TABLE `cbel_lead` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `communitypartner`
--

DROP TABLE IF EXISTS `communitypartner`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `communitypartner` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `community_partner` varchar(45) NOT NULL,
  `contact_name` varchar(45) NOT NULL,
  `email` varchar(45) DEFAULT NULL,
  `phone` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`pid`),
  UNIQUE KEY `pid_UNIQUE` (`pid`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `communitypartner`
--

LOCK TABLES `communitypartner` WRITE;
/*!40000 ALTER TABLE `communitypartner` DISABLE KEYS */;
INSERT INTO `communitypartner` VALUES (1,'The North','Lord Eddard Stark','winteriscoming@ice.ca','(423)423-2653'),(2,'Assholes Inc.','Joffrey \'Baratheon\'','faggot@shit.ca','(666)666-6666'),(3,'China','Huangdi','huangdi@sile.ca','(123)456-7890'),(4,'Generic Partner','Generic Name','generic@email.ca','(111)111-1111'),(7,'Tits','McGee','',''),(11,'Selfish Fools Who Start Wars','Rhaegar Targaryen','reddragon@fireandblood.ca','4564646');
/*!40000 ALTER TABLE `communitypartner` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `genkeys`
--

DROP TABLE IF EXISTS `genkeys`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `genkeys` (
  `unusedkey` varchar(29) NOT NULL,
  PRIMARY KEY (`unusedkey`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `genkeys`
--

LOCK TABLES `genkeys` WRITE;
/*!40000 ALTER TABLE `genkeys` DISABLE KEYS */;
INSERT INTO `genkeys` VALUES ('123'),('123123'),('1233'),('222'),('dogt46VR'),('eee'),('Fm22bcyM'),('fmq3z0DT'),('gn2F0umS'),('i26WpxpU'),('owE9K6jh'),('rrrrr');
/*!40000 ALTER TABLE `genkeys` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  `firstname` varchar(45) NOT NULL,
  `lastname` varchar(45) NOT NULL,
  `phonenumber` varchar(14) NOT NULL,
  `email` varchar(45) NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=109 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (100,'user1','pass',0,'ass','123','123-123-1234','123@123.c1om'),(102,'ninja','ninjapass',1,'ninjapass','Ninja','of Awesomeness','64658'),(103,'ninja1421','katana',0,'katana','Ninja','of Awesomeness','64658'),(104,'fool','evil',0,'Name','Last','666','fool@hotmail.com'),(105,'Stormborn','dracarys',0,'Daenerys','Targaryen','456-465-4544','dragonqueen@khaleesi.ca'),(106,'The Emperor','dragon',0,'Huangdi','sile','666-666-6667','emperor@gmail.com'),(107,'123','123',0,'123','123','123-123-1234','123@123.com'),(108,'1234','123',0,'123','123','123-123-1234','123@123123.COM');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-03-24 14:06:48
