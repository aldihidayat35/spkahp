<?php require_once APP_PATH . '/views/layouts/mahasiswa_header.php'; ?>

<div class="container-fluid px-4">
    <h1 class="mt-4"><i class="bi bi-trophy me-2"></i>Hasil Rekomendasi Tema Tugas Akhir</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?= url('mahasiswa/dashboard') ?>">Dashboard</a></li>
        <li class="breadcrumb-item active">Hasil Rekomendasi</li>
    </ol>

    <?php if (!empty($hasil_rekomendasi)): ?>
    
    <!-- Top Recommendation -->
    <div class="card mb-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: 0;">
        <div class="card-body text-white p-4">
            <div class="row align-items-center">
                <div class="col-md-2 text-center">
                    <i class="bi bi-trophy-fill" style="font-size: 5rem; opacity: 0.9;"></i>
                </div>
                <div class="col-md-10">
                    <h2 class="mb-2"><i class="bi bi-star-fill me-2"></i>Rekomendasi Terbaik untuk Anda</h2>
                    <h1 class="mb-3"><?= escape($hasil_rekomendasi[0]['nama_tema']) ?></h1>
                    <p class="mb-2" style="font-size: 1.1rem;"><?= escape($hasil_rekomendasi[0]['deskripsi']) ?></p>
                    <div class="mt-3">
                        <span class="badge bg-warning text-dark" style="font-size: 1.2rem; padding: 0.75rem 1.5rem;">
                            Skor: <?= number_format($hasil_rekomendasi[0]['total_score'] * 100, 2) ?>%
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- All Recommendations -->
    <div class="row">
        <?php foreach ($hasil_rekomendasi as $r): ?>
        <div class="col-lg-6 mb-4">
            <div class="recommendation-item <?= $r['ranking'] == 1 ? 'top-rank' : '' ?>" style="height: calc(100% - 1rem);">
                <div class="d-flex align-items-start">
                    <div class="rank-badge <?= $r['ranking'] == 1 ? 'gold' : 'silver' ?> me-3">
                        <?= $r['ranking'] ?>
                    </div>
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <h4 class="mb-1"><?= escape($r['nama_tema']) ?></h4>
                                <span class="badge badge-light-primary"><?= escape($r['kode']) ?></span>
                            </div>
                            <div class="text-end">
                                <div class="stat-value-metronic" style="font-size: 2rem; color: <?= $r['ranking'] == 1 ? '#ffc700' : '#009ef7' ?>;">
                                    <?= number_format($r['total_score'] * 100, 1) ?>%
                                </div>
                                <small class="text-muted">Total Score</small>
                            </div>
                        </div>
                        
                        <p class="text-muted mb-3"><?= escape($r['deskripsi']) ?></p>
                        
                        <div class="separator"></div>
                        
                        <div class="mt-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <small class="text-muted">Nilai Score</small>
                                <strong><?= number_format($r['total_score'], 6) ?></strong>
                            </div>
                            
                            <div class="progress-metronic">
                                <div class="progress-bar-metronic" 
                                     style="width: <?= $r['total_score'] * 100 ?>%; background: <?= $r['ranking'] == 1 ? 'linear-gradient(90deg, #ffc700 0%, #ffed4e 100%)' : 'linear-gradient(90deg, #009ef7 0%, #7239ea 100%)' ?>;">
                                </div>
                            </div>
                        </div>

                        <?php if (!empty($r['keterangan'])): ?>
                        <div class="alert alert-metronic alert-info mt-3 mb-0">
                            <small><i class="bi bi-info-circle me-1"></i><?= escape($r['keterangan']) ?></small>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- AHP Calculation Info -->
    <?php if (!empty($riwayat)): ?>
    <div class="card">
        <div class="card-header bg-light-info">
            <h5 class="mb-0 text-info"><i class="bi bi-calculator me-2"></i>Informasi Perhitungan AHP</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="stat-card-metronic text-center">
                        <div class="stat-label-metronic mb-2">Consistency Ratio (CR)</div>
                        <div class="stat-value-metronic"><?= number_format($riwayat['consistency_ratio'], 6) ?></div>
                        <div class="mt-2">
                            <?php if ($riwayat['is_consistent']): ?>
                                <span class="badge badge-light-success">
                                    <i class="bi bi-check-circle"></i> Konsisten
                                </span>
                            <?php else: ?>
                                <span class="badge badge-light-danger">
                                    <i class="bi bi-x-circle"></i> Tidak Konsisten
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="alert alert-metronic <?= $riwayat['is_consistent'] ? 'alert-success' : 'alert-warning' ?> mb-0 h-100 d-flex align-items-center">
                        <div>
                            <h6><i class="bi bi-lightbulb me-2"></i>Penjelasan:</h6>
                            <?php if ($riwayat['is_consistent']): ?>
                                <p class="mb-0">
                                    Hasil perhitungan <strong>konsisten</strong> (CR ≤ 0.1). 
                                    Rekomendasi dapat diandalkan dan sesuai dengan penilaian yang objektif berdasarkan nilai-nilai mata kuliah Anda.
                                </p>
                            <?php else: ?>
                                <p class="mb-0">
                                    Hasil perhitungan <strong>tidak konsisten</strong> (CR > 0.1). 
                                    Disarankan untuk review kembali nilai-nilai Anda atau konsultasi dengan dosen pembimbing akademik.
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Nilai Per Kriteria -->
            <?php if (!empty($nilai_per_kriteria)): ?>
            <div class="separator"></div>
            <h6 class="text-uppercase text-muted mb-3" style="letter-spacing: 0.5px;">Nilai Rata-rata Per Kriteria</h6>
            <div class="row">
                <?php foreach ($nilai_per_kriteria as $npk): ?>
                <div class="col-md-3 mb-3">
                    <div class="stat-card-metronic">
                        <div class="stat-label-metronic mb-2"><?= escape($npk['nama_kriteria']) ?></div>
                        <div class="stat-value-metronic" style="font-size: 1.75rem;">
                            <?= number_format($npk['rata_rata_nilai'] ?? 0, 2) ?>
                        </div>
                        <small class="text-muted"><?= $npk['jumlah_matkul'] ?? 0 ?> Mata Kuliah</small>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>

    <?php else: ?>
    <div class="card">
        <div class="card-body text-center py-5">
            <i class="bi bi-inbox display-1 text-muted mb-4"></i>
            <h3 class="mb-3">Belum Ada Hasil Rekomendasi</h3>
            <p class="text-muted mb-4">
                Silakan input nilai mata kuliah terlebih dahulu, kemudian proses rekomendasi untuk mendapatkan tema tugas akhir yang sesuai.
            </p>
            <a href="<?= url('mahasiswa/inputNilai') ?>" class="btn btn-metronic btn-primary-metronic btn-lg">
                <i class="bi bi-pencil"></i> Input Nilai Sekarang
            </a>
        </div>
    </div>
    <?php endif; ?>

    <div class="mt-4">
        <a href="<?= url('mahasiswa/dashboard') ?>" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>
</div>

<?php require_once APP_PATH . '/views/layouts/mahasiswa_footer.php'; ?>
