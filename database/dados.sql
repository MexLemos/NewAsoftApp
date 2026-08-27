-- --------------------------------------------------------
-- Anfitrião:                    127.0.0.1
-- Versão do servidor:           8.0.30 - MySQL Community Server - GPL
-- SO do servidor:               Win64
-- HeidiSQL Versão:              12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- A despejar estrutura para tabela asoftmedia_app.categories
CREATE TABLE IF NOT EXISTS `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- A despejar dados para tabela asoftmedia_app.categories: ~0 rows (aproximadamente)
INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `created_at`, `updated_at`) VALUES
	(1, 'Desenvolvimento', 'desenvolvimento', NULL, '2026-06-05 14:36:46', '2026-06-05 14:36:46');

-- A despejar estrutura para tabela asoftmedia_app.certificates
CREATE TABLE IF NOT EXISTS `certificates` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `course_id` bigint unsigned NOT NULL,
  `certificate_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pdf_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `certificates_certificate_code_unique` (`certificate_code`),
  KEY `certificates_user_id_foreign` (`user_id`),
  KEY `certificates_course_id_foreign` (`course_id`),
  CONSTRAINT `certificates_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  CONSTRAINT `certificates_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- A despejar dados para tabela asoftmedia_app.certificates: ~0 rows (aproximadamente)

-- A despejar estrutura para tabela asoftmedia_app.courses
CREATE TABLE IF NOT EXISTS `courses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `thumbnail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `is_free` tinyint(1) NOT NULL DEFAULT '0',
  `level` enum('basic','intermediate','advanced') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'basic',
  `is_published` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `courses_slug_unique` (`slug`),
  KEY `courses_category_id_foreign` (`category_id`),
  CONSTRAINT `courses_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- A despejar dados para tabela asoftmedia_app.courses: ~3 rows (aproximadamente)
INSERT INTO `courses` (`id`, `category_id`, `title`, `slug`, `description`, `thumbnail`, `price`, `is_free`, `level`, `is_published`, `created_at`, `updated_at`) VALUES
	(1, 1, 'PHP Laravel', 'php-laravel-1780674130', 'Aprenda a construir aplicações web modernas com PHP e Laravel 13', 'courses/L4BQD4ruASBeoNrOrWuVQegB6yIk1S5t0XA6HJAR.png', 50000.00, 0, 'basic', 1, '2026-06-05 14:42:10', '2026-06-05 14:42:10'),
	(2, 1, 'Excel Avançado para Negócios', 'excel-avancado-para-negocios-1780674241', 'Aprenda tabelas dinâmicas, macros e dashboard em excel + IA', 'courses/ZWbVQ4UkigD5fMWWvFprn9Az20uscbK7N9cm2QAK.jpg', 50000.00, 0, 'advanced', 1, '2026-06-05 14:44:01', '2026-06-05 14:44:01'),
	(3, 1, 'OPNSense', 'opnsense-1780674312', 'Segurança de dados, VPN e firewall', 'courses/paXDaBYaTQVtbcA5g2DEtfLMLif85JkifLXQVmaa.png', 450000.00, 0, 'intermediate', 1, '2026-06-05 14:45:12', '2026-06-05 14:45:12'),
	(4, 1, 'GitHub Desktop', 'github-desktop-1780695770', 'Aprenda a versionar e Controlar seus repositórios', 'courses/tWbWqI86jHQa3FQc0IQL1hSudTxmENjbr5hzPtwo.png', 0.00, 1, 'basic', 1, '2026-06-05 20:42:51', '2026-06-05 20:42:51');

-- A despejar estrutura para tabela asoftmedia_app.enrollments
CREATE TABLE IF NOT EXISTS `enrollments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `course_id` bigint unsigned NOT NULL,
  `status` enum('pending','active','suspended') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `progress_percent` int NOT NULL DEFAULT '0',
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `enrollments_user_id_foreign` (`user_id`),
  KEY `enrollments_course_id_foreign` (`course_id`),
  CONSTRAINT `enrollments_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  CONSTRAINT `enrollments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- A despejar dados para tabela asoftmedia_app.enrollments: ~0 rows (aproximadamente)
INSERT INTO `enrollments` (`id`, `user_id`, `course_id`, `status`, `progress_percent`, `completed_at`, `created_at`, `updated_at`) VALUES
	(1, 8, 4, 'active', 0, NULL, '2026-06-05 22:15:41', '2026-06-05 22:15:41');

-- A despejar estrutura para tabela asoftmedia_app.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- A despejar dados para tabela asoftmedia_app.failed_jobs: ~0 rows (aproximadamente)

-- A despejar estrutura para tabela asoftmedia_app.leads
CREATE TABLE IF NOT EXISTS `leads` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci,
  `status` enum('new','contacted','qualified','lost') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'new',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- A despejar dados para tabela asoftmedia_app.leads: ~0 rows (aproximadamente)
INSERT INTO `leads` (`id`, `name`, `email`, `phone`, `message`, `status`, `created_at`, `updated_at`) VALUES
	(1, 'Magalhães Lemos', 'mexlemos@gmail.com', '928052022', '--- NOVO PEDIDO DE COMPRA ---\nCliente: Magalhães Lemos (NIF: N/A)\nMorada: Luanda - Talatona - Sapú2\nForma de Pagamento: Transferência Bancária\n\nITENS:\n- 1x Monitores Led (Kz 50.000,00)\n\nRESUMO:\nSubtotal: Kz 50.000,00\nTaxa Entrega: Kz 3.000,00\nTOTAL: Kz 53.000,00\n\nCOMPROVATIVO:\n/storage/comprovativos/dicdmvqjexamnJxVfW7i8PdxiZAaTSrKWQVLCfwz.pdf\n', 'new', '2026-06-05 22:06:59', '2026-06-05 22:06:59');

-- A despejar estrutura para tabela asoftmedia_app.lessons
CREATE TABLE IF NOT EXISTS `lessons` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `module_id` bigint unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `video_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attachment_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_index` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `lessons_module_id_foreign` (`module_id`),
  CONSTRAINT `lessons_module_id_foreign` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- A despejar dados para tabela asoftmedia_app.lessons: ~0 rows (aproximadamente)

-- A despejar estrutura para tabela asoftmedia_app.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- A despejar dados para tabela asoftmedia_app.migrations: ~23 rows (aproximadamente)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
	(3, '2019_08_19_000000_create_failed_jobs_table', 1),
	(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(5, '2026_06_04_220435_create_categories_table', 1),
	(6, '2026_06_04_220436_create_courses_table', 1),
	(7, '2026_06_04_220437_create_modules_table', 1),
	(8, '2026_06_04_220438_create_lessons_table', 1),
	(9, '2026_06_04_220439_create_certificates_table', 1),
	(10, '2026_06_04_220439_create_quizzes_table', 1),
	(11, '2026_06_04_220441_create_enrollments_table', 1),
	(12, '2026_06_04_220441_create_product_categories_table', 1),
	(13, '2026_06_04_220442_create_products_table', 1),
	(14, '2026_06_04_220443_create_orders_table', 1),
	(15, '2026_06_04_220444_create_order_items_table', 1),
	(16, '2026_06_04_220445_create_leads_table', 1),
	(17, '2026_06_04_220445_create_partners_table', 1),
	(18, '2026_06_04_220446_create_services_table', 1),
	(19, '2026_06_04_220447_create_posts_table', 1),
	(20, '2026_06_04_220904_create_permission_tables', 1),
	(22, '2026_06_05_150026_create_settings_table', 2),
	(23, '2026_06_05_170021_add_is_featured_to_products_and_services', 3),
	(24, '2026_06_05_204209_add_status_to_enrollments_table', 4),
	(25, '2026_06_05_212833_add_is_free_to_courses_table', 5),
	(26, '2026_06_05_224105_add_is_active_to_users_table', 6);

-- A despejar estrutura para tabela asoftmedia_app.model_has_permissions
CREATE TABLE IF NOT EXISTS `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- A despejar dados para tabela asoftmedia_app.model_has_permissions: ~0 rows (aproximadamente)

-- A despejar estrutura para tabela asoftmedia_app.model_has_roles
CREATE TABLE IF NOT EXISTS `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- A despejar dados para tabela asoftmedia_app.model_has_roles: ~6 rows (aproximadamente)
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
	(1, 'App\\Models\\User', 1),
	(5, 'App\\Models\\User', 3),
	(1, 'App\\Models\\User', 4),
	(6, 'App\\Models\\User', 5),
	(6, 'App\\Models\\User', 6),
	(6, 'App\\Models\\User', 7),
	(1, 'App\\Models\\User', 8);

-- A despejar estrutura para tabela asoftmedia_app.modules
CREATE TABLE IF NOT EXISTS `modules` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `course_id` bigint unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_index` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `modules_course_id_foreign` (`course_id`),
  CONSTRAINT `modules_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- A despejar dados para tabela asoftmedia_app.modules: ~0 rows (aproximadamente)

-- A despejar estrutura para tabela asoftmedia_app.orders
CREATE TABLE IF NOT EXISTS `orders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `customer_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` enum('pending','processing','completed','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `orders_user_id_foreign` (`user_id`),
  CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- A despejar dados para tabela asoftmedia_app.orders: ~0 rows (aproximadamente)

-- A despejar estrutura para tabela asoftmedia_app.order_items
CREATE TABLE IF NOT EXISTS `order_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned DEFAULT NULL,
  `product_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_items_order_id_foreign` (`order_id`),
  KEY `order_items_product_id_foreign` (`product_id`),
  CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- A despejar dados para tabela asoftmedia_app.order_items: ~0 rows (aproximadamente)

-- A despejar estrutura para tabela asoftmedia_app.partners
CREATE TABLE IF NOT EXISTS `partners` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_index` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- A despejar dados para tabela asoftmedia_app.partners: ~6 rows (aproximadamente)
INSERT INTO `partners` (`id`, `name`, `logo_url`, `website_url`, `order_index`, `created_at`, `updated_at`) VALUES
	(1, 'Cegid', 'partners/ubnuBcL2pVYiXJi48roTShKf9Kx7B36fFEOF5gZ3.png', 'https://www.cegid.com/ao/', 0, '2026-06-05 21:08:35', '2026-06-05 21:08:35'),
	(4, 'KIWA', 'partners/cTOLuakcYlhTWcrbCPOXzu7UqcXmetlHPNvpwFUu.png', 'https://www.kiwa.com/', 0, '2026-06-05 21:11:01', '2026-06-05 21:11:01'),
	(5, 'JNM Global', 'partners/vDy4ZVi626UGAOIqKXb4S1R5Q1ydbwTCsMSvHyY9.png', 'http://jnmglobal.net/', 0, '2026-06-05 21:13:30', '2026-06-05 21:13:30'),
	(6, 'Envia Express', 'partners/UVD9zkTr6asIYjLUDRUvxLvLWPMdIT4rbCFILjaq.png', 'https://www.enviaexpress.ao/', 0, '2026-06-05 21:14:39', '2026-06-05 21:14:39'),
	(7, 'InWinteck', 'partners/kMXyEN07AClzkpj45JBm4DoIUZL4hMH5ojvehzeb.png', 'https://www.inwinteck.com/', 0, '2026-06-05 21:16:01', '2026-06-05 21:16:01'),
	(8, 'UniSaúde', 'partners/J4NyBJlUyLeDhln9zX5D3uKwo5xZk7bdqEfkUyTa.png', 'https://www.unisaude.co.ao/', 0, '2026-06-05 21:21:28', '2026-06-05 21:21:28');

-- A despejar estrutura para tabela asoftmedia_app.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- A despejar dados para tabela asoftmedia_app.password_reset_tokens: ~0 rows (aproximadamente)

-- A despejar estrutura para tabela asoftmedia_app.permissions
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- A despejar dados para tabela asoftmedia_app.permissions: ~0 rows (aproximadamente)

-- A despejar estrutura para tabela asoftmedia_app.personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- A despejar dados para tabela asoftmedia_app.personal_access_tokens: ~0 rows (aproximadamente)

-- A despejar estrutura para tabela asoftmedia_app.posts
CREATE TABLE IF NOT EXISTS `posts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `author_id` bigint unsigned DEFAULT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `posts_slug_unique` (`slug`),
  KEY `posts_author_id_foreign` (`author_id`),
  CONSTRAINT `posts_author_id_foreign` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- A despejar dados para tabela asoftmedia_app.posts: ~0 rows (aproximadamente)

-- A despejar estrutura para tabela asoftmedia_app.products
CREATE TABLE IF NOT EXISTS `products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_category_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `price` decimal(10,2) NOT NULL,
  `stock` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `products_slug_unique` (`slug`),
  KEY `products_product_category_id_foreign` (`product_category_id`),
  CONSTRAINT `products_product_category_id_foreign` FOREIGN KEY (`product_category_id`) REFERENCES `product_categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- A despejar dados para tabela asoftmedia_app.products: ~3 rows (aproximadamente)
INSERT INTO `products` (`id`, `product_category_id`, `name`, `slug`, `description`, `image`, `is_featured`, `price`, `stock`, `created_at`, `updated_at`) VALUES
	(2, 1, 'Monitores Led', 'monitores-led-1780678059', 'Monitor Dell 32\'', 'produtos/pmrGzuQ6Ll1L4Z5X9vnYMV3JlEA4GCZr6IhFJ4M0.jpg', 1, 50000.00, 0, '2026-06-05 15:47:39', '2026-06-05 16:08:10'),
	(3, 1, 'Switch Layer 3', 'switch-layer-3-1780679651', 'Switch de 24 Portas - Camada 3', 'produtos/TIMcJZ1IzLcJf1z4wTegvLBPKp2TFsRpQjShHCFW.jpg', 1, 200000.00, 0, '2026-06-05 16:14:11', '2026-06-05 16:14:11'),
	(4, 1, 'PC Portátil', 'pc-portatil-1780679804', 'Portátil Dell -  Processador i5 12ªGn', 'produtos/Hxewlw58I731OJ8KefmFNxC4dl1p4kHPyrdZ4xKI.jpg', 1, 250000.00, 0, '2026-06-05 16:16:44', '2026-06-05 16:16:44');

-- A despejar estrutura para tabela asoftmedia_app.product_categories
CREATE TABLE IF NOT EXISTS `product_categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_categories_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- A despejar dados para tabela asoftmedia_app.product_categories: ~0 rows (aproximadamente)
INSERT INTO `product_categories` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
	(1, 'Geral', 'geral', '2026-06-05 15:20:50', '2026-06-05 15:20:50');

-- A despejar estrutura para tabela asoftmedia_app.quizzes
CREATE TABLE IF NOT EXISTS `quizzes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `lesson_id` bigint unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `questions_json` text COLLATE utf8mb4_unicode_ci,
  `passing_score` int NOT NULL DEFAULT '70',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `quizzes_lesson_id_foreign` (`lesson_id`),
  CONSTRAINT `quizzes_lesson_id_foreign` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- A despejar dados para tabela asoftmedia_app.quizzes: ~0 rows (aproximadamente)

-- A despejar estrutura para tabela asoftmedia_app.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- A despejar dados para tabela asoftmedia_app.roles: ~5 rows (aproximadamente)
INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
	(1, 'admin', 'web', '2026-06-04 21:24:53', '2026-06-04 21:24:53'),
	(2, 'instrutor', 'web', '2026-06-04 21:24:53', '2026-06-04 21:24:53'),
	(3, 'aluno', 'web', '2026-06-04 21:24:53', '2026-06-04 21:24:53'),
	(4, 'cliente', 'web', '2026-06-04 21:24:53', '2026-06-04 21:24:53'),
	(5, 'formador', 'web', '2026-06-05 21:36:21', '2026-06-05 21:36:21'),
	(6, 'tech', 'web', '2026-06-05 21:40:50', '2026-06-05 21:40:50');

-- A despejar estrutura para tabela asoftmedia_app.role_has_permissions
CREATE TABLE IF NOT EXISTS `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- A despejar dados para tabela asoftmedia_app.role_has_permissions: ~0 rows (aproximadamente)

-- A despejar estrutura para tabela asoftmedia_app.services
CREATE TABLE IF NOT EXISTS `services` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `services_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- A despejar dados para tabela asoftmedia_app.services: ~3 rows (aproximadamente)
INSERT INTO `services` (`id`, `title`, `slug`, `description`, `icon`, `is_featured`, `created_at`, `updated_at`) VALUES
	(1, '2Funges', '2funges-1780678486', 'Gestão Inteligente da Cesta básica', 'produtos/hCk0Heb2FJ8nfj5kgFqJaEIYrpMrqEmOTRW46M6t.png', 1, '2026-06-05 15:54:46', '2026-06-05 16:09:33'),
	(2, 'Licenças Office 365', 'licencas-office-365-1780679481', 'Licença Definitiva do pacote Office 365', 'produtos/tzCLwY3k2PoSM5Mxu2naNYljuGye3BaLFO7Migct.png', 1, '2026-06-05 16:11:21', '2026-06-05 16:11:21'),
	(3, 'Licenças Windows 11 Pro', 'licencas-windows-11-pro-1780679559', 'Licenças para o SO Windows 11 Pro', 'produtos/nxr3MySbBWLTNRNr28sUB7YpOBljjX8tIOVytV0T.jpg', 1, '2026-06-05 16:12:39', '2026-06-05 16:12:39');

-- A despejar estrutura para tabela asoftmedia_app.settings
CREATE TABLE IF NOT EXISTS `settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_key_unique` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- A despejar dados para tabela asoftmedia_app.settings: ~0 rows (aproximadamente)

-- A despejar estrutura para tabela asoftmedia_app.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- A despejar dados para tabela asoftmedia_app.users: ~8 rows (aproximadamente)
INSERT INTO `users` (`id`, `name`, `email`, `is_active`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'Admin User', 'admin@asoftmedia.com', 1, '2026-06-04 21:24:53', '$2y$10$b9xCRd4ny1HAqy/UWB7E5..K4JsYQ7g9rs/tP4YIq1Km0y1QxYBGG', 'TRYFi8fSEJPJo2iExoRa6DmWtAIOX8cJ5EWDIQ6VUiq2qEkvpSSUK7FdA8aG', '2026-06-04 21:24:53', '2026-06-04 21:24:53'),
	(2, 'Magalhães Lemos', 'mexlemos@gmail.com', 1, NULL, '$2y$10$nPCy/58G.Q6LM.1akvi1A.QeKrJJ2LCaIyM5e5NXkiffEXO/1Ible', NULL, '2026-06-04 21:49:04', '2026-06-04 21:49:04'),
	(3, 'André Lendo', 'andrelendo@asoftmedia-ao.com', 1, NULL, '$2y$10$Pem7RjkKYVHb0lOTDF34COReXoqaLAyyGbENsRzA9Om2N5udqVXZS', NULL, '2026-06-05 21:36:20', '2026-06-05 21:36:20'),
	(4, 'Laurindo Pinheiro', 'laurindo.pinheiro@asoftmedia-ao.com', 1, NULL, '$2y$10$pgpcr7hiGYAxRC1xIWQ3J.I2LudeDrliKwxN5rp84sTWqAbg24J2G', NULL, '2026-06-05 21:39:07', '2026-06-05 21:39:07'),
	(5, 'Arminda dos Santos', 'arminda.santos@asoftmediaao.com', 1, NULL, '$2y$10$pcAb0eyjAzv0T.xcEwsguOoK8XI7MUOE0OQtYtSXcOIw1dkZ9Xwym', NULL, '2026-06-05 21:40:50', '2026-06-05 21:40:50'),
	(6, 'Nelson dos Santos', 'nelson.santos@asoftmedia-ao.com', 1, NULL, '$2y$10$qEaX3HEAaVdPtXM6/Dnk0uH/w87dibVzKj25boKt/qvUrK6kuVYkO', NULL, '2026-06-05 21:41:57', '2026-06-05 21:41:57'),
	(7, 'Kelven de Lemos', 'kelven.lemos@asoftmedia-ao.com', 1, NULL, '$2y$10$TojHOOKD/U.LRdhQvuDw8.XZW0e4qdDUKid2g9T431QqtLuasnqJS', NULL, '2026-06-05 21:43:11', '2026-06-05 21:43:11'),
	(8, 'Mex Lemos', 'mexteste@gmail.com', 1, NULL, '$2y$10$zk0h9OfzpeZ1oU6/5pA9U.kZwZXmU.aTFI.KR11srOzht.HYBSvXW', NULL, '2026-06-05 21:43:55', '2026-06-05 21:44:41');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
