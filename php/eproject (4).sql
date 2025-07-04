-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 04, 2025 at 10:55 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eproject`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `email`, `password`, `role_id`) VALUES
(8, 'admin', 'admin@gmail.com', '123', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cpri_tests`
--

CREATE TABLE `cpri_tests` (
  `cpri_test_id` int(11) NOT NULL,
  `product_id` varchar(20) NOT NULL,
  `related_test_id` varchar(50) NOT NULL,
  `submission_date` date NOT NULL,
  `received_by` varchar(100) DEFAULT NULL,
  `test_date` date DEFAULT NULL,
  `test_report_no` varchar(50) DEFAULT NULL,
  `parameters_tested` text DEFAULT NULL,
  `observed_output` text DEFAULT NULL,
  `result` enum('Pass','Fail','Conditional Pass') NOT NULL,
  `certification_status` enum('Certified','Rejected','Under Review') NOT NULL,
  `remarks` text DEFAULT NULL,
  `uploaded_report_path` varchar(255) DEFAULT NULL,
  `tested_by_cpri` varchar(100) DEFAULT NULL,
  `decision_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cpri_tests`
--

INSERT INTO `cpri_tests` (`cpri_test_id`, `product_id`, `related_test_id`, `submission_date`, `received_by`, `test_date`, `test_report_no`, `parameters_tested`, `observed_output`, `result`, `certification_status`, `remarks`, `uploaded_report_path`, `tested_by_cpri`, `decision_date`, `created_at`, `updated_at`) VALUES
(1, '002R5MF175', 'RT-20250705-001', '2025-07-18', 'Anas', '2025-07-11', 'TRN-2025-0001', 'drff3', 'qw2', '', 'Certified', 'fqeq3', 'uploads/reports/report_68683cc868b90_air_core_inductor.jpg', 'Ahmed', '2025-07-11', '2025-07-04 20:42:48', '2025-07-04 20:42:48'),
(2, '002R4MF770', 'RT-20250705-002', '2025-07-10', 'jjj', '2025-07-11', 'TRN-2025-0002', 'i8k', '6tyghujiko', '', 'Certified', 'drtyghbjklm;', 'uploads/reports/report_68683cf793301_ferrite_inductor.jpg', 'Ayesha', '2025-07-17', '2025-07-04 20:43:35', '2025-07-04 20:43:35'),
(3, '003R9MF430', 'RT-20250705-003', '2025-07-11', 'Ahmed', '2025-07-26', 'TRN-2025-0003', 'p[olkjh', 'poijh', '', 'Certified', '0i9uhg', 'uploads/reports/report_68683d3c0d0e7_Internal_connector.jpg', '9iuh', '2025-07-18', '2025-07-04 20:44:44', '2025-07-04 20:44:44'),
(4, '002R4MF803', 'RT-20250705-004', '2025-07-21', '324324', '2025-07-25', 'TRN-2025-0004', 'f3ewvf', '32evwf', '', '', 'efw32', 'uploads/reports/report_68683e5049bd4_air_core_inductor.jpg', 'f3232', '2025-07-09', '2025-07-04 20:49:20', '2025-07-04 20:49:20'),
(5, '004R3MF454', 'RT-20250705-005', '2025-07-16', 'ewfwf', '2025-07-16', 'TRN-2025-0005', 'wefdv', 'ewfvdsc', '', 'Rejected', 'EFDS', 'uploads/reports/report_68683e7744e7e_Internal_connector.jpg', 'wefdc', '2025-07-16', '2025-07-04 20:49:59', '2025-07-04 20:49:59'),
(6, '004R7MF188', 'RT-20250705-006', '2025-07-25', 'qwqw', '2025-07-08', 'TRN-2025-0006', '23rwefdscx', '32wedscx', '', 'Certified', '32wed', 'uploads/reports/report_68683ea25de64_Internal_connector.jpg', '23ewdc', '2025-07-11', '2025-07-04 20:50:42', '2025-07-04 20:50:42'),
(7, '004R8MF198', 'RT-20250705-007', '2025-07-14', 'jjj', '2025-07-17', 'TRN-2025-0007', '3wqrefdscx', '3wrefsdcx', '', 'Certified', 'ewfsdcx', 'uploads/reports/report_68683fc872ec7_Internal_connector.jpg', 'ewsd', '2025-07-16', '2025-07-04 20:55:36', '2025-07-04 20:55:36');

--
-- Triggers `cpri_tests`
--
DELIMITER $$
CREATE TRIGGER `before_insert_related_test_id` BEFORE INSERT ON `cpri_tests` FOR EACH ROW BEGIN
    DECLARE today_count INT DEFAULT 0;

    -- Count today's entries
    SELECT COUNT(*) + 1 INTO today_count
    FROM cpri_tests
    WHERE DATE(created_at) = CURDATE();

    -- Generate related_test_id like RT-20250701-001
    SET NEW.related_test_id = CONCAT(
        'RT-',
        DATE_FORMAT(CURDATE(), '%Y%m%d'),
        '-',
        LPAD(today_count, 3, '0')
    );
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_auto_test_report_no` BEFORE INSERT ON `cpri_tests` FOR EACH ROW BEGIN
  DECLARE yearCount INT;
  SELECT COUNT(*) + 1 INTO yearCount FROM cpri_tests WHERE YEAR(created_at) = YEAR(NOW());
  SET NEW.test_report_no = CONCAT('TRN-', YEAR(NOW()), '-', LPAD(yearCount, 4, '0'));
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `department_id` int(11) NOT NULL,
  `dept_name` varchar(100) NOT NULL,
  `location` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`department_id`, `dept_name`, `location`) VALUES
(1, 'Power Testing Department', 'Building C-2'),
(2, 'Load Testing', 'Building C-2'),
(3, 'Electrical Testing', 'Building A-3');

-- --------------------------------------------------------

--
-- Table structure for table `lab_test`
--

CREATE TABLE `lab_test` (
  `test_id` varchar(50) NOT NULL,
  `product_id` varchar(20) NOT NULL,
  `testing_type_id` int(11) NOT NULL,
  `department_id` int(11) DEFAULT NULL,
  `tester_id` int(11) DEFAULT NULL,
  `test_date` date NOT NULL,
  `test_start_time` time DEFAULT NULL,
  `test_end_time` time DEFAULT NULL,
  `criteria_tested` text DEFAULT NULL,
  `observed_output` text DEFAULT NULL,
  `expected_output` text DEFAULT NULL,
  `result` enum('Pass','Fail','Pending') NOT NULL,
  `remarks` text DEFAULT NULL,
  `test_roll_number` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lab_test`
--

INSERT INTO `lab_test` (`test_id`, `product_id`, `testing_type_id`, `department_id`, `tester_id`, `test_date`, `test_start_time`, `test_end_time`, `criteria_tested`, `observed_output`, `expected_output`, `result`, `remarks`, `test_roll_number`, `created_at`, `updated_at`) VALUES
('EleR30010001', '001R3MF364', 1, 3, 1, '2025-07-17', '02:13:00', '02:31:00', '2321', '230 V', '220V – 240V', 'Pass', 'ed2w', 'ROLL_20250705_014146_278', '2025-07-04 17:41:46', '2025-07-04 17:41:46'),
('TunR20010001', '001R2MF277', 1, 3, 1, '2025-07-16', '15:24:00', '14:34:00', 'Within ±10% of rated value (e.g. 10 µH ±10%)', 'Voltage remained stable at 220V', 'Signal continuity present', 'Pass', 'f32', 'ROLL_20250705_014204_841', '2025-07-04 17:42:04', '2025-07-04 17:42:04');

--
-- Triggers `lab_test`
--
DELIMITER $$
CREATE TRIGGER `trg_generate_test_id` BEFORE INSERT ON `lab_test` FOR EACH ROW BEGIN
    DECLARE v_product_code VARCHAR(3);
    DECLARE v_revise_code VARCHAR(2);
    DECLARE v_test_code VARCHAR(3);
    DECLARE v_roll INT;

    -- Step 1: Get Product Code & Revise Code from products
    SELECT 
        SUBSTRING(product_name, 1, 3),
        revise_code
    INTO 
        v_product_code,
        v_revise_code
    FROM products
    WHERE product_id = NEW.product_id;

    -- Step 2: Get Test Code from testing_types
    SELECT 
        LPAD(testing_type_id, 3, '0')
    INTO 
        v_test_code
    FROM testing_types
    WHERE testing_type_id = NEW.testing_type_id;

    -- Step 3: Generate Roll Number
    SELECT COUNT(*) + 1 INTO v_roll
    FROM lab_test
    WHERE product_id = NEW.product_id
      AND testing_type_id = NEW.testing_type_id;

    -- Step 4: Generate Final ID
    SET NEW.test_id = CONCAT(v_product_code, v_revise_code, v_test_code, LPAD(v_roll, 4, '0'));
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_generate_test_roll_number` BEFORE INSERT ON `lab_test` FOR EACH ROW BEGIN
  IF NEW.test_roll_number IS NULL OR NEW.test_roll_number = '' THEN
    SET NEW.test_roll_number = CONCAT(
      'ROLL_', 
      DATE_FORMAT(NOW(), '%Y%m%d_%H%i%S'), 
      '_', 
      LPAD(FLOOR(RAND()*1000), 3, '0')
    );
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` varchar(20) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `product_type_id` int(11) NOT NULL,
  `revise_code` varchar(10) DEFAULT NULL,
  `manufacture_no` varchar(20) DEFAULT NULL,
  `manufacture_date` date DEFAULT NULL,
  `status` enum('Manufactured','In Testing','Failed','Approved') DEFAULT 'Manufactured',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `product_type_id`, `revise_code`, `manufacture_no`, `manufacture_date`, `status`, `created_at`, `updated_at`) VALUES
('001R1MF829', 'Air Core Inductor', 1, 'R14', 'MF82954', '2025-06-30', 'Manufactured', '2025-07-03 15:23:47', '2025-07-03 15:23:47'),
('001R2MF277', 'Tunnel Diode', 1, 'R20', 'MF27773', '2025-07-15', 'Manufactured', '2025-07-04 20:35:30', '2025-07-04 20:35:30'),
('001R3MF009', 'Air Core Inductor', 1, 'R3', 'MF00991', '2025-06-30', 'Manufactured', '2025-07-03 20:38:45', '2025-07-03 20:38:45'),
('001R3MF364', 'Electric Bulb', 1, 'R3', 'MF36491', '2025-07-06', 'Manufactured', '2025-07-04 20:36:03', '2025-07-04 20:36:03'),
('001R3MF867', 'Striker Fuse', 1, 'R3', 'MF86745', '2025-07-18', 'Manufactured', '2025-07-04 20:15:59', '2025-07-04 20:15:59'),
('001R4MF751', 'Air Core Inductor', 1, 'R49', 'MF75122', '2025-07-10', 'Manufactured', '2025-07-04 19:55:15', '2025-07-04 19:55:15'),
('001R5MF195', 'Air Core Inductor', 1, 'R51', 'MF19521', '2025-07-05', 'Manufactured', '2025-07-04 11:24:31', '2025-07-04 11:24:31'),
('001R8MF049', 'Air Core Inductor', 1, 'R81', 'MF04928', '2025-07-05', 'Manufactured', '2025-07-03 15:22:25', '2025-07-03 15:22:25'),
('001R9MF351', 'sad', 1, 'R96', 'MF35110', '2025-07-22', 'Manufactured', '2025-07-04 11:31:05', '2025-07-04 11:31:05'),
('002R2MF212', 'Tunnel Diode', 2, 'R21', 'MF21282', '2025-07-07', 'Manufactured', '2025-07-04 19:55:23', '2025-07-04 19:55:23'),
('002R4MF770', 'WWW', 2, 'R4', 'MF77078', '2025-07-24', 'Manufactured', '2025-07-04 20:35:44', '2025-07-04 20:35:44'),
('002R4MF803', 'Tunnel Diode', 2, 'R41', 'MF80342', '2025-07-22', 'Manufactured', '2025-07-04 20:11:34', '2025-07-04 20:11:34'),
('002R5MF175', 'Tunnel Diode', 2, 'R58', 'MF17577', '2025-06-29', 'Manufactured', '2025-07-03 15:57:13', '2025-07-03 15:57:13'),
('002R6MF046', 'smart Diode', 2, 'R67', 'MF04605', '2025-07-08', 'Manufactured', '2025-07-04 20:16:28', '2025-07-04 20:16:28'),
('002R8MF043', 'Tunnel Diode', 2, 'R85', 'MF04359', '2025-07-07', 'Manufactured', '2025-07-04 11:24:45', '2025-07-04 11:24:45'),
('002R8MF988', 'Striker Fuse', 2, 'R82', 'MF98837', '2024-11-21', 'Manufactured', '2025-07-03 20:58:13', '2025-07-03 20:58:13'),
('003R3MF938', 'Tunnel Diode', 3, 'R36', 'MF93876', '0000-00-00', 'Manufactured', '2025-07-03 21:07:54', '2025-07-03 21:07:54'),
('003R5MF231', 'DC Fuse', 3, 'R51', 'MF23107', '2025-07-16', 'Manufactured', '2025-07-04 18:41:31', '2025-07-04 18:41:31'),
('003R8MF083', 'Striker Fuse', 3, 'R83', 'MF08314', '2025-07-17', 'Manufactured', '2025-07-04 20:01:04', '2025-07-04 20:01:04'),
('003R9MF430', 'Striker Fuse', 3, 'R9', 'MF43021', '2025-06-30', 'Manufactured', '2025-07-03 20:10:25', '2025-07-03 20:10:25'),
('004R1MF272', 'bj', 4, 'R14', 'MF27247', '2025-07-07', 'Manufactured', '2025-07-04 11:28:51', '2025-07-04 11:28:51'),
('004R3MF454', 'Charging Bulb', 4, 'R33', 'MF45431', '2025-06-29', 'Manufactured', '2025-07-03 20:16:51', '2025-07-03 20:16:51'),
('004R7MF126', 'Charging Bulb', 4, 'R75', 'MF12671', '2025-07-07', 'Manufactured', '2025-07-04 11:24:55', '2025-07-04 11:24:55'),
('004R7MF188', 'Electric Bulb', 4, 'R78', 'MF18816', '2025-07-16', 'Manufactured', '2025-07-04 20:16:40', '2025-07-04 20:16:40'),
('004R7MF555', 'Charging Bulb', 4, 'R74', 'MF55532', '2025-07-25', 'Manufactured', '2025-07-04 20:16:50', '2025-07-04 20:16:50'),
('004R8MF198', 'Electric Bulb', 4, 'R80', 'MF19820', '2025-07-23', 'Manufactured', '2025-07-04 18:40:04', '2025-07-04 18:40:04'),
('004R8MF973', 'Charging Bulb', 4, 'R89', 'MF97386', '2025-07-19', 'Manufactured', '2025-07-04 19:55:34', '2025-07-04 19:55:34');

--
-- Triggers `products`
--
DELIMITER $$
CREATE TRIGGER `before_insert_products` BEFORE INSERT ON `products` FOR EACH ROW BEGIN
    DECLARE max_id VARCHAR(20);
    DECLARE serial INT DEFAULT 1;
    DECLARE today_prefix VARCHAR(10);

    -- 1. Prefix banaye with current date
    SET today_prefix = CONCAT('P', DATE_FORMAT(CURDATE(), '%Y%m%d'));

    -- 2. Check karein max existing ID from today
    SELECT MAX(product_id)
    INTO max_id
    FROM products
    WHERE product_id LIKE CONCAT(today_prefix, '%');

    -- 3. Agar mila, to uska serial nikaalein aur +1 karein
    IF max_id IS NOT NULL THEN
        SET serial = CAST(SUBSTRING(max_id, -3) AS UNSIGNED) + 1;
    END IF;

    -- 4. Final ID banaye with 3 digit padded serial
    SET NEW.product_id = CONCAT(today_prefix, LPAD(serial, 3, '0'));
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_generate_product_id` BEFORE INSERT ON `products` FOR EACH ROW BEGIN
    DECLARE padded_type VARCHAR(3);
    DECLARE padded_revise VARCHAR(2);
    DECLARE padded_manu VARCHAR(5);

    SET padded_type = LPAD(NEW.product_type_id, 3, '0');
    SET padded_revise = LPAD(NEW.revise_code, 2, '0');
    SET padded_manu = LPAD(NEW.manufacture_no, 5, '0');

    SET NEW.product_id = CONCAT(padded_type, padded_revise, padded_manu);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `product_types`
--

CREATE TABLE `product_types` (
  `product_type_id` int(11) NOT NULL,
  `type_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_types`
--

INSERT INTO `product_types` (`product_type_id`, `type_name`) VALUES
(1, 'Inductor'),
(2, 'Diode'),
(3, 'Fuse'),
(4, 'BULB');

-- --------------------------------------------------------

--
-- Table structure for table `re-manufacture`
--

CREATE TABLE `re-manufacture` (
  `re-manufacture_id` varchar(50) NOT NULL,
  `re_product_id` varchar(20) DEFAULT NULL,
  `Tested_by` varchar(200) NOT NULL,
  `Department` varchar(200) NOT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `re-manufacture`
--

INSERT INTO `re-manufacture` (`re-manufacture_id`, `re_product_id`, `Tested_by`, `Department`, `remarks`, `created_at`, `updated_at`) VALUES
('RM001', '002R5MF175', '1', '1', NULL, '2025-07-04 18:42:04', '2025-07-04 18:42:04'),
('RM002', '004R8MF198', '1', '1', 're-manufactured manually.', '2025-07-05 00:15:31', '2025-07-05 00:15:31'),
('RM003', '004R8MF198', '1', '1', 're-manufactured manually.', '2025-07-05 00:15:43', '2025-07-05 00:15:43'),
('RM004', '004R3MF454', '1', '2', 're-manufactured manually.', '2025-07-05 00:16:34', '2025-07-05 00:16:34'),
('RM005', '003R9MF430', '1', '3', 're-manufactured manually.', '2025-07-05 00:17:12', '2025-07-05 00:17:12'),
('RM006', '002R8MF043', '', '', 'CPRI test failed. Sent for `re-manufacture`.', '2025-07-05 00:26:10', '2025-07-05 00:26:10'),
('RM007', '003R3MF938', '', '', 'CPRI test failed. Sent for re-manufacture.', '2025-07-05 00:34:06', '2025-07-05 00:34:06'),
('RM008', '001R5MF195', '', '', 'CPRI test failed. Sent for re-manufacture.', '2025-07-05 00:47:22', '2025-07-05 00:47:22'),
('RM009', '001R1MF829', '1', '1', 're-manufactured manually.', '2025-07-05 00:47:39', '2025-07-05 00:47:39'),
('RM010', '002R2MF212', '', '', 'CPRI test failed. Sent for re-manufacture.', '2025-07-05 01:00:26', '2025-07-05 01:00:26'),
('RM011', '001R1MF829', '1', '1', 're-manufactured manually.', '2025-07-05 01:04:01', '2025-07-05 01:04:01'),
('RM012', '001R4MF751', '1', '1', 're-manufactured manually.', '2025-07-05 01:05:43', '2025-07-05 01:05:43'),
('RM013', '001R8MF049', '1', '1', 're-manufactured manually.', '2025-07-05 01:07:40', '2025-07-05 01:07:40'),
('RM014', '002R4MF803', '', '', 'CPRI test failed. Sent for re-manufacture.', '2025-07-05 01:12:42', '2025-07-05 01:12:42'),
('RM015', '001R3MF867', '1', '3', 're-manufactured manually.', '2025-07-05 01:20:15', '2025-07-05 01:20:15'),
('RM016', '004R7MF188', '', '', 'CPRI test failed. Sent for re-manufacture.', '2025-07-05 01:20:47', '2025-07-05 01:20:47'),
('RM017', '004R7MF555', '', '', 'CPRI test failed. Sent for re-manufacture.', '2025-07-05 01:22:52', '2025-07-05 01:22:52'),
('RM018', '002R4MF770', '1', '3', 're-manufactured manually.', '2025-07-05 01:37:38', '2025-07-05 01:37:38');

--
-- Triggers `re-manufacture`
--
DELIMITER $$
CREATE TRIGGER `before_insert_re_manufacture` BEFORE INSERT ON `re-manufacture` FOR EACH ROW BEGIN
    DECLARE max_id INT DEFAULT 0;
    DECLARE new_id VARCHAR(10);

    -- Get the numeric part of the max existing ID
    SELECT 
        IFNULL(MAX(CAST(SUBSTRING(`re-manufacture_id`, 3) AS UNSIGNED)), 0)
    INTO 
        max_id 
    FROM 
        `re-manufacture`;

    -- Generate new ID
    SET new_id = CONCAT('RM', LPAD(max_id + 1, 3, '0'));

    -- Assign to new row
    SET NEW.`re-manufacture_id` = new_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `name`) VALUES
(1, 'admin'),
(2, 'employee');

-- --------------------------------------------------------

--
-- Table structure for table `testers`
--

CREATE TABLE `testers` (
  `tester_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(20) NOT NULL,
  `department_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `testers`
--

INSERT INTO `testers` (`tester_id`, `name`, `email`, `password`, `department_id`) VALUES
(1, 'kabir', 'kabir123@gmail.com', 'kabir123', 3);

-- --------------------------------------------------------

--
-- Table structure for table `testing_types`
--

CREATE TABLE `testing_types` (
  `testing_type_id` int(11) NOT NULL,
  `test_name` varchar(100) NOT NULL,
  `department_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `testing_types`
--

INSERT INTO `testing_types` (`testing_type_id`, `test_name`, `department_id`) VALUES
(1, 'Power Testing', 1),
(2, 'Components Load Test', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `cpri_tests`
--
ALTER TABLE `cpri_tests`
  ADD PRIMARY KEY (`cpri_test_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `related_test_id` (`related_test_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`department_id`);

--
-- Indexes for table `lab_test`
--
ALTER TABLE `lab_test`
  ADD PRIMARY KEY (`test_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `testing_type_id` (`testing_type_id`),
  ADD KEY `department_id` (`department_id`),
  ADD KEY `tester_id` (`tester_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `product_type_id` (`product_type_id`);

--
-- Indexes for table `product_types`
--
ALTER TABLE `product_types`
  ADD PRIMARY KEY (`product_type_id`);

--
-- Indexes for table `re-manufacture`
--
ALTER TABLE `re-manufacture`
  ADD PRIMARY KEY (`re-manufacture_id`),
  ADD KEY `Re-Product_id` (`re_product_id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testers`
--
ALTER TABLE `testers`
  ADD PRIMARY KEY (`tester_id`),
  ADD KEY `department_id` (`department_id`);

--
-- Indexes for table `testing_types`
--
ALTER TABLE `testing_types`
  ADD PRIMARY KEY (`testing_type_id`),
  ADD KEY `department_id` (`department_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `cpri_tests`
--
ALTER TABLE `cpri_tests`
  MODIFY `cpri_test_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `department_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `product_types`
--
ALTER TABLE `product_types`
  MODIFY `product_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `testers`
--
ALTER TABLE `testers`
  MODIFY `tester_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `testing_types`
--
ALTER TABLE `testing_types`
  MODIFY `testing_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`);

--
-- Constraints for table `cpri_tests`
--
ALTER TABLE `cpri_tests`
  ADD CONSTRAINT `cpri_tests_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `lab_test`
--
ALTER TABLE `lab_test`
  ADD CONSTRAINT `lab_test_ibfk_2` FOREIGN KEY (`testing_type_id`) REFERENCES `testing_types` (`testing_type_id`),
  ADD CONSTRAINT `lab_test_ibfk_3` FOREIGN KEY (`department_id`) REFERENCES `departments` (`department_id`),
  ADD CONSTRAINT `lab_test_ibfk_4` FOREIGN KEY (`tester_id`) REFERENCES `testers` (`tester_id`),
  ADD CONSTRAINT `lab_test_ibfk_5` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`product_type_id`) REFERENCES `product_types` (`product_type_id`);

--
-- Constraints for table `testers`
--
ALTER TABLE `testers`
  ADD CONSTRAINT `testers_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `departments` (`department_id`);

--
-- Constraints for table `testing_types`
--
ALTER TABLE `testing_types`
  ADD CONSTRAINT `testing_types_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `departments` (`department_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
