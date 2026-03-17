/*
 Navicat Premium Data Transfer

 Source Server         : LOCALHOST BIYU
 Source Server Type    : MySQL
 Source Server Version : 100424 (10.4.24-MariaDB)
 Source Host           : 127.0.0.1:3306
 Source Schema         : mealplan_db

 Target Server Type    : MySQL
 Target Server Version : 100424 (10.4.24-MariaDB)
 File Encoding         : 65001

 Date: 11/03/2026 16:40:54
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for bahan_resep
-- ----------------------------
DROP TABLE IF EXISTS `bahan_resep`;
CREATE TABLE `bahan_resep`  (
  `id_bahan` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_resep` int NOT NULL,
  `nama_bahan` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `jumlah` decimal(10, 2) NOT NULL DEFAULT 1.00,
  `satuan` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'buah',
  `harga_satuan` decimal(12, 2) NULL DEFAULT 0.00,
  `urutan` int NULL DEFAULT 0,
  PRIMARY KEY (`id_bahan`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 138 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of bahan_resep
-- ----------------------------
INSERT INTO `bahan_resep` VALUES (1, 4, 'Ayam', 250.00, 'gram', 15000.00, 1);
INSERT INTO `bahan_resep` VALUES (2, 4, 'Kecap Manis', 3.00, 'sdm', 1000.00, 2);
INSERT INTO `bahan_resep` VALUES (3, 4, 'Bawang Merah', 5.00, 'butir', 1000.00, 3);
INSERT INTO `bahan_resep` VALUES (4, 4, 'Bawang Putih', 3.00, 'siung', 500.00, 4);
INSERT INTO `bahan_resep` VALUES (5, 4, 'Cabai Merah', 3.00, 'buah', 1500.00, 5);
INSERT INTO `bahan_resep` VALUES (6, 4, 'Minyak Goreng', 2.00, 'sdm', 500.00, 6);
INSERT INTO `bahan_resep` VALUES (7, 4, 'Garam', 1.00, 'sdt', 200.00, 7);
INSERT INTO `bahan_resep` VALUES (8, 4, 'Gula', 1.00, 'sdt', 300.00, 8);
INSERT INTO `bahan_resep` VALUES (9, 1, 'Nasi', 2.00, 'porsi', 3000.00, 1);
INSERT INTO `bahan_resep` VALUES (10, 1, 'Telur', 2.00, 'butir', 2500.00, 2);
INSERT INTO `bahan_resep` VALUES (11, 1, 'Bawang Merah', 3.00, 'butir', 600.00, 3);
INSERT INTO `bahan_resep` VALUES (12, 1, 'Bawang Putih', 2.00, 'siung', 300.00, 4);
INSERT INTO `bahan_resep` VALUES (13, 1, 'Kecap Manis', 2.00, 'sdm', 700.00, 5);
INSERT INTO `bahan_resep` VALUES (14, 1, 'Minyak Goreng', 2.00, 'sdm', 500.00, 6);
INSERT INTO `bahan_resep` VALUES (15, 1, 'Garam', 1.00, 'sdt', 200.00, 7);
INSERT INTO `bahan_resep` VALUES (16, 11, 'Telur', 3.00, 'butir', 2500.00, 1);
INSERT INTO `bahan_resep` VALUES (17, 11, 'Daun Bawang', 1.00, 'batang', 500.00, 2);
INSERT INTO `bahan_resep` VALUES (18, 11, 'Garam', 1.00, 'sdt', 200.00, 3);
INSERT INTO `bahan_resep` VALUES (19, 11, 'Minyak Goreng', 2.00, 'sdm', 500.00, 4);
INSERT INTO `bahan_resep` VALUES (20, 20, 'Bayam', 2.00, 'ikat', 2000.00, 1);
INSERT INTO `bahan_resep` VALUES (21, 20, 'Jagung Manis', 1.00, 'buah', 1500.00, 2);
INSERT INTO `bahan_resep` VALUES (22, 20, 'Bawang Merah', 3.00, 'butir', 600.00, 3);
INSERT INTO `bahan_resep` VALUES (23, 20, 'Garam', 1.00, 'sdt', 200.00, 4);
INSERT INTO `bahan_resep` VALUES (24, 16, 'Tempe', 1.00, 'papan', 3000.00, 1);
INSERT INTO `bahan_resep` VALUES (25, 16, 'Kecap Manis', 2.00, 'sdm', 700.00, 2);
INSERT INTO `bahan_resep` VALUES (26, 16, 'Cabai Merah', 3.00, 'buah', 1500.00, 3);
INSERT INTO `bahan_resep` VALUES (27, 16, 'Bawang Merah', 3.00, 'butir', 600.00, 4);
INSERT INTO `bahan_resep` VALUES (28, 16, 'Minyak Goreng', 3.00, 'sdm', 750.00, 5);
INSERT INTO `bahan_resep` VALUES (53, 33, 'Beras', 1.00, 'centong', 5000.00, 1);
INSERT INTO `bahan_resep` VALUES (54, 33, 'lada hitam ', 3.00, 'sendok makan', 1000.00, 2);
INSERT INTO `bahan_resep` VALUES (55, 33, 'Bawang Putih', 1.00, 'biji', 0.00, 3);
INSERT INTO `bahan_resep` VALUES (56, 33, 'Bawang Merah ', 2.00, 'biji', 0.00, 4);
INSERT INTO `bahan_resep` VALUES (57, 33, 'Penyedap', 1.00, 'sendok kecil', 0.00, 5);
INSERT INTO `bahan_resep` VALUES (58, 34, 'Ayam', 0.50, 'kg', 20000.00, 1);
INSERT INTO `bahan_resep` VALUES (59, 34, 'cabe ijo', 0.00, '', 5000.00, 2);
INSERT INTO `bahan_resep` VALUES (60, 34, 'bawang', 1.00, '', 3000.00, 3);
INSERT INTO `bahan_resep` VALUES (61, 34, 'penyedap', 1.00, '', 2000.00, 4);
INSERT INTO `bahan_resep` VALUES (62, 35, 'Ayam', 1.00, '', 15000.00, 1);
INSERT INTO `bahan_resep` VALUES (63, 35, 'Kentang', 1.00, '', 5000.00, 2);
INSERT INTO `bahan_resep` VALUES (64, 35, 'bawang putih', 1.00, '', 2000.00, 3);
INSERT INTO `bahan_resep` VALUES (65, 35, 'penyedap', 1.00, '', 2000.00, 4);
INSERT INTO `bahan_resep` VALUES (66, 35, 'jahe', 1.00, '', 1000.00, 5);
INSERT INTO `bahan_resep` VALUES (74, 37, 'Brokoli', 1.00, '', 4000.00, 1);
INSERT INTO `bahan_resep` VALUES (75, 37, 'wortel', 1.00, '', 4000.00, 2);
INSERT INTO `bahan_resep` VALUES (76, 37, 'bawang', 1.00, '', 1000.00, 3);
INSERT INTO `bahan_resep` VALUES (77, 37, 'penyedap', 1.00, '', 1000.00, 4);
INSERT INTO `bahan_resep` VALUES (78, 38, 'Nasi', 2.00, 'porsi', 3000.00, 1);
INSERT INTO `bahan_resep` VALUES (79, 38, 'Telur', 2.00, 'butir', 2500.00, 2);
INSERT INTO `bahan_resep` VALUES (80, 38, 'Bawang Merah', 3.00, 'butir', 600.00, 3);
INSERT INTO `bahan_resep` VALUES (81, 38, 'Bawang Putih', 2.00, 'siung', 300.00, 4);
INSERT INTO `bahan_resep` VALUES (82, 38, 'Kecap Manis', 2.00, 'sdm', 700.00, 5);
INSERT INTO `bahan_resep` VALUES (83, 38, 'Minyak Goreng', 2.00, 'sdm', 500.00, 6);
INSERT INTO `bahan_resep` VALUES (84, 38, 'Garam', 1.00, 'sdt', 200.00, 7);
INSERT INTO `bahan_resep` VALUES (91, 39, 'Beras', 1.50, 'canteng', 4000.00, 1);
INSERT INTO `bahan_resep` VALUES (92, 39, 'bumbu nasi uduk sajiku', 1.00, '', 3000.00, 2);
INSERT INTO `bahan_resep` VALUES (93, 39, 'bilis', 0.50, 'ons', 6000.00, 3);
INSERT INTO `bahan_resep` VALUES (94, 39, 'cabe merah', 1.00, '', 3000.00, 4);
INSERT INTO `bahan_resep` VALUES (95, 39, 'bawang merah', 3.00, 'biji', 1000.00, 5);
INSERT INTO `bahan_resep` VALUES (96, 39, 'bawang putih', 2.00, 'biji', 1000.00, 6);
INSERT INTO `bahan_resep` VALUES (97, 31, 'tepung serba guna', 2.00, 'bungkus', 5000.00, 1);
INSERT INTO `bahan_resep` VALUES (98, 31, 'micin', 1.00, 'sendok kecil', 0.00, 2);
INSERT INTO `bahan_resep` VALUES (99, 31, 'Ayam', 0.50, 'Kg', 25000.00, 3);
INSERT INTO `bahan_resep` VALUES (100, 32, 'Ayam', 250.00, 'gram', 15000.00, 1);
INSERT INTO `bahan_resep` VALUES (101, 32, 'Kecap Manis', 3.00, 'sdm', 1000.00, 2);
INSERT INTO `bahan_resep` VALUES (102, 32, 'Bawang Merah', 5.00, 'butir', 1000.00, 3);
INSERT INTO `bahan_resep` VALUES (103, 32, 'Bawang Putih', 3.00, 'siung', 500.00, 4);
INSERT INTO `bahan_resep` VALUES (104, 32, 'Cabai Merah', 3.00, 'buah', 1500.00, 5);
INSERT INTO `bahan_resep` VALUES (105, 32, 'Minyak Goreng', 2.00, 'sdm', 500.00, 6);
INSERT INTO `bahan_resep` VALUES (106, 32, 'Garam', 1.00, 'sdt', 200.00, 7);
INSERT INTO `bahan_resep` VALUES (107, 32, 'Tomat ', 1.00, 'biji', 1000.00, 8);
INSERT INTO `bahan_resep` VALUES (108, 46, 'Telur', 3.00, 'butir', 2500.00, 1);
INSERT INTO `bahan_resep` VALUES (109, 46, 'Daun Bawang', 1.00, 'batang', 500.00, 2);
INSERT INTO `bahan_resep` VALUES (110, 46, 'Garam', 1.00, 'sdt', 200.00, 3);
INSERT INTO `bahan_resep` VALUES (111, 46, 'Minyak Goreng', 2.00, 'sdm', 500.00, 4);
INSERT INTO `bahan_resep` VALUES (112, 54, 'Tempe', 1.00, 'papan', 3000.00, 1);
INSERT INTO `bahan_resep` VALUES (113, 54, 'Kecap Manis', 2.00, 'sdm', 700.00, 2);
INSERT INTO `bahan_resep` VALUES (114, 54, 'Cabai Merah', 3.00, 'buah', 1500.00, 3);
INSERT INTO `bahan_resep` VALUES (115, 54, 'Bawang Merah', 3.00, 'butir', 600.00, 4);
INSERT INTO `bahan_resep` VALUES (116, 54, 'Minyak Goreng', 3.00, 'sdm', 750.00, 5);
INSERT INTO `bahan_resep` VALUES (117, 56, 'Bayam', 2.00, 'ikat', 2000.00, 1);
INSERT INTO `bahan_resep` VALUES (118, 56, 'Jagung Manis', 1.00, 'buah', 1500.00, 2);
INSERT INTO `bahan_resep` VALUES (119, 56, 'Bawang Merah', 3.00, 'butir', 600.00, 3);
INSERT INTO `bahan_resep` VALUES (120, 56, 'Garam', 1.00, 'sdt', 200.00, 4);
INSERT INTO `bahan_resep` VALUES (121, 36, 'Ikan Tongkol', 1.00, 'ekor besar', 20000.00, 1);
INSERT INTO `bahan_resep` VALUES (122, 36, 'Cabe Merah', 1.00, 'ons', 5000.00, 2);
INSERT INTO `bahan_resep` VALUES (123, 36, 'daun kemangi atau jeruk', 1.00, '', 1000.00, 3);
INSERT INTO `bahan_resep` VALUES (124, 36, 'tomat', 1.00, 'biji', 1000.00, 4);
INSERT INTO `bahan_resep` VALUES (125, 36, 'penyedap', 1.00, '', 1000.00, 5);
INSERT INTO `bahan_resep` VALUES (126, 36, 'bawang merah', 5.00, 'biji', 2000.00, 6);
INSERT INTO `bahan_resep` VALUES (127, 36, 'bawang putih', 2.00, 'biji', 3000.00, 7);
INSERT INTO `bahan_resep` VALUES (128, 66, 'bilis', 0.50, 'ons', 6000.00, 1);
INSERT INTO `bahan_resep` VALUES (129, 66, 'terong', 1.00, 'biji', 2000.00, 2);
INSERT INTO `bahan_resep` VALUES (130, 66, 'cabe merah', 1.00, 'ons', 5000.00, 3);
INSERT INTO `bahan_resep` VALUES (131, 66, 'bawang merah', 3.00, 'biji', 1000.00, 4);
INSERT INTO `bahan_resep` VALUES (132, 66, 'bawang putih', 2.00, 'biji', 1000.00, 5);
INSERT INTO `bahan_resep` VALUES (133, 66, 'penyedap', 1.00, '', 1000.00, 6);
INSERT INTO `bahan_resep` VALUES (134, 67, 'Bihun', 1.00, '', 2000.00, 1);
INSERT INTO `bahan_resep` VALUES (135, 67, 'Gambas / Brokoli', 1.00, '', 4000.00, 2);
INSERT INTO `bahan_resep` VALUES (136, 67, 'bawang merah, putih', 1.00, '', 2000.00, 3);
INSERT INTO `bahan_resep` VALUES (137, 67, 'penyedap', 1.00, '', 0.00, 4);

-- ----------------------------
-- Table structure for budget_minggu
-- ----------------------------
DROP TABLE IF EXISTS `budget_minggu`;
CREATE TABLE `budget_minggu`  (
  `id_budget` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_user` int NOT NULL,
  `minggu_ke` int NOT NULL,
  `tahun` int NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `budget_amount` decimal(12, 2) NOT NULL DEFAULT 300000.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp,
  PRIMARY KEY (`id_budget`) USING BTREE,
  UNIQUE INDEX `id_user`(`id_user` ASC, `minggu_ke` ASC, `tahun` ASC) USING BTREE,
  INDEX `idx_budget_user`(`id_user` ASC, `tahun` ASC, `minggu_ke` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of budget_minggu
-- ----------------------------
INSERT INTO `budget_minggu` VALUES (2, 1, 11, 2026, '2026-03-09', '2026-03-15', 300000.00, '2026-03-09 08:37:38');
INSERT INTO `budget_minggu` VALUES (3, 2, 11, 2026, '2026-03-09', '2026-03-15', 300000.00, '2026-03-11 16:27:29');

-- ----------------------------
-- Table structure for daftar_belanja
-- ----------------------------
DROP TABLE IF EXISTS `daftar_belanja`;
CREATE TABLE `daftar_belanja`  (
  `id_belanja` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_user` int NOT NULL,
  `id_budget` int NULL DEFAULT NULL,
  `nama_item` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `jumlah` decimal(10, 2) NULL DEFAULT 1.00,
  `satuan` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'buah',
  `estimasi_harga` decimal(12, 2) NULL DEFAULT 0.00,
  `is_checked` tinyint(1) NULL DEFAULT 0,
  `kategori_item` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp,
  PRIMARY KEY (`id_belanja`) USING BTREE,
  INDEX `idx_belanja_user`(`id_user` ASC, `id_budget` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 32 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of daftar_belanja
-- ----------------------------

-- ----------------------------
-- Table structure for jadwal_menu
-- ----------------------------
DROP TABLE IF EXISTS `jadwal_menu`;
CREATE TABLE `jadwal_menu`  (
  `id_jadwal` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_user` int NOT NULL,
  `tanggal` date NOT NULL,
  `waktu_makan` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `id_resep` int NULL DEFAULT NULL,
  `nama_custom` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `catatan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp,
  PRIMARY KEY (`id_jadwal`) USING BTREE,
  INDEX `idx_jadwal_user_tgl`(`id_user` ASC, `tanggal` ASC) USING BTREE,
  INDEX `idx_jadwal_slot`(`id_user` ASC, `tanggal` ASC, `waktu_makan` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 51 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of jadwal_menu
-- ----------------------------
INSERT INTO `jadwal_menu` VALUES (1, 1, '2026-03-02', 'pagi', 3, NULL, NULL, '2026-03-06 15:24:05');
INSERT INTO `jadwal_menu` VALUES (2, 1, '2026-03-02', 'siang', 16, NULL, NULL, '2026-03-06 15:24:05');
INSERT INTO `jadwal_menu` VALUES (3, 1, '2026-03-02', 'malam', 9, NULL, NULL, '2026-03-06 15:24:05');
INSERT INTO `jadwal_menu` VALUES (4, 1, '2026-03-03', 'pagi', 2, NULL, NULL, '2026-03-06 15:24:05');
INSERT INTO `jadwal_menu` VALUES (5, 1, '2026-03-03', 'siang', 2, NULL, NULL, '2026-03-06 15:24:05');
INSERT INTO `jadwal_menu` VALUES (6, 1, '2026-03-03', 'malam', 11, NULL, NULL, '2026-03-06 15:24:05');
INSERT INTO `jadwal_menu` VALUES (7, 1, '2026-03-04', 'pagi', 1, NULL, NULL, '2026-03-06 15:24:05');
INSERT INTO `jadwal_menu` VALUES (8, 1, '2026-03-04', 'siang', 29, NULL, NULL, '2026-03-06 15:24:05');
INSERT INTO `jadwal_menu` VALUES (9, 1, '2026-03-04', 'malam', 26, NULL, NULL, '2026-03-06 15:24:05');
INSERT INTO `jadwal_menu` VALUES (10, 1, '2026-03-05', 'pagi', 8, NULL, NULL, '2026-03-06 15:24:05');
INSERT INTO `jadwal_menu` VALUES (11, 1, '2026-03-05', 'siang', 28, NULL, NULL, '2026-03-06 15:24:05');
INSERT INTO `jadwal_menu` VALUES (12, 1, '2026-03-05', 'malam', 2, NULL, NULL, '2026-03-06 15:24:05');
INSERT INTO `jadwal_menu` VALUES (13, 1, '2026-03-06', 'pagi', 1, NULL, NULL, '2026-03-06 15:24:05');
INSERT INTO `jadwal_menu` VALUES (14, 1, '2026-03-06', 'siang', 2, NULL, NULL, '2026-03-06 15:24:05');
INSERT INTO `jadwal_menu` VALUES (15, 1, '2026-03-06', 'malam', 5, NULL, NULL, '2026-03-06 15:24:05');
INSERT INTO `jadwal_menu` VALUES (16, 1, '2026-03-07', 'pagi', 13, NULL, NULL, '2026-03-06 15:24:05');
INSERT INTO `jadwal_menu` VALUES (17, 1, '2026-03-07', 'siang', 13, NULL, NULL, '2026-03-06 15:24:05');
INSERT INTO `jadwal_menu` VALUES (18, 1, '2026-03-07', 'malam', 12, NULL, NULL, '2026-03-06 15:24:05');
INSERT INTO `jadwal_menu` VALUES (19, 1, '2026-03-08', 'pagi', 16, NULL, NULL, '2026-03-06 15:24:05');
INSERT INTO `jadwal_menu` VALUES (20, 1, '2026-03-08', 'siang', 1, NULL, NULL, '2026-03-06 15:24:05');
INSERT INTO `jadwal_menu` VALUES (21, 1, '2026-03-08', 'malam', 10, NULL, NULL, '2026-03-06 15:24:05');
INSERT INTO `jadwal_menu` VALUES (45, 1, '2026-03-11', 'malam', 67, NULL, NULL, '2026-03-11 09:16:07');
INSERT INTO `jadwal_menu` VALUES (50, 1, '2026-03-11', 'malam', 66, NULL, NULL, '2026-03-11 09:27:24');

-- ----------------------------
-- Table structure for kategori_menu
-- ----------------------------
DROP TABLE IF EXISTS `kategori_menu`;
CREATE TABLE `kategori_menu`  (
  `id_kategori` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `icon` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '?️',
  `urutan` int NULL DEFAULT 0,
  PRIMARY KEY (`id_kategori`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of kategori_menu
-- ----------------------------
INSERT INTO `kategori_menu` VALUES (1, 'Nasi & Karbohidrat', '🍚', 1);
INSERT INTO `kategori_menu` VALUES (2, 'Lauk Ayam', '🍗', 2);
INSERT INTO `kategori_menu` VALUES (3, 'Lauk Ikan', '🐟', 3);
INSERT INTO `kategori_menu` VALUES (4, 'Lauk Telur', '🥚', 4);
INSERT INTO `kategori_menu` VALUES (5, 'Lauk Daging', '🥩', 5);
INSERT INTO `kategori_menu` VALUES (6, 'Tahu & Tempe', '🫘', 6);
INSERT INTO `kategori_menu` VALUES (7, 'Sayur', '🥬', 7);
INSERT INTO `kategori_menu` VALUES (8, 'Sop & Kuah', '🍲', 8);
INSERT INTO `kategori_menu` VALUES (9, 'Gorengan', '🍳', 9);
INSERT INTO `kategori_menu` VALUES (10, 'Mie & Pasta', '🍝', 10);

-- ----------------------------
-- Table structure for master_harga
-- ----------------------------
DROP TABLE IF EXISTS `master_harga`;
CREATE TABLE `master_harga`  (
  `id_harga` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_user` int NULL DEFAULT NULL,
  `nama_bahan` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `harga_satuan` decimal(12, 2) NOT NULL DEFAULT 0.00,
  `satuan` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'buah',
  `kategori_bahan` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `catatan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp,
  PRIMARY KEY (`id_harga`) USING BTREE,
  INDEX `idx_master_harga_user`(`id_user` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 23 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of master_harga
-- ----------------------------
INSERT INTO `master_harga` VALUES (1, 1, 'Ayam', 15000.00, 'gram (250g)', 'protein', NULL, '2026-03-06 15:51:55', '2026-03-06 15:51:55');
INSERT INTO `master_harga` VALUES (2, 1, 'Ikan', 15000.00, 'gram (250g)', 'protein', NULL, '2026-03-06 15:51:55', '2026-03-06 15:51:55');
INSERT INTO `master_harga` VALUES (3, 1, 'Telur', 2500.00, 'butir', 'protein', NULL, '2026-03-06 15:51:55', '2026-03-06 15:51:55');
INSERT INTO `master_harga` VALUES (4, 1, 'Daging Sapi', 30000.00, 'gram (250g)', 'protein', NULL, '2026-03-06 15:51:55', '2026-03-06 15:51:55');
INSERT INTO `master_harga` VALUES (5, 1, 'Tempe', 3000.00, 'papan', 'protein', NULL, '2026-03-06 15:51:55', '2026-03-06 15:51:55');
INSERT INTO `master_harga` VALUES (6, 1, 'Tahu', 2500.00, 'buah', 'protein', NULL, '2026-03-06 15:51:55', '2026-03-06 15:51:55');
INSERT INTO `master_harga` VALUES (7, 1, 'Bayam', 2000.00, 'ikat', 'sayur', NULL, '2026-03-06 15:51:55', '2026-03-06 15:51:55');
INSERT INTO `master_harga` VALUES (8, 1, 'Kangkung', 2000.00, 'ikat', 'sayur', NULL, '2026-03-06 15:51:55', '2026-03-06 15:51:55');
INSERT INTO `master_harga` VALUES (9, 1, 'Kol', 5000.00, 'buah', 'sayur', NULL, '2026-03-06 15:51:55', '2026-03-06 15:51:55');
INSERT INTO `master_harga` VALUES (10, 1, 'Jagung Manis', 1500.00, 'buah', 'sayur', NULL, '2026-03-06 15:51:55', '2026-03-06 15:51:55');
INSERT INTO `master_harga` VALUES (11, 1, 'Bawang Merah', 1000.00, 'butir', 'bumbu', NULL, '2026-03-06 15:51:55', '2026-03-06 15:51:55');
INSERT INTO `master_harga` VALUES (12, 1, 'Bawang Putih', 1000.00, 'siung', 'bumbu', '', '2026-03-06 09:52:49', '2026-03-06 15:51:55');
INSERT INTO `master_harga` VALUES (13, 1, 'Cabai Merah', 1500.00, 'buah', 'bumbu', NULL, '2026-03-06 15:51:55', '2026-03-06 15:51:55');
INSERT INTO `master_harga` VALUES (14, 1, 'Garam', 200.00, 'sdt', 'bumbu', NULL, '2026-03-06 15:51:55', '2026-03-06 15:51:55');
INSERT INTO `master_harga` VALUES (15, 1, 'Gula', 300.00, 'sdt', 'bumbu', NULL, '2026-03-06 15:51:55', '2026-03-06 15:51:55');
INSERT INTO `master_harga` VALUES (16, 1, 'Kecap Manis', 700.00, 'sdm', 'bumbu', NULL, '2026-03-06 15:51:55', '2026-03-06 15:51:55');
INSERT INTO `master_harga` VALUES (17, 1, 'Beras', 83000.00, '5 kg', 'bahan_pokok', '', '2026-03-09 04:54:46', '2026-03-06 15:51:55');
INSERT INTO `master_harga` VALUES (19, 1, 'Mie Instan', 3500.00, 'bungkus', 'bahan_pokok', NULL, '2026-03-06 15:51:55', '2026-03-06 15:51:55');
INSERT INTO `master_harga` VALUES (20, 1, 'Minyak Goreng', 500.00, 'sdm', 'minyak', NULL, '2026-03-06 15:51:55', '2026-03-06 15:51:55');
INSERT INTO `master_harga` VALUES (21, 1, 'Daun Bawang', 500.00, 'batang', 'bumbu', NULL, '2026-03-06 15:51:55', '2026-03-06 15:51:55');

-- ----------------------------
-- Table structure for menu_favorit
-- ----------------------------
DROP TABLE IF EXISTS `menu_favorit`;
CREATE TABLE `menu_favorit`  (
  `id_favorit` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_user` int NOT NULL,
  `id_resep` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp,
  PRIMARY KEY (`id_favorit`) USING BTREE,
  UNIQUE INDEX `id_user`(`id_user` ASC, `id_resep` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of menu_favorit
-- ----------------------------

-- ----------------------------
-- Table structure for pemasukan
-- ----------------------------
DROP TABLE IF EXISTS `pemasukan`;
CREATE TABLE `pemasukan`  (
  `id_pemasukan` int NOT NULL AUTO_INCREMENT,
  `id_user` int NOT NULL,
  `bulan` int NOT NULL,
  `tahun` int NOT NULL,
  `sumber` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'cth: Gaji, Bonus, Freelance, dll',
  `jumlah` decimal(15, 2) NOT NULL DEFAULT 0.00,
  `catatan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `tanggal` date NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp,
  PRIMARY KEY (`id_pemasukan`) USING BTREE,
  INDEX `idx_pemasukan_user`(`id_user` ASC, `tahun` ASC, `bulan` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of pemasukan
-- ----------------------------
INSERT INTO `pemasukan` VALUES (1, 1, 3, 2026, 'Sisa Gaji', 1000000.00, '', '2026-03-11', '2026-03-11 13:50:26');
INSERT INTO `pemasukan` VALUES (2, 1, 3, 2026, 'THR', 3800000.00, '', '2026-03-11', '2026-03-11 13:52:29');

-- ----------------------------
-- Table structure for pengeluaran
-- ----------------------------
DROP TABLE IF EXISTS `pengeluaran`;
CREATE TABLE `pengeluaran`  (
  `id_pengeluaran` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_user` int NOT NULL,
  `id_budget` int NULL DEFAULT NULL,
  `nama_barang` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `harga` decimal(12, 2) NOT NULL,
  `kategori` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tanggal` date NOT NULL DEFAULT curdate,
  `catatan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp,
  PRIMARY KEY (`id_pengeluaran`) USING BTREE,
  INDEX `idx_pengeluaran_user`(`id_user` ASC, `tanggal` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of pengeluaran
-- ----------------------------
INSERT INTO `pengeluaran` VALUES (3, 1, 2, 'AYAM', 18000.00, 'lauk', '2026-03-09', '', '2026-03-11 09:01:22');
INSERT INTO `pengeluaran` VALUES (4, 1, 2, 'bawang, bumbu, sayur,dll', 14000.00, 'sayur', '2026-03-09', '', '2026-03-11 09:01:51');
INSERT INTO `pengeluaran` VALUES (5, 1, 2, 'tempe, brokoli', 10000.00, 'lauk', '2026-03-10', '', '2026-03-11 09:02:41');
INSERT INTO `pengeluaran` VALUES (6, 1, 2, 'bawang, Ubi', 15000.00, 'bahan_pokok', '2026-03-10', '', '2026-03-11 09:03:02');
INSERT INTO `pengeluaran` VALUES (7, 1, 2, 'Takjil', 12000.00, 'snack', '2026-03-10', '', '2026-03-11 09:03:21');
INSERT INTO `pengeluaran` VALUES (8, 1, 2, 'takjil', 12000.00, 'snack', '2026-03-09', '', '2026-03-11 09:03:32');

-- ----------------------------
-- Table structure for pengeluaran_lain
-- ----------------------------
DROP TABLE IF EXISTS `pengeluaran_lain`;
CREATE TABLE `pengeluaran_lain`  (
  `id_pengeluaran_lain` int NOT NULL AUTO_INCREMENT,
  `id_user` int NOT NULL,
  `nama` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'cth: Listrik, BPJS, Beli Kulkas',
  `jumlah` decimal(15, 2) NOT NULL DEFAULT 0.00,
  `kategori` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT 'lainnya' COMMENT 'tagihan, asuransi, peralatan, transportasi, pendidikan, hiburan, lainnya',
  `tanggal` date NOT NULL,
  `catatan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `is_rutin` tinyint(1) NULL DEFAULT 0 COMMENT '1=rutin tiap bulan, 0=sekali',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp,
  PRIMARY KEY (`id_pengeluaran_lain`) USING BTREE,
  INDEX `idx_pl_user`(`id_user` ASC, `tanggal` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of pengeluaran_lain
-- ----------------------------
INSERT INTO `pengeluaran_lain` VALUES (1, 1, 'WiFi/Internet', 216000.00, 'tagihan', '2026-03-11', '', 0, '2026-03-11 14:17:09');

-- ----------------------------
-- Table structure for resep
-- ----------------------------
DROP TABLE IF EXISTS `resep`;
CREATE TABLE `resep`  (
  `id_resep` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_kategori` int NULL DEFAULT NULL,
  `id_user` int NULL DEFAULT NULL,
  `nama_resep` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `porsi` int NULL DEFAULT 2,
  `estimasi_harga` decimal(12, 2) NULL DEFAULT 0.00,
  `waktu_masak` int NULL DEFAULT 30,
  `is_favorit` tinyint(1) NULL DEFAULT 0,
  `is_meal_prep` tinyint(1) NULL DEFAULT 0,
  `foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `catatan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp,
  PRIMARY KEY (`id_resep`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 68 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of resep
-- ----------------------------
INSERT INTO `resep` VALUES (31, 2, 1, 'Ayam Goreng Tepung', 5, 30000.00, 30, 0, 0, 'uploads/resep/f21a95e587258fcefc6c06a27cec832f.jpg', '', '2026-03-09 09:30:10');
INSERT INTO `resep` VALUES (32, 2, 1, 'Ayam Kecap', 5, 30000.00, 30, 0, 0, 'uploads/resep/e570c8724b361980cf27052a33786466.jpg', '', '2026-03-09 09:32:20');
INSERT INTO `resep` VALUES (33, 1, 1, 'Bubur Lada Hitam', 3, 6000.00, 25, 0, 0, 'uploads/resep/8dd6043f6309b075a5bb0679ee630db6.jpg', 'haluskan lada hitam, kemudian tumis bawang putih dan bawang merah hingga wangi, setelah itu dicampur ke beras yang sudah dibuat menjadi bubur, lalu diaduk rata dan tambahkan penyedap. Bubur siap disajikan', '2026-03-09 09:35:06');
INSERT INTO `resep` VALUES (34, 2, 1, 'Ayam Sambel Ijo', 5, 30000.00, 30, 0, 0, 'uploads/resep/e5141118934add5844d6766be45112d0.jpg', '', '2026-03-11 09:05:59');
INSERT INTO `resep` VALUES (35, 8, 1, 'Sup Ayam Hainan', 4, 25000.00, 30, 0, 0, 'uploads/resep/2a49f7df19ab58e5ad86e3cfc3dd981a.jpg', '', '2026-03-11 09:08:26');
INSERT INTO `resep` VALUES (36, 3, 1, 'Ikan Tongkol Suir Sambal Kemangi / Jeruk', 4, 20000.00, 30, 0, 0, 'uploads/resep/2b9527d76383e660ca3ada7e092584c9.jpg', '', '2026-03-11 09:11:18');
INSERT INTO `resep` VALUES (37, 7, 1, 'Tumis Browol (Brokoli + Wortel)', 4, 10000.00, 30, 0, 1, 'uploads/resep/f3e79f997fd7da46a809bc795bd4f947.jpg', '', '2026-03-11 09:13:18');
INSERT INTO `resep` VALUES (38, 1, 1, 'Nasi Goreng', 3, 12000.00, 15, 0, 0, 'uploads/resep/1f3c2cea8457c604d4e12d4639dda768.jpg', '', '2026-03-11 09:14:37');
INSERT INTO `resep` VALUES (39, 1, 1, 'Nasi Uduk', 4, 18000.00, 30, 0, 0, 'uploads/resep/abeb34e5ef7162ea9aaefeae1c0fbe0f.jpg', '', '2026-03-11 09:17:25');
INSERT INTO `resep` VALUES (40, 2, 1, 'Ayam Bumbu Rujak', 4, 25000.00, 40, 0, 1, 'uploads/resep/7c6cbe1d39773d9add24b7239d7646b3.jpg', '', '2026-03-11 09:22:57');
INSERT INTO `resep` VALUES (41, 2, 1, 'Ayam Goreng', 2, 18000.00, 25, 0, 0, 'uploads/resep/8ea3499f68ea96e284f80b94a3daa697.jpg', '', '2026-03-11 09:23:47');
INSERT INTO `resep` VALUES (42, 3, 1, 'Ikan Bumbu Kuning', 2, 16000.00, 30, 0, 1, 'uploads/resep/3f42fc15636cb302938a8bc10a440e57.jpg', '', '2026-03-11 09:26:50');
INSERT INTO `resep` VALUES (43, 3, 1, 'Ikan Goreng', 2, 15000.00, 20, 0, 0, 'uploads/resep/0e95fd857185a22ac37b7bf2573d8771.jpg', '', '2026-03-11 09:27:19');
INSERT INTO `resep` VALUES (44, 3, 1, 'Pepes Ikan', 2, 18000.00, 40, 0, 0, 'uploads/resep/e3e8141a3210c087186ee68c044e8144.jpg', '', '2026-03-11 09:27:42');
INSERT INTO `resep` VALUES (45, 4, 1, 'Telur Balado', 4, 12000.00, 20, 0, 1, 'uploads/resep/633ce7d56b49945b0a1d1f7c85124341.jpg', '', '2026-03-11 09:28:36');
INSERT INTO `resep` VALUES (46, 4, 1, 'Telur Dadar', 2, 5000.00, 10, 0, 0, 'uploads/resep/feb07362a8ecf6321e32d1b73a6f0cb2.jpg', '', '2026-03-11 09:29:45');
INSERT INTO `resep` VALUES (47, 4, 1, 'Telur ceplok Kecap', 4, 10000.00, 15, 0, 1, 'uploads/resep/ce29450ff76d9214c5f2c220c17211ef.jpg', '', '2026-03-11 09:31:36');
INSERT INTO `resep` VALUES (48, 4, 1, 'Telur Pontianak', 4, 10000.00, 15, 0, 1, 'uploads/resep/7be1b4e5e0a46ccdb1752dea41391b93.jpg', '', '2026-03-11 09:32:15');
INSERT INTO `resep` VALUES (49, 5, 1, 'Daging Rendang', 4, 45000.00, 120, 0, 1, 'uploads/resep/394eb9ef38682ab2b7d68ee0b075a3e9.jpg', '', '2026-03-11 09:35:48');
INSERT INTO `resep` VALUES (50, 5, 1, 'Semur Daging', 4, 40000.00, 60, 0, 1, 'uploads/resep/8e59b40b7c7211113cfea6b8ec1d081d.jpg', '', '2026-03-11 09:37:38');
INSERT INTO `resep` VALUES (51, 6, 1, 'Tahu Goreng Tepung', 2, 5000.00, 15, 0, 0, 'uploads/resep/7123ddffbb4fe06af2cae59a2eb67540.jpg', '', '2026-03-11 09:38:06');
INSERT INTO `resep` VALUES (52, 6, 1, 'Tahu Isi', 4, 10000.00, 25, 0, 0, 'uploads/resep/f064db532c1f1505323ca00ecb1bdfdf.jpg', '', '2026-03-11 09:38:25');
INSERT INTO `resep` VALUES (53, 6, 1, 'Tempe Mendoan', 4, 8000.00, 20, 0, 0, 'uploads/resep/82125efdefa03640f08a63b9446b6f66.jpg', '', '2026-03-11 09:39:14');
INSERT INTO `resep` VALUES (54, 6, 1, 'Tempe Orek', 2, 6000.00, 15, 0, 1, 'uploads/resep/5f15ce705741cb6edd0e325de9a0f9e7.jpg', '', '2026-03-11 09:41:35');
INSERT INTO `resep` VALUES (55, 7, 1, 'Capcay Sayur', 2, 10000.00, 15, 0, 0, 'uploads/resep/e3bd2f1b263b33c693b03170b7c92a86.jpg', '', '2026-03-11 09:43:16');
INSERT INTO `resep` VALUES (56, 7, 1, 'Sayur Bayam', 2, 5000.00, 15, 0, 0, 'uploads/resep/fd55399caeedf52caf5266ee082e6e64.jpg', '', '2026-03-11 09:43:50');
INSERT INTO `resep` VALUES (57, 7, 1, 'Tumis Kangkung', 2, 5000.00, 10, 0, 0, 'uploads/resep/0ebfae5fa022756622dfc36ec7e214d9.jpg', '', '2026-03-11 09:44:20');
INSERT INTO `resep` VALUES (58, 7, 1, 'Urap Sayur', 4, 8000.00, 25, 0, 1, 'uploads/resep/ce6efef858ce006b029d1e6a18c2adbf.jpg', '', '2026-03-11 09:44:47');
INSERT INTO `resep` VALUES (59, 8, 1, 'Sayur Asem', 4, 10000.00, 30, 0, 1, 'uploads/resep/5bbb7c1dc0ea5db1fe920136c4421389.jpg', '', '2026-03-11 09:45:15');
INSERT INTO `resep` VALUES (60, 8, 1, 'Sayur Lodeh', 4, 12000.00, 35, 0, 1, 'uploads/resep/8bbfe73fe58f5739863acf5b2d37fef2.jpg', '', '2026-03-11 09:45:45');
INSERT INTO `resep` VALUES (61, 8, 1, 'Sop Ayam', 4, 20000.00, 40, 0, 1, 'uploads/resep/4068bd5d40c00bb6a28d8e15fb4788f6.jpg', '', '2026-03-11 09:46:04');
INSERT INTO `resep` VALUES (62, 9, 1, 'Bakwan Sayur', 4, 7000.00, 20, 0, 0, 'uploads/resep/02b792c659aa2c0b78b07b69c97dea20.jpg', '', '2026-03-11 09:46:32');
INSERT INTO `resep` VALUES (63, 9, 1, 'Pisang Goreng', 4, 8000.00, 15, 0, 0, 'uploads/resep/05c73e9b1178c5343ede7d1c43d78b37.jpg', '', '2026-03-11 09:46:52');
INSERT INTO `resep` VALUES (64, 10, 1, 'Mie Goreng', 2, 8000.00, 15, 0, 0, 'uploads/resep/28e6f85a468f158d020cecfc7c95d2b9.jpg', '', '2026-03-11 09:47:14');
INSERT INTO `resep` VALUES (65, 10, 1, 'Mie Kuah', 2, 8000.00, 15, 0, 0, 'uploads/resep/fcb34784c825797801fc297c17aaeca7.jpg', '', '2026-03-11 09:47:38');
INSERT INTO `resep` VALUES (66, 3, 1, 'Ikan Teri Terong Balado', 4, 15000.00, 30, 0, 0, 'uploads/resep/1deb2f1b5cfa52943439c593c776a62e.jpg', '', '2026-03-11 15:12:38');
INSERT INTO `resep` VALUES (67, 7, 1, 'Sayur Bihun Brokoli / Gambas', 4, 10000.00, 30, 0, 0, 'uploads/resep/5a8abfd7d9c5ab3d85b17d6639548eba.jpg', '', '2026-03-11 15:15:53');

-- ----------------------------
-- Table structure for user_settings
-- ----------------------------
DROP TABLE IF EXISTS `user_settings`;
CREATE TABLE `user_settings`  (
  `id_setting` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_user` int NOT NULL,
  `jumlah_orang` int NOT NULL DEFAULT 2,
  `frekuensi_makan` int NOT NULL DEFAULT 3,
  `budget_mingguan` decimal(12, 2) NOT NULL DEFAULT 300000.00,
  `preferensi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp,
  PRIMARY KEY (`id_setting`) USING BTREE,
  UNIQUE INDEX `id_user`(`id_user` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user_settings
-- ----------------------------
INSERT INTO `user_settings` VALUES (1, 1, 2, 3, 300000.00, '[\"ayam\",\"ikan\",\"daging\",\"telur\",\"tahu_tempe\",\"sayur\",\"vegetarian\"]', '2026-03-06 09:23:49', '2026-03-06 09:53:31');
INSERT INTO `user_settings` VALUES (2, 2, 2, 3, 300000.00, NULL, '2026-03-11 16:27:20', '2026-03-11 16:27:20');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id_user` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp,
  PRIMARY KEY (`id_user`) USING BTREE,
  UNIQUE INDEX `email`(`email` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'SeiBiyu', 'seibiyu@gmail.com', '$2y$10$7jl34366pMzhbu1ftaLGgemyqqe5Tgcd3UnmSWqg9VlsakbMZUpei', NULL, '2026-03-06 15:20:33', '2026-03-06 15:20:33');
INSERT INTO `users` VALUES (2, 'TEST', 'test@gmail.com', '$2y$10$YwaPf.J.8KM.BJSPTEYUH.o0heA6Au0s55RNOtIx.bNlzWmCvOJG2', NULL, '2026-03-11 16:27:20', '2026-03-11 16:27:20');

SET FOREIGN_KEY_CHECKS = 1;
