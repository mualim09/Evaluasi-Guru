-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 12, 2019 at 09:51 PM
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hxs_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `attachment`
--

CREATE TABLE `attachment` (
  `attachment_ID` int(11) UNSIGNED NOT NULL,
  `service_ID` int(11) UNSIGNED DEFAULT NULL,
  `attachment_Name` varchar(255) DEFAULT NULL,
  `attachment_MIME` tinytext,
  `attachment_Data` longblob,
  `attachment_Date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `client_ID` int(11) UNSIGNED NOT NULL,
  `client_FName` varchar(85) DEFAULT NULL,
  `client_MName` varchar(85) DEFAULT NULL,
  `client_LName` varchar(85) DEFAULT NULL,
  `suffix_ID` int(11) UNSIGNED DEFAULT NULL,
  `client_Address` varchar(255) DEFAULT NULL,
  `client_Contact` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `client_group`
--

CREATE TABLE `client_group` (
  `cgroup_ID` int(11) UNSIGNED NOT NULL,
  `cgroup_Name` varchar(255) NOT NULL,
  `cgroup_Date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `client_group_member`
--

CREATE TABLE `client_group_member` (
  `cgmember_ID` int(11) UNSIGNED NOT NULL,
  `client_ID` int(11) UNSIGNED DEFAULT NULL,
  `service_ID` int(11) UNSIGNED DEFAULT NULL,
  `cgmember_Date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cost`
--

CREATE TABLE `cost` (
  `cost_ID` int(11) UNSIGNED NOT NULL,
  `cost_Name` varchar(255) DEFAULT NULL,
  `cost_Amount` double(19,2) DEFAULT NULL,
  `cost_Date` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `savings`
--

CREATE TABLE `savings` (
  `savings_ID` int(11) UNSIGNED NOT NULL,
  `savings_Amount` double(19,2) DEFAULT NULL,
  `savings_Date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `service`
--

CREATE TABLE `service` (
  `service_ID` int(11) UNSIGNED NOT NULL,
  `service_Title` varchar(255) DEFAULT NULL,
  `service_Description` text,
  `service_Repository` text,
  `service_Amount` double(19,2) DEFAULT NULL,
  `status_ID` int(11) UNSIGNED DEFAULT NULL,
  `service_Date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `service`
--

INSERT INTO `service` (`service_ID`, `service_Title`, `service_Description`, `service_Repository`, `service_Amount`, `status_ID`, `service_Date`) VALUES
(1, 'CvSU Tracer System', 'Alumni Tracer System', NULL, 11000.00, NULL, '2019-07-12 18:49:24'),
(2, 'Project Monitoring', 'Project Monitoring', NULL, 4000.00, NULL, '2019-07-12 18:51:01'),
(3, 'Notredame Information System', 'Notredame Information System', NULL, 500.00, NULL, '2019-07-12 18:51:45');

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `transaction_ID` int(11) UNSIGNED NOT NULL,
  `service_ID` int(11) UNSIGNED DEFAULT NULL,
  `transaction_Amount` double(19,2) DEFAULT NULL,
  `transaction_Change` double(19,2) DEFAULT NULL,
  `transaction_Date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_ID` int(11) UNSIGNED NOT NULL,
  `lvl_ID` tinyint(4) UNSIGNED DEFAULT NULL COMMENT 'user level',
  `user_img` longblob,
  `user_Name` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_Pass` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_Email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_Address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_Registered` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_ID`, `lvl_ID`, `user_img`, `user_Name`, `user_Pass`, `user_Email`, `user_Address`, `user_Registered`) VALUES
(1, 2, NULL, 'admin', 'QrUgcNdRjaE74hfEIeThKa/RaqA9N/KpBI+X7VeiyfE=', 'admin@gmail.com', 'admin', '2019-05-12 11:54:15'),
(2, 1, NULL, 'client', 'LNUOkX56slaOJFyE7LVQuu+cAFoHNTW0VJa46vct2+Q=', 'customer@gmail.com', 'customer', '2019-05-12 11:54:50'),
(14, 1, NULL, 'new', 'XnCOFXzvzFGHXS/GZ5kVEZ9PAE2N+oCeqydK87yGuwo=', 'new21@gmail.com', 'asd', '2019-07-12 18:36:26');

-- --------------------------------------------------------

--
-- Table structure for table `user_level`
--

CREATE TABLE `user_level` (
  `lvl_ID` tinyint(4) UNSIGNED NOT NULL,
  `lvl_Name` varchar(85) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_level`
--

INSERT INTO `user_level` (`lvl_ID`, `lvl_Name`) VALUES
(1, 'Client'),
(2, 'Admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attachment`
--
ALTER TABLE `attachment`
  ADD PRIMARY KEY (`attachment_ID`);

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`client_ID`);

--
-- Indexes for table `client_group`
--
ALTER TABLE `client_group`
  ADD PRIMARY KEY (`cgroup_ID`);

--
-- Indexes for table `client_group_member`
--
ALTER TABLE `client_group_member`
  ADD PRIMARY KEY (`cgmember_ID`);

--
-- Indexes for table `cost`
--
ALTER TABLE `cost`
  ADD PRIMARY KEY (`cost_ID`);

--
-- Indexes for table `savings`
--
ALTER TABLE `savings`
  ADD PRIMARY KEY (`savings_ID`);

--
-- Indexes for table `service`
--
ALTER TABLE `service`
  ADD PRIMARY KEY (`service_ID`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`transaction_ID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_ID`),
  ADD KEY `user_login_key` (`user_Name`),
  ADD KEY `user_email` (`user_Email`),
  ADD KEY `lvl_ID` (`lvl_ID`);

--
-- Indexes for table `user_level`
--
ALTER TABLE `user_level`
  ADD PRIMARY KEY (`lvl_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attachment`
--
ALTER TABLE `attachment`
  MODIFY `attachment_ID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `client`
--
ALTER TABLE `client`
  MODIFY `client_ID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `client_group`
--
ALTER TABLE `client_group`
  MODIFY `cgroup_ID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `client_group_member`
--
ALTER TABLE `client_group_member`
  MODIFY `cgmember_ID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `cost`
--
ALTER TABLE `cost`
  MODIFY `cost_ID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `savings`
--
ALTER TABLE `savings`
  MODIFY `savings_ID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `service`
--
ALTER TABLE `service`
  MODIFY `service_ID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `transaction_ID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_ID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `user_level`
--
ALTER TABLE `user_level`
  MODIFY `lvl_ID` tinyint(4) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
