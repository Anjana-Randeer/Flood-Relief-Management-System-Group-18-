-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 09, 2026 at 09:19 AM
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
-- Database: `flood_relief_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `relief_requests`
--

CREATE TABLE `relief_requests` (
  `request_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `relief_type` enum('Food','Water','Medicine','Shelter') NOT NULL,
  `district` varchar(100) NOT NULL,
  `divisional_secretariat` varchar(100) NOT NULL,
  `gn_division` varchar(100) NOT NULL,
  `contact_person` varchar(100) NOT NULL,
  `contact_number` varchar(15) NOT NULL,
  `address` text NOT NULL,
  `family_members` int(11) NOT NULL,
  `flood_severity` enum('Low','Medium','High') NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
--
-- Dumping data for table `relief_requests`
--

INSERT INTO `relief_requests` (`request_id`, `user_id`, `relief_type`, `district`, `divisional_secretariat`, `gn_division`, `contact_person`, `contact_number`, `address`, `family_members`, `flood_severity`, `description`, `created_at`) VALUES
(23, 1, 'Food', 'Galle', 'Hikkaduwa', 'Unawatuna', 'Rushini Keshani', '0771235671', 'No 41, Temple Road, Unawatuna', 2, 'High', 'Flood water entered house, need food supplies', '2026-02-11 03:35:00'),
(24, 2, 'Food', 'Galle', 'Akmeemana', 'Imaduwa GN 12', 'Tharindu Fernando', '0774589632', 'No 34, Temple Road, Akmeemana', 4, 'High', 'Flood water entered house, need food supplies', '2026-02-11 03:45:00'),
(25, 3, '', 'Matara', 'Weligama', 'Pelena GN 05', 'Dilani Perera', '0715567845', 'No 21, Station Road, Weligama', 3, 'Medium', 'Clean drinking water required for family', '2026-02-11 04:10:00'),
(26, 4, 'Medicine', 'Hambantota', 'Tangalle', 'Madilla GN 03', 'Chathura Silva', '0768896542', 'No 10, Lake View, Tangalle', 5, 'High', 'Children need medical assistance after flood', '2026-02-11 04:35:00'),
(27, 5, '', 'Kalutara', 'Panadura', 'Walana GN 08', 'Ishara Jayasinghe', '0756678943', 'No 55, River Side Road, Panadura', 6, 'Medium', 'Clothes lost due to heavy rain and flooding', '2026-02-11 05:00:00'),
(28, 6, '', 'Galle', 'Habaraduwa', 'Meepe GN 06', 'Ravindu Gunasekara', '0784456721', 'No 17, School Lane, Habaraduwa', 7, '', 'House damaged badly, need temporary shelter', '2026-02-11 05:30:00');

-- --------------------------------------------------------
--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
