<?php

return [
    // When true, the system will use these fixed criterion scores and
    // normalize them to produce final criterion weights used by the SPK.
    'enforce_fixed_weights' => false,

    // Raw scores for each criterion (the values you provided).
    // Matching is case-insensitive and will try substring matches on `nama_kriteria`.
    // 
    // MAPPING BERDASARKAN KRITERIA AKTUAL DI DATABASE:
    // - Kemampuan Pemrograman    → Score 5 (Nilai Mahasiswa)
    // - Kemampuan Multimedia     → Score 9 (Keunikan - Tertinggi)
    // - Minat dan Motivasi       → Score 8 (Minat & Bakat)
    // - Kemampuan Jaringan       → Score 5 (Waktu Pengerjaan)
    // - Kemampuan Kependidikan   → Score 7 (Referensi Terbaru)
    'fixed_kriteria' => [
        // Nama kriteria sesuai database
        'kemampuan pemrograman' => 5,
        'kemampuan multimedia' => 9,
        'minat dan motivasi' => 8,
        'kemampuan jaringan' => 5,
        'kemampuan kependidikan' => 7,
        
        // Alias untuk compatibility
        'pemrograman' => 5,
        'multimedia' => 9,
        'minat' => 8,
        'motivasi' => 8,
        'jaringan' => 5,
        'kependidikan' => 7,
        
        // Original requirement names (untuk backward compatibility)
        'nilai mahasiswa' => 5,
        'keunikan' => 9,
        'minat&bakat' => 8,
        'waktu pengerjaan' => 5,
        'referensi terbaru' => 7,
        'ketersediaan dosen' => 7
    ]
];
