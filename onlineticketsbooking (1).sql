-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 19, 2024 at 04:14 PM
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
-- Database: `onlineticketsbooking`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `admin_uname` varchar(20) NOT NULL,
  `admin_email` varchar(30) NOT NULL,
  `admin_pwd` varchar(60) NOT NULL,
  `profile` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `airline`
--

CREATE TABLE `airline` (
  `airline_id` int(11) NOT NULL,
  `airline_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `airline`
--

INSERT INTO `airline` (`airline_id`, `airline_name`) VALUES
(1, 'Myanmar Airway International(MAI)'),
(2, 'Mynamar National Airlines(MNA)'),
(3, 'Global Myanamr Airline');

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `class_id` int(11) NOT NULL,
  `class_name` varchar(255) NOT NULL,
  `base_fees` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`class_id`, `class_name`, `base_fees`) VALUES
(1, 'First', 6.00),
(2, 'Business', 4.00),
(3, 'Premium Economy', 2.00),
(4, 'Economy', 1.00);

-- --------------------------------------------------------

--
-- Table structure for table `flight`
--

CREATE TABLE `flight` (
  `flight_id` int(11) NOT NULL,
  `airline_id` int(11) NOT NULL,
  `flight_name` varchar(100) NOT NULL,
  `flight_date` date NOT NULL,
  `destination` varchar(255) NOT NULL,
  `source` varchar(100) NOT NULL,
  `total_distance` varchar(100) NOT NULL,
  `fee_per_ticket` decimal(10,2) NOT NULL,
  `departure_time` time NOT NULL,
  `arrival_time` time NOT NULL,
  `capacity` int(11) NOT NULL,
  `seats_researved` int(11) NOT NULL,
  `seats_available` int(11) NOT NULL,
  `gate` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `flight`
--

INSERT INTO `flight` (`flight_id`, `airline_id`, `flight_name`, `flight_date`, `destination`, `source`, `total_distance`, `fee_per_ticket`, `departure_time`, `arrival_time`, `capacity`, `seats_researved`, `seats_available`, `gate`) VALUES
(2, 1, 'MAI-201', '2024-06-27', 'Bangkok', 'Yangon', '580', 150.00, '09:00:00', '10:30:00', 150, 130, 20, 'A1'),
(4, 1, 'MAI 707', '2024-12-17', 'Chiang Mai', 'Yangon', '430', 100.00, '08:00:00', '10:00:00', 150, 100, 50, 'A2');

-- --------------------------------------------------------

--
-- Table structure for table `passengers`
--

CREATE TABLE `passengers` (
  `passenger_id` int(11) NOT NULL,
  `fullName` varchar(100) NOT NULL,
  `age` int(11) NOT NULL,
  `gender` varchar(100) NOT NULL,
  `nationality` varchar(100) NOT NULL,
  `phoneNo` int(11) NOT NULL,
  `IDcard` varchar(100) NOT NULL,
  `passportNo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `transaction_id` int(11) NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `card_no` int(11) NOT NULL,
  `Expire_date` datetime NOT NULL,
  `total_amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `seatno`
--

CREATE TABLE `seatno` (
  `seatNo_id` int(11) NOT NULL,
  `flightId` int(11) NOT NULL,
  `seatypeId` int(11) NOT NULL,
  `status` varchar(255) NOT NULL,
  `seatNo` varchar(255) NOT NULL,
  `seatLayout` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seatno`
--

INSERT INTO `seatno` (`seatNo_id`, `flightId`, `seatypeId`, `status`, `seatNo`, `seatLayout`) VALUES
(1, 2, 1, 'available', '1AF', 'Window'),
(2, 2, 1, 'available', '1GF', 'Aisle'),
(3, 2, 1, 'available', '2GF', 'Middle'),
(4, 2, 1, 'available', '3AF', 'Window'),
(5, 2, 2, 'available', '1AB', 'Middle'),
(6, 2, 2, 'available', '1GB', 'Aisle'),
(7, 2, 2, 'available', '2GB', 'Aisle'),
(8, 2, 2, 'available', '3AB', 'Window'),
(9, 2, 3, 'available', '1AP', 'Middle'),
(10, 2, 3, 'available', '1GP', 'Aisle '),
(11, 2, 3, 'available', '2GP', 'Widow'),
(12, 2, 3, 'available', '3AP', 'Middle'),
(13, 2, 4, 'available', '1AE', 'Aisle'),
(14, 2, 4, 'available', '1GE', 'Middle'),
(15, 2, 4, 'available', '2GE', 'Window'),
(16, 2, 4, 'available', '3AE', 'Window');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `ticket_id` int(11) NOT NULL,
  `flight_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_fees` int(11) NOT NULL,
  `bookAt` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `triptype`
--

CREATE TABLE `triptype` (
  `triptypeId` int(11) NOT NULL,
  `triptype_name` varchar(255) NOT NULL,
  `priceCharge` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `triptype`
--

INSERT INTO `triptype` (`triptypeId`, `triptype_name`, `priceCharge`) VALUES
(1, 'Single', 1.00),
(2, 'Round', 2.00);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(60) DEFAULT NULL,
  `cpassword` varchar(60) DEFAULT NULL,
  `profile` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `airline`
--
ALTER TABLE `airline`
  ADD PRIMARY KEY (`airline_id`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`class_id`);

--
-- Indexes for table `flight`
--
ALTER TABLE `flight`
  ADD PRIMARY KEY (`flight_id`),
  ADD KEY `FK_airflight` (`airline_id`);

--
-- Indexes for table `passengers`
--
ALTER TABLE `passengers`
  ADD PRIMARY KEY (`passenger_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`transaction_id`);

--
-- Indexes for table `seatno`
--
ALTER TABLE `seatno`
  ADD PRIMARY KEY (`seatNo_id`),
  ADD KEY `FK_flightseatno` (`flightId`),
  ADD KEY `FK_typeseatno` (`seatypeId`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`ticket_id`);

--
-- Indexes for table `triptype`
--
ALTER TABLE `triptype`
  ADD PRIMARY KEY (`triptypeId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `airline`
--
ALTER TABLE `airline`
  MODIFY `airline_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `class_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `flight`
--
ALTER TABLE `flight`
  MODIFY `flight_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `passengers`
--
ALTER TABLE `passengers`
  MODIFY `passenger_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `seatno`
--
ALTER TABLE `seatno`
  MODIFY `seatNo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `ticket_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `triptype`
--
ALTER TABLE `triptype`
  MODIFY `triptypeId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `flight`
--
ALTER TABLE `flight`
  ADD CONSTRAINT `FK_airflight` FOREIGN KEY (`airline_id`) REFERENCES `airline` (`airline_id`);

--
-- Constraints for table `seatno`
--
ALTER TABLE `seatno`
  ADD CONSTRAINT `FK_flightseatno` FOREIGN KEY (`flightId`) REFERENCES `flight` (`flight_id`),
  ADD CONSTRAINT `FK_typeseatno` FOREIGN KEY (`seatypeId`) REFERENCES `classes` (`class_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
