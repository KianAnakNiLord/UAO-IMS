-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 19, 2025 at 07:02 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `uao_ims`
--

-- --------------------------------------------------------

--
-- Table structure for table `borrow_requests`
--

CREATE TABLE `borrow_requests` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `inventory_item_id` int(11) NOT NULL,
  `status` enum('pending','approved','rejected','returned','overdue') DEFAULT 'pending',
  `request_date` date DEFAULT NULL,
  `return_date` date DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `quantity` int(11) DEFAULT 1,
  `quantity_requested` int(11) DEFAULT NULL,
  `purpose` text DEFAULT NULL,
  `rejection_reason` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `borrow_requests`
--

INSERT INTO `borrow_requests` (`id`, `user_id`, `inventory_item_id`, `status`, `request_date`, `return_date`, `created`, `modified`, `quantity`, `quantity_requested`, `purpose`, `rejection_reason`) VALUES
(1, 13, 3, 'approved', '2025-04-19', '2025-04-19', '2025-04-18 15:52:00', '2025-04-18 15:53:50', 1, NULL, NULL, NULL),
(2, 13, 4, 'pending', '2025-04-19', '2025-04-19', '2025-04-18 18:35:11', '2025-04-18 18:35:11', 1, 1, 'Varsity Training', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `inventory_items`
--

CREATE TABLE `inventory_items` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `procurement_date` date DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `item_condition` enum('new','used','damaged') DEFAULT NULL,
  `description` text DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory_items`
--

INSERT INTO `inventory_items` (`id`, `name`, `procurement_date`, `category`, `item_condition`, `description`, `quantity`, `created`, `modified`) VALUES
(3, 'Basketball Ring', NULL, NULL, NULL, 's', 2, '2025-04-18 15:33:25', '2025-04-18 15:33:25'),
(4, 'Volleyball net', '2025-04-18', 'supply', 'used', 'ad', 2, '2025-04-18 15:44:38', '2025-04-18 15:44:38'),
(5, 'Basketball Ring', '2025-04-18', 'ball_sports', 'new', 'dad', 2, '2025-04-18 15:44:57', '2025-04-18 15:44:57'),
(6, 'Ezra', '2025-04-17', 'strength', 'new', 'fsdf', 2, '2025-04-18 15:45:34', '2025-04-18 15:45:34');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `role` enum('borrower','admin') NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role`, `name`, `email`, `password`, `created`, `modified`) VALUES
(1, 'admin', 'Admin User', 'admin@example.com', '', '2025-04-18 18:29:19', '2025-04-18 18:29:19'),
(2, 'borrower', 'Student 1', 'student1@example.com', '', '2025-04-18 18:29:19', '2025-04-18 18:29:19'),
(3, 'borrower', 'Charles Babia', 'charles@my.xu.edu.ph', 'lebron', '2025-04-18 10:47:40', '2025-04-18 10:47:40'),
(4, 'borrower', 'Kian Porras', 'kian@gmail.com', 'kian', '2025-04-18 10:48:12', '2025-04-18 10:48:12'),
(5, 'borrower', 'Jericho', 'jericho@gmail.com', '$2y$10$itt4dduxCD4HMkt2bSuB/e2ZXKukZxdvJmSkYmyfkNEPTNf1RwsyC', '2025-04-18 10:51:21', '2025-04-18 10:51:21'),
(6, 'borrower', 'Ezra', 'test@gmail.com', '$2y$10$ZT54hWckosS1KklA8OnS9ew0St.FfLxx3BqKFWOiWMjl6DG0J6Fuy', '2025-04-18 10:52:38', '2025-04-18 10:52:38'),
(7, 'borrower', 'kiangwapo', 'kiangwapo@gmail.com', '$2y$10$6h9bcriOwXnyOKa.XHyVNuDvcS96KdbboMK2/6WEgjeuxHm0vuFme', '2025-04-18 10:57:33', '2025-04-18 10:57:33'),
(8, 'borrower', 'Gwapo', 'gwapo@gmail.com', '$2y$10$XufxOdmogOpin7zvsZ/7betYkSQOmjSder3Rv1PrX09oFWs3wto.6', '2025-04-18 11:00:46', '2025-04-18 11:00:46'),
(9, 'borrower', 'try', 'try@gmail.com', '$2y$10$tKtMljMFJ8p2EKRTR3ifVOLCbebqyGGz9Ocbg/v92j9KEkxWvoOuS', '2025-04-18 11:07:12', '2025-04-18 11:07:12'),
(10, 'borrower', 'ChatGpt', 'gpt@gmail.com', '$2y$10$NdHKQxQJwcMwKciQb8KbCuyTsPOp19nWd5mpI5RlPpGD7TxmDyBeq', '2025-04-18 11:08:38', '2025-04-18 11:08:38'),
(11, 'borrower', 'Good', 'good@gmail.com', '$2y$10$pq5JQDHRigrBS/yld8.YE.SxjCfKoKbNEiJijNnMcB2920ZdcQLsq', '2025-04-18 11:27:03', '2025-04-18 11:27:03'),
(13, 'borrower', 'Charlie Brown', 'brown@gmail.com', '$2y$10$/aPHv2GoG4uaZkVhW1vX8Optvq0WUKSPMK.dxnVfqRvy.fuVWfW/K', '2025-04-18 11:44:23', '2025-04-18 11:44:23'),
(14, 'borrower', 'practice', 'prac@gmail.com', '$2y$10$ZQZZGGsFDe9/K7/zOHXf8uhV5jPRfXl1oB4lfcXZJgbYt6oLK3P5e', '2025-04-18 12:04:52', '2025-04-18 12:04:52'),
(16, 'admin', 'Admin User', 'kianadmin@gmail.com', '$2y$10$mVutmVd9PH5sU5vSUcYYBOkWQCxbaeBKHje5dp7N3KYLeUPKluoIu', '2025-04-18 22:06:21', '2025-04-18 22:06:21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `borrow_requests`
--
ALTER TABLE `borrow_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `inventory_item_id` (`inventory_item_id`);

--
-- Indexes for table `inventory_items`
--
ALTER TABLE `inventory_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `borrow_requests`
--
ALTER TABLE `borrow_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `inventory_items`
--
ALTER TABLE `inventory_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `borrow_requests`
--
ALTER TABLE `borrow_requests`
  ADD CONSTRAINT `borrow_requests_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `borrow_requests_ibfk_2` FOREIGN KEY (`inventory_item_id`) REFERENCES `inventory_items` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
