-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 24, 2014 at 06:05 AM
-- Server version: 5.6.16
-- PHP Version: 5.5.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cbel_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `categoryoptions`
--

CREATE TABLE IF NOT EXISTS `categoryoptions` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `categoryoptions`
--

INSERT INTO `categoryoptions` (`iid`, `idea_type`, `referral`, `mandate`, `focus`, `main_activities`, `location`, `disciplines`, `timeframe`, `status`) VALUES
(1, 'One-Time Project', 'Course-Based Opportunity', 'Aboriginal Engagement', 'Aboriginal Engagement', 'Consultation', NULL, NULL, NULL, 'Initial Idea Inputted'),
(2, 'Recurring Project', 'Trek Program', 'Arts - Culture - Heritage', 'Arts - Culture - Heritage', 'Curriculum Development', NULL, NULL, NULL, 'Assigned Ownership'),
(3, 'Part of a Multi-Phase Project', 'Reading Week Project', 'Civic Participation - Politics - Democracy', 'Civic Participation - Politics - Democracy', 'Data Gathering and Mapping', NULL, NULL, NULL, 'Active Development'),
(4, 'On-Going Activity', 'Community Projects', 'Community and Economic Development', 'Community and Economic Development', 'Direct service delivery', NULL, NULL, NULL, 'Project request form sent'),
(5, NULL, 'Community-Based Research', 'Education - Research', 'Education - Research', 'Event', NULL, NULL, NULL, 'Referred to partner information session'),
(6, NULL, 'ISL Pre-Departure', 'Health - Human Services', 'Health - Human Services', 'Fund Development', NULL, NULL, NULL, 'Referred to partner scoping session'),
(7, NULL, 'BEd. Community Field Study', 'Inclusion - Diversity', 'Inclusion - Diversity', 'IT', NULL, NULL, NULL, 'In discussions'),
(8, NULL, 'Arts Internship Program', 'International', 'International', 'Marketing and Communications', NULL, NULL, NULL, 'Idea Referred (Pending Confirmation)'),
(9, NULL, 'Hackathon', 'IT - Media - Communication', 'IT - Media - Communication', 'Program Development', NULL, NULL, NULL, 'Referral Confirmed'),
(10, NULL, NULL, 'Legal - Justice - Human Rights', 'Legal - Justice - Human Rights', 'Research - Evaluation and Assessment', NULL, NULL, NULL, 'Project/Placement Being Implemented'),
(11, NULL, NULL, 'Recreation - Sport', 'Recreation - Sport', 'Research - Literature Review', NULL, NULL, NULL, 'Project/Placement Completed (Ready for Archiv'),
(12, NULL, NULL, 'Social Services', 'Social Services', 'Research - More formalized data collection', NULL, NULL, NULL, 'Archived'),
(13, NULL, NULL, 'Sustainability - Environment - Animals', 'Sustainability - Environment - Animals', NULL, NULL, NULL, NULL, 'Project Dropped');

-- --------------------------------------------------------

--
-- Table structure for table `cbel_lead`
--

CREATE TABLE IF NOT EXISTS `cbel_lead` (
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
  PRIMARY KEY (`lid`,`pid`),
  UNIQUE KEY `lid_UNIQUE` (`lid`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cbel_lead`
--

INSERT INTO `cbel_lead` (`lid`, `pid`, `lead_name`, `description`, `idea_type`, `referral`, `mandate`, `focus`, `main_activities`, `location`, `disciplines`, `timeframe`, `status`) VALUES
(1, 1, 'Rebel Against Aerys Targaryen', 'The Mad King must die', 'One-Time Project', 'Hackathon', 'Civic Participation - Politics - Democracy, L', 'Civic Participation - Politics - Democracy, L', 'Event', NULL, NULL, NULL, 'Archived'),
(2, 2, 'Behead Eddard Stark', 'I am the king! I do what I want.', 'One-Time Project', 'Hackathon', NULL, NULL, 'Event', NULL, NULL, NULL, 'Project/Placement Completed (Ready for Archiv'),
(16, 2, '', '', '', 'Course-Based Opportunity, Reading Week Project, Community-Based Research', 'Arts - Culture - Heritage, Civic Participation - Politics - Democracy, Community and Economic Development', 'Aboriginal Engagement, Arts - Culture - Heritage, Education - Research', 'Curriculum Development, Data Gathering and Mapping, Event', NULL, NULL, NULL, ''),
(17, 2, 'fjasl;', 'fjal;ksjfkl;sdaj', 'One-Time Project', 'Trek Program, Community Projects', 'Arts - Culture - Heritage, Education - Research', 'Civic Participation - Politics - Democracy, Community and Economic Development', 'Curriculum Development, Direct service delivery', NULL, NULL, NULL, 'Project Dropped'),
(18, 2, 'fjasl;', 'fjal;ksjfkl;sdaj', 'One-Time Project', 'Trek Program, Community Projects', 'Arts - Culture - Heritage, Education - Research', 'Civic Participation - Politics - Democracy, Community and Economic Development', 'Curriculum Development, Direct service delivery', NULL, NULL, NULL, 'Referred to partner information session'),
(19, 1, 'Marry Dead Brother''s Betrothed', 'Brandon is dead. I must marry Catelyn instead.', 'One-Time Project', 'Community Projects', 'Arts - Culture - Heritage, Civic Participation - Politics - Democracy', 'Arts - Culture - Heritage, Civic Participation - Politics - Democracy', 'Consultation, Event', NULL, NULL, NULL, 'Idea Referred (Pending Confirmation)'),
(21, 11, 'Run Away With Lyanna Stark', 'I want to fuck her. It shall be done.', 'One-Time Project', 'Trek Program', 'Arts - Culture - Heritage, Civic Participation - Politics - Democracy', 'Arts - Culture - Heritage, Civic Participation - Politics - Democracy', 'Data Gathering and Mapping, Event', NULL, NULL, NULL, 'Referral Confirmed'),
(22, 2, 'Be Stupid', 'I am a horrible and delusional little shit.', 'On-Going Activity', 'Arts Internship Program', 'Community and Economic Development, Education - Research, Health - Human Services, Inclusion - Diversity', 'Arts - Culture - Heritage, Civic Participation - Politics - Democracy, Community and Economic Development, Education - Research', 'Curriculum Development, Direct service delivery, Event', NULL, NULL, NULL, 'Referred to partner scoping session');

-- --------------------------------------------------------
--
-- Table structure for table `communitypartner`
--

CREATE TABLE IF NOT EXISTS `communitypartner` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `community_partner` varchar(45) NOT NULL,
  `contact_name` varchar(45) NOT NULL,
  `email` varchar(45) DEFAULT NULL,
  `phone` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`pid`),
  UNIQUE KEY `pid_UNIQUE` (`pid`)

) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
--
-- Dumping data for table `communitypartner`
--

INSERT INTO `communitypartner` (`pid`, `community_partner`, `contact_name`, `email`, `phone`) VALUES
(1, 'The North', 'Lord Eddard Stark', 'winteriscoming@ice.ca', '(423)423-2653'),
(2, 'Assholes Inc.', 'Joffrey ''Baratheon''', 'faggot@shit.ca', '(666)666-6666'),
(3, 'China', 'Huangdi', 'huangdi@sile.ca', '(123)456-7890'),
(4, 'Generic Partner', 'Generic Name', 'generic@email.ca', '(111)111-1111'),
(7, 'Tits', 'McGee', '', ''),
(11, 'Selfish Fools Who Start Wars', 'Rhaegar Targaryen', 'reddragon@fireandblood.ca', '4564646');

-- --------------------------------------------------------

--
-- Table structure for table `genkeys`
--

CREATE TABLE IF NOT EXISTS `genkeys` (
  `unusedkey` varchar(29) NOT NULL,
  PRIMARY KEY (`unusedkey`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `genkeys`
--

INSERT INTO `genkeys` (`unusedkey`) VALUES
('123'),
('123123'),
('1233'),
('222'),
('dogt46VR'),
('eee'),
('Fm22bcyM'),
('fmq3z0DT'),
('gn2F0umS'),
('i26WpxpU'),
('owE9K6jh'),
('rrrrr');

-- --------------------------------------------------------
--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  `firstname` varchar(45) NOT NULL,
  `lastname` varchar(45) NOT NULL,
  `phonenumber` varchar(14) NOT NULL,
  `email` varchar(45) NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=109 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`uid`, `username`, `password`, `admin`, `firstname`, `lastname`, `phonenumber`, `email`) VALUES
(100, 'user1', 'pass', 0, 'ass', '123', '123-123-1234', '123@123.c1om'),
(102, 'ninja', 'ninjapass', 1, 'ninjapass', 'Ninja', 'of Awesomeness', '64658'),
(103, 'ninja1421', 'katana', 0, 'katana', 'Ninja', 'of Awesomeness', '64658'),
(104, 'fool', 'evil', 0, 'Name', 'Last', '666', 'fool@hotmail.com'),
(105, 'Stormborn', 'dracarys', 0, 'Daenerys', 'Targaryen', '456-465-4544', 'dragonqueen@khaleesi.ca'),
(106, 'The Emperor', 'dragon', 0, 'Huangdi', 'sile', '666-666-6667', 'emperor@gmail.com'),
(107, '123', '123', 0, '123', '123', '123-123-1234', '123@123.com'),
(108, '1234', '123', 0, '123', '123', '123-123-1234', '123@123123.COM');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-03-24  9:55:22
