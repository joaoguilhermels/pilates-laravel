/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
DROP TABLE IF EXISTS `bank_accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bank_accounts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `bank` varchar(191) NOT NULL,
  `agency` varchar(191) NOT NULL,
  `account` varchar(191) NOT NULL,
  `balance` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `class_type_professional`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `class_type_professional` (
  `class_type_id` int(10) unsigned NOT NULL,
  `professional_id` int(10) unsigned NOT NULL,
  `value` double DEFAULT NULL,
  `value_type` varchar(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `class_type_professional_class_type_id_index` (`class_type_id`),
  KEY `class_type_professional_professional_id_index` (`professional_id`),
  CONSTRAINT `class_type_professional_class_type_id_foreign` FOREIGN KEY (`class_type_id`) REFERENCES `class_types` (`id`) ON DELETE CASCADE,
  CONSTRAINT `class_type_professional_professional_id_foreign` FOREIGN KEY (`professional_id`) REFERENCES `professionals` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `class_type_room`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `class_type_room` (
  `class_type_id` int(10) unsigned NOT NULL,
  `room_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `class_type_room_class_type_id_index` (`class_type_id`),
  KEY `class_type_room_room_id_index` (`room_id`),
  CONSTRAINT `class_type_room_class_type_id_foreign` FOREIGN KEY (`class_type_id`) REFERENCES `class_types` (`id`) ON DELETE CASCADE,
  CONSTRAINT `class_type_room_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `class_type_statuses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `class_type_statuses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `class_type_id` int(10) unsigned NOT NULL,
  `name` varchar(191) NOT NULL,
  `charge_client` tinyint(1) NOT NULL DEFAULT 0,
  `pay_professional` tinyint(1) NOT NULL DEFAULT 0,
  `color` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `class_type_statuses_class_type_id_index` (`class_type_id`),
  CONSTRAINT `class_type_statuses_class_type_id_foreign` FOREIGN KEY (`class_type_id`) REFERENCES `class_types` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `class_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `class_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `trial` tinyint(1) NOT NULL DEFAULT 0,
  `trial_class_price` double unsigned NOT NULL,
  `max_number_of_clients` smallint(5) unsigned NOT NULL,
  `duration` smallint(5) unsigned NOT NULL,
  `extra_class` tinyint(1) NOT NULL DEFAULT 0,
  `extra_class_price` double unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `client_plan_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `client_plan_details` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `client_plan_id` int(10) unsigned NOT NULL,
  `day_of_week` int(11) NOT NULL,
  `hour` time NOT NULL,
  `professional_id` int(10) unsigned NOT NULL,
  `room_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `client_plan_details_client_plan_id_index` (`client_plan_id`),
  KEY `client_plan_details_professional_id_index` (`professional_id`),
  KEY `client_plan_details_room_id_index` (`room_id`),
  CONSTRAINT `client_plan_details_client_plan_id_foreign` FOREIGN KEY (`client_plan_id`) REFERENCES `client_plans` (`id`),
  CONSTRAINT `client_plan_details_professional_id_foreign` FOREIGN KEY (`professional_id`) REFERENCES `professionals` (`id`),
  CONSTRAINT `client_plan_details_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `client_plans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `client_plans` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` int(10) unsigned NOT NULL,
  `plan_id` int(10) unsigned NOT NULL,
  `start_at` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `client_plans_client_id_index` (`client_id`),
  KEY `client_plans_plan_id_index` (`plan_id`),
  CONSTRAINT `client_plans_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`),
  CONSTRAINT `client_plans_plan_id_foreign` FOREIGN KEY (`plan_id`) REFERENCES `plans` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `clients` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `email` varchar(191) DEFAULT NULL,
  `phone` varchar(191) DEFAULT NULL,
  `observation` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `discountables`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `discountables` (
  `discount_id` int(11) NOT NULL,
  `discountable_type` varchar(191) NOT NULL,
  `discountable_id` bigint(20) unsigned NOT NULL,
  `value` double NOT NULL,
  `value_type` enum('percent','value') NOT NULL,
  `obs` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `discountables_discountable_type_discountable_id_index` (`discountable_type`,`discountable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `discounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `discounts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `value` double NOT NULL,
  `value_type` enum('percent','value') NOT NULL,
  `obs` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `expenses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `expenses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `date` date NOT NULL,
  `value` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `financial_transaction_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `financial_transaction_details` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `financial_transaction_id` int(10) unsigned NOT NULL,
  `payment_method_id` int(10) unsigned NOT NULL,
  `bank_account_id` int(10) unsigned DEFAULT NULL,
  `date` date NOT NULL,
  `value` double NOT NULL,
  `type` enum('received','paid') NOT NULL,
  `payment_number` int(10) unsigned NOT NULL DEFAULT 1,
  `observation` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `financial_transaction_details_financial_transaction_id_index` (`financial_transaction_id`),
  KEY `financial_transaction_details_payment_method_id_index` (`payment_method_id`),
  KEY `financial_transaction_details_bank_account_id_index` (`bank_account_id`),
  CONSTRAINT `financial_transaction_details_bank_account_id_foreign` FOREIGN KEY (`bank_account_id`) REFERENCES `bank_accounts` (`id`),
  CONSTRAINT `financial_transaction_details_financial_transaction_id_foreign` FOREIGN KEY (`financial_transaction_id`) REFERENCES `financial_transactions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `financial_transaction_details_payment_method_id_foreign` FOREIGN KEY (`payment_method_id`) REFERENCES `payment_methods` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `financial_transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `financial_transactions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `financiable_type` varchar(191) NOT NULL,
  `financiable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(191) NOT NULL,
  `total_number_of_payments` int(10) unsigned NOT NULL DEFAULT 1,
  `observation` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `financial_transactions_financiable_type_financiable_id_index` (`financiable_type`,`financiable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(191) NOT NULL,
  `notifiable_type` varchar(191) NOT NULL,
  `notifiable_id` bigint(20) unsigned NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_resets` (
  `email` varchar(191) NOT NULL,
  `token` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `payment_methods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payment_methods` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `plans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `plans` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `class_type_id` int(10) unsigned NOT NULL,
  `times` int(11) NOT NULL,
  `times_type` enum('week','month','class') NOT NULL DEFAULT 'week',
  `price` double NOT NULL,
  `price_type` enum('class','month','package') NOT NULL DEFAULT 'month',
  `duration` int(11) NOT NULL,
  `duration_type` enum('week','month','do-not-repeat') NOT NULL DEFAULT 'month',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `plans_class_type_id_index` (`class_type_id`),
  CONSTRAINT `plans_class_type_id_foreign` FOREIGN KEY (`class_type_id`) REFERENCES `class_types` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `professionals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `professionals` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `email` varchar(191) DEFAULT NULL,
  `phone` varchar(191) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `salary` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `rooms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rooms` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `schedules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `schedules` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned DEFAULT NULL,
  `client_id` int(10) unsigned NOT NULL,
  `scheduable_type` varchar(191) NOT NULL,
  `scheduable_id` bigint(20) unsigned NOT NULL,
  `trial` tinyint(1) NOT NULL DEFAULT 0,
  `room_id` int(10) unsigned NOT NULL,
  `class_type_id` int(10) unsigned NOT NULL,
  `professional_id` int(10) unsigned NOT NULL,
  `class_type_status_id` int(10) unsigned NOT NULL,
  `price` double NOT NULL,
  `value_professional_receives` double NOT NULL,
  `professional_payment_financial_transaction_id` int(10) unsigned DEFAULT NULL,
  `start_at` datetime NOT NULL,
  `end_at` datetime NOT NULL,
  `observation` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `schedules_scheduable_type_scheduable_id_index` (`scheduable_type`,`scheduable_id`),
  KEY `schedules_parent_id_index` (`parent_id`),
  KEY `schedules_client_id_index` (`client_id`),
  KEY `schedules_room_id_index` (`room_id`),
  KEY `schedules_class_type_id_index` (`class_type_id`),
  KEY `schedules_professional_id_index` (`professional_id`),
  KEY `schedules_class_type_status_id_index` (`class_type_status_id`),
  KEY `schedules_professional_payment_financial_transaction_id_index` (`professional_payment_financial_transaction_id`),
  CONSTRAINT `schedules_class_type_id_foreign` FOREIGN KEY (`class_type_id`) REFERENCES `class_types` (`id`),
  CONSTRAINT `schedules_class_type_status_id_foreign` FOREIGN KEY (`class_type_status_id`) REFERENCES `class_type_statuses` (`id`),
  CONSTRAINT `schedules_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`),
  CONSTRAINT `schedules_professional_id_foreign` FOREIGN KEY (`professional_id`) REFERENCES `professionals` (`id`),
  CONSTRAINT `schedules_professional_payment_financial_transaction_id_foreign` FOREIGN KEY (`professional_payment_financial_transaction_id`) REFERENCES `financial_transactions` (`id`) ON DELETE SET NULL,
  CONSTRAINT `schedules_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `password` varchar(60) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (1,'2014_10_12_000000_create_users_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (2,'2014_10_12_100000_create_password_resets_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (3,'2016_02_11_002539_create_clients_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (4,'2016_02_11_144718_create_professionals_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (5,'2016_02_12_014943_create_rooms_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (6,'2016_02_12_132157_create_class_types_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (7,'2016_02_13_134913_create_class_type_professional_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (8,'2016_02_15_020334_create_class_type_room_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (9,'2016_02_19_125942_create_class_type_statuses_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (10,'2016_02_28_170913_create_plans_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (11,'2016_02_29_125810_create_schedule_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (12,'2016_03_15_024906_create_client_plan_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (13,'2016_03_15_025009_create_client_plan_details_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (14,'2016_03_19_024400_create_expenses_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (15,'2016_04_01_140823_create_payment_methods_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (16,'2016_04_01_142459_create_bank_accounts_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (17,'2016_04_03_183244_create_financial_transactions_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (18,'2016_06_05_233626_create_financial_transaction_details_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (19,'2016_09_09_160128_add_professional_payment_financial_transaction_id_foreign_key_to_schedules_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (20,'2016_09_09_160807_add_financial_transaction_id_foreign_key_to_financial_transaction_details_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (21,'2016_09_09_160906_add_payment_method_id_foreign_key_to_financial_transaction_details_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (22,'2016_09_09_161005_add_bank_account_id_foreign_key_to_financial_transaction_details_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (23,'2016_10_15_151017_create_discounts_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (24,'2016_10_15_153607_create_discountables_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (25,'2016_10_30_193235_add_salary_column_on_professionals_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (26,'2017_01_08_190158_create_notifications_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (27,'2025_09_16_121129_add_email_verified_at_to_users_table',1);
