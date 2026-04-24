-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 23 Apr 2026 pada 12.56
-- Versi server: 8.0.30
-- Versi PHP: 8.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fadya_ukk`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `books`
--

CREATE TABLE `books` (
  `id` bigint UNSIGNED NOT NULL,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `publisher` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `publish_year` year DEFAULT NULL,
  `stock` int UNSIGNED NOT NULL DEFAULT '0',
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `books`
--

INSERT INTO `books` (`id`, `code`, `title`, `author`, `publisher`, `publish_year`, `stock`, `description`, `image`, `created_at`, `updated_at`) VALUES
(1, 'BK003', 'Matematika Wajib Kelas X', 'Siti Aminah', 'Gramedia', '2021', 10, 'Buku pelajaran matematika untuk siswa kelas 10', 'books/7INDpRzJkOc3F0VCNaRJYhP27vk99DAwy58H7N8K.jpg', '2026-04-22 18:10:41', '2026-04-22 23:26:06'),
(2, 'BK015', 'Bahasa Indonesia Kelas XII', 'Dian Pratiwi', 'Balai Pustaka', '2021', 19, 'Materi bahasa Indonesia kelas 12', 'books/qt5MWaQ87peE7SJfbI7Hw52LrFe50AnVqFJzhW24.jpg', '2026-04-22 18:29:14', '2026-04-22 23:25:04'),
(3, 'BK018', 'Pendidikan Jasmani', 'Rizky Ramadhan', 'Informatika', '2024', 24, 'Olahraga dan kesehatan tubuh', 'books/0BsAlACr1JwaVkh5t2loRoekwiSvHcyuzLo88K9t.jpg', '2026-04-22 18:33:43', '2026-04-23 02:12:47'),
(5, 'BK034', 'Malin Kundang', 'nanai', 'Balai Pustaka', '2013', 15, 'Anak durhaka jadi batu', 'books/MIRd0lC037fgIbGtP2dj951PFWqIV0BYBWTbP5y3.jpg', '2026-04-22 22:20:05', '2026-04-23 03:28:31'),
(6, 'BK031', 'Si Kancil dan Buaya', 'sri ayu', 'Nusantara Press', '2025', 10, 'Kisah kecerdikan si kancil', 'books/V1rBofi9l4BbJgWpzAFnxDPpfNM6TRekly4kjqxM.jpg', '2026-04-22 22:23:47', '2026-04-22 23:22:23'),
(7, 'BK055', 'Kisah Nabi untuk Anak', 'Siti Aisyah', 'Mizan', '2019', 14, 'Cerita nabi untuk anak-anak', 'books/aWFDvhbuDSJnHhDimebLDUWf6Tc0MVgKayEgdy18.jpg', '2026-04-22 23:52:12', '2026-04-23 02:12:59');

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-admin@perpustakaan.test|127.0.0.1', 'i:1;', 1776904063),
('laravel-cache-admin@perpustakaan.test|127.0.0.1:timer', 'i:1776904063;', 1776904063);

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `loans`
--

CREATE TABLE `loans` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `book_id` bigint UNSIGNED NOT NULL,
  `requested_at` date DEFAULT NULL,
  `borrowed_at` date NOT NULL,
  `due_at` date NOT NULL,
  `returned_requested_at` date DEFAULT NULL,
  `returned_at` date DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `approved_by` bigint UNSIGNED DEFAULT NULL,
  `return_verified_at` timestamp NULL DEFAULT NULL,
  `return_verified_by` bigint UNSIGNED DEFAULT NULL,
  `condition_status` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `condition_note` text COLLATE utf8mb4_unicode_ci,
  `late_fine` int UNSIGNED NOT NULL DEFAULT '0',
  `damage_fine` int UNSIGNED NOT NULL DEFAULT '0',
  `total_fine` int UNSIGNED NOT NULL DEFAULT '0',
  `fine_payment_status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'belum_bayar',
  `fine_payment_method` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fine_paid_at` timestamp NULL DEFAULT NULL,
  `approval_note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'dipinjam',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `loans`
--

INSERT INTO `loans` (`id`, `user_id`, `book_id`, `requested_at`, `borrowed_at`, `due_at`, `returned_requested_at`, `returned_at`, `approved_at`, `approved_by`, `return_verified_at`, `return_verified_by`, `condition_status`, `condition_note`, `late_fine`, `damage_fine`, `total_fine`, `fine_payment_status`, `fine_payment_method`, `fine_paid_at`, `approval_note`, `status`, `created_at`, `updated_at`) VALUES
(1, 3, 2, NULL, '2026-04-23', '2026-04-30', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 'belum_bayar', NULL, NULL, NULL, 'dipinjam', '2026-04-22 21:11:59', '2026-04-22 21:11:59'),
(2, 3, 3, NULL, '2026-04-23', '2026-04-30', NULL, '2026-04-23', NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 'belum_bayar', NULL, NULL, NULL, 'dikembalikan', '2026-04-22 21:30:09', '2026-04-23 02:12:25'),
(3, 3, 3, NULL, '2026-04-23', '2026-04-30', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 'belum_bayar', NULL, NULL, NULL, 'dipinjam', '2026-04-23 02:12:47', '2026-04-23 02:12:47'),
(4, 3, 7, NULL, '2026-04-23', '2026-04-30', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 'belum_bayar', NULL, NULL, NULL, 'dipinjam', '2026-04-23 02:12:59', '2026-04-23 02:12:59'),
(5, 3, 5, '2026-04-23', '2026-04-23', '2026-04-30', '2026-04-23', '2026-04-23', '2026-04-23 03:23:14', 1, '2026-04-23 03:23:47', 1, 'rusak_ringan', 'cover rusak', 0, 20000, 20000, 'lunas', 'qris', '2026-04-23 03:23:54', NULL, 'dikembalikan', '2026-04-23 03:23:04', '2026-04-23 03:23:54'),
(6, 3, 5, '2026-04-23', '2026-04-23', '2026-04-30', '2026-04-23', '2026-04-23', '2026-04-23 03:27:46', 1, '2026-04-23 03:28:31', 1, 'rusak_ringan', 'cover rusak', 0, 20000, 20000, 'belum_bayar', NULL, NULL, NULL, 'dikembalikan', '2026-04-23 03:27:36', '2026-04-23 03:28:31');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_04_23_070000_add_library_columns_to_users_table', 2),
(5, '2026_04_23_070100_create_books_table', 2),
(6, '2026_04_23_070200_create_loans_table', 2),
(7, '2026_04_23_083000_add_image_to_books_table', 3),
(8, '2026_04_23_162000_add_workflow_columns_to_loans_table', 4),
(9, '2026_04_23_231500_add_profile_identity_columns_to_users_table', 5);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('EkAHkfdvvIr9Dtl4G9e8bE1F81RFPjaEhCaUl8UI', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiI0QTBXNDViY0FYdGJZeVVVU0NFWWw0alVYTTJjaG5vNm93aWkxb2MwIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9hZG1pblwvZGFzaGJvYXJkIiwicm91dGUiOiJhZG1pbi5kYXNoYm9hcmQifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI6MX0=', 1776946160),
('F8wlqNfg3Qv6SSLMlp0Mf1ndjV7qJ4pxJAtDDaax', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiIxamtJdDVpYnRqZmpLcGtuTEFmeXBPYll2dEJ3bUNCSGJzQ1Y2NDlCIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL3Byb2ZpbGUiLCJyb3V0ZSI6InByb2ZpbGUuZWRpdCJ9LCJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI6MX0=', 1776948015),
('USzZAMLglDiqE2B7X1bNl6tmmjWafCrMVCsXfauQ', 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJiODlJVE9qMGRtRUFjMndTck1rd00wdXlOdUpIVGZmcFZwR3I3WmtnIiwidXJsIjpbXSwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9wcm9maWxlIiwicm91dGUiOiJwcm9maWxlLmVkaXQifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI6M30=', 1776948615);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'peminjam',
  `phone` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nip` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nis` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kelas` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `role`, `phone`, `address`, `nip`, `nis`, `kelas`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', NULL, 'admin@gmail.com', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, '$2y$12$8N3OAWEY6KZmpRyHYIvhEOHldifrDg.QmKDruPFb3lZ2REqDqiFoy', NULL, '2026-04-22 00:12:25', '2026-04-22 00:12:25'),
(2, 'billie', NULL, 'billie@gmail.com', 'peminjam', NULL, NULL, NULL, NULL, NULL, NULL, '$2y$12$im2G9UCBgnMszgkszgjXEuYvDqWZIdBSxvxPwpS1lfr5XEUI7vlT2', NULL, '2026-04-22 00:42:03', '2026-04-22 00:42:03'),
(3, 'peminjam', NULL, 'peminjam@gmail.com', 'peminjam', '081319420292', 'ciherang kidul', NULL, NULL, NULL, NULL, '$2y$12$KO/IZlKUBl3tjgBCEY55ae/kSUgZCt03Quptp6o3KNV1.kJ0UtZQS', NULL, '2026-04-22 17:20:47', '2026-04-22 17:20:47');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

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
-- Indeks untuk tabel `loans`
--
ALTER TABLE `loans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `loans_user_id_foreign` (`user_id`),
  ADD KEY `loans_book_id_foreign` (`book_id`),
  ADD KEY `loans_approved_by_foreign` (`approved_by`),
  ADD KEY `loans_return_verified_by_foreign` (`return_verified_by`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_nip_unique` (`nip`),
  ADD UNIQUE KEY `users_nis_unique` (`nis`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `books`
--
ALTER TABLE `books`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `loans`
--
ALTER TABLE `loans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `loans`
--
ALTER TABLE `loans`
  ADD CONSTRAINT `loans_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `loans_book_id_foreign` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `loans_return_verified_by_foreign` FOREIGN KEY (`return_verified_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `loans_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
