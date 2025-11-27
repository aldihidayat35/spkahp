-- ============================================
-- SQL Testing untuk Pairwise Alternatif
-- ============================================

-- 1. CEK DATA KRITERIA (harus ada dan aktif)
-- ============================================
SELECT 
    id,
    kode_kriteria,
    nama_kriteria,
    bobot,
    is_active,
    created_at
FROM kriteria 
WHERE is_active = 1
ORDER BY kode_kriteria;

-- Expected: Minimal 3-5 kriteria aktif


-- 2. CEK DATA ALTERNATIF (minimal 2 untuk bisa dibandingkan)
-- ============================================
SELECT 
    id,
    kode_tema,
    nama_tema,
    deskripsi,
    is_active,
    created_at
FROM alternatif 
WHERE is_active = 1
ORDER BY kode_tema;

-- Expected: Minimal 2 alternatif aktif


-- 3. CEK DATA PAIRWISE ALTERNATIF YANG SUDAH ADA
-- ============================================
SELECT 
    pa.id,
    k.nama_kriteria,
    a1.nama_tema as alternatif_1,
    a2.nama_tema as alternatif_2,
    pa.nilai,
    pa.created_at
FROM pairwise_alternatif pa
JOIN kriteria k ON pa.kriteria_id = k.id
JOIN alternatif a1 ON pa.alternatif_1 = a1.id
JOIN alternatif a2 ON pa.alternatif_2 = a2.id
ORDER BY k.nama_kriteria, a1.nama_tema, a2.nama_tema;

-- Expected: Data perbandingan yang sudah diinput sebelumnya


-- 4. CEK PAIRWISE UNTUK KRITERIA TERTENTU (ganti ID sesuai kebutuhan)
-- ============================================
SET @kriteria_id = 1;

SELECT 
    pa.id,
    a1.nama_tema as alternatif_1,
    a2.nama_tema as alternatif_2,
    pa.nilai,
    CASE 
        WHEN pa.nilai = 1 THEN 'Sama penting'
        WHEN pa.nilai = 3 THEN 'Sedikit lebih penting'
        WHEN pa.nilai = 5 THEN 'Lebih penting'
        WHEN pa.nilai = 7 THEN 'Sangat lebih penting'
        WHEN pa.nilai = 9 THEN 'Mutlak lebih penting'
        ELSE CONCAT('Custom: ', pa.nilai)
    END as keterangan
FROM pairwise_alternatif pa
JOIN alternatif a1 ON pa.alternatif_1 = a1.id
JOIN alternatif a2 ON pa.alternatif_2 = a2.id
WHERE pa.kriteria_id = @kriteria_id
ORDER BY a1.nama_tema, a2.nama_tema;


-- 5. HITUNG JUMLAH PERBANDINGAN YANG DIPERLUKAN
-- ============================================
-- Rumus: n(n-1)/2 dimana n = jumlah alternatif
SELECT 
    COUNT(*) as total_alternatif,
    (COUNT(*) * (COUNT(*) - 1)) / 2 as perbandingan_diperlukan,
    (SELECT COUNT(*) 
     FROM pairwise_alternatif 
     WHERE kriteria_id = @kriteria_id) as perbandingan_terisi
FROM alternatif 
WHERE is_active = 1;


-- 6. CEK ALTERNATIF MANA YANG BELUM DIBANDINGKAN
-- ============================================
-- Untuk kriteria tertentu, cek pasangan mana yang belum ada
SELECT 
    a1.id as id_1,
    a1.nama_tema as alternatif_1,
    a2.id as id_2,
    a2.nama_tema as alternatif_2,
    CASE 
        WHEN pa.id IS NULL THEN '❌ Belum ada'
        ELSE CONCAT('✅ Nilai: ', pa.nilai)
    END as status
FROM alternatif a1
CROSS JOIN alternatif a2
LEFT JOIN pairwise_alternatif pa 
    ON pa.kriteria_id = @kriteria_id 
    AND pa.alternatif_1 = a1.id 
    AND pa.alternatif_2 = a2.id
WHERE a1.is_active = 1 
    AND a2.is_active = 1 
    AND a1.id < a2.id
ORDER BY a1.nama_tema, a2.nama_tema;


-- 7. INSERT DATA SAMPLE (jika belum ada)
-- ============================================
-- HATI-HATI: Hanya jalankan jika data benar-benar kosong!

-- Uncomment untuk insert sample data
/*
-- Pastikan ada kriteria dengan ID 1
INSERT INTO pairwise_alternatif (kriteria_id, alternatif_1, alternatif_2, nilai, created_at)
SELECT 
    1 as kriteria_id,
    a1.id as alternatif_1,
    a2.id as alternatif_2,
    3 as nilai, -- Default: sedikit lebih penting
    NOW()
FROM alternatif a1
CROSS JOIN alternatif a2
WHERE a1.id < a2.id 
    AND a1.is_active = 1 
    AND a2.is_active = 1
    AND NOT EXISTS (
        SELECT 1 FROM pairwise_alternatif 
        WHERE kriteria_id = 1 
            AND alternatif_1 = a1.id 
            AND alternatif_2 = a2.id
    );
*/


-- 8. DELETE DATA PAIRWISE UNTUK KRITERIA TERTENTU (jika perlu reset)
-- ============================================
-- HATI-HATI: Ini akan menghapus semua data!
/*
DELETE FROM pairwise_alternatif WHERE kriteria_id = @kriteria_id;
*/


-- 9. CEK KONSISTENSI DATA
-- ============================================
-- Pastikan tidak ada referensi ke kriteria/alternatif yang tidak aktif
SELECT 
    'Pairwise dengan kriteria tidak aktif' as issue,
    COUNT(*) as jumlah
FROM pairwise_alternatif pa
JOIN kriteria k ON pa.kriteria_id = k.id
WHERE k.is_active = 0

UNION ALL

SELECT 
    'Pairwise dengan alternatif_1 tidak aktif' as issue,
    COUNT(*) as jumlah
FROM pairwise_alternatif pa
JOIN alternatif a ON pa.alternatif_1 = a.id
WHERE a.is_active = 0

UNION ALL

SELECT 
    'Pairwise dengan alternatif_2 tidak aktif' as issue,
    COUNT(*) as jumlah
FROM pairwise_alternatif pa
JOIN alternatif a ON pa.alternatif_2 = a.id
WHERE a.is_active = 0;

-- Expected: Semua jumlah = 0


-- 10. VIEW UNTUK MONITORING
-- ============================================
CREATE OR REPLACE VIEW v_pairwise_progress AS
SELECT 
    k.id as kriteria_id,
    k.nama_kriteria,
    (SELECT COUNT(*) FROM alternatif WHERE is_active = 1) as total_alternatif,
    ((SELECT COUNT(*) FROM alternatif WHERE is_active = 1) * 
     ((SELECT COUNT(*) FROM alternatif WHERE is_active = 1) - 1)) / 2 as perbandingan_diperlukan,
    COUNT(pa.id) as perbandingan_terisi,
    ROUND(
        (COUNT(pa.id) * 100.0) / 
        NULLIF(((SELECT COUNT(*) FROM alternatif WHERE is_active = 1) * 
                ((SELECT COUNT(*) FROM alternatif WHERE is_active = 1) - 1)) / 2, 0),
        2
    ) as persentase_lengkap
FROM kriteria k
LEFT JOIN pairwise_alternatif pa ON k.id = pa.kriteria_id
WHERE k.is_active = 1
GROUP BY k.id, k.nama_kriteria
ORDER BY k.nama_kriteria;

-- Gunakan view:
SELECT * FROM v_pairwise_progress;


-- ============================================
-- QUICK DIAGNOSTIC
-- ============================================
SELECT 
    'Total Kriteria Aktif' as metrik,
    COUNT(*) as nilai
FROM kriteria WHERE is_active = 1

UNION ALL

SELECT 
    'Total Alternatif Aktif' as metrik,
    COUNT(*) as nilai
FROM alternatif WHERE is_active = 1

UNION ALL

SELECT 
    'Total Pairwise Alternatif' as metrik,
    COUNT(*) as nilai
FROM pairwise_alternatif

UNION ALL

SELECT 
    'Kriteria dengan Pairwise Lengkap' as metrik,
    COUNT(*) as nilai
FROM v_pairwise_progress 
WHERE persentase_lengkap = 100;
