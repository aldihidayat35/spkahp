# Bug Fix: View not found - auth/change_password

## Error
```
View not found: auth/change_password
```

## Problem
- Controller `Auth.php` memiliki method `changePassword()` yang memanggil view `auth/change_password`
- File view `app/views/auth/change_password.php` tidak ada/hilang
- User tidak bisa mengakses halaman ubah password

## Solution
✅ **Created:** `app/views/auth/change_password.php`

## Features Added
1. **Form Ubah Password** dengan 3 field:
   - Password lama (required)
   - Password baru (required, min 6 karakter)
   - Konfirmasi password baru (required)

2. **UI/UX Enhancements:**
   - Toggle show/hide password untuk semua field
   - Password strength indicator (Lemah/Sedang/Kuat)
   - Real-time password match validation
   - Responsive design dengan Bootstrap 5
   - Gradient background matching login page

3. **Security Features:**
   - CSRF token protection
   - Client-side validation
   - Server-side validation (in controller)
   - Password encryption (handled by AuthModel)

4. **User Experience:**
   - Alert messages (success/error)
   - Password strength tips
   - Visual feedback for password match/mismatch
   - Button to return to dashboard

## How to Use
1. Login ke aplikasi dengan role apapun (admin/dosen/mahasiswa)
2. Navigate to: `https://yourapp.com/auth/changePassword`
3. Atau tambahkan link di header/sidebar menu
4. Fill in:
   - Password lama
   - Password baru (min 6 karakter)
   - Konfirmasi password baru
5. Submit form
6. Akan redirect ke dashboard jika berhasil

## Files Created
- `app/views/auth/change_password.php` (~250 lines)

## Dependencies
- Bootstrap 5.3.0 (CSS/JS)
- Bootstrap Icons 1.11.0
- Existing AuthModel::changePassword() method ✅
- Existing Auth controller method ✅

## Testing
- [x] View file created
- [x] Form displays correctly
- [x] CSRF token included
- [x] Password toggle works
- [x] Strength indicator works
- [x] Match validation works
- [x] Back to dashboard button works

## Related Files
- Controller: `app/controllers/Auth.php` (line 134)
- Model: `app/models/AuthModel.php` (line 139)
- View: `app/views/auth/change_password.php` (NEW)

---

**Fixed:** December 22, 2025
**Status:** ✅ RESOLVED
