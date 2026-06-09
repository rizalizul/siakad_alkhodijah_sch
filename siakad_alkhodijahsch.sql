-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 17 Sep 2025 pada 05.26
-- Versi server: 8.0.30
-- Versi PHP: 8.3.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `siakad_alkhodijah2`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `absensi`
--

CREATE TABLE `absensi` (
  `id` bigint UNSIGNED NOT NULL,
  `kelas_siswa_id` bigint UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `status` enum('Hadir','Sakit','Izin','Tanpa Keterangan') COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `recorded_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `absensi`
--

INSERT INTO `absensi` (`id`, `kelas_siswa_id`, `tanggal`, `status`, `keterangan`, `recorded_by`, `created_at`, `updated_at`) VALUES
(1, 1, '2025-08-29', 'Sakit', NULL, 5, '2025-08-29 10:55:12', '2025-08-29 10:55:12'),
(2, 2, '2025-08-29', 'Izin', NULL, 5, '2025-08-29 10:55:12', '2025-08-29 10:55:12');

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `ekstrakurikuler`
--

CREATE TABLE `ekstrakurikuler` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_ekskul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `ekstrakurikuler`
--

INSERT INTO `ekstrakurikuler` (`id`, `nama_ekskul`, `deskripsi`, `created_at`, `updated_at`) VALUES
(1, 'Pramuka', NULL, '2025-08-29 08:24:49', '2025-08-29 08:24:49'),
(2, 'Menggambar', NULL, '2025-08-29 08:24:49', '2025-08-29 08:24:49'),
(3, 'Renang', NULL, '2025-08-29 08:24:49', '2025-08-29 08:24:49'),
(4, 'Storytelling', NULL, '2025-08-29 08:24:49', '2025-08-29 08:24:49'),
(5, 'Banjari', NULL, '2025-08-29 08:24:49', '2025-08-29 08:24:49');

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `guru`
--

CREATE TABLE `guru` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `nip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telepon` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `guru`
--

INSERT INTO `guru` (`id`, `user_id`, `nip`, `nama`, `jenis_kelamin`, `email`, `telepon`, `alamat`, `foto`, `created_at`, `updated_at`) VALUES
(1, 5, '199703252023022003', 'Nanda Fitriana, S.Pd.', 'Perempuan', 'nanda.fitriana@alkhodijah.sch', NULL, NULL, NULL, '2025-08-29 08:24:50', '2025-08-29 08:24:50'),
(2, 6, '199508172023012001', 'Adella Nuraini, S.Pd.', 'Perempuan', 'adella.nuraini@alkhodijah.sch', NULL, NULL, NULL, '2025-08-29 08:24:50', '2025-08-29 08:24:50'),
(3, 7, '199605202023012002', 'Ayu Putri Damai Hati, S.Pd.', 'Perempuan', 'ayu.putri@alkhodijah.sch', NULL, NULL, NULL, '2025-08-29 08:24:50', '2025-08-29 08:24:50'),
(4, 8, '199411102023021001', 'Azmil Ulya, S.H.', 'Laki-laki', 'azmil.ulya.guru@alkhodijah.sch', NULL, NULL, NULL, '2025-08-29 08:24:51', '2025-08-29 08:24:51');

-- --------------------------------------------------------

--
-- Struktur dari tabel `guru_mapel`
--

CREATE TABLE `guru_mapel` (
  `id` bigint UNSIGNED NOT NULL,
  `tahun_ajaran_nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guru_id` bigint UNSIGNED NOT NULL,
  `mapel_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `guru_mapel`
--

INSERT INTO `guru_mapel` (`id`, `tahun_ajaran_nama`, `guru_id`, `mapel_id`, `created_at`, `updated_at`) VALUES
(1, '2025/2026', 1, 3, '2025-08-29 09:15:58', '2025-08-29 09:15:58'),
(2, '2025/2026', 1, 8, '2025-08-29 09:16:21', '2025-08-29 09:16:21'),
(3, '2025/2026', 1, 2, '2025-08-29 09:16:31', '2025-08-29 09:16:31'),
(4, '2025/2026', 1, 4, '2025-08-29 09:16:59', '2025-08-29 09:16:59'),
(5, '2025/2026', 1, 7, '2025-08-29 09:17:19', '2025-08-29 09:17:19'),
(6, '2025/2026', 2, 5, '2025-08-29 09:17:38', '2025-08-29 09:17:38'),
(7, '2025/2026', 3, 6, '2025-08-29 09:17:52', '2025-08-29 09:17:52'),
(8, '2025/2026', 4, 1, '2025-08-29 09:18:08', '2025-08-29 09:18:08');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jadwal_pelajaran`
--

CREATE TABLE `jadwal_pelajaran` (
  `id` bigint UNSIGNED NOT NULL,
  `tahun_ajaran_nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kelas_id` bigint UNSIGNED NOT NULL,
  `mapel_id` bigint UNSIGNED NOT NULL,
  `guru_id` bigint UNSIGNED NOT NULL,
  `hari` enum('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu') COLLATE utf8mb4_unicode_ci NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `jadwal_pelajaran`
--

INSERT INTO `jadwal_pelajaran` (`id`, `tahun_ajaran_nama`, `kelas_id`, `mapel_id`, `guru_id`, `hari`, `jam_mulai`, `jam_selesai`, `created_at`, `updated_at`) VALUES
(1, '2025/2026', 1, 1, 4, 'Senin', '08:00:00', '10:00:00', '2025-08-29 09:21:58', '2025-08-29 09:21:58'),
(2, '2025/2026', 1, 6, 3, 'Rabu', '08:00:00', '10:00:00', '2025-08-29 10:51:27', '2025-08-29 10:51:27'),
(3, '2025/2026', 1, 5, 2, 'Selasa', '08:00:00', '10:00:00', '2025-08-29 10:51:51', '2025-08-29 10:51:51'),
(4, '2025/2026', 1, 2, 1, 'Senin', '10:30:00', '11:30:00', '2025-08-29 10:52:06', '2025-08-29 10:52:06'),
(5, '2025/2026', 1, 8, 1, 'Senin', '12:00:00', '13:00:00', '2025-08-29 10:52:17', '2025-08-29 10:52:17'),
(6, '2025/2026', 1, 7, 1, 'Kamis', '08:00:00', '10:00:00', '2025-08-29 10:52:32', '2025-08-29 10:52:32'),
(7, '2025/2026', 1, 3, 1, 'Selasa', '10:30:00', '11:30:00', '2025-08-29 10:52:55', '2025-08-29 10:52:55'),
(8, '2025/2026', 1, 4, 1, 'Selasa', '12:00:00', '13:00:00', '2025-08-29 10:53:08', '2025-08-29 10:53:08');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis_pembayaran`
--

CREATE TABLE `jenis_pembayaran` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_jenis` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah_default` decimal(15,2) DEFAULT NULL,
  `tahun_ajaran_nama` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `jenis_pembayaran`
--

INSERT INTO `jenis_pembayaran` (`id`, `nama_jenis`, `jumlah_default`, `tahun_ajaran_nama`, `created_at`, `updated_at`) VALUES
(1, 'Formulir Pendaftaran', 300000.00, '2026/2027', '2025-08-29 08:31:16', '2025-08-29 08:33:35'),
(2, 'Biaya Masuk Sekolah 2026/2027', 9000000.00, '2026/2027', '2025-08-29 08:32:01', '2025-08-29 08:32:01');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kelas`
--

CREATE TABLE `kelas` (
  `id` bigint UNSIGNED NOT NULL,
  `tahun_ajaran_nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_kelas` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tingkat_kelas` int NOT NULL,
  `wali_kelas_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `kelas`
--

INSERT INTO `kelas` (`id`, `tahun_ajaran_nama`, `nama_kelas`, `tingkat_kelas`, `wali_kelas_id`, `created_at`, `updated_at`) VALUES
(1, '2025/2026', '1A', 1, 1, '2025-08-29 09:18:23', '2025-08-29 09:18:23');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kelas_siswa`
--

CREATE TABLE `kelas_siswa` (
  `id` bigint UNSIGNED NOT NULL,
  `tahun_ajaran_nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `siswa_id` bigint UNSIGNED NOT NULL,
  `kelas_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `kelas_siswa`
--

INSERT INTO `kelas_siswa` (`id`, `tahun_ajaran_nama`, `siswa_id`, `kelas_id`, `created_at`, `updated_at`) VALUES
(1, '2025/2026', 1, 1, '2025-08-29 09:20:16', '2025-08-29 09:20:16'),
(2, '2025/2026', 2, 1, '2025-08-29 09:20:16', '2025-08-29 09:20:16');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mata_pelajaran`
--

CREATE TABLE `mata_pelajaran` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_mapel` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kelompok` enum('Wajib','Seni Pilihan','Muatan Lokal') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `mata_pelajaran`
--

INSERT INTO `mata_pelajaran` (`id`, `nama_mapel`, `kelompok`, `created_at`, `updated_at`) VALUES
(1, 'Pendidikan Agama dan Budi Pekerti', 'Wajib', '2025-08-29 08:24:49', '2025-08-29 08:24:49'),
(2, 'Matematika', 'Wajib', '2025-08-29 08:24:49', '2025-08-29 08:24:49'),
(3, 'Bahasa Indonesia', 'Wajib', '2025-08-29 08:24:49', '2025-08-29 08:24:49'),
(4, 'Pendidikan Pancasila', 'Wajib', '2025-08-29 08:24:49', '2025-08-29 08:24:49'),
(5, 'PJOK', 'Wajib', '2025-08-29 08:24:49', '2025-08-29 08:24:49'),
(6, 'Bahasa Inggris', 'Wajib', '2025-08-29 08:24:49', '2025-08-29 08:24:49'),
(7, 'Seni Rupa', 'Seni Pilihan', '2025-08-29 08:24:49', '2025-08-29 08:24:49'),
(8, 'Bahasa Jawa', 'Muatan Lokal', '2025-08-29 08:24:49', '2025-08-29 08:24:49');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_07_24_041900_create_tahun_ajaran_table', 1),
(5, '2025_07_24_041939_create_guru_table', 1),
(6, '2025_07_24_042025_create_siswa_table', 1),
(7, '2025_07_24_042118_create_kelas_table', 1),
(8, '2025_07_24_042155_create_kelas_siswa_table', 1),
(9, '2025_07_24_042222_create_mata_pelajaran_table', 1),
(10, '2025_07_24_042254_create_guru_mapel_table', 1),
(11, '2025_07_24_042319_create_jadwal_pelajaran_table', 1),
(12, '2025_07_24_042341_create_absensi_table', 1),
(13, '2025_07_24_042414_create_nilai_sumatif_table', 1),
(14, '2025_07_24_042415_create_nilai_tp_table', 1),
(15, '2025_07_24_042439_create_rapor_table', 1),
(16, '2025_07_24_042440_create_nilai_ekstrakurikuler_table', 1),
(17, '2025_07_24_042557_create_jenis_pembayaran_table', 1),
(18, '2025_07_24_042644_create_tagihan_table', 1),
(19, '2025_07_24_042740_create_pembayaran_table', 1),
(20, '2025_08_05_053339_create_ekstrakurikuler_table', 1),
(21, '2025_08_23_002059_add_ppdb_fields_to_tables', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `nilai_ekstrakurikuler`
--

CREATE TABLE `nilai_ekstrakurikuler` (
  `id` bigint UNSIGNED NOT NULL,
  `rapor_id` bigint UNSIGNED NOT NULL,
  `nama_ekskul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `nilai_ekstrakurikuler`
--

INSERT INTO `nilai_ekstrakurikuler` (`id`, `rapor_id`, `nama_ekskul`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 1, 'Banjari', 'baik', '2025-08-29 10:55:46', '2025-08-29 10:55:46');

-- --------------------------------------------------------

--
-- Struktur dari tabel `nilai_sumatif`
--

CREATE TABLE `nilai_sumatif` (
  `id` bigint UNSIGNED NOT NULL,
  `kelas_siswa_id` bigint UNSIGNED NOT NULL,
  `mapel_id` bigint UNSIGNED NOT NULL,
  `tahun_ajaran_id` bigint UNSIGNED NOT NULL,
  `nilai_sts` int DEFAULT NULL,
  `nilai_sas` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `nilai_sumatif`
--

INSERT INTO `nilai_sumatif` (`id`, `kelas_siswa_id`, `mapel_id`, `tahun_ajaran_id`, `nilai_sts`, `nilai_sas`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 95, 95, '2025-08-29 09:37:30', '2025-08-29 09:37:30'),
(2, 2, 1, 1, 86, 86, '2025-08-29 09:37:30', '2025-08-29 09:37:30');

-- --------------------------------------------------------

--
-- Struktur dari tabel `nilai_tp`
--

CREATE TABLE `nilai_tp` (
  `id` bigint UNSIGNED NOT NULL,
  `kelas_siswa_id` bigint UNSIGNED NOT NULL,
  `mapel_id` bigint UNSIGNED NOT NULL,
  `tahun_ajaran_id` bigint UNSIGNED NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `nilai` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `nilai_tp`
--

INSERT INTO `nilai_tp` (`id`, `kelas_siswa_id`, `mapel_id`, `tahun_ajaran_id`, `deskripsi`, `nilai`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 'Menjelaskan makna Al-Qur\'an', 97, '2025-08-29 09:30:55', '2025-08-29 09:37:30'),
(2, 2, 1, 1, 'Menjelaskan makna Al-Qur\'an', 87, '2025-08-29 09:30:55', '2025-08-29 09:37:30'),
(3, 1, 1, 1, 'melafalkan huruf hijaiyah', 96, '2025-08-29 09:31:09', '2025-08-29 09:37:30'),
(4, 2, 1, 1, 'melafalkan huruf hijaiyah', 86, '2025-08-29 09:31:09', '2025-08-29 09:37:30'),
(5, 1, 1, 1, 'menyebutkan arti harakat', 95, '2025-08-29 09:31:21', '2025-08-29 09:37:30'),
(6, 2, 1, 1, 'menyebutkan arti harakat', 86, '2025-08-29 09:31:21', '2025-08-29 09:37:30'),
(7, 1, 1, 1, 'menyebutkan macam-macam harakat dengan baik serta menghafalkan surah Al-Fatihah', 95, '2025-08-29 09:31:38', '2025-08-29 09:37:30'),
(8, 2, 1, 1, 'menyebutkan macam-macam harakat dengan baik serta menghafalkan surah Al-Fatihah', 86, '2025-08-29 09:31:38', '2025-08-29 09:37:30'),
(9, 1, 1, 1, 'menjelaskan rukun iman dengan baik', 95, '2025-08-29 09:31:49', '2025-08-29 09:37:30'),
(10, 2, 1, 1, 'menjelaskan rukun iman dengan baik', 86, '2025-08-29 09:31:49', '2025-08-29 09:37:30');

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id` bigint UNSIGNED NOT NULL,
  `tagihan_id` bigint UNSIGNED NOT NULL,
  `nomor_kwitansi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah_bayar` decimal(15,2) NOT NULL,
  `tanggal_bayar` date NOT NULL,
  `metode_bayar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bukti_pembayaran` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `termin_ke` int DEFAULT NULL,
  `dicatat_oleh_user_id` bigint UNSIGNED DEFAULT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pembayaran`
--

INSERT INTO `pembayaran` (`id`, `tagihan_id`, `nomor_kwitansi`, `jumlah_bayar`, `tanggal_bayar`, `metode_bayar`, `bukti_pembayaran`, `termin_ke`, `dicatat_oleh_user_id`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 1, 'KW2025082911', 300000.00, '2025-08-29', 'Tunai', NULL, NULL, 2, 'Pembayaran Formulir PPDB', '2025-08-29 08:37:03', '2025-08-29 08:37:03'),
(2, 3, 'KW2025082932', 300000.00, '2025-08-29', 'Tunai', NULL, NULL, 2, 'Pembayaran Formulir PPDB', '2025-08-29 08:39:08', '2025-08-29 08:39:08'),
(3, 5, 'KW2025082953', 300000.00, '2025-08-29', 'Tunai', NULL, NULL, 2, 'Pembayaran Formulir PPDB', '2025-08-29 08:39:16', '2025-08-29 08:39:16');

-- --------------------------------------------------------

--
-- Struktur dari tabel `rapor`
--

CREATE TABLE `rapor` (
  `id` bigint UNSIGNED NOT NULL,
  `kelas_siswa_id` bigint UNSIGNED NOT NULL,
  `tahun_ajaran_id` bigint UNSIGNED NOT NULL,
  `catatan_wali_kelas` text COLLATE utf8mb4_unicode_ci,
  `naik_kelas` tinyint(1) DEFAULT NULL,
  `status_rapor` enum('draft','final','ditandatangani') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `tanggal_cetak` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `rapor`
--

INSERT INTO `rapor` (`id`, `kelas_siswa_id`, `tahun_ajaran_id`, `catatan_wali_kelas`, `naik_kelas`, `status_rapor`, `tanggal_cetak`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'catatan', NULL, 'final', NULL, '2025-08-29 09:39:46', '2025-08-29 10:55:46');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('SK6M50ySmfmTV3N0M9hCrhTIf4NrTv2QFWo1YvFF', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibWVHUGdEVGVVc0JPNUhJNUhESXhvN3FGbzNHaG1pVWRXVFAzU2ZDZSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fX0=', 1758086729);

-- --------------------------------------------------------

--
-- Struktur dari tabel `siswa`
--

CREATE TABLE `siswa` (
  `id` bigint UNSIGNED NOT NULL,
  `no_pendaftaran` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_panggilan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nisn` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nis` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_lahir` date NOT NULL,
  `tempat_lahir` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') COLLATE utf8mb4_unicode_ci NOT NULL,
  `agama` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pendidikan_sebelumnya` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat_siswa` text COLLATE utf8mb4_unicode_ci,
  `no_wa_siswa` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_ayah` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pekerjaan_ayah` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_ibu` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pekerjaan_ibu` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_wa_ortu` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat_ortu` text COLLATE utf8mb4_unicode_ci,
  `nama_wali` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pekerjaan_wali` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat_wali` text COLLATE utf8mb4_unicode_ci,
  `kk` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ktp_ayah` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ktp_ibu` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hasil_screening` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `akta_kelahiran` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kia` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('calon','diverifikasi','menunggu_screening','aktif','lulus','pindah','tidak_diterima') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'calon',
  `tahun_ajaran_ppdb` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `guardian_user_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `siswa`
--

INSERT INTO `siswa` (`id`, `no_pendaftaran`, `nama`, `nama_panggilan`, `nisn`, `nis`, `tanggal_lahir`, `tempat_lahir`, `jenis_kelamin`, `agama`, `pendidikan_sebelumnya`, `alamat_siswa`, `no_wa_siswa`, `nama_ayah`, `pekerjaan_ayah`, `nama_ibu`, `pekerjaan_ibu`, `no_wa_ortu`, `alamat_ortu`, `nama_wali`, `pekerjaan_wali`, `alamat_wali`, `kk`, `ktp_ayah`, `ktp_ibu`, `foto`, `hasil_screening`, `akta_kelahiran`, `kia`, `status`, `tahun_ajaran_ppdb`, `guardian_user_id`, `created_at`, `updated_at`) VALUES
(1, 'PPDB-2025-0001', 'Achmad Nurudin Akbar', 'Akbar', '3176048474', '000001', '2017-03-08', 'Mojokerto', 'Laki-laki', 'Islam', 'Tk Bina Insani', 'Dsn Sambirejo RT 05 RW 06 Ds. Wringinrejo Kab. Mojokerto', NULL, 'Davi Feri Anus', 'Karyawan Swasta', 'Liza Isdarwanti', 'Wiraswasta', '089608972661', 'Dsn Sambirejo RT 005 RW 006', NULL, NULL, NULL, NULL, NULL, NULL, 'dokumen_ppdb/foto/8gSgydwtCNpMkzQi3JrctSHeU9TfARLxR02tcAHs.jpg', NULL, NULL, NULL, 'aktif', '2026/2027', NULL, '2025-08-29 08:24:51', '2025-08-29 11:15:17'),
(2, 'PPDB-2025-0002', 'Adzqia Sabiya Mahiswari', 'Sabiya', '3175920627', '000002', '2017-12-29', 'Sidoarjo', 'Perempuan', 'Islam', 'TK Bina Insani', 'Dsn Sambirejo RT 05 RW 06 Ds. Wringinrejo Kab. Mojokerto', NULL, 'Mochamad Rizqi R', 'Karyawan Swasta', 'Chistya Maulidya', 'Karyawan Swasta', '089608972661', 'Dsn Sambirejo RT 005 RW 006', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'aktif', '2026/2027', NULL, '2025-08-29 08:24:51', '2025-08-29 09:19:45'),
(3, 'PPDB-2025-0003', 'Ahmad Mahendra Afuww Pradipta', 'Mahen', '3179387977', NULL, '2017-06-29', 'Mojokerto', 'Laki-laki', 'Islam', 'TK Dharma Wanita Meri', 'Perum Wikarsa F 16 Ds. Kenanten Kec. Puri Kab. Mojokerto', NULL, 'Afif Syarifudin Muzakki', 'Karyawan Swasta', 'Lady Zuhriah Nur L', 'Wiraswasta', '089608972661', 'Perum Wikarsa F16', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'menunggu_screening', '2026/2027', NULL, '2025-08-29 08:24:51', '2025-08-29 08:39:16'),
(4, 'PPDB-2025-0004', 'Ahmad Rijal Muzakki', 'Rijal', '0178336992', NULL, '2017-01-13', 'Mojokerto', 'Laki-laki', 'Islam', 'TK Islam Miftahul Hikmah', 'Kedung Mulang RT 13 RW 03 Kel. Surodinawan Kota Mojokerto', NULL, 'Muhsin', 'Penjahit', 'Masruroh', 'Ibu Rumah Tangga', '089608972661', 'Kedung Mulang RT 013 RW 003', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'diverifikasi', '2026/2027', NULL, '2025-08-29 08:24:51', '2025-08-29 08:28:20'),
(5, 'PPDB-2025-0005', 'Aisyah Nur Hermansyah', 'Aisyah', '3174552524', NULL, '2017-05-24', 'Mojokerto', 'Perempuan', 'Islam', 'TK Muslimat NU 007 Nurul Huda', 'Prajurit Kulon Gang Baru Kec. Prajurit Kulon Kota Mojokerto', NULL, 'Herman Iswanto', 'Kuli Bangunan', 'Titin Nurhayati', 'Ibu Rumah Tangga', '089608972661', 'Prajurit Kulon Gg Baru', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'diverifikasi', '2026/2027', NULL, '2025-08-29 08:24:51', '2025-08-29 08:28:26'),
(6, 'PPDB-2025-0006', 'Aqila Mufia Fadheela', 'Aqila', '3173086698', NULL, '2017-11-12', 'Mojokerto', 'Perempuan', 'Islam', 'TK \'Aisyiyah Bustanul Athfal', 'Wisma Sooko Indah Jl Tongkol 3 No 235 Sooko Kab. Mojokerto', NULL, 'Wiratsongko', 'Karyawan Swasta', 'Dany Teftiani Karina', 'Wiraswasta', '089608972661', 'Wisma Sooko Indah Jl Tongkol 3 No 235', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'calon', NULL, NULL, '2025-08-29 08:24:51', '2025-08-29 08:24:51'),
(7, 'PPDB-2025-0007', 'Asyakila Firza Azzafa', 'Syakila', '3176516558', NULL, '2017-06-07', 'Mojokerto', 'Perempuan', 'Islam', 'TK Muslimat NU 007 Nurul Huda', 'Ds. Wringin Rejo RT 02 RW 01 Kec. Sooko Kab. Mojokerto', NULL, 'Iswahyudi Pristiawan', 'Karyawan Swasta', 'Yuli Nur Isnaini', 'Ibu Rumah Tangga', '089608972661', 'Wringinrejo RT 002 RW 001', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'calon', NULL, NULL, '2025-08-29 08:24:51', '2025-08-29 08:24:51'),
(8, 'PPDB-2025-0008', 'Aulia Syahila Salsabila', 'Aulia', '3188707058', NULL, '2018-01-18', 'Mojokerto', 'Perempuan', 'Islam', 'TK IMTAQ Mojokerto', 'Dsn Unggahan RT 02 RW 08 Desa Banjaragung Kec. Puri', NULL, 'Danny Hermanto', 'Wiraswasta', 'Newi Maulita', 'Wiraswasta', '089608972661', 'Dsn. Unggahan RT 002 RW 008', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'calon', NULL, NULL, '2025-08-29 08:24:51', '2025-08-29 08:24:51'),
(9, 'PPDB-2025-0009', 'Diajeng Gendhis Tifanani', 'Gendhis', '3173973413', NULL, '2017-12-03', 'Mojokerto', 'Perempuan', 'Islam', 'TK IMTAQ Mojokerto', 'Trenggilis RT 01 RW 02 Kel. Blooto Kota Mojokerto', NULL, 'Muhammad Fanani, SE', 'Karyawan Swasta', 'Maria Bunga Yuspitasari, S.Pd', 'Ibu Rumah Tangga', '089608972661', 'Trenggilis RT 001 RW 002', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'calon', NULL, NULL, '2025-08-29 08:24:51', '2025-08-29 08:24:51'),
(10, 'PPDB-2025-0010', 'Hanifa Hayatul Fitra', 'Hani', '3186385878', NULL, '2018-06-14', 'Mojokerto', 'Perempuan', 'Islam', 'TK NU Kota Sorong Papua', 'Perum. Star Residen 1 Sambiroto Kec. Sooko Kab. Mojokerto', NULL, 'Yoyok Hariyanto', 'POLRI', 'Suaibatul Islamiyah', 'Guru', '089608972661', 'Perum Star 1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'calon', NULL, NULL, '2025-08-29 08:24:51', '2025-08-29 08:24:51');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tagihan`
--

CREATE TABLE `tagihan` (
  `id` bigint UNSIGNED NOT NULL,
  `siswa_id` bigint UNSIGNED NOT NULL,
  `jenis_pembayaran_id` bigint UNSIGNED NOT NULL,
  `jumlah_tagihan` decimal(15,2) NOT NULL,
  `sisa_tagihan` decimal(15,2) NOT NULL,
  `status` enum('Belum Lunas','Lunas','Cicilan') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Belum Lunas',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tagihan`
--

INSERT INTO `tagihan` (`id`, `siswa_id`, `jenis_pembayaran_id`, `jumlah_tagihan`, `sisa_tagihan`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 300000.00, 0.00, 'Lunas', '2025-08-29 08:37:03', '2025-08-29 08:37:03'),
(2, 1, 2, 9000000.00, 9000000.00, 'Belum Lunas', '2025-08-29 08:37:03', '2025-08-29 08:37:03'),
(3, 2, 1, 300000.00, 0.00, 'Lunas', '2025-08-29 08:39:08', '2025-08-29 08:39:08'),
(4, 2, 2, 9000000.00, 9000000.00, 'Belum Lunas', '2025-08-29 08:39:08', '2025-08-29 08:39:08'),
(5, 3, 1, 300000.00, 0.00, 'Lunas', '2025-08-29 08:39:16', '2025-08-29 08:39:16'),
(6, 3, 2, 9000000.00, 9000000.00, 'Belum Lunas', '2025-08-29 08:39:16', '2025-08-29 08:39:16');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tahun_ajaran`
--

CREATE TABLE `tahun_ajaran` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `semester` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `is_ppdb_open` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tahun_ajaran`
--

INSERT INTO `tahun_ajaran` (`id`, `nama`, `semester`, `is_active`, `is_ppdb_open`, `created_at`, `updated_at`) VALUES
(1, '2025/2026', '1', 1, 0, '2025-08-29 08:30:18', '2025-08-29 08:30:40'),
(2, '2025/2026', '2', 0, 0, '2025-08-29 08:30:24', '2025-08-29 08:30:24'),
(3, '2026/2027', '1', 0, 1, '2025-08-29 08:30:32', '2025-08-29 08:30:47');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('staf_administrasi','bendahara','guru_mapel','wali_kelas','kepala_sekolah','wakasek_kurikulum','orang_tua') COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Rizky Firdausi Nuzula, S.M.', 'admin@alkhodijah.sch', NULL, '$2y$12$Wh1HgmBqtyw1qN4V6EXMeOQX.rblQ0oePh0CBlWiK29oHr.qHv.Ei', 'staf_administrasi', NULL, '2025-08-29 08:24:48', '2025-08-29 08:24:48'),
(2, 'Azmil Ulya, S.H.', 'bendahara@alkhodijah.sch', NULL, '$2y$12$/oiKe7j4/B6dJjDIPBSGoO/EsQ6yi1ifk99z9vVPJIUl.fUqoM5g.', 'bendahara', NULL, '2025-08-29 08:24:49', '2025-08-29 08:24:49'),
(3, 'Maslakhatul Ummah, S.H.', 'kurikulum@alkhodijah.sch', NULL, '$2y$12$0yACnog4Aon7Li2yyboK1uF/srUrlnBYCXL/ZMbbXfC4a2Dsw6Ae6', 'wakasek_kurikulum', NULL, '2025-08-29 08:24:49', '2025-08-29 08:24:49'),
(4, 'Afifatur Rosidah, S.Si., M.Sc.', 'kepsek@alkhodijah.sch', NULL, '$2y$12$Rr/Y5G6mukzno2igWnojg.d1vnl0UDtQpBFMM723MFRexSSK2DApq', 'kepala_sekolah', NULL, '2025-08-29 08:24:49', '2025-08-29 08:24:49'),
(5, 'Nanda Fitriana, S.Pd.', 'nanda.fitriana@alkhodijah.sch', NULL, '$2y$12$WnJl7yW90PcCiRUJKQJ.7em8S2ETuFQzJv1ZQ9REysAYNj0sbwGg6', 'wali_kelas', NULL, '2025-08-29 08:24:50', '2025-08-29 09:18:23'),
(6, 'Adella Nuraini, S.Pd.', 'adella.nuraini@alkhodijah.sch', NULL, '$2y$12$915gSjc09OXaxy8YA44Une2MIXW0HUQdNk/z4UZ8u6iOXKc1.fCue', 'guru_mapel', NULL, '2025-08-29 08:24:50', '2025-08-29 08:24:50'),
(7, 'Ayu Putri Damai Hati, S.Pd.', 'ayu.putri@alkhodijah.sch', NULL, '$2y$12$dkf6wbudTVHnqWUJtFJ6aOQIy9yi.h.NLZuBHcmL2bzWSzsg9sJC2', 'guru_mapel', NULL, '2025-08-29 08:24:50', '2025-08-29 08:24:50'),
(8, 'Azmil Ulya, S.H.', 'azmil.ulya.guru@alkhodijah.sch', NULL, '$2y$12$HSvjICHuZ/cvP4nvMg1Z2eJSsr.2CnK1d5vyvITadWhn1GRxiOW2W', 'guru_mapel', NULL, '2025-08-29 08:24:51', '2025-08-29 08:24:51');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `absensi_kelas_siswa_id_tanggal_unique` (`kelas_siswa_id`,`tanggal`),
  ADD KEY `absensi_recorded_by_foreign` (`recorded_by`);

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `ekstrakurikuler`
--
ALTER TABLE `ekstrakurikuler`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ekstrakurikuler_nama_ekskul_unique` (`nama_ekskul`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `guru`
--
ALTER TABLE `guru`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `guru_nip_unique` (`nip`),
  ADD UNIQUE KEY `guru_email_unique` (`email`),
  ADD KEY `guru_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `guru_mapel`
--
ALTER TABLE `guru_mapel`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `guru_mapel_guru_id_mapel_id_tahun_ajaran_nama_unique` (`guru_id`,`mapel_id`,`tahun_ajaran_nama`),
  ADD KEY `guru_mapel_mapel_id_foreign` (`mapel_id`);

--
-- Indeks untuk tabel `jadwal_pelajaran`
--
ALTER TABLE `jadwal_pelajaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jadwal_pelajaran_kelas_id_foreign` (`kelas_id`),
  ADD KEY `jadwal_pelajaran_mapel_id_foreign` (`mapel_id`),
  ADD KEY `jadwal_pelajaran_guru_id_foreign` (`guru_id`);

--
-- Indeks untuk tabel `jenis_pembayaran`
--
ALTER TABLE `jenis_pembayaran`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kelas_wali_kelas_id_foreign` (`wali_kelas_id`);

--
-- Indeks untuk tabel `kelas_siswa`
--
ALTER TABLE `kelas_siswa`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kelas_siswa_siswa_id_tahun_ajaran_nama_unique` (`siswa_id`,`tahun_ajaran_nama`),
  ADD KEY `kelas_siswa_kelas_id_foreign` (`kelas_id`);

--
-- Indeks untuk tabel `mata_pelajaran`
--
ALTER TABLE `mata_pelajaran`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `nilai_ekstrakurikuler`
--
ALTER TABLE `nilai_ekstrakurikuler`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nilai_ekstrakurikuler_rapor_id_foreign` (`rapor_id`);

--
-- Indeks untuk tabel `nilai_sumatif`
--
ALTER TABLE `nilai_sumatif`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nilai_sumatif_unique` (`kelas_siswa_id`,`mapel_id`,`tahun_ajaran_id`),
  ADD KEY `nilai_sumatif_mapel_id_foreign` (`mapel_id`),
  ADD KEY `nilai_sumatif_tahun_ajaran_id_foreign` (`tahun_ajaran_id`);

--
-- Indeks untuk tabel `nilai_tp`
--
ALTER TABLE `nilai_tp`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nilai_tp_kelas_siswa_id_foreign` (`kelas_siswa_id`),
  ADD KEY `nilai_tp_mapel_id_foreign` (`mapel_id`),
  ADD KEY `nilai_tp_tahun_ajaran_id_foreign` (`tahun_ajaran_id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pembayaran_nomor_kwitansi_unique` (`nomor_kwitansi`),
  ADD KEY `pembayaran_tagihan_id_foreign` (`tagihan_id`),
  ADD KEY `pembayaran_dicatat_oleh_user_id_foreign` (`dicatat_oleh_user_id`);

--
-- Indeks untuk tabel `rapor`
--
ALTER TABLE `rapor`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rapor_kelas_siswa_id_tahun_ajaran_id_unique` (`kelas_siswa_id`,`tahun_ajaran_id`),
  ADD KEY `rapor_tahun_ajaran_id_foreign` (`tahun_ajaran_id`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `siswa_nisn_unique` (`nisn`),
  ADD UNIQUE KEY `siswa_nis_unique` (`nis`),
  ADD UNIQUE KEY `siswa_no_pendaftaran_unique` (`no_pendaftaran`),
  ADD KEY `siswa_guardian_user_id_foreign` (`guardian_user_id`);

--
-- Indeks untuk tabel `tagihan`
--
ALTER TABLE `tagihan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tagihan_siswa_id_foreign` (`siswa_id`),
  ADD KEY `tagihan_jenis_pembayaran_id_foreign` (`jenis_pembayaran_id`);

--
-- Indeks untuk tabel `tahun_ajaran`
--
ALTER TABLE `tahun_ajaran`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tahun_ajaran_nama_semester_unique` (`nama`,`semester`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `absensi`
--
ALTER TABLE `absensi`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `ekstrakurikuler`
--
ALTER TABLE `ekstrakurikuler`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `guru`
--
ALTER TABLE `guru`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `guru_mapel`
--
ALTER TABLE `guru_mapel`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `jadwal_pelajaran`
--
ALTER TABLE `jadwal_pelajaran`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `jenis_pembayaran`
--
ALTER TABLE `jenis_pembayaran`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `kelas_siswa`
--
ALTER TABLE `kelas_siswa`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `mata_pelajaran`
--
ALTER TABLE `mata_pelajaran`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT untuk tabel `nilai_ekstrakurikuler`
--
ALTER TABLE `nilai_ekstrakurikuler`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `nilai_sumatif`
--
ALTER TABLE `nilai_sumatif`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `nilai_tp`
--
ALTER TABLE `nilai_tp`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `rapor`
--
ALTER TABLE `rapor`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `tagihan`
--
ALTER TABLE `tagihan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `tahun_ajaran`
--
ALTER TABLE `tahun_ajaran`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `absensi`
--
ALTER TABLE `absensi`
  ADD CONSTRAINT `absensi_kelas_siswa_id_foreign` FOREIGN KEY (`kelas_siswa_id`) REFERENCES `kelas_siswa` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `absensi_recorded_by_foreign` FOREIGN KEY (`recorded_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `guru`
--
ALTER TABLE `guru`
  ADD CONSTRAINT `guru_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `guru_mapel`
--
ALTER TABLE `guru_mapel`
  ADD CONSTRAINT `guru_mapel_guru_id_foreign` FOREIGN KEY (`guru_id`) REFERENCES `guru` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `guru_mapel_mapel_id_foreign` FOREIGN KEY (`mapel_id`) REFERENCES `mata_pelajaran` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `jadwal_pelajaran`
--
ALTER TABLE `jadwal_pelajaran`
  ADD CONSTRAINT `jadwal_pelajaran_guru_id_foreign` FOREIGN KEY (`guru_id`) REFERENCES `guru` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `jadwal_pelajaran_kelas_id_foreign` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `jadwal_pelajaran_mapel_id_foreign` FOREIGN KEY (`mapel_id`) REFERENCES `mata_pelajaran` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `kelas`
--
ALTER TABLE `kelas`
  ADD CONSTRAINT `kelas_wali_kelas_id_foreign` FOREIGN KEY (`wali_kelas_id`) REFERENCES `guru` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `kelas_siswa`
--
ALTER TABLE `kelas_siswa`
  ADD CONSTRAINT `kelas_siswa_kelas_id_foreign` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `kelas_siswa_siswa_id_foreign` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `nilai_ekstrakurikuler`
--
ALTER TABLE `nilai_ekstrakurikuler`
  ADD CONSTRAINT `nilai_ekstrakurikuler_rapor_id_foreign` FOREIGN KEY (`rapor_id`) REFERENCES `rapor` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `nilai_sumatif`
--
ALTER TABLE `nilai_sumatif`
  ADD CONSTRAINT `nilai_sumatif_kelas_siswa_id_foreign` FOREIGN KEY (`kelas_siswa_id`) REFERENCES `kelas_siswa` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `nilai_sumatif_mapel_id_foreign` FOREIGN KEY (`mapel_id`) REFERENCES `mata_pelajaran` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `nilai_sumatif_tahun_ajaran_id_foreign` FOREIGN KEY (`tahun_ajaran_id`) REFERENCES `tahun_ajaran` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `nilai_tp`
--
ALTER TABLE `nilai_tp`
  ADD CONSTRAINT `nilai_tp_kelas_siswa_id_foreign` FOREIGN KEY (`kelas_siswa_id`) REFERENCES `kelas_siswa` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `nilai_tp_mapel_id_foreign` FOREIGN KEY (`mapel_id`) REFERENCES `mata_pelajaran` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `nilai_tp_tahun_ajaran_id_foreign` FOREIGN KEY (`tahun_ajaran_id`) REFERENCES `tahun_ajaran` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_dicatat_oleh_user_id_foreign` FOREIGN KEY (`dicatat_oleh_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `pembayaran_tagihan_id_foreign` FOREIGN KEY (`tagihan_id`) REFERENCES `tagihan` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `rapor`
--
ALTER TABLE `rapor`
  ADD CONSTRAINT `rapor_kelas_siswa_id_foreign` FOREIGN KEY (`kelas_siswa_id`) REFERENCES `kelas_siswa` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `rapor_tahun_ajaran_id_foreign` FOREIGN KEY (`tahun_ajaran_id`) REFERENCES `tahun_ajaran` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `siswa`
--
ALTER TABLE `siswa`
  ADD CONSTRAINT `siswa_guardian_user_id_foreign` FOREIGN KEY (`guardian_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `tagihan`
--
ALTER TABLE `tagihan`
  ADD CONSTRAINT `tagihan_jenis_pembayaran_id_foreign` FOREIGN KEY (`jenis_pembayaran_id`) REFERENCES `jenis_pembayaran` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tagihan_siswa_id_foreign` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
