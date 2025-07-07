-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 07, 2025 at 09:04 AM
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
-- Database: `mobile_review`
--

-- --------------------------------------------------------

--
-- Table structure for table `application_reviews`
--

CREATE TABLE `application_reviews` (
  `id` int(11) NOT NULL,
  `app_name` varchar(255) NOT NULL,
  `review` text DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `category_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `description` text NOT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `application_reviews`
--

INSERT INTO `application_reviews` (`id`, `app_name`, `review`, `image_path`, `is_active`, `category_id`, `created_at`, `updated_at`, `description`, `user_id`) VALUES
(1, 'pou', 'good', '', 1, 2, '2025-07-07 13:20:50', '2025-07-07 13:20:50', '', NULL),
(2, 'pou', 'good', '', 1, 2, '2025-07-07 13:25:30', '2025-07-07 13:25:30', '', NULL),
(3, 'whatsapp', 'easy to use', '', 1, 13, '2025-07-07 13:25:44', '2025-07-07 13:25:44', '', NULL),
(4, 'pou', 'ok', 'uploads/686b5e4a0c9f1_Screenshot 2024-11-27 130936.png', 1, 10, '2025-07-07 13:42:34', '2025-07-07 13:42:34', '', NULL),
(5, 'sleepcycle', 'bes', 'uploads/686b68a6cdc36_photo_6215314562534721620_y (1).jpg', 1, 9, '2025-07-07 14:26:46', '2025-07-07 14:26:46', '', NULL),
(6, 'sleepcycle', 'bes', 'uploads/686b68c6762da_photo_6215314562534721620_y (1).jpg', 1, 9, '2025-07-07 14:27:18', '2025-07-07 14:27:18', '', NULL),
(7, 'sleepcycle', 'bes', 'uploads/686b68ca8cefe_photo_6215314562534721620_y (1).jpg', 1, 9, '2025-07-07 14:27:22', '2025-07-07 14:27:22', '', NULL),
(8, 'sleepcycle', 'bes', 'uploads/686b691146d7c_photo_6215314562534721620_y (1).jpg', 1, 9, '2025-07-07 14:28:33', '2025-07-07 14:28:33', '', 2),
(9, 'sleepcycle', 'bes', 'uploads/686b6946b8491_photo_6215314562534721620_y (1).jpg', 1, 9, '2025-07-07 14:29:26', '2025-07-07 14:29:26', '', 2),
(10, 'sleepcycle', 'bes', 'uploads/686b695f036fc_photo_6215314562534721620_y (1).jpg', 1, 9, '2025-07-07 14:29:51', '2025-07-07 14:29:51', '', 2),
(12, 'sleepcycle', 'bes', 'uploads/686b699556c70_photo_6215314562534721620_y (1).jpg', 1, 9, '2025-07-07 14:30:45', '2025-07-07 14:30:45', '', 2),
(13, 'canva', 'it is good', 'uploads/686b69bae8b3c_Screenshot 2024-11-27 130936.png', 1, 11, '2025-07-07 14:31:22', '2025-07-07 14:31:22', '', 2),
(15, 'cat home', 'okay', 'uploads/686b6b69c08fe_photo_6278402465267304299_m.jpg', 1, 10, '2025-07-07 14:38:33', '2025-07-07 14:38:33', '', 2),
(18, 'grab', 'okay', 'uploads/686b70e26d1da_OIP (1).jpg', 1, 14, '2025-07-07 15:01:54', '2025-07-07 15:01:54', '', 8);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `modified` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `title`, `status`, `created`, `modified`) VALUES
(2, 'pou', 1, '2025-07-07 12:51:11', '2025-07-07 12:51:11'),
(9, 'Fitness', 1, '2025-07-07 13:25:09', '2025-07-07 13:25:09'),
(10, 'Entertainment', 1, '2025-07-07 13:25:09', '2025-07-07 13:25:09'),
(11, 'Education', 1, '2025-07-07 13:25:09', '2025-07-07 13:25:09'),
(12, 'Finance', 1, '2025-07-07 13:25:09', '2025-07-07 13:25:09'),
(13, 'Social Media', 1, '2025-07-07 13:25:09', '2025-07-07 13:25:09'),
(14, 'Productivity', 1, '2025-07-07 13:25:09', '2025-07-07 13:25:09'),
(15, 'kpop', 1, '2025-07-07 15:03:25', '2025-07-07 15:03:25');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `application_review_id` int(11) DEFAULT NULL,
  `comment_text` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  `avatar` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `full_name`, `username`, `password`, `role`, `avatar`, `created_at`) VALUES
(1, '', 'qilash', '$2y$10$8qLHhmCz./Z2mYSUgZiKnOgW5gl4uDPjbrJ.7axqM1KdJDn8DXWdS', 'user', NULL, '2025-07-07 06:02:56'),
(2, '', 'qila', '$2y$10$VZovd4TCyhYUoC4xOJjBfu8fXH6mNFSo3Sh9Wg7xfgXgOz1ngwZsm', 'user', NULL, '2025-07-07 06:03:11'),
(4, '', 'arifatun', '$2y$10$glt1GmWPfBkjbPsV8pZNsOyFjvatEUZdk4CEOC2Wms2OtdA0n826.', 'admin', NULL, '2025-07-07 06:05:23'),
(5, '', 'aqilah', '$2y$10$67OKsL08Bqvch2Bm.y1nEOcYS2PmcmeJvLA3tf5zawqPmWVEbIODC', 'user', NULL, '2025-07-07 06:52:03'),
(6, '', 'alya', '$2y$10$THczxkir8dOiQbtvFPtyauQP5/ocIAwhVcT.QEu9qMsbGkZWZ9KNy', 'user', NULL, '2025-07-07 06:54:57'),
(8, '', 'arifatunaqilah', '$2y$10$xykz0qluKlxkpp2RNmvtY.jaTZ1weFIlDIblZCKeG1oPUqPPcF/Le', 'user', NULL, '2025-07-07 07:00:35');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `application_reviews`
--
ALTER TABLE `application_reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `application_review_id` (`application_review_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `application_reviews`
--
ALTER TABLE `application_reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `application_reviews`
--
ALTER TABLE `application_reviews`
  ADD CONSTRAINT `application_reviews_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`application_review_id`) REFERENCES `application_reviews` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
