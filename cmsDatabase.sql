-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 25, 2018 at 06:20 PM
-- Server version: 5.6.34-log
-- PHP Version: 7.1.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cms`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `cat_id` int(3) NOT NULL,
  `cat_title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`cat_id`, `cat_title`) VALUES
(1, 'Bootstrap'),
(2, 'Javascript '),
(3, 'PHP'),
(4, 'JAVA'),
(18, 'OOP'),
(19, 'Procedural PHP'),
(20, 'c++'),
(21, 'AngularJS'),
(22, 'Node.js');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(3) NOT NULL,
  `comment_post_id` int(3) NOT NULL,
  `comment_author` varchar(255) NOT NULL,
  `comment_email` varchar(255) NOT NULL,
  `comment_content` text NOT NULL,
  `comment_status` varchar(250) NOT NULL,
  `comment_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `comment_post_id`, `comment_author`, `comment_email`, `comment_content`, `comment_status`, `comment_date`) VALUES
(20, 47, 'Edem Dumenu', 'ed@gmail.com', 'Lorem ipsum dolor sit amet, aliquam dictum ut vivamus libero, dignissim curabitur torquent dapibus luctus lectus habitant. ', 'approved', '2018-01-24'),
(21, 48, 'Selase Dumenu', 'sd@gmail.com', 'Lorem ipsum dolor sit amet, aliquam dictum ut vivamus libero, dignissim curabitur torquent dapibus luctus lectus habitant. ', 'Unapproved', '2018-01-24'),
(22, 54, 'Elorm Dumenu', 'ed@gmail.com', 'Lorem ipsum dolor sit amet, aliquam dictum ut vivamus libero, dignissim curabitur torquent dapibus luctus lectus habitant. ', 'Unapproved', '2018-01-24');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_id` int(3) NOT NULL,
  `post_category_id` int(3) NOT NULL,
  `post_title` varchar(255) NOT NULL,
  `post_author` varchar(255) NOT NULL,
  `post_user` varchar(255) NOT NULL,
  `post_date` date NOT NULL,
  `post_image` text NOT NULL,
  `post_content` text NOT NULL,
  `post_tags` varchar(255) NOT NULL,
  `post_comment_count` varchar(225) NOT NULL,
  `post_status` varchar(255) NOT NULL DEFAULT 'draft',
  `post_views_count` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `post_category_id`, `post_title`, `post_author`, `post_user`, `post_date`, `post_image`, `post_content`, `post_tags`, `post_comment_count`, `post_status`, `post_views_count`) VALUES
(47, 18, 'Test 2', '', 'peter', '2018-01-24', '38293697901_b1d773678b_b.jpg', '<p>sfnekjrnfe</p>', 'peter', '', 'published', 5),
(48, 18, 'Test 2', '', 'peter', '2018-01-24', '38293697901_b1d773678b_b.jpg', '<p>sfnekjrnfe</p>', 'peter', '', 'published', 2),
(53, 18, 'Test 2', '', 'peter', '2018-01-24', '38293697901_b1d773678b_b.jpg', '<p>sfnekjrnfe</p>', 'peter', '', 'published', 0),
(54, 18, 'Test 2', '', 'peter', '2018-01-24', '38293697901_b1d773678b_b.jpg', '<p>sfnekjrnfe</p>', 'peter', '', 'published', 2),
(57, 18, 'Test 2', '', 'peter', '2018-01-24', '38293697901_b1d773678b_b.jpg', '<p>sfnekjrnfe</p>', 'peter', '', 'published', 0),
(58, 18, 'Test 2', '', 'peter', '2018-01-24', '38293697901_b1d773678b_b.jpg', '<p>sfnekjrnfe</p>', 'peter', '', 'published', 0),
(63, 18, 'Test 2', '', 'peter', '2018-01-24', '38293697901_b1d773678b_b.jpg', '<p>sfnekjrnfe</p>', 'peter', '', 'published', 0),
(64, 1, 'Test 2', '', 'kdot', '2018-01-24', '02839_smalllakeinswitzerland_1280x800.jpg', '<p><span style=\"font-family: arial, helvetica, sans-serif; font-size: 12px; text-align: justify;\">Lorem ipsum dolor sit amet, aliquam dictum ut vivamus libero, dignissim curabitur torquent dapibus luctus lectus habitant. Ante est, sollicitudin placerat. Justo lacus in eget leo justo. Sagittis justo dis lobortis purus eu, vitae tenetur non odio. Quis adipiscing dui et rhoncus leo, parturient sed omnis sed aliquam in hymenaeos, imperdiet vitae, donec mi donec a wisi enim aenean, arcu condimentum elementum consectetuer eget sem ante.</span><br></p>', 'peter, snow', '', 'published', 1),
(68, 18, 'Test 2', '', 'demo', '2018-01-24', '223f05e1f1d01cdbaefe9398148ac418.jpg', '<p><span style=\"font-family: arial, helvetica, sans-serif; font-size: 12px; text-align: justify;\">Lorem ipsum dolor sit amet, aliquam dictum ut vivamus libero, dignissim curabitur torquent dapibus luctus lectus habitant. Ante est, sollicitudin placerat. Justo lacus in eget leo justo. Sagittis justo dis lobortis purus eu, vitae tenetur non odio. Quis adipiscing dui et rhoncus leo, parturient sed omnis sed aliquam in hymenaeos, imperdiet vitae, donec mi donec a wisi enim aenean, arcu condimentum elementum consectetuer eget sem ante.</span></p><p><br></p>', 'peter', '', 'published', 0),
(74, 2, 'Test 2', '', 'edumenu', '2018-01-24', '87a1d395b4171349922f3463c71de30a.jpg', '<p><span style=\"font-family: arial, helvetica, sans-serif; font-size: 12px; text-align: justify;\">Lorem ipsum dolor sit amet, aliquam dictum ut vivamus libero, dignissim curabitur torquent dapibus luctus lectus habitant. Ante est, sollicitudin placerat. Justo lacus in eget leo justo. Sagittis justo dis lobortis purus eu, vitae tenetur non odio. Quis adipiscing dui et rhoncus leo, parturient sed omnis sed aliquam in hymenaeos, imperdiet vitae, donec mi donec a wisi enim aenean, arcu condimentum elementum consectetuer eget sem ante.</span><br></p>', 'peter, 2', '', 'published', 2),
(76, 1, 'Jeezy', '', 'demo', '2018-01-24', 'a1Ajrl.jpg', ' <p>eifewifwe</p>    ', 'users', '', 'draft', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(3) NOT NULL,
  `username` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_firstname` varchar(255) NOT NULL,
  `user_lastname` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_image` text NOT NULL,
  `user_role` varchar(255) NOT NULL,
  `randSalt` varchar(255) NOT NULL DEFAULT '$2y$10$iusesomecrazystrings22'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `user_password`, `user_firstname`, `user_lastname`, `user_email`, `user_image`, `user_role`, `randSalt`) VALUES
(25, 'edumenu', '$1$71xe1hza$7iEPvkvzdmLuUL8GvlPXE.', 'Edem ', 'Dumenu', 'ed@gmail.com', '', 'admin', '$2y$10$iusesomecrazystrings22'),
(26, 'demo', '$1$bSNgrfUL$noV3Z9KGJH3Lv6Xu5ZkST.', 'George', 'Bruce', 'demo@gmail.com', '', 'admin', '$2y$10$iusesomecrazystrings22'),
(56, 'sdumenu', '$2y$12$o4heQUpy9zLS.Tkp9il87.gK3OvGiMelf21qWCiRLN7qMIcQ6LU/G', 'Selase', 'Dumenu', 's@gmail.com', '', 'admin', '$2y$10$iusesomecrazystrings22'),
(57, 'peter', '$2y$12$bvhBntbhifv9SoPuGrPhaO9qT5k1WP9r4h94ycDV.8DJgdhLga93q', 'Peter', 'Pan', 'p@gmail.com', '', 'admin', '$2y$10$iusesomecrazystrings22'),
(61, 'demo', '$2y$12$Ok8UlPJ0TJxgZMhvgOHxNu/E8a2WkU/EIL6xnOwfaBRDYnse9ly7u', 'Demo 1', 'mom 1', 'de@gmail.com', '', 'admin', '$2y$10$iusesomecrazystrings22'),
(62, 'kdot', '$2y$12$mv7H/2sE4XMA9Z8qc0ihGuwkDgFy1MjhEzC24sJY9Zi7kDLRzpy6C', 'Kendrick', 'Lamar', 'kdot@gmail.com', '', 'admin', '$2y$10$iusesomecrazystrings22');

-- --------------------------------------------------------

--
-- Table structure for table `users_online`
--

CREATE TABLE `users_online` (
  `id` int(11) NOT NULL,
  `session` varchar(255) NOT NULL,
  `time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users_online`
--

INSERT INTO `users_online` (`id`, `session`, `time`) VALUES
(9, '3bd2e45a75a66572cf3013a40b8a88be', 1516637422),
(10, '6ce9c44b1011a434f8de89074b500172', 1516645857),
(11, 'a1e8058c121667de011eb4d82fbc478d', 1516645488),
(12, 'fe684ab1fe5f6e7dd71648be3c156c22', 1516645082),
(13, '9286a915dfd13a03883625b83ff649f5', 1516711294),
(14, 'c352ddfc58cb56198914cb2a90f6ba19', 1516711591),
(15, 'a24ac3a5d2a911f4a3754a1459e3e3ef', 1516713567),
(16, '99527f0f54757185c3f3bc7801ed1463', 1516730002),
(17, '92baa5476b23b741337a656df9b53d15', 1516732016),
(18, '044d8cae6e6f86642bc7012ffcbfa582', 1516807454),
(19, '3b947d558ee2a1acd87cc86e43c33584', 1516809831),
(20, '3b26469852a0554b198265626ea87066', 1516885022);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `users_online`
--
ALTER TABLE `users_online`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `cat_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;
--
-- AUTO_INCREMENT for table `users_online`
--
ALTER TABLE `users_online`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
