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
INSERT INTO `categoryoptions` VALUES (1,'One-Time Project','Course-Based Opportunity','Aboriginal Engagement','Aboriginal Engagement','Consultation','UBC','Science',NULL,'Initial Idea Inputted'),(2,'Recurring Project','Trek Program','Arts - Culture - Heritage','Arts - Culture - Heritage','Curriculum Development','University Hill Elementary','Engineering',NULL,'Assigned Ownership'),(3,'Part of a Multi-Phase Project','Reading Week Project','Civic Participation - Politics - Democracy','Civic Participation - Politics - Democracy','Data Gathering and Mapping','St. George\'s School','Arts',NULL,'Active Development'),(4,'On-Going Activity','Community Projects','Community and Economic Development','Community and Economic Development','Direct service delivery','Little People Preschool','Fine Arts',NULL,'Project request form sent'),(5,'Something','Community-Based Research','Education - Research','Education - Research','Event','Pitch \'N Put','Kinesiology',NULL,'Referred to partner information session'),(6,NULL,'ISL Pre-Departure','Health - Human Services','Health - Human Services','Fund Development','VIking Sailing Club',NULL,NULL,'Referred to partner scoping session'),(7,NULL,'BEd. Community Field Study','Inclusion - Diversity','Inclusion - Diversity','IT','Kitsilano Community Center',NULL,NULL,'In discussions'),(8,NULL,'Arts Internship Program','International','International','Marketing and Communications',NULL,NULL,NULL,'Idea Referred (Pending Confirmation)'),(9,NULL,'Hackathon','IT - Media - Communication','IT - Media - Communication','Program Development',NULL,NULL,NULL,'Referral Confirmed'),(10,NULL,NULL,'Legal - Justice - Human Rights','Legal - Justice - Human Rights','Research - Evaluation and Assessment',NULL,NULL,NULL,'Project/Placement Being Implemented'),(11,NULL,NULL,'Recreation - Sport','Recreation - Sport','Research - Literature Review',NULL,NULL,NULL,'Project/Placement Completed (Ready for Archiv'),(12,NULL,NULL,'Social Services','Social Services','Research - More formalized data collection',NULL,NULL,NULL,'Archived'),(13,NULL,NULL,'Sustainability - Environment - Animals','Sustainability - Environment - Animals',NULL,NULL,NULL,NULL,'Dropped');
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
  `startdate` date DEFAULT NULL,
  `enddate` date DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `activity_count` int(11) DEFAULT '0',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`lid`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cbel_lead`
--

LOCK TABLES `cbel_lead` WRITE;
/*!40000 ALTER TABLE `cbel_lead` DISABLE KEYS */;
INSERT INTO `cbel_lead` VALUES (23,21,'Website Development','Still needs to be developed: Maintenance of  website (ongoing? One time project?)\r\n','On-Going Activity',NULL,'IT - Media - Communication','IT - Media - Communication','IT','Array',NULL,'0000-00-00','0000-00-00','',1,'2014-04-01 18:59:06'),(24,13,'Fitness','Engagement Studios part 2: to carry on the work of a previous group of CHD students who created a plan for a sustainable health and fitness program for individuals with developmental disabilities who are accessing the 4 Day Programs delivered by Comm','',NULL,'Community and Economic Development, Health - Human Services, Recreation - Sport','Health - Human Services, Recreation - Sport','Event',NULL,NULL,'0000-00-00','0000-00-00','',1,'2014-04-01 18:31:28'),(25,15,'CST','A brochure detailing community services and supports for the  Community Schools Team (CST) and Community Partner 3 and developed for use by teachers who don\'t live in the area and are unaware of local resources that can support their students and fam','On-Going Activity','Community Projects','Community and Economic Development','Education - Research',NULL,NULL,NULL,'0000-00-00','0000-00-00','',0,'2014-04-01 18:33:00'),(26,16,'Foodbank','1. Research community organizations in Richmond and the populations they serve and then identify which ones serve populations that are likely not accessing the Foodbank but could benefit from it\r\n','Part of a Multi-Phase Project',NULL,NULL,NULL,NULL,NULL,NULL,'0000-00-00','0000-00-00','Archived',2,'2014-04-01 18:59:42'),(27,17,'Open House','Agency focused open house at Community Partner 2\r\n','One-Time Project',NULL,'Community and Economic Development','Community and Economic Development','Direct service delivery, Event',NULL,NULL,'0000-00-00','0000-00-00','Dropped',2,'2014-04-01 18:49:00'),(28,18,'Sustainable Social Media','Still needs more development: Research, test, assess, and recommend any new social media trends and tools for future application; Monitor/track similar social media activity and respond in a timely manner; Help develop a sustainable social media plan','',NULL,NULL,NULL,NULL,NULL,NULL,'0000-00-00','0000-00-00','Initial Idea Inputted',0,'2014-04-01 18:50:57'),(29,28,'Aboriginal Open House','Open house in March for community to learn more about the organization\r\n','One-Time Project',NULL,'Aboriginal Engagement, Community and Economic Development','Aboriginal Engagement, Community and Economic Development',NULL,NULL,NULL,'2014-03-01','0000-00-00','',0,'2014-04-01 18:52:30'),(30,19,'Art Show','Have students work with staff to create a plan to showcase art created by residents in all Community Partner 6 program areas. For example: Photography Club, Galliano Camping Trip working with 2 artists (jewellery & water colour), Garden Boxes with, p','One-Time Project',NULL,NULL,'Aboriginal Engagement','Event','Array',NULL,'0000-00-00','0000-00-00','',0,'2014-04-01 18:54:14');
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
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `communitypartner`
--

LOCK TABLES `communitypartner` WRITE;
/*!40000 ALTER TABLE `communitypartner` DISABLE KEYS */;
INSERT INTO `communitypartner` VALUES (13,'Community Partner 1','Jane Smith','janesmith@cp1.ca',NULL),(14,'Community Partner 1','John Dumas','johndumas@cp1.ca',NULL),(15,'Community Partner 3','Mary Jones','mjones@ilikecommunity.ca',NULL),(16,'Community Partner 2','Edward Chang','edc@food.ca',NULL),(17,'Community Partner 2','Cherry Blue','Cherryb@food.ca',NULL),(18,'Community Partner 4','Luke Warmwater','lukewarmwater@media.com',NULL),(19,'Community Partner 6','Huey','huey@neighbourhood.ca',NULL),(20,'Community Partner 6','Marshall Ericson','marshall@neighbourhood.ca',NULL),(21,'Community Partner 7','Ginger Rogers','ginger@dance.com',NULL),(22,'Community Partner 8','Groucho Marx','groucho@it.com',NULL),(23,'Community Partner 9','Audrey Hepburn','audrey@dance.com',NULL),(24,'Community Partner 10','Elvis Presley','elvis@dance.com',NULL),(25,'Community Partner 11','Marilyn Monroe','mmonroe@idigcommunity.com',NULL),(26,'Community Partner 12','Peter Mansbridge','Pete@kidsrule.ca',NULL),(27,'Community Partner 13','Hannah Montana','hmontana@dance.com',NULL),(28,'Community Partner 14','Humphrey Bogart','katherine.MacIntyre@options.bc.ca ',NULL),(29,'Community Partner 15','Frank Sinatra','Frank@volunteer.ca',NULL),(30,'Community Partner 16','Aretha Franklin','respect@comm.com',NULL),(31,'Community Partner 17','Monica Geller','mon@geller.ca',NULL),(32,'Community Partner 18','Rachel Green','rachel.green@communitybusiness.ca',NULL),(33,'Community Partner 19','Chandler Bing','mschenandlerbong@gmail.com',NULL),(34,'Community Partner 20','Pheobe Buffet','Pheobe.buffet@art.com',NULL),(35,'Community Partner 21','Joey Tribiani, CEO','joe.tribiani@hr.ca',NULL),(36,'Community Partner 22','Ross Geller','ilovemarcel@communicate.com',NULL);
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
  CONSTRAINT `LIDLINK` FOREIGN KEY (`lid_link`) REFERENCES `cbel_lead` (`lid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `LIDMAIN` FOREIGN KEY (`lid_main`) REFERENCES `cbel_lead` (`lid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `linked_ids`
--

LOCK TABLES `linked_ids` WRITE;
/*!40000 ALTER TABLE `linked_ids` DISABLE KEYS */;
INSERT INTO `linked_ids` VALUES (26,27),(27,26);
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
  `seen` int(1) DEFAULT '0',
  `tags` int(1) DEFAULT '0',
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
) ENGINE=InnoDB AUTO_INCREMENT=111 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (106,'kieran','kieran',1,'Kieran','Harrison','456-456-4568','something@email.com',6),(107,'yoonsung','yoonsung',0,'Yoonsung','Ahn','456-456-4862','clyde@email.com',0),(108,'bobby','bobby',1,'Bobby','Lau','875-462-4896','bobby@email.com',0),(109,'taranbir','taranbir',0,'Taranbir','Bhullar','468-268-4568','td@email.com',0),(110,'chiho','chiho',0,'ChiHo','Won','285-564-8546','david@email.com',0);
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

-- Dump completed on 2014-04-01 12:00:50
