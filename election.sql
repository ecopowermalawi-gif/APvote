-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 29, 2025 at 07:33 PM
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
-- Database: `election`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'NYANDA', 'ddf28590e13e82cb5d2a320a21f41452965b57ea');

-- --------------------------------------------------------

--
-- Table structure for table `candidates`
--

CREATE TABLE `candidates` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `position_id` int(11) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `position` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `candidates`
--

INSERT INTO `candidates` (`id`, `full_name`, `position_id`, `photo`, `position`) VALUES
(11, 'BRIDGET BANDA', 14, '694fd7af3c189.jpeg', NULL),
(12, 'FENED CHITSULO', 14, '694fd7c56902e.png', NULL),
(13, 'ZOE MANDA', 14, '694fd7e0d9d7c.png', NULL),
(14, 'ZELIA CHAKALE', 14, '694fd7f19919a.png', NULL),
(15, 'PEMPHERO BANDA', 8, '694fe3c60a472.png', NULL),
(16, 'FAVOUR HARA', 8, '694fe3d7ebcb3.png', NULL),
(17, 'KSERNA MBIZI', 8, '694fe3e95509e.png', NULL),
(18, 'ATUPELE ALIFA', 8, '694fe3ff8449c.png', NULL),
(19, 'ESINTA ROBERT', 13, '694fe426f154e.png', NULL),
(20, 'SHAROM', 13, '694fe43c13890.png', NULL),
(21, 'CHIFUNDO CHWALO', 13, '694fe4513559f.jpeg', NULL),
(23, 'FAITH CHINYUMBA', 10, '694fe48947a66.jpeg', NULL),
(24, 'TAMMY HUSEIN', 10, '694fe49f7c5a6.png', NULL),
(25, 'SINDISIWE BANDA', 10, '694fe4b467c94.jpeg', NULL),
(26, 'ZIPHONA MLANGENI', 11, '694fe4cc2c753.jpeg', NULL),
(27, 'ZIMATHA MLANGENI', 11, '694fe4de08ef9.jpeg', NULL),
(28, 'RICHARD NAYNADA', 6, '694fe5987d0cb.png', NULL),
(29, 'BLE NYANDA', 5, '694fe5a754778.png', NULL),
(30, 'CHIKU NYANDA', 5, '694fe5b5b710e.png', NULL),
(31, 'ULEMU ', 6, '694fe5c81aacc.png', NULL),
(32, 'HOPE MKWICHI', 6, '694fe5d99cfaf.png', NULL),
(33, 'DENSIRE ', 7, '694fe5e953cdf.png', NULL),
(34, 'KJJFL', 9, '694fe5f62bbc8.png', NULL),
(35, 'JDJFDKJ', 12, '694fe69372ecc.png', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `positions`
--

CREATE TABLE `positions` (
  `id` int(11) NOT NULL,
  `position_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `positions`
--

INSERT INTO `positions` (`id`, `position_name`) VALUES
(5, 'HOSTEL PREFECTS (FORM 2)'),
(6, 'HOSTEL PREFECTS (FORM 3)'),
(7, 'HOSTEL PREFECTS (FORM 4)'),
(8, 'CAFETERIA PREFECTS'),
(9, 'LIBRARY PREFECTS'),
(10, 'SPORTS PREFECTS'),
(11, 'ENTERTAINMENT PREFECTS'),
(12, 'HEALTH PREFECTS'),
(13, 'VICE HEAD-GIRL'),
(14, 'HEAD-GIRL');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `voting_closed` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`voting_closed`) VALUES
(0);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `student_id` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `has_voted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `full_name`, `student_id`, `password`, `has_voted`) VALUES
(10, 'JESSIE BANDA', 'APU3978', '$2y$10$hm24YQ6Zk/qmxy9Z60qDMeESdZTnMvx5gKtb3Y8UC6bI0792JMnXa', 0),
(11, 'ZIONE MANDA', 'APU2248', '$2y$10$WRl.kulQ0VZZYVeo4c4JPOMgvISMZwSNXZSrD7ZjVK.sCwvVimJ1K', 0),
(12, 'ZIONE MANDA', 'APU136E', '$2y$10$gwQEWv7rgZf6oV0jDNgLDOYyz27zUnl2ivD/aMzeQtXfb4Ps47WBK', 0),
(13, 'ZELESI NYANDA', 'APU463E', '$2y$10$3JnITpxmQMSUSg1A0fAIZevzf9nRJ2PiY73QrHUsmvfYmk/5k3sSa', 1),
(14, 'vero', 'APUC1D1', '$2y$10$kjc6s3Vr/f9B0qRwA4R99O1RYWEpQtX9esZqbZovWnYZS4sZ9OTEe', 0),
(15, 'dickel', 'APU4516', '$2y$10$zEPYEJW7qzMJ.xbhs1/bver8dR47/X8dIU5ATkcrgQgSWaxN/tl/q', 1),
(16, 'jelomy', 'APU3F73', '$2y$10$/p8WvtSLq0eqi9GXSCosLeYp89Sbt/GjHO7DItf0P6UCVf.49JV1q', 1),
(17, 'RICHARD NYANDA', 'APU1EC0', '$2y$10$dk3TZVlAuNNuqIfwceTc6OaMddVaqQ/frrDKsAS3MIRksV4.2wmJe', 0),
(18, 'bright banda', 'APUFBEE', '$2y$10$sVMZUAc3qyi/WQ4bmJIut.7QMCPxIBz9L8UzBjgNLB03ElzFQnQTu', 1),
(19, 'asmenye', 'APU10AD', '$2y$10$2lRQFf1H4bvFfCEtyDDYZ.wPHzsFAbFXXnd395xK7BInzywTFm9Si', 0),
(20, 'zoe', 'APUCD94', '$2y$10$cTMlzmZvOdRLfCg/u7Jne.2/LP6xxJJC9CRgKr6fLCfDhMEglMlsO', 1),
(21, 'BRIAR CHIBWANA', 'APU1AB7', '$2y$10$7ca.ftt9XVw1L6oNTEgVL.JKHJM8rDgJ1HocCHFJCz9vIMaV5v866', 1),
(22, 'alick bandawe', 'APU6AFE', '$2y$10$Kuq5NvknIgU5JFtVrhYT3ugp6FVV/e11NRR9C5rZxd1VM0/Dpvbb6', 1),
(23, 'JOANA BANDA', 'APU4A37', '$2y$10$cWsyW1J8SrNe0KQ6bkON1Okf.LD2ya/0eRbvOHFtgkZDgzHQ3f.ve', 1),
(24, ' BRENDA MANDA', 'APUF2C1', '$2y$10$Mxa2IBjQtBH0p2z49aaoMuqgaXZf6DLbDRbZba4oK18de6FK9.BoK', 0),
(25, 'BENIAS BONOGWE', 'APU9650', '$2y$10$MBdRJpQDs.L3FTHd31YIwePThte49XlVWMpdee2QF6bOiXuFNt/22', 1),
(26, 'kjfkjfkjvfk', 'APUEA09', '$2y$10$qZnomTz5nfALjraXB8IlOunNMfJEwFLxvJ.2CtNYRWhO5uzZeEqOO', 0),
(27, 'jkjdskjdshjds', 'APUA497', '$2y$10$rxVi2MvCpQqm1tZrj/3IX.LNWVTN1t8zOnQ9xgf13TFgucwF07bBm', 1),
(28, 'FAITH KAPOLO', 'APUF880', '$2y$10$f1U5gGErhPG9mo2kYIUMXOLlHtUoWtCq9YPizpS/a.ckWjC7ETOpK', 1),
(29, 'PRESCORT JAMISON', 'APU9D47', '$2y$10$bZLrjkJiwye26F41XGXCHeL0Yr0ytNO/SIVfHbroOv.BM0ad1SCQW', 1);

-- --------------------------------------------------------

--
-- Table structure for table `votes`
--

CREATE TABLE `votes` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `position_id` int(11) DEFAULT NULL,
  `candidate_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `votes`
--

INSERT INTO `votes` (`id`, `student_id`, `position_id`, `candidate_id`) VALUES
(1, 13, 5, 29),
(2, 13, 6, 31),
(3, 13, 7, 33),
(4, 13, 8, 18),
(5, 13, 9, 34),
(6, 13, 10, 24),
(7, 13, 11, 27),
(8, 13, 12, 35),
(9, 13, 13, 21),
(10, 13, 14, 13),
(11, 15, 5, 30),
(12, 15, 6, 32),
(13, 15, 7, 33),
(14, 15, 8, 16),
(15, 15, 9, 34),
(16, 15, 10, 24),
(17, 15, 11, 27),
(18, 15, 12, 35),
(19, 15, 13, 21),
(20, 15, 14, 14),
(21, 16, 5, 30),
(22, 16, 6, 31),
(23, 16, 7, 33),
(24, 16, 8, 17),
(25, 16, 9, 34),
(26, 16, 10, 25),
(27, 16, 11, 27),
(28, 16, 12, 35),
(29, 16, 13, 21),
(30, 16, 14, 13),
(31, 18, 5, 30),
(32, 18, 6, 28),
(33, 18, 7, 33),
(34, 18, 8, 17),
(35, 18, 9, 34),
(36, 18, 10, 23),
(37, 18, 11, 26),
(38, 18, 12, 35),
(39, 18, 13, 21),
(40, 18, 14, 14),
(41, 20, 5, 29),
(42, 20, 6, 31),
(43, 20, 7, 33),
(44, 20, 8, 16),
(45, 20, 9, 34),
(46, 20, 10, 24),
(47, 20, 11, 27),
(48, 20, 12, 35),
(49, 20, 13, 20),
(50, 20, 14, 13),
(51, 21, 5, 30),
(52, 21, 6, 32),
(53, 21, 7, 33),
(54, 21, 8, 18),
(55, 21, 9, 34),
(56, 21, 10, 24),
(57, 21, 11, 27),
(58, 21, 12, 35),
(59, 21, 13, 20),
(60, 21, 14, 12),
(61, 22, 5, 30),
(62, 22, 6, 31),
(63, 22, 7, 33),
(64, 22, 8, 17),
(65, 22, 9, 34),
(66, 22, 10, 24),
(67, 22, 11, 27),
(68, 22, 12, 35),
(69, 22, 13, 21),
(70, 22, 14, 14),
(71, 23, 5, 29),
(72, 23, 6, 32),
(73, 23, 7, 33),
(74, 23, 8, 16),
(75, 23, 9, 34),
(76, 23, 10, 25),
(77, 23, 11, 27),
(78, 23, 12, 35),
(79, 23, 13, 20),
(80, 23, 14, 13),
(81, 25, 5, 30),
(82, 25, 6, 32),
(83, 25, 7, 33),
(84, 25, 8, 15),
(85, 25, 9, 34),
(86, 25, 10, 24),
(87, 25, 11, 27),
(88, 25, 12, 35),
(89, 25, 13, 21),
(90, 25, 14, 13),
(91, 27, 5, 29),
(92, 27, 6, 28),
(93, 27, 7, 33),
(94, 27, 8, 16),
(95, 27, 9, 34),
(96, 27, 10, 25),
(97, 27, 11, 27),
(98, 27, 12, 35),
(99, 27, 13, 21),
(100, 27, 14, 14),
(101, 28, 5, 30),
(102, 28, 6, 31),
(103, 28, 7, 33),
(104, 28, 8, 18),
(105, 28, 9, 34),
(106, 28, 10, 25),
(107, 28, 11, 27),
(108, 28, 12, 35),
(109, 28, 13, 21),
(110, 28, 14, 13),
(111, 29, 5, 30),
(112, 29, 6, 31),
(113, 29, 7, 33),
(114, 29, 8, 17),
(115, 29, 9, 34),
(116, 29, 10, 24),
(117, 29, 11, 27),
(118, 29, 12, 35),
(119, 29, 13, 20),
(120, 29, 14, 12);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `candidates`
--
ALTER TABLE `candidates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_position` (`position_id`);

--
-- Indexes for table `positions`
--
ALTER TABLE `positions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_id` (`student_id`);

--
-- Indexes for table `votes`
--
ALTER TABLE `votes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `position_id` (`position_id`),
  ADD KEY `candidate_id` (`candidate_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `candidates`
--
ALTER TABLE `candidates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `positions`
--
ALTER TABLE `positions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `votes`
--
ALTER TABLE `votes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `candidates`
--
ALTER TABLE `candidates`
  ADD CONSTRAINT `candidates_ibfk_1` FOREIGN KEY (`position_id`) REFERENCES `positions` (`id`),
  ADD CONSTRAINT `fk_position` FOREIGN KEY (`position_id`) REFERENCES `positions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `votes`
--
ALTER TABLE `votes`
  ADD CONSTRAINT `votes_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`),
  ADD CONSTRAINT `votes_ibfk_2` FOREIGN KEY (`position_id`) REFERENCES `positions` (`id`),
  ADD CONSTRAINT `votes_ibfk_3` FOREIGN KEY (`candidate_id`) REFERENCES `candidates` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
