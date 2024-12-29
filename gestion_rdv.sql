-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 30, 2024 at 12:17 AM
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
-- Database: `gestion_rdv`
--

-- --------------------------------------------------------

--
-- Table structure for table `medecins`
--

CREATE TABLE `medecins` (
  `ID` int(11) NOT NULL,
  `nom` varchar(100) DEFAULT NULL,
  `specialite` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medecins`
--

INSERT INTO `medecins` (`ID`, `nom`, `specialite`) VALUES
(1, 'mounir ben amor', 'gastrologue'),
(3, 'yosr ghorbel', 'dentiste'),
(5, 'emna fawz', 'opticienne'),
(6, 'mohamed ghorbel', 'chirugien');

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `ID` int(11) NOT NULL,
  `nom` varchar(100) DEFAULT NULL,
  `prenom` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telephone` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`ID`, `nom`, `prenom`, `email`, `telephone`) VALUES
(9, 'ghorbel', 'fatma', 'syrine.g@gmail.com', '21299194'),
(10, 'ghorbel', 'yosr', 'yosr.g@gmail.com', '26342204'),
(11, 'ghorbel', 'abir', 'abir.g@gmail.com', '23504910'),
(215, 'ghorbel', 'riadh', 'riadh@gmail.com', '26328001'),
(218, 'bouaziz', 'nour', 'nour@gmail.com', '22145632'),
(220, 'bouaziz', 'nadine', 'nadine@gmail.com', '52647895'),
(223, 'asri', 'julia', 'julia@gmail.com', '21456789'),
(224, 'ghorbel', 'emna', 'emna@gmail.com', '25896333'),
(226, 'ghorbel', 'wafa', 'wafa@gmail.com', '2355555'),
(231, 'ghorbel', 'wafa', 'kmar@gmail.com', '22125896'),
(232, 'hmila', 'foued', 'foued@gmail.com', '25417896'),
(233, 'ghorbel', 'nour', 'nour1@gmail.com', '25478196'),
(237, 'bouaziz', 'rahma', 'rahmagh@gmail.com', '25896741'),
(238, 'ghorbel', 'safa', 'safa@gmail.com', '25896314'),
(239, 'asri', 'jouri', 'jouri@gmail.com', '23504910'),
(241, 'ghorbel', 'rania', 'rania@gmail.com', '44125639'),
(242, 'ellouze', 'farah', 'farah@gmail.com', '53245698'),
(244, 'khbou', 'salima', 'salima@gmail.com', '23568974'),
(245, 'trabelsi', 'mariam', 'mariam@gmail.com', '21456987'),
(246, 'hmila', 'emna', 'hemna@gmail.com', '25896411'),
(247, 'asri', 'alaa', 'alaa@gmail.com', '52469871'),
(248, 'asri', 'ali', 'aliasri@gmail.com', '23258837'),
(249, 'ghorbel', 'FAHMI', 'fahmigh@gmail.com', '44789653'),
(250, 'hmila', 'samira', 'samira@gmail.com', '20643543'),
(251, 'ghorbel', 'nour elhouda', 'houda@gmail.com', '21456987');

-- --------------------------------------------------------

--
-- Table structure for table `rendezvous`
--

CREATE TABLE `rendezvous` (
  `ID` int(11) NOT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `medecin_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `heure` time DEFAULT NULL,
  `statut` enum('confirmé','annulé') DEFAULT 'confirmé'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rendezvous`
--

INSERT INTO `rendezvous` (`ID`, `patient_id`, `medecin_id`, `date`, `heure`, `statut`) VALUES
(1, 10, 1, '2024-12-22', '09:20:00', 'confirmé'),
(4, 223, 1, '2024-12-29', '09:00:00', 'confirmé'),
(6, 232, 3, '2024-12-22', '20:00:00', 'confirmé'),
(7, 10, 3, '2024-12-29', '22:00:00', 'confirmé'),
(8, 9, 5, '2024-12-29', '12:26:00', 'annulé'),
(9, 9, 5, '2024-12-29', '12:26:00', 'annulé'),
(10, 10, 6, '2024-12-30', '08:15:00', 'confirmé'),
(11, 11, 3, '2024-12-30', '11:48:00', 'confirmé'),
(12, 215, 1, '2025-01-01', '13:53:00', 'annulé'),
(14, 233, 5, '2024-12-31', '12:00:00', 'confirmé'),
(16, 215, 3, '2024-12-30', '08:30:00', 'confirmé'),
(18, 9, 1, '2025-01-03', '11:30:00', 'annulé'),
(19, 233, 6, '2025-01-04', '12:00:00', 'confirmé'),
(21, 11, 1, '2025-01-02', '00:00:00', 'confirmé'),
(23, 11, 5, '2024-12-17', '05:46:00', 'confirmé'),
(24, 215, 5, '2025-01-02', '23:00:00', 'confirmé');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `medecins`
--
ALTER TABLE `medecins`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `rendezvous`
--
ALTER TABLE `rendezvous`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `medecin_id` (`medecin_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `medecins`
--
ALTER TABLE `medecins`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=252;

--
-- AUTO_INCREMENT for table `rendezvous`
--
ALTER TABLE `rendezvous`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `rendezvous`
--
ALTER TABLE `rendezvous`
  ADD CONSTRAINT `rendezvous_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`ID`),
  ADD CONSTRAINT `rendezvous_ibfk_2` FOREIGN KEY (`medecin_id`) REFERENCES `medecins` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
