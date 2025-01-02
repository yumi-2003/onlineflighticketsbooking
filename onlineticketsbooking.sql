-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 02, 2025 at 08:44 PM
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

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `admin_uname`, `admin_email`, `admin_pwd`, `profile`) VALUES
(1, 'admin', 'admin@gmail.com', '$2y$10$0PqW2uHfQzVsSEjZppGriOzo5Cm4RfsDDmjOM3ch9Q0Ld8o8lQCM6', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `airline`
--

CREATE TABLE `airline` (
  `airline_id` int(11) NOT NULL,
  `airline_name` varchar(100) NOT NULL,
  `photo` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `airline`
--

INSERT INTO `airline` (`airline_id`, `airline_name`, `photo`) VALUES
(2, 'Myanmar International Airways(MNA)', '../flightImg/MNA.webp'),
(5, 'Myanmar Airway International                                ', '../flightImg/MAI.png'),
(6, 'Singapore Airlines(QA)                                                              ', '../flightImg/SA.png');

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
  `gate` varchar(255) NOT NULL,
  `placeImg` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `flight`
--

INSERT INTO `flight` (`flight_id`, `airline_id`, `flight_name`, `flight_date`, `destination`, `source`, `total_distance`, `fee_per_ticket`, `departure_time`, `arrival_time`, `capacity`, `seats_researved`, `seats_available`, `gate`, `placeImg`) VALUES
(2, 5, 'MAI-201', '2025-02-01', 'Bangkok', 'Yangon', '580', 150.00, '09:00:00', '10:30:00', 150, 130, 20, 'A1', '../flightImg/bk.jpg'),
(4, 2, 'MAI 707', '2025-02-01', 'Chiang Mai', 'Yangon', '430', 100.00, '08:00:00', '10:00:00', 150, 100, 50, 'A2', '../flightImg/Chiang Mai, Thailand.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `flightclasses`
--

CREATE TABLE `flightclasses` (
  `flightclasses_id` int(11) NOT NULL,
  `flight_id` int(11) DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `triptype` int(11) DEFAULT NULL,
  `classPrice` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `flightclasses`
--

INSERT INTO `flightclasses` (`flightclasses_id`, `flight_id`, `class_id`, `triptype`, `classPrice`) VALUES
(1, 2, 1, 1, 900.00),
(2, 2, 1, 2, 1800.00),
(3, 2, 2, 1, 600.00),
(4, 2, 2, 2, 1200.00),
(5, 2, 3, 2, 600.00),
(6, 2, 3, 1, 300.00),
(7, 2, 4, 1, 150.00),
(8, 2, 4, 2, 300.00),
(9, 4, 1, 1, 600.00),
(10, 4, 1, 2, 1200.00),
(11, 4, 2, 1, 400.00),
(12, 4, 2, 2, 800.00),
(13, 4, 3, 1, 200.00),
(14, 4, 3, 2, 400.00),
(15, 4, 4, 1, 100.00),
(16, 4, 4, 2, 200.00),
(17, 4, 1, 1, 600.00),
(18, 4, 1, 2, 1200.00),
(19, 4, 2, 1, 400.00),
(20, 4, 2, 2, 800.00),
(21, 4, 3, 1, 200.00),
(22, 4, 3, 2, 400.00),
(23, 4, 4, 1, 100.00),
(24, 4, 4, 2, 200.00);

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

--
-- Dumping data for table `passengers`
--

INSERT INTO `passengers` (`passenger_id`, `fullName`, `age`, `gender`, `nationality`, `phoneNo`, `IDcard`, `passportNo`) VALUES
(1, '', 0, '', '', 0, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `paymentID` int(11) NOT NULL,
  `cardNo` int(11) DEFAULT NULL,
  `securityCode` int(11) DEFAULT NULL,
  `expireDate` date DEFAULT NULL,
  `paymentType` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `paymenttype`
--

CREATE TABLE `paymenttype` (
  `typeID` int(11) NOT NULL,
  `paymentName` varchar(100) DEFAULT NULL,
  `logo` varchar(100) DEFAULT NULL
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
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `cpassword`, `profile`) VALUES
(7, 'yumimay', 'yumimay@gmail.com', '$2y$10$624QCrhZr/aUb9M7A8O6QemcRuebevCpav47xWucT8d6iXkWLpfAq', NULL, '../userPhoto/download (4).jpg');

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
-- Indexes for table `flightclasses`
--
ALTER TABLE `flightclasses`
  ADD PRIMARY KEY (`flightclasses_id`),
  ADD KEY `FK_flight` (`flight_id`),
  ADD KEY `FK_Class` (`class_id`),
  ADD KEY `FK_triptype` (`triptype`);

--
-- Indexes for table `passengers`
--
ALTER TABLE `passengers`
  ADD PRIMARY KEY (`passenger_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`paymentID`),
  ADD KEY `FK_type` (`paymentType`);

--
-- Indexes for table `paymenttype`
--
ALTER TABLE `paymenttype`
  ADD PRIMARY KEY (`typeID`);

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
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `airline`
--
ALTER TABLE `airline`
  MODIFY `airline_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
-- AUTO_INCREMENT for table `flightclasses`
--
ALTER TABLE `flightclasses`
  MODIFY `flightclasses_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `passengers`
--
ALTER TABLE `passengers`
  MODIFY `passenger_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `paymentID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `paymenttype`
--
ALTER TABLE `paymenttype`
  MODIFY `typeID` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `flight`
--
ALTER TABLE `flight`
  ADD CONSTRAINT `FK_airflight` FOREIGN KEY (`airline_id`) REFERENCES `airline` (`airline_id`);

--
-- Constraints for table `flightclasses`
--
ALTER TABLE `flightclasses`
  ADD CONSTRAINT `FK_Class` FOREIGN KEY (`class_id`) REFERENCES `classes` (`class_id`),
  ADD CONSTRAINT `FK_flight` FOREIGN KEY (`flight_id`) REFERENCES `flight` (`flight_id`),
  ADD CONSTRAINT `FK_triptype` FOREIGN KEY (`triptype`) REFERENCES `triptype` (`triptypeId`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `FK_type` FOREIGN KEY (`paymentType`) REFERENCES `payment` (`paymentID`);

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
