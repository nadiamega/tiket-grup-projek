-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 08, 2026 at 08:22 AM
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
-- Database: `proweb`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `kode_tiket` varchar(20) NOT NULL,
  `nama_lengkap` varchar(150) NOT NULL,
  `event_id` int(11) NOT NULL,
  `kelas` varchar(50) NOT NULL,
  `telp` varchar(20) NOT NULL,
  `tanggal_beli` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `user_id`, `kode_tiket`, `nama_lengkap`, `event_id`, `kelas`, `telp`, `tanggal_beli`) VALUES
(1, 2, 'TKT-65H9OY', 'sekar ayu', 1, 'xi rpl 5', '0812345678910', '2026-05-22 20:47:04'),
(2, 2, 'TKT-FH15QR', 'sekar ayu', 3, 'xi rpl 5', '08123456789', '2026-05-22 20:47:21'),
(4, 3, 'TKT-16B51G', 'najwa habiba ramadhani', 1, 'xi rpl 3', '0812345678910', '2026-05-22 20:50:04'),
(5, 4, 'TKT-L7KYQK', 'Sherina Maftukhatul Aisyah', 1, 'xi rpl 3', '083830249806', '2026-05-22 20:50:39'),
(6, 4, 'TKT-ENOND5', 'Sherina Maftukhatul Aisyah', 3, 'xi rpl 3', '083830249806', '2026-05-22 20:50:51'),
(7, 5, 'TKT-2TZZBH', 'nayla zavir', 1, 'xi rpl 3', '08123456789', '2026-05-22 20:51:28'),
(8, 6, 'TKT-0ONCSW', 'nadia mega aulia renata', 1, 'xi rpl 3', '0828282726623', '2026-05-22 20:53:41'),
(9, 6, 'TKT-QDF009', 'nadia mega aulia renata', 2, 'xi rpl 3', '08123456789', '2026-05-22 20:53:51'),
(10, 6, 'TKT-RSCEPZ', 'nadia mega aulia renata', 3, 'xi rpl 3', '081114563677886', '2026-05-22 20:54:06'),
(11, 4, 'TKT-SSIZVG', 'Sherina Maftukhatul Aisyah', 2, 'xi rpl 3', '083830249806', '2026-05-22 20:54:33'),
(12, 6, 'TKT-OXSFCC', 'Nadia Mega', 5, 'xi rpl 3', '0888888888', '2026-06-03 23:24:26'),
(13, 3, 'TKT-8BRVPZ', 'SKAR AYU', 5, 'ki', 'asxadasda', '2026-09-07 11:23:33'),
(14, 3, 'TKT-PNS5ZC', 'bamba', 5, 'xi rpl 3', '47678535454', '2026-09-07 11:24:50'),
(15, 3, 'TKT-MGP91L', 'bam', 5, 'xi rpl 3', '088899987', '2026-09-07 11:25:36'),
(16, 3, 'TKT-M8LRIE', 'hunt', 3, 'xi rpl 3', '12345678qrtyui', '2026-09-07 11:27:11'),
(17, 3, 'TKT-GKRBKB', 'SKAR AYU', 2, 'xi rpl 3', '0888888888', '2026-09-08 13:06:37');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `nama_event` varchar(200) NOT NULL,
  `kategori` varchar(100) NOT NULL,
  `tanggal` date NOT NULL,
  `harga` varchar(50) NOT NULL,
  `kuota` int(11) NOT NULL DEFAULT 0,
  `lokasi` varchar(200) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `poster` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `nama_event`, `kategori`, `tanggal`, `harga`, `kuota`, `lokasi`, `deskripsi`, `poster`) VALUES
(1, 'Theater \"Born To Die\"', 'Hiburan', '2026-05-31', 'Rp 5.000', 45, 'Bioskop SMART2', '', ''),
(2, 'Camp Membaca Mingguan', 'Akademik', '2026-05-30', 'Gratis', 97, 'B.03-07', '', ''),
(3, 'Pameran Karya Seni', 'Seni dan Budaya', '2026-05-29', 'Rp 10.000', 96, 'B.1-07', '', ''),
(5, 'Pentas Seni', 'Hiburan', '2026-06-04', 'Gratis', 496, 'Lapangan Merah', 'Pertunjukan Pentas Seni.', 'poster_1780503638.png');

-- --------------------------------------------------------

--
-- Table structure for table `sponsors`
--

CREATE TABLE `sponsors` (
  `id` int(11) NOT NULL,
  `nama_sponsor` varchar(200) NOT NULL,
  `kategori` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `telp` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sponsors`
--

INSERT INTO `sponsors` (`id`, `nama_sponsor`, `kategori`, `email`, `telp`) VALUES
(1, 'serin', 'Konsumsi', 'sherina@gmail.com', '083830249806'),
(2, 'rinpoo', 'Gedung', 'rinpoo@gmail.com', '088889988878'),
(4, 'Nadia Mega', 'Konsumsi', 'nadiamega@gmail.com', '0888888888');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'admin_antartika', 'admin123', 'admin'),
(2, 'siswa1', 'siswa1', 'user'),
(3, 'rinpoo', '123', 'user'),
(4, 'serinimut', '123', 'user'),
(5, 'japirunyah', '123', 'user'),
(6, 'blackpepper', '123', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_tiket` (`kode_tiket`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sponsors`
--
ALTER TABLE `sponsors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sponsors`
--
ALTER TABLE `sponsors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
