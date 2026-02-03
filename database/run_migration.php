<?php
/**
 * Run Database Migration
 * Execute: php database/run_migration.php
 */

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';

$db = new Database();
$conn = $db->getConnection();

// Read SQL file
$sql_file = __DIR__ . '/migrations/add_new_features.sql';
$sql = file_get_contents($sql_file);

// Split by semicolon and execute each statement
$statements = array_filter(
    array_map('trim', explode(';', $sql)),
    function($stmt) {
        return !empty($stmt) && !preg_match('/^--/', $stmt);
    }
);

echo "Running migration...\n";
echo str_repeat('=', 70) . "\n";

$success_count = 0;
$error_count = 0;

foreach ($statements as $index => $statement) {
    if (empty($statement)) continue;
    
    try {
        $conn->exec($statement);
        $success_count++;
        
        // Extract table name for display
        if (preg_match('/CREATE TABLE.*?`?(\w+)`?/i', $statement, $matches)) {
            echo "✓ Created table: {$matches[1]}\n";
        } elseif (preg_match('/ALTER TABLE `?(\w+)`?/i', $statement, $matches)) {
            echo "✓ Altered table: {$matches[1]}\n";
        } elseif (preg_match('/INSERT INTO `?(\w+)`?/i', $statement, $matches)) {
            echo "✓ Inserted data into: {$matches[1]}\n";
        } else {
            echo "✓ Executed statement #" . ($index + 1) . "\n";
        }
    } catch (PDOException $e) {
        $error_count++;
        // Skip if table already exists
        if (strpos($e->getMessage(), 'already exists') !== false || 
            strpos($e->getMessage(), 'Duplicate column') !== false) {
            echo "⊘ Skipped (already exists)\n";
        } else {
            echo "✗ Error: " . $e->getMessage() . "\n";
        }
    }
}

echo str_repeat('=', 70) . "\n";
echo "Migration completed!\n";
echo "Success: $success_count | Errors: $error_count\n";

// Create upload directories
$upload_dirs = [
    ROOT_PATH . '/uploads/foto_user',
    ROOT_PATH . '/uploads/khs'
];

echo "\nCreating upload directories...\n";
foreach ($upload_dirs as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
        echo "✓ Created: $dir\n";
    } else {
        echo "⊘ Already exists: $dir\n";
    }
}

echo "\n✅ All done!\n";
