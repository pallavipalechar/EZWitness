-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 06, 2023 at 08:11 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `manipal`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `Employee_ID` varchar(22) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Department` varchar(10) DEFAULT NULL,
  `Date` date NOT NULL,
  `Shift` varchar(20) DEFAULT NULL,
  `In_time` time NOT NULL,
  `Out_time` time NOT NULL,
  `Work_Hours` varchar(22) NOT NULL DEFAULT ' 00:00:00 ',
  `OT` time NOT NULL DEFAULT '00:00:00',
  `Status` varchar(22) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `emp_captured_data`
--

CREATE TABLE `emp_captured_data` (
  `id` int(11) NOT NULL,
  `eid` varchar(11) NOT NULL,
  `ename` varchar(30) NOT NULL,
  `json_string` mediumtext NOT NULL,
  `edate` date NOT NULL,
  `etime` time NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `emp_details`
--

CREATE TABLE `emp_details` (
  `id` int(11) NOT NULL,
  `eid` varchar(20) NOT NULL DEFAULT '0',
  `fname` varchar(200) DEFAULT '..',
  `lname` varchar(20) DEFAULT '0',
  `designation` varchar(60) DEFAULT '0',
  `dep_id` varchar(10) DEFAULT '0',
  `dep_description` varchar(30) DEFAULT '0',
  `dob` varchar(20) DEFAULT '2021-01-01',
  `email` varchar(50) DEFAULT NULL,
  `pas_wrd` varchar(20) DEFAULT NULL,
  `con` bigint(14) DEFAULT NULL,
  `gen` varchar(10) DEFAULT NULL,
  `addr` text DEFAULT NULL,
  `pic` varchar(10) DEFAULT NULL,
  `quli` text DEFAULT NULL,
  `shift` varchar(20) DEFAULT NULL,
  `status` varchar(11) DEFAULT NULL,
  `face_cap` int(11) DEFAULT 20
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `emp_details`
--

INSERT INTO `emp_details` (`id`, `eid`, `fname`, `lname`, `designation`, `dep_id`, `dep_description`, `dob`, `email`, `pas_wrd`, `con`, `gen`, `addr`, `pic`, `quli`, `shift`, `status`, `face_cap`) VALUES
(115, '1111', 'likith', '', '', '', '', '2021-01-01', '', '', NULL, 'male', 'd', '', '', NULL, 'Active', 20),
(116, '3333', 'shashank', '', '', '', '', '2021-01-01', '', '', NULL, 'male', '', '', '', NULL, 'Active', 20);

-- --------------------------------------------------------

--
-- Table structure for table `gen_attendance`
--

CREATE TABLE `gen_attendance` (
  `id` int(11) NOT NULL,
  `eid` varchar(11) NOT NULL,
  `ename` varchar(30) NOT NULL,
  `gtime` time NOT NULL,
  `gdate` date NOT NULL,
  `cam_id` varchar(30) NOT NULL,
  `cap_image` varchar(5000) NOT NULL,
  `acc_rate` float NOT NULL,
  `flag` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gen_attendance_cross`
--

CREATE TABLE `gen_attendance_cross` (
  `id` int(11) NOT NULL,
  `eid` varchar(11) NOT NULL,
  `ename` varchar(30) NOT NULL,
  `gtime` time NOT NULL,
  `gdate` date NOT NULL,
  `cam_id` varchar(30) NOT NULL,
  `cap_image` varchar(5000) NOT NULL,
  `acc_rate` float NOT NULL,
  `flag` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gen_holyday`
--

CREATE TABLE `gen_holyday` (
  `id` int(11) NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `start` date NOT NULL,
  `end` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `image_count`
--

CREATE TABLE `image_count` (
  `id` int(10) NOT NULL,
  `eid` varchar(20) NOT NULL,
  `number` int(10) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `adname` varchar(30) NOT NULL,
  `adpass` varchar(30) NOT NULL,
  `role` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `adname`, `adpass`, `role`) VALUES
(1, 'admin', 'admin', 'A');

-- --------------------------------------------------------

--
-- Table structure for table `shift_details`
--

CREATE TABLE `shift_details` (
  `id` int(11) NOT NULL,
  `shift_name` varchar(20) NOT NULL,
  `shift_description` varchar(70) NOT NULL,
  `shift_start_time` time NOT NULL,
  `shift_end_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `weekoff`
--

CREATE TABLE `weekoff` (
  `id` int(11) NOT NULL,
  `eid` int(11) NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `start` date NOT NULL,
  `end` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emp_captured_data`
--
ALTER TABLE `emp_captured_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emp_details`
--
ALTER TABLE `emp_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gen_attendance`
--
ALTER TABLE `gen_attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gen_attendance_cross`
--
ALTER TABLE `gen_attendance_cross`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gen_holyday`
--
ALTER TABLE `gen_holyday`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `image_count`
--
ALTER TABLE `image_count`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shift_details`
--
ALTER TABLE `shift_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `weekoff`
--
ALTER TABLE `weekoff`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `emp_captured_data`
--
ALTER TABLE `emp_captured_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `emp_details`
--
ALTER TABLE `emp_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;

--
-- AUTO_INCREMENT for table `gen_attendance`
--
ALTER TABLE `gen_attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gen_attendance_cross`
--
ALTER TABLE `gen_attendance_cross`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gen_holyday`
--
ALTER TABLE `gen_holyday`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `image_count`
--
ALTER TABLE `image_count`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `shift_details`
--
ALTER TABLE `shift_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `weekoff`
--
ALTER TABLE `weekoff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
