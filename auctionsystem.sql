-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 11, 2020 at 11:34 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `auctionsystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `auctions`
--

CREATE TABLE `auctions` (
  `auctionID` bigint(20) NOT NULL,
  `sellerID` bigint(20) NOT NULL,
  `buyerID` bigint(20) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `description` varchar(10000) NOT NULL,
  `startingBid` double NOT NULL,
  `address` varchar(255) NOT NULL,
  `address2` varchar(255) DEFAULT NULL,
  `country` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `zip` varchar(10) NOT NULL,
  `isActive` tinyint(1) DEFAULT 1,
  `buyPrice` double DEFAULT NULL,
  `startingDate` datetime NOT NULL DEFAULT current_timestamp(),
  `endingDate` datetime DEFAULT NULL,
  `imageFileName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `auctions`
--

INSERT INTO `auctions` (`auctionID`, `sellerID`, `buyerID`, `title`, `subtitle`, `description`, `startingBid`, `address`, `address2`, `country`, `state`, `zip`, `isActive`, `buyPrice`, `startingDate`, `endingDate`, `imageFileName`) VALUES
(22, 1, 4, 'Binoculars', '', 'Old pair of binoculars that belonged to a \"Poilu\" during World War I 14-18. Still functional. Correct condition. For lovers of military objects, militaria.', 100, '1275 Market Street', 'San Francisco', 'United States', 'California', '94103', 1, 200, '2020-11-23 02:27:00', '2020-12-10 14:43:59', '1606058811-image_0007.jpg'),
(25, 5, 3, 'Vintage Camera', '', 'A vintage 1950&#39;s era Zenith AM / FM radio with a  brown case. It is working. Measures 15&#34; 8.5&#34; x 8&#34;.', 200, '1982 Crawford Street', '', 'Canada', 'Yukon', '98567', 1, 251, '2020-11-23 04:33:32', '2020-12-10 14:43:59', '1606086212-image_0050.jpg'),
(26, 3, 5, 'Buddha Idol', '', 'Green Tara, one of the eleventh mothers, Tibetan Buddha from Tibetan Collection of Old Buddha Statues', 500, '198-B Bagtok Street', 'Saskatoon', 'Canada', 'Saskatchewan', '98754', 1, 600, '2020-11-24 05:11:28', '2020-12-10 14:43:59', '1606174888-image_0003.jpg'),
(29, 5, 6, 'iphone', '', 'The iPhone is a smartphone that has a touch display screen, data service, an MP3 player and the ability to connect to a Wi-Fi network. The iPhone is manufactured by Apple', 1000, '1st Floor, No. 10, 16.8 St', 'Doctor hesabi Blvd, 16 Allay', 'United States', 'California', '7196758987', 1, 1050, '2020-12-10 09:38:03', '2020-12-10 14:43:59', '1607593083-iphone-12-pro-family-hero.jpg'),
(30, 5, NULL, 'Round Metal Mirror', '', 'Mirrors can have magnification properties, making images appear smaller or larger than their actual size.', 200, '1st Floor, No. 10, 16.8 St', 'Doctor hesabi Blvd, 16 Allay', 'Canada', 'Ontario', '7196758987', 1, NULL, '2020-12-10 10:41:09', NULL, '1607596869-auctionsystem.jpg'),
(31, 6, 6, 'Macbook', '', 'Apple MacBook Pro Summary\r\nIt is powered by a Core i5 processor and it comes with 12GB of RAM. The Apple MacBook Pro packs 512GB of SSD storage.', 3000, 'block 32/2', 'Doctor hesabi Blvd, 16 Allay', 'Canada', 'Quebec', '7196758987', 1, 3050, '2020-12-10 10:44:59', '2020-12-10 14:43:59', '1607597099-macbook.jpg'),
(32, 5, NULL, 'Apple Mouse', '', 'The Magic Mouse is the first consumer mouse to have multi-touch capabilities. Taking after the iPhone, iPad, iPod Touch, and multi-touch trackpads.', 200, '1st Floor, No. 10, 16.8 St', '', 'Canada', 'Quebec', '7196758987', 1, NULL, '2020-12-10 13:41:59', NULL, '1607607719-mouse.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `bids`
--

CREATE TABLE `bids` (
  `bidID` bigint(20) NOT NULL,
  `bidderID` bigint(20) NOT NULL,
  `auctionID` bigint(20) NOT NULL,
  `bidTime` datetime NOT NULL DEFAULT current_timestamp(),
  `amount` float NOT NULL,
  `Name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `bids`
--

INSERT INTO `bids` (`bidID`, `bidderID`, `auctionID`, `bidTime`, `amount`, `Name`) VALUES
(3, 3, 22, '2020-11-24 02:54:30', 120, 'Test User 2'),
(4, 4, 25, '2020-11-24 03:58:04', 250, 'Test User 3'),
(5, 3, 25, '2020-11-24 03:58:25', 251, 'Test User 2'),
(6, 4, 22, '2020-11-24 03:58:37', 200, 'Test User 3'),
(9, 3, 26, '2020-12-10 09:58:10', 550, 'Prateek'),
(11, 6, 31, '2020-12-10 10:12:19', 3050, 'Ahsan Saleem'),
(12, 6, 29, '2020-12-10 10:12:58', 1050, 'Ahsan Saleem'),
(14, 5, 26, '2020-12-10 13:23:47', 600, 'Mahsa'),
(15, 5, 30, '2020-12-10 14:44:51', 250, 'Mahsa');

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `country` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`country`, `state`) VALUES
('United States', 'Alabama'),
('United States', 'Alaska'),
('United States', 'Arizona'),
('United States', 'Arkansas'),
('United States', 'California'),
('United States', 'Colorado'),
('United States', 'Connecticut'),
('United States', 'Delaware'),
('United States', 'Florida'),
('United States', 'Georgia'),
('United States', 'Hawaii'),
('United States', 'Idaho'),
('United States', 'Illinois'),
('United States', 'Indiana'),
('United States', 'Iowa'),
('United States', 'Kansas'),
('United States', 'Kentucky'),
('United States', 'Louisiana'),
('United States', 'Maine'),
('United States', 'Maryland'),
('United States', 'Massachusetts'),
('United States', 'Michigan'),
('United States', 'Minnesota'),
('United States', 'Mississippi'),
('United States', 'Missouri'),
('United States', 'Montana'),
('Canada', 'Alberta'),
('Canada', 'British Columbia'),
('Canada', 'Manitoba'),
('Canada', 'New Brunswick'),
('Canada', 'Newfoundland'),
('Canada', 'Northwest Territories'),
('Canada', 'Nova Scotia'),
('Canada', 'Nunavut'),
('Canada', 'Ontario'),
('Canada', 'Prince Edward Island'),
('Canada', 'Quebec'),
('Canada', 'Saskatchewan'),
('Canada', 'Yukon');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notificationID` bigint(20) NOT NULL,
  `type` varchar(50) NOT NULL,
  `auctionID` bigint(20) NOT NULL,
  `receiverID` bigint(20) NOT NULL,
  `isSeen` tinyint(1) NOT NULL DEFAULT 0,
  `dateAdded` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`notificationID`, `type`, `auctionID`, `receiverID`, `isSeen`, `dateAdded`) VALUES
(6, 'Item Sold', 22, 1, 1, '2020-11-24 06:58:30'),
(7, 'Bid Won', 22, 4, 0, '2020-11-24 06:58:30'),
(8, 'Item Sold', 25, 1, 1, '2020-11-24 06:58:30'),
(9, 'Bid Won', 25, 3, 0, '2020-11-24 06:58:30'),
(14, 'Item Sold', 22, 1, 0, '2020-12-10 10:02:02'),
(15, 'Bid Won', 22, 4, 0, '2020-12-10 10:02:02'),
(16, 'Item Sold', 25, 5, 1, '2020-12-10 10:02:02'),
(17, 'Bid Won', 25, 3, 0, '2020-12-10 10:02:02'),
(18, 'Item Sold', 26, 3, 0, '2020-12-10 10:02:02'),
(19, 'Bid Won', 26, 5, 1, '2020-12-10 10:02:02'),
(20, 'Item Sold', 22, 1, 0, '2020-12-10 10:59:21'),
(21, 'Bid Won', 22, 4, 0, '2020-12-10 10:59:21'),
(22, 'Item Sold', 25, 5, 1, '2020-12-10 10:59:21'),
(23, 'Bid Won', 25, 3, 0, '2020-12-10 10:59:21'),
(24, 'Item Sold', 26, 3, 0, '2020-12-10 10:59:21'),
(25, 'Bid Won', 26, 5, 1, '2020-12-10 10:59:21'),
(26, 'Item Sold', 29, 5, 1, '2020-12-10 10:59:21'),
(27, 'Bid Won', 29, 6, 1, '2020-12-10 10:59:21'),
(28, 'Item Sold', 31, 6, 1, '2020-12-10 10:59:21'),
(29, 'Bid Won', 31, 6, 1, '2020-12-10 10:59:21'),
(30, 'Item Sold', 22, 1, 0, '2020-12-10 14:43:59'),
(31, 'Bid Won', 22, 4, 0, '2020-12-10 14:43:59'),
(32, 'Item Sold', 25, 5, 1, '2020-12-10 14:43:59'),
(33, 'Bid Won', 25, 3, 0, '2020-12-10 14:43:59'),
(34, 'Item Sold', 26, 3, 0, '2020-12-10 14:43:59'),
(35, 'Bid Won', 26, 5, 1, '2020-12-10 14:43:59'),
(36, 'Item Sold', 29, 5, 1, '2020-12-10 14:43:59'),
(37, 'Bid Won', 29, 6, 0, '2020-12-10 14:43:59'),
(38, 'Item Sold', 31, 6, 0, '2020-12-10 14:43:59'),
(39, 'Bid Won', 31, 6, 0, '2020-12-10 14:43:59');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `signUpDate` datetime NOT NULL DEFAULT current_timestamp(),
  `isApproved` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `name`, `email`, `password`, `signUpDate`, `isApproved`) VALUES
(1, 'Test User 1', 'testuser1@email.com', '$2y$10$b/6INff7dVHqJSpa0WwOEOaIVygH0mhehDsE0i/pL0LzfJOtjgUY6', '2020-11-21 17:24:36', 0),
(3, 'Test User 2', 'testuser2@email.com', '$2y$10$cD19dNV5v74fSZ2x/nv8DuJi9DuZ/bGAbl0PucEXxcdtfJ0bnPf.y', '2020-11-23 07:08:44', 0),
(4, 'Test User 3', 'testuser3@gmail.com', '$2y$10$YqHHs7zUJvGptyL/5.yx0u7FeEGgkMdeYuGY3tMvCcz86g9xMhfIC', '2020-11-24 03:56:21', 0),
(5, 'Mahsa', 'mahsa.raeiszadeh@yahoo.com', '$2y$10$bftjLEeNraKRMOFcomMUZ.QDiXZGVBTEXoLt.lxMB2YhSUOTYrtWy', '2020-12-10 06:59:26', 0),
(6, 'Ahsan Saleem', 'ahsansaleem.saleem@gmail.com', '$2y$10$HpYuWZ3ejKySFz0g9Y9jbe0apJdXXTSuQS9HGP1GVW2.9tfb7IVaq', '2020-12-10 07:30:26', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `auctions`
--
ALTER TABLE `auctions`
  ADD PRIMARY KEY (`auctionID`);

--
-- Indexes for table `bids`
--
ALTER TABLE `bids`
  ADD PRIMARY KEY (`bidID`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notificationID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `auctions`
--
ALTER TABLE `auctions`
  MODIFY `auctionID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `bids`
--
ALTER TABLE `bids`
  MODIFY `bidID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notificationID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
