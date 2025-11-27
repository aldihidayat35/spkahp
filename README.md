# SPK AHP - Sistem Pendukung Keputusan

Aplikasi Sistem Pendukung Keputusan menggunakan metode AHP (Analytical Hierarchy Process) dengan PHP Native.

## Fitur

- ✅ MVC Architecture
- ✅ Routing System
- ✅ Database Connection dengan PDO
- ✅ CSRF Protection
- ✅ Session Management
- ✅ Helper Functions
- ✅ Form Validation
- ✅ Flash Messages
- ✅ File Upload Support
- ✅ Responsive Design

## Struktur Folder

```
SPK_AHP/
├── app/
│   ├── controllers/        # Controller files
│   ├── models/            # Model files
│   ├── views/             # View files
│   │   ├── templates/     # Header & Footer templates
│   │   └── home/          # Home views
│   ├── core/              # Core system files
│   │   ├── App.php        # Main application
│   │   ├── Controller.php # Base controller
│   │   └── Model.php      # Base model
│   └── init.php           # Autoloader
├── config/
│   ├── config.php         # App configuration
│   └── database.php       # Database connection
├── helpers/
│   └── functions.php      # Helper functions
├── public/                # Public accessible folder
│   ├── css/              # CSS files
│   ├── js/               # JavaScript files
│   ├── img/              # Images
│   ├── .htaccess         # URL rewriting
│   └── index.php         # Entry point
├── uploads/              # Upload directory
├── .env                  # Environment variables
├── .env.example          # Environment example
├── .gitignore            # Git ignore file
├── .htaccess             # Root htaccess
└── README.md             # Documentation
```

## Instalasi

1. Clone atau download project ini ke folder `c:\laragon\www\`

2. Buat database baru dengan nama `spk_ahp`

3. Copy file `.env.example` menjadi `.env` dan sesuaikan konfigurasi database:
```env
DB_HOST=localhost
DB_NAME=spk_ahp
DB_USER=root
DB_PASS=
```

4. Buka browser dan akses:
```
http://localhost/SPK_AHP
```

## Cara Penggunaan

### Membuat Controller Baru

```php
<?php

class NamaController extends Controller {
    public function index() {
        $data = [
            'title' => 'Halaman Nama'
        ];
        
        $this->view('nama/index', $data);
    }
}
```

### Membuat Model Baru

```php
<?php

class NamaModel extends Model {
    protected $table = 'nama_tabel';
    
    public function customMethod() {
        // Custom query
    }
}
```

### Menggunakan Helper Functions

```php
// URL helpers
url('path/to/page');
asset('css/style.css');
redirect('home/about');

// Security
escape($string);
csrf_field();

// Flash messages
setFlash('success', 'Data berhasil disimpan', 'success');
getFlash('success');

// Validation
$errors = validate($_POST, [
    'email' => 'required|email',
    'password' => 'required|min:6'
]);
```

### Routing

URL Pattern: `controller/method/param1/param2`

Contoh:
- `http://localhost/SPK_AHP` → Home::index()
- `http://localhost/SPK_AHP/home/about` → Home::about()
- `http://localhost/SPK_AHP/user/edit/1` → User::edit(1)

## Database Operations

```php
// Get all records
$users = $this->model('User')->findAll();

// Get by ID
$user = $this->model('User')->findById(1);

// Create
$this->model('User')->create([
    'name' => 'John Doe',
    'email' => 'john@example.com'
]);

// Update
$this->model('User')->update(1, [
    'name' => 'Jane Doe'
]);

// Delete
$this->model('User')->delete(1);

// Custom query
$this->model('User')->query("SELECT * FROM users WHERE status = ?", [1]);
```

## Keamanan

- CSRF Protection untuk form
- PDO Prepared Statements untuk query database
- XSS Protection dengan `escape()` function
- Session management
- Password hashing (gunakan `password_hash()`)

## Requirements

- PHP 7.4 atau lebih tinggi
- MySQL/MariaDB
- Apache dengan mod_rewrite enabled
- PDO Extension

## Lisensi

Open source - silakan gunakan dan modifikasi sesuai kebutuhan.

## Kontribusi

Silakan buat pull request atau issue untuk perbaikan dan penambahan fitur.
