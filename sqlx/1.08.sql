-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 05, 2011 at 10:03 PM
-- Server version: 5.1.36
-- PHP Version: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `terryxbase`
--

-- --------------------------------------------------------

--
-- Table structure for table `latest_update`
--

CREATE TABLE IF NOT EXISTS `latest_update` (
  `latest_id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(50) NOT NULL,
  PRIMARY KEY (`latest_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

ALTER TABLE `article` ADD `latest_id` INT NOT NULL AFTER `user_id` ,
ADD INDEX ( `latest_id` )

CREATE TABLE IF NOT EXISTS `video` (
`video_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`title` VARCHAR( 100 ) NOT NULL ,
`created` DATETIME NOT NULL ,
`body` TEXT NOT NULL ,
`visible` TINYINT NOT NULL ,
`user_id` INT NOT NULL ,
`latest_id` INT NOT NULL
) ENGINE = MYISAM ;
--
-- Dumping data for table `latest_update`
--

