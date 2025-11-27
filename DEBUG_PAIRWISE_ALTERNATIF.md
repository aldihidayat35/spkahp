# Debug Guide - Pairwise Alternatif Page

## Masalah
Ketika memilih kriteria dari dropdown, matrix perbandingan tidak muncul.

## Perbaikan Yang Sudah Dilakukan

### 1. **Controller: Admin.php - Method pairwiseAlternatif()**

**Masalah:** Parameter `$kriteria_id` dari URL tidak bisa menangkap parameter GET `kriteria_id`

**Solusi:** Ditambahkan pengecekan GET parameter
```php
// Get kriteria_id from GET parameter if not from URL
if (!$kriteria_id && isset($_GET['kriteria_id'])) {
    $kriteria_id = $_GET['kriteria_id'];
}
```

**Baris yang diubah:** Lines 551-565

---

## Cara Testing

### 1. **Test Manual dengan URL Langsung**
```
http://localhost/SPK_AHP/admin/pairwiseAlternatif?kriteria_id=1
```

**Yang Harus Muncul:**
- Dropdown kriteria terselect pada kriteria dengan ID 1
- Matrix perbandingan alternatif muncul
- Tabel hasil AHP muncul (jika sudah ada data)

### 2. **Test Dropdown Selection**
1. Buka halaman: `http://localhost/SPK_AHP/admin/pairwiseAlternatif`
2. Pilih kriteria dari dropdown
3. **Otomatis Submit** via JavaScript `onchange="this.form.submit()"`
4. Halaman reload dengan parameter `?kriteria_id=X`
5. Matrix harus muncul

---

## Debugging Checklist

### ✅ **Verifikasi Parameter Diterima**
Tambahkan kode debug di controller (baris ~555):
```php
public function pairwiseAlternatif($kriteria_id = null) {
    // DEBUG: Cek parameter
    error_log("URL Param: " . $kriteria_id);
    error_log("GET Param: " . (isset($_GET['kriteria_id']) ? $_GET['kriteria_id'] : 'NULL'));
    
    // ... rest of code
```

**Check log:** `c:\laragon\www\SPK_AHP\logs\app.log` atau PHP error log

### ✅ **Verifikasi Data Kriteria**
```php
// Setelah $kriteria_list = $kriteriaModel->getAllActive();
error_log("Total Kriteria: " . count($kriteria_list));
```

### ✅ **Verifikasi Data Alternatif**
```php
// Setelah $alternatif = $alternatifModel->getAllActive();
error_log("Total Alternatif: " . count($alternatif));
```

### ✅ **Verifikasi Kondisi di View**
Di `app/views/admin/pairwise/alternatif.php` line ~70:
```php
<?php if (isset($data['selected_kriteria']) && !empty($data['alternatif']) && count($data['alternatif']) >= 2): ?>
    <?php
        // DEBUG
        error_log("View Condition Met!");
        error_log("Selected Kriteria: " . $data['selected_kriteria']);
        error_log("Total Alternatif: " . count($data['alternatif']));
    ?>
    <!-- Matrix Form -->
```

---

## Testing di Subdomain

### URL untuk Test:
```
https://apkahp.demoj35.site/admin/pairwiseAlternatif?kriteria_id=1
```

### Browser Developer Tools
1. **Network Tab:**
   - Cek request URL saat submit form
   - Pastikan parameter `kriteria_id` ada di URL
   - Status Code harus 200

2. **Console Tab:**
   - Cek JavaScript errors
   - Pastikan form submit berjalan

3. **Application Tab:**
   - Cek Session storage
   - Pastikan user masih login

---

## Common Issues & Solutions

### ❌ **Matrix Tidak Muncul Sama Sekali**

**Kemungkinan Penyebab:**
1. Parameter tidak diterima controller
2. Data alternatif kosong atau < 2
3. Kondisi di view tidak terpenuhi

**Solusi:**
- Gunakan debug log di atas
- Cek database: `SELECT * FROM alternatif WHERE is_active = 1`
- Minimal harus ada 2 alternatif aktif

### ❌ **Dropdown Tidak Submit**

**Kemungkinan Penyebab:**
- JavaScript error
- Form action URL salah

**Solusi:**
- Buka Console browser, cek error
- Pastikan `onchange="this.form.submit()"` ada di `<select>`
- Test manual submit dengan klik tombol

### ❌ **Error 404 Setelah Submit**

**Kemungkinan Penyebab:**
- Routing issue
- URL helper salah

**Solusi:**
- Cek `.htaccess` di root
- Cek fungsi `url()` di `helpers/helpers.php`
- Test dengan URL lengkap: `<?= BASE_URL ?>/admin/pairwiseAlternatif`

---

## Expected Data Flow

```
1. User pilih kriteria dari dropdown
   ↓
2. JavaScript: onchange submit form dengan GET method
   ↓
3. URL: /admin/pairwiseAlternatif?kriteria_id=X
   ↓
4. Routing: catch dan kirim ke Admin->pairwiseAlternatif()
   ↓
5. Controller: 
   - Terima $kriteria_id dari URL param ATAU $_GET
   - Fetch kriteria_list (untuk dropdown)
   - Fetch alternatif (untuk matrix)
   - Fetch pairwise data (jika ada)
   - Calculate AHP (jika data lengkap)
   ↓
6. View: 
   - Render dropdown (selected = $kriteria_id)
   - IF kriteria_id SET AND alternatif >= 2:
     * Render comparison matrix
     * Render hasil AHP table
   ↓
7. User sees matrix and can input comparisons
```

---

## Database Check

### Pastikan Data Kriteria Ada
```sql
SELECT * FROM kriteria WHERE is_active = 1;
```
**Minimal:** 3-5 kriteria aktif

### Pastikan Data Alternatif Ada
```sql
SELECT * FROM alternatif WHERE is_active = 1;
```
**Minimal:** 2 alternatif aktif (untuk bisa berpasangan)

### Cek Data Pairwise Yang Sudah Ada
```sql
SELECT * FROM pairwise_alternatif 
WHERE kriteria_id = 1
ORDER BY alternatif_1, alternatif_2;
```

---

## Next Steps After Fix

1. **Test semua kriteria** - Pilih setiap kriteria dari dropdown
2. **Input perbandingan** - Masukkan nilai untuk setiap pasangan
3. **Verify AHP calculation** - Cek apakah bobot/prioritas muncul di tabel hasil
4. **Test save functionality** - Pastikan data tersimpan ke database

---

## Quick Fix Commands

### Restart Apache (jika perlu)
```bash
# Jika menggunakan Laragon
cd c:\laragon\bin\apache\apache-2.4.54-win64\bin
httpd.exe -k restart
```

### Clear PHP Cache (jika perlu)
```bash
# Hapus cache opcache
# Atau restart Apache
```

### Check Error Logs
```bash
# Laragon error log
type c:\laragon\www\SPK_AHP\logs\app.log

# PHP error log
type c:\laragon\bin\php\php-8.1.10-Win32-vs16-x64\php_error.log
```

---

## Contact Points

Jika masih error, cek:
1. **PHP Error Log** - Syntax/runtime errors
2. **Apache Error Log** - Server issues
3. **Browser Console** - JavaScript errors
4. **Network Tab** - Request/response issues

**File yang diubah:**
- `app/controllers/Admin.php` - Method `pairwiseAlternatif()` lines 551-599

**Status:** ✅ FIXED - Parameter GET sekarang bisa ditangkap dengan benar
