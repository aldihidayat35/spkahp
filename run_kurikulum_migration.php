<?php
$host = 'localhost';
$dbname = 'spk_ahp';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sql = file_get_contents(__DIR__ . '/migration_kurikulum_revisi.sql');
    
    echo "=== Running Migration ===\n\n";
    
    $pdo->exec($sql);
    
    echo "✓ Migration executed successfully!\n\n";
    
    echo "=== Verifying Changes ===\n";
    
    // Check kurikulum structure
    echo "\n1. Kurikulum table structure:\n";
    $stmt = $pdo->query("DESCRIBE kurikulum");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($columns as $col) {
        echo "   - {$col['Field']}\n";
    }
    
    // Check mata_kuliah structure
    echo "\n2. Mata_kuliah table structure:\n";
    $stmt = $pdo->query("DESCRIBE mata_kuliah");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($columns as $col) {
        echo "   - {$col['Field']}\n";
    }
    
    // Check mahasiswa structure
    echo "\n3. Mahasiswa table structure:\n";
    $stmt = $pdo->query("DESCRIBE mahasiswa");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($columns as $col) {
        echo "   - {$col['Field']}\n";
    }
    
    // Show all kurikulum
    echo "\n4. All Kurikulum:\n";
    $stmt = $pdo->query("SELECT * FROM kurikulum ORDER BY angkatan");
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($data as $row) {
        echo "   - {$row['nama_kurikulum']} ({$row['tahun_berlaku']}) - Angkatan {$row['angkatan']}\n";
    }
    
    echo "\n✓ Database ready!\n";
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
