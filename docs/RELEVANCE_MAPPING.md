# Relevance Mapping - AHP Algorithm

## Konsep

Relevance Mapping adalah pendekatan yang digunakan ketika tidak ada data **pairwise comparison** untuk alternatif. Sistem menggunakan **bobot relevansi** antara setiap kriteria dengan setiap alternatif tema.

## Struktur Data

### Kriteria (5 items)
1. **Kemampuan Pemrograman** (id: 1)
2. **Kemampuan Multimedia** (id: 2)  
3. **Kemampuan Jaringan** (id: 3)
4. **Kemampuan Kependidikan** (id: 4)
5. **Minat dan Motivasi** (id: 5)

### Alternatif Tema (4 items)
1. **Kependidikan** (id: 1)
2. **Pemrograman** (id: 2)
3. **Desain Media / Multimedia** (id: 3)
4. **Jaringan Komputer** (id: 4)

## Mapping Matrix

```php
$relevanceMap = [
    // [kriteria_id] => [alternatif_id => bobot_relevansi]
    
    1 => [2 => 1.0, 1 => 0.3, 3 => 0.5, 4 => 0.2], // Kemampuan Pemrograman
    2 => [3 => 1.0, 2 => 0.4, 1 => 0.2, 4 => 0.1], // Kemampuan Multimedia
    3 => [4 => 1.0, 2 => 0.5, 3 => 0.3, 1 => 0.1], // Kemampuan Jaringan
    4 => [1 => 1.0, 3 => 0.4, 2 => 0.2, 4 => 0.3], // Kemampuan Kependidikan
    5 => [1 => 0.25, 2 => 0.25, 3 => 0.25, 4 => 0.25] // Minat (equal)
];
```

## Penjelasan Detail

### 1. Kemampuan Pemrograman → Alternatif
| Alternatif | Bobot | Alasan |
|------------|-------|--------|
| Pemrograman | **1.0** | Sangat relevan - kriteria utama |
| Multimedia | **0.5** | Relevansi sedang - perlu coding untuk multimedia |
| Kependidikan | **0.3** | Relevansi rendah - butuh coding untuk e-learning |
| Jaringan | **0.2** | Relevansi kecil - scripting untuk jaringan |

### 2. Kemampuan Multimedia → Alternatif
| Alternatif | Bobot | Alasan |
|------------|-------|--------|
| Multimedia | **1.0** | Sangat relevan - kriteria utama |
| Pemrograman | **0.4** | Relevansi sedang - UI/UX design |
| Kependidikan | **0.2** | Relevansi rendah - media pembelajaran |
| Jaringan | **0.1** | Relevansi sangat kecil |

### 3. Kemampuan Jaringan → Alternatif
| Alternatif | Bobot | Alasan |
|------------|-------|--------|
| Jaringan | **1.0** | Sangat relevan - kriteria utama |
| Pemrograman | **0.5** | Relevansi sedang - web server, API |
| Multimedia | **0.3** | Relevansi rendah - streaming media |
| Kependidikan | **0.1** | Relevansi sangat kecil |

### 4. Kemampuan Kependidikan → Alternatif
| Alternatif | Bobot | Alasan |
|------------|-------|--------|
| Kependidikan | **1.0** | Sangat relevan - kriteria utama |
| Multimedia | **0.4** | Relevansi sedang - media pembelajaran |
| Jaringan | **0.3** | Relevansi rendah - e-learning infrastructure |
| Pemrograman | **0.2** | Relevansi rendah - learning management system |

### 5. Minat dan Motivasi → Alternatif
| Alternatif | Bobot | Alasan |
|------------|-------|--------|
| Semua | **0.25** | Equal distribution - minat subjektif |

## Formula Perhitungan

```php
// 1. Normalisasi nilai mahasiswa (0-1)
$nilai_normalized = $nilai_kriteria / 100;

// 2. Get relevance weight dari mapping
$relevance = $relevanceMap[$kriteria_id][$alt_id];

// 3. Hitung skor = nilai × relevansi × bobot kriteria
$alternativeScores[$alt_id] += $nilai_normalized * $relevance * $criteriaWeights[$kriteria_id];
```

## Contoh Kasus

### Mahasiswa A dengan nilai:
- Kemampuan Pemrograman: **85**
- Kemampuan Multimedia: **70**
- Kemampuan Jaringan: **60**
- Kemampuan Kependidikan: **75**
- Minat: **80**

### Asumsi bobot kriteria sama (1/5 = 0.2 untuk setiap kriteria)

### Perhitungan untuk Tema **Pemrograman** (alt_id = 2):

```
Dari Kriteria 1 (Kemampuan Pemrograman):
0.85 × 1.0 × 0.2 = 0.170

Dari Kriteria 2 (Kemampuan Multimedia):
0.70 × 0.4 × 0.2 = 0.056

Dari Kriteria 3 (Kemampuan Jaringan):
0.60 × 0.5 × 0.2 = 0.060

Dari Kriteria 4 (Kemampuan Kependidikan):
0.75 × 0.2 × 0.2 = 0.030

Dari Kriteria 5 (Minat):
0.80 × 0.25 × 0.2 = 0.040

TOTAL SKOR PEMROGRAMAN = 0.356
```

### Perhitungan untuk Tema **Kependidikan** (alt_id = 1):

```
Dari Kriteria 1 (Kemampuan Pemrograman):
0.85 × 0.3 × 0.2 = 0.051

Dari Kriteria 2 (Kemampuan Multimedia):
0.70 × 0.2 × 0.2 = 0.028

Dari Kriteria 3 (Kemampuan Jaringan):
0.60 × 0.1 × 0.2 = 0.012

Dari Kriteria 4 (Kemampuan Kependidikan):
0.75 × 1.0 × 0.2 = 0.150

Dari Kriteria 5 (Minat):
0.80 × 0.25 × 0.2 = 0.040

TOTAL SKOR KEPENDIDIKAN = 0.281
```

**Hasil:** Tema Pemrograman (0.356) > Tema Kependidikan (0.281) ✅

## Keuntungan Pendekatan Ini

1. ✅ **Tidak perlu data pairwise alternatif** - sistem tetap bisa beroperasi
2. ✅ **Skor berbeda untuk setiap alternatif** - berdasarkan nilai aktual mahasiswa
3. ✅ **Interpretable** - mudah dipahami dan dijelaskan
4. ✅ **Adjustable** - bobot relevansi bisa disesuaikan oleh admin
5. ✅ **Konsisten** - mengikuti logika domain knowledge

## Limitasi

1. ⚠️ **Subjektif** - bobot relevansi ditentukan secara manual
2. ⚠️ **Tidak menggunakan pairwise comparison penuh** - bukan AHP murni
3. ⚠️ **Fixed weights** - tidak dinamis berdasarkan perbandingan

## Upgrade Path

Untuk perhitungan AHP yang lebih akurat, admin harus:

1. **Populate tabel `pairwise_kriteria`** - untuk bobot kriteria yang lebih objektif
2. **Populate tabel `pairwise_alternatif`** - untuk bobot alternatif berdasarkan setiap kriteria
3. Sistem akan otomatis switch ke **full AHP calculation** ketika data tersedia

---

**Note:** Relevance mapping adalah **fallback mechanism** yang memastikan sistem tetap memberikan rekomendasi yang bermakna meskipun data pairwise comparison belum tersedia.
