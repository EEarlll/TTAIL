-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 11, 2024 at 11:53 AM
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
-- Database: `ttail`
--

-- --------------------------------------------------------

--
-- Table structure for table `account_tbl`
--

CREATE TABLE `account_tbl` (
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `balance_tbl`
--

CREATE TABLE `balance_tbl` (
  `id` int(11) NOT NULL,
  `student_no` varchar(255) NOT NULL,
  `transaction_type` enum('deposit','withdrawal') NOT NULL,
  `transaction_amount` decimal(10,2) NOT NULL,
  `balance` decimal(10,2) NOT NULL,
  `transaction_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `info_tbl`
--

CREATE TABLE `info_tbl` (
  `student_no` varchar(255) NOT NULL,
  `Section` varchar(255) DEFAULT NULL,
  `Name` varchar(255) DEFAULT NULL,
  `Contact_Number` varchar(255) DEFAULT NULL,
  `pic_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `time_in_tbl`
--

CREATE TABLE `time_in_tbl` (
  `entry_id` int(11) NOT NULL,
  `time_in` varchar(255) NOT NULL,
  `student_no` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `time_out_tbl`
--

CREATE TABLE `time_out_tbl` (
  `entry_id` int(11) NOT NULL,
  `time_out` varchar(255) NOT NULL,
  `student_no` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account_tbl`
--
ALTER TABLE `account_tbl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `balance_tbl`
--
ALTER TABLE `balance_tbl`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_no` (`student_no`);

--
-- Indexes for table `info_tbl`
--
ALTER TABLE `info_tbl`
  ADD PRIMARY KEY (`student_no`);

--
-- Indexes for table `time_in_tbl`
--
ALTER TABLE `time_in_tbl`
  ADD PRIMARY KEY (`entry_id`),
  ADD KEY `student_no` (`student_no`);

--
-- Indexes for table `time_out_tbl`
--
ALTER TABLE `time_out_tbl`
  ADD PRIMARY KEY (`entry_id`),
  ADD KEY `student_no` (`student_no`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account_tbl`
--
ALTER TABLE `account_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `balance_tbl`
--
ALTER TABLE `balance_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `time_in_tbl`
--
ALTER TABLE `time_in_tbl`
  MODIFY `entry_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `time_out_tbl`
--
ALTER TABLE `time_out_tbl`
  MODIFY `entry_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `balance_tbl`
--
ALTER TABLE `balance_tbl`
  ADD CONSTRAINT `balance_tbl_ibfk_1` FOREIGN KEY (`student_no`) REFERENCES `info_tbl` (`student_no`);

--
-- Constraints for table `time_in_tbl`
--
ALTER TABLE `time_in_tbl`
  ADD CONSTRAINT `time_in_tbl_ibfk_1` FOREIGN KEY (`student_no`) REFERENCES `info_tbl` (`student_no`) ON DELETE CASCADE;

--
-- Constraints for table `time_out_tbl`
--
ALTER TABLE `time_out_tbl`
  ADD CONSTRAINT `time_out_tbl_ibfk_1` FOREIGN KEY (`student_no`) REFERENCES `info_tbl` (`student_no`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
