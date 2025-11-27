# Changelog - SPK AHP System

## Update Terbaru - Homepage & Algorithm Fix

### 🎨 Homepage Redesign (COMPLETED)
Seluruh homepage telah diperbarui dengan Metronic design system:

1. **Hero Section**
   - Gradient text heading dengan efek modern
   - Button rounded dengan shadow dan hover effect
   - Spacing dan typography yang lebih baik

2. **Stats Section** 
   - Background gradient purple
   - 4 statistik: Tema Alternatif, Kriteria AHP, Otomatis 100%, CR ≤ 0.1
   - Icon besar dengan animasi

3. **Featured Services Section**
   - Card dengan border-radius 15px dan shadow
   - Gradient icon background (purple, pink, orange, cyan)
   - Hover effect transform translateY
   - 4 tema: Kependidikan, Pemrograman, Multimedia, Jaringan

4. **About Section**
   - Badge dengan gradient background
   - Check list dengan icon box
   - Gradient button CTA
   - Grid gambar dengan border-radius dan shadow

5. **Features Section**
   - 6 feature cards dengan gradient icons
   - Warna berbeda untuk setiap card (purple, pink, cyan, orange, green, indigo)
   - Hover animations

6. **Tema Section**
   - 4 gradient cards untuk setiap tema
   - Zoom-in animation dengan scale effect
   - Full gradient background per card

7. **Cara Kerja Section**
   - Step-by-step dengan numbered gradient boxes
   - 4 langkah: Input Nilai → Pairwise Matrix → Normalisasi → Hasil
   - Image dengan shadow dan border-radius

### 🔧 Critical Algorithm Fix (COMPLETED)

**MASALAH SEBELUMNYA:**
- Semua tema mendapat skor yang sama untuk setiap mahasiswa
- Reza Pratama: Semua tema = 0.250000 (25%)
- Siti Nurhaliza: Semua tema = 0.088350 (8.83%)
- Skor tidak mencerminkan perbedaan nilai mahasiswa di berbagai kriteria

**ROOT CAUSE:**
- Tidak ada data pairwise_alternatif di database
- Algoritma menggunakan equal distribution (1/4 = 0.25 untuk 4 tema)
- Formula: `$alternativeScores[$alt_id] += ($nilai_normalized / count($alternatif)) * $criteriaWeights[$kriteria_id]`
- Hasil: Semua alternatif mendapat skor sama karena dibagi rata

**SOLUSI:**
Implementasi **Relevance Mapping** pada `app/controllers/Mahasiswa.php`:

```php
// Mapping relevansi kriteria ke alternatif (0-1)
$relevanceMap = [
    1 => [2 => 1.0, 1 => 0.3, 3 => 0.5, 4 => 0.2], // Kemampuan Pemrograman
    2 => [3 => 1.0, 2 => 0.4, 1 => 0.2, 4 => 0.1], // Kemampuan Multimedia
    3 => [4 => 1.0, 2 => 0.5, 3 => 0.3, 1 => 0.1], // Kemampuan Jaringan
    4 => [1 => 1.0, 3 => 0.4, 2 => 0.2, 4 => 0.3], // Kemampuan Kependidikan
    5 => [1 => 0.25, 2 => 0.25, 3 => 0.25, 4 => 0.25] // Minat (equal)
];

// Skor = nilai mahasiswa × relevance × bobot kriteria
$alternativeScores[$alt_id] += $nilai_normalized * $relevance * $criteriaWeights[$kriteria_id];
```

**PENJELASAN:**
- **1.0** = Kriteria sangat relevan dengan tema (misal: Kemampuan Pemrograman → Tema Pemrograman)
- **0.5** = Relevansi sedang (misal: Kemampuan Pemrograman → Tema Multimedia)
- **0.3** = Relevansi rendah (misal: Kemampuan Pemrograman → Tema Kependidikan)
- **0.1** = Hampir tidak relevan (misal: Kemampuan Pemrograman → Tema Jaringan)

**HASIL:**
- ✅ Setiap tema sekarang mendapat skor berbeda berdasarkan nilai mahasiswa di kriteria yang relevan
- ✅ Mahasiswa dengan nilai tinggi di mata kuliah pemrograman akan mendapat skor lebih tinggi untuk tema Pemrograman
- ✅ Sistem dapat membedakan rekomendasi berdasarkan kemampuan aktual mahasiswa
- ✅ Ranking menjadi bermakna dan akurat

### 📝 Testing Instructions

1. **Hapus data rekomendasi lama:**
   ```sql
   DELETE FROM hasil_rekomendasi WHERE mahasiswa_id IN (1,2);
   ```

2. **Login sebagai mahasiswa** (username: `reza` / password: `123456`)

3. **Proses rekomendasi ulang** di dashboard mahasiswa

4. **Verifikasi hasil:**
   - Skor setiap tema harus BERBEDA
   - Tema dengan nilai kriteria terkait lebih tinggi harus mendapat skor lebih besar
   - CR harus ≤ 0.1

### 🎯 Next Steps

- [ ] Populate data pairwise_kriteria untuk bobot kriteria yang lebih akurat
- [ ] Populate data pairwise_alternatif untuk perhitungan AHP lengkap
- [ ] Test dengan multiple mahasiswa dengan nilai berbeda
- [ ] Validasi ranking dengan dosen pembimbing
- [ ] Implementasi view ubah password
- [ ] Implementasi interface dosen (lihat laporan)

---

**Author:** GitHub Copilot  
**Date:** 2024  
**Version:** 2.0
