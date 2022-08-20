-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 20, 2022 at 04:45 PM
-- Server version: 5.7.33
-- PHP Version: 7.3.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `far_dif_studicase`
--

-- --------------------------------------------------------

--
-- Table structure for table `allowances`
--

CREATE TABLE `allowances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `percentage_on_basic` int(10) UNSIGNED DEFAULT NULL,
  `fix_amount` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `allowances`
--

INSERT INTO `allowances` (`id`, `name`, `percentage_on_basic`, `fix_amount`, `created_at`, `updated_at`) VALUES
(1, 'telco', NULL, 300000, '2022-08-20 13:12:45', '2022-08-20 13:12:45'),
(2, 'transport', 10, NULL, '2022-08-20 13:12:59', '2022-08-20 13:12:59');

-- --------------------------------------------------------

--
-- Table structure for table `contract_histories`
--

CREATE TABLE `contract_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `contract_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `position` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `division` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start` date NOT NULL,
  `end` date NOT NULL,
  `basic_salary` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contract_histories`
--

INSERT INTO `contract_histories` (`id`, `contract_no`, `employee_id`, `position`, `division`, `start`, `end`, `basic_salary`, `created_at`, `updated_at`) VALUES
(1, '1241531355', 1, 'programmer', 'web dev', '2021-01-11', '2021-12-31', 5000000, '2022-08-20 13:13:21', '2022-08-20 13:13:21'),
(2, '1241531356', 1, 'programmer', 'web dev', '2022-01-11', '2022-12-31', 9500000, '2022-08-20 13:13:37', '2022-08-20 13:13:37');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pob` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dob` date NOT NULL,
  `gender` enum('male','female') COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `name`, `pob`, `dob`, `gender`, `contact`, `email`, `address`, `created_at`, `updated_at`) VALUES
(1, 'fuadagil', 'pekanbaru', '1996-02-23', 'male', '+6285278691552', 'contact@fuadagil.com', 'riau', '2022-08-20 13:13:03', '2022-08-20 13:13:03');

-- --------------------------------------------------------

--
-- Table structure for table `employee_has_allowances`
--

CREATE TABLE `employee_has_allowances` (
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `allowance_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employee_has_allowances`
--

INSERT INTO `employee_has_allowances` (`employee_id`, `allowance_id`) VALUES
(1, 1),
(1, 2);

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
(1, '2022_08_18_140844_create_employees_table', 1),
(2, '2022_08_18_140952_create_allowances_table', 1),
(3, '2022_08_18_141256_create_contract_histories_table', 1),
(4, '2022_08_18_141358_create_employee_has_allowances_table', 1),
(5, '2022_08_20_103724_create_payrolls_table', 1),
(6, '2022_08_20_192033_create_payroll_has_allowances_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `payrolls`
--

CREATE TABLE `payrolls` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `payroll_no` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `month` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `salary_amount` bigint(20) UNSIGNED NOT NULL,
  `allowance_amount` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `take_home_pay` bigint(20) UNSIGNED NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payrolls`
--

INSERT INTO `payrolls` (`id`, `payroll_no`, `month`, `year`, `employee_id`, `salary_amount`, `allowance_amount`, `take_home_pay`, `created_at`, `created_by`) VALUES
(2, 'UGuaeHhV7YXtYuz', 1, 2021, 1, 5000000, 800000, 5800000, '2022-08-20 20:19:55', 1);

-- --------------------------------------------------------

--
-- Table structure for table `payroll_has_allowances`
--

CREATE TABLE `payroll_has_allowances` (
  `payroll_no` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `allowance_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `allowance_amount` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payroll_has_allowances`
--

INSERT INTO `payroll_has_allowances` (`payroll_no`, `allowance_name`, `allowance_amount`) VALUES
('UGuaeHhV7YXtYuz', 'telco', '300000'),
('UGuaeHhV7YXtYuz', 'transport', '500000');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `allowances`
--
ALTER TABLE `allowances`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contract_histories`
--
ALTER TABLE `contract_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contract_histories_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_has_allowances`
--
ALTER TABLE `employee_has_allowances`
  ADD KEY `employee_has_allowances_employee_id_foreign` (`employee_id`),
  ADD KEY `employee_has_allowances_allowance_id_foreign` (`allowance_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payrolls`
--
ALTER TABLE `payrolls`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `payrolls_payroll_no_unique` (`payroll_no`),
  ADD KEY `payrolls_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `payroll_has_allowances`
--
ALTER TABLE `payroll_has_allowances`
  ADD KEY `payroll_has_allowances_payroll_no_foreign` (`payroll_no`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `allowances`
--
ALTER TABLE `allowances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `contract_histories`
--
ALTER TABLE `contract_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `payrolls`
--
ALTER TABLE `payrolls`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `contract_histories`
--
ALTER TABLE `contract_histories`
  ADD CONSTRAINT `contract_histories_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `employee_has_allowances`
--
ALTER TABLE `employee_has_allowances`
  ADD CONSTRAINT `employee_has_allowances_allowance_id_foreign` FOREIGN KEY (`allowance_id`) REFERENCES `allowances` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `employee_has_allowances_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payrolls`
--
ALTER TABLE `payrolls`
  ADD CONSTRAINT `payrolls_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payroll_has_allowances`
--
ALTER TABLE `payroll_has_allowances`
  ADD CONSTRAINT `payroll_has_allowances_payroll_no_foreign` FOREIGN KEY (`payroll_no`) REFERENCES `payrolls` (`payroll_no`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
