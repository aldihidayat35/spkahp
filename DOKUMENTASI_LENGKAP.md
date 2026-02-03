# 📚 DOKUMENTASI LENGKAP APLIKASI SPK AHP
## Sistem Pendukung Keputusan Pemilihan Tema PKL Menggunakan Metode AHP

---

## 📋 DAFTAR ISI

1. [Tentang Aplikasi](#tentang-aplikasi)
2. [Teknologi yang Digunakan](#teknologi-yang-digunakan)
3. [Struktur Aplikasi](#struktur-aplikasi)
4. [Alur Pembuatan Aplikasi](#alur-pembuatan-aplikasi)
5. [Cara Kerja Aplikasi](#cara-kerja-aplikasi)
6. [Metode AHP](#metode-ahp)
7. [Fitur-Fitur](#fitur-fitur)
8. [Database Schema](#database-schema)
9. [API & Endpoints](#api-endpoints)
10. [Deployment](#deployment)
11. [Troubleshooting](#troubleshooting)

---

## 🎯 TENTANG APLIKASI

### Deskripsi
Aplikasi **SPK AHP (Sistem Pendukung Keputusan - Analytical Hierarchy Process)** adalah sistem berbasis web yang membantu mahasiswa dalam memilih tema Praktik Kerja Lapangan (PKL) yang sesuai dengan kemampuan akademik mereka.

### Tujuan
- Memberikan rekomendasi tema PKL yang objektif berdasarkan nilai mata kuliah mahasiswa
- Menggunakan metode AHP untuk perhitungan yang sistematis dan terstruktur
- Memudahkan dosen dalam memonitor pemilihan tema PKL mahasiswa
- Memberikan transparansi dalam proses pemilihan tema

### Manfaat
- **Untuk Mahasiswa:** Mendapat rekomendasi tema PKL yang sesuai dengan kompetensi
- **Untuk Dosen:** Monitoring dan evaluasi pemilihan tema mahasiswa
- **Untuk Admin:** Pengelolaan data master dan konfigurasi sistem

---

## 💻 TEKNOLOGI YANG DIGUNAKAN

### Backend
- **PHP Native 7.4+** - Server-side programming
- **MySQL 5.7+** - Database management
- **PDO** - Database abstraction layer dengan prepared statements

### Frontend
- **HTML5** - Markup language
- **CSS3** - Styling
- **Bootstrap 5.3.0** - CSS framework
- **Bootstrap Icons 1.11.0** - Icon library
- **JavaScript (Vanilla)** - Client-side scripting

### Design System
- **Metronic 8 (Custom)** - Modern admin template design
- **Google Fonts (Inter)** - Typography

### Development Tools
- **Laragon** - Local development environment
- **Git** - Version control
- **VS Code** - Code editor

### Deployment
- **Shared Hosting** - Production environment
- **Subdomain:** apkahp.demoj35.site

---

## 📁 STRUKTUR APLIKASI

### Arsitektur: MVC (Model-View-Controller)

```
SPK_AHP/
│
├── .env                          # Environment configuration
├── .htaccess                     # Apache rewrite rules
├── index.php                     # Application entry point
│
├── app/                          # Application core
│   ├── controllers/              # Controllers (Business Logic)
│   │   ├── Admin.php            # Admin controller
│   │   ├── Dosen.php            # Dosen controller
│   │   ├── Mahasiswa.php        # Mahasiswa controller
│   │   ├── Auth.php             # Authentication controller
│   │   └── Home.php             # Homepage controller
│   │
│   ├── models/                   # Models (Data Layer)
│   │   ├── AlternatifModel.php  # Alternatif tema model
│   │   ├── AuthModel.php        # Authentication model
│   │   ├── KriteriaModel.php    # Kriteria model
│   │   ├── MahasiswaModel.php   # Mahasiswa model
│   │   ├── MataKuliahModel.php  # Mata kuliah model
│   │   ├── Model.php            # Base model
│   │   └── User.php             # User model
│   │
│   └── views/                    # Views (Presentation Layer)
│       ├── layouts/             # Layout templates
│       │   ├── admin_header.php
│       │   ├── admin_footer.php
│       │   ├── dosen_header.php
│       │   ├── mahasiswa_header.php
│       │   └── mahasiswa_footer.php
│       │
│       ├── admin/               # Admin views
│       │   ├── dashboard.php
│       │   ├── users/
│       │   ├── mahasiswa/
│       │   ├── kriteria/
│       │   ├── alternatif/
│       │   ├── matakuliah/
│       │   ├── pairwise/
│       │   ├── laporan/
│       │   └── visualisasi/
│       │
│       ├── dosen/               # Dosen views
│       │   ├── dashboard.php
│       │   ├── mahasiswa/
│       │   ├── laporan/
│       │   └── visualisasi/
│       │
│       ├── mahasiswa/           # Mahasiswa views
│       │   ├── dashboard.php
│       │   ├── profil.php
│       │   ├── nilai/
│       │   ├── rekomendasi/
│       │   └── riwayat/
│       │
│       ├── auth/                # Authentication views
│       │   ├── login.php
│       │   └── register.php
│       │
│       └── home/                # Public views
│           └── index.php
│
├── core/                         # Core framework
│   ├── App.php                  # Application router
│   ├── Controller.php           # Base controller
│   └── Database.php             # Database connection
│
├── helpers/                      # Helper functions
│   ├── helpers.php              # General helpers
│   └── ahp.php                  # AHP algorithm implementation
│
├── config/                       # Configuration files
│   └── config.php               # Application config
│
├── public/                       # Public assets
│   └── assets/
│       ├── css/                 # Stylesheets
│       │   ├── style.css
│       │   ├── admin.css
│       │   └── metronic.css
│       ├── js/                  # JavaScript files
│       │   └── main.js
│       └── images/              # Images
│
├── database/                     # Database files
│   ├── spk_ahp.sql             # Database schema & data
│   └── migrations/              # Database migrations
│
├── logs/                         # Application logs
│   └── app.log
│
└── docs/                         # Documentation
    ├── README_SPK_AHP.md
    ├── SETUP_SUBDOMAIN.md
    ├── DEBUG_PAIRWISE_ALTERNATIF.md
    ├── FIX_SUMMARY.md
    └── DOKUMENTASI_LENGKAP.md (this file)
```

### Penjelasan Struktur

#### 1. **Root Directory**
- `.env` - Menyimpan konfigurasi environment (database, URL, dll)
- `.htaccess` - Routing dan URL rewriting
- `index.php` - Entry point aplikasi, load semua component

#### 2. **app/** - Aplikasi Utama
**controllers/** - Menangani request dan business logic
- `Admin.php` - CRUD data, pairwise comparison, laporan
- `Dosen.php` - Monitoring mahasiswa dan rekomendasi
- `Mahasiswa.php` - Dashboard, profil, hitung rekomendasi
- `Auth.php` - Login, register, logout
- `Home.php` - Homepage public

**models/** - Interaksi dengan database
- Setiap model mewakili satu tabel database
- Menggunakan PDO dengan prepared statements
- Inheritance dari base `Model.php`

**views/** - Template HTML dengan PHP
- Terpisah per role (admin, dosen, mahasiswa)
- Menggunakan layout untuk header/footer
- Data dikirim dari controller sebagai array

#### 3. **core/** - Framework Core
- `App.php` - Router, parse URL, load controller
- `Controller.php` - Base class dengan helper methods
- `Database.php` - PDO connection dengan singleton pattern

#### 4. **helpers/** - Helper Functions
- `helpers.php` - Fungsi umum (url, asset, flash, validate, dll)
- `ahp.php` - Implementasi algoritma AHP

#### 5. **public/assets/** - Static Files
- CSS untuk styling (Bootstrap + custom)
- JavaScript untuk interactivity
- Images dan icon

---

## 🔨 ALUR PEMBUATAN APLIKASI

### Phase 1: Planning & Design (Hari 1-2)

#### 1.1 Analisis Kebutuhan
```
✅ Identifikasi stakeholder (Admin, Dosen, Mahasiswa)
✅ Definisi fitur per role
✅ Pemilihan metode (AHP)
✅ Penentuan kriteria dan alternatif
```

#### 1.2 Design Database
```sql
-- 10 tabel utama:
1. users              -- User authentication
2. mahasiswa          -- Data mahasiswa
3. kriteria           -- Kriteria penilaian
4. alternatif_tema    -- Tema PKL
5. mata_kuliah        -- Master mata kuliah
6. nilai_mahasiswa    -- Nilai per mata kuliah
7. pairwise_kriteria  -- Perbandingan berpasangan kriteria
8. pairwise_alternatif-- Perbandingan alternatif per kriteria
9. relevance_mapping  -- Mapping kriteria-alternatif
10. hasil_rekomendasi -- Output rekomendasi
```

#### 1.3 Design Architecture
```
Arsitektur: MVC Pattern
- Separation of concerns
- Reusable components
- Maintainable code
```

### Phase 2: Setup Project (Hari 3)

#### 2.1 Environment Setup
```bash
# Install Laragon (Apache, PHP, MySQL)
# Create project structure
mkdir SPK_AHP
cd SPK_AHP

# Initialize directories
mkdir -p app/{controllers,models,views}
mkdir -p core
mkdir -p helpers
mkdir -p config
mkdir -p public/assets/{css,js,images}
mkdir database
mkdir logs
```

#### 2.2 Core Framework
```php
// 1. Database.php - PDO connection
// 2. App.php - Router
// 3. Controller.php - Base controller
// 4. Model.php - Base model
```

#### 2.3 Configuration
```php
// .env file
DB_HOST=localhost
DB_NAME=spk_ahp
DB_USER=root
DB_PASS=

BASE_URL=http://localhost/SPK_AHP
APP_NAME=SPK AHP PKL
```

### Phase 3: Database Implementation (Hari 4-5)

#### 3.1 Create Database
```sql
CREATE DATABASE spk_ahp;
USE spk_ahp;
```

#### 3.2 Create Tables
```sql
-- Users table dengan role-based access
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE,
    password VARCHAR(255),
    nama VARCHAR(100),
    role ENUM('admin','dosen','mahasiswa'),
    is_active BOOLEAN DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Mahasiswa table
CREATE TABLE mahasiswa (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    nim VARCHAR(20) UNIQUE,
    nama VARCHAR(100),
    angkatan VARCHAR(4),
    minat_utama VARCHAR(100),
    email VARCHAR(100),
    no_hp VARCHAR(15),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- ... (10 tables total)
```

#### 3.3 Insert Sample Data
```sql
-- Admin user
INSERT INTO users VALUES (1, 'admin', 'hashed_password', 'Administrator', 'admin', 1, NOW());

-- Kriteria (5 kriteria)
INSERT INTO kriteria VALUES 
(1, 'K1', 'Pemrograman Web', ...),
(2, 'K2', 'Database', ...),
...;

-- Alternatif Tema (6 tema)
INSERT INTO alternatif_tema VALUES
(1, 'T1', 'Web Development', ...),
(2, 'T2', 'Mobile Development', ...),
...;
```

### Phase 4: Authentication System (Hari 6-7)

#### 4.1 Auth Model
```php
class AuthModel {
    public function login($username, $password)
    public function register($data)
    public function logout()
    public function isLoggedIn()
    public function hasRole($role)
}
```

#### 4.2 Auth Controller
```php
class Auth extends Controller {
    public function login()
    public function register()
    public function logout()
    public function changePassword()
}
```

#### 4.3 Session Management
```php
// Set session setelah login
$_SESSION['user_id'] = $user['id'];
$_SESSION['username'] = $user['username'];
$_SESSION['role'] = $user['role'];
$_SESSION['logged_in'] = true;
```

### Phase 5: Admin Panel (Hari 8-12)

#### 5.1 Dashboard
- Statistik (total mahasiswa, kriteria, alternatif)
- Recent mahasiswa
- Statistik tema populer

#### 5.2 CRUD Operations
```php
// Kelola User
- addUser()
- editUser()
- deleteUser()
- resetPassword()

// Kelola Kriteria
- addKriteria()
- editKriteria()
- deleteKriteria()

// Kelola Alternatif
- addAlternatif()
- editAlternatif()
- deleteAlternatif()

// Kelola Mata Kuliah
- addMatakuliah()
- editMatakuliah()
- deleteMatakuliah()
```

#### 5.3 Pairwise Comparison
```php
// Perbandingan Kriteria
public function pairwiseKriteria() {
    // Input perbandingan berpasangan
    // Hitung bobot dengan AHP
    // Update bobot kriteria
}

// Perbandingan Alternatif
public function pairwiseAlternatif($kriteria_id) {
    // Pilih kriteria
    // Input perbandingan per kriteria
    // Hitung prioritas alternatif
}
```

### Phase 6: AHP Algorithm (Hari 13-15)

#### 6.1 Implementasi AHP
```php
class AHP {
    // 1. Build comparison matrix
    public static function buildMatrix($items, $comparisons)
    
    // 2. Normalize matrix
    public static function normalizeMatrix($matrix)
    
    // 3. Calculate priority vector (eigenvector)
    public static function calculatePriorityVector($normalizedMatrix)
    
    // 4. Calculate consistency ratio
    public static function calculateConsistencyRatio($matrix, $weights)
    
    // 5. Process complete AHP
    public static function processAHP($items, $comparisons)
}
```

#### 6.2 Consistency Check
```php
// Random Index (RI) values
$RI = [0, 0, 0.58, 0.9, 1.12, 1.24, 1.32, 1.41, 1.45, 1.49];

// CI = (λmax - n) / (n - 1)
// CR = CI / RI
// Konsisten jika CR <= 0.1
```

### Phase 7: Mahasiswa Panel (Hari 16-18)

#### 7.1 Dashboard
- Profile summary
- Nilai mata kuliah
- Rekomendasi tema (jika sudah dihitung)

#### 7.2 Perhitungan Rekomendasi
```php
public function hitungRekomendasi() {
    // 1. Get nilai mahasiswa per kriteria
    // 2. Get bobot kriteria
    // 3. Get bobot alternatif per kriteria
    // 4. Hitung score total untuk tiap alternatif
    // 5. Ranking berdasarkan score
    // 6. Save ke database
}
```

#### 7.3 Lihat Hasil
- Top 3 rekomendasi
- Percentage score
- Detail per kriteria

### Phase 8: Dosen Panel (Hari 19-20)

#### 8.1 Features
- Lihat data mahasiswa
- Lihat detail mahasiswa & nilai
- Laporan rekomendasi
- Visualisasi AHP

#### 8.2 Implementation
```php
class Dosen extends Controller {
    public function dashboard()
    public function mahasiswa()
    public function detailMahasiswa($id)
    public function laporan()
    public function visualisasi()
}
```

### Phase 9: UI/UX Enhancement (Hari 21-23)

#### 9.1 Design System
- Metronic 8 custom components
- Gradient cards
- Modern badges
- Icon integration

#### 9.2 Responsive Design
- Bootstrap grid system
- Mobile-friendly tables
- Adaptive navigation

#### 9.3 Interactive Elements
- Form validation
- Confirmation dialogs
- Flash messages
- Loading states

### Phase 10: Testing & Debugging (Hari 24-26)

#### 10.1 Unit Testing
- Test setiap CRUD operation
- Test AHP calculation
- Test authentication

#### 10.2 Bug Fixes
```
✅ Fixed: Homepage tidak load (.htaccess)
✅ Fixed: Detail mahasiswa undefined keys
✅ Fixed: Pairwise alternatif tidak muncul (GET parameter)
✅ Fixed: Delete user tidak bisa (POST method)
✅ Fixed: Asset loading di subdomain
✅ Fixed: Dashboard dosen statistik tema
```

### Phase 11: Documentation (Hari 27-28)

#### 11.1 Code Documentation
- Inline comments
- PHPDoc blocks
- README files

#### 11.2 User Documentation
- Installation guide
- User manual
- Troubleshooting guide

### Phase 12: Deployment (Hari 29-30)

#### 12.1 Local Testing
```bash
# Test di Laragon
http://localhost/SPK_AHP
```

#### 12.2 Production Deployment
```bash
# Upload ke shared hosting
# Setup subdomain: apkahp.demoj35.site
# Configure .env
# Import database
# Set permissions
```

---

## ⚙️ CARA KERJA APLIKASI

### 1. Application Flow

```
User Request
    ↓
index.php (Entry Point)
    ↓
.htaccess (URL Rewriting)
    ↓
App.php (Router)
    ↓
Parse URL → /controller/method/params
    ↓
Load Controller
    ↓
Execute Method
    ↓
Load Model (if needed)
    ↓
Query Database
    ↓
Process Data
    ↓
Load View
    ↓
Render HTML
    ↓
Response to User
```

### 2. Authentication Flow

```
Login Page
    ↓
User input username & password
    ↓
AuthController::login()
    ↓
AuthModel::login()
    ↓
Query database
    ↓
Verify password (password_verify)
    ↓
Set session
    ↓
Redirect based on role:
    - admin → admin/dashboard
    - dosen → dosen/dashboard
    - mahasiswa → mahasiswa/dashboard
```

### 3. AHP Calculation Flow

#### Step 1: Perbandingan Berpasangan Kriteria
```
Admin → Pairwise Kriteria
    ↓
Input perbandingan (1-9 scale)
    ↓
Build comparison matrix
    ↓
Normalize matrix
    ↓
Calculate eigenvector (bobot kriteria)
    ↓
Check consistency (CR <= 0.1)
    ↓
Update bobot kriteria di database
```

#### Step 2: Perbandingan Berpasangan Alternatif
```
Admin → Pairwise Alternatif
    ↓
Pilih kriteria
    ↓
Input perbandingan untuk semua pasangan alternatif
    ↓
Build comparison matrix per kriteria
    ↓
Normalize matrix
    ↓
Calculate priority vector (bobot alternatif per kriteria)
    ↓
Save ke database
```

#### Step 3: Perhitungan Rekomendasi Mahasiswa
```
Mahasiswa → Hitung Rekomendasi
    ↓
Get nilai mahasiswa per mata kuliah
    ↓
Group nilai per kriteria
    ↓
Normalize nilai (0-100 scale)
    ↓
Get bobot kriteria
    ↓
Get bobot alternatif per kriteria
    ↓
Calculate score untuk setiap alternatif:
    Score(A) = Σ (Bobot_Kriteria × Nilai_Normalized × Bobot_Alternatif)
    ↓
Ranking berdasarkan total score
    ↓
Save hasil ke database
    ↓
Display top 3 rekomendasi
```

### 4. Database Query Flow

#### Example: Get Mahasiswa dengan User Info
```php
// MahasiswaModel.php
public function findByIdWithUser($id) {
    $query = "SELECT m.*, u.username, u.is_active 
              FROM mahasiswa m
              JOIN users u ON m.user_id = u.id
              WHERE m.id = :id";
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    return $stmt->fetch();
}
```

### 5. View Rendering Flow

```
Controller
    ↓
Prepare data array
    ↓
$data = [
    'title' => 'Page Title',
    'csrf_token' => '...',
    'users' => [...],
    ...
];
    ↓
$this->view('admin/users/index', $data)
    ↓
Load header (admin_header.php)
    ↓
Load view (index.php)
    ↓
Access data: <?= $data['title'] ?>
    ↓
Load footer (admin_footer.php)
    ↓
Output HTML
```

### 6. Security Flow

#### CSRF Protection
```php
// Generate token
public function generateCSRF() {
    $token = bin2hex(random_bytes(32));
    $_SESSION['csrf_token'] = $token;
    return $token;
}

// Validate token
public function validateCSRF() {
    if (!isset($_POST['csrf_token']) || 
        $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die('CSRF token validation failed');
    }
}
```

#### SQL Injection Protection
```php
// Using prepared statements
$query = "SELECT * FROM users WHERE username = :username";
$stmt = $this->db->prepare($query);
$stmt->bindParam(':username', $username);
$stmt->execute();
```

#### XSS Protection
```php
// Escape output
function escape($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

// In view
<?= escape($user['nama']) ?>
```

---

## 📊 METODE AHP (ANALYTICAL HIERARCHY PROCESS)

### Konsep Dasar AHP

AHP adalah metode pengambilan keputusan yang dikembangkan oleh Thomas L. Saaty. Metode ini memecah masalah kompleks menjadi hierarki dan menggunakan perbandingan berpasangan untuk menentukan prioritas.

### Mode Bobot Kriteria

Sistem ini mendukung dua mode penentuan bobot kriteria:

#### 1. Mode Bobot Tetap (Fixed Weights) - AKTIF
Dalam mode ini, bobot kriteria ditentukan secara eksplisit berdasarkan nilai tetap yang telah ditetapkan. Mode ini memberikan konsistensi dan kontrol penuh terhadap prioritas kriteria.

**Konfigurasi:** File `config/ahp_settings.php`
```php
return [
    'enforce_fixed_weights' => true, // Aktifkan mode bobot tetap
    'fixed_kriteria' => [
        'nilai mahasiswa' => 5,      // Skor: 5
        'keunikan' => 9,              // Skor: 9 (Tertinggi)
        'minat&bakat' => 8,           // Skor: 8
        'minat' => 8,                 // Alias untuk minat&bakat
        'waktu pengerjaan' => 5,      // Skor: 5
        'referensi terbaru' => 7,     // Skor: 7
        'ketersediaan dosen' => 7     // Skor: 7
    ]
];
```

**Normalisasi Bobot:**
Total skor = 5 + 9 + 8 + 5 + 7 + 7 = 41

Bobot akhir (normalized):
- Nilai Mahasiswa: 5/41 = 0.122 (12.2%)
- Keunikan: 9/41 = 0.220 (22.0%) ← Prioritas tertinggi
- Minat & Bakat: 8/41 = 0.195 (19.5%)
- Waktu Pengerjaan: 5/41 = 0.122 (12.2%)
- Referensi Terbaru: 7/41 = 0.171 (17.1%)
- Ketersediaan Dosen: 7/41 = 0.171 (17.1%)

**Cara Kerja:**
1. Sistem membaca skor dari config
2. Mencocokkan nama kriteria di database dengan config (case-insensitive, partial match)
3. Menormalisasi skor menjadi bobot (jumlah = 1.0)
4. Menggunakan bobot ini untuk perhitungan rekomendasi
5. Pairwise comparison kriteria tidak akan mengubah bobot

**Keuntungan:**
- ✅ Konsisten dan dapat diprediksi
- ✅ Kontrol penuh atas prioritas kriteria
- ✅ Tidak perlu input pairwise comparison
- ✅ CR (Consistency Ratio) = 0 (tidak ada inkonsistensi)

#### 2. Mode Pairwise Comparison (Dynamic Weights) - NON-AKTIF
Dalam mode ini, bobot dihitung dinamis menggunakan perbandingan berpasangan antar kriteria.

**Untuk mengaktifkan mode ini:**
Ubah `enforce_fixed_weights` menjadi `false` di `config/ahp_settings.php`

### Langkah-Langkah AHP

#### 1. Membangun Hierarki
```
Goal: Memilih Tema PKL
    ↓
Kriteria (dengan bobot tetap):
- Nilai Mahasiswa (12.2%)
- Keunikan (22.0%) ← Prioritas tertinggi
- Minat & Bakat (19.5%)
- Waktu Pengerjaan (12.2%)
- Referensi Terbaru (17.1%)
- Ketersediaan Dosen (17.1%)
    ↓
Alternatif:
- Web Development (A1)
- Mobile Development (A2)
- Data Science (A3)
- UI/UX Design (A4)
- IoT Development (A5)
- Game Development (A6)
```

#### 2. Perbandingan Berpasangan

**Skala Saaty (1-9):**
| Nilai | Keterangan |
|-------|------------|
| 1 | Sama penting |
| 3 | Sedikit lebih penting |
| 5 | Lebih penting |
| 7 | Sangat lebih penting |
| 9 | Mutlak lebih penting |
| 2,4,6,8 | Nilai antara |

**Catatan:** Dalam mode bobot tetap, perbandingan berpasangan kriteria tidak digunakan. Hanya perbandingan alternatif per kriteria yang tetap diperlukan.

**Contoh Matrix Perbandingan Kriteria (Mode Dynamic):**
```
       K1   K2   K3   K4   K5
K1  [  1    3    5    7    3  ]
K2  [ 1/3   1    3    5    3  ]
K3  [ 1/5  1/3   1    3    1  ]
K4  [ 1/7  1/5  1/3   1   1/3 ]
K5  [ 1/3  1/3   1    3    1  ]
```

#### 3. Normalisasi Matrix

```php
// Hitung jumlah setiap kolom
for ($j = 0; $j < $n; $j++) {
    $sum = 0;
    for ($i = 0; $i < $n; $i++) {
        $sum += $matrix[$i][$j];
    }
    $colSums[$j] = $sum;
}

// Normalisasi: bagi setiap elemen dengan jumlah kolomnya
for ($i = 0; $i < $n; $i++) {
    for ($j = 0; $j < $n; $j++) {
        $normalized[$i][$j] = $matrix[$i][$j] / $colSums[$j];
    }
}
```

#### 4. Hitung Priority Vector (Eigenvector)

```php
// Mode Bobot Tetap (Fixed Weights)
if ($enforce_fixed_weights) {
    // Normalisasi skor dari config
    $totalScore = array_sum($fixedScores);
    foreach ($fixedScores as $id => $score) {
        $weights[$id] = $score / $totalScore;
    }
} else {
    // Mode Dynamic: Rata-rata setiap baris
    for ($i = 0; $i < $n; $i++) {
        $sum = 0;
        for ($j = 0; $j < $n; $j++) {
            $sum += $normalized[$i][$j];
        }
        $weights[$i] = $sum / $n;
    }
}
```

**Contoh Output Bobot Kriteria (Fixed Weights):**
- Keunikan: 0.220 (22.0%) ← Tertinggi
- Minat & Bakat: 0.195 (19.5%)
- Referensi Terbaru: 0.171 (17.1%)
- Ketersediaan Dosen: 0.171 (17.1%)
- Nilai Mahasiswa: 0.122 (12.2%)
- Waktu Pengerjaan: 0.122 (12.2%)
- K2 (Database): 0.263 (26.3%)
- K3 (Mobile Dev): 0.132 (13.2%)
- K4 (Data Science): 0.070 (7.0%)
- K5 (UI/UX): 0.116 (11.6%)

#### 5. Uji Konsistensi

```php
// Calculate λmax (lambda max)
$lambdaMax = 0;
for ($j = 0; $j < $n; $j++) {
    $sum = 0;
    for ($i = 0; $i < $n; $i++) {
        $sum += $matrix[$i][$j];
    }
    $lambdaMax += $sum * $weights[$j];
}

// Calculate CI (Consistency Index)
$CI = ($lambdaMax - $n) / ($n - 1);

// Calculate CR (Consistency Ratio)
$RI = [0, 0, 0.58, 0.9, 1.12, 1.24, 1.32, 1.41];
$CR = $CI / $RI[$n - 1];

// Konsisten jika CR <= 0.1
if ($CR <= 0.1) {
    echo "Konsisten!";
}
```

#### 6. Perhitungan Skor Akhir

```php
// Untuk setiap alternatif
foreach ($alternatif as $alt) {
    $totalScore = 0;
    
    // Untuk setiap kriteria
    foreach ($kriteria as $krit) {
        // Nilai mahasiswa untuk kriteria ini (normalized)
        $nilaiMhs = getNilaiMahasiswa($mahasiswa_id, $krit['id']);
        
        // Bobot kriteria
        $bobotKrit = $krit['bobot'];
        
        // Bobot alternatif untuk kriteria ini
        $bobotAlt = getBobotAlternatif($alt['id'], $krit['id']);
        
        // Hitung kontribusi
        $kontribusi = $nilaiMhs * $bobotKrit * $bobotAlt;
        $totalScore += $kontribusi;
    }
    
    $hasilRekomendasi[] = [
        'alternatif_id' => $alt['id'],
        'nama_tema' => $alt['nama_tema'],
        'total_score' => $totalScore
    ];
}

// Ranking
usort($hasilRekomendasi, function($a, $b) {
    return $b['total_score'] <=> $a['total_score'];
});
```

### Relevance Mapping (Fallback)

Jika pairwise alternatif belum diinput, sistem menggunakan **relevance mapping**:

```php
// Mapping kriteria ke alternatif dengan skor relevansi
$mapping = [
    'Pemrograman Web' => [
        'Web Development' => 0.9,
        'Mobile Development' => 0.3,
        'Data Science' => 0.5,
        ...
    ],
    ...
];
```

---

## ✨ FITUR-FITUR

### Role: ADMIN

#### 1. Dashboard
- **Statistik Cards:**
  - Total Mahasiswa
  - Mahasiswa Sudah Rekomendasi
  - Total Kriteria
  - Tema Alternatif
- **Mahasiswa Terbaru:** Tabel 5 mahasiswa terakhir
- **Statistik Tema PKL:** Chart tema populer

#### 2. Kelola User
- **CRUD User:**
  - Tambah user (admin/dosen/mahasiswa)
  - Edit user
  - Delete user
  - Reset password
- **Filter by Role**
- **Status Aktif/Nonaktif**

#### 3. Data Mahasiswa
- **List Mahasiswa:** Tabel dengan filter
- **Detail Mahasiswa:**
  - Biodata lengkap
  - Nilai mata kuliah
  - Hasil rekomendasi
  - Statistik

#### 4. Kelola Kriteria
- **CRUD Kriteria:**
  - Tambah kriteria baru
  - Edit kriteria
  - Delete kriteria
- **Set Bobot:** Manual atau via AHP

#### 5. Kelola Alternatif
- **CRUD Alternatif Tema:**
  - Tambah tema PKL
  - Edit tema
  - Delete tema
- **Icon & Deskripsi**

#### 6. Kelola Mata Kuliah
- **CRUD Mata Kuliah:**
  - Tambah mata kuliah
  - Mapping ke kriteria
  - Set bobot mata kuliah

#### 7. Pairwise Comparison
- **Perbandingan Kriteria:**
  - Input perbandingan berpasangan
  - Auto-calculate bobot
  - Consistency check
- **Perbandingan Alternatif:**
  - Pilih kriteria
  - Input perbandingan per kriteria
  - Calculate priority vector

#### 8. Visualisasi AHP
- **Process Flow:** 4 langkah AHP
- **Kriteria Weights:** Bar chart
- **Alternatif Cards:** Grid dengan icon
- **Relevance Matrix:** Heatmap
- **Recent Recommendations:** Tabel

#### 9. Laporan
- **Laporan Rekomendasi:**
  - Filter by mahasiswa
  - Export data
  - Statistik tema
  
### Role: DOSEN

#### 1. Dashboard
- **Statistik:** Mahasiswa, rekomendasi, tema
- **Quick Access Menu**

#### 2. Data Mahasiswa
- **View Only:**
  - List mahasiswa
  - Detail mahasiswa
  - Nilai & rekomendasi

#### 3. Laporan
- **Statistik Tema:** Ranking popularitas
- **Daftar Rekomendasi:** Per mahasiswa

#### 4. Visualisasi AHP
- **Sama seperti admin** (read-only)

### Role: MAHASISWA

#### 1. Dashboard
- **Profile Card:** Biodata
- **Statistik Personal:**
  - Total nilai mata kuliah
  - Rata-rata nilai
  - Status rekomendasi
- **Quick Actions**

#### 2. Profil
- **View & Edit:**
  - Data personal
  - Email & no HP
  - Minat utama

#### 3. Nilai Mata Kuliah
- **List Nilai:**
  - Tabel nilai per mata kuliah
  - Grade & kriteria
  - Filtering

#### 4. Hitung Rekomendasi
- **Process:**
  1. Sistem ambil nilai mahasiswa
  2. Hitung dengan metode AHP
  3. Generate top 3 rekomendasi
- **Output:**
  - Ranking tema
  - Percentage score
  - Detail per kriteria

#### 5. Lihat Hasil
- **Top 3 Rekomendasi:**
  - Tema dengan score tertinggi
  - Visualisasi progress bar
  - Deskripsi tema
- **Detail Score:** Breakdown per kriteria

#### 6. Riwayat
- **History Perhitungan:**
  - Tanggal perhitungan
  - Hasil sebelumnya
  - Consistency ratio

---

## 🗄️ DATABASE SCHEMA

### Diagram ERD

```
users (1) ----→ (1) mahasiswa
  ↓
  └─→ role: admin/dosen/mahasiswa

mahasiswa (1) ----→ (*) nilai_mahasiswa
mahasiswa (1) ----→ (*) hasil_rekomendasi

kriteria (1) ----→ (*) mata_kuliah
kriteria (1) ----→ (*) pairwise_kriteria
kriteria (1) ----→ (*) pairwise_alternatif
kriteria (1) ----→ (*) relevance_mapping

alternatif_tema (1) ----→ (*) pairwise_alternatif
alternatif_tema (1) ----→ (*) relevance_mapping
alternatif_tema (1) ----→ (*) hasil_rekomendasi

mata_kuliah (1) ----→ (*) nilai_mahasiswa
```

### Tabel Details

#### 1. users
```sql
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    nama VARCHAR(100) NOT NULL,
    role ENUM('admin', 'dosen', 'mahasiswa') NOT NULL,
    is_active BOOLEAN DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```
**Purpose:** User authentication & authorization  
**Relationships:** 1-to-1 dengan mahasiswa

#### 2. mahasiswa
```sql
CREATE TABLE mahasiswa (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    nim VARCHAR(20) UNIQUE NOT NULL,
    nama VARCHAR(100) NOT NULL,
    angkatan VARCHAR(4) NOT NULL,
    minat_utama VARCHAR(100),
    email VARCHAR(100),
    no_hp VARCHAR(15),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```
**Purpose:** Data mahasiswa  
**Relationships:** 
- Belongs to users
- Has many nilai_mahasiswa
- Has many hasil_rekomendasi

#### 3. kriteria
```sql
CREATE TABLE kriteria (
    id INT PRIMARY KEY AUTO_INCREMENT,
    kode_kriteria VARCHAR(10) UNIQUE NOT NULL,
    nama_kriteria VARCHAR(100) NOT NULL,
    bobot DECIMAL(10,6) DEFAULT 0,
    jenis ENUM('benefit', 'cost') DEFAULT 'benefit',
    keterangan TEXT,
    is_active BOOLEAN DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```
**Purpose:** Master kriteria penilaian  
**Fields:**
- `bobot`: Dihitung dari AHP pairwise
- `jenis`: Benefit (max) atau Cost (min)

#### 4. alternatif_tema
```sql
CREATE TABLE alternatif_tema (
    id INT PRIMARY KEY AUTO_INCREMENT,
    kode_tema VARCHAR(10) UNIQUE NOT NULL,
    nama_tema VARCHAR(100) NOT NULL,
    deskripsi TEXT,
    icon VARCHAR(50),
    is_active BOOLEAN DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```
**Purpose:** Master tema PKL (alternatif)

#### 5. mata_kuliah
```sql
CREATE TABLE mata_kuliah (
    id INT PRIMARY KEY AUTO_INCREMENT,
    kode_matkul VARCHAR(10) UNIQUE NOT NULL,
    nama_matkul VARCHAR(100) NOT NULL,
    kriteria_id INT,
    bobot_matkul DECIMAL(5,2) DEFAULT 1,
    is_active BOOLEAN DEFAULT 1,
    FOREIGN KEY (kriteria_id) REFERENCES kriteria(id)
);
```
**Purpose:** Master mata kuliah  
**Relationships:** Many-to-one dengan kriteria

#### 6. nilai_mahasiswa
```sql
CREATE TABLE nilai_mahasiswa (
    id INT PRIMARY KEY AUTO_INCREMENT,
    mahasiswa_id INT NOT NULL,
    matkul_id INT NOT NULL,
    nilai DECIMAL(5,2) NOT NULL,
    grade VARCHAR(2),
    semester VARCHAR(10),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (mahasiswa_id) REFERENCES mahasiswa(id) ON DELETE CASCADE,
    FOREIGN KEY (matkul_id) REFERENCES mata_kuliah(id)
);
```
**Purpose:** Nilai mahasiswa per mata kuliah

#### 7. pairwise_kriteria
```sql
CREATE TABLE pairwise_kriteria (
    id INT PRIMARY KEY AUTO_INCREMENT,
    kriteria_1 INT NOT NULL,
    kriteria_2 INT NOT NULL,
    nilai DECIMAL(10,6) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (kriteria_1) REFERENCES kriteria(id),
    FOREIGN KEY (kriteria_2) REFERENCES kriteria(id),
    UNIQUE KEY unique_pair (kriteria_1, kriteria_2)
);
```
**Purpose:** Perbandingan berpasangan kriteria  
**Note:** Jika A vs B = 3, maka B vs A = 1/3

#### 8. pairwise_alternatif
```sql
CREATE TABLE pairwise_alternatif (
    id INT PRIMARY KEY AUTO_INCREMENT,
    kriteria_id INT NOT NULL,
    alternatif_1 INT NOT NULL,
    alternatif_2 INT NOT NULL,
    nilai DECIMAL(10,6) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (kriteria_id) REFERENCES kriteria(id),
    FOREIGN KEY (alternatif_1) REFERENCES alternatif_tema(id),
    FOREIGN KEY (alternatif_2) REFERENCES alternatif_tema(id),
    UNIQUE KEY unique_comparison (kriteria_id, alternatif_1, alternatif_2)
);
```
**Purpose:** Perbandingan alternatif per kriteria

#### 9. relevance_mapping
```sql
CREATE TABLE relevance_mapping (
    id INT PRIMARY KEY AUTO_INCREMENT,
    kriteria_id INT NOT NULL,
    alternatif_id INT NOT NULL,
    relevance_score DECIMAL(5,4) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (kriteria_id) REFERENCES kriteria(id),
    FOREIGN KEY (alternatif_id) REFERENCES alternatif_tema(id),
    UNIQUE KEY unique_mapping (kriteria_id, alternatif_id)
);
```
**Purpose:** Fallback jika pairwise belum lengkap  
**Range:** 0.0 - 1.0

#### 10. hasil_rekomendasi
```sql
CREATE TABLE hasil_rekomendasi (
    id INT PRIMARY KEY AUTO_INCREMENT,
    mahasiswa_id INT NOT NULL,
    alternatif_id INT NOT NULL,
    total_score DECIMAL(10,6) NOT NULL,
    ranking INT NOT NULL,
    consistency_ratio DECIMAL(10,6),
    detail_score JSON,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (mahasiswa_id) REFERENCES mahasiswa(id) ON DELETE CASCADE,
    FOREIGN KEY (alternatif_id) REFERENCES alternatif_tema(id)
);
```
**Purpose:** Output rekomendasi  
**Fields:**
- `detail_score`: JSON berisi score per kriteria
- `consistency_ratio`: CR dari AHP

---

## 🔌 API & ENDPOINTS

### Public Routes
```
GET  /                          → Home::index()
GET  /auth/login               → Auth::login()
POST /auth/login               → Auth::login() (process)
GET  /auth/register            → Auth::register()
POST /auth/register            → Auth::register() (process)
GET  /auth/logout              → Auth::logout()
```

### Admin Routes (Requires admin role)
```
Dashboard:
GET  /admin                     → Admin::dashboard()
GET  /admin/dashboard          → Admin::dashboard()

Users:
GET  /admin/users              → Admin::users()
GET  /admin/addUser            → Admin::addUser()
POST /admin/addUser            → Admin::addUser() (create)
GET  /admin/editUser/{id}      → Admin::editUser()
POST /admin/editUser/{id}      → Admin::editUser() (update)
POST /admin/deleteUser/{id}    → Admin::deleteUser()
POST /admin/resetPassword/{id} → Admin::resetPassword()

Mahasiswa:
GET  /admin/mahasiswa          → Admin::mahasiswa()
GET  /admin/detailMahasiswa/{id} → Admin::detailMahasiswa()

Kriteria:
GET  /admin/kriteria           → Admin::kriteria()
GET  /admin/addKriteria        → Admin::addKriteria()
POST /admin/addKriteria        → Admin::addKriteria() (create)
GET  /admin/editKriteria/{id}  → Admin::editKriteria()
POST /admin/editKriteria/{id}  → Admin::editKriteria() (update)
POST /admin/deleteKriteria/{id} → Admin::deleteKriteria()

Alternatif:
GET  /admin/alternatif         → Admin::alternatif()
GET  /admin/addAlternatif      → Admin::addAlternatif()
POST /admin/addAlternatif      → Admin::addAlternatif() (create)
GET  /admin/editAlternatif/{id} → Admin::editAlternatif()
POST /admin/editAlternatif/{id} → Admin::editAlternatif() (update)
POST /admin/deleteAlternatif/{id} → Admin::deleteAlternatif()

Mata Kuliah:
GET  /admin/matakuliah         → Admin::matakuliah()
GET  /admin/addMatakuliah      → Admin::addMatakuliah()
POST /admin/addMatakuliah      → Admin::addMatakuliah() (create)

Pairwise:
GET  /admin/pairwiseKriteria   → Admin::pairwiseKriteria()
POST /admin/savePairwiseKriteria → Admin::savePairwiseKriteria()
GET  /admin/pairwiseAlternatif?kriteria_id={id} → Admin::pairwiseAlternatif()
POST /admin/savePairwiseAlternatif → Admin::savePairwiseAlternatif()

Reports:
GET  /admin/visualisasi        → Admin::visualisasi()
GET  /admin/laporan            → Admin::laporan()
```

### Dosen Routes (Requires dosen role)
```
GET  /dosen                     → Dosen::dashboard()
GET  /dosen/dashboard          → Dosen::dashboard()
GET  /dosen/mahasiswa          → Dosen::mahasiswa()
GET  /dosen/detailMahasiswa/{id} → Dosen::detailMahasiswa()
GET  /dosen/laporan            → Dosen::laporan()
GET  /dosen/visualisasi        → Dosen::visualisasi()
```

### Mahasiswa Routes (Requires mahasiswa role)
```
GET  /mahasiswa                → Mahasiswa::dashboard()
GET  /mahasiswa/dashboard      → Mahasiswa::dashboard()
GET  /mahasiswa/profil         → Mahasiswa::profil()
POST /mahasiswa/updateProfil   → Mahasiswa::updateProfil()
GET  /mahasiswa/nilai          → Mahasiswa::nilai()
GET  /mahasiswa/rekomendasi    → Mahasiswa::rekomendasi()
POST /mahasiswa/hitungRekomendasi → Mahasiswa::hitungRekomendasi()
GET  /mahasiswa/riwayat        → Mahasiswa::riwayat()
```

### Common Routes (All authenticated users)
```
GET  /auth/changePassword      → Auth::changePassword()
POST /auth/changePassword      → Auth::changePassword() (update)
```

---

## 🚀 DEPLOYMENT

### Local Development (Laragon)

#### 1. Install Laragon
```
Download: https://laragon.org/
Install dengan PHP 7.4+, MySQL 5.7+, Apache
```

#### 2. Setup Project
```bash
# Clone atau copy project ke
C:\laragon\www\SPK_AHP\

# Import database
mysql -u root -p spk_ahp < database/spk_ahp.sql
```

#### 3. Configure .env
```env
DB_HOST=localhost
DB_NAME=spk_ahp
DB_USER=root
DB_PASS=

BASE_URL=http://localhost/SPK_AHP
APP_NAME=SPK AHP PKL
SESSION_LIFETIME=3600
```

#### 4. Set Permissions
```bash
# Windows - tidak perlu chmod
# Pastikan folder writable:
logs/
```

#### 5. Access
```
http://localhost/SPK_AHP
```

### Production Deployment (Shared Hosting)

#### 1. Prepare Files
```bash
# Zip project (exclude logs, .git)
zip -r spk_ahp.zip . -x "logs/*" ".git/*" ".env"
```

#### 2. Upload to Server
```
- Login cPanel
- File Manager → public_html/subdomain_folder/
- Upload & Extract
```

#### 3. Setup Database
```sql
-- Create database via cPanel → MySQL Databases
-- Import spk_ahp.sql via phpMyAdmin
```

#### 4. Configure .env
```env
DB_HOST=localhost
DB_NAME=username_spkahp
DB_USER=username_dbuser
DB_PASS=your_password

BASE_URL=https://apkahp.demoj35.site
APP_NAME=SPK AHP PKL
SESSION_LIFETIME=3600
```

#### 5. Set Permissions
```bash
chmod 755 -R assets/
chmod 755 -R app/
chmod 755 logs/
chmod 644 .env
chmod 644 .htaccess
```

#### 6. .htaccess Configuration
```apache
# Root .htaccess
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php?url=$1 [QSA,L]

# Redirect www to non-www (optional)
RewriteCond %{HTTP_HOST} ^www\.(.*)$ [NC]
RewriteRule ^(.*)$ https://%1/$1 [R=301,L]
```

#### 7. Test
```
https://apkahp.demoj35.site
```

### SSL Certificate
```
- Via cPanel → SSL/TLS
- Let's Encrypt (Free)
- Auto-install
```

### Backup Strategy
```bash
# Database backup (daily)
mysqldump -u user -p spk_ahp > backup_$(date +%Y%m%d).sql

# File backup (weekly)
tar -czf backup_files_$(date +%Y%m%d).tar.gz /path/to/SPK_AHP
```

---

## 🔧 TROUBLESHOOTING

### 1. Homepage Tidak Load (404)

**Problem:** Menampilkan directory listing atau 404

**Solution:**
```apache
# .htaccess di root
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteBase /SPK_AHP/
    
    # Redirect root ke index.php
    RewriteRule ^$ index.php [L]
    
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^(.*)$ index.php?url=$1 [QSA,L]
</IfModule>
```

### 2. Assets Tidak Load (CSS/JS)

**Problem:** Style tidak muncul, broken layout

**Solution:**
```php
// helpers/helpers.php - Check BASE_URL
function asset($path) {
    return BASE_URL . '/public/assets/' . ltrim($path, '/');
}

// .env - Pastikan BASE_URL benar
BASE_URL=https://apkahp.demoj35.site  # Tanpa trailing slash
```

### 3. Database Connection Failed

**Problem:** Error "Connection failed"

**Solution:**
```php
// Check .env credentials
DB_HOST=localhost
DB_NAME=correct_db_name
DB_USER=correct_username
DB_PASS=correct_password

// Test connection
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    echo "Connected!";
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
```

### 4. Session Tidak Persist

**Problem:** Logout otomatis, session hilang

**Solution:**
```php
// config/config.php
session_start();
ini_set('session.gc_maxlifetime', 3600);
session_set_cookie_params(3600);

// Check session timeout
if (time() - $_SESSION['last_activity'] > 3600) {
    session_destroy();
}
$_SESSION['last_activity'] = time();
```

### 5. Pairwise Alternatif Matrix Tidak Muncul

**Problem:** Dropdown kriteria tidak trigger matrix

**Solution:**
```php
// Admin.php - Method pairwiseAlternatif
public function pairwiseAlternatif($kriteria_id = null) {
    // FIX: Get parameter dari GET request
    if (!$kriteria_id && isset($_GET['kriteria_id'])) {
        $kriteria_id = $_GET['kriteria_id'];
    }
    // ... rest of code
}
```

### 6. Delete User Tidak Berfungsi

**Problem:** Click delete tidak ada efek

**Solution:**
```html
<!-- Ganti link jadi form POST -->
<form method="POST" action="<?= url('admin/deleteUser/' . $user['id']) ?>">
    <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
    <button type="submit" onclick="return confirm('Yakin?')">
        Delete
    </button>
</form>
```

### 7. Undefined Array Key

**Problem:** Warning "Undefined array key 'is_active'"

**Solution:**
```php
// Use null coalescing operator
<?= $user['is_active'] ?? 0 ?>

// Or check with isset
<?php if (isset($user['is_active']) && $user['is_active']): ?>
```

### 8. AHP Calculation Error

**Problem:** Division by zero, inconsistent results

**Solution:**
```php
// Check matrix size
if (count($items) < 2) {
    return ['error' => 'Minimum 2 items required'];
}

// Check for zero division
if ($colSum == 0) {
    $colSum = 1; // Prevent division by zero
}

// Validate comparisons
if (empty($comparisons)) {
    return ['error' => 'No comparisons data'];
}
```

### 9. File Upload Issues

**Problem:** Upload gagal (jika ada fitur upload)

**Solution:**
```php
// Check permissions
chmod 755 uploads/

// php.ini settings
upload_max_filesize = 10M
post_max_size = 10M
max_execution_time = 300

// Validate file
if ($_FILES['file']['error'] !== UPLOAD_ERR_OK) {
    throw new Exception('Upload failed');
}
```

### 10. Performance Issues

**Problem:** Loading lambat

**Solution:**
```sql
-- Add indexes
CREATE INDEX idx_mahasiswa_user ON mahasiswa(user_id);
CREATE INDEX idx_nilai_mahasiswa ON nilai_mahasiswa(mahasiswa_id);
CREATE INDEX idx_hasil_mahasiswa ON hasil_rekomendasi(mahasiswa_id);

-- Optimize queries
EXPLAIN SELECT * FROM ...;

-- Enable query cache (if MySQL 5.7)
SET GLOBAL query_cache_size = 67108864;
```

---

## 📝 CATATAN PENTING

### Best Practices

#### 1. Security
```php
// Always use prepared statements
$stmt = $db->prepare("SELECT * FROM users WHERE id = :id");
$stmt->bindParam(':id', $id);

// Always escape output
<?= escape($user['name']) ?>

// Always validate CSRF
$this->validateCSRF();

// Always hash passwords
password_hash($password, PASSWORD_DEFAULT);
```

#### 2. Code Organization
```
- Satu controller untuk satu resource
- Satu model untuk satu tabel
- Pisahkan business logic dari view
- Gunakan helper untuk fungsi reusable
```

#### 3. Database
```sql
-- Gunakan FOREIGN KEY
FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE

-- Set INDEX untuk query cepat
CREATE INDEX idx_name ON table(column);

-- Gunakan ENUM untuk field terbatas
role ENUM('admin', 'dosen', 'mahasiswa')
```

#### 4. Error Handling
```php
try {
    // Code
} catch (PDOException $e) {
    error_log($e->getMessage());
    return ['success' => false, 'message' => 'Database error'];
}
```

### Known Limitations

1. **Single Server:** Tidak support distributed system
2. **No API:** Hanya web interface, belum ada REST API
3. **File Upload:** Belum ada fitur upload dokumen
4. **Real-time:** Tidak ada WebSocket/real-time updates
5. **Email:** Belum ada notifikasi email
6. **Export:** Belum ada export PDF/Excel

### Future Enhancements

1. **REST API** untuk mobile app
2. **Export to PDF/Excel** untuk laporan
3. **Email Notification** untuk hasil rekomendasi
4. **File Upload** untuk dokumen mahasiswa
5. **Advanced Analytics** dengan chart interaktif
6. **Multi-language** support (EN/ID)
7. **Dark Mode** UI option
8. **Batch Import** untuk data mahasiswa via Excel
9. **API Integration** dengan SIAKAD
10. **Machine Learning** untuk improve recommendation

---

## 📚 REFERENSI

### Dokumentasi
- [PHP Manual](https://www.php.net/manual/en/)
- [MySQL Reference](https://dev.mysql.com/doc/)
- [Bootstrap 5 Docs](https://getbootstrap.com/docs/5.3/)
- [PDO Tutorial](https://phpdelusions.net/pdo)

### AHP References
- Saaty, T.L. (1980). The Analytic Hierarchy Process
- [AHP Wikipedia](https://en.wikipedia.org/wiki/Analytic_hierarchy_process)
- Tutorial AHP: [YouTube](https://www.youtube.com/results?search_query=ahp+tutorial)

### Design Resources
- [Metronic Admin Template](https://keenthemes.com/metronic/)
- [Bootstrap Icons](https://icons.getbootstrap.com/)
- [Google Fonts](https://fonts.google.com/)

---

## 👨‍💻 CREDITS

**Developer:** Aldi Hidayat  
**GitHub:** @aldihidayat35  
**Repository:** spkahp  
**Version:** 1.0.0  
**Last Update:** December 17, 2025

---

## 📞 SUPPORT

Untuk pertanyaan atau bantuan:
1. Check dokumentasi ini terlebih dahulu
2. Review file troubleshooting: `DEBUG_*.md`
3. Check GitHub Issues
4. Contact developer

---

**Happy Coding! 🚀**

*Dokumentasi ini akan terus diupdate sesuai perkembangan aplikasi.*
