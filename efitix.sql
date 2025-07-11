-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 11 Jul 2025 pada 14.16
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `efitix`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `absensi`
--

CREATE TABLE `absensi` (
  `id` int(11) NOT NULL,
  `pekerja_id` int(11) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `shift` enum('Pagi','Sore','Malam') DEFAULT NULL,
  `status` enum('Hadir','Tidak Hadir','Belum Konfirmasi') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jadwal`
--

CREATE TABLE `jadwal` (
  `id` int(11) NOT NULL,
  `pekerja_id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `shift` enum('Pagi','Sore','Malam') NOT NULL,
  `status_kehadiran` enum('Belum','Belum Konfirmasi','Hadir','Tidak Hadir') DEFAULT 'Belum',
  `konfirmasi` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `jadwal`
--

INSERT INTO `jadwal` (`id`, `pekerja_id`, `tanggal`, `shift`, `status_kehadiran`, `konfirmasi`) VALUES
(1, 12, '2025-07-08', 'Pagi', 'Hadir', 1),
(2, 67, '2025-07-08', 'Pagi', 'Hadir', 1),
(3, 73, '2025-07-08', 'Malam', 'Hadir', 1),
(4, 72, '2025-07-08', 'Malam', 'Hadir', 1),
(5, 77, '2025-07-08', 'Pagi', 'Hadir', 1),
(6, 69, '2025-07-08', 'Pagi', 'Hadir', 1),
(7, 75, '2025-07-08', 'Malam', 'Hadir', 1),
(8, 74, '2025-07-08', 'Malam', 'Hadir', 1),
(9, 70, '2025-07-08', 'Pagi', 'Hadir', 1),
(10, 71, '2025-07-08', 'Sore', 'Hadir', 1),
(11, 12, '2025-07-09', 'Pagi', 'Hadir', 1),
(12, 67, '2025-07-09', 'Pagi', 'Belum', 0),
(13, 73, '2025-07-09', 'Malam', 'Belum', 0),
(14, 72, '2025-07-09', 'Malam', 'Belum', 0),
(15, 69, '2025-07-09', 'Pagi', 'Belum', 0),
(16, 77, '2025-07-09', 'Pagi', 'Belum', 0),
(17, 74, '2025-07-09', 'Malam', 'Belum', 0),
(18, 75, '2025-07-09', 'Malam', 'Belum', 0),
(19, 80, '2025-07-09', 'Pagi', 'Belum', 0),
(20, 71, '2025-07-09', 'Sore', 'Belum', 0),
(21, 12, '2025-07-11', 'Pagi', 'Hadir', 1),
(22, 67, '2025-07-11', 'Pagi', 'Hadir', 1),
(23, 82, '2025-07-11', 'Pagi', 'Hadir', 1),
(24, 73, '2025-07-11', 'Malam', 'Hadir', 1),
(25, 72, '2025-07-11', 'Malam', 'Hadir', 1),
(26, 77, '2025-07-11', 'Pagi', 'Hadir', 1),
(27, 69, '2025-07-11', 'Pagi', 'Hadir', 1),
(28, 75, '2025-07-11', 'Malam', 'Hadir', 1),
(29, 74, '2025-07-11', 'Malam', 'Hadir', 1),
(30, 80, '2025-07-11', 'Pagi', 'Hadir', 1),
(31, 81, '2025-07-11', 'Sore', 'Hadir', 1),
(32, 70, '2025-07-11', 'Pagi', 'Hadir', 1),
(33, 71, '2025-07-11', 'Sore', 'Hadir', 1),
(34, 83, '2025-07-11', 'Malam', 'Hadir', 1),
(35, 84, '2025-07-11', 'Malam', 'Hadir', 1),
(36, 85, '2025-07-11', 'Pagi', 'Hadir', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `laporan`
--

CREATE TABLE `laporan` (
  `id` int(11) NOT NULL,
  `periode_awal` date DEFAULT NULL,
  `periode_akhir` date DEFAULT NULL,
  `total_pengunjung` int(11) DEFAULT NULL,
  `total_tiket` int(11) DEFAULT NULL,
  `total_shift` int(11) DEFAULT NULL,
  `rata2_pekerja_per_hari` int(11) DEFAULT NULL,
  `dibuat_pada` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `notifikasi`
--

CREATE TABLE `notifikasi` (
  `id` int(11) NOT NULL,
  `pekerja_id` int(11) NOT NULL,
  `pesan` text NOT NULL,
  `tipe` enum('warning','info','danger') DEFAULT 'info',
  `waktu` time NOT NULL,
  `status` enum('belum_dibaca','dibaca') DEFAULT 'belum_dibaca'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `notifikasi`
--

INSERT INTO `notifikasi` (`id`, `pekerja_id`, `pesan`, `tipe`, `waktu`, `status`) VALUES
(1, 12, 'Segera konfirmasi kehadiran Anda untuk tanggal 08-07-2025 (Shift: Pagi)', 'warning', '20:20:10', 'belum_dibaca'),
(2, 67, 'Segera konfirmasi kehadiran Anda untuk tanggal 08-07-2025 (Shift: Pagi)', 'warning', '20:20:20', 'belum_dibaca'),
(3, 73, 'Segera konfirmasi kehadiran Anda untuk tanggal 08-07-2025 (Shift: Malam)', 'warning', '20:20:24', 'belum_dibaca'),
(4, 72, 'Segera konfirmasi kehadiran Anda untuk tanggal 08-07-2025 (Shift: Malam)', 'warning', '20:20:28', 'belum_dibaca'),
(5, 77, 'Segera konfirmasi kehadiran Anda untuk tanggal 08-07-2025 (Shift: Pagi)', 'warning', '20:20:32', 'belum_dibaca'),
(6, 69, 'Segera konfirmasi kehadiran Anda untuk tanggal 08-07-2025 (Shift: Pagi)', 'warning', '20:20:37', 'belum_dibaca'),
(7, 75, 'Segera konfirmasi kehadiran Anda untuk tanggal 08-07-2025 (Shift: Malam)', 'warning', '20:20:42', 'belum_dibaca'),
(8, 74, 'Segera konfirmasi kehadiran Anda untuk tanggal 08-07-2025 (Shift: Malam)', 'warning', '20:20:45', 'belum_dibaca'),
(9, 70, 'Segera konfirmasi kehadiran Anda untuk tanggal 08-07-2025 (Shift: Pagi)', 'warning', '20:20:49', 'belum_dibaca'),
(10, 71, 'Segera konfirmasi kehadiran Anda untuk tanggal 08-07-2025 (Shift: Sore)', 'warning', '20:20:52', 'belum_dibaca'),
(11, 12, 'Anda telah mengonfirmasi kehadiran sebagai \"Hadir\"', 'info', '20:23:17', 'belum_dibaca'),
(12, 67, 'Anda telah mengonfirmasi kehadiran sebagai \"Hadir\"', 'info', '20:24:17', 'belum_dibaca'),
(13, 73, 'Anda telah mengonfirmasi kehadiran sebagai \"Hadir\"', 'info', '20:24:40', 'belum_dibaca'),
(14, 72, 'Anda telah mengonfirmasi kehadiran sebagai \"Hadir\"', 'info', '20:24:57', 'belum_dibaca'),
(15, 77, 'Anda telah mengonfirmasi kehadiran sebagai \"Hadir\"', 'info', '20:25:16', 'belum_dibaca'),
(16, 69, 'Anda telah mengonfirmasi kehadiran sebagai \"Hadir\"', 'info', '20:25:32', 'belum_dibaca'),
(17, 75, 'Anda telah mengonfirmasi kehadiran sebagai \"Hadir\"', 'info', '20:26:00', 'belum_dibaca'),
(18, 74, 'Anda telah mengonfirmasi kehadiran sebagai \"Hadir\"', 'info', '20:26:15', 'belum_dibaca'),
(19, 70, 'Anda telah mengonfirmasi kehadiran sebagai \"Hadir\"', 'info', '20:26:34', 'belum_dibaca'),
(20, 71, 'Anda telah mengonfirmasi kehadiran sebagai \"Hadir\"', 'info', '20:26:51', 'belum_dibaca'),
(21, 12, 'Segera konfirmasi kehadiran Anda untuk tanggal 09-07-2025 (Shift: Pagi)', 'warning', '09:29:04', 'belum_dibaca'),
(22, 67, 'Segera konfirmasi kehadiran Anda untuk tanggal 09-07-2025 (Shift: Pagi)', 'warning', '09:29:13', 'belum_dibaca'),
(23, 73, 'Segera konfirmasi kehadiran Anda untuk tanggal 09-07-2025 (Shift: Malam)', 'warning', '09:29:29', 'belum_dibaca'),
(24, 72, 'Segera konfirmasi kehadiran Anda untuk tanggal 09-07-2025 (Shift: Malam)', 'warning', '09:29:37', 'belum_dibaca'),
(25, 69, 'Segera konfirmasi kehadiran Anda untuk tanggal 09-07-2025 (Shift: Pagi)', 'warning', '09:29:45', 'belum_dibaca'),
(26, 77, 'Segera konfirmasi kehadiran Anda untuk tanggal 09-07-2025 (Shift: Pagi)', 'warning', '09:29:52', 'belum_dibaca'),
(27, 74, 'Segera konfirmasi kehadiran Anda untuk tanggal 09-07-2025 (Shift: Malam)', 'warning', '09:29:59', 'belum_dibaca'),
(28, 75, 'Segera konfirmasi kehadiran Anda untuk tanggal 09-07-2025 (Shift: Malam)', 'warning', '09:30:04', 'belum_dibaca'),
(29, 80, 'Segera konfirmasi kehadiran Anda untuk tanggal 09-07-2025 (Shift: Pagi)', 'warning', '09:30:10', 'belum_dibaca'),
(30, 71, 'Segera konfirmasi kehadiran Anda untuk tanggal 09-07-2025 (Shift: Sore)', 'warning', '09:30:34', 'belum_dibaca'),
(31, 12, 'Anda telah mengonfirmasi kehadiran sebagai \"Hadir\"', 'info', '09:31:21', 'belum_dibaca'),
(32, 12, 'Segera konfirmasi kehadiran Anda untuk tanggal 11-07-2025 (Shift: Pagi)', 'warning', '18:45:28', 'belum_dibaca'),
(33, 67, 'Segera konfirmasi kehadiran Anda untuk tanggal 11-07-2025 (Shift: Pagi)', 'warning', '18:45:35', 'belum_dibaca'),
(34, 82, 'Segera konfirmasi kehadiran Anda untuk tanggal 11-07-2025 (Shift: Pagi)', 'warning', '18:48:26', 'belum_dibaca'),
(35, 73, 'Segera konfirmasi kehadiran Anda untuk tanggal 11-07-2025 (Shift: Malam)', 'warning', '18:49:33', 'belum_dibaca'),
(36, 72, 'Segera konfirmasi kehadiran Anda untuk tanggal 11-07-2025 (Shift: Malam)', 'warning', '18:49:40', 'belum_dibaca'),
(37, 77, 'Segera konfirmasi kehadiran Anda untuk tanggal 11-07-2025 (Shift: Pagi)', 'warning', '18:51:02', 'belum_dibaca'),
(38, 69, 'Segera konfirmasi kehadiran Anda untuk tanggal 11-07-2025 (Shift: Pagi)', 'warning', '18:51:11', 'belum_dibaca'),
(39, 75, 'Segera konfirmasi kehadiran Anda untuk tanggal 11-07-2025 (Shift: Malam)', 'warning', '18:51:19', 'belum_dibaca'),
(40, 74, 'Segera konfirmasi kehadiran Anda untuk tanggal 11-07-2025 (Shift: Malam)', 'warning', '18:51:24', 'belum_dibaca'),
(41, 80, 'Segera konfirmasi kehadiran Anda untuk tanggal 11-07-2025 (Shift: Pagi)', 'warning', '18:51:34', 'belum_dibaca'),
(42, 81, 'Segera konfirmasi kehadiran Anda untuk tanggal 11-07-2025 (Shift: Sore)', 'warning', '18:51:45', 'belum_dibaca'),
(43, 70, 'Segera konfirmasi kehadiran Anda untuk tanggal 11-07-2025 (Shift: Pagi)', 'warning', '18:51:58', 'belum_dibaca'),
(44, 71, 'Segera konfirmasi kehadiran Anda untuk tanggal 11-07-2025 (Shift: Sore)', 'warning', '18:52:04', 'belum_dibaca'),
(45, 83, 'Segera konfirmasi kehadiran Anda untuk tanggal 11-07-2025 (Shift: Malam)', 'warning', '18:53:01', 'belum_dibaca'),
(46, 84, 'Segera konfirmasi kehadiran Anda untuk tanggal 11-07-2025 (Shift: Malam)', 'warning', '18:54:26', 'belum_dibaca'),
(47, 85, 'Segera konfirmasi kehadiran Anda untuk tanggal 11-07-2025 (Shift: Pagi)', 'warning', '18:55:14', 'belum_dibaca'),
(48, 12, 'Anda telah mengonfirmasi kehadiran sebagai \"Hadir\"', 'info', '18:56:16', 'belum_dibaca'),
(49, 67, 'Anda telah mengonfirmasi kehadiran sebagai \"Hadir\"', 'info', '18:56:56', 'belum_dibaca'),
(50, 69, 'Anda telah mengonfirmasi kehadiran sebagai \"Hadir\"', 'info', '18:57:17', 'belum_dibaca'),
(51, 70, 'Anda telah mengonfirmasi kehadiran sebagai \"Hadir\"', 'info', '18:57:38', 'belum_dibaca'),
(52, 71, 'Anda telah mengonfirmasi kehadiran sebagai \"Hadir\"', 'info', '18:57:55', 'belum_dibaca'),
(53, 72, 'Anda telah mengonfirmasi kehadiran sebagai \"Hadir\"', 'info', '18:58:11', 'belum_dibaca'),
(54, 73, 'Anda telah mengonfirmasi kehadiran sebagai \"Hadir\"', 'info', '18:58:24', 'belum_dibaca'),
(55, 74, 'Anda telah mengonfirmasi kehadiran sebagai \"Hadir\"', 'info', '18:58:39', 'belum_dibaca'),
(56, 75, 'Anda telah mengonfirmasi kehadiran sebagai \"Hadir\"', 'info', '18:58:53', 'belum_dibaca'),
(57, 77, 'Anda telah mengonfirmasi kehadiran sebagai \"Hadir\"', 'info', '18:59:07', 'belum_dibaca'),
(58, 80, 'Anda telah mengonfirmasi kehadiran sebagai \"Hadir\"', 'info', '18:59:21', 'belum_dibaca'),
(59, 81, 'Anda telah mengonfirmasi kehadiran sebagai \"Hadir\"', 'info', '18:59:31', 'belum_dibaca'),
(60, 82, 'Anda telah mengonfirmasi kehadiran sebagai \"Hadir\"', 'info', '18:59:50', 'belum_dibaca'),
(61, 83, 'Anda telah mengonfirmasi kehadiran sebagai \"Hadir\"', 'info', '19:00:04', 'belum_dibaca'),
(62, 84, 'Anda telah mengonfirmasi kehadiran sebagai \"Hadir\"', 'info', '19:00:19', 'belum_dibaca'),
(63, 85, 'Anda telah mengonfirmasi kehadiran sebagai \"Hadir\"', 'info', '19:00:31', 'belum_dibaca');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pekerja`
--

CREATE TABLE `pekerja` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `jabatan` enum('Tiket','Validasi','Kebersihan','Admin') NOT NULL,
  `tipe` enum('Tetap','Freelance') NOT NULL,
  `hari_operasional` enum('Awal Pekan','Akhir Pekan','HLN/Event') NOT NULL,
  `tanggal_mulai` date DEFAULT NULL,
  `shift` enum('Pagi','Siang','Sore','Malam') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pekerja`
--

INSERT INTO `pekerja` (`id`, `user_id`, `nama_lengkap`, `email`, `jabatan`, `tipe`, `hari_operasional`, `tanggal_mulai`, `shift`) VALUES
(1, 4, 'Septian Angga Dwi Cahyo', 'septianangga2004@gmail.com', 'Admin', 'Tetap', 'Awal Pekan', '2025-07-07', 'Pagi'),
(2, 5, 'Ahmad Khaniful Huda', 'hanif1976@gmail.com', 'Admin', 'Tetap', 'Awal Pekan', '2025-07-07', 'Malam'),
(10, 13, 'admin', 'admin@gmail.com', 'Admin', 'Tetap', 'Akhir Pekan', '2025-07-07', 'Pagi'),
(12, 15, 'pekerja', 'pekerja@gmail.com', 'Tiket', 'Tetap', 'Awal Pekan', '2025-07-08', 'Pagi'),
(67, 79, 'Arjun', 'arjun@gmail.com', 'Tiket', 'Tetap', 'Awal Pekan', '2025-07-08', 'Pagi'),
(68, 80, 'Bima', 'bima@gmail.com', 'Validasi', 'Tetap', 'Awal Pekan', '2025-07-08', 'Pagi'),
(69, 81, 'Danu', 'danu@gmail.com', 'Validasi', 'Tetap', 'Awal Pekan', '2025-07-08', 'Pagi'),
(70, 82, 'Erlangga', 'erlangga@gmail.com', 'Kebersihan', 'Tetap', 'Awal Pekan', '2025-07-08', 'Pagi'),
(71, 83, 'Gatot', 'gatot@gmail.com', 'Kebersihan', 'Tetap', 'Awal Pekan', '2025-07-08', 'Sore'),
(72, 84, 'Hanung', 'hanung@gmail.com', 'Tiket', 'Tetap', 'Awal Pekan', '2025-07-08', 'Malam'),
(73, 85, 'Jaya', 'jaya@gmail.com', 'Tiket', 'Tetap', 'Awal Pekan', '2025-07-08', 'Malam'),
(74, 86, 'Kresna', 'kresna@gmail.com', 'Validasi', 'Tetap', 'Awal Pekan', '2025-07-08', 'Malam'),
(75, 87, 'Prabu', 'prabu@gmail.com', 'Validasi', 'Tetap', 'Awal Pekan', '2025-07-08', 'Malam'),
(77, 89, 'Asih', 'asih@gmail.com', 'Validasi', 'Tetap', 'Akhir Pekan', '2025-07-08', 'Pagi'),
(80, 92, 'Sardi', 'sardi@gmail.com', 'Kebersihan', 'Freelance', 'HLN/Event', '2025-07-08', 'Pagi'),
(81, 93, 'Toyib', 'toyib@gmail.com', 'Kebersihan', 'Freelance', 'HLN/Event', '2025-07-08', 'Sore'),
(82, 94, 'Wisnu', 'wisnu@gmail.com', 'Tiket', 'Tetap', 'Akhir Pekan', '2025-07-11', 'Pagi'),
(83, 95, 'Dewi', 'dewi@gmail.com', 'Tiket', 'Tetap', 'Akhir Pekan', '2025-07-11', 'Malam'),
(84, 96, 'Endah', 'endah@gmail.com', 'Validasi', 'Tetap', 'Akhir Pekan', '2025-07-11', 'Malam'),
(85, 97, 'Fitri', 'fitri@gmail.com', 'Validasi', 'Tetap', 'Akhir Pekan', '2025-07-11', 'Pagi');

-- --------------------------------------------------------

--
-- Struktur dari tabel `penjualan_tiket`
--

CREATE TABLE `penjualan_tiket` (
  `id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `jumlah_terjual` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `penjualan_tiket`
--

INSERT INTO `penjualan_tiket` (`id`, `tanggal`, `jumlah_terjual`) VALUES
(1, '2025-07-08', 95),
(2, '2025-07-09', 80),
(3, '2025-07-11', 145);

-- --------------------------------------------------------

--
-- Struktur dari tabel `prediksi`
--

CREATE TABLE `prediksi` (
  `id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `cuaca` varchar(50) DEFAULT NULL,
  `jumlah_pengunjung` int(11) NOT NULL,
  `tiket` int(11) DEFAULT 0,
  `validasi` int(11) DEFAULT 0,
  `kebersihan` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `prediksi`
--

INSERT INTO `prediksi` (`id`, `tanggal`, `cuaca`, `jumlah_pengunjung`, `tiket`, `validasi`, `kebersihan`) VALUES
(1, '2025-07-08', 'Cerah', 100, 4, 4, 2),
(2, '2025-07-09', 'Cerah', 100, 4, 4, 2),
(3, '2025-07-11', 'Cerah', 150, 6, 5, 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `prediksi_kebutuhan`
--

CREATE TABLE `prediksi_kebutuhan` (
  `id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `pengunjung` int(11) DEFAULT NULL,
  `tiket` int(11) DEFAULT NULL,
  `validasi` int(11) DEFAULT NULL,
  `kebersihan` int(11) DEFAULT NULL,
  `cuaca` varchar(50) DEFAULT NULL,
  `tipe_hari` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level` enum('admin','pekerja') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `level`, `created_at`) VALUES
(4, 'septian', '$2y$10$Q9FdukO48n/FoGqQyiEmieEKF.jKwuuFEVEiXfgfq.HTS5GAirmF2', 'admin', '2025-07-05 04:57:17'),
(5, 'hanif', '$2y$10$l88BiUO6BpzHgu6nzOh7DuPpqoQ46ZFLX6srvMox./GH9P3ZGCVVm', 'admin', '2025-07-05 05:07:44'),
(13, 'admin', '$2y$10$1s8ysHVBJOe0NbaYDyvtk.X7Ojbqjy8sAomiJ.xu1TcphFxU2WNna', 'admin', '2025-07-05 18:02:31'),
(15, 'pekerja', '$2y$10$t8U3rTmTOzaUtroOFQrVJuczN4bJWtYuiA5nPNPwjna8cjnSXE//q', 'pekerja', '2025-07-05 18:48:16'),
(79, 'arjun', '$2y$10$UgKh9EXcK/AuUXc.hPXBdeNJywTGVZlcsoHd8f4Fr/yy55iHB6l32', 'pekerja', '2025-07-08 07:19:07'),
(80, 'bima', '$2y$10$bfURtxsFLCucMpIMEt92D.dszFhPhpb9AR6w8uq403ftl8C9UcE3a', 'admin', '2025-07-08 07:20:24'),
(81, 'danu', '$2y$10$tYYsZQSdJ7et0vy74K3YhezXF6LnFFkhfshiYB4s.ZerVB.8v7eLq', 'pekerja', '2025-07-08 07:21:05'),
(82, 'erlangga', '$2y$10$GAvPtfVJgyEqyGFiDDwBk.RhDaEp5rVi/u0y9cMSfHrP9ORKXkyva', 'pekerja', '2025-07-08 07:22:01'),
(83, 'gatot', '$2y$10$sLiwrJ7S.2zXO17GS8V5XOelvQ8DPls/L.BLuOcmjpqbsC0mEsLki', 'pekerja', '2025-07-08 07:22:38'),
(84, 'hanung', '$2y$10$Za7STcVjhzjv47wJ8zbPIu.2jGX.OmGzfxG1QUoaamv6ExEITYLVe', 'pekerja', '2025-07-08 09:38:11'),
(85, 'jaya', '$2y$10$Ytj1Tbb7SreNoW3DvvVx3Oacoi6Iu9su3tmJ5MhZVOdOQ3ksS2QVu', 'pekerja', '2025-07-08 09:38:46'),
(86, 'kresna', '$2y$10$PUrT7m/dUuu4XhRCaujAGuIwvU9OcTZDlSN6fXA0ucbB6CPbTFFY6', 'pekerja', '2025-07-08 09:41:17'),
(87, 'prabu', '$2y$10$gbOn.9Nt130tldinChl0guYpt40PVos51Knu036NcnQfXKBryMvrS', 'pekerja', '2025-07-08 09:42:40'),
(89, 'asih', '$2y$10$h5GEKeqGdjJIhXuqpSSo1uJM4piG4dIXwNjO13KX29kk1AYgatK8W', 'pekerja', '2025-07-08 10:12:17'),
(92, 'sardi', '$2y$10$OSEmDEXlegz0gGBg4mqnYunsjpsuYnhBWbn.X08PQ3Fu.oadwCTGW', 'pekerja', '2025-07-08 14:13:26'),
(93, 'toyib', '$2y$10$VhXEKNlhgXcE9K3HLFIuuuOcVub7psiQKTNYm/FF3o4NxdvGy7DxW', 'pekerja', '2025-07-08 14:14:16'),
(94, 'wisnu', '$2y$10$Ow9fLJKtEq5vx7F7uunEtuFXiDSZ/GNSxIWP.ZXWd2VGNP/DjHJO6', 'pekerja', '2025-07-11 11:47:08'),
(95, 'dewi', '$2y$10$Kh4pludwO7AYbIpQKqYGTOh34zOprcp9BY70NIUrO2D.s5RBjlyH6', 'pekerja', '2025-07-11 11:52:53'),
(96, 'endah', '$2y$10$DBxyy447IbYC2BTNoO.7SOl1/2RrD.UqIXNYS22c8uzfdArwj6gye', 'pekerja', '2025-07-11 11:53:57'),
(97, 'fitri', '$2y$10$ARXsN/Qo.bd6uLZ3Z80Kneqf7WUzuDuXtNGYxg4GFNyD.wIWOxrQe', 'pekerja', '2025-07-11 11:55:07');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `jadwal`
--
ALTER TABLE `jadwal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pekerja_id` (`pekerja_id`);

--
-- Indeks untuk tabel `laporan`
--
ALTER TABLE `laporan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pekerja`
--
ALTER TABLE `pekerja`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `penjualan_tiket`
--
ALTER TABLE `penjualan_tiket`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `prediksi`
--
ALTER TABLE `prediksi`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unik_tanggal` (`tanggal`);

--
-- Indeks untuk tabel `prediksi_kebutuhan`
--
ALTER TABLE `prediksi_kebutuhan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tanggal` (`tanggal`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `absensi`
--
ALTER TABLE `absensi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jadwal`
--
ALTER TABLE `jadwal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT untuk tabel `laporan`
--
ALTER TABLE `laporan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `notifikasi`
--
ALTER TABLE `notifikasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT untuk tabel `pekerja`
--
ALTER TABLE `pekerja`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT untuk tabel `penjualan_tiket`
--
ALTER TABLE `penjualan_tiket`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `prediksi`
--
ALTER TABLE `prediksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `prediksi_kebutuhan`
--
ALTER TABLE `prediksi_kebutuhan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `jadwal`
--
ALTER TABLE `jadwal`
  ADD CONSTRAINT `jadwal_ibfk_1` FOREIGN KEY (`pekerja_id`) REFERENCES `pekerja` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pekerja`
--
ALTER TABLE `pekerja`
  ADD CONSTRAINT `pekerja_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
