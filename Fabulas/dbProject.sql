-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 23, 2021 at 09:15 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbProject`
--

-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

CREATE TABLE `chat` (
  `id` int(11) NOT NULL,
  `envoyeur` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `destinataire` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `message` varchar(300) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `chat`
--

INSERT INTO `chat` (`id`, `envoyeur`, `destinataire`, `message`) VALUES
(12, 'Simon', 'Dapenta', 'salut'),
(35, 'Dapenta', 'Simon', 'Salut, ça va ?'),
(36, 'Theo', 'Dapenta', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis a.'),
(37, 'Theo', 'Dapenta', 'orem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse dapibus.'),
(38, 'Theo', 'Dapenta', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed id.'),
(39, 'Theo', 'Simon', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed maximus.'),
(40, 'Simon', 'Happy', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec a.'),
(41, 'Simon', 'Happy', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean consequat.'),
(42, 'Happy', 'Simon', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum eu.');

-- --------------------------------------------------------

--
-- Table structure for table `Favoris`
--

CREATE TABLE `Favoris` (
  `id_post` int(11) NOT NULL,
  `liked_by` varchar(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `Favoris`
--

INSERT INTO `Favoris` (`id_post`, `liked_by`) VALUES
(51, 'Dapenta'),
(49, 'Simon'),
(95, 'Simon'),
(95, 'Theo'),
(95, 'Happy'),
(101, 'Dapenta');

-- --------------------------------------------------------

--
-- Table structure for table `Follow`
--

CREATE TABLE `Follow` (
  `username` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `following` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `Follow`
--

INSERT INTO `Follow` (`username`, `following`) VALUES
('Theo', 'Dapenta'),
('Simon', 'Dapenta'),
('Simon', 'Theo'),
('Happy', 'Dapenta'),
('Happy', 'Simon'),
('Happy', 'Theo'),
('Dapenta', 'Theo'),
('Simon', 'Happy'),
('Theo', 'Simon'),
('Dapenta', 'Simon');

-- --------------------------------------------------------

--
-- Table structure for table `Publication`
--

CREATE TABLE `Publication` (
  `id` int(11) NOT NULL,
  `username` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `post` varchar(300) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `Publication`
--

INSERT INTO `Publication` (`id`, `username`, `post`) VALUES
(49, 'Theo', 'Bonjour.'),
(51, 'Simon', 'Test de premier post.'),
(52, 'Happy', 'Bonjour'),
(95, 'Dapenta', 'Bonjour'),
(101, 'Theo', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque eget est laoreet diam euismod sagittis. Morbi mattis feugiat augue. Sed dapibus magna id aliquet ultricies.');

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE `Users` (
  `username` varchar(20) NOT NULL,
  `mdp` varchar(255) DEFAULT NULL,
  `email` varchar(80) DEFAULT NULL,
  `avatar` varchar(1000) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '''\\''Default.jpg\\''''',
  `admin` int(11) NOT NULL,
  `style` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`username`, `mdp`, `email`, `avatar`, `admin`, `style`) VALUES
('Admin', '$2y$10$TT9PmWhE6tEx7MCUulbGB.hwFz.oaurU2Nd3F07x5V.QT7dT.sOfu', 'admin@gmail.com', 'Admin2021-05-23 19:34:15.675.png', 1, 'G'),
('Dapenta', '$2y$10$Q8vsjxzZf53vgATiJFqOTODUE0rWVXYhDdlcAGKPpQY.3sPoFiGF2', 'theodapenta@gmail.com', 'Dapenta2021-05-23 15:03:23.962.jpg', 1, 'N'),
('Happy', '$2y$10$q4hyUGWwEZcz2/pzJ.DgROOthqDH6kBrTqubk8LI.io/j.VBLKWIW', 'Happy@gmail.com', 'Happy.gif', 0, 'E'),
('Simon', '$2y$10$O8.08VYJP6dw9OVUKh5jtuFNLuBsXm9/xAHKb5GsYaOXOFC6Qmp3e', 'Simon@gmail.com', 'Simon.jpg', 2, 'E'),
('Theo', '$2y$10$IwsdIuVcKv2kHaIoYDvtrOzMNPzCnmeqLxhg46i.3RojQYKYl9kL2', 'theobigand@gmail.com', 'Theo.jpg', 2, 'N');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Publication`
--
ALTER TABLE `Publication`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chat`
--
ALTER TABLE `chat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `Publication`
--
ALTER TABLE `Publication`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
