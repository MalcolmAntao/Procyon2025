-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 30, 2025 at 08:28 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
CREATE Database `procyon2025`;
--

-- --------------------------------------------------------

--
-- Table structure for table `classregistration`
--

CREATE TABLE `classregistration` (
  `id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `category` varchar(20) DEFAULT 'class'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `classregistration`
--

INSERT INTO `classregistration` (`id`, `username`, `password`, `category`) VALUES
(1, 'KshitizKc', '2111015', 'class'),
(2, 'VedantGad', '2114060', 'class'),
(3, 'AckyshmaFernandes', '2113001', 'class'),
(4, 'MohammadSheikh', '2112021', 'class'),
(5, 'BasilMohammad', '2414011', 'class'),
(6, 'SwarajSingh', '2416024', 'class'),
(7, 'GaryAraujo', '2412008', 'class'),
(8, 'YuvrajDalvi', '2411026', 'class'),
(9, 'SujayHaldankar', '2414099', 'class'),
(10, 'ShaunakKunde', '244CDS09', 'class'),
(11, 'LeonardoVaz', '241CSE04', 'class'),
(12, 'RosanneRebelo', '2314082', 'class'),
(13, 'JuveriyaShaikh', '2314032', 'class'),
(14, 'PrestonDsilva', '2316035', 'class'),
(15, 'AyyanShaikh', '2312006', 'class'),
(16, 'ManfredSilva', '2311010', 'class'),
(17, 'NathaniaBaptista', '2214032', 'class'),
(18, 'VanoshFernandes', '2216055', 'class'),
(19, 'EldenRodrigues', '2212012', 'class'),
(20, 'FinoshaRebelo', '2211008', 'class');

-- --------------------------------------------------------

--
-- Table structure for table `departmentregistration`
--

CREATE TABLE `departmentregistration` (
  `id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `category` varchar(20) DEFAULT 'department'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departmentregistration`
--

INSERT INTO `departmentregistration` (`id`, `username`, `password`, `category`) VALUES
(1, 'KshitizKc', '2111015', 'department'),
(2, 'VedantGad', '2114060', 'department'),
(3, 'AckyshmaFernandes', '2113001', 'department'),
(4, 'MohammadSheikh', '2112021', 'department');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `classregistration`
--
ALTER TABLE `classregistration`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `departmentregistration`
--
ALTER TABLE `departmentregistration`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `classregistration`
--
ALTER TABLE `classregistration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `departmentregistration`
--
ALTER TABLE `departmentregistration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
