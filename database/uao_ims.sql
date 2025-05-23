-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 23, 2025 at 10:31 AM
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
  `user_id` int(11) UNSIGNED DEFAULT NULL,
  `inventory_item_id` int(10) UNSIGNED DEFAULT NULL,
  `status` enum('pending','approved','rejected','returned','overdue') DEFAULT 'pending',
  `approval_note` text DEFAULT NULL,
  `request_date` date DEFAULT NULL,
  `return_date` date DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `quantity` int(11) DEFAULT 1,
  `quantity_requested` int(11) DEFAULT NULL,
  `purpose` text DEFAULT NULL,
  `rejection_reason` text DEFAULT NULL,
  `return_time` time DEFAULT NULL,
  `id_image` varchar(255) DEFAULT NULL,
  `returned_good` int(11) DEFAULT 0,
  `returned_damaged` int(11) DEFAULT 0,
  `overdue_duration` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `borrow_requests`
--

INSERT INTO `borrow_requests` (`id`, `user_id`, `inventory_item_id`, `status`, `approval_note`, `request_date`, `return_date`, `created`, `modified`, `quantity`, `quantity_requested`, `purpose`, `rejection_reason`, `return_time`, `id_image`, `returned_good`, `returned_damaged`, `overdue_duration`) VALUES
(81, 42, 9, 'rejected', NULL, '2025-05-22', '2025-05-22', '2025-05-22 21:47:53', '2025-05-22 21:48:15', 1, 4, 'sdfdsfsfsdfsdf', 'csdadasda', '23:47:46', 'uploads/1747921673_cruslogo.png', 0, 0, NULL),
(82, 42, 9, 'returned', '', '2025-05-23', '2025-05-23', '2025-05-23 01:46:57', '2025-05-23 01:53:56', 1, 3, 'dsfsdfsdf', NULL, '01:50:45', 'uploads/1747936017_cruslogo.png', 3, 0, NULL),
(89, 42, 11, 'returned', '', '2025-05-23', '2025-05-23', '2025-05-23 03:01:04', '2025-05-23 03:04:35', 1, 1, 'hfhfh', NULL, '03:02:56', 'uploads/1747940464_profile.jpg', 1, 0, NULL),
(90, 42, 11, 'returned', '', '2025-05-23', '2025-05-23', '2025-05-23 03:11:12', '2025-05-23 03:14:19', 1, 1, 'fsd', NULL, '03:12:06', 'uploads/1747941072_signatureporras.png', 1, 0, NULL),
(91, 42, 11, 'returned', '', '2025-05-23', '2025-05-23', '2025-05-23 03:17:12', '2025-05-23 03:19:53', 2, 2, 'fsdf', NULL, '03:18:06', 'uploads/1747941432_profile.jpg', 2, 0, NULL),
(92, 42, 9, 'returned', '', '2025-05-23', '2025-05-23', '2025-05-23 03:24:23', '2025-05-23 03:31:15', 2, 2, 'ew', NULL, '03:25:17', 'uploads/1747941863_cruslogo.png', 2, 0, NULL),
(93, 42, 9, 'returned', '', '2025-05-23', '2025-05-23', '2025-05-23 03:33:53', '2025-05-23 03:35:54', 3, 3, 'SFDA', NULL, '03:34:46', 'uploads/1747942433_signatureporras.png', 3, 0, '0 day(s), 0 hour(s), 1 min(s)');

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
  `modified` datetime DEFAULT NULL,
  `returned_damaged` int(11) DEFAULT 0,
  `location` varchar(100) NOT NULL DEFAULT 'UA Office'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory_items`
--

INSERT INTO `inventory_items` (`id`, `name`, `procurement_date`, `category`, `item_condition`, `description`, `quantity`, `created`, `modified`, `returned_damaged`, `location`) VALUES
(8, 'Soccer Ball', '2025-05-14', 'equipment', 'new', 'Adidas Brand', 1, '2025-05-13 20:49:51', '2025-05-19 13:49:16', 0, 'UA Office'),
(9, 'Badminton Racket', '2025-05-18', 'equipment', 'new', 'Yonex', 6, '2025-05-18 14:24:30', '2025-05-23 03:35:54', 0, 'UA Office'),
(10, 'Athletic Tape', '2025-05-18', 'supply', 'new', 'Rolyan', 0, '2025-05-18 14:26:20', '2025-05-22 21:46:43', 7, 'UA Office'),
(11, 'Cone', '2025-05-19', 'strength', 'new', 'Cone Brand ', 3, '2025-05-19 09:33:48', '2025-05-23 03:19:53', 0, 'UA Office'),
(12, 'Agility Ladder', '2025-05-20', 'strength', 'damaged', 'dasd', 3, '2025-05-20 22:48:16', '2025-05-20 22:48:16', 0, 'UA Office'),
(13, 'Try', '2025-05-21', 'equipment', 'used', 'fas', 2, '2025-05-21 01:55:30', '2025-05-21 01:55:30', 0, 'Covered Court'),
(14, 'try', '2025-05-21', 'equipment', 'used', 'dsad', 1, '2025-05-21 01:57:19', '2025-05-21 01:57:19', 0, 'Covered Court-Green Rm');

-- --------------------------------------------------------

--
-- Table structure for table `social_profiles`
--

CREATE TABLE `social_profiles` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED DEFAULT NULL,
  `provider` varchar(255) DEFAULT NULL,
  `identifier` varchar(255) DEFAULT NULL,
  `access_token` text DEFAULT NULL,
  `refresh_token` text DEFAULT NULL,
  `expires` datetime DEFAULT NULL,
  `link` text DEFAULT NULL,
  `profile_url` text DEFAULT NULL,
  `image_url` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `gender` varchar(20) DEFAULT NULL,
  `locale` varchar(10) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `raw_data` text DEFAULT NULL,
  `created` datetime DEFAULT current_timestamp(),
  `modified` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `social_profiles`
--

INSERT INTO `social_profiles` (`id`, `user_id`, `provider`, `identifier`, `access_token`, `refresh_token`, `expires`, `link`, `profile_url`, `image_url`, `description`, `email`, `username`, `full_name`, `first_name`, `last_name`, `gender`, `locale`, `birthday`, `raw_data`, `created`, `modified`) VALUES
(42, 42, 'google', '107198915122772613198', 'O:39:\"SocialConnect\\OpenIDConnect\\AccessToken\":7:{s:8:\"\0*\0token\";s:224:\"ya29.a0AW4XtxjrwqpJaI7iWtw8EZhE8KFmybP0DOt6PHUrbpQDK32aCLVa3nYj-LtMW1rWKAQebVed_-hntAWP3TLIxaNh0ChF3PrqCs8eVAuPEQNxsuE2yXmXMaJNu7wXYgMozKvQNxDvdagcZRmHuDcyPt6wwpL7HSBa7yqN-UZoLQaCgYKAU4SARISFQHGX2MiaeUZOrZIbuK-3byByiIpGQ0177\";s:15:\"\0*\0refreshToken\";N;s:10:\"\0*\0expires\";i:1747946011;s:6:\"\0*\0uid\";s:21:\"107198915122772613198\";s:8:\"\0*\0email\";N;s:6:\"\0*\0jwt\";O:21:\"SocialConnect\\JWX\\JWT\":3:{s:10:\"\0*\0headers\";a:3:{s:3:\"alg\";s:5:\"RS256\";s:3:\"kid\";s:40:\"660ef3b9784bdf56ebe859f577f7fb2e8c1ceffb\";s:3:\"typ\";s:3:\"JWT\";}s:10:\"\0*\0payload\";a:10:{s:3:\"iss\";s:19:\"accounts.google.com\";s:3:\"azp\";s:72:\"317753544990-k8stjr2n7de20tt2qummpvc1c64o35dp.apps.googleusercontent.com\";s:3:\"aud\";s:72:\"317753544990-k8stjr2n7de20tt2qummpvc1c64o35dp.apps.googleusercontent.com\";s:3:\"sub\";s:21:\"107198915122772613198\";s:2:\"hd\";s:12:\"my.xu.edu.ph\";s:5:\"email\";s:24:\"20220024802@my.xu.edu.ph\";s:14:\"email_verified\";b:1;s:7:\"at_hash\";s:22:\"2BEfzhfh1lxqM1bnFXPrPA\";s:3:\"iat\";i:1747942414;s:3:\"exp\";i:1747946014;}s:12:\"\0*\0signature\";s:256:\"?A\0???u??*???H??EvS&????&n??6L?ޛ??ڨ^񋇝P{?t<??6????5??5??a\'?_?è	C?Dk??â?4y\"??.\Z?????;5q??\"?????Z??r????V?FJ.ԫ;?qY????wm?Ȗ@59?@???b??\"?z,???X?L??\0d(??wu?\'s???]Ͻ>c?l?8??9???_???J?.Jd\\?P?\r`??O??+?2>?\n)???ƚ[???P\r?sif\n?????7b\";}s:10:\"\0*\0idToken\";s:936:\"eyJhbGciOiJSUzI1NiIsImtpZCI6IjY2MGVmM2I5Nzg0YmRmNTZlYmU4NTlmNTc3ZjdmYjJlOGMxY2VmZmIiLCJ0eXAiOiJKV1QifQ.eyJpc3MiOiJhY2NvdW50cy5nb29nbGUuY29tIiwiYXpwIjoiMzE3NzUzNTQ0OTkwLWs4c3RqcjJuN2RlMjB0dDJxdW1tcHZjMWM2NG8zNWRwLmFwcHMuZ29vZ2xldXNlcmNvbnRlbnQuY29tIiwiYXVkIjoiMzE3NzUzNTQ0OTkwLWs4c3RqcjJuN2RlMjB0dDJxdW1tcHZjMWM2NG8zNWRwLmFwcHMuZ29vZ2xldXNlcmNvbnRlbnQuY29tIiwic3ViIjoiMTA3MTk4OTE1MTIyNzcyNjEzMTk4IiwiaGQiOiJteS54dS5lZHUucGgiLCJlbWFpbCI6IjIwMjIwMDI0ODAyQG15Lnh1LmVkdS5waCIsImVtYWlsX3ZlcmlmaWVkIjp0cnVlLCJhdF9oYXNoIjoiMkJFZnpoZmgxbHhxTTFibkZYUHJQQSIsImlhdCI6MTc0Nzk0MjQxNCwiZXhwIjoxNzQ3OTQ2MDE0fQ.mkEAgsngdY30KqW-tEj7D7RFdlMmhq7_yyZuqP42TMAH3pvc49qoXh_xi4edUHvPdDzZ8zb-nRin2hs1F7mzNZuQYSeyX5kGw6gJQ51Ea-ayw6K6fzR5ItvcHAYuGrzp7PKPOzVxvIoik93N2cla8vdyivzzE-pWDuRGSi7UqzuscVnn4rzmd23yyJYeQDU5P0DC0vACYuD7IpB6LOmd9liHTOXHDABkKJLSdxgEdd4dJ3MZ9srFCF3PvQI-Y60SDGyfOLYBqzmVg8BfEO7A-EqxLkpkXLZQkA1gvZpP288rvTI-DpwKKaGrzAfGmlv164VQDfJzaWYKpPTj9MA3Yg\";}', NULL, NULL, NULL, NULL, NULL, NULL, '20220024802@my.xu.edu.ph', NULL, 'KIAN ALVAREZ PORRAS', 'KIAN ALVAREZ', 'PORRAS', NULL, NULL, NULL, '{\"provider\":\"google\",\"access_token\":{},\"identifier\":\"107198915122772613198\",\"first_name\":\"KIAN ALVAREZ\",\"last_name\":\"PORRAS\",\"email\":\"20220024802@my.xu.edu.ph\",\"email_verified\":true,\"full_name\":\"KIAN ALVAREZ PORRAS\",\"picture_url\":\"https:\\/\\/lh3.googleusercontent.com\\/a\\/ACg8ocJYfXbJtGX6ECdt1gkuEg9dVC-mvxz-FcBOvcSnauUYJiXlTw=s96-c\"}', '2025-05-21 13:07:48', '2025-05-23 03:33:36');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `role` enum('borrower','admin') NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `otp_code` varchar(6) DEFAULT NULL,
  `otp_expires_at` datetime DEFAULT NULL,
  `is_verified` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role`, `name`, `email`, `password`, `created`, `modified`, `otp_code`, `otp_expires_at`, `is_verified`) VALUES
(1, 'admin', 'Admin User', 'admin@example.com', '', '2025-04-18 18:29:19', '2025-04-18 18:29:19', NULL, NULL, 0),
(13, 'borrower', 'Charlie Brown', 'brown@gmail.com', '$2y$10$/aPHv2GoG4uaZkVhW1vX8Optvq0WUKSPMK.dxnVfqRvy.fuVWfW/K', '2025-04-18 11:44:23', '2025-04-18 11:44:23', NULL, NULL, 0),
(14, 'borrower', 'practice', 'prac@gmail.com', '$2y$10$ZQZZGGsFDe9/K7/zOHXf8uhV5jPRfXl1oB4lfcXZJgbYt6oLK3P5e', '2025-04-18 12:04:52', '2025-04-18 12:04:52', NULL, NULL, 0),
(16, 'admin', 'Admin User', 'kianadmin@gmail.com', '$2y$10$mVutmVd9PH5sU5vSUcYYBOkWQCxbaeBKHje5dp7N3KYLeUPKluoIu', '2025-04-18 22:06:21', '2025-04-18 22:06:21', NULL, NULL, 0),
(18, 'borrower', 'Lebron', 'lebron@gmail.com', '$2y$10$mrNlnqW6rRrraarjjm86o.r7eaZiDNg0sW.MhzEIPUM.ieMk5cirC', '2025-04-30 09:21:58', '2025-04-30 09:21:58', NULL, NULL, 0),
(20, 'borrower', 'Brown King', 'browney@gmail.com', '$2y$10$2sWLFjSdbCnkZWfHeBhtUuQ8LczML9mqxj0Z305X5MuQh/vfUazSC', '2025-05-02 16:36:54', '2025-05-02 16:36:54', NULL, NULL, 0),
(21, 'borrower', 'Blackey', '20220024809@my.xu.edu.ph', '$2y$10$mawxiDCVTrTX/X6di4MvA.XOMOv73KVo7waUzDcz.NRTzC6mma/Bq', '2025-05-02 16:39:40', '2025-05-02 16:39:40', NULL, NULL, 0),
(42, 'borrower', 'KIAN ALVAREZ PORRAS', '20220024802@my.xu.edu.ph', '', '2025-05-21 21:07:48', '2025-05-21 21:07:48', NULL, NULL, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `borrow_requests`
--
ALTER TABLE `borrow_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_inventory_item` (`inventory_item_id`),
  ADD KEY `fk_borrow_requests_user_id` (`user_id`);

--
-- Indexes for table `inventory_items`
--
ALTER TABLE `inventory_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `social_profiles`
--
ALTER TABLE `social_profiles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `provider_identifier_unique` (`provider`,`identifier`),
  ADD KEY `fk_social_profiles_user_id` (`user_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT for table `inventory_items`
--
ALTER TABLE `inventory_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `social_profiles`
--
ALTER TABLE `social_profiles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `borrow_requests`
--
ALTER TABLE `borrow_requests`
  ADD CONSTRAINT `borrow_requests_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_borrow_requests_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_inventory_item` FOREIGN KEY (`inventory_item_id`) REFERENCES `inventory_items` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `social_profiles`
--
ALTER TABLE `social_profiles`
  ADD CONSTRAINT `fk_social_profiles_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `social_profiles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
