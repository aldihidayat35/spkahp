<?php

/**
 * AHP Helper Functions
 * Fungsi-fungsi untuk perhitungan metode AHP
 */

class AHP {
    /**
     * Random Index (RI) untuk perhitungan Consistency Ratio
     */
    private static $RI = [
        1 => 0.00,
        2 => 0.00,
        3 => 0.58,
        4 => 0.90,
        5 => 1.12,
        6 => 1.24,
        7 => 1.32,
        8 => 1.41,
        9 => 1.45,
        10 => 1.49,
        11 => 1.51,
        12 => 1.48,
        13 => 1.56,
        14 => 1.57,
        15 => 1.59
    ];

    /**
     * Membuat matriks pairwise comparison lengkap
     * @param array $items Array of items to compare
     * @param array $comparisons Array of pairwise comparisons
     * @return array Complete pairwise matrix
     */
    public static function buildPairwiseMatrix($items, $comparisons) {
        $n = count($items);
        $matrix = array_fill(0, $n, array_fill(0, $n, 0));

        // Diagonal = 1
        for ($i = 0; $i < $n; $i++) {
            $matrix[$i][$i] = 1;
        }

        // Fill from comparisons
        foreach ($comparisons as $comp) {
            $i = array_search($comp['item1'], $items);
            $j = array_search($comp['item2'], $items);
            
            if ($i !== false && $j !== false) {
                $matrix[$i][$j] = $comp['value'];
                $matrix[$j][$i] = 1 / $comp['value']; // Reciprocal
            }
        }

        return $matrix;
    }

    /**
     * Normalisasi matriks
     * @param array $matrix
     * @return array Normalized matrix
     */
    public static function normalizeMatrix($matrix) {
        $n = count($matrix);
        $normalized = array_fill(0, $n, array_fill(0, $n, 0));
        
        // Calculate column sums
        $columnSums = array_fill(0, $n, 0);
        for ($j = 0; $j < $n; $j++) {
            for ($i = 0; $i < $n; $i++) {
                $columnSums[$j] += $matrix[$i][$j];
            }
        }

        // Normalize each element
        for ($i = 0; $i < $n; $i++) {
            for ($j = 0; $j < $n; $j++) {
                $normalized[$i][$j] = $columnSums[$j] > 0 ? $matrix[$i][$j] / $columnSums[$j] : 0;
            }
        }

        return $normalized;
    }

    /**
     * Hitung priority vector (eigenvector) dari matriks ternormalisasi
     * @param array $normalizedMatrix
     * @return array Priority vector
     */
    public static function calculatePriorityVector($normalizedMatrix) {
        $n = count($normalizedMatrix);
        $priorityVector = array_fill(0, $n, 0);

        for ($i = 0; $i < $n; $i++) {
            $sum = 0;
            for ($j = 0; $j < $n; $j++) {
                $sum += $normalizedMatrix[$i][$j];
            }
            $priorityVector[$i] = $sum / $n;
        }

        return $priorityVector;
    }

    /**
     * Hitung weighted sum vector
     * @param array $matrix
     * @param array $priorityVector
     * @return array Weighted sum vector
     */
    public static function calculateWeightedSum($matrix, $priorityVector) {
        $n = count($matrix);
        $weightedSum = array_fill(0, $n, 0);

        for ($i = 0; $i < $n; $i++) {
            for ($j = 0; $j < $n; $j++) {
                $weightedSum[$i] += $matrix[$i][$j] * $priorityVector[$j];
            }
        }

        return $weightedSum;
    }

    /**
     * Hitung lambda max (eigenvalue maksimum)
     * @param array $weightedSum
     * @param array $priorityVector
     * @return float Lambda max
     */
    public static function calculateLambdaMax($weightedSum, $priorityVector) {
        $n = count($weightedSum);
        $lambdaMax = 0;

        for ($i = 0; $i < $n; $i++) {
            if ($priorityVector[$i] > 0) {
                $lambdaMax += $weightedSum[$i] / $priorityVector[$i];
            }
        }

        return $lambdaMax / $n;
    }

    /**
     * Hitung Consistency Index (CI)
     * @param float $lambdaMax
     * @param int $n Size of matrix
     * @return float CI
     */
    public static function calculateCI($lambdaMax, $n) {
        if ($n <= 1) return 0;
        return ($lambdaMax - $n) / ($n - 1);
    }

    /**
     * Hitung Consistency Ratio (CR)
     * @param float $ci
     * @param int $n Size of matrix
     * @return float CR
     */
    public static function calculateCR($ci, $n) {
        if ($n <= 2) return 0;
        $ri = self::$RI[$n] ?? 1.49;
        return $ri > 0 ? $ci / $ri : 0;
    }

    /**
     * Proses lengkap AHP untuk satu matriks
     * @param array $items
     * @param array $comparisons
     * @return array Result with weights and consistency
     */
    public static function processAHP($items, $comparisons) {
        // Build matrix
        $matrix = self::buildPairwiseMatrix($items, $comparisons);
        
        // Normalize matrix
        $normalized = self::normalizeMatrix($matrix);
        
        // Calculate priority vector (weights)
        $weights = self::calculatePriorityVector($normalized);
        
        // Calculate consistency
        $weightedSum = self::calculateWeightedSum($matrix, $weights);
        $lambdaMax = self::calculateLambdaMax($weightedSum, $weights);
        $n = count($items);
        $ci = self::calculateCI($lambdaMax, $n);
        $cr = self::calculateCR($ci, $n);
        
        return [
            'matrix' => $matrix,
            'normalized' => $normalized,
            'weights' => $weights,
            'lambda_max' => $lambdaMax,
            'ci' => $ci,
            'cr' => $cr,
            'is_consistent' => $cr <= 0.1
        ];
    }

    /**
     * Hitung skor akhir alternatif
     * @param array $criteriaWeights Bobot kriteria
     * @param array $alternativeWeights Bobot alternatif per kriteria [kriteria_id => [alt_id => weight]]
     * @return array Final scores for each alternative
     */
    public static function calculateFinalScores($criteriaWeights, $alternativeWeights) {
        $finalScores = [];

        foreach ($alternativeWeights as $criteriaId => $altWeights) {
            $criteriaWeight = $criteriaWeights[$criteriaId] ?? 0;
            
            foreach ($altWeights as $altId => $weight) {
                if (!isset($finalScores[$altId])) {
                    $finalScores[$altId] = 0;
                }
                $finalScores[$altId] += $weight * $criteriaWeight;
            }
        }

        return $finalScores;
    }

    /**
     * Ranking alternatif berdasarkan skor
     * @param array $scores
     * @return array Ranked alternatives
     */
    public static function rankAlternatives($scores) {
        arsort($scores);
        $ranked = [];
        $rank = 1;
        
        foreach ($scores as $altId => $score) {
            $ranked[$altId] = [
                'score' => $score,
                'rank' => $rank++
            ];
        }
        
        return $ranked;
    }

    /**
     * Generate matriks pairwise dari nilai mahasiswa
     * Untuk membandingkan alternatif berdasarkan nilai mata kuliah
     * @param array $nilai Array nilai per alternatif
     * @return array Pairwise comparisons
     */
    public static function generatePairwiseFromNilai($nilai) {
        $comparisons = [];
        $alternatives = array_keys($nilai);
        $n = count($alternatives);

        for ($i = 0; $i < $n; $i++) {
            for ($j = $i + 1; $j < $n; $j++) {
                $alt1 = $alternatives[$i];
                $alt2 = $alternatives[$j];
                
                $nilai1 = $nilai[$alt1];
                $nilai2 = $nilai[$alt2];

                // Hitung rasio perbandingan
                if ($nilai2 > 0) {
                    $ratio = $nilai1 / $nilai2;
                } else {
                    $ratio = $nilai1 > 0 ? 9 : 1;
                }

                // Konversi ke skala AHP (1-9)
                $value = self::convertToAHPScale($ratio);

                $comparisons[] = [
                    'item1' => $alt1,
                    'item2' => $alt2,
                    'value' => $value
                ];
            }
        }

        return $comparisons;
    }

    /**
     * Konversi rasio ke skala AHP (1-9)
     * @param float $ratio
     * @return float AHP scale value
     */
    private static function convertToAHPScale($ratio) {
        if ($ratio >= 2.5) return 9;
        if ($ratio >= 2.0) return 7;
        if ($ratio >= 1.5) return 5;
        if ($ratio >= 1.2) return 3;
        if ($ratio >= 0.8) return 1;
        if ($ratio >= 0.67) return 1/3;
        if ($ratio >= 0.5) return 1/5;
        if ($ratio >= 0.4) return 1/7;
        return 1/9;
    }

    /**
     * Format angka untuk tampilan
     * @param float $number
     * @param int $decimals
     * @return string
     */
    public static function formatNumber($number, $decimals = 4) {
        return number_format($number, $decimals, ',', '.');
    }

    /**
     * Get status consistency
     * @param float $cr
     * @return array Status info
     */
    public static function getConsistencyStatus($cr) {
        if ($cr <= 0.1) {
            return [
                'status' => 'Konsisten',
                'class' => 'success',
                'message' => 'Perbandingan berpasangan konsisten (CR ≤ 0,1)'
            ];
        } else {
            return [
                'status' => 'Tidak Konsisten',
                'class' => 'danger',
                'message' => 'Perbandingan berpasangan tidak konsisten (CR > 0,1). Perlu diperbaiki.'
            ];
        }
    }
}
