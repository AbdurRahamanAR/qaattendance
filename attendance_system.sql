-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 29, 2024 at 06:30 AM
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
-- Database: `attendance_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `active_qr`
--

CREATE TABLE `active_qr` (
  `qr_id` int(11) NOT NULL,
  `qr_text` text DEFAULT NULL,
  `qr_description` text DEFAULT NULL,
  `qr_lat` decimal(11,3) DEFAULT NULL,
  `qr_lon` decimal(11,3) DEFAULT NULL,
  `qr_isactive` binary(1) DEFAULT NULL,
  `qr_createdatetime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `user_id` int(11) NOT NULL,
  `qr_id` int(11) DEFAULT NULL,
  `sacn_datetime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` text DEFAULT NULL,
  `user_email` text DEFAULT NULL,
  `user_password` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_email`, `user_password`) VALUES
(1, 'karim', 'karim@gmail.com', 'ddd'),
(2, 'akbar', 'akbar@gmail.com', 'kjdlksjfols'),
(3, 'sh sajjad', 'sajjad@gmail.com', 'dfjldjkfs'),
(3333, 'tanim', 'tanim@example.com', 'tanimvai'),
(12345, 'John Doe', 'johndoe@example.com', 'hashed_password_here'),
(23849, 'John Doe', 'johndoe@example.com', 'hashed_password_here'),
(23849345, 'abir', 'abir@gmail.com', 'hdgdfdfsfge'),
(123454354, 'Johnathan Doe', 'johnathan@example.com', 'new_secure_password_here'),
(2147483647, 'abdur rahman', 'abdurrahman@gmail.com', 'hdgdfge');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `active_qr`
--
ALTER TABLE `active_qr`
  ADD PRIMARY KEY (`qr_id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `active_qr`
--
ALTER TABLE `active_qr`
  MODIFY `qr_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2147483648;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
