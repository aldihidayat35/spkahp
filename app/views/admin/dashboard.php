<?php require_once APP_PATH . '/views/layouts/admin_header.php'; ?>

<div class="container-fluid px-4">
    <h1 class="mt-4"><i class="bi bi-speedometer2"></i> Dashboard Admin</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>

    <!-- Statistics Cards -->
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card primary">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-label">Total Mahasiswa</div>
                        <div class="stat-value"><?= $stats['total_mahasiswa'] ?></div>
                    </div>
                    <div class="stat-icon">
                        <i class="bi bi-people"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card success">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-label">Sudah Rekomendasi</div>
                        <div class="stat-value"><?= $stats['mahasiswa_sudah_rekomendasi'] ?></div>
                    </div>
                    <div class="stat-icon">
                        <i class="bi bi-check-circle"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card info">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-label">Total Kriteria</div>
                        <div class="stat-value"><?= $stats['total_kriteria'] ?></div>
                    </div>
                    <div class="stat-icon">
                        <i class="bi bi-list-check"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card warning">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-label">Tema Alternatif</div>
                        <div class="stat-value"><?= $stats['total_alternatif'] ?></div>
                    </div>
                    <div class="stat-icon">
                        <i class="bi bi-bookmark-star"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts and Tables Row -->
    <div class="row">
        <!-- Recent Mahasiswa -->
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-person-plus me-1"></i>
                    Mahasiswa Terbaru
                </div>
                <div class="card-body">
                    <?php if (!empty($recent_mahasiswa)): ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>NIM</th>
                                        <th>Nama</th>
                                        <th>Angkatan</th>
                                        <th>Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($recent_mahasiswa as $mhs): ?>
                                    <tr>
                                        <td><strong><?= escape($mhs['nim']) ?></strong></td>
                                        <td><?= escape($mhs['nama']) ?></td>
                                        <td><span class="badge bg-primary"><?= escape($mhs['angkatan']) ?></span></td>
                                        <td><small><?= formatDate($mhs['created_at'], 'd/m/Y') ?></small></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            <a href="<?= url('admin/mahasiswa') ?>" class="btn btn-sm btn-primary">
                                <i class="bi bi-arrow-right"></i> Lihat Semua
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info mb-0">
                            <i class="bi bi-info-circle"></i> Belum ada data mahasiswa
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Statistik Tema -->
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-bar-chart me-1"></i>
                    Statistik Tema Tugas Akhir
                </div>
                <div class="card-body">
                    <?php if (!empty($statistik_tema)): ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Tema</th>
                                        <th class="text-center">Total</th>
                                        <th class="text-center">Ranking #1</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($statistik_tema as $st): ?>
                                    <tr>
                                        <td><strong><?= escape($st['nama_tema']) ?></strong></td>
                                        <td class="text-center">
                                            <span class="badge bg-info"><?= $st['jumlah_mahasiswa'] ?></span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-success"><?= $st['jumlah_ranking_1'] ?></span>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info mb-0">
                            <i class="bi bi-info-circle"></i> Belum ada data rekomendasi
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-header bg-gradient">
                    <i class="bi bi-lightning-fill me-1"></i>
                    Aksi Cepat
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <a href="<?= url('admin/users/add') ?>" class="btn btn-primary w-100 py-3">
                                <i class="bi bi-person-plus fs-3 d-block mb-2"></i>
                                <strong>Tambah User</strong>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="<?= url('admin/kriteria/add') ?>" class="btn btn-info w-100 py-3">
                                <i class="bi bi-plus-circle fs-3 d-block mb-2"></i>
                                <strong>Tambah Kriteria</strong>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="<?= url('admin/alternatif/add') ?>" class="btn btn-success w-100 py-3">
                                <i class="bi bi-bookmark-plus fs-3 d-block mb-2"></i>
                                <strong>Tambah Tema</strong>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="<?= url('admin/laporan') ?>" class="btn btn-warning w-100 py-3">
                                <i class="bi bi-file-earmark-text fs-3 d-block mb-2"></i>
                                <strong>Lihat Laporan</strong>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once APP_PATH . '/views/layouts/admin_footer.php'; ?>
