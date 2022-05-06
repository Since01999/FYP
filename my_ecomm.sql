-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 06, 2022 at 07:49 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `my_ecomm`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `email`, `password`, `created_at`, `updated_at`) VALUES
(1, 'Admin@gmail.com', '$2y$10$kGr6YO.dR8EZEdu.K7q2PunANIhfGZaAF2ngxPqydb2RE121HhXRC', '2022-03-23 16:43:04', '2022-03-02 11:04:48');

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_home` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `name`, `image`, `is_home`, `status`, `created_at`, `updated_at`) VALUES
(5, 'Cultus', '1648134736.jpg', 1, 1, '2022-03-24 10:11:02', '2022-03-29 15:46:01'),
(6, 'Lexus', '1648135063.jpg', 1, 1, '2022-03-24 10:14:32', '2022-03-29 15:46:09'),
(7, 'Civic', '1648135290.jpg', 1, 1, '2022-03-24 10:18:17', '2022-03-29 15:46:17'),
(8, 'Ferrari', '1648305663.jpg', 1, 1, '2022-03-26 09:41:03', '2022-03-29 15:46:24');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_type` enum('Reg','Not-Reg') NOT NULL,
  `qty` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_attr_id` int(11) NOT NULL,
  `added_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `user_type`, `qty`, `product_id`, `product_attr_id`, `added_on`) VALUES
(3, 287593431, 'Not-Reg', 1, 4, 6, '2022-04-21 07:10:31'),
(4, 942696192, 'Not-Reg', 1, 3, 5, '2022-04-22 04:00:09'),
(5, 942696192, 'Not-Reg', 1, 2, 2, '2022-04-22 04:00:13'),
(6, 659923367, 'Not-Reg', 1, 2, 2, '2022-04-22 08:00:15'),
(7, 659923367, 'Not-Reg', 1, 3, 5, '2022-04-22 08:00:19'),
(11, 10, 'Reg', 1, 4, 6, '2022-04-24 05:08:22'),
(23, 119597784, 'Not-Reg', 1, 2, 2, '2022-04-27 08:10:17'),
(27, 4, 'Reg', 1, 5, 7, '2022-05-06 10:25:42'),
(28, 4, 'Reg', 5, 4, 6, '2022-05-06 05:30:21'),
(29, 4, 'Reg', 1, 3, 5, '2022-05-06 05:36:01');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_category_id` int(11) NOT NULL,
  `category_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_home` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_name`, `category_slug`, `parent_category_id`, `category_image`, `is_home`, `status`, `created_at`, `updated_at`) VALUES
(13, 'mother12', 'mother12', 20, '1648579973.jpg', 1, 1, '2022-03-02 13:52:47', '2022-04-08 22:30:21'),
(14, 'Royal', 'Royal', 20, '1648638957.jpg', 1, 1, '2022-03-03 11:26:26', '2022-04-08 22:30:18'),
(15, 'RoyalAnas', 'RoyalAnas', 20, '1648579231.jpg', 1, 1, '2022-03-03 11:31:56', '2022-03-30 06:17:02'),
(16, 'New Cat', 'new Cat1', 0, '1648278592.jpg', 0, 1, '2022-03-26 00:00:00', '2022-03-26 02:09:52'),
(19, 'Childrens', '0123', 16, '1648484360.jpg', 1, 1, '2022-03-28 11:19:20', '2022-03-28 11:19:20'),
(20, 'Social', '12221111', 0, '1648866849.jpg', 1, 1, '2022-04-01 21:34:09', '2022-04-01 21:34:09'),
(21, 'Family', '9889', 20, '1648870528.jpg', 1, 1, '2022-04-01 22:35:28', '2022-04-01 22:35:28'),
(22, 'Friends', '3233', 15, '1648870582.jpg', 1, 1, '2022-04-01 22:36:22', '2022-04-01 22:36:22'),
(23, 'Ladies', '2323232', 0, '1648870702.jpg', 1, 1, '2022-04-01 22:38:22', '2022-04-01 22:38:22');

-- --------------------------------------------------------

--
-- Table structure for table `colors`
--

CREATE TABLE `colors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `colors`
--

INSERT INTO `colors` (`id`, `color`, `status`, `created_at`, `updated_at`) VALUES
(2, 'Red', 1, '2022-03-08 07:51:57', '2022-03-08 07:51:57'),
(3, 'Green', 1, '2022-04-03 01:49:38', '2022-04-03 01:56:43'),
(4, 'Black', 1, '2022-04-03 01:49:43', '2022-04-03 01:49:43'),
(5, 'Yellow', 1, '2022-04-03 01:49:48', '2022-04-03 01:49:48'),
(6, 'Purple', 1, '2022-04-09 23:20:21', '2022-04-09 23:20:21'),
(7, 'orange', 1, '2022-04-09 23:20:29', '2022-04-09 23:20:29'),
(8, 'Blue', 1, '2022-04-09 23:21:08', '2022-04-09 23:21:08'),
(9, 'Grey', 1, '2022-04-09 23:21:28', '2022-04-09 23:21:28'),
(10, 'Pink', 1, '2022-04-09 23:21:33', '2022-04-09 23:21:33');

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('Value','Percentage') COLLATE utf8mb4_unicode_ci NOT NULL,
  `min_order_amt` int(11) NOT NULL DEFAULT 0,
  `is_one_time` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `title`, `code`, `status`, `value`, `type`, `min_order_amt`, `is_one_time`, `created_at`, `updated_at`) VALUES
(1, 'Alpha', 'B', 1, '113322', 'Value', 0, 1, NULL, '2022-03-20 02:36:47'),
(2, 'BetaGamma', 'F', 0, '12344', 'Value', 0, 0, '2022-03-03 11:51:30', '2022-03-03 12:51:57'),
(3, 'Charlie1', 'D1', 1, '1000', 'Value', 6000, 1, '2022-03-03 11:54:07', '2022-03-03 12:49:19'),
(5, 'cXenRUhQZt', 'D2', 1, '2000', 'Value', 2500, 0, '2022-03-03 11:58:02', '2022-03-03 11:58:02'),
(6, 'New Coupon', '0099', 1, '1000', 'Percentage', 0, 1, '2022-03-25 23:00:20', '2022-03-25 23:00:20'),
(7, 'New  Coupon', '12111', 1, '5000', 'Percentage', 0, 1, '2022-03-25 23:02:36', '2022-03-25 23:02:36'),
(8, 'New Coupon', '1212121', 1, '30000', 'Value', 50000, 0, '2022-03-25 23:03:43', '2022-03-25 23:04:10'),
(9, 'Test', 'ABCD', 1, '100', 'Value', 0, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gstin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL,
  `is_verify` int(11) NOT NULL,
  `is_forgot_password` int(11) NOT NULL,
  `rand_id` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `email`, `mobile`, `password`, `address`, `city`, `state`, `zip`, `company`, `gstin`, `status`, `is_verify`, `is_forgot_password`, `rand_id`, `created_at`, `updated_at`) VALUES
(2, 'Ahmad', 'ahamd@example.com', '030042323221', '1234567', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '', NULL, NULL),
(3, 'Aliyan', 'aliyan@example.com', '11111111111', '1233333', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '', '2022-04-14 01:41:23', '2022-04-14 01:41:23'),
(4, 'Arslan', 'arslan@email.com', '02220202222', 'eyJpdiI6IkpDdnB3RlRLbXlraXJzK3hsbmFYWVE9PSIsInZhbHVlIjoibW4yN2JCbU5NN2txQXZrc2g5ZldqUT09IiwibWFjIjoiYTI3MmQwODk2YmNiYzhiMmM1YWM4NWZiOGI3ZTgyMTBmYTQyZDAwMDUzOTU2ODM3ZGRmODA2ZDRiNDc0NjE1ZSIsInRhZyI6IiJ9', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, '', '2022-04-17 21:52:02', '2022-04-17 21:52:02'),
(10, 'Anas', 'anasmuhammad1211@gmail.com', '03089369091', 'eyJpdiI6Im8ybGJxT21wTEVBeHZwTEdSamtWY2c9PSIsInZhbHVlIjoiSVV5d2hmbWRxOVNlUHhBTitaSWtSdz09IiwibWFjIjoiMzkwYjMxZWIwM2IwMmVkYTliOGEwYjZlMDZjMmE2NzY2M2Y1MDViMWYyZjJkODhmN2RhZGU3NTU4NDRmOGEwYSIsInRhZyI6IiJ9', 'Multan', 'Multan', 'Punjab', '66000', NULL, NULL, 1, 1, 0, '', '2022-04-19 02:20:25', '2022-04-19 02:20:25'),
(11, 'Anas', 'anasmuhammad0909@gmail.com', '0090909090990', 'eyJpdiI6ImE3dmFGKzJlQzRxRXBqTi95anBraHc9PSIsInZhbHVlIjoiR2l0YmRyamF6QTBtdHB5eEc4QnVNdz09IiwibWFjIjoiYzYwOTBjZDY0NTg5NjJjYzk4YzIzN2JmZTUwNmE4ZTdkMDU5ZGQ2YWJjZjhhZDE1NGFlMWUyNzUzOTA4MGY5ZiIsInRhZyI6IiJ9', 'DHA Multan', 'Multan', 'Punjab', '66000', NULL, NULL, 1, 1, 0, '820677087', '2022-04-30 00:27:14', '2022-04-30 00:27:14');

-- --------------------------------------------------------

--
-- Table structure for table `home_banners`
--

CREATE TABLE `home_banners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `btn_text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `btn_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `home_banners`
--

INSERT INTO `home_banners` (`id`, `image`, `btn_text`, `btn_link`, `status`, `created_at`, `updated_at`) VALUES
(1, '1648659038.jpg', NULL, NULL, 1, '2022-03-30 11:50:38', '2022-03-30 12:22:48'),
(2, '1648659239.jpg', 'Shop Later', 'https://yahoo.com', 1, '2022-03-30 11:53:59', '2022-03-30 11:53:59'),
(3, '1648659260.jpg', 'Check this Varient', NULL, 1, '2022-03-30 11:54:20', '2022-03-30 11:54:20');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(3, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(4, '2022_03_01_154743_create_admins_table', 1),
(5, '2022_03_01_180857_create_categories_table', 2),
(6, '2022_03_03_161614_create_coupons_table', 3),
(7, '2022_03_08_104017_create_sizes_table', 4),
(10, '2022_03_08_112850_create_colors_table', 5),
(11, '2022_03_20_074338_create_products_table', 6),
(12, '2022_03_24_095138_create_brands_table', 7),
(13, '2022_03_26_051318_create_taxes_table', 8),
(14, '2022_03_26_082121_create_customers_table', 9),
(15, '2022_03_30_112429_create_home_banners_table', 10);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customers_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(50) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `pincode` int(25) NOT NULL,
  `coupon_code` varchar(50) DEFAULT NULL,
  `coupon_value` int(11) DEFAULT NULL,
  `order_status` int(11) NOT NULL,
  `payment_type` varchar(11) NOT NULL,
  `payment_status` varchar(50) NOT NULL,
  `payment_id` varchar(100) DEFAULT NULL,
  `txn_id` varchar(100) DEFAULT NULL,
  `track_details` varchar(255) DEFAULT NULL,
  `total_amount` int(11) NOT NULL,
  `added_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customers_id`, `name`, `email`, `mobile`, `address`, `city`, `state`, `pincode`, `coupon_code`, `coupon_value`, `order_status`, `payment_type`, `payment_status`, `payment_id`, `txn_id`, `track_details`, `total_amount`, `added_on`) VALUES
(24, 4, 'Arslan', 'anasmuhammad0909@gmail.com', '02220202222', 'DHA Multan', 'Multan', 'Punjab', 66000, NULL, 0, 1, 'Gateway', 'Pending', NULL, '', NULL, 9154, '2022-04-26 06:15:05'),
(25, 4, 'Arslan', 'anasmuhammad0909@gmail.com', '0222', 'Multan', 'Multan', 'Punjab', 66000, NULL, 0, 1, 'Gateway', 'Pending', NULL, NULL, NULL, 9184, '2022-04-27 07:41:11'),
(26, 4, 'Arslan', 'anasmuhammad0909@gmail.com', '0222', 'Multan', 'Multan', 'Punjab', 66000, NULL, 0, 1, 'Gateway', 'Pending', NULL, NULL, NULL, 9184, '2022-04-27 07:41:26'),
(27, 4, 'Arslan', 'anasmuhammad0909@gmail.com', '02220202222', 'DHA Multan', 'Multan', 'Punjab', 66000, NULL, 0, 1, 'Gateway', 'Pending', NULL, NULL, NULL, 9184, '2022-04-27 07:44:43'),
(28, 4, 'Arslan', 'anasmuhammad0909@gmail.com', '02220202222', 'DHA Multan', 'Multan', 'Punjab', 66000, NULL, 0, 1, 'Gateway', 'Success', 'MOJO2427G05A06520321', '267eb4896cc94649b8df5d2dd4b4cb19', NULL, 9184, '2022-04-27 07:45:37'),
(29, 4, 'Arslan', 'anasmuhammad0909@gmail.com', '02220202222', 'DHA Multan', 'Multan', 'Punjab', 66000, NULL, 0, 1, 'Gateway', 'Success', 'MOJO2427605A06520322', 'd8f7a1717c3f4e95945d2b579feae980', NULL, 30, '2022-04-27 07:48:39'),
(30, 4, 'Arslan', 'arslan@email.com', '022', 'DHA Multan', 'Multan', 'Punjab', 66000, NULL, 0, 1, 'Gateway', 'Pending', NULL, NULL, NULL, 5000, '2022-04-27 07:53:19'),
(31, 4, 'Arslan', 'anasmuhammad0909@gmail.com', 'asasasass', 'DHA Multan', 'Multan', 'assas', 66000, NULL, 0, 1, 'COD', 'Pending', NULL, NULL, NULL, 5000, '2022-04-27 08:05:03'),
(32, 4, 'Arslan', 'anasmuhammad0909@gmail.com', '02220202222', 'DHA Multan', 'Multan', 'sas', 66000, NULL, 0, 2, 'COD', 'Success', NULL, NULL, 'will  be delievered in 4 days and may be more', 30, '2022-04-27 08:05:52'),
(33, 4, 'Arslan', 'anasmuhammad0909@gmail.com', '02220202222', 'DHA Multan', 'Multan', 'sas', 66000, NULL, 0, 1, 'COD', 'Pending', NULL, NULL, NULL, 0, '2022-04-27 08:07:03'),
(34, 4, 'Arslan', 'anasmuhammad090a9@gmail.com', '02220202222', 'DHA Multan', 'Multan', 'sas', 66000, NULL, 0, 1, 'COD', 'Pending', NULL, NULL, NULL, 0, '2022-04-27 08:09:12'),
(35, 11, 'Anas', 'anasmuhammad0909@gmail.com', '0090909090990', 'DHA Multan', 'Multan', 'Punjab', 66000, NULL, 0, 1, 'Gateway', 'Pending', NULL, NULL, NULL, 5000, '2022-04-30 05:27:21'),
(36, 11, 'Anas', 'anasmuhammad0909@gmail.com', '0090909090990', 'DHA Multan', 'Multan', 'Punjab', 66000, NULL, 0, 1, 'Gateway', 'Pending', NULL, NULL, NULL, 5000, '2022-04-30 05:27:34'),
(37, 11, 'Anas', 'anasmuhammad0909@gmail.com', '0090909090990', 'DHA Multan', 'Multan', 'Punjab', 66000, NULL, 0, 1, 'COD', 'Pending', NULL, NULL, NULL, 5000, '2022-04-30 05:28:52'),
(38, 11, 'Anas', 'anasmuhammad0909@gmail.com', '0090909090990', 'DHA Multan', 'Multan', 'Punjab', 66000, NULL, 0, 1, 'Gateway', 'Pending', NULL, NULL, NULL, 0, '2022-04-30 05:29:03'),
(39, 4, 'Arslan', 'arslan@email.com', '02220202222', 'DHA Multan', 'Multan', 'Punjab', 66000, 'D2', 2000, 1, 'COD', 'Pending', NULL, NULL, NULL, 5125, '2022-05-02 12:01:31');

-- --------------------------------------------------------

--
-- Table structure for table `orders_detail`
--

CREATE TABLE `orders_detail` (
  `id` int(11) NOT NULL,
  `orders_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `products_attr_id` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders_detail`
--

INSERT INTO `orders_detail` (`id`, `orders_id`, `product_id`, `products_attr_id`, `price`, `qty`) VALUES
(1, 1, 3, 5, 5000, 1),
(2, 1, 2, 2, 30, 1),
(3, 1, 3, 5, 5000, 1),
(4, 1, 4, 6, 125, 1),
(5, 2, 3, 5, 5000, 1),
(6, 2, 2, 2, 30, 1),
(7, 2, 3, 5, 5000, 1),
(8, 2, 4, 6, 125, 1),
(9, 3, 3, 5, 5000, 1),
(10, 4, 3, 5, 5000, 1),
(11, 4, 4, 6, 125, 1),
(12, 4, 5, 7, 3999, 1),
(13, 5, 3, 5, 5000, 1),
(14, 5, 4, 6, 125, 1),
(15, 5, 5, 7, 3999, 1),
(16, 6, 3, 5, 5000, 1),
(17, 6, 4, 6, 125, 1),
(18, 6, 5, 7, 3999, 1),
(19, 7, 3, 5, 5000, 1),
(20, 7, 4, 6, 125, 1),
(21, 7, 5, 7, 3999, 1),
(22, 8, 3, 5, 5000, 1),
(23, 8, 4, 6, 125, 1),
(24, 8, 5, 7, 3999, 1),
(25, 9, 3, 5, 5000, 1),
(26, 9, 4, 6, 125, 1),
(27, 9, 5, 7, 3999, 1),
(28, 10, 3, 5, 5000, 1),
(29, 10, 4, 6, 125, 1),
(30, 10, 5, 7, 3999, 1),
(31, 11, 3, 5, 5000, 1),
(32, 11, 4, 6, 125, 1),
(33, 11, 5, 7, 3999, 1),
(34, 12, 3, 5, 5000, 1),
(35, 12, 4, 6, 125, 1),
(36, 12, 5, 7, 3999, 1),
(37, 13, 3, 5, 5000, 1),
(38, 13, 4, 6, 125, 1),
(39, 13, 5, 7, 3999, 1),
(40, 14, 3, 5, 5000, 1),
(41, 14, 4, 6, 125, 1),
(42, 14, 5, 7, 3999, 1),
(43, 15, 3, 5, 5000, 1),
(44, 15, 4, 6, 125, 1),
(45, 15, 5, 7, 3999, 1),
(46, 16, 4, 6, 125, 1),
(47, 17, 4, 6, 125, 1),
(48, 18, 4, 6, 125, 1),
(49, 19, 4, 6, 125, 1),
(50, 20, 4, 6, 125, 1),
(51, 21, 4, 6, 125, 1),
(52, 22, 3, 5, 5000, 1),
(53, 22, 4, 6, 125, 1),
(54, 22, 5, 7, 3999, 1),
(55, 23, 3, 5, 5000, 1),
(56, 23, 4, 6, 125, 1),
(57, 23, 5, 7, 3999, 1),
(58, 23, 2, 2, 30, 1),
(59, 24, 3, 5, 5000, 1),
(60, 24, 4, 6, 125, 1),
(61, 24, 5, 7, 3999, 1),
(62, 24, 2, 2, 30, 1),
(63, 25, 3, 5, 5000, 1),
(64, 25, 4, 6, 125, 1),
(65, 25, 5, 7, 3999, 1),
(66, 25, 2, 2, 30, 1),
(67, 25, 2, 2, 30, 1),
(68, 26, 3, 5, 5000, 1),
(69, 26, 4, 6, 125, 1),
(70, 26, 5, 7, 3999, 1),
(71, 26, 2, 2, 30, 1),
(72, 26, 2, 2, 30, 1),
(73, 27, 3, 5, 5000, 1),
(74, 27, 4, 6, 125, 1),
(75, 27, 5, 7, 3999, 1),
(76, 27, 2, 2, 30, 1),
(77, 27, 2, 2, 30, 1),
(78, 28, 3, 5, 5000, 1),
(79, 28, 4, 6, 125, 1),
(80, 28, 5, 7, 3999, 1),
(81, 28, 2, 2, 30, 1),
(82, 28, 2, 2, 30, 1),
(83, 29, 2, 2, 30, 1),
(84, 30, 3, 5, 5000, 1),
(85, 31, 3, 5, 5000, 1),
(86, 32, 2, 2, 30, 1),
(87, 35, 3, 5, 5000, 1),
(88, 36, 3, 5, 5000, 1),
(89, 37, 3, 5, 5000, 1),
(90, 39, 3, 5, 5000, 1),
(91, 39, 4, 6, 125, 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders_status`
--

CREATE TABLE `orders_status` (
  `id` int(11) NOT NULL,
  `orders_status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders_status`
--

INSERT INTO `orders_status` (`id`, `orders_status`) VALUES
(1, 'Placed'),
(2, 'On The Way'),
(3, 'Delivered');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `brand` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_desc` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `desc` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `keywords` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `technical_specification` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `uses` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `warranty` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `lead_time` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tax_id` int(11) NOT NULL,
  `is_promo` int(11) NOT NULL,
  `is_featured` int(11) NOT NULL,
  `is_discounted` int(11) NOT NULL,
  `is_trending` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `image`, `slug`, `brand`, `model`, `short_desc`, `desc`, `keywords`, `technical_specification`, `uses`, `warranty`, `lead_time`, `tax_id`, `is_promo`, `is_featured`, `is_discounted`, `is_trending`, `status`, `created_at`, `updated_at`) VALUES
(2, 15, 'X1uHjeWcE3', '1649483725.jpg', '92121121', '7', '2002', '<p>wasd</p>', '<p>sasa</p>', 'RXEQmLsJDh', '<p>sfsf</p>', 'WfRwTTbLZe', 'CkUMOYj1yD', '10', 2, 1, 1, 1, 1, 1, '2022-03-24 13:04:00', '2022-04-09 00:55:25'),
(3, 15, 'Shirts', '1648582008.jpg', '209', '5', '2200', '<p>this is a shitrt</p>', '<p>this is a shitrt</p>', 'this is a shitrt', '<p>this is a shitrt</p>', 'Childrens', '2 years', '20', 2, 1, 1, 1, 1, 1, '2022-03-29 14:26:48', '2022-04-03 01:31:46'),
(4, 15, 'Pents', '1648585504.jpg', '667755', '6', '2001', '<p>this is a brand</p>', '<p>this is a brand</p>', 'this is a brand', '<p>this is a brand</p>', 'this is a brand', 'this is a brand', '30', 2, 0, 1, 0, 0, 1, '2022-03-29 15:25:04', '2022-03-30 06:17:18'),
(5, 15, 'Wescoat', '1648966450.jpg', '1999', '7', '2021', '<p>Now here what you need</p>', '<p>This description is awesome</p>', '1qvAPP9dXE', '<p>Now we are good to go</p>', 'LahdXM3qpx', '3 years', '20 days', 2, 1, 1, 1, 1, 1, '2022-04-03 01:14:10', '2022-04-03 01:15:45'),
(6, 19, 'Belts', '1649228470.jpg', 'Belts', '7', '2022', '<p>This is company</p>', '<p>This is company</p>', '87kPnRglqB', '<p>This is company</p>', 'uQffG4Zxt7', '3 years', '60', 2, 1, 1, 1, 1, 1, '2022-04-06 02:01:11', '2022-04-06 02:01:11');

-- --------------------------------------------------------

--
-- Table structure for table `products_attr`
--

CREATE TABLE `products_attr` (
  `id` int(11) NOT NULL,
  `sku` varchar(255) NOT NULL,
  `attr_image` varchar(255) NOT NULL,
  `mrp` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `size_id` int(11) NOT NULL,
  `color_id` int(11) DEFAULT NULL,
  `products_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products_attr`
--

INSERT INTO `products_attr` (`id`, `sku`, `attr_image`, `mrp`, `price`, `qty`, `size_id`, `color_id`, `products_id`) VALUES
(1, '558899', ' ', 1, 1, 1, 2, 2, 1),
(2, '55889988', '8584232446.jpg', 300, 30, 3000, 4, 3, 2),
(5, '345544', '5813624636.jpg', 12202, 5000, 2, 2, 2, 3),
(6, '018', '5715500526.jpg', 998881, 125, 499, 3, 2, 4),
(7, '55888', '868778311.jpg', 3199, 3999, 199, 2, 2, 5),
(8, '1232132', '6103856418.jpg', 2999, 4999, 121212, 3, 3, 5),
(9, '2332323', '8084716062.jpg', 7999, 9999, 129, 3, 4, 5),
(10, '3434', '7067002262.jpg', 4444, 5555, 55, 4, 5, 5),
(11, '99800', '2241338709.jpg', 299, 299, 6, 0, 0, 6);

-- --------------------------------------------------------

--
-- Table structure for table `products_images`
--

CREATE TABLE `products_images` (
  `id` int(11) NOT NULL,
  `products_id` int(11) NOT NULL,
  `images` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products_images`
--

INSERT INTO `products_images` (`id`, `products_id`, `images`) VALUES
(1, 2, '4807988945.jpg'),
(4, 3, '4018779730.jpg'),
(5, 4, '1188244903.jpg'),
(6, 5, '4599131171.jpg'),
(7, 5, '990937567.jpg'),
(8, 3, '5274983540.jpg'),
(9, 5, '9491998830.jpg'),
(10, 5, '286308331.jpg'),
(11, 6, '3767369716.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `product_review`
--

CREATE TABLE `product_review` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `products_id` int(11) NOT NULL,
  `rating` varchar(20) NOT NULL,
  `review` text NOT NULL,
  `status` int(11) NOT NULL,
  `added_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_review`
--

INSERT INTO `product_review` (`id`, `customer_id`, `products_id`, `rating`, `review`, `status`, `added_on`) VALUES
(1, 4, 5, 'Very Good', 'asasaasa', 1, '2022-05-06 10:49:25'),
(2, 4, 3, 'Good', 'THis is a good Product', 1, '2022-05-06 11:20:06');

-- --------------------------------------------------------

--
-- Table structure for table `sizes`
--

CREATE TABLE `sizes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `size` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sizes`
--

INSERT INTO `sizes` (`id`, `size`, `status`, `created_at`, `updated_at`) VALUES
(2, 'XXL', 1, '2022-03-08 06:24:11', '2022-03-08 06:24:11'),
(3, 'M', 1, '2022-03-24 10:46:08', '2022-03-24 10:46:08'),
(4, 'L', 1, '2022-04-03 05:14:45', '2022-04-03 05:14:45'),
(5, 'S', 1, '2022-04-03 05:14:50', '2022-04-03 05:14:50'),
(6, 'XL', 1, '2022-04-03 05:14:56', '2022-04-03 05:14:56');

-- --------------------------------------------------------

--
-- Table structure for table `taxes`
--

CREATE TABLE `taxes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tax_desc` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tax_value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `taxes`
--

INSERT INTO `taxes` (`id`, `tax_desc`, `tax_value`, `status`, `created_at`, `updated_at`) VALUES
(2, 'GST 30%', '30', 1, '2022-03-26 00:53:20', '2022-03-26 00:53:20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `colors`
--
ALTER TABLE `colors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `home_banners`
--
ALTER TABLE `home_banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders_detail`
--
ALTER TABLE `orders_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders_status`
--
ALTER TABLE `orders_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products_attr`
--
ALTER TABLE `products_attr`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products_images`
--
ALTER TABLE `products_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_review`
--
ALTER TABLE `product_review`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sizes`
--
ALTER TABLE `sizes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `taxes`
--
ALTER TABLE `taxes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `colors`
--
ALTER TABLE `colors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `home_banners`
--
ALTER TABLE `home_banners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `orders_detail`
--
ALTER TABLE `orders_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT for table `orders_status`
--
ALTER TABLE `orders_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `products_attr`
--
ALTER TABLE `products_attr`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `products_images`
--
ALTER TABLE `products_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `product_review`
--
ALTER TABLE `product_review`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sizes`
--
ALTER TABLE `sizes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `taxes`
--
ALTER TABLE `taxes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
