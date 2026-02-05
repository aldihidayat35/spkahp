<?php
$host = 'localhost';
$dbname = 'spk_ahp';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "=== Struktur Tabel Kurikulum ===\n";
    $stmt = $pdo->query("DESCRIBE kurikulum");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($columns as $col) {
        echo "{$col['Field']} - {$col['Type']}\n";
    }
    
    echo "\n=== Struktur Tabel mata_kuliah ===\n";
    $stmt = $pdo->query("DESCRIBE mata_kuliah");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($columns as $col) {
        echo "{$col['Field']} - {$col['Type']}\n";
    }
    
    echo "\n=== Struktur Tabel mahasiswa ===\n";
    $stmt = $pdo->query("DESCRIBE mahasiswa");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($columns as $col) {
        echo "{$col['Field']} - {$col['Type']}\n";
    }
    
    echo "\n=== Data Kurikulum ===\n";
    $stmt = $pdo->query("SELECT * FROM kurikulum");
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    print_r($data);
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
