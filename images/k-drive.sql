-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 02, 2020 at 02:31 AM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.1.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `k-drive`
--

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `id` int(20) NOT NULL,
  `name` varchar(5555) NOT NULL,
  `parent` varchar(5555) NOT NULL,
  `uniqueId` varchar(5555) NOT NULL,
  `shared` varchar(1) NOT NULL DEFAULT '0',
  `mimeType` varchar(5555) NOT NULL,
  `owner` varchar(5555) NOT NULL,
  `address` varchar(5555) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`id`, `name`, `parent`, `uniqueId`, `shared`, `mimeType`, `owner`, `address`) VALUES
(24, 'Class 8 Cambridge List.txt', '5e8396fcac848', '2e1cd53733765e9f000833cd1e53c3af', '1', 'text/plain', 'fatima1', '2e1cd53733765e9f000833cd1e53c3afClass 8 Cambridge List.txt'),
(26, 'image (1).png', '5e8396fcac848', 'f5484a7b42d9ae9da8bf8080b0e4abe4', '0', 'image/png', 'fatima1', 'f5484a7b42d9ae9da8bf8080b0e4abe4image (1).png'),
(28, 'Appstore imj.jpeg', '5e8396fcac848', 'b8b1e0f576730871ddc6383aa7e648a3', '1', 'image/jpeg', 'fatima1', 'b8b1e0f576730871ddc6383aa7e648a3Appstore imj.jpeg'),
(29, 'codelogo.png', '5e8396fcac848', 'e4c334419e47226a4370a80a84089c99', '0', 'image/png', 'fatima1', 'e4c334419e47226a4370a80a84089c99codelogo.png'),
(30, '2059_w19_ms_1.pdf', '5e8396fcac848', 'c81a88c4c2cf3d2392d80b855cdab110', '1', 'application/pdf', 'fatima1', 'c81a88c4c2cf3d2392d80b855cdab1102059_w19_ms_1.pdf'),
(32, 'first.mp4', '5e8396fcac848', '99e53532b7204a9df8ff789259c53fb1', '0', 'video/mp4', 'fatima1', '99e53532b7204a9df8ff789259c53fb1first.mp4'),
(34, '828.gif', '5e84f2f89cd84', '13da85ce708183c07d0491f41f03d0a7', '0', 'image/gif', 'vefogese@mail62.net', '13da85ce708183c07d0491f41f03d0a7828.gif'),
(36, 'background-circle-color.png', '5e84f2f89cd84', '14b80a5e679e0f8b4303b9d6b24e899b', '0', 'image/png', 'vefogese@mail62.net', '14b80a5e679e0f8b4303b9d6b24e899bbackground-circle-color.png'),
(37, '828.gif', '5e84f2f89cd84', 'fd36d3750ed6115222bc6dd0c94510a0', '0', 'image/gif', 'vefogese@mail62.net', 'fd36d3750ed6115222bc6dd0c94510a0828.gif'),
(39, 'first.mp4', '5e84f2f89cd84', '046e9b1efc8b86e4750bd612ae3fc387', '0', 'video/mp4', 'vefogese@mail62.net', '046e9b1efc8b86e4750bd612ae3fc387first.mp4'),
(40, 'appstore.jpeg', '5e84f2f89cd84', '441980b67eb25e709b6a2acdb3c20bd9', '0', 'image/jpeg', 'vefogese@mail62.net', '441980b67eb25e709b6a2acdb3c20bd9appstore.jpeg'),
(41, 'fatima.html', '5e84f2f89cd84', '2f58dcf9770404c92db7c7aaccc2a24a', '0', 'text/html', 'vefogese@mail62.net', '2f58dcf9770404c92db7c7aaccc2a24afatima.html'),
(42, 'index.html', '5e84f2f89cd84', '77d95873d7ce59b1107f171e80fcd9de', '0', 'text/html', 'vefogese@mail62.net', '77d95873d7ce59b1107f171e80fcd9deindex.html');

-- --------------------------------------------------------

--
-- Table structure for table `folders`
--

CREATE TABLE `folders` (
  `id` int(11) NOT NULL,
  `parent` varchar(5555) NOT NULL,
  `childern` varchar(5555) NOT NULL,
  `shared` varchar(1) NOT NULL DEFAULT '0',
  `owner` varchar(5555) NOT NULL,
  `name` varchar(5555) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `folders`
--

INSERT INTO `folders` (`id`, `parent`, `childern`, `shared`, `owner`, `name`) VALUES
(3, '5e8396fcac848', '', '0', 'fatima1', 'My Drive'),
(4, '5e84f2f89cd84', '', '', 'vefogese@mail62.net', 'My Drive');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `uniqueId` varchar(5555) NOT NULL,
  `plus` varchar(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `uniqueId`, `plus`) VALUES
(0, 'vajefa@6mail.top', 'vajefa@6mail.top', '593810f0f1b8b46b11d3d711e5405f10', '5e83916e1b8f9', '0'),
(0, 'nike@7dmail.com', 'nike@7dmail.com', '87cd5e16f78f3efdf81bfe5bce1fe52f', '5e8391e272746', '0'),
(0, 'fatima', 'fatima@gmail.com', 'b5d5f67b30809413156655abdda382a3', '5e8395ae7b710', '0'),
(0, 'fatima1', 'fatima1@fatima1.fatima1', 'eee9420daf9ab1f105e867fbb7e7760f', '5e8396fcac848', '0'),
(0, 'vefogese@mail62.net', 'vefogese@mail62.net', 'e2429f02ba27645e4bead5b859f914c2', '5e84f2f89cd84', '0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `folders`
--
ALTER TABLE `folders`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `folders`
--
ALTER TABLE `folders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
