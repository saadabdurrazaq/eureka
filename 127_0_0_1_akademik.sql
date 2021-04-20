--
-- Database: `refologperole`
--
CREATE DATABASE IF NOT EXISTS `refologperole` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `refologperole`;

-- --------------------------------------------------------

--
-- Table structure for table `applicants`
--
DROP TABLE IF EXISTS `applicants`;
CREATE TABLE `applicants` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` enum('Male','Female') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verified` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('ACTIVE','INACTIVE') COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `applicants`
--

INSERT INTO `applicants` (`id`, `name`, `username`, `gender`, `email`, `email_verified_at`, `phone`, `password`, `remember_token`, `verified`, `created_at`, `created_by`, `updated_at`, `deleted_at`, `avatar`, `status`) VALUES
(131, 'Herbalvora', 'herbalvora', NULL, 'herbalvorastore@gmail.com', NULL, '097253729912', '$2y$10$VKHR3vyaVkAHQ6cpcTfKC.H2L.E9M2U4CCkxqhfcwtAKvjfp81pA.', NULL, 0, '2020-05-15 05:05:37', NULL, '2020-05-15 05:05:37', NULL, NULL, 'ACTIVE');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_07_20_034721_create_permission_tables', 1),
(4, '2019_07_20_034826_create_products_table', 1),
(5, '2020_05_11_085406_create_social_google_accounts_table', 2),
(6, '2020_05_11_115055_create_verify_users_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` int(10) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(2, 'App\\User', 4),
(1, 'App\\User', 3),
(2, 'App\\User', 8),
(1, 'App\\User', 18),
(1, 'App\\User', 19),
(1, 'App\\User', 20),
(1, 'App\\User', 21),
(1, 'App\\User', 22),
(1, 'App\\User', 23),
(1, 'App\\User', 24),
(1, 'App\\User', 25),
(1, 'App\\User', 26),
(1, 'App\\User', 27),
(1, 'App\\User', 28),
(1, 'App\\User', 29),
(1, 'App\\User', 30),
(1, 'App\\User', 31),
(1, 'App\\User', 32),
(1, 'App\\User', 33),
(1, 'App\\User', 34),
(1, 'App\\User', 35),
(1, 'App\\User', 36),
(1, 'App\\User', 37),
(1, 'App\\User', 38),
(1, 'App\\User', 39),
(1, 'App\\User', 40),
(1, 'App\\User', 41),
(1, 'App\\User', 42),
(1, 'App\\User', 43),
(1, 'App\\User', 44),
(1, 'App\\User', 45),
(1, 'App\\User', 46),
(1, 'App\\User', 47),
(1, 'App\\User', 48),
(1, 'App\\User', 49),
(1, 'App\\User', 50),
(1, 'App\\User', 51),
(1, 'App\\User', 52),
(1, 'App\\User', 53),
(1, 'App\\User', 54),
(1, 'App\\User', 55),
(1, 'App\\User', 56),
(1, 'App\\User', 57),
(1, 'App\\User', 58),
(1, 'App\\User', 59),
(1, 'App\\User', 60),
(1, 'App\\User', 61),
(1, 'App\\User', 62),
(1, 'App\\User', 63),
(1, 'App\\User', 64),
(1, 'App\\User', 65),
(1, 'App\\User', 66),
(1, 'App\\User', 67),
(1, 'App\\User', 68),
(1, 'App\\User', 69),
(1, 'App\\User', 70),
(1, 'App\\User', 71),
(1, 'App\\User', 72),
(1, 'App\\User', 73),
(1, 'App\\User', 74),
(1, 'App\\User', 75),
(1, 'App\\User', 76),
(1, 'App\\User', 77),
(1, 'App\\User', 78),
(1, 'App\\User', 79),
(1, 'App\\User', 80),
(1, 'App\\User', 81),
(1, 'App\\User', 82),
(1, 'App\\User', 83),
(1, 'App\\User', 84),
(1, 'App\\User', 85),
(1, 'App\\User', 86),
(1, 'App\\User', 87),
(1, 'App\\User', 88),
(1, 'App\\User', 89),
(1, 'App\\User', 90),
(1, 'App\\User', 91),
(1, 'App\\User', 92),
(1, 'App\\User', 93),
(1, 'App\\User', 94),
(2, 'App\\User', 96),
(2, 'App\\User', 97),
(2, 'App\\User', 98),
(2, 'App\\User', 99),
(2, 'App\\User', 100),
(2, 'App\\User', 101),
(2, 'App\\User', 102),
(2, 'App\\User', 103),
(2, 'App\\User', 104),
(2, 'App\\User', 105),
(1, 'App\\User', 111),
(1, 'App\\User', 112),
(1, 'App\\User', 113),
(1, 'App\\User', 114),
(1, 'App\\User', 116),
(1, 'App\\User', 1),
(2, 'App\\User', 95),
(3, 'App\\User', 117),
(3, 'App\\User', 118),
(3, 'App\\User', 119),
(3, 'App\\User', 120);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('herbalvorastore@gmail.com', '$2y$10$Je6BkJCh892AAfNWryLp.uJE0dbLK.yACu4sifBRkbZ3C6bj1bJum', '2020-05-12 05:12:41'),
('seadclark@gmail.com', '$2y$10$GurrI9l6utcRMwEh05X8euKwG0sa9uAUz.Q6g0J2SEtfNZalIs9/a', '2020-05-14 14:41:51');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'View Roles', 'web', '2020-04-15 21:33:57', '2020-04-15 21:33:57'),
(2, 'Create Roles', 'web', '2020-04-15 21:33:57', '2020-04-15 21:33:57'),
(3, 'Edit Roles', 'web', '2020-04-15 21:33:57', '2020-04-15 21:33:57'),
(4, 'Delete Roles', 'web', '2020-04-15 21:33:57', '2020-04-15 21:33:57'),
(5, 'View Users', 'web', '2020-04-15 21:33:57', '2020-04-15 21:33:57'),
(6, 'Create Users', 'web', '2020-04-15 21:33:57', '2020-04-15 21:33:57'),
(7, 'Edit User', 'web', '2020-04-15 21:33:57', '2020-04-15 21:33:57'),
(8, 'Show User', 'web', '2020-04-15 21:33:57', '2020-04-15 21:33:57'),
(9, 'Trash Users', 'web', '2020-04-15 21:33:57', '2020-04-15 21:33:57'),
(10, 'Restore Users', 'web', '2020-04-15 21:33:57', '2020-04-15 21:33:57'),
(11, 'Delete Users', 'web', '2020-04-15 21:33:57', '2020-04-15 21:33:57'),
(12, 'Activate Users', 'web', '2020-04-15 21:33:57', '2020-04-15 21:33:57'),
(13, 'Deactivate Users', 'web', '2020-04-15 21:33:57', '2020-04-15 21:33:57');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'web', '2020-04-15 21:34:10', '2020-04-15 21:34:10'),
(2, 'Super Admin', 'web', '2020-04-15 21:37:14', '2020-05-10 12:32:09'),
(3, 'General User', 'web', '2020-05-14 05:40:11', '2020-05-14 05:40:11');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 2),
(2, 2),
(3, 2),
(4, 2),
(5, 2),
(6, 2),
(7, 2),
(8, 2),
(9, 2),
(10, 2),
(11, 2),
(12, 2),
(13, 2),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(5, 3);

-- --------------------------------------------------------

--
-- Table structure for table `social_facebook_accounts`
--

CREATE TABLE `social_facebook_accounts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `provider_user_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `provider` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `social_facebook_accounts`
--

INSERT INTO `social_facebook_accounts` (`id`, `user_id`, `provider_user_id`, `provider`, `created_at`, `updated_at`) VALUES
(14, 105, '10213179667204636', 'facebook', '2020-05-13 07:30:55', '2020-05-13 07:30:55');

-- --------------------------------------------------------

--
-- Table structure for table `social_google_accounts`
--

CREATE TABLE `social_google_accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `provider_user_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `provider` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` enum('Male','Female') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verified` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('ACTIVE','INACTIVE') COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `gender`, `email`, `email_verified_at`, `phone`, `password`, `remember_token`, `verified`, `created_at`, `created_by`, `updated_at`, `deleted_at`, `avatar`, `status`) VALUES
(1, 'Hardik Savani', 'hardik', 'Male', 'admin@gmail.com', NULL, '081574289012', '$2y$10$0xuL2omfShrYy/YdoNUbs.xsvkK/nNNi3NrhHbBkclQGRbI4QtOFK', NULL, 0, '2020-04-15 21:34:10', '0', '2020-05-14 02:33:01', NULL, NULL, 'ACTIVE'),
(3, 'Comfoodtable Official', 'comfoodtable', 'Male', 'comfoodtableofficial@gmail.com', NULL, '085217418065', '$2y$10$O.UEOajkhvzEvdGyGETSJOIasCpalAdWgSPiQH6pe6ajqb8OKGQAi', NULL, 0, '2020-04-16 01:14:05', '0', '2020-04-16 01:14:05', NULL, NULL, 'ACTIVE'),
(8, 'Fatria Hidayat', 'fatriahidayat', 'Male', 'fatratourofficial@gmail.com', NULL, '081931895364', '$2y$10$sulUH9Hu.Jm00p5UnHe2h.Deb7bWTL46VujcRiBbiWsoFeM4m8gXa', NULL, 0, '2020-05-11 02:04:53', '0', '2020-05-11 02:04:53', NULL, NULL, 'ACTIVE'),
(105, 'Saad Abdurrazaq', 'saadabdurrazaq', 'Male', 'seadclark@gmail.com', '2020-05-12 09:43:59', '085624853448', '$2y$10$YZtuMs3dkGc9Eb5CAlKSpuuDM.O3m1SSFt63uhWG/WJfFJfDFsqIC', NULL, 0, '2020-05-12 09:42:11', '0', '2020-05-14 05:37:20', NULL, NULL, 'ACTIVE'),
(114, 'John Doe', 'johndoe', 'Male', 'john@doe.com', NULL, '085624853449', '$2y$10$mukJA9TtqRaJPFHo2N6S6u1O9M0F9tUsupqMdtur./OatWAZmC0FG', NULL, 0, '2020-05-13 23:06:23', NULL, '2020-05-13 23:07:09', NULL, NULL, 'ACTIVE'),
(116, 'Kelly Clare', 'kellyclare', 'Male', 'kelly@clare.com', NULL, '087854218743', '$2y$10$pt/NjTXZEi1CiTTY1919s.plEZbqMFroys2rjRJD0KmY8dY9monuC', NULL, 0, '2020-05-14 03:27:36', NULL, '2020-05-14 03:27:36', NULL, NULL, 'ACTIVE');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applicants`
--
ALTER TABLE `applicants`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD KEY `model_has_permissions_permission_id_foreign` (`permission_id`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD KEY `model_has_roles_role_id_foreign` (`role_id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD KEY `role_has_permissions_permission_id_foreign` (`permission_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `social_facebook_accounts`
--
ALTER TABLE `social_facebook_accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `social_google_accounts`
--
ALTER TABLE `social_google_accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `applicants`
--
ALTER TABLE `applicants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `social_facebook_accounts`
--
ALTER TABLE `social_facebook_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `social_google_accounts`
--
ALTER TABLE `social_google_accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
