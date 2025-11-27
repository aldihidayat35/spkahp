<?php require_once APP_PATH . '/views/layouts/mahasiswa_header.php'; ?>

<!-- Welcome Banner -->
<div class="welcome-banner mb-4">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h2><i class="bi bi-hand-wave-fill me-2"></i>Selamat Datang, <?= escape($mahasiswa['nama']) ?>!</h2>
            <p class="mb-0">
                <i class="bi bi-person-badge me-2"></i>NIM: <?= escape($mahasiswa['nim']) ?> | 
                <i class="bi bi-calendar3 ms-3 me-2"></i>Angkatan: <?= escape($mahasiswa['angkatan']) ?>
            </p>
        </div>
        <div class="col-md-4 text-end">
            <div class="d-none d-md-block">
                <i class="bi bi-mortarboard-fill" style="font-size: 5rem; opacity: 0.3;"></i>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="stat-card-metronic">
            <div class="stat-icon-metronic bg-light-primary text-primary">
                <i class="bi bi-book"></i>
            </div>
            <div class="stat-label-metronic mb-2">Mata Kuliah</div>
            <div class="stat-value-metronic"><?= $stats['total_matkul'] ?></div>
            <div class="mt-2">
                <span class="badge badge-light-primary">Nilai Terinput</span>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-6 mb-4">
        <div class="stat-card-metronic">
            <div class="stat-icon-metronic bg-light-success text-success">
                <i class="bi bi-graph-up"></i>
            </div>
            <div class="stat-label-metronic mb-2">Rata-rata Nilai</div>
            <div class="stat-value-metronic"><?= number_format($stats['rata_rata_nilai'], 2) ?></div>
            <div class="mt-2">
                <span class="badge badge-light-success">IPK Sementara</span>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-6 mb-4">
        <div class="stat-card-metronic">
            <?php if ($stats['has_rekomendasi']): ?>
                <div class="stat-icon-metronic bg-light-warning text-warning">
                    <i class="bi bi-trophy-fill"></i>
                </div>
                <div class="stat-label-metronic mb-2">Tema Rekomendasi</div>
                <div class="stat-value-metronic" style="font-size: 1.5rem;">
                    <?= escape($stats['tema_rekomendasi']) ?>
                </div>
                <div class="mt-2">
                    <span class="badge badge-light-success">
                        <i class="bi bi-check-circle"></i> Tersedia
                    </span>
                </div>
            <?php else: ?>
                <div class="stat-icon-metronic bg-light-danger text-danger">
                    <i class="bi bi-exclamation-circle"></i>
                </div>
                <div class="stat-label-metronic mb-2">Rekomendasi</div>
                <div class="stat-value-metronic" style="font-size: 1.5rem;">Belum Ada</div>
                <div class="mt-2">
                    <a href="<?= url('mahasiswa/inputNilai') ?>" class="btn btn-sm btn-metronic btn-primary-metronic">
                        Input Nilai
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Action Cards -->
<div class="row mb-4">
    <div class="col-lg-6 mb-4">
        <div class="action-card">
            <div class="action-card-icon bg-light-primary text-primary">
                <i class="bi bi-pencil-square"></i>
            </div>
            <h5>Input & Update Nilai</h5>
            <p class="text-muted">Lengkapi nilai mata kuliah Anda untuk mendapatkan rekomendasi tema tugas akhir yang sesuai dengan kemampuan dan minat Anda.</p>
            <a href="<?= url('mahasiswa/inputNilai') ?>" class="btn btn-metronic btn-primary-metronic">
                <i class="bi bi-pencil"></i> Input Nilai Sekarang
            </a>
        </div>
    </div>

    <div class="col-lg-6 mb-4">
        <div class="action-card">
            <div class="action-card-icon bg-light-success text-success">
                <i class="bi bi-calculator"></i>
            </div>
            <h5>Proses Rekomendasi AHP</h5>
            <p class="text-muted">Setelah mengisi nilai, proses perhitungan menggunakan metode AHP untuk mendapatkan rekomendasi tema yang paling sesuai.</p>
            <?php if ($stats['total_matkul'] > 0): ?>
                <form action="<?= url('mahasiswa/prosesRekomendasi') ?>" method="POST">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-metronic btn-success-metronic" 
                            onclick="return confirm('Proses perhitungan rekomendasi tema?')">
                        <i class="bi bi-play-circle"></i> Proses Sekarang
                    </button>
                </form>
            <?php else: ?>
                <button class="btn btn-secondary" disabled>
                    <i class="bi bi-x-circle"></i> Input Nilai Terlebih Dahulu
                </button>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Nilai Mata Kuliah -->
<?php if (!empty($nilai_matkul)): ?>
<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="bi bi-list-check me-2"></i>Nilai Mata Kuliah Anda</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-metronic">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Mata Kuliah</th>
                        <th>Kriteria</th>
                        <th class="text-center">Nilai</th>
                        <th class="text-center">Grade</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($nilai_matkul as $nm): ?>
                    <tr>
                        <td><strong><?= escape($nm['kode']) ?></strong></td>
                        <td><?= escape($nm['nama_matkul']) ?></td>
                        <td>
                            <span class="badge badge-light-info">
                                <?= escape($nm['nama_kriteria']) ?>
                            </span>
                        </td>
                        <td class="text-center">
                            <strong class="text-primary"><?= number_format($nm['nilai'], 2) ?></strong>
                        </td>
                        <td class="text-center">
                            <?php
                            $gradeClass = 'badge-light-primary';
                            if (in_array($nm['grade'], ['A', 'A-'])) $gradeClass = 'badge-light-success';
                            elseif (in_array($nm['grade'], ['D', 'E'])) $gradeClass = 'badge-light-danger';
                            ?>
                            <span class="badge badge-metronic <?= $gradeClass ?>">
                                <?= $nm['grade'] ?>
                            </span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Hasil Rekomendasi -->
<?php if (!empty($hasil_rekomendasi)): ?>
<div class="card">
    <div class="card-header bg-light-success">
        <h5 class="mb-0 text-success"><i class="bi bi-trophy me-2"></i>Hasil Rekomendasi Tema Tugas Akhir</h5>
    </div>
    <div class="card-body">
        <div class="alert alert-metronic alert-success mb-4">
            <div class="d-flex align-items-center">
                <i class="bi bi-star-fill me-3" style="font-size: 2rem;"></i>
                <div>
                    <h5 class="mb-1">Tema yang Paling Direkomendasikan:</h5>
                    <h3 class="mb-1 text-success"><?= escape($hasil_rekomendasi[0]['nama_tema']) ?></h3>
                    <p class="mb-0">
                        <i class="bi bi-info-circle me-1"></i>
                        <?= escape($hasil_rekomendasi[0]['deskripsi']) ?>
                    </p>
                </div>
            </div>
        </div>

        <h6 class="mb-3 text-uppercase text-muted" style="letter-spacing: 0.5px;">Ranking Semua Tema:</h6>
        
        <?php foreach ($hasil_rekomendasi as $hr): ?>
        <div class="recommendation-item <?= $hr['ranking'] == 1 ? 'top-rank' : '' ?>">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center flex-grow-1">
                    <div class="rank-badge <?= $hr['ranking'] == 1 ? 'gold' : 'silver' ?> me-3">
                        <?= $hr['ranking'] ?>
                    </div>
                    <div class="flex-grow-1">
                        <h5 class="mb-1"><?= escape($hr['nama_tema']) ?></h5>
                        <p class="mb-0 text-muted small"><?= escape($hr['keterangan']) ?></p>
                    </div>
                </div>
                <div class="text-end ms-3">
                    <div class="stat-value-metronic" style="font-size: 1.75rem; color: var(--bs-success);">
                        <?= number_format($hr['total_score'] * 100, 1) ?>%
                    </div>
                    <small class="text-muted">Score: <?= number_format($hr['total_score'], 6) ?></small>
                </div>
            </div>
        </div>
        <?php endforeach; ?>

        <div class="mt-4">
            <a href="<?= url('mahasiswa/hasilRekomendasi') ?>" class="btn btn-metronic btn-success-metronic">
                <i class="bi bi-eye"></i> Lihat Detail Lengkap
            </a>
        </div>
    </div>
</div>
<?php endif; ?>

<?php require_once APP_PATH . '/views/layouts/mahasiswa_footer.php'; ?>
