-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 29, 2021 at 04:19 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `plusagency_3.1`
--

-- --------------------------------------------------------

--
-- Table structure for table `permalinks`
--

CREATE TABLE `permalinks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `permalink` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `details` tinyint(4) NOT NULL DEFAULT 0 COMMENT '1 - for details page, 0 - for non-details page'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permalinks`
--

INSERT INTO `permalinks` (`id`, `permalink`, `type`, `details`) VALUES
(1, 'packages', 'packages', 0),
(2, 'package', 'package_order', 1),
(3, 'services', 'services', 0),
(4, 'service', 'service_details', 1),
(5, 'portfolios', 'portfolios', 0),
(6, 'portfolio', 'portfolio_details', 1),
(7, 'products', 'products', 0),
(8, 'product', 'product_details', 1),
(9, 'cart', 'cart', 0),
(10, 'checkout', 'product_checkout', 0),
(11, 'team', 'team', 0),
(12, 'courses', 'courses', 0),
(13, 'course', 'course_details', 1),
(14, 'causes', 'causes', 0),
(15, 'cause', 'cause_details', 1),
(16, 'events', 'events', 0),
(17, 'event', 'event_details', 1),
(18, 'career', 'career', 0),
(19, 'job', 'career_details', 1),
(20, 'event-calendar', 'event_calendar', 0),
(21, 'knowledgebase', 'knowledgebase', 0),
(22, 'article', 'knowledgebase_details', 1),
(23, 'gallery', 'gallery', 0),
(24, 'faq', 'faq', 0),
(25, 'blogs', 'blogs', 0),
(26, 'blog', 'blog_details', 1),
(27, 'rss', 'rss', 0),
(28, 'rss', 'rss_details', 1),
(29, 'contact', 'contact', 0),
(30, 'quote', 'quote', 0),
(31, 'login', 'login', 0),
(32, 'register', 'register', 0),
(33, 'forget-password', 'forget_password', 0),
(67, 'admin', 'admin_login', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `permalinks`
--
ALTER TABLE `permalinks`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `permalinks`
--
ALTER TABLE `permalinks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
