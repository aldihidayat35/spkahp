<?php require_once APP_PATH . '/views/layouts/admin_header.php'; ?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Laporan Hasil Rekomendasi</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?= url('admin/dashboard') ?>">Dashboard</a></li>
        <li class="breadcrumb-item active">Laporan</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="bi bi-file-text me-1"></i>
            Daftar Hasil Rekomendasi Mahasiswa
        </div>
        <div class="card-body">
            <?php if (!empty($laporan)): ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIM</th>
                            <th>Nama Mahasiswa</th>
                            <th>Tema Rekomendasi</th>
                            <th>Score</th>
                            <th>CR</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $current_mhs = null;
                        $no = 1;
                        foreach ($laporan as $l): 
                            if ($current_mhs != $l['mahasiswa_id']):
                                $current_mhs = $l['mahasiswa_id'];
                        ?>
                        <tr class="table-light">
                            <td><?= $no++ ?></td>
                            <td><strong><?= escape($l['nim']) ?></strong></td>
                            <td><strong><?= escape($l['nama_mahasiswa']) ?></strong></td>
                            <td colspan="5">
                                <a href="<?= url('admin/detailMahasiswa/' . $l['mahasiswa_id']) ?>" class="btn btn-sm btn-info">
                                    <i class="bi bi-eye"></i> Lihat Detail
                                </a>
                            </td>
                        </tr>
                        <?php endif; ?>
                        <tr>
                            <td></td>
                            <td colspan="2"></td>
                            <td>
                                <?php if ($l['ranking'] == 1): ?>
                                    <i class="bi bi-trophy-fill text-warning"></i>
                                <?php endif; ?>
                                #<?= $l['ranking'] ?> - <?= escape($l['nama_tema']) ?>
                            </td>
                            <td><?= number_format($l['total_score'], 6) ?></td>
                            <td>
                                <?= number_format($l['consistency_ratio'] ?? 0, 6) ?>
                                <?php if (($l['consistency_ratio'] ?? 0) <= 0.1): ?>
                                    <span class="badge bg-success">OK</span>
                                <?php endif; ?>
                            </td>
                            <td><?= formatDateTime($l['created_at']) ?></td>
                            <td>
                                <span class="badge bg-<?= $l['ranking'] == 1 ? 'primary' : 'secondary' ?>">
                                    <?= number_format($l['total_score'] * 100, 2) ?>%
                                </span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
            <p class="text-muted">Belum ada data laporan rekomendasi</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once APP_PATH . '/views/layouts/admin_footer.php'; ?>
