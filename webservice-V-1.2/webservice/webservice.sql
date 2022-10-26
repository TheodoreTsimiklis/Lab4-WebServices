-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 28, 2022 at 09:55 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webservice`
--

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `licensenumber` varchar(100) DEFAULT NULL,
  `licensestartdate` date DEFAULT NULL,
  `licenseenddate` date DEFAULT NULL,
  `apikey` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `name`, `licensenumber`, `licensestartdate`, `licenseenddate`, `apikey`) VALUES
(1, 'company1', '64char', '2022-09-01', '2023-10-31', 'apikey123');

-- --------------------------------------------------------

--
-- Table structure for table `videoconversions`
--

CREATE TABLE `videoconversions` (
  `id` int(11) NOT NULL,
  `clientid` int(11) NOT NULL,
  `requestdate` date NOT NULL,
  `completiondate` date DEFAULT NULL,
  `originalformat` varchar(50) NOT NULL,
  `targetformat` varchar(50) NOT NULL,
  `inputfile` varchar(300) NOT NULL,
  `outputfile` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `videoconversions`
--

INSERT INTO `videoconversions` (`id`, `clientid`, `requestdate`, `completiondate`, `originalformat`, `targetformat`, `inputfile`, `outputfile`) VALUES
(1, 1, '2022-09-28', '2022-09-28', 'mp4', 'avi', 'video1.mp4', 'video1.avi'),
(2, 1, '2022-09-28', '2022-09-28', 'mp4', 'avi', 'video2.mp4', 'video2.avi');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `videoconversions`
--
ALTER TABLE `videoconversions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_conversion` (`clientid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `videoconversions`
--
ALTER TABLE `videoconversions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `videoconversions`
--
ALTER TABLE `videoconversions`
  ADD CONSTRAINT `client_conversion` FOREIGN KEY (`clientid`) REFERENCES `clients` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
