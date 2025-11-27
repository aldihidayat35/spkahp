<?php require_once APP_PATH . '/views/layouts/dosen_header.php'; ?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Laporan Hasil Rekomendasi</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?= url('dosen/dashboard') ?>">Dashboard</a></li>
        <li class="breadcrumb-item active">Laporan</li>
    </ol>

    <!-- Statistik Tema -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-bar-chart me-1"></i>
                    Statistik Tema PKL Populer
                </div>
                <div class="card-body">
                    <?php if (!empty($statistik_tema)): ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tema</th>
                                        <th class="text-center">Jumlah Mahasiswa (Ranking 1)</th>
                                        <th class="text-center">Total Rekomendasi</th>
                                        <th class="text-center">Rata-rata Score</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $no = 1;
                                    foreach ($statistik_tema as $stat): 
                                        if ($stat['jumlah_ranking_1'] > 0 || $stat['jumlah_mahasiswa'] > 0):
                                    ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td>
                                            <strong><?= escape($stat['nama_tema']) ?></strong><br>
                                            <small class="text-muted"><?= escape($stat['kode_tema']) ?></small>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-primary"><?= $stat['jumlah_ranking_1'] ?? 0 ?> mahasiswa</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-info"><?= $stat['jumlah_mahasiswa'] ?? 0 ?></span>
                                        </td>
                                        <td class="text-center">
                                            <?= number_format($stat['rata_rata_score'] ?? 0, 4) ?>
                                        </td>
                                    </tr>
                                    <?php 
                                        endif;
                                    endforeach; 
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p class="text-muted">Belum ada data rekomendasi</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Rekomendasi per Mahasiswa -->
    <div class="card mb-4">
        <div class="card-header">
            <i class="bi bi-file-text me-1"></i>
            Daftar Hasil Rekomendasi Mahasiswa
        </div>
        <div class="card-body">
            <?php if (!empty($rekomendasi)): ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIM</th>
                            <th>Nama Mahasiswa</th>
                            <th>Tema Rekomendasi</th>
                            <th>Score</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        foreach ($rekomendasi as $r): 
                        ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><strong><?= escape($r['nim']) ?></strong></td>
                            <td><?= escape($r['nama']) ?></td>
                            <td>
                                <i class="bi bi-trophy-fill text-warning"></i>
                                <strong><?= escape($r['nama_tema']) ?></strong>
                            </td>
                            <td>
                                <span class="badge bg-primary">
                                    <?= number_format($r['total_score'] * 100, 2) ?>%
                                </span>
                            </td>
                            <td><?= formatDateTime($r['created_at']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
            <p class="text-muted">Belum ada data rekomendasi</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once APP_PATH . '/views/layouts/admin_footer.php'; ?>
