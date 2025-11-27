-- Database SPK AHP Penentuan Tema Tugas Akhir
-- PTIK UIN Sjech M. Djamil Djambek Bukittinggi

-- Drop database if exists
DROP DATABASE IF EXISTS spk_ahp;

-- Create database
CREATE DATABASE spk_ahp CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE spk_ahp;

-- ========================================
-- Tabel Users (Authentication)
-- ========================================
CREATE TABLE users (
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    nama VARCHAR(100) NOT NULL,
    role ENUM('admin', 'mahasiswa', 'dosen') NOT NULL DEFAULT 'mahasiswa',
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_username (username),
    INDEX idx_role (role)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ========================================
-- Tabel Mahasiswa
-- ========================================
CREATE TABLE mahasiswa (
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    user_id INT(11) UNIQUE NOT NULL,
    nim VARCHAR(20) UNIQUE NOT NULL,
    nama VARCHAR(100) NOT NULL,
    angkatan VARCHAR(4) NOT NULL,
    minat_utama VARCHAR(50),
    email VARCHAR(100),
    no_hp VARCHAR(15),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_nim (nim),
    INDEX idx_angkatan (angkatan)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ========================================
-- Tabel Kriteria AHP
-- ========================================
CREATE TABLE kriteria (
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    kode VARCHAR(10) UNIQUE NOT NULL,
    nama_kriteria VARCHAR(100) NOT NULL,
    jenis ENUM('benefit', 'cost') DEFAULT 'benefit',
    bobot DECIMAL(10,6) DEFAULT 0,
    keterangan TEXT,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_kode (kode)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ========================================
-- Tabel Alternatif Tema Tugas Akhir
-- ========================================
CREATE TABLE alternatif_tema (
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    kode VARCHAR(10) UNIQUE NOT NULL,
    nama_tema VARCHAR(100) NOT NULL,
    deskripsi TEXT,
    icon VARCHAR(50),
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_kode (kode)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ========================================
-- Tabel Mata Kuliah
-- ========================================
CREATE TABLE mata_kuliah (
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    kode VARCHAR(10) UNIQUE NOT NULL,
    nama_matkul VARCHAR(100) NOT NULL,
    kriteria_id INT(11),
    bobot_matkul DECIMAL(5,2) DEFAULT 1,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (kriteria_id) REFERENCES kriteria(id) ON DELETE SET NULL,
    INDEX idx_kode (kode)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ========================================
-- Tabel Nilai Mata Kuliah Mahasiswa
-- ========================================
CREATE TABLE nilai_matkul (
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    mahasiswa_id INT(11) NOT NULL,
    matkul_id INT(11) NOT NULL,
    nilai DECIMAL(5,2) NOT NULL CHECK (nilai >= 0 AND nilai <= 100),
    grade VARCHAR(2),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (mahasiswa_id) REFERENCES mahasiswa(id) ON DELETE CASCADE,
    FOREIGN KEY (matkul_id) REFERENCES mata_kuliah(id) ON DELETE CASCADE,
    UNIQUE KEY unique_nilai (mahasiswa_id, matkul_id),
    INDEX idx_mahasiswa (mahasiswa_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ========================================
-- Tabel Pairwise Comparison Kriteria
-- ========================================
CREATE TABLE pairwise_kriteria (
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    kriteria_1 INT(11) NOT NULL,
    kriteria_2 INT(11) NOT NULL,
    nilai DECIMAL(5,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (kriteria_1) REFERENCES kriteria(id) ON DELETE CASCADE,
    FOREIGN KEY (kriteria_2) REFERENCES kriteria(id) ON DELETE CASCADE,
    UNIQUE KEY unique_pair (kriteria_1, kriteria_2)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ========================================
-- Tabel Pairwise Comparison Alternatif
-- ========================================
CREATE TABLE pairwise_alternatif (
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    kriteria_id INT(11) NOT NULL,
    alternatif_1 INT(11) NOT NULL,
    alternatif_2 INT(11) NOT NULL,
    nilai DECIMAL(5,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (kriteria_id) REFERENCES kriteria(id) ON DELETE CASCADE,
    FOREIGN KEY (alternatif_1) REFERENCES alternatif_tema(id) ON DELETE CASCADE,
    FOREIGN KEY (alternatif_2) REFERENCES alternatif_tema(id) ON DELETE CASCADE,
    UNIQUE KEY unique_pair (kriteria_id, alternatif_1, alternatif_2)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ========================================
-- Tabel Hasil Rekomendasi
-- ========================================
CREATE TABLE hasil_rekomendasi (
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    mahasiswa_id INT(11) NOT NULL,
    alternatif_id INT(11) NOT NULL,
    total_score DECIMAL(10,6) NOT NULL,
    ranking INT(11) NOT NULL,
    keterangan TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (mahasiswa_id) REFERENCES mahasiswa(id) ON DELETE CASCADE,
    FOREIGN KEY (alternatif_id) REFERENCES alternatif_tema(id) ON DELETE CASCADE,
    INDEX idx_mahasiswa (mahasiswa_id),
    INDEX idx_ranking (ranking)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ========================================
-- Tabel Riwayat Perhitungan AHP
-- ========================================
CREATE TABLE riwayat_perhitungan (
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    mahasiswa_id INT(11) NOT NULL,
    consistency_ratio DECIMAL(10,6),
    is_consistent TINYINT(1) DEFAULT 1,
    detail_perhitungan JSON,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (mahasiswa_id) REFERENCES mahasiswa(id) ON DELETE CASCADE,
    INDEX idx_mahasiswa (mahasiswa_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ========================================
-- DATA DUMMY
-- ========================================

-- Insert Users
INSERT INTO users (username, password, nama, role) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrator', 'admin'),
('dosen1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Dr. Ahmad Fadli', 'dosen'),
('2021001', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Reza Pratama', 'mahasiswa'),
('2021002', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Siti Nurhaliza', 'mahasiswa'),
('2021003', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Budi Santoso', 'mahasiswa');
-- Password default: password

-- Insert Mahasiswa
INSERT INTO mahasiswa (user_id, nim, nama, angkatan, minat_utama, email) VALUES
(3, '2021001', 'Reza Pratama', '2021', 'Pemrograman', 'reza@example.com'),
(4, '2021002', 'Siti Nurhaliza', '2021', 'Multimedia', 'siti@example.com'),
(5, '2021003', 'Budi Santoso', '2021', 'Jaringan', 'budi@example.com');

-- Insert Kriteria
INSERT INTO kriteria (kode, nama_kriteria, jenis, keterangan) VALUES
('K1', 'Kemampuan Pemrograman', 'benefit', 'Kemampuan dalam bidang programming dan coding'),
('K2', 'Kemampuan Multimedia', 'benefit', 'Kemampuan dalam desain grafis, video, animasi'),
('K3', 'Kemampuan Jaringan', 'benefit', 'Kemampuan dalam jaringan komputer dan sistem'),
('K4', 'Kemampuan Kependidikan', 'benefit', 'Kemampuan dalam bidang pendidikan dan pengajaran'),
('K5', 'Minat dan Motivasi', 'benefit', 'Tingkat minat dan motivasi terhadap bidang tertentu');

-- Insert Alternatif Tema
INSERT INTO alternatif_tema (kode, nama_tema, deskripsi, icon) VALUES
('A1', 'Kependidikan', 'Penelitian di bidang teknologi pendidikan, media pembelajaran, e-learning', 'fa-graduation-cap'),
('A2', 'Pemrograman', 'Pengembangan aplikasi web, mobile, desktop, sistem informasi', 'fa-code'),
('A3', 'Desain Media / Multimedia', 'Desain grafis, animasi, video editing, game development', 'fa-palette'),
('A4', 'Jaringan Komputer', 'Jaringan, keamanan sistem, IoT, cloud computing', 'fa-network-wired');

-- Insert Mata Kuliah
INSERT INTO mata_kuliah (kode, nama_matkul, kriteria_id) VALUES
('MK01', 'Pemrograman Web', 1),
('MK02', 'Pemrograman Mobile', 1),
('MK03', 'Basis Data', 1),
('MK04', 'Multimedia', 2),
('MK05', 'Desain Grafis', 2),
('MK06', 'Video Editing', 2),
('MK07', 'Jaringan Komputer', 3),
('MK08', 'Keamanan Sistem', 3),
('MK09', 'Ilmu Pendidikan', 4),
('MK10', 'Teknologi Pembelajaran', 4),
('MK11', 'Media Pembelajaran', 4);

-- Insert Nilai Mahasiswa (Dummy)
INSERT INTO nilai_matkul (mahasiswa_id, matkul_id, nilai, grade) VALUES
-- Reza Pratama (Kuat di Pemrograman)
(1, 1, 90, 'A'),
(1, 2, 88, 'A'),
(1, 3, 85, 'A'),
(1, 4, 75, 'B'),
(1, 5, 70, 'B'),
(1, 7, 78, 'B'),
(1, 9, 72, 'B'),
-- Siti Nurhaliza (Kuat di Multimedia)
(2, 1, 75, 'B'),
(2, 4, 92, 'A'),
(2, 5, 90, 'A'),
(2, 6, 88, 'A'),
(2, 9, 80, 'A'),
-- Budi Santoso (Kuat di Jaringan)
(3, 1, 78, 'B'),
(3, 7, 90, 'A'),
(3, 8, 87, 'A'),
(3, 3, 82, 'A'),
(3, 9, 76, 'B');

-- Insert Pairwise Kriteria (Dummy - harus disesuaikan dengan AHP yang benar)
-- Nilai: 1=sama penting, 3=sedikit lebih penting, 5=lebih penting, 7=sangat penting, 9=mutlak lebih penting
INSERT INTO pairwise_kriteria (kriteria_1, kriteria_2, nilai) VALUES
-- K1 vs others
(1, 2, 3),  -- K1 lebih penting dari K2
(1, 3, 2),  -- K1 sedikit lebih penting dari K3
(1, 4, 5),  -- K1 lebih penting dari K4
(1, 5, 2),  -- K1 sedikit lebih penting dari K5
-- K2 vs others
(2, 3, 2),  -- K2 sedikit lebih penting dari K3
(2, 4, 4),  -- K2 lebih penting dari K4
(2, 5, 1),  -- K2 sama penting dengan K5
-- K3 vs others
(3, 4, 3),  -- K3 lebih penting dari K4
(3, 5, 1),  -- K3 sama penting dengan K5
-- K4 vs K5
(4, 5, 0.5); -- K4 kurang penting dari K5

-- ========================================
-- VIEWS untuk kemudahan query
-- ========================================

-- View untuk melihat data lengkap mahasiswa dengan user
CREATE VIEW v_mahasiswa_lengkap AS
SELECT 
    m.id,
    m.nim,
    m.nama,
    m.angkatan,
    m.minat_utama,
    m.email,
    m.no_hp,
    u.username,
    u.is_active,
    u.created_at as tanggal_daftar
FROM mahasiswa m
JOIN users u ON m.user_id = u.id;

-- View untuk rata-rata nilai per kriteria per mahasiswa
CREATE VIEW v_nilai_kriteria_mahasiswa AS
SELECT 
    m.id as mahasiswa_id,
    m.nim,
    m.nama,
    k.id as kriteria_id,
    k.nama_kriteria,
    AVG(nm.nilai) as rata_rata_nilai,
    COUNT(nm.id) as jumlah_matkul
FROM mahasiswa m
LEFT JOIN nilai_matkul nm ON m.id = nm.mahasiswa_id
LEFT JOIN mata_kuliah mk ON nm.matkul_id = mk.id
LEFT JOIN kriteria k ON mk.kriteria_id = k.id
GROUP BY m.id, k.id;

-- ========================================
-- STORED PROCEDURES
-- ========================================

DELIMITER //

-- Procedure untuk reset password user
CREATE PROCEDURE sp_reset_password(
    IN p_user_id INT,
    IN p_new_password VARCHAR(255)
)
BEGIN
    UPDATE users 
    SET password = p_new_password,
        updated_at = CURRENT_TIMESTAMP
    WHERE id = p_user_id;
END //

-- Procedure untuk mendapatkan statistik tema
CREATE PROCEDURE sp_statistik_tema()
BEGIN
    SELECT 
        at.nama_tema,
        COUNT(DISTINCT hr.mahasiswa_id) as jumlah_mahasiswa,
        AVG(hr.total_score) as rata_rata_score,
        COUNT(CASE WHEN hr.ranking = 1 THEN 1 END) as jumlah_ranking_1
    FROM alternatif_tema at
    LEFT JOIN hasil_rekomendasi hr ON at.id = hr.alternatif_id
    GROUP BY at.id, at.nama_tema
    ORDER BY jumlah_ranking_1 DESC, rata_rata_score DESC;
END //

DELIMITER ;

-- ========================================
-- INDEXES untuk performa
-- ========================================

CREATE INDEX idx_nilai_mahasiswa_matkul ON nilai_matkul(mahasiswa_id, matkul_id);
CREATE INDEX idx_hasil_mahasiswa_score ON hasil_rekomendasi(mahasiswa_id, total_score DESC);

-- ========================================
-- Selesai
-- ========================================
