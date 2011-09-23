-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 21, 2011 at 04:21 PM
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
-- Table structure for table `picture`
--

CREATE TABLE IF NOT EXISTS `picture` (
  `picture_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `resized_name` varchar(150) NOT NULL,
  `is_show` tinyint(4) NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`picture_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `picture`
--

INSERT INTO `picture` (`picture_id`, `name`, `created`, `resized_name`, `is_show`, `title`, `description`, `user_id`) VALUES
(1, '253528_106646866091730_100002392522773_64593_4193027_n.jpg', '2011-07-21 23:29:41', 'life_img_20110721112941', 1, '', '', 2),
(2, '261534_120484958041254_100002392522773_157935_2808582_n.jpg', '2011-07-21 23:32:10', 'life_img_20110721113210', 1, '', '', 2),
(3, '264915_117753964981020_100002392522773_148923_7942265_n.jpg', '2011-07-21 23:36:46', 'life_img_20110721113646', 1, '', '', 2),
(4, '268962_122565974499819_100002392522773_163405_4438235_n.jpg', '2011-07-21 23:38:26', 'life_img_20110721113825', 1, '', '', 2),
(5, '269860_116566145099802_100002392522773_143839_161565_n.jpg', '2011-07-21 23:43:14', 'life_img_20110721114314', 1, '', '', 2),
(6, '270300_118211328268617_100002392522773_150494_1166410_n.jpg', '2011-07-21 23:44:01', 'life_img_20110721114401', 1, '', '', 2),
(7, '270723_114955765260840_100002392522773_137488_138158_n.jpg', '2011-07-22 00:03:11', 'life_img_20110722120311', 1, '', '', 2),
(8, '282787_122566237833126_100002392522773_163406_5924411_n.jpg', '2011-07-22 00:04:34', 'life_img_20110722120434', 1, '', '', 2);
