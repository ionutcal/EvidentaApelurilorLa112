-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 16, 2025 at 04:28 AM
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
-- Database: `proiectbd`
--

-- --------------------------------------------------------

--
-- Table structure for table `apel`
--

CREATE TABLE `apel` (
  `id_apel` int(11) NOT NULL,
  `data_apel` date NOT NULL,
  `ora_apel` time NOT NULL,
  `tip_urgenta` varchar(50) NOT NULL,
  `id_apelant` int(11) DEFAULT NULL,
  `id_dispatcher` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `apel`
--

INSERT INTO `apel` (`id_apel`, `data_apel`, `ora_apel`, `tip_urgenta`, `id_apelant`, `id_dispatcher`) VALUES
(1, '2025-01-01', '10:00:00', 'Urgenta 1', 1, 1),
(2, '2025-01-02', '11:00:00', 'Urgenta 2', 2, 2),
(3, '2025-01-03', '12:00:00', 'Urgenta 3', 3, 3),
(4, '2025-01-04', '13:00:00', 'Urgenta 4', 4, 4),
(6, '2025-01-06', '15:00:00', 'Urgenta 6', 6, 6),
(8, '2025-01-08', '17:00:00', 'Urgenta 8', 8, 8),
(9, '2025-01-09', '18:00:00', 'Urgenta 9', 9, 9),
(10, '2025-01-10', '19:00:00', 'Urgenta 10', 10, 10),
(11, '2025-01-10', '14:00:00', 'Urgenta 6', 6, 1),
(12, '2025-01-11', '15:30:00', 'Urgenta 13', 6, 2),
(13, '2025-01-12', '10:45:00', 'Urgenta 1', 7, 3),
(14, '2025-01-13', '09:20:00', 'Urgenta 6', 8, 4),
(15, '2025-01-13', '18:00:00', 'Urgenta 14', 6, 1);

-- --------------------------------------------------------

--
-- Table structure for table `apelant`
--

CREATE TABLE `apelant` (
  `id_apelant` int(11) NOT NULL,
  `nume` varchar(50) DEFAULT NULL,
  `prenume` varchar(50) DEFAULT NULL,
  `telefon` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `apelant`
--

INSERT INTO `apelant` (`id_apelant`, `nume`, `prenume`, `telefon`) VALUES
(1, 'Popescu', 'Ion', '0721000001'),
(2, 'Ionescu', 'Maria', '0721000002'),
(3, 'Georgescu', 'Alex', '0721000003'),
(4, 'Marinescu', 'Andreea', '0721000004'),
(5, 'Dumitru', 'Mihai', '0721000005'),
(6, 'Preda', 'Alina', '0721000006'),
(7, 'Constantinescu', 'Bogdan', '0721000007'),
(8, 'Radulescu', 'Elena', '0721000008'),
(9, 'Vasilescu', 'Florin', '0721000009'),
(10, 'Stoica', 'Ioana', '0721000010'),
(11, 'Popescu', 'Ion', '0721000001'),
(12, 'Ionescu', 'Maria', '0721000002'),
(13, 'Georgescu', 'Alex', '0721000003'),
(14, 'Vasilescu', 'Florin', '0721000009'),
(15, 'Stoica', 'Ioana', '0721000010');

-- --------------------------------------------------------

--
-- Table structure for table `dispatcher`
--

CREATE TABLE `dispatcher` (
  `id_dispatcher` int(11) NOT NULL,
  `nume` varchar(50) NOT NULL,
  `prenume` varchar(50) NOT NULL,
  `telefon_serviciu` varchar(15) NOT NULL,
  `tura` varchar(50) NOT NULL,
  `parola` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dispatcher`
--

INSERT INTO `dispatcher` (`id_dispatcher`, `nume`, `prenume`, `telefon_serviciu`, `tura`, `parola`) VALUES
(1, 'Alexandru', 'Mihai', '0722333444', 'Zi', 'parola1'),
(2, 'Solomon', 'Andra', '0722444555', 'Noapte', 'parola2'),
(3, 'Alexiu', 'Radu', '0733111222', 'Zi', 'parola3'),
(4, 'Popescu', 'Cristian', '0734222333', 'Noapte', 'parola4'),
(5, 'Vlad', 'Robert', '0721112233', 'Zi', 'parola5'),
(6, 'Cirstoiu', 'Vlad', '0751047256', 'Noapte', 'parola6'),
(7, 'Baciu', 'Paul', '0751582057', 'Zi', 'parola7'),
(8, 'Carabelea', 'Petru', '0751139818', 'Noapte', 'parola8'),
(9, 'Petrescu', 'Irina', '0751703529', 'Zi', 'parola9'),
(10, 'Iliescu', 'Alin', '0751849570', 'Noapte', 'parola10');

-- --------------------------------------------------------

--
-- Table structure for table `echipaj`
--

CREATE TABLE `echipaj` (
  `id_echipaj` int(11) NOT NULL,
  `nume_echipaj` varchar(100) NOT NULL,
  `tip_echipaj` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `echipaj`
--

INSERT INTO `echipaj` (`id_echipaj`, `nume_echipaj`, `tip_echipaj`) VALUES
(1, 'Echipaj 1', 'Pompieri'),
(2, 'Echipaj 11', 'Politie 2'),
(3, 'Echipaj 3', 'Politie'),
(4, 'Echipaj 4', 'Jandarmerie'),
(5, 'Echipaj 5', 'Pompieri'),
(6, 'Echipaj 6', 'SMURD'),
(7, 'Echipaj 7', 'Pompieri'),
(8, 'Echipaj 8', 'Salvare'),
(9, 'Echipaj 9', 'Politie'),
(10, 'Echipaj 10', 'Jandarmerie'),
(11, 'Echipaj 1', 'Pompieri'),
(12, 'Echipaj 8', 'Politie'),
(13, 'Echipaj 4', 'Salvare'),
(14, 'Echipaj 6', 'SMURD'),
(15, 'Echipaj 12', 'Jandarmerie');

-- --------------------------------------------------------

--
-- Table structure for table `interventie`
--

CREATE TABLE `interventie` (
  `id_interventie` int(11) NOT NULL,
  `data_interventie` date NOT NULL,
  `ora_sosire` time NOT NULL,
  `id_locatie` int(11) DEFAULT NULL,
  `id_apel` int(11) DEFAULT NULL,
  `id_tip` int(11) DEFAULT NULL,
  `id_dispatcher` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `interventie`
--

INSERT INTO `interventie` (`id_interventie`, `data_interventie`, `ora_sosire`, `id_locatie`, `id_apel`, `id_tip`, `id_dispatcher`) VALUES
(1, '2025-01-01', '10:30:00', 1, 1, 1, 1),
(3, '2025-01-03', '12:30:00', 3, 3, 3, 3),
(4, '2025-01-04', '13:30:00', 4, 4, 4, 4),
(6, '2025-01-06', '15:30:00', 6, 6, 6, 6),
(8, '2025-01-08', '17:30:00', 8, 8, 8, 8),
(9, '2025-01-09', '18:30:00', 9, 9, 9, 9),
(10, '2025-01-10', '19:30:00', 10, 10, 10, 10),
(11, '2025-01-10', '14:20:00', 6, 6, 6, 1),
(13, '2025-01-12', '11:00:00', 8, 8, 8, 3),
(14, '2025-01-13', '09:45:00', 9, 9, 9, 4),
(15, '2025-01-13', '18:30:00', 10, 10, 10, 1);

-- --------------------------------------------------------

--
-- Table structure for table `interventie_echipaj`
--

CREATE TABLE `interventie_echipaj` (
  `id_interventie_echipaj` int(11) NOT NULL,
  `id_interventie` int(11) DEFAULT NULL,
  `id_echipaj` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `interventie_echipaj`
--

INSERT INTO `interventie_echipaj` (`id_interventie_echipaj`, `id_interventie`, `id_echipaj`) VALUES
(1, 1, 1),
(3, 3, 3),
(4, 4, 4),
(6, 6, 6),
(8, 8, 8),
(9, 9, 9),
(10, 10, 10),
(11, 6, 1),
(13, 8, 3),
(14, 9, 4),
(15, 10, 1),
(16, 10, 2);

-- --------------------------------------------------------

--
-- Table structure for table `locatie`
--

CREATE TABLE `locatie` (
  `id_locatie` int(11) NOT NULL,
  `adresa` varchar(255) DEFAULT NULL,
  `oras` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `locatie`
--

INSERT INTO `locatie` (`id_locatie`, `adresa`, `oras`) VALUES
(1, 'Strada Lalelelor 10', 'Bucuresti'),
(2, 'Strada Magnoliei 15', 'Cluj-Napoca'),
(3, 'Strada Trandafirilor 20', 'Timisoara'),
(4, 'Strada Panselutelor 8', 'Iasi'),
(5, 'Strada Crinului 18', 'Constanta'),
(6, 'Strada Zorilor 25', 'Brasov'),
(7, 'Strada Bujorului 12', 'Sibiu'),
(8, 'Strada Garoafei 30', 'Oradea'),
(9, 'Strada Viorelelor 5', 'Craiova'),
(10, 'Strada Irisului 14', 'Ploiesti'),
(11, 'Strada Florilor 10', 'Cluj-Napoca'),
(12, 'Bulevardul Unirii 23', 'Cluj-Napoca'),
(13, 'Strada Libertății 5', 'Iași'),
(14, 'Bulevardul Revoluției 15', 'Cluj-Napoca'),
(15, 'Strada Primăverii 30', 'Timișoara');

-- --------------------------------------------------------

--
-- Table structure for table `tip_interventie`
--

CREATE TABLE `tip_interventie` (
  `id_tip` int(11) NOT NULL,
  `denumire` varchar(50) NOT NULL,
  `prioritate` int(11) NOT NULL,
  `descriere` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tip_interventie`
--

INSERT INTO `tip_interventie` (`id_tip`, `denumire`, `prioritate`, `descriere`) VALUES
(1, 'Incendiu', 1, 'Interventie pentru incendiu de mari proportii.'),
(2, 'Accident', 2, 'Interventie pentru accident rutier.'),
(3, 'Inundatie', 2, 'Interventie pentru inundatie.'),
(4, 'Cutremur', 1, 'Interventie in caz de cutremur.'),
(5, 'Explozie', 1, 'Interventie pentru explozie.'),
(6, 'Salvare', 3, 'Interventie pentru salvare persoane.'),
(7, 'Epidemie', 1, 'Interventie pentru prevenire epidemii.'),
(8, 'Alunecare', 2, 'Interventie pentru alunecare de teren.'),
(9, 'Incendiu mic', 3, 'Interventie pentru incendiu de mica amploare.'),
(10, 'Poluare', 2, 'Interventie pentru poluare.'),
(11, 'Salvare', 2, 'Intervenție pentru salvarea de vieți'),
(12, 'Asistență 1', 0, 'Transport medical specializat'),
(13, 'Pompieri', 2, 'Stingere incendii în zone rezidențiale'),
(14, 'Ajutor tehnic', 0, 'Intervenție tehnică pentru defecțiuni'),
(15, 'Evacuare', 3, 'Evacuarea persoanelor din clădiri periculoase');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `apel`
--
ALTER TABLE `apel`
  ADD PRIMARY KEY (`id_apel`),
  ADD KEY `id_apelant` (`id_apelant`),
  ADD KEY `id_dispatcher` (`id_dispatcher`);

--
-- Indexes for table `apelant`
--
ALTER TABLE `apelant`
  ADD PRIMARY KEY (`id_apelant`);

--
-- Indexes for table `dispatcher`
--
ALTER TABLE `dispatcher`
  ADD PRIMARY KEY (`id_dispatcher`);

--
-- Indexes for table `echipaj`
--
ALTER TABLE `echipaj`
  ADD PRIMARY KEY (`id_echipaj`);

--
-- Indexes for table `interventie`
--
ALTER TABLE `interventie`
  ADD PRIMARY KEY (`id_interventie`),
  ADD KEY `id_apel` (`id_apel`),
  ADD KEY `id_tip` (`id_tip`),
  ADD KEY `id_dispatcher` (`id_dispatcher`);

--
-- Indexes for table `interventie_echipaj`
--
ALTER TABLE `interventie_echipaj`
  ADD PRIMARY KEY (`id_interventie_echipaj`),
  ADD KEY `id_interventie` (`id_interventie`),
  ADD KEY `id_echipaj` (`id_echipaj`);

--
-- Indexes for table `locatie`
--
ALTER TABLE `locatie`
  ADD PRIMARY KEY (`id_locatie`),
  ADD KEY `oras` (`oras`) USING BTREE,
  ADD KEY `adresa` (`adresa`) USING BTREE;

--
-- Indexes for table `tip_interventie`
--
ALTER TABLE `tip_interventie`
  ADD PRIMARY KEY (`id_tip`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `apel`
--
ALTER TABLE `apel`
  MODIFY `id_apel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `apelant`
--
ALTER TABLE `apelant`
  MODIFY `id_apelant` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `dispatcher`
--
ALTER TABLE `dispatcher`
  MODIFY `id_dispatcher` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `echipaj`
--
ALTER TABLE `echipaj`
  MODIFY `id_echipaj` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `interventie`
--
ALTER TABLE `interventie`
  MODIFY `id_interventie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `interventie_echipaj`
--
ALTER TABLE `interventie_echipaj`
  MODIFY `id_interventie_echipaj` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `locatie`
--
ALTER TABLE `locatie`
  MODIFY `id_locatie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `tip_interventie`
--
ALTER TABLE `tip_interventie`
  MODIFY `id_tip` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `apel`
--
ALTER TABLE `apel`
  ADD CONSTRAINT `apel_ibfk_1` FOREIGN KEY (`id_apelant`) REFERENCES `apelant` (`id_apelant`),
  ADD CONSTRAINT `apel_ibfk_2` FOREIGN KEY (`id_dispatcher`) REFERENCES `dispatcher` (`id_dispatcher`);

--
-- Constraints for table `interventie`
--
ALTER TABLE `interventie`
  ADD CONSTRAINT `interventie_ibfk_2` FOREIGN KEY (`id_apel`) REFERENCES `apel` (`id_apel`),
  ADD CONSTRAINT `interventie_ibfk_3` FOREIGN KEY (`id_tip`) REFERENCES `tip_interventie` (`id_tip`);

--
-- Constraints for table `interventie_echipaj`
--
ALTER TABLE `interventie_echipaj`
  ADD CONSTRAINT `interventie_echipaj_ibfk_1` FOREIGN KEY (`id_interventie`) REFERENCES `interventie` (`id_interventie`),
  ADD CONSTRAINT `interventie_echipaj_ibfk_2` FOREIGN KEY (`id_echipaj`) REFERENCES `echipaj` (`id_echipaj`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
