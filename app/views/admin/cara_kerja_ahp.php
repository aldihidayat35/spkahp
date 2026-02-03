<?php require_once APP_PATH . '/views/layouts/admin_header.php'; ?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Cara Kerja Metode AHP</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?= url('admin/dashboard') ?>">Dashboard</a></li>
        <li class="breadcrumb-item active">Cara Kerja AHP</li>
    </ol>

    <!-- Introduction -->
    <div class="card mb-4 border-primary">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="bi bi-info-circle-fill me-2"></i>Tentang Metode AHP</h5>
        </div>
        <div class="card-body">
            <p class="lead">
                <strong>Analytical Hierarchy Process (AHP)</strong> adalah metode pengambilan keputusan yang dikembangkan oleh 
                <em>Thomas L. Saaty</em> untuk membantu menentukan prioritas dari beberapa alternatif berdasarkan kriteria tertentu.
            </p>
            <div class="row mt-4">
                <div class="col-md-6">
                    <h6><i class="bi bi-check-circle text-success"></i> Kelebihan AHP:</h6>
                    <ul>
                        <li>Struktur hierarki yang jelas</li>
                        <li>Mempertimbangkan konsistensi penilaian</li>
                        <li>Dapat mengukur tingkat kepentingan relatif</li>
                        <li>Menggabungkan penilaian kualitatif dan kuantitatif</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <h6><i class="bi bi-diagram-3 text-info"></i> Komponen AHP:</h6>
                    <ul>
                        <li><strong>Kriteria:</strong> Aspek penilaian (minat, kemampuan, dll)</li>
                        <li><strong>Alternatif:</strong> Pilihan tema PKL/Tugas Akhir</li>
                        <li><strong>Pairwise Comparison:</strong> Perbandingan berpasangan</li>
                        <li><strong>Consistency Ratio:</strong> Tingkat konsistensi (≤ 0.1)</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Process Flow -->
    <div class="card mb-4">
        <div class="card-header bg-gradient" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
            <h5 class="mb-0"><i class="bi bi-diagram-3-fill me-2"></i>Alur Proses AHP di Aplikasi</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Step 1 -->
                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center">
                            <div class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center mb-3" 
                                 style="width: 60px; height: 60px; font-size: 24px; font-weight: bold;">
                                1
                            </div>
                            <h5 class="card-title">Setup Data Master</h5>
                            <p class="card-text text-muted">
                                Admin mengatur kriteria, alternatif tema, dan mata kuliah sebagai basis perhitungan.
                            </p>
                            <div class="text-start mt-3">
                                <small class="text-primary"><i class="bi bi-arrow-right-circle"></i> Kriteria (5 aspek)</small><br>
                                <small class="text-primary"><i class="bi bi-arrow-right-circle"></i> Alternatif (6 tema)</small><br>
                                <small class="text-primary"><i class="bi bi-arrow-right-circle"></i> Mata Kuliah</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center">
                            <div class="rounded-circle bg-success text-white d-inline-flex align-items-center justify-content-center mb-3" 
                                 style="width: 60px; height: 60px; font-size: 24px; font-weight: bold;">
                                2
                            </div>
                            <h5 class="card-title">Pairwise Comparison</h5>
                            <p class="card-text text-muted">
                                Admin membandingkan setiap kriteria dan alternatif secara berpasangan.
                            </p>
                            <div class="text-start mt-3">
                                <small class="text-success"><i class="bi bi-arrow-right-circle"></i> Kriteria vs Kriteria</small><br>
                                <small class="text-success"><i class="bi bi-arrow-right-circle"></i> Alternatif per Kriteria</small><br>
                                <small class="text-success"><i class="bi bi-arrow-right-circle"></i> Skala 1-9 (Saaty)</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center">
                            <div class="rounded-circle bg-warning text-white d-inline-flex align-items-center justify-content-center mb-3" 
                                 style="width: 60px; height: 60px; font-size: 24px; font-weight: bold;">
                                3
                            </div>
                            <h5 class="card-title">Input Nilai Mahasiswa</h5>
                            <p class="card-text text-muted">
                                Mahasiswa atau admin input nilai mata kuliah untuk setiap mahasiswa.
                            </p>
                            <div class="text-start mt-3">
                                <small class="text-warning"><i class="bi bi-arrow-right-circle"></i> Nilai per Matkul</small><br>
                                <small class="text-warning"><i class="bi bi-arrow-right-circle"></i> Mapping ke Kriteria</small><br>
                                <small class="text-warning"><i class="bi bi-arrow-right-circle"></i> Normalisasi (0-1)</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 4 -->
                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center">
                            <div class="rounded-circle bg-danger text-white d-inline-flex align-items-center justify-content-center mb-3" 
                                 style="width: 60px; height: 60px; font-size: 24px; font-weight: bold;">
                                4
                            </div>
                            <h5 class="card-title">Hasil Rekomendasi</h5>
                            <p class="card-text text-muted">
                                Sistem menghitung dan menghasilkan ranking tema yang sesuai untuk mahasiswa.
                            </p>
                            <div class="text-start mt-3">
                                <small class="text-danger"><i class="bi bi-arrow-right-circle"></i> Perhitungan AHP</small><br>
                                <small class="text-danger"><i class="bi bi-arrow-right-circle"></i> Ranking Tema</small><br>
                                <small class="text-danger"><i class="bi bi-arrow-right-circle"></i> Score & Persentase</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed Steps -->
    <div class="row">
        <!-- Phase 1 -->
        <div class="col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-1-circle-fill me-2"></i>Phase 1: Perbandingan Kriteria</h5>
                </div>
                <div class="card-body">
                    <p><strong>Tujuan:</strong> Menentukan bobot tingkat kepentingan setiap kriteria</p>
                    
                    <div class="alert alert-info">
                        <strong>Contoh Kriteria:</strong>
                        <ul class="mb-0">
                            <li>Minat & Motivasi (C1)</li>
                            <li>Kemampuan Teknis (C2)</li>
                            <li>Nilai Akademik (C3)</li>
                            <li>Relevansi dengan Jurusan (C4)</li>
                            <li>Prospek Karir (C5)</li>
                        </ul>
                    </div>

                    <h6 class="mt-3">Langkah-langkah:</h6>
                    <ol>
                        <li><strong>Buat Matrix Perbandingan</strong>
                            <ul>
                                <li>Bandingkan setiap pasangan kriteria</li>
                                <li>Gunakan skala 1-9 (Saaty Scale)</li>
                                <li>Matrix berukuran n×n (5×5 untuk 5 kriteria)</li>
                            </ul>
                        </li>
                        <li><strong>Normalisasi Matrix</strong>
                            <ul>
                                <li>Jumlahkan setiap kolom</li>
                                <li>Bagi setiap elemen dengan jumlah kolomnya</li>
                            </ul>
                        </li>
                        <li><strong>Hitung Eigenvector (Bobot)</strong>
                            <ul>
                                <li>Rata-rata setiap baris matrix ternormalisasi</li>
                                <li>Hasil = Bobot kriteria (W)</li>
                            </ul>
                        </li>
                        <li><strong>Cek Consistency Ratio (CR)</strong>
                            <ul>
                                <li>Hitung λmax, CI, dan CR</li>
                                <li>CR ≤ 0.1 = Konsisten ✓</li>
                                <li>CR > 0.1 = Perlu revisi ✗</li>
                            </ul>
                        </li>
                    </ol>

                    <div class="alert alert-success">
                        <strong><i class="bi bi-calculator"></i> Rumus CR:</strong><br>
                        <code>CR = CI / RI</code><br>
                        <code>CI = (λmax - n) / (n - 1)</code><br>
                        <small>RI = Random Index berdasarkan ukuran matrix</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Phase 2 -->
        <div class="col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="bi bi-2-circle-fill me-2"></i>Phase 2: Perbandingan Alternatif</h5>
                </div>
                <div class="card-body">
                    <p><strong>Tujuan:</strong> Menentukan prioritas alternatif terhadap setiap kriteria</p>
                    
                    <div class="alert alert-info">
                        <strong>Contoh Alternatif Tema:</strong>
                        <ul class="mb-0">
                            <li>Web Development (A1)</li>
                            <li>Mobile Application (A2)</li>
                            <li>Data Science & AI (A3)</li>
                            <li>IoT & Embedded Systems (A4)</li>
                            <li>Cyber Security (A5)</li>
                            <li>Game Development (A6)</li>
                        </ul>
                    </div>

                    <h6 class="mt-3">Langkah-langkah:</h6>
                    <ol>
                        <li><strong>Pilih Kriteria</strong>
                            <ul>
                                <li>Lakukan untuk setiap kriteria (C1, C2, ...)</li>
                                <li>Misal: Bandingkan alternatif terhadap C1</li>
                            </ul>
                        </li>
                        <li><strong>Buat Matrix Perbandingan</strong>
                            <ul>
                                <li>Matrix 6×6 (untuk 6 alternatif)</li>
                                <li>Bandingkan: A1 vs A2, A1 vs A3, dst</li>
                                <li>Gunakan skala 1-9</li>
                            </ul>
                        </li>
                        <li><strong>Normalisasi & Hitung Bobot</strong>
                            <ul>
                                <li>Sama seperti kriteria</li>
                                <li>Hasil = Bobot alternatif per kriteria</li>
                            </ul>
                        </li>
                        <li><strong>Ulangi untuk Semua Kriteria</strong>
                            <ul>
                                <li>Setiap kriteria punya bobot alternatif sendiri</li>
                                <li>Total: 5 matrix (untuk 5 kriteria)</li>
                            </ul>
                        </li>
                    </ol>

                    <div class="alert alert-warning">
                        <strong><i class="bi bi-exclamation-triangle"></i> Penting:</strong><br>
                        Setiap matrix alternatif juga harus dicek CR-nya!
                    </div>
                </div>
            </div>
        </div>

        <!-- Phase 3 -->
        <div class="col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0"><i class="bi bi-3-circle-fill me-2"></i>Phase 3: Agregasi Nilai Mahasiswa</h5>
                </div>
                <div class="card-body">
                    <p><strong>Tujuan:</strong> Mengumpulkan dan mengolah nilai akademik mahasiswa</p>

                    <h6>Langkah-langkah:</h6>
                    <ol>
                        <li><strong>Input Nilai Mata Kuliah</strong>
                            <ul>
                                <li>Nilai per mata kuliah (0-100 atau A-E)</li>
                                <li>Misal: Pemrograman Web = 85</li>
                            </ul>
                        </li>
                        <li><strong>Mapping ke Kriteria</strong>
                            <ul>
                                <li>Setiap matkul terkait dengan kriteria</li>
                                <li>Pemrograman Web → C2 (Kemampuan Teknis)</li>
                            </ul>
                        </li>
                        <li><strong>Agregasi per Kriteria</strong>
                            <ul>
                                <li>Rata-rata nilai matkul dalam 1 kriteria</li>
                                <li>C2 = (85 + 78 + 90) / 3 = 84.33</li>
                            </ul>
                        </li>
                        <li><strong>Normalisasi (0-1)</strong>
                            <ul>
                                <li>Bagi dengan nilai maksimum (100)</li>
                                <li>C2 = 84.33 / 100 = 0.8433</li>
                            </ul>
                        </li>
                    </ol>

                    <div class="card bg-light mt-3">
                        <div class="card-body">
                            <h6>Contoh Data Mahasiswa:</h6>
                            <table class="table table-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th>Kriteria</th>
                                        <th>Nilai</th>
                                        <th>Normalized</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>C1 - Minat</td>
                                        <td>90</td>
                                        <td>0.900</td>
                                    </tr>
                                    <tr>
                                        <td>C2 - Kemampuan</td>
                                        <td>84.33</td>
                                        <td>0.843</td>
                                    </tr>
                                    <tr>
                                        <td>C3 - Nilai Akademik</td>
                                        <td>88</td>
                                        <td>0.880</td>
                                    </tr>
                                    <tr>
                                        <td>C4 - Relevansi</td>
                                        <td>85</td>
                                        <td>0.850</td>
                                    </tr>
                                    <tr>
                                        <td>C5 - Prospek</td>
                                        <td>82</td>
                                        <td>0.820</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Phase 4 -->
        <div class="col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0"><i class="bi bi-4-circle-fill me-2"></i>Phase 4: Perhitungan Final Score</h5>
                </div>
                <div class="card-body">
                    <p><strong>Tujuan:</strong> Menghitung score akhir dan ranking untuk setiap alternatif</p>

                    <h6>Formula Perhitungan:</h6>
                    <div class="alert alert-success">
                        <code>Score(A<sub>i</sub>) = Σ (W<sub>j</sub> × V<sub>ij</sub> × N<sub>j</sub>)</code><br><br>
                        <small>
                            <strong>A<sub>i</sub></strong> = Alternatif ke-i<br>
                            <strong>W<sub>j</sub></strong> = Bobot kriteria ke-j<br>
                            <strong>V<sub>ij</sub></strong> = Bobot alternatif i terhadap kriteria j<br>
                            <strong>N<sub>j</sub></strong> = Nilai mahasiswa untuk kriteria j (normalized)
                        </small>
                    </div>

                    <h6>Contoh Perhitungan:</h6>
                    <div class="card bg-light">
                        <div class="card-body">
                            <p><strong>Data yang dibutuhkan:</strong></p>
                            <ul>
                                <li>Bobot Kriteria (dari Phase 1): W = [0.465, 0.257, 0.109, 0.047, 0.122]</li>
                                <li>Bobot Alternatif per Kriteria (dari Phase 2)</li>
                                <li>Nilai Mahasiswa per Kriteria (dari Phase 3): N = [0.9, 0.843, 0.88, 0.85, 0.82]</li>
                            </ul>

                            <p><strong>Perhitungan untuk Alternatif A1 (Web Development):</strong></p>
                            <pre class="bg-white p-2 border">
Score(A1) = (0.465 × 0.418 × 0.900) + 
            (0.257 × 0.289 × 0.843) + 
            (0.109 × 0.156 × 0.880) + 
            (0.047 × 0.078 × 0.850) + 
            (0.122 × 0.201 × 0.820)
         = 0.175 + 0.063 + 0.015 + 0.003 + 0.020
         = <strong>0.276 (27.6%)</strong>
                            </pre>

                            <p><strong>Ulangi untuk semua alternatif (A2, A3, ..., A6)</strong></p>
                        </div>
                    </div>

                    <h6 class="mt-3">Output Akhir:</h6>
                    <ol>
                        <li>Score untuk setiap alternatif</li>
                        <li>Ranking (dari tertinggi ke terendah)</li>
                        <li>Persentase kesesuaian</li>
                        <li>Rekomendasi tema #1, #2, #3</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Saaty Scale -->
    <div class="card mb-4">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0"><i class="bi bi-table me-2"></i>Skala Perbandingan Berpasangan (Saaty Scale)</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center">Nilai</th>
                            <th>Definisi</th>
                            <th>Penjelasan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center"><span class="badge bg-secondary">1</span></td>
                            <td><strong>Sama Penting</strong> (Equal Importance)</td>
                            <td>Kedua elemen memiliki pengaruh yang sama</td>
                        </tr>
                        <tr>
                            <td class="text-center"><span class="badge bg-info">3</span></td>
                            <td><strong>Sedikit Lebih Penting</strong> (Moderate Importance)</td>
                            <td>Pengalaman dan penilaian sedikit menyokong satu elemen atas elemen lainnya</td>
                        </tr>
                        <tr>
                            <td class="text-center"><span class="badge bg-primary">5</span></td>
                            <td><strong>Lebih Penting</strong> (Strong Importance)</td>
                            <td>Pengalaman dan penilaian kuat menyokong satu elemen atas elemen lainnya</td>
                        </tr>
                        <tr>
                            <td class="text-center"><span class="badge bg-warning text-dark">7</span></td>
                            <td><strong>Sangat Penting</strong> (Very Strong Importance)</td>
                            <td>Satu elemen sangat disukai dan dominannya telah terlihat dalam praktek</td>
                        </tr>
                        <tr>
                            <td class="text-center"><span class="badge bg-danger">9</span></td>
                            <td><strong>Mutlak Lebih Penting</strong> (Extreme Importance)</td>
                            <td>Satu elemen mutlak lebih disukai, pada tingkat keyakinan tertinggi</td>
                        </tr>
                        <tr>
                            <td class="text-center"><span class="badge bg-light text-dark">2, 4, 6, 8</span></td>
                            <td><strong>Nilai Tengah</strong></td>
                            <td>Nilai di antara dua pertimbangan yang berdekatan</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div class="alert alert-info mt-3">
                <i class="bi bi-lightbulb"></i> <strong>Tips:</strong> 
                Jika elemen A dibandingkan dengan B mendapat nilai 5, maka B dibandingkan dengan A mendapat nilai 1/5 (reciprocal).
            </div>
        </div>
    </div>

    <!-- Example Result -->
    <div class="card mb-4">
        <div class="card-header" style="background: linear-gradient(135deg, #50cd89 0%, #2ecc71 100%); color: white;">
            <h5 class="mb-0"><i class="bi bi-trophy-fill me-2"></i>Contoh Hasil Rekomendasi</h5>
        </div>
        <div class="card-body">
            <p>Setelah semua proses selesai, mahasiswa akan mendapat rekomendasi tema seperti berikut:</p>
            
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-success">
                        <tr>
                            <th class="text-center">Ranking</th>
                            <th>Tema</th>
                            <th class="text-center">Total Score</th>
                            <th class="text-center">Persentase</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="table-success">
                            <td class="text-center">
                                <span class="badge bg-warning text-dark" style="font-size: 1.2rem;">
                                    <i class="bi bi-trophy-fill"></i> 1
                                </span>
                            </td>
                            <td><strong>Web Development</strong></td>
                            <td class="text-center"><strong>0.276</strong></td>
                            <td class="text-center"><strong>27.6%</strong></td>
                            <td><span class="badge bg-success">Sangat Direkomendasikan</span></td>
                        </tr>
                        <tr>
                            <td class="text-center"><span class="badge bg-secondary">2</span></td>
                            <td>Mobile Application</td>
                            <td class="text-center">0.234</td>
                            <td class="text-center">23.4%</td>
                            <td><span class="badge bg-primary">Direkomendasikan</span></td>
                        </tr>
                        <tr>
                            <td class="text-center"><span class="badge bg-secondary">3</span></td>
                            <td>Data Science & AI</td>
                            <td class="text-center">0.189</td>
                            <td class="text-center">18.9%</td>
                            <td><span class="badge bg-info">Alternatif Bagus</span></td>
                        </tr>
                        <tr>
                            <td class="text-center"><span class="badge bg-light text-dark">4</span></td>
                            <td>Game Development</td>
                            <td class="text-center">0.156</td>
                            <td class="text-center">15.6%</td>
                            <td><span class="badge bg-light text-dark">Pertimbangan</span></td>
                        </tr>
                        <tr>
                            <td class="text-center"><span class="badge bg-light text-dark">5</span></td>
                            <td>Cyber Security</td>
                            <td class="text-center">0.089</td>
                            <td class="text-center">8.9%</td>
                            <td><span class="badge bg-light text-dark">Kurang Sesuai</span></td>
                        </tr>
                        <tr>
                            <td class="text-center"><span class="badge bg-light text-dark">6</span></td>
                            <td>IoT & Embedded Systems</td>
                            <td class="text-center">0.056</td>
                            <td class="text-center">5.6%</td>
                            <td><span class="badge bg-light text-dark">Tidak Direkomendasikan</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="alert alert-success mt-3">
                <h6><i class="bi bi-check-circle-fill"></i> Interpretasi:</h6>
                <p class="mb-0">
                    Mahasiswa ini <strong>sangat cocok</strong> dengan tema <strong>Web Development</strong> (27.6%), 
                    diikuti dengan Mobile Application (23.4%) dan Data Science (18.9%). 
                    Rekomendasi ini didasarkan pada nilai akademik, minat, kemampuan, dan faktor lainnya yang telah dianalisis menggunakan metode AHP.
                </p>
            </div>
        </div>
    </div>

    <!-- Additional Info -->
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card h-100 border-info">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="bi bi-question-circle-fill me-2"></i>FAQ</h5>
                </div>
                <div class="card-body">
                    <h6>Apa itu Consistency Ratio (CR)?</h6>
                    <p>CR adalah ukuran seberapa konsisten penilaian perbandingan berpasangan. CR ≤ 0.1 dianggap konsisten.</p>

                    <h6>Mengapa harus ada perbandingan berpasangan?</h6>
                    <p>Karena lebih mudah membandingkan 2 hal secara langsung daripada memberi nilai absolut untuk banyak hal sekaligus.</p>

                    <h6>Bisakah hasil rekomendasi berubah?</h6>
                    <p>Ya, jika ada perubahan pada: nilai mahasiswa, bobot kriteria, atau bobot alternatif.</p>

                    <h6>Apa keunggulan AHP dibanding metode lain?</h6>
                    <p>AHP mempertimbangkan konsistensi penilaian dan dapat menangani kriteria kualitatif maupun kuantitatif.</p>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card h-100 border-warning">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0"><i class="bi bi-exclamation-triangle-fill me-2"></i>Catatan Penting</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning">
                        <strong>Untuk Admin:</strong>
                        <ul class="mb-0">
                            <li>Pastikan semua kriteria dan alternatif sudah diinput</li>
                            <li>Lakukan pairwise comparison dengan hati-hati</li>
                            <li>Selalu cek Consistency Ratio (CR ≤ 0.1)</li>
                            <li>Update bobot jika ada perubahan kebijakan</li>
                        </ul>
                    </div>

                    <div class="alert alert-info">
                        <strong>Untuk Mahasiswa:</strong>
                        <ul class="mb-0">
                            <li>Pastikan semua nilai mata kuliah sudah diinput</li>
                            <li>Klik "Hitung Rekomendasi" untuk update hasil</li>
                            <li>Rekomendasi adalah saran, bukan keputusan final</li>
                            <li>Konsultasikan dengan dosen pembimbing</li>
                        </ul>
                    </div>

                    <div class="alert alert-success mb-0">
                        <strong>Untuk Dosen:</strong>
                        <ul class="mb-0">
                            <li>Gunakan hasil rekomendasi sebagai referensi</li>
                            <li>Pertimbangkan faktor lain (motivasi, passion, dll)</li>
                            <li>Berikan bimbingan sesuai kemampuan mahasiswa</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<?php require_once APP_PATH . '/views/layouts/admin_footer.php'; ?>
