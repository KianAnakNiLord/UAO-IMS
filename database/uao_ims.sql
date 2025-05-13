-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 13, 2025 at 10:55 PM
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
  `inventory_item_id` int(10) UNSIGNED DEFAULT NULL,
  `status` enum('pending','approved','rejected','returned','overdue') DEFAULT 'pending',
  `request_date` date DEFAULT NULL,
  `return_date` date DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `quantity` int(11) DEFAULT 1,
  `quantity_requested` int(11) DEFAULT NULL,
  `purpose` text DEFAULT NULL,
  `rejection_reason` text DEFAULT NULL,
  `return_time` time DEFAULT NULL,
  `id_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventory_items`
--

CREATE TABLE `inventory_items` (
  `id` int(10) UNSIGNED NOT NULL,
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
(8, 'Soccer Ball', '2025-05-14', 'equipment', 'new', 'Adidas Brand', 5, '2025-05-13 20:49:51', '2025-05-13 20:49:51');

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
(13, 'borrower', 'Charlie Brown', 'brown@gmail.com', '$2y$10$/aPHv2GoG4uaZkVhW1vX8Optvq0WUKSPMK.dxnVfqRvy.fuVWfW/K', '2025-04-18 11:44:23', '2025-04-18 11:44:23'),
(14, 'borrower', 'practice', 'prac@gmail.com', '$2y$10$ZQZZGGsFDe9/K7/zOHXf8uhV5jPRfXl1oB4lfcXZJgbYt6oLK3P5e', '2025-04-18 12:04:52', '2025-04-18 12:04:52'),
(16, 'admin', 'Admin User', 'kianadmin@gmail.com', '$2y$10$mVutmVd9PH5sU5vSUcYYBOkWQCxbaeBKHje5dp7N3KYLeUPKluoIu', '2025-04-18 22:06:21', '2025-04-18 22:06:21'),
(18, 'borrower', 'Lebron', 'lebron@gmail.com', '$2y$10$mrNlnqW6rRrraarjjm86o.r7eaZiDNg0sW.MhzEIPUM.ieMk5cirC', '2025-04-30 09:21:58', '2025-04-30 09:21:58'),
(20, 'borrower', 'Brown King', 'browney@gmail.com', '$2y$10$2sWLFjSdbCnkZWfHeBhtUuQ8LczML9mqxj0Z305X5MuQh/vfUazSC', '2025-05-02 16:36:54', '2025-05-02 16:36:54'),
(21, 'borrower', 'Blackey', '20220024809@my.xu.edu.ph', '$2y$10$mawxiDCVTrTX/X6di4MvA.XOMOv73KVo7waUzDcz.NRTzC6mma/Bq', '2025-05-02 16:39:40', '2025-05-02 16:39:40');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `borrow_requests`
--
ALTER TABLE `borrow_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `fk_inventory_item` (`inventory_item_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `inventory_items`
--
ALTER TABLE `inventory_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `borrow_requests`
--
ALTER TABLE `borrow_requests`
  ADD CONSTRAINT `borrow_requests_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_inventory_item` FOREIGN KEY (`inventory_item_id`) REFERENCES `inventory_items` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
