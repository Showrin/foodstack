-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 06, 2018 at 08:04 AM
-- Server version: 10.1.29-MariaDB
-- PHP Version: 7.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `foodstack`
--

-- --------------------------------------------------------

--
-- Table structure for table `friend_list`
--

CREATE TABLE `friend_list` (
  `serial` int(255) NOT NULL,
  `one_user_id` int(255) NOT NULL,
  `another_user_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `friend_list`
--

INSERT INTO `friend_list` (`serial`, `one_user_id`, `another_user_id`) VALUES
(4, 28, 18),
(5, 29, 20),
(6, 25, 20),
(7, 28, 17),
(8, 22, 17),
(9, 28, 19);

-- --------------------------------------------------------

--
-- Table structure for table `friend_requests`
--

CREATE TABLE `friend_requests` (
  `friend_request_id` int(255) NOT NULL,
  `getter_id` int(255) NOT NULL,
  `sender_id` int(255) NOT NULL,
  `date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `loves`
--

CREATE TABLE `loves` (
  `love_id` int(255) NOT NULL,
  `post_id` int(255) NOT NULL,
  `lover_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `loves`
--

INSERT INTO `loves` (`love_id`, `post_id`, `lover_id`) VALUES
(69, 2, 18),
(70, 13, 18),
(72, 15, 27),
(75, 6, 18),
(77, 11, 28),
(78, 15, 18),
(80, 12, 17),
(81, 2, 29),
(83, 15, 29),
(85, 17, 20),
(86, 6, 29),
(88, 18, 29),
(89, 17, 29),
(90, 15, 20),
(91, 17, 25),
(92, 7, 28),
(96, 15, 28);

-- --------------------------------------------------------

--
-- Table structure for table `menues`
--

CREATE TABLE `menues` (
  `menu_id` int(255) NOT NULL,
  `menu_name` varchar(255) NOT NULL,
  `average_rating` float NOT NULL,
  `restaurant_id` int(255) NOT NULL,
  `price` int(255) NOT NULL,
  `menu_pic` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menues`
--

INSERT INTO `menues` (`menu_id`, `menu_name`, `average_rating`, `restaurant_id`, `price`, `menu_pic`) VALUES
(1, 'Chicken Shawrma', 3, 1, 120, '1.jpg'),
(2, 'Beef Burger', 3, 1, 250, '2.jpg'),
(3, 'Lacchi', 3, 1, 60, '3.jpg'),
(4, 'Pastry Cake', 3, 2, 80, '4.jpg'),
(5, 'Fried Rice', 3, 2, 100, '5.jpg'),
(6, 'Chilli Chicken ', 5, 2, 220, '6.jpg'),
(7, 'Faluda', 3, 3, 150, '7.jpg'),
(8, 'Grilled Chicken', 3, 3, 120, '8.jpg'),
(9, 'Chicken Juicy Burger ', 3, 3, 250, '9.jpg'),
(10, 'Sub Sandwich ', 3, 4, 120, '10.jpg'),
(11, 'Pasta', 3, 4, 250, '11.jpg'),
(12, 'French Fry', 3, 4, 50, '12.jpg'),
(13, 'Chicken Biriyani', 3, 5, 130, '13.jpg'),
(14, 'Kacchi', 3, 5, 140, '14.jpg'),
(15, 'Morog Polao', 3, 5, 120, '15.jpg'),
(16, 'Coffee ', 3, 6, 120, '16.jpg'),
(17, 'Beef Steak', 3, 6, 600, '17.jpg'),
(18, 'Chicken Fry', 3, 6, 180, '18.jpg'),
(23, 'Beef Shawrma', 8, 7, 0, '23.jpg'),
(24, 'Sub Sandwich', 7, 7, 0, '24.jpg'),
(25, 'Hyderabadi Biryani', 10, 8, 0, '25.jpg'),
(28, 'Murog Polao', 9, 9, 0, '28.jpg'),
(29, 'Fish', 2, 2, 0, '29.jpg'),
(30, 'Chicken Juicy Burger', 9, 1, 0, '30.jpg'),
(32, 'Fish Fry', 7, 10, 0, '32.jpg'),
(33, 'murgi vuna', 10, 11, 0, '33.jpg'),
(34, 'Beef with chuijhal', 9, 12, 0, '34.jpeg'),
(35, 'Vanila Cake', 9, 13, 0, '35.jpeg'),
(36, 'Chicken Biriyani', 2, 9, 0, '36.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` int(255) NOT NULL,
  `getter_id` int(255) NOT NULL,
  `sender_id` int(255) NOT NULL,
  `post_id` int(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`notification_id`, `getter_id`, `sender_id`, `post_id`, `type`, `date`) VALUES
(17, 19, 18, 2, 'love', '26 Jun 2018'),
(18, 24, 18, 13, 'love', '26 Jun 2018'),
(19, 18, 18, 11, 'love', '26 Jun 2018'),
(20, 27, 27, 15, 'love', '26 Jun 2018'),
(21, 19, 18, 6, 'love', '26 Jun 2018'),
(22, 17, 17, 12, 'love', '27 Jun 2018'),
(23, 29, 20, 0, 'friend', '27 Jun 2018'),
(24, 20, 20, 17, 'love', '27 Jun 2018'),
(25, 29, 29, 18, 'love', '27 Jun 2018'),
(26, 25, 20, 0, 'friend', '27 Jun 2018'),
(27, 28, 17, 0, 'friend', '01 Jul 2018'),
(28, 17, 28, 7, 'love', '01 Jul 2018'),
(29, 22, 17, 0, 'friend', '01 Jul 2018'),
(30, 28, 19, 0, 'friend', '06 Aug 2018');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_id` int(255) NOT NULL,
  `post_giver_id` int(255) DEFAULT NULL,
  `restaurant_id` int(11) DEFAULT NULL,
  `menu_id` int(255) DEFAULT NULL,
  `date` varchar(255) NOT NULL,
  `rating` float NOT NULL,
  `opinion` varchar(255) NOT NULL,
  `post_pic` varchar(255) NOT NULL,
  `loves` int(255) NOT NULL,
  `reports` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `post_giver_id`, `restaurant_id`, `menu_id`, `date`, `rating`, `opinion`, `post_pic`, `loves`, `reports`) VALUES
(2, 19, 2, 6, '24 Jun 2018', 7, 'The food was very tasty .....', '2.jpg', 2, 0),
(6, 19, 7, 23, '24 Jun 2018', 8, 'This food is very tasty ....', '6.jpg', 2, 1),
(7, 17, 7, 24, '25 Jun 2018', 9, 'This food was so delicious......\r\nAnd I loved it ...............\r\nBehavior was so good ...... ', '7.jpg', 1, 0),
(8, 17, 8, 25, '25 Jun 2018', 10, 'Sooooo tastyyyyyy .....', '8.jpg', 0, 0),
(11, 18, 9, 28, '25 Jun 2018', 9, 'Tastyyyyyy', '11.jpg', 1, 0),
(12, 17, 2, 29, '25 Jun 2018', 2, 'The taste was very bad. It smelled bitter.I will never go to this restaurant again . :(', '12.jpg', 1, 0),
(13, 24, 1, 30, '25 Jun 2018', 9, 'Tastyyyyyyyyyyyyyyy', '13.jpg', 1, 0),
(15, 27, 10, 32, '26 Jun 2018', 7, 'Very good service & test was so good', '15.jpg', 5, 1),
(16, 18, 7, 24, '26 Jun 2018', 5, 'So Bad....', '16.jpg', 0, 0),
(17, 20, 11, 33, '27 Jun 2018', 10, 'delicious', '17.jpg', 3, 0),
(18, 29, 12, 34, '27 Jun 2018', 9, 'Awesome taste ,Very spicy .', '18.jpeg', 1, 0),
(19, 28, 13, 35, '01 Jul 2018', 10, 'The cake was so delicious .....', '19.jpeg', 0, 0),
(20, 22, 9, 36, '01 Jul 2018', 2, 'Not good.Totally disgusting.', '20.jpg', 0, 0),
(21, 28, 13, 35, '06 Jul 2018', 8, 'So delicious .........', '21.jpeg', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `report_id` int(255) NOT NULL,
  `post_id` int(255) NOT NULL,
  `reporter_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`report_id`, `post_id`, `reporter_id`) VALUES
(1, 6, 28),
(2, 15, 28);

-- --------------------------------------------------------

--
-- Table structure for table `restaurants`
--

CREATE TABLE `restaurants` (
  `restaurant_id` int(255) NOT NULL,
  `restaurant_name` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `restaurant_pic` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `restaurants`
--

INSERT INTO `restaurants` (`restaurant_id`, `restaurant_name`, `city`, `restaurant_pic`) VALUES
(1, 'Hotel Royal', 'dha', '1.jpg'),
(2, 'Hotel Castle Salam', 'dha', '2.jpg'),
(3, 'King Shawrma', 'dha', '3.jpg'),
(4, 'Finlay', 'chi', '4.jpg'),
(5, 'Delhi Darbar', 'chi', '5.jpg'),
(6, 'Cafe 24', 'chi', '6.jpg'),
(7, 'Bistro C', 'dha', 'unknown.jpg'),
(8, 'Raajkachuri', 'dha', 'unknown.jpg'),
(9, 'Mughals Dine', 'dha', 'unknown.jpg'),
(10, 'Bistro C', 'khu', 'unknown.jpg'),
(11, 'Mota mama', 'khu', 'unknown.jpg'),
(12, 'Muslim Hotel', 'dha', 'unknown.jpg'),
(13, 'Tasty Pastry', 'dha', 'unknown.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `saved_posts`
--

CREATE TABLE `saved_posts` (
  `save_id` int(255) NOT NULL,
  `post_id` int(255) NOT NULL,
  `saver_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(255) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `birth_date` date NOT NULL,
  `pro_pic` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `email`, `password`, `country`, `city`, `birth_date`, `pro_pic`) VALUES
(17, 'Nafisa', 'Tasneem', 'nafisa@gmail.com', '58642a5795552493eeaca03a8999e6978449fe81', 'Bangladesh', 'dha', '1997-01-11', '17.jpg'),
(18, 'Fahmida', 'Chowdhury', 'nisa@gmail.com', '58642a5795552493eeaca03a8999e6978449fe81', 'Bangladesh', 'dha', '1997-09-23', '18.jpg'),
(19, 'Iffat', 'Hossain', 'iffat@gmail.com', '58642a5795552493eeaca03a8999e6978449fe81', 'Bangladesh', 'dha', '1996-06-01', '19.jpg'),
(20, 'Taef ', 'Nadim', 'nadim@gmail.com', '58642a5795552493eeaca03a8999e6978449fe81', 'Bangladesh', 'chi', '1996-06-07', '20.jpg'),
(21, 'Farzana', 'Meghla', 'meghla@gmail.com', '58642a5795552493eeaca03a8999e6978449fe81', 'Bangladesh', 'dha', '1997-10-24', '21.jpg'),
(22, 'Nazmus', 'Saadat', 'salmir@gmail.com', '58642a5795552493eeaca03a8999e6978449fe81', 'Bangladesh', 'dha', '1995-08-18', '22.jpg'),
(23, 'Mashrur', 'Alam', 'prem@gmail.com', '58642a5795552493eeaca03a8999e6978449fe81', 'Bangladesh', 'dha', '1997-04-02', '23.jpg'),
(24, 'Galib', 'Hassan', 'galib@gmail.com', '58642a5795552493eeaca03a8999e6978449fe81', 'Bangladesh', 'chi', '1996-01-17', '24.jpg'),
(25, 'Tiyabur', 'Tamim', 'tamim@gmail.com', '58642a5795552493eeaca03a8999e6978449fe81', 'Bangladesh', 'chi', '1996-06-05', '25.jpg'),
(26, 'Arif', 'Istiak', 'sunny@gmail.com', '58642a5795552493eeaca03a8999e6978449fe81', 'Bangladesh', 'chi', '1996-06-05', '26.jpg'),
(27, 'Fahim', 'Istiak', 'fahim@gmail.com', '58642a5795552493eeaca03a8999e6978449fe81', 'Bangladesh', 'dha', '1996-08-29', '27.jpg'),
(28, 'Showrin ', 'Barua', 'showrin@gmail.com', '58642a5795552493eeaca03a8999e6978449fe81', 'Bangladesh', 'dha', '1996-06-16', '28.JPG'),
(29, 'Samiul', 'Pial', 'pialsamiul@gmail.com', '58642a5795552493eeaca03a8999e6978449fe81', 'Bangladesh', 'chi', '1997-03-07', '29.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `friend_list`
--
ALTER TABLE `friend_list`
  ADD PRIMARY KEY (`serial`),
  ADD KEY `one_user_id` (`one_user_id`),
  ADD KEY `another_user_id` (`another_user_id`);

--
-- Indexes for table `friend_requests`
--
ALTER TABLE `friend_requests`
  ADD PRIMARY KEY (`friend_request_id`),
  ADD KEY `getter_id` (`getter_id`),
  ADD KEY `sender_id` (`sender_id`);

--
-- Indexes for table `loves`
--
ALTER TABLE `loves`
  ADD PRIMARY KEY (`love_id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `lover_id` (`lover_id`);

--
-- Indexes for table `menues`
--
ALTER TABLE `menues`
  ADD PRIMARY KEY (`menu_id`),
  ADD KEY `restaurant_id` (`restaurant_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `getter_id` (`getter_id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `restaurant_id` (`restaurant_id`),
  ADD KEY `menu_id` (`menu_id`),
  ADD KEY `post_giver_id` (`post_giver_id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`report_id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `reporter_id` (`reporter_id`);

--
-- Indexes for table `restaurants`
--
ALTER TABLE `restaurants`
  ADD PRIMARY KEY (`restaurant_id`);

--
-- Indexes for table `saved_posts`
--
ALTER TABLE `saved_posts`
  ADD PRIMARY KEY (`save_id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `saver_id` (`saver_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `friend_list`
--
ALTER TABLE `friend_list`
  MODIFY `serial` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `friend_requests`
--
ALTER TABLE `friend_requests`
  MODIFY `friend_request_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `loves`
--
ALTER TABLE `loves`
  MODIFY `love_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT for table `menues`
--
ALTER TABLE `menues`
  MODIFY `menu_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `report_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `restaurants`
--
ALTER TABLE `restaurants`
  MODIFY `restaurant_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `saved_posts`
--
ALTER TABLE `saved_posts`
  MODIFY `save_id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `friend_list`
--
ALTER TABLE `friend_list`
  ADD CONSTRAINT `friend_list_ibfk_1` FOREIGN KEY (`one_user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `friend_list_ibfk_2` FOREIGN KEY (`another_user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `friend_requests`
--
ALTER TABLE `friend_requests`
  ADD CONSTRAINT `friend_requests_ibfk_1` FOREIGN KEY (`getter_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `friend_requests_ibfk_2` FOREIGN KEY (`sender_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `loves`
--
ALTER TABLE `loves`
  ADD CONSTRAINT `loves_ibfk_1` FOREIGN KEY (`lover_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `loves_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `menues`
--
ALTER TABLE `menues`
  ADD CONSTRAINT `menues_ibfk_1` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurants` (`restaurant_id`);

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`getter_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `notifications_ibfk_2` FOREIGN KEY (`sender_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`post_giver_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurants` (`restaurant_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `posts_ibfk_3` FOREIGN KEY (`menu_id`) REFERENCES `menues` (`menu_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`),
  ADD CONSTRAINT `reports_ibfk_2` FOREIGN KEY (`reporter_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `saved_posts`
--
ALTER TABLE `saved_posts`
  ADD CONSTRAINT `saved_posts_ibfk_1` FOREIGN KEY (`saver_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `saved_posts_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
