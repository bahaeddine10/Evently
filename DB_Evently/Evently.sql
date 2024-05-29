-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 02, 2024 at 07:01 AM
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
-- Database: `evently`
--

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id_e` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `description` varchar(30) NOT NULL,
  `capacity` int(11) NOT NULL,
  `details` varchar(30) NOT NULL,
  `date_e` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id_e`, `name`, `description`, `capacity`, `details`, `date_e`) VALUES
(15, 'card1', 'idk', 500, 'abcde', '2003-03-07');

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `id_Post` int(11) NOT NULL,
  `id_u` int(11) NOT NULL,
  `Date_Publish` varchar(30) NOT NULL,
  `textPost` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`id_Post`, `id_u`, `Date_Publish`, `textPost`) VALUES
(15, 5, '2024-05-01', ' jaaaaaaw'),
(16, 4, '2024-05-01', ' aa'),
(18, 5, '2024-05-01', ' aa');

-- --------------------------------------------------------

--
-- Table structure for table `session`
--

CREATE TABLE `session` (
  `id_u` int(11) NOT NULL,
  `token` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `session`
--

INSERT INTO `session` (`id_u`, `token`) VALUES
(4, '8e0b8118a2f5f2473d6c6ca6c2ddac05a6959d19eac655a16d859ba40c7292e9'),
(4, '3f096638b4ea5579836a22143d3bfa9f472ee9acf5fbaf9add50fd6825b03d34'),
(4, 'b60e956037f8909673368db36b2d9b2e208327e8a8b4b974393917cd0d3657a6'),
(4, '666330f6dfa74ed6b54ecf77df0a267d4286867b5e02252931919b170e0f85bd'),
(4, 'a000f97a02f5e424977bdcb9baa50e16f38d3ada5dde3a828e1a44fed2666117'),
(5, 'f8bc35ab44cba7da4043ad669171e7d15696976f1ac0e54915fba92d03a80935'),
(4, 'd166d11337abb3d344b87b42fcf24a3af6219c6a05b28d63b373ff47d0632aba'),
(5, 'af7f8f4184c11cd67b467c6b359ce3cb32445c94153dbebd5d268e0fe71566f1'),
(4, '5a7f2c505c91bd2e458c74296bb473302fe058e221b5586ed6cf5a794d86d655'),
(4, 'e86a7640ce4e70fb2a3aef4541ef149910a029ac0fa6e2e914705daac07871c3'),
(5, '7ea6ed245a19fe1ce0f38d2acb82c140c8cf3f43640a1ca7acad4080017b00ff'),
(4, 'e6e2af9931c636be763f5c7b1268729643dbd4dc921e8ddbc6d6e1c40f4e4d31'),
(5, 'c44dc8e533d07ef31f0453c959ff62107f93963663f03ce14fbd083b422ba73e'),
(4, 'df3a2e46401c2e7351dcf1dc620518e47cb63a1474880c180decd5b415a56e71'),
(5, 'c7adf466eed293942f7c5225530240abe344e7fcc43392683e15502acb0b529b'),
(4, '7e2398d90efc1c9d4c17800f106b667630471e64178552ffe258fc9a5dc64d81'),
(5, 'c5b8200ac7893aef1fd4a215bcbac3aa32827a2fc57cdbdccd1a7d45cddcc51b'),
(4, '90b30ee60d615b2bce991379116307a74bc72eb183ce686fbbd133c146fdb564'),
(5, '5466cda20f0e3e28bf957a1937e8819d3f0eb632eff47423340756a0f6677b45'),
(5, 'a6494de8d7c5ec8cbbaa70272bdc3423d28aa3666f1d5c4fe733421108672249'),
(5, 'a63ebcd2260a8e77043a746d8c7746cc4ff52b793af166399acb535bfb14f195'),
(5, 'a53a1d6c386f43da05738ca1bed31a1f27e68cf6b3dbd9865ec398709400cdfb'),
(5, '65cd3568a6ac6257acbd0b7906d73c0960f41c209395d4ae8f4d62a8e3e65a28'),
(5, '1eee530ab8f8ec376748348e24bacb0ab825a1bf7bbe5e2df00b0957cb6b41c9'),
(5, '8a49546181a9f90643d1ab3d86ef5d4e5a206b8496abf06cd83940d906c7c130'),
(5, '519f82df563dd0782e72e9cc034a9d94f703eec17437ff3f5630d2b4b5610c06');

-- --------------------------------------------------------

--
-- Table structure for table `user3`
--

CREATE TABLE `user3` (
  `id_u` int(11) NOT NULL,
  `firstname` varchar(30) NOT NULL,
  `lastname` varchar(30) NOT NULL,
  `email` varchar(40) NOT NULL,
  `password` varchar(40) NOT NULL,
  `telephone` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user3`
--

INSERT INTO `user3` (`id_u`, `firstname`, `lastname`, `email`, `password`, `telephone`) VALUES
(4, 'moussa', 'lejmi', 'moussalejmi@gmail.com', '1234', 23888137),
(5, 'momo', 'mo', 'm@gmail.com', '1111', 23);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id_e`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id_Post`),
  ADD KEY `id_u_fk` (`id_u`);

--
-- Indexes for table `session`
--
ALTER TABLE `session`
  ADD KEY `id_u_fk` (`id_u`);

--
-- Indexes for table `user3`
--
ALTER TABLE `user3`
  ADD PRIMARY KEY (`id_u`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id_e` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `id_Post` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `user3`
--
ALTER TABLE `user3`
  MODIFY `id_u` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`id_u`) REFERENCES `user3` (`id_u`);

--
-- Constraints for table `session`
--
ALTER TABLE `session`
  ADD CONSTRAINT `session_ibfk_1` FOREIGN KEY (`id_u`) REFERENCES `user3` (`id_u`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
