-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 14 Jul 2022 pada 16.40
-- Versi server: 10.4.19-MariaDB
-- Versi PHP: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_bus`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `authentication`
--

CREATE TABLE `authentication` (
  `username` varchar(30) NOT NULL,
  `password` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `authentication`
--

INSERT INTO `authentication` (`username`, `password`) VALUES
('admin', 'admin123');

-- --------------------------------------------------------

--
-- Struktur dari tabel `bus`
--

CREATE TABLE `bus` (
  `bus_id` varchar(8) NOT NULL,
  `bus_name` varchar(15) NOT NULL,
  `capacity` int(3) NOT NULL,
  `departure_location` varchar(50) NOT NULL,
  `bus_type` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `bus`
--

INSERT INTO `bus` (`bus_id`, `bus_name`, `capacity`, `departure_location`, `bus_type`) VALUES
('2f3dbb46', 'Maju Jaya', 50, 'Yogyakarta', 'Economy'),
('3faf34c9', 'Primajaya', 50, 'Surabaya', 'Economy'),
('43e481a8', 'Kawan Lintas', 30, 'Semarang', 'Eksekutif'),
('5b1df9ca', 'Harapan Joyo', 50, 'Bandung', 'Eksekutif'),
('5c8c36eb', 'Lingkar Selatan', 40, 'Solo', 'Eksekutif'),
('db4daf40', 'kito rabus', 50, 'Jambi', 'Economy');

-- --------------------------------------------------------

--
-- Struktur dari tabel `destination`
--

CREATE TABLE `destination` (
  `destination_id` varchar(8) NOT NULL,
  `destination_name` varchar(15) NOT NULL,
  `quantity` int(11) NOT NULL,
  `terminal_name` varchar(30) NOT NULL,
  `terminal_address` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `destination`
--

INSERT INTO `destination` (`destination_id`, `destination_name`, `quantity`, `terminal_name`, `terminal_address`) VALUES
('0875e57e', 'Jambi', 40, 'Rawasari', 'Jl. Sukamajus'),
('1b42c845', 'Semarang', 45, 'Pasar Baru', 'Jl. Sekeliling'),
('469ea8c8', 'Bandung', 50, 'Pasar Caringin', 'Jl. Soekarno Hatta'),
('89878b30', 'Solo', 35, 'Solo Balapan', 'Jl. Jatayu'),
('ad903ecc', 'Yogyakarta', 50, 'Pasar lama', 'Jl. Kenangan'),
('df61b6b1', 'Jakarta', 30, 'Kebon Jeruk', 'Jl. Sukasari');

-- --------------------------------------------------------

--
-- Struktur dari tabel `passenger`
--

CREATE TABLE `passenger` (
  `passenger_id` varchar(8) NOT NULL,
  `name` varchar(30) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `phone_number` varchar(12) NOT NULL,
  `gender` enum('MALE','FEMALE') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `passenger_ticket`
--

CREATE TABLE `passenger_ticket` (
  `pass_ticket_id` varchar(8) NOT NULL,
  `ticket_id` varchar(8) NOT NULL,
  `passenger_id` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `ticket`
--

CREATE TABLE `ticket` (
  `ticket_id` varchar(8) NOT NULL,
  `destination_id` varchar(8) NOT NULL,
  `price` int(11) NOT NULL,
  `bus_id` varchar(8) NOT NULL,
  `seat_number` int(11) NOT NULL,
  `departure_time` text NOT NULL,
  `arrival_time` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `ticket`
--

INSERT INTO `ticket` (`ticket_id`, `destination_id`, `price`, `bus_id`, `seat_number`, `departure_time`, `arrival_time`) VALUES
('0b6efd65', 'df61b6b1', 9000000, 'db4daf40', 9, '2022-07-22 15:27', '2022-07-30 15:28'),
('d36383d4', '469ea8c8', 145000, '2f3dbb46', 4, '2022-07-12 16:14', '2022-07-15 16:14'),
('f6b26866', '89878b30', 100000, '3faf34c9', 10, '2022-07-15 15:48', '2022-07-16 15:48');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_profile`
--

CREATE TABLE `user_profile` (
  `profile_id` int(11) NOT NULL,
  `fullname` varchar(30) NOT NULL,
  `username` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `user_profile`
--

INSERT INTO `user_profile` (`profile_id`, `fullname`, `username`, `email`) VALUES
(1, 'Thoriq Hidayat', 'admin', 'thor@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `authentication`
--
ALTER TABLE `authentication`
  ADD PRIMARY KEY (`username`);

--
-- Indeks untuk tabel `bus`
--
ALTER TABLE `bus`
  ADD PRIMARY KEY (`bus_id`);

--
-- Indeks untuk tabel `destination`
--
ALTER TABLE `destination`
  ADD PRIMARY KEY (`destination_id`);

--
-- Indeks untuk tabel `passenger`
--
ALTER TABLE `passenger`
  ADD PRIMARY KEY (`passenger_id`);

--
-- Indeks untuk tabel `passenger_ticket`
--
ALTER TABLE `passenger_ticket`
  ADD PRIMARY KEY (`pass_ticket_id`),
  ADD KEY `fk_passenger` (`passenger_id`),
  ADD KEY `fk_ticket` (`ticket_id`);

--
-- Indeks untuk tabel `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`ticket_id`),
  ADD KEY `fk_destination` (`destination_id`),
  ADD KEY `fk_bus` (`bus_id`);

--
-- Indeks untuk tabel `user_profile`
--
ALTER TABLE `user_profile`
  ADD PRIMARY KEY (`profile_id`),
  ADD KEY `fk_username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `user_profile`
--
ALTER TABLE `user_profile`
  MODIFY `profile_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `passenger_ticket`
--
ALTER TABLE `passenger_ticket`
  ADD CONSTRAINT `fk_passenger` FOREIGN KEY (`passenger_id`) REFERENCES `passenger` (`passenger_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_ticket` FOREIGN KEY (`ticket_id`) REFERENCES `ticket` (`ticket_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `ticket`
--
ALTER TABLE `ticket`
  ADD CONSTRAINT `fk_bus` FOREIGN KEY (`bus_id`) REFERENCES `bus` (`bus_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_destination` FOREIGN KEY (`destination_id`) REFERENCES `destination` (`destination_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `user_profile`
--
ALTER TABLE `user_profile`
  ADD CONSTRAINT `fk_username` FOREIGN KEY (`username`) REFERENCES `authentication` (`username`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
