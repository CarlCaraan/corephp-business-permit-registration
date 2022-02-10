-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 10, 2022 at 06:22 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `business`
--

-- --------------------------------------------------------

--
-- Table structure for table `login_data`
--

CREATE TABLE `login_data` (
  `login_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `login_otp` int(6) NOT NULL,
  `last_activity` datetime NOT NULL,
  `login_datetime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login_data`
--

INSERT INTO `login_data` (`login_id`, `user_id`, `login_otp`, `last_activity`, `login_datetime`) VALUES
(32, 178, 325807, '2009-01-22 08:44:07', '2022-01-09 07:44:07'),
(33, 209, 530687, '2009-01-22 10:18:32', '2022-01-09 09:18:32'),
(34, 210, 582577, '2021-01-22 09:23:23', '2022-01-21 08:23:23'),
(35, 209, 652105, '2027-01-22 07:31:59', '2022-01-27 06:31:59'),
(36, 209, 584016, '2009-02-22 02:34:53', '2022-02-09 01:34:53'),
(37, 209, 180625, '2009-02-22 02:36:00', '2022-02-09 01:36:00'),
(38, 209, 174583, '2009-02-22 02:36:27', '2022-02-09 01:36:27');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `content` varchar(255) NOT NULL,
  `timestamp` varchar(255) NOT NULL,
  `seen_status` int(10) NOT NULL,
  `unique_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `name`, `content`, `timestamp`, `seen_status`, `unique_name`) VALUES
(1, 'Carl Caraan', 'has submitted a business permit registration request.', '2022-02-09', 1, ''),
(3, 'Carl Caraan', 'has submitted a business permit registration request.', '2022-02-09', 1, ''),
(11, 'Carl Caraan', 'has submitted a business permit registration request.', '2022-02-10 01:30:07', 1, '2022-02-10 01-30-07.Carl Caraan11.pdf'),
(13, 'Carl Caraan', 'has submitted a business permit registration request.', '2022-02-10 01:31:45', 1, '2022-02-10 01-31-45.Carl Caraan11.pdf'),
(14, 'Carl Caraan', 'has submitted a business permit registration request.', '2022-02-10 01:32:47', 1, '2022-02-10 01-32-47.Carl Caraan11.pdf'),
(17, 'Carl Caraan', 'has submitted a business permit registration request.', '2022-02-10 03:43:47', 1, '2022-02-10 03-43-47.Carl Caraan11.pdf'),
(19, 'Carl Caraan', 'has submitted a business permit registration request.', '2022-02-10 06:09:57', 1, '2022-02-10 06-09-57.Carl Caraan11.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `added_by` varchar(255) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_size` varchar(255) NOT NULL,
  `date_added` varchar(255) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'For Verification',
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `deleted` varchar(3) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `added_by`, `file_name`, `file_size`, `date_added`, `status`, `first_name`, `last_name`, `deleted`, `email`) VALUES
(315, 'carl_castillo', '2022-02-09 07-22-22.Carl Caraan11.pdf', '28241', '2022-02-09', 'Please Resubmit', 'Carl', 'Castillo', 'no', 'bannedefused3@gmail.com'),
(333, 'carl_caraan', '2022-02-10 03-43-47.Carl Caraan11.pdf', '28241', '2022-02-10 03:43:47', 'Please Resubmit', 'Carl', 'Caraan', 'no', 'bannedefused@gmail.com'),
(335, 'carl_caraan', '2022-02-10 06-09-57.Carl Caraan11.pdf', '28241', '2022-02-10 06:09:57', 'For Verification', 'Carl', 'Caraan', 'no', 'bannedefused@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `register_user`
--

CREATE TABLE `register_user` (
  `register_user_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `user_name` varchar(250) NOT NULL,
  `user_email` varchar(250) NOT NULL,
  `user_password` varchar(250) NOT NULL,
  `user_activation_code` varchar(250) NOT NULL,
  `user_email_status` enum('not verified','verified') NOT NULL,
  `user_otp` int(11) NOT NULL,
  `user_datetime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user_gender` varchar(10) NOT NULL,
  `user_type` varchar(10) NOT NULL DEFAULT 'user',
  `account` varchar(255) NOT NULL DEFAULT 'local'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `register_user`
--

INSERT INTO `register_user` (`register_user_id`, `first_name`, `last_name`, `user_name`, `user_email`, `user_password`, `user_activation_code`, `user_email_status`, `user_otp`, `user_datetime`, `user_gender`, `user_type`, `account`) VALUES
(209, 'Carl', 'Castillo', 'carl_castillo', 'bannedefused3@gmail.com', '', '', 'verified', 0, '2022-02-09 10:48:20', 'Male', 'admin', 'google'),
(210, 'Carl', 'Caraan', 'carl_caraan', 'bannedefused@gmail.com', '$2y$10$mp7hn7fUWsPaui4dyLLIfuOMdXwM2pwrLPTED1nQ.tTsm/Igu.VwK', '', 'verified', 0, '2022-02-09 02:52:29', 'Female', 'user', 'google');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `login_data`
--
ALTER TABLE `login_data`
  ADD PRIMARY KEY (`login_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `register_user`
--
ALTER TABLE `register_user`
  ADD PRIMARY KEY (`register_user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `login_data`
--
ALTER TABLE `login_data`
  MODIFY `login_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=336;

--
-- AUTO_INCREMENT for table `register_user`
--
ALTER TABLE `register_user`
  MODIFY `register_user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=220;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
