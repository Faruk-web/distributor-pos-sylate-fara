-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 01, 2022 at 12:14 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ehishab_pos`
--

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

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shop_id` int(11) NOT NULL,
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

INSERT INTO `customers` (`id`, `shop_id`, `branch_id`, `code`, `name`, `email`, `phone`, `address`, `customers_type_id`, `opening_bl`, `is_comissioned`, `balance`, `wallets`, `wallet_balance`, `active`, `created_at`, `updated_at`) VALUES
(1, 221001319, NULL, '221001319WALKING', 'Walking Customer', 'WC221001319@gmail.com', 'p221001319', 'none', NULL, 0, NULL, 0, NULL, NULL, 1, NULL, NULL);

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
(76, '2022_07_09_111422_create_multiple_payments_table', 1);

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
(1, '221001319', 1, 'Logged In. IP Address: 127.0.0.1', '2022-10-01 10:11:20', NULL),
(2, '221001319', 1, 'Want to logged in, but due to deactivation can not logged in.', '2022-10-01 10:11:20', NULL),
(3, '221001319', 1, 'Logged In. IP Address: 127.0.0.1', '2022-10-01 10:12:08', NULL);

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
(1, 221001319, 0, NULL, NULL);

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
  `price` double NOT NULL,
  `discount` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no',
  `discount_amount` double NOT NULL DEFAULT 0,
  `discount_in_tk` double NOT NULL DEFAULT 0,
  `vat_amount` double DEFAULT NULL,
  `total_price` double NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shop_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `total_gross` double NOT NULL,
  `vat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `vat_in_tk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `discount_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount_rate` double DEFAULT NULL,
  `discount_in_tk` double NOT NULL DEFAULT 0,
  `pre_due` double NOT NULL DEFAULT 0,
  `others_crg` double NOT NULL DEFAULT 0,
  `delivery_crg` double NOT NULL DEFAULT 0,
  `invoice_total` double NOT NULL DEFAULT 0,
  `payment_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `wallet_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no',
  `wallet_balance` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `total_for_point` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `point_earn_rate` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `wallet_point` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `paid_amount` double NOT NULL DEFAULT 0,
  `change_amount` double NOT NULL DEFAULT 0,
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
  `sms_status` int(11) NOT NULL DEFAULT 0,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(53, 'account.dashboard', 'web', 'Account_Wing', NULL, NULL),
(54, 'account.loan', 'web', 'Account_Wing', NULL, NULL),
(55, 'account.list.of.group', 'web', 'Account_Wing', NULL, NULL),
(56, 'account.ledger.head', 'web', 'Account_Wing', NULL, NULL),
(57, 'account.bank.and.cash', 'web', 'Account_Wing', NULL, NULL),
(58, 'account.transaction', 'web', 'Account_Wing', NULL, NULL),
(59, 'account.vouchers', 'web', 'Account_Wing', NULL, NULL),
(60, 'account.customer.report', 'web', 'Account_Wing', NULL, NULL),
(61, 'account.report', 'web', 'Account_Wing', NULL, NULL),
(62, 'account.income.statement', 'web', 'Account_Wing', NULL, NULL),
(63, 'admin.transaction.vouchers', 'web', 'Account_Wing', NULL, NULL),
(64, 'account.capital', 'web', 'Account_Wing', NULL, NULL),
(65, 'account.expense', 'web', 'Account_Wing', NULL, NULL),
(66, 'account.statement', 'web', 'Account_Wing', NULL, NULL),
(67, 'account.indirect.income', 'web', 'Account_Wing', NULL, NULL),
(68, 'branch.dashboard', 'web', 'Branch', NULL, NULL),
(69, 'branch.customers', 'web', 'Branch', NULL, NULL),
(70, 'branch.product.stock', 'web', 'Branch', NULL, NULL),
(71, 'branch.sell', 'web', 'Branch', NULL, NULL),
(72, 'branch.return.product', 'web', 'Branch', NULL, NULL),
(73, 'branch.deliveryman', 'web', 'Branch', NULL, NULL),
(74, 'branch.received.customer.due', 'web', 'Branch', NULL, NULL),
(75, 'branch.reports', 'web', 'Branch', NULL, NULL),
(76, 'branch.damage.product', 'web', 'Branch', NULL, NULL),
(77, 'branch.setting', 'web', 'Branch', NULL, NULL),
(78, 'branch.sell.discount', 'web', 'Branch', NULL, NULL),
(79, 'godown.dashboard', 'web', 'Godown_Wing', NULL, NULL),
(80, 'godown.stock.info', 'web', 'Godown_Wing', NULL, NULL),
(81, 'godown.stock.out', 'web', 'Godown_Wing', NULL, NULL),
(82, 'godown.stock.in.out.report', 'web', 'Godown_Wing', NULL, NULL),
(83, 'admin.setting', 'web', 'Main_Wing', NULL, NULL),
(84, 'admin.dashboard', 'web', 'Main_Wing', NULL, NULL),
(85, 'admin.helper.role.permission', 'web', 'Main_Wing', NULL, NULL),
(86, 'branch', 'web', 'Main_Wing', NULL, NULL),
(87, 'admin.crm', 'web', 'Main_Wing', NULL, NULL),
(88, 'admin.deliveryman', 'web', 'Main_Wing', NULL, NULL),
(89, 'admin.products', 'web', 'Main_Wing', NULL, NULL),
(90, 'branch.role.permission', 'web', 'Main_Wing', NULL, NULL),
(91, 'others.customers', 'web', 'Main_Wing', NULL, NULL),
(92, 'others.sell', 'web', 'Main_Wing', NULL, NULL),
(93, 'others.receive.customers.due', 'web', 'Main_Wing', NULL, NULL),
(94, 'others.returns.refund', 'web', 'Main_Wing', NULL, NULL),
(95, 'admin.branch.product.stock', 'web', 'Main_Wing', NULL, NULL),
(96, 'admin.set.opening.and.own.stock', 'web', 'Main_Wing', NULL, NULL),
(97, 'admin.product.ledger.table', 'web', 'Main_Wing', NULL, NULL),
(98, 'admin.damage.product', 'web', 'Main_Wing', NULL, NULL),
(99, 'admin.header.balance.statements', 'web', 'Main_Wing', NULL, NULL),
(100, 'admin.sms.panel', 'web', 'Main_Wing', NULL, NULL),
(101, 'others.sell.discount', 'web', 'Main_Wing', NULL, NULL),
(102, 'supplier.dashboard', 'web', 'Supplier_Wing', NULL, NULL),
(103, 'supplier.add', 'web', 'Supplier_Wing', NULL, NULL),
(104, 'supplier.stock.in', 'web', 'Supplier_Wing', NULL, NULL),
(105, 'supplier.view.and.edit', 'web', 'Supplier_Wing', NULL, NULL),
(106, 'supplier.report', 'web', 'Supplier_Wing', NULL, NULL),
(107, 'supplier.table.ledger', 'web', 'Supplier_Wing', NULL, NULL),
(108, 'supplier.return.product', 'web', 'Supplier_Wing', NULL, NULL);

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
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `purchase_price` double NOT NULL,
  `selling_price` double NOT NULL,
  `barCode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `p_description` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vat_status` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vat_rate` double DEFAULT NULL,
  `discount` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount_amount` double DEFAULT NULL,
  `is_warranty` int(11) NOT NULL DEFAULT 0,
  `warranty_id` int(11) DEFAULT NULL,
  `is_expiry` int(11) NOT NULL DEFAULT 0,
  `is_variable` int(11) NOT NULL DEFAULT 0,
  `alert_quantity` int(11) DEFAULT NULL,
  `active` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `branch_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` double NOT NULL DEFAULT 0,
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
  `supplier_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `note` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
('kk61mcUsvSh4c1RolMzQzVu4lqeK8aHAwvmSSJ2H', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/106.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiRnJuVlhtZkFHTU5IVGt1TVdwclo1N3d0Vkx6WHFVbjNJRU1zdlRnOSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjIxOiJodHRwOi8vbG9jYWxob3N0OjgwMDAiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6MTc6InBhc3N3b3JkX2hhc2hfd2ViIjtzOjYwOiIkMnkkMTAkR3RnZVVsMWN3NjZ5VE5XSy4xTnJIT0k1LjdFUnp5cDVlMFIvWEtKZjZ2L0NQVFpPYWlqR3UiO30=', 1664619176);

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
  `is_active` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shop_settings`
--

INSERT INTO `shop_settings` (`id`, `shop_code`, `shop_name`, `shop_logo`, `email`, `phone`, `address`, `shop_website`, `vat_type`, `point_redeem_rate`, `point_earn_rate`, `minimum_purchase_to_get_point`, `is_active_customer_points`, `default_branch_id_for_sell`, `sms_active_status`, `sms_limit`, `start_date`, `renew_date`, `reseller_id`, `trial_status`, `trial_end_date`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 221001319, 'FARA IT LTD.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, NULL, NULL, '2022-10-01', NULL, 'none', 'running', NULL, '1', NULL, NULL);

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
  `balance` double DEFAULT NULL,
  `active` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `quantity` double NOT NULL,
  `price` double NOT NULL,
  `total_price` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shop_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `current_team_id` bigint(20) UNSIGNED DEFAULT NULL,
  `profile_photo_path` varchar(2048) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `shop_id`, `branch_id`, `name`, `email`, `phone`, `type`, `address`, `active`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `remember_token`, `current_team_id`, `profile_photo_path`, `created_at`, `updated_at`) VALUES
(1, 221001319, NULL, 'Ridoy Paul', 'cse.ridoypaul@gmail.com', '01627382866', 'owner', NULL, '1', NULL, '$2y$10$GtgeUl1cw66yTNWK.1NrHOI5.7ERzyp5e0R/XKJf6v/CPTZOaijGu', NULL, NULL, NULL, NULL, NULL, '2022-10-01 10:11:20', '2022-10-01 10:11:20');

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
  ADD KEY `users_branch_id_index` (`branch_id`);

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
-- AUTO_INCREMENT for table `banks`
--
ALTER TABLE `banks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `barcode_printers`
--
ALTER TABLE `barcode_printers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `branch_settings`
--
ALTER TABLE `branch_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `business_renews`
--
ALTER TABLE `business_renews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `capital_transactions`
--
ALTER TABLE `capital_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cash_flows`
--
ALTER TABLE `cash_flows`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contras`
--
ALTER TABLE `contras`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customer_types`
--
ALTER TABLE `customer_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `damage_products`
--
ALTER TABLE `damage_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expense_groups`
--
ALTER TABLE `expense_groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expense_transactions`
--
ALTER TABLE `expense_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loan_people`
--
ALTER TABLE `loan_people`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loan_transactions`
--
ALTER TABLE `loan_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `moments_traffics`
--
ALTER TABLE `moments_traffics`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `multiple_payments`
--
ALTER TABLE `multiple_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `net_cash_bls`
--
ALTER TABLE `net_cash_bls`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ordered_products`
--
ALTER TABLE `ordered_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_return_porducts`
--
ALTER TABLE `order_return_porducts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `owners`
--
ALTER TABLE `owners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_stocks`
--
ALTER TABLE `product_stocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_trackers`
--
ALTER TABLE `product_trackers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `return_orders`
--
ALTER TABLE `return_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shop_settings`
--
ALTER TABLE `shop_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `supplier_invoices`
--
ALTER TABLE `supplier_invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `supplier_inv_returns`
--
ALTER TABLE `supplier_inv_returns`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `supplier_payments`
--
ALTER TABLE `supplier_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `supplier_return_products`
--
ALTER TABLE `supplier_return_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `s_m_s_settings`
--
ALTER TABLE `s_m_s_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `take_customer_dues`
--
ALTER TABLE `take_customer_dues`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tutorials`
--
ALTER TABLE `tutorials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `unit_types`
--
ALTER TABLE `unit_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
