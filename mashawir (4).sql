-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 27, 2023 at 11:21 PM
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
-- Database: `mashawir`
--

-- --------------------------------------------------------

--
-- Table structure for table `about_us`
--

CREATE TABLE `about_us` (
  `id` int(11) NOT NULL DEFAULT 1,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `linkedin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `facebook` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `twitter` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_ar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_en` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `aboutUs_ar` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `aboutUs_en` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `terms_condition_ar` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `terms_condition_en` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `about_us`
--

INSERT INTO `about_us` (`id`, `logo`, `phone`, `linkedin`, `facebook`, `twitter`, `location`, `address_ar`, `address_en`, `aboutUs_ar`, `aboutUs_en`, `terms_condition_ar`, `terms_condition_en`, `created_at`, `updated_at`) VALUES
(1, 'image.png', '0251511581', 'linkedin', 'facebook', 'twitter', 'http:\\fddddd', 'تبتssssssssssssssssssssتب', 'تبتتsssssssssssssssssssssssب', 'تبتssssssssssssssfghfsfsfsfssssssssssssssssssssتب', 'تبsssssssssssssssfsdhsfhsssssssssssssssssssssssssتتب', 'تبتتsssssssfsdhfhssssssssssssssssssssب', 'تبتsssssssssssssssssssssتب', '2022-11-16 21:09:57', '2022-11-16 21:09:57');

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `username`, `password`, `phone_number`, `status`, `created_at`, `updated_at`) VALUES
(1, 'mohamedelsolya74@gmail.com', 'mohamedelsolya74@gmail.com', 'admin', '$2y$10$nkhmaPq0V3pliS4spE3/xurWPVSOLZW.K3s1zS7f0D9xiRRaksA9G', '', 'active', NULL, NULL),
(2, 'elsolya', 'ss@dd.comssss', 'elsolya1675806256', '$2y$10$.iqiCSEdFW5iCs5WsebC2.jeA9rduz77Cjq0I5xGSoA4wHc8QDQ2S', '54158', 'inactive', '2023-01-16 16:41:17', '2023-02-07 19:44:16'),
(15, 'elsolya', 'ss@dd.coms', 'elsolya1673895532', '$2y$10$Ri.OL66UcN3t0kSIwY9ChuF1pre7kD8u/eMaXkScBH2ylIMEXTtku', '54158418419', 'active', '2023-01-16 16:58:52', '2023-01-16 16:58:52');

-- --------------------------------------------------------

--
-- Table structure for table `airports`
--

CREATE TABLE `airports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_en` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_ar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `lat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `long` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `airports`
--

INSERT INTO `airports` (`id`, `name_en`, `name_ar`, `status`, `lat`, `long`, `created_at`, `updated_at`) VALUES
(1, 'test namesss', 'test name ar sssssssssss', 'active', NULL, NULL, '2022-12-07 20:01:44', '2022-12-07 20:02:50');

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `banner_type_id` bigint(20) UNSIGNED DEFAULT NULL,
  `target` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`id`, `banner_type_id`, `target`, `image`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'http://127.0.0.1:8000/dddd', 'uploads/j5LwRnHHtPLMQBb9Dy8ksmoXBXRGnhQL8Qd3pBoD.jpg', 'inactive', '2022-12-06 16:35:14', '2022-12-06 16:36:25'),
(3, 1, 'http://127.0.0.1:8000', 'uploads/TOK5nrCP2Gaa4KtA8lp9Mhe0n9U0onNjSV6HEDvT.jpg', 'active', '2022-12-06 16:36:00', '2022-12-06 16:36:00'),
(4, 1, 'http://127.0.0.1:8000', 'uploads/aLZI4oa4Yz55d7CamqfP6olDYEudSi9wdihS48aa.jpg', 'active', '2023-01-30 18:36:00', '2023-01-30 18:36:00'),
(5, 1, 'http://127.0.0.1:8000/dddd', 'uploads/5h4N9FCioOpIYiR77fFtabXPByW2kuITGdREB7Ry.jpg', 'inactive', '2023-02-01 19:19:06', '2023-02-01 19:19:18');

-- --------------------------------------------------------

--
-- Table structure for table `banner_types`
--

CREATE TABLE `banner_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banner_types`
--

INSERT INTO `banner_types` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'servicess', '2022-12-06 16:18:11', '2022-12-06 16:19:13');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_en` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_en` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name_ar` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_ar` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','archived') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name_en`, `description_en`, `name_ar`, `description_ar`, `image`, `status`, `created_at`, `updated_at`) VALUES
(1, 'test name', 'العمالة المنزليه', 'test name ar r', 'العمالة المنزليه', 'uploads/Vz7TeNwGMPrSB7pRBTK5NVZ5Schyqh4uzvqVM9Ri.jpg', 'active', NULL, '2022-12-03 16:47:48'),
(3, 'test name', NULL, 'test name ar', NULL, 'uploads/6524NrR8lbqZWQzdjWdtNN39iD0BtozCNUMCGrsF.png', 'active', '2022-12-03 16:47:23', '2022-12-03 16:47:23'),
(5, 'test name', NULL, 'test name ar', NULL, NULL, 'active', '2023-02-07 19:50:24', '2023-02-07 19:50:24'),
(6, 'test name', NULL, 'test name ar rييي', NULL, 'uploads/hhPDjLwMnE9mtJ4SjX88zI07sUqHuZi7sM3TIeaV.jpg', 'active', '2023-02-07 19:51:09', '2023-02-07 19:51:54');

-- --------------------------------------------------------

--
-- Table structure for table `drivers`
--

CREATE TABLE `drivers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `verification_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `lat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `long` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `fcm_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `drivers`
--

INSERT INTO `drivers` (`id`, `name`, `image`, `email`, `phone`, `email_verified_at`, `verification_code`, `password`, `status`, `lat`, `long`, `created_at`, `updated_at`, `fcm_token`) VALUES
(1, 'dddddd', 'uploads/JIRea8c7NRz3pg5I5sKhFTkTv7GWYcnoxmLB75RP.jpg', 'email@email.com', '45848948111', NULL, '263203', '$2y$10$LNncAeBBjxPrcNSWCjQR2OGuMPbkxPzgHHK2998KqHVFZwO5cFtVi', 'inactive', '22258478.22', '22258478.22', NULL, '2023-01-19 16:13:50', '354654654656'),
(2, 'elsolya', NULL, NULL, '5415841841', NULL, NULL, '$2y$10$6yZqSR4TIbrtoPZVsUKG3OsOtCqhlXS42ADWv4PBMRQ71LOYzWq.W', 'active', NULL, NULL, '2022-12-19 21:17:26', '2022-12-19 21:17:26', NULL),
(3, 'elsolya', NULL, NULL, '54158418411', NULL, NULL, '$2y$10$3Y9O1SLs4w76h/Mj5G2DWOLObDacnDSDvHL1yUKLyK9XVpAAk46o2', 'active', NULL, NULL, '2023-01-07 12:15:47', '2023-01-07 12:15:47', NULL),
(4, 'elsolya', NULL, NULL, '541584184111', NULL, NULL, '$2y$10$P/eK05Z/EHOWsCJehzFyqeCtwM6cHVmpdgCslXVoaxqQhUlqdM4l.', 'active', NULL, NULL, '2023-01-07 12:16:55', '2023-01-07 12:16:55', 'dddd'),
(5, 'fgfgf', NULL, 'ss@dd.com', '541584184110', NULL, NULL, '$2y$10$RX9PHpTjgjQ33uY8Jif5huomTvqI.zzqWREt.H96dTH5wnXiX9ogi', 'inactive', NULL, NULL, '2023-01-15 15:34:24', '2023-02-08 15:30:09', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `drivers_monies`
--

CREATE TABLE `drivers_monies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `driver_id` bigint(20) UNSIGNED DEFAULT NULL,
  `amount` double(8,2) DEFAULT NULL,
  `type` enum('petrol','salary') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'salary',
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `drivers_monies`
--

INSERT INTO `drivers_monies` (`id`, `driver_id`, `amount`, `type`, `notes`, `created_at`, `updated_at`) VALUES
(1, 1, 52.00, 'salary', NULL, '2023-01-16 19:40:42', '2023-01-16 19:40:42'),
(2, 1, 52.00, 'petrol', NULL, '2023-01-16 19:40:42', '2023-01-16 19:40:42'),
(3, 1, 52.00, 'salary', NULL, '2023-01-16 19:40:42', '2023-01-16 19:40:42');

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
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(13, '2022_09_29_141004_create_categories_table', 2),
(14, '2022_11_13_182235_create_services_table', 2),
(15, '2022_11_15_101401_create_admins_table', 3),
(16, '2022_11_15_221826_create_onboards_table', 3),
(20, '2022_11_16_185208_create_about_us_table', 4),
(23, '2022_11_22_200355_create_wallets_table', 6),
(25, '2022_11_22_225953_create_user_credits_table', 7),
(26, '2022_11_23_192536_add_column_balance_to_users_table', 8),
(34, '2022_11_24_182443_create_service_attributes_table', 13),
(38, '2022_12_06_172600_create_banner_types_table', 14),
(39, '2022_12_07_164518_create_banners_table', 14),
(41, '2022_12_07_182539_create_airports_table', 16),
(44, '2022_11_19_134002_create_orders_table', 17),
(45, '2022_11_27_210908_add_columns_verified_and_cancel_reason_to_orders_table', 17),
(46, '2022_11_27_215937_add_column_service_attributes_to_orders_table', 17),
(47, '2022_12_07_181913_add_columns_long_and_lat_to_orders_table', 17),
(48, '2022_12_07_191511_add_columns_airport_id_to_orders_table', 17),
(49, '2022_12_09_143919_add_columns_image_front_and_image_back_to_users_table', 18),
(50, '2022_12_13_193335_add_column_status_users_table', 19),
(51, '2022_12_15_003350_create_payments_table', 20),
(52, '2022_12_19_223915_create_drivers_table', 20),
(53, '2022_12_19_232039_add_driver_id_to_orders_table', 21),
(56, '2022_12_31_125310_add_column_alt_long_to_drivers_table', 23),
(57, '2022_12_20_180012_add_column_driver_status_to_orders_table', 24),
(58, '2022_12_31_180558_add_column_alt_long_to_airports_table', 25),
(59, '2023_01_04_161737_create_notification_data_table', 26),
(60, '2023_01_04_012729_add_column_fcm_token_to_users_table', 27),
(61, '2023_01_07_012729_add_column_fcm_token_to_drivers_table', 28),
(62, '2023_01_16_210441_create_drivers_moneies_table', 29),
(63, '2023_02_05_190033_add_column_category_id_to_orders_table', 30);

-- --------------------------------------------------------

--
-- Table structure for table `notification_data`
--

CREATE TABLE `notification_data` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sender_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `receiver_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `action` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `platform` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notification_data`
--

INSERT INTO `notification_data` (`id`, `sender_id`, `receiver_token`, `title`, `description`, `image`, `action`, `type`, `platform`, `created_at`, `updated_at`) VALUES
(1, 'Yone App', 'ttedhfbgd', ' ! تم انشاء الاورد بنجاح ورقم الاوردر 7', 'تم انشاء الاوردر ب نجاح وهو ف ي الطريق اليك', '', 'create_order', 'create', 'web', '2023-01-04 19:45:30', '2023-01-04 19:45:30'),
(2, 'Yone App', 'ttedhfbgd', ' ! تم انشاء الاورد بنجاح ورقم الاوردر 3', 'تم انشاء الاوردر ب نجاح وهو ف ي الطريق اليك', '', 'create_order', 'create', 'web', '2023-01-04 19:45:33', '2023-01-04 19:45:33'),
(3, 'Mashawir App', NULL, ' ! لديك رحلة جديد ورقم الطلب 2', ' لديك رحلة جديد', '', 'assign_order', 'assign', 'web', '2023-01-07 12:10:29', '2023-01-07 12:10:29'),
(4, 'Mashawir App', 'dddd', ' ! لديك رحلة جديد ورقم الطلب 2', ' لديك رحلة جديد', '', 'assign_order', 'assign', 'web', '2023-01-07 12:17:53', '2023-01-07 12:17:53');

-- --------------------------------------------------------

--
-- Table structure for table `onboards`
--

CREATE TABLE `onboards` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title_en` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_en` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_ar` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_ar` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `onboards`
--

INSERT INTO `onboards` (`id`, `title_en`, `description_en`, `title_ar`, `description_ar`, `image`, `status`, `created_at`, `updated_at`) VALUES
(1, 'sdgsfgrfsgsfgsfg', 'Electronic desc', 'نعباعابعلابعلاعهلات', 'Electronic متبنلاعبعلاعب', 'image.png', 'inactive', '2022-11-16 16:01:06', '2022-11-16 16:04:25'),
(3, 'تبتتب', 'Electronic desc', 'نعباعابعلابعلاعهلات', 'Electronic متبنلاعبعلاعب', 'image.png', 'active', '2022-11-16 16:01:12', '2022-11-16 16:01:12');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `service_id` bigint(20) UNSIGNED DEFAULT NULL,
  `from` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `to` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `appointment_date` date NOT NULL,
  `appointment_time` time NOT NULL,
  `image_front` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_back` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_ticket` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_passport` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'cod',
  `payment_status` enum('pending','paid','failed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `status` enum('pending','processing','delivering','completed','cancelled','refunded') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `total` double(8,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT 0,
  `cancel_reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `service_attributes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`service_attributes`)),
  `lat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `long` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `airport_id` bigint(20) UNSIGNED DEFAULT NULL,
  `driver_id` bigint(20) UNSIGNED DEFAULT NULL,
  `driver_status` enum('new_order','accepted','refused','pending','servant_delivered','servant_delivering') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'new_order',
  `category_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `service_id`, `from`, `to`, `appointment_date`, `appointment_time`, `image_front`, `image_back`, `image_ticket`, `image_passport`, `payment_method`, `payment_status`, `status`, `total`, `created_at`, `updated_at`, `verified`, `cancel_reason`, `service_attributes`, `lat`, `long`, `airport_id`, `driver_id`, `driver_status`, `category_id`) VALUES
(1, 1, 1, 'dobai', 'cairo', '2022-11-20', '05:00:00', 'uploads/8ZzunFLyKbOFun4FtnfboM3QgJ38uuavyyONsQBr.png', 'uploads/W5U2j9gEfwc7o3ln1hb5bRXAM14z5I0tNwwrGb0p.jpg', 'uploads/OHCzNd0wAUgLXu2UBaJiR1DkttRialVYaiCkeQiw.jpg', 'uploads/7tn2ebchYYDSrrG0U19o0ixHZ3q4mhUaErtA7QBR.png', 'cod', 'paid', 'completed', 520.00, '2022-12-07 20:12:30', '2023-01-18 15:14:44', 0, NULL, NULL, '22.33', '585.255', 1, 1, 'accepted', 1),
(2, 1, 1, 'dobai', 'cairo', '2022-11-20', '05:00:00', 'uploads/AaZ4lJmKsNTvyLYVsfJiiJRCX9c3YdMHXAeatXwE.png', 'uploads/ipOu8WlhHZAEDd0TzpSMqQKjZWyrwFMxyfanHvqA.png', 'uploads/01GOr2mk5jxu9BlZpI1GRYxOXcsxMLn7KX2SjNTX.png', 'uploads/FGd7bCQlfepY5zixKFpjriy0CViF2poSxS6YKjAz.png', 'cod', 'paid', 'pending', 520.00, '2023-01-01 11:01:29', '2023-01-07 12:17:48', 0, NULL, NULL, '22.33', '585.255', 1, 4, 'pending', 1),
(3, 1, 2, 'dobai', 'cairo', '2022-11-20', '05:00:00', 'uploads/I6eZEExAA6QjvtQLslk9TnDBVxtikjyumKnMRY3B.png', 'uploads/t2GBhwu5LfJS1BGv0n2V98941sit0rRGSqDb2oKu.png', 'uploads/EFyOCijdh1K1AtuDrtQsIrXPsFwMpeMftKxjRlu4.png', 'uploads/UqALGHXR5KIW3LErh5TQj3uF4uLfY7ejjkcSI2Mj.png', 'cod', 'paid', 'pending', 520.00, '2023-01-01 11:02:57', '2023-01-01 11:02:57', 0, NULL, NULL, '22.33', '585.255', 1, 1, 'pending', 1),
(4, 1, 1, 'dobai', 'cairo', '2022-11-20', '05:00:00', 'uploads/YwCFFIXhsVuIRUG7OLeAv0hreLSGApLFTl71zW4t.png', 'uploads/yd7Exw6ZObO9j3DXbYaGJZwM1hHeS36TnfMYAQ61.png', 'uploads/Ok23mI4RFBgw0OwJoyL0xb0YsfPXz4S1p5CK7KOe.png', 'uploads/3HD1PMNdGpiUdTRipDFEsMmnnlXVjtvYyKK48zBg.png', 'cod', 'paid', 'pending', 100.00, '2023-01-04 19:33:23', '2023-01-04 19:33:23', 0, NULL, NULL, '22.33', '585.255', 1, NULL, 'pending', 1),
(5, 1, 1, 'dobai', 'cairo', '2022-11-20', '05:00:00', 'uploads/FG3KmPoY7MvxqRP3zZoQmZ6NJqcz5R6Jy22D4iD1.png', 'uploads/VnmEjJATjNpak3MNDDZguxEdq3lMPNVej9AAMVd6.png', 'uploads/mC2ph28e4sH3zA09U1W2E31iqxR3GKH9V4ELrEok.png', 'uploads/1NIhqnE2mZVHhn67yyfmWVD9dlafY6DUeHPGD3VF.png', 'cod', 'paid', 'pending', 100.00, '2023-01-04 19:33:33', '2023-01-04 19:33:33', 0, NULL, NULL, '22.33', '585.255', 1, NULL, 'pending', 1),
(6, 1, 2, 'dobai', 'cairo', '2022-11-20', '05:00:00', 'uploads/AMHOtGXH49HRNglZP4zBj57TTFmtIXiq8B6vM2Gi.png', 'uploads/0SKB0RhsX3gUHEiUpZ6lzdOpgkgnOEXXb84W3GDj.png', 'uploads/PwFPLhn4q6qSWNhfykPP9AusaOXI3mbf5fRsJMOe.png', 'uploads/iMt71CWRBlXy7FB6RtuPcEXGVd77mDrycFZgDoNU.png', 'cod', 'paid', 'pending', 520.00, '2023-01-04 19:45:20', '2023-01-04 19:45:20', 0, NULL, NULL, '22.33', '585.255', 1, NULL, 'pending', 1),
(7, 1, 1, 'dobai', 'cairo', '2022-11-20', '05:00:00', 'uploads/qOJAmTXr785zccZUjrfwcl97harrhBveGkl5h47r.png', 'uploads/yQnZpPEx4cx3CiYFDQD89XPTsJ2uZ7di7aJRGgXm.png', 'uploads/SBsXRR5XLm0UgNXuiDNn3ejWyo5J2oCfzEFyhw6l.png', 'uploads/hZLqUnr1P7H7Wjzu5C7xojqReXs3XWKoGnQfTeQh.png', 'cod', 'paid', 'pending', 100.00, '2023-01-04 19:45:28', '2023-01-04 19:45:28', 0, NULL, NULL, '22.33', '585.255', 1, NULL, 'pending', 1),
(8, 1, 1, 'dobai', 'cairo', '2022-11-20', '05:00:00', 'uploads/EQDpv3rXd2IJPzAvzpQ81G75CDWqtiYdmTya4ByW.png', 'uploads/80oqWxtq9rgXwtR1c5tvBvtxslaVBWBknFwIBSPJ.png', 'uploads/qKwuTtVFd2uXK54SUXRpDtUdXoCWrtT5BiV8h1ZL.png', 'uploads/s7fxgLyP7nKCafT8nikICqfxTe72rPP1eY2BYVGU.png', 'cod', 'paid', 'cancelled', 520.00, '2023-01-18 15:18:20', '2023-01-18 15:21:01', 0, NULL, NULL, '22.33', '585.255', 1, 1, 'new_order', 1),
(9, 1, 1, 'dobai', 'cairo', '2022-11-20', '05:00:00', 'uploads/sdURosYxUUu40roF5vGbcbD62PctzyHDv4ovp8vW.png', 'uploads/FopdAn47pnyKRotxdCORrYVfYoKFhFHDYuHHKw5C.png', 'uploads/do7M8mSJ9Jliq2Mzw1tT4er5hhdO8LO6gffqxruc.png', 'uploads/OrcI65NMipeVHmlMdRt3AKkWCd21lnhC120vChW1.png', 'cod', 'paid', 'pending', 520.00, '2023-01-19 16:29:55', '2023-01-19 16:29:55', 0, NULL, NULL, '22.33', '585.255', 1, NULL, 'new_order', 1),
(10, 1, 1, 'dobai', 'cairo', '2022-11-20', '05:00:00', 'uploads/Zkmg6L4AoIdBaEwt7d9rFA1Nl637zaBoyE2KpMOK.png', 'uploads/ywIrysvKGu2g3CBd9teuj2sbJuXyPTBAsxABRawO.png', 'uploads/VrKUg6Id9U9Q8ZcG2c6PS7u3KdYaaPTz7vgp0sNR.png', 'uploads/Vpe0KAQi9OQog4x8dQItiaMmnMFzoHsOulgxrhNW.png', 'cod', 'paid', 'pending', 520.00, '2023-01-19 16:31:12', '2023-01-19 16:31:12', 0, NULL, NULL, '22.33', '585.255', 1, NULL, 'new_order', 1),
(11, 1, 1, 'dobai', 'cairo', '2022-11-20', '05:00:00', 'uploads/wOZqHamQOGeVwZC4VHm2kjZUOepq5Vjgubn8Jzle.png', 'uploads/Mdr4mHN3ftXpvrUWwky7i4YSqGKAFi61bQ8lSktJ.png', 'uploads/bLnGjYxYkf01NmeCKEAwnluNVMEhuEC5Qstn1zzu.png', 'uploads/8rhZ1DTvz70F4nEhavk7HzDgnstUbH8cjxccfz7I.png', 'cod', 'paid', 'pending', 520.00, '2023-01-19 16:31:55', '2023-01-19 16:31:55', 0, NULL, NULL, '22.33', '585.255', 1, NULL, 'new_order', 1),
(12, 1, 1, 'dobai', 'cairo', '2022-11-20', '05:00:00', 'uploads/WLOgD2dyw6MTQ4vyEzrrPP4B7cttAIqrtOMG2VaF.png', 'uploads/d54btZT1xgLZi4b9BXG7PKBtUmRT0doc5Nv1QFbv.png', 'uploads/V9rK53Df2ezgwkPvz16ZQIlPrvBaoqh0hIeD1NK7.png', 'uploads/4vYKJzLEuYOb0kZqwE7hdq1dCM2nfp26qZmMePOX.png', 'cod', 'paid', 'pending', 520.00, '2023-01-19 16:33:11', '2023-01-19 16:33:11', 0, NULL, NULL, '22.33', '585.255', 1, NULL, 'new_order', 1),
(13, 1, 1, 'dobai', 'cairo', '2022-11-20', '05:00:00', 'uploads/qVK4IW0vb2v0hYinG51g5kbXisGtJDuWALjKFU6q.png', 'uploads/15UTCwycQRI8iARYj4gaaV89xEcgCJKajveiCGpp.png', 'uploads/KYzmAbG3impxRzk6kkUajfoDfSOJlHSrya930dXu.png', 'uploads/chfut18tVIFSPEls1p6Zv3MFZoqP5gn9kYK5xN0b.png', 'cod', 'paid', 'pending', 520.00, '2023-01-19 16:33:17', '2023-01-19 16:33:17', 0, NULL, NULL, '22.33', '585.255', 1, NULL, 'new_order', 1),
(14, 1, 1, 'dobai', 'cairo', '2022-11-20', '05:00:00', 'uploads/I98ePQZrDZ7KwYIktzuhAm19guma28rRziAvcPgh.png', 'uploads/cftBcblOt7alJoPH1N1Ngw5iWjid3Vgl8S9FGc4E.png', 'uploads/W8hf1sxQiPLSNE7mIFz87pPkvrOZlTBhN72ocBTj.png', 'uploads/r0S15i9ptgj4dkaR4T08CQwsawnFzVqQixIhYQPp.png', 'cod', 'paid', 'pending', 520.00, '2023-01-19 16:33:29', '2023-01-19 16:33:29', 0, NULL, NULL, '22.33', '585.255', 1, NULL, 'new_order', 1),
(15, 1, 1, 'dobai', 'cairo', '2022-11-20', '05:00:00', 'uploads/gH3gFpq3tTKNPFpGRHm8d2httCeLlGchS4f4975s.png', 'uploads/peCTJLUzcaSLrpHM4mB2C7YVX5DTUdWrxnufnWgM.png', 'uploads/a5lH3ECj3NgYN7GtRLMQ7UwfUcqtbPzcFHODz6ll.png', 'uploads/dqDQsrDwGY0Q2T5CWejPfnoAi87BZGPZ9EGje1Qk.png', 'cod', 'paid', 'pending', 520.00, '2023-01-19 16:39:44', '2023-01-19 16:39:44', 0, NULL, NULL, '22.33', '585.255', 1, NULL, 'new_order', 1),
(16, 1, 1, 'dobai', 'cairo', '2022-11-20', '05:00:00', 'uploads/1QGpXeWxuT3SABXCJBKuE7avQbEIwrluhw3HLurE.png', 'uploads/VXaRcQoj9PmrWdKUuLHvjOpapPwqz6hhDgLjKl2d.png', 'uploads/JZLpqdorntyFlrJH6dDss4uAMbUDxA29yHFoE8dm.png', 'uploads/zTGa89EjJ9MjJcdRti8es1imlgaKW0xhTsBOvFQz.png', 'cod', 'paid', 'pending', 520.00, '2023-01-19 16:41:14', '2023-01-19 16:41:14', 0, NULL, NULL, '22.33', '585.255', 1, NULL, 'new_order', 1),
(17, 1, 1, 'dobai', 'cairo', '2022-11-20', '05:00:00', 'uploads/1M4jcmoeoOTdQKZqdKQaSsFGq3ZucCh1OV4NbPAz.png', 'uploads/D65fXy1GFddknY06DL77ZTjYkxyyCDQb1AV5Soqr.png', 'uploads/7Dgyzbk3C2GkdIvtFF4qJfLSotf1ZT3A8lTA5Vju.png', 'uploads/XjAXBjnghHHrj6Yoj5TCglwoc03zeUeLogfp69Ib.png', 'cod', 'paid', 'pending', 520.00, '2023-01-19 16:41:40', '2023-01-19 16:41:40', 0, NULL, NULL, '22.33', '585.255', 1, NULL, 'new_order', 1),
(18, 1, 1, 'dobai', 'cairo', '2022-11-20', '05:00:00', 'uploads/iheYmnBUQcLrdLj7LlU43pYXzf3OCUBHDsH27rMK.jpg', 'uploads/K8NJUwBJ6Vdmp6gvZZU3uC8y8gMYQT5fStfkBEKV.jpg', 'uploads/MtiT48Bw7F7nABPNGsLOrjNq2Hn5wv3pXhdGBOTA.jpg', 'uploads/axPcSOZx9o90ACNIRwj69qWAsNzIuXRdu9eZ8UME.jpg', 'cod', 'paid', 'pending', 520.00, '2023-01-23 15:06:47', '2023-01-23 15:06:47', 0, NULL, NULL, '22.33', '585.255', 1, NULL, 'new_order', 1),
(19, 1, 1, 'dobai', 'cairo', '2022-11-20', '05:00:00', 'uploads/2wO1W9ZlgP3AAnq0OMIWSkN8H1CrUu9vTJoagvQ0.jpg', 'uploads/WEn4VlMeGfn9mAXwcBaOylo70etrZAAwD3MBMOra.jpg', 'uploads/Jt6JvHXHhAlClHjYK3DDe4OdIZz5nZWivA6WKIG2.jpg', 'uploads/aWJbmY79zMGUBRvoiHTUPWZOldB7XiPVcEBpxhxO.jpg', 'cod', 'paid', 'pending', 520.00, '2023-01-23 15:07:31', '2023-01-23 15:07:31', 0, NULL, NULL, '22.33', '585.255', 1, NULL, 'new_order', 1),
(20, 1, 1, 'dobai', 'cairo', '2022-11-20', '05:00:00', 'uploads/bZHkmT3ewKTcYmiikpRylDqRqdwfx9HGFtLrwWrv.jpg', 'uploads/533ONPASWgnBoW8Z24Hmit4lCJk1oj6otosAgfDu.jpg', 'uploads/PWjmMC3UP9GehItUU3SZyqzARxQbXrmVlwen39Hw.jpg', 'uploads/2nwIKPPB3AU3EiBC0qhmpy5hBrvSbD9NM7dUbjOo.jpg', 'cod', 'paid', 'pending', 520.00, '2023-01-23 15:08:07', '2023-01-23 15:08:07', 0, NULL, NULL, '22.33', '585.255', 1, NULL, 'new_order', 1),
(21, 1, 1, 'dobai', 'cairo', '2022-11-20', '05:00:00', 'uploads/sRY3Dec7cSpVDldwuMcq7mc8pB2ZWpDMVuSq4PI9.jpg', 'uploads/ldYeRbjp6cGMfEUjdzZoZKsNbdq6aM630gGE1TiP.jpg', 'uploads/FkHpuhjRpVg5MrjtZVQ9k239rpJqxwObyDjKrehz.jpg', 'uploads/vfIw9uejuX4BF7lO8oVEYhCyopBJXOKl0ms9Fzrf.jpg', 'cod', 'paid', 'pending', 520.00, '2023-01-23 15:33:50', '2023-01-23 15:33:50', 0, NULL, NULL, '22.33', '585.255', 1, NULL, 'new_order', 1),
(22, 1, 1, 'dobai', 'cairo', '2022-11-20', '05:00:00', 'uploads/FeV32CPlAi1M5po9plpIBWL14iXXxZR3vmNQgNjs.jpg', 'uploads/mFxl0kpQKtzyqAn3ZBF8nZpZRMg5la7TG08WEd7x.jpg', 'uploads/bTQ8XuxZPNHpFKgVjBWUmvaYO7FzBFsePiPfS6bK.jpg', 'uploads/NDImcdyZJYlYWUXY2LTPOlI0tjgPIONd43QNihzM.jpg', 'cod', 'paid', 'pending', 520.00, '2023-01-23 15:33:58', '2023-01-23 15:33:58', 0, NULL, NULL, '22.33', '585.255', 1, NULL, 'new_order', 1),
(23, 1, 1, 'dobai', 'cairo', '2022-11-20', '05:00:00', 'uploads/gePFBxOskHRgxWosvpUGzK8gMfa8woB80VWv7emx.jpg', 'uploads/fQHOUOkntDcNnLe0AQgjlqrpUX9WzNhmqCIgEDIX.jpg', 'uploads/1WKSGUjz8LeCxuzOufKS3A2cKL8qqjJ9NbOwhFtf.jpg', 'uploads/HVNM4ObLrcxPRVsY5FjLkPWAzoB2rUSEVM9VnfMW.jpg', 'cod', 'paid', 'pending', 520.00, '2023-01-23 15:38:52', '2023-01-23 15:38:52', 0, NULL, NULL, '22.33', '585.255', 1, NULL, 'new_order', 1),
(24, 1, 1, 'dobai', 'cairo', '2022-11-20', '05:00:00', 'uploads/5AMYbumC3ocD8mWc1lmxctrBBQEXcpBVnuVLQquJ.jpg', 'uploads/3XKx950j8qezZjrfIgXKp9NV7LHmSoQsjewCwvbQ.jpg', 'uploads/wFExH3qFW6NQsWIV8m7K3bd95gOrH9tpll4TfnLt.jpg', 'uploads/zvrpZNOaVm28YfMx6KbbkGr30dy3WRakjsuhIoi1.jpg', 'cod', 'paid', 'pending', 520.00, '2023-01-23 19:12:45', '2023-01-23 19:12:45', 0, NULL, NULL, '22.33', '585.255', 1, NULL, 'new_order', 1),
(25, 1, 1, 'dobai', 'cairo', '2022-11-20', '05:00:00', 'uploads/JAGMjnod8QSBBdI8EkRiWbXyo7YFNW07D19i9JXO.jpg', 'uploads/wGrsgzf6blIqNR0pK6rKsvbyzipnwqnmkK1jhhsU.jpg', 'uploads/If2MZJkZYvqwOhV65L2mmtxrYrZzv3ucVsI9i8Lx.jpg', 'uploads/Hy9I93mh5GAXaEucnyEU6OXhRvGoUI6QL7re1de8.jpg', 'cod', 'paid', 'pending', 520.00, '2023-01-23 19:13:02', '2023-01-23 19:13:02', 0, NULL, NULL, '22.33', '585.255', 1, NULL, 'new_order', 1),
(26, 1, 1, 'dobai', 'cairo', '2022-11-20', '05:00:00', 'uploads/FkglqnccRFbeadwDs6slKkKJLEaPHssfzmYZbmlU.jpg', 'uploads/DDYCu6M9hahuaJQDsGyTLQwOTxEGz0EdaXlL2dUr.jpg', 'uploads/lTfGr3nl5zGRw2UmCs63oD3iM7edau4t8xTy4ise.jpg', 'uploads/1GlxMBNRJ0JMPD5qnCqaPHioiFJtVuUuYC0lFevP.jpg', 'cod', 'paid', 'pending', 520.00, '2023-01-23 19:14:10', '2023-01-23 19:14:10', 0, NULL, NULL, '22.33', '585.255', 1, NULL, 'new_order', 1),
(27, 1, 1, 'dobai', 'cairo', '2022-11-20', '05:00:00', 'uploads/dpOTbA46E0a4vd6q9vpPZNH2zAoGVo4Mtn7HfEey.jpg', 'uploads/Ghtxo39pWQ5h31nSQDXeWXzlnLDWrjH0is5PiiYx.jpg', 'uploads/VW5bGIo9fd2NM7X1tzUQ4TJlPfKgktRAIGIckfMu.jpg', 'uploads/U50VB9m5AFssVu6Bks4H8Ph8x6HfkxARCP73SAAZ.jpg', 'cod', 'paid', 'pending', 520.00, '2023-01-23 19:14:31', '2023-01-23 19:14:31', 0, NULL, NULL, '22.33', '585.255', 1, NULL, 'new_order', 1),
(28, 1, 1, 'cairo', 'kwauit', '2022-11-20', '05:00:00', 'ddd.png', 'ddd.png', 'ddd.png', 'ddd.png', 'cod', 'paid', 'completed', 502.00, '2023-02-04 17:17:18', '2023-02-05 17:17:18', 0, NULL, NULL, NULL, NULL, NULL, NULL, 'new_order', 1),
(29, 1, 1, 'cairo', 'kwauit', '2022-11-20', '05:00:00', 'ddd.png', 'ddd.png', 'ddd.png', 'ddd.png', 'cod', 'paid', 'completed', 502.00, '2023-02-05 17:17:38', '2023-02-05 17:17:38', 0, NULL, NULL, NULL, NULL, NULL, NULL, 'new_order', 1),
(30, 1, 1, 'cairo', 'kwauit', '2022-11-20', '05:00:00', 'ddd.png', 'ddd.png', 'ddd.png', 'ddd.png', 'cod', 'paid', 'completed', 502.00, '2023-02-05 17:18:50', '2023-02-05 17:18:50', 0, NULL, NULL, NULL, NULL, NULL, NULL, 'new_order', 1),
(32, 1, 1, 'cairo', 'kwauit', '2022-11-20', '05:00:00', 'ddd.png', 'ddd.png', 'ddd.png', 'ddd.png', 'cod', 'paid', 'completed', 502.00, '2023-02-05 20:48:04', '2023-02-05 20:48:04', 0, NULL, NULL, NULL, NULL, NULL, NULL, 'new_order', 1);

-- --------------------------------------------------------

--
-- Table structure for table `order_service_form`
--

CREATE TABLE `order_service_form` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `service_id` bigint(20) UNSIGNED DEFAULT NULL,
  `from` tinyint(1) NOT NULL DEFAULT 0,
  `to` tinyint(1) NOT NULL DEFAULT 0,
  `appointment_date` tinyint(1) NOT NULL DEFAULT 0,
  `appointment_time` tinyint(1) NOT NULL DEFAULT 0,
  `images` tinyint(1) NOT NULL DEFAULT 0,
  `gender` tinyint(1) NOT NULL DEFAULT 0,
  `embassy` tinyint(1) NOT NULL DEFAULT 0,
  `select_service` tinyint(1) NOT NULL DEFAULT 0,
  `employee_status` tinyint(1) NOT NULL DEFAULT 0,
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
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `amount` double(8,2) NOT NULL,
  `currency` char(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'KWD',
  `method` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','completed','failed','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `transaction_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`transaction_data`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `order_id`, `amount`, `currency`, `method`, `status`, `transaction_id`, `transaction_data`, `created_at`, `updated_at`) VALUES
(1, 2, 520.00, 'KWD', 'KNET', 'pending', '', NULL, '2023-01-01 11:01:29', '2023-01-01 11:01:29'),
(2, 3, 520.00, 'KWD', 'KNET', 'completed', '', NULL, '2023-01-01 11:02:57', '2023-01-01 11:18:51'),
(3, 4, 100.00, 'KWD', 'KNET', 'completed', '', NULL, '2023-01-04 19:33:23', '2023-01-04 19:33:23'),
(4, 5, 100.00, 'KWD', 'KNET', 'completed', '', NULL, '2023-01-04 19:33:33', '2023-01-04 19:33:33'),
(5, 6, 520.00, 'KWD', 'KNET', 'completed', '', NULL, '2023-01-04 19:45:20', '2023-01-04 19:45:20'),
(6, 7, 100.00, 'KWD', 'KNET', 'completed', '', NULL, '2023-01-04 19:45:28', '2023-01-04 19:45:28'),
(7, 8, 520.00, 'KWD', 'KNET', 'completed', '', NULL, '2023-01-18 15:18:20', '2023-01-18 15:18:20'),
(8, 9, 520.00, 'KWD', 'KNET', 'completed', '', NULL, '2023-01-19 16:29:55', '2023-01-19 16:29:55'),
(9, 10, 520.00, 'KWD', 'KNET', 'completed', '', NULL, '2023-01-19 16:31:12', '2023-01-19 16:31:12'),
(10, 11, 520.00, 'KWD', 'KNET', 'completed', '', NULL, '2023-01-19 16:31:55', '2023-01-19 16:31:55'),
(11, 12, 520.00, 'KWD', 'KNET', 'completed', '', NULL, '2023-01-19 16:33:11', '2023-01-19 16:33:11'),
(12, 13, 520.00, 'KWD', 'KNET', 'completed', '', NULL, '2023-01-19 16:33:17', '2023-01-19 16:33:17'),
(13, 14, 520.00, 'KWD', 'KNET', 'completed', '', NULL, '2023-01-19 16:33:29', '2023-01-19 16:33:29'),
(14, 15, 520.00, 'KWD', 'KNET', 'completed', '', NULL, '2023-01-19 16:39:44', '2023-01-19 16:39:44'),
(15, 16, 520.00, 'KWD', 'KNET', 'completed', '', NULL, '2023-01-19 16:41:14', '2023-01-19 16:41:14'),
(16, 17, 520.00, 'KWD', 'KNET', 'completed', '', NULL, '2023-01-19 16:41:40', '2023-01-19 16:41:40'),
(17, 18, 520.00, 'KWD', 'KNET', 'completed', '', NULL, '2023-01-23 15:06:47', '2023-01-23 15:06:47'),
(18, 19, 520.00, 'KWD', 'KNET', 'completed', '', NULL, '2023-01-23 15:07:31', '2023-01-23 15:07:31'),
(19, 20, 520.00, 'KWD', 'KNET', 'completed', '', NULL, '2023-01-23 15:08:07', '2023-01-23 15:08:07'),
(20, 21, 520.00, 'KWD', 'KNET', 'completed', '', NULL, '2023-01-23 15:33:50', '2023-01-23 15:33:50'),
(21, 22, 520.00, 'KWD', 'KNET', 'completed', '', NULL, '2023-01-23 15:33:58', '2023-01-23 15:33:58'),
(22, 23, 520.00, 'KWD', 'KNET', 'completed', '', NULL, '2023-01-23 15:38:52', '2023-01-23 15:38:52'),
(23, 24, 520.00, 'KWD', 'KNET', 'completed', '', NULL, '2023-01-23 19:12:45', '2023-01-23 19:12:45'),
(24, 25, 520.00, 'KWD', 'KNET', 'completed', '', NULL, '2023-01-23 19:13:02', '2023-01-23 19:13:02'),
(25, 26, 520.00, 'KWD', 'KNET', 'completed', '', NULL, '2023-01-23 19:14:10', '2023-01-23 19:14:10'),
(26, 27, 520.00, 'KWD', 'KNET', 'completed', '', NULL, '2023-01-23 19:14:31', '2023-01-23 19:14:31'),
(28, 32, 502.00, 'KWD', 'KNET', 'completed', '', NULL, '2023-02-05 20:48:04', '2023-02-05 20:48:04');

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
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_en` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_en` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `terms_conditions_en` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_ar` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_ar` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `terms_conditions_ar` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double(8,2) NOT NULL,
  `status` enum('active','unactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `category_id`, `image`, `name_en`, `description_en`, `terms_conditions_en`, `name_ar`, `description_ar`, `terms_conditions_ar`, `price`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'uploads/service_details_image.jpg', 'خدمة توصيل من المنزل للمطار ddddd', 'تسطيع مع بخدمتك ان تطلب السياره التى تريدها وسوف تصلك ف الوقت المحدد الى المكان التى تريده بسلامه وامان', 'تسطيع مع بخدمتك ان تطلب السياره التى تريدها وسوف تصلك ف الوقت المحدد الى المكان التى تريده بسلامه وامان', 'خدمة توصيل من المنزل للمطار', 'تسطيع مع بخدمتك ان تطلب السياره التى تريدها وسوف تصلك ف الوقت المحدد الى المكان التى تريده بسلامه وامان', 'تسطيع مع بخدمتك ان تطلب السياره التى تريدها وسوف تصلك ف الوقت المحدد الى المكان التى تريده بسلامه وامان', 150.00, 'active', '2022-11-29 20:08:01', '2023-02-07 19:54:24'),
(2, 1, 'uploads/service_details_image.jpg', 'خدمة توصيل من المنزل للمطار', 'تسطيع مع بخدمتك ان تطلب السياره التى تريدها وسوف تصلك ف الوقت المحدد الى المكان التى تريده بسلامه وامان', '    <ul>\n        <li>ابلاغ الشركة بموعد الوصول قبلها ب 24 ساعه</li>\n        <li> فى حالة تاخدر الامتعه او فقدنها الشركة غير مسئوله عن ذلك</li>\n        <li> في حالة الغاء الطلب خدمة التوصيل من المكتب او منك يتم استرجاع المبلغ المدفوع قبل 24 ساعه ويتم رده في محفظتك </li>\n        <li>فى حالة طلب ارجاع المبلغ الى حسابك يتم التواصل عبر الدعم الفني من قبلك وبعد اعتماد الارجاع  من الموظف المختص  يتم ارجاع المبلغ الى حسابك خلال 4 ايام او حساب البنك لديك</li>\n    </ul>', 'خدمة توصيل من المنزل للمطار', 'تسطيع مع بخدمتك ان تطلب السياره التى تريدها وسوف تصلك ف الوقت المحدد الى المكان التى تريده بسلامه وامان', '    <ul>\n        <li>ابلاغ الشركة بموعد الوصول قبلها ب 24 ساعه</li>\n        <li> فى حالة تاخدر الامتعه او فقدنها الشركة غير مسئوله عن ذلك</li>\n        <li> في حالة الغاء الطلب خدمة التوصيل من المكتب او منك يتم استرجاع المبلغ المدفوع قبل 24 ساعه ويتم رده في محفظتك </li>\n        <li>فى حالة طلب ارجاع المبلغ الى حسابك يتم التواصل عبر الدعم الفني من قبلك وبعد اعتماد الارجاع  من الموظف المختص  يتم ارجاع المبلغ الى حسابك خلال 4 ايام او حساب البنك لديك</li>\n    </ul>', 15.00, 'unactive', '2022-11-29 20:12:39', '2022-11-29 20:12:39');

-- --------------------------------------------------------

--
-- Table structure for table `service_attributes`
--

CREATE TABLE `service_attributes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `service_id` bigint(20) UNSIGNED DEFAULT NULL,
  `from` tinyint(1) NOT NULL DEFAULT 0,
  `to` tinyint(1) NOT NULL DEFAULT 0,
  `appointment_date` tinyint(1) NOT NULL DEFAULT 0,
  `appointment_time` tinyint(1) NOT NULL DEFAULT 0,
  `images` tinyint(1) NOT NULL DEFAULT 0,
  `gender` tinyint(1) NOT NULL DEFAULT 0,
  `embassy` tinyint(1) NOT NULL DEFAULT 0,
  `select_service` tinyint(1) NOT NULL DEFAULT 0,
  `employee_status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `service_attributes`
--

INSERT INTO `service_attributes` (`id`, `service_id`, `from`, `to`, `appointment_date`, `appointment_time`, `images`, `gender`, `embassy`, `select_service`, `employee_status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, '2022-12-04 18:08:17', '2022-12-04 18:10:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_front` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_back` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `verification_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `balance` double(8,2) NOT NULL DEFAULT 0.00,
  `status` enum('active','inactive','banned') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `fcm_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `image`, `image_front`, `image_back`, `email_verified_at`, `verification_code`, `password`, `remember_token`, `created_at`, `updated_at`, `balance`, `status`, `fcm_token`) VALUES
(1, 'silaaaaaaaaaa sola', 'email@email.com', '652954959', 'uploads/mByfnQfckp7iqvmy9zeUe68DpTWvD0nGhBGaOULX.jpg', 'uploads/iobnHB87pKxXulOhG1P6i1N9Ve9K8CKJIKMFbA4A.jpg', 'uploads/hjGtWJOutzSvfeaBFRcdIgnFCyLnE5V1WATOCpOj.jpg', NULL, NULL, '$2y$10$AbyBKx3XCNleSXfEI7L0Ienc1Vvj9ZkPyWJpXFVApG9.VihqS0Qoa', NULL, '2022-11-12 16:11:11', '2023-02-07 19:34:07', 862.00, 'active', NULL),
(3, 'elsolya', 'mohamedelsolssya@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$01ttSWrUoRVeZF3.B4mGhuo8ugGM2A3nEzGV9LAv8J4GCOQUSgz1G', NULL, '2022-11-17 16:50:31', '2022-11-17 16:50:31', 0.00, 'active', NULL),
(4, '54498449', 'ddd@ddd.com', '458489484', NULL, NULL, NULL, NULL, NULL, '$2y$10$GaXrwfpaZvJX4fW0rNwIlOQGkx1OeRrKQJB52CDc4FQflkNsy94GK', NULL, '2022-11-17 17:10:16', '2022-11-17 17:10:16', 0.00, 'active', NULL),
(5, '54498449', 'ddd@ddd.comd', '45848948', NULL, NULL, NULL, NULL, NULL, '$2y$10$lrg.ufWZH39UPdTKZ5OgkOsj4cffDOGAL7NvOqvStkoB7N11LXHLS', NULL, '2022-11-17 17:11:03', '2022-11-17 17:11:03', 0.00, 'active', NULL),
(6, 'elsolya', 'mohameffffdelsolssya@gmail.comff', '54158418484', NULL, NULL, NULL, NULL, NULL, '$2y$10$O3/EnbkO.KxNk.XEcxGLb.D3gbgLkAtVLY7/wp9Hzj2qko.RxU0sy', NULL, '2022-11-20 19:12:34', '2022-11-20 19:12:34', 0.00, 'active', NULL),
(7, 'elsolya', NULL, '541584184841', NULL, NULL, NULL, NULL, NULL, '$2y$10$ZfcRGpCrqY6SLl8eQiUkeeVzMygskpJHdlb4asrclSG/NDHvZ87ym', NULL, '2022-11-23 20:09:25', '2022-11-23 20:09:25', 0.00, 'active', NULL),
(8, 'elsolya', NULL, '541584184', NULL, NULL, NULL, NULL, NULL, '$2y$10$A5UCxPPJVLDRFprl0gJKcuFHqO3ba2oBco1tgr84J5bzCQobteWyC', NULL, '2022-11-26 13:31:24', '2022-11-26 13:31:24', 0.00, 'active', NULL),
(9, 'elsolya', NULL, '5415841848', NULL, NULL, NULL, NULL, NULL, '$2y$10$G87vcj27TX0FDvTRh8NvYeGg2uWnX2YtZuFq.mTWOnR3kr5MbQTFO', NULL, '2022-11-27 19:16:21', '2022-11-27 19:16:21', 0.00, 'active', NULL),
(10, 'elsolya', NULL, '54158418483', NULL, NULL, NULL, NULL, NULL, '$2y$10$kq.hvy3ORPv5z6Q1RzxlfOTj1M9avbZzbd1whmQcci437TCfRk9jy', NULL, '2023-01-04 19:40:14', '2023-01-04 19:40:14', 0.00, 'active', NULL),
(11, 'elsolya', NULL, '54158418481', NULL, NULL, NULL, NULL, NULL, '$2y$10$znoscPy7GdE2y9xz/vyKLu/7OGbnCUQ7gdxUQlVWtolP3BvhVcWQS', NULL, '2023-01-04 19:40:42', '2023-01-04 19:40:42', 0.00, 'active', '555');

-- --------------------------------------------------------

--
-- Table structure for table `user_credits`
--

CREATE TABLE `user_credits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `credit_number` bigint(20) DEFAULT NULL,
  `credit_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expired_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cvv` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_credits`
--

INSERT INTO `user_credits` (`id`, `user_id`, `payment_method`, `credit_number`, `credit_name`, `expired_date`, `cvv`, `created_at`, `updated_at`) VALUES
(2, 1, 'knet', 111111115555444, 'solya', '20/52', 1452, '2022-11-23 17:02:36', '2022-11-23 17:02:36');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`),
  ADD UNIQUE KEY `admins_username_unique` (`username`),
  ADD UNIQUE KEY `admins_phone_number_unique` (`phone_number`);

--
-- Indexes for table `airports`
--
ALTER TABLE `airports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`),
  ADD KEY `banners_banner_type_id_foreign` (`banner_type_id`);

--
-- Indexes for table `banner_types`
--
ALTER TABLE `banner_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `drivers`
--
ALTER TABLE `drivers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `drivers_email_unique` (`email`),
  ADD UNIQUE KEY `drivers_phone_unique` (`phone`),
  ADD UNIQUE KEY `drivers_verification_code_unique` (`verification_code`);

--
-- Indexes for table `drivers_monies`
--
ALTER TABLE `drivers_monies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `drivers_monies_driver_id_foreign` (`driver_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification_data`
--
ALTER TABLE `notification_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `onboards`
--
ALTER TABLE `onboards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_user_id_foreign` (`user_id`),
  ADD KEY `orders_service_id_foreign` (`service_id`),
  ADD KEY `orders_airport_id_foreign` (`airport_id`),
  ADD KEY `orders_driver_id_foreign` (`driver_id`),
  ADD KEY `orders_category_id_foreign` (`category_id`);

--
-- Indexes for table `order_service_form`
--
ALTER TABLE `order_service_form`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_service_form_service_id_foreign` (`service_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_order_id_foreign` (`order_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `services_category_id_foreign` (`category_id`);

--
-- Indexes for table `service_attributes`
--
ALTER TABLE `service_attributes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `service_attributes_service_id_foreign` (`service_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_credits`
--
ALTER TABLE `user_credits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_credits_user_id_foreign` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `airports`
--
ALTER TABLE `airports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `banner_types`
--
ALTER TABLE `banner_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `drivers`
--
ALTER TABLE `drivers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `drivers_monies`
--
ALTER TABLE `drivers_monies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `notification_data`
--
ALTER TABLE `notification_data`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `onboards`
--
ALTER TABLE `onboards`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `order_service_form`
--
ALTER TABLE `order_service_form`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `service_attributes`
--
ALTER TABLE `service_attributes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `user_credits`
--
ALTER TABLE `user_credits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `banners`
--
ALTER TABLE `banners`
  ADD CONSTRAINT `banners_banner_type_id_foreign` FOREIGN KEY (`banner_type_id`) REFERENCES `banners` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `drivers_monies`
--
ALTER TABLE `drivers_monies`
  ADD CONSTRAINT `drivers_monies_driver_id_foreign` FOREIGN KEY (`driver_id`) REFERENCES `drivers` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_airport_id_foreign` FOREIGN KEY (`airport_id`) REFERENCES `airports` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `orders_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `orders_driver_id_foreign` FOREIGN KEY (`driver_id`) REFERENCES `drivers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `orders_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `order_service_form`
--
ALTER TABLE `order_service_form`
  ADD CONSTRAINT `order_service_form_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `services_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `service_attributes`
--
ALTER TABLE `service_attributes`
  ADD CONSTRAINT `service_attributes_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `user_credits`
--
ALTER TABLE `user_credits`
  ADD CONSTRAINT `user_credits_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
