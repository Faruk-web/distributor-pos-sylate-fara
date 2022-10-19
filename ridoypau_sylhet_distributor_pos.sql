-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 19, 2022 at 11:28 PM
-- Server version: 10.3.36-MariaDB
-- PHP Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ridoypau_sylhet_distributor_pos`
--

-- --------------------------------------------------------

--
-- Table structure for table `areas`
--

CREATE TABLE `areas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shop_id` int(11) NOT NULL,
  `name` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `areas`
--

INSERT INTO `areas` (`id`, `shop_id`, `name`, `note`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 221013160, 'Mirpur 10', NULL, 1, '2022-10-15 05:03:34', '2022-10-15 05:03:34'),
(2, 221013468, 'Mirpur 11', NULL, 1, '2022-10-15 08:27:33', '2022-10-15 08:27:33'),
(3, 221013341, 'Ambarkhana', NULL, 1, '2022-10-15 13:18:11', '2022-10-15 13:18:11'),
(4, 221013341, 'JogonnathPur Bazar', NULL, 1, '2022-10-17 07:10:55', '2022-10-17 07:10:55');

-- --------------------------------------------------------

--
-- Table structure for table `banks`
--

CREATE TABLE `banks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shop_id` int(11) NOT NULL,
  `bank_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank_branch` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `opening_bl` double NOT NULL,
  `balance` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banks`
--

INSERT INTO `banks` (`id`, `shop_id`, `bank_name`, `bank_branch`, `account_no`, `account_type`, `opening_bl`, `balance`, `created_at`, `updated_at`) VALUES
(1, 221013468, 'Pubali bank', 'Ambarkhana', '647656656.', 'Current', 0, 1000, NULL, NULL),
(2, 221013341, 'Pubali Bank Limited.', 'Dargagate', '1414901042867', 'Business Account', 0, 0, NULL, NULL),
(3, 221013341, 'IFIC Bank Limited.', 'Subidbazar (Modina Market)', '0200155879001', 'Business Account', 0, 0, NULL, NULL),
(4, 221013341, 'Brac Bank Limited.', 'Sylhet', '6301203994437001', 'Business Account', 0, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `barcode_printers`
--

CREATE TABLE `barcode_printers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shop_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `branch_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `printer_name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `page_width` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `page_margin_left` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `page_margin_right` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `page_margin_top` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `page_margin_bottom` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `barcode_row` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `barcode_width` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `barcode_height` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `barcode_margin_left` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `barcode_margin_right` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `barcode_margin_top` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `barcode_margin_bottom` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `column1_margin_left` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `column1_margin_right` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `column1_margin_top` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `column1_margin_bottom` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `column2_margin_left` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `column2_margin_right` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `column2_margin_top` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `column2_margin_bottom` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `column3_margin_left` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `column3_margin_right` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `column3_margin_top` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `column3_margin_bottom` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `column4_margin_left` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `column4_margin_right` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `column4_margin_top` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `column4_margin_bottom` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `column5_margin_left` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `column5_margin_right` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `column5_margin_top` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `column5_margin_bottom` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `barcode_image_height` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `text_size` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `branch_settings`
--

CREATE TABLE `branch_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shop_id` int(11) NOT NULL,
  `branch_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `branch_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `branch_phone_1` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `branch_phone_2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `branch_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vat_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vat_rate` double DEFAULT NULL,
  `discount_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `online_sell_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sell_note` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `others_charge` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sms_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `print_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `branch_settings`
--

INSERT INTO `branch_settings` (`id`, `shop_id`, `branch_name`, `branch_address`, `branch_phone_1`, `branch_phone_2`, `branch_email`, `vat_status`, `vat_rate`, `discount_type`, `online_sell_status`, `sell_note`, `others_charge`, `sms_status`, `print_by`, `created_at`, `updated_at`) VALUES
(1, 221013160, 'Mirpur Branch', 'Shah Ali plaza', '+8801627382866', NULL, 'cse.ridoypaul@gmail.com', 'no', NULL, 'no', 'no', 'no', 'no', 'no', 'no', '2022-10-15 04:50:03', NULL),
(2, 221013468, 'Godown 1', 'Themuki Sylhet Bypass', '6', NULL, NULL, 'no', NULL, 'no', 'no', 'no', 'no', 'no', 'general', '2022-10-15 08:26:55', NULL),
(3, 221013341, 'Godown 1', 'Themuki Sylhet Bypass', '01796262571', NULL, NULL, 'no', NULL, 'no', 'no', 'no', 'no', 'no', 'general', '2022-10-15 13:02:51', NULL),
(4, 221013468, 'Godown 2', 'Ambarkhana', '41563415321', NULL, NULL, 'no', NULL, 'no', 'no', 'no', 'no', 'no', 'general', '2022-10-15 14:31:54', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `branch_to_branch_transfers`
--

CREATE TABLE `branch_to_branch_transfers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shop_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `invoice_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sender_branch_id` int(11) NOT NULL,
  `receiver_branch_id` int(11) NOT NULL,
  `note` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `branch_to_branch_transfers`
--

INSERT INTO `branch_to_branch_transfers` (`id`, `shop_id`, `user_id`, `invoice_id`, `sender_branch_id`, `receiver_branch_id`, `note`, `date`, `created_at`, `updated_at`) VALUES
(1, '221013468', 5, 'BTB_T_221013468_1', 2, 4, 'Note', '2022-10-15', '2022-10-15 14:32:46', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `branch_to_branch_transfer_products`
--

CREATE TABLE `branch_to_branch_transfer_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `purchase_line_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lot_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `purchase_price` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `sales_price` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `pid` int(11) NOT NULL,
  `variation_id` int(11) NOT NULL DEFAULT 0,
  `quantity` double NOT NULL,
  `is_cartoon` double DEFAULT 0,
  `cartoon_quantity` double DEFAULT 0,
  `cartoon_amount` double DEFAULT 0,
  `discount` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no',
  `discount_amount` double NOT NULL DEFAULT 0,
  `vat_amount` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `branch_to_sr_transfered_products`
--

CREATE TABLE `branch_to_sr_transfered_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sr_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `purchase_line_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lot_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `purchase_price` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `sales_price` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `pid` int(11) NOT NULL,
  `variation_id` int(11) NOT NULL DEFAULT 0,
  `quantity` double NOT NULL,
  `is_cartoon` int(11) DEFAULT 0,
  `cartoon_quantity` double DEFAULT 0,
  `cartoon_amount` double DEFAULT 0,
  `discount` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no',
  `discount_amount` double NOT NULL DEFAULT 0,
  `vat_amount` double DEFAULT NULL,
  `date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `branch_to_sr_transfered_products`
--

INSERT INTO `branch_to_sr_transfered_products` (`id`, `invoice_id`, `sr_id`, `purchase_line_id`, `lot_number`, `purchase_price`, `sales_price`, `pid`, `variation_id`, `quantity`, `is_cartoon`, `cartoon_quantity`, `cartoon_amount`, `discount`, `discount_amount`, `vat_amount`, `date`, `created_at`, `updated_at`) VALUES
(1, 'BTSR_T_221013160_1', '6', '1', '1', '10', '20', 2, 0, 100, 1, 20, 5, 'no', 0, 0, '2022-10-15', '2022-10-15 05:05:08', '2022-10-15 05:05:08'),
(2, 'BTSR_T_221013160_1', '6', '2', '1', '50', '100', 1, 0, 200, 1, 20, 10, 'no', 0, 0, '2022-10-15', '2022-10-15 05:05:08', '2022-10-15 05:05:08'),
(3, 'BTSR_T_221013468_1', '7', '6', '1', '5.12', '6.041', 132, 0, 120, 1, 24, 5, 'flat', 50, 0, '2022-10-15', '2022-10-15 11:18:18', '2022-10-15 11:18:18'),
(4, 'BTSR_T_221013468_1', '7', '5', '1', '6.5', '8', 133, 0, 80, 1, 20, 4, 'percent', 5, 0, '2022-10-15', '2022-10-15 11:18:18', '2022-10-15 11:18:18'),
(5, 'BTSR_T_221013468_1', '7', '4', '1', '10.667', '13', 134, 0, 36, 1, 12, 3, 'no', 0, 0, '2022-10-15', '2022-10-15 11:18:18', '2022-10-15 11:18:18'),
(6, 'BTSR_T_221013468_1', '7', '3', '1', '16.3334', '20', 135, 0, 12, 1, 6, 2, 'no', 0, 0, '2022-10-15', '2022-10-15 11:18:18', '2022-10-15 11:18:18'),
(7, 'BTSR_T_221013160_2', '7', '1', '1', '10', '20', 2, 0, 80, 1, 20, 4, 'no', 0, 0, '2022-10-15', '2022-10-15 11:35:07', '2022-10-15 11:35:07'),
(8, 'BTSR_T_221013341_1', '13', '7', '1', '16.3334', '20', 6, 0, 600, 1, 6, 100, 'no', 0, 0, '2022-10-15', '2022-10-15 13:23:24', '2022-10-15 13:23:24'),
(9, 'BTSR_T_221013341_1', '13', '8', '1', '10.667', '13', 5, 0, 1200, 1, 12, 100, 'no', 0, 0, '2022-10-15', '2022-10-15 13:23:25', '2022-10-15 13:23:25'),
(10, 'BTSR_T_221013341_1', '13', '9', '1', '6.5', '8', 4, 0, 1200, 1, 20, 60, 'no', 0, 0, '2022-10-15', '2022-10-15 13:23:25', '2022-10-15 13:23:25'),
(11, 'BTSR_T_221013468_2', '14', '4', '1', '10.667', '13', 134, 0, 60, 1, 12, 5, 'no', 0, 0, '2022-10-15', '2022-10-15 13:59:42', '2022-10-15 13:59:42'),
(12, 'BTSR_T_221013468_2', '14', '3', '1', '16.3334', '20', 135, 0, 12, 1, 6, 2, 'no', 0, 0, '2022-10-15', '2022-10-15 13:59:42', '2022-10-15 13:59:42'),
(13, 'BTSR_T_221013468_3', '14', '6', '1', '5.12', '6.041', 132, 0, 240, 1, 24, 10, 'flat', 50, 0, '2022-10-16', '2022-10-16 08:46:00', '2022-10-16 08:46:00'),
(14, 'BTSR_T_221013468_3', '14', '5', '1', '6.5', '8', 133, 0, 200, 1, 20, 10, 'percent', 5, 0, '2022-10-16', '2022-10-16 08:46:00', '2022-10-16 08:46:00'),
(15, 'BTSR_T_221013468_3', '14', '4', '1', '10.667', '13', 134, 0, 120, 1, 12, 10, 'no', 0, 0, '2022-10-16', '2022-10-16 08:46:00', '2022-10-16 08:46:00'),
(16, 'BTSR_T_221013468_3', '14', '3', '1', '16.3334', '20', 135, 0, 30, 1, 6, 5, 'no', 0, 0, '2022-10-16', '2022-10-16 08:46:00', '2022-10-16 08:46:00'),
(17, 'BTSR_T_221013160_3', '6', '2', '1', '50', '100', 1, 0, 100, 1, 20, 5, 'no', 0, 0, '2022-10-16', '2022-10-16 10:00:23', '2022-10-16 10:00:23'),
(18, 'BTSR_T_221013468_4', '14', '12', '2', '10.667', '13', 134, 0, 24, 1, 12, 2, 'no', 0, 0, '2022-10-16', '2022-10-16 15:46:55', '2022-10-16 15:46:55'),
(19, 'BTSR_T_221013468_4', '14', '5', '1', '6.5', '8', 133, 0, 40, 1, 20, 2, 'percent', 5, 0, '2022-10-16', '2022-10-16 15:46:55', '2022-10-16 15:46:55'),
(20, 'BTSR_T_221013468_5', '14', '13', '2', '6.5', '8', 133, 0, 400, 1, 20, 20, 'percent', 5, 0, '2022-10-17', '2022-10-17 11:57:07', '2022-10-17 11:57:07'),
(21, 'BTSR_T_221013468_5', '14', '3', '1', '16.3334', '20', 135, 0, 30, 1, 6, 5, 'no', 0, 0, '2022-10-17', '2022-10-17 11:57:08', '2022-10-17 11:57:08'),
(22, 'BTSR_T_221013468_5', '14', '4', '1', '10.667', '13', 134, 0, 156, 1, 12, 13, 'no', 0, 0, '2022-10-17', '2022-10-17 11:57:08', '2022-10-17 11:57:08'),
(23, 'BTSR_T_221013468_5', '14', '5', '1', '6.5', '8', 133, 0, 275, 1, 20, 13.75, 'percent', 5, 0, '2022-10-17', '2022-10-17 11:57:08', '2022-10-17 11:57:08'),
(24, 'BTSR_T_221013468_5', '14', '6', '1', '5.12', '6.041', 132, 0, 240, 1, 24, 10, 'flat', 50, 0, '2022-10-17', '2022-10-17 11:57:08', '2022-10-17 11:57:08'),
(25, 'BTSR_T_221013341_2', '24', '102', '1', '67.25', '71.29', 7, 0, 108, 1, 36, 3, 'no', 0, 0, '2022-10-08', '2022-10-17 15:01:24', '2022-10-17 15:01:24'),
(26, 'BTSR_T_221013341_2', '24', '103', '1', '106', '113.5', 8, 0, 24, 1, 24, 1, 'no', 0, 0, '2022-10-08', '2022-10-17 15:01:24', '2022-10-17 15:01:24'),
(27, 'BTSR_T_221013341_2', '24', '105', '1', '67.83334', '67.7', 11, 0, 108, 1, 36, 3, 'no', 0, 0, '2022-10-08', '2022-10-17 15:01:24', '2022-10-17 15:01:24'),
(28, 'BTSR_T_221013341_2', '24', '106', '1', '67.25', '71.91', 10, 0, 108, 1, 36, 3, 'no', 0, 0, '2022-10-08', '2022-10-17 15:01:24', '2022-10-17 15:01:24'),
(29, 'BTSR_T_221013341_2', '24', '107', '1', '106', '110', 12, 0, 24, 1, 24, 1, 'no', 0, 0, '2022-10-08', '2022-10-17 15:01:24', '2022-10-17 15:01:24'),
(30, 'BTSR_T_221013341_2', '24', '108', '1', '60.3334', '63.96', 13, 0, 72, 1, 36, 2, 'no', 0, 0, '2022-10-08', '2022-10-17 15:01:24', '2022-10-17 15:01:24'),
(31, 'BTSR_T_221013341_2', '24', '109', '1', '143.75', '152.25', 14, 0, 36, 1, 12, 3, 'no', 0, 0, '2022-10-08', '2022-10-17 15:01:24', '2022-10-17 15:01:24'),
(32, 'BTSR_T_221013341_2', '24', '110', '1', '135.6667', '143.83', 15, 0, 36, 1, 12, 3, 'no', 0, 0, '2022-10-08', '2022-10-17 15:01:24', '2022-10-17 15:01:24'),
(33, 'BTSR_T_221013341_2', '24', '124', '2', '159.59', '169.25', 16, 0, 12, 1, 12, 1, 'no', 0, 0, '2022-10-08', '2022-10-17 15:01:24', '2022-10-17 15:01:24'),
(34, 'BTSR_T_221013341_2', '24', '112', '1', '70.16667', '71.96', 17, 0, 72, 1, 18, 4, 'no', 0, 0, '2022-10-08', '2022-10-17 15:01:24', '2022-10-17 15:01:24'),
(35, 'BTSR_T_221013341_2', '24', '114', '1', '104.45834', '110.72584', 19, 0, 72, 1, 24, 3, 'no', 0, 0, '2022-10-08', '2022-10-17 15:01:24', '2022-10-17 15:01:24'),
(36, 'BTSR_T_221013341_2', '24', '115', '1', '231.5834', '245.48', 20, 0, 24, 1, 12, 2, 'no', 0, 0, '2022-10-08', '2022-10-17 15:01:24', '2022-10-17 15:01:24'),
(37, 'BTSR_T_221013341_2', '24', '116', '1', '155.6667', '165.01', 21, 0, 96, 1, 12, 8, 'no', 0, 0, '2022-10-08', '2022-10-17 15:01:24', '2022-10-17 15:01:24'),
(38, 'BTSR_T_221013341_2', '24', '120', '1', '117.75', '126.93', 142, 0, 32, 1, 16, 2, 'no', 0, 0, '2022-10-08', '2022-10-17 15:01:24', '2022-10-17 15:01:24');

-- --------------------------------------------------------

--
-- Table structure for table `branch_to_s_rproducts_transfers`
--

CREATE TABLE `branch_to_s_rproducts_transfers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shop_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `invoice_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sender_branch_id` int(11) NOT NULL,
  `sr_id` int(11) NOT NULL,
  `total_gross` double NOT NULL DEFAULT 0,
  `note` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `branch_to_s_rproducts_transfers`
--

INSERT INTO `branch_to_s_rproducts_transfers` (`id`, `shop_id`, `user_id`, `invoice_id`, `sender_branch_id`, `sr_id`, `total_gross`, `note`, `date`, `created_at`, `updated_at`) VALUES
(1, '221013160', 1, 'BTSR_T_221013160_1', 1, 6, 0, 'Note', '2022-10-15', '2022-10-15 05:05:08', NULL),
(2, '221013468', 5, 'BTSR_T_221013468_1', 2, 7, 0, 'for delivery', '2022-10-15', '2022-10-15 11:18:18', NULL),
(3, '221013160', 1, 'BTSR_T_221013160_2', 1, 7, 0, 'Note', '2022-10-15', '2022-10-15 11:35:07', NULL),
(4, '221013341', 4, 'BTSR_T_221013341_1', 3, 13, 0, 'Note', '2022-10-15', '2022-10-15 13:23:24', NULL),
(5, '221013468', 5, 'BTSR_T_221013468_2', 2, 14, 0, 'Note', '2022-10-15', '2022-10-15 13:59:42', NULL),
(6, '221013468', 5, 'BTSR_T_221013468_3', 2, 14, 0, 'Note', '2022-10-16', '2022-10-16 08:46:00', NULL),
(7, '221013160', 1, 'BTSR_T_221013160_3', 1, 6, 0, 'Note', '2022-10-16', '2022-10-16 10:00:23', NULL),
(8, '221013468', 5, 'BTSR_T_221013468_4', 2, 14, 0, 'Note', '2022-10-16', '2022-10-16 15:46:55', NULL),
(9, '221013468', 5, 'BTSR_T_221013468_5', 2, 14, 0, 'Note', '2022-10-17', '2022-10-17 11:57:07', NULL),
(10, '221013341', 4, 'BTSR_T_221013341_2', 3, 24, 0, 'Note', '2022-10-08', '2022-10-17 15:01:24', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shop_id` int(11) NOT NULL,
  `brand_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `shop_id`, `brand_name`, `active`, `created_at`, `updated_at`) VALUES
(1, 221013160, 'Walton', 1, '2022-10-15 04:46:42', NULL),
(2, 221013160, 'Samsung', 1, '2022-10-15 04:47:12', NULL),
(3, 221013341, 'Britannia Food & Beverage Ltd..', 1, '2022-10-15 09:52:55', NULL),
(4, 221013341, 'Green 9 Company Ltd.', 1, '2022-10-15 09:52:55', NULL),
(5, 221013341, 'Gazi Brand Power Mosquito Coil', 1, '2022-10-15 09:52:55', NULL),
(6, 221013341, 'Olympic Industries Ltd.', 1, '2022-10-15 09:52:55', NULL),
(7, 221013341, 'Pran Mr.Mango', 1, '2022-10-15 09:52:55', NULL),
(8, 221013341, 'Star Line Food Products Ltd.', 1, '2022-10-15 09:52:55', NULL),
(9, 221013468, 'Britannia Food & Beverage Ltd..', 1, '2022-10-15 10:52:53', NULL),
(10, 221013468, 'Green 9 Company Ltd.', 1, '2022-10-15 10:52:53', NULL),
(11, 221013468, 'Gazi Brand Power Mosquito Coil', 1, '2022-10-15 10:52:54', NULL),
(12, 221013468, 'Olympic Industries Ltd.', 1, '2022-10-15 10:52:54', NULL),
(13, 221013468, 'Pran Mr.Mango', 1, '2022-10-15 10:52:54', NULL),
(14, 221013468, 'Star Line Food Products Ltd.', 1, '2022-10-15 10:52:54', NULL),
(15, 221013341, 'Akij Food', 1, '2022-10-17 10:40:44', '2022-10-17 10:40:56');

-- --------------------------------------------------------

--
-- Table structure for table `business_renews`
--

CREATE TABLE `business_renews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shop_id` int(11) NOT NULL,
  `renew_by` int(11) NOT NULL,
  `amount` double DEFAULT NULL,
  `paymentBy` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `renew_date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `capital_transactions`
--

CREATE TABLE `capital_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `voucher_num` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shop_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `add_or_withdraw` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cash_or_cheque` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` double NOT NULL,
  `bank_id` int(11) DEFAULT NULL,
  `account_num` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cheque_num` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `owner_bank_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cheque_diposite_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cheque_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `capital_transactions`
--

INSERT INTO `capital_transactions` (`id`, `voucher_num`, `shop_id`, `user_id`, `owner_id`, `add_or_withdraw`, `cash_or_cheque`, `amount`, `bank_id`, `account_num`, `cheque_num`, `owner_bank_name`, `cheque_diposite_date`, `cheque_date`, `note`, `created_at`, `updated_at`) VALUES
(1, 'CA221013341_1', 221013341, 4, 2, 'ADD', 'cash', 400000, NULL, NULL, NULL, NULL, NULL, NULL, 'Rin Newa Nessa', '2022-09-30 18:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cash_flows`
--

CREATE TABLE `cash_flows` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shop_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `account` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `credit_or_debit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `balance` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shop_id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `cat_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `shop_id`, `parent_id`, `cat_name`, `active`, `created_at`, `updated_at`) VALUES
(1, 221013160, NULL, 'Drinks', 1, '2022-10-15 04:46:49', NULL),
(2, 221013160, NULL, 'food', 1, '2022-10-15 04:47:17', NULL),
(3, 221013341, NULL, 'Britannia', 1, '2022-10-15 09:53:32', '2022-10-17 07:21:08'),
(4, 221013341, NULL, 'Olympic', 1, '2022-10-15 09:53:32', '2022-10-17 07:21:32'),
(5, 221013468, NULL, 'Water', 1, '2022-10-15 10:53:21', NULL),
(6, 221013468, NULL, 'Food', 1, '2022-10-15 10:53:21', NULL),
(7, 221013341, NULL, 'Gazi', 1, '2022-10-17 07:21:47', NULL),
(8, 221013341, NULL, 'Pran', 1, '2022-10-17 10:41:32', NULL),
(9, 221013341, NULL, 'Star line', 1, '2022-10-17 10:41:57', NULL),
(10, 221013341, NULL, 'Green 9', 1, '2022-10-17 10:42:13', NULL),
(11, 221013341, NULL, 'Akij', 1, '2022-10-17 10:42:31', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `contras`
--

CREATE TABLE `contras` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `voucher_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shop_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `CTB_or_BTC` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sender` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `receiver` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contra_amount` double NOT NULL,
  `note` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contras`
--

INSERT INTO `contras` (`id`, `voucher_number`, `shop_id`, `user_id`, `CTB_or_BTC`, `sender`, `receiver`, `contra_amount`, `note`, `created_at`, `updated_at`) VALUES
(1, 'CONTRA221013468_1', 221013468, 5, 'CTB', 'cash', '1', 1000, NULL, '2022-10-15 18:00:00', NULL),
(2, 'CONTRA221013468_2', 221013468, 5, 'CTB', 'cash', '1', 2000, '202331', '2022-10-15 18:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shop_id` int(11) NOT NULL,
  `area_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customers_type_id` int(11) DEFAULT NULL,
  `opening_bl` double DEFAULT NULL,
  `is_comissioned` double DEFAULT NULL,
  `balance` double DEFAULT NULL,
  `wallets` double DEFAULT NULL,
  `wallet_balance` double DEFAULT NULL,
  `active` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `shop_id`, `area_id`, `branch_id`, `code`, `name`, `email`, `phone`, `address`, `customers_type_id`, `opening_bl`, `is_comissioned`, `balance`, `wallets`, `wallet_balance`, `active`, `created_at`, `updated_at`) VALUES
(1, 221013160, 1, 1, 'C221013160S1', 'Ridoy Paul', 'cse.ridoypaul@gmail.com', '01627382866', 'Shah Ali plaza', NULL, 0, NULL, 800, NULL, NULL, 1, '2022-10-15 05:03:54', NULL),
(2, 221013468, 2, NULL, 'C221013468S1', 'da', NULL, '63556346000', NULL, NULL, 0, NULL, 0, NULL, NULL, 1, '2022-10-15 08:27:55', NULL),
(3, 221013468, 2, NULL, 'C221013468S3', 'q', NULL, '01236547890', NULL, NULL, 0, NULL, 0, NULL, NULL, 1, '2022-10-15 08:29:20', NULL),
(4, 221013468, 2, NULL, 'C221013468S4', 'qw', NULL, '10235478965', NULL, NULL, 0, NULL, 0, NULL, NULL, 1, '2022-10-15 10:54:48', NULL),
(5, 221013468, 2, NULL, 'C221013468S5', 'q', NULL, '563.4563456', NULL, NULL, 0, NULL, 0, NULL, NULL, 1, '2022-10-15 11:21:11', NULL),
(6, 221013468, 2, NULL, 'C221013468S6', 'j', NULL, '41563435646', NULL, NULL, 0, NULL, 187.4, NULL, NULL, 1, '2022-10-15 11:30:14', NULL),
(7, 221013468, 2, NULL, 'C221013468S7', 'rtyhj', NULL, '23545345345', NULL, NULL, 0, NULL, 0, NULL, NULL, 1, '2022-10-15 11:38:03', NULL),
(8, 221013468, 2, NULL, 'C221013468S8', 'Saju Paul', NULL, '1586320123', NULL, NULL, 0, NULL, 0, NULL, NULL, 1, '2022-10-15 11:51:17', NULL),
(9, 221013468, 2, NULL, 'C221013468S9', 'Saju Paul', NULL, '01325876846', NULL, NULL, 0, NULL, 0, NULL, NULL, 1, '2022-10-15 13:45:32', NULL),
(10, 221013468, 2, NULL, 'C221013468S10', 'Mahfuj', NULL, '2316456456', NULL, NULL, 0, NULL, 0, NULL, NULL, 1, '2022-10-15 13:53:56', NULL),
(11, 221013468, 2, NULL, 'C221013468S11', 'g', NULL, '23545345341', NULL, NULL, 0, NULL, 0, NULL, NULL, 1, '2022-10-16 08:45:16', NULL),
(12, 221013468, 2, NULL, 'C221013468S12', 'qwe', NULL, '01258964210', NULL, NULL, 0, NULL, 20, NULL, NULL, 1, '2022-10-16 10:52:16', NULL),
(13, 221013468, 2, NULL, 'C221013468S13', 'w', NULL, 'a', NULL, NULL, 0, NULL, 0, NULL, NULL, 1, '2022-10-16 13:51:39', NULL),
(14, 221013468, 2, NULL, 'C221013468S14', 'a', NULL, '4225425204', NULL, NULL, 0, NULL, 0, NULL, NULL, 1, '2022-10-16 13:52:31', NULL),
(15, 221013468, 2, NULL, 'C221013468S15', 'jhg', NULL, '01234578940', NULL, NULL, 0, NULL, 0, NULL, NULL, 1, '2022-10-16 15:47:43', NULL),
(16, 221013341, 4, 3, 'C221013341S1', 'M/s Luknath Veraties Store', NULL, '01725348568', 'Jogonnathpur Bazar', NULL, 0, NULL, -616.17952000002, NULL, NULL, 1, '2022-10-17 07:15:55', '2022-10-17 16:37:59'),
(17, 221013468, 2, NULL, 'C221013468S16', 'mesba', NULL, '16565656561', NULL, NULL, 0, NULL, 0, NULL, NULL, 1, '2022-10-17 11:57:32', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customer_types`
--

CREATE TABLE `customer_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shop_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `damage_products`
--

CREATE TABLE `damage_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shop_id` int(11) NOT NULL,
  `purchase_line_id` int(11) DEFAULT NULL,
  `lot_number` int(11) DEFAULT NULL,
  `branch_id` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `variation_id` int(11) NOT NULL DEFAULT 0,
  `quantity` double NOT NULL,
  `is_cartoon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `cartoon_quantity` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `cartoon_amount` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `purchase_price` double NOT NULL,
  `selling_price` double NOT NULL,
  `discount` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no',
  `discount_amount` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `vat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `reason` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` date NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `damage_products`
--

INSERT INTO `damage_products` (`id`, `shop_id`, `purchase_line_id`, `lot_number`, `branch_id`, `pid`, `variation_id`, `quantity`, `is_cartoon`, `cartoon_quantity`, `cartoon_amount`, `purchase_price`, `selling_price`, `discount`, `discount_amount`, `vat`, `reason`, `date`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 221013468, 10, 2, 2, 132, 0, 1, '1', '24', '0.04', 5.12, 6.041, 'flat', '50', '0', 'nosto', '2022-10-16', 5, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `expense_groups`
--

CREATE TABLE `expense_groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `parent` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `group_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `group_under` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `expense_groups`
--

INSERT INTO `expense_groups` (`id`, `parent`, `group_name`, `group_under`, `created_at`, `updated_at`) VALUES
(1, 'current asset', 'bank account', 'assets', NULL, NULL),
(2, 'current asset', 'cash in hand', 'assets', NULL, NULL),
(3, 'current asset', 'closing stock', 'assets', NULL, NULL),
(4, 'current asset', 'sundry debtors', 'assets', NULL, NULL),
(5, 'current asset', 'deposit', 'assets', NULL, NULL),
(6, 'current asset', 'investment', 'assets', NULL, NULL),
(7, 'current asset', 'fixed assets', 'assets', NULL, NULL),
(8, 'liabilities', 'loans', 'liabilities', NULL, NULL),
(9, '', 'bank O/D account', 'liabilities', NULL, NULL),
(10, '', 'capital account', 'liabilities', NULL, NULL),
(11, '', 'sundry creditors', 'liabilities', NULL, NULL),
(12, '', 'direct incomes', 'CR', NULL, NULL),
(13, '', 'direct expenses', 'DR', NULL, NULL),
(14, '', 'indirect incomes', 'CR', NULL, NULL),
(15, '', 'indirect expenses', 'DR', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `expense_transactions`
--

CREATE TABLE `expense_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `voucher_num` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shop_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `ledger_head` int(11) NOT NULL,
  `cash_or_cheque` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` double NOT NULL,
  `bank_id` int(11) DEFAULT NULL,
  `cheque_num` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cheque_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `voucher` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `expense_transactions`
--

INSERT INTO `expense_transactions` (`id`, `voucher_num`, `shop_id`, `user_id`, `ledger_head`, `cash_or_cheque`, `amount`, `bank_id`, `cheque_num`, `cheque_date`, `voucher`, `file`, `note`, `created_at`, `updated_at`) VALUES
(1, 'E221013160_1', 221013160, 1, 1, 'cash', 100, NULL, NULL, NULL, NULL, '', NULL, '2022-10-15 18:00:00', NULL),
(2, 'E221013160_2', 221013160, 1, 2, 'cash', 100, NULL, NULL, NULL, 'STAFF_SALARY', NULL, 'Salary Paid to Staff. Staff name: Abir', '2022-10-15 18:00:00', NULL),
(3, 'E221013160_3', 221013160, 1, 2, 'cash', 100, NULL, NULL, NULL, 'STAFF_SALARY', NULL, 'Salary Paid to Staff. Staff name: Abir', '2022-10-15 18:00:00', NULL),
(4, 'E221013160_4', 221013160, 1, 2, 'cash', 750, NULL, NULL, NULL, 'STAFF_SALARY', NULL, 'Salary Paid to Staff. Staff name: Abir', '2022-10-15 18:00:00', NULL),
(5, 'E221013468_1', 221013468, 5, 3, 'cash', 1000, NULL, NULL, NULL, 'STAFF_SALARY', NULL, 'Salary Paid to Staff. Staff name: Saju Paul', '2022-10-15 18:00:00', NULL),
(6, 'E221013468_2', 221013468, 5, 3, 'cash', 1000, NULL, NULL, NULL, 'STAFF_SALARY', NULL, 'Salary Paid to Staff. Staff name: Fahid', '2022-10-15 18:00:00', NULL),
(7, 'E221013160_5', 221013160, 1, 2, 'cash', 100, NULL, NULL, NULL, 'STAFF_SALARY', NULL, 'Salary Paid to Staff. Staff name: Abir', '2022-10-15 18:00:00', NULL),
(8, 'E221013468_3', 221013468, 5, 3, 'cash', 1000, NULL, NULL, NULL, 'STAFF_SALARY', NULL, 'Salary Paid to Staff. Staff name: Fahid', '2022-10-15 18:00:00', NULL),
(9, 'E221013160_6', 221013160, 1, 2, 'cash', 100, NULL, NULL, NULL, 'STAFF_SALARY', NULL, 'Salary Paid to Staff. Staff name: Abir', '2022-10-15 18:00:00', NULL),
(10, 'E221013160_7', 221013160, 1, 2, 'cash', 100, NULL, NULL, NULL, 'STAFF_SALARY', NULL, 'Salary Paid to Staff. Staff name: Abir', '2022-10-15 18:00:00', NULL),
(11, 'E221013468_4', 221013468, 5, 3, 'cash', 1000, NULL, NULL, NULL, 'STAFF_SALARY', NULL, 'Salary Paid to Staff. Staff name: Fahid', '2022-10-15 18:00:00', NULL),
(12, 'E221013468_5', 221013468, 5, 5, 'cash', 1000, NULL, NULL, NULL, NULL, '', NULL, '2022-10-15 18:00:00', NULL),
(13, 'E221013468_6', 221013468, 5, 7, 'cash', 1000, NULL, NULL, NULL, NULL, '', NULL, '2022-10-15 18:00:00', NULL),
(14, 'E221013468_7', 221013468, 5, 3, 'cash', 1000, NULL, NULL, NULL, 'STAFF_SALARY', NULL, 'Salary Paid to Staff. Staff name: Saju Paul', '2022-10-15 18:00:00', NULL),
(15, 'E221013468_8', 221013468, 5, 9, 'cash', 1000, NULL, NULL, NULL, NULL, '', NULL, '2022-10-15 18:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `godown_stock_out_invoices`
--

CREATE TABLE `godown_stock_out_invoices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shop_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `invoice_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `branch_id` int(11) NOT NULL,
  `note` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `indirect_incomes`
--

CREATE TABLE `indirect_incomes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `voucher_num` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shop_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `ledger_head` int(11) NOT NULL,
  `cash_or_cheque` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` double NOT NULL DEFAULT 0,
  `bank_id` int(11) DEFAULT NULL,
  `cheque_or_mfs_acc_num` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cheque_or_mfs_acc_bank` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cheque_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cheque_deposit_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ledger__heads`
--

CREATE TABLE `ledger__heads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shop_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `head_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_edit` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ledger__heads`
--

INSERT INTO `ledger__heads` (`id`, `shop_id`, `group_id`, `head_name`, `is_edit`, `created_at`, `updated_at`) VALUES
(1, 221013160, 13, 'Staff Salary', 1, '2022-10-15 06:57:32', NULL),
(2, 221013160, 13, 'all staff salary', 1, '2022-10-16 12:42:12', '2022-10-16 12:42:12'),
(3, 221013468, 13, 'all staff salary', 0, '2022-10-16 12:59:21', '2022-10-16 12:59:21'),
(4, 221013341, 13, 'Daily Expense', 1, '2022-10-16 13:39:07', NULL),
(5, 221013468, 13, 'Daily Expense', 1, '2022-10-16 13:39:45', NULL),
(6, 221013468, 13, 'Office Rent', 1, '2022-10-16 13:40:04', NULL),
(7, 221013468, 13, 'Vehicle Rent', 1, '2022-10-16 13:40:17', NULL),
(8, 221013468, 13, 'Internet Bill', 1, '2022-10-16 16:19:54', NULL),
(9, 221013468, 13, 'Monthly Expense', 1, '2022-10-16 16:20:09', NULL),
(10, 221013341, 13, 'Office Rent', 1, '2022-10-17 17:21:08', '2022-10-17 17:21:49'),
(11, 221013341, 13, 'Monthly Bill', 1, '2022-10-17 17:23:29', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `loan_people`
--

CREATE TABLE `loan_people` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shop_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `opening_balance` double NOT NULL,
  `balance` double NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `loan_people`
--

INSERT INTO `loan_people` (`id`, `shop_id`, `name`, `phone`, `email`, `address`, `opening_balance`, `balance`, `created_at`, `updated_at`) VALUES
(1, 221013468, 'IBBl', '58745', NULL, NULL, 0, 9000, '2022-10-16 09:14:22', NULL),
(2, 221013341, 'Brac Bank Limited.', '01709819697', NULL, 'Sylhet Brunch', 0, 0, '2022-10-17 05:43:23', NULL),
(3, 221013341, 'Rangs Motors Ltd.', '01993338081', 'bidduthsenmc@gmail.com', 'Humaun Chattor Sylhet-3100', 0, 0, '2022-10-17 17:57:48', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `loan_transactions`
--

CREATE TABLE `loan_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `voucher_num` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shop_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `lender_id` int(11) NOT NULL,
  `paid_or_received` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cash_or_cheque` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` double NOT NULL DEFAULT 0,
  `bank_id` int(11) DEFAULT NULL,
  `account_num` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cheque_num` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lender_bank_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cheque_diposite_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cheque_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `loan_transactions`
--

INSERT INTO `loan_transactions` (`id`, `voucher_num`, `shop_id`, `user_id`, `lender_id`, `paid_or_received`, `cash_or_cheque`, `amount`, `bank_id`, `account_num`, `cheque_num`, `lender_bank_name`, `cheque_diposite_date`, `cheque_date`, `note`, `created_at`, `updated_at`) VALUES
(1, 'LR221013468_1', 221013468, 5, 1, 'RECEIVE', 'cash', 10000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-10-15 18:00:00', NULL),
(2, 'LP221013468_2', 221013468, 5, 1, 'PAID', 'cash', 1000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-10-15 18:00:00', NULL);

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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2014_10_12_200000_add_two_factor_columns_to_users_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2021_08_25_060238_create_sessions_table', 1),
(7, '2021_08_25_071356_create_shop_settings_table', 1),
(8, '2021_08_25_072515_create_branch_settings_table', 1),
(9, '2021_08_25_073840_create_customers_table', 1),
(10, '2021_08_25_075112_create_categories_table', 1),
(11, '2021_08_25_075246_create_brands_table', 1),
(12, '2021_08_25_075349_create_unit_types_table', 1),
(13, '2021_08_25_075523_create_products_table', 1),
(14, '2021_08_25_081219_create_damage_products_table', 1),
(15, '2021_08_25_082042_create_orders_table', 1),
(16, '2021_08_25_092920_create_ordered_products_table', 1),
(17, '2021_08_25_093521_create_return_orders_table', 1),
(18, '2021_08_25_095123_create_order_return_porducts_table', 1),
(19, '2021_08_25_095325_create_product_trackers_table', 1),
(20, '2021_08_25_100014_create_suppliers_table', 1),
(21, '2021_08_25_100329_create_supplier_invoices_table', 1),
(22, '2021_08_25_102810_create_supplier_inv_returns_table', 1),
(23, '2021_08_25_103234_create_supplier_return_products_table', 1),
(24, '2021_08_25_103814_create_banks_table', 1),
(25, '2021_08_25_105226_create_net_cash_bls_table', 1),
(26, '2021_08_25_105925_create_sms_table', 1),
(27, '2021_08_25_110229_create_tutorials_table', 1),
(28, '2021_08_28_044317_create_permission_tables', 1),
(29, '2021_09_18_165143_create_product_stocks_table', 1),
(30, '2021_09_19_174836_create_moments_traffics_table', 1),
(31, '2021_09_22_164136_add_vat_status_to_products_table', 1),
(32, '2021_09_23_073419_create_godown_stock_out_invoices_table', 1),
(33, '2021_09_29_065218_add_vat_type_to_shop_settings', 1),
(34, '2021_09_29_065606_add_address_to_shop_settings', 1),
(35, '2021_10_05_051817_create_cash_flows_table', 1),
(36, '2021_10_06_063754_create_take_customer_dues_table', 1),
(37, '2021_10_16_115001_create_supplier_payments_table', 1),
(38, '2021_10_17_052112_create_transactions_table', 1),
(39, '2021_10_17_101113_add_voucher_num_to_take_customer_dues_table', 1),
(40, '2021_10_17_112109_create_contras_table', 1),
(41, '2021_10_18_110041_create_loan_people_table', 1),
(42, '2021_10_19_145938_create_loan_transactions_table', 1),
(43, '2021_10_25_071707_create_owners_table', 1),
(44, '2021_10_25_085844_create_capital_transactions_table', 1),
(45, '2021_10_26_044241_create_expense_groups_table', 1),
(46, '2021_10_26_053259_create_ledger__heads_table', 1),
(47, '2021_10_26_065045_create_expense_transactions_table', 1),
(48, '2021_11_04_092552_create_customer_types_table', 1),
(49, '2021_11_06_061534_add_new_column_to_customers_table', 1),
(50, '2021_11_06_094133_add_new_column_to_shop_settings_table', 1),
(51, '2021_11_07_064333_add_cash_or_bank_to_transactions_table', 1),
(52, '2021_11_08_115641_add_point_earn_rate_to_shop_settings_table', 1),
(53, '2021_11_08_124353_add_wallets_into_customers_table', 1),
(54, '2021_11_23_062354_add_return_place_to_supplier_return_products_table', 1),
(55, '2021_12_02_052909_add_print_by_to_branch_settings_table', 1),
(56, '2021_12_08_092255_create_s_m_s_settings_table', 1),
(57, '2021_12_08_093050_create_sms_histories_table', 1),
(58, '2021_12_08_093643_create_sms_recharge_requests_table', 1),
(59, '2021_12_08_095517_add_sms_limit_and_sms_status_into_shop_settings', 1),
(60, '2021_12_14_064650_create_indirect_incomes_table', 1),
(61, '2022_01_01_075509_create_business_renews_table', 1),
(62, '2022_01_17_115527_add_reseller_id_to_shop_settings', 1),
(63, '2022_02_16_133647_add_is_edit_to_ledger__heads_table', 1),
(64, '2022_02_16_134155_add_discount_status_to_supplier_invoices_table', 1),
(65, '2022_02_17_181431_add_total_discount_amount_to_supplier_invoices', 1),
(66, '2022_02_28_152359_create_barcode_printers_table', 1),
(67, '2022_03_05_123507_add_extra_column_to_sms_histories_table', 1),
(68, '2022_04_03_114200_create_purchase_lines_table', 1),
(69, '2022_04_03_121429_add_alert_quentity_into_products_table', 1),
(70, '2022_04_03_124548_add_purchase_price_and_lot_number_into_supplier_return_products', 1),
(71, '2022_04_03_131249_add_purchase_price_and_lot_number_into_damage_products', 1),
(72, '2022_05_11_132632_create_product_variations_table', 1),
(73, '2022_05_11_133155_create_variation_lists_table', 1),
(74, '2022_06_20_182127_create_product_with_variations_table', 1),
(75, '2022_06_28_155744_create_point_redeem_infos_table', 1),
(76, '2022_07_09_111422_create_multiple_payments_table', 1),
(77, '2022_10_01_172625_create_areas_table', 1),
(78, '2022_10_03_164113_create_branch_to_branch_transfers_table', 1),
(79, '2022_10_03_171829_create_branch_to_branch_transfer_products_table', 1),
(80, '2022_10_05_162940_create_s_r_stocks_table', 1),
(81, '2022_10_05_163458_create_branch_to_s_rproducts_transfers_table', 1),
(82, '2022_10_05_174853_create_branch_to_sr_transfered_products_table', 1),
(83, '2022_10_12_110037_create_sr_to_branch_transfers_table', 1),
(84, '2022_10_12_110334_create_sr_to_branch_transfer_products_table', 1),
(85, '2022_10_12_112036_create_staff_in_out_details_table', 1),
(86, '2022_10_12_112223_create_staff_daily_attendences_table', 1),
(87, '2022_10_15_125956_create_staff_salleries_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 22);

-- --------------------------------------------------------

--
-- Table structure for table `moments_traffics`
--

CREATE TABLE `moments_traffics` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shop_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `info` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `moments_traffics`
--

INSERT INTO `moments_traffics` (`id`, `shop_id`, `user_id`, `info`, `created_at`, `updated_at`) VALUES
(1, '221013160', 1, 'Logged In. IP Address: 127.0.0.1', '2022-10-13 12:36:30', NULL),
(2, '221013160', 1, 'Want to logged in, but due to deactivation can not logged in.', '2022-10-13 12:36:58', NULL),
(3, '221013160', 1, 'Logged In. IP Address: 103.49.203.92', '2022-10-13 13:00:40', NULL),
(4, '221013169', 3, 'Logged In. IP Address: 103.242.23.181', '2022-10-13 16:57:31', NULL),
(5, '221013169', 3, 'Logged In. IP Address: 103.242.23.181', '2022-10-13 16:58:09', NULL),
(6, '221013341', 4, 'Logged In. IP Address: 103.242.23.181', '2022-10-13 17:02:24', NULL),
(7, '221013341', 4, 'Want to logged in, but due to deactivation can not logged in.', '2022-10-13 17:02:24', NULL),
(8, '221013169', 3, 'Logged In. IP Address: 103.242.23.181', '2022-10-13 17:02:35', NULL),
(9, '221013341', 4, 'Logged In. IP Address: 182.48.89.164', '2022-10-13 17:03:42', NULL),
(10, '221013468', 5, 'Logged In. IP Address: 103.242.23.181', '2022-10-13 17:04:24', NULL),
(11, '221013468', 5, 'Want to logged in, but due to deactivation can not logged in.', '2022-10-13 17:04:24', NULL),
(12, '221013169', 3, 'Logged In. IP Address: 103.242.23.181', '2022-10-13 17:04:31', NULL),
(13, '221013468', 5, 'Logged In. IP Address: 182.48.89.164', '2022-10-13 17:07:48', NULL),
(14, '221013341', 4, 'Logged In. IP Address: 182.48.89.164', '2022-10-13 17:17:38', NULL),
(15, '221013341', 4, 'Logged In. IP Address: 182.48.89.164', '2022-10-13 17:37:27', NULL),
(16, '221013341', 4, 'Logged In. IP Address: 182.48.89.164', '2022-10-13 17:41:39', NULL),
(17, '221013468', 5, 'Logged In. IP Address: 182.48.89.164', '2022-10-13 18:00:44', NULL),
(18, '221013341', 4, 'Logged In. IP Address: 182.48.89.164', '2022-10-13 18:03:54', NULL),
(19, '221013341', 4, 'Logged In. IP Address: 103.127.94.254', '2022-10-14 13:38:23', NULL),
(20, '221013160', 1, 'Logged In. IP Address: 103.49.203.92', '2022-10-15 04:32:16', NULL),
(21, '221013160', 1, 'Logged In. IP Address: 103.49.203.92', '2022-10-15 04:39:43', NULL),
(22, '221013160', 1, 'Added New supplier, Supplier name: FARA IT LTD., Phone: 01627382866', '2022-10-15 04:44:57', NULL),
(23, '221013160', 1, 'Added New Product Brand(Brand name: Walton)', '2022-10-15 04:46:42', NULL),
(24, '221013160', 1, 'Added New Category(name: Drinks)', '2022-10-15 04:46:49', NULL),
(25, '221013160', 1, 'Added New Product Brand(Brand name: Samsung)', '2022-10-15 04:47:12', NULL),
(26, '221013160', 1, 'Added New Category(name: food)', '2022-10-15 04:47:17', NULL),
(27, '221013160', 1, 'Added New Product, Product name: test products', '2022-10-15 04:48:16', NULL),
(28, '221013160', 1, 'Added New Product, Product name: water 2 litre', '2022-10-15 04:49:18', NULL),
(29, '221013160', 1, 'Add New Branch(Branch Name: Mirpur Branch)', '2022-10-15 04:50:03', NULL),
(30, '221013160', 1, 'Stock In from supplier. Invoice num # STB/221013160/1', '2022-10-14 18:00:00', NULL),
(31, '221013160', 1, 'New Customer (Name: Ridoy Paul, Phone: 01627382866) Added', '2022-10-15 05:03:54', NULL),
(32, '221013160', 1, 'Stock Out from Branch To SR Transfer (BTSR). Invoice num BTSR_T_221013160_1', '2022-10-15 05:05:08', NULL),
(33, '221013160', 1, 'Product Sell to C221013160S1, Invoice Num: S/221013160/6/1', '2022-10-15 05:05:32', NULL),
(34, '221013160', 1, 'Shop Setting Updated', '2022-10-15 05:23:44', NULL),
(35, '221013160', 1, 'Shop Setting Updated', '2022-10-15 05:46:10', NULL),
(36, '221013160', 1, 'Shop Setting Updated', '2022-10-15 05:50:41', NULL),
(37, '221013160', 1, 'Shop Setting Updated', '2022-10-15 05:56:22', NULL),
(38, '221013160', 1, 'Direct Product Return to supplier. Invoice num SDR_221013160_1', '2022-10-15 05:56:33', NULL),
(39, '221013160', 1, 'Direct Product Return to supplier. Invoice num SDR_221013160_2', '2022-10-15 05:58:35', NULL),
(40, '221013160', 1, 'New Ledger Head (Name: Staff Salary) Added', '2022-10-15 06:57:32', NULL),
(41, '221013468', 5, 'Logged In. IP Address: 182.48.89.164', '2022-10-15 08:05:45', NULL),
(42, '221013341', 4, 'Logged In. IP Address: 182.48.89.164', '2022-10-15 08:11:47', NULL),
(43, '221013468', 5, 'Logged In. IP Address: 182.48.89.164', '2022-10-15 08:25:06', NULL),
(44, '221013468', 5, 'Add New Branch(Branch Name: Godown 1)', '2022-10-15 08:26:55', NULL),
(45, '221013341', 4, 'Logged In. IP Address: 182.48.89.164', '2022-10-15 09:52:34', NULL),
(46, '221013341', 4, 'Added New Brand Using CSV(Brand name: Britannia Food & Beverage Ltd..)', '2022-10-15 09:52:55', NULL),
(47, '221013341', 4, 'Added New Brand Using CSV(Brand name: Green 9 Company Ltd.)', '2022-10-15 09:52:55', NULL),
(48, '221013341', 4, 'Added New Brand Using CSV(Brand name: Gazi Brand Power Mosquito Coil)', '2022-10-15 09:52:55', NULL),
(49, '221013341', 4, 'Added New Brand Using CSV(Brand name: Olympic Industries Ltd.)', '2022-10-15 09:52:55', NULL),
(50, '221013341', 4, 'Added New Brand Using CSV(Brand name: Pran Mr.Mango)', '2022-10-15 09:52:55', NULL),
(51, '221013341', 4, 'Added New Brand Using CSV(Brand name: Star Line Food Products Ltd.)', '2022-10-15 09:52:55', NULL),
(52, '221013341', 4, 'Added New Category Using CSV(Category name: Water)', '2022-10-15 09:53:32', NULL),
(53, '221013341', 4, 'Added New Category Using CSV(Category name: Food)', '2022-10-15 09:53:32', NULL),
(54, '221013341', 4, 'Added New Unit Type Using CSV(Unit Type name: piece)', '2022-10-15 09:54:06', NULL),
(55, '221013341', 4, 'Logged In. IP Address: 103.49.203.92', '2022-10-15 10:13:38', NULL),
(56, '221013341', 4, 'Added Product Using CSV(product name: Britania Drinking Water 250ml)', '2022-10-15 10:14:51', NULL),
(57, '221013341', 4, 'Added Product Using CSV(product name: Britania Drinking Water 500ml)', '2022-10-15 10:14:51', NULL),
(58, '221013341', 4, 'Added Product Using CSV(product name: Britania Drinking Water 1000ml)', '2022-10-15 10:14:52', NULL),
(59, '221013341', 4, 'Added Product Using CSV(product name: Britania Drinking Water 2000ml)', '2022-10-15 10:14:52', NULL),
(60, '221013341', 4, 'Added Product Using CSV(product name: Green 9 Dairy Milk tk5)', '2022-10-15 10:14:52', NULL),
(61, '221013341', 4, 'Added Product Using CSV(product name: Green 9 Dairy Milk 15gm tk10)', '2022-10-15 10:14:52', NULL),
(62, '221013341', 4, 'Added Product Using CSV(product name: Green 9 Dairy Milk tk20)', '2022-10-15 10:14:52', NULL),
(63, '221013341', 4, 'Added Product Using CSV(product name: Green9 Milk Bar tk5)', '2022-10-15 10:14:52', NULL),
(64, '221013341', 4, 'Added Product Using CSV(product name: Green9 Bery Bar Stb tk5)', '2022-10-15 10:14:52', NULL),
(65, '221013341', 4, 'Added Product Using CSV(product name: Green 9 Bery Bar Stb tk10)', '2022-10-15 10:14:52', NULL),
(66, '221013341', 4, 'Added Product Using CSV(product name: Green 9 Rasing Car tk5)', '2022-10-15 10:14:52', NULL),
(67, '221013341', 4, 'Added Product Using CSV(product name: Green 9 Doramura tk5)', '2022-10-15 10:14:52', NULL),
(68, '221013341', 4, 'Added Product Using CSV(product name: Green 9 Mojamoja Cup Chocolate tk5)', '2022-10-15 10:14:52', NULL),
(69, '221013341', 4, 'Added Product Using CSV(product name: Green 9 Magic Ball tk2)', '2022-10-15 10:14:52', NULL),
(70, '221013341', 4, 'Added Product Using CSV(product name: Green 9 Surprise Chocolate Ball tk5)', '2022-10-15 10:14:52', NULL),
(71, '221013341', 4, 'Added Product Using CSV(product name: Green 9 Lovebirth & Magic Star tk5)', '2022-10-15 10:14:52', NULL),
(72, '221013341', 4, 'Added Product Using CSV(product name: Gree 9 Choco Choco+Milk Magic tk2)', '2022-10-15 10:14:52', NULL),
(73, '221013341', 4, 'Added Product Using CSV(product name: Gree 9 Choco Choco tk5)', '2022-10-15 10:14:52', NULL),
(74, '221013341', 4, 'Added Product Using CSV(product name: Green 9 Papols Mix Candy tk2)', '2022-10-15 10:14:52', NULL),
(75, '221013341', 4, 'Added Product Using CSV(product name: Green 9 Mix Candy tk1)', '2022-10-15 10:14:52', NULL),
(76, '221013341', 4, 'Added Product Using CSV(product name: Almond poly)', '2022-10-15 10:14:52', NULL),
(77, '221013341', 4, 'Added Product Using CSV(product name: Gazi  Coill 5Tk)', '2022-10-15 10:14:52', NULL),
(78, '221013341', 4, 'Added Product Using CSV(product name: Gazi  Coill 10Tk)', '2022-10-15 10:14:52', NULL),
(79, '221013341', 4, 'Added Product Using CSV(product name: Energ Plus Malai 45gm 36pcs)', '2022-10-15 10:14:52', NULL),
(80, '221013341', 4, 'Added Product Using CSV(product name: Coconut Plus 55gm 24pcs)', '2022-10-15 10:14:52', NULL),
(81, '221013341', 4, 'Added Product Using CSV(product name: Chocolate Cream Biscuit 50gm 24pcs)', '2022-10-15 10:14:52', NULL),
(82, '221013341', 4, 'Added Product Using CSV(product name: Pineapple Cream 50gm 24pcs)', '2022-10-15 10:14:52', NULL),
(83, '221013341', 4, 'Added Product Using CSV(product name: Soft Cake Chocolate 40gm 48pcs)', '2022-10-15 10:14:52', NULL),
(84, '221013341', 4, 'Added Product Using CSV(product name: Soft Cake Chocolate 80gm 18pcs)', '2022-10-15 10:14:52', NULL),
(85, '221013341', 4, 'Added Product Using CSV(product name: Glucose ST 24pcs)', '2022-10-15 10:14:52', NULL),
(86, '221013341', 4, 'Added Product Using CSV(product name: Mojadar Family 8pcs)', '2022-10-15 10:14:52', NULL),
(87, '221013341', 4, 'Added Product Using CSV(product name: ChocoMarry Family 8pcs)', '2022-10-15 10:14:52', NULL),
(88, '221013341', 4, 'Added Product Using CSV(product name: Daily Cokies Family 8pcs)', '2022-10-15 10:14:52', NULL),
(89, '221013341', 4, 'Added Product Using CSV(product name: Elatchi Family 8pcs)', '2022-10-15 10:14:52', NULL),
(90, '221013341', 4, 'Added Product Using CSV(product name: Elatchi ST 24pcs)', '2022-10-15 10:14:52', NULL),
(91, '221013341', 4, 'Added Product Using CSV(product name: Mama Wafer 5Tk mix Olympic)', '2022-10-15 10:14:52', NULL),
(92, '221013341', 4, 'Added Product Using CSV(product name: Olympic Battery)', '2022-10-15 10:14:52', NULL),
(93, '221013341', 4, 'Added Product Using CSV(product name: Chips Olympic)', '2022-10-15 10:14:52', NULL),
(94, '221013341', 4, 'Added Product Using CSV(product name: Chokito Mobile Jar)', '2022-10-15 10:14:52', NULL),
(95, '221013341', 4, 'Added Product Using CSV(product name: Pulse Masala Jolpai)', '2022-10-15 10:14:52', NULL),
(96, '221013341', 4, 'Added Product Using CSV(product name: Ghee Bite ST 24pc)', '2022-10-15 10:14:52', NULL),
(97, '221013341', 4, 'Added Product Using CSV(product name: Ghee Bite Family 8pc)', '2022-10-15 10:14:52', NULL),
(98, '221013341', 4, 'Added Product Using CSV(product name: Chocolate Cream Mini 21gm 48pcs/14gm 72pcs)', '2022-10-15 10:14:52', NULL),
(99, '221013341', 4, 'Added Product Using CSV(product name: Foodie Bite Chanachur 13gm)', '2022-10-15 10:14:52', NULL),
(100, '221013341', 4, 'Added Product Using CSV(product name: Sipo Tasty Saline Orange 9gm)', '2022-10-15 10:14:52', NULL),
(101, '221013341', 4, 'Added Product Using CSV(product name: Pulse Masala Jolpai 40poush)', '2022-10-15 10:14:52', NULL),
(102, '221013341', 4, 'Added Product Using CSV(product name: Pulse Masala Jolpai 20poush)', '2022-10-15 10:14:52', NULL),
(103, '221013341', 4, 'Added Product Using CSV(product name: Magic Candy Milk -Mango 600gm)', '2022-10-15 10:14:52', NULL),
(104, '221013341', 4, 'Added Product Using CSV(product name: Toffeeto Kulfi 3.5gm)', '2022-10-15 10:14:52', NULL),
(105, '221013341', 4, 'Added Product Using CSV(product name: Mr Mango Candy 50ps - 1 pouch - 1Tk)', '2022-10-15 10:14:52', NULL),
(106, '221013341', 4, 'Added Product Using CSV(product name: Mr Mango Candy 100ps - 1 Jar - 1Tk)', '2022-10-15 10:14:52', NULL),
(107, '221013341', 4, 'Added Product Using CSV(product name: Mr Mango Candy 250ps - 1 Jar - 1Tk)', '2022-10-15 10:14:52', NULL),
(108, '221013341', 4, 'Added Product Using CSV(product name: Mr Mango Candy 300ps - 1 Jar - 1Tk)', '2022-10-15 10:14:52', NULL),
(109, '221013341', 4, 'Added Product Using CSV(product name: Mr Mango Candy Igjetic 150ps - 1 Jar - 2Tk)', '2022-10-15 10:14:52', NULL),
(110, '221013341', 4, 'Added Product Using CSV(product name: Hajom Candy 50ps - 1 Pouch - 1Tk)', '2022-10-15 10:14:52', NULL),
(111, '221013341', 4, 'Added Product Using CSV(product name: Hajom Candy 250 ps - 1 Jar - 1Tk)', '2022-10-15 10:14:52', NULL),
(112, '221013341', 4, 'Added Product Using CSV(product name: Hajom Candy 350ps - 1 jar - 1Tk)', '2022-10-15 10:14:52', NULL),
(113, '221013341', 4, 'Added Product Using CSV(product name: Pinut Candy 50ps poly - 1Tk)', '2022-10-15 10:14:52', NULL),
(114, '221013341', 4, 'Added Product Using CSV(product name: Pinut Candy 250ps 1 Jar - 1Tk)', '2022-10-15 10:14:52', NULL),
(115, '221013341', 4, 'Added Product Using CSV(product name: Frute Candy 200ps 1 Jar - 1Tk)', '2022-10-15 10:14:52', NULL),
(116, '221013341', 4, 'Added Product Using CSV(product name: Freeshin Candy 250ps 1 Jar - 1Tk)', '2022-10-15 10:14:52', NULL),
(117, '221013341', 4, 'Added Product Using CSV(product name: Atoom Litchi 150ps 1 Jar - 2Tk)', '2022-10-15 10:14:52', NULL),
(118, '221013341', 4, 'Added Product Using CSV(product name: DR Milk Candy 50ps 1 Poly - 1 Tk)', '2022-10-15 10:14:52', NULL),
(119, '221013341', 4, 'Added Product Using CSV(product name: Mr Toom Candy 250ps 1 Jar - 1Tk)', '2022-10-15 10:14:52', NULL),
(120, '221013341', 4, 'Added Product Using CSV(product name: Dr Milk Candy 200ps 1 Jar - 1 Tk)', '2022-10-15 10:14:52', NULL),
(121, '221013341', 4, 'Added Product Using CSV(product name: Soft Bite 100 Ps 1 Jar - 2 tk)', '2022-10-15 10:14:52', NULL),
(122, '221013341', 4, 'Added Product Using CSV(product name: Pran Coffe Candy 150ps 1 Jar - 2 Tk)', '2022-10-15 10:14:52', NULL),
(123, '221013341', 4, 'Added Product Using CSV(product name: Sheumin Candy 150ps 1 Jar - 2 Tk)', '2022-10-15 10:14:52', NULL),
(124, '221013341', 4, 'Added Product Using CSV(product name: Fix Candy 25 ps 1 Pouch)', '2022-10-15 10:14:52', NULL),
(125, '221013341', 4, 'Added Product Using CSV(product name: King Kong lolipop 80 ps 1 Jar - 3 Tk)', '2022-10-15 10:14:52', NULL),
(126, '221013341', 4, 'Added Product Using CSV(product name: Chow Chow Lolipop 100 ps 1 Jar - 3 Tk)', '2022-10-15 10:14:52', NULL),
(127, '221013341', 4, 'Added Product Using CSV(product name: Whistle lolipop 100 Ps 1 Jar - 5 Tk)', '2022-10-15 10:14:52', NULL),
(128, '221013341', 4, 'Added Product Using CSV(product name: Treet Fish Lolipop 80 Ps 1 Jar - 5 Tk)', '2022-10-15 10:14:52', NULL),
(129, '221013341', 4, 'Added Product Using CSV(product name: Football lLolipop 100 Ps 1 Jar - 3 Tk)', '2022-10-15 10:14:52', NULL),
(130, '221013341', 4, 'Added Product Using CSV(product name: Horry Pop V Orange Lolipop 100pcs - 2 Tk)', '2022-10-15 10:14:52', NULL),
(131, '221013341', 4, 'Added Product Using CSV(product name: Mango Jose Pack Frute 125 ml 80 Ps - 13 Tk)', '2022-10-15 10:14:52', NULL),
(132, '221013341', 4, 'Added Product Using CSV(product name: Mango Frute Drinks 200 ml 48 Ps - 15 Tk)', '2022-10-15 10:14:52', NULL),
(133, '221013341', 4, 'Added Product Using CSV(product name: Freshly Mango Frute Drinks 250 ml 24 ps - 25 Tk)', '2022-10-15 10:14:52', NULL),
(134, '221013341', 4, 'Added Product Using CSV(product name: Bro Candy 150 ps 1 Jar - 2 Tk)', '2022-10-15 10:14:53', NULL),
(135, '221013341', 4, 'Added Product Using CSV(product name: Litchita Candy 250 ps 1 jar 1 Tk)', '2022-10-15 10:14:53', NULL),
(136, '221013341', 4, 'Added Product Using CSV(product name: Freshly Lacchi 200 ml 24 ps - 20 Tk)', '2022-10-15 10:14:53', NULL),
(137, '221013341', 4, 'Added Product Using CSV(product name: Freshly Litchi Drinks 150 ml 72 Ps 12 Tk)', '2022-10-15 10:14:53', NULL),
(138, '221013341', 4, 'Added Product Using CSV(product name: Drinko Orange 150 ml 72 ps - 12 Tk)', '2022-10-15 10:14:53', NULL),
(139, '221013341', 4, 'Added Product Using CSV(product name: Cream Dream Chocolate Biscuit 25gm 72 ps - 5 Tk)', '2022-10-15 10:14:53', NULL),
(140, '221013341', 4, 'Added Product Using CSV(product name: Mama Wafer Venila Chain 18gm 72 ps - 5 tk)', '2022-10-15 10:14:53', NULL),
(141, '221013341', 4, 'Added Product Using CSV(product name: Eggy Box 30 ps 1 Jar - 10 Tk)', '2022-10-15 10:14:53', NULL),
(142, '221013341', 4, 'Added Product Using CSV(product name: Pran Mango bar 30ps - 1 box)', '2022-10-15 10:14:53', NULL),
(143, '221013341', 4, 'Added Product Using CSV(product name: Magic Cup 18 ps 1 Ploy - 2 Tk)', '2022-10-15 10:14:53', NULL),
(144, '221013341', 4, 'Added Product Using CSV(product name: Bisco Dry Cake 40gm 48 ps - 10 Tk)', '2022-10-15 10:14:53', NULL),
(145, '221013341', 4, 'Added Product Using CSV(product name: Balti)', '2022-10-15 10:14:53', NULL),
(146, '221013341', 4, 'Added Product Using CSV(product name: Gamla/Bowl)', '2022-10-15 10:14:53', NULL),
(147, '221013341', 4, 'Added Product Using CSV(product name: Jag)', '2022-10-15 10:14:53', NULL),
(148, '221013341', 4, 'Added Product Using CSV(product name: Freshly Mango Fruit Drink 1000ml)', '2022-10-15 10:14:53', NULL),
(149, '221013341', 4, 'Added Product Using CSV(product name: Masala Candy 150Pcs)', '2022-10-15 10:14:53', NULL),
(150, '221013341', 4, 'Added Product Using CSV(product name: Atoom Box 50pcs)', '2022-10-15 10:14:53', NULL),
(151, '221013341', 4, 'Added Product Using CSV(product name: Dearly Candy 50 pouch)', '2022-10-15 10:14:53', NULL),
(152, '221013341', 4, 'Added Product Using CSV(product name: SOFT Bite Gift BOX)', '2022-10-15 10:14:53', NULL),
(153, '221013341', 4, 'Added Product Using CSV(product name: Horry Pop V Orange Lolipop 150pcs - 2 Tk)', '2022-10-15 10:14:53', NULL),
(154, '221013341', 4, 'Added Product Using CSV(product name: Pluse Pluse 150pcs 2Tk Candy 15 Jar)', '2022-10-15 10:14:53', NULL),
(155, '221013341', 4, 'Added Product Using CSV(product name: Hajom 150pcs 2Tk candy 15 jar)', '2022-10-15 10:14:53', NULL),
(156, '221013341', 4, 'Added Product Using CSV(product name: Pran Milk Candy Lollipop 100pcs 8 Jar)', '2022-10-15 10:14:53', NULL),
(157, '221013341', 4, 'Added Product Using CSV(product name: Mr Mango Candy 150ps - 1 Jar - 2Tk)', '2022-10-15 10:14:53', NULL),
(158, '221013341', 4, 'Added Product Using CSV(product name: Energy mini 10Tk)', '2022-10-15 10:14:53', NULL),
(159, '221013341', 4, 'Added Product Using CSV(product name: Orange mini 10Tk)', '2022-10-15 10:14:53', NULL),
(160, '221013341', 4, 'Added Product Using CSV(product name: Butter Tost mini 5TK)', '2022-10-15 10:14:53', NULL),
(161, '221013341', 4, 'Added Product Using CSV(product name: Star Dry Cake Mini 10Tk)', '2022-10-15 10:14:53', NULL),
(162, '221013341', 4, 'Added Product Using CSV(product name: Chiffon Cake 5Tk)', '2022-10-15 10:14:53', NULL),
(163, '221013341', 4, 'Added Product Using CSV(product name: Orio Chanachur 140gm)', '2022-10-15 10:14:53', NULL),
(164, '221013341', 4, 'Added Product Using CSV(product name: Orio Motor)', '2022-10-15 10:14:53', NULL),
(165, '221013341', 4, 'Added Product Using CSV(product name: BBQ Chanachur 150gm)', '2022-10-15 10:14:53', NULL),
(166, '221013341', 4, 'Added Product Using CSV(product name: Tomato Sauce)', '2022-10-15 10:14:53', NULL),
(167, '221013341', 4, 'Added Product Using CSV(product name: Horlicks Cookies Family)', '2022-10-15 10:14:53', NULL),
(168, '221013341', 4, 'Added Product Using CSV(product name: Classic Choice Star Line)', '2022-10-15 10:14:53', NULL),
(169, '221013341', 4, 'Added Product Using CSV(product name: Fruti Orange Mini)', '2022-10-15 10:14:53', NULL),
(170, '221013341', 4, 'Added Product Using CSV(product name: Orio Jhal ChanaChur)', '2022-10-15 10:14:53', NULL),
(171, '221013341', 4, 'Added Product Using CSV(product name: Orio Masala Dal Vaja)', '2022-10-15 10:14:53', NULL),
(172, '221013341', 4, 'Added Product Using CSV(product name: Hot Chanachur 280gm)', '2022-10-15 10:14:53', NULL),
(173, '221013341', 4, 'Added Product Using CSV(product name: Tang Full up mini)', '2022-10-15 10:14:53', NULL),
(174, '221013341', 4, 'Added Product Using CSV(product name: Tang Full up 125gm)', '2022-10-15 10:14:53', NULL),
(175, '221013341', 4, 'Added Product Using CSV(product name: Tang Full up 250gm)', '2022-10-15 10:14:53', NULL),
(176, '221013341', 4, 'Added Product Using CSV(product name: Stik Noodlose)', '2022-10-15 10:14:53', NULL),
(177, '221013341', 4, 'Added Product Using CSV(product name: Special Tost Star line)', '2022-10-15 10:14:53', NULL),
(178, '221013341', 4, 'Added Product Using CSV(product name: Tomato Sauce mini)', '2022-10-15 10:14:53', NULL),
(179, '221013341', 4, 'Added Product Using CSV(product name: Pineapple Cream Lione Star Line)', '2022-10-15 10:14:53', NULL),
(180, '221013341', 4, 'Added Product Using CSV(product name: Capsicam Chanachur 23gm 5Tk)', '2022-10-15 10:14:53', NULL),
(181, '221013341', 4, 'Added Product Using CSV(product name: Jhal Muri 5TK)', '2022-10-15 10:14:53', NULL),
(182, '221013341', 4, 'Added Product Using CSV(product name: Orange Family 6pcs)', '2022-10-15 10:14:53', NULL),
(183, '221013341', 4, 'Added Product Using CSV(product name: Chocolate chips cokies 6pcs)', '2022-10-15 10:14:53', NULL),
(184, '221013341', 4, 'Added Product Using CSV(product name: Chicken Noodols)', '2022-10-15 10:14:53', NULL),
(185, '221013160', 1, 'Logged In. IP Address: 103.49.203.92', '2022-10-15 10:46:48', NULL),
(186, '221013160', 1, 'Shop Setting Updated', '2022-10-15 10:51:19', NULL),
(187, '221013468', 5, 'Logged In. IP Address: 182.48.89.164', '2022-10-15 10:52:03', NULL),
(188, '221013468', 5, 'Added New Unit Type Using CSV(Unit Type name: piece)', '2022-10-15 10:52:23', NULL),
(189, '221013468', 5, 'Added New Brand Using CSV(Brand name: Britannia Food & Beverage Ltd..)', '2022-10-15 10:52:53', NULL),
(190, '221013468', 5, 'Added New Brand Using CSV(Brand name: Green 9 Company Ltd.)', '2022-10-15 10:52:53', NULL),
(191, '221013468', 5, 'Added New Brand Using CSV(Brand name: Gazi Brand Power Mosquito Coil)', '2022-10-15 10:52:54', NULL),
(192, '221013468', 5, 'Added New Brand Using CSV(Brand name: Olympic Industries Ltd.)', '2022-10-15 10:52:54', NULL),
(193, '221013468', 5, 'Added New Brand Using CSV(Brand name: Pran Mr.Mango)', '2022-10-15 10:52:54', NULL),
(194, '221013468', 5, 'Added New Brand Using CSV(Brand name: Star Line Food Products Ltd.)', '2022-10-15 10:52:54', NULL),
(195, '221013468', 5, 'Added New Category Using CSV(Category name: Water)', '2022-10-15 10:53:21', NULL),
(196, '221013468', 5, 'Added New Category Using CSV(Category name: Food)', '2022-10-15 10:53:21', NULL),
(197, '221013468', 5, 'Added Product Using CSV(product name: Britania Drinking Water 250ml)', '2022-10-15 10:53:40', NULL),
(198, '221013468', 5, 'Added Product Using CSV(product name: Britania Drinking Water 500ml)', '2022-10-15 10:53:40', NULL),
(199, '221013468', 5, 'Added Product Using CSV(product name: Britania Drinking Water 1000ml)', '2022-10-15 10:53:40', NULL),
(200, '221013468', 5, 'Added Product Using CSV(product name: Britania Drinking Water 2000ml)', '2022-10-15 10:53:40', NULL),
(201, '221013160', 1, 'Shop Setting Updated', '2022-10-15 11:00:21', NULL),
(202, '221013160', 1, 'Shop Setting Updated', '2022-10-15 11:01:38', NULL),
(203, '221013341', 4, 'Logged In. IP Address: 182.48.89.164', '2022-10-15 11:17:00', NULL),
(204, '221013468', 5, 'Stock Out from Branch To SR Transfer (BTSR). Invoice num BTSR_T_221013468_1', '2022-10-15 11:18:18', NULL),
(205, '221013468', 5, 'Stock Out from SR To Branch Transfer (SRTB). Invoice num SRTB_T_221013468_1', '2022-10-15 11:19:03', NULL),
(206, '221013468', 5, 'Stock Out from SR To Branch Transfer (SRTB). Invoice num SRTB_T_221013468_2', '2022-10-15 11:20:00', NULL),
(207, '221013468', 5, 'Product Sell to C221013468S5, Invoice Num: S/221013468/7/1', '2022-10-15 11:21:52', NULL),
(208, '221013160', 1, 'Shop Setting Updated', '2022-10-15 11:25:31', NULL),
(209, '221013160', 1, 'Shop Setting Updated', '2022-10-15 11:25:35', NULL),
(210, '221013468', 5, 'Product Sell to C221013468S6, Invoice Num: S/221013468/7/2', '2022-10-15 11:31:32', NULL),
(211, '221013160', 1, 'Stock Out from Branch To SR Transfer (BTSR). Invoice num BTSR_T_221013160_2', '2022-10-15 11:35:07', NULL),
(212, '221013160', 1, 'Stock Out from SR To Branch Transfer (SRTB). Invoice num SRTB_T_221013160_1', '2022-10-15 11:38:25', NULL),
(213, '221013468', 5, 'Product Sell to C221013468S7, Invoice Num: S/221013468/7/3', '2022-10-15 11:38:43', NULL),
(214, '221013468', 5, 'Added New supplier, Supplier name: Britanuia, Phone: 11235456', '2022-10-15 11:40:16', NULL),
(215, '221013341', 4, 'Logged In. IP Address: 103.49.203.92', '2022-10-15 11:43:57', NULL),
(216, '221013341', 4, 'Logged In. IP Address: 182.48.89.164', '2022-10-15 11:45:48', NULL),
(217, '221013468', 5, 'Logged In. IP Address: 182.48.89.164', '2022-10-15 11:50:38', NULL),
(218, '221013341', 4, 'Shop Setting Updated', '2022-10-15 11:52:58', NULL),
(219, '221013468', 5, 'Shop Setting Updated', '2022-10-15 11:54:29', NULL),
(220, '221013468', 5, 'Shop Setting Updated', '2022-10-15 11:55:42', NULL),
(221, '221013341', 4, 'Logged In. IP Address: 182.48.89.164', '2022-10-15 11:56:33', NULL),
(222, '221013341', 4, 'Shop Setting Updated', '2022-10-15 12:08:30', NULL),
(223, '221013341', 4, 'Update Category(name: Beverage)', '2022-10-15 13:00:20', NULL),
(224, '221013341', 4, 'Add New Branch(Branch Name: Godown 1)', '2022-10-15 13:02:51', NULL),
(225, '221013468', 5, 'Logged In. IP Address: 182.48.89.164', '2022-10-15 13:13:56', NULL),
(226, '221013341', 4, 'Logged In. IP Address: 182.48.89.164', '2022-10-15 13:17:16', NULL),
(227, '221013341', 4, 'Stock Out from Branch To SR Transfer (BTSR). Invoice num BTSR_T_221013341_1', '2022-10-15 13:23:24', NULL),
(228, '221013468', 5, 'Logged In. IP Address: 182.48.89.164', '2022-10-15 13:44:06', NULL),
(229, '221013468', 5, 'Product Sell to C221013468S9, Invoice Num: S/221013468/7/4', '2022-10-15 13:46:19', NULL),
(230, '221013468', 5, 'Product Sell to C221013468S10, Invoice Num: S/221013468/7/5', '2022-10-15 13:55:23', NULL),
(231, '221013468', 5, 'Stock Out from Branch To SR Transfer (BTSR). Invoice num BTSR_T_221013468_2', '2022-10-15 13:59:42', NULL),
(232, '221013468', 5, 'Stock Out from SR To Branch Transfer (SRTB). Invoice num SRTB_T_221013468_3', '2022-10-15 14:00:23', NULL),
(233, '221013160', 1, 'Logged In. IP Address: 116.206.188.84', '2022-10-15 14:02:56', NULL),
(234, '221013468', 5, 'Add New Branch(Branch Name: Godown 2)', '2022-10-15 14:31:54', NULL),
(235, '221013468', 5, 'Stock Out from Branch BY BTB Transfer. Invoice num BTB_T_221013468_1', '2022-10-15 14:32:46', NULL),
(236, '221013160', 1, 'Logged In. IP Address: 123.253.215.138', '2022-10-15 16:55:49', NULL),
(237, '221013341', 4, 'Logged In. IP Address: 182.48.89.164', '2022-10-15 17:13:53', NULL),
(238, '221013468', 5, 'Logged In. IP Address: 182.48.89.164', '2022-10-15 17:19:43', NULL),
(239, '221013468', 5, 'Logged In. IP Address: 103.127.94.254', '2022-10-15 20:19:41', NULL),
(240, '221013160', 1, 'Logged In. IP Address: 103.49.203.92', '2022-10-16 04:26:51', NULL),
(241, '221013160', 1, 'Logged In. IP Address: 103.49.203.92', '2022-10-16 04:34:46', NULL),
(242, '221013468', 5, 'Logged In. IP Address: 182.48.89.164', '2022-10-16 06:01:03', NULL),
(243, '221013468', 5, 'Logged In. IP Address: 182.48.89.164', '2022-10-16 06:11:35', NULL),
(244, '221013341', 4, 'Logged In. IP Address: 103.127.94.254', '2022-10-16 07:43:25', NULL),
(245, '221013160', 1, 'Logged In. IP Address: 103.49.203.92', '2022-10-16 08:31:19', NULL),
(246, '221013468', 5, 'Stock Out from Branch To SR Transfer (BTSR). Invoice num BTSR_T_221013468_3', '2022-10-16 08:46:00', NULL),
(247, '221013341', 4, 'Logged In. IP Address: 182.48.89.164', '2022-10-16 08:48:02', NULL),
(248, '221013468', 5, 'Logged In. IP Address: 182.48.89.164', '2022-10-16 08:50:14', NULL),
(249, '221013468', 5, 'Stock In from supplier. Invoice num # STB/221013468/1', '2022-10-15 18:00:00', NULL),
(250, '221013468', 5, 'New Business Owners / Capital Person (Name: Fahid, Phone: 053456343) Added', '2022-10-16 09:13:03', NULL),
(251, '221013468', 5, 'New Loan Person (Name: IBBl, Phone: 58745) Added', '2022-10-16 09:14:22', NULL),
(252, '221013468', 5, 'Loan Received from Lender, Lender name: IBBl, Paid Amount: 10000,  Voucher Num: LR221013468/1', '2022-10-16 09:14:37', NULL),
(253, '221013468', 5, 'Loan Paid to Lender, Lender name: IBBl, Paid Amount: 1000,  Voucher Num: LP221013468/2', '2022-10-16 09:14:56', NULL),
(254, '221013468', 5, 'Shop Setting Updated', '2022-10-16 09:16:22', NULL),
(255, '221013468', 5, 'Shop Setting Updated', '2022-10-16 09:16:29', NULL),
(256, '221013160', 1, 'Stock Out from Branch To SR Transfer (BTSR). Invoice num BTSR_T_221013160_3', '2022-10-16 10:00:23', NULL),
(257, '221013160', 1, 'Product Sell to C221013160S1, Invoice Num: S/221013160/6/2', '2022-10-16 10:29:08', NULL),
(258, '221013341', 4, 'Logged In. IP Address: 182.48.89.164', '2022-10-16 10:31:59', NULL),
(259, '221013160', 1, 'Product Sell to C221013160S1, Invoice Num: S/221013160/6/3', '2022-10-16 10:42:23', NULL),
(260, '221013468', 5, 'Logged In. IP Address: 182.48.89.164', '2022-10-16 10:48:00', NULL),
(261, '221013468', 5, 'Product Sell to C221013468S12, Invoice Num: S/221013468/7/6', '2022-10-16 10:52:28', NULL),
(262, '221013341', 4, 'Logged In. IP Address: 182.48.89.164', '2022-10-16 11:22:20', NULL),
(263, '221013341', 4, 'Logged In. IP Address: 182.48.89.164', '2022-10-16 11:28:35', NULL),
(264, '221013160', 1, 'New Expense Added, Ledger Head name: Staff Salary, Voucher Num: E221013160/1', '2022-10-15 18:00:00', NULL),
(265, '221013468', 5, 'Logged In. IP Address: 182.48.89.164', '2022-10-16 12:45:59', NULL),
(266, '221013468', 5, 'Logged In. IP Address: 182.48.89.164', '2022-10-16 12:58:54', NULL),
(267, '221013341', 4, 'Logged In. IP Address: 182.48.89.164', '2022-10-16 13:01:56', NULL),
(268, '221013468', 5, 'Logged In. IP Address: 182.48.89.164', '2022-10-16 13:07:15', NULL),
(269, '221013160', 1, 'Product Sell to C221013160S1, Invoice Num: S/221013160/6/4', '2022-10-16 13:25:20', NULL),
(270, '221013160', 1, 'Product Sell to C221013160S1, Invoice Num: S/221013160/6/5', '2022-10-16 13:25:55', NULL),
(271, '221013341', 4, 'Logged In. IP Address: 182.48.89.164', '2022-10-16 13:33:38', NULL),
(272, '221013341', 4, 'New Ledger Head (Name: Daily Expense) Added', '2022-10-16 13:39:07', NULL),
(273, '221013468', 5, 'Logged In. IP Address: 182.48.89.164', '2022-10-16 13:39:16', NULL),
(274, '221013468', 5, 'New Ledger Head (Name: Daily Expense) Added', '2022-10-16 13:39:45', NULL),
(275, '221013468', 5, 'New Ledger Head (Name: Office Rent) Added', '2022-10-16 13:40:04', NULL),
(276, '221013468', 5, 'New Ledger Head (Name: Vehicle Rent) Added', '2022-10-16 13:40:17', NULL),
(277, '221013468', 5, 'New Expense Added, Ledger Head name: Daily Expense, Voucher Num: E221013468/5', '2022-10-15 18:00:00', NULL),
(278, '221013468', 5, 'New Expense Added, Ledger Head name: Vehicle Rent, Voucher Num: E221013468/6', '2022-10-15 18:00:00', NULL),
(279, '221013468', 5, 'Balance Transfer Cash To Bank, Tracking Num: # CONTRA221013468/1, Amount: 1000', '2022-10-16 13:49:13', NULL),
(280, '221013468', 5, 'Balance Transfer Cash To Bank, Tracking Num: # CONTRA221013468/2, Amount: 2000', '2022-10-16 13:49:43', NULL),
(281, '221013468', 5, 'Product Sell to C221013468S14, Invoice Num: S/221013468/14/1', '2022-10-16 13:53:17', NULL),
(282, '221013468', 5, 'Stock Out from SR To Branch Transfer (SRTB). Invoice num SRTB_T_221013468_4', '2022-10-16 13:54:18', NULL),
(283, '221013468', 5, 'Payment To supplier, supplier Code: S221013468S1, name: Britanuia, Amount: 2000', '2022-10-16 14:03:08', NULL),
(284, '221013341', 4, 'Logged In. IP Address: 182.48.89.164', '2022-10-16 14:33:03', NULL),
(285, '221013468', 5, 'Logged In. IP Address: 182.48.89.164', '2022-10-16 15:40:49', NULL),
(286, '221013468', 5, 'Stock Out from Branch To SR Transfer (BTSR). Invoice num BTSR_T_221013468_4', '2022-10-16 15:46:55', NULL),
(287, '221013468', 5, 'Product Sell to C221013468S15, Invoice Num: S/221013468/14/2', '2022-10-16 15:47:58', NULL),
(288, '221013468', 5, 'Stock Out from SR To Branch Transfer (SRTB). Invoice num SRTB_T_221013468_5', '2022-10-16 15:48:23', NULL),
(289, '221013341', 4, 'Logged In. IP Address: 182.48.89.164', '2022-10-16 15:55:24', NULL),
(290, '221013341', 4, 'Added New Admin Helper Role(role name: Manager)', '2022-10-16 15:55:40', NULL),
(291, '221013341', 22, 'Logged In. IP Address: 182.48.89.164', '2022-10-16 16:00:13', NULL),
(292, '221013341', 4, 'Logged In. IP Address: 182.48.89.164', '2022-10-16 16:01:46', NULL),
(293, '221013341', 4, 'New Business Owners / Capital Person (Name: Akm Shamim, Phone: 01716395573) Added', '2022-10-16 16:03:19', NULL),
(294, '221013468', 5, 'Logged In. IP Address: 182.48.89.164', '2022-10-16 16:17:08', NULL),
(295, '221013468', 5, 'New Ledger Head (Name: Internet Bill) Added', '2022-10-16 16:19:54', NULL),
(296, '221013468', 5, 'New Ledger Head (Name: Monthly Expense) Added', '2022-10-16 16:20:09', NULL),
(297, '221013468', 5, 'New Expense Added, Ledger Head name: Monthly Expense, Voucher Num: E221013468/8', '2022-10-15 18:00:00', NULL),
(298, '221013341', 22, 'Logged In. IP Address: 182.48.89.164', '2022-10-16 16:29:12', NULL),
(299, '221013341', 22, 'Logged In. IP Address: 182.48.89.164', '2022-10-16 16:35:24', NULL),
(300, '221013468', 5, 'Logged In. IP Address: 103.242.23.191', '2022-10-16 17:07:04', NULL),
(301, '221013341', 4, 'Logged In. IP Address: 182.48.89.164', '2022-10-16 17:11:51', NULL),
(302, '221013341', 4, 'Logged In. IP Address: 182.48.89.164', '2022-10-17 05:33:41', NULL),
(303, '221013341', 4, 'New Business Owners / Capital Person (Name: Md. Shamsul Alam, Phone: 01753881380) Added', '2022-10-17 05:38:36', NULL),
(304, '221013341', 4, 'Updated Business Owners / Capital Person(Name: Akm Shamim, Phone: 01716395573)', '2022-10-17 05:40:04', NULL),
(305, '221013341', 4, 'New Loan Person (Name: Brac Bank Limited., Phone: 01709819697) Added', '2022-10-17 05:43:23', NULL),
(306, '221013341', 4, 'Update Category(name: Britannia)', '2022-10-17 07:21:08', NULL),
(307, '221013341', 4, 'Update Category(name: Olympic)', '2022-10-17 07:21:32', NULL),
(308, '221013341', 4, 'Added New Category(name: Gazi)', '2022-10-17 07:21:47', NULL),
(309, '221013341', 22, 'Logged In. IP Address: 182.48.89.164', '2022-10-17 07:27:29', NULL),
(310, '221013341', 22, 'Added New Product Brand(Brand name: Akij Food)', '2022-10-17 10:40:44', NULL),
(311, '221013341', 22, 'Deactive Product Brand', '2022-10-17 10:40:47', NULL),
(312, '221013341', 22, 'Active Product Brand', '2022-10-17 10:40:56', NULL),
(313, '221013341', 22, 'Added New Category(name: Pran)', '2022-10-17 10:41:32', NULL),
(314, '221013341', 22, 'Added New Category(name: Star line)', '2022-10-17 10:41:57', NULL),
(315, '221013341', 22, 'Added New Category(name: Green 9)', '2022-10-17 10:42:13', NULL),
(316, '221013341', 22, 'Added New Category(name: Akij)', '2022-10-17 10:42:31', NULL),
(317, '221013341', 4, 'Logged In. IP Address: 103.127.94.254', '2022-10-17 10:54:50', NULL),
(318, '221013341', 22, 'Added New Product, Product name: Mojo Daet Can 250ml 24pcs', '2022-10-17 11:11:05', NULL),
(319, '221013341', 22, 'Added New Product, Product name: Mojo Can 250ml 24pcs', '2022-10-17 11:14:04', NULL),
(320, '221013341', 4, 'Update Product, Product name: Mojo Daet Can 250ml 24pcs', '2022-10-17 11:16:14', NULL),
(321, '221013341', 4, 'Update Product, Product name: Mojo Can 250ml 24pcs', '2022-10-17 11:17:33', NULL),
(322, '221013341', 4, 'Deactivate Customer', '2022-10-17 11:20:35', NULL),
(323, '221013341', 4, 'Activate Customer', '2022-10-17 11:20:42', NULL),
(324, '221013341', 22, 'Added New Product, Product name: Mojo Naga Can 250ml 24pcs', '2022-10-17 11:23:01', NULL),
(325, '221013341', 22, 'Added New Product, Product name: Mojo peat Can 250ml 24pcs', '2022-10-17 11:25:55', NULL),
(326, '221013468', 5, 'Logged In. IP Address: 103.49.203.92', '2022-10-17 11:54:22', NULL),
(327, '221013468', 5, 'Stock In from supplier. Invoice num # STB/221013468/2', '2022-10-16 18:00:00', NULL),
(328, '221013468', 5, 'Stock Out from Branch To SR Transfer (BTSR). Invoice num BTSR_T_221013468_5', '2022-10-17 11:57:07', NULL),
(329, '221013341', 22, 'Added New Product, Product name: Mojo Peat 500ml 24pcs', '2022-10-17 12:52:29', NULL),
(330, '221013341', 4, 'Logged In. IP Address: 182.48.89.167', '2022-10-17 13:28:10', NULL),
(331, '221013341', 22, 'Added New Product, Product name: Clemon Can 250ml 24pcs', '2022-10-17 13:40:56', NULL),
(332, '221013341', 4, 'Added New Product, Product name: Penut Bar', '2022-10-17 13:46:12', NULL),
(333, '221013341', 4, 'Added New Product, Product name: Kismi Chocolate Jar', '2022-10-17 13:52:13', NULL),
(334, '221013341', 4, 'Added New Product, Product name: Kismi Chocolate Poly', '2022-10-17 13:57:16', NULL),
(335, '221013341', 22, 'Added New Product, Product name: Clemon Peat 250ml 24pcs', '2022-10-17 14:15:12', NULL),
(336, '221013341', 4, 'Added New supplier, Supplier name: Green 9 Company Limited., Phone: 01842131137', '2022-10-17 14:23:39', NULL),
(337, '221013341', 4, 'Capital Received from Owner, Owner name: Akm Shamim, Voucher Num: #CA221013341/1', '2022-09-30 18:00:00', NULL),
(338, '221013341', 4, 'Stock In from supplier. Invoice num # STB/221013341/1', '2022-10-05 18:00:00', NULL),
(339, '221013341', 4, 'Stock Out from Branch To SR Transfer (BTSR). Invoice num BTSR_T_221013341_2', '2022-10-17 15:01:24', NULL),
(340, '221013341', 4, 'Product Sell to C221013341S1, Invoice Num: S/221013341/24/1', '2022-10-17 15:06:43', NULL),
(341, '221013341', 4, 'Payment To supplier, supplier Code: S221013341S1, name: Green 9 Company Limited., Amount: 100000', '2022-10-17 15:13:22', NULL),
(342, '221013341', 4, 'Shop Setting Updated', '2022-10-17 15:24:53', NULL),
(343, '221013341', 22, 'Logged In. IP Address: 182.48.89.167', '2022-10-17 16:29:16', NULL),
(344, '221013341', 4, 'Updated Customer(Name: M/s Luknath Veraties Store, Phone: 01725348568) Info', '2022-10-17 16:37:59', NULL),
(345, '221013341', 4, 'Added New supplier, Supplier name: Britannia Food & Beverage Ltd., Phone: 01925507892', '2022-10-17 16:56:43', NULL),
(346, '221013341', 4, 'Added New supplier, Supplier name: Akij Food & Beverage Ltd., Phone: 01755630267', '2022-10-17 17:02:10', NULL),
(347, '221013341', 4, 'Added New supplier, Supplier name: Olympic Industries Ltd., Phone: +880-29565228', '2022-10-17 17:05:36', NULL),
(348, '221013341', 4, 'Added New supplier, Supplier name: Gazi Coil, Phone: 01752090678', '2022-10-17 17:07:55', NULL),
(349, '221013341', 4, 'Added New supplier, Supplier name: Star Line Food Products Ltd., Phone: 01753218357', '2022-10-17 17:11:11', NULL),
(350, '221013341', 4, 'Update supplier, Supplier name: Noorjahan Enterprise Gazi Coil, Phone: 01752090678', '2022-10-17 17:13:17', NULL),
(351, '221013341', 4, 'Added New supplier, Supplier name: Pran Mr. Mango Group, Phone: 01704142493', '2022-10-17 17:15:56', NULL),
(352, '221013341', 4, 'New Ledger Head (Name: Daily Expenses) Added', '2022-10-17 17:21:08', NULL),
(353, '221013341', 4, 'Update Ledger Head (Name: Office Rent) Added', '2022-10-17 17:21:49', NULL),
(354, '221013341', 4, 'New Ledger Head (Name: Monthly Bill) Added', '2022-10-17 17:23:29', NULL),
(355, '221013341', 4, 'New Loan Person (Name: Rangs Motors Ltd., Phone: 01993338081) Added', '2022-10-17 17:57:48', NULL),
(356, '221013341', 4, 'Logged In. IP Address: 182.48.89.167', '2022-10-17 18:07:15', NULL),
(357, '221013341', 4, 'Logged In. IP Address: 182.48.89.167', '2022-10-17 18:07:29', NULL),
(358, '221013341', 4, 'Logged In. IP Address: 182.48.89.167', '2022-10-18 09:13:25', NULL),
(359, '221013341', 22, 'Logged In. IP Address: 182.48.89.167', '2022-10-18 13:38:48', NULL),
(360, '221013341', 4, 'Logged In. IP Address: 182.48.89.167', '2022-10-18 14:19:44', NULL),
(361, '221013341', 4, 'Logged In. IP Address: 37.111.215.164', '2022-10-18 15:50:18', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `multiple_payments`
--

CREATE TABLE `multiple_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shop_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `branch_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `invoice_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `paid_amount` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `payment_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `info` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deposit_to` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `custom_field` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `net_cash_bls`
--

CREATE TABLE `net_cash_bls` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shop_id` int(11) NOT NULL,
  `balance` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `net_cash_bls`
--

INSERT INTO `net_cash_bls` (`id`, `shop_id`, `balance`, `created_at`, `updated_at`) VALUES
(1, 221013160, 7400, NULL, '2022-10-16 13:02:44'),
(2, 221013341, 385000, NULL, NULL),
(3, 221013468, 0.60000000000002, NULL, '2022-10-16 15:41:10');

-- --------------------------------------------------------

--
-- Table structure for table `ordered_products`
--

CREATE TABLE `ordered_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lot_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `purchase_price` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `product_id` int(11) NOT NULL,
  `variation_id` int(11) NOT NULL DEFAULT 0,
  `quantity` double NOT NULL,
  `delivered_quantity` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `is_cartoon` int(11) DEFAULT 0,
  `cartoon_quantity` double DEFAULT 0,
  `cartoon_amount` double DEFAULT 0,
  `price` double NOT NULL,
  `discount` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no',
  `discount_amount` double NOT NULL DEFAULT 0,
  `discount_in_tk` double NOT NULL DEFAULT 0,
  `vat_amount` double DEFAULT NULL,
  `total_price` double NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ordered_products`
--

INSERT INTO `ordered_products` (`id`, `invoice_id`, `lot_number`, `purchase_price`, `product_id`, `variation_id`, `quantity`, `delivered_quantity`, `is_cartoon`, `cartoon_quantity`, `cartoon_amount`, `price`, `discount`, `discount_amount`, `discount_in_tk`, `vat_amount`, `total_price`, `created_at`, `updated_at`) VALUES
(1, 'S_221013160_6_1', NULL, '0', 2, 0, 20, '20.00', 1, 20, 1, 20, 'no', 0, 0, 0, 400, '2022-10-14 18:00:00', NULL),
(2, 'S_221013160_6_1', NULL, '0', 1, 0, 20, '20.00', 1, 20, 1, 100, 'no', 0, 0, 0, 2000, '2022-10-14 18:00:00', NULL),
(3, 'S_221013468_7_1', NULL, '0', 135, 0, 1, '1', 1, 6, 0.16666666666667, 20, 'no', 0, 0, 0, 20, '2022-10-14 18:00:00', NULL),
(4, 'S_221013468_7_1', NULL, '0', 133, 0, 1, '1', 1, 20, 0.05, 8, 'percent', 5, 0.4, 0, 7.6, '2022-10-14 18:00:00', NULL),
(5, 'S_221013468_7_1', NULL, '0', 134, 0, 1, '1', 1, 12, 0.083333333333333, 13, 'no', 0, 0, 0, 13, '2022-10-14 18:00:00', NULL),
(6, 'S_221013468_7_2', NULL, '0', 135, 0, 5, '5', 1, 6, 0.83333333333333, 20, 'no', 0, 0, 0, 100, '2022-10-14 18:00:00', NULL),
(7, 'S_221013468_7_2', NULL, '0', 134, 0, 11, '11', 1, 12, 0.91666666666667, 13, 'no', 0, 0, 0, 143, '2022-10-14 18:00:00', NULL),
(8, 'S_221013468_7_2', NULL, '0', 133, 0, 19, '19', 1, 20, 0.95, 8, 'percent', 5, 7.6, 0, 144.4, '2022-10-14 18:00:00', NULL),
(9, 'S_221013468_7_3', NULL, '0', 2, 0, 60, '60.00', 1, 20, 3, 20, 'no', 0, 0, 0, 1200, '2022-10-14 18:00:00', NULL),
(10, 'S_221013468_7_4', NULL, '0', 2, 0, 10, '10', 1, 20, 0.5, 20, 'no', 0, 0, 0, 200, '2022-10-14 18:00:00', NULL),
(11, 'S_221013468_7_5', NULL, '0', 2, 0, 5, '5', 1, 20, 0.25, 20, 'no', 0, 0, 0, 100, '2022-10-14 18:00:00', NULL),
(12, 'S_221013160_6_2', NULL, '0', 1, 0, 40, '40.00', 1, 20, 2, 100, 'no', 0, 0, 0, 4000, '2022-10-15 18:00:00', NULL),
(13, 'S_221013160_6_3', NULL, '0', 1, 0, 40, '40.00', 1, 20, 2, 100, 'no', 0, 0, 0, 4000, '2022-10-15 18:00:00', NULL),
(14, 'S_221013468_7_6', NULL, '0', 2, 0, 1, '1', 1, 20, 0.05, 20, 'no', 0, 0, 0, 20, '2022-10-15 18:00:00', NULL),
(15, 'S_221013160_6_4', NULL, '0', 1, 0, 10, '10', 1, 20, 0.5, 100, 'no', 0, 0, 0, 1000, '2022-10-15 18:00:00', NULL),
(16, 'S_221013160_6_5', NULL, '0', 1, 0, 5, '5', 1, 20, 0.25, 100, 'no', 0, 0, 0, 500, '2022-10-15 18:00:00', NULL),
(17, 'S_221013468_14_1', NULL, '0', 135, 0, 12, '12.00', 1, 6, 2, 20, 'no', 0, 0, 0, 240, '2022-10-15 18:00:00', NULL),
(18, 'S_221013468_14_1', NULL, '0', 134, 0, 12, '12.00', 1, 12, 1, 13, 'no', 0, 0, 0, 156, '2022-10-15 18:00:00', NULL),
(19, 'S_221013468_14_1', NULL, '0', 133, 0, 60, '60.00', 1, 20, 3, 8, 'percent', 5, 24, 0, 456, '2022-10-15 18:00:00', NULL),
(20, 'S_221013468_14_2', NULL, '0', 134, 0, 10, '10', 1, 12, 0.83333333333333, 13, 'no', 0, 0, 0, 130, '2022-10-15 18:00:00', NULL),
(21, 'S_221013468_14_2', NULL, '0', 133, 0, 25, '25', 1, 20, 1.25, 8, 'percent', 5, 10, 0, 190, '2022-10-15 18:00:00', NULL),
(22, 'S_221013341_24_1', NULL, '0', 7, 0, 108, '108', 1, 36, 3, 71.29, 'no', 0, 0, 0, 7699.32, '2022-10-16 18:00:00', NULL),
(23, 'S_221013341_24_1', NULL, '0', 8, 0, 24, '24', 1, 24, 1, 113.5, 'no', 0, 0, 0, 2724, '2022-10-16 18:00:00', NULL),
(24, 'S_221013341_24_1', NULL, '0', 10, 0, 108, '108', 1, 36, 3, 71.91, 'no', 0, 0, 0, 7766.28, '2022-10-16 18:00:00', NULL),
(25, 'S_221013341_24_1', NULL, '0', 11, 0, 108, '108', 1, 36, 3, 67.7, 'no', 0, 0, 0, 7311.6, '2022-10-16 18:00:00', NULL),
(26, 'S_221013341_24_1', NULL, '0', 12, 0, 24, '24', 1, 24, 1, 110, 'no', 0, 0, 0, 2640, '2022-10-16 18:00:00', NULL),
(27, 'S_221013341_24_1', NULL, '0', 13, 0, 72, '72', 1, 36, 2, 63.96, 'no', 0, 0, 0, 4605.12, '2022-10-16 18:00:00', NULL),
(28, 'S_221013341_24_1', NULL, '0', 14, 0, 36, '36', 1, 12, 3, 152.25, 'no', 0, 0, 0, 5481, '2022-10-16 18:00:00', NULL),
(29, 'S_221013341_24_1', NULL, '0', 15, 0, 36, '36', 1, 12, 3, 143.83, 'no', 0, 0, 0, 5177.88, '2022-10-16 18:00:00', NULL),
(30, 'S_221013341_24_1', NULL, '0', 16, 0, 12, '12', 1, 12, 1, 169.25, 'no', 0, 0, 0, 2031, '2022-10-16 18:00:00', NULL),
(31, 'S_221013341_24_1', NULL, '0', 17, 0, 72, '72', 1, 18, 4, 71.96, 'no', 0, 0, 0, 5181.12, '2022-10-16 18:00:00', NULL),
(32, 'S_221013341_24_1', NULL, '0', 19, 0, 72, '72', 1, 24, 3, 110.72584, 'no', 0, 0, 0, 7972.26048, '2022-10-16 18:00:00', NULL),
(33, 'S_221013341_24_1', NULL, '0', 20, 0, 24, '24', 1, 12, 2, 245.48, 'no', 0, 0, 0, 5891.52, '2022-10-16 18:00:00', NULL),
(34, 'S_221013341_24_1', NULL, '0', 21, 0, 96, '96', 1, 12, 8, 165.01, 'no', 0, 0, 0, 15840.96, '2022-10-16 18:00:00', NULL),
(35, 'S_221013341_24_1', NULL, '0', 142, 0, 32, '32', 1, 16, 2, 126.93, 'no', 0, 0, 0, 4061.76, '2022-10-16 18:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shop_id` int(11) NOT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `area_id` int(11) DEFAULT NULL,
  `sr_id` int(11) NOT NULL,
  `invoice_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_id` int(11) NOT NULL,
  `total_gross` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `vat_in_tk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `discount_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount_rate` double DEFAULT NULL,
  `discount_in_tk` double NOT NULL DEFAULT 0,
  `pre_due` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `others_crg` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `delivery_crg` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `invoice_total` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `payment_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `wallet_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no',
  `wallet_balance` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `total_for_point` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `point_earn_rate` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `wallet_point` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `paid_amount` double NOT NULL DEFAULT 0,
  `change_amount` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `note` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delivery_man_id` int(11) DEFAULT NULL,
  `card_or_mfs` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no',
  `cheque_or_mfs_acc` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mfs_acc_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cheque_bank` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `diposit_to` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cheque_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `c_diposit_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `crm_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sms_status` int(11) DEFAULT 0,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `shop_id`, `branch_id`, `area_id`, `sr_id`, `invoice_id`, `customer_id`, `total_gross`, `vat`, `vat_in_tk`, `discount_status`, `discount_rate`, `discount_in_tk`, `pre_due`, `others_crg`, `delivery_crg`, `invoice_total`, `payment_by`, `wallet_status`, `wallet_balance`, `total_for_point`, `point_earn_rate`, `wallet_point`, `paid_amount`, `change_amount`, `note`, `delivery_man_id`, `card_or_mfs`, `cheque_or_mfs_acc`, `mfs_acc_type`, `cheque_bank`, `diposit_to`, `cheque_date`, `c_diposit_date`, `crm_id`, `sms_status`, `date`, `created_at`, `updated_at`) VALUES
(1, 221013160, NULL, 1, 6, 'S_221013160_6_1', 1, '2400', '0', '0', 'no', 0, 0, '0', '0', '0', '2400', 'cash', 'no', '0', '0', '0', '0', 2400, NULL, 'Note', NULL, 'no', NULL, NULL, NULL, NULL, NULL, NULL, '1', 1, '2022-10-15', '2022-10-15 05:05:32', NULL),
(2, 221013468, NULL, 2, 7, 'S_221013468_7_1', 5, '40.6', '0', '0', 'no', 0, 0, '0', '0', '0', '40.6', 'cash', 'no', '0', '0', '0', '0', 40.6, NULL, 'Note', NULL, 'no', NULL, NULL, NULL, NULL, NULL, NULL, '5', 1, '2022-10-15', '2022-10-15 11:21:52', NULL),
(3, 221013468, NULL, 2, 7, 'S_221013468_7_2', 6, '387.4', '0', '0', 'no', 0, 0, '0', '0', '0', '387.4', 'cash', 'no', '0', '0', '0', '0', 200, NULL, 'Note', NULL, 'no', NULL, NULL, NULL, NULL, NULL, NULL, '5', 1, '2022-10-15', '2022-10-15 11:31:32', NULL),
(4, 221013468, NULL, 2, 7, 'S_221013468_7_3', 7, '1200', '0', '0', 'no', 0, 0, '0', '0', '0', '1200', 'cash', 'no', '0', '0', '0', '0', 1200, NULL, 'Note', NULL, 'no', NULL, NULL, NULL, NULL, NULL, NULL, '5', 1, '2022-10-15', '2022-10-15 11:38:43', NULL),
(5, 221013468, NULL, 2, 7, 'S_221013468_7_4', 9, '200', '0', '0', 'no', 0, 0, '0', '0', '0', '200', 'cash', 'no', '0', '0', '0', '0', 200, NULL, 'Note', NULL, 'no', NULL, NULL, NULL, NULL, NULL, NULL, '5', 1, '2022-10-15', '2022-10-15 13:46:19', NULL),
(6, 221013468, NULL, 2, 7, 'S_221013468_7_5', 10, '100', '0', '0', 'no', 0, 0, '0', '0', '0', '100', 'cash', 'no', '0', '0', '0', '0', 100, NULL, 'Note', NULL, 'no', NULL, NULL, NULL, NULL, NULL, NULL, '5', 1, '2022-10-15', '2022-10-15 13:55:22', NULL),
(7, 221013160, NULL, 1, 6, 'S_221013160_6_2', 1, '4000', '0', '0', 'no', 0, 0, '0', '0', '0', '4000', 'cash', 'no', '0', '0', '0', '0', 4000, NULL, 'Note', NULL, 'no', NULL, NULL, NULL, NULL, NULL, NULL, '1', 1, '2022-10-16', '2022-10-16 10:29:08', NULL),
(8, 221013160, NULL, 1, 6, 'S_221013160_6_3', 1, '4000', '0', '0', 'no', 0, 0, '0', '0', '0', '4000', 'cash', 'no', '0', '0', '0', '0', 4000, NULL, 'Note', NULL, 'no', NULL, NULL, NULL, NULL, NULL, NULL, '1', 1, '2022-10-16', '2022-10-16 10:42:23', NULL),
(9, 221013468, NULL, 2, 7, 'S_221013468_7_6', 12, '20', '0', '0', 'no', 0, 0, '0', '0', '0', '20', 'cash', 'no', '0', '0', '0', '0', 0, NULL, 'Note', NULL, 'no', NULL, NULL, NULL, NULL, NULL, NULL, '5', 1, '2022-10-16', '2022-10-16 10:52:28', NULL),
(10, 221013160, NULL, 1, 6, 'S_221013160_6_4', 1, '1000', '0', '0', 'no', 0, 0, '0', '0', '0', '1000', 'cash', 'no', '0', '0', '0', '0', 500, NULL, 'Note', NULL, 'no', NULL, NULL, NULL, NULL, NULL, NULL, '1', 1, '2022-10-16', '2022-10-16 13:25:20', NULL),
(11, 221013160, NULL, 1, 6, 'S_221013160_6_5', 1, '500', '0', '0', 'no', 0, 0, '500', '0', '0', '1000', 'cash', 'no', '0', '0', '0', '0', 200, NULL, 'Note', NULL, 'no', NULL, NULL, NULL, NULL, NULL, NULL, '1', 1, '2022-10-16', '2022-10-16 13:25:55', NULL),
(12, 221013468, NULL, 2, 14, 'S_221013468_14_1', 14, '852', '0', '0', 'no', 0, 0, '0', '0', '0', '852', 'cash', 'no', '0', '0', '0', '0', 852, NULL, 'Note', NULL, 'no', NULL, NULL, NULL, NULL, NULL, NULL, '5', 1, '2022-10-16', '2022-10-16 13:53:17', NULL),
(13, 221013468, NULL, 2, 14, 'S_221013468_14_2', 15, '320', '0', '0', 'no', 0, 0, '0', '0', '0', '320', 'cash', 'no', '0', '0', '0', '0', 320, NULL, 'Note', NULL, 'no', NULL, NULL, NULL, NULL, NULL, NULL, '5', 1, '2022-10-16', '2022-10-16 15:47:58', NULL),
(14, 221013341, NULL, 4, 24, 'S_221013341_24_1', 16, '84383.82048', '0', '0', 'no', 0, 0, '0', '0', '0', '84383.82048', 'cash', 'no', '0', '0', '0', '0', 85000, NULL, 'Note', NULL, 'card', NULL, 'no', NULL, NULL, '2022-10-17', '2022-10-17', '4', 1, '2022-10-17', '2022-10-17 15:06:43', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_return_porducts`
--

CREATE TABLE `order_return_porducts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lot_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `purchase_price` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `return_or_exchange` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'r',
  `how_many_times_edited` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `variation_id` int(11) NOT NULL DEFAULT 0,
  `quantity` double NOT NULL DEFAULT 0,
  `is_cartoon` int(11) NOT NULL DEFAULT 0,
  `cartoon_quantity` double DEFAULT 0,
  `cartoon_amount` double DEFAULT 0,
  `price` double NOT NULL DEFAULT 0,
  `discount` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no',
  `discount_amount` double NOT NULL DEFAULT 0,
  `vat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_price` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `owners`
--

CREATE TABLE `owners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shop_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nid_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `opening_capital` double NOT NULL,
  `capital` double NOT NULL DEFAULT 0,
  `business_portion` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `owners`
--

INSERT INTO `owners` (`id`, `shop_id`, `name`, `phone`, `nid_number`, `address`, `opening_capital`, `capital`, `business_portion`, `created_at`, `updated_at`) VALUES
(1, 221013468, 'Fahid', '053456343', NULL, 'Dhaka', 0, 0, 100, '2022-10-16 09:13:03', NULL),
(2, 221013341, 'Akm Shamim', '01716395573', '9012385571483', 'Themuki Baypss Sylhet', 0, 400000, 100, '2022-10-16 16:03:19', '2022-10-17 05:40:04'),
(3, 221013341, 'Md. Shamsul Alam', '01753881380', '8685227368', 'Themuki Bypass Sylhet', 0, 0, 50, '2022-10-17 05:38:36', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `group_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `group_name`, `created_at`, `updated_at`) VALUES
(1, 'account.dashboard', 'web', 'Account_Wing', NULL, NULL),
(2, 'account.loan', 'web', 'Account_Wing', NULL, NULL),
(3, 'account.list.of.group', 'web', 'Account_Wing', NULL, NULL),
(4, 'account.ledger.head', 'web', 'Account_Wing', NULL, NULL),
(5, 'account.bank.and.cash', 'web', 'Account_Wing', NULL, NULL),
(6, 'account.transaction', 'web', 'Account_Wing', NULL, NULL),
(7, 'account.vouchers', 'web', 'Account_Wing', NULL, NULL),
(8, 'account.customer.report', 'web', 'Account_Wing', NULL, NULL),
(9, 'account.report', 'web', 'Account_Wing', NULL, NULL),
(10, 'account.income.statement', 'web', 'Account_Wing', NULL, NULL),
(11, 'admin.transaction.vouchers', 'web', 'Account_Wing', NULL, NULL),
(12, 'account.capital', 'web', 'Account_Wing', NULL, NULL),
(13, 'account.expense', 'web', 'Account_Wing', NULL, NULL),
(14, 'account.statement', 'web', 'Account_Wing', NULL, NULL),
(15, 'account.indirect.income', 'web', 'Account_Wing', NULL, NULL),
(16, 'branch.dashboard', 'web', 'Branch', NULL, NULL),
(17, 'branch.customers', 'web', 'Branch', NULL, NULL),
(18, 'branch.product.stock', 'web', 'Branch', NULL, NULL),
(19, 'branch.sell', 'web', 'Branch', NULL, NULL),
(20, 'branch.return.product', 'web', 'Branch', NULL, NULL),
(21, 'branch.deliveryman', 'web', 'Branch', NULL, NULL),
(22, 'branch.received.customer.due', 'web', 'Branch', NULL, NULL),
(23, 'branch.reports', 'web', 'Branch', NULL, NULL),
(24, 'branch.damage.product', 'web', 'Branch', NULL, NULL),
(25, 'branch.setting', 'web', 'Branch', NULL, NULL),
(26, 'branch.sell.discount', 'web', 'Branch', NULL, NULL),
(27, 'admin.setting', 'web', 'Main_Wing', NULL, NULL),
(28, 'admin.dashboard', 'web', 'Main_Wing', NULL, NULL),
(29, 'admin.helper.role.permission', 'web', 'Main_Wing', NULL, NULL),
(30, 'admin.area', 'web', 'Main_Wing', NULL, NULL),
(31, 'admin.sr', 'web', 'Main_Wing', NULL, NULL),
(32, 'branch', 'web', 'Main_Wing', NULL, NULL),
(33, 'admin.crm', 'web', 'Main_Wing', NULL, NULL),
(34, 'admin.deliveryman', 'web', 'Main_Wing', NULL, NULL),
(35, 'admin.products', 'web', 'Main_Wing', NULL, NULL),
(36, 'branch.role.permission', 'web', 'Main_Wing', NULL, NULL),
(37, 'others.customers', 'web', 'Main_Wing', NULL, NULL),
(38, 'others.sell', 'web', 'Main_Wing', NULL, NULL),
(39, 'others.receive.customers.due', 'web', 'Main_Wing', NULL, NULL),
(40, 'others.returns.refund', 'web', 'Main_Wing', NULL, NULL),
(41, 'admin.branch.product.stock', 'web', 'Main_Wing', NULL, NULL),
(42, 'admin.set.opening.and.own.stock', 'web', 'Main_Wing', NULL, NULL),
(43, 'admin.product.ledger.table', 'web', 'Main_Wing', NULL, NULL),
(44, 'admin.damage.product', 'web', 'Main_Wing', NULL, NULL),
(45, 'admin.header.balance.statements', 'web', 'Main_Wing', NULL, NULL),
(46, 'admin.sms.panel', 'web', 'Main_Wing', NULL, NULL),
(47, 'admin.branch.to.sr.transfer.products', 'web', 'Main_Wing', NULL, NULL),
(48, 'others.sell.discount', 'web', 'Main_Wing', NULL, NULL),
(49, 'supplier.dashboard', 'web', 'Supplier_Wing', NULL, NULL),
(50, 'supplier.add', 'web', 'Supplier_Wing', NULL, NULL),
(51, 'supplier.stock.in', 'web', 'Supplier_Wing', NULL, NULL),
(52, 'supplier.view.and.edit', 'web', 'Supplier_Wing', NULL, NULL),
(53, 'supplier.report', 'web', 'Supplier_Wing', NULL, NULL),
(54, 'supplier.table.ledger', 'web', 'Supplier_Wing', NULL, NULL),
(55, 'supplier.return.product', 'web', 'Supplier_Wing', NULL, NULL);

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
-- Table structure for table `point_redeem_infos`
--

CREATE TABLE `point_redeem_infos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shop_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `point_redeem_rate` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_point` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `converted_wallet_amount` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shop_id` int(11) NOT NULL,
  `p_name` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `p_cat` int(11) NOT NULL,
  `p_brand` int(11) DEFAULT NULL,
  `p_unit_type` int(11) NOT NULL,
  `G_current_stock` double NOT NULL DEFAULT 0,
  `is_cartoon` int(11) NOT NULL DEFAULT 0,
  `cartoon_quantity` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `cartoon_purchase_price` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `cartoon_sales_price` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `purchase_price` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `selling_price` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `barCode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `p_description` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vat_status` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vat_rate` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount_amount` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_warranty` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `warranty_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_expiry` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `is_variable` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'simple',
  `alert_quantity` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `shop_id`, `p_name`, `p_cat`, `p_brand`, `p_unit_type`, `G_current_stock`, `is_cartoon`, `cartoon_quantity`, `cartoon_purchase_price`, `cartoon_sales_price`, `image`, `purchase_price`, `selling_price`, `barCode`, `p_description`, `vat_status`, `vat_rate`, `discount`, `discount_amount`, `is_warranty`, `warranty_id`, `is_expiry`, `is_variable`, `alert_quantity`, `active`, `created_at`, `updated_at`) VALUES
(1, 221013160, 'test products', 1, 1, 1, 0, 1, '20', '100', '198', NULL, '50', '100', NULL, NULL, 'no', NULL, 'no', NULL, '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 04:48:16', '2022-10-15 04:48:16'),
(2, 221013160, 'water 2 litre', 1, 2, 2, 0, 1, '20', '100', '198', NULL, '10', '20', NULL, NULL, 'no', NULL, 'no', NULL, '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 04:49:17', '2022-10-15 04:49:17'),
(3, 221013341, 'Britania Drinking Water 250ml', 3, 3, 3, 0, 1, '24', '0', '0', NULL, '5.12', '6.041', 'BT0001', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:51', NULL),
(4, 221013341, 'Britania Drinking Water 500ml', 3, 3, 3, 0, 1, '20', '0', '0', NULL, '6.5', '8', 'BT0002', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:51', NULL),
(5, 221013341, 'Britania Drinking Water 1000ml', 3, 3, 3, 0, 1, '12', '0', '0', NULL, '10.667', '13', 'BT0003', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:51', NULL),
(6, 221013341, 'Britania Drinking Water 2000ml', 3, 3, 3, 0, 1, '6', '0', '0', NULL, '16.3334', '20', 'BT0004', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:52', NULL),
(7, 221013341, 'Green 9 Dairy Milk tk5', 3, 4, 3, 0, 1, '36', '0', '0', NULL, '67.25', '71.29', 'G910001', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:52', NULL),
(8, 221013341, 'Green 9 Dairy Milk 15gm tk10', 3, 4, 3, 0, 1, '24', '0', '0', NULL, '106', '113.5', 'G910002', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:52', NULL),
(9, 221013341, 'Green 9 Dairy Milk tk20', 3, 4, 3, 0, 1, '24', '0', '0', NULL, '113.8334', '120.67', 'G910003', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:52', NULL),
(10, 221013341, 'Green9 Milk Bar tk5', 3, 4, 3, 0, 1, '36', '0', '0', NULL, '67.25', '71.91', 'G910004', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:52', NULL),
(11, 221013341, 'Green9 Bery Bar Stb tk5', 3, 4, 3, 0, 1, '36', '0', '0', NULL, '67.83334', '67.7', 'G910005', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:52', NULL),
(12, 221013341, 'Green 9 Bery Bar Stb tk10', 3, 4, 3, 0, 1, '24', '0', '0', NULL, '106', '110', 'G910006', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:52', NULL),
(13, 221013341, 'Green 9 Rasing Car tk5', 3, 4, 3, 0, 1, '36', '0', '0', NULL, '60.3334', '63.96', 'G910007', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:52', NULL),
(14, 221013341, 'Green 9 Doramura tk5', 3, 4, 3, 0, 1, '12', '0', '0', NULL, '143.75', '152.25', 'G910008', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:52', NULL),
(15, 221013341, 'Green 9 Mojamoja Cup Chocolate tk5', 3, 4, 3, 0, 1, '12', '0', '0', NULL, '135.6667', '143.83', 'G910009', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:52', NULL),
(16, 221013341, 'Green 9 Magic Ball tk2', 3, 4, 3, 0, 1, '12', '0', '0', NULL, '159.66', '169.25', 'G910010', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:52', NULL),
(17, 221013341, 'Green 9 Surprise Chocolate Ball tk5', 3, 4, 3, 0, 1, '18', '0', '0', NULL, '70.16667', '71.96', 'G910011', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:52', NULL),
(18, 221013341, 'Green 9 Lovebirth & Magic Star tk5', 3, 4, 3, 0, 1, '16', '0', '0', NULL, '143.68', '152.31', 'G910012', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:52', NULL),
(19, 221013341, 'Gree 9 Choco Choco+Milk Magic tk2', 3, 4, 3, 0, 1, '24', '0', '0', NULL, '104.45834', '110.72584', 'G910013', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:52', NULL),
(20, 221013341, 'Gree 9 Choco Choco tk5', 3, 4, 3, 0, 1, '12', '0', '0', NULL, '231.5834', '245.48', 'G910014', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:52', NULL),
(21, 221013341, 'Green 9 Papols Mix Candy tk2', 3, 4, 3, 0, 1, '12', '0', '0', NULL, '155.6667', '165.01', 'G910018', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:52', NULL),
(22, 221013341, 'Green 9 Mix Candy tk1', 3, 4, 3, 0, 1, '12', '0', '0', NULL, '127.91664', '135.6', 'G910025', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:52', NULL),
(23, 221013341, 'Almond poly', 3, 4, 3, 0, 1, '24', '0', '0', NULL, '71.9', '90', 'G910026', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:52', NULL),
(24, 221013341, 'Gazi  Coill 5Tk', 3, 5, 3, 0, 1, '30', '0', '0', NULL, '33.5', '36', 'GB00001', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:52', NULL),
(25, 221013341, 'Gazi  Coill 10Tk', 3, 5, 3, 0, 1, '30', '0', '0', NULL, '45.16129', '50', 'GB00002', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:52', NULL),
(26, 221013341, 'Energ Plus Malai 45gm 36pcs', 3, 6, 3, 0, 1, '36', '0', '0', NULL, '11.07695', '12.638', 'Oly50001', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:52', NULL),
(27, 221013341, 'Coconut Plus 55gm 24pcs', 3, 6, 3, 0, 1, '24', '0', '0', NULL, '11.07709', '12.625', 'Oly50002', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:52', NULL),
(28, 221013341, 'Chocolate Cream Biscuit 50gm 24pcs', 3, 6, 3, 0, 1, '24', '0', '0', NULL, '12', '12.625', 'Oly50003', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:52', NULL),
(29, 221013341, 'Pineapple Cream 50gm 24pcs', 3, 6, 3, 0, 1, '24', '0', '0', NULL, '12', '12.625', 'Oly50004', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:52', NULL),
(30, 221013341, 'Soft Cake Chocolate 40gm 48pcs', 3, 6, 3, 0, 1, '48', '0', '0', NULL, '16', '16.875', 'Oly50005', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:52', NULL),
(31, 221013341, 'Soft Cake Chocolate 80gm 18pcs', 3, 6, 3, 0, 1, '18', '0', '0', NULL, '28', '29.445', 'Oly50006', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:52', NULL),
(32, 221013341, 'Glucose ST 24pcs', 3, 6, 3, 0, 1, '24', '0', '0', NULL, '8.334', '8.666', 'Oly50007', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:52', NULL),
(33, 221013341, 'Mojadar Family 8pcs', 3, 6, 3, 0, 1, '8', '0', '0', NULL, '37.6477', '42', 'Oly50008', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:52', NULL),
(34, 221013341, 'ChocoMarry Family 8pcs', 3, 6, 3, 0, 1, '8', '0', '0', NULL, '40', '42', 'Oly50009', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:52', NULL),
(35, 221013341, 'Daily Cokies Family 8pcs', 3, 6, 3, 0, 1, '8', '0', '0', NULL, '48', '50', 'Oly50010', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:52', NULL),
(36, 221013341, 'Elatchi Family 8pcs', 3, 6, 3, 0, 1, '8', '0', '0', NULL, '48', '50', 'Oly50011', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:52', NULL),
(37, 221013341, 'Elatchi ST 24pcs', 3, 6, 3, 0, 1, '24', '0', '0', NULL, '16', '16.75', 'Oly50012', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:52', NULL),
(38, 221013341, 'Mama Wafer 5Tk mix Olympic', 3, 6, 3, 0, 1, '72', '0', '0', NULL, '3.60944', '3.789', 'Oly50013', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:52', NULL),
(39, 221013341, 'Olympic Battery', 3, 6, 3, 0, 1, '480', '0', '0', NULL, '11.9', '12', 'Oly50014', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:52', NULL),
(40, 221013341, 'Chips Olympic', 3, 6, 3, 0, 1, '80', '0', '0', NULL, '11.5', '12', 'Oly50015', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:52', NULL),
(41, 221013341, 'Chokito Mobile Jar', 3, 6, 3, 0, 1, '6', '0', '0', NULL, '123.42834', '125', 'Oly50016', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:52', NULL),
(42, 221013341, 'Pulse Masala Jolpai', 3, 6, 3, 0, 1, '6', '0', '0', NULL, '286', '300', 'Oly50017', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:52', NULL),
(43, 221013341, 'Ghee Bite ST 24pc', 3, 6, 3, 0, 1, '24', '0', '0', NULL, '12', '12.625', 'Oly50018', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:52', NULL),
(44, 221013341, 'Ghee Bite Family 8pc', 3, 6, 3, 0, 1, '8', '0', '0', NULL, '37.6477', '42', 'Oly50019', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:52', NULL),
(45, 221013341, 'Chocolate Cream Mini 21gm 48pcs/14gm 72pcs', 3, 6, 3, 0, 1, '72', '0', '0', NULL, '4', '4.166', 'Oly50020', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:52', NULL),
(46, 221013341, 'Foodie Bite Chanachur 13gm', 3, 6, 3, 0, 1, '160', '0', '0', NULL, '3.636375', '3.8', 'Oly50021', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:52', NULL),
(47, 221013341, 'Sipo Tasty Saline Orange 9gm', 3, 6, 3, 0, 1, '400', '0', '0', NULL, '4.4', '4.65', 'Oly50022', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:52', NULL),
(48, 221013341, 'Pulse Masala Jolpai 40poush', 3, 6, 3, 0, 1, '40', '0', '0', NULL, '16', '17', 'Oly50023', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:52', NULL),
(49, 221013341, 'Pulse Masala Jolpai 20poush', 3, 6, 3, 0, 1, '20', '0', '0', NULL, '40', '42', 'Oly50024', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:52', NULL),
(50, 221013341, 'Magic Candy Milk -Mango 600gm', 3, 6, 3, 0, 1, '6', '0', '0', NULL, '214', '225', 'Oly50025', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:52', NULL),
(51, 221013341, 'Toffeeto Kulfi 3.5gm', 3, 6, 3, 0, 1, '6', '0', '0', NULL, '375', '392.5', 'Oly50026', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:52', NULL),
(52, 221013341, 'Mr Mango Candy 50ps - 1 pouch - 1Tk', 3, 7, 3, 0, 1, '56', '0', '0', NULL, '34', '36.04', 'PR0001', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:52', NULL),
(53, 221013341, 'Mr Mango Candy 100ps - 1 Jar - 1Tk', 3, 7, 3, 0, 1, '15', '0', '0', NULL, '66.66', '70.67', 'PR0002', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:52', NULL),
(54, 221013341, 'Mr Mango Candy 250ps - 1 Jar - 1Tk', 3, 7, 3, 0, 1, '15', '0', '0', NULL, '172.5', '182.85', 'PR0003', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:52', NULL),
(55, 221013341, 'Mr Mango Candy 300ps - 1 Jar - 1Tk', 3, 7, 3, 0, 1, '15', '0', '0', NULL, '196.22', '210', 'PR0004', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:52', NULL),
(56, 221013341, 'Mr Mango Candy Igjetic 150ps - 1 Jar - 2Tk', 3, 7, 3, 0, 1, '15', '0', '0', NULL, '198.5', '210', 'PR0005', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:52', NULL),
(57, 221013341, 'Hajom Candy 50ps - 1 Pouch - 1Tk', 3, 7, 3, 0, 1, '56', '0', '0', NULL, '34', '36.04', 'PR0006', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:52', NULL),
(58, 221013341, 'Hajom Candy 250 ps - 1 Jar - 1Tk', 3, 7, 3, 0, 1, '15', '0', '0', NULL, '172.5', '182.85', 'PR0007', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:52', NULL),
(59, 221013341, 'Hajom Candy 350ps - 1 jar - 1Tk', 3, 7, 3, 0, 1, '15', '0', '0', NULL, '232.75', '246.72', 'PR0008', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:52', NULL),
(60, 221013341, 'Pinut Candy 50ps poly - 1Tk', 3, 7, 3, 0, 1, '56', '0', '0', NULL, '35', '37', 'PR0009', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:52', NULL),
(61, 221013341, 'Pinut Candy 250ps 1 Jar - 1Tk', 3, 7, 3, 0, 1, '15', '0', '0', NULL, '180', '190', 'PR0010', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:52', NULL),
(62, 221013341, 'Frute Candy 200ps 1 Jar - 1Tk', 3, 7, 3, 0, 1, '12', '0', '0', NULL, '151.11', '160', 'PR0011', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:52', NULL),
(63, 221013341, 'Freeshin Candy 250ps 1 Jar - 1Tk', 3, 7, 3, 0, 1, '15', '0', '0', NULL, '169.64', '179.82', 'PR0012', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:52', NULL),
(64, 221013341, 'Atoom Litchi 150ps 1 Jar - 2Tk', 3, 7, 3, 0, 1, '15', '0', '0', NULL, '206.47', '215', 'PR0013', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:52', NULL),
(65, 221013341, 'DR Milk Candy 50ps 1 Poly - 1 Tk', 3, 7, 3, 0, 1, '56', '0', '0', NULL, '34', '33', 'PR0014', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:52', NULL),
(66, 221013341, 'Mr Toom Candy 250ps 1 Jar - 1Tk', 3, 7, 3, 0, 1, '15', '0', '0', NULL, '172.5', '179.82', 'PR0015', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:52', NULL),
(67, 221013341, 'Dr Milk Candy 200ps 1 Jar - 1 Tk', 3, 7, 3, 0, 1, '12', '0', '0', NULL, '135.1', '143', 'PR0016', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:52', NULL),
(68, 221013341, 'Soft Bite 100 Ps 1 Jar - 2 tk', 3, 7, 3, 0, 1, '12', '0', '0', NULL, '156', '165', 'PR0017', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:52', NULL),
(69, 221013341, 'Pran Coffe Candy 150ps 1 Jar - 2 Tk', 3, 7, 3, 0, 1, '15', '0', '0', NULL, '210', '240', 'PR0018', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:52', NULL),
(70, 221013341, 'Sheumin Candy 150ps 1 Jar - 2 Tk', 3, 7, 3, 0, 1, '15', '0', '0', NULL, '204.5', '217', 'PR0019', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:52', NULL),
(71, 221013341, 'Fix Candy 25 ps 1 Pouch', 3, 7, 3, 0, 1, '50', '0', '0', NULL, '32.8125', '34.78', 'PR0020', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:52', NULL),
(72, 221013341, 'King Kong lolipop 80 ps 1 Jar - 3 Tk', 3, 7, 3, 0, 1, '6', '0', '0', NULL, '123.6', '131', 'PR0021', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:52', NULL),
(73, 221013341, 'Chow Chow Lolipop 100 ps 1 Jar - 3 Tk', 3, 7, 3, 0, 1, '6', '0', '0', NULL, '210', '220', 'PR0022', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:52', NULL),
(74, 221013341, 'Whistle lolipop 100 Ps 1 Jar - 5 Tk', 3, 7, 3, 0, 1, '6', '0', '0', NULL, '339', '360', 'PR0023', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:52', NULL),
(75, 221013341, 'Treet Fish Lolipop 80 Ps 1 Jar - 5 Tk', 3, 7, 3, 0, 1, '6', '0', '0', NULL, '292.7', '310', 'PR0024', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:52', NULL),
(76, 221013341, 'Football lLolipop 100 Ps 1 Jar - 3 Tk', 3, 7, 3, 0, 1, '6', '0', '0', NULL, '206', '218.45', 'PR0025', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:52', NULL),
(77, 221013341, 'Horry Pop V Orange Lolipop 100pcs - 2 Tk', 3, 7, 3, 0, 1, '8', '0', '0', NULL, '151.3513', '160.43', 'PR0026', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:52', NULL),
(78, 221013341, 'Mango Jose Pack Frute 125 ml 80 Ps - 13 Tk', 3, 7, 3, 0, 1, '80', '0', '0', NULL, '8.7811', '9.328', 'PR0027', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:52', NULL),
(79, 221013341, 'Mango Frute Drinks 200 ml 48 Ps - 15 Tk', 3, 7, 3, 0, 1, '48', '0', '0', NULL, '13.574', '14.38844', 'PR0028', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:52', NULL),
(80, 221013341, 'Freshly Mango Frute Drinks 250 ml 24 ps - 25 Tk', 3, 7, 3, 0, 1, '24', '0', '0', NULL, '17.5926', '19', 'PR0029', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:52', NULL),
(81, 221013341, 'Bro Candy 150 ps 1 Jar - 2 Tk', 3, 7, 3, 0, 1, '12', '0', '0', NULL, '210', '212', 'PR0030', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:53', NULL),
(82, 221013341, 'Litchita Candy 250 ps 1 jar 1 Tk', 3, 7, 3, 0, 1, '15', '0', '0', NULL, '172.5', '182.85', 'PR0031', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:53', NULL),
(83, 221013341, 'Freshly Lacchi 200 ml 24 ps - 20 Tk', 3, 7, 3, 0, 1, '24', '0', '0', NULL, '20.68', '17.5', 'PR0032', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:53', NULL),
(84, 221013341, 'Freshly Litchi Drinks 150 ml 72 Ps 12 Tk', 3, 7, 3, 0, 1, '72', '0', '0', NULL, '7.7131', '9', 'PR0033', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:53', NULL),
(85, 221013341, 'Drinko Orange 150 ml 72 ps - 12 Tk', 3, 7, 3, 0, 1, '72', '0', '0', NULL, '7.7', '8.162', 'PR0034', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:53', NULL),
(86, 221013341, 'Cream Dream Chocolate Biscuit 25gm 72 ps - 5 Tk', 3, 7, 3, 0, 1, '72', '0', '0', NULL, '3.878208', '4.282188', 'PR0035', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:53', NULL),
(87, 221013341, 'Mama Wafer Venila Chain 18gm 72 ps - 5 tk', 3, 7, 3, 0, 1, '72', '0', '0', NULL, '3.72924', '4', 'PR0036', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:53', NULL),
(88, 221013341, 'Eggy Box 30 ps 1 Jar - 10 Tk', 3, 7, 3, 0, 1, '6', '0', '0', NULL, '229.35', '245', 'PR0037', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:53', NULL),
(89, 221013341, 'Pran Mango bar 30ps - 1 box', 3, 7, 3, 0, 1, '12', '0', '0', NULL, '225.6', '202', 'PR0038', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:53', NULL),
(90, 221013341, 'Magic Cup 18 ps 1 Ploy - 2 Tk', 3, 7, 3, 0, 1, '36', '0', '0', NULL, '26.036', '27.6', 'PR0039', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:53', NULL),
(91, 221013341, 'Bisco Dry Cake 40gm 48 ps - 10 Tk', 3, 7, 3, 0, 1, '48', '0', '0', NULL, '7.83', '8.308', 'PR0040', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:53', NULL),
(92, 221013341, 'Balti', 3, 7, 3, 0, 1, '1', '0', '0', NULL, '40', '42.4', 'PR0041', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:53', NULL),
(93, 221013341, 'Gamla/Bowl', 3, 7, 3, 0, 1, '1', '0', '0', NULL, '40', '42.4', 'PR0042', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:53', NULL),
(94, 221013341, 'Jag', 3, 7, 3, 0, 1, '1', '0', '0', NULL, '32', '33.92', 'PR0043', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:53', NULL),
(95, 221013341, 'Freshly Mango Fruit Drink 1000ml', 3, 7, 3, 0, 1, '12', '0', '0', NULL, '48', '54', 'PR0044', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:53', NULL),
(96, 221013341, 'Masala Candy 150Pcs', 3, 7, 3, 0, 1, '15', '0', '0', NULL, '204.5455', '205', 'PR0045', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:53', NULL),
(97, 221013341, 'Atoom Box 50pcs', 3, 7, 3, 0, 1, '20', '0', '0', NULL, '65.94', '80', 'PR0046', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:53', NULL),
(98, 221013341, 'Dearly Candy 50 pouch', 3, 7, 3, 0, 1, '48', '0', '0', NULL, '90.5661', '100', 'Pr0047', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:53', NULL),
(99, 221013341, 'SOFT Bite Gift BOX', 3, 7, 3, 0, 1, '48', '0', '0', NULL, '145', '155', 'PR0048', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:53', NULL),
(100, 221013341, 'Horry Pop V Orange Lolipop 150pcs - 2 Tk', 3, 7, 3, 0, 1, '8', '0', '0', NULL, '225', '240', 'PR0049', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:53', NULL),
(101, 221013341, 'Pluse Pluse 150pcs 2Tk Candy 15 Jar', 3, 7, 3, 0, 1, '15', '0', '0', NULL, '210', '222.6', 'PR0050', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:53', NULL),
(102, 221013341, 'Hajom 150pcs 2Tk candy 15 jar', 3, 7, 3, 0, 1, '15', '0', '0', NULL, '210', '222.6', 'PR0051', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:53', NULL),
(103, 221013341, 'Pran Milk Candy Lollipop 100pcs 8 Jar', 3, 7, 3, 0, 1, '6', '0', '0', NULL, '328.026', '347.71', 'PR0052', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:53', NULL),
(104, 221013341, 'Mr Mango Candy 150ps - 1 Jar - 2Tk', 3, 7, 3, 0, 1, '12', '0', '0', NULL, '210', '222.6', 'PR0053', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:53', NULL),
(105, 221013341, 'Energy mini 10Tk', 3, 8, 3, 0, 1, '24', '0', '0', NULL, '7.6325', '8.16', 'SL5000', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:53', NULL),
(106, 221013341, 'Orange mini 10Tk', 3, 8, 3, 0, 1, '24', '0', '0', NULL, '7.6325', '8.16', 'SL5001', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:53', NULL),
(107, 221013341, 'Butter Tost mini 5TK', 3, 8, 3, 0, 1, '48', '0', '0', NULL, '3.7475', '4.01', 'SL5002', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:53', NULL),
(108, 221013341, 'Star Dry Cake Mini 10Tk', 3, 8, 3, 0, 1, '48', '0', '0', NULL, '7.4767', '8', 'SL5003', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:53', NULL),
(109, 221013341, 'Chiffon Cake 5Tk', 3, 8, 3, 0, 1, '72', '0', '0', NULL, '3.8942', '4', 'SL5004', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:53', NULL),
(110, 221013341, 'Orio Chanachur 140gm', 3, 8, 3, 0, 1, '48', '0', '0', NULL, '29.90645834', '32', 'SL5005', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:53', NULL),
(111, 221013341, 'Orio Motor', 3, 8, 3, 0, 1, '192', '0', '0', NULL, '3.73835', '4', 'SL5006', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:53', NULL),
(112, 221013341, 'BBQ Chanachur 150gm', 3, 8, 3, 0, 1, '48', '0', '0', NULL, '32.711', '35', 'SL5007', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:53', NULL),
(113, 221013341, 'Tomato Sauce', 3, 8, 3, 0, 1, '288', '0', '0', NULL, '37.019', '39.6', 'SL5008', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:53', NULL),
(114, 221013341, 'Horlicks Cookies Family', 3, 8, 3, 0, 1, '6', '0', '0', NULL, '42.99', '46', 'SL5009', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:53', NULL),
(115, 221013341, 'Classic Choice Star Line', 3, 8, 3, 0, 1, '24', '0', '0', NULL, '7.6325', '8.16', 'SL5010', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:53', NULL),
(116, 221013341, 'Fruti Orange Mini', 3, 8, 3, 0, 1, '24', '0', '0', NULL, '7.6325', '8.17', 'SL5011', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:53', NULL),
(117, 221013341, 'Orio Jhal ChanaChur', 3, 8, 3, 0, 1, '192', '0', '0', NULL, '3.7383', '4', 'SL5012', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:53', NULL),
(118, 221013341, 'Orio Masala Dal Vaja', 3, 8, 3, 0, 1, '192', '0', '0', NULL, '3.701', '3.9588', 'SL5013', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:53', NULL),
(119, 221013341, 'Hot Chanachur 280gm', 3, 8, 3, 0, 1, '48', '0', '0', NULL, '57.94375', '62', 'SL5014', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:53', NULL),
(120, 221013341, 'Tang Full up mini', 3, 8, 3, 0, 1, '360', '0', '0', NULL, '3.115', '3.34', 'SL5015', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:53', NULL),
(121, 221013341, 'Tang Full up 125gm', 3, 8, 3, 0, 1, '24', '0', '0', NULL, '37.388', '40', 'SL5016', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:53', NULL),
(122, 221013341, 'Tang Full up 250gm', 3, 8, 3, 0, 1, '12', '0', '0', NULL, '70.085', '75', 'SL5017', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:53', NULL),
(123, 221013341, 'Stik Noodlose', 3, 8, 3, 0, 1, '24', '0', '0', NULL, '14.019', '15', 'SL5018', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:53', NULL),
(124, 221013341, 'Special Tost Star line', 3, 8, 3, 0, 1, '6', '0', '0', NULL, '37.3834', '40', 'SL5019', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:53', NULL),
(125, 221013341, 'Tomato Sauce mini', 3, 8, 3, 0, 1, '', '0', '0', NULL, '1.542084', '1.65', 'SL5020', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:53', NULL),
(126, 221013341, 'Pineapple Cream Lione Star Line', 3, 8, 3, 0, 1, '24', '0', '0', NULL, '3.7475', '4.01', 'SL5021', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:53', NULL),
(127, 221013341, 'Capsicam Chanachur 23gm 5Tk', 3, 8, 3, 0, 1, '192', '0', '0', NULL, '3.738334', '4', 'SL5022', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:53', NULL),
(128, 221013341, 'Jhal Muri 5TK', 3, 8, 3, 0, 1, '60', '0', '0', NULL, '3.738334', '4', 'SL5023', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:53', NULL),
(129, 221013341, 'Orange Family 6pcs', 3, 8, 3, 0, 1, '6', '0', '0', NULL, '35.51334', '38', 'SL5024', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:53', NULL),
(130, 221013341, 'Chocolate chips cokies 6pcs', 3, 8, 3, 0, 1, '6', '0', '0', NULL, '46.81167', '50', 'SL5025', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:53', NULL),
(131, 221013341, 'Chicken Noodols', 3, 8, 3, 0, 1, '24', '0', '0', NULL, '13.08417', '14', 'SL5026', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:14:53', NULL),
(132, 221013468, 'Britania Drinking Water 250ml', 5, 9, 4, 0, 1, '24', '', '', NULL, '5.12', '6.041', 'BT0001', NULL, 'yes', '10', 'flat', '50', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:53:40', NULL),
(133, 221013468, 'Britania Drinking Water 500ml', 5, 9, 4, 0, 1, '20', '', '', NULL, '6.5', '8', 'BT0002', NULL, 'no', '0', 'percent', '5', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:53:40', NULL),
(134, 221013468, 'Britania Drinking Water 1000ml', 5, 9, 4, 0, 1, '12', '', '', NULL, '10.667', '13', 'BT0003', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:53:40', NULL),
(135, 221013468, 'Britania Drinking Water 2000ml', 5, 9, 4, 0, 1, '6', '', '', NULL, '16.3334', '20', 'BT0004', NULL, 'no', '0', 'no', '0', '0', NULL, '0', 'simple', NULL, 1, '2022-10-15 10:53:40', NULL),
(136, 221013341, 'Mojo Daet Can 250ml 24pcs', 11, 15, 3, 0, 1, '24', '710', '750', NULL, '29.58334', '31.25', 'AKJ0001', NULL, 'no', NULL, 'no', NULL, '0', NULL, '0', 'simple', NULL, 1, '2022-10-17 11:11:05', '2022-10-17 11:16:14'),
(137, 221013341, 'Mojo Can 250ml 24pcs', 11, 15, 3, 0, 1, '24', '600', '635', NULL, '25', '26.4584', 'AKJ0002', NULL, 'no', NULL, 'no', NULL, '0', NULL, '0', 'simple', NULL, 1, '2022-10-17 11:14:04', '2022-10-17 11:18:03'),
(138, 221013341, 'Mojo Naga Can 250ml 24pcs', 11, 15, 3, 0, 1, '24', '655', '690', NULL, '27.29167', '28.75', 'AKJ0003', NULL, 'no', NULL, 'no', NULL, '0', NULL, '0', 'simple', NULL, 1, '2022-10-17 11:23:01', '2022-10-17 11:23:01'),
(139, 221013341, 'Mojo peat Can 250ml 24pcs', 11, 15, 3, 0, 1, '24', '373', '395', NULL, '15.54167', '16.45834', 'AKJ0004', NULL, 'no', NULL, 'no', NULL, '0', NULL, '0', 'simple', NULL, 1, '2022-10-17 11:25:55', '2022-10-17 11:25:55'),
(140, 221013341, 'Mojo Peat 500ml 24pcs', 11, 15, 3, 0, 1, '24', '620', '650', NULL, '25.834', '27.0834', 'AKJ0005', NULL, 'no', NULL, 'no', NULL, '0', NULL, '0', 'simple', NULL, 1, '2022-10-17 12:52:29', '2022-10-17 12:52:29'),
(141, 221013341, 'Clemon Can 250ml 24pcs', 11, 15, 3, 0, 1, '24', '600', '635', NULL, '25', '26.45834', 'AKJ0006', NULL, 'no', NULL, 'no', NULL, '0', NULL, '0', 'simple', NULL, 1, '2022-10-17 13:40:56', '2022-10-17 13:40:56'),
(142, 221013341, 'Penut Bar', 10, 4, 3, 0, 1, '16', '1884', '2031', NULL, '117.75', '126.93', 'G910032', NULL, 'no', NULL, 'no', NULL, '0', NULL, '0', 'simple', NULL, 1, '2022-10-17 13:46:12', '2022-10-17 13:46:12'),
(143, 221013341, 'Kismi Chocolate Jar', 10, 4, 3, 0, 1, '12', '1915', '2030', NULL, '159.66', '169.25', 'G910031', NULL, 'no', NULL, 'no', NULL, '0', NULL, '0', 'simple', NULL, 1, '2022-10-17 13:52:13', '2022-10-17 13:52:13'),
(144, 221013341, 'Kismi Chocolate Poly', 10, 4, 3, 0, 1, '18', '1263', '1340', NULL, '70.17', '74.38', 'G910030', NULL, 'no', NULL, 'no', NULL, '0', NULL, '0', 'simple', NULL, 1, '2022-10-17 13:57:16', '2022-10-17 13:57:16'),
(145, 221013341, 'Clemon Peat 250ml 24pcs', 11, 15, 3, 0, 1, '24', '373', '395', NULL, '15.541667', '16.458334', 'AKJ0007', NULL, 'no', NULL, 'no', NULL, '0', NULL, '0', 'simple', NULL, 1, '2022-10-17 14:15:12', '2022-10-17 14:15:12');

-- --------------------------------------------------------

--
-- Table structure for table `product_stocks`
--

CREATE TABLE `product_stocks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shop_id` int(11) NOT NULL,
  `purchase_line_id` int(11) NOT NULL,
  `lot_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `branch_id` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `variation_id` int(11) DEFAULT NULL,
  `purchase_price` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sales_price` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no',
  `discount_amount` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `vat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `stock` double NOT NULL DEFAULT 0,
  `is_cartoon` int(11) NOT NULL DEFAULT 0,
  `cartoon_quantity` double NOT NULL DEFAULT 0,
  `cartoon_amount` double NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_stocks`
--

INSERT INTO `product_stocks` (`id`, `shop_id`, `purchase_line_id`, `lot_number`, `branch_id`, `pid`, `variation_id`, `purchase_price`, `sales_price`, `discount`, `discount_amount`, `vat`, `stock`, `is_cartoon`, `cartoon_quantity`, `cartoon_amount`, `created_at`, `updated_at`) VALUES
(6, 221013468, 6, '1', 2, 132, 0, '5.12', '6.041', 'flat', '50', '0', 480, 1, 24, 20, '2022-10-14 18:00:00', NULL),
(7, 221013160, 2, '1', 1, 1, 0, '50', '100', 'no', '0', '0', 80, 1, 20, 4, NULL, NULL),
(8, 221013341, 7, '1', 3, 6, 0, '16.3334', '20', 'no', '0', '0', 857, 1, 6, 142.83, '2022-10-14 18:00:00', NULL),
(9, 221013341, 8, '1', 3, 5, 0, '10.667', '13', 'no', '0', '0', 2191, 1, 12, 182.58, '2022-10-14 18:00:00', NULL),
(10, 221013341, 9, '1', 3, 4, 0, '6.5', '8', 'no', '0', '0', 2240, 1, 20, 112, '2022-10-14 18:00:00', NULL),
(11, 221013468, 6, '1', 4, 132, 0, '5.12', '6.041', 'flat', '50', '0', 240, 1, 24, 10, NULL, NULL),
(12, 221013468, 5, '1', 4, 133, 0, '6.5', '8', 'percent', '5', '0', 220, 1, 20, 11, NULL, NULL),
(13, 221013468, 4, '1', 4, 134, 0, '10.667', '13', 'no', '0', '0', 60, 1, 12, 5, NULL, NULL),
(14, 221013468, 3, '1', 4, 135, 0, '16.3334', '20', 'no', '0', '0', 12, 1, 6, 2, NULL, NULL),
(15, 221013468, 10, '2', 2, 132, 0, '5.12', '6.041', 'flat', '50', '0', 239, 1, 24, 9.96, '2022-10-15 18:00:00', '2022-10-16 16:23:24'),
(16, 221013468, 11, '2', 2, 135, 0, '16.3334', '20', 'no', '0', '0', 60, 1, 6, 10, '2022-10-15 18:00:00', NULL),
(17, 221013468, 12, '2', 2, 134, 0, '10.667', '13', 'no', '0', '0', 134, 1, 12, 11.17, '2022-10-15 18:00:00', NULL),
(19, 221013341, 14, '1', 3, 24, 0, '33.5', '36', 'no', '0', '0', 927, 1, 30, 30.9, '2022-10-16 18:00:00', NULL),
(20, 221013341, 15, '1', 3, 25, 0, '45.16129', '50', 'no', '0', '0', 234, 1, 30, 7.8, '2022-10-16 18:00:00', NULL),
(21, 221013341, 16, '1', 3, 26, 0, '11.07695', '12.638', 'no', '0', '0', 2143, 1, 36, 59.53, '2022-09-30 18:00:00', NULL),
(22, 221013341, 17, '1', 3, 27, 0, '11.07709', '12.625', 'no', '0', '0', 2664, 1, 24, 111, '2022-09-30 18:00:00', NULL),
(23, 221013341, 18, '1', 3, 28, 0, '12', '12.625', 'no', '0', '0', 40, 1, 24, 1.67, '2022-09-30 18:00:00', NULL),
(24, 221013341, 19, '1', 3, 29, 0, '12', '12.625', 'no', '0', '0', 31, 1, 24, 1.29, '2022-09-30 18:00:00', NULL),
(25, 221013341, 20, '1', 3, 30, 0, '16', '16.875', 'no', '0', '0', 468, 1, 48, 9.75, '2022-09-30 18:00:00', NULL),
(26, 221013341, 21, '1', 3, 31, 0, '28', '29.445', 'no', '0', '0', 68, 1, 18, 3.78, '2022-09-30 18:00:00', NULL),
(27, 221013341, 22, '1', 3, 32, 0, '8.334', '8.666', 'no', '0', '0', 2204, 1, 24, 91.83, '2022-09-30 18:00:00', NULL),
(28, 221013341, 23, '1', 3, 33, 0, '37.6477', '42', 'no', '0', '0', 0, 1, 8, 0, '2022-09-30 18:00:00', NULL),
(29, 221013341, 24, '1', 3, 34, 0, '40', '42', 'no', '0', '0', 316, 1, 8, 39.5, '2022-09-30 18:00:00', NULL),
(30, 221013341, 25, '1', 3, 35, 0, '48', '50', 'no', '0', '0', 284, 1, 8, 35.5, '2022-09-30 18:00:00', NULL),
(31, 221013341, 26, '1', 3, 36, 0, '48', '50', 'no', '0', '0', 396, 1, 8, 49.5, '2022-09-30 18:00:00', NULL),
(32, 221013341, 27, '1', 3, 37, 0, '16', '16.75', 'no', '0', '0', 0, 1, 24, 0, '2022-09-30 18:00:00', NULL),
(33, 221013341, 28, '1', 3, 38, 0, '3.60944', '3.789', 'no', '0', '0', 7200, 1, 72, 100, '2022-09-30 18:00:00', NULL),
(34, 221013341, 29, '1', 3, 39, 0, '11.9', '12', 'no', '0', '0', 0, 1, 480, 0, '2022-09-30 18:00:00', NULL),
(35, 221013341, 30, '1', 3, 40, 0, '11.5', '12', 'no', '0', '0', 5414, 1, 80, 67.67, '2022-09-30 18:00:00', NULL),
(36, 221013341, 31, '1', 3, 41, 0, '123.42834', '125', 'no', '0', '0', 91, 1, 6, 15.17, '2022-09-30 18:00:00', NULL),
(37, 221013341, 32, '1', 3, 42, 0, '286', '300', 'no', '0', '0', 60, 1, 6, 10, '2022-09-30 18:00:00', NULL),
(38, 221013341, 33, '1', 3, 43, 0, '12', '12.625', 'no', '0', '0', 37, 1, 24, 1.54, '2022-09-30 18:00:00', NULL),
(39, 221013341, 34, '1', 3, 44, 0, '37.6477', '42', 'no', '0', '0', 193, 1, 8, 24.13, '2022-09-30 18:00:00', NULL),
(40, 221013341, 35, '1', 3, 45, 0, '4', '4.166', 'no', '0', '0', 1250, 1, 72, 17.36, '2022-09-30 18:00:00', NULL),
(41, 221013341, 36, '1', 3, 46, 0, '3.636375', '3.8', 'no', '0', '0', 320, 1, 160, 2, '2022-09-30 18:00:00', NULL),
(42, 221013341, 37, '1', 3, 47, 0, '4.4', '4.65', 'no', '0', '0', 10700, 1, 400, 26.75, '2022-09-30 18:00:00', NULL),
(43, 221013341, 38, '1', 3, 48, 0, '16', '17', 'no', '0', '0', 264, 1, 40, 6.6, '2022-09-30 18:00:00', NULL),
(44, 221013341, 39, '1', 3, 49, 0, '40', '42', 'no', '0', '0', 48, 1, 20, 2.4, '2022-09-30 18:00:00', NULL),
(45, 221013341, 40, '1', 3, 50, 0, '214', '225', 'no', '0', '0', 1, 1, 6, 0.17, '2022-09-30 18:00:00', NULL),
(46, 221013341, 41, '1', 3, 51, 0, '375', '392.5', 'no', '0', '0', 5, 1, 6, 0.83, '2022-09-30 18:00:00', NULL),
(47, 221013341, 42, '1', 3, 105, 0, '7.6325', '8.16', 'no', '0', '0', 761, 1, 24, 31.71, '2022-09-30 18:00:00', NULL),
(48, 221013341, 43, '1', 3, 107, 0, '3.7475', '4.01', 'no', '0', '0', 744, 1, 48, 15.5, '2022-09-30 18:00:00', NULL),
(49, 221013341, 44, '1', 3, 108, 0, '7.4767', '8', 'no', '0', '0', 2628, 1, 48, 54.75, '2022-09-30 18:00:00', NULL),
(50, 221013341, 45, '1', 3, 109, 0, '3.8942', '4', 'no', '0', '0', 1704, 1, 72, 23.67, '2022-09-30 18:00:00', NULL),
(51, 221013341, 46, '1', 3, 110, 0, '29.90645834', '32', 'no', '0', '0', 35, 1, 48, 0.73, '2022-09-30 18:00:00', NULL),
(52, 221013341, 47, '1', 3, 111, 0, '3.73835', '4', 'no', '0', '0', 6936, 1, 192, 36.13, '2022-09-30 18:00:00', NULL),
(53, 221013341, 48, '1', 3, 112, 0, '32.711', '35', 'no', '0', '0', 76, 1, 48, 1.58, '2022-09-30 18:00:00', NULL),
(54, 221013341, 49, '1', 3, 113, 0, '37.019', '39.6', 'no', '0', '0', 3168, 1, 288, 11, '2022-09-30 18:00:00', NULL),
(55, 221013341, 50, '1', 3, 114, 0, '42.99', '46', 'no', '0', '0', 53, 1, 6, 8.83, '2022-09-30 18:00:00', NULL),
(56, 221013341, 51, '1', 3, 115, 0, '7.6325', '8.16', 'no', '0', '0', 467, 1, 24, 19.46, '2022-09-30 18:00:00', NULL),
(57, 221013341, 52, '1', 3, 116, 0, '7.6325', '8.17', 'no', '0', '0', 929, 1, 24, 38.71, '2022-09-30 18:00:00', NULL),
(58, 221013341, 53, '1', 3, 117, 0, '3.7383', '4', 'no', '0', '0', 5712, 1, 192, 29.75, '2022-09-30 18:00:00', NULL),
(59, 221013341, 54, '1', 3, 118, 0, '3.701', '3.9588', 'no', '0', '0', 1920, 1, 192, 10, '2022-09-30 18:00:00', NULL),
(60, 221013341, 55, '1', 3, 119, 0, '57.94375', '62', 'no', '0', '0', 20, 1, 48, 0.42, '2022-09-30 18:00:00', NULL),
(61, 221013341, 56, '1', 3, 121, 0, '37.388', '40', 'no', '0', '0', 54, 1, 24, 2.25, '2022-09-30 18:00:00', NULL),
(62, 221013341, 57, '1', 3, 122, 0, '70.085', '75', 'no', '0', '0', 26, 1, 12, 2.17, '2022-09-30 18:00:00', NULL),
(63, 221013341, 58, '1', 3, 124, 0, '37.3834', '40', 'no', '0', '0', 126, 1, 6, 21, '2022-09-30 18:00:00', NULL),
(64, 221013341, 59, '1', 3, 126, 0, '3.7475', '4.01', 'no', '0', '0', 48, 1, 24, 2, '2022-09-30 18:00:00', NULL),
(65, 221013341, 60, '1', 3, 128, 0, '3.738334', '4', 'no', '0', '0', 7, 1, 60, 0.12, '2022-09-30 18:00:00', NULL),
(66, 221013341, 61, '1', 3, 129, 0, '35.51334', '38', 'no', '0', '0', 299, 1, 6, 49.83, '2022-09-30 18:00:00', NULL),
(67, 221013341, 62, '1', 3, 130, 0, '46.81167', '50', 'no', '0', '0', 106, 1, 6, 17.67, '2022-09-30 18:00:00', NULL),
(68, 221013341, 63, '1', 3, 131, 0, '13.08417', '14', 'no', '0', '0', 120, 1, 24, 5, '2022-09-30 18:00:00', NULL),
(69, 221013341, 64, '1', 3, 54, 0, '172.5', '182.85', 'no', '0', '0', 11, 1, 15, 0.73, '2022-09-30 18:00:00', NULL),
(70, 221013341, 65, '1', 3, 56, 0, '198.5', '210', 'no', '0', '0', 1, 1, 15, 0.07, '2022-09-30 18:00:00', NULL),
(71, 221013341, 66, '1', 3, 57, 0, '34', '36.04', 'no', '0', '0', 1, 1, 56, 0.02, '2022-09-30 18:00:00', NULL),
(72, 221013341, 67, '1', 3, 60, 0, '35', '37', 'no', '0', '0', 309, 1, 56, 5.52, '2022-09-30 18:00:00', NULL),
(73, 221013341, 68, '1', 3, 61, 0, '180', '190', 'no', '0', '0', 335, 1, 15, 22.33, '2022-09-30 18:00:00', NULL),
(74, 221013341, 69, '1', 3, 62, 0, '151.11', '160', 'no', '0', '0', 138, 1, 12, 11.5, '2022-09-30 18:00:00', NULL),
(75, 221013341, 70, '1', 3, 64, 0, '206.47', '215', 'no', '0', '0', 20, 1, 15, 1.33, '2022-09-30 18:00:00', NULL),
(76, 221013341, 71, '1', 3, 66, 0, '172.5', '179.82', 'no', '0', '0', 11, 1, 15, 0.73, '2022-09-30 18:00:00', NULL),
(77, 221013341, 72, '1', 3, 69, 0, '210', '240', 'no', '0', '0', 108, 1, 15, 7.2, '2022-09-30 18:00:00', NULL),
(78, 221013341, 73, '1', 3, 71, 0, '32.8125', '34.78', 'no', '0', '0', 72, 1, 50, 1.44, '2022-09-30 18:00:00', NULL),
(79, 221013341, 74, '1', 3, 73, 0, '210', '220', 'no', '0', '0', 121, 1, 6, 20.17, '2022-09-30 18:00:00', NULL),
(80, 221013341, 75, '1', 3, 74, 0, '339', '360', 'no', '0', '0', 14, 1, 6, 2.33, '2022-09-30 18:00:00', NULL),
(81, 221013341, 76, '1', 3, 75, 0, '292.7', '310', 'no', '0', '0', 8, 1, 6, 1.33, '2022-09-30 18:00:00', NULL),
(82, 221013341, 77, '1', 3, 78, 0, '8.7811', '9.328', 'no', '0', '0', 1136, 1, 80, 14.2, '2022-09-30 18:00:00', NULL),
(83, 221013341, 78, '1', 3, 79, 0, '13.574', '14.38844', 'no', '0', '0', 220, 1, 48, 4.58, '2022-09-30 18:00:00', NULL),
(84, 221013341, 79, '1', 3, 80, 0, '17.5926', '19', 'no', '0', '0', 708, 1, 24, 29.5, '2022-09-30 18:00:00', NULL),
(85, 221013341, 80, '1', 3, 81, 0, '210', '212', 'no', '0', '0', 37, 1, 12, 3.08, '2022-09-30 18:00:00', NULL),
(86, 221013341, 81, '1', 3, 82, 0, '172.5', '182.85', 'no', '0', '0', 12, 1, 15, 0.8, '2022-09-30 18:00:00', NULL),
(87, 221013341, 82, '1', 3, 83, 0, '20.68', '17.5', 'no', '0', '0', 1152, 1, 24, 48, '2022-09-30 18:00:00', NULL),
(88, 221013341, 83, '1', 3, 86, 0, '3.878208', '4.282188', 'no', '0', '0', 2664, 1, 72, 37, '2022-09-30 18:00:00', NULL),
(89, 221013341, 84, '1', 3, 87, 0, '3.72924', '4', 'no', '0', '0', 1728, 1, 72, 24, '2022-09-30 18:00:00', NULL),
(90, 221013341, 85, '1', 3, 88, 0, '229.35', '245', 'no', '0', '0', 9, 1, 6, 1.5, '2022-09-30 18:00:00', NULL),
(91, 221013341, 86, '1', 3, 91, 0, '7.83', '8.308', 'no', '0', '0', 336, 1, 48, 7, '2022-09-30 18:00:00', NULL),
(92, 221013341, 87, '1', 3, 95, 0, '48', '54', 'no', '0', '0', 42, 1, 12, 3.5, '2022-09-30 18:00:00', NULL),
(93, 221013341, 88, '1', 3, 96, 0, '204.5455', '205', 'no', '0', '0', 22, 1, 15, 1.47, '2022-09-30 18:00:00', NULL),
(94, 221013341, 89, '1', 3, 97, 0, '65.94', '80', 'no', '0', '0', 1, 1, 20, 0.05, '2022-09-30 18:00:00', NULL),
(95, 221013341, 90, '1', 3, 98, 0, '90.5661', '100', 'no', '0', '0', 37, 1, 48, 0.77, '2022-09-30 18:00:00', NULL),
(96, 221013341, 91, '1', 3, 99, 0, '145', '155', 'no', '0', '0', 24, 1, 48, 0.5, '2022-09-30 18:00:00', NULL),
(97, 221013341, 92, '1', 3, 100, 0, '225', '240', 'no', '0', '0', 41, 1, 8, 5.13, '2022-09-30 18:00:00', NULL),
(98, 221013341, 93, '1', 3, 101, 0, '210', '222.6', 'no', '0', '0', 17, 1, 15, 1.13, '2022-09-30 18:00:00', NULL),
(99, 221013341, 94, '1', 3, 102, 0, '210', '222.6', 'no', '0', '0', 88, 1, 15, 5.87, '2022-09-30 18:00:00', NULL),
(100, 221013341, 95, '1', 3, 103, 0, '328.026', '347.71', 'no', '0', '0', 43, 1, 6, 7.17, '2022-09-30 18:00:00', NULL),
(101, 221013341, 96, '1', 3, 84, 0, '7.7131', '9', 'no', '0', '0', 3600, 1, 72, 50, '2022-09-30 18:00:00', NULL),
(102, 221013341, 97, '1', 3, 104, 0, '210', '222.6', 'no', '0', '0', 45, 1, 12, 3.75, '2022-09-30 18:00:00', NULL),
(103, 221013468, 98, '3', 2, 135, 0, '16.3334', '20', 'no', '0', '0', 600, 1, 6, 100, '2022-10-16 18:00:00', NULL),
(104, 221013468, 99, '3', 2, 134, 0, '10.667', '13', 'no', '0', '0', 1200, 1, 12, 100, '2022-10-16 18:00:00', NULL),
(105, 221013468, 100, '3', 2, 133, 0, '6.5', '8', 'percent', '5', '0', 2000, 1, 20, 100, '2022-10-16 18:00:00', NULL),
(106, 221013468, 101, '3', 2, 132, 0, '5.12', '6.041', 'flat', '50', '0', 2400, 1, 24, 100, '2022-10-16 18:00:00', NULL),
(107, 221013341, 102, '1', 3, 7, 0, '67.25', '71.29', 'no', '0', '0', 137, 1, 36, 3.81, '2022-09-30 18:00:00', NULL),
(108, 221013341, 103, '1', 3, 8, 0, '106', '113.5', 'no', '0', '0', 85, 1, 24, 3.54, '2022-09-30 18:00:00', NULL),
(109, 221013341, 104, '1', 3, 9, 0, '113.8334', '120.67', 'no', '0', '0', 48, 1, 24, 2, '2022-09-30 18:00:00', NULL),
(110, 221013341, 105, '1', 3, 11, 0, '67.83334', '67.7', 'no', '0', '0', 36, 1, 36, 1, '2022-09-30 18:00:00', NULL),
(112, 221013341, 107, '1', 3, 12, 0, '106', '110', 'no', '0', '0', 37, 1, 24, 1.54, '2022-09-30 18:00:00', NULL),
(113, 221013341, 108, '1', 3, 13, 0, '60.3334', '63.96', 'no', '0', '0', 36, 1, 36, 1, '2022-09-30 18:00:00', NULL),
(115, 221013341, 110, '1', 3, 15, 0, '135.6667', '143.83', 'no', '0', '0', 72, 1, 12, 6, '2022-09-30 18:00:00', NULL),
(116, 221013341, 111, '1', 3, 16, 0, '159.66', '169.25', 'no', '0', '0', 0, 1, 12, 0, '2022-09-30 18:00:00', NULL),
(117, 221013341, 112, '1', 3, 17, 0, '70.16667', '71.96', 'no', '0', '0', 54, 1, 18, 3, '2022-09-30 18:00:00', NULL),
(118, 221013341, 113, '1', 3, 18, 0, '143.68', '152.31', 'no', '0', '0', 0, 1, 16, 0, '2022-09-30 18:00:00', NULL),
(119, 221013341, 114, '1', 3, 19, 0, '104.45834', '110.72584', 'no', '0', '0', 23, 1, 24, 0.96, '2022-09-30 18:00:00', NULL),
(120, 221013341, 115, '1', 3, 20, 0, '231.5834', '245.48', 'no', '0', '0', 12, 1, 12, 1, '2022-09-30 18:00:00', NULL),
(121, 221013341, 116, '1', 3, 21, 0, '155.6667', '165.01', 'no', '0', '0', 168, 1, 12, 14, '2022-09-30 18:00:00', NULL),
(122, 221013341, 117, '1', 3, 22, 0, '127.91664', '135.6', 'no', '0', '0', 23, 1, 12, 1.92, '2022-09-30 18:00:00', NULL),
(123, 221013341, 118, '1', 3, 144, 0, '70.17', '74.38', 'no', '0', '0', 0, 1, 18, 0, '2022-09-30 18:00:00', NULL),
(124, 221013341, 119, '1', 3, 143, 0, '159.66', '169.25', 'no', '0', '0', 0, 1, 12, 0, '2022-09-30 18:00:00', NULL),
(125, 221013341, 120, '1', 3, 142, 0, '117.75', '126.93', 'no', '0', '0', 64, 1, 16, 4, '2022-09-30 18:00:00', NULL),
(126, 221013341, 121, '1', 3, 23, 0, '71.9', '90', 'no', '0', '0', 24, 1, 24, 1, '2022-09-30 18:00:00', NULL),
(127, 221013341, 122, '2', 3, 142, 0, '117.75', '126.93', 'no', '0', '0', 32, 1, 16, 2, '2022-10-05 18:00:00', NULL),
(128, 221013341, 123, '2', 3, 21, 0, '155.6667', '165.01', 'no', '0', '0', 108, 1, 12, 9, '2022-10-05 18:00:00', NULL),
(129, 221013341, 124, '2', 3, 16, 0, '159.59', '169.25', 'no', '0', '0', 12, 1, 12, 1, '2022-10-05 18:00:00', NULL),
(130, 221013341, 125, '2', 3, 13, 0, '60.3334', '63.96', 'no', '0', '0', 72, 1, 36, 2, '2022-10-05 18:00:00', NULL),
(131, 221013341, 126, '2', 3, 14, 0, '143.75', '152.25', 'no', '0', '0', 60, 1, 12, 5, '2022-10-05 18:00:00', NULL),
(132, 221013341, 127, '2', 3, 20, 0, '234.25', '245.48', 'no', '0', '0', 24, 1, 12, 2, '2022-10-05 18:00:00', NULL),
(133, 221013341, 128, '2', 3, 19, 0, '104.45834', '110.72584', 'no', '0', '0', 96, 1, 24, 4, '2022-10-05 18:00:00', NULL),
(134, 221013341, 129, '2', 3, 12, 0, '106', '110', 'no', '0', '0', 72, 1, 24, 3, '2022-10-05 18:00:00', NULL),
(135, 221013341, 130, '2', 3, 11, 0, '67.83334', '67.7', 'no', '0', '0', 108, 1, 36, 3, '2022-10-05 18:00:00', NULL),
(136, 221013341, 131, '2', 3, 10, 0, '67.25', '71.91', 'no', '0', '0', 108, 1, 36, 3, '2022-10-05 18:00:00', NULL),
(137, 221013341, 132, '2', 3, 8, 0, '106', '113.5', 'no', '0', '0', 72, 1, 24, 3, '2022-10-05 18:00:00', NULL),
(138, 221013341, 133, '2', 3, 7, 0, '67.25', '71.29', 'no', '0', '0', 180, 1, 36, 5, '2022-10-05 18:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_trackers`
--

CREATE TABLE `product_trackers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shop_id` int(11) NOT NULL,
  `purchase_line_id` int(11) DEFAULT NULL,
  `lot_number` int(11) DEFAULT NULL,
  `purchase_price` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `total_purchase_price` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `sales_price` double NOT NULL DEFAULT 0,
  `variation_id` int(11) NOT NULL DEFAULT 0,
  `branch_id` int(11) DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` double NOT NULL DEFAULT 0,
  `is_cartoon` int(11) DEFAULT 0,
  `cartoon_quantity` double DEFAULT 0,
  `cartoon_amount` double DEFAULT 0,
  `price` double NOT NULL DEFAULT 0,
  `discount` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no',
  `discount_amount` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `discount_in_tk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `vat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `vat_in_tk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `total_price` double NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL,
  `product_form` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `invoice_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `supplier_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_trackers`
--

INSERT INTO `product_trackers` (`id`, `shop_id`, `purchase_line_id`, `lot_number`, `purchase_price`, `total_purchase_price`, `sales_price`, `variation_id`, `branch_id`, `product_id`, `quantity`, `is_cartoon`, `cartoon_quantity`, `cartoon_amount`, `price`, `discount`, `discount_amount`, `discount_in_tk`, `vat`, `vat_in_tk`, `total_price`, `status`, `product_form`, `invoice_id`, `supplier_id`, `note`, `created_at`, `updated_at`) VALUES
(1, 221013160, 1, 1, '10', '2000', 20, 0, 1, 2, 200, 1, 20, 10, 10, 'no', '0', '0', '0', '0', 2000, 1, 'SUPP_TO_B', 'STB_221013160_1', '1', 'Note', '2022-10-14 18:00:00', NULL),
(2, 221013160, 2, 1, '50', '20000', 100, 0, 1, 1, 400, 1, 20, 20, 50, 'no', '0', '0', '0', '0', 20000, 1, 'SUPP_TO_B', 'STB_221013160_1', '1', 'Note', '2022-10-14 18:00:00', NULL),
(3, 221013160, 1, 1, '10', '0', 20, 0, 1, 2, 100, 1, 20, 5, 0, 'no', '0', '0', '0', '0', 0, 1, 'BTSR', 'BTSR_T_221013160_1', NULL, 'Note', '2022-10-14 18:00:00', NULL),
(4, 221013160, 2, 1, '50', '0', 100, 0, 1, 1, 200, 1, 20, 10, 0, 'no', '0', '0', '0', '0', 0, 1, 'BTSR', 'BTSR_T_221013160_1', NULL, 'Note', '2022-10-14 18:00:00', NULL),
(5, 221013160, 1, 1, '10', '200', 20, 0, 6, 2, 20, 1, 20, 1, 20, 'no', '0', '0', '0', '0', 400, 0, 'S', 'S_221013160_6_1', '1', NULL, '2022-10-14 18:00:00', NULL),
(6, 221013160, 2, 1, '50', '1000', 100, 0, 6, 1, 20, 1, 20, 1, 100, 'no', '0', '0', '0', '0', 2000, 0, 'S', 'S_221013160_6_1', '1', NULL, '2022-10-14 18:00:00', NULL),
(7, 221013160, 2, 1, '50', '10000', 100, 0, 1, 1, 200, 1, 20, 10, 50, 'no', '0', '0', '0', '0', 10000, 0, 'SUPP_R', 'SDR_221013160_1', '1', NULL, '2022-10-15 05:56:33', NULL),
(8, 221013160, 1, 1, '10', '200', 20, 0, 1, 2, 20, 1, 20, 1, 10, 'no', '0', '0', '0', '0', 200, 0, 'SUPP_R', 'SDR_221013160_2', '1', NULL, '2022-10-15 05:58:35', NULL),
(9, 221013468, 3, 1, '16.3334', '980.004', 20, 0, 2, 135, 60, 1, 6, 10, 16.3334, 'no', '0', '0', '0', '0', 980.004, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-10-14 18:00:00', NULL),
(10, 221013468, 4, 1, '10.667', '2560.08', 13, 0, 2, 134, 240, 1, 12, 20, 10.667, 'no', '0', '0', '0', '0', 2560.08, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-10-14 18:00:00', NULL),
(11, 221013468, 5, 1, '6.5', '3900', 8, 0, 2, 133, 600, 1, 20, 30, 6.5, 'percent', '5', '0', '0', '0', 3900, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-10-14 18:00:00', NULL),
(12, 221013468, 6, 1, '5.12', '4915.2', 6.041, 0, 2, 132, 960, 1, 24, 40, 5.12, 'flat', '50', '0', '0', '0', 4915.2, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-10-14 18:00:00', NULL),
(13, 221013468, 6, 1, '5.12', '0', 6.041, 0, 2, 132, 120, 1, 24, 5, 0, 'flat', '50', '0', '0', '0', 0, 1, 'BTSR', 'BTSR_T_221013468_1', NULL, 'for delivery', '2022-10-14 18:00:00', NULL),
(14, 221013468, 5, 1, '6.5', '0', 8, 0, 2, 133, 80, 1, 20, 4, 0, 'percent', '5', '0', '0', '0', 0, 1, 'BTSR', 'BTSR_T_221013468_1', NULL, 'for delivery', '2022-10-14 18:00:00', NULL),
(15, 221013468, 4, 1, '10.667', '0', 13, 0, 2, 134, 36, 1, 12, 3, 0, 'no', '0', '0', '0', '0', 0, 1, 'BTSR', 'BTSR_T_221013468_1', NULL, 'for delivery', '2022-10-14 18:00:00', NULL),
(16, 221013468, 3, 1, '16.3334', '0', 20, 0, 2, 135, 12, 1, 6, 2, 0, 'no', '0', '0', '0', '0', 0, 1, 'BTSR', 'BTSR_T_221013468_1', NULL, 'for delivery', '2022-10-14 18:00:00', NULL),
(17, 221013468, 3, 1, '16.3334', '0', 20, 0, 2, 135, 6, 1, 6, 1, 0, 'no', '0', '0', '0', '0', 0, 1, 'SRTB', 'SRTB_T_221013468_1', NULL, 'Note', '2022-10-14 18:00:00', NULL),
(18, 221013468, 4, 1, '10.667', '0', 13, 0, 2, 134, 24, 1, 12, 2, 0, 'no', '0', '0', '0', '0', 0, 1, 'SRTB', 'SRTB_T_221013468_1', NULL, 'Note', '2022-10-14 18:00:00', NULL),
(19, 221013468, 5, 1, '6.5', '0', 8, 0, 2, 133, 60, 1, 20, 3, 0, 'percent', '5', '0', '0', '0', 0, 1, 'SRTB', 'SRTB_T_221013468_1', NULL, 'Note', '2022-10-14 18:00:00', NULL),
(20, 221013468, 6, 1, '5.12', '0', 6.041, 0, 2, 132, 96, 1, 24, 4, 0, 'flat', '50', '0', '0', '0', 0, 1, 'SRTB', 'SRTB_T_221013468_1', NULL, 'Note', '2022-10-14 18:00:00', NULL),
(21, 221013468, 6, 1, '5.12', '0', 6.041, 0, 2, 132, 24, 1, 24, 1, 0, 'flat', '50', '0', '0', '0', 0, 1, 'SRTB', 'SRTB_T_221013468_2', NULL, 'Notem', '2022-10-14 18:00:00', NULL),
(22, 221013468, 3, 1, '16.3334', '16.3334', 20, 0, 7, 135, 1, 1, 6, 0.16666666666667, 20, 'no', '0', '0', '0', '0', 20, 0, 'S', 'S_221013468_7_1', '5', NULL, '2022-10-14 18:00:00', NULL),
(23, 221013468, 5, 1, '6.5', '6.5', 8, 0, 7, 133, 1, 1, 20, 0.05, 8, 'percent', '5', '0.4', '0', '0', 7.6, 0, 'S', 'S_221013468_7_1', '5', NULL, '2022-10-14 18:00:00', NULL),
(24, 221013468, 4, 1, '10.667', '10.667', 13, 0, 7, 134, 1, 1, 12, 0.083333333333333, 13, 'no', '0', '0', '0', '0', 13, 0, 'S', 'S_221013468_7_1', '5', NULL, '2022-10-14 18:00:00', NULL),
(25, 221013468, 3, 1, '16.3334', '81.667', 20, 0, 7, 135, 5, 1, 6, 0.83333333333333, 20, 'no', '0', '0', '0', '0', 100, 0, 'S', 'S_221013468_7_2', '6', NULL, '2022-10-14 18:00:00', NULL),
(26, 221013468, 4, 1, '10.667', '117.337', 13, 0, 7, 134, 11, 1, 12, 0.91666666666667, 13, 'no', '0', '0', '0', '0', 143, 0, 'S', 'S_221013468_7_2', '6', NULL, '2022-10-14 18:00:00', NULL),
(27, 221013468, 5, 1, '6.5', '123.5', 8, 0, 7, 133, 19, 1, 20, 0.95, 8, 'percent', '5', '7.6', '0', '0', 144.4, 0, 'S', 'S_221013468_7_2', '6', NULL, '2022-10-14 18:00:00', NULL),
(28, 221013160, 1, 1, '10', '0', 20, 0, 1, 2, 80, 1, 20, 4, 0, 'no', '0', '0', '0', '0', 0, 1, 'BTSR', 'BTSR_T_221013160_2', NULL, 'Note', '2022-10-14 18:00:00', NULL),
(29, 221013160, 2, 1, '50', '0', 100, 0, 1, 1, 180, 1, 20, 9, 0, 'no', '0', '0', '0', '0', 0, 1, 'SRTB', 'SRTB_T_221013160_1', NULL, 'Note', '2022-10-14 18:00:00', NULL),
(30, 221013468, 1, 1, '10', '600', 20, 0, 7, 2, 60, 1, 20, 3, 20, 'no', '0', '0', '0', '0', 1200, 0, 'S', 'S_221013468_7_3', '7', NULL, '2022-10-14 18:00:00', NULL),
(31, 221013341, 7, 1, '16.3334', '23797.7638', 20, 0, 3, 6, 1457, 1, 6, 242.83, 16.3334, 'no', '0', '0', '0', '0', 23797.7638, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-10-14 18:00:00', NULL),
(32, 221013341, 8, 1, '10.667', '36171.797', 13, 0, 3, 5, 3391, 1, 12, 282.58, 10.667, 'no', '0', '0', '0', '0', 36171.797, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-10-14 18:00:00', NULL),
(33, 221013341, 9, 1, '6.5', '22360', 8, 0, 3, 4, 3440, 1, 20, 172, 6.5, 'no', '0', '0', '0', '0', 22360, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-10-14 18:00:00', NULL),
(34, 221013341, 7, 1, '16.3334', '0', 20, 0, 3, 6, 600, 1, 6, 100, 0, 'no', '0', '0', '0', '0', 0, 1, 'BTSR', 'BTSR_T_221013341_1', NULL, 'Note', '2022-10-14 18:00:00', NULL),
(35, 221013341, 8, 1, '10.667', '0', 13, 0, 3, 5, 1200, 1, 12, 100, 0, 'no', '0', '0', '0', '0', 0, 1, 'BTSR', 'BTSR_T_221013341_1', NULL, 'Note', '2022-10-14 18:00:00', NULL),
(36, 221013341, 9, 1, '6.5', '0', 8, 0, 3, 4, 1200, 1, 20, 60, 0, 'no', '0', '0', '0', '0', 0, 1, 'BTSR', 'BTSR_T_221013341_1', NULL, 'Note', '2022-10-14 18:00:00', NULL),
(37, 221013468, 1, 1, '10', '100', 20, 0, 7, 2, 10, 1, 20, 0.5, 20, 'no', '0', '0', '0', '0', 200, 0, 'S', 'S_221013468_7_4', '9', NULL, '2022-10-14 18:00:00', NULL),
(38, 221013468, 1, 1, '10', '50', 20, 0, 7, 2, 5, 1, 20, 0.25, 20, 'no', '0', '0', '0', '0', 100, 0, 'S', 'S_221013468_7_5', '10', NULL, '2022-10-14 18:00:00', NULL),
(39, 221013468, 4, 1, '10.667', '0', 13, 0, 2, 134, 60, 1, 12, 5, 0, 'no', '0', '0', '0', '0', 0, 1, 'BTSR', 'BTSR_T_221013468_2', NULL, 'Note', '2022-10-14 18:00:00', NULL),
(40, 221013468, 3, 1, '16.3334', '0', 20, 0, 2, 135, 12, 1, 6, 2, 0, 'no', '0', '0', '0', '0', 0, 1, 'BTSR', 'BTSR_T_221013468_2', NULL, 'Note', '2022-10-14 18:00:00', NULL),
(41, 221013468, 3, 1, '16.3334', '0', 20, 0, 2, 135, 12, 1, 6, 2, 0, 'no', '0', '0', '0', '0', 0, 1, 'SRTB', 'SRTB_T_221013468_3', NULL, 'Note', '2022-10-14 18:00:00', NULL),
(42, 221013468, 4, 1, '10.667', '0', 13, 0, 2, 134, 60, 1, 12, 5, 0, 'no', '0', '0', '0', '0', 0, 1, 'SRTB', 'SRTB_T_221013468_3', NULL, 'Note', '2022-10-14 18:00:00', NULL),
(43, 221013468, 6, 1, '5.12', '0', 6.041, 0, 2, 132, 240, 1, 24, 10, 0, 'flat', '50', '0', '0', '0', 0, 1, 'BTB', 'BTB_T_221013468_1', NULL, 'Note', '2022-10-14 18:00:00', NULL),
(44, 221013468, 5, 1, '6.5', '0', 8, 0, 2, 133, 220, 1, 20, 11, 0, 'percent', '5', '0', '0', '0', 0, 1, 'BTB', 'BTB_T_221013468_1', NULL, 'Note', '2022-10-14 18:00:00', NULL),
(45, 221013468, 4, 1, '10.667', '0', 13, 0, 2, 134, 60, 1, 12, 5, 0, 'no', '0', '0', '0', '0', 0, 1, 'BTB', 'BTB_T_221013468_1', NULL, 'Note', '2022-10-14 18:00:00', NULL),
(46, 221013468, 3, 1, '16.3334', '0', 20, 0, 2, 135, 12, 1, 6, 2, 0, 'no', '0', '0', '0', '0', 0, 1, 'BTB', 'BTB_T_221013468_1', NULL, 'Note', '2022-10-14 18:00:00', NULL),
(47, 221013468, 6, 1, '5.12', '0', 6.041, 0, 2, 132, 240, 1, 24, 10, 0, 'flat', '50', '0', '0', '0', 0, 1, 'BTSR', 'BTSR_T_221013468_3', NULL, 'Note', '2022-10-15 18:00:00', NULL),
(48, 221013468, 5, 1, '6.5', '0', 8, 0, 2, 133, 200, 1, 20, 10, 0, 'percent', '5', '0', '0', '0', 0, 1, 'BTSR', 'BTSR_T_221013468_3', NULL, 'Note', '2022-10-15 18:00:00', NULL),
(49, 221013468, 4, 1, '10.667', '0', 13, 0, 2, 134, 120, 1, 12, 10, 0, 'no', '0', '0', '0', '0', 0, 1, 'BTSR', 'BTSR_T_221013468_3', NULL, 'Note', '2022-10-15 18:00:00', NULL),
(50, 221013468, 3, 1, '16.3334', '0', 20, 0, 2, 135, 30, 1, 6, 5, 0, 'no', '0', '0', '0', '0', 0, 1, 'BTSR', 'BTSR_T_221013468_3', NULL, 'Note', '2022-10-15 18:00:00', NULL),
(51, 221013468, 10, 2, '5.12', '1228.8', 6.041, 0, 2, 132, 240, 1, 24, 10, 5.12, 'flat', '50', '0', '0', '0', 1228.8, 1, 'SUPP_TO_B', 'STB_221013468_1', '2', 'Note', '2022-10-15 18:00:00', NULL),
(52, 221013468, 11, 2, '16.3334', '980.004', 20, 0, 2, 135, 60, 1, 6, 10, 16.3334, 'no', '0', '0', '0', '0', 980.004, 1, 'SUPP_TO_B', 'STB_221013468_1', '2', 'Note', '2022-10-15 18:00:00', NULL),
(53, 221013468, 12, 2, '10.667', '1536.048', 13, 0, 2, 134, 144, 1, 12, 12, 10.667, 'no', '0', '0', '0', '0', 1536.048, 1, 'SUPP_TO_B', 'STB_221013468_1', '2', 'Note', '2022-10-15 18:00:00', NULL),
(54, 221013468, 13, 2, '6.5', '2600', 8, 0, 2, 133, 400, 1, 20, 20, 6.5, 'percent', '5', '0', '0', '0', 2600, 1, 'SUPP_TO_B', 'STB_221013468_1', '2', 'Note', '2022-10-15 18:00:00', NULL),
(55, 221013160, 2, 1, '50', '0', 100, 0, 1, 1, 100, 1, 20, 5, 0, 'no', '0', '0', '0', '0', 0, 1, 'BTSR', 'BTSR_T_221013160_3', NULL, 'Note', '2022-10-15 18:00:00', NULL),
(56, 221013160, 2, 1, '50', '2000', 100, 0, 6, 1, 40, 1, 20, 2, 100, 'no', '0', '0', '0', '0', 4000, 0, 'S', 'S_221013160_6_2', '1', NULL, '2022-10-15 18:00:00', NULL),
(57, 221013160, 2, 1, '50', '2000', 100, 0, 6, 1, 40, 1, 20, 2, 100, 'no', '0', '0', '0', '0', 4000, 0, 'S', 'S_221013160_6_3', '1', NULL, '2022-10-15 18:00:00', NULL),
(58, 221013468, 1, 1, '10', '10', 20, 0, 7, 2, 1, 1, 20, 0.05, 20, 'no', '0', '0', '0', '0', 20, 0, 'S', 'S_221013468_7_6', '12', NULL, '2022-10-15 18:00:00', NULL),
(59, 221013160, 2, 1, '50', '500', 100, 0, 6, 1, 10, 1, 20, 0.5, 100, 'no', '0', '0', '0', '0', 1000, 0, 'S', 'S_221013160_6_4', '1', NULL, '2022-10-15 18:00:00', NULL),
(60, 221013160, 2, 1, '50', '250', 100, 0, 6, 1, 5, 1, 20, 0.25, 100, 'no', '0', '0', '0', '0', 500, 0, 'S', 'S_221013160_6_5', '1', NULL, '2022-10-15 18:00:00', NULL),
(61, 221013468, 3, 1, '16.3334', '196.0008', 20, 0, 14, 135, 12, 1, 6, 2, 20, 'no', '0', '0', '0', '0', 240, 0, 'S', 'S_221013468_14_1', '14', NULL, '2022-10-15 18:00:00', NULL),
(62, 221013468, 4, 1, '10.667', '128.004', 13, 0, 14, 134, 12, 1, 12, 1, 13, 'no', '0', '0', '0', '0', 156, 0, 'S', 'S_221013468_14_1', '14', NULL, '2022-10-15 18:00:00', NULL),
(63, 221013468, 5, 1, '6.5', '390', 8, 0, 14, 133, 60, 1, 20, 3, 8, 'percent', '5', '24', '0', '0', 456, 0, 'S', 'S_221013468_14_1', '14', NULL, '2022-10-15 18:00:00', NULL),
(64, 221013468, 3, 1, '16.3334', '0', 20, 0, 2, 135, 18, 1, 6, 3, 0, 'no', '0', '0', '0', '0', 0, 1, 'SRTB', 'SRTB_T_221013468_4', NULL, 'Note', '2022-10-15 18:00:00', NULL),
(65, 221013468, 4, 1, '10.667', '0', 13, 0, 2, 134, 108, 1, 12, 9, 0, 'no', '0', '0', '0', '0', 0, 1, 'SRTB', 'SRTB_T_221013468_4', NULL, 'Note', '2022-10-15 18:00:00', NULL),
(66, 221013468, 5, 1, '6.5', '0', 8, 0, 2, 133, 140, 1, 20, 7, 0, 'percent', '5', '0', '0', '0', 0, 1, 'SRTB', 'SRTB_T_221013468_4', NULL, 'Note', '2022-10-15 18:00:00', NULL),
(67, 221013468, 6, 1, '5.12', '0', 6.041, 0, 2, 132, 240, 1, 24, 10, 0, 'flat', '50', '0', '0', '0', 0, 1, 'SRTB', 'SRTB_T_221013468_4', NULL, 'Note', '2022-10-15 18:00:00', NULL),
(68, 221013468, 12, 2, '10.667', '0', 13, 0, 2, 134, 24, 1, 12, 2, 0, 'no', '0', '0', '0', '0', 0, 1, 'BTSR', 'BTSR_T_221013468_4', NULL, 'Note', '2022-10-15 18:00:00', NULL),
(69, 221013468, 5, 1, '6.5', '0', 8, 0, 2, 133, 40, 1, 20, 2, 0, 'percent', '5', '0', '0', '0', 0, 1, 'BTSR', 'BTSR_T_221013468_4', NULL, 'Note', '2022-10-15 18:00:00', NULL),
(70, 221013468, 12, 2, '10.667', '106.67', 13, 0, 14, 134, 10, 1, 12, 0.83333333333333, 13, 'no', '0', '0', '0', '0', 130, 0, 'S', 'S_221013468_14_2', '15', NULL, '2022-10-15 18:00:00', NULL),
(71, 221013468, 5, 1, '6.5', '162.5', 8, 0, 14, 133, 25, 1, 20, 1.25, 8, 'percent', '5', '10', '0', '0', 190, 0, 'S', 'S_221013468_14_2', '15', NULL, '2022-10-15 18:00:00', NULL),
(72, 221013468, 12, 2, '10.667', '0', 13, 0, 2, 134, 14, 1, 12, 1.17, 0, 'no', '0', '0', '0', '0', 0, 1, 'SRTB', 'SRTB_T_221013468_5', NULL, 'Note', '2022-10-15 18:00:00', NULL),
(73, 221013468, 5, 1, '6.5', '0', 8, 0, 2, 133, 15, 1, 20, 0.75, 0, 'percent', '5', '0', '0', '0', 0, 1, 'SRTB', 'SRTB_T_221013468_5', NULL, 'Note', '2022-10-15 18:00:00', NULL),
(74, 221013468, 10, 2, '5.12', '5.12', 6.041, 0, 2, 132, 1, 1, 24, 0.04, 5.12, 'flat', '50', '0', '0', '0', 5.12, 0, 'DM', 'DM', NULL, 'nosto', '2022-10-16 16:23:24', NULL),
(75, 221013341, 14, 1, '33.5', '31054.5', 36, 0, 3, 24, 927, 1, 30, 30.9, 33.5, 'no', '0', '0', '0', '0', 31054.5, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-10-16 18:00:00', NULL),
(76, 221013341, 15, 1, '45.16129', '10567.74186', 50, 0, 3, 25, 234, 1, 30, 7.8, 45.16129, 'no', '0', '0', '0', '0', 10567.74186, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-10-16 18:00:00', NULL),
(77, 221013341, 16, 1, '11.07695', '23737.90385', 12.638, 0, 3, 26, 2143, 1, 36, 59.53, 11.07695, 'no', '0', '0', '0', '0', 23737.90385, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(78, 221013341, 17, 1, '11.07709', '29509.36776', 12.625, 0, 3, 27, 2664, 1, 24, 111, 11.07709, 'no', '0', '0', '0', '0', 29509.36776, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(79, 221013341, 18, 1, '12', '480', 12.625, 0, 3, 28, 40, 1, 24, 1.67, 12, 'no', '0', '0', '0', '0', 480, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(80, 221013341, 19, 1, '12', '372', 12.625, 0, 3, 29, 31, 1, 24, 1.29, 12, 'no', '0', '0', '0', '0', 372, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(81, 221013341, 20, 1, '16', '7488', 16.875, 0, 3, 30, 468, 1, 48, 9.75, 16, 'no', '0', '0', '0', '0', 7488, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(82, 221013341, 21, 1, '28', '1904', 29.445, 0, 3, 31, 68, 1, 18, 3.78, 28, 'no', '0', '0', '0', '0', 1904, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(83, 221013341, 22, 1, '8.334', '18368.136', 8.666, 0, 3, 32, 2204, 1, 24, 91.83, 8.334, 'no', '0', '0', '0', '0', 18368.136, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(84, 221013341, 23, 1, '37.6477', '0', 42, 0, 3, 33, 0, 1, 8, 0, 37.6477, 'no', '0', '0', '0', '0', 0, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(85, 221013341, 24, 1, '40', '12640', 42, 0, 3, 34, 316, 1, 8, 39.5, 40, 'no', '0', '0', '0', '0', 12640, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(86, 221013341, 25, 1, '48', '13632', 50, 0, 3, 35, 284, 1, 8, 35.5, 48, 'no', '0', '0', '0', '0', 13632, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(87, 221013341, 26, 1, '48', '19008', 50, 0, 3, 36, 396, 1, 8, 49.5, 48, 'no', '0', '0', '0', '0', 19008, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(88, 221013341, 27, 1, '16', '0', 16.75, 0, 3, 37, 0, 1, 24, 0, 16, 'no', '0', '0', '0', '0', 0, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(89, 221013341, 28, 1, '3.60944', '25987.968', 3.789, 0, 3, 38, 7200, 1, 72, 100, 3.60944, 'no', '0', '0', '0', '0', 25987.968, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(90, 221013341, 29, 1, '11.9', '0', 12, 0, 3, 39, 0, 1, 480, 0, 11.9, 'no', '0', '0', '0', '0', 0, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(91, 221013341, 30, 1, '11.5', '62261', 12, 0, 3, 40, 5414, 1, 80, 67.67, 11.5, 'no', '0', '0', '0', '0', 62261, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(92, 221013341, 31, 1, '123.42834', '11231.97894', 125, 0, 3, 41, 91, 1, 6, 15.17, 123.42834, 'no', '0', '0', '0', '0', 11231.97894, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(93, 221013341, 32, 1, '286', '17160', 300, 0, 3, 42, 60, 1, 6, 10, 286, 'no', '0', '0', '0', '0', 17160, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(94, 221013341, 33, 1, '12', '444', 12.625, 0, 3, 43, 37, 1, 24, 1.54, 12, 'no', '0', '0', '0', '0', 444, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(95, 221013341, 34, 1, '37.6477', '7266.0061', 42, 0, 3, 44, 193, 1, 8, 24.13, 37.6477, 'no', '0', '0', '0', '0', 7266.0061, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(96, 221013341, 35, 1, '4', '5000', 4.166, 0, 3, 45, 1250, 1, 72, 17.36, 4, 'no', '0', '0', '0', '0', 5000, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(97, 221013341, 36, 1, '3.636375', '1163.64', 3.8, 0, 3, 46, 320, 1, 160, 2, 3.636375, 'no', '0', '0', '0', '0', 1163.64, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(98, 221013341, 37, 1, '4.4', '47080', 4.65, 0, 3, 47, 10700, 1, 400, 26.75, 4.4, 'no', '0', '0', '0', '0', 47080, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(99, 221013341, 38, 1, '16', '4224', 17, 0, 3, 48, 264, 1, 40, 6.6, 16, 'no', '0', '0', '0', '0', 4224, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(100, 221013341, 39, 1, '40', '1920', 42, 0, 3, 49, 48, 1, 20, 2.4, 40, 'no', '0', '0', '0', '0', 1920, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(101, 221013341, 40, 1, '214', '214', 225, 0, 3, 50, 1, 1, 6, 0.17, 214, 'no', '0', '0', '0', '0', 214, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(102, 221013341, 41, 1, '375', '1875', 392.5, 0, 3, 51, 5, 1, 6, 0.83, 375, 'no', '0', '0', '0', '0', 1875, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(103, 221013341, 42, 1, '7.6325', '5808.3325', 8.16, 0, 3, 105, 761, 1, 24, 31.71, 7.6325, 'no', '0', '0', '0', '0', 5808.3325, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(104, 221013341, 43, 1, '3.7475', '2788.14', 4.01, 0, 3, 107, 744, 1, 48, 15.5, 3.7475, 'no', '0', '0', '0', '0', 2788.14, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(105, 221013341, 44, 1, '7.4767', '19648.7676', 8, 0, 3, 108, 2628, 1, 48, 54.75, 7.4767, 'no', '0', '0', '0', '0', 19648.7676, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(106, 221013341, 45, 1, '3.8942', '6635.7168', 4, 0, 3, 109, 1704, 1, 72, 23.67, 3.8942, 'no', '0', '0', '0', '0', 6635.7168, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(107, 221013341, 46, 1, '29.90645834', '1046.7260419', 32, 0, 3, 110, 35, 1, 48, 0.73, 29.90645834, 'no', '0', '0', '0', '0', 1046.7260419, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(108, 221013341, 47, 1, '3.73835', '25929.1956', 4, 0, 3, 111, 6936, 1, 192, 36.13, 3.73835, 'no', '0', '0', '0', '0', 25929.1956, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(109, 221013341, 48, 1, '32.711', '2486.036', 35, 0, 3, 112, 76, 1, 48, 1.58, 32.711, 'no', '0', '0', '0', '0', 2486.036, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(110, 221013341, 49, 1, '37.019', '117276.192', 39.6, 0, 3, 113, 3168, 1, 288, 11, 37.019, 'no', '0', '0', '0', '0', 117276.192, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(111, 221013341, 50, 1, '42.99', '2278.47', 46, 0, 3, 114, 53, 1, 6, 8.83, 42.99, 'no', '0', '0', '0', '0', 2278.47, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(112, 221013341, 51, 1, '7.6325', '3564.3775', 8.16, 0, 3, 115, 467, 1, 24, 19.46, 7.6325, 'no', '0', '0', '0', '0', 3564.3775, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(113, 221013341, 52, 1, '7.6325', '7090.5925', 8.17, 0, 3, 116, 929, 1, 24, 38.71, 7.6325, 'no', '0', '0', '0', '0', 7090.5925, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(114, 221013341, 53, 1, '3.7383', '21353.1696', 4, 0, 3, 117, 5712, 1, 192, 29.75, 3.7383, 'no', '0', '0', '0', '0', 21353.1696, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(115, 221013341, 54, 1, '3.701', '7105.92', 3.9588, 0, 3, 118, 1920, 1, 192, 10, 3.701, 'no', '0', '0', '0', '0', 7105.92, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(116, 221013341, 55, 1, '57.94375', '1158.875', 62, 0, 3, 119, 20, 1, 48, 0.42, 57.94375, 'no', '0', '0', '0', '0', 1158.875, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(117, 221013341, 56, 1, '37.388', '2018.952', 40, 0, 3, 121, 54, 1, 24, 2.25, 37.388, 'no', '0', '0', '0', '0', 2018.952, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(118, 221013341, 57, 1, '70.085', '1822.21', 75, 0, 3, 122, 26, 1, 12, 2.17, 70.085, 'no', '0', '0', '0', '0', 1822.21, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(119, 221013341, 58, 1, '37.3834', '4710.3084', 40, 0, 3, 124, 126, 1, 6, 21, 37.3834, 'no', '0', '0', '0', '0', 4710.3084, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(120, 221013341, 59, 1, '3.7475', '179.88', 4.01, 0, 3, 126, 48, 1, 24, 2, 3.7475, 'no', '0', '0', '0', '0', 179.88, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(121, 221013341, 60, 1, '3.738334', '26.168338', 4, 0, 3, 128, 7, 1, 60, 0.12, 3.738334, 'no', '0', '0', '0', '0', 26.168338, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(122, 221013341, 61, 1, '35.51334', '10618.48866', 38, 0, 3, 129, 299, 1, 6, 49.83, 35.51334, 'no', '0', '0', '0', '0', 10618.48866, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(123, 221013341, 62, 1, '46.81167', '4962.03702', 50, 0, 3, 130, 106, 1, 6, 17.67, 46.81167, 'no', '0', '0', '0', '0', 4962.03702, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(124, 221013341, 63, 1, '13.08417', '1570.1004', 14, 0, 3, 131, 120, 1, 24, 5, 13.08417, 'no', '0', '0', '0', '0', 1570.1004, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(125, 221013341, 64, 1, '172.5', '1897.5', 182.85, 0, 3, 54, 11, 1, 15, 0.73, 172.5, 'no', '0', '0', '0', '0', 1897.5, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(126, 221013341, 65, 1, '198.5', '198.5', 210, 0, 3, 56, 1, 1, 15, 0.07, 198.5, 'no', '0', '0', '0', '0', 198.5, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(127, 221013341, 66, 1, '34', '34', 36.04, 0, 3, 57, 1, 1, 56, 0.02, 34, 'no', '0', '0', '0', '0', 34, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(128, 221013341, 67, 1, '35', '10815', 37, 0, 3, 60, 309, 1, 56, 5.52, 35, 'no', '0', '0', '0', '0', 10815, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(129, 221013341, 68, 1, '180', '60300', 190, 0, 3, 61, 335, 1, 15, 22.33, 180, 'no', '0', '0', '0', '0', 60300, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(130, 221013341, 69, 1, '151.11', '20853.18', 160, 0, 3, 62, 138, 1, 12, 11.5, 151.11, 'no', '0', '0', '0', '0', 20853.18, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(131, 221013341, 70, 1, '206.47', '4129.4', 215, 0, 3, 64, 20, 1, 15, 1.33, 206.47, 'no', '0', '0', '0', '0', 4129.4, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(132, 221013341, 71, 1, '172.5', '1897.5', 179.82, 0, 3, 66, 11, 1, 15, 0.73, 172.5, 'no', '0', '0', '0', '0', 1897.5, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(133, 221013341, 72, 1, '210', '22680', 240, 0, 3, 69, 108, 1, 15, 7.2, 210, 'no', '0', '0', '0', '0', 22680, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(134, 221013341, 73, 1, '32.8125', '2362.5', 34.78, 0, 3, 71, 72, 1, 50, 1.44, 32.8125, 'no', '0', '0', '0', '0', 2362.5, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(135, 221013341, 74, 1, '210', '25410', 220, 0, 3, 73, 121, 1, 6, 20.17, 210, 'no', '0', '0', '0', '0', 25410, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(136, 221013341, 75, 1, '339', '4746', 360, 0, 3, 74, 14, 1, 6, 2.33, 339, 'no', '0', '0', '0', '0', 4746, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(137, 221013341, 76, 1, '292.7', '2341.6', 310, 0, 3, 75, 8, 1, 6, 1.33, 292.7, 'no', '0', '0', '0', '0', 2341.6, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(138, 221013341, 77, 1, '8.7811', '9975.3296', 9.328, 0, 3, 78, 1136, 1, 80, 14.2, 8.7811, 'no', '0', '0', '0', '0', 9975.3296, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(139, 221013341, 78, 1, '13.574', '2986.28', 14.38844, 0, 3, 79, 220, 1, 48, 4.58, 13.574, 'no', '0', '0', '0', '0', 2986.28, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(140, 221013341, 79, 1, '17.5926', '12455.5608', 19, 0, 3, 80, 708, 1, 24, 29.5, 17.5926, 'no', '0', '0', '0', '0', 12455.5608, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(141, 221013341, 80, 1, '210', '7770', 212, 0, 3, 81, 37, 1, 12, 3.08, 210, 'no', '0', '0', '0', '0', 7770, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(142, 221013341, 81, 1, '172.5', '2070', 182.85, 0, 3, 82, 12, 1, 15, 0.8, 172.5, 'no', '0', '0', '0', '0', 2070, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(143, 221013341, 82, 1, '20.68', '23823.36', 17.5, 0, 3, 83, 1152, 1, 24, 48, 20.68, 'no', '0', '0', '0', '0', 23823.36, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(144, 221013341, 83, 1, '3.878208', '10331.546112', 4.282188, 0, 3, 86, 2664, 1, 72, 37, 3.878208, 'no', '0', '0', '0', '0', 10331.546112, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(145, 221013341, 84, 1, '3.72924', '6444.12672', 4, 0, 3, 87, 1728, 1, 72, 24, 3.72924, 'no', '0', '0', '0', '0', 6444.12672, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(146, 221013341, 85, 1, '229.35', '2064.15', 245, 0, 3, 88, 9, 1, 6, 1.5, 229.35, 'no', '0', '0', '0', '0', 2064.15, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(147, 221013341, 86, 1, '7.83', '2630.88', 8.308, 0, 3, 91, 336, 1, 48, 7, 7.83, 'no', '0', '0', '0', '0', 2630.88, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(148, 221013341, 87, 1, '48', '2016', 54, 0, 3, 95, 42, 1, 12, 3.5, 48, 'no', '0', '0', '0', '0', 2016, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(149, 221013341, 88, 1, '204.5455', '4500.001', 205, 0, 3, 96, 22, 1, 15, 1.47, 204.5455, 'no', '0', '0', '0', '0', 4500.001, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(150, 221013341, 89, 1, '65.94', '65.94', 80, 0, 3, 97, 1, 1, 20, 0.05, 65.94, 'no', '0', '0', '0', '0', 65.94, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(151, 221013341, 90, 1, '90.5661', '3350.9457', 100, 0, 3, 98, 37, 1, 48, 0.77, 90.5661, 'no', '0', '0', '0', '0', 3350.9457, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(152, 221013341, 91, 1, '145', '3480', 155, 0, 3, 99, 24, 1, 48, 0.5, 145, 'no', '0', '0', '0', '0', 3480, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(153, 221013341, 92, 1, '225', '9225', 240, 0, 3, 100, 41, 1, 8, 5.13, 225, 'no', '0', '0', '0', '0', 9225, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(154, 221013341, 93, 1, '210', '3570', 222.6, 0, 3, 101, 17, 1, 15, 1.13, 210, 'no', '0', '0', '0', '0', 3570, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(155, 221013341, 94, 1, '210', '18480', 222.6, 0, 3, 102, 88, 1, 15, 5.87, 210, 'no', '0', '0', '0', '0', 18480, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(156, 221013341, 95, 1, '328.026', '14105.118', 347.71, 0, 3, 103, 43, 1, 6, 7.17, 328.026, 'no', '0', '0', '0', '0', 14105.118, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(157, 221013341, 96, 1, '7.7131', '27767.16', 9, 0, 3, 84, 3600, 1, 72, 50, 7.7131, 'no', '0', '0', '0', '0', 27767.16, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(158, 221013341, 97, 1, '210', '9450', 222.6, 0, 3, 104, 45, 1, 12, 3.75, 210, 'no', '0', '0', '0', '0', 9450, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(159, 221013468, 98, 3, '16.3334', '9800.04', 20, 0, 2, 135, 600, 1, 6, 100, 16.3334, 'no', '0', '0', '0', '0', 9800.04, 1, 'SUPP_TO_B', 'STB_221013468_2', '2', 'Note', '2022-10-16 18:00:00', NULL),
(160, 221013468, 99, 3, '10.667', '12800.4', 13, 0, 2, 134, 1200, 1, 12, 100, 10.667, 'no', '0', '0', '0', '0', 12800.4, 1, 'SUPP_TO_B', 'STB_221013468_2', '2', 'Note', '2022-10-16 18:00:00', NULL),
(161, 221013468, 100, 3, '6.5', '13000', 8, 0, 2, 133, 2000, 1, 20, 100, 6.5, 'percent', '5', '0', '0', '0', 13000, 1, 'SUPP_TO_B', 'STB_221013468_2', '2', 'Note', '2022-10-16 18:00:00', NULL),
(162, 221013468, 101, 3, '5.12', '12288', 6.041, 0, 2, 132, 2400, 1, 24, 100, 5.12, 'flat', '50', '0', '0', '0', 12288, 1, 'SUPP_TO_B', 'STB_221013468_2', '2', 'Note', '2022-10-16 18:00:00', NULL),
(163, 221013468, 13, 2, '6.5', '0', 8, 0, 2, 133, 400, 1, 20, 20, 0, 'percent', '5', '0', '0', '0', 0, 1, 'BTSR', 'BTSR_T_221013468_5', NULL, 'Note', '2022-10-16 18:00:00', NULL),
(164, 221013468, 3, 1, '16.3334', '0', 20, 0, 2, 135, 30, 1, 6, 5, 0, 'no', '0', '0', '0', '0', 0, 1, 'BTSR', 'BTSR_T_221013468_5', NULL, 'Note', '2022-10-16 18:00:00', NULL),
(165, 221013468, 4, 1, '10.667', '0', 13, 0, 2, 134, 156, 1, 12, 13, 0, 'no', '0', '0', '0', '0', 0, 1, 'BTSR', 'BTSR_T_221013468_5', NULL, 'Note', '2022-10-16 18:00:00', NULL),
(166, 221013468, 5, 1, '6.5', '0', 8, 0, 2, 133, 275, 1, 20, 13.75, 0, 'percent', '5', '0', '0', '0', 0, 1, 'BTSR', 'BTSR_T_221013468_5', NULL, 'Note', '2022-10-16 18:00:00', NULL),
(167, 221013468, 6, 1, '5.12', '0', 6.041, 0, 2, 132, 240, 1, 24, 10, 0, 'flat', '50', '0', '0', '0', 0, 1, 'BTSR', 'BTSR_T_221013468_5', NULL, 'Note', '2022-10-16 18:00:00', NULL),
(168, 221013341, 102, 1, '67.25', '16476.25', 71.29, 0, 3, 7, 245, 1, 36, 6.81, 67.25, 'no', '0', '0', '0', '0', 16476.25, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(169, 221013341, 103, 1, '106', '11554', 113.5, 0, 3, 8, 109, 1, 24, 4.54, 106, 'no', '0', '0', '0', '0', 11554, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(170, 221013341, 104, 1, '113.8334', '5464.0032', 120.67, 0, 3, 9, 48, 1, 24, 2, 113.8334, 'no', '0', '0', '0', '0', 5464.0032, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(171, 221013341, 105, 1, '67.83334', '9768.00096', 67.7, 0, 3, 11, 144, 1, 36, 4, 67.83334, 'no', '0', '0', '0', '0', 9768.00096, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(172, 221013341, 106, 1, '67.25', '7263', 71.91, 0, 3, 10, 108, 1, 36, 3, 67.25, 'no', '0', '0', '0', '0', 7263, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(173, 221013341, 107, 1, '106', '6466', 110, 0, 3, 12, 61, 1, 24, 2.54, 106, 'no', '0', '0', '0', '0', 6466, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(174, 221013341, 108, 1, '60.3334', '6516.0072', 63.96, 0, 3, 13, 108, 1, 36, 3, 60.3334, 'no', '0', '0', '0', '0', 6516.0072, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(175, 221013341, 109, 1, '143.75', '5175', 152.25, 0, 3, 14, 36, 1, 12, 3, 143.75, 'no', '0', '0', '0', '0', 5175, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(176, 221013341, 110, 1, '135.6667', '14652.0036', 143.83, 0, 3, 15, 108, 1, 12, 9, 135.6667, 'no', '0', '0', '0', '0', 14652.0036, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(177, 221013341, 111, 1, '159.66', '0', 169.25, 0, 3, 16, 0, 1, 12, 0, 159.66, 'no', '0', '0', '0', '0', 0, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(178, 221013341, 112, 1, '70.16667', '8841.00042', 71.96, 0, 3, 17, 126, 1, 18, 7, 70.16667, 'no', '0', '0', '0', '0', 8841.00042, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(179, 221013341, 113, 1, '143.68', '0', 152.31, 0, 3, 18, 0, 1, 16, 0, 143.68, 'no', '0', '0', '0', '0', 0, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(180, 221013341, 114, 1, '104.45834', '9923.5423', 110.72584, 0, 3, 19, 95, 1, 24, 3.96, 104.45834, 'no', '0', '0', '0', '0', 9923.5423, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(181, 221013341, 115, 1, '231.5834', '8337.0024', 245.48, 0, 3, 20, 36, 1, 12, 3, 231.5834, 'no', '0', '0', '0', '0', 8337.0024, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(182, 221013341, 116, 1, '155.6667', '41096.0088', 165.01, 0, 3, 21, 264, 1, 12, 22, 155.6667, 'no', '0', '0', '0', '0', 41096.0088, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(183, 221013341, 117, 1, '127.91664', '2942.08272', 135.6, 0, 3, 22, 23, 1, 12, 1.92, 127.91664, 'no', '0', '0', '0', '0', 2942.08272, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(184, 221013341, 118, 1, '70.17', '0', 74.38, 0, 3, 144, 0, 1, 18, 0, 70.17, 'no', '0', '0', '0', '0', 0, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(185, 221013341, 119, 1, '159.66', '0', 169.25, 0, 3, 143, 0, 1, 12, 0, 159.66, 'no', '0', '0', '0', '0', 0, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(186, 221013341, 120, 1, '117.75', '11304', 126.93, 0, 3, 142, 96, 1, 16, 6, 117.75, 'no', '0', '0', '0', '0', 11304, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(187, 221013341, 121, 1, '71.9', '1725.6', 90, 0, 3, 23, 24, 1, 24, 1, 71.9, 'no', '0', '0', '0', '0', 1725.6, 1, 'OP', 'OPENING_STOCK', NULL, NULL, '2022-09-30 18:00:00', NULL),
(188, 221013341, 122, 2, '117.75', '3768', 126.93, 0, 3, 142, 32, 1, 16, 2, 117.75, 'no', '0', '0', '0', '0', 3768, 1, 'SUPP_TO_B', 'STB_221013341_1', '3', 'Product Short Delivery 4Ctn', '2022-10-05 18:00:00', NULL),
(189, 221013341, 123, 2, '155.6667', '16812.0036', 165.01, 0, 3, 21, 108, 1, 12, 9, 155.6667, 'no', '0', '0', '0', '0', 16812.0036, 1, 'SUPP_TO_B', 'STB_221013341_1', '3', 'Product Short Delivery 4Ctn', '2022-10-05 18:00:00', NULL),
(190, 221013341, 124, 2, '159.59', '3830.16', 169.25, 0, 3, 16, 24, 1, 12, 2, 159.59, 'no', '0', '0', '0', '0', 3830.16, 1, 'SUPP_TO_B', 'STB_221013341_1', '3', 'Product Short Delivery 4Ctn', '2022-10-05 18:00:00', NULL),
(191, 221013341, 125, 2, '60.3334', '4344.0048', 63.96, 0, 3, 13, 72, 1, 36, 2, 60.3334, 'no', '0', '0', '0', '0', 4344.0048, 1, 'SUPP_TO_B', 'STB_221013341_1', '3', 'Product Short Delivery 4Ctn', '2022-10-05 18:00:00', NULL),
(192, 221013341, 126, 2, '143.75', '8625', 152.25, 0, 3, 14, 60, 1, 12, 5, 143.75, 'no', '0', '0', '0', '0', 8625, 1, 'SUPP_TO_B', 'STB_221013341_1', '3', 'Product Short Delivery 4Ctn', '2022-10-05 18:00:00', NULL),
(193, 221013341, 127, 2, '234.25', '5622', 245.48, 0, 3, 20, 24, 1, 12, 2, 234.25, 'no', '0', '0', '0', '0', 5622, 1, 'SUPP_TO_B', 'STB_221013341_1', '3', 'Product Short Delivery 4Ctn', '2022-10-05 18:00:00', NULL),
(194, 221013341, 128, 2, '104.45834', '10028.00064', 110.72584, 0, 3, 19, 96, 1, 24, 4, 104.45834, 'no', '0', '0', '0', '0', 10028.00064, 1, 'SUPP_TO_B', 'STB_221013341_1', '3', 'Product Short Delivery 4Ctn', '2022-10-05 18:00:00', NULL),
(195, 221013341, 129, 2, '106', '7632', 110, 0, 3, 12, 72, 1, 24, 3, 106, 'no', '0', '0', '0', '0', 7632, 1, 'SUPP_TO_B', 'STB_221013341_1', '3', 'Product Short Delivery 4Ctn', '2022-10-05 18:00:00', NULL),
(196, 221013341, 130, 2, '67.83334', '7326.00072', 67.7, 0, 3, 11, 108, 1, 36, 3, 67.83334, 'no', '0', '0', '0', '0', 7326.00072, 1, 'SUPP_TO_B', 'STB_221013341_1', '3', 'Product Short Delivery 4Ctn', '2022-10-05 18:00:00', NULL),
(197, 221013341, 131, 2, '67.25', '7263', 71.91, 0, 3, 10, 108, 1, 36, 3, 67.25, 'no', '0', '0', '0', '0', 7263, 1, 'SUPP_TO_B', 'STB_221013341_1', '3', 'Product Short Delivery 4Ctn', '2022-10-05 18:00:00', NULL),
(198, 221013341, 132, 2, '106', '7632', 113.5, 0, 3, 8, 72, 1, 24, 3, 106, 'no', '0', '0', '0', '0', 7632, 1, 'SUPP_TO_B', 'STB_221013341_1', '3', 'Product Short Delivery 4Ctn', '2022-10-05 18:00:00', NULL),
(199, 221013341, 133, 2, '67.25', '12105', 71.29, 0, 3, 7, 180, 1, 36, 5, 67.25, 'no', '0', '0', '0', '0', 12105, 1, 'SUPP_TO_B', 'STB_221013341_1', '3', 'Product Short Delivery 4Ctn', '2022-10-05 18:00:00', NULL),
(200, 221013341, 102, 1, '67.25', '0', 71.29, 0, 3, 7, 108, 1, 36, 3, 0, 'no', '0', '0', '0', '0', 0, 1, 'BTSR', 'BTSR_T_221013341_2', NULL, 'Note', '2022-10-07 18:00:00', NULL),
(201, 221013341, 103, 1, '106', '0', 113.5, 0, 3, 8, 24, 1, 24, 1, 0, 'no', '0', '0', '0', '0', 0, 1, 'BTSR', 'BTSR_T_221013341_2', NULL, 'Note', '2022-10-07 18:00:00', NULL),
(202, 221013341, 105, 1, '67.83334', '0', 67.7, 0, 3, 11, 108, 1, 36, 3, 0, 'no', '0', '0', '0', '0', 0, 1, 'BTSR', 'BTSR_T_221013341_2', NULL, 'Note', '2022-10-07 18:00:00', NULL),
(203, 221013341, 106, 1, '67.25', '0', 71.91, 0, 3, 10, 108, 1, 36, 3, 0, 'no', '0', '0', '0', '0', 0, 1, 'BTSR', 'BTSR_T_221013341_2', NULL, 'Note', '2022-10-07 18:00:00', NULL),
(204, 221013341, 107, 1, '106', '0', 110, 0, 3, 12, 24, 1, 24, 1, 0, 'no', '0', '0', '0', '0', 0, 1, 'BTSR', 'BTSR_T_221013341_2', NULL, 'Note', '2022-10-07 18:00:00', NULL),
(205, 221013341, 108, 1, '60.3334', '0', 63.96, 0, 3, 13, 72, 1, 36, 2, 0, 'no', '0', '0', '0', '0', 0, 1, 'BTSR', 'BTSR_T_221013341_2', NULL, 'Note', '2022-10-07 18:00:00', NULL),
(206, 221013341, 109, 1, '143.75', '0', 152.25, 0, 3, 14, 36, 1, 12, 3, 0, 'no', '0', '0', '0', '0', 0, 1, 'BTSR', 'BTSR_T_221013341_2', NULL, 'Note', '2022-10-07 18:00:00', NULL),
(207, 221013341, 110, 1, '135.6667', '0', 143.83, 0, 3, 15, 36, 1, 12, 3, 0, 'no', '0', '0', '0', '0', 0, 1, 'BTSR', 'BTSR_T_221013341_2', NULL, 'Note', '2022-10-07 18:00:00', NULL),
(208, 221013341, 124, 2, '159.59', '0', 169.25, 0, 3, 16, 12, 1, 12, 1, 0, 'no', '0', '0', '0', '0', 0, 1, 'BTSR', 'BTSR_T_221013341_2', NULL, 'Note', '2022-10-07 18:00:00', NULL),
(209, 221013341, 112, 1, '70.16667', '0', 71.96, 0, 3, 17, 72, 1, 18, 4, 0, 'no', '0', '0', '0', '0', 0, 1, 'BTSR', 'BTSR_T_221013341_2', NULL, 'Note', '2022-10-07 18:00:00', NULL),
(210, 221013341, 114, 1, '104.45834', '0', 110.72584, 0, 3, 19, 72, 1, 24, 3, 0, 'no', '0', '0', '0', '0', 0, 1, 'BTSR', 'BTSR_T_221013341_2', NULL, 'Note', '2022-10-07 18:00:00', NULL),
(211, 221013341, 115, 1, '231.5834', '0', 245.48, 0, 3, 20, 24, 1, 12, 2, 0, 'no', '0', '0', '0', '0', 0, 1, 'BTSR', 'BTSR_T_221013341_2', NULL, 'Note', '2022-10-07 18:00:00', NULL),
(212, 221013341, 116, 1, '155.6667', '0', 165.01, 0, 3, 21, 96, 1, 12, 8, 0, 'no', '0', '0', '0', '0', 0, 1, 'BTSR', 'BTSR_T_221013341_2', NULL, 'Note', '2022-10-07 18:00:00', NULL),
(213, 221013341, 120, 1, '117.75', '0', 126.93, 0, 3, 142, 32, 1, 16, 2, 0, 'no', '0', '0', '0', '0', 0, 1, 'BTSR', 'BTSR_T_221013341_2', NULL, 'Note', '2022-10-07 18:00:00', NULL),
(214, 221013341, 102, 1, '67.25', '7263', 71.29, 0, 24, 7, 108, 1, 36, 3, 71.29, 'no', '0', '0', '0', '0', 7699.32, 0, 'S', 'S_221013341_24_1', '16', NULL, '2022-10-16 18:00:00', NULL),
(215, 221013341, 103, 1, '106', '2544', 113.5, 0, 24, 8, 24, 1, 24, 1, 113.5, 'no', '0', '0', '0', '0', 2724, 0, 'S', 'S_221013341_24_1', '16', NULL, '2022-10-16 18:00:00', NULL),
(216, 221013341, 106, 1, '67.25', '7263', 71.91, 0, 24, 10, 108, 1, 36, 3, 71.91, 'no', '0', '0', '0', '0', 7766.28, 0, 'S', 'S_221013341_24_1', '16', NULL, '2022-10-16 18:00:00', NULL),
(217, 221013341, 105, 1, '67.83334', '7326.00072', 67.7, 0, 24, 11, 108, 1, 36, 3, 67.7, 'no', '0', '0', '0', '0', 7311.6, 0, 'S', 'S_221013341_24_1', '16', NULL, '2022-10-16 18:00:00', NULL),
(218, 221013341, 107, 1, '106', '2544', 110, 0, 24, 12, 24, 1, 24, 1, 110, 'no', '0', '0', '0', '0', 2640, 0, 'S', 'S_221013341_24_1', '16', NULL, '2022-10-16 18:00:00', NULL),
(219, 221013341, 108, 1, '60.3334', '4344.0048', 63.96, 0, 24, 13, 72, 1, 36, 2, 63.96, 'no', '0', '0', '0', '0', 4605.12, 0, 'S', 'S_221013341_24_1', '16', NULL, '2022-10-16 18:00:00', NULL),
(220, 221013341, 109, 1, '143.75', '5175', 152.25, 0, 24, 14, 36, 1, 12, 3, 152.25, 'no', '0', '0', '0', '0', 5481, 0, 'S', 'S_221013341_24_1', '16', NULL, '2022-10-16 18:00:00', NULL),
(221, 221013341, 110, 1, '135.6667', '4884.0012', 143.83, 0, 24, 15, 36, 1, 12, 3, 143.83, 'no', '0', '0', '0', '0', 5177.88, 0, 'S', 'S_221013341_24_1', '16', NULL, '2022-10-16 18:00:00', NULL),
(222, 221013341, 124, 2, '159.59', '1915.08', 169.25, 0, 24, 16, 12, 1, 12, 1, 169.25, 'no', '0', '0', '0', '0', 2031, 0, 'S', 'S_221013341_24_1', '16', NULL, '2022-10-16 18:00:00', NULL),
(223, 221013341, 112, 1, '70.16667', '5052.00024', 71.96, 0, 24, 17, 72, 1, 18, 4, 71.96, 'no', '0', '0', '0', '0', 5181.12, 0, 'S', 'S_221013341_24_1', '16', NULL, '2022-10-16 18:00:00', NULL),
(224, 221013341, 114, 1, '104.45834', '7521.00048', 110.72584, 0, 24, 19, 72, 1, 24, 3, 110.72584, 'no', '0', '0', '0', '0', 7972.26048, 0, 'S', 'S_221013341_24_1', '16', NULL, '2022-10-16 18:00:00', NULL),
(225, 221013341, 115, 1, '231.5834', '5558.0016', 245.48, 0, 24, 20, 24, 1, 12, 2, 245.48, 'no', '0', '0', '0', '0', 5891.52, 0, 'S', 'S_221013341_24_1', '16', NULL, '2022-10-16 18:00:00', NULL),
(226, 221013341, 116, 1, '155.6667', '14944.0032', 165.01, 0, 24, 21, 96, 1, 12, 8, 165.01, 'no', '0', '0', '0', '0', 15840.96, 0, 'S', 'S_221013341_24_1', '16', NULL, '2022-10-16 18:00:00', NULL),
(227, 221013341, 120, 1, '117.75', '3768', 126.93, 0, 24, 142, 32, 1, 16, 2, 126.93, 'no', '0', '0', '0', '0', 4061.76, 0, 'S', 'S_221013341_24_1', '16', NULL, '2022-10-16 18:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_variations`
--

CREATE TABLE `product_variations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shop_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_with_variations`
--

CREATE TABLE `product_with_variations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shop_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sku` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pid` int(11) NOT NULL,
  `variation_list_id` int(11) NOT NULL,
  `purchase_price` double DEFAULT NULL,
  `selling_price` double DEFAULT NULL,
  `barCode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tax` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dicount_amount` double DEFAULT NULL,
  `is_active` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_lines`
--

CREATE TABLE `purchase_lines` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shop_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `branch_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `invoice_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_id` int(11) NOT NULL,
  `purchase_price` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `sales_price` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `discount` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no',
  `discount_amount` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `vat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `lot_number` int(11) DEFAULT NULL,
  `mfg_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `exp_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `warranty_id` int(11) DEFAULT NULL,
  `warranty_period` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `variation_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `imei_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `is_cartoon` int(11) DEFAULT 0,
  `cartoon_quantity` double DEFAULT 0,
  `cartoon_amount` double DEFAULT 0,
  `note` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase_lines`
--

INSERT INTO `purchase_lines` (`id`, `shop_id`, `branch_id`, `invoice_id`, `product_id`, `purchase_price`, `sales_price`, `discount`, `discount_amount`, `vat`, `lot_number`, `mfg_date`, `exp_date`, `warranty_id`, `warranty_period`, `variation_id`, `imei_number`, `quantity`, `is_cartoon`, `cartoon_quantity`, `cartoon_amount`, `note`, `date`, `created_at`, `updated_at`) VALUES
(1, '221013160', '1', 'STB_221013160_1', 2, '10', '20', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '200.00', 1, 20, 10, NULL, '2022-10-15', '2022-10-15 04:51:27', '2022-10-15 04:51:27'),
(2, '221013160', '1', 'STB_221013160_1', 1, '50', '100', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '400.00', 1, 20, 20, NULL, '2022-10-15', '2022-10-15 04:51:27', '2022-10-15 04:51:27'),
(3, '221013468', '2', 'OPENING_STOCK', 135, '16.3334', '20', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '60.00', 1, 6, 10, NULL, '2022-10-15', '2022-10-15 10:56:02', '2022-10-15 10:56:02'),
(4, '221013468', '2', 'OPENING_STOCK', 134, '10.667', '13', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '240.00', 1, 12, 20, NULL, '2022-10-15', '2022-10-15 10:56:02', '2022-10-15 10:56:02'),
(5, '221013468', '2', 'OPENING_STOCK', 133, '6.5', '8', 'percent', '5', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '600.00', 1, 20, 30, NULL, '2022-10-15', '2022-10-15 10:56:02', '2022-10-15 10:56:02'),
(6, '221013468', '2', 'OPENING_STOCK', 132, '5.12', '6.041', 'flat', '50', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '960.00', 1, 24, 40, NULL, '2022-10-15', '2022-10-15 10:56:02', '2022-10-15 10:56:02'),
(7, '221013341', '3', 'OPENING_STOCK', 6, '16.3334', '20', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '1457', 1, 6, 242.83, NULL, '2022-10-15', '2022-10-15 13:04:55', '2022-10-15 13:04:55'),
(8, '221013341', '3', 'OPENING_STOCK', 5, '10.667', '13', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '3391', 1, 12, 282.58, NULL, '2022-10-15', '2022-10-15 13:04:55', '2022-10-15 13:04:55'),
(9, '221013341', '3', 'OPENING_STOCK', 4, '6.5', '8', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '3440', 1, 20, 172, NULL, '2022-10-15', '2022-10-15 13:04:55', '2022-10-15 13:04:55'),
(10, '221013468', '2', 'STB_221013468_1', 132, '5.12', '6.041', 'flat', '50', '0', 2, NULL, NULL, NULL, NULL, '0', NULL, '240.00', 1, 24, 10, NULL, '2022-10-16', '2022-10-16 09:08:21', '2022-10-16 09:08:21'),
(11, '221013468', '2', 'STB_221013468_1', 135, '16.3334', '20', 'no', '0', '0', 2, NULL, NULL, NULL, NULL, '0', NULL, '60.00', 1, 6, 10, NULL, '2022-10-16', '2022-10-16 09:08:21', '2022-10-16 09:08:21'),
(12, '221013468', '2', 'STB_221013468_1', 134, '10.667', '13', 'no', '0', '0', 2, NULL, NULL, NULL, NULL, '0', NULL, '144.00', 1, 12, 12, NULL, '2022-10-16', '2022-10-16 09:08:21', '2022-10-16 09:08:21'),
(13, '221013468', '2', 'STB_221013468_1', 133, '6.5', '8', 'percent', '5', '0', 2, NULL, NULL, NULL, NULL, '0', NULL, '400.00', 1, 20, 20, NULL, '2022-10-16', '2022-10-16 09:08:21', '2022-10-16 09:08:21'),
(14, '221013341', '3', 'OPENING_STOCK', 24, '33.5', '36', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '927', 1, 30, 30.9, NULL, '2022-10-17', '2022-10-17 06:31:32', '2022-10-17 06:31:32'),
(15, '221013341', '3', 'OPENING_STOCK', 25, '45.16129', '50', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '234', 1, 30, 7.8, NULL, '2022-10-17', '2022-10-17 06:31:32', '2022-10-17 06:31:32'),
(16, '221013341', '3', 'OPENING_STOCK', 26, '11.07695', '12.638', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '2143', 1, 36, 59.53, NULL, '2022-10-01', '2022-10-17 06:56:42', '2022-10-17 06:56:42'),
(17, '221013341', '3', 'OPENING_STOCK', 27, '11.07709', '12.625', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '2664', 1, 24, 111, NULL, '2022-10-01', '2022-10-17 06:56:42', '2022-10-17 06:56:42'),
(18, '221013341', '3', 'OPENING_STOCK', 28, '12', '12.625', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '40', 1, 24, 1.67, NULL, '2022-10-01', '2022-10-17 06:56:42', '2022-10-17 06:56:42'),
(19, '221013341', '3', 'OPENING_STOCK', 29, '12', '12.625', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '31', 1, 24, 1.29, NULL, '2022-10-01', '2022-10-17 06:56:43', '2022-10-17 06:56:43'),
(20, '221013341', '3', 'OPENING_STOCK', 30, '16', '16.875', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '468', 1, 48, 9.75, NULL, '2022-10-01', '2022-10-17 06:56:43', '2022-10-17 06:56:43'),
(21, '221013341', '3', 'OPENING_STOCK', 31, '28', '29.445', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '68', 1, 18, 3.78, NULL, '2022-10-01', '2022-10-17 06:56:43', '2022-10-17 06:56:43'),
(22, '221013341', '3', 'OPENING_STOCK', 32, '8.334', '8.666', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '2204', 1, 24, 91.83, NULL, '2022-10-01', '2022-10-17 06:56:44', '2022-10-17 06:56:44'),
(23, '221013341', '3', 'OPENING_STOCK', 33, '37.6477', '42', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '0', 1, 8, 0, NULL, '2022-10-01', '2022-10-17 06:56:44', '2022-10-17 06:56:44'),
(24, '221013341', '3', 'OPENING_STOCK', 34, '40', '42', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '316', 1, 8, 39.5, NULL, '2022-10-01', '2022-10-17 06:56:45', '2022-10-17 06:56:45'),
(25, '221013341', '3', 'OPENING_STOCK', 35, '48', '50', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '284', 1, 8, 35.5, NULL, '2022-10-01', '2022-10-17 06:56:45', '2022-10-17 06:56:45'),
(26, '221013341', '3', 'OPENING_STOCK', 36, '48', '50', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '396', 1, 8, 49.5, NULL, '2022-10-01', '2022-10-17 06:56:45', '2022-10-17 06:56:45'),
(27, '221013341', '3', 'OPENING_STOCK', 37, '16', '16.75', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '0', 1, 24, 0, NULL, '2022-10-01', '2022-10-17 06:56:46', '2022-10-17 06:56:46'),
(28, '221013341', '3', 'OPENING_STOCK', 38, '3.60944', '3.789', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '7200', 1, 72, 100, NULL, '2022-10-01', '2022-10-17 06:56:46', '2022-10-17 06:56:46'),
(29, '221013341', '3', 'OPENING_STOCK', 39, '11.9', '12', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '0', 1, 480, 0, NULL, '2022-10-01', '2022-10-17 06:56:47', '2022-10-17 06:56:47'),
(30, '221013341', '3', 'OPENING_STOCK', 40, '11.5', '12', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '5414', 1, 80, 67.67, NULL, '2022-10-01', '2022-10-17 06:56:47', '2022-10-17 06:56:47'),
(31, '221013341', '3', 'OPENING_STOCK', 41, '123.42834', '125', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '91', 1, 6, 15.17, NULL, '2022-10-01', '2022-10-17 06:56:47', '2022-10-17 06:56:47'),
(32, '221013341', '3', 'OPENING_STOCK', 42, '286', '300', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '60', 1, 6, 10, NULL, '2022-10-01', '2022-10-17 06:56:47', '2022-10-17 06:56:47'),
(33, '221013341', '3', 'OPENING_STOCK', 43, '12', '12.625', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '37', 1, 24, 1.54, NULL, '2022-10-01', '2022-10-17 06:56:47', '2022-10-17 06:56:47'),
(34, '221013341', '3', 'OPENING_STOCK', 44, '37.6477', '42', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '193', 1, 8, 24.13, NULL, '2022-10-01', '2022-10-17 06:56:48', '2022-10-17 06:56:48'),
(35, '221013341', '3', 'OPENING_STOCK', 45, '4', '4.166', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '1250', 1, 72, 17.36, NULL, '2022-10-01', '2022-10-17 06:56:48', '2022-10-17 06:56:48'),
(36, '221013341', '3', 'OPENING_STOCK', 46, '3.636375', '3.8', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '320', 1, 160, 2, NULL, '2022-10-01', '2022-10-17 06:56:48', '2022-10-17 06:56:48'),
(37, '221013341', '3', 'OPENING_STOCK', 47, '4.4', '4.65', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '10700', 1, 400, 26.75, NULL, '2022-10-01', '2022-10-17 06:56:49', '2022-10-17 06:56:49'),
(38, '221013341', '3', 'OPENING_STOCK', 48, '16', '17', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '264', 1, 40, 6.6, NULL, '2022-10-01', '2022-10-17 06:56:49', '2022-10-17 06:56:49'),
(39, '221013341', '3', 'OPENING_STOCK', 49, '40', '42', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '48', 1, 20, 2.4, NULL, '2022-10-01', '2022-10-17 06:56:50', '2022-10-17 06:56:50'),
(40, '221013341', '3', 'OPENING_STOCK', 50, '214', '225', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '1', 1, 6, 0.17, NULL, '2022-10-01', '2022-10-17 06:56:50', '2022-10-17 06:56:50'),
(41, '221013341', '3', 'OPENING_STOCK', 51, '375', '392.5', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '5', 1, 6, 0.83, NULL, '2022-10-01', '2022-10-17 06:56:50', '2022-10-17 06:56:50'),
(42, '221013341', '3', 'OPENING_STOCK', 105, '7.6325', '8.16', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '761', 1, 24, 31.71, NULL, '2022-10-01', '2022-10-17 07:42:49', '2022-10-17 07:42:49'),
(43, '221013341', '3', 'OPENING_STOCK', 107, '3.7475', '4.01', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '744', 1, 48, 15.5, NULL, '2022-10-01', '2022-10-17 07:42:49', '2022-10-17 07:42:49'),
(44, '221013341', '3', 'OPENING_STOCK', 108, '7.4767', '8', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '2628', 1, 48, 54.75, NULL, '2022-10-01', '2022-10-17 07:42:49', '2022-10-17 07:42:49'),
(45, '221013341', '3', 'OPENING_STOCK', 109, '3.8942', '4', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '1704', 1, 72, 23.67, NULL, '2022-10-01', '2022-10-17 07:42:49', '2022-10-17 07:42:49'),
(46, '221013341', '3', 'OPENING_STOCK', 110, '29.90645834', '32', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '35', 1, 48, 0.73, NULL, '2022-10-01', '2022-10-17 07:42:49', '2022-10-17 07:42:49'),
(47, '221013341', '3', 'OPENING_STOCK', 111, '3.73835', '4', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '6936', 1, 192, 36.13, NULL, '2022-10-01', '2022-10-17 07:42:49', '2022-10-17 07:42:49'),
(48, '221013341', '3', 'OPENING_STOCK', 112, '32.711', '35', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '76', 1, 48, 1.58, NULL, '2022-10-01', '2022-10-17 07:42:49', '2022-10-17 07:42:49'),
(49, '221013341', '3', 'OPENING_STOCK', 113, '37.019', '39.6', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '3168', 1, 288, 11, NULL, '2022-10-01', '2022-10-17 07:42:49', '2022-10-17 07:42:49'),
(50, '221013341', '3', 'OPENING_STOCK', 114, '42.99', '46', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '53', 1, 6, 8.83, NULL, '2022-10-01', '2022-10-17 07:42:49', '2022-10-17 07:42:49'),
(51, '221013341', '3', 'OPENING_STOCK', 115, '7.6325', '8.16', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '467', 1, 24, 19.46, NULL, '2022-10-01', '2022-10-17 07:42:49', '2022-10-17 07:42:49'),
(52, '221013341', '3', 'OPENING_STOCK', 116, '7.6325', '8.17', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '929', 1, 24, 38.71, NULL, '2022-10-01', '2022-10-17 07:42:49', '2022-10-17 07:42:49'),
(53, '221013341', '3', 'OPENING_STOCK', 117, '3.7383', '4', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '5712', 1, 192, 29.75, NULL, '2022-10-01', '2022-10-17 07:42:49', '2022-10-17 07:42:49'),
(54, '221013341', '3', 'OPENING_STOCK', 118, '3.701', '3.9588', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '1920', 1, 192, 10, NULL, '2022-10-01', '2022-10-17 07:42:49', '2022-10-17 07:42:49'),
(55, '221013341', '3', 'OPENING_STOCK', 119, '57.94375', '62', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '20', 1, 48, 0.42, NULL, '2022-10-01', '2022-10-17 07:42:50', '2022-10-17 07:42:50'),
(56, '221013341', '3', 'OPENING_STOCK', 121, '37.388', '40', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '54', 1, 24, 2.25, NULL, '2022-10-01', '2022-10-17 07:42:50', '2022-10-17 07:42:50'),
(57, '221013341', '3', 'OPENING_STOCK', 122, '70.085', '75', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '26', 1, 12, 2.17, NULL, '2022-10-01', '2022-10-17 07:42:50', '2022-10-17 07:42:50'),
(58, '221013341', '3', 'OPENING_STOCK', 124, '37.3834', '40', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '126', 1, 6, 21, NULL, '2022-10-01', '2022-10-17 07:42:50', '2022-10-17 07:42:50'),
(59, '221013341', '3', 'OPENING_STOCK', 126, '3.7475', '4.01', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '48', 1, 24, 2, NULL, '2022-10-01', '2022-10-17 07:42:50', '2022-10-17 07:42:50'),
(60, '221013341', '3', 'OPENING_STOCK', 128, '3.738334', '4', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '7', 1, 60, 0.12, NULL, '2022-10-01', '2022-10-17 07:42:50', '2022-10-17 07:42:50'),
(61, '221013341', '3', 'OPENING_STOCK', 129, '35.51334', '38', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '299', 1, 6, 49.83, NULL, '2022-10-01', '2022-10-17 07:42:50', '2022-10-17 07:42:50'),
(62, '221013341', '3', 'OPENING_STOCK', 130, '46.81167', '50', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '106', 1, 6, 17.67, NULL, '2022-10-01', '2022-10-17 07:42:50', '2022-10-17 07:42:50'),
(63, '221013341', '3', 'OPENING_STOCK', 131, '13.08417', '14', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '120', 1, 24, 5, NULL, '2022-10-01', '2022-10-17 07:42:50', '2022-10-17 07:42:50'),
(64, '221013341', '3', 'OPENING_STOCK', 54, '172.5', '182.85', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '11', 1, 15, 0.73, NULL, '2022-10-01', '2022-10-17 09:11:31', '2022-10-17 09:11:31'),
(65, '221013341', '3', 'OPENING_STOCK', 56, '198.5', '210', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '1', 1, 15, 0.07, NULL, '2022-10-01', '2022-10-17 09:11:31', '2022-10-17 09:11:31'),
(66, '221013341', '3', 'OPENING_STOCK', 57, '34', '36.04', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '1', 1, 56, 0.02, NULL, '2022-10-01', '2022-10-17 09:11:31', '2022-10-17 09:11:31'),
(67, '221013341', '3', 'OPENING_STOCK', 60, '35', '37', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '309', 1, 56, 5.52, NULL, '2022-10-01', '2022-10-17 09:11:31', '2022-10-17 09:11:31'),
(68, '221013341', '3', 'OPENING_STOCK', 61, '180', '190', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '335', 1, 15, 22.33, NULL, '2022-10-01', '2022-10-17 09:11:31', '2022-10-17 09:11:31'),
(69, '221013341', '3', 'OPENING_STOCK', 62, '151.11', '160', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '138', 1, 12, 11.5, NULL, '2022-10-01', '2022-10-17 09:11:31', '2022-10-17 09:11:31'),
(70, '221013341', '3', 'OPENING_STOCK', 64, '206.47', '215', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '20', 1, 15, 1.33, NULL, '2022-10-01', '2022-10-17 09:11:31', '2022-10-17 09:11:31'),
(71, '221013341', '3', 'OPENING_STOCK', 66, '172.5', '179.82', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '11', 1, 15, 0.73, NULL, '2022-10-01', '2022-10-17 09:11:31', '2022-10-17 09:11:31'),
(72, '221013341', '3', 'OPENING_STOCK', 69, '210', '240', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '108', 1, 15, 7.2, NULL, '2022-10-01', '2022-10-17 09:11:31', '2022-10-17 09:11:31'),
(73, '221013341', '3', 'OPENING_STOCK', 71, '32.8125', '34.78', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '72', 1, 50, 1.44, NULL, '2022-10-01', '2022-10-17 09:11:31', '2022-10-17 09:11:31'),
(74, '221013341', '3', 'OPENING_STOCK', 73, '210', '220', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '121', 1, 6, 20.17, NULL, '2022-10-01', '2022-10-17 09:11:31', '2022-10-17 09:11:31'),
(75, '221013341', '3', 'OPENING_STOCK', 74, '339', '360', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '14', 1, 6, 2.33, NULL, '2022-10-01', '2022-10-17 09:11:31', '2022-10-17 09:11:31'),
(76, '221013341', '3', 'OPENING_STOCK', 75, '292.7', '310', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '8', 1, 6, 1.33, NULL, '2022-10-01', '2022-10-17 09:11:31', '2022-10-17 09:11:31'),
(77, '221013341', '3', 'OPENING_STOCK', 78, '8.7811', '9.328', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '1136', 1, 80, 14.2, NULL, '2022-10-01', '2022-10-17 09:11:31', '2022-10-17 09:11:31'),
(78, '221013341', '3', 'OPENING_STOCK', 79, '13.574', '14.38844', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '220', 1, 48, 4.58, NULL, '2022-10-01', '2022-10-17 09:11:31', '2022-10-17 09:11:31'),
(79, '221013341', '3', 'OPENING_STOCK', 80, '17.5926', '19', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '708', 1, 24, 29.5, NULL, '2022-10-01', '2022-10-17 09:11:31', '2022-10-17 09:11:31'),
(80, '221013341', '3', 'OPENING_STOCK', 81, '210', '212', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '37', 1, 12, 3.08, NULL, '2022-10-01', '2022-10-17 09:11:31', '2022-10-17 09:11:31'),
(81, '221013341', '3', 'OPENING_STOCK', 82, '172.5', '182.85', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '12', 1, 15, 0.8, NULL, '2022-10-01', '2022-10-17 09:11:31', '2022-10-17 09:11:31'),
(82, '221013341', '3', 'OPENING_STOCK', 83, '20.68', '17.5', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '1152', 1, 24, 48, NULL, '2022-10-01', '2022-10-17 09:11:32', '2022-10-17 09:11:32'),
(83, '221013341', '3', 'OPENING_STOCK', 86, '3.878208', '4.282188', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '2664', 1, 72, 37, NULL, '2022-10-01', '2022-10-17 09:11:32', '2022-10-17 09:11:32'),
(84, '221013341', '3', 'OPENING_STOCK', 87, '3.72924', '4', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '1728', 1, 72, 24, NULL, '2022-10-01', '2022-10-17 09:11:32', '2022-10-17 09:11:32'),
(85, '221013341', '3', 'OPENING_STOCK', 88, '229.35', '245', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '9', 1, 6, 1.5, NULL, '2022-10-01', '2022-10-17 09:11:32', '2022-10-17 09:11:32'),
(86, '221013341', '3', 'OPENING_STOCK', 91, '7.83', '8.308', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '336', 1, 48, 7, NULL, '2022-10-01', '2022-10-17 09:11:32', '2022-10-17 09:11:32'),
(87, '221013341', '3', 'OPENING_STOCK', 95, '48', '54', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '42', 1, 12, 3.5, NULL, '2022-10-01', '2022-10-17 09:11:32', '2022-10-17 09:11:32'),
(88, '221013341', '3', 'OPENING_STOCK', 96, '204.5455', '205', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '22', 1, 15, 1.47, NULL, '2022-10-01', '2022-10-17 09:11:32', '2022-10-17 09:11:32'),
(89, '221013341', '3', 'OPENING_STOCK', 97, '65.94', '80', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '1', 1, 20, 0.05, NULL, '2022-10-01', '2022-10-17 09:11:32', '2022-10-17 09:11:32'),
(90, '221013341', '3', 'OPENING_STOCK', 98, '90.5661', '100', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '37', 1, 48, 0.77, NULL, '2022-10-01', '2022-10-17 09:11:32', '2022-10-17 09:11:32'),
(91, '221013341', '3', 'OPENING_STOCK', 99, '145', '155', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '24', 1, 48, 0.5, NULL, '2022-10-01', '2022-10-17 09:11:32', '2022-10-17 09:11:32'),
(92, '221013341', '3', 'OPENING_STOCK', 100, '225', '240', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '41', 1, 8, 5.13, NULL, '2022-10-01', '2022-10-17 09:11:32', '2022-10-17 09:11:32'),
(93, '221013341', '3', 'OPENING_STOCK', 101, '210', '222.6', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '17', 1, 15, 1.13, NULL, '2022-10-01', '2022-10-17 09:11:32', '2022-10-17 09:11:32'),
(94, '221013341', '3', 'OPENING_STOCK', 102, '210', '222.6', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '88', 1, 15, 5.87, NULL, '2022-10-01', '2022-10-17 09:11:32', '2022-10-17 09:11:32'),
(95, '221013341', '3', 'OPENING_STOCK', 103, '328.026', '347.71', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '43', 1, 6, 7.17, NULL, '2022-10-01', '2022-10-17 09:11:32', '2022-10-17 09:11:32'),
(96, '221013341', '3', 'OPENING_STOCK', 84, '7.7131', '9', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '3600', 1, 72, 50, NULL, '2022-10-01', '2022-10-17 09:11:32', '2022-10-17 09:11:32'),
(97, '221013341', '3', 'OPENING_STOCK', 104, '210', '222.6', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '45', 1, 12, 3.75, NULL, '2022-10-01', '2022-10-17 09:11:32', '2022-10-17 09:11:32'),
(98, '221013468', '2', 'STB_221013468_2', 135, '16.3334', '20', 'no', '0', '0', 3, NULL, NULL, NULL, NULL, '0', NULL, '600.00', 1, 6, 100, NULL, '2022-10-17', '2022-10-17 11:55:49', '2022-10-17 11:55:49'),
(99, '221013468', '2', 'STB_221013468_2', 134, '10.667', '13', 'no', '0', '0', 3, NULL, NULL, NULL, NULL, '0', NULL, '1200.00', 1, 12, 100, NULL, '2022-10-17', '2022-10-17 11:55:49', '2022-10-17 11:55:49'),
(100, '221013468', '2', 'STB_221013468_2', 133, '6.5', '8', 'percent', '5', '0', 3, NULL, NULL, NULL, NULL, '0', NULL, '2000.00', 1, 20, 100, NULL, '2022-10-17', '2022-10-17 11:55:49', '2022-10-17 11:55:49'),
(101, '221013468', '2', 'STB_221013468_2', 132, '5.12', '6.041', 'flat', '50', '0', 3, NULL, NULL, NULL, NULL, '0', NULL, '2400.00', 1, 24, 100, NULL, '2022-10-17', '2022-10-17 11:55:49', '2022-10-17 11:55:49'),
(102, '221013341', '3', 'OPENING_STOCK', 7, '67.25', '71.29', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '245', 1, 36, 6.81, NULL, '2022-10-01', '2022-10-17 14:07:10', '2022-10-17 14:07:10'),
(103, '221013341', '3', 'OPENING_STOCK', 8, '106', '113.5', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '109', 1, 24, 4.54, NULL, '2022-10-01', '2022-10-17 14:07:10', '2022-10-17 14:07:10'),
(104, '221013341', '3', 'OPENING_STOCK', 9, '113.8334', '120.67', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '48', 1, 24, 2, NULL, '2022-10-01', '2022-10-17 14:07:10', '2022-10-17 14:07:10'),
(105, '221013341', '3', 'OPENING_STOCK', 11, '67.83334', '67.7', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '144', 1, 36, 4, NULL, '2022-10-01', '2022-10-17 14:07:10', '2022-10-17 14:07:10'),
(106, '221013341', '3', 'OPENING_STOCK', 10, '67.25', '71.91', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '108', 1, 36, 3, NULL, '2022-10-01', '2022-10-17 14:07:10', '2022-10-17 14:07:10'),
(107, '221013341', '3', 'OPENING_STOCK', 12, '106', '110', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '61', 1, 24, 2.54, NULL, '2022-10-01', '2022-10-17 14:07:11', '2022-10-17 14:07:11'),
(108, '221013341', '3', 'OPENING_STOCK', 13, '60.3334', '63.96', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '108', 1, 36, 3, NULL, '2022-10-01', '2022-10-17 14:07:11', '2022-10-17 14:07:11'),
(109, '221013341', '3', 'OPENING_STOCK', 14, '143.75', '152.25', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '36', 1, 12, 3, NULL, '2022-10-01', '2022-10-17 14:07:11', '2022-10-17 14:07:11'),
(110, '221013341', '3', 'OPENING_STOCK', 15, '135.6667', '143.83', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '108', 1, 12, 9, NULL, '2022-10-01', '2022-10-17 14:07:11', '2022-10-17 14:07:11'),
(111, '221013341', '3', 'OPENING_STOCK', 16, '159.66', '169.25', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '0', 1, 12, 0, NULL, '2022-10-01', '2022-10-17 14:07:11', '2022-10-17 14:07:11'),
(112, '221013341', '3', 'OPENING_STOCK', 17, '70.16667', '71.96', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '126', 1, 18, 7, NULL, '2022-10-01', '2022-10-17 14:07:11', '2022-10-17 14:07:11'),
(113, '221013341', '3', 'OPENING_STOCK', 18, '143.68', '152.31', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '0', 1, 16, 0, NULL, '2022-10-01', '2022-10-17 14:07:11', '2022-10-17 14:07:11'),
(114, '221013341', '3', 'OPENING_STOCK', 19, '104.45834', '110.72584', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '95', 1, 24, 3.96, NULL, '2022-10-01', '2022-10-17 14:07:11', '2022-10-17 14:07:11'),
(115, '221013341', '3', 'OPENING_STOCK', 20, '231.5834', '245.48', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '36', 1, 12, 3, NULL, '2022-10-01', '2022-10-17 14:07:11', '2022-10-17 14:07:11'),
(116, '221013341', '3', 'OPENING_STOCK', 21, '155.6667', '165.01', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '264', 1, 12, 22, NULL, '2022-10-01', '2022-10-17 14:07:11', '2022-10-17 14:07:11'),
(117, '221013341', '3', 'OPENING_STOCK', 22, '127.91664', '135.6', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '23', 1, 12, 1.92, NULL, '2022-10-01', '2022-10-17 14:07:11', '2022-10-17 14:07:11'),
(118, '221013341', '3', 'OPENING_STOCK', 144, '70.17', '74.38', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '0', 1, 18, 0, NULL, '2022-10-01', '2022-10-17 14:07:11', '2022-10-17 14:07:11'),
(119, '221013341', '3', 'OPENING_STOCK', 143, '159.66', '169.25', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '0', 1, 12, 0, NULL, '2022-10-01', '2022-10-17 14:07:11', '2022-10-17 14:07:11'),
(120, '221013341', '3', 'OPENING_STOCK', 142, '117.75', '126.93', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '96', 1, 16, 6, NULL, '2022-10-01', '2022-10-17 14:07:11', '2022-10-17 14:07:11'),
(121, '221013341', '3', 'OPENING_STOCK', 23, '71.9', '90', 'no', '0', '0', 1, NULL, NULL, NULL, NULL, '0', NULL, '24', 1, 24, 1, NULL, '2022-10-01', '2022-10-17 14:07:11', '2022-10-17 14:07:11'),
(122, '221013341', '3', 'STB_221013341_1', 142, '117.75', '126.93', 'no', '0', '0', 2, NULL, NULL, NULL, NULL, '0', NULL, '32.00', 1, 16, 2, NULL, '2022-10-06', '2022-10-17 14:49:57', '2022-10-17 14:49:57'),
(123, '221013341', '3', 'STB_221013341_1', 21, '155.6667', '165.01', 'no', '0', '0', 2, NULL, NULL, NULL, NULL, '0', NULL, '108.00', 1, 12, 9, NULL, '2022-10-06', '2022-10-17 14:49:57', '2022-10-17 14:49:57'),
(124, '221013341', '3', 'STB_221013341_1', 16, '159.59', '169.25', 'no', '0', '0', 2, NULL, NULL, NULL, NULL, '0', NULL, '24.00', 1, 12, 2, NULL, '2022-10-06', '2022-10-17 14:49:57', '2022-10-17 14:49:57'),
(125, '221013341', '3', 'STB_221013341_1', 13, '60.3334', '63.96', 'no', '0', '0', 2, NULL, NULL, NULL, NULL, '0', NULL, '72.00', 1, 36, 2, NULL, '2022-10-06', '2022-10-17 14:49:57', '2022-10-17 14:49:57'),
(126, '221013341', '3', 'STB_221013341_1', 14, '143.75', '152.25', 'no', '0', '0', 2, NULL, NULL, NULL, NULL, '0', NULL, '60.00', 1, 12, 5, NULL, '2022-10-06', '2022-10-17 14:49:57', '2022-10-17 14:49:57'),
(127, '221013341', '3', 'STB_221013341_1', 20, '234.25', '245.48', 'no', '0', '0', 2, NULL, NULL, NULL, NULL, '0', NULL, '24.00', 1, 12, 2, NULL, '2022-10-06', '2022-10-17 14:49:57', '2022-10-17 14:49:57'),
(128, '221013341', '3', 'STB_221013341_1', 19, '104.45834', '110.72584', 'no', '0', '0', 2, NULL, NULL, NULL, NULL, '0', NULL, '96.00', 1, 24, 4, NULL, '2022-10-06', '2022-10-17 14:49:57', '2022-10-17 14:49:57'),
(129, '221013341', '3', 'STB_221013341_1', 12, '106', '110', 'no', '0', '0', 2, NULL, NULL, NULL, NULL, '0', NULL, '72.00', 1, 24, 3, NULL, '2022-10-06', '2022-10-17 14:49:57', '2022-10-17 14:49:57'),
(130, '221013341', '3', 'STB_221013341_1', 11, '67.83334', '67.7', 'no', '0', '0', 2, NULL, NULL, NULL, NULL, '0', NULL, '108.00', 1, 36, 3, NULL, '2022-10-06', '2022-10-17 14:49:57', '2022-10-17 14:49:57'),
(131, '221013341', '3', 'STB_221013341_1', 10, '67.25', '71.91', 'no', '0', '0', 2, NULL, NULL, NULL, NULL, '0', NULL, '108.00', 1, 36, 3, NULL, '2022-10-06', '2022-10-17 14:49:57', '2022-10-17 14:49:57'),
(132, '221013341', '3', 'STB_221013341_1', 8, '106', '113.5', 'no', '0', '0', 2, NULL, NULL, NULL, NULL, '0', NULL, '72.00', 1, 24, 3, NULL, '2022-10-06', '2022-10-17 14:49:57', '2022-10-17 14:49:57'),
(133, '221013341', '3', 'STB_221013341_1', 7, '67.25', '71.29', 'no', '0', '0', 2, NULL, NULL, NULL, NULL, '0', NULL, '180.00', 1, 36, 5, NULL, '2022-10-06', '2022-10-17 14:49:58', '2022-10-17 14:49:58');

-- --------------------------------------------------------

--
-- Table structure for table `return_orders`
--

CREATE TABLE `return_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shop_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `invoice_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `return_current_times` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `total_gross` double NOT NULL DEFAULT 0,
  `vat_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `discount_rate` double DEFAULT NULL,
  `others_crg` double DEFAULT NULL,
  `fine` double DEFAULT NULL,
  `refundAbleAmount` double NOT NULL,
  `currentDue` double NOT NULL,
  `paid` double NOT NULL DEFAULT 0,
  `invoice_point` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `back_point` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `note` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shop_id` int(11) NOT NULL,
  `which_roll` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `shop_id`, `which_roll`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 221013341, 'admin', '221013341#Manager', 'web', '2022-10-16 15:55:40', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(3, 1),
(5, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(13, 1),
(15, 1),
(27, 1),
(28, 1),
(29, 1),
(30, 1),
(31, 1),
(32, 1),
(33, 1),
(34, 1),
(35, 1),
(36, 1),
(37, 1),
(38, 1),
(39, 1),
(40, 1),
(41, 1),
(42, 1),
(43, 1),
(44, 1),
(45, 1),
(46, 1),
(47, 1),
(48, 1),
(49, 1),
(50, 1),
(51, 1),
(52, 1),
(53, 1),
(54, 1),
(55, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payload` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('3A5Ua9repUk8T7Vc8rUP5JEvii5E6v46VQkbBV64', NULL, '54.226.138.233', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.106 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTVM1Zm1ORXhBbkUyRmZPelF2QnZ0eEV1WTU4Ynl2REVzYTExcXNYaiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyODoiaHR0cDovL3d3dy5kaXMucmlkb3lwYXVsLnh5eiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1666138758),
('4yRWG3fJND3X5C8xSOS3UZpUepcgFRMdJHM5WwK8', NULL, '34.203.241.54', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.106 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSnZFb3JRZHZ0aHp6Z3NwNVBaaGZzbTNLU0xhQmwzUlhQYU9xRnV6RCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyODoiaHR0cDovL3d3dy5kaXMucmlkb3lwYXVsLnh5eiI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjI4OiJodHRwOi8vd3d3LmRpcy5yaWRveXBhdWwueHl6Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1666138759),
('5bFh8IMVIdAl04jzuKVvM2bE2L5zG4729gD8VXaG', NULL, '44.206.242.199', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/94.0.4606.81 Safari/537.36 OPR/80.0.4170.63', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWHJXUzJUWmFuenowYmZkQUt2RllScGs2ZUEyNjVRZ1o0anoxa0pNVyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9kaXMucmlkb3lwYXVsLnh5ei9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1666192735),
('7gMq6VDnUcTcycCnE578xtidHQNlc7ztmK8SBqd7', NULL, '3.80.143.2', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.106 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoibXYzU3R3bEJmVEhSZ0dQTWpYTlhiNEdPOUlhT3pOZU1iWjNjS3BCSCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyNDoiaHR0cDovL2Rpcy5yaWRveXBhdWwueHl6Ijt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjQ6Imh0dHA6Ly9kaXMucmlkb3lwYXVsLnh5eiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1666138760),
('aj3Cp6Iv4vPR4tJgJsxifn38mUBND6FECE3hlqSI', NULL, '3.87.81.62', 'Apache-HttpClient/5.1.3 (Java/11.0.16.1)', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoicXpXSlpJRTJJSFlLU25HRGg4VnRlUzBLRzRnTUt1emZaR3BDOUVrOCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyNToiaHR0cHM6Ly9kaXMucmlkb3lwYXVsLnh5eiI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjI1OiJodHRwczovL2Rpcy5yaWRveXBhdWwueHl6Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1666138757),
('aRpCOAELVKhRfSzCvT2LvxUuqUTmjCoM69oniHtb', NULL, '44.201.203.193', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.106 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZDFDSGFLZmlPb2h1UDV1RldsT2tIaXNYd1A4OXBJUGhnWVpydkRlZyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly93d3cuZGlzLnJpZG95cGF1bC54eXovbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1666138761),
('cxCP5fnrXFnJCHjwPfmIcPGJJ2AlTAjpViTehKDx', NULL, '54.159.137.190', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.106 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicEExcTZFTkxyREpNM2kyeDEyQmtRa24xN2lLYXRWMmNlNml5cEhZMiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9kaXMucmlkb3lwYXVsLnh5ei9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1666138761),
('IdK67DQ7jDeu0vgxu0lfT0U9DtWKp5pTfm58YpwK', NULL, '18.234.134.12', 'Apache-HttpClient/5.1.3 (Java/11.0.16.1)', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiT2NpU0V2SUFidU1uc2poc1NienpldkdrY3U5TmxSQUNoUDY2TEZxRSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyOToiaHR0cHM6Ly93d3cuZGlzLnJpZG95cGF1bC54eXoiO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoyOToiaHR0cHM6Ly93d3cuZGlzLnJpZG95cGF1bC54eXoiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1666138757),
('Jn6mu7ETO52CagyMCIXRfgvOIB0jKPNJp5C2t3tj', NULL, '205.210.31.139', 'Expanse, a Palo Alto Networks company, searches across the global IPv4 space multiple times per day to identify customers&#39; presences on the Internet. If you would like to be excluded from our scans, please send IP addresses/domains to: scaninfo@paloaltonetworks.com', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVXJKcFdqQVZzRGV1MUVhWFJmR2Y4aG1nT1FMVFlHZXlaS09Pd20wRiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyODoiaHR0cDovL3d3dy5kaXMucmlkb3lwYXVsLnh5eiI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjI4OiJodHRwOi8vd3d3LmRpcy5yaWRveXBhdWwueHl6Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1666169696),
('JyNtWmZn77w66scY2cJqojFiFRHZQRs4ms56JkHA', NULL, '198.235.24.178', 'Expanse, a Palo Alto Networks company, searches across the global IPv4 space multiple times per day to identify customers&#39; presences on the Internet. If you would like to be excluded from our scans, please send IP addresses/domains to: scaninfo@paloaltonetworks.com', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiaVpSSE9NSXpnRG1URkZXTUFUOFkwMlpDZHRZSzJMTHA4U0E0NkxXWSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyOToiaHR0cHM6Ly93d3cuZGlzLnJpZG95cGF1bC54eXoiO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoyOToiaHR0cHM6Ly93d3cuZGlzLnJpZG95cGF1bC54eXoiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1666197794),
('ooa8ddlOUSiW4pYxRit9VwfTzfKfECIk52jfU9dW', NULL, '52.87.244.228', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.106 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZnJ1SDVVRmJUWXphZTZVeTJwN2NKS05EVXpZcGs1NGc1OHc1Znp4cyI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyNDoiaHR0cDovL2Rpcy5yaWRveXBhdWwueHl6Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1666138758),
('VM6jESD1xs9fla0yh2DJouLuFWIyLCbQVNhSfKBR', NULL, '44.202.122.63', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36 Edg/96.0.1054.29', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoieTV6TkN6ZzB1WnpUSWh4ckF0TW9vNHE0RDlsTnh0WXBzVlM2NlBGWCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly93d3cuZGlzLnJpZG95cGF1bC54eXovbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1666192735);

-- --------------------------------------------------------

--
-- Table structure for table `shop_settings`
--

CREATE TABLE `shop_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shop_code` int(11) NOT NULL,
  `shop_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shop_logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shop_website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vat_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `point_redeem_rate` double DEFAULT NULL,
  `point_earn_rate` double DEFAULT NULL,
  `minimum_purchase_to_get_point` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `is_active_customer_points` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `default_branch_id_for_sell` int(11) DEFAULT NULL,
  `sms_active_status` int(11) DEFAULT NULL,
  `sms_limit` double DEFAULT NULL,
  `start_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `renew_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reseller_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trial_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'running',
  `trial_end_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `office_start_time` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `office_end_time` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `days_of_late_absent` int(11) DEFAULT NULL,
  `commission_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'monthley',
  `minimum_sell_to_get_daily_commission` double DEFAULT NULL,
  `minimum_sell_to_get_monthley_commission` double DEFAULT NULL,
  `commission_percent_monthley` double DEFAULT NULL,
  `commission_percent_daily` double DEFAULT NULL,
  `attendence_api_auth_user` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attendence_api_auth_code` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shop_settings`
--

INSERT INTO `shop_settings` (`id`, `shop_code`, `shop_name`, `shop_logo`, `email`, `phone`, `address`, `shop_website`, `vat_type`, `point_redeem_rate`, `point_earn_rate`, `minimum_purchase_to_get_point`, `is_active_customer_points`, `default_branch_id_for_sell`, `sms_active_status`, `sms_limit`, `start_date`, `renew_date`, `reseller_id`, `trial_status`, `trial_end_date`, `office_start_time`, `office_end_time`, `days_of_late_absent`, `commission_type`, `minimum_sell_to_get_daily_commission`, `minimum_sell_to_get_monthley_commission`, `commission_percent_monthley`, `commission_percent_daily`, `attendence_api_auth_user`, `attendence_api_auth_code`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 221013160, 'FARA IT LTD.', 'images/1746729880526786.jpg', 'cse.ridoypaul@gmail.com', '0121545245', 'xfggfgsgj', 'http://dis.ridoypaul.xyz/admin/shop-setting', 'never_used', NULL, NULL, '0', NULL, NULL, NULL, NULL, '2022-10-13', NULL, 'none', 'running', NULL, '00:21', '03:46', 12, 'monthley', 5645, 45, 7841, 241, 'Faraitlimited', 'g92pwwbyrl71134os90pzfqf90wbvdl', '1', NULL, NULL),
(2, 221013341, 'M/s Nessa Enterprise', 'images/1746948895018920.jpg', 'akmsamim30@gmail.com', '01312395573', 'Themuki Bypass Sylhet', NULL, 'never_used', NULL, NULL, '0', NULL, NULL, NULL, NULL, '2022-10-13', NULL, 'none', 'running', NULL, '09:15', '18:00', 3, 'monthley', NULL, NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL),
(3, 221013468, 'Cartoon\'s World', NULL, 'akmsamim30@gmail.com', '01236547890', 'Themuki Baypass Sylhet', NULL, 'never_used', NULL, NULL, '0', NULL, NULL, NULL, NULL, '2022-10-13', NULL, 'none', 'running', NULL, '09:00', '18:00', 3, 'monthley', NULL, NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sms`
--

CREATE TABLE `sms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shop_id` int(11) NOT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `phone_num` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sms_histories`
--

CREATE TABLE `sms_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shop_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `sms_count` int(11) DEFAULT NULL,
  `send_to` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `length` int(11) DEFAULT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `info` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sms_recharge_requests`
--

CREATE TABLE `sms_recharge_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shop_id` int(11) NOT NULL,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rechargeable_amount` double NOT NULL,
  `per_sms_price` double DEFAULT NULL,
  `sms_quantity` double DEFAULT NULL,
  `is_approved` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sr_to_branch_transfers`
--

CREATE TABLE `sr_to_branch_transfers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shop_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `invoice_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sender_sr_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `total_gross` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `note` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sr_to_branch_transfers`
--

INSERT INTO `sr_to_branch_transfers` (`id`, `shop_id`, `user_id`, `invoice_id`, `sender_sr_id`, `branch_id`, `total_gross`, `note`, `date`, `created_at`, `updated_at`) VALUES
(1, '221013468', 5, 'SRTB_T_221013468_1', 2, 7, '0', 'Note', '2022-10-15', '2022-10-15 11:19:03', NULL),
(2, '221013468', 5, 'SRTB_T_221013468_2', 2, 7, '0', 'Notem', '2022-10-15', '2022-10-15 11:20:00', NULL),
(3, '221013160', 1, 'SRTB_T_221013160_1', 1, 6, '0', 'Note', '2022-10-15', '2022-10-15 11:38:25', NULL),
(4, '221013468', 5, 'SRTB_T_221013468_3', 2, 14, '0', 'Note', '2022-10-15', '2022-10-15 14:00:23', NULL),
(5, '221013468', 5, 'SRTB_T_221013468_4', 2, 14, '0', 'Note', '2022-10-16', '2022-10-16 13:54:18', NULL),
(6, '221013468', 5, 'SRTB_T_221013468_5', 2, 14, '0', 'Note', '2022-10-16', '2022-10-16 15:48:23', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sr_to_branch_transfer_products`
--

CREATE TABLE `sr_to_branch_transfer_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sr_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `purchase_line_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lot_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `purchase_price` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `sales_price` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `pid` int(11) NOT NULL,
  `variation_id` int(11) NOT NULL DEFAULT 0,
  `quantity` double NOT NULL,
  `is_cartoon` int(11) DEFAULT 0,
  `cartoon_quantity` double DEFAULT 0,
  `cartoon_amount` double DEFAULT 0,
  `discount` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no',
  `discount_amount` double NOT NULL DEFAULT 0,
  `vat_amount` double DEFAULT NULL,
  `date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sr_to_branch_transfer_products`
--

INSERT INTO `sr_to_branch_transfer_products` (`id`, `invoice_id`, `sr_id`, `purchase_line_id`, `lot_number`, `purchase_price`, `sales_price`, `pid`, `variation_id`, `quantity`, `is_cartoon`, `cartoon_quantity`, `cartoon_amount`, `discount`, `discount_amount`, `vat_amount`, `date`, `created_at`, `updated_at`) VALUES
(1, 'SRTB_T_221013468_1', '7', '3', '1', '16.3334', '20', 135, 0, 6, 1, 6, 1, 'no', 0, 0, '2022-10-15', '2022-10-15 11:19:03', '2022-10-15 11:19:03'),
(2, 'SRTB_T_221013468_1', '7', '4', '1', '10.667', '13', 134, 0, 24, 1, 12, 2, 'no', 0, 0, '2022-10-15', '2022-10-15 11:19:03', '2022-10-15 11:19:03'),
(3, 'SRTB_T_221013468_1', '7', '5', '1', '6.5', '8', 133, 0, 60, 1, 20, 3, 'percent', 5, 0, '2022-10-15', '2022-10-15 11:19:03', '2022-10-15 11:19:03'),
(4, 'SRTB_T_221013468_1', '7', '6', '1', '5.12', '6.041', 132, 0, 96, 1, 24, 4, 'flat', 50, 0, '2022-10-15', '2022-10-15 11:19:03', '2022-10-15 11:19:03'),
(5, 'SRTB_T_221013468_2', '7', '6', '1', '5.12', '6.041', 132, 0, 24, 1, 24, 1, 'flat', 50, 0, '2022-10-15', '2022-10-15 11:20:00', '2022-10-15 11:20:00'),
(6, 'SRTB_T_221013160_1', '6', '2', '1', '50', '100', 1, 0, 180, 1, 20, 9, 'no', 0, 0, '2022-10-15', '2022-10-15 11:38:25', '2022-10-15 11:38:25'),
(7, 'SRTB_T_221013468_3', '14', '3', '1', '16.3334', '20', 135, 0, 12, 1, 6, 2, 'no', 0, 0, '2022-10-15', '2022-10-15 14:00:23', '2022-10-15 14:00:23'),
(8, 'SRTB_T_221013468_3', '14', '4', '1', '10.667', '13', 134, 0, 60, 1, 12, 5, 'no', 0, 0, '2022-10-15', '2022-10-15 14:00:23', '2022-10-15 14:00:23'),
(9, 'SRTB_T_221013468_4', '14', '3', '1', '16.3334', '20', 135, 0, 18, 1, 6, 3, 'no', 0, 0, '2022-10-16', '2022-10-16 13:54:18', '2022-10-16 13:54:18'),
(10, 'SRTB_T_221013468_4', '14', '4', '1', '10.667', '13', 134, 0, 108, 1, 12, 9, 'no', 0, 0, '2022-10-16', '2022-10-16 13:54:18', '2022-10-16 13:54:18'),
(11, 'SRTB_T_221013468_4', '14', '5', '1', '6.5', '8', 133, 0, 140, 1, 20, 7, 'percent', 5, 0, '2022-10-16', '2022-10-16 13:54:18', '2022-10-16 13:54:18'),
(12, 'SRTB_T_221013468_4', '14', '6', '1', '5.12', '6.041', 132, 0, 240, 1, 24, 10, 'flat', 50, 0, '2022-10-16', '2022-10-16 13:54:19', '2022-10-16 13:54:19'),
(13, 'SRTB_T_221013468_5', '14', '12', '2', '10.667', '13', 134, 0, 14, 1, 12, 1.17, 'no', 0, 0, '2022-10-16', '2022-10-16 15:48:23', '2022-10-16 15:48:23'),
(14, 'SRTB_T_221013468_5', '14', '5', '1', '6.5', '8', 133, 0, 15, 1, 20, 0.75, 'percent', 5, 0, '2022-10-16', '2022-10-16 15:48:23', '2022-10-16 15:48:23');

-- --------------------------------------------------------

--
-- Table structure for table `staff_daily_attendences`
--

CREATE TABLE `staff_daily_attendences` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `staff_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shop_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `in_time` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `out_time` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `staff_daily_attendences`
--

INSERT INTO `staff_daily_attendences` (`id`, `staff_id`, `shop_id`, `date`, `in_time`, `out_time`, `created_at`, `updated_at`) VALUES
(1, '7', '221013160', '2022-10-15', '14:23:29', '16:15:45', '2022-10-15 11:25:53', '2022-10-15 12:13:18'),
(2, '12', '221013160', '2022-10-15', '18:27:40', '18:27:12', '2022-10-15 12:29:50', '2022-10-15 12:29:50');

-- --------------------------------------------------------

--
-- Table structure for table `staff_in_out_details`
--

CREATE TABLE `staff_in_out_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shop_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `staff_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `time` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `access_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `staff_in_out_details`
--

INSERT INTO `staff_in_out_details` (`id`, `shop_id`, `staff_id`, `date`, `time`, `access_id`, `created_at`, `updated_at`) VALUES
(12, '221013160', '12', '2022-10-15', '18:27:40', '23844366', '2022-10-15 12:29:50', '2022-10-15 12:29:50'),
(13, '221013160', '12', '2022-10-15', '18:27:12', '23844367', '2022-10-15 12:29:50', '2022-10-15 12:29:50');

-- --------------------------------------------------------

--
-- Table structure for table `staff_salleries`
--

CREATE TABLE `staff_salleries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shop_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `month` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paid_amount` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `staff_salleries`
--

INSERT INTO `staff_salleries` (`id`, `shop_id`, `user_id`, `month`, `paid_amount`, `note`, `date`, `created_at`, `updated_at`) VALUES
(1, NULL, '11', NULL, '1000', NULL, '2022-10-16', '2022-10-16 09:11:36', '2022-10-16 09:11:36'),
(2, NULL, '11', NULL, '1000', NULL, '2022-10-16', '2022-10-16 09:11:46', '2022-10-16 09:11:46'),
(3, NULL, '7', NULL, '10', NULL, '2022-10-16', '2022-10-16 09:39:50', '2022-10-16 09:39:50'),
(4, NULL, '6', NULL, '10', NULL, '2022-10-16', '2022-10-16 10:17:14', '2022-10-16 10:17:14'),
(5, NULL, '6', NULL, '10', NULL, '2022-10-16', '2022-10-16 10:21:25', '2022-10-16 10:21:25'),
(6, NULL, '8', NULL, '100', NULL, '2022-10-16', '2022-10-16 11:19:24', '2022-10-16 11:19:24'),
(7, NULL, '6', NULL, '10', NULL, '2022-10-16', '2022-10-16 11:19:41', '2022-10-16 11:19:41'),
(8, NULL, '6', NULL, '10', NULL, '2022-10-16', '2022-10-16 11:22:16', '2022-10-16 11:22:16'),
(9, '221013160', NULL, NULL, '100', 'fghdgdfg', '2022-10-16', '2022-10-16 12:42:12', '2022-10-16 12:42:12'),
(10, '221013160', NULL, NULL, '100', 'fghdgdfg', '2022-10-16', '2022-10-16 12:42:39', '2022-10-16 12:42:39'),
(11, '221013160', '7', NULL, '100', NULL, '2022-10-16', '2022-10-16 12:52:46', '2022-10-16 12:52:46'),
(12, '221013160', '7', NULL, '100', 'fghfgh', '2022-10-16', '2022-10-16 12:53:14', '2022-10-16 12:53:14'),
(13, '221013160', '7', NULL, '750', 'fghfgh', '2022-10-16', '2022-10-16 12:54:26', '2022-10-16 12:54:26'),
(14, '221013468', '11', NULL, '1000', NULL, '2022-10-16', '2022-10-16 12:59:21', '2022-10-16 12:59:21'),
(15, '221013468', '14', NULL, '1000', NULL, '2022-10-16', '2022-10-16 13:00:23', '2022-10-16 13:00:23'),
(16, '221013160', '7', NULL, '100', 'dfghdfg', '2022-10-16', '2022-10-16 13:00:41', '2022-10-16 13:00:41'),
(17, '221013468', '14', NULL, '1000', NULL, '2022-10-16', '2022-10-16 13:00:50', '2022-10-16 13:00:50'),
(18, '221013160', '7', '2022-10', '100', 'fghfgh', '2022-10-16', '2022-10-16 13:01:19', '2022-10-16 13:01:19'),
(19, '221013160', '7', '2022-10', '100', 'dfgdfg', '2022-10-16', '2022-10-16 13:02:44', '2022-10-16 13:02:44'),
(20, '221013468', '14', '2022-09', '1000', NULL, '2022-10-16', '2022-10-16 13:32:53', '2022-10-16 13:32:53'),
(21, '221013468', '11', '2022-10', '1000', NULL, '2022-10-16', '2022-10-16 15:41:10', '2022-10-16 15:41:10');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shop_id` int(11) NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `opening_bl` double DEFAULT NULL,
  `advance_payment` double DEFAULT NULL,
  `balance` double DEFAULT NULL,
  `active` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `shop_id`, `code`, `company_name`, `name`, `email`, `phone`, `address`, `opening_bl`, `advance_payment`, `balance`, `active`, `created_at`, `updated_at`) VALUES
(1, 221013160, 'S221013160S1', 'none', 'FARA IT LTD.', 'cse.ridoypaul@gmail.com', '01627382866', 'Shah Ali plaza', 0, NULL, 11800, 1, '2022-10-15 04:44:57', NULL),
(2, 221013468, 'S221013468S1', 'none', 'Britanuia', NULL, '11235456', NULL, 1000, NULL, 52321.292, 1, '2022-10-15 11:40:16', NULL),
(3, 221013341, 'S221013341S1', 'none', 'Green 9 Company Limited.', NULL, '01842131137', '17/6 Fowzerbari, Uzampur, Uttarkhan Dhaka-1230', 0, NULL, -5012.83024, 1, '2022-10-17 14:23:39', NULL),
(4, 221013341, 'S221013341S4', 'none', 'Britannia Food & Beverage Ltd.', NULL, '01925507892', 'Garden Tower Uposhahar Sylhet-3100', 0, NULL, 0, 1, '2022-10-17 16:56:43', NULL),
(5, 221013341, 'S221013341S5', 'none', 'Akij Food & Beverage Ltd.', NULL, '01755630267', 'Akij Center Gulshan Link Road Dhaka', 0, NULL, 0, 1, '2022-10-17 17:02:10', NULL),
(6, 221013341, 'S221013341S6', 'none', 'Olympic Industries Ltd.', NULL, '+880-29565228', 'Amin Court 6th Floor 62/63 Motijhell C/A Dhaka-1000', 0, NULL, 0, 1, '2022-10-17 17:05:36', NULL),
(7, 221013341, 'S221013341S7', 'none', 'Noorjahan Enterprise Gazi Coil', NULL, '01752090678', '92/1 Motijheel C/A 2nd Floor Dhaka-1000', 0, NULL, 0, 1, '2022-10-17 17:07:55', '2022-10-17 17:13:17'),
(8, 221013341, 'S221013341S8', 'none', 'Star Line Food Products Ltd.', NULL, '01753218357', 'Beside Jalalabad thana Moiyerchor Sylhet-3100', 0, NULL, 0, 1, '2022-10-17 17:11:11', NULL),
(9, 221013341, 'S221013341S9', 'none', 'Pran Mr. Mango Group', NULL, '01704142493', 'Pran Rfl Center Marul Badda Dhaka-1208', 0, NULL, 0, 1, '2022-10-17 17:15:56', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `supplier_invoices`
--

CREATE TABLE `supplier_invoices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shop_id` int(11) NOT NULL,
  `supp_invoice_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `total_gross` double NOT NULL DEFAULT 0,
  `pre_due` double NOT NULL DEFAULT 0,
  `others_crg` double DEFAULT NULL,
  `discount_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount_rate` double DEFAULT 0,
  `total_discount_amount` double NOT NULL DEFAULT 0,
  `paid` double NOT NULL DEFAULT 0,
  `note` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `supp_voucher_num` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `place` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `branch_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `supplier_invoices`
--

INSERT INTO `supplier_invoices` (`id`, `shop_id`, `supp_invoice_id`, `supplier_id`, `total_gross`, `pre_due`, `others_crg`, `discount_status`, `discount_rate`, `total_discount_amount`, `paid`, `note`, `supp_voucher_num`, `place`, `branch_id`, `date`, `created_at`, `updated_at`) VALUES
(1, 221013160, 'STB_221013160_1', 1, 22000, 0, 0, '0', 0, 0, 0, 'Note', '768jutn', 'SUPP_TO_B', '1', '2022-10-15', '2022-10-14 18:00:00', NULL),
(2, 221013468, 'STB_221013468_1', 2, 6344.852, 1000, 0, '0', 0, 0, 0, 'Note', '12', 'SUPP_TO_B', '2', '2022-10-16', '2022-10-15 18:00:00', NULL),
(3, 221013468, 'STB_221013468_2', 2, 47888.44, 5344.852, 0, '0', 0, 0, 912, 'Note', '22', 'SUPP_TO_B', '2', '2022-10-17', '2022-10-16 18:00:00', NULL),
(4, 221013341, 'STB_221013341_1', 3, 94987.16976, 0, 0, '0', 0, 0, 0, 'Product Short Delivery 4Ctn', '0002', 'SUPP_TO_B', '3', '2022-10-06', '2022-10-05 18:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `supplier_inv_returns`
--

CREATE TABLE `supplier_inv_returns` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shop_id` int(11) NOT NULL,
  `supp_invoice_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `total_gross` double NOT NULL,
  `supp_Due` double NOT NULL,
  `note` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `how_many_times_edited` int(11) NOT NULL,
  `date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `supplier_inv_returns`
--

INSERT INTO `supplier_inv_returns` (`id`, `shop_id`, `supp_invoice_id`, `supplier_id`, `total_gross`, `supp_Due`, `note`, `how_many_times_edited`, `date`, `created_at`, `updated_at`) VALUES
(1, 221013160, 'SDR_221013160_1', 1, 10000, 22000, 'dfgdfgdfg', 0, '2022-10-15 11:56:33', '2022-10-15 05:56:33', NULL),
(2, 221013160, 'SDR_221013160_2', 1, 200, 12000, 'fgdfg', 0, '2022-10-15 11:58:35', '2022-10-15 05:58:35', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `supplier_payments`
--

CREATE TABLE `supplier_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `voucher_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shop_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `supplier_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `paymentBy` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `due` double NOT NULL DEFAULT 0,
  `paid` double NOT NULL DEFAULT 0,
  `cheque_or_mfs_account` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cheque_num` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cheque_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `supplier_payments`
--

INSERT INTO `supplier_payments` (`id`, `voucher_number`, `shop_id`, `supplier_code`, `user_id`, `paymentBy`, `due`, `paid`, `cheque_or_mfs_account`, `cheque_num`, `cheque_date`, `note`, `created_at`, `updated_at`) VALUES
(1, 'SDP221013468_0', '221013468', 'S221013468S1', 5, 'cheque', 7344.852, 2000, '1', '012', '2022-10-16', NULL, '2022-10-15 18:00:00', NULL),
(2, 'SDP221013341_0', '221013341', 'S221013341S1', 4, 'cash', 94987.16976, 100000, NULL, NULL, '2022-10-17', 'Pubali Bank Limuted.', '2022-10-05 18:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `supplier_return_products`
--

CREATE TABLE `supplier_return_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shop_id` int(11) NOT NULL,
  `supp_invoice_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lot_number` int(11) DEFAULT NULL,
  `purchase_price` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `how_many_times_edited` int(11) NOT NULL,
  `product_id` double NOT NULL,
  `variation_id` double NOT NULL,
  `quantity` double NOT NULL DEFAULT 0,
  `is_cartoon` int(11) NOT NULL DEFAULT 0,
  `cartoon_quantity` double DEFAULT 0,
  `cartoon_amount` double DEFAULT 0,
  `price` double NOT NULL DEFAULT 0,
  `total_price` double NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `supplier_return_products`
--

INSERT INTO `supplier_return_products` (`id`, `shop_id`, `supp_invoice_id`, `lot_number`, `purchase_price`, `how_many_times_edited`, `product_id`, `variation_id`, `quantity`, `is_cartoon`, `cartoon_quantity`, `cartoon_amount`, `price`, `total_price`, `created_at`, `updated_at`) VALUES
(1, 221013160, 'SDR_221013160_1', 1, NULL, 0, 1, 0, 200, 1, 20, 10, 50, 10000, '2022-10-15 05:56:33', NULL),
(2, 221013160, 'SDR_221013160_2', 1, NULL, 0, 2, 0, 20, 1, 20, 1, 10, 200, '2022-10-15 05:58:35', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `s_m_s_settings`
--

CREATE TABLE `s_m_s_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `masking_price` double DEFAULT NULL,
  `non_masking_price` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `s_r_stocks`
--

CREATE TABLE `s_r_stocks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shop_id` int(11) NOT NULL,
  `purchase_line_id` int(11) NOT NULL,
  `lot_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sr_id` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `variation_id` int(11) DEFAULT NULL,
  `purchase_price` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sales_price` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no',
  `discount_amount` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `vat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `stock` double NOT NULL DEFAULT 0,
  `is_cartoon` int(11) DEFAULT 0,
  `cartoon_quantity` double DEFAULT 0,
  `cartoon_amount` double DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `s_r_stocks`
--

INSERT INTO `s_r_stocks` (`id`, `shop_id`, `purchase_line_id`, `lot_number`, `sr_id`, `pid`, `variation_id`, `purchase_price`, `sales_price`, `discount`, `discount_amount`, `vat`, `stock`, `is_cartoon`, `cartoon_quantity`, `cartoon_amount`, `created_at`, `updated_at`) VALUES
(1, 221013160, 1, '1', 6, 2, 0, '10', '20', 'no', '0', '0', 80, 1, 20, 4, NULL, '2022-10-15 05:05:32'),
(4, 221013468, 5, '1', 7, 133, 0, '6.5', '8', 'percent', '5', '0', 0, 1, 20, 0, NULL, '2022-10-15 11:31:32'),
(5, 221013468, 4, '1', 7, 134, 0, '10.667', '13', 'no', '0', '0', 0, 1, 12, 0.0000000000000033306690738755, NULL, '2022-10-15 11:31:32'),
(6, 221013468, 3, '1', 7, 135, 0, '16.3334', '20', 'no', '0', '0', 0, 1, 6, -0.0000000000000033306690738755, NULL, '2022-10-15 11:31:32'),
(7, 221013160, 1, '1', 7, 2, 0, '10', '20', 'no', '0', '0', 4, 1, 20, 0.2, NULL, '2022-10-16 10:52:28'),
(8, 221013341, 7, '1', 13, 6, 0, '16.3334', '20', 'no', '0', '0', 600, 1, 6, 100, NULL, NULL),
(9, 221013341, 8, '1', 13, 5, 0, '10.667', '13', 'no', '0', '0', 1200, 1, 12, 100, NULL, NULL),
(10, 221013341, 9, '1', 13, 4, 0, '6.5', '8', 'no', '0', '0', 1200, 1, 20, 60, NULL, NULL),
(17, 221013160, 2, '1', 6, 1, 0, '50', '100', 'no', '0', '0', 5, 1, 20, 0.25, NULL, '2022-10-16 13:25:55'),
(20, 221013468, 13, '2', 14, 133, 0, '6.5', '8', 'percent', '5', '0', 400, 1, 20, 20, NULL, NULL),
(21, 221013468, 3, '1', 14, 135, 0, '16.3334', '20', 'no', '0', '0', 30, 1, 6, 5, NULL, NULL),
(22, 221013468, 4, '1', 14, 134, 0, '10.667', '13', 'no', '0', '0', 156, 1, 12, 13, NULL, NULL),
(23, 221013468, 5, '1', 14, 133, 0, '6.5', '8', 'percent', '5', '0', 275, 1, 20, 13.75, NULL, NULL),
(24, 221013468, 6, '1', 14, 132, 0, '5.12', '6.041', 'flat', '50', '0', 240, 1, 24, 10, NULL, NULL),
(25, 221013341, 102, '1', 24, 7, 0, '67.25', '71.29', 'no', '0', '0', 0, 1, 36, 0, NULL, '2022-10-17 15:06:43'),
(26, 221013341, 103, '1', 24, 8, 0, '106', '113.5', 'no', '0', '0', 0, 1, 24, 0, NULL, '2022-10-17 15:06:43'),
(27, 221013341, 105, '1', 24, 11, 0, '67.83334', '67.7', 'no', '0', '0', 0, 1, 36, 0, NULL, '2022-10-17 15:06:43'),
(28, 221013341, 106, '1', 24, 10, 0, '67.25', '71.91', 'no', '0', '0', 0, 1, 36, 0, NULL, '2022-10-17 15:06:43'),
(29, 221013341, 107, '1', 24, 12, 0, '106', '110', 'no', '0', '0', 0, 1, 24, 0, NULL, '2022-10-17 15:06:43'),
(30, 221013341, 108, '1', 24, 13, 0, '60.3334', '63.96', 'no', '0', '0', 0, 1, 36, 0, NULL, '2022-10-17 15:06:43'),
(31, 221013341, 109, '1', 24, 14, 0, '143.75', '152.25', 'no', '0', '0', 0, 1, 12, 0, NULL, '2022-10-17 15:06:43'),
(32, 221013341, 110, '1', 24, 15, 0, '135.6667', '143.83', 'no', '0', '0', 0, 1, 12, 0, NULL, '2022-10-17 15:06:43'),
(33, 221013341, 124, '2', 24, 16, 0, '159.59', '169.25', 'no', '0', '0', 0, 1, 12, 0, NULL, '2022-10-17 15:06:43'),
(34, 221013341, 112, '1', 24, 17, 0, '70.16667', '71.96', 'no', '0', '0', 0, 1, 18, 0, NULL, '2022-10-17 15:06:43'),
(35, 221013341, 114, '1', 24, 19, 0, '104.45834', '110.72584', 'no', '0', '0', 0, 1, 24, 0, NULL, '2022-10-17 15:06:43'),
(36, 221013341, 115, '1', 24, 20, 0, '231.5834', '245.48', 'no', '0', '0', 0, 1, 12, 0, NULL, '2022-10-17 15:06:43'),
(37, 221013341, 116, '1', 24, 21, 0, '155.6667', '165.01', 'no', '0', '0', 0, 1, 12, 0, NULL, '2022-10-17 15:06:43'),
(38, 221013341, 120, '1', 24, 142, 0, '117.75', '126.93', 'no', '0', '0', 0, 1, 16, 0, NULL, '2022-10-17 15:06:43');

-- --------------------------------------------------------

--
-- Table structure for table `take_customer_dues`
--

CREATE TABLE `take_customer_dues` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shop_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `voucher_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `customer_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `paymentBy` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `due` double NOT NULL,
  `received_amount` double NOT NULL,
  `cheque_or_mfs_account` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cheque_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cheque_bank_or_mfs_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deposit_to` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deposit_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shop_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `branch_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `added_by` int(11) NOT NULL,
  `for_what` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `track` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `refference` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cash_or_bank` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` double NOT NULL,
  `creadit_or_debit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `shop_id`, `branch_id`, `added_by`, `for_what`, `track`, `refference`, `cash_or_bank`, `amount`, `creadit_or_debit`, `note`, `created_at`, `updated_at`) VALUES
(1, '221013160', NULL, 1, 'S', '1', 'S_221013160_6_1', 'cash', 2400, 'CR', 'Sell to customer. Invoice Num. #S/221013160/6/1', '2022-10-14 18:00:00', NULL),
(2, '221013468', NULL, 5, 'S', '5', 'S_221013468_7_1', 'cash', 40.6, 'CR', 'Sell to customer. Invoice Num. #S/221013468/7/1', '2022-10-14 18:00:00', NULL),
(3, '221013468', NULL, 5, 'S', '6', 'S_221013468_7_2', 'cash', 200, 'CR', 'Sell to customer. Invoice Num. #S/221013468/7/2', '2022-10-14 18:00:00', NULL),
(4, '221013468', NULL, 5, 'S', '7', 'S_221013468_7_3', 'cash', 1200, 'CR', 'Sell to customer. Invoice Num. #S/221013468/7/3', '2022-10-14 18:00:00', NULL),
(5, '221013468', NULL, 5, 'S', '9', 'S_221013468_7_4', 'cash', 200, 'CR', 'Sell to customer. Invoice Num. #S/221013468/7/4', '2022-10-14 18:00:00', NULL),
(6, '221013468', NULL, 5, 'S', '10', 'S_221013468_7_5', 'cash', 100, 'CR', 'Sell to customer. Invoice Num. #S/221013468/7/5', '2022-10-14 18:00:00', NULL),
(7, '221013468', NULL, 5, 'LR', '1', 'LR221013468_1', 'cash', 10000, 'CR', 'Loan Received from Lender, Lender name: IBBl, Voucher Num: LR221013468/1', '2022-10-16 09:14:37', NULL),
(8, '221013468', NULL, 5, 'LP', '1', 'LP221013468_2', 'cash', 1000, 'DR', 'Loan Paid to Lender, Lender name: IBBl, Voucher Num: LP221013468/2', '2022-10-16 09:14:56', NULL),
(9, '221013160', NULL, 1, 'S', '1', 'S_221013160_6_2', 'cash', 4000, 'CR', 'Sell to customer. Invoice Num. #S/221013160/6/2', '2022-10-15 18:00:00', NULL),
(10, '221013160', NULL, 1, 'S', '1', 'S_221013160_6_3', 'cash', 4000, 'CR', 'Sell to customer. Invoice Num. #S/221013160/6/3', '2022-10-15 18:00:00', NULL),
(11, '221013468', NULL, 5, 'S', '12', 'S_221013468_7_6', 'cash', 0, 'CR', 'Sell to customer. Invoice Num. #S/221013468/7/6', '2022-10-15 18:00:00', NULL),
(12, '221013160', NULL, 1, 'E', '1', 'E221013160_1', 'cash', 100, 'DR', 'New Expense Added, Ledger Head name: Staff Salary, Voucher Num: E221013160/1', '2022-10-15 18:00:00', NULL),
(13, '221013160', NULL, 1, 'S', '1', 'S_221013160_6_4', 'cash', 500, 'CR', 'Sell to customer. Invoice Num. #S/221013160/6/4', '2022-10-15 18:00:00', NULL),
(14, '221013160', NULL, 1, 'S', '1', 'S_221013160_6_5', 'cash', 200, 'CR', 'Sell to customer. Invoice Num. #S/221013160/6/5', '2022-10-15 18:00:00', NULL),
(15, '221013468', NULL, 5, 'E', '5', 'E221013468_5', 'cash', 1000, 'DR', 'New Expense Added, Ledger Head name: Daily Expense, Voucher Num: E221013468/5', '2022-10-15 18:00:00', NULL),
(16, '221013468', NULL, 5, 'E', '7', 'E221013468_6', 'cash', 1000, 'DR', 'New Expense Added, Ledger Head name: Vehicle Rent, Voucher Num: E221013468/6', '2022-10-15 18:00:00', NULL),
(17, '221013468', NULL, 5, 'CONTRA', 'CTB', 'CONTRA221013468_1', 'cash', 1000, 'CONTRA', 'Balance Transfer Cash to bank', '2022-10-16 13:49:12', NULL),
(18, '221013468', NULL, 5, 'CONTRA', 'CTB', 'CONTRA221013468_2', 'cash', 2000, 'CONTRA', 'Balance Transfer Cash to bank', '2022-10-16 13:49:43', NULL),
(19, '221013468', NULL, 5, 'S', '14', 'S_221013468_14_1', 'cash', 852, 'CR', 'Sell to customer. Invoice Num. #S/221013468/14/1', '2022-10-15 18:00:00', NULL),
(20, '221013468', NULL, 5, 'SDP', 'S221013468S1', 'SDP221013468_0', '1', 2000, 'DR', 'Payment To supplier, supplier Code: S221013468S1, name: Britanuia, Amount: 2000', '2022-10-16 14:03:08', NULL),
(21, '221013468', NULL, 5, 'S', '15', 'S_221013468_14_2', 'cash', 320, 'CR', 'Sell to customer. Invoice Num. #S/221013468/14/2', '2022-10-15 18:00:00', NULL),
(22, '221013468', NULL, 5, 'E', '9', 'E221013468_8', 'cash', 1000, 'DR', 'New Expense Added, Ledger Head name: Monthly Expense, Voucher Num: E221013468/8', '2022-10-15 18:00:00', NULL),
(23, '221013468', NULL, 5, 'SIP', '2', 'STB_221013468_2', 'cash', 912, 'DR', 'Supplier Invoice Instant Payment, Invoice Num: # STB/221013468/2', '2022-10-17 11:55:49', NULL),
(24, '221013341', NULL, 4, 'CA', '2', 'CA221013341_1', 'cash', 400000, 'CR', 'Capital Received from Owner, Owner name: Akm Shamim, Voucher Num: #CA221013341/1', '2022-09-30 18:00:00', NULL),
(25, '221013341', NULL, 4, 'S', '16', 'S_221013341_24_1', 'cash', 85000, 'CR', 'Sell to customer. Invoice Num. #S/221013341/24/1', '2022-10-16 18:00:00', NULL),
(26, '221013341', NULL, 4, 'SDP', 'S221013341S1', 'SDP221013341_0', 'cash', 100000, 'DR', 'Payment To supplier, supplier Code: S221013341S1, name: Green 9 Company Limited., Amount: 100000', '2022-10-17 15:13:22', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tutorials`
--

CREATE TABLE `tutorials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `unit_types`
--

CREATE TABLE `unit_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shop_id` int(11) NOT NULL,
  `unit_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `unit_types`
--

INSERT INTO `unit_types` (`id`, `shop_id`, `unit_name`, `active`, `created_at`, `updated_at`) VALUES
(1, 221013160, 'piece', 1, '2022-10-15 04:46:54', NULL),
(2, 221013160, 'Litre', 1, '2022-10-15 04:47:21', NULL),
(3, 221013341, 'piece', 1, '2022-10-15 09:54:06', NULL),
(4, 221013468, 'piece', 1, '2022-10-15 10:52:23', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shop_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `sr_area_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `current_team_id` bigint(20) UNSIGNED DEFAULT NULL,
  `profile_photo_path` varchar(2048) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_employee` int(11) NOT NULL DEFAULT 0,
  `sallery` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cv` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nid_info` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `shop_id`, `branch_id`, `sr_area_id`, `name`, `email`, `phone`, `type`, `address`, `active`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `remember_token`, `current_team_id`, `profile_photo_path`, `is_employee`, `sallery`, `cv`, `nid_info`, `created_at`, `updated_at`) VALUES
(1, 221013160, NULL, NULL, 'Ridoy Paul', 'cse.ridoypaul@gmail.com', '01627382866', 'owner', NULL, '1', NULL, '$2y$10$HMH4ZN6UGbRFcBjSnOn/yOHiBjN5EaLkZiOWWXFuyqFSBAwKHaKgu', NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '2022-10-13 12:36:29', '2022-10-13 12:36:29'),
(3, 221013169, NULL, NULL, 'Fahid', 'info@faraitltd.com', '01627382864', 'super_admin', NULL, '1', NULL, '$2y$10$HMH4ZN6UGbRFcBjSnOn/yOHiBjN5EaLkZiOWWXFuyqFSBAwKHaKgu', NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '2022-10-13 12:36:29', '2022-10-13 12:36:29'),
(4, 221013341, NULL, NULL, 'AKM Shamim', 'akmsamim30@gmail.com', '01716395573', 'owner', NULL, '1', NULL, '$2y$10$wFLr9qBRS8HAjVTjl.iVsez3yUSLZHDMnqXq1RpIcnE2IiMooLiiS', NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '2022-10-13 17:02:24', '2022-10-13 17:02:44'),
(5, 221013468, NULL, NULL, 'Fahid', 'fahid824@gmail.com', '01625280778', 'owner', NULL, '1', NULL, '$2y$10$G4v625Cj.DsBkyHYP9P2lOTbEyXD.gCgrkDaMfbRT8UbfjuaKR0g.', NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '2022-10-13 17:04:24', '2022-10-13 17:04:47'),
(6, 221013160, NULL, 1, 'abul kabul', 'abulkabul@gmail.com', '12345678900', 'SR', 'Shah Ali plaza', '1', '2022-10-15 05:04:32', '$2y$10$Q8xUwMYpZbPFFFLSIJLGqOSVYqz.MCCNkmHjQ8an.5Yn7ow9xtNla', NULL, NULL, NULL, NULL, NULL, 1, '42', NULL, NULL, NULL, '2022-10-15 08:28:09'),
(7, 221013468, NULL, 2, 'Abir', 'abir1@gmail.com', '12345678901', 'SR', 'Mirpur', '1', '2022-10-15 08:28:46', '$2y$10$lIF7FPZdXxxd1GaEu.FHV.mAaLQ7n1zX4K5qu.39Rvy7JrhD2EtSq', NULL, NULL, NULL, NULL, NULL, 1, '12', NULL, NULL, NULL, NULL),
(8, 221013160, NULL, 2, 'Omar Faruk', 'admin@gmail.com', '0121545245', 'SR', 'xfggfgsgj', '1', '2022-10-15 11:29:32', '$2y$10$7F6fu2QZ9a3ZagsOo49ZmumyARS4slPNFCDJqqVhE0DfeGZSvpSDq', NULL, NULL, NULL, NULL, NULL, 1, '20000', NULL, NULL, NULL, '2022-10-16 11:18:50'),
(9, 221013160, NULL, NULL, 'Mim Dewan', 'omarfaruk678@gmail.com', '01754206780', 'other', 'xfggfgsgj', '1', '2022-10-15 11:34:04', '$2y$10$mD5grhmlKQUV0sdrYbhVmuWNVenXTu9mMpdJ4U4ruENxyhijf42Ca', NULL, NULL, NULL, NULL, NULL, 1, '12000', NULL, NULL, NULL, NULL),
(10, 221013160, NULL, 1, 'test', 'test@gmail.com', '01627382666', 'SR', 'Shah Ali plaza', '1', '2022-10-15 11:36:19', '$2y$10$qx7tONTVT29ZrgRVIReEJ.oukUyoSdLu.gx4MREdBRDxmHLkc7wQO', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL),
(11, 221013341, NULL, NULL, 'Saju Paul', 'sajuppaul810@gmail.com', '01796262571', 'other', 'Sylhet', '1', '2022-10-15 11:59:22', '$2y$10$IO5nIoxQ6T7ysaJ.kUBkjetK8qdcoxobsTh5G1ufWNhaUPPWt71Ha', NULL, NULL, NULL, NULL, NULL, 1, '10000', NULL, NULL, NULL, NULL),
(12, 221013160, NULL, NULL, 'sohel Mia', 'sohel@gmail.com', '01234567888', 'other', 'Shah Ali plaza', '1', '2022-10-15 12:03:46', '$2y$10$jMlT60CXDhNL4CqQf12Xzes2OhkRusZwjd4EyJOOhqZKM3IjBaOsa', NULL, NULL, NULL, NULL, NULL, 1, '20000', NULL, NULL, NULL, NULL),
(13, 221013341, NULL, 3, 'Amith Roy', 'am@mail.com', '01721069111', 'SR', 'Major Tila', '1', '2022-10-15 13:22:08', '$2y$10$4yau02kNdj9YmULX93Eak.95cSk.xEjG7JI6L3Un/nwfU2IdZAFai', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL),
(14, 221013468, NULL, 2, 'Fahid', 'f@a.com', '12468446317', 'SR', 'Dhaka', '1', '2022-10-15 13:59:07', '$2y$10$CLa7EEjZ/oAOY7jxeXTLReCCkWD5sgzKaXQDKtS5iOYSN9TwnPiFG', NULL, NULL, NULL, NULL, NULL, 1, '10000', NULL, NULL, NULL, '2022-10-16 13:00:08'),
(15, 221013341, NULL, NULL, 'Lutfar Rahman', 'l@a.com', '01712325929', 'other', 'Sylhet', '1', '2022-10-16 10:40:37', '$2y$10$MSQztCJ2lCd0IMsvzTMpaeY9ruNp5i/dC7ueDGlgdHuge24VVMks2', NULL, NULL, NULL, NULL, NULL, 1, '6000', NULL, NULL, NULL, NULL),
(16, 221013341, NULL, NULL, 'Milton Chowdhury', 'mc@gmail.com', '01774498655', 'other', 'Roy Nagar', '1', '2022-10-16 10:44:05', '$2y$10$sngry4S8ChEwItOa3mRrvuvg2jW5.1UBnhKlSeKYQKb046dB9PGPq', NULL, NULL, NULL, NULL, NULL, 1, '9000', NULL, NULL, NULL, NULL),
(17, 221013468, NULL, NULL, 'Md Roise Mia', 'm@a.com', '01716221171', 'other', 'Sheikh Para', '1', '2022-10-16 11:21:55', '$2y$10$q0QvrZc/rUOcamTYWsvJPO0oiJfyBAfaQwvX9h/aIEcmGLcWm3PnG', NULL, NULL, NULL, NULL, NULL, 1, '8000', NULL, NULL, NULL, NULL),
(18, 221013341, NULL, NULL, 'Md Roise Mia', 's@f.com', '01716221170', 'other', 'Sheikh Para', '1', '2022-10-16 11:24:25', '$2y$10$SnPu6ihEfJ50XktpK8hty.WBZr/zeJwS1Ba.P9s4d.86xy1asjama', NULL, NULL, NULL, NULL, NULL, 1, '8000', NULL, NULL, NULL, NULL),
(19, 221013341, NULL, NULL, 'Md Ossman', 'o@gmail.com', '01796823664', 'other', 'West Kajol Sha', '1', '2022-10-16 11:27:14', '$2y$10$Ow3WTVY3B5W7u4zk6g3QCetlFDEWTgqCw5aqGisH9M36qPC92Qns2', NULL, NULL, NULL, NULL, NULL, 1, '9000', NULL, NULL, NULL, NULL),
(20, 221013341, NULL, NULL, 'Shaleh Ahmed', 'a@n.com', '01796789710', 'other', 'Lati Tila', '1', '2022-10-16 14:35:50', '$2y$10$eX.TflpznRtwvX6.FaKG1.PfDyVZdqi0bMsuYnOl9/CcuzxfKvPAy', NULL, NULL, NULL, NULL, NULL, 1, '9000', NULL, NULL, NULL, NULL),
(21, 221013341, NULL, NULL, 'Md Eliyas', 'e2i@gmail.com', '01647834276', 'other', 'Jawa Bazar', '1', '2022-10-16 15:15:09', '$2y$10$lMKU25IN5dowwk11ornHA.15oxKukxEsAxVeW6Z7ZLFjPsdKLj2QC', NULL, NULL, NULL, NULL, NULL, 1, '6000', NULL, NULL, NULL, NULL),
(22, 221013341, NULL, NULL, 'Saju Paul', 'msnessaenterprise@gmail.com', '01312395573', 'owner_helper', 'Sylhet', '1', NULL, '$2y$10$13LKWZFpcbN5fHfi6HkRfOY/5p8SBSwu5fTZn6tOrwiZffYGp3MZW', NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL),
(23, 221013341, NULL, NULL, 'Md Badar Uddin Ahmed Kamran (Mahabub)', 'n@b.com', '01312662694', 'other', 'Char Kali Das, Jawa, Chattak, Sunamganj', '1', '2022-10-16 16:12:07', '$2y$10$ULhLkzgJmdXBP3BrsC9IlOO2R4tFcEKhVsCeKIj/B7z77iKlDeFwO', NULL, NULL, NULL, NULL, NULL, 1, '7000', NULL, NULL, NULL, NULL),
(24, 221013341, NULL, 4, 'Md. Ruman Ahmed (G-9)', 'r@gmail.com', '01790875533', 'SR', 'Silaura Jogonnathpu', '1', '2022-10-17 07:13:19', '$2y$10$qxnzxbrLutR7Wi1m.E5QOOmBr/7e7ZPSQ9syw5sc6gtPJ11y.y2vq', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `variation_lists`
--

CREATE TABLE `variation_lists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shop_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `variation_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `list_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `areas`
--
ALTER TABLE `areas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `areas_shop_id_index` (`shop_id`);

--
-- Indexes for table `banks`
--
ALTER TABLE `banks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `banks_shop_id_index` (`shop_id`);

--
-- Indexes for table `barcode_printers`
--
ALTER TABLE `barcode_printers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `barcode_printers_shop_id_index` (`shop_id`),
  ADD KEY `barcode_printers_branch_id_index` (`branch_id`),
  ADD KEY `barcode_printers_code_index` (`code`);

--
-- Indexes for table `branch_settings`
--
ALTER TABLE `branch_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `branch_settings_shop_id_index` (`shop_id`);

--
-- Indexes for table `branch_to_branch_transfers`
--
ALTER TABLE `branch_to_branch_transfers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `branch_to_branch_transfers_shop_id_index` (`shop_id`),
  ADD KEY `branch_to_branch_transfers_user_id_index` (`user_id`),
  ADD KEY `branch_to_branch_transfers_invoice_id_index` (`invoice_id`),
  ADD KEY `branch_to_branch_transfers_sender_branch_id_index` (`sender_branch_id`),
  ADD KEY `branch_to_branch_transfers_receiver_branch_id_index` (`receiver_branch_id`);

--
-- Indexes for table `branch_to_branch_transfer_products`
--
ALTER TABLE `branch_to_branch_transfer_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `branch_to_branch_transfer_products_invoice_id_index` (`invoice_id`),
  ADD KEY `branch_to_branch_transfer_products_pid_index` (`pid`),
  ADD KEY `branch_to_branch_transfer_products_variation_id_index` (`variation_id`);

--
-- Indexes for table `branch_to_sr_transfered_products`
--
ALTER TABLE `branch_to_sr_transfered_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `branch_to_sr_transfered_products_invoice_id_index` (`invoice_id`),
  ADD KEY `branch_to_sr_transfered_products_sr_id_index` (`sr_id`),
  ADD KEY `branch_to_sr_transfered_products_pid_index` (`pid`),
  ADD KEY `branch_to_sr_transfered_products_variation_id_index` (`variation_id`);

--
-- Indexes for table `branch_to_s_rproducts_transfers`
--
ALTER TABLE `branch_to_s_rproducts_transfers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `branch_to_s_rproducts_transfers_shop_id_index` (`shop_id`),
  ADD KEY `branch_to_s_rproducts_transfers_user_id_index` (`user_id`),
  ADD KEY `branch_to_s_rproducts_transfers_invoice_id_index` (`invoice_id`),
  ADD KEY `branch_to_s_rproducts_transfers_sender_branch_id_index` (`sender_branch_id`),
  ADD KEY `branch_to_s_rproducts_transfers_sr_id_index` (`sr_id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`),
  ADD KEY `brands_shop_id_index` (`shop_id`);

--
-- Indexes for table `business_renews`
--
ALTER TABLE `business_renews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `business_renews_shop_id_index` (`shop_id`),
  ADD KEY `business_renews_renew_by_index` (`renew_by`);

--
-- Indexes for table `capital_transactions`
--
ALTER TABLE `capital_transactions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `capital_transactions_voucher_num_unique` (`voucher_num`),
  ADD KEY `capital_transactions_shop_id_index` (`shop_id`),
  ADD KEY `capital_transactions_user_id_index` (`user_id`),
  ADD KEY `capital_transactions_owner_id_index` (`owner_id`);

--
-- Indexes for table `cash_flows`
--
ALTER TABLE `cash_flows`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cash_flows_shop_id_index` (`shop_id`),
  ADD KEY `cash_flows_user_id_index` (`user_id`),
  ADD KEY `cash_flows_branch_id_index` (`branch_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categories_shop_id_index` (`shop_id`);

--
-- Indexes for table `contras`
--
ALTER TABLE `contras`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contras_voucher_number_index` (`voucher_number`),
  ADD KEY `contras_shop_id_index` (`shop_id`),
  ADD KEY `contras_user_id_index` (`user_id`),
  ADD KEY `contras_ctb_or_btc_index` (`CTB_or_BTC`),
  ADD KEY `contras_sender_index` (`sender`),
  ADD KEY `contras_receiver_index` (`receiver`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customers_code_unique` (`code`),
  ADD UNIQUE KEY `customers_phone_unique` (`phone`),
  ADD KEY `customers_shop_id_index` (`shop_id`),
  ADD KEY `customers_area_id_index` (`area_id`),
  ADD KEY `customers_branch_id_index` (`branch_id`);

--
-- Indexes for table `customer_types`
--
ALTER TABLE `customer_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_types_shop_id_index` (`shop_id`);

--
-- Indexes for table `damage_products`
--
ALTER TABLE `damage_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `damage_products_shop_id_index` (`shop_id`),
  ADD KEY `damage_products_branch_id_index` (`branch_id`),
  ADD KEY `damage_products_pid_index` (`pid`),
  ADD KEY `damage_products_variation_id_index` (`variation_id`),
  ADD KEY `damage_products_created_by_index` (`created_by`);

--
-- Indexes for table `expense_groups`
--
ALTER TABLE `expense_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expense_transactions`
--
ALTER TABLE `expense_transactions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `expense_transactions_voucher_num_unique` (`voucher_num`),
  ADD KEY `expense_transactions_shop_id_index` (`shop_id`),
  ADD KEY `expense_transactions_user_id_index` (`user_id`),
  ADD KEY `expense_transactions_ledger_head_index` (`ledger_head`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `godown_stock_out_invoices`
--
ALTER TABLE `godown_stock_out_invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `godown_stock_out_invoices_shop_id_index` (`shop_id`),
  ADD KEY `godown_stock_out_invoices_user_id_index` (`user_id`),
  ADD KEY `godown_stock_out_invoices_invoice_id_index` (`invoice_id`),
  ADD KEY `godown_stock_out_invoices_branch_id_index` (`branch_id`);

--
-- Indexes for table `indirect_incomes`
--
ALTER TABLE `indirect_incomes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `indirect_incomes_voucher_num_index` (`voucher_num`),
  ADD KEY `indirect_incomes_shop_id_index` (`shop_id`),
  ADD KEY `indirect_incomes_user_id_index` (`user_id`),
  ADD KEY `indirect_incomes_ledger_head_index` (`ledger_head`);

--
-- Indexes for table `ledger__heads`
--
ALTER TABLE `ledger__heads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ledger__heads_shop_id_index` (`shop_id`),
  ADD KEY `ledger__heads_group_id_index` (`group_id`);

--
-- Indexes for table `loan_people`
--
ALTER TABLE `loan_people`
  ADD PRIMARY KEY (`id`),
  ADD KEY `loan_people_shop_id_index` (`shop_id`);

--
-- Indexes for table `loan_transactions`
--
ALTER TABLE `loan_transactions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `loan_transactions_voucher_num_unique` (`voucher_num`),
  ADD KEY `loan_transactions_shop_id_index` (`shop_id`),
  ADD KEY `loan_transactions_user_id_index` (`user_id`),
  ADD KEY `loan_transactions_lender_id_index` (`lender_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `moments_traffics`
--
ALTER TABLE `moments_traffics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `moments_traffics_shop_id_index` (`shop_id`),
  ADD KEY `moments_traffics_user_id_index` (`user_id`);

--
-- Indexes for table `multiple_payments`
--
ALTER TABLE `multiple_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `multiple_payments_shop_id_index` (`shop_id`),
  ADD KEY `multiple_payments_customer_id_index` (`customer_id`),
  ADD KEY `multiple_payments_branch_id_index` (`branch_id`),
  ADD KEY `multiple_payments_invoice_id_index` (`invoice_id`);

--
-- Indexes for table `net_cash_bls`
--
ALTER TABLE `net_cash_bls`
  ADD PRIMARY KEY (`id`),
  ADD KEY `net_cash_bls_shop_id_index` (`shop_id`);

--
-- Indexes for table `ordered_products`
--
ALTER TABLE `ordered_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ordered_products_invoice_id_index` (`invoice_id`),
  ADD KEY `ordered_products_lot_number_index` (`lot_number`),
  ADD KEY `ordered_products_product_id_index` (`product_id`),
  ADD KEY `ordered_products_variation_id_index` (`variation_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_invoice_id_unique` (`invoice_id`),
  ADD KEY `orders_shop_id_index` (`shop_id`),
  ADD KEY `orders_branch_id_index` (`branch_id`),
  ADD KEY `orders_area_id_index` (`area_id`),
  ADD KEY `orders_sr_id_index` (`sr_id`),
  ADD KEY `orders_customer_id_index` (`customer_id`),
  ADD KEY `orders_crm_id_index` (`crm_id`);

--
-- Indexes for table `order_return_porducts`
--
ALTER TABLE `order_return_porducts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_return_porducts_invoice_id_index` (`invoice_id`),
  ADD KEY `order_return_porducts_lot_number_index` (`lot_number`),
  ADD KEY `order_return_porducts_product_id_index` (`product_id`),
  ADD KEY `order_return_porducts_variation_id_index` (`variation_id`);

--
-- Indexes for table `owners`
--
ALTER TABLE `owners`
  ADD PRIMARY KEY (`id`),
  ADD KEY `owners_shop_id_index` (`shop_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `point_redeem_infos`
--
ALTER TABLE `point_redeem_infos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `point_redeem_infos_shop_id_index` (`shop_id`),
  ADD KEY `point_redeem_infos_customer_id_index` (`customer_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_shop_id_index` (`shop_id`),
  ADD KEY `products_p_cat_index` (`p_cat`),
  ADD KEY `products_p_brand_index` (`p_brand`),
  ADD KEY `products_p_unit_type_index` (`p_unit_type`);

--
-- Indexes for table `product_stocks`
--
ALTER TABLE `product_stocks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_stocks_shop_id_index` (`shop_id`),
  ADD KEY `product_stocks_purchase_line_id_index` (`purchase_line_id`),
  ADD KEY `product_stocks_branch_id_index` (`branch_id`),
  ADD KEY `product_stocks_pid_index` (`pid`),
  ADD KEY `product_stocks_variation_id_index` (`variation_id`),
  ADD KEY `product_stocks_sales_price_index` (`sales_price`),
  ADD KEY `product_stocks_discount_index` (`discount`),
  ADD KEY `product_stocks_discount_amount_index` (`discount_amount`),
  ADD KEY `product_stocks_stock_index` (`stock`);

--
-- Indexes for table `product_trackers`
--
ALTER TABLE `product_trackers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_trackers_shop_id_index` (`shop_id`),
  ADD KEY `product_trackers_purchase_line_id_index` (`purchase_line_id`),
  ADD KEY `product_trackers_lot_number_index` (`lot_number`),
  ADD KEY `product_trackers_branch_id_index` (`branch_id`),
  ADD KEY `product_trackers_product_id_index` (`product_id`),
  ADD KEY `product_trackers_invoice_id_index` (`invoice_id`),
  ADD KEY `product_trackers_supplier_id_index` (`supplier_id`);

--
-- Indexes for table `product_variations`
--
ALTER TABLE `product_variations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_variations_shop_id_index` (`shop_id`);

--
-- Indexes for table `product_with_variations`
--
ALTER TABLE `product_with_variations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_with_variations_shop_id_index` (`shop_id`),
  ADD KEY `product_with_variations_pid_index` (`pid`),
  ADD KEY `product_with_variations_variation_list_id_index` (`variation_list_id`);

--
-- Indexes for table `purchase_lines`
--
ALTER TABLE `purchase_lines`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_lines_shop_id_index` (`shop_id`),
  ADD KEY `purchase_lines_branch_id_index` (`branch_id`),
  ADD KEY `purchase_lines_invoice_id_index` (`invoice_id`),
  ADD KEY `purchase_lines_product_id_index` (`product_id`),
  ADD KEY `purchase_lines_lot_number_index` (`lot_number`);

--
-- Indexes for table `return_orders`
--
ALTER TABLE `return_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `return_orders_shop_id_index` (`shop_id`),
  ADD KEY `return_orders_branch_id_index` (`branch_id`),
  ADD KEY `return_orders_invoice_id_index` (`invoice_id`),
  ADD KEY `return_orders_customer_id_index` (`customer_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `shop_settings`
--
ALTER TABLE `shop_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `shop_settings_shop_code_unique` (`shop_code`);

--
-- Indexes for table `sms`
--
ALTER TABLE `sms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sms_shop_id_index` (`shop_id`),
  ADD KEY `sms_branch_id_index` (`branch_id`);

--
-- Indexes for table `sms_histories`
--
ALTER TABLE `sms_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sms_histories_shop_id_index` (`shop_id`),
  ADD KEY `sms_histories_user_id_index` (`user_id`);

--
-- Indexes for table `sms_recharge_requests`
--
ALTER TABLE `sms_recharge_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sms_recharge_requests_shop_id_index` (`shop_id`),
  ADD KEY `sms_recharge_requests_user_id_index` (`user_id`);

--
-- Indexes for table `sr_to_branch_transfers`
--
ALTER TABLE `sr_to_branch_transfers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sr_to_branch_transfers_shop_id_index` (`shop_id`),
  ADD KEY `sr_to_branch_transfers_user_id_index` (`user_id`),
  ADD KEY `sr_to_branch_transfers_invoice_id_index` (`invoice_id`),
  ADD KEY `sr_to_branch_transfers_sender_sr_id_index` (`sender_sr_id`),
  ADD KEY `sr_to_branch_transfers_branch_id_index` (`branch_id`);

--
-- Indexes for table `sr_to_branch_transfer_products`
--
ALTER TABLE `sr_to_branch_transfer_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sr_to_branch_transfer_products_invoice_id_index` (`invoice_id`),
  ADD KEY `sr_to_branch_transfer_products_sr_id_index` (`sr_id`),
  ADD KEY `sr_to_branch_transfer_products_pid_index` (`pid`),
  ADD KEY `sr_to_branch_transfer_products_variation_id_index` (`variation_id`);

--
-- Indexes for table `staff_daily_attendences`
--
ALTER TABLE `staff_daily_attendences`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff_in_out_details`
--
ALTER TABLE `staff_in_out_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff_salleries`
--
ALTER TABLE `staff_salleries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `suppliers_code_unique` (`code`),
  ADD UNIQUE KEY `suppliers_phone_unique` (`phone`),
  ADD UNIQUE KEY `suppliers_email_unique` (`email`),
  ADD KEY `suppliers_shop_id_index` (`shop_id`);

--
-- Indexes for table `supplier_invoices`
--
ALTER TABLE `supplier_invoices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `supplier_invoices_supp_invoice_id_unique` (`supp_invoice_id`),
  ADD KEY `supplier_invoices_shop_id_index` (`shop_id`),
  ADD KEY `supplier_invoices_supplier_id_index` (`supplier_id`),
  ADD KEY `supplier_invoices_branch_id_index` (`branch_id`);

--
-- Indexes for table `supplier_inv_returns`
--
ALTER TABLE `supplier_inv_returns`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `supplier_inv_returns_supp_invoice_id_unique` (`supp_invoice_id`),
  ADD KEY `supplier_inv_returns_shop_id_index` (`shop_id`),
  ADD KEY `supplier_inv_returns_supplier_id_index` (`supplier_id`);

--
-- Indexes for table `supplier_payments`
--
ALTER TABLE `supplier_payments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `supplier_payments_voucher_number_unique` (`voucher_number`),
  ADD KEY `supplier_payments_shop_id_index` (`shop_id`),
  ADD KEY `supplier_payments_supplier_code_index` (`supplier_code`);

--
-- Indexes for table `supplier_return_products`
--
ALTER TABLE `supplier_return_products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `supplier_return_products_supp_invoice_id_unique` (`supp_invoice_id`),
  ADD KEY `supplier_return_products_shop_id_index` (`shop_id`),
  ADD KEY `supplier_return_products_product_id_index` (`product_id`),
  ADD KEY `supplier_return_products_variation_id_index` (`variation_id`);

--
-- Indexes for table `s_m_s_settings`
--
ALTER TABLE `s_m_s_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `s_r_stocks`
--
ALTER TABLE `s_r_stocks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `s_r_stocks_shop_id_index` (`shop_id`),
  ADD KEY `s_r_stocks_purchase_line_id_index` (`purchase_line_id`),
  ADD KEY `s_r_stocks_sr_id_index` (`sr_id`),
  ADD KEY `s_r_stocks_pid_index` (`pid`),
  ADD KEY `s_r_stocks_variation_id_index` (`variation_id`),
  ADD KEY `s_r_stocks_sales_price_index` (`sales_price`),
  ADD KEY `s_r_stocks_discount_index` (`discount`),
  ADD KEY `s_r_stocks_discount_amount_index` (`discount_amount`),
  ADD KEY `s_r_stocks_stock_index` (`stock`);

--
-- Indexes for table `take_customer_dues`
--
ALTER TABLE `take_customer_dues`
  ADD PRIMARY KEY (`id`),
  ADD KEY `take_customer_dues_shop_id_index` (`shop_id`),
  ADD KEY `take_customer_dues_voucher_number_index` (`voucher_number`),
  ADD KEY `take_customer_dues_user_id_index` (`user_id`),
  ADD KEY `take_customer_dues_branch_id_index` (`branch_id`),
  ADD KEY `take_customer_dues_customer_code_index` (`customer_code`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transactions_shop_id_index` (`shop_id`),
  ADD KEY `transactions_branch_id_index` (`branch_id`),
  ADD KEY `transactions_for_what_index` (`for_what`),
  ADD KEY `transactions_refference_index` (`refference`);

--
-- Indexes for table `tutorials`
--
ALTER TABLE `tutorials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `unit_types`
--
ALTER TABLE `unit_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `unit_types_shop_id_index` (`shop_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_phone_unique` (`phone`),
  ADD KEY `users_shop_id_index` (`shop_id`),
  ADD KEY `users_branch_id_index` (`branch_id`),
  ADD KEY `users_sr_area_id_index` (`sr_area_id`);

--
-- Indexes for table `variation_lists`
--
ALTER TABLE `variation_lists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `variation_lists_shop_id_index` (`shop_id`),
  ADD KEY `variation_lists_variation_id_index` (`variation_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `areas`
--
ALTER TABLE `areas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `banks`
--
ALTER TABLE `banks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `barcode_printers`
--
ALTER TABLE `barcode_printers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `branch_settings`
--
ALTER TABLE `branch_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `branch_to_branch_transfers`
--
ALTER TABLE `branch_to_branch_transfers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `branch_to_branch_transfer_products`
--
ALTER TABLE `branch_to_branch_transfer_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `branch_to_sr_transfered_products`
--
ALTER TABLE `branch_to_sr_transfered_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `branch_to_s_rproducts_transfers`
--
ALTER TABLE `branch_to_s_rproducts_transfers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `business_renews`
--
ALTER TABLE `business_renews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `capital_transactions`
--
ALTER TABLE `capital_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cash_flows`
--
ALTER TABLE `cash_flows`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `contras`
--
ALTER TABLE `contras`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `customer_types`
--
ALTER TABLE `customer_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `damage_products`
--
ALTER TABLE `damage_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `expense_groups`
--
ALTER TABLE `expense_groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `expense_transactions`
--
ALTER TABLE `expense_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `godown_stock_out_invoices`
--
ALTER TABLE `godown_stock_out_invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `indirect_incomes`
--
ALTER TABLE `indirect_incomes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ledger__heads`
--
ALTER TABLE `ledger__heads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `loan_people`
--
ALTER TABLE `loan_people`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `loan_transactions`
--
ALTER TABLE `loan_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT for table `moments_traffics`
--
ALTER TABLE `moments_traffics`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=362;

--
-- AUTO_INCREMENT for table `multiple_payments`
--
ALTER TABLE `multiple_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `net_cash_bls`
--
ALTER TABLE `net_cash_bls`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ordered_products`
--
ALTER TABLE `ordered_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `order_return_porducts`
--
ALTER TABLE `order_return_porducts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `owners`
--
ALTER TABLE `owners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `point_redeem_infos`
--
ALTER TABLE `point_redeem_infos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=146;

--
-- AUTO_INCREMENT for table `product_stocks`
--
ALTER TABLE `product_stocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=139;

--
-- AUTO_INCREMENT for table `product_trackers`
--
ALTER TABLE `product_trackers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=228;

--
-- AUTO_INCREMENT for table `product_variations`
--
ALTER TABLE `product_variations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_with_variations`
--
ALTER TABLE `product_with_variations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_lines`
--
ALTER TABLE `purchase_lines`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134;

--
-- AUTO_INCREMENT for table `return_orders`
--
ALTER TABLE `return_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `shop_settings`
--
ALTER TABLE `shop_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sms`
--
ALTER TABLE `sms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sms_histories`
--
ALTER TABLE `sms_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sms_recharge_requests`
--
ALTER TABLE `sms_recharge_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sr_to_branch_transfers`
--
ALTER TABLE `sr_to_branch_transfers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `sr_to_branch_transfer_products`
--
ALTER TABLE `sr_to_branch_transfer_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `staff_daily_attendences`
--
ALTER TABLE `staff_daily_attendences`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `staff_in_out_details`
--
ALTER TABLE `staff_in_out_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `staff_salleries`
--
ALTER TABLE `staff_salleries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `supplier_invoices`
--
ALTER TABLE `supplier_invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `supplier_inv_returns`
--
ALTER TABLE `supplier_inv_returns`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `supplier_payments`
--
ALTER TABLE `supplier_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `supplier_return_products`
--
ALTER TABLE `supplier_return_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `s_m_s_settings`
--
ALTER TABLE `s_m_s_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `s_r_stocks`
--
ALTER TABLE `s_r_stocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `take_customer_dues`
--
ALTER TABLE `take_customer_dues`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `tutorials`
--
ALTER TABLE `tutorials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `unit_types`
--
ALTER TABLE `unit_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `variation_lists`
--
ALTER TABLE `variation_lists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
