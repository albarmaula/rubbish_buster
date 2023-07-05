-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 05 Jul 2023 pada 22.30
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rubbish_buster`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `comments`
--

INSERT INTO `comments` (`id`, `post_id`, `email`, `content`, `created_at`) VALUES
(7, 36, 'Admin123@gmail.com', 'Weh Semangat', '2023-07-05 20:22:34'),
(8, 35, 'Admin123@gmail.com', 'Keren bang semangat yaa', '2023-07-05 20:22:49'),
(9, 36, 'Admin123@gmail.com', 'Semangat ngab!!\r\n', '2023-07-05 20:29:58');

-- --------------------------------------------------------

--
-- Struktur dari tabel `locations`
--

CREATE TABLE `locations` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `latitude` varchar(20) DEFAULT NULL,
  `longitude` varchar(20) DEFAULT NULL,
  `photo_path` varchar(255) DEFAULT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `locations`
--

INSERT INTO `locations` (`id`, `name`, `address`, `latitude`, `longitude`, `photo_path`, `status`) VALUES
(29, 'user', 'KEDONDONG KIDUL 1/55', '-7.261244', '112.754488', 'Logo-01.png', 'approved');

-- --------------------------------------------------------

--
-- Struktur dari tabel `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `image_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `posts`
--

INSERT INTO `posts` (`id`, `title`, `content`, `created_at`, `image_name`, `email`) VALUES
(35, 'Bersih Bersih Pagi', 'Minggu Pagi Bersih Bersih Yok', '2023-07-05 19:28:00', 'IMG_0498.PNG', 'muhamadzaim.w@gmail.com'),
(36, 'coba ke 2', 'ini post ke 2', '2023-07-05 19:41:09', 'cv_Intan.jpg', 'muhamadzaim.w@gmail.com');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `username` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone_num` varchar(20) DEFAULT NULL,
  `photo_path` varchar(255) DEFAULT NULL,
  `role` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`username`, `email`, `password`, `address`, `phone_num`, `photo_path`, `role`) VALUES
('Admin1', 'Admin', '$2y$10$Phb19gkL0mBmqixbLJMoyu.j/rVPBCYkz5eFRZZVtP97PBUcOOtda', 'KEDONDONG KIDUL 1/55', '085648499655', '', 'admin'),
('Widad(Admin)', 'Admin123@gmail.com', '$2y$10$062ZMLo4UYWc0BCDeLUHIuE.zLJvsShBUL6thl0OPP6dF.fB26NwO', 'Jl.Kedondong Kidul1/55', '082233445566', '', 'admin'),
('Muhammad Zaim Wibowo Ramadhani', 'muhamadzaim.w@gmail.com', '$2y$10$xB1g275TB2EABU.OJbs5xOkzcNnKhe2YZKVASfPznXBu/zWuP/Qbm', 'Jl.Kedondong Kidul1/55', '085648499655', '', ''),
('Nocz', 'Nocz@gmail.com', '$2y$10$3gNqZPxvfvWaDlOPJPg/g.rlv4BZyuOcozxYwYde9yrN/CCUhq5RK', NULL, NULL, NULL, ''),
('Wira ', 'Wira123@gmail.com', '$2y$10$x65zwynumbUl8ht0EIZHqu0VFipbOPbKA9MiqqX/p0OjKKf.9E/na', NULL, NULL, NULL, '');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `email` (`email`);

--
-- Indeks untuk tabel `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `locations`
--
ALTER TABLE `locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT untuk tabel `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`email`) REFERENCES `user` (`email`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
