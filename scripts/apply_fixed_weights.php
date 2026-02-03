#!/usr/bin/env php
<?php

/**
 * apply_fixed_weights.php
 * CLI script to apply fixed criterion weights from ahp_settings.php
 */

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';

$ahp_settings = require __DIR__ . '/../config/ahp_settings.php';

if (empty($ahp_settings['enforce_fixed_weights']) || empty($ahp_settings['fixed_kriteria'])) {
    die("Fixed weights are not enabled in ahp_settings.php\n");
}

$db = new Database();
$conn = $db->getConnection();

// Get all active kriteria
$stmt = $conn->prepare("SELECT * FROM kriteria WHERE is_active = 1");
$stmt->execute();
$kriteria = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($kriteria)) {
    die("No active kriteria found in database\n");
}

// Map each criterion to its score
$scoreMap = [];
$fixedScores = $ahp_settings['fixed_kriteria'];

foreach ($kriteria as $k) {
    $name = strtolower(trim($k['nama_kriteria']));
    $score = null;
    
    // Try exact match first
    if (isset($fixedScores[$name])) {
        $score = $fixedScores[$name];
    } else {
        // Try partial match
        foreach ($fixedScores as $key => $val) {
            if (stripos($name, $key) !== false || stripos($key, $name) !== false) {
                $score = $val;
                break;
            }
        }
    }
    
    if ($score === null) {
        echo "WARNING: No score found for criterion: " . $k['nama_kriteria'] . " (ID=" . $k['id'] . ")\n";
        echo "Available keys in ahp_settings: " . implode(', ', array_keys($fixedScores)) . "\n";
        echo "Defaulting to score=5\n";
        $score = 5;
    }
    
    $scoreMap[$k['id']] = $score;
    echo "Matched: {$k['nama_kriteria']} => score={$score}\n";
}

// Normalize scores to get weights (sum = 1)
$totalScore = array_sum($scoreMap);
$weightsMap = [];

foreach ($scoreMap as $id => $score) {
    $weightsMap[$id] = $score / $totalScore;
}

// Update database
echo "\nUpdating database...\n";
$stmt = $conn->prepare("UPDATE kriteria SET bobot = :bobot WHERE id = :id");

foreach ($weightsMap as $id => $weight) {
    $stmt->bindValue(':bobot', $weight, PDO::PARAM_STR);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    
    $name = '';
    foreach ($kriteria as $k) {
        if ($k['id'] == $id) {
            $name = $k['nama_kriteria'];
            break;
        }
    }
    
    echo "  Updated: {$name} (ID={$id}) => bobot=" . number_format($weight, 6) . "\n";
}

echo "\nDone! All criterion weights updated based on fixed scores.\n";
echo "Total weight sum: " . number_format(array_sum($weightsMap), 6) . "\n";

