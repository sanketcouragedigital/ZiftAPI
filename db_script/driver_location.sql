-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 31, 2015 at 11:25 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `appcom_ziftapp`
--

-- --------------------------------------------------------

--
-- Table structure for table `driver_location`
--

CREATE TABLE IF NOT EXISTS `driver_location` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mobileno` bigint(10) NOT NULL,
  `latitude` float(10,6) NOT NULL,
  `longitude` float(10,6) NOT NULL,
  `location_area` varchar(30) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `mobileno` (`mobileno`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=82 ;

--
-- Dumping data for table `driver_location`
--


--
-- Constraints for dumped tables
--

--
-- Constraints for table `driver_location`
--
ALTER TABLE `driver_location`
  ADD CONSTRAINT `driver_location_ibfk_1` FOREIGN KEY (`mobileno`) REFERENCES `driver_details` (`mobileno`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
