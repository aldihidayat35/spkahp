<?php require_once APP_PATH . '/views/layouts/dosen_header.php'; ?>

<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="mb-2" style="font-weight: 700; color: #1e1e2d;">
                <i class="bi bi-diagram-3 me-2" style="color: #009ef7;"></i>Visualisasi AHP
            </h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="<?= url('dosen/dashboard') ?>">Dashboard</a></li>
                    <li class="breadcrumb-item active">Visualisasi AHP</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Info Cards -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card stat-card-metronic">
                <div class="card-body p-6">
                    <div class="d-flex align-items-center">
                        <div class="symbol symbol-50px me-4">
                            <div class="symbol-label" style="background: linear-gradient(135deg, #009ef7 0%, #0077b6 100%);">
                                <i class="bi bi-list-check text-white fs-2"></i>
                            </div>
                        </div>
                        <div>
                            <span class="text-muted fw-semibold d-block fs-7">Total Kriteria</span>
                            <span class="text-gray-800 fw-bold fs-2"><?= count($kriteria ?? []) ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card stat-card-metronic">
                <div class="card-body p-6">
                    <div class="d-flex align-items-center">
                        <div class="symbol symbol-50px me-4">
                            <div class="symbol-label" style="background: linear-gradient(135deg, #50cd89 0%, #2ecc71 100%);">
                                <i class="bi bi-trophy text-white fs-2"></i>
                            </div>
                        </div>
                        <div>
                            <span class="text-muted fw-semibold d-block fs-7">Total Alternatif</span>
                            <span class="text-gray-800 fw-bold fs-2"><?= count($alternatif ?? []) ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card stat-card-metronic">
                <div class="card-body p-6">
                    <div class="d-flex align-items-center">
                        <div class="symbol symbol-50px me-4">
                            <div class="symbol-label" style="background: linear-gradient(135deg, #7239ea 0%, #5e17eb 100%);">
                                <i class="bi bi-people text-white fs-2"></i>
                            </div>
                        </div>
                        <div>
                            <span class="text-muted fw-semibold d-block fs-7">Total Mahasiswa</span>
                            <span class="text-gray-800 fw-bold fs-2"><?= $total_mahasiswa ?? 0 ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card stat-card-metronic">
                <div class="card-body p-6">
                    <div class="d-flex align-items-center">
                        <div class="symbol symbol-50px me-4">
                            <div class="symbol-label" style="background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);">
                                <i class="bi bi-graph-up-arrow text-white fs-2"></i>
                            </div>
                        </div>
                        <div>
                            <span class="text-muted fw-semibold d-block fs-7">Proses Selesai</span>
                            <span class="text-gray-800 fw-bold fs-2"><?= $total_rekomendasi ?? 0 ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- AHP Process Flow -->
    <div class="card stat-card-metronic mb-4">
        <div class="card-header border-0 pt-6">
            <h3 class="card-title fw-bold m-0" style="color: #1e1e2d;">
                <i class="bi bi-flow-chart me-2" style="color: #009ef7;"></i>Alur Proses AHP
            </h3>
        </div>
        <div class="card-body p-6">
            <div class="row g-4">
                <div class="col-md-3">
                    <div class="text-center p-5" style="background: linear-gradient(135deg, #f1faff 0%, #e3f5ff 100%); border-radius: 12px;">
                        <div class="symbol symbol-75px symbol-circle mb-4" style="margin: 0 auto;">
                            <div class="symbol-label" style="background: linear-gradient(135deg, #009ef7 0%, #0077b6 100%);">
                                <span class="text-white fw-bold fs-1">1</span>
                            </div>
                        </div>
                        <h4 class="fw-bold mb-2" style="color: #1e1e2d;">Input Nilai</h4>
                        <p class="text-muted fs-7 mb-0">Mahasiswa menginput nilai mata kuliah yang telah ditempuh</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-center p-5" style="background: linear-gradient(135deg, #e8fff3 0%, #d3f9e3 100%); border-radius: 12px;">
                        <div class="symbol symbol-75px symbol-circle mb-4" style="margin: 0 auto;">
                            <div class="symbol-label" style="background: linear-gradient(135deg, #50cd89 0%, #2ecc71 100%);">
                                <span class="text-white fw-bold fs-1">2</span>
                            </div>
                        </div>
                        <h4 class="fw-bold mb-2" style="color: #1e1e2d;">Normalisasi</h4>
                        <p class="text-muted fs-7 mb-0">Nilai dinormalisasi ke skala 0-1 untuk setiap kriteria</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-center p-5" style="background: linear-gradient(135deg, #f8f5ff 0%, #ede5ff 100%); border-radius: 12px;">
                        <div class="symbol symbol-75px symbol-circle mb-4" style="margin: 0 auto;">
                            <div class="symbol-label" style="background: linear-gradient(135deg, #7239ea 0%, #5e17eb 100%);">
                                <span class="text-white fw-bold fs-1">3</span>
                            </div>
                        </div>
                        <h4 class="fw-bold mb-2" style="color: #1e1e2d;">Pembobotan</h4>
                        <p class="text-muted fs-7 mb-0">Menerapkan bobot kriteria dan relevansi alternatif</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-center p-5" style="background: linear-gradient(135deg, #fff8dd 0%, #ffeaa7 100%); border-radius: 12px;">
                        <div class="symbol symbol-75px symbol-circle mb-4" style="margin: 0 auto;">
                            <div class="symbol-label" style="background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);">
                                <span class="text-white fw-bold fs-1">4</span>
                            </div>
                        </div>
                        <h4 class="fw-bold mb-2" style="color: #1e1e2d;">Ranking</h4>
                        <p class="text-muted fs-7 mb-0">Hasil akhir berupa ranking tema dengan skor prioritas</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Kriteria Weights -->
    <div class="row g-4 mb-4">
        <div class="col-lg-6">
            <div class="card stat-card-metronic h-100">
                <div class="card-header border-0 pt-6">
                    <h3 class="card-title fw-bold m-0" style="color: #1e1e2d;">
                        <i class="bi bi-bar-chart me-2" style="color: #009ef7;"></i>Bobot Kriteria
                    </h3>
                </div>
                <div class="card-body py-4">
                    <?php if (!empty($kriteria)): ?>
                        <?php 
                        $totalKriteria = count($kriteria);
                        $equalWeight = 1 / $totalKriteria;
                        ?>
                        <?php foreach ($kriteria as $index => $k): ?>
                        <div class="mb-5">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-gray-800 fw-bold fs-6"><?= escape($k['nama_kriteria']) ?></span>
                                <span class="badge badge-primary fw-bold"><?= number_format($equalWeight * 100, 2) ?>%</span>
                            </div>
                            <div class="progress" style="height: 10px; border-radius: 6px;">
                                <div class="progress-bar" role="progressbar" 
                                     style="width: <?= $equalWeight * 100 ?>%; background: linear-gradient(90deg, #009ef7 0%, #0077b6 100%);" 
                                     aria-valuenow="<?= $equalWeight * 100 ?>" aria-valuemin="0" aria-valuemax="100">
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                        <div class="alert alert-info d-flex align-items-center mt-4" style="background-color: #f1faff; border: none;">
                            <i class="bi bi-info-circle me-3 fs-3" style="color: #009ef7;"></i>
                            <div>
                                <strong>Catatan:</strong> Bobot kriteria saat ini menggunakan equal distribution. 
                                Tambahkan data pairwise comparison untuk perhitungan AHP yang lebih akurat.
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="bi bi-inbox fs-1 text-muted"></i>
                            <p class="text-muted mt-3">Belum ada data kriteria</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card stat-card-metronic h-100">
                <div class="card-header border-0 pt-6">
                    <h3 class="card-title fw-bold m-0" style="color: #1e1e2d;">
                        <i class="bi bi-diagram-2 me-2" style="color: #50cd89;"></i>Tema Alternatif
                    </h3>
                </div>
                <div class="card-body py-4">
                    <?php if (!empty($alternatif)): ?>
                        <div class="d-flex flex-column gap-4">
                            <?php 
                            $colors = [
                                'linear-gradient(135deg, #009ef7 0%, #0077b6 100%)',
                                'linear-gradient(135deg, #f093fb 0%, #f5576c 100%)',
                                'linear-gradient(135deg, #fa709a 0%, #fee140 100%)',
                                'linear-gradient(135deg, #4facfe 0%, #00f2fe 100%)'
                            ];
                            ?>
                            <?php foreach ($alternatif as $index => $alt): ?>
                            <div class="d-flex align-items-center p-4" style="background: <?= $colors[$index % 4] ?>; border-radius: 12px;">
                                <div class="symbol symbol-50px me-4">
                                    <div class="symbol-label" style="background: rgba(255,255,255,0.3);">
                                        <span class="text-white fw-bold fs-2"><?= $index + 1 ?></span>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="text-white fw-bold mb-1"><?= escape($alt['nama_tema']) ?></h5>
                                    <p class="text-white mb-0 fs-7" style="opacity: 0.9;"><?= escape($alt['kode']) ?></p>
                                </div>
                                <div>
                                    <i class="bi bi-trophy-fill text-white fs-1" style="opacity: 0.3;"></i>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="bi bi-inbox fs-1 text-muted"></i>
                            <p class="text-muted mt-3">Belum ada data alternatif</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Relevance Mapping Matrix -->
    <div class="card stat-card-metronic mb-4">
        <div class="card-header border-0 pt-6">
            <h3 class="card-title fw-bold m-0" style="color: #1e1e2d;">
                <i class="bi bi-grid-3x3 me-2" style="color: #7239ea;"></i>Matriks Relevansi Kriteria-Alternatif
            </h3>
        </div>
        <div class="card-body py-4">
            <p class="text-muted mb-4">
                Matriks ini menunjukkan tingkat relevansi antara setiap kriteria dengan alternatif tema. 
                Nilai berkisar dari 0.1 (relevansi rendah) hingga 1.0 (relevansi tinggi).
            </p>
            <?php if (!empty($kriteria) && !empty($alternatif)): ?>
                <?php
                // Relevance mapping from controller logic
                $relevanceMap = [
                    1 => [2 => 1.0, 1 => 0.3, 3 => 0.5, 4 => 0.2],
                    2 => [3 => 1.0, 2 => 0.4, 1 => 0.2, 4 => 0.1],
                    3 => [4 => 1.0, 2 => 0.5, 3 => 0.3, 1 => 0.1],
                    4 => [1 => 1.0, 3 => 0.4, 2 => 0.2, 4 => 0.3],
                    5 => [1 => 0.25, 2 => 0.25, 3 => 0.25, 4 => 0.25]
                ];
                ?>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead>
                            <tr>
                                <th class="text-center fw-bold bg-light" style="color: #1e1e2d;">Kriteria / Alternatif</th>
                                <?php foreach ($alternatif as $alt): ?>
                                <th class="text-center fw-bold bg-light" style="color: #1e1e2d;">
                                    <?= escape($alt['nama_tema']) ?>
                                </th>
                                <?php endforeach; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($kriteria as $k): ?>
                            <tr>
                                <td class="fw-bold" style="background: #f9fafb;">
                                    <?= escape($k['nama_kriteria']) ?>
                                </td>
                                <?php foreach ($alternatif as $alt): ?>
                                <td class="text-center">
                                    <?php 
                                    $relevance = $relevanceMap[$k['id']][$alt['id']] ?? 0.1;
                                    $bgColor = '';
                                    if ($relevance >= 0.8) $bgColor = 'background: #e8fff3; color: #50cd89;';
                                    elseif ($relevance >= 0.5) $bgColor = 'background: #fff8dd; color: #ffc107;';
                                    elseif ($relevance >= 0.3) $bgColor = 'background: #f1faff; color: #009ef7;';
                                    else $bgColor = 'background: #f5f5f5; color: #999;';
                                    ?>
                                    <span class="badge fw-bold fs-6" style="<?= $bgColor ?> padding: 8px 16px;">
                                        <?= number_format($relevance, 2) ?>
                                    </span>
                                </td>
                                <?php endforeach; ?>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    <div class="d-flex align-items-center gap-3 flex-wrap">
                        <span class="text-muted fw-semibold">Legenda:</span>
                        <span class="badge fw-bold" style="background: #e8fff3; color: #50cd89; padding: 6px 12px;">≥ 0.8 Sangat Tinggi</span>
                        <span class="badge fw-bold" style="background: #fff8dd; color: #ffc107; padding: 6px 12px;">0.5 - 0.8 Tinggi</span>
                        <span class="badge fw-bold" style="background: #f1faff; color: #009ef7; padding: 6px 12px;">0.3 - 0.5 Sedang</span>
                        <span class="badge fw-bold" style="background: #f5f5f5; color: #999; padding: 6px 12px;">< 0.3 Rendah</span>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Recent Recommendations -->
    <div class="card stat-card-metronic">
        <div class="card-header border-0 pt-6">
            <h3 class="card-title fw-bold m-0" style="color: #1e1e2d;">
                <i class="bi bi-clock-history me-2" style="color: #ffc107;"></i>Rekomendasi Terbaru
            </h3>
        </div>
        <div class="card-body py-4">
            <?php if (!empty($recent_recommendations)): ?>
                <div class="table-responsive">
                    <table class="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3">
                        <thead>
                            <tr class="fw-bold text-muted">
                                <th>Mahasiswa</th>
                                <th>NIM</th>
                                <th>Tema Rekomendasi</th>
                                <th class="text-center">Score</th>
                                <th class="text-center">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recent_recommendations as $rec): ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="symbol symbol-40px me-3">
                                            <div class="symbol-label bg-light-primary">
                                                <i class="bi bi-person text-primary fs-4"></i>
                                            </div>
                                        </div>
                                        <span class="text-gray-800 fw-bold"><?= escape($rec['nama_mahasiswa']) ?></span>
                                    </div>
                                </td>
                                <td><span class="text-muted fw-semibold"><?= escape($rec['nim']) ?></span></td>
                                <td>
                                    <span class="badge badge-light-success fw-bold">
                                        <?= escape($rec['tema_top']) ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-primary fw-bold">
                                        <?= number_format($rec['score_top'] * 100, 2) ?>%
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="text-muted fw-semibold fs-7">
                                        <?= date('d M Y', strtotime($rec['created_at'])) ?>
                                    </span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="text-center py-10">
                    <div class="symbol symbol-100px symbol-circle mb-5" style="margin: 0 auto;">
                        <div class="symbol-label bg-light-primary">
                            <i class="bi bi-inbox fs-1 text-primary"></i>
                        </div>
                    </div>
                    <p class="text-gray-500 fs-4 fw-semibold">Belum ada data rekomendasi</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once APP_PATH . '/views/layouts/admin_footer.php'; ?>
