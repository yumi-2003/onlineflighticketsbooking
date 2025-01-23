-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 23, 2025 at 05:56 AM
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
(2, 'Myanmar National Airways                                                            ', '../flightImg/MNA.webp'),
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
(104, 8, 2, 2, 2, 467, '2025-01-23', 119, 'confirm', '2025-01-23', 71);

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
(119, 'Nway thu', 19, 'Female', 'Myanmar', '09786993707', 'brvrv4', '3fc34c');

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
(71, '3232', '2424', '2025-02-08', 1, 'nway', 1380.00, '2025-01-23');

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
  `status` enum('available','booked','reserved') DEFAULT 'available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seat_layout`
--

INSERT INTO `seat_layout` (`id`, `flight_id`, `class_id`, `seatNo`, `status`) VALUES
(453, 2, 1, 'F1', 'booked'),
(454, 2, 1, 'F2', 'booked'),
(455, 2, 1, 'F3', 'booked'),
(456, 2, 1, 'F4', 'booked'),
(457, 2, 1, 'F5', 'booked'),
(458, 2, 1, 'F6', 'booked'),
(459, 2, 1, 'F7', 'booked'),
(460, 2, 1, 'F8', 'booked'),
(461, 2, 1, 'F9', 'booked'),
(462, 2, 1, 'F10', 'booked'),
(463, 2, 2, 'B1', 'booked'),
(464, 2, 2, 'B2', 'booked'),
(465, 2, 2, 'B3', 'booked'),
(466, 2, 2, 'B4', 'booked'),
(467, 2, 2, 'B5', 'booked'),
(468, 2, 2, 'B6', 'available'),
(469, 2, 2, 'B7', 'available'),
(470, 2, 2, 'B8', 'available'),
(471, 2, 2, 'B9', 'available'),
(472, 2, 2, 'B10', 'available'),
(473, 2, 2, 'B11', 'available'),
(474, 2, 2, 'B12', 'available'),
(475, 2, 2, 'B13', 'available'),
(476, 2, 2, 'B14', 'available'),
(477, 2, 2, 'B15', 'booked'),
(478, 2, 2, 'B16', 'available'),
(479, 2, 2, 'B17', 'available'),
(480, 2, 2, 'B18', 'available'),
(481, 2, 2, 'B19', 'available'),
(482, 2, 2, 'B20', 'available'),
(483, 2, 2, 'B21', 'available'),
(484, 2, 2, 'B22', 'booked'),
(485, 2, 2, 'B23', 'booked'),
(486, 2, 2, 'B24', 'available'),
(487, 2, 2, 'B25', 'available'),
(488, 2, 2, 'B26', 'booked'),
(489, 2, 2, 'B27', 'available'),
(490, 2, 2, 'B28', 'available'),
(491, 2, 2, 'B29', 'available'),
(492, 2, 2, 'B30', 'available'),
(493, 2, 3, 'P1', 'available'),
(494, 2, 3, 'P2', 'available'),
(495, 2, 3, 'P3', 'available'),
(496, 2, 3, 'P4', 'available'),
(497, 2, 3, 'P5', 'available'),
(498, 2, 3, 'P6', 'available'),
(499, 2, 3, 'P7', 'available'),
(500, 2, 3, 'P8', 'available'),
(501, 2, 3, 'P9', 'available'),
(502, 2, 3, 'P10', 'available'),
(503, 2, 3, 'P11', 'available'),
(504, 2, 3, 'P12', 'available'),
(505, 2, 3, 'P13', 'available'),
(506, 2, 3, 'P14', 'available'),
(507, 2, 3, 'P15', 'available'),
(508, 2, 3, 'P16', 'available'),
(509, 2, 3, 'P17', 'available'),
(510, 2, 3, 'P18', 'available'),
(511, 2, 3, 'P19', 'available'),
(512, 2, 3, 'P20', 'available'),
(513, 2, 3, 'P21', 'available'),
(514, 2, 3, 'P22', 'available'),
(515, 2, 3, 'P23', 'available'),
(516, 2, 3, 'P24', 'available'),
(517, 2, 3, 'P25', 'available'),
(518, 2, 3, 'P26', 'available'),
(519, 2, 3, 'P27', 'available'),
(520, 2, 3, 'P28', 'available'),
(521, 2, 3, 'P29', 'available'),
(522, 2, 3, 'P30', 'available'),
(523, 2, 3, 'P31', 'available'),
(524, 2, 3, 'P32', 'available'),
(525, 2, 3, 'P33', 'available'),
(526, 2, 3, 'P34', 'available'),
(527, 2, 3, 'P35', 'available'),
(528, 2, 3, 'P36', 'available'),
(529, 2, 3, 'P37', 'available'),
(530, 2, 3, 'P38', 'available'),
(531, 2, 3, 'P39', 'available'),
(532, 2, 3, 'P40', 'available'),
(533, 2, 3, 'P41', 'available'),
(534, 2, 3, 'P42', 'available'),
(535, 2, 3, 'P43', 'available'),
(536, 2, 3, 'P44', 'available'),
(537, 2, 3, 'P45', 'available'),
(538, 2, 3, 'P46', 'booked'),
(539, 2, 3, 'P47', 'booked'),
(540, 2, 3, 'P48', 'available'),
(541, 2, 3, 'P49', 'available'),
(542, 2, 3, 'P50', 'available'),
(543, 2, 4, 'E1', 'booked'),
(544, 2, 4, 'E2', 'available'),
(545, 2, 4, 'E3', 'available'),
(546, 2, 4, 'E4', 'available'),
(547, 2, 4, 'E5', 'available'),
(548, 2, 4, 'E6', 'available'),
(549, 2, 4, 'E7', 'available'),
(550, 2, 4, 'E8', 'available'),
(551, 2, 4, 'E9', 'available'),
(552, 2, 4, 'E10', 'available'),
(553, 2, 4, 'E11', 'available'),
(554, 2, 4, 'E12', 'available'),
(555, 2, 4, 'E13', 'available'),
(556, 2, 4, 'E14', 'available'),
(557, 2, 4, 'E15', 'available'),
(558, 2, 4, 'E16', 'available'),
(559, 2, 4, 'E17', 'available'),
(560, 2, 4, 'E18', 'available'),
(561, 2, 4, 'E19', 'available'),
(562, 2, 4, 'E20', 'available'),
(563, 2, 4, 'E21', 'available'),
(564, 2, 4, 'E22', 'available'),
(565, 2, 4, 'E23', 'available'),
(566, 2, 4, 'E24', 'available'),
(567, 2, 4, 'E25', 'available'),
(568, 2, 4, 'E26', 'available'),
(569, 2, 4, 'E27', 'available'),
(570, 2, 4, 'E28', 'available'),
(571, 2, 4, 'E29', 'available'),
(572, 2, 4, 'E30', 'available'),
(573, 2, 4, 'E31', 'available'),
(574, 2, 4, 'E32', 'available'),
(575, 2, 4, 'E33', 'available'),
(576, 2, 4, 'E34', 'available'),
(577, 2, 4, 'E35', 'available'),
(578, 2, 4, 'E36', 'available'),
(579, 2, 4, 'E37', 'available'),
(580, 2, 4, 'E38', 'available'),
(581, 2, 4, 'E39', 'available'),
(582, 2, 4, 'E40', 'available'),
(583, 2, 4, 'E41', 'available'),
(584, 2, 4, 'E42', 'available'),
(585, 2, 4, 'E43', 'available'),
(586, 2, 4, 'E44', 'available'),
(587, 2, 4, 'E45', 'available'),
(588, 2, 4, 'E46', 'available'),
(589, 2, 4, 'E47', 'available'),
(590, 2, 4, 'E48', 'available'),
(591, 2, 4, 'E49', 'available'),
(592, 2, 4, 'E50', 'available'),
(593, 2, 4, 'E51', 'available'),
(594, 2, 4, 'E52', 'available'),
(595, 2, 4, 'E53', 'available'),
(596, 2, 4, 'E54', 'available'),
(597, 2, 4, 'E55', 'available'),
(598, 2, 4, 'E56', 'booked'),
(599, 2, 4, 'E57', 'booked'),
(600, 2, 4, 'E58', 'available'),
(601, 2, 4, 'E59', 'available'),
(602, 2, 4, 'E60', 'available'),
(603, 4, 1, 'F1', 'available'),
(604, 4, 1, 'F2', 'available'),
(605, 4, 1, 'F3', 'available'),
(606, 4, 1, 'F4', 'available'),
(607, 4, 1, 'F5', 'available'),
(608, 4, 1, 'F6', 'available'),
(609, 4, 1, 'F7', 'available'),
(610, 4, 1, 'F8', 'available'),
(611, 4, 1, 'F9', 'available'),
(612, 4, 1, 'F10', 'available'),
(613, 4, 2, 'B1', 'booked'),
(614, 4, 2, 'B2', 'available'),
(615, 4, 2, 'B3', 'available'),
(616, 4, 2, 'B4', 'available'),
(617, 4, 2, 'B5', 'available'),
(618, 4, 2, 'B6', 'available'),
(619, 4, 2, 'B7', 'available'),
(620, 4, 2, 'B8', 'available'),
(621, 4, 2, 'B9', 'available'),
(622, 4, 2, 'B10', 'available'),
(623, 4, 2, 'B11', 'available'),
(624, 4, 2, 'B12', 'available'),
(625, 4, 2, 'B13', 'available'),
(626, 4, 2, 'B14', 'available'),
(627, 4, 2, 'B15', 'available'),
(628, 4, 2, 'B16', 'available'),
(629, 4, 2, 'B17', 'available'),
(630, 4, 2, 'B18', 'available'),
(631, 4, 2, 'B19', 'available'),
(632, 4, 2, 'B20', 'available'),
(633, 4, 2, 'B21', 'available'),
(634, 4, 2, 'B22', 'available'),
(635, 4, 2, 'B23', 'available'),
(636, 4, 2, 'B24', 'available'),
(637, 4, 2, 'B25', 'available'),
(638, 4, 2, 'B26', 'available'),
(639, 4, 2, 'B27', 'available'),
(640, 4, 2, 'B28', 'available'),
(641, 4, 2, 'B29', 'available'),
(642, 4, 2, 'B30', 'available'),
(643, 4, 3, 'P1', 'available'),
(644, 4, 3, 'P2', 'available'),
(645, 4, 3, 'P3', 'available'),
(646, 4, 3, 'P4', 'available'),
(647, 4, 3, 'P5', 'available'),
(648, 4, 3, 'P6', 'available'),
(649, 4, 3, 'P7', 'available'),
(650, 4, 3, 'P8', 'available'),
(651, 4, 3, 'P9', 'available'),
(652, 4, 3, 'P10', 'available'),
(653, 4, 3, 'P11', 'available'),
(654, 4, 3, 'P12', 'available'),
(655, 4, 3, 'P13', 'available'),
(656, 4, 3, 'P14', 'available'),
(657, 4, 3, 'P15', 'available'),
(658, 4, 3, 'P16', 'available'),
(659, 4, 3, 'P17', 'available'),
(660, 4, 3, 'P18', 'available'),
(661, 4, 3, 'P19', 'available'),
(662, 4, 3, 'P20', 'available'),
(663, 4, 3, 'P21', 'available'),
(664, 4, 3, 'P22', 'available'),
(665, 4, 3, 'P23', 'available'),
(666, 4, 3, 'P24', 'available'),
(667, 4, 3, 'P25', 'available'),
(668, 4, 3, 'P26', 'available'),
(669, 4, 3, 'P27', 'available'),
(670, 4, 3, 'P28', 'available'),
(671, 4, 3, 'P29', 'available'),
(672, 4, 3, 'P30', 'available'),
(673, 4, 3, 'P31', 'available'),
(674, 4, 3, 'P32', 'available'),
(675, 4, 3, 'P33', 'available'),
(676, 4, 3, 'P34', 'available'),
(677, 4, 3, 'P35', 'available'),
(678, 4, 3, 'P36', 'available'),
(679, 4, 3, 'P37', 'available'),
(680, 4, 3, 'P38', 'available'),
(681, 4, 3, 'P39', 'available'),
(682, 4, 3, 'P40', 'available'),
(683, 4, 3, 'P41', 'available'),
(684, 4, 3, 'P42', 'available'),
(685, 4, 3, 'P43', 'available'),
(686, 4, 3, 'P44', 'available'),
(687, 4, 3, 'P45', 'available'),
(688, 4, 3, 'P46', 'available'),
(689, 4, 3, 'P47', 'available'),
(690, 4, 3, 'P48', 'available'),
(691, 4, 3, 'P49', 'available'),
(692, 4, 3, 'P50', 'available'),
(693, 4, 4, 'E1', 'available'),
(694, 4, 4, 'E2', 'available'),
(695, 4, 4, 'E3', 'available'),
(696, 4, 4, 'E4', 'available'),
(697, 4, 4, 'E5', 'available'),
(698, 4, 4, 'E6', 'available'),
(699, 4, 4, 'E7', 'available'),
(700, 4, 4, 'E8', 'available'),
(701, 4, 4, 'E9', 'available'),
(702, 4, 4, 'E10', 'available'),
(703, 4, 4, 'E11', 'available'),
(704, 4, 4, 'E12', 'available'),
(705, 4, 4, 'E13', 'available'),
(706, 4, 4, 'E14', 'available'),
(707, 4, 4, 'E15', 'available'),
(708, 4, 4, 'E16', 'available'),
(709, 4, 4, 'E17', 'available'),
(710, 4, 4, 'E18', 'available'),
(711, 4, 4, 'E19', 'available'),
(712, 4, 4, 'E20', 'available'),
(713, 4, 4, 'E21', 'available'),
(714, 4, 4, 'E22', 'available'),
(715, 4, 4, 'E23', 'available'),
(716, 4, 4, 'E24', 'available'),
(717, 4, 4, 'E25', 'available'),
(718, 4, 4, 'E26', 'available'),
(719, 4, 4, 'E27', 'available'),
(720, 4, 4, 'E28', 'available'),
(721, 4, 4, 'E29', 'available'),
(722, 4, 4, 'E30', 'available'),
(723, 4, 4, 'E31', 'available'),
(724, 4, 4, 'E32', 'available'),
(725, 4, 4, 'E33', 'available'),
(726, 4, 4, 'E34', 'available'),
(727, 4, 4, 'E35', 'available'),
(728, 4, 4, 'E36', 'available'),
(729, 4, 4, 'E37', 'available'),
(730, 4, 4, 'E38', 'available'),
(731, 4, 4, 'E39', 'available'),
(732, 4, 4, 'E40', 'available'),
(733, 4, 4, 'E41', 'available'),
(734, 4, 4, 'E42', 'available'),
(735, 4, 4, 'E43', 'available'),
(736, 4, 4, 'E44', 'available'),
(737, 4, 4, 'E45', 'available'),
(738, 4, 4, 'E46', 'available'),
(739, 4, 4, 'E47', 'available'),
(740, 4, 4, 'E48', 'available'),
(741, 4, 4, 'E49', 'available'),
(742, 4, 4, 'E50', 'available'),
(743, 4, 4, 'E51', 'available'),
(744, 4, 4, 'E52', 'available'),
(745, 4, 4, 'E53', 'available'),
(746, 4, 4, 'E54', 'available'),
(747, 4, 4, 'E55', 'available'),
(748, 4, 4, 'E56', 'available'),
(749, 4, 4, 'E57', 'available'),
(750, 4, 4, 'E58', 'available'),
(751, 4, 4, 'E59', 'available'),
(752, 4, 4, 'E60', 'available');

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
(8, 'nora', 'nora@gmail.com', '$2y$10$ksnIcwgmMJT2/iHp1GnMO.81Qu8fVq9q80vuMP9a7AwPNVbiTpD1.', NULL, '../userPhoto/'),
(9, 'Emma', 'emma@gmail.com', '$2y$10$oRFV38ZIColJW4obfMkv4u4da7Oc8W22qD/AoAjrrW6Q444wVVo4m', NULL, '../userPhoto/d7ca1bbb-d965-4630-b386-0598a38917d1.jpg'),
(11, 'Phoo Nge', 'phoonge@gmail.com', '$2y$10$ud8MojGtInBQOjtJcU1VXORnI038poy3y5.RMoNQW7S7z3RvJ6Gdi', NULL, '../userPhoto/dog.jpg'),
(12, 'maymon', 'maymon@gmail.com', '$2y$10$CClct0GlCvdHtyFo7rBWCu3VSwuEkdRSoyGQJuS.z6tBAK6MD20iO', NULL, '../userPhoto/dog.jpg'),
(14, 'nwaythu', 'nwaythu@gmail.com', '$2y$10$I2n.1PaeZEbogs4ioBeYfuDgiUNkWvaO2fF/16K0bSsjSrkuBLkoS', NULL, '../userPhoto/'),
(15, 'swarsi', 'swarsi@gmail.com', '$2y$10$/IE6X9BWou3WLYPwSjm2p.tdMVfp6kFw7GEU9SGD.pCZlp4kKhosi', NULL, '../userPhoto/');

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
(24, 15, 5, '2025-01-20'),
(25, 15, 11, '2025-01-20'),
(28, 15, 15, '2025-01-20'),
(29, 15, 1, '2025-01-21'),
(30, 15, 24, '2025-01-21'),
(31, 15, 24, '2025-01-21'),
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
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

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
  MODIFY `flightclasses_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `passengers`
--
ALTER TABLE `passengers`
  MODIFY `passenger_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `paymentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=753;

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
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `wishListId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

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
