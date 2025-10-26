-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 26, 2025 at 06:46 PM
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
-- Database: `stockbarang`
--

-- --------------------------------------------------------

--
-- Table structure for table `keluar`
--

CREATE TABLE `keluar` (
  `idkeluar` int(11) NOT NULL,
  `idbarang` int(11) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp(),
  `penerima` varchar(25) NOT NULL,
  `qty` int(11) NOT NULL,
  `admin` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `keluar`
--

INSERT INTO `keluar` (`idkeluar`, `idbarang`, `tanggal`, `penerima`, `qty`, `admin`) VALUES
(8, 5, '2025-10-26 14:45:10', '-', 14, 'Admin Y'),
(9, 6, '2025-10-26 14:45:26', '-', 9, 'Admin W'),
(10, 7, '2025-10-26 14:45:40', '-', 13, 'Admin Z'),
(11, 9, '2025-10-26 14:46:20', '-', 8, 'Admin W'),
(13, 11, '2025-10-26 15:55:12', '-', 15, 'Admin W');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `iduser` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`iduser`, `username`, `password`) VALUES
(1, 'yusuf8386', '12345'),
(2, 'wowo', '12345');

-- --------------------------------------------------------

--
-- Table structure for table `masuk`
--

CREATE TABLE `masuk` (
  `idmasuk` int(11) NOT NULL,
  `idbarang` int(11) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp(),
  `keterangan` varchar(25) NOT NULL,
  `qty` int(11) NOT NULL,
  `admin` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `masuk`
--

INSERT INTO `masuk` (`idmasuk`, `idbarang`, `tanggal`, `keterangan`, `qty`, `admin`) VALUES
(7, 5, '2025-10-26 14:36:58', '-', 9, 'Admin Z'),
(8, 6, '2025-10-26 14:38:37', '-', 15, 'Admin Y'),
(9, 7, '2025-10-26 14:40:09', '-', 21, 'Admin W'),
(10, 8, '2025-10-26 14:43:19', '-', 8, 'Admin Z'),
(11, 9, '2025-10-26 14:43:34', '-', 12, 'Admin W'),
(12, 10, '2025-10-26 14:43:54', '-', 7, 'Admin Y'),
(13, 11, '2025-10-26 14:44:07', '-', 15, 'Admin Y');

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `idbarang` int(11) NOT NULL,
  `namabarang` varchar(25) NOT NULL,
  `deskripsi` varchar(25) NOT NULL,
  `stock` int(11) NOT NULL,
  `image` varchar(99) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`idbarang`, `namabarang`, `deskripsi`, `stock`, `image`) VALUES
(5, 'Pulpen', 'Faber-Castell', 45, '948e335001fb7666087ddbe0d51cde59.png'),
(6, 'Gunting', 'Joyko', 40, 'cee2b3c03b9e67600db749fa77c015ed.jpg'),
(7, 'Pensil', 'Faber-Castell', 65, 'ae632c07ea2fcdd2ba0ef436feb62d41.png'),
(8, 'Kertas A4', 'Kiky', 33, '56f159c51e977fad9e66145510885fd2.jpg'),
(9, 'Buku Tulis', 'Campus', 54, '9fbd78b6bf2a1aec1db11828d4df687c.jpg'),
(10, 'Penggaris', 'Kenko', 22, 'f3f634b42f3304c87be7f1df1a615d35.png'),
(11, 'Spidol', 'Snowman', 43, '5793dab841c73eaa05de90ca9816424b.jpg'),
(13, 'Binder', 'Joyko', -11, 'bc0794dd07eeb46f9d6f418d07c6b170.jpg'),
(14, 'Moza R3', 'Mainan', 6, 'a1861f79aadddbcbc4e08c096c12525b.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `keluar`
--
ALTER TABLE `keluar`
  ADD PRIMARY KEY (`idkeluar`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`iduser`);

--
-- Indexes for table `masuk`
--
ALTER TABLE `masuk`
  ADD PRIMARY KEY (`idmasuk`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`idbarang`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `keluar`
--
ALTER TABLE `keluar`
  MODIFY `idkeluar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `iduser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `masuk`
--
ALTER TABLE `masuk`
  MODIFY `idmasuk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `idbarang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
