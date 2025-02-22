-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 04, 2024 at 10:37 AM
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
-- Database: `bazag01`
--

-- --------------------------------------------------------

--
-- Table structure for table `korisnici`
--

DROP TABLE IF EXISTS `korisnici`;
CREATE TABLE IF NOT EXISTS `korisnici` (
  `IDkorisnika` int NOT NULL AUTO_INCREMENT,
  `Ime` varchar(45) NOT NULL,
  `Prezime` varchar(45) NOT NULL,
  `Telefon` varchar(15) NOT NULL,
  `Email` varchar(45) NOT NULL,
  `Sifra` varchar(45) NOT NULL,
  `Adresa` varchar(45) NOT NULL,
  `tip` int DEFAULT NULL,
  PRIMARY KEY (`IDkorisnika`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `korisnici`
--

INSERT INTO `korisnici` (`IDkorisnika`, `Ime`, `Prezime`, `Telefon`, `Email`, `Sifra`, `Adresa`, `tip`) VALUES
(1, 'Ognjen', 'Stamenković', '+381651234567', 'ostamenkovic@gmail.com', 'Proba123', 'Bul. Kralja Aleksandra 83', 1),
(2, 'Luka', 'Hadžić', '+381609876543', 'lhadzic@gmail.com', 'Proba123', 'Bul. Kralja Aleksandra 83', 2);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
