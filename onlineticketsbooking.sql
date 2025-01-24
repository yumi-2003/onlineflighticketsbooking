-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 24, 2025 at 03:53 PM
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
(1, 'admin', 'admin@gmail.com', '$2y$10$0PqW2uHfQzVsSEjZppGriOzo5Cm4RfsDDmjOM3ch9Q0Ld8o8lQCM6', '../userPhoto/. stitch.jpg');

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
(2, 'Myanmar National Airways                                                                            ', '../flightImg/images.png'),
(5, 'Myanmar Airway International                                ', '../flightImg/MAI.png'),
(6, 'Singapore Airlines(QA)                                                              ', '../flightImg/SA.png');

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `booking_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `flight_id` int(11) DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `triptype_id` int(11) DEFAULT NULL,
  `seatNoId` int(11) DEFAULT NULL,
  `bookAt` date NOT NULL DEFAULT current_timestamp(),
  `passenger_id` int(11) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `payment_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`booking_id`, `user_id`, `flight_id`, `class_id`, `triptype_id`, `seatNoId`, `bookAt`, `passenger_id`, `status`, `updated_at`, `payment_id`) VALUES
(73, 7, 2, 2, 1, 463, '2025-01-09', 88, 'confirm', '2025-01-09', 59),
(74, 7, 2, 2, 1, 464, '2025-01-09', 89, 'confirm', '2025-01-09', 59),
(75, 7, 2, 1, 1, 454, '2025-01-09', 90, 'confirm', '2025-01-09', 62),
(76, 7, 2, 4, 1, 543, '2025-01-09', 91, 'confirm', '2025-01-10', 63),
(77, 7, 2, 3, 1, 538, '2025-01-11', 92, 'confirm', '2025-01-11', 64),
(78, 7, 2, 3, 1, 539, '2025-01-11', 93, 'confirm', '2025-01-11', 64),
(79, 7, 2, 2, 1, 465, '2025-01-13', 94, 'confirm', '2025-01-13', 65),
(80, 7, 2, 2, 1, 466, '2025-01-13', 95, 'confirm', '2025-01-13', 65),
(82, 11, 2, 2, 1, 477, '2025-01-14', 97, 'confirm', '2025-01-14', 66),
(83, 11, 2, 2, 1, 489, '2025-01-19', 98, 'pending', NULL, NULL),
(84, 11, 4, 2, 1, 613, '2025-01-19', 99, 'confirm', '2025-01-20', 67),
(85, 7, 2, 2, 2, 473, '2025-01-20', 100, 'pending', NULL, NULL),
(86, 7, 2, 3, 1, 507, '2025-01-20', 101, 'pending', NULL, NULL),
(87, 7, 2, 3, 1, 507, '2025-01-20', 102, 'pending', NULL, NULL),
(88, 7, 2, 3, 1, 507, '2025-01-20', 103, 'pending', NULL, NULL),
(89, 7, 2, 3, 1, 507, '2025-01-20', 104, 'pending', NULL, NULL),
(90, 7, 2, 3, 1, 507, '2025-01-20', 105, 'pending', NULL, NULL),
(91, 7, 2, 3, 1, 507, '2025-01-20', 106, 'pending', NULL, NULL),
(92, 7, 2, 3, 1, 537, '2025-01-20', 107, 'pending', NULL, NULL),
(93, 7, 2, 3, 1, 537, '2025-01-20', 108, 'pending', NULL, NULL),
(94, 7, 2, 4, 1, 558, '2025-01-20', 109, 'pending', NULL, NULL),
(95, 7, 2, 4, 1, 558, '2025-01-20', 110, 'pending', NULL, NULL),
(96, 7, 2, 4, 1, 558, '2025-01-20', 111, 'pending', NULL, NULL),
(97, 14, 4, 2, 1, 637, '2025-01-22', 112, 'pending', NULL, NULL),
(98, 14, 4, 2, 1, 638, '2025-01-22', 113, 'pending', NULL, NULL),
(99, 14, 2, 4, 1, 598, '2025-01-22', 114, 'confirm', '2025-01-22', 68),
(100, 14, 2, 4, 1, 599, '2025-01-22', 115, 'confirm', '2025-01-22', 68),
(101, 14, 2, 2, 1, 488, '2025-01-22', 116, 'confirm', '2025-01-22', 69),
(102, 14, 2, 2, 2, 484, '2025-01-22', 117, 'confirm', '2025-01-22', 70),
(103, 14, 2, 2, 2, 485, '2025-01-22', 118, 'confirm', '2025-01-22', 70),
(104, 8, 2, 2, 2, 467, '2025-01-23', 119, 'confirm', '2025-01-23', 71),
(105, 15, 4, 2, 1, 639, '2025-01-24', 120, 'pending', NULL, NULL),
(106, 15, 4, 2, 1, 640, '2025-01-24', 121, 'pending', NULL, NULL),
(107, 15, 4, 2, 1, 639, '2025-01-24', 122, 'pending', NULL, NULL),
(108, 15, 4, 2, 1, 639, '2025-01-24', 123, 'pending', NULL, NULL),
(109, 15, 4, 2, 1, 640, '2025-01-24', 124, 'pending', NULL, NULL),
(110, 15, 4, 2, 1, 639, '2025-01-24', 125, 'confirm', '2025-01-24', 72),
(111, 15, 4, 2, 1, 640, '2025-01-24', 126, 'confirm', '2025-01-24', 72);

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
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `contact_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `message` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`contact_id`, `user_id`, `name`, `email`, `message`) VALUES
(1, 7, 'Ingyin', 'ingyin@gmail.com', 'Can i know when the flight to London will be available');

-- --------------------------------------------------------

--
-- Table structure for table `discount`
--

CREATE TABLE `discount` (
  `discount_id` int(11) NOT NULL,
  `promoCode` varchar(100) DEFAULT NULL,
  `discount_percentage` decimal(10,2) DEFAULT NULL,
  `valid_date` date DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `discount`
--

INSERT INTO `discount` (`discount_id`, `promoCode`, `discount_percentage`, `valid_date`) VALUES
(1, 'SWIFT10', 15.00, '2025-02-28');

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
  `fee_per_ticket` float NOT NULL,
  `departure_time` time NOT NULL,
  `arrival_time` time NOT NULL,
  `capacity` int(11) NOT NULL,
  `gate` varchar(255) NOT NULL,
  `placeImg` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `flight`
--

INSERT INTO `flight` (`flight_id`, `airline_id`, `flight_name`, `flight_date`, `destination`, `source`, `total_distance`, `fee_per_ticket`, `departure_time`, `arrival_time`, `capacity`, `gate`, `placeImg`) VALUES
(2, 5, 'MAI 201', '2025-02-01', 'Bangkok', 'Yangon', '580', 150, '09:00:00', '10:30:00', 150, 'A1', '../flightImg/bangkok.jpg'),
(4, 2, 'MNA 707', '2025-02-01', 'Chiang Mai', 'Yangon', '430', 100, '08:00:00', '10:00:00', 150, 'A2', '../flightImg/cm1.jpg'),
(5, 6, 'SQ 221', '2025-02-22', 'Singapore', 'Yangon', '1927', 200, '13:00:00', '15:00:00', 150, 'B1', '../flightImg/sg1.jpg');

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
(24, 4, 4, 2, 200.00),
(50, 5, 3, 2, 800.00),
(51, 5, 3, 1, 400.00),
(53, 5, 4, 1, 200.00),
(59, 5, 4, 2, 400.00),
(60, 5, 1, 1, 1200.00),
(61, 5, 1, 2, 2400.00),
(63, 5, 2, 1, 800.00),
(64, 5, 2, 2, 1600.00);

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
  `phoneNo` varchar(100) NOT NULL,
  `IDcard` varchar(100) NOT NULL,
  `passportNo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `passengers`
--

INSERT INTO `passengers` (`passenger_id`, `fullName`, `age`, `gender`, `nationality`, `phoneNo`, `IDcard`, `passportNo`) VALUES
(87, 'Nway thu', 19, 'Female', 'Myanmar', '988765544', 'brvrv4', '3fc34c'),
(88, 'phoo nge', 23, 'Female', 'Myanmar', '54657657', 'brvrv4', '3fc34c'),
(89, 'nora', 34, 'Female', 'Myanmar', '454645', 'eve3', '557657'),
(90, 'nora', 21, 'Female', 'Myanmar', '43545646', 'brvrv4', '3fc34c'),
(91, 'Ingyin', 22, 'Female', 'Myanmar', '2147483647', 'brvrv4', '3fc34c'),
(92, 'nora', 21, 'Female', 'Myanmar', '09786993707', 'eve3', '557657'),
(93, 'ju', 32, 'Female', 'Myanmar', '09786993707', 'eve3', '557657'),
(94, 'nora', 21, 'Female', 'Myanmar', '09786993707', 'eve3', '3fc34c'),
(95, 'phoo nge', 34, 'Female', 'Myanmar', '09786993707', 'eve3', '557657'),
(96, 'phoo nge', 31, 'Female', 'Myanmar', '09788976544', 'brvrv4', '557657'),
(97, 'nora', 21, 'Female', 'Myanmar', '09786993707', 'brvrv4', '557657'),
(98, 'phoo nge', 21, 'Female', 'Myanmar', '09786993707', 'brvrv4', '3fc34c'),
(99, 'nora', 21, 'Female', 'Myanmar', '09788976544', 'brvrv4', '557657'),
(100, 'nora', 21, 'Female', 'Myanmar', '09786993707', 'eve3', '557657'),
(101, 'nora', 21, 'Female', 'Myanmar', '09786993707', 'brvrv4', '3fc34c'),
(102, 'nora', 21, 'Female', 'Myanmar', '09786993707', 'brvrv4', '3fc34c'),
(103, 'nora', 21, 'Female', 'Myanmar', '09786993707', 'brvrv4', '3fc34c'),
(104, 'nora', 21, 'Female', 'Myanmar', '09786993707', 'brvrv4', '3fc34c'),
(105, 'nora', 21, 'Female', 'Myanmar', '09786993707', 'brvrv4', '3fc34c'),
(106, 'nora', 21, 'Female', 'Myanmar', '09786993707', 'brvrv4', '3fc34c'),
(107, 'nora', 12, 'Female', 'Myanmar', '09786993707', 'eve3', '557657'),
(108, 'Nway thu', 23, 'Female', 'Myanmar', '09786993707', 'brvrv4', '3fc34c'),
(109, 'nora', 23, 'Female', 'Myanmar', '09788976544', 'brvrv4', '3fc34c'),
(110, 'nora', 23, 'Female', 'Myanmar', '09788976544', 'brvrv4', '3fc34c'),
(111, 'nora', 23, 'Female', 'Myanmar', '09788976544', 'brvrv4', '3fc34c'),
(112, 'nora', 21, 'Female', 'Myanmar', '09786993707', 'brvrv4', '557657'),
(113, 'phoo nge', 21, 'Female', 'Myanmar', '09786993707', 'brvrv4', '557657'),
(114, 'nora', 21, 'Female', 'Myanmar', '09786993707', 'brvrv4', '3fc34c'),
(115, 'phoo nge', 21, 'Female', 'Myanmar', '09786993707', 'brvrv4', '557657'),
(116, 'nora', 21, 'Female', 'Myanmar', '09788976544', 'brvrv4', '557657'),
(117, 'Nyi say', 20, 'Female', 'Myanmar', '09786993707', 'brvrv4', '3fc34c'),
(118, 'Swar Si', 23, 'Female', 'Myanmar', '09786993707', 'brvrv4', '557657'),
(119, 'Nway thu', 19, 'Female', 'Myanmar', '09786993707', 'brvrv4', '3fc34c'),
(120, 'nora', 21, 'Female', 'Myanmar', '09786993707', 'eve3', '3fc34c'),
(121, 'Ingyin', 22, 'Female', 'Myanmar', '09786993707', 'brvrv4', '3fc34c'),
(122, 'Zwe Thu', 23, 'Male', 'Myanmar', '09786545623', '12/ABC(N)123456', 'M1234567'),
(123, 'thu thu', 23, 'Male', 'Myanmar', '09876654231', '12/ABC(A)123789', 'O5678901'),
(124, 'lynn lynn', 21, 'Male', 'Myanmar', '09765432134', '12/ABC(N)123456', 'M1234567'),
(125, 'thu thu', 23, 'Male', 'Myanmar', '09876654231', '12/ABC(A)123789', 'O5678901'),
(126, 'lynn lynn', 21, 'Male', 'Myanmar', '09765432134', '12/ABC(N)123456', 'M1234567');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `paymentID` int(11) NOT NULL,
  `cardNo` varchar(100) DEFAULT NULL,
  `securityCode` varchar(100) DEFAULT NULL,
  `expireDate` date DEFAULT NULL,
  `paymentType` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `totalPrice` decimal(10,2) DEFAULT NULL,
  `paymentDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`paymentID`, `cardNo`, `securityCode`, `expireDate`, `paymentType`, `name`, `totalPrice`, `paymentDate`) VALUES
(59, '13131', '131', '0031-12-01', 1, '12312', 1380.00, '2025-01-09'),
(62, '3243432', '23432543', '2025-01-25', 1, 'Ingyin', 1035.00, '2025-01-09'),
(63, '43543534', '34543543', '2025-01-18', 1, 'Ingyin', 172.50, '2025-01-09'),
(64, '34534', '454654', '2025-01-14', 2, 'Phoo Nge', 690.00, '2025-01-11'),
(65, '2435', '2445', '2025-01-23', 1, 'nway', 1380.00, '2025-01-13'),
(66, '224343', '32342', '2025-01-24', 2, 'yumi', 690.00, '2025-01-14'),
(67, '34354', '424242', '2025-02-08', 1, 'Phoo Nge', 460.00, '2025-01-19'),
(68, '233211', '232323', '2025-02-08', 1, 'yumi', 345.00, '2025-01-22'),
(69, '232', '232', '2025-01-31', 1, 'yumi', 690.00, '2025-01-22'),
(70, '123', '212', '2025-02-07', 1, 'Swar Si', 2760.00, '2025-01-22'),
(71, '3232', '2424', '2025-02-08', 1, 'nway', 1380.00, '2025-01-23'),
(72, '434343', '242424', '2025-02-08', 1, 'Swar Si', 920.00, '2025-01-24');

-- --------------------------------------------------------

--
-- Table structure for table `paymenttype`
--

CREATE TABLE `paymenttype` (
  `typeID` int(11) NOT NULL,
  `paymentName` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `paymenttype`
--

INSERT INTO `paymenttype` (`typeID`, `paymentName`) VALUES
(1, 'visa'),
(2, 'paypal');

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `review_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `rating` tinyint(4) DEFAULT NULL CHECK (`rating` between 1 and 5),
  `review_text` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`review_id`, `user_id`, `rating`, `review_text`) VALUES
(2, 7, 3, 'it needs to make fast process\r\n                  \r\n                  '),
(3, 9, 3, 'the function needs to be improved');

-- --------------------------------------------------------

--
-- Table structure for table `seat_layout`
--

CREATE TABLE `seat_layout` (
  `id` int(11) NOT NULL,
  `flight_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `seatNo` varchar(50) NOT NULL,
  `status` enum('available','booked','reserved') DEFAULT 'available',
  `reserved_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seat_layout`
--

INSERT INTO `seat_layout` (`id`, `flight_id`, `class_id`, `seatNo`, `status`, `reserved_at`) VALUES
(453, 2, 1, 'F1', 'booked', NULL),
(454, 2, 1, 'F2', 'booked', NULL),
(455, 2, 1, 'F3', 'booked', NULL),
(456, 2, 1, 'F4', 'booked', NULL),
(457, 2, 1, 'F5', 'booked', NULL),
(458, 2, 1, 'F6', 'booked', NULL),
(459, 2, 1, 'F7', 'booked', NULL),
(460, 2, 1, 'F8', 'booked', NULL),
(461, 2, 1, 'F9', 'booked', NULL),
(462, 2, 1, 'F10', 'booked', NULL),
(463, 2, 2, 'B1', 'booked', NULL),
(464, 2, 2, 'B2', 'booked', NULL),
(465, 2, 2, 'B3', 'booked', NULL),
(466, 2, 2, 'B4', 'booked', NULL),
(467, 2, 2, 'B5', 'booked', NULL),
(468, 2, 2, 'B6', 'available', NULL),
(469, 2, 2, 'B7', 'available', NULL),
(470, 2, 2, 'B8', 'available', NULL),
(471, 2, 2, 'B9', 'available', NULL),
(472, 2, 2, 'B10', 'available', NULL),
(473, 2, 2, 'B11', 'available', NULL),
(474, 2, 2, 'B12', 'available', NULL),
(475, 2, 2, 'B13', 'available', NULL),
(476, 2, 2, 'B14', 'available', NULL),
(477, 2, 2, 'B15', 'booked', NULL),
(478, 2, 2, 'B16', 'available', NULL),
(479, 2, 2, 'B17', 'available', NULL),
(480, 2, 2, 'B18', 'available', NULL),
(481, 2, 2, 'B19', 'available', NULL),
(482, 2, 2, 'B20', 'available', NULL),
(483, 2, 2, 'B21', 'available', NULL),
(484, 2, 2, 'B22', 'booked', NULL),
(485, 2, 2, 'B23', 'booked', NULL),
(486, 2, 2, 'B24', 'available', NULL),
(487, 2, 2, 'B25', 'available', NULL),
(488, 2, 2, 'B26', 'booked', NULL),
(489, 2, 2, 'B27', 'available', NULL),
(490, 2, 2, 'B28', 'available', NULL),
(491, 2, 2, 'B29', 'available', NULL),
(492, 2, 2, 'B30', 'available', NULL),
(493, 2, 3, 'P1', 'available', NULL),
(494, 2, 3, 'P2', 'available', NULL),
(495, 2, 3, 'P3', 'available', NULL),
(496, 2, 3, 'P4', 'available', NULL),
(497, 2, 3, 'P5', 'available', NULL),
(498, 2, 3, 'P6', 'available', NULL),
(499, 2, 3, 'P7', 'available', NULL),
(500, 2, 3, 'P8', 'available', NULL),
(501, 2, 3, 'P9', 'available', NULL),
(502, 2, 3, 'P10', 'available', NULL),
(503, 2, 3, 'P11', 'available', NULL),
(504, 2, 3, 'P12', 'available', NULL),
(505, 2, 3, 'P13', 'available', NULL),
(506, 2, 3, 'P14', 'available', NULL),
(507, 2, 3, 'P15', 'available', NULL),
(508, 2, 3, 'P16', 'available', NULL),
(509, 2, 3, 'P17', 'available', NULL),
(510, 2, 3, 'P18', 'available', NULL),
(511, 2, 3, 'P19', 'available', NULL),
(512, 2, 3, 'P20', 'available', NULL),
(513, 2, 3, 'P21', 'available', NULL),
(514, 2, 3, 'P22', 'available', NULL),
(515, 2, 3, 'P23', 'available', NULL),
(516, 2, 3, 'P24', 'available', NULL),
(517, 2, 3, 'P25', 'available', NULL),
(518, 2, 3, 'P26', 'available', NULL),
(519, 2, 3, 'P27', 'available', NULL),
(520, 2, 3, 'P28', 'available', NULL),
(521, 2, 3, 'P29', 'available', NULL),
(522, 2, 3, 'P30', 'available', NULL),
(523, 2, 3, 'P31', 'available', NULL),
(524, 2, 3, 'P32', 'available', NULL),
(525, 2, 3, 'P33', 'available', NULL),
(526, 2, 3, 'P34', 'available', NULL),
(527, 2, 3, 'P35', 'available', NULL),
(528, 2, 3, 'P36', 'available', NULL),
(529, 2, 3, 'P37', 'available', NULL),
(530, 2, 3, 'P38', 'available', NULL),
(531, 2, 3, 'P39', 'available', NULL),
(532, 2, 3, 'P40', 'available', NULL),
(533, 2, 3, 'P41', 'available', NULL),
(534, 2, 3, 'P42', 'available', NULL),
(535, 2, 3, 'P43', 'available', NULL),
(536, 2, 3, 'P44', 'available', NULL),
(537, 2, 3, 'P45', 'available', NULL),
(538, 2, 3, 'P46', 'booked', NULL),
(539, 2, 3, 'P47', 'booked', NULL),
(540, 2, 3, 'P48', 'available', NULL),
(541, 2, 3, 'P49', 'available', NULL),
(542, 2, 3, 'P50', 'available', NULL),
(543, 2, 4, 'E1', 'booked', NULL),
(544, 2, 4, 'E2', 'available', NULL),
(545, 2, 4, 'E3', 'available', NULL),
(546, 2, 4, 'E4', 'available', NULL),
(547, 2, 4, 'E5', 'available', NULL),
(548, 2, 4, 'E6', 'available', NULL),
(549, 2, 4, 'E7', 'available', NULL),
(550, 2, 4, 'E8', 'available', NULL),
(551, 2, 4, 'E9', 'available', NULL),
(552, 2, 4, 'E10', 'available', NULL),
(553, 2, 4, 'E11', 'available', NULL),
(554, 2, 4, 'E12', 'available', NULL),
(555, 2, 4, 'E13', 'available', NULL),
(556, 2, 4, 'E14', 'available', NULL),
(557, 2, 4, 'E15', 'available', NULL),
(558, 2, 4, 'E16', 'available', NULL),
(559, 2, 4, 'E17', 'available', NULL),
(560, 2, 4, 'E18', 'available', NULL),
(561, 2, 4, 'E19', 'available', NULL),
(562, 2, 4, 'E20', 'available', NULL),
(563, 2, 4, 'E21', 'available', NULL),
(564, 2, 4, 'E22', 'available', NULL),
(565, 2, 4, 'E23', 'available', NULL),
(566, 2, 4, 'E24', 'available', NULL),
(567, 2, 4, 'E25', 'available', NULL),
(568, 2, 4, 'E26', 'available', NULL),
(569, 2, 4, 'E27', 'available', NULL),
(570, 2, 4, 'E28', 'available', NULL),
(571, 2, 4, 'E29', 'available', NULL),
(572, 2, 4, 'E30', 'available', NULL),
(573, 2, 4, 'E31', 'available', NULL),
(574, 2, 4, 'E32', 'available', NULL),
(575, 2, 4, 'E33', 'available', NULL),
(576, 2, 4, 'E34', 'available', NULL),
(577, 2, 4, 'E35', 'available', NULL),
(578, 2, 4, 'E36', 'available', NULL),
(579, 2, 4, 'E37', 'available', NULL),
(580, 2, 4, 'E38', 'available', NULL),
(581, 2, 4, 'E39', 'available', NULL),
(582, 2, 4, 'E40', 'available', NULL),
(583, 2, 4, 'E41', 'available', NULL),
(584, 2, 4, 'E42', 'available', NULL),
(585, 2, 4, 'E43', 'available', NULL),
(586, 2, 4, 'E44', 'available', NULL),
(587, 2, 4, 'E45', 'available', NULL),
(588, 2, 4, 'E46', 'available', NULL),
(589, 2, 4, 'E47', 'available', NULL),
(590, 2, 4, 'E48', 'available', NULL),
(591, 2, 4, 'E49', 'available', NULL),
(592, 2, 4, 'E50', 'available', NULL),
(593, 2, 4, 'E51', 'available', NULL),
(594, 2, 4, 'E52', 'available', NULL),
(595, 2, 4, 'E53', 'available', NULL),
(596, 2, 4, 'E54', 'available', NULL),
(597, 2, 4, 'E55', 'available', NULL),
(598, 2, 4, 'E56', 'booked', NULL),
(599, 2, 4, 'E57', 'booked', NULL),
(600, 2, 4, 'E58', 'available', NULL),
(601, 2, 4, 'E59', 'available', NULL),
(602, 2, 4, 'E60', 'available', NULL),
(603, 4, 1, 'F1', 'available', NULL),
(604, 4, 1, 'F2', 'available', NULL),
(605, 4, 1, 'F3', 'available', NULL),
(606, 4, 1, 'F4', 'available', NULL),
(607, 4, 1, 'F5', 'available', NULL),
(608, 4, 1, 'F6', 'available', NULL),
(609, 4, 1, 'F7', 'available', NULL),
(610, 4, 1, 'F8', 'available', NULL),
(611, 4, 1, 'F9', 'available', NULL),
(612, 4, 1, 'F10', 'available', NULL),
(613, 4, 2, 'B1', 'booked', NULL),
(614, 4, 2, 'B2', 'available', NULL),
(615, 4, 2, 'B3', 'available', NULL),
(616, 4, 2, 'B4', 'available', NULL),
(617, 4, 2, 'B5', 'available', NULL),
(618, 4, 2, 'B6', 'available', NULL),
(619, 4, 2, 'B7', 'available', NULL),
(620, 4, 2, 'B8', 'available', NULL),
(621, 4, 2, 'B9', 'available', NULL),
(622, 4, 2, 'B10', 'available', NULL),
(623, 4, 2, 'B11', 'available', NULL),
(624, 4, 2, 'B12', 'available', NULL),
(625, 4, 2, 'B13', 'available', NULL),
(626, 4, 2, 'B14', 'available', NULL),
(627, 4, 2, 'B15', 'available', NULL),
(628, 4, 2, 'B16', 'available', NULL),
(629, 4, 2, 'B17', 'available', NULL),
(630, 4, 2, 'B18', 'available', NULL),
(631, 4, 2, 'B19', 'available', NULL),
(632, 4, 2, 'B20', 'available', NULL),
(633, 4, 2, 'B21', 'available', NULL),
(634, 4, 2, 'B22', 'available', NULL),
(635, 4, 2, 'B23', 'available', NULL),
(636, 4, 2, 'B24', 'available', NULL),
(637, 4, 2, 'B25', 'available', NULL),
(638, 4, 2, 'B26', 'available', NULL),
(639, 4, 2, 'B27', 'booked', NULL),
(640, 4, 2, 'B28', 'booked', NULL),
(641, 4, 2, 'B29', 'available', NULL),
(642, 4, 2, 'B30', 'available', NULL),
(643, 4, 3, 'P1', 'available', NULL),
(644, 4, 3, 'P2', 'available', NULL),
(645, 4, 3, 'P3', 'available', NULL),
(646, 4, 3, 'P4', 'available', NULL),
(647, 4, 3, 'P5', 'available', NULL),
(648, 4, 3, 'P6', 'available', NULL),
(649, 4, 3, 'P7', 'available', NULL),
(650, 4, 3, 'P8', 'available', NULL),
(651, 4, 3, 'P9', 'available', NULL),
(652, 4, 3, 'P10', 'available', NULL),
(653, 4, 3, 'P11', 'available', NULL),
(654, 4, 3, 'P12', 'available', NULL),
(655, 4, 3, 'P13', 'available', NULL),
(656, 4, 3, 'P14', 'available', NULL),
(657, 4, 3, 'P15', 'available', NULL),
(658, 4, 3, 'P16', 'available', NULL),
(659, 4, 3, 'P17', 'available', NULL),
(660, 4, 3, 'P18', 'available', NULL),
(661, 4, 3, 'P19', 'available', NULL),
(662, 4, 3, 'P20', 'available', NULL),
(663, 4, 3, 'P21', 'available', NULL),
(664, 4, 3, 'P22', 'available', NULL),
(665, 4, 3, 'P23', 'available', NULL),
(666, 4, 3, 'P24', 'available', NULL),
(667, 4, 3, 'P25', 'available', NULL),
(668, 4, 3, 'P26', 'available', NULL),
(669, 4, 3, 'P27', 'available', NULL),
(670, 4, 3, 'P28', 'available', NULL),
(671, 4, 3, 'P29', 'available', NULL),
(672, 4, 3, 'P30', 'available', NULL),
(673, 4, 3, 'P31', 'available', NULL),
(674, 4, 3, 'P32', 'available', NULL),
(675, 4, 3, 'P33', 'available', NULL),
(676, 4, 3, 'P34', 'available', NULL),
(677, 4, 3, 'P35', 'available', NULL),
(678, 4, 3, 'P36', 'available', NULL),
(679, 4, 3, 'P37', 'available', NULL),
(680, 4, 3, 'P38', 'available', NULL),
(681, 4, 3, 'P39', 'available', NULL),
(682, 4, 3, 'P40', 'available', NULL),
(683, 4, 3, 'P41', 'available', NULL),
(684, 4, 3, 'P42', 'available', NULL),
(685, 4, 3, 'P43', 'available', NULL),
(686, 4, 3, 'P44', 'available', NULL),
(687, 4, 3, 'P45', 'available', NULL),
(688, 4, 3, 'P46', 'available', NULL),
(689, 4, 3, 'P47', 'available', NULL),
(690, 4, 3, 'P48', 'available', NULL),
(691, 4, 3, 'P49', 'available', NULL),
(692, 4, 3, 'P50', 'available', NULL),
(693, 4, 4, 'E1', 'available', NULL),
(694, 4, 4, 'E2', 'available', NULL),
(695, 4, 4, 'E3', 'available', NULL),
(696, 4, 4, 'E4', 'available', NULL),
(697, 4, 4, 'E5', 'available', NULL),
(698, 4, 4, 'E6', 'available', NULL),
(699, 4, 4, 'E7', 'available', NULL),
(700, 4, 4, 'E8', 'available', NULL),
(701, 4, 4, 'E9', 'available', NULL),
(702, 4, 4, 'E10', 'available', NULL),
(703, 4, 4, 'E11', 'available', NULL),
(704, 4, 4, 'E12', 'available', NULL),
(705, 4, 4, 'E13', 'available', NULL),
(706, 4, 4, 'E14', 'available', NULL),
(707, 4, 4, 'E15', 'available', NULL),
(708, 4, 4, 'E16', 'available', NULL),
(709, 4, 4, 'E17', 'available', NULL),
(710, 4, 4, 'E18', 'available', NULL),
(711, 4, 4, 'E19', 'available', NULL),
(712, 4, 4, 'E20', 'available', NULL),
(713, 4, 4, 'E21', 'available', NULL),
(714, 4, 4, 'E22', 'available', NULL),
(715, 4, 4, 'E23', 'available', NULL),
(716, 4, 4, 'E24', 'available', NULL),
(717, 4, 4, 'E25', 'available', NULL),
(718, 4, 4, 'E26', 'available', NULL),
(719, 4, 4, 'E27', 'available', NULL),
(720, 4, 4, 'E28', 'available', NULL),
(721, 4, 4, 'E29', 'available', NULL),
(722, 4, 4, 'E30', 'available', NULL),
(723, 4, 4, 'E31', 'available', NULL),
(724, 4, 4, 'E32', 'available', NULL),
(725, 4, 4, 'E33', 'available', NULL),
(726, 4, 4, 'E34', 'available', NULL),
(727, 4, 4, 'E35', 'available', NULL),
(728, 4, 4, 'E36', 'available', NULL),
(729, 4, 4, 'E37', 'available', NULL),
(730, 4, 4, 'E38', 'available', NULL),
(731, 4, 4, 'E39', 'available', NULL),
(732, 4, 4, 'E40', 'available', NULL),
(733, 4, 4, 'E41', 'available', NULL),
(734, 4, 4, 'E42', 'available', NULL),
(735, 4, 4, 'E43', 'available', NULL),
(736, 4, 4, 'E44', 'available', NULL),
(737, 4, 4, 'E45', 'available', NULL),
(738, 4, 4, 'E46', 'available', NULL),
(739, 4, 4, 'E47', 'available', NULL),
(740, 4, 4, 'E48', 'available', NULL),
(741, 4, 4, 'E49', 'available', NULL),
(742, 4, 4, 'E50', 'available', NULL),
(743, 4, 4, 'E51', 'available', NULL),
(744, 4, 4, 'E52', 'available', NULL),
(745, 4, 4, 'E53', 'available', NULL),
(746, 4, 4, 'E54', 'available', NULL),
(747, 4, 4, 'E55', 'available', NULL),
(748, 4, 4, 'E56', 'available', NULL),
(749, 4, 4, 'E57', 'available', NULL),
(750, 4, 4, 'E58', 'available', NULL),
(751, 4, 4, 'E59', 'available', NULL),
(752, 4, 4, 'E60', 'available', NULL),
(755, 5, 1, 'F1', 'available', NULL),
(756, 5, 1, 'F2', 'available', NULL),
(757, 5, 1, 'F3', 'available', NULL),
(758, 5, 1, 'F4', 'available', NULL),
(759, 5, 1, 'F5', 'available', NULL),
(760, 5, 1, 'F6', 'available', NULL),
(761, 5, 1, 'F7', 'available', NULL),
(762, 5, 1, 'F8', 'available', NULL),
(763, 5, 1, 'F9', 'available', NULL),
(764, 5, 1, 'F10', 'available', NULL),
(765, 5, 2, 'B1', 'available', NULL),
(766, 5, 2, 'B2', 'available', NULL),
(767, 5, 2, 'B3', 'available', NULL),
(768, 5, 2, 'B4', 'available', NULL),
(769, 5, 2, 'B5', 'available', NULL),
(770, 5, 2, 'B6', 'available', NULL),
(771, 5, 2, 'B7', 'available', NULL),
(772, 5, 2, 'B8', 'available', NULL),
(773, 5, 2, 'B9', 'available', NULL),
(774, 5, 2, 'B10', 'available', NULL),
(775, 5, 2, 'B11', 'available', NULL),
(776, 5, 2, 'B12', 'available', NULL),
(777, 5, 2, 'B13', 'available', NULL),
(778, 5, 2, 'B14', 'available', NULL),
(779, 5, 2, 'B15', 'available', NULL),
(780, 5, 2, 'B16', 'available', NULL),
(781, 5, 2, 'B17', 'available', NULL),
(782, 5, 2, 'B18', 'available', NULL),
(783, 5, 2, 'B19', 'available', NULL),
(784, 5, 2, 'B20', 'available', NULL),
(785, 5, 2, 'B21', 'available', NULL),
(786, 5, 2, 'B22', 'available', NULL),
(787, 5, 2, 'B23', 'available', NULL),
(788, 5, 2, 'B24', 'available', NULL),
(789, 5, 2, 'B25', 'available', NULL),
(790, 5, 2, 'B26', 'available', NULL),
(791, 5, 2, 'B27', 'available', NULL),
(792, 5, 2, 'B28', 'available', NULL),
(793, 5, 2, 'B29', 'available', NULL),
(794, 5, 2, 'B30', 'available', NULL),
(795, 5, 3, 'P1', 'available', NULL),
(796, 5, 3, 'P2', 'available', NULL),
(797, 5, 3, 'P3', 'available', NULL),
(798, 5, 3, 'P4', 'available', NULL),
(799, 5, 3, 'P5', 'available', NULL),
(800, 5, 3, 'P6', 'available', NULL),
(801, 5, 3, 'P7', 'available', NULL),
(802, 5, 3, 'P8', 'available', NULL),
(803, 5, 3, 'P9', 'available', NULL),
(804, 5, 3, 'P10', 'available', NULL),
(805, 5, 3, 'P11', 'available', NULL),
(806, 5, 3, 'P12', 'available', NULL),
(807, 5, 3, 'P13', 'available', NULL),
(808, 5, 3, 'P14', 'available', NULL),
(809, 5, 3, 'P15', 'available', NULL),
(810, 5, 3, 'P16', 'available', NULL),
(811, 5, 3, 'P17', 'available', NULL),
(812, 5, 3, 'P18', 'available', NULL),
(813, 5, 3, 'P19', 'available', NULL),
(814, 5, 3, 'P20', 'available', NULL),
(815, 5, 3, 'P21', 'available', NULL),
(816, 5, 3, 'P22', 'available', NULL),
(817, 5, 3, 'P23', 'available', NULL),
(818, 5, 3, 'P24', 'available', NULL),
(819, 5, 3, 'P25', 'available', NULL),
(820, 5, 3, 'P26', 'available', NULL),
(821, 5, 3, 'P27', 'available', NULL),
(822, 5, 3, 'P28', 'available', NULL),
(823, 5, 3, 'P29', 'available', NULL),
(824, 5, 3, 'P30', 'available', NULL),
(825, 5, 3, 'P31', 'available', NULL),
(826, 5, 3, 'P32', 'available', NULL),
(827, 5, 3, 'P33', 'available', NULL),
(828, 5, 3, 'P34', 'available', NULL),
(829, 5, 3, 'P35', 'available', NULL),
(830, 5, 3, 'P36', 'available', NULL),
(831, 5, 3, 'P37', 'available', NULL),
(832, 5, 3, 'P38', 'available', NULL),
(833, 5, 3, 'P39', 'available', NULL),
(834, 5, 3, 'P40', 'available', NULL),
(835, 5, 3, 'P41', 'available', NULL),
(836, 5, 3, 'P42', 'available', NULL),
(837, 5, 3, 'P43', 'available', NULL),
(838, 5, 3, 'P44', 'available', NULL),
(839, 5, 3, 'P45', 'available', NULL),
(840, 5, 3, 'P46', 'available', NULL),
(841, 5, 3, 'P47', 'available', NULL),
(842, 5, 3, 'P48', 'available', NULL),
(843, 5, 3, 'P49', 'available', NULL),
(844, 5, 3, 'P50', 'available', NULL),
(845, 5, 4, 'E1', 'available', NULL),
(846, 5, 4, 'E2', 'available', NULL),
(847, 5, 4, 'E3', 'available', NULL),
(848, 5, 4, 'E4', 'available', NULL),
(849, 5, 4, 'E5', 'available', NULL),
(850, 5, 4, 'E6', 'available', NULL),
(851, 5, 4, 'E7', 'available', NULL),
(852, 5, 4, 'E8', 'available', NULL),
(853, 5, 4, 'E9', 'available', NULL),
(854, 5, 4, 'E10', 'available', NULL),
(855, 5, 4, 'E11', 'available', NULL),
(856, 5, 4, 'E12', 'available', NULL),
(857, 5, 4, 'E13', 'available', NULL),
(858, 5, 4, 'E14', 'available', NULL),
(859, 5, 4, 'E15', 'available', NULL),
(860, 5, 4, 'E16', 'available', NULL),
(861, 5, 4, 'E17', 'available', NULL),
(862, 5, 4, 'E18', 'available', NULL),
(863, 5, 4, 'E19', 'available', NULL),
(864, 5, 4, 'E20', 'available', NULL),
(865, 5, 4, 'E21', 'available', NULL),
(866, 5, 4, 'E22', 'available', NULL),
(867, 5, 4, 'E23', 'available', NULL),
(868, 5, 4, 'E24', 'available', NULL),
(869, 5, 4, 'E25', 'available', NULL),
(870, 5, 4, 'E26', 'available', NULL),
(871, 5, 4, 'E27', 'available', NULL),
(872, 5, 4, 'E28', 'available', NULL),
(873, 5, 4, 'E29', 'available', NULL),
(874, 5, 4, 'E30', 'available', NULL),
(875, 5, 4, 'E31', 'available', NULL),
(876, 5, 4, 'E32', 'available', NULL),
(877, 5, 4, 'E33', 'available', NULL),
(878, 5, 4, 'E34', 'available', NULL),
(879, 5, 4, 'E35', 'available', NULL),
(880, 5, 4, 'E36', 'available', NULL),
(881, 5, 4, 'E37', 'available', NULL),
(882, 5, 4, 'E38', 'available', NULL),
(883, 5, 4, 'E39', 'available', NULL),
(884, 5, 4, 'E40', 'available', NULL),
(885, 5, 4, 'E41', 'available', NULL),
(886, 5, 4, 'E42', 'available', NULL),
(887, 5, 4, 'E43', 'available', NULL),
(888, 5, 4, 'E44', 'available', NULL),
(889, 5, 4, 'E45', 'available', NULL),
(890, 5, 4, 'E46', 'available', NULL),
(891, 5, 4, 'E47', 'available', NULL),
(892, 5, 4, 'E48', 'available', NULL),
(893, 5, 4, 'E49', 'available', NULL),
(894, 5, 4, 'E50', 'available', NULL),
(895, 5, 4, 'E51', 'available', NULL),
(896, 5, 4, 'E52', 'available', NULL),
(897, 5, 4, 'E53', 'available', NULL),
(898, 5, 4, 'E54', 'available', NULL),
(899, 5, 4, 'E55', 'available', NULL),
(900, 5, 4, 'E56', 'available', NULL),
(901, 5, 4, 'E57', 'available', NULL),
(902, 5, 4, 'E58', 'available', NULL),
(903, 5, 4, 'E59', 'available', NULL),
(904, 5, 4, 'E60', 'available', NULL);

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
(7, 'yumi', 'yumi@gmail.com', '$2y$10$624QCrhZr/aUb9M7A8O6QemcRuebevCpav47xWucT8d6iXkWLpfAq', NULL, '../userPhoto/download.jfif'),
(8, 'nora', 'nora@gmail.com', '$2y$10$ksnIcwgmMJT2/iHp1GnMO.81Qu8fVq9q80vuMP9a7AwPNVbiTpD1.', NULL, '../userPhoto/photo_2024-01-07_17-04-55.jpg'),
(9, 'Emma', 'emma@gmail.com', '$2y$10$oRFV38ZIColJW4obfMkv4u4da7Oc8W22qD/AoAjrrW6Q444wVVo4m', NULL, '../userPhoto/d7ca1bbb-d965-4630-b386-0598a38917d1.jpg'),
(11, 'Phoo Nge', 'phoonge@gmail.com', '$2y$10$ud8MojGtInBQOjtJcU1VXORnI038poy3y5.RMoNQW7S7z3RvJ6Gdi', NULL, '../userPhoto/dog.jpg'),
(12, 'maymon', 'maymon@gmail.com', '$2y$10$CClct0GlCvdHtyFo7rBWCu3VSwuEkdRSoyGQJuS.z6tBAK6MD20iO', NULL, '../userPhoto/dog.jpg'),
(14, 'nwaythu', 'nwaythu@gmail.com', '$2y$10$I2n.1PaeZEbogs4ioBeYfuDgiUNkWvaO2fF/16K0bSsjSrkuBLkoS', NULL, '../userPhoto/'),
(15, 'swarsi', 'swarsi@gmail.com', '$2y$10$/IE6X9BWou3WLYPwSjm2p.tdMVfp6kFw7GEU9SGD.pCZlp4kKhosi', NULL, '../userPhoto/'),
(16, 'Nyi Say', 'nyisay@gmail.com', '$2y$10$WSRS7lMuFwRc5LNLr3MsTeryBxxRcTeFFqvqURGCRhw3CliwEfg02', NULL, '../userPhoto/');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `wishListId` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `flightclasses_id` int(11) DEFAULT NULL,
  `created_at` date DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`wishListId`, `user_id`, `flightclasses_id`, `created_at`) VALUES
(22, 7, 1, '2025-01-20'),
(23, 7, 2, '2025-01-20'),
(44, 9, 11, '2025-01-21'),
(45, 9, 13, '2025-01-21'),
(46, 9, 9, '2025-01-21'),
(47, 9, 8, '2025-01-21'),
(48, 9, 7, '2025-01-21'),
(49, 9, 7, '2025-01-21'),
(50, 9, 11, '2025-01-21'),
(51, 9, 24, '2025-01-21');

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
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `FK_flightbook` (`flight_id`),
  ADD KEY `FK_seatNobook` (`seatNoId`),
  ADD KEY `FK_classbook` (`class_id`),
  ADD KEY `FK_passengerbook` (`passenger_id`),
  ADD KEY `FK_userBook` (`user_id`),
  ADD KEY `FK_payBook` (`payment_id`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`class_id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`contact_id`),
  ADD KEY `FK_userContact` (`user_id`);

--
-- Indexes for table `discount`
--
ALTER TABLE `discount`
  ADD PRIMARY KEY (`discount_id`);

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
  ADD KEY `FK_paymenttype` (`paymentType`);

--
-- Indexes for table `paymenttype`
--
ALTER TABLE `paymenttype`
  ADD PRIMARY KEY (`typeID`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `seat_layout`
--
ALTER TABLE `seat_layout`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_flightseat` (`flight_id`),
  ADD KEY `FK_seatclass` (`class_id`);

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
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`wishListId`),
  ADD KEY `FK_wishflight` (`flightclasses_id`),
  ADD KEY `FK_userwish` (`user_id`);

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
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `class_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `contact_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `discount`
--
ALTER TABLE `discount`
  MODIFY `discount_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `flight`
--
ALTER TABLE `flight`
  MODIFY `flight_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `flightclasses`
--
ALTER TABLE `flightclasses`
  MODIFY `flightclasses_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `passengers`
--
ALTER TABLE `passengers`
  MODIFY `passenger_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=127;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `paymentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `paymenttype`
--
ALTER TABLE `paymenttype`
  MODIFY `typeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `seat_layout`
--
ALTER TABLE `seat_layout`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=905;

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
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `wishListId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `FK_classbook` FOREIGN KEY (`class_id`) REFERENCES `classes` (`class_id`),
  ADD CONSTRAINT `FK_flightbook` FOREIGN KEY (`flight_id`) REFERENCES `flight` (`flight_id`),
  ADD CONSTRAINT `FK_passengerbook` FOREIGN KEY (`passenger_id`) REFERENCES `passengers` (`passenger_id`),
  ADD CONSTRAINT `FK_payBook` FOREIGN KEY (`payment_id`) REFERENCES `payment` (`paymentID`),
  ADD CONSTRAINT `FK_seatNobook` FOREIGN KEY (`seatNoId`) REFERENCES `seat_layout` (`id`),
  ADD CONSTRAINT `FK_userBook` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `contact`
--
ALTER TABLE `contact`
  ADD CONSTRAINT `FK_userContact` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

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
  ADD CONSTRAINT `FK_paymenttype` FOREIGN KEY (`paymentType`) REFERENCES `paymenttype` (`typeID`);

--
-- Constraints for table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `seat_layout`
--
ALTER TABLE `seat_layout`
  ADD CONSTRAINT `FK_flightseat` FOREIGN KEY (`flight_id`) REFERENCES `flight` (`flight_id`),
  ADD CONSTRAINT `FK_seatclass` FOREIGN KEY (`class_id`) REFERENCES `classes` (`class_id`);

--
-- Constraints for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `FK_userwish` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `FK_wishflight` FOREIGN KEY (`flightclasses_id`) REFERENCES `flightclasses` (`flightclasses_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
