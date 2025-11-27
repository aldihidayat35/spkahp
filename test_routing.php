<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Routing - SPK AHP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: #f5f5f5;
        }
        .test-box {
            background: white;
            padding: 20px;
            margin: 10px 0;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .success {
            color: #28a745;
            font-weight: bold;
        }
        .error {
            color: #dc3545;
            font-weight: bold;
        }
        a {
            display: inline-block;
            padding: 10px 20px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 5px;
        }
        a:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="test-box">
        <h1>🧪 Test Routing SPK AHP</h1>
        <p>Halaman ini untuk memverifikasi routing aplikasi bekerja dengan baik.</p>
    </div>

    <?php
    require_once __DIR__ . '/config/config.php';
    
    echo '<div class="test-box">';
    echo '<h2>📋 Informasi Konfigurasi</h2>';
    echo '<p><strong>BASE_URL:</strong> ' . BASE_URL . '</p>';
    echo '<p><strong>APP_PATH:</strong> ' . APP_PATH . '</p>';
    echo '<p><strong>ROOT_PATH:</strong> ' . ROOT_PATH . '</p>';
    echo '</div>';

    // Check controllers
    $controllers = ['Home', 'Auth', 'Admin', 'Mahasiswa'];
    echo '<div class="test-box">';
    echo '<h2>🎮 Controller Files</h2>';
    foreach ($controllers as $controller) {
        $file = APP_PATH . '/controllers/' . $controller . '.php';
        if (file_exists($file)) {
            echo '<p class="success">✅ ' . $controller . '.php - OK</p>';
        } else {
            echo '<p class="error">❌ ' . $controller . '.php - NOT FOUND</p>';
        }
    }
    echo '</div>';

    // Check helpers
    echo '<div class="test-box">';
    echo '<h2>🔧 Helper Files</h2>';
    $helpers = ['functions.php', 'ahp.php'];
    foreach ($helpers as $helper) {
        $file = ROOT_PATH . '/helpers/' . $helper;
        if (file_exists($file)) {
            echo '<p class="success">✅ ' . $helper . ' - OK</p>';
        } else {
            echo '<p class="error">❌ ' . $helper . ' - NOT FOUND</p>';
        }
    }
    echo '</div>';

    // Check .htaccess
    echo '<div class="test-box">';
    echo '<h2>⚙️ .htaccess Files</h2>';
    $htaccess_files = [
        ROOT_PATH . '/.htaccess' => 'Root .htaccess',
        ROOT_PATH . '/public/.htaccess' => 'Public .htaccess'
    ];
    foreach ($htaccess_files as $file => $name) {
        if (file_exists($file)) {
            echo '<p class="success">✅ ' . $name . ' - OK</p>';
        } else {
            echo '<p class="error">❌ ' . $name . ' - NOT FOUND</p>';
        }
    }
    echo '</div>';
    ?>

    <div class="test-box">
        <h2>🔗 Test Links</h2>
        <p>Klik link berikut untuk test routing:</p>
        <div>
            <a href="<?= BASE_URL ?>">Homepage</a>
            <a href="<?= BASE_URL ?>/auth/login">Login Page</a>
            <a href="<?= BASE_URL ?>/auth/register">Register Page</a>
            <a href="<?= BASE_URL ?>/test_connection.php">Test Database</a>
        </div>
    </div>

    <div class="test-box">
        <h2>📝 Akun Demo</h2>
        <p><strong>Admin:</strong> admin / password</p>
        <p><strong>Mahasiswa:</strong> 2021001 / password</p>
        <p><strong>Dosen:</strong> dosen1 / password</p>
    </div>
</body>
</html>
