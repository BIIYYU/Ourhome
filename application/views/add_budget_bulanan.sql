-- ============================================================
-- Tambah tabel budget_bulanan (budget belanja & pengeluaran lain per bulan)
-- Jalankan di phpMyAdmin → tab SQL
-- ============================================================

CREATE TABLE IF NOT EXISTS `budget_bulanan` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `id_user` INT NOT NULL,
  `bulan` INT NOT NULL,
  `tahun` INT NOT NULL,
  `budget_belanja` DECIMAL(15,2) NOT NULL DEFAULT 500000 COMMENT 'Budget belanja dapur bulanan',
  `budget_lainnya` DECIMAL(15,2) NOT NULL DEFAULT 500000 COMMENT 'Budget pengeluaran lain bulanan',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `uq_budget_bln` (`id_user`, `bulan`, `tahun`),
  INDEX `idx_bb` (`id_user`, `tahun`, `bulan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
