<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/database.php';

$database = new Database();
$db = $database->getConnection();

if ($db) {
    echo "✅ Koneksi database berhasil!<br><br>";
    
    // Test query
    try {
        $stmt = $db->query("SHOW TABLES");
        $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
        
        echo "📋 Tabel yang tersedia:<br>";
        echo "<ol>";
        foreach ($tables as $table) {
            echo "<li>$table</li>";
        }
        echo "</ol><br>";
        
        // Test data users
        $stmt = $db->query("SELECT id, username, nama, role FROM users LIMIT 5");
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo "👥 Data Users:<br>";
        echo "<table border='1' cellpadding='5'>";
        echo "<tr><th>ID</th><th>Username</th><th>Nama</th><th>Role</th></tr>";
        foreach ($users as $user) {
            echo "<tr>";
            echo "<td>{$user['id']}</td>";
            echo "<td>{$user['username']}</td>";
            echo "<td>{$user['nama']}</td>";
            echo "<td>{$user['role']}</td>";
            echo "</tr>";
        }
        echo "</table>";
        
    } catch (PDOException $e) {
        echo "❌ Error query: " . $e->getMessage();
    }
} else {
    echo "❌ Koneksi database gagal!";
}
?>
