# 🔒 FITUR BOBOT KRITERIA TETAP (Fixed Weights)

## 📋 Daftar Isi
1. [Overview](#overview)
2. [Konfigurasi](#konfigurasi)
3. [Cara Kerja](#cara-kerja)
4. [Implementasi Teknis](#implementasi-teknis)
5. [Panduan Penggunaan](#panduan-penggunaan)
6. [FAQ](#faq)

---

## 🎯 Overview

### Apa itu Bobot Tetap?

Bobot Tetap (Fixed Weights) adalah fitur yang memungkinkan sistem menggunakan bobot kriteria yang sudah ditentukan secara eksplisit, menggantikan perhitungan dinamis menggunakan pairwise comparison.

### Mengapa Menggunakan Bobot Tetap?

✅ **Konsistensi**: Bobot tidak berubah-ubah setiap kali admin melakukan pairwise comparison  
✅ **Kontrol Penuh**: Admin/stakeholder dapat menentukan prioritas kriteria dengan tepat  
✅ **Efisiensi**: Tidak perlu input pairwise comparison kriteria berulang kali  
✅ **Transparansi**: Bobot jelas dan dapat diprediksi  
✅ **Zero Inconsistency**: CR (Consistency Ratio) = 0, karena tidak ada perbandingan subjektif

### Kapan Menggunakan Mode Ini?

- ✅ Ketika stakeholder sudah memiliki prioritas kriteria yang jelas
- ✅ Ketika ingin konsistensi hasil rekomendasi
- ✅ Ketika kriteria sudah melalui proses konsensus
- ✅ Untuk sistem production yang stabil

---

## ⚙️ Konfigurasi

### File Konfigurasi

**Lokasi:** `config/ahp_settings.php`

```php
<?php
return [
    // Aktifkan/nonaktifkan mode bobot tetap
    'enforce_fixed_weights' => true, // true = aktif, false = gunakan pairwise
    
    // Definisi skor untuk setiap kriteria
    // Format: 'nama_kriteria' => skor (1-10)
    'fixed_kriteria' => [
        'nilai mahasiswa' => 5,      // Skor: 5
        'keunikan' => 9,              // Skor: 9 (Prioritas tertinggi)
        'minat&bakat' => 8,           // Skor: 8
        'minat' => 8,                 // Alias untuk minat&bakat
        'waktu pengerjaan' => 5,      // Skor: 5
        'referensi terbaru' => 7,     // Skor: 7
        'ketersediaan dosen' => 7     // Skor: 7
    ]
];
```

### Parameter Konfigurasi

#### `enforce_fixed_weights`
- **Type:** `boolean`
- **Default:** `true`
- **Deskripsi:** Flag untuk mengaktifkan/menonaktifkan mode bobot tetap
- **Values:**
  - `true`: Gunakan bobot tetap dari config
  - `false`: Gunakan pairwise comparison (mode dynamic)

#### `fixed_kriteria`
- **Type:** `array`
- **Format:** `['nama_kriteria' => skor]`
- **Deskripsi:** Mapping nama kriteria ke skor numerik
- **Range Skor:** 1-10 (semakin tinggi = semakin penting)

---

## 🔧 Cara Kerja

### Alur Proses

```
1. Load config/ahp_settings.php
        ↓
2. Cek enforce_fixed_weights
        ↓
   [TRUE]                    [FALSE]
        ↓                         ↓
3a. Load fixed_kriteria    3b. Load pairwise comparison
        ↓                         ↓
4a. Match nama kriteria    4b. Build comparison matrix
    dari database                 ↓
        ↓                    5b. Process AHP
5a. Normalisasi skor            ↓
    (sum = 1.0)            6b. Calculate weights
        ↓                         ↓
6a. Set CR = 0            7b. Check CR < 0.1
        ↓                         ↓
        └─────────────────────────┘
                    ↓
7. Update database kriteria.bobot
                    ↓
8. Gunakan bobot untuk perhitungan rekomendasi
```

### Perhitungan Bobot

#### Input (Skor Mentah):
```
Nilai Mahasiswa    : 5
Keunikan           : 9
Minat & Bakat      : 8
Waktu Pengerjaan   : 5
Referensi Terbaru  : 7
Ketersediaan Dosen : 7
─────────────────────
Total              : 41
```

#### Normalisasi:
```php
Bobot = Skor / Total Skor

Nilai Mahasiswa    : 5/41  = 0.121951 (12.2%)
Keunikan           : 9/41  = 0.219512 (22.0%) ← Tertinggi
Minat & Bakat      : 8/41  = 0.195122 (19.5%)
Waktu Pengerjaan   : 5/41  = 0.121951 (12.2%)
Referensi Terbaru  : 7/41  = 0.170732 (17.1%)
Ketersediaan Dosen : 7/41  = 0.170732 (17.1%)
──────────────────────────────────────
Total              : 1.000000 (100%) ✓
```

### Name Matching

Sistem menggunakan **fuzzy matching** untuk mencocokkan nama kriteria:

1. **Exact Match** (case-insensitive):
   ```
   Database: "Nilai Mahasiswa"
   Config  : "nilai mahasiswa"
   ✓ Match!
   ```

2. **Partial Match**:
   ```
   Database: "Minat dan Bakat Mahasiswa"
   Config  : "minat"
   ✓ Match!
   ```

3. **Alias Support**:
   ```
   Database: "Minat & Bakat"
   Config  : ["minat&bakat" => 8, "minat" => 8]
   ✓ Match! (menggunakan salah satu)
   ```

4. **Default Score**:
   ```
   Database: "Kriteria Baru"
   Config  : (tidak ada)
   → Default score = 5
   ```

---

## 💻 Implementasi Teknis

### 1. File Controller: `app/controllers/Mahasiswa.php`

**Method:** `prosesRekomendasi()`

```php
public function prosesRekomendasi() {
    // Load config
    $ahp_settings = require ROOT_PATH . '/config/ahp_settings.php';
    
    // Cek mode bobot tetap
    if (!empty($ahp_settings['enforce_fixed_weights'])) {
        // === MODE BOBOT TETAP ===
        
        // Load skor dari config
        $fixedScores = $ahp_settings['fixed_kriteria'];
        $scoreMap = [];
        
        // Match nama kriteria
        foreach ($kriteria as $k) {
            $name = strtolower($k['nama_kriteria']);
            $matched = false;
            
            // Exact match first
            foreach ($fixedScores as $configName => $score) {
                if (strtolower($configName) === $name) {
                    $scoreMap[$k['id']] = $score;
                    $matched = true;
                    break;
                }
            }
            
            // Partial match
            if (!$matched) {
                foreach ($fixedScores as $configName => $score) {
                    if (strpos($name, strtolower($configName)) !== false || 
                        strpos(strtolower($configName), $name) !== false) {
                        $scoreMap[$k['id']] = $score;
                        $matched = true;
                        break;
                    }
                }
            }
            
            // Default score
            if (!$matched) {
                $scoreMap[$k['id']] = 5;
            }
        }
        
        // Normalisasi ke bobot
        $totalScore = array_sum($scoreMap);
        foreach ($kriteria as $k) {
            $criteriaWeights[$k['id']] = $scoreMap[$k['id']] / $totalScore;
        }
        
        // Set CR = 0 (konsisten sempurna)
        $consistency_ratio = 0;
        
    } else {
        // === MODE PAIRWISE COMPARISON ===
        // ... (kode pairwise original)
    }
    
    // Lanjutkan perhitungan rekomendasi dengan $criteriaWeights
    // ...
}
```

### 2. File Controller: `app/controllers/Admin.php`

**Method:** `pairwiseKriteria()`

```php
public function pairwiseKriteria() {
    // Load config
    $ahp_settings = require ROOT_PATH . '/config/ahp_settings.php';
    $fixed_weights_enabled = !empty($ahp_settings['enforce_fixed_weights']);
    
    if ($fixed_weights_enabled) {
        // Gunakan bobot tetap
        // Sama seperti Mahasiswa controller
        // Update database dengan bobot tetap
    } else {
        // Gunakan pairwise comparison
        // Kode AHP original
    }
}
```

### 3. File View: `app/views/admin/kriteria/index.php`

```php
<?php
// Load config
$ahp_settings = require ROOT_PATH . '/config/ahp_settings.php';
$fixed_weights_enabled = !empty($ahp_settings['enforce_fixed_weights']);
?>

<!-- Alert Notice -->
<?php if ($fixed_weights_enabled): ?>
<div class="alert alert-info">
    <strong>Mode Bobot Tetap Aktif!</strong>
    Bobot kriteria dihitung berdasarkan nilai tetap yang telah ditetapkan.
    <!-- List skor dari config -->
</div>
<?php endif; ?>

<!-- Tabel Kriteria -->
<td>
    <?= number_format($k['bobot'], 6) ?>
    <?php if ($fixed_weights_enabled): ?>
    <span class="badge bg-warning text-dark ms-1">
        <i class="bi bi-lock-fill"></i> TETAP
    </span>
    <?php endif; ?>
</td>
```

### 4. File View: `app/views/admin/pairwise/kriteria.php`

```php
<?php
$ahp_settings = require ROOT_PATH . '/config/ahp_settings.php';
$fixed_weights_enabled = !empty($ahp_settings['enforce_fixed_weights']);
?>

<!-- Warning Alert -->
<?php if ($fixed_weights_enabled): ?>
<div class="alert alert-warning">
    <h5>Mode Bobot Tetap Aktif</h5>
    <p>Pairwise comparison tidak akan mengubah bobot kriteria.</p>
    <small>
        Untuk menggunakan pairwise, ubah <code>enforce_fixed_weights</code> 
        menjadi <code>false</code> di <code>config/ahp_settings.php</code>
    </small>
</div>
<?php endif; ?>
```

### 5. CLI Script: `scripts/apply_fixed_weights.php`

Script untuk update database secara langsung:

```php
<?php
// Load config
$ahp_settings = require __DIR__ . '/../config/ahp_settings.php';

// Connect database
$db = new PDO($dsn, $user, $pass);

// Get kriteria
$stmt = $db->query("SELECT id, nama_kriteria FROM kriteria WHERE is_active = 1");
$kriteria = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Match dan normalize
$scoreMap = [];
// ... (fuzzy matching logic)

$totalScore = array_sum($scoreMap);

// Update database
foreach ($kriteria as $k) {
    $weight = $scoreMap[$k['id']] / $totalScore;
    $update = $db->prepare("UPDATE kriteria SET bobot = ? WHERE id = ?");
    $update->execute([$weight, $k['id']]);
    echo "✓ {$k['nama_kriteria']}: $weight\n";
}

echo "\n✅ Bobot berhasil diupdate!\n";
```

**Cara Jalankan:**
```bash
php scripts/apply_fixed_weights.php
```

---

## 📖 Panduan Penggunaan

### Aktivasi Bobot Tetap

1. **Edit Config File**
   ```bash
   nano config/ahp_settings.php
   ```

2. **Set Flag ke True**
   ```php
   'enforce_fixed_weights' => true,
   ```

3. **Definisikan Skor Kriteria**
   ```php
   'fixed_kriteria' => [
       'nilai mahasiswa' => 5,
       'keunikan' => 9,
       // ... dst
   ],
   ```

4. **Update Database** (Optional - otomatis saat diakses)
   ```bash
   php scripts/apply_fixed_weights.php
   ```

5. **Verifikasi**
   - Buka halaman Admin → Data Kriteria
   - Lihat badge "TETAP" pada kolom bobot
   - Lihat alert info di bagian atas

### Modifikasi Bobot

1. **Edit Skor di Config**
   ```php
   'fixed_kriteria' => [
       'keunikan' => 10, // Ubah dari 9 ke 10
       // ...
   ],
   ```

2. **Sistem Otomatis Update**
   - Controller akan mendeteksi perubahan
   - Bobot dinormalisasi ulang
   - Database diupdate saat diakses

3. **Force Update (Optional)**
   ```bash
   php scripts/apply_fixed_weights.php
   ```

### Tambah Kriteria Baru

1. **Tambah lewat Admin Panel**
   - Admin → Data Kriteria → Tambah Kriteria

2. **Update Config**
   ```php
   'fixed_kriteria' => [
       // ... kriteria lama
       'kriteria baru' => 6, // Tambah baris ini
   ],
   ```

3. **Recalculate**
   - Akses halaman pairwise kriteria atau
   - Jalankan script: `php scripts/apply_fixed_weights.php`

### Nonaktifkan Bobot Tetap

1. **Edit Config**
   ```php
   'enforce_fixed_weights' => false, // Ubah ke false
   ```

2. **Sistem Kembali ke Pairwise**
   - Admin → Pairwise Kriteria
   - Input perbandingan berpasangan
   - Sistem hitung bobot dengan AHP

---

## ❓ FAQ

### Q: Apakah pairwise comparison masih berfungsi?
**A:** Ya, tetap bisa diakses untuk alternatif. Pairwise kriteria hanya tidak akan mengubah bobot ketika mode fixed aktif.

### Q: Bagaimana jika nama kriteria di database tidak match dengan config?
**A:** Sistem menggunakan default score = 5 untuk kriteria yang tidak match.

### Q: Apakah bisa menggunakan skor desimal?
**A:** Ya, bisa. Contoh: `'keunikan' => 9.5`

### Q: Range skor yang direkomendasikan?
**A:** 1-10. Hindari perbedaan terlalu ekstrim (misal: 1 vs 10) agar bobot tidak terlalu dominan.

### Q: Apakah perlu restart server setelah ubah config?
**A:** Tidak perlu. Config di-load setiap kali request.

### Q: Bagaimana cara melihat bobot saat ini?
**A:** Admin → Data Kriteria. Lihat kolom "Bobot" dengan badge "TETAP".

### Q: Apakah data pairwise yang lama hilang?
**A:** Tidak. Data pairwise tetap tersimpan di database, hanya tidak digunakan saat mode fixed aktif.

### Q: Consistency Ratio (CR) nya berapa?
**A:** Selalu 0 (nol) dalam mode fixed weights, karena tidak ada perbandingan subjektif.

### Q: Bisa kombinasi fixed dan dynamic?
**A:** Tidak. Harus pilih salah satu mode untuk semua kriteria.

### Q: Bagaimana backup config?
**A:** Copy file `config/ahp_settings.php` ke lokasi aman. Atau commit ke git repository.

---

## 🎯 Best Practices

### 1. Penentuan Skor
- ✅ Libatkan stakeholder dalam menentukan skor
- ✅ Dokumentasikan alasan di balik setiap skor
- ✅ Review berkala (misal: setiap semester)
- ✅ Hindari skor terlalu ekstrim kecuali ada alasan kuat

### 2. Naming Convention
- ✅ Gunakan nama yang sama dengan database (case-insensitive)
- ✅ Tambahkan alias untuk variasi nama
- ✅ Dokumentasikan mapping di comment

### 3. Maintenance
- ✅ Backup config file sebelum edit
- ✅ Test perubahan di environment development dulu
- ✅ Monitor hasil rekomendasi setelah perubahan bobot
- ✅ Version control config file dengan git

### 4. Documentation
- ✅ Update dokumentasi saat ubah bobot
- ✅ Catat tanggal dan alasan perubahan
- ✅ Komunikasikan ke pengguna sistem

---

## 📝 Changelog

### v1.0 - 2024
- ✅ Fitur bobot tetap initial release
- ✅ Support fuzzy name matching
- ✅ UI indicators (badge, alert)
- ✅ CLI script untuk update database
- ✅ Backward compatible dengan mode pairwise
- ✅ Dokumentasi lengkap

---

## 🔗 Related Files

- **Config:** `config/ahp_settings.php`
- **Controllers:** 
  - `app/controllers/Mahasiswa.php` (prosesRekomendasi)
  - `app/controllers/Admin.php` (pairwiseKriteria)
- **Views:**
  - `app/views/admin/kriteria/index.php`
  - `app/views/admin/pairwise/kriteria.php`
- **Scripts:** `scripts/apply_fixed_weights.php`
- **Documentation:** 
  - `DOKUMENTASI_LENGKAP.md`
  - `FEATURE_CARA_KERJA_AHP.md`

---

## 📞 Support

Jika ada pertanyaan atau issue terkait fitur ini:
1. Cek dokumentasi ini terlebih dahulu
2. Review kode di file-file terkait
3. Test di environment development
4. Contact: admin@spkahp.app

---

**© 2024 SPK AHP - Sistem Pendukung Keputusan dengan Analytical Hierarchy Process**
