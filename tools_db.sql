-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 09, 2023 at 04:09 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tools_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_borrow_tools`
--

CREATE TABLE `tbl_borrow_tools` (
  `check_id` int(20) NOT NULL,
  `barcode` varchar(200) NOT NULL,
  `status_` varchar(200) DEFAULT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `check_out_date` datetime DEFAULT NULL,
  `check_in_date` datetime DEFAULT NULL,
  `actual_date_returned` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_borrow_tools`
--

INSERT INTO `tbl_borrow_tools` (`check_id`, `barcode`, `status_`, `employee_id`, `check_out_date`, `check_in_date`, `actual_date_returned`) VALUES
(56, '8285337507167', 'returned', 101, '2023-05-01 00:00:00', '2023-05-01 18:44:31', 'Late Return'),
(57, '8285337507167', 'returned', 101, '2023-05-01 00:00:00', '2023-05-01 18:45:23', 'Not Late'),
(58, '1243213012321', 'returned', 101, '2023-05-01 00:00:00', '2023-05-01 18:54:45', 'Not Late'),
(59, '8285337507167', 'returned', 102, '2023-05-01 00:00:00', '2023-05-01 19:06:39', 'Late Return'),
(61, '1243213012321', 'returned', 101, '2023-05-02 00:00:00', '2023-05-02 15:30:05', 'Not Late'),
(62, '1243213012321', 'returned', 101, '2023-05-02 00:00:00', '2023-05-02 18:26:11', 'Late Return'),
(63, '1243213012321', 'returned', 101, '2023-05-02 00:00:00', '2023-05-02 18:27:55', 'Late Return'),
(64, '1243213012321', 'returned', 103, '2023-05-02 00:00:00', '2023-05-02 18:42:05', 'Late Return'),
(65, '8285337507167', 'returned', 102, '2023-05-02 00:00:00', '2023-05-02 18:42:08', 'Late Return'),
(66, '1243213012321', 'returned', 101, '2023-05-02 00:00:00', '2023-05-02 18:42:19', 'Late Return'),
(67, '1243213012321', 'returned', 102, '2023-05-02 00:00:00', '2023-05-02 18:43:34', 'Late Return'),
(68, '8285337507167', 'returned', 102, '2023-05-02 00:00:00', '2023-05-02 18:43:31', 'Late Return'),
(69, '8285337507167', 'returned', 101, '2023-05-02 00:00:00', '2023-05-02 18:43:58', 'Late Return'),
(70, '8285337507167', 'returned', 101, '2023-05-02 00:00:00', '2023-05-02 18:44:23', 'Late Return'),
(71, '1243213012321', 'returned', 101, '2023-05-02 00:00:00', '2023-05-02 18:45:47', 'Late Return'),
(72, '1243213012321', 'returned', 101, '2023-05-02 18:46:39', '2023-05-02 18:46:46', 'Late Return'),
(73, '8285337507167', 'returned', 102, '2023-05-07 16:26:05', '2023-05-07 16:26:12', 'Not Late');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_department`
--

CREATE TABLE `tbl_department` (
  `dept_id` int(11) NOT NULL,
  `department` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_department`
--

INSERT INTO `tbl_department` (`dept_id`, `department`) VALUES
(1, 'Mechanic'),
(2, 'Inspection');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_employee`
--

CREATE TABLE `tbl_employee` (
  `employee_id` int(11) NOT NULL,
  `employee_name` varchar(200) NOT NULL,
  `employee_email` varchar(200) NOT NULL,
  `department` varchar(200) NOT NULL,
  `employee_role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_employee`
--

INSERT INTO `tbl_employee` (`employee_id`, `employee_name`, `employee_email`, `department`, `employee_role`) VALUES
(101, 'Muhammad Husin Bin Ramli', 'husin_ramli@gmail.com', 'Inspection', 'Head Engineer'),
(102, 'John Doe', 'johndoe@gmail.com', 'Mechanic', 'Head Engineer'),
(103, 'Karim Benzema', 'karim_benzema11@gmail.com', 'Mechanic', 'Junior Technician');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_job`
--

CREATE TABLE `tbl_job` (
  `job_id` int(11) NOT NULL,
  `role` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_job`
--

INSERT INTO `tbl_job` (`job_id`, `role`) VALUES
(1, 'Head Engineer'),
(2, 'Head Technician'),
(3, 'Engineer'),
(4, 'Technician'),
(5, 'Junior Engineer'),
(6, 'Junior Technician');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_maintenance`
--

CREATE TABLE `tbl_maintenance` (
  `mid` int(11) NOT NULL,
  `barcode` varchar(200) NOT NULL,
  `problem` varchar(200) DEFAULT NULL,
  `solution` varchar(200) DEFAULT NULL,
  `date_report` date DEFAULT NULL,
  `date_released` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_maintenance`
--

INSERT INTO `tbl_maintenance` (`mid`, `barcode`, `problem`, `solution`, `date_report`, `date_released`) VALUES
(65, '8285337507167', 'or', 'Remark', '2023-04-12', '2023-04-13');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_status`
--

CREATE TABLE `tbl_status` (
  `sid` int(11) NOT NULL,
  `status` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_status`
--

INSERT INTO `tbl_status` (`sid`, `status`) VALUES
(1, 'Available'),
(2, 'Maintenance');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tools`
--

CREATE TABLE `tbl_tools` (
  `barcode` varchar(200) NOT NULL,
  `tools_name` varchar(200) DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  `location` varchar(50) DEFAULT NULL,
  `price` double DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `image` varchar(200) DEFAULT NULL,
  `available_quantity` int(11) DEFAULT NULL,
  `status` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_tools`
--

INSERT INTO `tbl_tools` (`barcode`, `tools_name`, `description`, `location`, `price`, `quantity`, `image`, `available_quantity`, `status`) VALUES
('1243213012321', 'Screw Driver', 'Screw Driver             ', 'A2', 300, 1, '64353256213e6.jpg', 1, 'Available'),
('8285337507167', 'Spanner', 'Spanner to repair bolt           ', 'B2', 100, 1, '64353f67e5550.jpg', 1, 'Available');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `userid` int(11) NOT NULL,
  `username` varchar(200) NOT NULL,
  `useremail` varchar(200) NOT NULL,
  `userpassword` varchar(200) NOT NULL,
  `role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`userid`, `username`, `useremail`, `userpassword`, `role`) VALUES
(1, 'Nuruddin Naim', 'naim@gmail.com', 'naim123', 'Admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_borrow_tools`
--
ALTER TABLE `tbl_borrow_tools`
  ADD PRIMARY KEY (`check_id`);

--
-- Indexes for table `tbl_department`
--
ALTER TABLE `tbl_department`
  ADD PRIMARY KEY (`dept_id`);

--
-- Indexes for table `tbl_employee`
--
ALTER TABLE `tbl_employee`
  ADD PRIMARY KEY (`employee_id`);

--
-- Indexes for table `tbl_job`
--
ALTER TABLE `tbl_job`
  ADD PRIMARY KEY (`job_id`);

--
-- Indexes for table `tbl_maintenance`
--
ALTER TABLE `tbl_maintenance`
  ADD PRIMARY KEY (`mid`);

--
-- Indexes for table `tbl_status`
--
ALTER TABLE `tbl_status`
  ADD PRIMARY KEY (`sid`);

--
-- Indexes for table `tbl_tools`
--
ALTER TABLE `tbl_tools`
  ADD PRIMARY KEY (`barcode`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_borrow_tools`
--
ALTER TABLE `tbl_borrow_tools`
  MODIFY `check_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `tbl_department`
--
ALTER TABLE `tbl_department`
  MODIFY `dept_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_job`
--
ALTER TABLE `tbl_job`
  MODIFY `job_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_maintenance`
--
ALTER TABLE `tbl_maintenance`
  MODIFY `mid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `tbl_status`
--
ALTER TABLE `tbl_status`
  MODIFY `sid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
