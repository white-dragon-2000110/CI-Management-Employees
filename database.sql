/*
 Navicat Premium Data Transfer

 Source Server         : MySQL_connection
 Source Server Type    : MySQL
 Source Server Version : 100427 (10.4.27-MariaDB)
 Source Host           : localhost:3306
 Source Schema         : employee_management

 Target Server Type    : MySQL
 Target Server Version : 100427 (10.4.27-MariaDB)
 File Encoding         : 65001

 Date: 22/08/2025 17:29:27
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for access_blocks
-- ----------------------------
DROP TABLE IF EXISTS `access_blocks`;
CREATE TABLE `access_blocks`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `employee_id` int NOT NULL,
  `reason` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `blocked_by` int NOT NULL,
  `blocked_until` datetime NULL DEFAULT NULL,
  `status` enum('active','expired','removed') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `employee_id`(`employee_id` ASC) USING BTREE,
  CONSTRAINT `access_blocks_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of access_blocks
-- ----------------------------
INSERT INTO `access_blocks` VALUES (1, 8, 'fasfqrqwefas', 10, NULL, 'removed', '2025-08-20 14:27:32');
INSERT INTO `access_blocks` VALUES (2, 8, 'afasfd', 10, NULL, 'removed', '2025-08-20 14:27:54');
INSERT INTO `access_blocks` VALUES (3, 8, 'asfasd', 10, '2025-08-30 01:44:00', 'active', '2025-08-20 14:42:23');

-- ----------------------------
-- Table structure for alarm_events
-- ----------------------------
DROP TABLE IF EXISTS `alarm_events`;
CREATE TABLE `alarm_events`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `event_type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `severity` enum('low','medium','high','critical') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `unit_id` int NOT NULL,
  `company_id` int NOT NULL,
  `status` enum('open','investigating','resolved','closed') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'open',
  `reported_by` int NULL DEFAULT NULL,
  `resolved_by` int NULL DEFAULT NULL,
  `resolved_at` datetime NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `unit_id`(`unit_id` ASC) USING BTREE,
  INDEX `company_id`(`company_id` ASC) USING BTREE,
  CONSTRAINT `alarm_events_ibfk_1` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `alarm_events_ibfk_2` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of alarm_events
-- ----------------------------
INSERT INTO `alarm_events` VALUES (1, 'system_failure', 'high', 'Database connection timeout', 1, 1, 'resolved', NULL, NULL, NULL, '2025-08-19 22:35:39');
INSERT INTO `alarm_events` VALUES (2, 'security_breach', 'critical', 'Unauthorized access attempt', 1, 1, 'resolved', NULL, NULL, NULL, '2025-08-19 22:35:39');
INSERT INTO `alarm_events` VALUES (3, 'maintenance', 'medium', 'Printer not responding', 2, 1, 'open', NULL, NULL, NULL, '2025-08-19 22:35:39');

-- ----------------------------
-- Table structure for companies
-- ----------------------------
DROP TABLE IF EXISTS `companies`;
CREATE TABLE `companies`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `code`(`code` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of companies
-- ----------------------------
INSERT INTO `companies` VALUES (1, 'Tech Solutions Inc.', 'TSI', 'active', '2025-08-19 22:35:39');
INSERT INTO `companies` VALUES (2, 'Global Industries', 'GI', 'active', '2025-08-19 22:35:39');
INSERT INTO `companies` VALUES (3, 'Innovation Corp', 'IC', 'active', '2025-08-19 22:35:39');
INSERT INTO `companies` VALUES (4, 'TechCorp Solutions', '', 'active', '2025-08-20 01:25:33');

-- ----------------------------
-- Table structure for employee_photos
-- ----------------------------
DROP TABLE IF EXISTS `employee_photos`;
CREATE TABLE `employee_photos`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `employee_id` int NOT NULL,
  `photo_path` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo_hash` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `capture_date` timestamp NOT NULL DEFAULT current_timestamp,
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT 'active',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `employee_id`(`employee_id` ASC) USING BTREE,
  CONSTRAINT `employee_photos_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of employee_photos
-- ----------------------------

-- ----------------------------
-- Table structure for employee_pins
-- ----------------------------
DROP TABLE IF EXISTS `employee_pins`;
CREATE TABLE `employee_pins`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `employee_id` int NOT NULL,
  `pin_4digit` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pin_6digit` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `employee_id`(`employee_id` ASC) USING BTREE,
  CONSTRAINT `employee_pins_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of employee_pins
-- ----------------------------

-- ----------------------------
-- Table structure for employees
-- ----------------------------
DROP TABLE IF EXISTS `employees`;
CREATE TABLE `employees`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `cpf` varchar(14) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `position` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `unit_id` int NOT NULL,
  `company_id` int NOT NULL,
  `access_level` enum('basic','intermediate','advanced','admin') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'basic',
  `status` enum('active','vacation','blocked','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'active',
  `pin_4digit` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `pin_6digit` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `photo_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `cpf`(`cpf` ASC) USING BTREE,
  UNIQUE INDEX `email`(`email` ASC) USING BTREE,
  INDEX `unit_id`(`unit_id` ASC) USING BTREE,
  INDEX `company_id`(`company_id` ASC) USING BTREE,
  CONSTRAINT `employees_ibfk_1` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `employees_ibfk_2` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of employees
-- ----------------------------
INSERT INTO `employees` VALUES (8, '123.123.123-12', '123', '123@gmail.com', '123123123', '123123', 3, 2, '', 'blocked', '$2y$10$u3KyPVVtCIPFZ.dzkaSdqeoli5jsoPqcaqRcc4Z8/DnVjhHraIrMi', '$2y$10$rl8HIwjRy0YmNZjyRd1tBO/4HRrXNvlJEQy3W/Zb0j1Hiwd2X64yK', NULL, '2025-08-20 13:57:32', '2025-08-20 14:42:23');
INSERT INTO `employees` VALUES (9, '131.231.231-21', 'qwer', 'qaaq@gmail.com', '13413', 'qr', 4, 3, '', 'active', '$2y$10$eFz4Zdc4F24K1UXq0FpAg.fG4zJvMpBaSqt63SM8X3Bgow4ePUJ26', '$2y$10$Jk8erxcdi9MU7H1Ac4qBTeP0Vu7it2JA4akE4Pkphse08apJjALha', NULL, '2025-08-20 14:43:01', '2025-08-20 14:43:01');
INSERT INTO `employees` VALUES (10, '234.234.234-23', '1234', '234@gmail.com', '234', '234', 4, 3, '', 'active', '$2y$10$KA1fo1pee2hS3FJuQX58Be5qHl..yMAHrRzyV3c5HMwk9Sh/DPz/i', '$2y$10$YslGqhe/lRRD03a3bKhacOOV/e6clQkzsa7A1fEuEKkf/OzcyO2q2', 'uploads/employee_photos/employee_10_1755823158.jpg', '2025-08-21 10:55:22', '2025-08-21 20:39:18');

-- ----------------------------
-- Table structure for login_sessions
-- ----------------------------
DROP TABLE IF EXISTS `login_sessions`;
CREATE TABLE `login_sessions`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `employee_id` int NOT NULL,
  `session_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `login_time` timestamp NOT NULL DEFAULT current_timestamp,
  `logout_time` timestamp NULL DEFAULT NULL,
  `status` enum('active','expired','logged_out') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT 'active',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `employee_id`(`employee_id` ASC) USING BTREE,
  CONSTRAINT `login_sessions_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of login_sessions
-- ----------------------------

-- ----------------------------
-- Table structure for support_tickets
-- ----------------------------
DROP TABLE IF EXISTS `support_tickets`;
CREATE TABLE `support_tickets`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `priority` enum('low','medium','high','urgent') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` enum('open','in_progress','resolved','closed') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'open',
  `unit_id` int NOT NULL,
  `company_id` int NOT NULL,
  `reported_by` int NULL DEFAULT NULL,
  `assigned_to` int NULL DEFAULT NULL,
  `resolved_at` datetime NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `unit_id`(`unit_id` ASC) USING BTREE,
  INDEX `company_id`(`company_id` ASC) USING BTREE,
  CONSTRAINT `support_tickets_ibfk_1` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `support_tickets_ibfk_2` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of support_tickets
-- ----------------------------
INSERT INTO `support_tickets` VALUES (1, 'Email System Access Issue', 'Users unable to access shared drives', 'high', 'in_progress', 1, 1, NULL, NULL, NULL, '2025-08-19 22:35:39', '2025-08-20 01:50:33');
INSERT INTO `support_tickets` VALUES (2, 'Printer Network Problem', 'Need to renew Office 365 licenses', 'medium', 'open', 2, 1, NULL, NULL, NULL, '2025-08-19 22:35:39', '2025-08-20 01:50:34');
INSERT INTO `support_tickets` VALUES (3, 'Software License Renewal', 'Request for new laptops for development team', 'low', 'open', 1, 1, NULL, NULL, NULL, '2025-08-19 22:35:39', '2025-08-20 01:50:34');

-- ----------------------------
-- Table structure for units
-- ----------------------------
DROP TABLE IF EXISTS `units`;
CREATE TABLE `units`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `company_id` int NOT NULL,
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `company_id`(`company_id` ASC) USING BTREE,
  CONSTRAINT `units_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of units
-- ----------------------------
INSERT INTO `units` VALUES (1, 'IT Department', 'IT', 1, 'active', '2025-08-19 22:35:39');
INSERT INTO `units` VALUES (2, 'HR Department', 'HR', 1, 'active', '2025-08-19 22:35:39');
INSERT INTO `units` VALUES (3, 'Operations', 'OPS', 2, 'active', '2025-08-19 22:35:39');
INSERT INTO `units` VALUES (4, 'Research & Development', 'RND', 3, 'active', '2025-08-19 22:35:39');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('user','admin') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `email`(`email` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'Admin User', 'admin@example.com', '$2y$10$wjM2FinraJwuvHDbcwxBi.pVU1aB.9.3kL3JyG4zwKHN7xvLz4hXC', 'admin', '2025-08-20 10:35:54', '2025-08-20 10:35:54');
INSERT INTO `users` VALUES (10, 'qaaq', 'qaaq@gmail.com', '$2y$10$caEV0TMVzmrx5Ds63mRADOMR/1ebt/tbF4n.WqJwuNaKoSYOeFb4y', 'user', '2025-08-20 20:11:56', '2025-08-20 11:11:56');

-- ----------------------------
-- Table structure for vacation_periods
-- ----------------------------
DROP TABLE IF EXISTS `vacation_periods`;
CREATE TABLE `vacation_periods`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `employee_id` int NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `reason` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `status` enum('pending','approved','rejected') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'pending',
  `approved_by` int NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `employee_id`(`employee_id` ASC) USING BTREE,
  CONSTRAINT `vacation_periods_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of vacation_periods
-- ----------------------------
INSERT INTO `vacation_periods` VALUES (1, 8, '2025-08-21', '2025-08-29', 'd', 'pending', NULL, '2025-08-20 14:41:26');
INSERT INTO `vacation_periods` VALUES (2, 8, '2025-08-21', '2025-08-30', 'wer', 'pending', NULL, '2025-08-20 14:41:59');

SET FOREIGN_KEY_CHECKS = 1;
