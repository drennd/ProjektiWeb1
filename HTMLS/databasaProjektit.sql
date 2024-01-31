-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 31, 2024 at 05:06 PM
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
-- Database: `databaseprojektit`
--
CREATE DATABASE IF NOT EXISTS `databaseprojektit` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `databaseprojektit`;

-- --------------------------------------------------------

--
-- Table structure for table `about_us`
--

CREATE TABLE `about_us` (
  `ID` int(11) NOT NULL,
  `about_text` text NOT NULL,
  `mission_text` text NOT NULL,
  `team_text` text NOT NULL,
  `why_choose_text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `about_us`
--

INSERT INTO `about_us` (`ID`, `about_text`, `mission_text`, `team_text`, `why_choose_text`) VALUES
(1, 'Mire qe erdhet te BluehWeather, Jemi nje website i formuar prej dy studenteve per vetem nje projekt dhe pak me shum experienca ne kete lende.', 'Ne BluehWeather, missioni jone nuk eshte i madh veq eshte per me kalu projektin please.', 'Kemi nje grup te embel te djemve qe po lodhen me i kry qit projekt.', 'Sepse Jes.Nuk e di vet');

-- --------------------------------------------------------

--
-- Table structure for table `footer`
--

CREATE TABLE `footer` (
  `ID` int(11) NOT NULL,
  `footer_left_txt` varchar(255) NOT NULL,
  `advertise_txt` varchar(50) NOT NULL,
  `support_txt` varchar(50) NOT NULL,
  `company_txt` varchar(50) NOT NULL,
  `contact_txt` varchar(50) NOT NULL,
  `terms_of_use_txt` varchar(255) NOT NULL,
  `priv_policy_txt` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `footer`
--

INSERT INTO `footer` (`ID`, `footer_left_txt`, `advertise_txt`, `support_txt`, `company_txt`, `contact_txt`, `terms_of_use_txt`, `priv_policy_txt`) VALUES
(1, 'BluehWeather eshte nje weather website e bere per projekt te UBTS PLEASE DONT QUESTION!', 'Advertise Us! info@BluehWeather.com', 'Support Us! ', 'Hai This is us.', 'Contatct: 044905450  jh64945@ubt-uni.net', 'Terms of Use: BRRR', 'Privacy Policy: Wut is dis');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `descrption` varchar(255) NOT NULL,
  `time` date NOT NULL,
  `imgPath` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `username`, `email`, `password`, `role`) VALUES
(1, 'admin', 'info@catalogz.com', '123', 'admin'),
(2, 'jonhaziri', 'jonhaziri18@gmail.com', '123', 'user'),
(3, 'ava', 'ava@gmail.com', 'ava', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `about_us`
--
ALTER TABLE `about_us`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `footer`
--
ALTER TABLE `footer`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `about_us`
--
ALTER TABLE `about_us`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `footer`
--
ALTER TABLE `footer`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
