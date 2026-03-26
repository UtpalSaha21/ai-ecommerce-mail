-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 26, 2026 at 04:32 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ai_email_automation`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT 1,
  `status` enum('active','abandoned') DEFAULT 'active',
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `reminder_sent` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `user_id`, `product_id`, `quantity`, `status`, `last_updated`, `reminder_sent`) VALUES
(13, 1, 3, 1, 'active', '2026-03-21 21:31:11', 1),
(14, 1, 5, 1, 'active', '2026-03-21 21:31:15', 1);

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `coupon_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `code` varchar(20) DEFAULT NULL,
  `discount_percent` int(11) DEFAULT NULL,
  `expiry_date` datetime DEFAULT NULL,
  `status` varchar(20) DEFAULT 'active',
  `product_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`coupon_id`, `user_id`, `code`, `discount_percent`, `expiry_date`, `status`, `product_id`) VALUES
(1, 1, 'AI76121', 10, '2026-02-27 11:54:39', 'active', NULL),
(2, 1, 'AI53301', 10, '2026-02-27 11:54:46', 'active', NULL),
(3, 6, 'AI18686', 10, '2026-02-27 11:54:51', 'active', NULL),
(4, 6, 'AI54466', 10, '2026-03-01 09:03:21', 'active', 1),
(5, 6, 'AI19846', 10, '2026-03-01 09:03:26', 'used', 2),
(6, 1, 'AI27491', 10, '2026-03-09 20:32:27', 'used', 2),
(7, 1, 'AI57851', 10, '2026-03-23 22:31:06', 'active', 3),
(8, 1, 'AI93311', 10, '2026-03-23 22:31:11', 'active', 5);

-- --------------------------------------------------------

--
-- Table structure for table `email_logs`
--

CREATE TABLE `email_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `email_type` varchar(50) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `sent_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `email_logs`
--

INSERT INTO `email_logs` (`id`, `user_id`, `email`, `subject`, `email_type`, `status`, `sent_at`) VALUES
(1, 0, 'utpalsaha221@gmail.com', 'Purchase Confirmation', 'purchase_confirmation', 'sent', '2026-02-25 16:35:25'),
(2, 0, 'utpalsaha221@gmail.com', 'Purchase Confirmation', 'purchase_confirmation', 'sent', '2026-02-25 16:37:28'),
(3, 1, 'utpalsaha221@gmail.com', 'Purchase Confirmation', 'purchase_confirmation', 'sent', '2026-02-25 16:38:12'),
(4, 1, 'utpalsaha221@gmail.com', 'Complete Your Purchase & Get 10% OFF!', 'cart_reminder', 'sent', '2026-02-25 16:54:46'),
(5, 1, 'utpalsaha221@gmail.com', 'Complete Your Purchase & Get 10% OFF!', 'cart_reminder', 'sent', '2026-02-25 16:54:51'),
(6, 6, 'utpalsaha1085@gmail.com', 'Complete Your Purchase & Get 10% OFF!', 'cart_reminder', 'sent', '2026-02-25 16:54:57'),
(7, 1, 'utpalsaha221@gmail.com', 'Purchase Confirmation', 'purchase_confirmation', 'sent', '2026-02-25 16:57:07'),
(8, 6, 'utpalsaha1085@gmail.com', 'Complete Your Purchase & Get 10% OFF!', 'cart_reminder', 'sent', '2026-02-27 14:03:26'),
(9, 6, 'utpalsaha1085@gmail.com', 'Complete Your Purchase & Get 10% OFF!', 'cart_reminder', 'sent', '2026-02-27 14:03:30'),
(10, 6, 'utpalsaha1085@gmail.com', 'Purchase Confirmation', 'purchase_confirmation', 'sent', '2026-02-27 14:15:21'),
(11, 1, 'utpalsaha221@gmail.com', 'Purchase Confirmation', 'purchase_confirmation', 'sent', '2026-03-08 01:26:44'),
(12, 1, 'utpalsaha221@gmail.com', 'Purchase Confirmation', 'purchase_confirmation', 'sent', '2026-03-08 01:27:35'),
(13, 1, 'utpalsaha221@gmail.com', 'Complete Your Purchase & Get 10% OFF!', 'cart_reminder', 'sent', '2026-03-08 01:32:32'),
(14, 1, 'utpalsaha221@gmail.com', 'Purchase Confirmation', 'purchase_confirmation', 'sent', '2026-03-08 01:35:25'),
(15, 1, 'utpalsaha221@gmail.com', 'Purchase Confirmation', 'purchase_confirmation', 'sent', '2026-03-22 03:21:42'),
(16, 1, 'utpalsaha221@gmail.com', 'Complete Your Purchase & Get 10% OFF!', 'cart_reminder', 'sent', '2026-03-22 03:31:11'),
(17, 1, 'utpalsaha221@gmail.com', 'Complete Your Purchase & Get 10% OFF!', 'cart_reminder', 'sent', '2026-03-22 03:31:15');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` varchar(50) DEFAULT 'Pending',
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `address` text DEFAULT NULL,
  `contact_no` varchar(20) DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `total_amount`, `status`, `order_date`, `address`, `contact_no`, `payment_method`) VALUES
(1, 1, 999.99, 'Pending', '2026-02-15 21:33:59', NULL, NULL, NULL),
(2, 1, 999.99, 'Pending', '2026-02-17 20:05:24', 'dak bangla', '33546456757', 'Cash On Delivery'),
(3, 1, 2699.98, 'Processing', '2026-02-17 20:06:39', 'bl', '68557898788', 'Bkash'),
(4, 1, 999.99, 'Pending', '2026-02-19 19:03:19', 'nirala', '65675754754', 'Cash On Delivery'),
(5, 1, 999.99, 'Pending', '2026-02-19 19:05:08', 'nirala', '65675754754', 'Cash On Delivery'),
(6, 1, 999.99, 'Pending', '2026-02-19 19:06:38', 'nirala,khulna', '65675754754', 'Bkash'),
(7, 1, 999.99, 'Pending', '2026-02-19 19:10:39', 'nirala,khulna', '65675754754', 'Bkash'),
(8, 1, 999.99, 'Pending', '2026-02-19 19:12:54', 'nirala,khulna', '65675754754', 'Bkash'),
(9, 1, 999.99, 'Pending', '2026-02-19 19:14:47', 'nirala,khulna', '65675754754', 'Bkash'),
(10, 1, 999.99, 'Pending', '2026-02-19 19:15:05', 'nirala,khulna', '65675754754', 'Bkash'),
(11, 1, 999.99, 'Pending', '2026-02-19 19:17:54', 'nirala,khulna', '65675754754', 'Bkash'),
(12, 1, 999.99, 'Pending', '2026-02-19 19:18:18', 'nirala,khulna', '65675754754', 'Bkash'),
(13, 1, 999.99, 'Pending', '2026-02-25 10:35:18', 'bn', '65675754754', 'Bkash'),
(14, 1, 999.99, 'Pending', '2026-02-25 10:37:22', 'bn', '65675754754', 'Bkash'),
(15, 1, 999.99, 'Pending', '2026-02-25 10:38:06', 'bn', '65675754754', 'Bkash'),
(16, 1, 60399.97, 'Pending', '2026-02-25 10:56:59', 'gjjmjj', '42342345435', 'Cash On Delivery'),
(17, 6, 52299.98, 'Delivered', '2026-02-27 08:15:16', 'van', '65675754754', 'Bkash'),
(18, 1, 700.00, 'Processing', '2026-03-07 19:26:39', 'bg', '65675754754', 'Cash On Delivery'),
(19, 1, 56999.99, 'Pending', '2026-03-07 19:27:31', 'jj', '42342345435', 'Bkash'),
(20, 1, 51347.97, 'Pending', '2026-03-07 19:35:21', 'bghf', '42342345435', 'Cash On Delivery'),
(21, 1, 343.22, 'Pending', '2026-03-21 21:21:37', 'bagmara', '65675754754', 'Cash On Delivery');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_item_id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(1, 1, 1, 1, 999.99),
(2, 2, 1, 1, 999.99),
(3, 3, 1, 2, 999.99),
(4, 3, 3, 1, 700.00),
(5, 4, 1, 1, 999.99),
(6, 5, 1, 1, 999.99),
(7, 6, 1, 1, 999.99),
(8, 7, 1, 1, 999.99),
(9, 8, 1, 1, 999.99),
(10, 9, 1, 1, 999.99),
(11, 10, 1, 1, 999.99),
(12, 11, 1, 1, 999.99),
(13, 12, 1, 1, 999.99),
(14, 13, 1, 1, 999.99),
(15, 14, 1, 1, 999.99),
(16, 15, 1, 1, 999.99),
(17, 16, 3, 2, 700.00),
(18, 16, 2, 1, 56999.99),
(19, 16, 1, 2, 999.99),
(20, 17, 1, 1, 999.99),
(21, 17, 2, 1, 51299.99),
(22, 18, 3, 1, 700.00),
(23, 19, 2, 1, 56999.99),
(24, 20, 2, 1, 51299.99),
(25, 20, 4, 2, 23.99),
(26, 21, 1, 1, 343.22);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(150) NOT NULL,
  `image_name` varchar(255) NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `image_name`, `category`, `price`, `stock`, `created_at`) VALUES
(1, 'Pirate Hat', 'Product_Name_527.jpg', 'Apparel & Accessories', 343.22, 149, '2026-02-07 10:16:15'),
(2, 'USB Gaming Mouse', 'Product_Name_7497.png', 'Electronics', 2300.43, 70, '2026-02-07 10:17:35'),
(3, 'Smart Tv (LED)', 'Product_Name_8028.png', 'Electronics', 55499.99, 35, '2026-02-07 10:18:07'),
(4, 'Touch Screen TV', 'Product_Name_921.jpg', 'Electronics', 89999.59, 20, '2026-03-07 19:29:24'),
(5, 'Graduation Cap (Black)', 'Product_Name_8218.jpg', 'Apparel & Accessories', 613.89, 100, '2026-03-18 08:35:06'),
(6, 'Plasma Pen', 'Product_Name_1216.png', 'Health & Beauty', 5000.00, 27, '2026-03-25 20:24:56'),
(7, 'Frying Pot', 'Product_Name_493.jpg', 'Home & Garden', 355.70, 114, '2026-03-25 21:55:22'),
(8, 'Aluminium Food Tray', 'Product_Name_731.jpg', 'Home & Garden', 50.00, 45, '2026-03-26 15:15:13'),
(9, 'Lip Gloss Set', 'Product_Name_1131.jpg', 'Health & Beauty', 3500.00, 57, '2026-03-26 15:19:51'),
(10, 'Kodomo Baby Oil', 'Product_Name_117.jpg', 'Baby & Kids', 250.00, 87, '2026-03-26 15:23:07'),
(11, '1:18 RC Off Road Car Q191 Waterproof', 'Product_Name_5062.jpg', 'Baby & Kids', 4526.00, 19, '2026-03-26 15:25:27'),
(12, 'Pickleball Paddles Set Carbon Fiber Rackets', 'Product_Name_8418.jpg', 'Sports & Outdoors', 1300.00, 49, '2026-03-26 15:28:21'),
(13, 'American Football Beach Ball', 'Product_Name_4630.jpg', 'Sports & Outdoors', 798.00, 244, '2026-03-26 15:30:04');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','customer') DEFAULT 'customer',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'utpal', 'utpalsaha221@gmail.com', '25d55ad283aa400af464c76d713c07ad', 'customer', '2026-02-05 20:24:44'),
(4, 'test', 'test@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'customer', '2026-02-05 20:35:12'),
(5, 'Admin', 'admin@gmail.com', '21232f297a57a5a743894a0e4a801fc3', 'admin', '2026-02-06 13:38:59'),
(6, 'prianka', 'utpalsaha1085@gmail.com', '25d55ad283aa400af464c76d713c07ad', 'customer', '2026-02-20 09:30:37');

-- --------------------------------------------------------

--
-- Table structure for table `user_activity`
--

CREATE TABLE `user_activity` (
  `activity_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `activity_type` enum('view','cart') NOT NULL,
  `activity_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `user_activity`
--

INSERT INTO `user_activity` (`activity_id`, `user_id`, `product_id`, `activity_type`, `activity_time`) VALUES
(1, 1, 1, 'view', '2026-02-09 17:42:20'),
(2, 1, 1, 'view', '2026-02-09 17:47:24'),
(3, 1, 1, 'view', '2026-02-09 17:47:53'),
(4, 1, 1, 'view', '2026-02-09 17:52:40'),
(5, 1, 1, 'view', '2026-02-10 12:11:41'),
(6, 1, 1, 'view', '2026-02-15 21:33:03'),
(7, 1, 1, 'view', '2026-02-15 21:33:08'),
(8, 1, 1, 'cart', '2026-02-15 21:33:08'),
(9, 1, 1, 'view', '2026-02-15 21:33:15'),
(10, 1, 1, 'view', '2026-02-15 21:33:16'),
(11, 1, 1, 'view', '2026-02-15 21:33:17'),
(12, 1, 1, 'view', '2026-02-15 21:33:59'),
(13, 1, 1, '', '2026-02-15 21:33:59'),
(14, 1, 1, 'view', '2026-02-15 21:34:01'),
(15, 1, 1, 'view', '2026-02-16 10:58:55'),
(16, 1, 1, 'view', '2026-02-16 10:58:57'),
(17, 1, 1, 'cart', '2026-02-16 10:58:57'),
(18, 1, 1, 'view', '2026-02-16 10:59:06'),
(19, 1, 1, 'view', '2026-02-16 10:59:07'),
(20, 1, 1, 'view', '2026-02-16 10:59:08'),
(21, 1, 2, 'view', '2026-02-16 10:59:19'),
(22, 1, 2, 'view', '2026-02-16 10:59:20'),
(23, 1, 2, 'cart', '2026-02-16 10:59:20'),
(24, 1, 1, 'view', '2026-02-16 12:45:28'),
(25, 1, 1, 'view', '2026-02-16 12:45:31'),
(30, 1, 3, 'view', '2026-02-16 19:33:17'),
(31, 1, 3, 'view', '2026-02-16 19:33:19'),
(32, 1, 3, 'cart', '2026-02-16 19:33:19'),
(33, 1, 3, 'view', '2026-02-17 17:59:17'),
(34, 1, 1, 'view', '2026-02-17 19:54:26'),
(35, 1, 1, 'view', '2026-02-17 19:54:29'),
(36, 1, 1, '', '2026-02-17 20:05:24'),
(37, 1, 1, '', '2026-02-17 20:06:39'),
(38, 1, 3, '', '2026-02-17 20:06:39'),
(39, 1, 3, 'view', '2026-02-19 13:16:47'),
(40, 1, 3, 'view', '2026-02-19 13:17:36'),
(41, 1, 3, 'cart', '2026-02-19 13:17:36'),
(42, 1, 3, 'view', '2026-02-19 13:17:39'),
(43, 1, 2, 'view', '2026-02-19 13:17:42'),
(44, 1, 2, 'view', '2026-02-19 13:17:43'),
(45, 1, 2, 'cart', '2026-02-19 13:17:43'),
(46, 1, 2, 'view', '2026-02-19 13:17:45'),
(47, 1, 1, 'view', '2026-02-19 13:17:48'),
(48, 1, 1, 'view', '2026-02-19 13:17:52'),
(49, 1, 1, 'cart', '2026-02-19 13:17:52'),
(50, 1, 1, 'view', '2026-02-19 19:02:58'),
(51, 1, 1, '', '2026-02-19 19:03:19'),
(52, 1, 1, '', '2026-02-19 19:05:08'),
(53, 1, 1, '', '2026-02-19 19:06:38'),
(54, 1, 1, '', '2026-02-19 19:10:39'),
(55, 1, 1, '', '2026-02-19 19:12:54'),
(56, 1, 1, '', '2026-02-19 19:14:47'),
(57, 1, 1, '', '2026-02-19 19:15:05'),
(58, 1, 1, '', '2026-02-19 19:17:54'),
(59, 1, 1, '', '2026-02-19 19:18:18'),
(60, 6, 1, 'view', '2026-02-20 09:31:16'),
(61, 6, 1, 'view', '2026-02-20 09:31:18'),
(62, 6, 1, 'cart', '2026-02-20 09:31:18'),
(63, 6, 1, 'view', '2026-02-20 09:31:20'),
(64, 6, 2, 'view', '2026-02-20 09:31:24'),
(65, 6, 2, 'view', '2026-02-20 09:31:25'),
(66, 6, 2, 'cart', '2026-02-20 09:31:25'),
(67, 1, 1, 'view', '2026-02-25 10:35:03'),
(68, 1, 1, 'view', '2026-02-25 10:35:07'),
(69, 1, 1, '', '2026-02-25 10:35:18'),
(70, 1, 1, '', '2026-02-25 10:37:22'),
(71, 1, 1, '', '2026-02-25 10:38:06'),
(72, 1, 3, '', '2026-02-25 10:56:59'),
(73, 1, 2, '', '2026-02-25 10:56:59'),
(74, 1, 1, '', '2026-02-25 10:56:59'),
(75, 6, 1, '', '2026-02-27 08:15:16'),
(76, 6, 2, '', '2026-02-27 08:15:16'),
(77, 6, 3, 'view', '2026-02-28 09:07:34'),
(78, 6, 2, 'view', '2026-02-28 09:07:39'),
(79, 6, 1, 'view', '2026-02-28 09:07:41'),
(80, 6, 3, 'view', '2026-02-28 09:12:37'),
(81, 1, 3, 'view', '2026-03-07 19:25:53'),
(82, 1, 3, 'view', '2026-03-07 19:25:56'),
(83, 1, 3, 'cart', '2026-03-07 19:25:56'),
(84, 1, 3, 'view', '2026-03-07 19:26:08'),
(85, 1, 3, 'view', '2026-03-07 19:26:11'),
(86, 1, 3, 'cart', '2026-03-07 19:26:11'),
(87, 1, 3, 'view', '2026-03-07 19:26:13'),
(88, 1, 3, '', '2026-03-07 19:26:39'),
(89, 1, 2, 'view', '2026-03-07 19:27:07'),
(90, 1, 2, 'view', '2026-03-07 19:27:09'),
(91, 1, 2, 'cart', '2026-03-07 19:27:09'),
(92, 1, 1, 'view', '2026-03-07 19:27:16'),
(93, 1, 2, 'view', '2026-03-07 19:27:20'),
(94, 1, 2, 'view', '2026-03-07 19:27:22'),
(95, 1, 2, '', '2026-03-07 19:27:31'),
(96, 1, 4, 'view', '2026-03-07 19:34:00'),
(97, 1, 4, 'view', '2026-03-07 19:34:03'),
(98, 1, 4, 'cart', '2026-03-07 19:34:03'),
(99, 1, 2, '', '2026-03-07 19:35:21'),
(100, 1, 4, '', '2026-03-07 19:35:21'),
(101, 1, 3, 'view', '2026-03-07 19:35:40'),
(102, 1, 3, 'view', '2026-03-07 19:35:42'),
(103, 1, 3, 'cart', '2026-03-07 19:35:42'),
(104, 1, 4, 'view', '2026-03-07 19:35:45'),
(105, 1, 5, 'view', '2026-03-19 13:34:08'),
(106, 1, 5, 'view', '2026-03-19 13:35:15'),
(107, 1, 5, 'view', '2026-03-19 13:35:39'),
(108, 1, 5, 'view', '2026-03-19 13:35:40'),
(109, 1, 5, 'view', '2026-03-19 13:36:25'),
(110, 1, 5, 'view', '2026-03-19 13:36:36'),
(111, 1, 5, 'view', '2026-03-19 13:36:50'),
(112, 1, 5, 'view', '2026-03-19 13:37:30'),
(113, 1, 5, 'view', '2026-03-19 13:39:37'),
(114, 1, 5, 'view', '2026-03-19 13:39:41'),
(115, 1, 5, 'cart', '2026-03-19 13:39:41'),
(116, 1, 1, 'view', '2026-03-21 21:01:19'),
(117, 1, 1, 'view', '2026-03-21 21:21:09'),
(118, 1, 1, 'view', '2026-03-21 21:21:21'),
(119, 1, 1, '', '2026-03-21 21:21:37'),
(120, 1, 1, 'view', '2026-03-25 20:35:41'),
(121, 1, 6, 'view', '2026-03-25 20:40:52'),
(122, 1, 6, 'view', '2026-03-25 20:41:34'),
(123, 1, 6, 'view', '2026-03-25 20:42:09'),
(124, 1, 1, 'view', '2026-03-25 20:43:35'),
(125, 1, 1, 'view', '2026-03-25 20:43:54'),
(126, 1, 6, 'view', '2026-03-25 20:48:14'),
(127, 1, 11, 'view', '2026-03-26 15:25:54'),
(128, 1, 12, 'view', '2026-03-26 15:28:42'),
(129, 1, 13, 'view', '2026-03-26 15:31:03'),
(130, 1, 12, 'view', '2026-03-26 15:31:11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`coupon_id`);

--
-- Indexes for table `email_logs`
--
ALTER TABLE `email_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_activity`
--
ALTER TABLE `user_activity`
  ADD PRIMARY KEY (`activity_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `coupon_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `email_logs`
--
ALTER TABLE `email_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_activity`
--
ALTER TABLE `user_activity`
  MODIFY `activity_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=131;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `user_activity`
--
ALTER TABLE `user_activity`
  ADD CONSTRAINT `user_activity_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `user_activity_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
