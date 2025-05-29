-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 24, 2025 at 09:03 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cnews`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `email`, `password`) VALUES
(1, 'Coco Admin', 'coco@gmail.com', '$2y$10$7l4fDesf0qkPP67NSvkjnO3uAVdo69E0TqIbJ0nGJDepA7xf5PfO.');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Ubutabera'),
(2, 'Uburezi'),
(3, 'Asanzwe'),
(4, 'Imikino'),
(5, 'Ikoranabuhanga'),
(6, 'ubuzima'),
(7, 'ubukungu'),
(9, 'politiki');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `news_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `comment` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `news_id`, `name`, `email`, `comment`, `created_at`) VALUES
(1, 10, 'yves', '', 'good', '2025-05-04 11:25:32'),
(2, 10, 'aby', '', 'the best developer', '2025-05-04 11:25:57'),
(3, 1, 'esthermichhira domuto', 'michiraesther@gmail', '👋', '2025-05-04 11:37:39'),
(5, 1, 'yves', 'yvesabimana0@gmail.com', 'good news', '2025-05-04 11:39:32');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `name`, `email`, `message`, `created_at`) VALUES
(1, 'esthermichhira domuto', 'michiraesther@gmail', 'esthermichhira domutoesthermichhira domutoesthermichhira domutoesthermichhira domutoesthermichhira domutoesthermichhira domuto', '2025-05-04 10:53:36');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `title`, `content`, `category`, `image`, `created_at`) VALUES
(1, 'Abaminisitiri b’u Rwanda mu ngendo zo kureshya abashoramari', 'Abaminisitiri b’u Rwanda mu ngendo zo kureshya abashoramariAbaminisitiri b’u Rwanda mu ngendo zo kureshya abashoramariAbaminisitiri b’u Rwanda mu ngendo zo kureshya abashoramariAbaminisitiri b’u Rwanda mu ngendo zo kureshya abashoramariAbaminisitiri b’u Rwanda mu ngendo zo kureshya abashoramari', 'Ubukungu', '1746235714_2c0de1a6-3d17-498e-8a83-311fa2b33ea3.jfif', '2025-05-03 03:28:34'),
(2, 'APR VS RAYON', 'Umuryango nyarwanda wigeze kuzima urongera urazuka – Migeprof', 'Imikino', '1746333337_29bea996-447d-4dae-bc0a-f074b9d63317.jfif', '2025-05-04 02:30:07'),
(6, 'Umuryango nyarwanda wigeze kuzima urongera urazuka', 'Umuryango nyarwanda wigeze kuzima urongera urazuka – MigeprofUmuryango nyarwanda wigeze kuzima urongera urazuka – Migeprof', 'Asanzwe', '1746334254_15 Spiritual Meanings Of Seeing Letters In The Clouds.jfif', '2025-05-04 06:31:32'),
(9, 'Kuki Bugesera FC yitegura Rayon Sports yahagaritse Bakame na Peter Otema?', 'Kuki Bugesera FC yitegura Rayon Sports yahagaritse Bakame na Peter Otema?Kuki Bugesera FC yitegura Rayon Sports yahagaritse Bakame na Peter Otema?Kuki Bugesera FC yitegura Rayon Sports yahagaritse Bakame na Peter Otema?', 'Imikino', '1746343572_900+ For love of names ideas _ names, secret lovers, graphic image.jfif', '2025-05-04 09:26:12'),
(10, 'Impamvu buri Munyarwanda akwiye gukoresha RW nk’aderesi ye yo kuri murandasi', 'Impamvu buri Munyarwanda akwiye gukoresha RW nk’aderesi ye yo kuri murandasiImpamvu buri Munyarwanda akwiye gukoresha RW nk’aderesi ye yo kuri murandasi', 'Ikoranabuhanga', '1746344707_Coco DIY Custom LED Name Sign丨neon Light Sign Hanging丨neon Sign Custom丨flex Led Logo丨home Bar Wall Room Floor Decoration of Custom LED Sign - Etsy.jfif', '2025-05-04 09:45:07'),
(11, 'Ibibazo by’umutekano wa Afurika ntibyakemurwa n’abo hanze yayo - Perezida Kagame', 'Ibibazo by’umutekano wa Afurika ntibyakemurwa n’abo hanze yayo - Perezida KagameIbibazo by’umutekano wa Afurika ntibyakemurwa n’abo hanze yayo - Perezida KagameIbibazo by’umutekano wa Afurika ntibyakemurwa n’abo hanze yayo - Perezida Kagame', 'Asanzwe', '1746610816_blog-img.png', '2025-05-07 11:36:44'),
(12, 'Nta Gikundiro, nta Bugesera jye nzifanira u Rwanda', 'Nta Gikundiro, nta Bugesera jye nzifanira u RwandaNta Gikundiro, nta Bugesera jye nzifanira u RwandaNta Gikundiro, nta Bugesera jye nzifanira u RwandaNta Gikundiro, nta Bugesera jye nzifanira u Rwanda', 'Asanzwe', '1746610798_3D Diamond Letters, Dominic TT.jfif', '2025-05-07 11:38:00'),
(13, 'Ibibazo by’umutekano wa Afurika ntibyakemurwa n’abo hanze yayo - Perezida Kagame', 'Ibibazo by’umutekano wa Afurika ntibyakemurwa n’abo hanze yayo - Perezida KagameIbibazo by’umutekano wa Afurika ntibyakemurwa n’abo hanze yayo - Perezida KagameIbibazo by’umutekano wa Afurika ntibyakemurwa n’abo hanze yayo - Perezida Kagame', 'politiki', 'uploads/681bf1cc70027_about-bg.png', '2025-05-08 01:50:36');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `news_id` (`news_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
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
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`news_id`) REFERENCES `news` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
