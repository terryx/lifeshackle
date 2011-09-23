-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 26, 2011 at 12:33 PM
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
-- Table structure for table `article`
--

CREATE TABLE IF NOT EXISTS `article` (
  `article_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `created` datetime NOT NULL,
  `body` text NOT NULL,
  `visible` tinyint(4) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`article_id`),
  KEY `name` (`title`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `article`
--


-- --------------------------------------------------------

--
-- Table structure for table `picture`
--

CREATE TABLE IF NOT EXISTS `picture` (
  `picture_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `resized_name` varchar(150) NOT NULL,
  `visible` tinyint(4) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`picture_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `picture`
--

INSERT INTO `picture` (`picture_id`, `name`, `created`, `resized_name`, `visible`, `user_id`) VALUES
(7, 'life_img_20110724061946.jpg', '2011-07-24 18:19:46', 'life_img_20110724061946', 1, 2),
(8, 'life_img_20110724061950.jpg', '2011-07-24 18:19:50', 'life_img_20110724061950', 1, 2),
(9, 'life_img_20110724061954.jpg', '2011-07-24 18:19:55', 'life_img_20110724061954', 1, 2),
(10, 'life_img_20110724061958.jpg', '2011-07-24 18:19:58', 'life_img_20110724061958', 1, 2),
(11, 'life_img_20110724062001.jpg', '2011-07-24 18:20:01', 'life_img_20110724062001', 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `tag`
--

CREATE TABLE IF NOT EXISTS `tag` (
  `tag_id` int(11) NOT NULL AUTO_INCREMENT,
  `article_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`tag_id`),
  KEY `article_id` (`article_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `tag`
--

INSERT INTO `tag` (`tag_id`, `article_id`, `name`) VALUES
(1, 1, '2'),
(2, 0, 'Lifestyle'),
(3, 2, '2');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `type` enum('normal','admin','super_admin') NOT NULL,
  `status` enum('active','inactive') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=35 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `firstname`, `lastname`, `email`, `type`, `status`) VALUES
(2, 'terryx', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 'Terryx', 'Yuen', 'terryxlife@gmail.com', 'super_admin', 'active'),
(27, 'terry5', 'c7854c301113d781c6f3cc763390da65f6459ee30cc52359842f5901649abbee', 'ttt', 'tt', 'terryxlife@gmail.com', 'admin', 'active'),
(26, 'terry4', 'c7854c301113d781c6f3cc763390da65f6459ee30cc52359842f5901649abbee', 'terry', 'tt', 'terryxlife@gmail.com', 'admin', 'active'),
(25, 'terry3', 'bcb15f821479b4d5772bd0ca866c00ad5f926e3580720659cc80d39c9d09802a', 'Terryxx', 'Yuen', 'terryxlife@gmail.com', 'admin', 'active'),
(23, 'terryg', 'c7854c301113d781c6f3cc763390da65f6459ee30cc52359842f5901649abbee', 'terry', 'tt', 'terryxlife@gmail.com', 'admin', 'active'),
(24, 'terry2', 'bcb15f821479b4d5772bd0ca866c00ad5f926e3580720659cc80d39c9d09802a', 'Terryxx', 'Yuen', 'terryxlife@gmail.com', 'admin', 'active'),
(16, 'terryy', 'c7854c301113d781c6f3cc763390da65f6459ee30cc52359842f5901649abbee', 'tt', 'tt', 'terryxlife@gmail.com', 'admin', 'active'),
(28, 'terry6', 'c7854c301113d781c6f3cc763390da65f6459ee30cc52359842f5901649abbee', 'terryxx', 't', 'terryxlife@gmail.com', 'admin', 'active'),
(29, 'terry7', 'c7854c301113d781c6f3cc763390da65f6459ee30cc52359842f5901649abbee', 'terry', 'tt', 'terryxlife@gmail.com', 'admin', 'active'),
(30, 'terry8', 'c7854c301113d781c6f3cc763390da65f6459ee30cc52359842f5901649abbee', 'tt', 'tt', 'terryxlife@gmail.com', 'admin', 'active'),
(31, 'terry9', 'c7854c301113d781c6f3cc763390da65f6459ee30cc52359842f5901649abbee', 'terry', 'tt', 'terryxlife@gmail.com', 'admin', 'active'),
(32, 'rff', '72239e8b21c5b0d1435b672ce16340acb3d9672bcfa890a1517a495853c61366', 'y', 'rr', 'terryxlife@gmail.com', 'admin', 'active'),
(33, 'terry', '86cd02bdf97b21b2a1307ec21edb6af71d91673ee26c0b0d23544580d38f02a1', 't', 't', 'terryxlife@gmail.com', 'admin', 'active'),
(34, 'ttt', 'c7854c301113d781c6f3cc763390da65f6459ee30cc52359842f5901649abbee', 'terry', 't', 'terryxlife@gmail.com', 'admin', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `users_ip`
--

CREATE TABLE IF NOT EXISTS `users_ip` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip_address` text NOT NULL,
  `login_attempt` tinyint(4) NOT NULL,
  `status` enum('active','inactive') NOT NULL,
  `last_login_date` datetime NOT NULL,
  `login_as` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `users_ip`
--

INSERT INTO `users_ip` (`id`, `ip_address`, `login_attempt`, `status`, `last_login_date`, `login_as`) VALUES
(7, '127.0.0.1', 2, 'active', '2011-05-12 15:02:41', 'terryx1');
