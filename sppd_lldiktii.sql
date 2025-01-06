-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 16, 2023 at 04:26 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sppd_lldikti`
--

-- --------------------------------------------------------

--
-- Table structure for table `disposisi`
--

CREATE TABLE `disposisi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `users_id` bigint(20) UNSIGNED NOT NULL,
  `pusat_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `disposisi`
--

INSERT INTO `disposisi` (`id`, `users_id`, `pusat_id`, `created_at`, `updated_at`) VALUES
(1, 2, 1, '2023-02-16 01:18:00', '2023-02-16 01:18:00');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fullboard`
--

CREATE TABLE `fullboard` (
  `id` bigint(20) NOT NULL,
  `jumlah` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fullboard`
--

INSERT INTO `fullboard` (`id`, `jumlah`) VALUES
(1, 110000);

-- --------------------------------------------------------

--
-- Table structure for table `jabatan`
--

CREATE TABLE `jabatan` (
  `id` bigint(20) NOT NULL,
  `nama_jabatan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jabatan`
--

INSERT INTO `jabatan` (`id`, `nama_jabatan`) VALUES
(4, 'Bendahara Pengeluaran Pembantu'),
(5, 'Pejabat Pembuat Komitmen'),
(6, 'Bendahara Pengeluaran'),
(7, 'Kepala LLDIKTI Wilayah X');

-- --------------------------------------------------------

--
-- Table structure for table `kantor`
--

CREATE TABLE `kantor` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `lokasi_id` bigint(20) UNSIGNED NOT NULL,
  `users_id` bigint(20) UNSIGNED NOT NULL,
  `judul_surat` varchar(255) NOT NULL,
  `tanggal_pergi` date NOT NULL,
  `tanggal_pulang` date NOT NULL,
  `lampiran_surat` varchar(255) NOT NULL,
  `status_keuangan` varchar(255) NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kantor`
--

INSERT INTO `kantor` (`id`, `lokasi_id`, `users_id`, `judul_surat`, `tanggal_pergi`, `tanggal_pulang`, `lampiran_surat`, `status_keuangan`, `created_at`, `updated_at`) VALUES
(1, 11, 1, 'tes 9', '2023-03-29', '2023-04-01', 'Salma.pdf', 'Pending', '2023-02-16 01:15:10', '2023-02-16 01:15:10'),
(2, 2, 1, 'tes 10', '2023-03-11', '2023-04-01', 'Salma1.pdf', 'Pending', '2023-02-16 01:15:10', '2023-02-16 01:15:10'),
(3, 1, 1, 'tes 11', '2023-03-11', '2023-04-01', 'Salma2.pdf', 'Pending', '2023-02-16 01:15:10', '2023-02-16 01:15:10'),
(4, 3, 1, 'tes 12', '2023-03-11', '2023-04-01', 'Salma3.pdf', 'Pending', '2023-02-16 01:15:10', '2023-02-16 01:15:10');

-- --------------------------------------------------------

--
-- Table structure for table `karyawan`
--

CREATE TABLE `karyawan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nip` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `gender` varchar(20) NOT NULL,
  `jabatan` varchar(255) NOT NULL,
  `golongan` varchar(255) NOT NULL,
  `divisi` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `karyawan`
--

INSERT INTO `karyawan` (`id`, `nip`, `nama`, `gender`, `jabatan`, `golongan`, `divisi`, `created_at`, `updated_at`) VALUES
(1, '197009192014091004', 'Yondri', 'Laki-laki', 'Pengadministrasi Persuratan', 'II b', 'TU & BMN', NULL, NULL),
(2, '197012051992032002', 'Afdalisma', 'Perempuan', 'Kepala', 'IV c', 'Pimpinan', NULL, NULL),
(3, '196805301993032002', 'Ernita', 'Perempuan', 'Pengelola Kepegawaian', 'III d', 'HKT', NULL, NULL),
(4, '198109142010121003', 'Wandi', 'Laki-laki', 'Pengelola Keuangan', 'III b', 'Perencanaan & Penganggaran', NULL, NULL),
(5, '196708231991032001', 'Ely Susanti', 'Perempuan', 'Analis SDM Aparatur Ahli Madya', 'IV b', 'Akademik & Kemahasiswaan', NULL, NULL),
(6, '196502101991032002', 'Febrina Fitri', 'Perempuan', 'Analis SDM Aparatur Ahli Madya', 'IV b', 'SDPT', NULL, NULL),
(8, '197302021998031007', 'Evrinaldi', 'Laki-laki', 'Analis Mutu dan Akademik', 'IV a', 'Akademik', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `karyawan_disposisi`
--

CREATE TABLE `karyawan_disposisi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `disposisi_id` bigint(20) UNSIGNED DEFAULT NULL,
  `karyawan_id` bigint(20) UNSIGNED NOT NULL,
  `pusat_id` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `karyawan_disposisi`
--

INSERT INTO `karyawan_disposisi` (`id`, `disposisi_id`, `karyawan_id`, `pusat_id`, `created_at`, `updated_at`) VALUES
(1, 1, 5, 1, '2023-02-16 01:17:55', '2023-02-16 01:18:00'),
(2, 1, 6, 1, '2023-02-16 01:17:55', '2023-02-16 01:18:00');

-- --------------------------------------------------------

--
-- Table structure for table `karyawan_kantor`
--

CREATE TABLE `karyawan_kantor` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kantor_id` bigint(20) UNSIGNED NOT NULL,
  `karyawan_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `karyawan_kantor`
--

INSERT INTO `karyawan_kantor` (`id`, `kantor_id`, `karyawan_id`, `created_at`, `updated_at`) VALUES
(1, 1, 2, '2023-02-16 01:15:10', '2023-02-16 01:15:10'),
(2, 2, 1, '2023-02-16 01:15:10', '2023-02-16 01:15:10'),
(3, 3, 4, '2023-02-16 01:15:10', '2023-02-16 01:15:10'),
(4, 4, 3, '2023-02-16 01:15:10', '2023-02-16 01:15:10');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_kategori` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id`, `nama_kategori`) VALUES
(1, 'Fullboard'),
(2, 'Fullday');

-- --------------------------------------------------------

--
-- Table structure for table `keuangan`
--

CREATE TABLE `keuangan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `users_id` bigint(20) UNSIGNED NOT NULL,
  `disposisi_id` bigint(20) UNSIGNED DEFAULT NULL,
  `pusat_id` bigint(20) UNSIGNED DEFAULT NULL,
  `kantor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `tipe_penginapan_id` bigint(20) UNSIGNED NOT NULL,
  `id_lokasi` bigint(20) UNSIGNED NOT NULL,
  `hari` bigint(20) NOT NULL DEFAULT 0,
  `uang_transport` int(11) DEFAULT NULL,
  `uang_penginapan` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `keterangan` varchar(1000) DEFAULT NULL,
  `kategori_id` bigint(20) DEFAULT NULL,
  `status_keuangan` varchar(255) NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `keuangan`
--

INSERT INTO `keuangan` (`id`, `users_id`, `disposisi_id`, `pusat_id`, `kantor_id`, `tipe_penginapan_id`, `id_lokasi`, `hari`, `uang_transport`, `uang_penginapan`, `created_at`, `updated_at`, `keterangan`, `kategori_id`, `status_keuangan`) VALUES
(5, 5, 1, 1, NULL, 1, 1, 0, NULL, NULL, NULL, NULL, 'padang Jakarta pp', NULL, 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `keuangan_pn`
--

CREATE TABLE `keuangan_pn` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pn_id` bigint(20) UNSIGNED DEFAULT NULL,
  `gabung_pn_id` bigint(20) UNSIGNED NOT NULL,
  `uang` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `keuangan_pn`
--

INSERT INTO `keuangan_pn` (`id`, `pn_id`, `gabung_pn_id`, `uang`, `created_at`, `updated_at`) VALUES
(6, 3, 5, 150000, '2023-02-16 03:23:02', '2023-02-16 03:23:02');

-- --------------------------------------------------------

--
-- Table structure for table `keuangan_tp`
--

CREATE TABLE `keuangan_tp` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `transport_id` bigint(20) UNSIGNED DEFAULT NULL,
  `gabung_tp_id` bigint(20) UNSIGNED NOT NULL,
  `uang` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `keuangan_tp`
--

INSERT INTO `keuangan_tp` (`id`, `transport_id`, `gabung_tp_id`, `uang`, `created_at`, `updated_at`) VALUES
(10, 3, 5, 2000000, '2023-02-16 03:23:02', '2023-02-16 03:23:02'),
(11, 2, 5, 200000, '2023-02-16 03:23:02', '2023-02-16 03:23:02');

-- --------------------------------------------------------

--
-- Table structure for table `lokasi`
--

CREATE TABLE `lokasi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `Provinsi` varchar(255) NOT NULL,
  `nama_kota` varchar(255) NOT NULL,
  `besaran_lumpsum` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lokasi`
--

INSERT INTO `lokasi` (`id`, `Provinsi`, `nama_kota`, `besaran_lumpsum`, `created_at`, `updated_at`) VALUES
(1, 'Jambi', 'Jambi', 1000000, NULL, NULL),
(2, 'DKI Jakarta', 'Jakarta', 2000000, NULL, NULL),
(3, 'Kalimantan Barat', 'Pontianak', 2500000, NULL, NULL),
(11, 'Sumatera Barat', 'Padang', 100000, '2023-02-02 08:42:42', '2023-02-02 08:42:42');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_11_142021_create_karyawan_table', 1),
(2, '2014_10_12_000000_create_users_table', 1),
(3, '2014_10_12_100000_create_password_resets_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2022_10_03_141802_create_lokasi_table', 1),
(7, '2022_10_03_141803_create_transportasi_table', 1),
(8, '2022_10_03_141804_create_penginapan_table', 1),
(9, '2022_10_03_141914_create_pusat_table', 1),
(10, '2022_10_03_141956_create_kantor_table', 1),
(11, '2022_10_03_141957_create_disposisi_table', 1),
(12, '2022_10_03_141958_create_keuangan_table', 1),
(13, '2022_10_25_031436_create_karyawan_kantor_table', 1),
(14, '2022_10_25_031533_create_karyawan_disposisi_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `penandatangan`
--

CREATE TABLE `penandatangan` (
  `id` bigint(20) NOT NULL,
  `karyawan_id` bigint(20) NOT NULL,
  `jabatan_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `penandatangan`
--

INSERT INTO `penandatangan` (`id`, `karyawan_id`, `jabatan_id`) VALUES
(1, 4, 4),
(2, 5, 5),
(3, 8, 6),
(4, 2, 7);

-- --------------------------------------------------------

--
-- Table structure for table `penginapan`
--

CREATE TABLE `penginapan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_penginapan` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `penginapan`
--

INSERT INTO `penginapan` (`id`, `nama_penginapan`, `created_at`, `updated_at`) VALUES
(1, 'The Premiere Hotel', NULL, NULL),
(2, 'Axana', NULL, NULL),
(3, 'Hotel Ibis', NULL, NULL),
(5, 'Hotel Mercure', NULL, NULL),
(6, '-', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pusat`
--

CREATE TABLE `pusat` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `lokasi_id` bigint(20) UNSIGNED NOT NULL,
  `users_id` bigint(20) UNSIGNED NOT NULL,
  `no_surat` varchar(255) NOT NULL,
  `judul_surat` varchar(255) NOT NULL,
  `tanggal_pergi` date NOT NULL,
  `tanggal_pulang` date NOT NULL,
  `lampiran_undangan` varchar(255) NOT NULL,
  `status_disposisi` varchar(255) NOT NULL DEFAULT 'Pending',
  `status_keuangan` varchar(255) NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pusat`
--

INSERT INTO `pusat` (`id`, `lokasi_id`, `users_id`, `no_surat`, `judul_surat`, `tanggal_pergi`, `tanggal_pulang`, `lampiran_undangan`, `status_disposisi`, `status_keuangan`, `created_at`, `updated_at`) VALUES
(1, 3, 1, '234', '432', '2023-02-17', '2023-02-20', '234.pdf', 'Terima', 'Pending', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `reff_tipe_lumpsum`
--

CREATE TABLE `reff_tipe_lumpsum` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tipe_lumpsum` varchar(20) NOT NULL,
  `jumlah` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reff_tipe_lumpsum`
--

INSERT INTO `reff_tipe_lumpsum` (`id`, `tipe_lumpsum`, `jumlah`) VALUES
(1, 'Fullboard', 110000),
(2, 'Fullday', 0);

-- --------------------------------------------------------

--
-- Table structure for table `transportasi`
--

CREATE TABLE `transportasi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `jenis_transportasi` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transportasi`
--

INSERT INTO `transportasi` (`id`, `jenis_transportasi`, `created_at`, `updated_at`) VALUES
(1, 'Bus', NULL, NULL),
(2, 'Pesawat', NULL, NULL),
(3, 'Mobil kantor', NULL, NULL),
(4, 'Taksi', NULL, NULL),
(5, 'Kapal', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `karyawan_id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role_user` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `karyawan_id`, `email`, `email_verified_at`, `password`, `role_user`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 1, 'yondri@gmail.com', NULL, '$2y$10$K793WRjWlR7c5fGV2oj1U.jmRgt7zS/mz1aGUXOxj51FrstMHEiZC', 'Admin', 'KEMyOmAGmsVWGlcE9pjvmeo7GOU7PDkvmKtBtRy9DKLdpUjpmUTg2nMovOcr', '2022-10-29 07:38:02', '2022-10-29 07:38:02'),
(2, 2, 'afdalisma@gmail.com', NULL, '$2y$10$/pCF2RmlR31Zrr11Vlzn9uU9DIqzERAa/pkRYCVAwvxxRhOvuoTTq', 'Pimpinan', NULL, '2022-10-29 07:43:09', '2022-10-29 07:43:09'),
(3, 3, 'ernita@gmail.com', NULL, '$2y$10$iylHicxrVeVXRmjxPkABzeA4XIzvivbttbIdNguZAsSJMHHG1PTIm', 'Admin HKT', NULL, '2022-10-29 07:43:25', '2022-10-29 07:43:25'),
(5, 4, 'wandi@gmail.com', NULL, '$2y$10$CXIMK8OWOI.K8PkRmXX/huSdNN0XSsMKtsP1fiLYKwP56EYIlktwu', 'Admin Keuangan', NULL, '2022-11-01 23:28:13', '2022-12-21 22:17:02');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `disposisi`
--
ALTER TABLE `disposisi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `disposisi_users_id_index` (`users_id`),
  ADD KEY `disposisi_pusat_id_index` (`pusat_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `fullboard`
--
ALTER TABLE `fullboard`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jabatan`
--
ALTER TABLE `jabatan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kantor`
--
ALTER TABLE `kantor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kantor_lokasi_id_index` (`lokasi_id`),
  ADD KEY `kantor_users_id_index` (`users_id`);

--
-- Indexes for table `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `karyawan_nip_unique` (`nip`);

--
-- Indexes for table `karyawan_disposisi`
--
ALTER TABLE `karyawan_disposisi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `karyawan_disposisi_disposisi_id_index` (`disposisi_id`),
  ADD KEY `karyawan_disposisi_karyawan_id_index` (`karyawan_id`),
  ADD KEY `pusat_id` (`pusat_id`);

--
-- Indexes for table `karyawan_kantor`
--
ALTER TABLE `karyawan_kantor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `karyawan_kantor_kantor_id_index` (`kantor_id`),
  ADD KEY `karyawan_kantor_karyawan_id_index` (`karyawan_id`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `keuangan`
--
ALTER TABLE `keuangan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `keuangan_users_id_index` (`users_id`),
  ADD KEY `keuangan_disposisi_id_index` (`disposisi_id`),
  ADD KEY `keuangan_kantor_id_index` (`kantor_id`),
  ADD KEY `tipe_penginapan_id` (`tipe_penginapan_id`),
  ADD KEY `id_lokasi` (`id_lokasi`),
  ADD KEY `pusat_id` (`pusat_id`);

--
-- Indexes for table `keuangan_pn`
--
ALTER TABLE `keuangan_pn`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pn_id` (`pn_id`),
  ADD KEY `gabung_pn_id` (`gabung_pn_id`);

--
-- Indexes for table `keuangan_tp`
--
ALTER TABLE `keuangan_tp`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transport_id` (`transport_id`),
  ADD KEY `gabung_tp_id` (`gabung_tp_id`);

--
-- Indexes for table `lokasi`
--
ALTER TABLE `lokasi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `penandatangan`
--
ALTER TABLE `penandatangan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `karyawan_id` (`karyawan_id`) USING BTREE,
  ADD KEY `jabatan_id` (`jabatan_id`);

--
-- Indexes for table `penginapan`
--
ALTER TABLE `penginapan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `pusat`
--
ALTER TABLE `pusat`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pusat_no_surat_unique` (`no_surat`),
  ADD KEY `pusat_lokasi_id_index` (`lokasi_id`),
  ADD KEY `pusat_users_id_index` (`users_id`);

--
-- Indexes for table `reff_tipe_lumpsum`
--
ALTER TABLE `reff_tipe_lumpsum`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transportasi`
--
ALTER TABLE `transportasi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_karyawan_id_index` (`karyawan_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `disposisi`
--
ALTER TABLE `disposisi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fullboard`
--
ALTER TABLE `fullboard`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110001;

--
-- AUTO_INCREMENT for table `jabatan`
--
ALTER TABLE `jabatan`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `kantor`
--
ALTER TABLE `kantor`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `karyawan`
--
ALTER TABLE `karyawan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `karyawan_disposisi`
--
ALTER TABLE `karyawan_disposisi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `karyawan_kantor`
--
ALTER TABLE `karyawan_kantor`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `keuangan`
--
ALTER TABLE `keuangan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `keuangan_pn`
--
ALTER TABLE `keuangan_pn`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `keuangan_tp`
--
ALTER TABLE `keuangan_tp`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `lokasi`
--
ALTER TABLE `lokasi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `penandatangan`
--
ALTER TABLE `penandatangan`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `penginapan`
--
ALTER TABLE `penginapan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pusat`
--
ALTER TABLE `pusat`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `transportasi`
--
ALTER TABLE `transportasi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `disposisi`
--
ALTER TABLE `disposisi`
  ADD CONSTRAINT `disposisi_pusat_id_foreign` FOREIGN KEY (`pusat_id`) REFERENCES `pusat` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `disposisi_users_id_foreign` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `kantor`
--
ALTER TABLE `kantor`
  ADD CONSTRAINT `kantor_lokasi_id_foreign` FOREIGN KEY (`lokasi_id`) REFERENCES `lokasi` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `kantor_users_id_foreign` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `karyawan_kantor`
--
ALTER TABLE `karyawan_kantor`
  ADD CONSTRAINT `karyawan_kantor_kantor_id_foreign` FOREIGN KEY (`kantor_id`) REFERENCES `kantor` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `karyawan_kantor_karyawan_id_foreign` FOREIGN KEY (`karyawan_id`) REFERENCES `karyawan` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `keuangan`
--
ALTER TABLE `keuangan`
  ADD CONSTRAINT `keuangan_disposisi_id_foreign` FOREIGN KEY (`disposisi_id`) REFERENCES `disposisi` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `keuangan_ibfk_1` FOREIGN KEY (`tipe_penginapan_id`) REFERENCES `reff_tipe_lumpsum` (`id`),
  ADD CONSTRAINT `keuangan_ibfk_2` FOREIGN KEY (`id_lokasi`) REFERENCES `lokasi` (`id`),
  ADD CONSTRAINT `keuangan_ibfk_3` FOREIGN KEY (`pusat_id`) REFERENCES `pusat` (`id`),
  ADD CONSTRAINT `keuangan_kantor_id_foreign` FOREIGN KEY (`kantor_id`) REFERENCES `kantor` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `keuangan_users_id_foreign` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `keuangan_pn`
--
ALTER TABLE `keuangan_pn`
  ADD CONSTRAINT `keuangan_pn_ibfk_1` FOREIGN KEY (`pn_id`) REFERENCES `penginapan` (`id`),
  ADD CONSTRAINT `keuangan_pn_ibfk_2` FOREIGN KEY (`gabung_pn_id`) REFERENCES `keuangan` (`id`);

--
-- Constraints for table `keuangan_tp`
--
ALTER TABLE `keuangan_tp`
  ADD CONSTRAINT `keuangan_tp_ibfk_1` FOREIGN KEY (`transport_id`) REFERENCES `transportasi` (`id`),
  ADD CONSTRAINT `keuangan_tp_ibfk_2` FOREIGN KEY (`gabung_tp_id`) REFERENCES `keuangan` (`id`),
  ADD CONSTRAINT `keuangan_tp_ibfk_3` FOREIGN KEY (`gabung_tp_id`) REFERENCES `keuangan` (`id`),
  ADD CONSTRAINT `keuangan_tp_ibfk_4` FOREIGN KEY (`gabung_tp_id`) REFERENCES `keuangan` (`id`);

--
-- Constraints for table `penandatangan`
--
ALTER TABLE `penandatangan`
  ADD CONSTRAINT `penandatangan_ibfk_1` FOREIGN KEY (`jabatan_id`) REFERENCES `jabatan` (`id`);

--
-- Constraints for table `pusat`
--
ALTER TABLE `pusat`
  ADD CONSTRAINT `pusat_lokasi_id_foreign` FOREIGN KEY (`lokasi_id`) REFERENCES `lokasi` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pusat_users_id_foreign` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_karyawan_id_foreign` FOREIGN KEY (`karyawan_id`) REFERENCES `karyawan` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
