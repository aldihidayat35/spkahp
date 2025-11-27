<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Pairwise Alternatif - Quick Diagnostic</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 2rem;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        h1 {
            color: #667eea;
            margin-bottom: 1rem;
            font-size: 2rem;
        }
        .status {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
        }
        .status.success {
            background: #d4edda;
            color: #155724;
            border-left: 4px solid #28a745;
        }
        .status.error {
            background: #f8d7da;
            color: #721c24;
            border-left: 4px solid #dc3545;
        }
        .status.warning {
            background: #fff3cd;
            color: #856404;
            border-left: 4px solid #ffc107;
        }
        .info-box {
            background: #e7f3ff;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            border-left: 4px solid #2196F3;
        }
        .test-section {
            margin-bottom: 2rem;
            padding: 1.5rem;
            background: #f8f9fa;
            border-radius: 8px;
        }
        .test-section h2 {
            color: #495057;
            margin-bottom: 1rem;
            font-size: 1.3rem;
            border-bottom: 2px solid #667eea;
            padding-bottom: 0.5rem;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }
        th, td {
            padding: 0.75rem;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }
        th {
            background: #667eea;
            color: white;
            font-weight: 600;
        }
        tr:hover {
            background: #f1f3f5;
        }
        .badge {
            padding: 0.25rem 0.75rem;
            border-radius: 12px;
            font-size: 0.85rem;
            font-weight: 600;
        }
        .badge.success {
            background: #28a745;
            color: white;
        }
        .badge.danger {
            background: #dc3545;
            color: white;
        }
        .badge.warning {
            background: #ffc107;
            color: #000;
        }
        .btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            margin-right: 1rem;
            margin-top: 1rem;
            transition: all 0.3s;
        }
        .btn:hover {
            background: #5568d3;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }
        .btn.secondary {
            background: #6c757d;
        }
        .btn.secondary:hover {
            background: #5a6268;
        }
        code {
            background: #f8f9fa;
            padding: 0.2rem 0.5rem;
            border-radius: 4px;
            font-family: 'Courier New', monospace;
            color: #e83e8c;
        }
        pre {
            background: #2d2d2d;
            color: #f8f8f2;
            padding: 1rem;
            border-radius: 6px;
            overflow-x: auto;
            margin-top: 1rem;
        }
        .metric {
            display: inline-block;
            padding: 1rem 1.5rem;
            background: white;
            border-radius: 8px;
            margin-right: 1rem;
            margin-bottom: 1rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .metric-value {
            font-size: 2rem;
            font-weight: bold;
            color: #667eea;
        }
        .metric-label {
            font-size: 0.9rem;
            color: #6c757d;
            margin-top: 0.25rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔍 Diagnostic Test - Pairwise Alternatif</h1>
        
        <div class="info-box">
            <strong>Tujuan:</strong> Halaman ini untuk testing apakah fix pada controller <code>Admin.php</code> berhasil menangkap parameter GET.
        </div>

        <?php
        // CONFIG
        define('ROOT_PATH', dirname(__DIR__));
        
        // Load environment
        if (file_exists(ROOT_PATH . '/.env')) {
            $env = parse_ini_file(ROOT_PATH . '/.env');
            foreach ($env as $key => $value) {
                $_ENV[$key] = $value;
                putenv("$key=$value");
            }
        }

        // Database connection
        try {
            $pdo = new PDO(
                "mysql:host=" . getenv('DB_HOST') . ";dbname=" . getenv('DB_NAME'),
                getenv('DB_USER'),
                getenv('DB_PASS')
            );
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $db_status = "success";
            $db_message = "✅ Database terhubung dengan sukses";
        } catch (PDOException $e) {
            $db_status = "error";
            $db_message = "❌ Database error: " . $e->getMessage();
        }
        ?>

        <!-- Database Status -->
        <div class="status <?= $db_status ?>">
            <?= $db_message ?>
        </div>

        <?php if ($db_status === 'success'): ?>

        <!-- Test Section 1: Data Kriteria -->
        <div class="test-section">
            <h2>1️⃣ Data Kriteria</h2>
            <?php
            $stmt = $pdo->query("SELECT COUNT(*) as total FROM kriteria WHERE is_active = 1");
            $kriteria_count = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
            
            if ($kriteria_count > 0) {
                echo '<div class="status success">✅ Ditemukan ' . $kriteria_count . ' kriteria aktif</div>';
                
                $stmt = $pdo->query("SELECT id, kode_kriteria, nama_kriteria, bobot FROM kriteria WHERE is_active = 1 ORDER BY kode_kriteria");
                $kriteria_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                echo '<table>';
                echo '<thead><tr><th>ID</th><th>Kode</th><th>Nama Kriteria</th><th>Bobot</th></tr></thead>';
                echo '<tbody>';
                foreach ($kriteria_list as $k) {
                    echo '<tr>';
                    echo '<td>' . $k['id'] . '</td>';
                    echo '<td>' . $k['kode_kriteria'] . '</td>';
                    echo '<td>' . $k['nama_kriteria'] . '</td>';
                    echo '<td>' . $k['bobot'] . '</td>';
                    echo '</tr>';
                }
                echo '</tbody></table>';
            } else {
                echo '<div class="status error">❌ Tidak ada kriteria aktif! Silakan tambahkan data kriteria terlebih dahulu.</div>';
            }
            ?>
        </div>

        <!-- Test Section 2: Data Alternatif -->
        <div class="test-section">
            <h2>2️⃣ Data Alternatif (Tema PKL)</h2>
            <?php
            $stmt = $pdo->query("SELECT COUNT(*) as total FROM alternatif WHERE is_active = 1");
            $alternatif_count = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
            
            if ($alternatif_count >= 2) {
                echo '<div class="status success">✅ Ditemukan ' . $alternatif_count . ' alternatif aktif (minimal 2 untuk perbandingan)</div>';
                
                $stmt = $pdo->query("SELECT id, kode_tema, nama_tema FROM alternatif WHERE is_active = 1 ORDER BY kode_tema");
                $alternatif_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                echo '<table>';
                echo '<thead><tr><th>ID</th><th>Kode</th><th>Nama Tema</th></tr></thead>';
                echo '<tbody>';
                foreach ($alternatif_list as $a) {
                    echo '<tr>';
                    echo '<td>' . $a['id'] . '</td>';
                    echo '<td>' . $a['kode_tema'] . '</td>';
                    echo '<td>' . $a['nama_tema'] . '</td>';
                    echo '</tr>';
                }
                echo '</tbody></table>';
            } elseif ($alternatif_count == 1) {
                echo '<div class="status warning">⚠️ Hanya ada 1 alternatif. Minimal 2 alternatif diperlukan untuk perbandingan!</div>';
            } else {
                echo '<div class="status error">❌ Tidak ada alternatif aktif! Silakan tambahkan data alternatif terlebih dahulu.</div>';
            }
            ?>
        </div>

        <!-- Test Section 3: Pairwise Data -->
        <div class="test-section">
            <h2>3️⃣ Data Pairwise Alternatif</h2>
            <?php
            $stmt = $pdo->query("SELECT COUNT(*) as total FROM pairwise_alternatif");
            $pairwise_count = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
            
            echo '<div class="metric">';
            echo '<div class="metric-value">' . $pairwise_count . '</div>';
            echo '<div class="metric-label">Total Pairwise Data</div>';
            echo '</div>';
            
            if ($alternatif_count >= 2) {
                $required = ($alternatif_count * ($alternatif_count - 1)) / 2;
                $required_total = $required * $kriteria_count;
                
                echo '<div class="metric">';
                echo '<div class="metric-value">' . $required . '</div>';
                echo '<div class="metric-label">Diperlukan per Kriteria</div>';
                echo '</div>';
                
                echo '<div class="metric">';
                echo '<div class="metric-value">' . $required_total . '</div>';
                echo '<div class="metric-label">Total Diperlukan (Semua Kriteria)</div>';
                echo '</div>';
            }
            
            if ($pairwise_count > 0) {
                echo '<div style="clear:both; margin-top: 1rem;"></div>';
                echo '<div class="status success">✅ Sudah ada data pairwise</div>';
                
                $stmt = $pdo->query("
                    SELECT 
                        k.id as kriteria_id,
                        k.nama_kriteria,
                        COUNT(pa.id) as jumlah_pairwise
                    FROM kriteria k
                    LEFT JOIN pairwise_alternatif pa ON k.id = pa.kriteria_id
                    WHERE k.is_active = 1
                    GROUP BY k.id, k.nama_kriteria
                    ORDER BY k.nama_kriteria
                ");
                $pairwise_summary = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                echo '<table>';
                echo '<thead><tr><th>Kriteria</th><th>Jumlah Pairwise</th><th>Status</th></tr></thead>';
                echo '<tbody>';
                foreach ($pairwise_summary as $ps) {
                    $required_per_kriteria = ($alternatif_count * ($alternatif_count - 1)) / 2;
                    $is_complete = ($ps['jumlah_pairwise'] >= $required_per_kriteria);
                    
                    echo '<tr>';
                    echo '<td>' . $ps['nama_kriteria'] . '</td>';
                    echo '<td>' . $ps['jumlah_pairwise'] . ' / ' . $required_per_kriteria . '</td>';
                    echo '<td>';
                    if ($is_complete) {
                        echo '<span class="badge success">Lengkap</span>';
                    } elseif ($ps['jumlah_pairwise'] > 0) {
                        echo '<span class="badge warning">Tidak Lengkap</span>';
                    } else {
                        echo '<span class="badge danger">Kosong</span>';
                    }
                    echo '</td>';
                    echo '</tr>';
                }
                echo '</tbody></table>';
            } else {
                echo '<div style="clear:both; margin-top: 1rem;"></div>';
                echo '<div class="status warning">⚠️ Belum ada data pairwise. Silakan input perbandingan melalui halaman admin.</div>';
            }
            ?>
        </div>

        <!-- Test Section 4: URL Testing -->
        <div class="test-section">
            <h2>4️⃣ URL Testing Links</h2>
            <p>Klik link di bawah untuk testing halaman Pairwise Alternatif dengan parameter:</p>
            
            <?php
            $base_url = getenv('BASE_URL') ?: 'http://localhost/SPK_AHP';
            
            if ($kriteria_count > 0) {
                echo '<div style="margin-top: 1rem;">';
                foreach ($kriteria_list as $k) {
                    $test_url = $base_url . '/admin/pairwiseAlternatif?kriteria_id=' . $k['id'];
                    echo '<a href="' . $test_url . '" class="btn" target="_blank">';
                    echo '🔗 Test: ' . $k['nama_kriteria'];
                    echo '</a>';
                }
                echo '</div>';
                
                echo '<div style="margin-top: 1rem;">';
                echo '<p><strong>Atau copy URL manual:</strong></p>';
                echo '<pre>' . $base_url . '/admin/pairwiseAlternatif?kriteria_id=1</pre>';
                echo '</div>';
            }
            ?>
        </div>

        <!-- Test Section 5: Expected Behavior -->
        <div class="test-section">
            <h2>5️⃣ Expected Behavior</h2>
            <div class="info-box">
                <h3 style="margin-bottom: 0.5rem;">Setelah klik link di atas, yang seharusnya muncul:</h3>
                <ol style="margin-left: 1.5rem; line-height: 1.8;">
                    <li>✅ Dropdown kriteria terisi dengan semua kriteria</li>
                    <li>✅ Kriteria yang dipilih sudah ter-select di dropdown</li>
                    <li>✅ <strong>Matrix perbandingan muncul</strong> (ini yang sebelumnya error)</li>
                    <li>✅ Tabel hasil AHP muncul (jika data pairwise sudah lengkap)</li>
                </ol>
            </div>
        </div>

        <!-- Test Section 6: Troubleshooting -->
        <div class="test-section">
            <h2>6️⃣ Troubleshooting</h2>
            
            <h3>❌ Jika Matrix Masih Tidak Muncul:</h3>
            <ol style="margin-left: 1.5rem; line-height: 1.8; margin-top: 0.5rem;">
                <li>Pastikan sudah login sebagai admin</li>
                <li>Check browser console (F12) untuk JavaScript errors</li>
                <li>Check Network tab untuk melihat apakah request sukses (200 OK)</li>
                <li>Pastikan <code>count(alternatif) >= 2</code> (lihat section 2)</li>
                <li>Lihat file log: <code>c:\laragon\www\SPK_AHP\logs\app.log</code></li>
            </ol>

            <h3 style="margin-top: 1rem;">📝 Cara Debugging:</h3>
            <p>Tambahkan kode berikut di <code>app/controllers/Admin.php</code> line ~555:</p>
            <pre>public function pairwiseAlternatif($kriteria_id = null) {
    // DEBUG
    error_log("=== PAIRWISE ALTERNATIF DEBUG ===");
    error_log("URL Param kriteria_id: " . ($kriteria_id ?? 'NULL'));
    error_log("GET Param kriteria_id: " . ($_GET['kriteria_id'] ?? 'NULL'));
    
    // ... rest of code</pre>
        </div>

        <!-- Action Buttons -->
        <div style="margin-top: 2rem; padding-top: 2rem; border-top: 2px solid #dee2e6;">
            <a href="<?= $base_url ?>/admin/pairwiseAlternatif" class="btn" target="_blank">
                🚀 Buka Halaman Pairwise Alternatif
            </a>
            <a href="<?= $base_url ?>/admin/dashboard" class="btn secondary" target="_blank">
                📊 Buka Dashboard Admin
            </a>
        </div>

        <?php endif; ?>

    </div>
</body>
</html>
