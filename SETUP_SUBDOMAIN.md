# 🌐 Setup untuk Subdomain: apkahp.demoj35.site

## 📋 Langkah-langkah Perbaikan Asset

### ✅ Solusi 1: Update .env dan Struktur Folder (RECOMMENDED)

**1. Edit file `.env`:**
```env
# Database Configuration
DB_HOST=localhost
DB_NAME=username_spk_ahp
DB_USER=username_dbuser
DB_PASS=password_kamu

# PENTING: BASE_URL tanpa trailing slash
BASE_URL=https://apkahp.demoj35.site

APP_NAME=SPK AHP PTIK
SESSION_LIFETIME=7200
```

**2. Struktur folder yang benar:**
```
public_html/apkahp.demoj35.site/
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
├── .htaccess
└── README.md
```

**3. File `.htaccess` di ROOT (apkahp.demoj35.site/.htaccess):**
```apache
RewriteEngine On

# Prevent access to .env file
<Files .env>
    Order allow,deny
    Deny from all
</Files>

# Redirect root to public/index.php
RewriteCond %{REQUEST_URI} ^/?$
RewriteRule ^(.*)$ public/index.php [L]

# Redirect to public folder if not already there
RewriteCond %{REQUEST_URI} !^/public/
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ public/$1 [L]
```

**4. File `public/.htaccess`:**
```apache
RewriteEngine On

# Allow access to assets
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d

# Route all requests to index.php
RewriteRule ^(.*)$ index.php?url=$1 [QSA,L]
```

**5. Set Permission:**
```bash
# Via File Manager cPanel atau FTP
chmod 755 public/assets/
chmod 755 public/assets/css/
chmod 755 public/assets/js/
chmod 755 public/assets/img/
chmod 755 public/assets/vendor/
chmod 777 uploads/
```

---

### ✅ Solusi 2: Pindahkan ke Root Subdomain (ALTERNATIF)

Jika Solusi 1 tidak berhasil, lakukan ini:

**1. Pindahkan semua isi folder `public/` ke root subdomain:**

**Dari:**
```
public_html/apkahp.demoj35.site/
├── public/
│   ├── assets/
│   ├── index.php
│   └── .htaccess
```

**Menjadi:**
```
public_html/apkahp.demoj35.site/
├── assets/          ← PINDAHKAN KE SINI
├── index.php        ← PINDAHKAN KE SINI
├── .htaccess        ← SUDAH ADA, UPDATE ISI
├── app/
├── config/
├── helpers/
└── ...
```

**2. Edit `index.php` di root, ubah path:**

**SEBELUM:**
```php
define('APP_PATH', __DIR__ . '/../app');
define('CONFIG_PATH', __DIR__ . '/../config');
define('HELPERS_PATH', __DIR__ . '/../helpers');
```

**SESUDAH:**
```php
define('APP_PATH', __DIR__ . '/app');
define('CONFIG_PATH', __DIR__ . '/config');
define('HELPERS_PATH', __DIR__ . '/helpers');
```

**3. Update `.htaccess` di root:**
```apache
RewriteEngine On

# Prevent access to .env
<Files .env>
    Order allow,deny
    Deny from all
</Files>

# Prevent access to sensitive folders
RewriteRule ^(app|config|database|helpers)/ - [F,L]

# Allow assets
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d

# Route to index.php
RewriteRule ^(.*)$ index.php?url=$1 [QSA,L]
```

**4. Hapus folder `public/` yang sudah kosong**

**5. Update `.env`:**
```env
BASE_URL=https://apkahp.demoj35.site
```

---

### 🔍 Debugging Asset

**Test URL asset langsung di browser:**

1. **Test CSS:**
   ```
   https://apkahp.demoj35.site/assets/css/main.css
   ```
   Harus menampilkan file CSS, bukan 404

2. **Test Bootstrap:**
   ```
   https://apkahp.demoj35.site/assets/vendor/bootstrap/css/bootstrap.min.css
   ```

3. **Test Image:**
   ```
   https://apkahp.demoj35.site/assets/img/logo.png
   ```

**Jika 404 Not Found:**
- Berarti structure folder salah ATAU
- .htaccess tidak berfungsi ATAU
- Permission folder salah

**Jika 403 Forbidden:**
- Permission folder terlalu ketat
- Ubah ke 755

---

### 📝 Checklist Perbaikan

- [ ] File `.env` sudah diupdate dengan `BASE_URL=https://apkahp.demoj35.site`
- [ ] Tidak ada trailing slash di BASE_URL
- [ ] Folder `public/assets/` ada dan berisi subfolder (css, js, img, vendor)
- [ ] Permission `public/assets/` = 755
- [ ] File `.htaccess` di root sudah benar
- [ ] File `public/.htaccess` sudah benar
- [ ] Test akses langsung: `https://apkahp.demoj35.site/assets/css/main.css` → file muncul
- [ ] Clear browser cache (Ctrl + Shift + R)
- [ ] Homepage bisa dibuka tanpa error
- [ ] Login page style sudah muncul

---

### 🆘 Jika Masih Belum Work

**1. Cek via Browser Developer Tools:**
- Tekan F12
- Tab "Network"
- Refresh halaman
- Lihat request yang failed (merah)
- Klik request → Tab "Headers" → lihat Request URL
- Pastikan URL asset benar: `https://apkahp.demoj35.site/assets/...`

**2. Cek Error Log:**
- cPanel → File Manager
- Klik ikon "Show Hidden Files" (titik di pojok kanan atas)
- Cari file `error_log` di root subdomain
- Baca error terakhir

**3. Hubungi Support Hosting:**
Tanyakan apakah:
- mod_rewrite sudah enabled?
- AllowOverride All sudah enabled?
- PHP version minimal 7.4?

**4. Test Sederhana:**
Buat file `test.html` di `public_html/apkahp.demoj35.site/assets/`:
```html
<!DOCTYPE html>
<html>
<head><title>Test</title></head>
<body><h1>Asset folder works!</h1></body>
</html>
```

Akses: `https://apkahp.demoj35.site/assets/test.html`

Jika TIDAK muncul → masalah permission atau .htaccess
Jika MUNCUL → masalah di konfigurasi aplikasi (cek BASE_URL)

---

### 📞 Kontak Jika Butuh Bantuan

Kirim info berikut:
1. Screenshot error di browser (F12 → Network tab)
2. Isi file `.env` (TANPA password)
3. Isi file `.htaccess` (root dan public)
4. Screenshot struktur folder di File Manager

---

**Good luck! 🚀**
