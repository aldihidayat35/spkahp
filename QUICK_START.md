# 🚀 QUICK START - SPK AHP Tema Tugas Akhir

## Instalasi Cepat (5 Menit)

### 1. Import Database
```sql
- Buka phpMyAdmin
- Klik "New" untuk buat database baru
- Nama database: spk_ahp
- Import file: database/spk_ahp.sql
```

### 2. Cek Konfigurasi
File `.env` sudah siap, pastikan settingnya benar:
```env
DB_HOST=localhost
DB_NAME=spk_ahp
DB_USER=root
DB_PASS=
BASE_URL=http://localhost/SPK_AHP
```

### 3. Akses Aplikasi
```
http://localhost/SPK_AHP
```

## 👤 Login

### Admin
- Username: `admin`
- Password: `password`

### Mahasiswa (Demo)
- Username: `2021001`
- Password: `password`

## ✅ Checklist Admin (Setup Awal)

1. **Login sebagai admin**
2. **Cek Kriteria** (Menu: Kelola Kriteria)
   - Sudah ada 5 kriteria default
   - Bisa tambah/edit sesuai kebutuhan

3. **Cek Alternatif Tema** (Menu: Alternatif Tema)
   - Sudah ada 4 tema: Kependidikan, Pemrograman, Multimedia, Jaringan
   - Bisa tambah/edit

4. **Cek Mata Kuliah** (Menu: Mata Kuliah)
   - Sudah ada 11 mata kuliah
   - Bisa tambah/edit

5. **Input Perbandingan Kriteria** (Menu: Perbandingan Kriteria)
   - Isi matriks perbandingan berpasangan
   - Skala 1-9
   - Cek CR (harus ≤ 0.1)

6. **Input Perbandingan Alternatif** (Menu: Perbandingan Alternatif)
   - Untuk setiap kriteria
   - Isi perbandingan antar tema
   - Cek CR

7. **Tambah User Mahasiswa** (Menu: Kelola User)
   - Atau mahasiswa bisa registrasi sendiri

## ✅ Checklist Mahasiswa

1. **Login** dengan NIM/username
2. **Input Nilai** (Menu: Input Nilai)
   - Isi nilai semua mata kuliah (0-100)
3. **Proses Rekomendasi** (Dashboard)
   - Klik "Proses Sekarang"
4. **Lihat Hasil** (Menu: Hasil Rekomendasi)
   - Tema yang direkomendasikan
   - Ranking semua tema

## 🎯 Fitur Utama

### Admin:
- ✅ CRUD User, Kriteria, Tema, Mata Kuliah
- ✅ Pairwise Comparison dengan validasi CR
- ✅ Perhitungan AHP Otomatis
- ✅ Laporan & Statistik
- ✅ Reset Password

### Mahasiswa:
- ✅ Input/Update Nilai
- ✅ Proses Rekomendasi Otomatis
- ✅ Lihat Hasil Ranking
- ✅ Dashboard Informatif

## 📊 Metode AHP

Aplikasi sudah implementasi:
- ✅ Pairwise Comparison Matrix
- ✅ Normalisasi Matrix
- ✅ Eigenvector (Priority Vector)
- ✅ Lambda Max
- ✅ Consistency Index (CI)
- ✅ Consistency Ratio (CR)
- ✅ Final Score Calculation
- ✅ Ranking

## 🐛 Troubleshooting

**Error database connection?**
- Cek MySQL running
- Cek username/password di `.env`

**Error 404?**
- Cek `BASE_URL` di `.env`
- Cek file `.htaccess`

**CR > 0.1?**
- Perbaiki nilai perbandingan berpasangan
- Pastikan konsisten dalam penilaian

## 📞 Support

Baca `README_SPK_AHP.md` untuk dokumentasi lengkap.

---

**Happy Coding! 🎓**
