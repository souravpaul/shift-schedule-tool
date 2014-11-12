-- phpMyAdmin SQL Dump
-- version 3.4.10.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 06, 2014 at 07:24 AM
-- Server version: 5.5.20
-- PHP Version: 5.3.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `SHIFT_SCHEDULE`
--

-- --------------------------------------------------------

--
-- Table structure for table `ACCOUNT`
--

CREATE TABLE IF NOT EXISTS `ACCOUNT` (
  `USER_ID` int(11) NOT NULL AUTO_INCREMENT,
  `USERNAME` varchar(50) NOT NULL,
  `PASSWORD` text NOT NULL,
  `ADMIN_TYPE` varchar(25) NOT NULL DEFAULT '0',
  `USER_EMAIL` varchar(75) NOT NULL,
  `TEAM_ID` int(11) DEFAULT NULL,
  `ACTIVE` int(1) NOT NULL DEFAULT '1',
  `PASSWORD_TYPE` varchar(15) NOT NULL DEFAULT 'PART_TIME',
  `MEMBER_ID` int(11) NOT NULL DEFAULT '-1',
  PRIMARY KEY (`USER_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

--
-- Table structure for table `EMAIL_LOG`
--

CREATE TABLE IF NOT EXISTS `EMAIL_LOG` (
  `ID` int(20) NOT NULL AUTO_INCREMENT,
  `SENDER` text NOT NULL,
  `SENDER_NAME` varchar(100) NOT NULL DEFAULT 'Shift Schedule Admin',
  `RECEIVER` text NOT NULL,
  `SUBJECT` text NOT NULL,
  `BODY` text NOT NULL,
  `SEND_TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `MAIL_STATUS` varchar(20) NOT NULL DEFAULT 'PENDING',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

-- --------------------------------------------------------

--
-- Table structure for table `MEMBER`
--

CREATE TABLE IF NOT EXISTS `MEMBER` (
  `MEM_ID` int(11) NOT NULL AUTO_INCREMENT,
  `FIRST_NAME` varchar(20) NOT NULL,
  `MIDDLE_NAME` varchar(20) DEFAULT NULL,
  `LAST_NAME` varchar(20) NOT NULL,
  `CMP_EMAIL` varchar(50) DEFAULT NULL,
  `CMP_ID` varchar(25) NOT NULL,
  `PJ_EMAIL` varchar(50) NOT NULL,
  `PJ_ROLE` varchar(50) DEFAULT NULL,
  `PJ_ID` varchar(25) NOT NULL,
  `CONTACT_1` varchar(20) NOT NULL,
  `CONTACT_2` varchar(20) DEFAULT NULL,
  `CMP_ROLE` varchar(50) DEFAULT NULL,
  `LOCATION` varchar(30) DEFAULT NULL,
  `TEAM_ID` varchar(10) NOT NULL,
  `LOCATION_TYPE` varchar(20) NOT NULL,
  `ACTIVE` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`MEM_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Table structure for table `SCHEDULE`
--

CREATE TABLE IF NOT EXISTS `SCHEDULE` (
  `SCH_ID` int(11) NOT NULL AUTO_INCREMENT,
  `DATE` varchar(10) NOT NULL,
  `SHIFT_ID` int(5) NOT NULL,
  `MEMBER_ID` int(10) NOT NULL,
  `TEAM_ID` int(11) NOT NULL,
  `RANK` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`SCH_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `SHIFT_STRUCTURE`
--

CREATE TABLE IF NOT EXISTS `SHIFT_STRUCTURE` (
  `STRUCT_ID` int(11) NOT NULL AUTO_INCREMENT,
  `START_TIME` text NOT NULL,
  `END_TIME` text NOT NULL,
  `SHIFT_TYPE` varchar(10) NOT NULL,
  `SHIFT_DAYS` varchar(11) NOT NULL,
  `TEAM_ID` int(5) NOT NULL,
  `ACTIVE` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`STRUCT_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `TEAM`
--

CREATE TABLE IF NOT EXISTS `TEAM` (
  `TEAM_ID` int(5) NOT NULL AUTO_INCREMENT,
  `FULL_NAME` varchar(25) NOT NULL,
  `SHORT_NAME` varchar(15) NOT NULL,
  `EMAIL` varchar(75) NOT NULL,
  `ACTIVE` int(11) NOT NULL DEFAULT '1',
  `EMAIL_REF` int(11) DEFAULT '0',
  PRIMARY KEY (`TEAM_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
