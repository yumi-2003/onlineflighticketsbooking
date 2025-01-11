-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 11, 2025 at 08:49 AM
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
(1, 'admin', 'admin@gmail.com', '$2y$10$0PqW2uHfQzVsSEjZppGriOzo5Cm4RfsDDmjOM3ch9Q0Ld8o8lQCM6', '../userPhoto/. d7ca1bbb-d965-4630-b386-0598a38917d1.jpg');

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
(2, 'Myanmar National Airways(MNA)                                        ', '../flightImg/MNA.webp'),
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
  `bookAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `passenger_id` int(11) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `payment_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`booking_id`, `user_id`, `flight_id`, `class_id`, `triptype_id`, `seatNoId`, `bookAt`, `passenger_id`, `status`, `updated_at`, `payment_id`) VALUES
(73, 7, 2, 2, 1, 463, '2025-01-08 23:24:41', 88, 'confirm', '2025-01-09', 59),
(74, 7, 2, 2, 1, 464, '2025-01-08 23:24:41', 89, 'confirm', '2025-01-09', 59),
(75, 7, 2, 1, 1, 454, '2025-01-09 10:12:29', 90, 'confirm', '2025-01-09', 62),
(76, 7, 2, 4, 1, 543, '2025-01-09 17:17:23', 91, 'confirm', '2025-01-10', 63),
(77, 7, 2, 3, 1, 538, '2025-01-10 23:20:29', 92, 'confirm', '2025-01-11', 64),
(78, 7, 2, 3, 1, 539, '2025-01-10 23:20:29', 93, 'confirm', '2025-01-11', 64);

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
(2, 5, 'MAI-201', '2025-02-01', 'Bangkok', 'Yangon', '580', 150.00, '09:00:00', '10:30:00', 150, 130, 20, 'A1', '../flightImg/bangkok.jpg'),
(4, 2, 'MAI 707', '2025-02-01', 'Chiang Mai', 'Yangon', '430', 100.00, '08:00:00', '10:00:00', 150, 100, 50, 'A2', '../flightImg/chaingmai.jpg');

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
(93, 'ju', 32, 'Female', 'Myanmar', '09786993707', 'eve3', '557657');

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
(64, '34534', '454654', '2025-01-14', 2, 'Phoo Nge', 690.00, '2025-01-11');

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
  `review_text` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`review_id`, `user_id`, `rating`, `review_text`, `created_at`) VALUES
(2, 7, 5, 'it was excellent', '2025-01-10 23:21:54'),
(3, 9, 3, 'the function needs to be improved', '2025-01-11 02:02:45');

-- --------------------------------------------------------

--
-- Table structure for table `seat_layout`
--

CREATE TABLE `seat_layout` (
  `id` int(11) NOT NULL,
  `flight_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `seatNo` varchar(50) NOT NULL,
  `status` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seat_layout`
--

INSERT INTO `seat_layout` (`id`, `flight_id`, `class_id`, `seatNo`, `status`) VALUES
(453, 2, 1, 'F1', 1),
(454, 2, 1, 'F2', 1),
(455, 2, 1, 'F3', 1),
(456, 2, 1, 'F4', 1),
(457, 2, 1, 'F5', 1),
(458, 2, 1, 'F6', 1),
(459, 2, 1, 'F7', 1),
(460, 2, 1, 'F8', 1),
(461, 2, 1, 'F9', 1),
(462, 2, 1, 'F10', 1),
(463, 2, 2, 'B1', 1),
(464, 2, 2, 'B2', 1),
(465, 2, 2, 'B3', 0),
(466, 2, 2, 'B4', 0),
(467, 2, 2, 'B5', 0),
(468, 2, 2, 'B6', 0),
(469, 2, 2, 'B7', 0),
(470, 2, 2, 'B8', 0),
(471, 2, 2, 'B9', 0),
(472, 2, 2, 'B10', 0),
(473, 2, 2, 'B11', 0),
(474, 2, 2, 'B12', 0),
(475, 2, 2, 'B13', 0),
(476, 2, 2, 'B14', 0),
(477, 2, 2, 'B15', 0),
(478, 2, 2, 'B16', 0),
(479, 2, 2, 'B17', 0),
(480, 2, 2, 'B18', 0),
(481, 2, 2, 'B19', 0),
(482, 2, 2, 'B20', 0),
(483, 2, 2, 'B21', 0),
(484, 2, 2, 'B22', 0),
(485, 2, 2, 'B23', 0),
(486, 2, 2, 'B24', 0),
(487, 2, 2, 'B25', 0),
(488, 2, 2, 'B26', 0),
(489, 2, 2, 'B27', 0),
(490, 2, 2, 'B28', 0),
(491, 2, 2, 'B29', 0),
(492, 2, 2, 'B30', 0),
(493, 2, 3, 'P1', 0),
(494, 2, 3, 'P2', 0),
(495, 2, 3, 'P3', 0),
(496, 2, 3, 'P4', 0),
(497, 2, 3, 'P5', 0),
(498, 2, 3, 'P6', 0),
(499, 2, 3, 'P7', 0),
(500, 2, 3, 'P8', 0),
(501, 2, 3, 'P9', 0),
(502, 2, 3, 'P10', 0),
(503, 2, 3, 'P11', 0),
(504, 2, 3, 'P12', 0),
(505, 2, 3, 'P13', 0),
(506, 2, 3, 'P14', 0),
(507, 2, 3, 'P15', 0),
(508, 2, 3, 'P16', 0),
(509, 2, 3, 'P17', 0),
(510, 2, 3, 'P18', 0),
(511, 2, 3, 'P19', 0),
(512, 2, 3, 'P20', 0),
(513, 2, 3, 'P21', 0),
(514, 2, 3, 'P22', 0),
(515, 2, 3, 'P23', 0),
(516, 2, 3, 'P24', 0),
(517, 2, 3, 'P25', 0),
(518, 2, 3, 'P26', 0),
(519, 2, 3, 'P27', 0),
(520, 2, 3, 'P28', 0),
(521, 2, 3, 'P29', 0),
(522, 2, 3, 'P30', 0),
(523, 2, 3, 'P31', 0),
(524, 2, 3, 'P32', 0),
(525, 2, 3, 'P33', 0),
(526, 2, 3, 'P34', 0),
(527, 2, 3, 'P35', 0),
(528, 2, 3, 'P36', 0),
(529, 2, 3, 'P37', 0),
(530, 2, 3, 'P38', 0),
(531, 2, 3, 'P39', 0),
(532, 2, 3, 'P40', 0),
(533, 2, 3, 'P41', 0),
(534, 2, 3, 'P42', 0),
(535, 2, 3, 'P43', 0),
(536, 2, 3, 'P44', 0),
(537, 2, 3, 'P45', 0),
(538, 2, 3, 'P46', 1),
(539, 2, 3, 'P47', 1),
(540, 2, 3, 'P48', 0),
(541, 2, 3, 'P49', 0),
(542, 2, 3, 'P50', 0),
(543, 2, 4, 'E1', 1),
(544, 2, 4, 'E2', 0),
(545, 2, 4, 'E3', 0),
(546, 2, 4, 'E4', 0),
(547, 2, 4, 'E5', 0),
(548, 2, 4, 'E6', 0),
(549, 2, 4, 'E7', 0),
(550, 2, 4, 'E8', 0),
(551, 2, 4, 'E9', 0),
(552, 2, 4, 'E10', 0),
(553, 2, 4, 'E11', 0),
(554, 2, 4, 'E12', 0),
(555, 2, 4, 'E13', 0),
(556, 2, 4, 'E14', 0),
(557, 2, 4, 'E15', 0),
(558, 2, 4, 'E16', 0),
(559, 2, 4, 'E17', 0),
(560, 2, 4, 'E18', 0),
(561, 2, 4, 'E19', 0),
(562, 2, 4, 'E20', 0),
(563, 2, 4, 'E21', 0),
(564, 2, 4, 'E22', 0),
(565, 2, 4, 'E23', 0),
(566, 2, 4, 'E24', 0),
(567, 2, 4, 'E25', 0),
(568, 2, 4, 'E26', 0),
(569, 2, 4, 'E27', 0),
(570, 2, 4, 'E28', 0),
(571, 2, 4, 'E29', 0),
(572, 2, 4, 'E30', 0),
(573, 2, 4, 'E31', 0),
(574, 2, 4, 'E32', 0),
(575, 2, 4, 'E33', 0),
(576, 2, 4, 'E34', 0),
(577, 2, 4, 'E35', 0),
(578, 2, 4, 'E36', 0),
(579, 2, 4, 'E37', 0),
(580, 2, 4, 'E38', 0),
(581, 2, 4, 'E39', 0),
(582, 2, 4, 'E40', 0),
(583, 2, 4, 'E41', 0),
(584, 2, 4, 'E42', 0),
(585, 2, 4, 'E43', 0),
(586, 2, 4, 'E44', 0),
(587, 2, 4, 'E45', 0),
(588, 2, 4, 'E46', 0),
(589, 2, 4, 'E47', 0),
(590, 2, 4, 'E48', 0),
(591, 2, 4, 'E49', 0),
(592, 2, 4, 'E50', 0),
(593, 2, 4, 'E51', 0),
(594, 2, 4, 'E52', 0),
(595, 2, 4, 'E53', 0),
(596, 2, 4, 'E54', 0),
(597, 2, 4, 'E55', 0),
(598, 2, 4, 'E56', 0),
(599, 2, 4, 'E57', 0),
(600, 2, 4, 'E58', 0),
(601, 2, 4, 'E59', 0),
(602, 2, 4, 'E60', 0),
(603, 4, 1, 'F1', 0),
(604, 4, 1, 'F2', 0),
(605, 4, 1, 'F3', 0),
(606, 4, 1, 'F4', 0),
(607, 4, 1, 'F5', 0),
(608, 4, 1, 'F6', 0),
(609, 4, 1, 'F7', 0),
(610, 4, 1, 'F8', 0),
(611, 4, 1, 'F9', 0),
(612, 4, 1, 'F10', 0),
(613, 4, 2, 'B1', 0),
(614, 4, 2, 'B2', 0),
(615, 4, 2, 'B3', 0),
(616, 4, 2, 'B4', 0),
(617, 4, 2, 'B5', 0),
(618, 4, 2, 'B6', 0),
(619, 4, 2, 'B7', 0),
(620, 4, 2, 'B8', 0),
(621, 4, 2, 'B9', 0),
(622, 4, 2, 'B10', 0),
(623, 4, 2, 'B11', 0),
(624, 4, 2, 'B12', 0),
(625, 4, 2, 'B13', 0),
(626, 4, 2, 'B14', 0),
(627, 4, 2, 'B15', 0),
(628, 4, 2, 'B16', 0),
(629, 4, 2, 'B17', 0),
(630, 4, 2, 'B18', 0),
(631, 4, 2, 'B19', 0),
(632, 4, 2, 'B20', 0),
(633, 4, 2, 'B21', 0),
(634, 4, 2, 'B22', 0),
(635, 4, 2, 'B23', 0),
(636, 4, 2, 'B24', 0),
(637, 4, 2, 'B25', 0),
(638, 4, 2, 'B26', 0),
(639, 4, 2, 'B27', 0),
(640, 4, 2, 'B28', 0),
(641, 4, 2, 'B29', 0),
(642, 4, 2, 'B30', 0),
(643, 4, 3, 'P1', 0),
(644, 4, 3, 'P2', 0),
(645, 4, 3, 'P3', 0),
(646, 4, 3, 'P4', 0),
(647, 4, 3, 'P5', 0),
(648, 4, 3, 'P6', 0),
(649, 4, 3, 'P7', 0),
(650, 4, 3, 'P8', 0),
(651, 4, 3, 'P9', 0),
(652, 4, 3, 'P10', 0),
(653, 4, 3, 'P11', 0),
(654, 4, 3, 'P12', 0),
(655, 4, 3, 'P13', 0),
(656, 4, 3, 'P14', 0),
(657, 4, 3, 'P15', 0),
(658, 4, 3, 'P16', 0),
(659, 4, 3, 'P17', 0),
(660, 4, 3, 'P18', 0),
(661, 4, 3, 'P19', 0),
(662, 4, 3, 'P20', 0),
(663, 4, 3, 'P21', 0),
(664, 4, 3, 'P22', 0),
(665, 4, 3, 'P23', 0),
(666, 4, 3, 'P24', 0),
(667, 4, 3, 'P25', 0),
(668, 4, 3, 'P26', 0),
(669, 4, 3, 'P27', 0),
(670, 4, 3, 'P28', 0),
(671, 4, 3, 'P29', 0),
(672, 4, 3, 'P30', 0),
(673, 4, 3, 'P31', 0),
(674, 4, 3, 'P32', 0),
(675, 4, 3, 'P33', 0),
(676, 4, 3, 'P34', 0),
(677, 4, 3, 'P35', 0),
(678, 4, 3, 'P36', 0),
(679, 4, 3, 'P37', 0),
(680, 4, 3, 'P38', 0),
(681, 4, 3, 'P39', 0),
(682, 4, 3, 'P40', 0),
(683, 4, 3, 'P41', 0),
(684, 4, 3, 'P42', 0),
(685, 4, 3, 'P43', 0),
(686, 4, 3, 'P44', 0),
(687, 4, 3, 'P45', 0),
(688, 4, 3, 'P46', 0),
(689, 4, 3, 'P47', 0),
(690, 4, 3, 'P48', 0),
(691, 4, 3, 'P49', 0),
(692, 4, 3, 'P50', 0),
(693, 4, 4, 'E1', 0),
(694, 4, 4, 'E2', 0),
(695, 4, 4, 'E3', 0),
(696, 4, 4, 'E4', 0),
(697, 4, 4, 'E5', 0),
(698, 4, 4, 'E6', 0),
(699, 4, 4, 'E7', 0),
(700, 4, 4, 'E8', 0),
(701, 4, 4, 'E9', 0),
(702, 4, 4, 'E10', 0),
(703, 4, 4, 'E11', 0),
(704, 4, 4, 'E12', 0),
(705, 4, 4, 'E13', 0),
(706, 4, 4, 'E14', 0),
(707, 4, 4, 'E15', 0),
(708, 4, 4, 'E16', 0),
(709, 4, 4, 'E17', 0),
(710, 4, 4, 'E18', 0),
(711, 4, 4, 'E19', 0),
(712, 4, 4, 'E20', 0),
(713, 4, 4, 'E21', 0),
(714, 4, 4, 'E22', 0),
(715, 4, 4, 'E23', 0),
(716, 4, 4, 'E24', 0),
(717, 4, 4, 'E25', 0),
(718, 4, 4, 'E26', 0),
(719, 4, 4, 'E27', 0),
(720, 4, 4, 'E28', 0),
(721, 4, 4, 'E29', 0),
(722, 4, 4, 'E30', 0),
(723, 4, 4, 'E31', 0),
(724, 4, 4, 'E32', 0),
(725, 4, 4, 'E33', 0),
(726, 4, 4, 'E34', 0),
(727, 4, 4, 'E35', 0),
(728, 4, 4, 'E36', 0),
(729, 4, 4, 'E37', 0),
(730, 4, 4, 'E38', 0),
(731, 4, 4, 'E39', 0),
(732, 4, 4, 'E40', 0),
(733, 4, 4, 'E41', 0),
(734, 4, 4, 'E42', 0),
(735, 4, 4, 'E43', 0),
(736, 4, 4, 'E44', 0),
(737, 4, 4, 'E45', 0),
(738, 4, 4, 'E46', 0),
(739, 4, 4, 'E47', 0),
(740, 4, 4, 'E48', 0),
(741, 4, 4, 'E49', 0),
(742, 4, 4, 'E50', 0),
(743, 4, 4, 'E51', 0),
(744, 4, 4, 'E52', 0),
(745, 4, 4, 'E53', 0),
(746, 4, 4, 'E54', 0),
(747, 4, 4, 'E55', 0),
(748, 4, 4, 'E56', 0),
(749, 4, 4, 'E57', 0),
(750, 4, 4, 'E58', 0),
(751, 4, 4, 'E59', 0),
(752, 4, 4, 'E60', 0);

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
(7, 'yumi', 'yumi@gmail.com', '$2y$10$624QCrhZr/aUb9M7A8O6QemcRuebevCpav47xWucT8d6iXkWLpfAq', NULL, '../userPhoto/download (3).jpg'),
(8, 'nora', 'nora@gmail.com', '$2y$10$ksnIcwgmMJT2/iHp1GnMO.81Qu8fVq9q80vuMP9a7AwPNVbiTpD1.', NULL, '../userPhoto/'),
(9, 'Emma', 'emma@gmail.com', '$2y$10$oRFV38ZIColJW4obfMkv4u4da7Oc8W22qD/AoAjrrW6Q444wVVo4m', NULL, '../userPhoto/d7ca1bbb-d965-4630-b386-0598a38917d1.jpg'),
(10, 'yumi', 'yumi@gmail.com', '$2y$10$iOl7fR5lS.BkV.fuXiOzUuMtuPmEVJUarfU8P9OQa2mZ3PaSpWIAi', NULL, '../userPhoto/');

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
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

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
  MODIFY `passenger_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `paymentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

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
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
