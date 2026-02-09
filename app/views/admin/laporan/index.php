<?php require_once APP_PATH . '/views/layouts/admin_header.php'; ?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Laporan Hasil Rekomendasi</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?= url('admin/dashboard') ?>">Dashboard</a></li>
        <li class="breadcrumb-item active">Laporan</li>
    </ol>

    <!-- Statistik Tema -->
    <?php if (!empty($statistik_tema)): ?>
    <div class="card mb-4">
        <div class="card-header">
            <i class="bi bi-bar-chart me-1"></i>
            Statistik Tema Rekomendasi
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tema</th>
                            <th class="text-center">Jumlah Ranking 1</th>
                            <th class="text-center">Total Rekomendasi</th>
                            <th class="text-center">Rata-rata Score</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($statistik_tema as $stat): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><strong><?= escape($stat['nama_tema']) ?></strong></td>
                            <td class="text-center">
                                <span class="badge bg-primary"><?= $stat['jumlah_ranking_1'] ?? 0 ?></span>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-info"><?= $stat['jumlah_mahasiswa'] ?? 0 ?></span>
                            </td>
                            <td class="text-center">
                                <?= number_format($stat['rata_rata_score'] ?? 0, 4) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Daftar Rekomendasi -->
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>
                <i class="bi bi-file-text me-1"></i>
                Daftar Hasil Rekomendasi Mahasiswa (Ranking 1)
            </span>
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
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($rekomendasi as $r): ?>
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
                            <td>
                                <a href="<?= url('admin/detailMahasiswa/' . $r['mahasiswa_id']) ?>" class="btn btn-sm btn-info">
                                    <i class="bi bi-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
            <div class="text-center py-4">
                <i class="bi bi-inbox" style="font-size: 3rem; color: #ccc;"></i>
                <p class="text-muted mt-2">Belum ada data laporan rekomendasi</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once APP_PATH . '/views/layouts/admin_footer.php'; ?>
