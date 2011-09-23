-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 09, 2011 at 02:44 AM
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
  `tag` text NOT NULL,
  `visible` tinyint(4) NOT NULL,
  `user_id` int(11) NOT NULL,
  `latest_id` int(11) NOT NULL,
  PRIMARY KEY (`article_id`),
  KEY `name` (`title`),
  KEY `latest_id` (`latest_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `article`
--

INSERT INTO `article` (`article_id`, `title`, `created`, `body`, `tag`, `visible`, `user_id`, `latest_id`) VALUES
(3, 'doophp orm database', '2011-07-31 15:15:39', '<pre><span style="color:yellow"># Enable sql tracking for debug purpose, remove it in\nProduction mode</span>\r\nDoo::db()-&gt;sql_tracking = true;\r\n\r\n<span style="color:yellow"># A simple Find all</span>\r\nDoo::db()-&gt;find(''Food'');\r\n\r\n<span style="color:yellow"># A simple relate search</span>\r\nDoo::db()-&gt;relate(''Food'', ''FoodType'');\r\n\r\n<span style="color:yellow"># A simple relate search that ONLY returns FoodType that has\nFood</span>\r\nDoo::db()-&gt;relate(''FoodType'',''Food'', array(''match''=&gt;true));\r\n\r\n<span style="color:yellow"># A simple relate search that ONLY returns FoodType that has\nFood</span>\r\nDoo::db()-&gt;relate(''FoodType'',''Food'', array(''match''=&gt;true));\r\n\r\n<span style="color:yellow"># Find a record, this is exposed to sql injection and doesn''t\nhandle any escaping/quoting </span>\r\nDoo::db()-&gt;find(''Food'', array(\r\n                            ''limit''=&gt;1,\r\n                            ''where''=&gt;''food.name = '' . $this-&gt;params[''foodname''],\r\n                    ));\r\n\r\n<span style="color:yellow"># Instead, Do this! Pass array to param</span>\r\nDoo::db()-&gt;find(''Food'', array(\r\n                            ''limit''=&gt;1,\r\n                            ''where''=&gt;''food.name = ?'',\r\n                            ''param''=&gt; array( $this-&gt;params[''foodname''] )\r\n                    ));\r\n\r\n<span style="color:yellow"># Or create the Model object and search. Escaping/quoting is\nautomatically done</span>\r\nDoo::loadModel(''Food'');\r\n$food = new Food;\r\n$food-&gt;name = $this-&gt;params[''foodname''];\r\nDoo::db()-&gt;find($food, array(''limit''=&gt;1));</pre>', '', 0, 2, 0),
(12, 'test3', '2011-08-06 07:50:10', 'asd', '', 0, 2, 3);

-- --------------------------------------------------------

--
-- Table structure for table `expense`
--

CREATE TABLE IF NOT EXISTS `expense` (
  `expense_id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `breakfast` double NOT NULL,
  `lunch` double NOT NULL,
  `dinner` double NOT NULL,
  `supper` double NOT NULL,
  `travel` double NOT NULL,
  `leisure` double NOT NULL,
  `misc` double NOT NULL,
  PRIMARY KEY (`expense_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `expense`
--

INSERT INTO `expense` (`expense_id`, `date`, `breakfast`, `lunch`, `dinner`, `supper`, `travel`, `leisure`, `misc`) VALUES
(1, '0000-00-00', 10, 0, 0, 0, 0, 0, 0),
(2, '0000-00-00', 5, 0, 0, 0, 0, 0, 0),
(3, '0000-00-00', 5, 0, 0, 0, 0, 0, 0),
(4, '0000-00-00', 20, 0, 0, 0, 0, 0, 0),
(5, '0000-00-00', 10, 0, 0, 0, 0, 0, 0),
(6, '0000-00-00', 12, 0, 0, 0, 0, 0, 0),
(7, '2011-08-05', 10, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `latest_update`
--

CREATE TABLE IF NOT EXISTS `latest_update` (
  `latest_id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(50) NOT NULL,
  PRIMARY KEY (`latest_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `latest_update`
--

INSERT INTO `latest_update` (`latest_id`, `type`) VALUES
(1, 'article'),
(3, 'article');

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `picture`
--

INSERT INTO `picture` (`picture_id`, `name`, `created`, `resized_name`, `visible`, `user_id`) VALUES
(1, 'life_img_20110726094630.jpg', '2011-07-26 21:46:30', 'life_img_20110726094630', 0, 2),
(2, 'life_img_20110726094633.jpg', '2011-07-26 21:46:33', 'life_img_20110726094633', 0, 2),
(3, 'life_img_20110726094636.jpg', '2011-07-26 21:46:36', 'life_img_20110726094636', 0, 2),
(4, 'life_img_20110726094639.jpg', '2011-07-26 21:46:40', 'life_img_20110726094639', 0, 2),
(5, 'life_img_20110726094819.jpg', '2011-07-26 21:48:19', 'life_img_20110726094819', 0, 2),
(6, 'life_img_20110726094829.jpg', '2011-07-26 21:48:29', 'life_img_20110726094829', 0, 2);

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

-- --------------------------------------------------------

--
-- Table structure for table `video`
--

CREATE TABLE IF NOT EXISTS `video` (
  `video_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `created` datetime NOT NULL,
  `link` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `visible` tinyint(4) NOT NULL,
  `user_id` int(11) NOT NULL,
  `latest_id` int(11) NOT NULL,
  PRIMARY KEY (`video_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `video`
--


-- --------------------------------------------------------

--
-- Table structure for table `visitor_count`
--

CREATE TABLE IF NOT EXISTS `visitor_count` (
  `count_id` int(11) NOT NULL AUTO_INCREMENT,
  `count` int(11) NOT NULL,
  `page` varchar(100) NOT NULL,
  `remote_ip` varchar(30) NOT NULL,
  PRIMARY KEY (`count_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `visitor_count`
--

