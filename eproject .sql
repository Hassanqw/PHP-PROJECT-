-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 27, 2025 at 07:43 PM
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
  `result` enum('Pass','Fail') NOT NULL,
  `certification_status` enum('Certified','Rejected') NOT NULL,
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
(1, '007R1MF901', 'RT-20250727-001', '2025-07-31', 'sana', '2025-07-31', 'TRN-2025-0001', 'eqw', 'qwe', 'Pass', 'Certified', 'qwed s', 'uploads/reports/report_68863101bc120_Striker_fuse.jpg', 'Abdul Kabeer', '2025-07-30', '2025-07-27 14:00:33', '2025-07-27 14:00:33'),
(2, '005R2MF027', 'RT-20250727-002', '2025-07-30', 'Hassan', '2025-07-31', 'TRN-2025-0002', 'dassac', 'asdqw', 'Pass', 'Certified', 'dasc', 'uploads/reports/report_688631264e2f6_IMG-20250627-WA0030.png', 'Ahmed', '2025-07-30', '2025-07-27 14:01:10', '2025-07-27 14:01:17'),
(3, '004R5MF240', 'RT-20250727-003', '2025-07-29', 'Ayesha', '2025-07-28', 'TRN-2025-0003', 'qwedc', 'dwqsa', 'Pass', 'Certified', 'dqwsa', 'uploads/reports/report_688632002717f_IMG-20250627-WA0030.png', 'Abdul Kabeer', '2025-07-29', '2025-07-27 14:04:48', '2025-07-27 14:04:48'),
(4, '001R1MF256', 'RT-20250727-004', '2025-08-08', 'Ayesha', '2025-07-30', 'TRN-2025-0004', '2eqwdas', 'qwads', 'Pass', 'Certified', '2qwsdxc', 'uploads/reports/report_688632489cf46_Striker_fuse.jpg', 'Hassan', '2025-08-08', '2025-07-27 14:06:00', '2025-07-27 14:06:19');

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
(3, 'Electrical Testing', 'Building A-3'),
(4, 'Quality Assurance (QA) Department', 'Building B-3'),
(5, 'Connectors & Terminals Testing Lab', 'Building A-2'),
(7, 'HR Department', 'Building A-5'),
(8, 'Connectors & Terminals Testing Lab', 'Building A-2');

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
('LigR20010001', '005R2MF027', 1, 1, 3, '2025-08-07', '14:31:00', '02:13:00', 'Voltage Tolerance at 220V', 'Passed – Breaks at 1.02A, normal continuity', 'Voltage should remain stable at 220V ±5%', 'Pass', 'sad', 'ROLL_20250727_185933_602', '2025-07-27 10:59:33', '2025-07-27 10:59:33'),
('StrR10020001', '001R1MF256', 2, 4, 4, '2025-08-01', '02:13:00', '02:13:00', 'Input Voltage (AC)', '10.2 µH', 'Signal continuity present', 'Pass', 'es', 'ROLL_20250727_190529_834', '2025-07-27 11:05:29', '2025-07-27 11:05:29'),
('TerR10010001', '007R1MF901', 1, 4, 1, '2025-08-08', '02:13:00', '14:11:00', 'Continuity', 'Voltage remained stable at 220V', 'Voltage should remain stable at 220V ±5%', 'Fail', 'dsa', 'ROLL_20250727_185905_751', '2025-07-27 10:59:05', '2025-07-27 10:59:05'),
('TunR50010001', '004R5MF240', 1, 4, 3, '2025-08-09', '02:13:00', '14:13:00', 'Voltage Tolerance at 220V', 'Input Voltage (DC)', '220V – 240V', 'Fail', 'dsa', 'ROLL_20250727_190417_607', '2025-07-27 11:04:17', '2025-07-27 11:04:17');

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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `product_type_id`, `revise_code`, `manufacture_no`, `manufacture_date`, `created_at`, `updated_at`) VALUES
('001R1MF256', 'Striker Fuse', 1, 'R17', 'MF25665', '2025-08-02', '2025-07-22 19:39:59', '2025-07-22 19:39:59'),
('001R2MF206', 'blast fuse', 1, 'R24', 'MF20648', '2025-07-22', '2025-07-22 19:44:27', '2025-07-22 19:44:27'),
('001R6MF611', 'blast fuse X', 1, 'R6', 'MF61131', '2025-07-30', '2025-07-27 10:28:08', '2025-07-27 10:28:08'),
('001R7MF504', 'blast fuse X', 1, 'R70', 'MF50408', '2025-08-01', '2025-07-27 10:25:09', '2025-07-27 10:25:09'),
('001R9MF690', 'Striker Fuse', 1, 'R9', 'MF69015', '2025-07-30', '2025-07-23 05:59:32', '2025-07-23 05:59:32'),
('002R1MF167', 'Air Core Inductor', 2, 'R14', 'MF16772', '2025-07-24', '2025-07-22 19:08:33', '2025-07-22 19:08:33'),
('003R4MF887', 'Charging Bulb', 3, 'R48', 'MF88732', '2025-07-25', '2025-07-22 19:08:52', '2025-07-22 19:08:52'),
('003R8MF869', 'Tunnell Diode', 3, 'R82', 'MF86963', '2025-07-24', '2025-07-22 20:02:03', '2025-07-22 20:02:03'),
('004R5MF240', 'Tunnel Diode', 4, 'R56', 'MF24089', '2025-07-22', '2025-07-22 19:08:43', '2025-07-22 19:08:43'),
('005R1MF264', 'Lighting Connector', 5, 'R16', 'MF26428', '2025-07-27', '2025-07-22 19:59:25', '2025-07-22 19:59:25'),
('005R2MF027', 'Lighhting Connector', 5, 'R25', 'MF02759', '2025-07-31', '2025-07-22 19:52:58', '2025-07-22 19:52:58'),
('007R1MF901', 'Terminal', 7, 'R11', 'MF90115', '2026-02-25', '2025-07-23 07:15:41', '2025-07-23 07:15:41');

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
(1, 'Fuse'),
(2, 'Inductor'),
(3, 'BULB'),
(4, 'Diode'),
(5, 'Connetor'),
(6, 'Capasitor'),
(7, 'Terminal');

-- --------------------------------------------------------

--
-- Table structure for table `re-manufacture`
--

CREATE TABLE `re-manufacture` (
  `re-manufacture_id` varchar(50) NOT NULL,
  `re_product_id` varchar(20) DEFAULT NULL,
  `Tested_by` varchar(100) NOT NULL,
  `Department` varchar(100) NOT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `re-manufacture`
--

INSERT INTO `re-manufacture` (`re-manufacture_id`, `re_product_id`, `Tested_by`, `Department`, `remarks`, `created_at`, `updated_at`) VALUES
('RM001', '007R1MF901', '1', '4', 're-manufactured manually.', '2025-07-27 18:59:55', '2025-07-27 18:59:55'),
('RM002', '005R2MF027', '1', '1', 're-manufactured manually.', '2025-07-27 19:01:17', '2025-07-27 19:01:17'),
('RM003', '004R5MF240', '2', '2', 're-manufactured manually.', '2025-07-27 19:04:22', '2025-07-27 19:04:22'),
('RM004', '001R1MF256', '1', '1', 're-manufactured manually.', '2025-07-27 19:06:19', '2025-07-27 19:06:19');

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
(2, 'tester');

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
(1, 'Ahmed ', 'Ahmed123@gmail.com', '1234', 2),
(2, 'Hassan', 'Hassan123@gmail.com', '123', 4),
(3, 'Anas', 'Anas123@gmail.com', '123', 3),
(4, 'Ayesha', 'Ayesha123@gmail.com', '1234', 7),
(5, 'hamza', 'Hamza@gmail.com', '123', 5);

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
(2, 'Continuity Test', 2),
(3, 'Components Load Test', 4);

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
  MODIFY `cpri_test_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `department_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `product_types`
--
ALTER TABLE `product_types`
  MODIFY `product_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `testers`
--
ALTER TABLE `testers`
  MODIFY `tester_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `testing_types`
--
ALTER TABLE `testing_types`
  MODIFY `testing_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
-- Constraints for table `re-manufacture`
--
ALTER TABLE `re-manufacture`
  ADD CONSTRAINT `re-manufacture_ibfk_1` FOREIGN KEY (`re_product_id`) REFERENCES `products` (`product_id`);

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
