#!/usr/bin/env php
<?php
/**
 * Database Migration Script
 * Run all migrations in sequence
 */

$host = 'localhost';
$dbname = 'spk_ahp';
$username = 'root';
$password = '';

echo "\n";
echo "╔════════════════════════════════════════════╗\n";
echo "║   SPK AHP - Database Migration Tool       ║\n";
echo "╚════════════════════════════════════════════╝\n";
echo "\n";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
    
    echo "✓ Connected to database: $dbname\n\n";
    
    // List of migration files
    $migrations = [
        'migration_revisi_2026.sql' => 'Migration Revisi 2026 (KHS, Kurikulum, Judul)',
        'migration_kurikulum_revisi.sql' => 'Migration Kurikulum Update (Foreign Keys)'
    ];
    
    $total_success = 0;
    $total_errors = 0;
    
    foreach ($migrations as $file => $description) {
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
        echo "Running: $description\n";
        echo "File: $file\n";
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
        
        $filepath = __DIR__ . '/' . $file;
        
        if (!file_exists($filepath)) {
            echo "⚠ Warning: File not found - $file (skipping)\n\n";
            continue;
        }
        
        $sql = file_get_contents($filepath);
        
        // Split by semicolon but keep it for execution
        $statements = array_filter(array_map('trim', explode(';', $sql)));
        
        $success = 0;
        $errors = 0;
        
        foreach ($statements as $statement) {
            if (empty($statement) || 
                substr($statement, 0, 2) === '--' || 
                substr($statement, 0, 2) === '/*') {
                continue;
            }
            
            try {
                $pdo->exec($statement);
                $success++;
                echo ".";
            } catch (PDOException $e) {
                $errors++;
                // Check if it's a benign error (table exists, column exists, etc)
                $errorCode = $e->getCode();
                $errorMsg = $e->getMessage();
                
                if (strpos($errorMsg, 'Duplicate key name') !== false ||
                    strpos($errorMsg, 'Duplicate column') !== false ||
                    strpos($errorMsg, 'already exists') !== false ||
                    strpos($errorMsg, 'Table') !== false && strpos($errorMsg, 'already exists') !== false) {
                    echo "s"; // s = skipped (already exists)
                } else {
                    echo "!";
                    // Uncomment to see errors:
                    // echo "\n⚠ " . substr($errorMsg, 0, 100) . "\n";
                }
            }
        }
        
        echo "\n";
        echo "✓ Executed: $success statements\n";
        if ($errors > 0) {
            echo "⚠ Skipped/Errors: $errors statements\n";
        }
        echo "\n";
        
        $total_success += $success;
        $total_errors += $errors;
    }
    
    // Add foto column if not exists
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    echo "Running: Add foto column to users\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    
    try {
        $stmt = $pdo->query("SHOW COLUMNS FROM users LIKE 'foto'");
        $result = $stmt->fetchAll();
        
        if (count($result) == 0) {
            $pdo->exec("ALTER TABLE `users` ADD COLUMN `foto` varchar(255) DEFAULT NULL AFTER `role`");
            echo "✓ Column 'foto' added successfully!\n";
        } else {
            echo "s Column 'foto' already exists (skipped)\n";
        }
    } catch (PDOException $e) {
        echo "⚠ Warning: " . $e->getMessage() . "\n";
    }
    
    echo "\n";
    
    // Verification
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    echo "VERIFICATION\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    
    $tables = [
        'kurikulum' => 'Kurikulum',
        'matkul_kurikulum' => 'Mata Kuliah Kurikulum (linking)',
        'judul_kating' => 'Judul Kating (2021)',
        'mahasiswa_judul' => 'Mahasiswa Judul',
        'khs_upload' => 'KHS Upload'
    ];
    
    foreach ($tables as $table => $name) {
        try {
            $stmt = $pdo->query("SELECT COUNT(*) as count FROM $table");
            $count = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
            echo "✓ $name: $count records\n";
        } catch (PDOException $e) {
            echo "✗ $name: NOT FOUND\n";
        }
    }
    
    echo "\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    echo "SUMMARY\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    echo "✓ Total Success: $total_success statements\n";
    echo "⚠ Total Skipped: $total_errors statements\n";
    echo "\n";
    echo "╔════════════════════════════════════════════╗\n";
    echo "║        ✓ Migration Completed!             ║\n";
    echo "╚════════════════════════════════════════════╝\n";
    echo "\n";
    
} catch (PDOException $e) {
    echo "\n";
    echo "╔════════════════════════════════════════════╗\n";
    echo "║        ✗ Migration Failed!                ║\n";
    echo "╚════════════════════════════════════════════╝\n";
    echo "\n";
    echo "Error: " . $e->getMessage() . "\n\n";
    exit(1);
}
