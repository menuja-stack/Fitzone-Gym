-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 05, 2024 at 06:32 AM
-- Server version: 8.3.0
-- PHP Version: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `login_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

DROP TABLE IF EXISTS `feedback`;
CREATE TABLE IF NOT EXISTS `feedback` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `user_id`, `message`, `created_at`) VALUES
(1, 2, 'super workouts sir and i lose weight well', '2024-11-02 04:09:45'),
(7, 7, 'hi', '2024-11-05 06:14:24'),
(4, 2, 'hi', '2024-11-02 07:23:09'),
(6, 2, 'nice process. I\'m so satisfied. ', '2024-11-04 09:33:14'),
(8, 8, 'abcd', '2024-11-05 06:20:46');

-- --------------------------------------------------------

--
-- Table structure for table `plans`
--

DROP TABLE IF EXISTS `plans`;
CREATE TABLE IF NOT EXISTS `plans` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` text,
  `price_per_month` decimal(10,2) NOT NULL,
  `features` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `plans`
--

INSERT INTO `plans` (`id`, `name`, `description`, `price_per_month`, `features`) VALUES
(1, 'Basic', 'Perfect for beginners', 5000.00, 'Smart workout plans\r\nAt Home workouts'),
(2, 'Pro', 'For dedicated fitness enthusiasts', 8000.00, 'Smart workout plans\r\npro Gym workouts\r\nDiet Plans'),
(3, 'Premium', 'Ultimate fitness experience', 10000.00, 'Smart workout plans\r\npro Gym workouts\r\nDiet Plans\r\nPersonal Traning');

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

DROP TABLE IF EXISTS `subscriptions`;
CREATE TABLE IF NOT EXISTS `subscriptions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `plan_id` int DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_months` date NOT NULL,
  `duration_month` date NOT NULL,
  `statues` int DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `plan_id` (`plan_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `subscriptions`
--

INSERT INTO `subscriptions` (`id`, `user_id`, `plan_id`, `start_date`, `end_months`, `duration_month`, `statues`, `created_at`) VALUES
(1, 4, 1, '2024-11-05', '2024-12-05', '0000-00-00', 0, '2024-11-05 05:41:16'),
(2, 5, 1, '2024-11-05', '2024-12-05', '0000-00-00', 0, '2024-11-05 06:08:30'),
(3, 3, 2, '2024-11-05', '2025-05-05', '0000-00-00', 0, '2024-11-05 06:12:53'),
(4, 8, 2, '2024-11-05', '2025-02-05', '0000-00-00', 0, '2024-11-05 06:20:28');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `user_type` enum('user','admin') DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `user_type`, `created_at`) VALUES
(1, 'menuja', '$2y$10$gAQ2GYLjP8ccyPouR4lVseOUuXUNkahk6kebnr78Lwt5peGL3rgUS', 'menujaaluthwathe@gmail.com', 'admin', '2024-11-02 03:45:06'),
(2, 'pavi', '$2y$10$ue6QqPEHGLF2LwXLy.QaCuezAfzdztybH0AgJ8CfuPYr45KS5Sdei', 'pavi@gmail.com', 'admin', '2024-11-02 03:49:42'),
(3, 'anoj', '$2y$10$fiVj96GgZ20mgc.BY0jRMuZ0YPR/cktnDKRUlRF6/mjDlfnGyyt/2', 'anoj@gmail.com', 'user', '2024-11-05 06:19:44'),
(4, 'anusha', '$2y$10$9dXSHZaJ5ZEMGAg1f33v8OvRDd27HywfvO9UdLjg98Dije2ae4aN6', 'anusha@gmail.com', 'user', '2024-11-02 04:11:51'),
(5, 'hasini', '$2y$10$YzH.1LLeIyYSoYSaKiz7Vu/PJ6GYFmvQ.U.vC5pOduVacBb0L1REa', 'hasini@gmail.com', 'user', '2024-11-05 04:38:14');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
