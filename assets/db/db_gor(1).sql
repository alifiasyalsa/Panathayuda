-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 24, 2021 at 12:18 PM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
  `SCH_TIME` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `field`
--

CREATE TABLE `field` (
  `FIELD_ID` char(4) NOT NULL,
  `FIELD_NAME` varchar(30) DEFAULT NULL,
  `FIELD_PRICE` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `SCH_ID` char(4) NOT NULL,
  `FIELD_ID` char(4) NOT NULL,
  `SCH_TIME` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `transcation`
--

CREATE TABLE `transcation` (
  `TRANS_ID` char(4) NOT NULL,
  `BOOK_ID` int(11) DEFAULT NULL,
  `QR_CODE` varchar(20) DEFAULT NULL,
  `TRANS_NAME` varchar(20) DEFAULT NULL,
  `TRANS_PHONE` int(11) DEFAULT NULL,
  `TRANS_DATE` timestamp NULL DEFAULT NULL,
  `PAYMENT_TOTAL` int(11) DEFAULT NULL,
  `PAYMENT_SLIP` varchar(250) DEFAULT NULL,
  `TRANS_STATUS` char(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `username` varchar(10) NOT NULL,
  `password` varchar(8) NOT NULL,
  `user_level` varchar(10) NOT NULL,
  `full_name` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
-- Indexes for table `transcation`
--
ALTER TABLE `transcation`
  ADD PRIMARY KEY (`TRANS_ID`),
  ADD UNIQUE KEY `TRANSCATION_PK` (`TRANS_ID`),
  ADD KEY `TRANS_BOOK_FK` (`BOOK_ID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `book_schedule`
--
ALTER TABLE `book_schedule`
  MODIFY `BOOK_ID` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
