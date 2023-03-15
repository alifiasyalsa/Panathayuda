-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 07, 2021 at 10:44 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_gor`
--

-- --------------------------------------------------------

--
-- Table structure for table `book_schedule`
--

CREATE TABLE `book_schedule` (
  `BOOK_ID` int(11) NOT NULL,
  `FIELD_ID` char(4) NOT NULL,
  `SCH_DATE` date DEFAULT NULL,
  `SCH_TIME` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Truncate table before insert `book_schedule`
--

TRUNCATE TABLE `book_schedule`;
--
-- Dumping data for table `book_schedule`
--

INSERT INTO `book_schedule` (`BOOK_ID`, `FIELD_ID`, `SCH_DATE`, `SCH_TIME`) VALUES
(1, 'F01', '2021-06-08', '07.00-10.00'),
(2, 'F01', '2021-06-08', '10.00-13.00');

-- --------------------------------------------------------

--
-- Table structure for table `field`
--

CREATE TABLE `field` (
  `FIELD_ID` char(4) NOT NULL,
  `FIELD_NAME` varchar(30) DEFAULT NULL,
  `FIELD_PRICE` int(11) DEFAULT NULL,
  `FIELD_IMG` varchar(30) NOT NULL,
  `FIELD_SIZE` varchar(11) NOT NULL,
  `FIELD_DESC` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Truncate table before insert `field`
--

TRUNCATE TABLE `field`;
--
-- Dumping data for table `field`
--

INSERT INTO `field` (`FIELD_ID`, `FIELD_NAME`, `FIELD_PRICE`, `FIELD_IMG`, `FIELD_SIZE`, `FIELD_DESC`) VALUES
('F01', 'Lapangan Badminton', 100000, '', '', ''),
('F02', 'Lapangan Basket', 100000, '', '', ''),
('F03', 'Lapangan Voli', 100000, '', '', ''),
('F04', 'Lapangan Tenis', 200000, '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `REVIEW_ID` char(4) NOT NULL,
  `REVIEW_NAME` varchar(20) DEFAULT NULL,
  `REVIEW_DESC` varchar(250) DEFAULT NULL,
  `REVIEW_STATUS` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Truncate table before insert `review`
--

TRUNCATE TABLE `review`;
-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `SCH_ID` char(4) NOT NULL,
  `FIELD_ID` char(4) NOT NULL,
  `SCH_TIME` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Truncate table before insert `schedule`
--

TRUNCATE TABLE `schedule`;
--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`SCH_ID`, `FIELD_ID`, `SCH_TIME`) VALUES
('S01', 'F02', '07.00-10.00'),
('S02', 'F02', '10.00-13.00');

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `TRANS_ID` char(4) NOT NULL,
  `BOOK_ID` int(11) DEFAULT NULL,
  `QR_CODE` varchar(20) DEFAULT NULL,
  `TRANS_NAME` varchar(20) DEFAULT NULL,
  `TRANS_PHONE` varchar(15) DEFAULT NULL,
  `TRANS_DATE` timestamp NULL DEFAULT NULL,
  `PAYMENT_TOTAL` int(11) DEFAULT NULL,
  `PAYMENT_SLIP` varchar(250) DEFAULT NULL,
  `TRANS_STATUS` char(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Truncate table before insert `transaction`
--

TRUNCATE TABLE `transaction`;
--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`TRANS_ID`, `BOOK_ID`, `QR_CODE`, `TRANS_NAME`, `TRANS_PHONE`, `TRANS_DATE`, `PAYMENT_TOTAL`, `PAYMENT_SLIP`, `TRANS_STATUS`) VALUES
('T001', 1, 'QR', 'Regawa', '0000', '2021-06-07 17:00:00', 100000, 'slip', 'BOOK'),
('T002', 2, 'QR', 'Regawa', '0000', '2021-06-07 17:00:00', 100000, 'slip', 'BOOK');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `USERNAME` varchar(10) NOT NULL,
  `PASSWORD` varchar(8) NOT NULL,
  `USER_LEVEL` varchar(10) NOT NULL,
  `FULL_NAME` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Truncate table before insert `user`
--

TRUNCATE TABLE `user`;
--
-- Dumping data for table `user`
--

INSERT INTO `user` (`USERNAME`, `PASSWORD`, `USER_LEVEL`, `FULL_NAME`) VALUES
('super', 'super', 'super', 'Super');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `book_schedule`
--
ALTER TABLE `book_schedule`
  ADD PRIMARY KEY (`BOOK_ID`),
  ADD UNIQUE KEY `BOOK_SCHEDULE_PK` (`BOOK_ID`),
  ADD KEY `FIELD_BOOK_FK` (`FIELD_ID`);

--
-- Indexes for table `field`
--
ALTER TABLE `field`
  ADD PRIMARY KEY (`FIELD_ID`),
  ADD UNIQUE KEY `FIELD_PK` (`FIELD_ID`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`REVIEW_ID`),
  ADD UNIQUE KEY `REVIEW_PK` (`REVIEW_ID`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`SCH_ID`),
  ADD UNIQUE KEY `SCHEDULE_PK` (`SCH_ID`),
  ADD KEY `FIELD_SCH_FK` (`FIELD_ID`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`TRANS_ID`),
  ADD UNIQUE KEY `TRANSCATION_PK` (`TRANS_ID`),
  ADD KEY `TRANS_BOOK_FK` (`BOOK_ID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`USERNAME`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
