CREATE DATABASE  IF NOT EXISTS `cbel_db` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `cbel_db`;
-- MySQL dump 10.13  Distrib 5.6.13, for Win32 (x86)
--
-- Host: localhost    Database: cbel_db
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
INSERT INTO `categoryoptions` VALUES (1,'One-Time Project','Course-Based Opportunity','Aboriginal Engagement','Aboriginal Engagement','Consultation',NULL,NULL,NULL,'Initial Idea Inputted'),(2,'Recurring Project','Trek Program','Arts - Culture - Heritage','Arts - Culture - Heritage','Curriculum Development',NULL,NULL,NULL,'Assigned Ownership'),(3,'Part of a Multi-Phase Project','Reading Week Project','Civic Participation - Politics - Democracy','Civic Participation - Politics - Democracy','Data Gathering and Mapping',NULL,NULL,NULL,'Active Development'),(4,'On-Going Activity','Community Projects','Community and Economic Development','Community and Economic Development','Direct service delivery',NULL,NULL,NULL,'Project request form sent'),(5,'Something','Community-Based Research','Education - Research','Education - Research','Event',NULL,NULL,NULL,'Referred to partner information session'),(6,NULL,'ISL Pre-Departure','Health - Human Services','Health - Human Services','Fund Development',NULL,NULL,NULL,'Referred to partner scoping session'),(7,NULL,'BEd. Community Field Study','Inclusion - Diversity','Inclusion - Diversity','IT',NULL,NULL,NULL,'In discussions'),(8,NULL,'Arts Internship Program','International','International','Marketing and Communications',NULL,NULL,NULL,'Idea Referred (Pending Confirmation)'),(9,NULL,'Hackathon','IT - Media - Communication','IT - Media - Communication','Program Development',NULL,NULL,NULL,'Referral Confirmed'),(10,NULL,NULL,'Legal - Justice - Human Rights','Legal - Justice - Human Rights','Research - Evaluation and Assessment',NULL,NULL,NULL,'Project/Placement Being Implemented'),(11,NULL,NULL,'Recreation - Sport','Recreation - Sport','Research - Literature Review',NULL,NULL,NULL,'Project/Placement Completed (Ready for Archiv'),(12,NULL,NULL,'Social Services','Social Services','Research - More formalized data collection',NULL,NULL,NULL,'Archived'),(13,NULL,NULL,'Sustainability - Environment - Animals','Sustainability - Environment - Animals',NULL,NULL,NULL,NULL,NULL);
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
  `activity_count` int(11) DEFAULT '0',
  PRIMARY KEY (`lid`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cbel_lead`
--

LOCK TABLES `cbel_lead` WRITE;
/*!40000 ALTER TABLE `cbel_lead` DISABLE KEYS */;
INSERT INTO `cbel_lead` VALUES (1,1,'Rebel Against Aerys Targaryen','The Mad King must die','One-Time Project','Community-Based Research, Hackathon','Civic Participation - Politics - Democracy','Civic Participation - Politics - Democracy','Event',NULL,NULL,NULL,'Archived',16),(2,2,'Behead Eddard Stark','I am the king! I do what I want. Blah.','One-Time Project','Hackathon','','','Event',NULL,NULL,NULL,'Project/Placement Completed (Ready for Archiv',21),(18,2,'fjasl;','fjal;ksjfkl;sdaj','One-Time Project','Trek Program, Community Projects','Arts - Culture - Heritage, Education - Research','Civic Participation - Politics - Democracy, Community and Economic Development','Curriculum Development, Direct service delivery',NULL,NULL,NULL,'Referred to partner information session',6),(19,1,'Marry Dead Brother\'s Betrothed','Brandon is dead. I must marry Catelyn instead.','One-Time Project','Course-Based Opportunity, Community Projects','Arts - Culture - Heritage, Civic Participation - Politics - Democracy','Arts - Culture - Heritage, Civic Participation - Politics - Democracy','Consultation, Event',NULL,NULL,NULL,'Idea Referred (Pending Confirmation)',5),(21,11,'Run Away With Lyanna Stark','I want to fuck her. It shall be done.','One-Time Project','Trek Program','Arts - Culture - Heritage, Civic Participation - Politics - Democracy','Arts - Culture - Heritage, Civic Participation - Politics - Democracy','Data Gathering and Mapping, Event',NULL,NULL,NULL,'Referral Confirmed',4),(22,2,'Be Stupid','I am a horrible and delusional little shit.  Many people want to kill me.','On-Going Activity','Arts Internship Program','Community and Economic Development, Education - Research, Health - Human Services, Inclusion - Diversity','Arts - Culture - Heritage, Civic Participation - Politics - Democracy, Community and Economic Development, Education - Research','Curriculum Development, Direct service delivery, Event',NULL,NULL,NULL,'Referred to partner scoping session',9);
/*!40000 ALTER TABLE `cbel_lead` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comment`
--

DROP TABLE IF EXISTS `comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comment` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) NOT NULL,
  `lid` int(11) NOT NULL,
  `regDate` datetime NOT NULL,
  `post` text NOT NULL,
  PRIMARY KEY (`cid`),
  KEY `_idx` (`username`),
  KEY `lid_idx` (`lid`),
  CONSTRAINT `lid` FOREIGN KEY (`lid`) REFERENCES `cbel_lead` (`lid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `username` FOREIGN KEY (`username`) REFERENCES `user` (`username`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comment`
--

LOCK TABLES `comment` WRITE;
/*!40000 ALTER TABLE `comment` DISABLE KEYS */;
INSERT INTO `comment` VALUES (43,'admin',1,'2014-03-24 15:02:03','As a web producer, I still prefer web designers to design a website for my clients, and developers to code it. Not too comfortable with design by developers.'),(44,'admin',1,'2014-03-24 15:02:27','Couldn&rsquo;t disagree more. If your design is based entirely on diagonals then bootstrap is maybe not a perfect fit. Although, it seems likely you will still have a button someplace and that you would like that button to behave the same way in all browsers and that your button will be composed of colors and gradients that you&rsquo;d like to define using a modern css precomiler that accepts variables for those colors so the similarities between your buttons and other elements can be centrally managed. So yes, you could start from scratch and create that system yourself that does all that but I don&rsquo;t think it has much to do with the goal of a unique visual design.\r\n\r\nMore importantly, a good design is almost useless without a living, HTML and CSS-based style guide. Most projects continue to grow and change after the initial design phase. If you want an agile team where developers can build things without needing to get design involved for every minutia then you need to have some general coding styles and practices in place. A style guide is the answer. So you could spend a few weeks or months creating your own style guide from scratch. Most competent designers would have no problem starting with the Bootstrap style guide and creating something unique and beautiful and likely a heck of a lot more functional and error-free than starting with a blank file, not to mention be a better position for future growth of the design.\r\n\r\nWeb design has stylistic periods just like any living design practice. Sites have been looking all the same long before Bootstrap came into the picture. The nice thing with Bootstrap is that it&rsquo;s much easier for a competent designer to change it when it does start looking all the same because it has all been implemented using well-informed, modern coding practices.'),(45,'admin',1,'2014-03-24 15:04:57','dsfs\r\n\r\nsg'),(46,'admin',1,'2014-03-24 15:05:16','1'),(47,'admin',1,'2014-03-24 15:05:20','2'),(48,'admin',1,'2014-03-24 15:05:25','3'),(49,'admin',1,'2014-03-24 15:05:36','4'),(50,'admin',1,'2014-03-24 15:05:40','5'),(51,'admin',1,'2014-03-24 15:05:43','6'),(52,'admin',1,'2014-03-24 15:05:45','7'),(53,'admin',1,'2014-03-24 15:05:50','8'),(54,'admin',1,'2014-03-24 15:05:55','9'),(55,'admin',1,'2014-03-24 15:06:01','10'),(56,'admin',1,'2014-03-24 15:08:17','test comments:'),(57,'user1',1,'2014-03-24 15:09:12','test comments!!!'),(59,'admin',1,'2014-03-24 20:25:18','test'),(60,'admin',1,'2014-03-25 15:12:50','test123456'),(62,'admin',1,'2014-03-25 15:40:40','fsdfds'),(63,'admin',1,'2014-03-25 15:40:51','dsfs'),(64,'admin',1,'2014-03-25 15:41:31','this is the test now cs319'),(65,'ninja',1,'2014-03-25 17:02:39','Does this work?');
/*!40000 ALTER TABLE `comment` ENABLE KEYS */;
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
  PRIMARY KEY (`pid`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `communitypartner`
--

LOCK TABLES `communitypartner` WRITE;
/*!40000 ALTER TABLE `communitypartner` DISABLE KEYS */;
INSERT INTO `communitypartner` VALUES (1,'The North','Lord Eddard Stark','winteriscoming@ice.ca','423-423-2653'),(2,'Assholes Inc.','Joffrey \'Baratheon\'','faggot@shit.ca','666-666-6666'),(3,'China','Huangdi','huangdi@sile.ca','123-456-7890'),(4,'Generic Partner','Generic Name','generic@email.ca','111-111-1111'),(7,'Tits','McGee','',''),(11,'Selfish Fools Who Start Wars','Rhaegar Targaryen','reddragon@fireandblood.ca','456-464-6485'),(12,'','','','');
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
-- Table structure for table `linked_ids`
--

DROP TABLE IF EXISTS `linked_ids`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `linked_ids` (
  `lid_main` int(11) DEFAULT NULL,
  `lid_link` int(11) DEFAULT NULL,
  KEY `lid_main_idx` (`lid_main`,`lid_link`),
  KEY `LIDLINK_idx` (`lid_link`),
  CONSTRAINT `LIDMAIN` FOREIGN KEY (`lid_main`) REFERENCES `cbel_lead` (`lid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `LIDLINK` FOREIGN KEY (`lid_link`) REFERENCES `cbel_lead` (`lid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `linked_ids`
--

LOCK TABLES `linked_ids` WRITE;
/*!40000 ALTER TABLE `linked_ids` DISABLE KEYS */;
INSERT INTO `linked_ids` VALUES (1,18),(1,21),(1,22),(1,22),(18,21);
/*!40000 ALTER TABLE `linked_ids` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tag`
--

DROP TABLE IF EXISTS `tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tag` (
  `uid` int(11) NOT NULL,
  `lid` int(11) NOT NULL,
  PRIMARY KEY (`uid`,`lid`),
  KEY `lid_idx` (`lid`),
  CONSTRAINT `leadID` FOREIGN KEY (`lid`) REFERENCES `cbel_lead` (`lid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `userID` FOREIGN KEY (`uid`) REFERENCES `user` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tag`
--

LOCK TABLES `tag` WRITE;
/*!40000 ALTER TABLE `tag` DISABLE KEYS */;
/*!40000 ALTER TABLE `tag` ENABLE KEYS */;
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
  `activity_count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`),
  UNIQUE KEY `username_UNIQUE` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=106 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (100,'user1','pass',0,'David','Kim','','user1@hotmail.com',4),(101,'user2','swag',0,'John','Park','','user2@hotmail.com',2),(102,'ninja','ninjapass',0,'ninjapass','Ninja','','ninja@hotmail.com',141),(103,'ninja1421','katana',0,'katana','Ninja','','ninja1421@hotmail.com',0),(104,'fool','evil',0,'Name','Last','','fool@hotmail.com',34),(105,'admin','admin',1,'Jacky','Kataki','','admin@hotmail.com',1000);
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

-- Dump completed on 2014-03-26  3:59:07
