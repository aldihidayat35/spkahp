# 📊 ALUR KERJA METODE AHP DALAM APLIKASI
## Step-by-Step Process Flow

---

## 🎯 OVERVIEW PROSES AHP

```
┌─────────────────────────────────────────────────────────────┐
│                    SISTEM REKOMENDASI PKL                    │
│                    Menggunakan Metode AHP                    │
└─────────────────────────────────────────────────────────────┘
                              ↓
    ┌─────────────────────────────────────────────────┐
    │  FASE 1: SETUP MASTER DATA (Admin)              │
    │  - Kriteria (5 kriteria penilaian)              │
    │  - Alternatif (6 tema PKL)                      │
    │  - Mata Kuliah (mapping ke kriteria)            │
    └─────────────────────────────────────────────────┘
                              ↓
    ┌─────────────────────────────────────────────────┐
    │  FASE 2: PERBANDINGAN BERPASANGAN (Admin)       │
    │  - Pairwise Kriteria (hitung bobot kriteria)    │
    │  - Pairwise Alternatif (per kriteria)           │
    └─────────────────────────────────────────────────┘
                              ↓
    ┌─────────────────────────────────────────────────┐
    │  FASE 3: INPUT NILAI (Admin/Mahasiswa)          │
    │  - Nilai mata kuliah mahasiswa                  │
    │  - Mapping otomatis ke kriteria                 │
    └─────────────────────────────────────────────────┘
                              ↓
    ┌─────────────────────────────────────────────────┐
    │  FASE 4: PERHITUNGAN REKOMENDASI (Mahasiswa)    │
    │  - Normalisasi nilai                            │
    │  - Kalkulasi score dengan bobot                 │
    │  - Ranking alternatif                           │
    └─────────────────────────────────────────────────┘
                              ↓
    ┌─────────────────────────────────────────────────┐
    │  OUTPUT: TOP 3 REKOMENDASI TEMA PKL             │
    │  - Tema dengan score tertinggi                  │
    │  - Presentase score                             │
    │  - Detail breakdown per kriteria                │
    └─────────────────────────────────────────────────┘
```

---

## 📋 FASE 1: SETUP MASTER DATA

### 1.1 Input Kriteria

**Admin → Kelola Kriteria → Tambah Kriteria**

```
Contoh Data Kriteria:
┌────┬──────┬──────────────────────┬────────┬────────┐
│ ID │ Kode │ Nama Kriteria        │ Bobot  │ Jenis  │
├────┼──────┼──────────────────────┼────────┼────────┤
│ 1  │ K1   │ Pemrograman Web      │ 0.419  │Benefit │
│ 2  │ K2   │ Database             │ 0.263  │Benefit │
│ 3  │ K3   │ Mobile Development   │ 0.132  │Benefit │
│ 4  │ K4   │ Data Science         │ 0.070  │Benefit │
│ 5  │ K5   │ UI/UX Design         │ 0.116  │Benefit │
└────┴──────┴──────────────────────┴────────┴────────┘

* Bobot awal = 0, akan dihitung via pairwise comparison
```

### 1.2 Input Alternatif Tema

**Admin → Kelola Alternatif → Tambah Alternatif**

```
Contoh Data Alternatif:
┌────┬──────┬──────────────────────┬──────────────────────────┐
│ ID │ Kode │ Nama Tema            │ Deskripsi                │
├────┼──────┼──────────────────────┼──────────────────────────┤
│ 1  │ T1   │ Web Development      │ Frontend & Backend       │
│ 2  │ T2   │ Mobile Development   │ Android/iOS App          │
│ 3  │ T3   │ Data Science         │ Machine Learning, AI     │
│ 4  │ T4   │ UI/UX Design         │ Design & Prototyping     │
│ 5  │ T5   │ IoT Development      │ Hardware & Software      │
│ 6  │ T6   │ Game Development     │ Unity, Unreal Engine     │
└────┴──────┴──────────────────────┴──────────────────────────┘
```

### 1.3 Input Mata Kuliah

**Admin → Kelola Mata Kuliah → Tambah Mata Kuliah**

```
Mapping Mata Kuliah ke Kriteria:
┌─────────────────────────┬──────────────────────┬────────┐
│ Nama Mata Kuliah        │ Kriteria             │ Bobot  │
├─────────────────────────┼──────────────────────┼────────┤
│ Pemrograman Web         │ K1 (Prog. Web)       │ 1.0    │
│ Web Lanjut              │ K1 (Prog. Web)       │ 1.0    │
│ Database                │ K2 (Database)        │ 1.0    │
│ Basis Data Lanjut       │ K2 (Database)        │ 1.0    │
│ Mobile Programming      │ K3 (Mobile Dev)      │ 1.0    │
│ Data Mining             │ K4 (Data Science)    │ 1.0    │
│ Desain Grafis           │ K5 (UI/UX)           │ 1.0    │
└─────────────────────────┴──────────────────────┴────────┘

* Bobot matkul untuk weighted average jika ada banyak matkul per kriteria
```

---

## 🔢 FASE 2: PERBANDINGAN BERPASANGAN

### 2.1 Pairwise Comparison Kriteria

**Admin → Pairwise Comparison → Kriteria**

#### Step 1: Input Perbandingan

```
Skala Perbandingan (Saaty):
1 = Sama penting
3 = Sedikit lebih penting
5 = Lebih penting
7 = Sangat lebih penting
9 = Mutlak lebih penting

Contoh Input:
"K1 (Pemrograman Web) vs K2 (Database)" → Nilai: 3
"K1 (Pemrograman Web) vs K3 (Mobile Dev)" → Nilai: 5
"K1 (Pemrograman Web) vs K4 (Data Science)" → Nilai: 7
...dst untuk semua pasangan
```

#### Step 2: Build Matrix

```
Matrix Perbandingan (5x5):
        K1      K2      K3      K4      K5
K1  [  1.000   3.000   5.000   7.000   3.000 ]
K2  [  0.333   1.000   3.000   5.000   3.000 ]
K3  [  0.200   0.333   1.000   3.000   1.000 ]
K4  [  0.143   0.200   0.333   1.000   0.333 ]
K5  [  0.333   0.333   1.000   3.000   1.000 ]
---------------------------------------------------
SUM    2.009   4.866   10.333  19.000   8.333
```

#### Step 3: Normalize Matrix

```
Normalisasi (bagi setiap elemen dengan SUM kolom):
        K1      K2      K3      K4      K5      AVG (Bobot)
K1  [  0.498   0.617   0.484   0.368   0.360 ] → 0.465
K2  [  0.166   0.206   0.290   0.263   0.360 ] → 0.257
K3  [  0.100   0.068   0.097   0.158   0.120 ] → 0.109
K4  [  0.071   0.041   0.032   0.053   0.040 ] → 0.047
K5  [  0.166   0.068   0.097   0.158   0.120 ] → 0.122
```

#### Step 4: Calculate Bobot Kriteria

```
HASIL BOBOT KRITERIA:
┌──────────────────────┬────────┬────────┐
│ Kriteria             │ Bobot  │   %    │
├──────────────────────┼────────┼────────┤
│ K1: Pemrograman Web  │ 0.465  │ 46.5%  │
│ K2: Database         │ 0.257  │ 25.7%  │
│ K3: Mobile Dev       │ 0.109  │ 10.9%  │
│ K4: Data Science     │ 0.047  │  4.7%  │
│ K5: UI/UX Design     │ 0.122  │ 12.2%  │
└──────────────────────┴────────┴────────┘
TOTAL = 1.000 (100%)
```

#### Step 5: Consistency Check

```
Hitung λmax (lambda max):
λmax = Σ (column_sum × weight)
     = (2.009 × 0.465) + (4.866 × 0.257) + ... 
     = 5.234

Hitung CI (Consistency Index):
CI = (λmax - n) / (n - 1)
   = (5.234 - 5) / (5 - 1)
   = 0.0585

Hitung CR (Consistency Ratio):
RI (Random Index untuk n=5) = 1.12
CR = CI / RI
   = 0.0585 / 1.12
   = 0.052

✅ CR = 0.052 < 0.1 → KONSISTEN!
```

### 2.2 Pairwise Comparison Alternatif

**Admin → Pairwise Comparison → Alternatif**

#### Proses untuk Setiap Kriteria

```
KRITERIA K1: Pemrograman Web
─────────────────────────────────────────

Pilih Kriteria: K1
  ↓
Input perbandingan semua pasangan alternatif:
  
  T1 vs T2 → 5 (Web lebih penting dari Mobile untuk Prog Web)
  T1 vs T3 → 3
  T1 vs T4 → 7
  T1 vs T5 → 5
  T1 vs T6 → 3
  T2 vs T3 → 1
  ...dst (total 15 perbandingan untuk 6 alternatif)
  
  ↓
Build matrix 6x6
  ↓
Normalize
  ↓
Calculate priority vector

HASIL BOBOT ALTERNATIF untuk K1:
┌──────────────────────┬────────┐
│ Alternatif           │ Bobot  │
├──────────────────────┼────────┤
│ T1: Web Development  │ 0.350  │
│ T2: Mobile Dev       │ 0.080  │
│ T3: Data Science     │ 0.150  │
│ T4: UI/UX Design     │ 0.050  │
│ T5: IoT Development  │ 0.120  │
│ T6: Game Development │ 0.250  │
└──────────────────────┴────────┘

* Ulangi untuk K2, K3, K4, K5
```

#### Summary Matrix Bobot Alternatif

```
Bobot Alternatif per Kriteria:
┌────────────┬──────┬──────┬──────┬──────┬──────┐
│ Alternatif │  K1  │  K2  │  K3  │  K4  │  K5  │
├────────────┼──────┼──────┼──────┼──────┼──────┤
│ T1: Web    │ 0.35 │ 0.30 │ 0.10 │ 0.15 │ 0.20 │
│ T2: Mobile │ 0.08 │ 0.05 │ 0.40 │ 0.10 │ 0.05 │
│ T3: Data   │ 0.15 │ 0.25 │ 0.05 │ 0.45 │ 0.10 │
│ T4: UI/UX  │ 0.05 │ 0.05 │ 0.05 │ 0.05 │ 0.50 │
│ T5: IoT    │ 0.12 │ 0.15 │ 0.25 │ 0.15 │ 0.10 │
│ T6: Game   │ 0.25 │ 0.20 │ 0.15 │ 0.10 │ 0.05 │
└────────────┴──────┴──────┴──────┴──────┴──────┘
```

---

## 📝 FASE 3: INPUT NILAI MAHASISWA

**Admin atau Mahasiswa → Input Nilai**

```
Contoh Nilai Mahasiswa (NIM: 2001010001):
┌─────────────────────────┬──────────────────┬───────┬───────┐
│ Mata Kuliah             │ Kriteria         │ Nilai │ Grade │
├─────────────────────────┼──────────────────┼───────┼───────┤
│ Pemrograman Web         │ K1               │ 85    │ A     │
│ Web Lanjut              │ K1               │ 78    │ B+    │
│ Database                │ K2               │ 90    │ A     │
│ Basis Data Lanjut       │ K2               │ 82    │ A-    │
│ Mobile Programming      │ K3               │ 75    │ B     │
│ Data Mining             │ K4               │ 70    │ B     │
│ Machine Learning        │ K4               │ 68    │ B-    │
│ Desain Grafis           │ K5               │ 88    │ A     │
│ Interaksi Manusia Komp  │ K5               │ 80    │ A-    │
└─────────────────────────┴──────────────────┴───────┴───────┘
```

---

## 🧮 FASE 4: PERHITUNGAN REKOMENDASI

**Mahasiswa → Dashboard → Hitung Rekomendasi**

### Step 1: Agregasi Nilai per Kriteria

```
Nilai Mahasiswa per Kriteria (rata-rata):
┌──────────────────────┬───────────────┬──────────────┐
│ Kriteria             │ Mata Kuliah   │ Rata-rata    │
├──────────────────────┼───────────────┼──────────────┤
│ K1: Pemrograman Web  │ 85, 78        │ 81.5         │
│ K2: Database         │ 90, 82        │ 86.0         │
│ K3: Mobile Dev       │ 75            │ 75.0         │
│ K4: Data Science     │ 70, 68        │ 69.0         │
│ K5: UI/UX Design     │ 88, 80        │ 84.0         │
└──────────────────────┴───────────────┴──────────────┘
```

### Step 2: Normalisasi Nilai (0-1 scale)

```
Normalized = (Nilai - Min) / (Max - Min)
Atau jika semua benefit: Nilai / 100

Nilai Normalized:
┌──────────────────────┬──────────┬─────────────┐
│ Kriteria             │ Nilai    │ Normalized  │
├──────────────────────┼──────────┼─────────────┤
│ K1: Pemrograman Web  │ 81.5     │ 0.815       │
│ K2: Database         │ 86.0     │ 0.860       │
│ K3: Mobile Dev       │ 75.0     │ 0.750       │
│ K4: Data Science     │ 69.0     │ 0.690       │
│ K5: UI/UX Design     │ 84.0     │ 0.840       │
└──────────────────────┴──────────┴─────────────┘
```

### Step 3: Hitung Score untuk Setiap Alternatif

```
Formula:
Score(Alternatif_i) = Σ (Bobot_Kriteria_j × Nilai_Normalized_j × Bobot_Alternatif_ij)

Untuk T1 (Web Development):
Score = (0.465 × 0.815 × 0.35) +  [K1]
        (0.257 × 0.860 × 0.30) +  [K2]
        (0.109 × 0.750 × 0.10) +  [K3]
        (0.047 × 0.690 × 0.15) +  [K4]
        (0.122 × 0.840 × 0.20)    [K5]
        
Score = 0.1327 + 0.0663 + 0.0082 + 0.0049 + 0.0205
      = 0.2326

Detail Perhitungan Semua Alternatif:
┌────────────┬────────┬────────┬────────┬────────┬────────┬─────────┐
│ Alternatif │  K1    │  K2    │  K3    │  K4    │  K5    │  TOTAL  │
├────────────┼────────┼────────┼────────┼────────┼────────┼─────────┤
│ T1: Web    │ 0.1327 │ 0.0663 │ 0.0082 │ 0.0049 │ 0.0205 │ 0.2326  │
│ T2: Mobile │ 0.0303 │ 0.0110 │ 0.0327 │ 0.0032 │ 0.0051 │ 0.0823  │
│ T3: Data   │ 0.0568 │ 0.0553 │ 0.0041 │ 0.0146 │ 0.0103 │ 0.1411  │
│ T4: UI/UX  │ 0.0189 │ 0.0110 │ 0.0041 │ 0.0016 │ 0.0513 │ 0.0869  │
│ T5: IoT    │ 0.0454 │ 0.0332 │ 0.0204 │ 0.0049 │ 0.0103 │ 0.1142  │
│ T6: Game   │ 0.0946 │ 0.0442 │ 0.0122 │ 0.0032 │ 0.0051 │ 0.1593  │
└────────────┴────────┴────────┴────────┴────────┴────────┴─────────┘
```

### Step 4: Ranking Alternatif

```
Urutkan berdasarkan Total Score (descending):
┌──────┬─────────────────────┬─────────┬─────────┬─────────┐
│ Rank │ Tema PKL            │  Score  │  Score% │ Status  │
├──────┼─────────────────────┼─────────┼─────────┼─────────┤
│  1   │ Web Development     │ 0.2326  │ 23.26%  │ ⭐⭐⭐   │
│  2   │ Game Development    │ 0.1593  │ 15.93%  │ ⭐⭐     │
│  3   │ Data Science        │ 0.1411  │ 14.11%  │ ⭐       │
│  4   │ IoT Development     │ 0.1142  │ 11.42%  │         │
│  5   │ UI/UX Design        │ 0.0869  │  8.69%  │         │
│  6   │ Mobile Development  │ 0.0823  │  8.23%  │         │
└──────┴─────────────────────┴─────────┴─────────┴─────────┘

✅ TOP 3 REKOMENDASI:
1. Web Development (23.26%)
2. Game Development (15.93%)
3. Data Science (14.11%)
```

### Step 5: Save ke Database

```sql
INSERT INTO hasil_rekomendasi 
(mahasiswa_id, alternatif_id, total_score, ranking, detail_score, created_at)
VALUES
(1, 1, 0.2326, 1, '{"K1":0.1327,"K2":0.0663,...}', NOW()),
(1, 6, 0.1593, 2, '{"K1":0.0946,"K2":0.0442,...}', NOW()),
(1, 3, 0.1411, 3, '{"K1":0.0568,"K2":0.0553,...}', NOW()),
...
```

---

## 📊 OUTPUT VISUALISASI

### Dashboard Mahasiswa

```
┌─────────────────────────────────────────────────────┐
│           HASIL REKOMENDASI TEMA PKL                │
├─────────────────────────────────────────────────────┤
│                                                     │
│  🏆 RANKING #1: WEB DEVELOPMENT                     │
│  ━━━━━━━━━━━━━━━━━━━━━━━━━ 23.26%                   │
│                                                     │
│  Detail Score per Kriteria:                        │
│  • Pemrograman Web:  ████████████░░░ 13.27%        │
│  • Database:         ██████░░░░░░░░░  6.63%        │
│  • Mobile Dev:       █░░░░░░░░░░░░░░  0.82%        │
│  • Data Science:     ░░░░░░░░░░░░░░░  0.49%        │
│  • UI/UX Design:     ██░░░░░░░░░░░░░  2.05%        │
│                                                     │
├─────────────────────────────────────────────────────┤
│  🥈 RANKING #2: GAME DEVELOPMENT                    │
│  ━━━━━━━━━━━━━━━ 15.93%                             │
├─────────────────────────────────────────────────────┤
│  🥉 RANKING #3: DATA SCIENCE                        │
│  ━━━━━━━━━━━━━ 14.11%                               │
└─────────────────────────────────────────────────────┘
```

### Consistency Ratio Display

```
┌─────────────────────────────────────┐
│  UJI KONSISTENSI AHP                │
├─────────────────────────────────────┤
│  λmax = 5.234                       │
│  CI   = 0.0585                      │
│  CR   = 0.052                       │
│                                     │
│  Status: ✅ KONSISTEN               │
│  (CR < 0.1)                         │
└─────────────────────────────────────┘
```

---

## 🔄 ALUR PENGGUNAAN APLIKASI

### Untuk Admin

```
1. Login → admin/dashboard
   ↓
2. Setup Master Data:
   • Kriteria → admin/kriteria
   • Alternatif → admin/alternatif
   • Mata Kuliah → admin/matakuliah
   ↓
3. Input Perbandingan Berpasangan:
   • Pairwise Kriteria → admin/pairwiseKriteria
     → Input semua pasangan (10 perbandingan untuk 5 kriteria)
     → Auto-calculate bobot
     → Check CR
   • Pairwise Alternatif → admin/pairwiseAlternatif
     → Pilih kriteria
     → Input perbandingan (15 perbandingan untuk 6 alternatif)
     → Ulangi untuk semua kriteria (5x)
   ↓
4. Kelola User & Mahasiswa:
   • Tambah user mahasiswa → admin/addUser
   • Input nilai mahasiswa → admin/mahasiswa
   ↓
5. Monitoring:
   • Visualisasi AHP → admin/visualisasi
   • Laporan → admin/laporan
```

### Untuk Dosen

```
1. Login → dosen/dashboard
   ↓
2. Monitoring Mahasiswa:
   • List mahasiswa → dosen/mahasiswa
   • Detail mahasiswa → dosen/detailMahasiswa/{id}
   ↓
3. Lihat Laporan:
   • Laporan rekomendasi → dosen/laporan
   • Visualisasi AHP → dosen/visualisasi
```

### Untuk Mahasiswa

```
1. Login → mahasiswa/dashboard
   ↓
2. Lihat/Edit Profil:
   • Profil → mahasiswa/profil
   • Update data → mahasiswa/updateProfil
   ↓
3. Lihat Nilai:
   • Nilai mata kuliah → mahasiswa/nilai
   ↓
4. Hitung Rekomendasi:
   • Dashboard → Klik "Hitung Rekomendasi"
   • Sistem proses AHP
   • Lihat hasil top 3
   ↓
5. Lihat Riwayat:
   • Riwayat perhitungan → mahasiswa/riwayat
```

---

## 💡 TIPS & BEST PRACTICES

### Untuk Admin

1. **Setup Awal:**
   - Input kriteria sesuai kompetensi program studi
   - Pastikan alternatif tema relevan dengan kebutuhan industri
   - Mapping mata kuliah ke kriteria dengan tepat

2. **Pairwise Comparison:**
   - Konsisten dalam memberikan penilaian
   - Jika CR > 0.1, review ulang perbandingan
   - Diskusikan dengan tim/dosen untuk objektifitas

3. **Maintenance:**
   - Update bobot secara berkala (per semester/tahun)
   - Review relevansi tema dengan perkembangan teknologi
   - Backup database secara rutin

### Untuk Mahasiswa

1. **Nilai Akademik:**
   - Pastikan nilai sudah lengkap sebelum hitung rekomendasi
   - Fokus pada mata kuliah yang terkait dengan minat

2. **Interpretasi Hasil:**
   - Perhatikan detail score per kriteria
   - Pertimbangkan ranking 2 & 3 sebagai alternatif
   - Konsultasikan dengan dosen pembimbing

---

**End of Document**

*Dokumentasi ini merupakan panduan lengkap alur kerja metode AHP dalam aplikasi SPK Pemilihan Tema PKL.*
