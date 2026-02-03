-- Migration: Add user photo and new features
-- Date: 2026-02-03

-- 1. Add foto column to users table
ALTER TABLE users 
ADD COLUMN foto VARCHAR(255) NULL AFTER email,
ADD COLUMN angkatan YEAR NULL AFTER foto COMMENT 'Tahun angkatan mahasiswa';

-- 2. Create kurikulum table
CREATE TABLE IF NOT EXISTS kurikulum (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_kurikulum VARCHAR(100) NOT NULL,
    tahun_mulai YEAR NOT NULL,
    tahun_akhir YEAR NULL,
    deskripsi TEXT NULL,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 3. Create matkul_kurikulum table (many-to-many relationship)
CREATE TABLE IF NOT EXISTS matkul_kurikulum (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kurikulum_id INT NOT NULL,
    matkul_id INT NOT NULL,
    semester INT NOT NULL COMMENT '1-8',
    is_wajib TINYINT(1) DEFAULT 1 COMMENT '1=wajib, 0=pilihan',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (kurikulum_id) REFERENCES kurikulum(id) ON DELETE CASCADE,
    FOREIGN KEY (matkul_id) REFERENCES mata_kuliah(id) ON DELETE CASCADE,
    UNIQUE KEY unique_kurikulum_matkul (kurikulum_id, matkul_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 4. Create judul_kating table for previous thesis titles
CREATE TABLE IF NOT EXISTS judul_kating (
    id INT AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(255) NOT NULL,
    nama_mahasiswa VARCHAR(100) NOT NULL,
    nim VARCHAR(20) NOT NULL,
    tahun YEAR NOT NULL,
    tema_id INT NULL,
    dosen_pembimbing VARCHAR(100) NULL,
    nilai VARCHAR(2) NULL COMMENT 'A, B+, B, etc',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (tema_id) REFERENCES alternatif(id) ON DELETE SET NULL,
    INDEX idx_tahun (tahun),
    INDEX idx_tema (tema_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 5. Create mahasiswa_judul table for student's proposed titles
CREATE TABLE IF NOT EXISTS mahasiswa_judul (
    id INT AUTO_INCREMENT PRIMARY KEY,
    mahasiswa_id INT NOT NULL,
    judul VARCHAR(255) NOT NULL,
    tema_id INT NULL,
    deskripsi TEXT NULL,
    status ENUM('draft', 'submitted', 'approved', 'rejected') DEFAULT 'draft',
    catatan TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (mahasiswa_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (tema_id) REFERENCES alternatif(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 6. Create khs_upload table for transcript uploads
CREATE TABLE IF NOT EXISTS khs_upload (
    id INT AUTO_INCREMENT PRIMARY KEY,
    mahasiswa_id INT NOT NULL,
    file_name VARCHAR(255) NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    file_size INT NOT NULL COMMENT 'in bytes',
    semester INT NOT NULL,
    tahun_akademik VARCHAR(10) NOT NULL COMMENT 'e.g., 2023/2024',
    upload_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    verified TINYINT(1) DEFAULT 0,
    verified_by INT NULL,
    verified_at TIMESTAMP NULL,
    catatan TEXT NULL,
    FOREIGN KEY (mahasiswa_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (verified_by) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 7. Insert sample kurikulum data
INSERT INTO kurikulum (nama_kurikulum, tahun_mulai, tahun_akhir, deskripsi, is_active) VALUES
('Kurikulum 2020', 2020, 2024, 'Kurikulum Teknologi Informasi 2020', 1),
('Kurikulum 2024', 2024, NULL, 'Kurikulum Teknologi Informasi 2024 (MBKM)', 1);

-- 8. Insert sample judul kating 2021
INSERT INTO judul_kating (judul, nama_mahasiswa, nim, tahun, tema_id, dosen_pembimbing, nilai) VALUES
('Sistem Informasi Perpustakaan Berbasis Web', 'Ahmad Fauzi', '2021001', 2021, 1, 'Dr. Budi Santoso', 'A'),
('Aplikasi Mobile Pemesanan Makanan', 'Siti Nurhaliza', '2021002', 2021, 2, 'Dr. Ani Wijaya', 'A-'),
('Implementasi Machine Learning untuk Prediksi Cuaca', 'Rudi Hartono', '2021003', 2021, 3, 'Dr. Candra Dewi', 'B+'),
('Desain UI/UX Aplikasi E-Commerce', 'Dewi Sartika', '2021004', 2021, 4, 'Dr. Dedi Irawan', 'A'),
('Sistem Monitoring IoT Berbasis Sensor', 'Eko Prasetyo', '2021005', 2021, 5, 'Dr. Eka Putri', 'B+'),
('Game Edukasi Matematika untuk Anak SD', 'Fitri Handayani', '2021006', 2021, 6, 'Dr. Fajar Nugroho', 'A-');

-- 9. Create uploads directory structure (to be created via PHP)
-- uploads/foto_user/
-- uploads/khs/
