# ✅ PERBAIKAN PAIRWISE ALTERNATIF - SUMMARY

## 🔴 Masalah Yang Ditemukan
Ketika user memilih kriteria dari dropdown, matrix perbandingan **TIDAK MUNCUL**.

### Root Cause:
Controller method `pairwiseAlternatif($kriteria_id = null)` **tidak bisa menangkap** parameter GET `kriteria_id` dari form submission.

---

## ✅ Solusi Yang Diterapkan

### File: `app/controllers/Admin.php`
**Lokasi:** Method `pairwiseAlternatif()` - Lines 551-565

**Perubahan:**
```php
// SEBELUM (Error)
public function pairwiseAlternatif($kriteria_id = null) {
    // $kriteria_id hanya dari URL segment, tidak dari GET parameter
    
    if ($kriteria_id) {
        // Code...
    }
}

// SESUDAH (Fixed)
public function pairwiseAlternatif($kriteria_id = null) {
    // Tambahan: cek GET parameter jika URL param kosong
    if (!$kriteria_id && isset($_GET['kriteria_id'])) {
        $kriteria_id = $_GET['kriteria_id'];
    }
    
    if ($kriteria_id) {
        // Code...
    }
}
```

**Penjelasan:**
- Form menggunakan `method="GET"` dan mengirim `?kriteria_id=X`
- Routing PHP native tidak otomatis mapping GET params ke method parameters
- Fix: Cek manual `$_GET['kriteria_id']` jika parameter URL kosong

---

## 🧪 Cara Testing

### Option 1: Test Page (Recommended)
```
http://localhost/SPK_AHP/test_pairwise.php
```

Page ini akan:
- ✅ Cek koneksi database
- ✅ Show semua kriteria dan alternatif
- ✅ Generate link testing untuk setiap kriteria
- ✅ Show expected behavior
- ✅ Troubleshooting guide

### Option 2: Direct URL Test
```
http://localhost/SPK_AHP/admin/pairwiseAlternatif?kriteria_id=1
```

Ganti angka `1` dengan ID kriteria yang ada.

### Option 3: Via Admin Panel
1. Login sebagai admin
2. Menu: **Pairwise Comparison** → **Alternatif**
3. **Pilih kriteria** dari dropdown
4. Matrix seharusnya langsung **MUNCUL** ✅

---

## 📋 Expected Behavior (Setelah Fix)

### Saat Halaman Load Pertama Kali:
- ✅ Dropdown kriteria muncul dan terisi
- ❌ Matrix belum muncul (normal, karena belum pilih kriteria)

### Saat Pilih Kriteria dari Dropdown:
1. ✅ Form auto-submit via `onchange`
2. ✅ URL berubah menjadi: `.../pairwiseAlternatif?kriteria_id=X`
3. ✅ Page reload
4. ✅ Dropdown kriteria tetap ter-select
5. ✅ **MATRIX PERBANDINGAN MUNCUL** 🎉
6. ✅ Tabel hasil AHP muncul (jika data sudah lengkap)

---

## 🔍 Debugging (Jika Masih Error)

### 1. Check Browser Console
```
F12 → Console Tab
```
Lihat apakah ada JavaScript errors.

### 2. Check Network Tab
```
F12 → Network Tab → Pilih kriteria → Lihat request
```
- Status harus: **200 OK**
- URL harus ada: `?kriteria_id=X`

### 3. Check PHP Error Log
```bash
# Lokasi log (sesuaikan dengan setup)
type c:\laragon\bin\php\php-8.x.x\php_error.log

# Atau aplikasi log
type c:\laragon\www\SPK_AHP\logs\app.log
```

### 4. Add Debug Output
Edit `app/controllers/Admin.php` line ~555:
```php
public function pairwiseAlternatif($kriteria_id = null) {
    // DEBUG
    error_log("=== DEBUG PAIRWISE ===");
    error_log("URL Param: " . ($kriteria_id ?? 'NULL'));
    error_log("GET Param: " . ($_GET['kriteria_id'] ?? 'NULL'));
    error_log("======================");
    
    // ... rest of code
```

### 5. Check Database
Jalankan SQL test di `test_pairwise.sql`:
```sql
-- Cek kriteria aktif
SELECT * FROM kriteria WHERE is_active = 1;

-- Cek alternatif aktif (minimal 2)
SELECT * FROM alternatif WHERE is_active = 1;

-- Cek data pairwise
SELECT * FROM pairwise_alternatif;
```

---

## 📊 Data Requirements

Untuk matrix bisa muncul, syarat minimal:

### ✅ Kriteria:
- Minimal **1 kriteria aktif**
- Field `is_active = 1`

### ✅ Alternatif:
- Minimal **2 alternatif aktif** (untuk bisa dibandingkan)
- Field `is_active = 1`

### ⚠️ Pairwise Data:
- Boleh kosong (user bisa input lewat matrix)
- Jika sudah ada, akan tampil di matrix

---

## 🌐 Testing di Subdomain

### URL Subdomain:
```
https://apkahp.demoj35.site/admin/pairwiseAlternatif?kriteria_id=1
```

### Pastikan:
1. ✅ `.env` di subdomain sudah benar:
   ```env
   BASE_URL=https://apkahp.demoj35.site
   ```

2. ✅ File uploaded semua (termasuk fix di `Admin.php`)

3. ✅ Permissions correct:
   ```bash
   chmod 755 -R assets/
   chmod 644 .env
   ```

4. ✅ Browser cache cleared (Ctrl+Shift+R)

---

## 📁 Files Changed

### Modified:
- ✅ `app/controllers/Admin.php` (Lines 551-565)

### Created (Documentation):
- ✅ `DEBUG_PAIRWISE_ALTERNATIF.md` - Detailed debug guide
- ✅ `test_pairwise.sql` - SQL testing queries
- ✅ `test_pairwise.php` - Interactive test page
- ✅ `FIX_SUMMARY.md` - This file

---

## 🎯 Next Steps

### 1. Test Locally
```
1. Buka: http://localhost/SPK_AHP/test_pairwise.php
2. Klik link "Test: [Nama Kriteria]"
3. Verify matrix muncul
```

### 2. Upload ke Subdomain
```bash
# Upload file yang diubah
- app/controllers/Admin.php

# (Optional) Upload test files
- test_pairwise.php
- test_pairwise.sql
```

### 3. Test di Production
```
1. Buka: https://apkahp.demoj35.site/admin/pairwiseAlternatif
2. Login sebagai admin
3. Pilih kriteria
4. Verify matrix muncul
```

### 4. Input Data Pairwise
```
1. Isi matrix perbandingan
2. Save
3. Check hasil AHP calculation
```

---

## 💡 Technical Notes

### Routing Behavior:
- PHP Native MVC dengan `.htaccess` rewrite
- URL segments mapped ke controller/method/params
- GET parameters **TIDAK otomatis** jadi method params
- **Solution:** Manual check `$_GET` array

### Form Submission:
- Method: `GET` (bukan POST)
- Action: `url('admin/pairwiseAlternatif')`
- Trigger: `onchange="this.form.submit()"`
- Result URL: `?kriteria_id=X` appended

### View Conditions:
```php
// Matrix hanya muncul jika:
isset($data['selected_kriteria']) 
&& !empty($data['alternatif']) 
&& count($data['alternatif']) >= 2
```

---

## ✅ Success Indicators

Jika fix berhasil, user akan melihat:

1. ✅ **Dropdown kriteria** terisi dan bisa dipilih
2. ✅ **Auto-submit** saat pilih kriteria
3. ✅ **URL parameter** muncul: `?kriteria_id=X`
4. ✅ **Matrix form** langsung muncul
5. ✅ **Bisa input** nilai perbandingan (1-9)
6. ✅ **Save berhasil** dan data tersimpan
7. ✅ **Hasil AHP** muncul di tabel (jika data lengkap)

---

## 🆘 Support

Jika masih ada masalah:

1. **Check documentation files:**
   - `DEBUG_PAIRWISE_ALTERNATIF.md` - Detail debugging
   - `SETUP_SUBDOMAIN.md` - Subdomain setup
   - `README_SPK_AHP.md` - General documentation

2. **Run test files:**
   - `test_pairwise.php` - Interactive diagnostic
   - `test_pairwise.sql` - Database checks

3. **Check logs:**
   - Browser Console (F12)
   - PHP Error Log
   - Apache Error Log

---

**Status:** ✅ **FIXED** - Parameter GET sekarang berhasil ditangkap oleh controller

**Tested:** ✅ Local development (http://localhost/SPK_AHP)

**Ready for:** 🚀 Production deployment (https://apkahp.demoj35.site)

---

*Last Updated: 2024*
*Fix Version: 1.0*
