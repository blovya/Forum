-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 26, 2023 at 02:18 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.4.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `iwd_forum`
--
CREATE DATABASE IF NOT EXISTS `iwd_forum` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `iwd_forum`;

-- --------------------------------------------------------

--
-- Table structure for table `forum`
--

CREATE TABLE `forum` (
  `forum_id` tinyint(4) UNSIGNED NOT NULL,
  `forum_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `forum`:
--

--
-- Dumping data for table `forum`
--

INSERT INTO `forum` (`forum_id`, `forum_name`) VALUES
(1, 'General Discussion'),
(2, 'News and Events'),
(3, 'Videos and Images');

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE `log` (
  `log_id` int(11) NOT NULL,
  `log_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `ip_address` varchar(50) NOT NULL,
  `username` varchar(20) DEFAULT NULL,
  `event_type` varchar(50) NOT NULL,
  `event_details` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `log`:
--   `username`
--       `user` -> `username`
--

--
-- Dumping data for table `log`
--

INSERT INTO `log` (`log_id`, `log_date`, `ip_address`, `username`, `event_type`, `event_details`) VALUES
(166, '2023-10-26 06:13:25', '::1', 'bsmith', 'Logout', NULL),
(167, '2023-10-26 06:13:53', '::1', 'jbloggs', 'Login (Successful)', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `reply`
--

CREATE TABLE `reply` (
  `reply_id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `thread_id` int(11) NOT NULL,
  `content` varchar(10000) NOT NULL,
  `post_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `reply`:
--   `username`
--       `user` -> `username`
--   `thread_id`
--       `thread` -> `thread_id`
--

--
-- Dumping data for table `reply`
--

INSERT INTO `reply` (`reply_id`, `username`, `thread_id`, `content`, `post_date`) VALUES
(3, 'jbloggs', 6, 'Take care and get well soon :)', '2023-10-26 06:14:18');

-- --------------------------------------------------------

--
-- Table structure for table `tag`
--

CREATE TABLE `tag` (
  `tag_id` smallint(6) NOT NULL,
  `tag_name` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `tag`:
--

--
-- Dumping data for table `tag`
--

INSERT INTO `tag` (`tag_id`, `tag_name`) VALUES
(4, 'are'),
(2, 'events'),
(3, 'gaming'),
(1, 'news');

-- --------------------------------------------------------

--
-- Table structure for table `thread`
--

CREATE TABLE `thread` (
  `thread_id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `forum_id` tinyint(4) UNSIGNED NOT NULL,
  `title` varchar(100) NOT NULL,
  `content` varchar(40000) NOT NULL,
  `post_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `thread`:
--   `username`
--       `user` -> `username`
--   `forum_id`
--       `forum` -> `forum_id`
--

--
-- Dumping data for table `thread`
--

INSERT INTO `thread` (`thread_id`, `username`, `forum_id`, `title`, `content`, `post_date`) VALUES
(6, 'bsmith', 1, 'So how about this weather?', 'It has been raining non-stop for the past few days - getting pretty sick of it, plus it\'s really cold!', '2023-10-26 05:47:46'),
(7, 'jbloggs', 1, 'Strong rain last night', 'For a few minutes last night, there was a downpour that was stronger than anything I\'ve ever experienced before.\n\nIt was loud enough (on my tin roof) to wake me up and I couldn\'t get back to sleep afterwards!', '2023-10-26 05:47:46'),
(8, 'jbloggs', 1, 'Turn your lights on when driving in the rain', 'It can be really hard to see other cars on the road, particularly grey ones, when there is heavy rain.\nSo please, turn your lights on!', '2023-10-26 05:47:46'),
(9, 'bsmith', 2, 'Blazing Swan', 'Anyone ever been to Blazing Swan? It\'s Perth\'s \"Burning Man\" style event, held up in Kulin. Usually around late March/early April.', '2023-10-26 05:47:46'),
(10, 'bsmith', 2, 'Perfectly normal thread', 'This not at all a test of whether this forum is vulnerable to XSS attacks.\n<script>alert(\"Hacked!\");</script>\nPlease move along.', '2023-10-26 05:47:46');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `real_name` varchar(100) DEFAULT NULL,
  `dob` date NOT NULL,
  `access_level` varchar(10) NOT NULL DEFAULT 'member'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `user`:
--

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`username`, `password`, `real_name`, `dob`, `access_level`) VALUES
('bsmith', '$2y$10$LUIH3Bzi7zd0biqtBVVi7O4gWl4R.fHWkgyjj6yyKqFqpOHZN3UZe', 'Bob Smith', '1998-05-21', 'admin'),
('jbloggs', '$2y$10$/FBMPo4g25V7wh9WA3FkVuBuwLFDG/oltdxeH4g4bxPxT4y2Emq/q', 'Joe Bloggs', '2000-10-01', 'member');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `forum`
--
ALTER TABLE `forum`
  ADD PRIMARY KEY (`forum_id`),
  ADD UNIQUE KEY `forum_name` (`forum_name`);

--
-- Indexes for table `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `username` (`username`);

--
-- Indexes for table `reply`
--
ALTER TABLE `reply`
  ADD PRIMARY KEY (`reply_id`),
  ADD KEY `username` (`username`),
  ADD KEY `thread_id` (`thread_id`);

--
-- Indexes for table `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`tag_id`),
  ADD UNIQUE KEY `tag_name` (`tag_name`);

--
-- Indexes for table `thread`
--
ALTER TABLE `thread`
  ADD PRIMARY KEY (`thread_id`),
  ADD KEY `username` (`username`),
  ADD KEY `forum_id` (`forum_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `forum`
--
ALTER TABLE `forum`
  MODIFY `forum_id` tinyint(4) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `log`
--
ALTER TABLE `log`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=168;

--
-- AUTO_INCREMENT for table `reply`
--
ALTER TABLE `reply`
  MODIFY `reply_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tag`
--
ALTER TABLE `tag`
  MODIFY `tag_id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `thread`
--
ALTER TABLE `thread`
  MODIFY `thread_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `log`
--
ALTER TABLE `log`
  ADD CONSTRAINT `log_ibfk_1` FOREIGN KEY (`username`) REFERENCES `user` (`username`) ON DELETE SET NULL;

--
-- Constraints for table `reply`
--
ALTER TABLE `reply`
  ADD CONSTRAINT `reply_ibfk_1` FOREIGN KEY (`username`) REFERENCES `user` (`username`),
  ADD CONSTRAINT `reply_ibfk_2` FOREIGN KEY (`thread_id`) REFERENCES `thread` (`thread_id`);

--
-- Constraints for table `thread`
--
ALTER TABLE `thread`
  ADD CONSTRAINT `thread_ibfk_1` FOREIGN KEY (`username`) REFERENCES `user` (`username`),
  ADD CONSTRAINT `thread_ibfk_2` FOREIGN KEY (`forum_id`) REFERENCES `forum` (`forum_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
