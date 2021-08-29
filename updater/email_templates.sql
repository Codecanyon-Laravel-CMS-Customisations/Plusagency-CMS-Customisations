-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 11, 2021 at 01:09 PM
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
-- Table structure for table `email_templates`
--

CREATE TABLE `email_templates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email_type` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_subject` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_body` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `email_templates`
--

INSERT INTO `email_templates` (`id`, `email_type`, `email_subject`, `email_body`) VALUES
(1, 'email_verification', 'Verify Your Email', '<p style=\"line-height: 1.6;\">Hello<b> {customer_username}</b>,</p><p style=\"line-height: 1.6;\"><br></p><p style=\"line-height: 1.6;\">Welcome to&nbsp;<span style=\"font-size: medium;\"><b>{website_title}</b>.</span><br>Please click the link below to verify your email.</p><p>{verification_link}</p><p><br></p><p>Best Regards,</p><p>{website_title}</p>'),
(2, 'product_order', 'Order has been placed', '<p style=\"line-height: 1.6;\">Hello {customer_name},</p><p style=\"line-height: 1.6;\"><br>Your order has been placed successfully. We have attached an invoice in this mail.<br>Order Number: #{order_number}</p><p><br>Please click on the below link to see your order details.<br>{order_link}</p><p><br></p><p>Best Regards,<br>{website_title}</p>'),
(3, 'package_subscription', 'Package Subscription Successful', '<p style=\"line-height: 2;\">Hello {customer_name},</p><p style=\"line-height: 1;\">You have successfully subscribed to <b>{package_name} </b>package.</p><p style=\"line-height: 1;\"><b>Activation Date:</b> {activation_date}</p><p style=\"line-height: 1;\"><b>Expire Date:</b> {expire_date}</p><p style=\"line-height: 2;\">We have also attached an invoice with this email.</p><p style=\"line-height: 1.2;\">Best Regards,</p><p style=\"line-height: 1.2;\">{website_title}</p>'),
(4, 'package_order', 'Package Ordered Successfully', '<p style=\"line-height: 3;\">Hello {customer_name},</p><p style=\"line-height: 1.6;\">You have placed order for {package_name}.&nbsp;<br>Order Number: #{order_number}</p><p>{order_link}</p><p>We have also attached an invoice with this mail.</p><p><br></p><p>Best Regards,<br>{website_title}</p>'),
(5, 'course_enroll', 'Enrolled Course Successfully', '<p style=\"line-height: 1.6;\">Hello {customer_name},</p><p style=\"line-height: 1.6;\"><br>You have enrolled successfully to <b>{course_name}</b> course.<br>Order Number: #{order_number}</p><p><br>Please click on the below link to see your order details.<br>{order_link}</p><p><br></p><p>Best Regards,<br>{website_title}</p>'),
(6, 'donation', 'Donated Successfully', '<p style=\"line-height: 1.6;\">Hello,</p><p style=\"line-height: 1.6;\"><br>You have donated successfully for <b>{cause_name}</b></p><p style=\"line-height: 1.6;\">We have also attached an invoice with this mail.</p><p><br></p><p>Best Regards,<br>{website_title}</p>'),
(7, 'event_ticket', 'Ticket Booked Successfully', '<p style=\"line-height: 1.6;\">Hello {customer_name},</p><p style=\"line-height: 1.6;\"><br>Your order has been placed successfully. We have attached the ticket with this mail.</p><p style=\"line-height: 1.6;\"><b>Event Name: {event_name}</b><br>Ticket ID: #{ticket_id}</p><p><br>Please click on the below link to see your order details.<br>{order_link}</p><p><br></p><p>Best Regards,<br>{website_title}</p>'),
(8, 'subscription_expiry_reminder', 'Your Subscription is about to Expire', '<p>Hello {customer_name},<br><br>Your subscription is about to expire.<br>You have only <strong>{remaining_days} days</strong> remaining.<br>Please extend your current package / change to new one.<br><strong>Current Package:</strong> {current_package_name}<br><strong>Expire Date: </strong>{expire_date}<br><br>Best Regards,</p><p>{website_title}</p>'),
(9, 'subscription_expired', 'Your Subscription is expired', '<p>Hello {customer_name},<br><br>Your subscription is expired<br>Please purchase a package to continue the subscription.</p><p>{packages_link}<br><strong>Expired Package:</strong> {expired_package}<br><strong>Expire Date: </strong>{expire_date}<br><br>Best Regards,</p><p>{website_title}</p>');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `email_templates`
--
ALTER TABLE `email_templates`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `email_templates`
--
ALTER TABLE `email_templates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
