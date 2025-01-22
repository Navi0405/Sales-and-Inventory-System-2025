-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 05, 2023 at 03:36 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pos`
--

-- --------------------------------------------------------

--
-- Table structure for table `action_logs`
--

CREATE TABLE `action_logs` (
  `id` int(11) NOT NULL,
  `datetime` datetime DEFAULT NULL,
  `role` varchar(10) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `action` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `action_logs`
--

INSERT INTO `action_logs` (`id`, `datetime`, `role`, `username`, `action`) VALUES
(1, '2023-03-17 01:07:16', 'O', 'owner', 'User has logged in'),
(2, '2023-03-16 18:10:24', 'O', 'owner', 'Successfully saved the Category'),
(3, '2023-03-16 18:11:01', 'O', 'owner', 'Successfully saved the Category'),
(4, '2023-03-16 18:11:21', 'O', 'owner', 'Successfully saved the Category'),
(5, '2023-03-16 18:11:39', 'O', 'owner', 'Successfully saved the Category'),
(6, '2023-03-16 18:11:55', 'O', 'owner', 'Successfully saved the Category'),
(7, '2023-03-16 18:12:05', 'O', 'owner', 'Successfully saved the Category'),
(8, '2023-03-16 18:12:13', 'O', 'owner', 'Successfully saved the Category'),
(9, '2023-03-16 18:12:37', 'O', 'owner', 'Successfully saved the Category'),
(10, '2023-03-16 18:12:45', 'O', 'owner', 'Successfully updated the Category'),
(11, '2023-03-16 18:12:51', 'O', 'owner', 'Successfully updated the Category'),
(12, '2023-03-16 18:12:56', 'O', 'owner', 'Successfully updated the Category'),
(13, '2023-03-16 18:13:02', 'O', 'owner', 'Successfully updated the Category'),
(14, '2023-03-16 18:13:07', 'O', 'owner', 'Successfully updated the Category'),
(15, '2023-03-16 18:13:11', 'O', 'owner', 'Successfully updated the Category'),
(16, '2023-03-16 18:13:18', 'O', 'owner', 'Successfully updated the Category'),
(17, '2023-03-16 18:13:28', 'O', 'owner', 'Successfully updated the Category'),
(18, '2023-03-16 18:15:53', 'O', 'owner', 'Successfully saved the Product'),
(19, '2023-03-16 18:15:54', 'O', 'owner', 'Successfully saved the Product'),
(20, '2023-03-16 18:15:55', 'O', 'owner', 'Successfully saved the Product'),
(21, '2023-03-16 18:15:55', 'O', 'owner', 'Successfully saved the Product'),
(22, '2023-03-16 18:15:55', 'O', 'owner', 'Successfully saved the Product'),
(23, '2023-03-16 18:17:59', 'O', 'owner', 'Successfully saved the Product'),
(24, '2023-03-16 18:18:00', 'O', 'owner', 'Successfully update sell price of the Product'),
(25, '2023-03-16 18:18:00', 'O', 'owner', 'Successfully saved the Product details'),
(26, '2023-03-16 18:18:54', 'O', 'owner', 'Successfully saved the Product'),
(27, '2023-03-16 18:18:55', 'O', 'owner', 'Successfully update sell price of the Product'),
(28, '2023-03-16 18:18:55', 'O', 'owner', 'Successfully saved the Product details'),
(29, '2023-03-16 18:21:39', 'O', 'owner', 'Successfully saved the Product'),
(30, '2023-03-16 18:21:39', 'O', 'owner', 'Successfully update sell price of the Product'),
(31, '2023-03-16 18:21:39', 'O', 'owner', 'Successfully saved the Product details'),
(32, '2023-03-16 18:22:58', 'O', 'owner', 'Successfully saved the Product'),
(33, '2023-03-16 18:22:58', 'O', 'owner', 'Successfully update sell price of the Product'),
(34, '2023-03-16 18:22:58', 'O', 'owner', 'Successfully saved the Product details'),
(35, '2023-03-16 18:23:39', 'O', 'owner', 'Successfully updated the Category'),
(36, '2023-03-16 18:25:11', 'O', 'owner', 'Successfully saved the Product'),
(37, '2023-03-16 18:25:11', 'O', 'owner', 'Successfully update sell price of the Product'),
(38, '2023-03-16 18:25:11', 'O', 'owner', 'Successfully saved the Product details'),
(39, '2023-03-16 18:42:39', 'O', 'owner', 'Successfully saved the Product'),
(40, '2023-03-16 18:42:40', 'O', 'owner', 'Successfully update sell price of the Product'),
(41, '2023-03-16 18:42:40', 'O', 'owner', 'Successfully saved the Product details'),
(42, '2023-03-16 18:43:32', 'O', 'owner', 'Successfully saved the Product'),
(43, '2023-03-16 18:43:33', 'O', 'owner', 'Successfully update sell price of the Product'),
(44, '2023-03-16 18:43:33', 'O', 'owner', 'Successfully saved the Product details'),
(45, '2023-03-16 18:44:12', 'O', 'owner', 'Successfully saved the Product'),
(46, '2023-03-16 18:44:13', 'O', 'owner', 'Successfully update sell price of the Product'),
(47, '2023-03-16 18:44:13', 'O', 'owner', 'Successfully saved the Product details'),
(48, '2023-03-16 18:45:19', 'O', 'owner', 'Successfully saved the Product'),
(49, '2023-03-16 18:45:19', 'O', 'owner', 'Successfully update sell price of the Product'),
(50, '2023-03-16 18:45:19', 'O', 'owner', 'Successfully saved the Product details'),
(51, '2023-03-16 18:46:01', 'O', 'owner', 'Successfully saved the Product'),
(52, '2023-03-16 18:46:01', 'O', 'owner', 'Successfully update sell price of the Product'),
(53, '2023-03-16 18:46:01', 'O', 'owner', 'Successfully saved the Product details'),
(54, '2023-03-16 18:47:36', 'O', 'owner', 'Successfully saved the Product'),
(55, '2023-03-16 18:47:37', 'O', 'owner', 'Successfully update sell price of the Product'),
(56, '2023-03-16 18:47:37', 'O', 'owner', 'Successfully saved the Product details'),
(57, '2023-03-16 18:47:54', 'O', 'owner', 'Successfully updated the Category'),
(58, '2023-03-16 18:48:39', 'O', 'owner', 'Successfully saved the Product'),
(59, '2023-03-16 18:48:39', 'O', 'owner', 'Successfully update sell price of the Product'),
(60, '2023-03-16 18:48:39', 'O', 'owner', 'Successfully saved the Product details'),
(61, '2023-03-16 18:49:21', 'O', 'owner', 'Successfully saved the Product'),
(62, '2023-03-16 18:49:21', 'O', 'owner', 'Successfully update sell price of the Product'),
(63, '2023-03-16 18:49:21', 'O', 'owner', 'Successfully saved the Product details'),
(64, '2023-03-16 18:50:16', 'O', 'owner', 'Successfully saved the Product'),
(65, '2023-03-16 18:50:16', 'O', 'owner', 'Successfully update sell price of the Product'),
(66, '2023-03-16 18:50:16', 'O', 'owner', 'Successfully saved the Product details'),
(67, '2023-03-16 18:51:45', 'O', 'owner', 'Successfully saved the Product'),
(68, '2023-03-16 18:51:46', 'O', 'owner', 'Successfully update sell price of the Product'),
(69, '2023-03-16 18:51:46', 'O', 'owner', 'Successfully saved the Product details'),
(70, '2023-03-16 18:53:05', 'O', 'owner', 'Successfully saved the Product'),
(71, '2023-03-16 18:53:06', 'O', 'owner', 'Successfully update sell price of the Product'),
(72, '2023-03-16 18:53:06', 'O', 'owner', 'Successfully saved the Product details'),
(73, '2023-03-16 19:12:57', 'O', 'owner', 'Successfully saved the Product'),
(74, '2023-03-16 19:12:57', 'O', 'owner', 'Successfully update sell price of the Product'),
(75, '2023-03-16 19:12:57', 'O', 'owner', 'Successfully saved the Product details'),
(76, '2023-03-16 19:24:43', 'O', 'owner', 'Successfully saved the Product'),
(77, '2023-03-16 19:24:44', 'O', 'owner', 'Successfully update sell price of the Product'),
(78, '2023-03-16 19:24:44', 'O', 'owner', 'Successfully saved the Product details'),
(79, '2023-03-16 19:25:30', 'O', 'owner', 'Successfully saved the Product'),
(80, '2023-03-16 19:25:31', 'O', 'owner', 'Successfully update sell price of the Product'),
(81, '2023-03-16 19:25:31', 'O', 'owner', 'Successfully saved the Product details'),
(82, '2023-03-16 19:26:36', 'O', 'owner', 'Successfully saved the Product'),
(83, '2023-03-16 19:26:37', 'O', 'owner', 'Successfully update sell price of the Product'),
(84, '2023-03-16 19:26:37', 'O', 'owner', 'Successfully saved the Product details'),
(85, '2023-03-16 19:44:37', 'O', 'owner', 'Successfully saved the Product'),
(86, '2023-03-16 19:44:37', 'O', 'owner', 'Successfully update sell price of the Product'),
(87, '2023-03-16 19:44:37', 'O', 'owner', 'Successfully saved the Product details'),
(88, '2023-03-16 19:45:48', 'O', 'owner', 'Successfully saved the Product'),
(89, '2023-03-16 19:45:49', 'O', 'owner', 'Successfully update sell price of the Product'),
(90, '2023-03-16 19:45:49', 'O', 'owner', 'Successfully saved the Product details'),
(91, '2023-03-16 19:46:02', 'O', 'owner', 'Successfully updated the Product'),
(92, '2023-03-16 19:47:04', 'O', 'owner', 'Successfully saved the Product'),
(93, '2023-03-16 19:47:05', 'O', 'owner', 'Successfully update sell price of the Product'),
(94, '2023-03-16 19:47:05', 'O', 'owner', 'Successfully saved the Product details'),
(95, '2023-03-16 19:47:41', 'O', 'owner', 'Successfully saved the Product'),
(96, '2023-03-16 19:47:42', 'O', 'owner', 'Successfully update sell price of the Product'),
(97, '2023-03-16 19:47:42', 'O', 'owner', 'Successfully saved the Product details'),
(98, '2023-03-16 19:48:23', 'O', 'owner', 'Successfully saved the Product'),
(99, '2023-03-16 19:48:24', 'O', 'owner', 'Successfully update sell price of the Product'),
(100, '2023-03-16 19:48:24', 'O', 'owner', 'Successfully saved the Product details'),
(101, '2023-03-16 19:51:06', 'O', 'owner', 'Successfully saved the Product'),
(102, '2023-03-16 19:51:06', 'O', 'owner', 'Successfully update sell price of the Product'),
(103, '2023-03-16 19:51:06', 'O', 'owner', 'Successfully saved the Product details'),
(104, '2023-03-16 19:51:49', 'O', 'owner', 'Successfully saved the Product'),
(105, '2023-03-16 19:51:49', 'O', 'owner', 'Successfully update sell price of the Product'),
(106, '2023-03-16 19:51:49', 'O', 'owner', 'Successfully saved the Product details'),
(107, '2023-03-16 19:52:33', 'O', 'owner', 'Successfully saved the Product'),
(108, '2023-03-16 19:52:33', 'O', 'owner', 'Successfully update sell price of the Product'),
(109, '2023-03-16 19:52:33', 'O', 'owner', 'Successfully saved the Product details'),
(110, '2023-03-16 19:53:18', 'O', 'owner', 'Successfully saved the Product'),
(111, '2023-03-16 19:53:18', 'O', 'owner', 'Successfully update sell price of the Product'),
(112, '2023-03-16 19:53:18', 'O', 'owner', 'Successfully saved the Product details'),
(113, '2023-03-16 19:54:01', 'O', 'owner', 'Successfully saved the Product'),
(114, '2023-03-16 19:54:01', 'O', 'owner', 'Successfully update sell price of the Product'),
(115, '2023-03-16 19:54:01', 'O', 'owner', 'Successfully saved the Product details'),
(116, '2023-03-16 19:59:05', 'O', 'owner', 'Successfully updated the Product'),
(117, '2023-03-16 19:59:18', 'O', 'owner', 'Successfully updated the Product'),
(118, '2023-03-16 19:59:28', 'O', 'owner', 'Successfully updated the Product'),
(119, '2023-03-16 19:59:33', 'O', 'owner', 'Successfully updated the Product'),
(120, '2023-03-16 19:59:39', 'O', 'owner', 'Successfully updated the Product'),
(121, '2023-03-16 19:59:43', 'O', 'owner', 'Successfully updated the Product'),
(122, '2023-03-16 19:59:48', 'O', 'owner', 'Successfully updated the Product'),
(123, '2023-03-16 19:59:53', 'O', 'owner', 'Successfully updated the Product'),
(124, '2023-03-16 19:59:58', 'O', 'owner', 'Successfully updated the Product'),
(125, '2023-03-16 20:00:11', 'O', 'owner', 'Successfully updated the Product'),
(126, '2023-03-16 20:00:24', 'O', 'owner', 'Successfully updated the Product'),
(127, '2023-03-16 20:00:34', 'O', 'owner', 'Successfully updated the Product'),
(128, '2023-03-16 20:00:50', 'O', 'owner', 'Successfully updated the Product'),
(129, '2023-03-16 20:01:37', 'O', 'owner', 'Successfully updated the Product'),
(130, '2023-03-16 20:01:50', 'O', 'owner', 'Successfully updated the Product'),
(131, '2023-03-16 20:02:04', 'O', 'owner', 'Successfully updated the Product'),
(132, '2023-03-16 20:02:17', 'O', 'owner', 'Successfully updated the Product'),
(133, '2023-03-16 20:02:54', 'O', 'owner', 'Successfully updated the Product'),
(134, '2023-03-16 20:03:02', 'O', 'owner', 'Successfully updated the Product'),
(135, '2023-03-16 20:03:15', 'O', 'owner', 'Successfully updated the Product'),
(136, '2023-03-16 20:03:29', 'O', 'owner', 'Successfully updated the Product'),
(137, '2023-03-16 20:03:57', 'O', 'owner', 'Successfully updated the Product'),
(138, '2023-03-16 20:04:10', 'O', 'owner', 'Successfully updated the Product'),
(139, '2023-03-16 20:04:17', 'O', 'owner', 'Successfully updated the Product'),
(140, '2023-03-16 20:04:24', 'O', 'owner', 'Successfully updated the Product'),
(141, '2023-03-16 20:04:31', 'O', 'owner', 'Successfully updated the Product'),
(142, '2023-03-16 20:04:38', 'O', 'owner', 'Successfully updated the Product'),
(143, '2023-03-16 20:04:47', 'O', 'owner', 'Successfully updated the Product'),
(144, '2023-03-16 20:04:55', 'O', 'owner', 'Successfully updated the Product'),
(145, '2023-03-16 20:05:03', 'O', 'owner', 'Successfully updated the Product'),
(146, '2023-03-16 20:06:07', 'O', 'owner', 'Successfully saved the User'),
(147, '2023-03-16 20:07:09', 'O', 'owner', 'Successfully saved the User'),
(148, '2023-03-16 20:11:02', 'O', 'owner', 'Successfully saved the Product'),
(149, '2023-03-16 20:11:02', 'O', 'owner', 'Successfully update sell price of the Product'),
(150, '2023-03-16 20:11:02', 'O', 'owner', 'Successfully saved the Product details'),
(151, '2023-03-16 20:12:41', 'O', 'owner', 'Successfully saved the Product'),
(152, '2023-03-16 20:12:42', 'O', 'owner', 'Successfully update sell price of the Product'),
(153, '2023-03-16 20:12:42', 'O', 'owner', 'Successfully saved the Product details'),
(154, '2023-03-16 20:14:18', 'O', 'owner', 'Successfully saved the Product'),
(155, '2023-03-16 20:14:18', 'O', 'owner', 'Successfully update sell price of the Product'),
(156, '2023-03-16 20:14:18', 'O', 'owner', 'Successfully saved the Product details'),
(157, '2023-03-16 20:15:12', 'O', 'owner', 'Successfully saved the Product'),
(158, '2023-03-16 20:15:13', 'O', 'owner', 'Successfully update sell price of the Product'),
(159, '2023-03-16 20:15:13', 'O', 'owner', 'Successfully saved the Product details'),
(160, '2023-03-16 20:16:07', 'O', 'owner', 'Successfully saved the Product'),
(161, '2023-03-16 20:16:07', 'O', 'owner', 'Successfully update sell price of the Product'),
(162, '2023-03-16 20:16:07', 'O', 'owner', 'Successfully saved the Product details'),
(163, '2023-03-16 20:18:47', 'O', 'owner', 'Successfully saved the Product'),
(164, '2023-03-16 20:18:48', 'O', 'owner', 'Successfully update sell price of the Product'),
(165, '2023-03-16 20:18:48', 'O', 'owner', 'Successfully saved the Product details'),
(166, '2023-03-16 20:19:31', 'O', 'owner', 'Successfully saved the Product'),
(167, '2023-03-16 20:19:34', 'O', 'owner', 'Successfully update sell price of the Product'),
(168, '2023-03-16 20:19:34', 'O', 'owner', 'Successfully saved the Product details'),
(169, '2023-03-16 20:19:45', 'O', 'owner', 'Successfully updated the Product'),
(170, '2023-03-16 20:20:47', 'O', 'owner', 'Successfully saved the Product'),
(171, '2023-03-16 20:20:47', 'O', 'owner', 'Successfully update sell price of the Product'),
(172, '2023-03-16 20:20:47', 'O', 'owner', 'Successfully saved the Product details'),
(173, '2023-03-16 20:21:38', 'O', 'owner', 'Successfully saved the Product'),
(174, '2023-03-16 20:21:38', 'O', 'owner', 'Successfully update sell price of the Product'),
(175, '2023-03-16 20:21:38', 'O', 'owner', 'Successfully saved the Product details'),
(176, '2023-03-16 20:23:50', 'O', 'owner', 'Successfully saved the Product'),
(177, '2023-03-16 20:23:51', 'O', 'owner', 'Successfully update sell price of the Product'),
(178, '2023-03-16 20:23:51', 'O', 'owner', 'Successfully saved the Product details'),
(179, '2023-03-16 20:24:32', 'O', 'owner', 'Successfully updated the Product'),
(180, '2023-03-16 20:24:39', 'O', 'owner', 'Successfully updated the Product'),
(181, '2023-03-16 20:25:25', 'O', 'owner', 'Successfully updated the Product'),
(182, '2023-03-16 20:25:59', 'O', 'owner', 'Successfully updated the Product'),
(183, '2023-03-17 18:32:43', 'O', 'owner', 'Account has logged in'),
(184, '2023-03-17 18:32:44', 'O', 'owner', 'Account has logged in'),
(185, '2023-03-17 18:32:50', 'O', 'owner', 'Account has logged in'),
(186, '2023-03-17 18:32:57', 'O', 'owner', 'Account has logged in'),
(187, '2023-03-17 18:33:45', 'O', 'owner', 'Account has logged in'),
(188, '2023-03-17 18:34:35', 'O', 'owner', 'Account has logged in'),
(189, '2023-03-17 18:34:36', 'O', 'owner', 'Account has logged in'),
(190, '2023-03-17 18:34:36', 'O', 'owner', 'Account has logged in'),
(191, '2023-03-17 18:35:34', 'O', 'owner', 'Account has logged in'),
(192, '2023-03-17 18:35:44', 'O', 'owner', 'Account has logged in'),
(193, '2023-03-17 18:35:49', 'O', 'owner', 'Account has logged in'),
(194, '2023-03-17 18:35:56', 'O', 'owner', 'Account has logged in'),
(195, '2023-03-17 18:35:57', 'O', 'owner', 'Account has logged in'),
(196, '2023-03-17 18:39:50', 'O', 'owner', 'Account has logged in'),
(197, '2023-03-17 18:39:51', 'O', 'owner', 'Account has logged in'),
(198, '2023-03-17 18:39:52', 'O', 'owner', 'Account has logged in'),
(199, '2023-03-17 18:42:27', 'O', 'owner', 'Account has logged in'),
(200, '2023-03-17 11:42:48', 'O', 'owner', 'Successfully updated the Product'),
(201, '2023-03-17 11:44:02', 'O', 'owner', 'Successfully updated the Product'),
(202, '2023-03-17 11:44:09', 'O', 'owner', 'Successfully updated the Product'),
(203, '2023-03-17 11:44:17', 'O', 'owner', 'Successfully updated the Product'),
(204, '2023-03-17 11:44:24', 'O', 'owner', 'Successfully updated the Product'),
(205, '2023-03-17 11:44:32', 'O', 'owner', 'Successfully updated the Product'),
(206, '2023-03-17 11:44:40', 'O', 'owner', 'Successfully updated the Product'),
(207, '2023-03-17 11:44:48', 'O', 'owner', 'Successfully updated the Product'),
(208, '2023-03-17 11:44:56', 'O', 'owner', 'Successfully updated the Product'),
(209, '2023-03-17 11:45:03', 'O', 'owner', 'Successfully updated the Product'),
(210, '2023-03-17 11:45:19', 'O', 'owner', 'Successfully updated the Product'),
(211, '2023-03-17 11:50:16', 'O', 'owner', 'Account has logged out'),
(212, '2023-03-17 18:50:19', 'O', 'owner', 'Account has logged in'),
(213, '2023-06-29 14:38:32', 'O', 'owner', 'Account has logged in'),
(214, '2023-06-29 08:46:06', 'O', 'owner', 'Successfully saved the Product'),
(215, '2023-06-29 08:46:07', 'O', 'owner', 'Successfully update sell price of the Product'),
(216, '2023-06-29 14:46:07', 'O', 'owner', 'Successfully saved the Product details'),
(217, '2023-06-29 09:16:33', 'O', 'owner', 'Account has logged out'),
(218, '2023-06-29 15:33:30', 'O', 'owner', 'Account has logged in'),
(219, '2023-07-04 12:23:29', 'O', 'owner', 'Account has logged in'),
(220, '2023-07-04 06:25:03', 'O', 'owner', 'Successfully updated the Product'),
(221, '2023-07-04 06:57:11', 'O', 'owner', 'Account has logged out'),
(222, '2023-07-05 09:12:33', 'Owner', 'owner', 'Account has logged in');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'MILK & DIAPERS'),
(2, 'OINTMENTS'),
(3, 'BRANDED TABLETS'),
(4, 'GENERIC TABLETS'),
(5, 'SUPPLEMENTS'),
(6, 'BRANDED SYRUP'),
(7, 'GENERIC SYRUP'),
(8, 'GALLENICALS');

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` int(11) NOT NULL,
  `number` varchar(50) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `date_transact` datetime DEFAULT NULL,
  `total_items` int(11) DEFAULT NULL,
  `total_purchase` float DEFAULT NULL,
  `discount` tinyint(1) DEFAULT 0 COMMENT 'True | False',
  `costumer_name` varchar(100) DEFAULT NULL,
  `osca_number` varchar(50) DEFAULT NULL,
  `cash_payment` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `barcode` varchar(13) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `sale_price` float DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `max_stock` int(11) DEFAULT NULL,
  `min_stock` int(11) DEFAULT NULL,
  `type` varchar(10) DEFAULT NULL,
  `expired_products` int(11) NOT NULL,
  `stock_status` int(1) NOT NULL,
  `lot_num` int(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `barcode`, `name`, `sale_price`, `status`, `max_stock`, `min_stock`, `type`, `expired_products`, `stock_status`, `lot_num`) VALUES
(6, 2, '4806512120054', 'Foskina Ointment', 25.5, 1, 100, 10, NULL, 0, 1, NULL),
(7, 2, '4800333160329', 'Betnovate Ointment', 31, 1, 100, 10, NULL, 0, 1, NULL),
(8, 2, '4800333160848', 'Dermovate Ointment', 35, 1, 100, 10, NULL, 0, 1, NULL),
(9, 2, '4800304910021', 'Nizoral Cream', 40, 1, 100, 10, NULL, 0, 1, NULL),
(10, 2, '4801962202770', 'Canesten Cream', 24, 1, 100, 10, NULL, 0, 1, NULL),
(11, 5, '4800153302220', 'Centrum advance', 20, 1, 100, 10, NULL, 0, 1, NULL),
(12, 5, '4800153302398', 'Stresstabs tablet', 15, 1, 100, 10, NULL, 0, 1, NULL),
(13, 5, '4806519309032', 'Fern-C capsule', 18, 1, 100, 10, NULL, 0, 1, NULL),
(14, 5, '4809013625004', 'MX-3 capsule', 20.5, 1, 100, 10, NULL, 0, 1, NULL),
(15, 5, '4806510690658', 'Immunomax 10mg capsule           ', 20, 1, 100, 10, NULL, 0, 1, NULL),
(16, 3, '4800153300677', 'Advil Liquigel capsule           ', 12, 1, 100, 10, 'branded', 0, 1, NULL),
(17, 3, '4800204719915', 'Ascof 600mg capsule             ', 12.5, 1, 100, 10, 'branded', 0, 1, NULL),
(18, 3, '4800253243850', 'Dolo Neurobion tab             ', 20, 1, 100, 10, 'branded', 0, 1, NULL),
(19, 3, '4807788526762', 'Bioflu tablet                           ', 15, 1, 100, 10, 'branded', 0, 1, NULL),
(20, 3, '4807788709318', 'Solmux Advance 500mg/5mg tablet ', 15, 1, 100, 10, 'branded', 0, 1, NULL),
(21, 8, '722066005385', 'Antigen', 450, 1, 100, 10, NULL, 0, 1, NULL),
(22, 8, '4809013220032', 'Placenta Soap Goat\'s milk 135g     ', 111, 1, 100, 10, NULL, 0, 1, NULL),
(23, 8, '4806507831484', 'Silka Facial cleanser 150ml  ', 55, 1, 100, 10, NULL, 0, 1, NULL),
(24, 8, '4800119212877', 'Maxi Peel Sun Block cream 25g    ', 30.5, 1, 100, 10, NULL, 0, 1, NULL),
(25, 8, '4005808160235', 'Nivea Creme 30ml                       ', 50, 1, 100, 10, NULL, 0, 1, NULL),
(26, 6, '4800153811333', 'Clusivol 60ml', 90, 1, 100, 10, 'branded', 0, 1, NULL),
(27, 6, '4807788519344', 'Ferlin syrup 120ml                ', 50, 1, 100, 10, 'branded', 0, 1, NULL),
(28, 6, '4807788519368', 'Growee Pedtech drop 15ml     ', 40, 1, 100, 10, 'branded', 0, 1, NULL),
(29, 6, '4807788519306', 'Enervon-C syrup 60ml     ', 44, 1, 100, 10, 'branded', 0, 1, NULL),
(30, 6, '4806516401005', 'Propan TLC drops 15ml       ', 54, 1, 100, 10, 'branded', 0, 1, NULL),
(31, 1, '4802288813046', 'Happy Baby Pants Large 4s     ', 54, 1, 100, 10, NULL, 0, 1, NULL),
(32, 1, '4800488958789', 'EQ Dry Medium 4s            ', 56, 1, 100, 10, NULL, 0, 1, NULL),
(33, 1, '8712045022023', 'Lactum 3+ 1.2kg      ', 30, 1, 100, 10, NULL, 0, 1, NULL),
(34, 1, '4800153138737', 'S-26 Gold One 400g     ', 600, 1, 100, 10, NULL, 0, 1, NULL),
(35, 1, '8712045030202', 'Enfamil Two 350g       ', 450, 1, 100, 10, NULL, 0, 1, NULL),
(36, 4, '1367', 'Aspirin 100mg tab', 15, 1, 100, 10, 'generic', 0, 1, NULL),
(37, 4, '1008', 'Atorvastatin 10mg', 12, 1, 100, 10, 'generic', 0, 1, NULL),
(38, 4, '1282', 'Mefenamic acis 250mg cap', 13, 1, 100, 10, 'generic', 0, 1, NULL),
(39, 4, '1586', 'Diphenhydramine 50mg cap', 14, 1, 100, 10, 'generic', 0, 1, NULL),
(40, 4, '1010', 'Candesartan 8mg      ', 17, 1, 100, 10, 'generic', 0, 1, NULL),
(41, 7, '1404', 'Symdex syrup 60ml      ', 49, 1, 100, 10, 'generic', 0, 1, NULL),
(42, 7, '1129', 'Cefaclor 250mg/60ml susp           ', 38, 1, 100, 10, 'generic', 0, 1, NULL),
(43, 7, '219', 'Cotrimoxazole 400mg susp    ', 60, 1, 100, 10, 'generic', 0, 1, NULL),
(44, 7, '214', 'Cloxacillin 125mg susp       ', 55, 1, 100, 10, 'generic', 0, 1, NULL),
(45, 7, '178', 'Salbutamol Syrup', 47, 1, 100, 10, 'generic', 0, 1, NULL),
(56, 3, '34123413', 'Test', 85, 1, 0, 0, NULL, 0, 3, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_details`
--

CREATE TABLE `product_details` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `buy_price` float DEFAULT NULL,
  `date_added` datetime DEFAULT NULL,
  `manufacture_date` date DEFAULT NULL,
  `expiration_date` date DEFAULT NULL,
  `expired_status` int(11) DEFAULT 0,
  `batch` int(11) DEFAULT NULL,
  `designation` int(1) NOT NULL,
  `lot_number` varchar(20) NOT NULL,
  `lot_num` int(50) DEFAULT NULL,
  `location` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_details`
--

INSERT INTO `product_details` (`id`, `product_id`, `quantity`, `buy_price`, `date_added`, `manufacture_date`, `expiration_date`, `expired_status`, `batch`, `designation`, `lot_number`, `lot_num`, `location`) VALUES
(7, 6, 100, 20, '2023-03-16 18:18:00', '2023-03-01', '2023-12-17', 0, 1, 0, '', NULL, ''),
(9, 7, 100, 25, '2023-03-16 18:18:55', '2023-03-02', '2023-12-17', 0, 1, 0, '', NULL, ''),
(11, 8, 100, 30, '2023-03-16 18:21:39', '2023-03-16', '2023-12-17', 0, 1, 0, '', NULL, ''),
(13, 9, 100, 35, '2023-03-16 18:22:58', '2023-03-16', '2023-11-30', 0, 1, 0, '', NULL, ''),
(15, 10, 100, 20, '2023-03-16 18:25:11', '2023-03-14', '2023-12-17', 0, 1, 0, '', NULL, ''),
(17, 11, 100, 15, '2023-03-16 18:42:40', '2023-03-06', '2023-12-17', 0, 1, 0, '', NULL, ''),
(19, 12, 100, 10, '2023-03-16 18:43:33', '2023-03-05', '2024-12-17', 0, 1, 0, '', NULL, ''),
(21, 13, 100, 15, '2023-03-16 18:44:13', '2023-02-17', '2024-12-17', 0, 1, 0, '', NULL, ''),
(23, 14, 100, 15.5, '2023-03-16 18:45:19', '2023-03-08', '2023-12-17', 0, 1, 0, '', NULL, ''),
(25, 15, 100, 15, '2023-03-16 18:46:01', '2023-03-07', '2023-12-17', 0, 1, 0, '', NULL, ''),
(27, 16, 100, 10, '2023-03-16 18:47:37', '2023-03-16', '2024-12-17', 0, 1, 0, '', NULL, ''),
(29, 17, 100, 10, '2023-03-16 18:48:39', '2023-03-08', '2023-12-17', 0, 1, 0, '', NULL, ''),
(31, 18, 100, 10, '2023-03-16 18:49:21', '2023-03-13', '2023-12-17', 0, 1, 0, '', NULL, ''),
(33, 19, 100, 11.5, '2023-03-16 18:50:16', '2023-03-06', '2023-12-30', 0, 1, 0, '', NULL, ''),
(35, 20, 100, 10, '2023-03-16 18:51:46', '2023-03-15', '2024-12-17', 0, 1, 0, '', NULL, ''),
(37, 21, 100, 400, '2023-03-16 18:53:06', '2023-03-05', '2025-12-17', 0, 1, 0, '', NULL, ''),
(39, 22, 100, 100, '2023-03-16 19:12:57', '2023-03-09', '2023-12-17', 0, 1, 0, '', NULL, ''),
(41, 23, 100, 45, '2023-03-16 19:24:44', '2023-03-16', '2023-12-17', 0, 1, 0, '', NULL, ''),
(43, 24, 100, 23.5, '2023-03-16 19:25:31', '2023-03-15', '2023-12-17', 0, 1, 0, '', NULL, ''),
(45, 25, 100, 40, '2023-03-16 19:26:37', '2023-03-15', '2023-12-17', 0, 1, 0, '', NULL, ''),
(47, 26, 100, 87, '2023-03-16 19:44:37', '2023-03-16', '2023-12-17', 0, 1, 0, '', NULL, ''),
(49, 27, 100, 45, '2023-03-16 19:45:49', '2023-02-17', '2024-12-17', 0, 1, 0, '', NULL, ''),
(51, 28, 100, 34, '2023-03-16 19:47:05', '2023-03-16', '2023-11-17', 0, 1, 0, '', NULL, ''),
(53, 29, 100, 33, '2023-03-16 19:47:42', '2023-03-15', '2024-10-17', 0, 1, 0, '', NULL, ''),
(55, 30, 100, 44, '2023-03-16 19:48:24', '2023-02-17', '2024-12-17', 0, 1, 0, '', NULL, ''),
(57, 31, 100, 45, '2023-03-16 19:51:06', '2023-03-07', '2023-12-17', 0, 1, 0, '', NULL, ''),
(59, 32, 100, 43, '2023-03-16 19:51:49', '2023-02-17', '2025-12-17', 0, 1, 0, '', NULL, ''),
(61, 33, 100, 25, '2023-03-16 19:52:33', '2023-03-08', '2023-12-17', 0, 1, 0, '', NULL, ''),
(63, 34, 100, 500, '2023-03-16 19:53:18', '2023-03-15', '2023-12-17', 0, 1, 0, '', NULL, ''),
(65, 35, 100, 400, '2023-03-16 19:54:01', '2023-03-15', '2023-12-17', 0, 1, 0, '', NULL, ''),
(67, 36, 100, 10, '2023-03-16 20:11:02', '2023-03-15', '2023-12-17', 0, 1, 0, '', NULL, ''),
(69, 37, 100, 10, '2023-03-16 20:12:42', '2023-03-13', '2023-12-17', 0, 1, 0, '', NULL, ''),
(71, 38, 100, 10, '2023-03-16 20:14:18', '2023-03-06', '2023-12-17', 0, 1, 0, '', NULL, ''),
(73, 39, 100, 10, '2023-03-16 20:15:13', '2023-03-15', '2023-12-17', 0, 1, 0, '', NULL, ''),
(75, 40, 100, 12, '2023-03-16 20:16:07', '2023-03-01', '2024-11-17', 0, 1, 0, '', NULL, ''),
(77, 41, 100, 45, '2023-03-16 20:18:48', '2023-03-08', '2023-12-28', 0, 1, 0, '', NULL, ''),
(79, 42, 100, 34, '2023-03-16 20:19:34', '2023-03-13', '2023-12-17', 0, 1, 0, '', NULL, ''),
(81, 43, 100, 54, '2023-03-16 20:20:47', '2023-03-08', '2023-12-17', 0, 1, 0, '', NULL, ''),
(83, 44, 100, 45, '2023-03-16 20:21:38', '2023-02-17', '2024-09-17', 0, 1, 0, '', NULL, ''),
(85, 45, 100, 43, '2023-03-16 20:23:51', '2023-02-17', '2023-12-17', 0, 1, 0, '', NULL, ''),
(87, 56, 89, 80, '2023-06-29 14:46:07', '2023-06-28', '2023-12-29', 0, 1, 0, '', NULL, '');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `price` float DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `date_purchased` datetime DEFAULT NULL,
  `invoice_id` int(11) DEFAULT NULL,
  `product_detail_id` int(11) DEFAULT NULL,
  `void` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `trigger`
--

CREATE TABLE `trigger` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `triggered` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `role` int(1) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `login_attempt` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `username`, `password`, `role`, `status`, `last_login`, `login_attempt`) VALUES
(1, 'Jericho', 'Magsumbol', 'owner', '$2y$10$uovfGxUqgB7aaOXTlT832OEXoy52Kj1lJ6wzqchHhhnTi65937ZAS', 1, 1, '2023-07-05 09:12:33', 0),
(8, 'Iron', 'Med', 'ironmed', '$2y$10$B9qxEA8k8OXLfJj/J1xXxOdCIs5KGOpSHoWNsfWHyyvXrrpLFUjNm', 2, 1, NULL, NULL),
(9, 'Sam ', 'North', 'sammy', '$2y$10$LxG0D/blX.gLviuMi3piEuf/OyDNLGL5YdM9rngyIXIbUJBHm7ZYm', 3, 1, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `action_logs`
--
ALTER TABLE `action_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoices_FK` (`user_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_FK` (`category_id`);

--
-- Indexes for table `product_details`
--
ALTER TABLE `product_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_details_FK` (`product_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sales_FK` (`product_id`),
  ADD KEY `sales_FK_1` (`invoice_id`),
  ADD KEY `sales_FK_2` (`product_detail_id`);

--
-- Indexes for table `trigger`
--
ALTER TABLE `trigger`
  ADD PRIMARY KEY (`id`),
  ADD KEY `trigger_FK` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `action_logs`
--
ALTER TABLE `action_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=223;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `product_details`
--
ALTER TABLE `product_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `trigger`
--
ALTER TABLE `trigger`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_FK` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_FK` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Constraints for table `product_details`
--
ALTER TABLE `product_details`
  ADD CONSTRAINT `product_details_FK` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_FK` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `sales_FK_1` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`),
  ADD CONSTRAINT `sales_FK_2` FOREIGN KEY (`product_detail_id`) REFERENCES `product_details` (`id`);

--
-- Constraints for table `trigger`
--
ALTER TABLE `trigger`
  ADD CONSTRAINT `trigger_FK` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
