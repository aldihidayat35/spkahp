# Panduan Instalasi SPK AHP

## Langkah-langkah Instalasi

### 1. Persiapan Database
```bash
# Buka phpMyAdmin atau MySQL CLI
# Import file database
mysql -u root -p < database/spk_ahp.sql

# Atau via phpMyAdmin:
# - Buka http://localhost/phpmyadmin
# - Klik "Import"
# - Pilih file: database/spk_ahp.sql
# - Klik "Go"
```

### 2. Konfigurasi Environment
```bash
# File .env sudah ada dengan konfigurasi default
# Sesuaikan jika perlu:
DB_HOST=localhost
DB_NAME=spk_ahp
DB_USER=root
DB_PASS=

BASE_URL=http://localhost/SPK_AHP
```

### 3. Test Koneksi Database
```
Buka: http://localhost/SPK_AHP/test_connection.php

Pastikan:
✅ Koneksi database berhasil
✅ Semua tabel terlihat (10 tabel)
✅ Data users tersedia (5 users)
```

### 4. Akses Aplikasi
```
Homepage: http://localhost/SPK_AHP
Login: http://localhost/SPK_AHP/auth/login
```

### 5. Akun Demo

**Admin:**
- Username: `admin`
- Password: `password`

**Mahasiswa:**
- Username: `2021001` (Reza Pratama)
- Password: `password`

- Username: `2021002` (Siti Nurhaliza)
- Password: `password`

**Dosen:**
- Username: `dosen1` (Dr. Ahmad Fadli)
- Password: `password`

## Troubleshooting

### Error: Asset tidak muncul
- Pastikan folder `public/assets` ada
- Cek file `.htaccess` di root sudah aktif
- Pastikan mod_rewrite Apache enabled

### Error: Page Not Found
- Pastikan mod_rewrite enabled di Apache
- Cek `.htaccess` di folder `public/`
- Restart Apache

### Error: Database Connection Failed
- Pastikan MySQL/MariaDB running
- Cek kredensial di file `.env`
- Import ulang file `database/spk_ahp.sql`

### Error: Login tidak berhasil
1. Pastikan database sudah diimport
2. Test koneksi dengan `test_connection.php`
3. Cek browser console untuk error JavaScript
4. Cek Apache error log

## Struktur URL

```
/                           → Homepage
/auth/login                 → Halaman Login
/auth/register              → Registrasi Mahasiswa
/admin/dashboard            → Dashboard Admin
/mahasiswa/dashboard        → Dashboard Mahasiswa
/dosen/dashboard            → Dashboard Dosen
```

## Kebutuhan Sistem

- PHP 7.4 atau lebih tinggi
- MySQL 5.7 atau MariaDB 10.3+
- Apache dengan mod_rewrite enabled
- Laragon/XAMPP/WAMP

## Selesai!

Jika semua langkah sudah dilakukan, aplikasi siap digunakan! 🎉
