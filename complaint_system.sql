-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: May 23, 2026 at 01:37 AM
-- Server version: 8.0.44
-- PHP Version: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `complaint_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `complaints`
--

CREATE TABLE `complaints` (
  `complaint_id` int NOT NULL,
  `customer_id` int NOT NULL,
  `product_service_id` int NOT NULL,
  `complaint_type_id` int NOT NULL,
  `assigned_employee_id` int DEFAULT NULL,
  `complaint_description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `complaint_status` enum('Open','Resolved','Closed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Open',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `resolution_date` date DEFAULT NULL,
  `resolution_notes` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `complaints`
--

INSERT INTO `complaints` (`complaint_id`, `customer_id`, `product_service_id`, `complaint_type_id`, `assigned_employee_id`, `complaint_description`, `image_path`, `complaint_status`, `created_at`, `resolution_date`, `resolution_notes`) VALUES
(1, 1, 1, 1, 2, 'My internet service has been down since yesterday evening.', NULL, 'Open', '2026-05-22 21:35:51', NULL, NULL),
(2, 2, 5, 2, NULL, 'My bill shows an extra charge that I do not recognize.', NULL, 'Open', '2026-05-22 21:35:51', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `complaint_notes`
--

CREATE TABLE `complaint_notes` (
  `note_id` int NOT NULL,
  `complaint_id` int NOT NULL,
  `employee_id` int NOT NULL,
  `note_text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `complaint_types`
--

CREATE TABLE `complaint_types` (
  `complaint_type_id` int NOT NULL,
  `complaint_type_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `complaint_types`
--

INSERT INTO `complaint_types` (`complaint_type_id`, `complaint_type_name`, `description`, `active`) VALUES
(1, 'Service Outage', 'Customer is reporting that a service is not working.', 1),
(2, 'Billing Issue', 'Customer is reporting a problem with a bill or payment.', 1),
(3, 'Product Defect', 'Customer is reporting defective equipment or product failure.', 1),
(4, 'Warranty Claim', 'Customer is requesting service under warranty coverage.', 1);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `street_address` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` char(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `zip_code` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `email`, `first_name`, `last_name`, `street_address`, `city`, `state`, `zip_code`, `phone_number`, `password_hash`, `created_at`) VALUES
(1, 'customer1@example.com', 'Michael', 'Smith', '123 Main Street', 'Richmond', 'VA', '23220', '804-555-1111', '$2y$10$examplehashedpasswordcustomer1', '2026-05-22 21:35:51'),
(2, 'customer2@example.com', 'Ashley', 'Johnson', '456 Oak Avenue', 'Norfolk', 'VA', '23510', '757-555-2222', '$2y$10$examplehashedpasswordcustomer2', '2026-05-22 21:35:51');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `employee_id` int NOT NULL,
  `user_id` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_extension` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `employee_level` enum('Administrator','Technician') COLLATE utf8mb4_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`employee_id`, `user_id`, `first_name`, `last_name`, `email`, `phone_extension`, `employee_level`, `password_hash`, `created_at`) VALUES
(1, 'admin01', 'System', 'Admin', 'admin@example.com', '1001', 'Administrator', '$2y$10$examplehashedpasswordadmin', '2026-05-22 21:35:51'),
(2, 'tech01', 'John', 'Technician', 'john.tech@example.com', '2001', 'Technician', '$2y$10$examplehashedpasswordtech1', '2026-05-22 21:35:51'),
(3, 'tech02', 'Sarah', 'Technician', 'sarah.tech@example.com', '2002', 'Technician', '$2y$10$examplehashedpasswordtech2', '2026-05-22 21:35:51');

-- --------------------------------------------------------

--
-- Table structure for table `products_services`
--

CREATE TABLE `products_services` (
  `product_service_id` int NOT NULL,
  `product_service_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products_services`
--

INSERT INTO `products_services` (`product_service_id`, `product_service_name`, `description`, `active`) VALUES
(1, 'Internet Service', 'Residential or business internet service support.', 1),
(2, 'Cable Television', 'Cable television package, channel, or equipment support.', 1),
(3, 'Home Phone Service', 'Landline and digital home phone support.', 1),
(4, 'Mobile App Access', 'Support for issues using the customer mobile application.', 1),
(5, 'Billing Services', 'Billing, payment, invoice, and account balance support.', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `complaints`
--
ALTER TABLE `complaints`
  ADD PRIMARY KEY (`complaint_id`),
  ADD KEY `fk_complaints_customer` (`customer_id`),
  ADD KEY `fk_complaints_product_service` (`product_service_id`),
  ADD KEY `fk_complaints_complaint_type` (`complaint_type_id`),
  ADD KEY `fk_complaints_employee` (`assigned_employee_id`);

--
-- Indexes for table `complaint_notes`
--
ALTER TABLE `complaint_notes`
  ADD PRIMARY KEY (`note_id`),
  ADD KEY `fk_notes_complaint` (`complaint_id`),
  ADD KEY `fk_notes_employee` (`employee_id`);

--
-- Indexes for table `complaint_types`
--
ALTER TABLE `complaint_types`
  ADD PRIMARY KEY (`complaint_type_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`employee_id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `products_services`
--
ALTER TABLE `products_services`
  ADD PRIMARY KEY (`product_service_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `complaints`
--
ALTER TABLE `complaints`
  MODIFY `complaint_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `complaint_notes`
--
ALTER TABLE `complaint_notes`
  MODIFY `note_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `complaint_types`
--
ALTER TABLE `complaint_types`
  MODIFY `complaint_type_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `employee_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `products_services`
--
ALTER TABLE `products_services`
  MODIFY `product_service_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `complaints`
--
ALTER TABLE `complaints`
  ADD CONSTRAINT `fk_complaints_complaint_type` FOREIGN KEY (`complaint_type_id`) REFERENCES `complaint_types` (`complaint_type_id`),
  ADD CONSTRAINT `fk_complaints_customer` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`),
  ADD CONSTRAINT `fk_complaints_employee` FOREIGN KEY (`assigned_employee_id`) REFERENCES `employees` (`employee_id`),
  ADD CONSTRAINT `fk_complaints_product_service` FOREIGN KEY (`product_service_id`) REFERENCES `products_services` (`product_service_id`);

--
-- Constraints for table `complaint_notes`
--
ALTER TABLE `complaint_notes`
  ADD CONSTRAINT `fk_notes_complaint` FOREIGN KEY (`complaint_id`) REFERENCES `complaints` (`complaint_id`),
  ADD CONSTRAINT `fk_notes_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`employee_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
