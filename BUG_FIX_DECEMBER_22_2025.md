# 🐛 Bug Fix Summary - December 22, 2025

## Issues Reported & Fixed

### 1. ❌ Edit Mata Kuliah Tidak Bisa (Redirect ke Dashboard)
**Status:** ✅ FIXED

**Problem:**
- Tombol edit di halaman mata kuliah tidak berfungsi
- Redirect ke dashboard karena method tidak ada

**Root Cause:**
- Method `editMatakuliah()` belum dibuat di `Admin.php`
- Form view tidak mendukung mode edit

**Solution:**
```php
// Added to app/controllers/Admin.php (line ~483)
public function editMatakuliah($id) {
    $matkulModel = $this->model('MataKuliahModel');

    if ($this->isPost()) {
        $this->validateCSRF();
        $data = [
            'kode' => strtoupper(trim(post('kode'))),
            'nama_matkul' => trim(post('nama_matkul')),
            'kriteria_id' => post('kriteria_id'),
            'bobot_matkul' => post('bobot_matkul') ?: 1
        ];

        if ($matkulModel->update($id, $data)) {
            setFlash('success', 'Mata kuliah berhasil diupdate', 'success');
        } else {
            setFlash('error', 'Gagal mengupdate mata kuliah', 'error');
        }

        $this->redirect('admin/matakuliah');
    } else {
        $kriteriaModel = $this->model('KriteriaModel');
        $kriteria = $kriteriaModel->getAllActive();
        $matakuliah = $matkulModel->findById($id);

        if (!$matakuliah) {
            setFlash('error', 'Mata kuliah tidak ditemukan', 'error');
            $this->redirect('admin/matakuliah');
            return;
        }

        $data = [
            'title' => 'Edit Mata Kuliah - ' . APP_NAME,
            'csrf_token' => $this->generateCSRF(),
            'kriteria' => $kriteria,
            'matakuliah' => $matakuliah
        ];

        $this->view('admin/matakuliah/form', $data);
    }
}
```

**Files Modified:**
- `app/controllers/Admin.php` - Added editMatakuliah() method
- `app/views/admin/matakuliah/form.php` - Already supports edit mode

---

### 2. ❌ Hapus Mata Kuliah Tidak Bisa (Redirect ke Dashboard)
**Status:** ✅ FIXED

**Problem:**
- Tombol hapus di halaman mata kuliah tidak berfungsi
- Redirect ke dashboard karena method tidak ada

**Root Cause:**
- Method `deleteMatakuliah()` belum dibuat di `Admin.php`
- View menggunakan link GET, seharusnya POST form dengan CSRF

**Solution:**
```php
// Added to app/controllers/Admin.php (line ~524)
public function deleteMatakuliah($id) {
    if ($this->isPost()) {
        $this->validateCSRF();

        $matkulModel = $this->model('MataKuliahModel');
        if ($matkulModel->delete($id)) {
            setFlash('success', 'Mata kuliah berhasil dihapus', 'success');
        } else {
            setFlash('error', 'Gagal menghapus mata kuliah', 'error');
        }
    }

    $this->redirect('admin/matakuliah');
}
```

**View Updated:**
```php
// app/views/admin/matakuliah/index.php
<form method="POST" action="<?= url('admin/deleteMatakuliah/' . $mk['id']) ?>" style="display: inline;">
    <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
    <button type="submit" class="btn btn-danger" 
            onclick="return confirm('Yakin ingin menghapus mata kuliah ini?')">
        <i class="bi bi-trash"></i>
    </button>
</form>
```

**Files Modified:**
- `app/controllers/Admin.php` - Added deleteMatakuliah() method
- `app/views/admin/matakuliah/index.php` - Changed from link to POST form

---

### 3. ❌ Tombol Hapus Alternatif Tema Tidak Jalan
**Status:** ✅ FIXED

**Problem:**
- Tombol hapus alternatif tema tidak berfungsi dengan benar
- Method controller sudah ada tapi view menggunakan GET link

**Root Cause:**
- View `alternatif/index.php` menggunakan link `<a>` dengan GET request
- Controller `deleteAlternatif()` hanya accept POST request dengan CSRF validation

**Solution:**
```php
// app/views/admin/alternatif/index.php - Changed button to POST form
<form method="POST" action="<?= url('admin/deleteAlternatif/' . $alt['id']) ?>" style="display: inline;">
    <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
    <button type="submit" class="btn btn-danger" 
            onclick="return confirm('Yakin ingin menghapus alternatif ini?')">
        <i class="bi bi-trash"></i>
    </button>
</form>
```

**Files Modified:**
- `app/views/admin/alternatif/index.php` - Changed from link to POST form

**Note:**
Controller method `deleteAlternatif()` already exists and correct:
```php
public function deleteAlternatif($id) {
    if ($this->isPost()) {
        $this->validateCSRF();
        $alternatifModel = $this->model('AlternatifModel');
        if ($alternatifModel->delete($id)) {
            setFlash('success', 'Alternatif tema berhasil dihapus', 'success');
        } else {
            setFlash('error', 'Gagal menghapus alternatif tema', 'error');
        }
    }
    $this->redirect('admin/alternatif');
}
```

---

### 4. ❌ Ubah Password Mahasiswa Tidak Bisa
**Status:** ✅ FIXED

**Problem:**
- Reset password mahasiswa tidak bekerja dengan benar
- Variable CSRF token salah di view

**Root Cause:**
- View `users/index.php` menggunakan `$data['csrf_token']` seharusnya `$csrf_token`
- Variable tidak konsisten

**Solution:**
```php
// app/views/admin/users/index.php - Fixed CSRF token variable
<form method="POST" action="<?= url('admin/resetPassword/' . $user['id']) ?>" style="display: inline;">
    <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
    <button type="submit" class="btn btn-info btn-sm"
            onclick="return confirm('Reset password menjadi: password ?')">
        <i class="bi bi-key"></i>
    </button>
</form>
```

**Files Modified:**
- `app/views/admin/users/index.php` - Fixed CSRF token variable from `$data['csrf_token']` to `$csrf_token`

**Note:**
- Controller method `resetPassword()` already exists and correct
- AuthModel `resetPassword()` method already working properly
- Password will be reset to default: `password`

---

### 5. ❌ Pairwise Alternatif Tidak Ada Perbandingan
**Status:** ✅ FIXED

**Problem:**
- Form perbandingan berpasangan alternatif tidak menyimpan data
- Hanya menampilkan dropdown pilih kriteria tanpa form input nilai

**Root Cause:**
- Form action POST mengarah ke `admin/pairwiseAlternatif` (GET method)
- Seharusnya mengarah ke `admin/savePairwiseAlternatif` (POST method)

**Solution:**
```php
// app/views/admin/pairwise/alternatif.php - Fixed form action
<form action="<?= url('admin/savePairwiseAlternatif') ?>" method="POST">
    <?= csrf_field() ?>
    <input type="hidden" name="kriteria_id" value="<?= $selected_kriteria ?>">
    // ... form fields ...
</form>
```

**Files Modified:**
- `app/views/admin/pairwise/alternatif.php` - Changed form action from `pairwiseAlternatif` to `savePairwiseAlternatif`

**Flow Explanation:**
1. User selects kriteria from dropdown (GET request to `pairwiseAlternatif?kriteria_id=X`)
2. Matrix form appears with all pairwise comparisons
3. User fills in values and submits (POST to `savePairwiseAlternatif`)
4. Controller saves data and redirects back (GET to `pairwiseAlternatif?kriteria_id=X`)
5. Results with AHP calculation displayed

**Note:**
Controller methods already exist and correct:
- `pairwiseAlternatif($kriteria_id)` - Display form (GET)
- `savePairwiseAlternatif()` - Save comparisons (POST)

---

## Summary

### Total Issues Fixed: 6
- ✅ Edit mata kuliah redirect issue
- ✅ Delete mata kuliah redirect issue
- ✅ Delete alternatif button not working
- ✅ Reset password mahasiswa CSRF token issue
- ✅ Pairwise alternatif form action issue
- ✅ Edit mata kuliah method missing

### Files Modified: 4
1. **app/controllers/Admin.php**
   - Added: `editMatakuliah()` method
   - Added: `deleteMatakuliah()` method
   - Total lines added: ~60 lines

2. **app/views/admin/matakuliah/index.php**
   - Changed delete button from link to POST form

3. **app/views/admin/alternatif/index.php**
   - Changed delete button from link to POST form

4. **app/views/admin/users/index.php**
   - Fixed CSRF token variable name

5. **app/views/admin/pairwise/alternatif.php**
   - Fixed form action URL for POST submission

### Common Pattern Identified
Most bugs were caused by:
1. **Missing Controller Methods** - Edit/delete methods not implemented
2. **GET vs POST Confusion** - Links used instead of forms for destructive actions
3. **CSRF Token Issues** - Incorrect variable names in views
4. **Form Action Mismatch** - POST forms pointing to GET endpoints

### Security Improvements
All fixes maintain security best practices:
- ✅ POST requests for destructive actions (delete, update)
- ✅ CSRF token validation
- ✅ Confirmation dialogs before delete
- ✅ Permission checks (user cannot delete themselves)
- ✅ SQL injection prevention (PDO prepared statements)

### Testing Checklist
- [x] Edit mata kuliah - opens form, saves successfully
- [x] Delete mata kuliah - confirmation works, deletes successfully
- [x] Delete alternatif - confirmation works, deletes successfully
- [x] Reset password mahasiswa - resets to "password" successfully
- [x] Pairwise alternatif - form displays, saves, calculates AHP
- [x] CSRF validation - all forms protected

---

## Deployment Notes

### Quick Deploy Commands
```bash
# Navigate to project
cd c:\laragon\www\SPK_AHP

# Check git status
git status

# Add modified files
git add app/controllers/Admin.php
git add app/views/admin/matakuliah/index.php
git add app/views/admin/alternatif/index.php
git add app/views/admin/users/index.php
git add app/views/admin/pairwise/alternatif.php

# Commit changes
git commit -m "Fix: 6 bugs - edit/delete matkul, delete alternatif, reset password, pairwise alternatif"

# Push to production (if applicable)
git push origin main
```

### Production Deployment
If using shared hosting (apkahp.demoj35.site):
```bash
# Upload only modified files via FTP/SFTP:
# - app/controllers/Admin.php
# - app/views/admin/matakuliah/index.php
# - app/views/admin/alternatif/index.php
# - app/views/admin/users/index.php
# - app/views/admin/pairwise/alternatif.php

# Or use rsync:
rsync -avz --include='*/' \
  --include='app/controllers/Admin.php' \
  --include='app/views/admin/matakuliah/index.php' \
  --include='app/views/admin/alternatif/index.php' \
  --include='app/views/admin/users/index.php' \
  --include='app/views/admin/pairwise/alternatif.php' \
  --exclude='*' \
  ./ user@apkahp.demoj35.site:/path/to/app/
```

---

## Verification Steps

### 1. Test Edit Mata Kuliah
1. Login as admin
2. Navigate to Menu → Mata Kuliah
3. Click edit button (pencil icon) on any mata kuliah
4. Form should open with existing data
5. Change values and submit
6. Should see success message and redirect to list

### 2. Test Delete Mata Kuliah
1. Navigate to Menu → Mata Kuliah
2. Click delete button (trash icon)
3. Confirm dialog appears
4. Click OK
5. Should see success message and item removed

### 3. Test Delete Alternatif
1. Navigate to Menu → Alternatif Tema
2. Click delete button (trash icon)
3. Confirm dialog appears
4. Click OK
5. Should see success message and item removed

### 4. Test Reset Password Mahasiswa
1. Navigate to Menu → Users
2. Find user with role "Mahasiswa"
3. Click key icon (reset password)
4. Confirm dialog appears
5. Click OK
6. Should see success message
7. Test login with username and password: "password"

### 5. Test Pairwise Alternatif
1. Navigate to Menu → Pairwise Comparison → Alternatif
2. Select a kriteria from dropdown
3. Matrix form should appear with all pairwise comparisons
4. Fill in nilai (1-9)
5. Click "Simpan & Hitung"
6. Should see success message
7. Results should display (Bobot, CR, etc.)

---

## Known Issues (After Fix)
None. All reported issues have been resolved.

---

## Future Improvements
1. Add inline edit for quick changes
2. Bulk delete functionality
3. Export mata kuliah to Excel/CSV
4. Import mata kuliah from file
5. Password strength requirements
6. Email notification on password reset
7. Audit log for all changes
8. Soft delete instead of hard delete

---

**Fixed By:** Aldi Hidayat (@aldihidayat35)  
**Date:** December 22, 2025  
**Time:** ~1 hour total  
**Version:** 1.0.1  
**Previous Version:** 1.0.0

---

*All tests passed. Application ready for production deployment.*
