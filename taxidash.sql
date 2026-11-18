-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 18, 2026 at 09:34 AM
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
-- Database: `taxidash`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_concern`
--

CREATE TABLE `tbl_concern` (
  `id` int(11) NOT NULL,
  `conversation_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `timestamp` timestamp NULL DEFAULT current_timestamp(),
  `status` enum('sent','delivered','read') DEFAULT 'sent'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_concern`
--

INSERT INTO `tbl_concern` (`id`, `conversation_id`, `sender_id`, `receiver_id`, `message`, `timestamp`, `status`) VALUES
(1, 13, 11, 17, 'Hoo', '2024-12-30 16:46:10', 'sent'),
(2, 13, 5, 11, 'goods ba', '2024-12-30 16:46:29', 'sent'),
(3, 13, 5, 11, 'oo', '2024-12-30 16:46:39', 'sent'),
(4, 13, 11, 17, 'Oo', '2024-12-30 16:46:44', 'sent'),
(5, 13, 5, 11, 'k', '2024-12-30 16:47:03', 'sent'),
(6, 13, 11, 17, 'Zzz', '2024-12-30 16:47:22', 'sent'),
(7, 13, 11, 17, 'Meow', '2024-12-30 16:47:39', 'sent'),
(8, 13, 5, 11, 'hii', '2024-12-30 16:49:03', 'sent'),
(9, 13, 5, 11, 'grrrr', '2024-12-30 16:49:21', 'sent'),
(10, 13, 5, 11, 'hh', '2024-12-30 16:50:12', 'sent'),
(11, 13, 5, 11, 'hii', '2024-12-30 16:51:24', 'sent'),
(12, 13, 11, 17, 'Oks na', '2024-12-30 16:51:30', 'sent'),
(13, 13, 5, 11, 'dsadsa', '2024-12-30 16:51:54', 'sent'),
(14, 13, 11, 17, 'Magblue ka', '2024-12-30 16:52:26', 'sent'),
(15, 13, 5, 11, 'admin lue', '2024-12-30 16:52:34', 'sent'),
(16, 13, 5, 11, 'loo', '2024-12-30 16:52:48', 'sent'),
(17, 13, 5, 11, 'meow', '2024-12-30 16:52:58', 'sent'),
(18, 13, 5, 11, 'hiii', '2024-12-30 16:53:22', 'sent'),
(19, 13, 11, 17, 'Hello', '2024-12-30 16:53:25', 'sent'),
(20, 13, 5, 11, 'meron', '2024-12-30 16:53:46', 'sent'),
(21, 13, 5, 11, 'gods?', '2024-12-30 16:53:51', 'sent'),
(22, 13, 11, 17, 'Okay na', '2024-12-30 16:53:58', 'sent'),
(23, 13, 11, 17, 'Gegege', '2024-12-30 16:54:03', 'sent'),
(24, 12, 10, 17, 'Buhay kapa?', '2024-12-30 16:54:49', 'sent'),
(25, 12, 5, 10, 'oo', '2024-12-30 16:54:57', 'sent'),
(26, 12, 10, 17, 'Good', '2024-12-30 16:55:02', 'sent'),
(27, 12, 5, 10, 'nice', '2024-12-30 16:55:08', 'sent'),
(28, 14, 17, 17, 'hello', '2025-02-24 08:39:16', 'sent'),
(29, 14, 5, 17, 'GHAISDUGHIASJKD', '2025-02-24 08:40:09', 'sent'),
(30, 16, 5, 24, 'hghdf', '2026-10-28 03:24:46', 'sent'),
(31, 16, 5, 17, 'ddgg', '2026-10-28 03:24:53', 'sent');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_messages`
--

CREATE TABLE `tbl_messages` (
  `id` int(11) NOT NULL,
  `conversation_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `timestamp` timestamp NULL DEFAULT current_timestamp(),
  `status` enum('sent','delivered','read') DEFAULT 'sent'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_messages`
--

INSERT INTO `tbl_messages` (`id`, `conversation_id`, `sender_id`, `receiver_id`, `message`, `timestamp`, `status`) VALUES
(1, 2, 4, 22, 'Kupal', '2025-03-10 07:57:59', 'sent'),
(2, 2, 22, 17, 'hello', '2025-03-10 07:58:18', 'sent'),
(3, 2, 4, 22, 'Ugh', '2025-03-10 07:58:36', 'sent'),
(4, 3, 4, 22, 'hh', '2025-03-10 08:01:08', 'sent'),
(5, 3, 22, 17, 'Ugh', '2025-03-10 08:01:11', 'sent'),
(6, 3, 22, 17, 'Shit', '2025-03-10 08:01:17', 'sent'),
(7, 3, 4, 22, 'ughhh', '2025-03-10 08:01:30', 'sent'),
(8, 6, 23, 17, 'kupal', '2026-10-28 02:17:26', 'sent'),
(9, 6, 23, 23, 'kupal ka den', '2026-10-28 02:17:36', 'sent'),
(10, 21, 24, 17, 'hgh', '2026-10-28 06:35:48', 'sent'),
(11, 21, 4, 24, 'hi', '2026-10-28 06:35:55', 'sent'),
(12, 21, 24, 17, 'fsdd', '2026-10-28 06:36:01', 'sent'),
(13, 22, 4, 24, 'hi', '2026-10-28 07:18:11', 'sent'),
(14, 22, 24, 4, 'Hello Driver', '2026-10-28 07:24:16', 'sent'),
(15, 22, 24, 4, 'hii', '2026-10-28 07:26:26', 'sent');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_ratings`
--

CREATE TABLE `tbl_ratings` (
  `id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `driver_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `feedback` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_ratings`
--

INSERT INTO `tbl_ratings` (`id`, `booking_id`, `user_id`, `driver_id`, `rating`, `feedback`, `created_at`) VALUES
(1, 4, 16, 4, 5, 'Very safe and fast driving!', '2026-10-28 03:18:44'),
(3, 13, 16, 4, 5, 'Smooth ride and very polite driver! Highly recommended.', '2026-10-28 06:10:30'),
(4, 14, 24, 0, 5, '', '2026-10-28 06:14:58'),
(5, 15, 24, 4, 5, 'kupal sya', '2026-10-28 06:24:43'),
(6, 21, 24, 4, 5, 'rarw', '2026-10-28 06:38:23');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `id` int(11) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `middlename` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `contact` varchar(15) DEFAULT NULL,
  `profile_photo` varchar(255) DEFAULT NULL,
  `valid_id` varchar(255) DEFAULT NULL,
  `plate` varchar(20) NOT NULL,
  `address_proof` varchar(255) DEFAULT 'gcash.png',
  `user_type` enum('user','driver','admin') NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`id`, `firstname`, `middlename`, `lastname`, `email`, `password`, `contact`, `profile_photo`, `valid_id`, `plate`, `address_proof`, `user_type`, `created_at`, `updated_at`, `status`) VALUES
(1, 'Angge', NULL, 'Pannig', 'malazarako@gmail.com', '123456', '09366583068', 'driver.jpg', NULL, 'ABC 123', NULL, 'user', '2024-12-18 02:28:29', '2025-01-13 00:44:54', 0),
(4, 'Ivan', NULL, 'Jade', 'driver@gmail.com', '12345678', '09526212790', 'driver.jpg', NULL, 'DAG 342', 'IMG_20250224_084535.jpg', 'driver', '2024-12-18 02:28:29', '2025-02-24 00:49:55', 1),
(5, 'Admin', NULL, 'admin', 'admin@gmail.com', '123456', '09366583068', 'driver.jpg', NULL, 'ABC 123', NULL, 'admin', '2024-12-18 02:28:29', '2026-10-28 02:26:40', 1),
(6, 'Ivan', NULL, 'Lugo', 'lugoivanjade@gmail.com', 'lugo', '09618379175', NULL, NULL, '', NULL, 'user', '2024-12-18 03:40:46', '2024-12-18 03:40:46', 1),
(8, 'Ivan', NULL, 'Jade', 'driver2@gmail.com', '123456', '09366583068', 'driver.jpg', NULL, 'CAG 342', NULL, 'driver', '2024-12-18 02:28:29', '2024-12-30 04:39:36', 0),
(9, 'Meynard', NULL, 'Marquez', 'penxelmar@gmail.com', '12345', '09760255751', 'driver-icon-isolated-on-white-background-vector.jpg', NULL, 'CAF02532', NULL, 'driver', '2024-12-30 13:12:55', '2024-12-30 07:11:31', 1),
(10, 'Edson ', NULL, 'moon', 'eljohnmalazar3@gmail.com', '12345678', '0955142151', '1701247697670.jpg', NULL, 'ABC 123', 'Screenshot_20241222_133436_com.globe.gcash.android.png', 'driver', '2024-12-30 15:38:17', '2025-01-12 13:22:30', 1),
(11, 'Adrian', NULL, 'Ammugauan', 'Edzonemalazar@gmail.com', '12345', '09526212790', 'Screenshot 2024-12-30 at 1.17.09â€¯PM.png', NULL, '', NULL, 'user', '2024-12-30 07:44:31', '2024-12-30 09:21:14', 1),
(12, 'Pass', NULL, 'Engeer', 'user@gmail.com', '123456', '0952631275679', NULL, NULL, '', 'gcash.png', 'user', '2025-01-04 10:56:42', '2025-02-24 00:39:27', 0),
(13, 'Edward', NULL, 'Lopez', 'edward@gmail.com', 'Lopez', '09657158189', 'IMG_20230521_170647-02.jpeg', NULL, 'BIK555', 'GCash-MyQR-24122024200555.PNG.jpg', 'driver', '2025-01-12 20:37:17', '2025-01-12 13:00:12', 1),
(14, 'ban', NULL, 'jade', 'ban@gmail.com', '1234', '09618379175', NULL, NULL, '', 'gcash.png', 'user', '2025-01-12 12:47:03', '2025-01-12 12:47:03', 1),
(15, 'Edward ', NULL, 'Garma', 'garmaedward@gmail.com', '123456', '093665325422', 'Screenshot_20241220_153738_com.paymaya.jpg', NULL, 'ZYS 6183', 'Screenshot_20250111_203729_com.facebook.orca.jpg', 'user', '2025-01-12 12:47:43', '2025-01-12 12:56:07', 1),
(16, 'Joanard', NULL, 'Soriano', 'josoriano@gmail.com', '123456', '09655314684', '1701247697670.jpg', NULL, '', 'gcash.png', 'user', '2025-01-12 12:49:55', '2025-01-12 12:50:45', 1),
(17, 'isu', NULL, 'cauayan', 'isu@gmail.com', '1234', '09757749877', 'Screenshot_20250217-155959_Gallery.jpg', NULL, '', 'gcash.png', 'user', '2025-02-24 00:32:09', '2025-02-24 03:21:39', 1),
(18, 'driver3', NULL, 'drive', 'driver3@gmail.com', 'drive', '0987654312', 'd1.jpg', NULL, 'UFS 321', 'gcash.png', 'driver', '2025-02-24 08:53:47', '2025-02-24 00:54:54', 0),
(20, 'Russel', NULL, 'driver', 'russ@gmail.com', 'driver', '0987654312', 'd1.jpg', NULL, 'UFS 321', 'gcash.png', 'driver', '2025-02-24 08:55:25', '2025-02-24 00:55:25', 1),
(21, 'Jeriel', NULL, 'Talosig', 'jerieltalosig3@gmail.com', 'Qwerty#123', '09385029314', NULL, NULL, '', 'gcash.png', 'user', '2025-02-24 03:22:02', '2025-02-24 03:22:02', 1),
(22, 'jj', NULL, 'j', 'jj@gmail.com', '1234', '09657158189', 'FB_IMG_1737639399757.jpg', NULL, '', 'gcash.png', 'user', '2025-02-25 05:36:12', '2025-02-27 02:53:53', 1),
(23, 'eds', NULL, 'Respicio', 'respicioricney1984@gmail.com', '123456', '09657158189', NULL, NULL, '', 'gcash.png', 'user', '2026-10-28 02:15:39', '2026-10-28 02:15:39', 1),
(24, 'rarw', NULL, 'rawr', 'rawr@gmail.com', '123456', '067643476677668', NULL, NULL, '', 'gcash.png', 'user', '2026-10-28 02:28:24', '2026-10-28 07:03:42', 1);

-- --------------------------------------------------------

--
-- Table structure for table `temp_ride_bookings`
--

CREATE TABLE `temp_ride_bookings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `driver_id` int(11) NOT NULL,
  `pickup_location` varchar(255) NOT NULL,
  `pickup_lat` decimal(10,8) NOT NULL,
  `pickup_lng` decimal(11,8) NOT NULL,
  `dropoff_location` varchar(255) NOT NULL,
  `dropoff_lat` decimal(10,8) NOT NULL,
  `dropoff_lng` decimal(11,8) NOT NULL,
  `drvLoc_lng` varchar(100) NOT NULL,
  `drvLoc_lat` varchar(100) NOT NULL,
  `ride_type` enum('standard','premium','van') NOT NULL,
  `payVia` varchar(30) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `proof` varchar(200) NOT NULL,
  `remarks` varchar(300) NOT NULL,
  `status` tinyint(4) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `temp_ride_bookings`
--

INSERT INTO `temp_ride_bookings` (`id`, `user_id`, `driver_id`, `pickup_location`, `pickup_lat`, `pickup_lng`, `dropoff_location`, `dropoff_lat`, `dropoff_lng`, `drvLoc_lng`, `drvLoc_lat`, `ride_type`, `payVia`, `price`, `proof`, `remarks`, `status`, `created_at`) VALUES
(1, 22, 4, 'Ilagan, Isabela, Cagayan Valley, 3300, Philippines', 17.12559790, 121.87901950, 'Maharlika Highway, Rizaluna, Isabela, Cagayan Valley, Philippines', 16.84734630, 121.74963210, '121.8759384', '17.1169866', 'standard', 'gcash', 557.93, 'payment_67ce2960684110.24886262.png', '', 7, '2025-03-10 07:50:18'),
(2, 22, 4, 'Ilagan, Isabela, Cagayan Valley, 3300, Philippines', 17.12559790, 121.87901950, 'Maharlika Highway, Guibang, Isabela, Cagayan Valley, 3301, Philippines', 17.07122953, 121.85363822, '121.8759384', '17.1169866', 'standard', 'gcash', 149.30, 'payment_67ce2ae2caacc7.33931408.jpg', '', 7, '2025-03-10 07:56:12'),
(3, 22, 4, 'BLISS Village, Ilagan, Isabela, Cagayan Valley, 3300, Philippines', 17.11698660, 121.87593840, 'Maharlika Highway, District II, Cauayan, Isabela, Cagayan Valley, 3305, Philippines', 16.93854630, 121.76804245, '121.8790195', '17.1255979', 'standard', 'gcash', 393.79, 'payment_67ce2baea87514.77318531.jpg', '', 7, '2025-03-10 08:00:11'),
(4, 22, 4, 'Adventist University - Northeast Luzon Campus, Maharlika Highway, Midtown Subdivision, Alicia, Isabela, Cagayan Valley, 3306, Philippines', 16.81275231, 121.72439575, 'Antonino, Alicia, Isabela, Cagayan Valley, 3306, Philippines', 16.78908821, 121.70413971, '121.8759397', '17.1169848', 'standard', 'gcash', 101.03, 'payment_67cf11a38c7d59.64699070.png', '', 7, '2025-03-11 00:21:03'),
(5, 4, 0, 'Victory Liner Bus Terminal, Gangan Avenue, San Vicente, Ilagan, Isabela, Cagayan Valley, 3300, Philippines', 17.14344875, 121.88835795, 'La Fortuna Homes, Paddad, Isabela, Cagayan Valley, 3306, Philippines', 16.81180744, 121.72233582, '', '', 'standard', '', 0.00, '', '', 1, '2026-10-28 01:56:27'),
(6, 23, 23, 'Victory Liner Bus Terminal, Gangan Avenue, San Vicente, Ilagan, Isabela, Cagayan Valley, 3300, Philippines', 17.14344977, 121.88835733, 'M. H. del Pilar, Isabela, Cagayan Valley, Philippines', 16.84236934, 121.75014496, '121.88834082684544', '17.143450302736053', 'standard', 'gcash', 598.44, 'payment_6ae15b1c0067a1.64611111.png', '', 6, '2026-10-28 02:16:24'),
(13, 16, 4, 'Cauayan City Hall, Isabela', 16.93120000, 121.77450000, 'SM City Cauayan, Isabela', 16.92480000, 121.76980000, '121.7750', '16.9320', 'standard', 'gcash', 85.50, '', '', 7, '2026-10-28 06:10:30'),
(16, 16, 0, 'Ilagan Capitol', 17.14000000, 121.88000000, 'Cauayan Airport', 16.93000000, 121.75000000, '', '', 'standard', 'gcash', 120.00, '', '', 0, '2026-10-28 06:20:54'),
(21, 24, 4, 'Rizal, Isabela, Cagayan Valley, 3306, Philippines', 16.83610795, 121.67890549, 'Rizal Avenue, Centro Poblacion, Ilagan, Isabela, Cagayan Valley, 3300, Philippines', 17.14973242, 121.88839674, '121.88836993287697', '17.143450513089647', 'standard', 'gcash', 670.72, 'payment_6ae197b2d0e373.62401540.jpg', 'sgs', 7, '2026-10-28 06:34:27'),
(22, 24, 4, 'Maharlika Highway, BLISS, Labinab Pequeño, Nappaccu Grande, Isabela, Cagayan Valley, 3302, Philippines', 16.98915875, 121.80404663, 'District I, Reina Mercedes, Isabela, Cagayan Valley, 3302, Philippines', 16.98505445, 121.83219910, '121.88833989789187', '17.14345286177188', 'standard', 'gcash', 95.43, 'payment_6ae1a1856aeff2.55445179.jpg', '', 7, '2026-10-28 07:07:06');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `ticket_id` int(11) NOT NULL,
  `submission_date` datetime NOT NULL,
  `subject` varchar(255) NOT NULL,
  `description` varchar(500) NOT NULL,
  `last_updated` datetime NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_contact` varchar(100) NOT NULL,
  `priority` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`ticket_id`, `submission_date`, `subject`, `description`, `last_updated`, `user_name`, `user_email`, `user_contact`, `priority`, `user_id`, `status`) VALUES
(1, '2024-09-20 10:15:00', 'Unable to reset password', '', '2024-12-17 23:09:24', 'John Doe', 'johndoe@example.com', '1', 'High', 1, '1'),
(3, '2024-12-17 22:34:03', '534534', '43534534', '2024-12-17 23:21:50', '', '', '', '', 1, '2'),
(5, '2024-12-17 22:45:35', 'Test Issue', 'Test Subject', '2025-01-12 12:32:59', '', '', '', '', 8, '3'),
(11, '2024-12-30 12:04:22', 'sdsad', 'asdsadasdas', '2024-12-30 04:27:42', '', '', '', '', 4, '1'),
(12, '2024-12-30 15:53:43', 'huy', 'rdydfjfg', '2024-12-30 07:57:03', '', '', '', '', 10, '1'),
(13, '2024-12-30 16:00:09', 'Blehh', '', '2024-12-30 08:01:04', '', '', '', '', 11, '1'),
(14, '2025-02-24 08:38:55', 'drunk driver', 'last transaction', '2025-02-24 00:39:57', '', '', '', '', 17, '1'),
(15, '2026-10-28 11:19:11', 'EMERGENCY SOS ALERT - Trip #4', 'URGENT: Passenger Joanard Soriano triggered the SOS emergency button on Trip #4 at 2026-10-28 11:19:11. Immediate assistance required.', '2026-10-28 11:19:11', 'Joanard Soriano', 'josoriano@gmail.com', '09655314684', 'Urgent', 16, '0'),
(16, '2026-10-28 11:24:11', 'tyhd', 'dghdf', '2026-10-28 11:24:38', '', '', '', '', 24, '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_concern`
--
ALTER TABLE `tbl_concern`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_messages`
--
ALTER TABLE `tbl_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_ratings`
--
ALTER TABLE `tbl_ratings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `temp_ride_bookings`
--
ALTER TABLE `temp_ride_bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`ticket_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_concern`
--
ALTER TABLE `tbl_concern`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `tbl_messages`
--
ALTER TABLE `tbl_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tbl_ratings`
--
ALTER TABLE `tbl_ratings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `temp_ride_bookings`
--
ALTER TABLE `temp_ride_bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `ticket_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
