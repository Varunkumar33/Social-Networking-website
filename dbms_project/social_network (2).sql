-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3307
-- Generation Time: Feb 05, 2023 at 07:31 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `social_network`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `com_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` varchar(255) NOT NULL,
  `comment_author` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`com_id`, `post_id`, `user_id`, `comment`, `comment_author`, `date`) VALUES
(2, 7, 1, 'hello varun', 'anish_krishna_657716', '2023-01-20 19:59:53'),
(4, 9, 2, 'good', 'ramesh_kumar_326361', '2023-01-21 07:12:23'),
(6, 10, 7, 'hi!', 'varun_kumar_791399', '2023-01-28 16:57:55'),
(7, 7, 1, 'awesome bro!', 'guru_l_158341', '2023-01-29 10:53:01');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `user_id` int(20) NOT NULL,
  `post_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`user_id`, `post_id`) VALUES
(1, 9),
(2, 12),
(2, 13),
(8, 7),
(9, 9),
(9, 12);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_content` varchar(255) NOT NULL,
  `upload_image` varchar(255) NOT NULL,
  `post_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `user_id`, `post_content`, `upload_image`, `post_date`) VALUES
(7, 1, ' hello egale', 'eagle.jpg.49', '2023-01-20 19:53:55'),
(9, 2, ' KL RAHUL', 'kl rahul.jpg.43', '2023-01-21 06:35:23'),
(10, 7, ' hello', '', '2023-01-21 07:11:46'),
(12, 8, ' ', 'cars1.jfif.39', '2023-01-29 10:51:10'),
(13, 9, ' ', 'bike cgt.jfif.34', '2023-01-29 11:07:18'),
(14, 1, ' ', 'CantinaBand3.wav.54', '2023-02-04 18:33:48');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `f_name` text NOT NULL,
  `l_name` text NOT NULL,
  `user_name` text NOT NULL,
  `describe_user` varchar(225) NOT NULL,
  `Relationship` text NOT NULL,
  `user_pass` varchar(255) NOT NULL,
  `user_email` varchar(225) NOT NULL,
  `user_country` text NOT NULL,
  `user_gender` text NOT NULL,
  `user_birthday` text NOT NULL,
  `user_image` varchar(255) NOT NULL,
  `user_cover` varchar(255) NOT NULL,
  `user_reg_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` text NOT NULL,
  `posts` text NOT NULL,
  `recovery_account` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `f_name`, `l_name`, `user_name`, `describe_user`, `Relationship`, `user_pass`, `user_email`, `user_country`, `user_gender`, `user_birthday`, `user_image`, `user_cover`, `user_reg_date`, `status`, `posts`, `recovery_account`) VALUES
(1, 'Varun', 'Kumar', 'varun_kumar_791399', 'Hello Instabook. This is my default status!', '....', '1234567890', 'bvk9019@gmail.com', 'India', 'Male', '2002-04-17', 'head_blue.png', 'eagle.jpg.91.60', '2023-01-20 19:43:57', 'verified', 'yes', 'Iwanttoputadingintheuniverse.'),
(2, 'Anish', 'Krishna', 'anish_krishna_657716', 'Hello Instabook. This is my default status!', '....', '1234567890', 'anish@gmail.com', 'India', 'Male', '2002-05-10', 'head_pink.png', 'default_cover.jpg', '2023-01-20 19:55:57', 'verified', 'yes', 'rahul'),
(7, 'Akash', 'Reddy', 'Akash_Reddy_326361', 'Hello Instabook. This is my default status!', 'Single', '1234567890', 'akashreddy@gmail.com', 'India', 'Male', '2023-01-21', 'head_pink.png', 'default_cover.jpg', '2023-01-21 07:11:03', 'verified', 'yes', 'Iwanttoputadingintheuniverse.'),
(8, 'Guru', 'L', 'guru_l_158341', 'Hello Instabook. This is my default status!', '....', '1234567890', 'guru@gmail.com', 'India', 'Male', '2002-03-29', 'head_pink.png', 'default_cover.jpg', '2023-01-29 10:49:34', 'verified', 'yes', 'Iwanttoputadingintheuniverse.'),
(9, 'Amartha', 'Shravan', 'amartha_shravan_583768', 'Hello Instabook. This is my default status!', '....', '1234567890', 'ashravan@gmail.com', 'India', 'Male', '2002-08-25', 'head_pink.png', 'default_cover.jpg', '2023-01-29 11:05:25', 'verified', 'yes', 'Iwanttoputadingintheuniverse.');

-- --------------------------------------------------------

--
-- Table structure for table `user_messages`
--

CREATE TABLE `user_messages` (
  `id` int(11) NOT NULL,
  `user_to` int(11) NOT NULL,
  `user_from` int(11) NOT NULL,
  `msg_body` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `msg_seen` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_messages`
--

INSERT INTO `user_messages` (`id`, `user_to`, `user_from`, `msg_body`, `date`, `msg_seen`) VALUES
(4, 1, 2, 'hello varun......how are you?', '2023-01-20 20:02:54', 'no'),
(5, 2, 1, 'I&#039;m fine anish.....how r u??', '2023-01-20 20:10:11', 'no'),
(6, 1, 1, 'hi anish', '2023-01-21 06:30:45', 'no'),
(7, 1, 7, 'hi', '2023-01-21 07:13:02', 'no'),
(8, 7, 1, 'hello', '2023-01-21 07:13:31', 'no'),
(10, 2, 1, 'hi', '2023-01-21 09:14:03', 'no'),
(11, 2, 1, 'hello bro\r\n', '2023-01-21 15:23:20', 'no'),
(12, 2, 2, 'hello bro\r\n', '2023-01-21 15:24:56', 'no'),
(13, 1, 2, 'hey bro', '2023-01-21 15:28:47', 'no');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`com_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`user_id`,`post_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_messages`
--
ALTER TABLE `user_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_to` (`user_to`,`user_from`),
  ADD KEY `user_from` (`user_from`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `com_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user_messages`
--
ALTER TABLE `user_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `user_messages`
--
ALTER TABLE `user_messages`
  ADD CONSTRAINT `user_messages_ibfk_1` FOREIGN KEY (`user_from`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `user_messages_ibfk_2` FOREIGN KEY (`user_to`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
