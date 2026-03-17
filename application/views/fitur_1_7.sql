-- ============================================================
-- FITUR 1-7: New tables for Our Home app
-- Jalankan di phpMyAdmin → tab SQL
-- ============================================================

-- 4. Catatan/Memo per Minggu
CREATE TABLE IF NOT EXISTS `catatan_minggu` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `id_user` INT NOT NULL,
  `minggu_ke` INT NOT NULL,
  `tahun` INT NOT NULL,
  `catatan` TEXT,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `uq_catatan` (`id_user`, `minggu_ke`, `tahun`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 5. Template Belanja
CREATE TABLE IF NOT EXISTS `template_belanja` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `id_user` INT NOT NULL,
  `nama_template` VARCHAR(100) NOT NULL DEFAULT 'Belanja Mingguan',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX `idx_tpl` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `template_belanja_item` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `id_template` INT NOT NULL,
  `nama_item` VARCHAR(100) NOT NULL,
  `jumlah` DECIMAL(10,2) DEFAULT 1,
  `satuan` VARCHAR(30) DEFAULT 'buah',
  `estimasi_harga` DECIMAL(12,2) DEFAULT 0,
  `kategori_item` VARCHAR(50) DEFAULT NULL,
  INDEX `idx_tpl_item` (`id_template`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 7. Target Tabungan
CREATE TABLE IF NOT EXISTS `target_tabungan` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `id_user` INT NOT NULL,
  `nama_target` VARCHAR(150) NOT NULL DEFAULT 'Tabungan',
  `target_amount` DECIMAL(15,2) NOT NULL DEFAULT 0,
  `is_active` TINYINT(1) DEFAULT 1,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX `idx_tab` (`id_user`, `is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tambah kolom budget_bulanan jika belum ada
-- (table budget_bulanan sudah dibuat sebelumnya)
