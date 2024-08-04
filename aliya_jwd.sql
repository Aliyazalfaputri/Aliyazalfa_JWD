-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 04, 2024 at 02:58 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aliya_jwd`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `email`, `password`) VALUES
(1, 'admintravel@gmail.com', '$2y$10$Gn1kEMe9zuDiLYA1SGgUruFS0u.qMemI4M1ustpJ.j47uMTbKY9q.');

-- --------------------------------------------------------

--
-- Table structure for table `paket_wisata`
--

CREATE TABLE `paket_wisata` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `hari` int(11) NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `keterangan` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `gambar` varchar(255) DEFAULT NULL,
  `tanggal_mulai` date DEFAULT NULL,
  `tanggal_akhir` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `paket_wisata`
--

INSERT INTO `paket_wisata` (`id`, `judul`, `hari`, `harga`, `keterangan`, `created_at`, `gambar`, `tanggal_mulai`, `tanggal_akhir`) VALUES
(15, 'Keliling Yogyakarta', 2, 500000.00, 'Yogyakarta, atau \"Jogja,\" adalah jantung budaya dan seni Indonesia, menggabungkan tradisi klasik dengan kehidupan modern dalam harmoni yang menakjubkan. Dikenal dengan warisan sejarahnya yang kaya, dari Candi Borobudur yang megah hingga Keraton yang anggun, Jogja menawarkan pengalaman wisata yang tak terlupakan. Dalam tur 2 hari di Yogyakarta, Anda akan mengunjungi Candi Prambanan dan Keraton Yogyakarta pada hari pertama, serta menjelajahi Kota Gede dan berbelanja di Malioboro. Di hari kedua, saksikan keindahan sunrise di Candi Borobudur, berpetualang di Lava Tour Merapi, dan mengunjungi Taman Sari sambil menikmati kuliner khas Jogja. Nikmati dua hari penuh keajaiban di kota ini dan rasakan pesona Jogja yang memikat!', '2024-08-04 04:04:28', 'kelilingjogja.jpg', '2024-08-09', '2024-08-12'),
(16, 'Keliling Bandung', 2, 350000.00, 'Bandung, kota yang dikenal dengan keindahan alam dan pesona kulturalnya, menawarkan pengalaman liburan yang mengesankan. Dalam tur 2 hari kami, Anda akan memulai petualangan dengan mengunjungi Kawah Putih dan menjelajahi pasar tradisional di Ciwidey, serta menikmati arsitektur bersejarah Gedung Sate. Di hari kedua, Anda akan disuguhkan keindahan Tangkuban Perahu dengan kawah vulkaniknya yang menakjubkan, berkeliling di kawasan Dago untuk menemukan berbagai tempat makan dan belanja unik, dan bersantai di Farmhouse Lembang. Nikmati keindahan alam dan budaya Bandung dengan tur kami yang penuh aktivitas menarik dan pengalaman yang memukau!', '2024-08-04 04:24:10', 'kelilingbandung.jpg', '2024-08-11', '2024-08-14'),
(17, 'Keliling Bali', 3, 600000.00, 'Temukan pesona Bali dalam tur 2 hari yang tak terlupakan! Pada hari pertama, kunjungi Pura Tanah Lot untuk menikmati pemandangan matahari terbenam yang menakjubkan, lalu jelajahi Ubud dengan pasar seni dan Monkey Forest yang ikonik. Akhiri hari dengan santapan malam di restoran lokal yang menyajikan hidangan khas Bali. Pada hari kedua, bersantailah di Pantai Kuta yang terkenal, kunjungi Pura Besakih yang megah, dan nikmati waktu bersantai di Nusa Dua Beach. Rasakan keindahan alam dan budaya Bali dalam waktu singkat ini!', '2024-08-04 04:25:27', 'kelilingbali.jpg', '2024-08-19', '2024-08-22'),
(18, 'Keliling Malang', 2, 650000.00, 'Rasakan keajaiban Malang dan Bromo dalam tur 2 hari yang memukau! Pada hari pertama, jelajahi keindahan Kota Malang dengan mengunjungi Jatim Park dan Museum Angkut, lalu nikmati kelezatan kuliner lokal di alun-alun kota. Pada malam hari, berangkat menuju Gunung Bromo untuk persiapan menyaksikan matahari terbit yang spektakuler. Di hari kedua, saksikan keindahan matahari terbit di Bromo, berpetualang ke lautan pasir, dan nikmati panorama kawah yang menakjubkan. Akhiri perjalanan dengan mengunjungi air terjun Canting di Malang sebelum kembali ke kota.', '2024-08-04 04:26:37', 'kelilingmalang.JPG', '2024-08-12', '2024-08-15'),
(19, 'Tour Raja Ampat', 3, 500000.00, 'Temukan surga tersembunyi di Raja Ampat, Papua Barat, yang dikenal sebagai salah satu destinasi terindah di dunia dengan kekayaan terumbu karang dan keanekaragaman hayati bawah lautnya. Dalam tur 3 hari, nikmati keindahan pantai pasir putih dan air jernih Raja Ampat. Hari pertama, snorkeling di Misool dan menjelajahi keindahan bawah lautnya. Hari kedua, kunjungi Wayag untuk melihat pemandangan menakjubkan dari puncak bukit dan snorkeling di kawasan sekitar. Hari ketiga, jelajahi pulau-pulau kecil di sekitar Waigeo dan rasakan kehangatan budaya lokal sebelum kembali. Nikmati pengalaman tak terlupakan di surga tropis ini!', '2024-08-04 04:29:17', 'tourrajaampat.jpg', '2024-08-12', '2024-08-16');

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `id` int(11) NOT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `nomor_telepon` varchar(15) NOT NULL,
  `kata_sandi` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`id`, `nama_lengkap`, `alamat`, `email`, `nomor_telepon`, `kata_sandi`) VALUES
(3, 'ALIYA ZALFA PUTRI', 'kedaton', 'aliyazalfa186@gmail.com', '085156826366', '$2y$10$/q0jor9ivrRI1isP4eEq3OUar0Aj63o8aIzo4a.KJSy7e3L2NTrGC'),
(6, 'Naura', 'Jakarta Pusat', 'naura@gmail.com', '087659826112', '$2y$10$ALzuCZzK72EhVif5J.oow.bWMTpl17o2MAC6skcgLIogaFy4Ag986'),
(9, 'Putri Maharani', 'Sumatera Selatan', 'pmaharani00@gmail.com', '089152387719', '$2y$10$fX5J1nU/LrWApbjGqIVjU.opZcG34kBWoM1pqMlycYxE/HcNzw92K');

-- --------------------------------------------------------

--
-- Table structure for table `reservasi`
--

CREATE TABLE `reservasi` (
  `id` int(11) NOT NULL,
  `jenis_tour` varchar(255) DEFAULT NULL,
  `nama_pemesan` varchar(100) NOT NULL,
  `nomor_tel_hp` varchar(15) NOT NULL,
  `waktu_pelaksanaan` varchar(255) NOT NULL,
  `jumlah_peserta` int(11) NOT NULL,
  `pelayanan_paket` text NOT NULL,
  `harga_paket` int(11) NOT NULL,
  `jumlah_tagihan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservasi`
--

INSERT INTO `reservasi` (`id`, `jenis_tour`, `nama_pemesan`, `nomor_tel_hp`, `waktu_pelaksanaan`, `jumlah_peserta`, `pelayanan_paket`, `harga_paket`, `jumlah_tagihan`) VALUES
(15, 'Keliling Yogyakarta', 'Aliya Zalfa', '085156826636', '9 Aug 2024 - 12 Aug 2024', 2, 'Penginapan, Transportasi', 2200000, 9800000),
(16, 'Keliling Bali', 'Putri Maharani', '089152387719', '19 Aug 2024 - 22 Aug 2024', 3, 'Penginapan, Transportasi, Makanan', 2700000, 26100000),
(17, 'Tour Raja Ampat', 'Naura', '081231447123', '12 Aug 2024 - 16 Aug 2024', 2, 'Penginapan, Transportasi', 2200000, 14200000);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `paket_wisata`
--
ALTER TABLE `paket_wisata`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `reservasi`
--
ALTER TABLE `reservasi`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `paket_wisata`
--
ALTER TABLE `paket_wisata`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `reservasi`
--
ALTER TABLE `reservasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
