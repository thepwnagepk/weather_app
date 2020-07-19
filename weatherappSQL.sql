-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 19, 2020 at 06:56 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `weatherapp`
--

-- --------------------------------------------------------

--
-- Table structure for table `favourites`
--

CREATE TABLE `favourites` (
  `locationID` int(11) NOT NULL,
  `userID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `favourites`
--

INSERT INTO `favourites` (`locationID`, `userID`) VALUES
(2, 1),
(3, 1),
(4, 1),
(6, 1),
(7, 1);

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE `location` (
  `locationID` int(11) NOT NULL,
  `locationname` varchar(255) NOT NULL,
  `latitude` double(10,7) DEFAULT NULL,
  `longitude` double(10,7) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`locationID`, `locationname`, `latitude`, `longitude`) VALUES
(1, 'Falkirk, Killingworth, North Tyneside, Tyne and Wear, North East England, England, NE12 6QA, United Kingdom', 55.0395779, -1.5692732),
(2, 'Kettering, Northamptonshire, East Midlands, England, United Kingdom', 52.3994233, -0.7280040),
(3, 'Cardiff, Wales, CF, United Kingdom', 51.4816546, -3.1791934),
(4, '', 0.0000000, 0.0000000),
(6, 'Kettering, Station Road, Leisure Village, Kettering, Northamptonshire, East Midlands, England, NN15 7HJ, United Kingdom', 52.3934929, -0.7320125),
(7, 'Dubai, Al Khamila Street, Emirates Hills, Dubai, 24857, United Arab Emirates', 25.0750095, 55.1887609),
(8, 'Glasgow, Glasgow City, Scotland, G2 1DY, United Kingdom', 55.8611389, -4.2501672),
(9, 'Dulverton, Somerset, South West England, England, TA22, United Kingdom', 51.0401089, -3.5501059),
(10, 'Minehead, Somerset, South West England, England, TA24 5UF, United Kingdom', 51.2057511, -3.4783542),
(11, 'Hereford, Herefordshire, West Midlands, England, HR1 2NB, United Kingdom', 52.0553813, -2.7151735),
(12, 'Maldives', 4.7064352, 73.3287853);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `email`, `name`, `password`) VALUES
(1, 'test@gmail.com', 'John Doe', '1234');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `favourites`
--
ALTER TABLE `favourites`
  ADD PRIMARY KEY (`locationID`,`userID`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`locationID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `location`
--
ALTER TABLE `location`
  MODIFY `locationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `favourites`
--
ALTER TABLE `favourites`
  ADD CONSTRAINT `favourites_ibfk_1` FOREIGN KEY (`locationID`) REFERENCES `location` (`locationID`),
  ADD CONSTRAINT `favourites_ibfk_2` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
