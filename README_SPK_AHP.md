# Sistem Pendukung Keputusan Penentuan Tema Tugas Akhir

Aplikasi SPK menggunakan metode AHP (Analytic Hierarchy Process) untuk membantu mahasiswa PTIK UIN Sjech M. Djamil Djambek Bukittinggi dalam menentukan tema tugas akhir yang sesuai dengan minat dan kemampuan mereka.

## 📋 Fitur Utama

### Untuk Admin / Prodi
- ✅ Kelola user (mahasiswa, admin, dosen)
- ✅ Kelola kriteria penilaian
- ✅ Kelola alternatif tema (Kependidikan, Pemrograman, Multimedia, Jaringan)
- ✅ Kelola mata kuliah
- ✅ Input perbandingan berpasangan kriteria (Pairwise Comparison)
- ✅ Input perbandingan berpasangan alternatif per kriteria
- ✅ Perhitungan otomatis bobot kriteria dan alternatif dengan metode AHP
- ✅ Validasi Consistency Ratio (CR ≤ 0.1)
- ✅ Laporan rekomendasi tema per mahasiswa
- ✅ Statistik tema yang paling banyak direkomendasikan
- ✅ Reset password user

### Untuk Mahasiswa
- ✅ Registrasi dan login
- ✅ Input nilai mata kuliah
- ✅ Update profil (minat, email, no HP)
- ✅ Proses perhitungan rekomendasi tema otomatis
- ✅ Lihat hasil rekomendasi dengan ranking
- ✅ Dashboard informatif dengan statistik nilai
- ✅ Riwayat perhitungan AHP

## 🔧 Teknologi

- **Backend**: PHP Native (No Framework)
- **Database**: MySQL
- **Frontend**: Bootstrap 5, Bootstrap Icons
- **Server**: Laragon / XAMPP
- **Metode**: AHP (Analytic Hierarchy Process)

## 📦 Instalasi

### Prasyarat
- PHP >= 7.4
- MySQL / MariaDB
- Apache Web Server (dengan mod_rewrite enabled)
- Laragon / XAMPP

### Langkah Instalasi

1. **Clone/Download Project**
   ```bash
   # Project sudah ada di c:\laragon\www\SPK_AHP
   ```

2. **Buat Database**
   - Buka phpMyAdmin atau MySQL CLI
   - Import file database:
   ```bash
   mysql -u root -p < database/spk_ahp.sql
   ```
   
   Atau melalui phpMyAdmin:
   - Buat database baru dengan nama `spk_ahp`
   - Import file `database/spk_ahp.sql`

3. **Konfigurasi Database**
   - File `.env` sudah dibuat otomatis
   - Jika perlu, sesuaikan konfigurasi di file `.env`:
   ```env
   DB_HOST=localhost
   DB_NAME=spk_ahp
   DB_USER=root
   DB_PASS=
   ```

4. **Set Base URL**
   - Edit file `.env`
   - Sesuaikan BASE_URL sesuai lokasi project Anda:
   ```env
   BASE_URL=http://localhost/SPK_AHP
   ```

5. **Jalankan Aplikasi**
   - Buka browser
   - Akses: `http://localhost/SPK_AHP`

## 👥 Akun Default

### Admin
- **Username**: `admin`
- **Password**: `password`

### Mahasiswa (Demo)
- **Username**: `2021001`
- **Password**: `password`

- **Username**: `2021002`
- **Password**: `password`

**⚠️ PENTING**: Segera ubah password default setelah login pertama kali!

## 📊 Struktur Database

### Tabel Utama:
1. **users** - Data user (admin, mahasiswa, dosen)
2. **mahasiswa** - Data lengkap mahasiswa
3. **kriteria** - Kriteria penilaian AHP
4. **alternatif_tema** - Tema tugas akhir (Kependidikan, Pemrograman, Multimedia, Jaringan)
5. **mata_kuliah** - Daftar mata kuliah
6. **nilai_matkul** - Nilai mahasiswa per mata kuliah
7. **pairwise_kriteria** - Matriks perbandingan berpasangan kriteria
8. **pairwise_alternatif** - Matriks perbandingan berpasangan alternatif
9. **hasil_rekomendasi** - Hasil perhitungan rekomendasi
10. **riwayat_perhitungan** - Riwayat perhitungan AHP

## 🎯 Cara Penggunaan

### Untuk Admin

1. **Login** sebagai admin
2. **Kelola Kriteria**:
   - Tambah/edit kriteria penilaian
   - Contoh: Kemampuan Pemrograman, Multimedia, Jaringan, Kependidikan
3. **Kelola Alternatif Tema**:
   - Tambah/edit tema tugas akhir
   - Default: Kependidikan, Pemrograman, Multimedia, Jaringan
4. **Kelola Mata Kuliah**:
   - Tambah mata kuliah dan hubungkan dengan kriteria
5. **Perbandingan Berpasangan Kriteria**:
   - Input nilai perbandingan (skala 1-9)
   - Sistem otomatis menghitung bobot dan CR
6. **Perbandingan Berpasangan Alternatif**:
   - Untuk setiap kriteria, input perbandingan antar alternatif
7. **Lihat Laporan**:
   - Statistik rekomendasi per tema
   - Daftar mahasiswa yang sudah mendapat rekomendasi

### Untuk Mahasiswa

1. **Registrasi** atau login dengan akun yang diberikan admin
2. **Lengkapi Profil**:
   - Minat utama
   - Email dan nomor HP
3. **Input Nilai Mata Kuliah**:
   - Isi nilai untuk setiap mata kuliah
   - Nilai 0-100
4. **Proses Rekomendasi**:
   - Klik tombol "Proses Rekomendasi"
   - Sistem akan menghitung dengan metode AHP
5. **Lihat Hasil**:
   - Tema yang direkomendasikan (ranking #1)
   - Ranking semua tema dengan skor
   - Penjelasan hasil

## 📐 Metode AHP

Aplikasi ini mengimplementasikan metode AHP lengkap:

1. **Penyusunan Hirarki**
   - Tujuan: Menentukan tema tugas akhir terbaik
   - Kriteria: Kemampuan (Pemrograman, Multimedia, Jaringan, Kependidikan), Minat
   - Alternatif: Tema-tema tugas akhir

2. **Pairwise Comparison**
   - Admin menginput perbandingan berpasangan
   - Skala 1-9 (Saaty)

3. **Perhitungan Bobot**
   - Normalisasi matriks
   - Eigenvector (priority vector)
   - Lambda max

4. **Uji Konsistensi**
   - Consistency Index (CI)
   - Consistency Ratio (CR)
   - Valid jika CR ≤ 0.1

5. **Perhitungan Skor Akhir**
   - Perkalian bobot kriteria × bobot alternatif
   - Ranking berdasarkan skor tertinggi

## 🗂️ Struktur Folder

```
SPK_AHP/
├── app/
│   ├── controllers/     # AuthController, AdminController, MahasiswaController
│   ├── models/         # Model untuk database
│   ├── views/          # Template views
│   │   ├── auth/       # Login, register
│   │   ├── admin/      # Dashboard dan modul admin
│   │   ├── mahasiswa/  # Dashboard dan modul mahasiswa
│   │   └── layouts/    # Header, footer
│   ├── core/           # App, Controller, Model core
│   └── init.php        # Autoloader
├── config/
│   ├── config.php      # Konfigurasi aplikasi
│   └── database.php    # Koneksi database
├── database/
│   └── spk_ahp.sql     # File SQL database
├── helpers/
│   ├── functions.php   # Helper functions
│   └── ahp.php         # Fungsi perhitungan AHP
├── public/
│   ├── css/           # File CSS
│   ├── js/            # File JavaScript
│   ├── img/           # Gambar
│   └── index.php      # Entry point
├── uploads/           # Folder upload
├── .env               # Environment variables
├── .env.example       # Contoh env
├── .gitignore         # Git ignore
└── README.md          # Dokumentasi
```

## 🔒 Keamanan

- ✅ Password di-hash dengan `password_hash()`
- ✅ CSRF Protection pada semua form
- ✅ Prepared Statement untuk query database
- ✅ XSS Protection dengan `escape()` function
- ✅ Session management dengan timeout
- ✅ Role-based access control

## 🐛 Troubleshooting

### Error: "Connection error"
- Pastikan MySQL sudah running
- Cek konfigurasi di file `.env`
- Pastikan database `spk_ahp` sudah dibuat

### Error: "404 Not Found"
- Pastikan mod_rewrite Apache sudah enabled
- Cek file `.htaccess` di root dan folder `public/`
- Sesuaikan `BASE_URL` di `.env`

### Error: "Access denied"
- Cek username/password MySQL di `.env`
- Pastikan user MySQL punya akses ke database

### Tampilan berantakan / Asset tidak load
- Pastikan koneksi internet aktif (untuk Bootstrap CDN)
- Atau download Bootstrap dan simpan lokal
- **Untuk Subdomain**: Pastikan BASE_URL di `.env` sesuai subdomain
- Cek struktur folder: assets harus di dalam `public/assets/`
- Set permission folder `public/assets/` ke 755

### Khusus Subdomain (contoh: apkahp.demoj35.site)

**Struktur folder di server:**
```
public_html/
└── apkahp.demoj35.site/
    ├── app/
    ├── config/
    ├── database/
    ├── helpers/
    ├── public/
    │   ├── assets/
    │   │   ├── css/
    │   │   ├── js/
    │   │   ├── img/
    │   │   └── vendor/
    │   ├── .htaccess
    │   └── index.php
    ├── uploads/
    ├── .env
    └── .htaccess
```

**File `.env` harus:**
```env
BASE_URL=https://apkahp.demoj35.site
# TANPA trailing slash!
```

**Jika assets tetap tidak load:**
1. Pindahkan isi folder `public/` ke root subdomain
2. Edit `index.php` di root, ubah path menjadi relatif
3. Assets akan diakses dari: `https://apkahp.demoj35.site/assets/`

## 📝 Catatan Pengembangan

### Data Dummy
Database sudah terisi dengan data dummy:
- 1 admin, 1 dosen, 3 mahasiswa
- 5 kriteria
- 4 alternatif tema
- 11 mata kuliah
- Nilai mahasiswa (sample)
- Pairwise comparison (sample)

### Kustomisasi
Anda dapat:
- Menambah/mengurangi kriteria
- Menambah/mengurangi alternatif tema
- Menyesuaikan mata kuliah
- Mengubah bobot perbandingan
- Menambah fitur laporan
- Export ke PDF/Excel

## 👨‍💻 Developer

Dikembangkan untuk:
**Program Studi PTIK**  
**UIN Sjech M. Djamil Djambek Bukittinggi**

## 📄 Lisensi

Open source - dapat digunakan dan dimodifikasi sesuai kebutuhan.

## 📧 Kontak & Support

Jika ada pertanyaan atau butuh bantuan, silakan hubungi admin prodi.

---

**Selamat Menggunakan! 🎓**
