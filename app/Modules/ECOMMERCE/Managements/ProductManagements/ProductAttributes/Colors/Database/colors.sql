-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 09, 2025 at 05:54 PM
-- Server version: 8.0.35
-- PHP Version: 8.3.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sql_techecom_tec`
--

-- --------------------------------------------------------

--
-- Table structure for table `colors`
--

CREATE TABLE `colors` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `colors`
--

INSERT INTO `colors` (`id`, `name`, `code`, `created_at`, `updated_at`) VALUES
(24, 'Red', '#FF0000', '2025-04-29 04:38:08', '2025-04-29 04:38:08'),
(25, 'Green', '#008000', '2025-04-29 04:38:08', '2025-04-29 04:38:08'),
(26, 'Blue', '#0000FF', '2025-04-29 04:38:08', '2025-04-29 04:38:08'),
(27, 'Yellow', '#FFFF00', '2025-04-29 04:38:08', '2025-04-29 04:38:08'),
(28, 'Black', '#000000', '2025-04-29 04:38:08', '2025-04-29 04:38:08'),
(29, 'White', '#FFFFFF', '2025-04-29 04:38:08', '2025-04-29 04:38:08'),
(30, 'Gray', '#808080', '2025-04-29 04:38:08', '2025-04-29 04:38:08'),
(31, 'Orange', '#FFA500', '2025-04-29 04:38:08', '2025-04-29 04:38:08'),
(32, 'Pink', '#FFC0CB', '2025-04-29 04:38:08', '2025-04-29 04:38:08'),
(33, 'Purple', '#800080', '2025-04-29 04:38:08', '2025-04-29 04:38:08'),
(34, 'Brown', '#A52A2A', '2025-04-29 04:38:08', '2025-04-29 04:38:08'),
(35, 'Cyan', '#00FFFF', '2025-04-29 04:38:08', '2025-04-29 04:38:08'),
(36, 'Magenta', '#FF00FF', '2025-04-29 04:38:08', '2025-04-29 04:38:08'),
(37, 'Lime', '#00FF00', '2025-04-29 04:38:08', '2025-04-29 04:38:08'),
(38, 'Navy', '#000080', '2025-04-29 04:38:08', '2025-04-29 04:38:08'),
(39, 'Teal', '#008080', '2025-04-29 04:38:08', '2025-04-29 04:38:08'),
(40, 'Olive', '#808000', '2025-04-29 04:38:08', '2025-04-29 04:38:08'),
(41, 'Maroon', '#800000', '2025-04-29 04:38:08', '2025-04-29 04:38:08'),
(42, 'Silver', '#C0C0C0', '2025-04-29 04:38:08', '2025-04-29 04:38:08'),
(43, 'Gold', '#FFD700', '2025-04-29 04:38:08', '2025-04-29 04:38:08'),
(44, 'Light Apricot', '#f3d5b1', '2025-04-30 08:46:57', '2025-04-30 08:52:04'),
(45, 'Medium Spring Bud', '#cfda7b', '2025-04-30 08:49:03', '2025-04-30 08:51:51'),
(46, 'Green White', '#e5e9ec', '2025-04-30 08:50:20', '2025-04-30 08:51:32'),
(47, 'Bright Orange', '#ff5612', '2025-04-30 08:58:11', NULL),
(48, 'Woody Brown', '#43362f', '2025-04-30 08:59:57', NULL),
(49, 'Light Blue Grey', '#b8c8e2', '2025-04-30 09:00:58', NULL),
(50, 'Bright Maroon', '#b9274f', '2025-04-30 09:01:47', NULL),
(51, 'Almond', '#f2e2c8', '2025-04-30 09:03:47', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `colors`
--
ALTER TABLE `colors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `colors_name_unique` (`name`),
  ADD UNIQUE KEY `colors_code_unique` (`code`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `colors`
--
ALTER TABLE `colors`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
