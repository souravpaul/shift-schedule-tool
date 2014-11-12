-- phpMyAdmin SQL Dump
-- version 3.4.10.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 29, 2014 at 05:09 PM
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
  `TEAM_ID` int(11) DEFAULT NULL,
  `ACTIVE` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`USER_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Table structure for table `TEAM`
--

CREATE TABLE IF NOT EXISTS `TEAM` (
  `TEAM_ID` int(5) NOT NULL AUTO_INCREMENT,
  `NAME` varchar(25) NOT NULL,
  `ADMIN_ID` int(10) NOT NULL,
  `ACTIVE` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`TEAM_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
