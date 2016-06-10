-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Gegenereerd op: 14 mei 2016 om 13:53
-- Serverversie: 5.6.26
-- PHP-versie: 5.5.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE DATABASE IF NOT EXISTS `av_apparatuur` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;

--
-- Database: `av_apparatuur`
--

USE `av_apparatuur`;
-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `productreservations`
--

CREATE TABLE IF NOT EXISTS `productreservations` (
  `id` int(10) NOT NULL,
  `reservation_id` int(10) NOT NULL,
  `product_id` int(10) NOT NULL,
  `product_serial` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(10) NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  `img` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `img`) VALUES
(10, 'Canon D7', 'Mooie camera', 'panasonic.png'),
(11, 'Canon 5d', 'Dit is een test canon', 'wireFrame_');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `reservations`
--

CREATE TABLE IF NOT EXISTS `reservations` (
  `id` int(10) NOT NULL,
  `user` int(255) NOT NULL,
  `date_rented` date NOT NULL,
  `date_retour` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `serials`
--

CREATE TABLE IF NOT EXISTS `serials` (
  `id` int(10) NOT NULL,
  `product_id` int(10) NOT NULL,
  `serial` int(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `serials`
--

INSERT INTO `serials` (`id`, `product_id`, `serial`) VALUES
(28, 10, 1),
(29, 10, 2),
(30, 10, 3),
(31, 10, 4),
(32, 10, 5),
(33, 10, 6),
(34, 10, 7),
(35, 11, 1),
(36, 11, 2),
(37, 11, 3),
(38, 11, 4),
(39, 11, 5);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(255) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `password_salt` char(32) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `tsn_voegsel` varchar(10) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(32) NOT NULL,
  `mobile` int(10) NOT NULL,
  `student_number` int(10) NOT NULL,
  `permission` enum('0','1') NOT NULL,
  `last_login` date NOT NULL,
  `status` enum('0','1','2','3') DEFAULT '0',
  `picture` varchar(255) NOT NULL DEFAULT 'default.png'
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `password_salt`, `first_name`, `tsn_voegsel`, `last_name`, `email`, `mobile`, `student_number`, `permission`, `last_login`, `status`, `picture`) VALUES
(1, 'Ashna', '$2y$11$Q2k0Kzd5b2JhZnhnTUJuT.xMNAICWCKeWN1F8nI/sNh7dSObOapfK', 'Ci4+7yobafxgMBnLUq/TE40mUFHr3g==', 'Ashna', '', 'wiar', 'ashna@hotmail.com', 617383551, 121571, '1', '0000-00-00', '0', 'default.png'),
(3, 'sergen', '$2y$11$cE9pWGp2ZlhmSlBsMFRmZer960GekYsAB/BFaqqWWs318Ka4ngik.', 'pOiXjvfXfJPl0Tffu9Alo19AilyKoQ==', 'Sergen', '', 'Tebbens', 'sergen-97@hotmail.com', 2147483647, 114411, '0', '0000-00-00', '0', 'default.png'),
(4, 'jerry', '$2y$11$UWJQVnNiQ0ZZZmU1K0oxQO65cHrwArivALz8rwJlS8S2t0zB2tTw6', 'QbPVsbCFYfe5+J1AKUSYf4G02kE42g==', 'Jerry', '', 'beij', 'jerry.beij@student.rocleiden.nl', 909090909, 121079, '0', '0000-00-00', '0', 'default.png');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `productreservations`
--
ALTER TABLE `productreservations`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `serials`
--
ALTER TABLE `serials`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `productreservations`
--
ALTER TABLE `productreservations`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT voor een tabel `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT voor een tabel `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT voor een tabel `serials`
--
ALTER TABLE `serials`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=40;
--
-- AUTO_INCREMENT voor een tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
