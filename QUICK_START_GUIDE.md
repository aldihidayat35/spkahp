# 🚀 QUICK START GUIDE
## SPK AHP - Sistem Pemilihan Tema PKL

---

## 📦 INSTALASI CEPAT

### Option 1: Local Development (Laragon)

```bash
# 1. Install Laragon
Download: https://laragon.org/

# 2. Extract project ke folder
C:\laragon\www\SPK_AHP\

# 3. Import database
- Buka phpMyAdmin: http://localhost/phpmyadmin
- Create database: spk_ahp
- Import file: database/spk_ahp.sql

# 4. Konfigurasi .env
DB_HOST=localhost
DB_NAME=spk_ahp
DB_USER=root
DB_PASS=
BASE_URL=http://localhost/SPK_AHP

# 5. Akses aplikasi
http://localhost/SPK_AHP

# Login Default:
Username: admin
Password: admin123
```

### Option 2: Production (Shared Hosting)

```bash
# 1. Upload files via FTP/cPanel
Upload semua file ke: public_html/subdomain/

# 2. Create database via cPanel
- MySQL Databases → Create database
- Import spk_ahp.sql via phpMyAdmin

# 3. Configure .env
DB_HOST=localhost
DB_NAME=username_dbname
DB_USER=username_dbuser
DB_PASS=your_password
BASE_URL=https://yourdomain.com

# 4. Set permissions
chmod 755 assets/
chmod 755 app/
chmod 644 .env

# 5. Akses
https://yourdomain.com
```

---

## 👥 USER ROLES & ACCESS

### 1. ADMIN
**Akses penuh untuk:**
- ✅ Kelola semua master data
- ✅ Pairwise comparison
- ✅ Kelola user & mahasiswa
- ✅ Monitoring & laporan

**Login:**
```
URL: /auth/login
Username: admin
Password: admin123
```

### 2. DOSEN
**Akses untuk:**
- ✅ Lihat data mahasiswa
- ✅ Monitoring rekomendasi
- ✅ Laporan & visualisasi

**Login:**
```
URL: /auth/login
Username: dosen1
Password: password
```

### 3. MAHASISWA
**Akses untuk:**
- ✅ Lihat/edit profil
- ✅ Lihat nilai
- ✅ Hitung rekomendasi tema PKL
- ✅ Lihat riwayat

**Login:**
```
URL: /auth/login
Username: (NIM mahasiswa)
Password: (password)
```

---

## 🎯 QUICK SETUP (Admin)

### Step 1: Setup Kriteria (5 menit)

```
Admin Panel → Kelola Kriteria → Tambah Kriteria

Contoh Kriteria:
1. Pemrograman Web (K1)
2. Database (K2)
3. Mobile Development (K3)
4. Data Science (K4)
5. UI/UX Design (K5)

✅ Save
```

### Step 2: Setup Alternatif (5 menit)

```
Admin Panel → Kelola Alternatif → Tambah Alternatif

Contoh Tema PKL:
1. Web Development (T1)
2. Mobile Development (T2)
3. Data Science (T3)
4. UI/UX Design (T4)
5. IoT Development (T5)
6. Game Development (T6)

✅ Save
```

### Step 3: Setup Mata Kuliah (10 menit)

```
Admin Panel → Kelola Mata Kuliah → Tambah Mata Kuliah

Contoh:
- Pemrograman Web → Kriteria: K1
- Database → Kriteria: K2
- Mobile Programming → Kriteria: K3
- Data Mining → Kriteria: K4
- Desain Grafis → Kriteria: K5

✅ Save
```

### Step 4: Pairwise Kriteria (15 menit)

```
Admin Panel → Pairwise Comparison → Kriteria

Input perbandingan:
K1 vs K2 → 3 (K1 sedikit lebih penting dari K2)
K1 vs K3 → 5 (K1 lebih penting dari K3)
K1 vs K4 → 7 (K1 sangat lebih penting dari K4)
K1 vs K5 → 3
K2 vs K3 → 3
K2 vs K4 → 5
K2 vs K5 → 3
K3 vs K4 → 3
K3 vs K5 → 1
K4 vs K5 → 1/3

✅ Save → Bobot otomatis terhitung
✅ Check CR < 0.1 (konsisten)
```

### Step 5: Pairwise Alternatif (30 menit)

```
Admin Panel → Pairwise Comparison → Alternatif

Untuk setiap kriteria (K1-K5):
1. Pilih kriteria
2. Input perbandingan 15 pasangan alternatif
3. Save
4. Ulangi untuk kriteria berikutnya

✅ Selesai untuk semua kriteria
```

### Step 6: Tambah User Mahasiswa (5 menit)

```
Admin Panel → Kelola User → Tambah User

Role: Mahasiswa
Username: 2001010001
Password: password
Nama: John Doe
NIM: 2001010001
Angkatan: 2020
Email: john@example.com

✅ Save
```

---

## 📊 QUICK TEST (Mahasiswa)

### Hitung Rekomendasi

```
1. Login sebagai mahasiswa
   Username: 2001010001
   Password: password

2. Pastikan nilai sudah ada
   Menu: Nilai Mata Kuliah
   (Jika belum, admin input dulu)

3. Hitung rekomendasi
   Dashboard → Button "Hitung Rekomendasi"
   
4. Lihat hasil
   - Ranking #1: Tema A (XX.XX%)
   - Ranking #2: Tema B (XX.XX%)
   - Ranking #3: Tema C (XX.XX%)

✅ Rekomendasi berhasil!
```

---

## 🔍 VERIFIKASI SISTEM

### Checklist Setup

```
✅ Database terkoneksi
✅ Login admin berhasil
✅ Minimal 3 kriteria aktif
✅ Minimal 3 alternatif aktif
✅ Pairwise kriteria complete (CR < 0.1)
✅ Pairwise alternatif complete (minimal 1 kriteria)
✅ Minimal 1 mahasiswa dengan nilai
✅ Perhitungan rekomendasi berhasil
```

### Test URLs

```bash
# Homepage
http://localhost/SPK_AHP/

# Admin Dashboard
http://localhost/SPK_AHP/admin/dashboard

# Dosen Dashboard
http://localhost/SPK_AHP/dosen/dashboard

# Mahasiswa Dashboard
http://localhost/SPK_AHP/mahasiswa/dashboard

# Visualisasi AHP
http://localhost/SPK_AHP/admin/visualisasi
```

---

## 🛠️ TROUBLESHOOTING CEPAT

### Error: Database Connection Failed
```php
// Check .env
DB_HOST=localhost  ✅
DB_NAME=spk_ahp    ✅
DB_USER=root       ✅
DB_PASS=           ✅ (kosong untuk Laragon)
```

### Error: 404 Not Found
```apache
# Check .htaccess ada di root
# Isi .htaccess:
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php?url=$1 [QSA,L]
```

### Error: Assets Tidak Load
```php
// Check BASE_URL di .env
BASE_URL=http://localhost/SPK_AHP  ✅ (tanpa trailing slash)

// Clear browser cache
Ctrl + Shift + R
```

### Error: Session Logout Otomatis
```php
// config/config.php - increase session lifetime
define('SESSION_LIFETIME', 3600); // 1 jam
```

### Error: Pairwise Matrix Tidak Muncul
```
1. Pastikan minimal 2 alternatif aktif
2. Check browser console untuk JavaScript error
3. Refresh page (Ctrl + F5)
```

---

## 📚 DOKUMENTASI LENGKAP

Untuk dokumentasi detail, lihat:

1. **DOKUMENTASI_LENGKAP.md** - Full documentation
2. **ALUR_KERJA_AHP.md** - AHP workflow detail
3. **README_SPK_AHP.md** - General readme
4. **SETUP_SUBDOMAIN.md** - Subdomain deployment guide

---

## 🎓 TUTORIAL VIDEO

Coming soon...

---

## 💬 SUPPORT

Butuh bantuan?
1. Baca dokumentasi lengkap
2. Check troubleshooting guide
3. GitHub Issues
4. Contact developer

---

## ✅ QUICK REFERENCE

### Skala Pairwise (1-9)
| Nilai | Keterangan |
|-------|-----------|
| 1 | Sama penting |
| 3 | Sedikit lebih penting |
| 5 | Lebih penting |
| 7 | Sangat lebih penting |
| 9 | Mutlak lebih penting |

### Consistency Ratio
```
CR < 0.1  → Konsisten ✅
CR >= 0.1 → Tidak konsisten ❌ (review input)
```

### Default Login
```
Admin:
- Username: admin
- Password: admin123

Dosen:
- Username: dosen1
- Password: password

Mahasiswa:
- Username: (NIM)
- Password: (set by admin)
```

---

## 🚀 NEXT STEPS

Setelah setup selesai:

1. ✅ **Customize kriteria** sesuai program studi
2. ✅ **Input alternatif tema** yang relevan
3. ✅ **Setup pairwise comparison** dengan teliti
4. ✅ **Tambah data mahasiswa** dan nilai
5. ✅ **Test perhitungan** rekomendasi
6. ✅ **Deploy ke production** (optional)
7. ✅ **Training user** admin, dosen, mahasiswa

---

**Selamat Menggunakan SPK AHP! 🎉**

Version: 1.0.0  
Last Update: December 17, 2025  
Developer: Aldi Hidayat (@aldihidayat35)
