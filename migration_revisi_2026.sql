-- Migration for SPK AHP Revisi 2026
-- Run this SQL script to create all new tables

USE spk_ahp;

-- 1. Tabel Kurikulum (per angkatan)
CREATE TABLE IF NOT EXISTS `kurikulum` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `angkatan` varchar(10) NOT NULL,
  `nama_kurikulum` varchar(255) NOT NULL,
  `keterangan` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `angkatan` (`angkatan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 2. Tabel Mata Kuliah per Kurikulum
CREATE TABLE IF NOT EXISTS `matkul_kurikulum` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kurikulum_id` int(11) NOT NULL,
  `kode_matkul` varchar(20) NOT NULL,
  `nama_matkul` varchar(255) NOT NULL,
  `sks` int(11) NOT NULL,
  `semester` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `kurikulum_id` (`kurikulum_id`),
  CONSTRAINT `fk_matkul_kurikulum` FOREIGN KEY (`kurikulum_id`) REFERENCES `kurikulum` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 3. Tabel Judul Kating (dari tahun 2021)
CREATE TABLE IF NOT EXISTS `judul_kating` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) NOT NULL,
  `tema_id` int(11) DEFAULT NULL,
  `tahun` year(4) NOT NULL,
  `angkatan` varchar(10) DEFAULT NULL,
  `status` enum('lulus','sedang_berjalan') DEFAULT 'lulus',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `tema_id` (`tema_id`),
  KEY `tahun` (`tahun`),
  CONSTRAINT `fk_judul_kating_tema` FOREIGN KEY (`tema_id`) REFERENCES `alternatif_tema` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 4. Tabel Mahasiswa Judul (input judul oleh mahasiswa)
CREATE TABLE IF NOT EXISTS `mahasiswa_judul` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mahasiswa_id` int(11) NOT NULL,
  `tema_id` int(11) DEFAULT NULL,
  `judul` varchar(255) NOT NULL,
  `deskripsi` text,
  `status` enum('draft','diajukan','disetujui','ditolak') DEFAULT 'draft',
  `catatan_dosen` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `mahasiswa_id` (`mahasiswa_id`),
  KEY `tema_id` (`tema_id`),
  CONSTRAINT `fk_mahasiswa_judul_mahasiswa` FOREIGN KEY (`mahasiswa_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_mahasiswa_judul_tema` FOREIGN KEY (`tema_id`) REFERENCES `alternatif_tema` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 5. Tabel KHS Upload (jaminan nilai)
CREATE TABLE IF NOT EXISTS `khs_upload` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mahasiswa_id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_size` bigint(20) NOT NULL,
  `semester` int(11) DEFAULT NULL,
  `tahun_akademik` varchar(20) DEFAULT NULL,
  `verified` tinyint(1) DEFAULT 0,
  `verified_by` int(11) DEFAULT NULL,
  `verified_at` timestamp NULL DEFAULT NULL,
  `catatan` text,
  `upload_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `mahasiswa_id` (`mahasiswa_id`),
  KEY `verified_by` (`verified_by`),
  CONSTRAINT `fk_khs_mahasiswa` FOREIGN KEY (`mahasiswa_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_khs_verified` FOREIGN KEY (`verified_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 6. Tambah kolom foto di tabel users (jika belum ada)
-- Skip jika kolom sudah ada
-- ALTER TABLE `users` ADD COLUMN `foto` varchar(255) DEFAULT NULL AFTER `role`;

-- Insert sample data untuk kurikulum
INSERT INTO `kurikulum` (`angkatan`, `nama_kurikulum`, `keterangan`) VALUES
('2020', 'Kurikulum 2020', 'Kurikulum untuk angkatan 2020'),
('2021', 'Kurikulum 2021', 'Kurikulum untuk angkatan 2021'),
('2022', 'Kurikulum 2022', 'Kurikulum untuk angkatan 2022'),
('2023', 'Kurikulum 2023', 'Kurikulum untuk angkatan 2023')
ON DUPLICATE KEY UPDATE angkatan=angkatan;

-- Insert sample mata kuliah untuk kurikulum 2021
INSERT INTO `matkul_kurikulum` (`kurikulum_id`, `kode_matkul`, `nama_matkul`, `sks`, `semester`) 
SELECT k.id, 'IF101', 'Pemrograman Dasar', 3, 1 FROM `kurikulum` k WHERE k.angkatan = '2021'
UNION ALL
SELECT k.id, 'IF102', 'Struktur Data', 3, 2 FROM `kurikulum` k WHERE k.angkatan = '2021'
UNION ALL
SELECT k.id, 'IF103', 'Basis Data', 3, 3 FROM `kurikulum` k WHERE k.angkatan = '2021'
UNION ALL
SELECT k.id, 'IF104', 'Pemrograman Web', 3, 4 FROM `kurikulum` k WHERE k.angkatan = '2021'
UNION ALL
SELECT k.id, 'IF105', 'Sistem Operasi', 3, 3 FROM `kurikulum` k WHERE k.angkatan = '2021'
UNION ALL
SELECT k.id, 'IF106', 'Jaringan Komputer', 3, 4 FROM `kurikulum` k WHERE k.angkatan = '2021'
ON DUPLICATE KEY UPDATE kode_matkul=kode_matkul;

-- Insert sample judul kating dari tahun 2021
INSERT INTO `judul_kating` (`judul`, `tahun`, `angkatan`, `status`) VALUES
('Sistem Informasi Geografis Pemetaan Wisata Berbasis Web', 2021, '2017', 'lulus'),
('Aplikasi Mobile Learning Berbasis Android', 2021, '2017', 'lulus'),
('Sistem Pakar Diagnosa Penyakit Tanaman Padi', 2021, '2017', 'lulus'),
('E-Commerce Fashion Menggunakan Framework Laravel', 2021, '2017', 'lulus'),
('Chatbot Customer Service Berbasis Natural Language Processing', 2021, '2017', 'lulus'),
('Sistem Monitoring IoT Untuk Smart Home', 2021, '2017', 'lulus')
ON DUPLICATE KEY UPDATE judul=judul;

SELECT 'Migration completed successfully!' as status;
