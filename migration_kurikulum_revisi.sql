-- Migration untuk Revisi Kurikulum sesuai masukan Dosen
-- Tanggal: 5 Februari 2026

USE spk_ahp;

-- 1. Update tabel kurikulum - tambahkan kolom tahun_berlaku
ALTER TABLE `kurikulum` 
ADD COLUMN `tahun_berlaku` varchar(20) DEFAULT NULL AFTER `nama_kurikulum`;

-- 2. Update data kurikulum yang sudah ada dengan tahun berlaku
UPDATE `kurikulum` SET `tahun_berlaku` = CONCAT(angkatan, '/', CAST(angkatan AS UNSIGNED) + 1);

-- 3. Tambahkan kolom kurikulum_id di tabel mata_kuliah
ALTER TABLE `mata_kuliah` 
ADD COLUMN `kurikulum_id` int(11) DEFAULT NULL AFTER `nama_matkul`,
ADD KEY `fk_matkul_kurikulum_id` (`kurikulum_id`),
ADD CONSTRAINT `fk_matkul_kurikulum_id` FOREIGN KEY (`kurikulum_id`) REFERENCES `kurikulum` (`id`) ON DELETE SET NULL;

-- 4. Tambahkan kolom kurikulum_id di tabel mahasiswa
ALTER TABLE `mahasiswa` 
ADD COLUMN `kurikulum_id` int(11) DEFAULT NULL AFTER `angkatan`,
ADD KEY `fk_mahasiswa_kurikulum_id` (`kurikulum_id`),
ADD CONSTRAINT `fk_mahasiswa_kurikulum_id` FOREIGN KEY (`kurikulum_id`) REFERENCES `kurikulum` (`id`) ON DELETE SET NULL;

-- 5. Update mahasiswa yang sudah ada dengan kurikulum berdasarkan angkatan
UPDATE `mahasiswa` m 
LEFT JOIN `kurikulum` k ON m.angkatan = k.angkatan
SET m.kurikulum_id = k.id;

-- 6. Insert kurikulum Kurikulum B dan Kurikulum C untuk PTIK
INSERT INTO `kurikulum` (`angkatan`, `nama_kurikulum`, `tahun_berlaku`, `keterangan`) VALUES
('2024', 'Kurikulum B', '2024/2025', 'Kurikulum untuk angkatan 2024'),
('2025', 'Kurikulum C', '2025/2026', 'Kurikulum untuk angkatan 2025 dan seterusnya')
ON DUPLICATE KEY UPDATE 
    nama_kurikulum = VALUES(nama_kurikulum),
    tahun_berlaku = VALUES(tahun_berlaku),
    keterangan = VALUES(keterangan);

SELECT 'Migration completed successfully!' as status;
SELECT * FROM kurikulum;
