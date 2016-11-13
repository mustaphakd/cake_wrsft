
-- phpMyAdmin SQL Dump
-- version 2.11.11.3
-- http://www.phpmyadmin.net
--
-- Host: 68.178.143.75
-- Generation Time: Nov 12, 2016 at 01:44 PM
-- Server version: 5.5.43
-- PHP Version: 5.1.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `woroarchweb`
--

-- --------------------------------------------------------

--
-- Table structure for table `downloads`
--

CREATE TABLE IF NOT EXISTS `downloads` (
  `id` binary(36) NOT NULL,
  `user_id` binary(36) NOT NULL,
  `version_id` binary(36) NOT NULL,
  `last_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `downloads`
--


-- --------------------------------------------------------

--
-- Table structure for table `forums`
--

CREATE TABLE IF NOT EXISTS `forums` (
  `id` binary(36) NOT NULL,
  `version_id` binary(36) NOT NULL,
  `title` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `is_open` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `version_id` (`version_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `forums`
--


-- --------------------------------------------------------

--
-- Table structure for table `licenses`
--

CREATE TABLE IF NOT EXISTS `licenses` (
  `id` binary(36) NOT NULL,
  `payment_id` binary(36) NOT NULL,
  `user_id` binary(36) NOT NULL,
  `version_id` binary(36) NOT NULL,
  `activation_start_date` datetime NOT NULL COMMENT 'starts once user/client retrieves license file',
  `duration` int(11) NOT NULL COMMENT 'months',
  `retrieved` tinyint(1) NOT NULL,
  `license_file` blob NOT NULL COMMENT 'x509 file',
  `public_key` blob NOT NULL COMMENT '4096 bits',
  `private_key` blob NOT NULL COMMENT '4096 bits',
  `expiration_date` datetime NOT NULL COMMENT 'set at the same moment activation start_date is set',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `licenses`
--


-- --------------------------------------------------------

--
-- Table structure for table `machines`
--

CREATE TABLE IF NOT EXISTS `machines` (
  `id` binary(36) NOT NULL,
  `user_id` binary(36) NOT NULL,
  `ip_address` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `token` text COLLATE utf8_unicode_ci NOT NULL,
  `registration_date` datetime DEFAULT NULL,
  `type` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `machines`
--


-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `id` binary(36) NOT NULL,
  `user_id` binary(36) NOT NULL,
  `title` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `body` text COLLATE utf8_unicode_ci NOT NULL,
  `date_sent` datetime NOT NULL,
  `email` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `confirmation` char(40) COLLATE utf8_unicode_ci NOT NULL,
  `viewed` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `messages`
--


-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE IF NOT EXISTS `payments` (
  `id` binary(36) NOT NULL,
  `user_id` binary(36) NOT NULL,
  `license_generation_status` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'NotStarted' COMMENT 'NotStarted, Started, Error, Completed',
  `payment_provider` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `transaction_status` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Started' COMMENT 'started, Error, Committed',
  `transaction_start_date` datetime NOT NULL,
  `transaction_end_date` datetime NOT NULL,
  `version_id` binary(36) NOT NULL,
  `amount` double NOT NULL,
  `currency` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `license_duration` int(11) NOT NULL COMMENT 'months',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `payments`
--


-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` binary(36) NOT NULL,
  `name` varchar(36) CHARACTER SET latin1 NOT NULL,
  `announced_date` datetime DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `products`
--


-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` binary(36) NOT NULL,
  `name` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roles`
--


-- --------------------------------------------------------

--
-- Table structure for table `roles_users`
--

CREATE TABLE IF NOT EXISTS `roles_users` (
  `id` binary(36) NOT NULL,
  `role_id` binary(36) DEFAULT NULL,
  `user_id` binary(36) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `roles_users`
--


-- --------------------------------------------------------

--
-- Table structure for table `threads`
--

CREATE TABLE IF NOT EXISTS `threads` (
  `id` binary(36) NOT NULL,
  `forum_id` binary(36) NOT NULL,
  `user_id` binary(36) NOT NULL,
  `posted_date` datetime DEFAULT NULL,
  `thread_id` binary(36) NOT NULL,
  `comment` text CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `threads`
--


-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` binary(36) NOT NULL,
  `username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime DEFAULT NULL,
  `email` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `modified` datetime DEFAULT NULL,
  `confirmed` datetime DEFAULT NULL,
  `resethash` char(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `confirmationhash` char(40) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`,`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--


-- --------------------------------------------------------

--
-- Table structure for table `versions`
--

CREATE TABLE IF NOT EXISTS `versions` (
  `id` binary(36) NOT NULL,
  `product_description_type` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'serialized version of a productdescriptiontype',
  `product_id` binary(36) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `available` tinyint(1) NOT NULL DEFAULT '0',
  `price` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `path` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `download_count` int(11) NOT NULL DEFAULT '0',
  `installer_product_id` binary(36) NOT NULL,
  `build` varchar(12) COLLATE utf8_unicode_ci NOT NULL COMMENT 'format : Major.Minor.Revision.Build each section can have a maximum of 3 letter numbers.',
  `release_notes` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `versions`
--

