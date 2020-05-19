-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 19, 2020 at 07:59 PM
-- Server version: 5.7.24
-- PHP Version: 7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blood_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `blood_bank`
--

DROP TABLE IF EXISTS `blood_bank`;
CREATE TABLE IF NOT EXISTS `blood_bank` (
  `id` int(7) NOT NULL,
  `blood_group` varchar(50) DEFAULT NULL,
  `address` varchar(50) DEFAULT NULL,
  `bloodbank_phone` varchar(11) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `blood_bank`
--

INSERT INTO `blood_bank` (`id`, `blood_group`, `address`, `bloodbank_phone`, `email`) VALUES
(1, 'O+', 'Gaibandha', '01752746973', 'oahidzihad1@gmail.com'),
(2, 'O+', 'Gaibandha', '01752746973', 'oahidzihad1@gmail.com'),
(3, 'A-', 'Dhaka', '01752746988', 'zihadzihad111@gmail.com'),
(4, 'B+', 'Rangpur', '01752733333', 'ludhfuiasdasf@gmail.com'),
(5, 'O-', 'Barishal', '01752755555', 'aaasssssidf@gmail.com'),
(6, 'A+', 'Comilla', '01718429111', 'mojammalhossain813@gmail.com'),
(7, 'B-', 'Chadpur', '01718429157', 'zihadzihad111@gmail.com'),
(8, 'A-', 'Jessore', '01718422222', 'amizihad@gmail.com'),
(9, 'O-', 'America', '01718429999', 'guythatsfunny@gmail.com'),
(10, 'O-', 'America', '01718429999', 'guythatsfunny@gmail.com'),
(11, 'O+', 'Gaibandha', '01752746973', 'oahidzihad1@gmail.com'),
(15, 'A+', 'America', '01752755555', 'guythatsfunny@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `blood_stock`
--

DROP TABLE IF EXISTS `blood_stock`;
CREATE TABLE IF NOT EXISTS `blood_stock` (
  `id` int(7) NOT NULL AUTO_INCREMENT,
  `blood_id` int(7) NOT NULL,
  `qty` int(7) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `blood_stock`
--

INSERT INTO `blood_stock` (`id`, `blood_id`, `qty`) VALUES
(1, 6, 11),
(3, 7, 8),
(9, 1, 70),
(6, 12, 7),
(8, 3, 12);

-- --------------------------------------------------------

--
-- Table structure for table `donation_history`
--

DROP TABLE IF EXISTS `donation_history`;
CREATE TABLE IF NOT EXISTS `donation_history` (
  `id` int(7) NOT NULL AUTO_INCREMENT,
  `seeker_id` int(7) NOT NULL,
  `blood_id` int(7) NOT NULL,
  `qty` int(7) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `donation_history`
--

INSERT INTO `donation_history` (`id`, `seeker_id`, `blood_id`, `qty`) VALUES
(12, 1, 4, 10),
(11, 1, 4, 10),
(10, 2, 4, 10),
(9, 2, 7, 2);

-- --------------------------------------------------------

--
-- Table structure for table `donor`
--

DROP TABLE IF EXISTS `donor`;
CREATE TABLE IF NOT EXISTS `donor` (
  `id` int(7) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `blood_group` varchar(50) NOT NULL,
  `last_donation_date` date NOT NULL,
  `contact_no` varchar(11) NOT NULL,
  `address` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=121 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `donor`
--

INSERT INTO `donor` (`id`, `name`, `blood_group`, `last_donation_date`, `contact_no`, `address`, `email`) VALUES
(1, 'Shoumik', 'A+', '2020-05-06', '01752746999', 'Gaibandha', 'mojammalhossain813@gmail.com'),
(2, 'Ri Naz', 'A-', '2020-05-06', '01711111111', 'America', 'guythatsfunny@gmail.com'),
(5, 'zihad', 'O+', '2020-05-06', '01752746999', 'gaibandha', 'ludhfuiasdasf@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `seeker`
--

DROP TABLE IF EXISTS `seeker`;
CREATE TABLE IF NOT EXISTS `seeker` (
  `id` int(7) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `address` varchar(50) NOT NULL,
  `age` int(10) NOT NULL,
  `blood_group` varchar(50) NOT NULL,
  `contact_no` varchar(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `seeker`
--

INSERT INTO `seeker` (`id`, `name`, `address`, `age`, `blood_group`, `contact_no`) VALUES
(1, 'John Cina', 'America', 40, 'A-', '01752746999'),
(2, 'Ri Naz', 'Dhaka', 25, 'B-', '01711111111'),
(3, 'Shanila', 'Dhaka', 25, 'A+', '01722222222'),
(4, 'Oahid', 'Gaibandha', 25, 'O+', '01711111111');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
