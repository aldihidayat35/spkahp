<?php require_once APP_PATH . '/views/layouts/dosen_header.php'; ?>

<div class="container-fluid px-4">
    <h1 class="mt-4"><i class="bi bi-speedometer2"></i> Dashboard Dosen</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>

    <!-- Statistics Cards -->
    <div class="row">
        <div class="col-xl-4 col-md-6 mb-4">
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

        <div class="col-xl-4 col-md-6 mb-4">
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

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card stat-card warning">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-label">Tema PKL</div>
                        <div class="stat-value"><?= $stats['total_tema'] ?></div>
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
                            <a href="<?= url('dosen/mahasiswa') ?>" class="btn btn-sm btn-primary">Lihat Semua Mahasiswa</a>
                        </div>
                    <?php else: ?>
                        <p class="text-muted">Belum ada data mahasiswa</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Statistik Tema -->
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-bar-chart me-1"></i>
                    Statistik Tema PKL Populer
                </div>
                <div class="card-body">
                    <?php if (!empty($statistik_tema)): ?>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Tema</th>
                                        <th class="text-center">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($statistik_tema as $stat): ?>
                                    <tr>
                                        <td><?= escape($stat['nama_tema']) ?></td>
                                        <td class="text-center">
                                            <span class="badge bg-info"><?= $stat['jumlah_ranking_1'] ?? 0 ?> mahasiswa</span>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            <a href="<?= url('dosen/laporan') ?>" class="btn btn-sm btn-success">Lihat Laporan Lengkap</a>
                        </div>
                    <?php else: ?>
                        <p class="text-muted">Belum ada data rekomendasi</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-lightning me-1"></i>
                    Menu Cepat
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <a href="<?= url('dosen/mahasiswa') ?>" class="text-decoration-none">
                                <div class="card bg-primary text-white h-100">
                                    <div class="card-body text-center">
                                        <i class="bi bi-people fs-1"></i>
                                        <h6 class="mt-2">Data Mahasiswa</h6>
                                        <p class="small mb-0">Lihat semua data mahasiswa</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="<?= url('dosen/laporan') ?>" class="text-decoration-none">
                                <div class="card bg-success text-white h-100">
                                    <div class="card-body text-center">
                                        <i class="bi bi-file-earmark-text fs-1"></i>
                                        <h6 class="mt-2">Laporan</h6>
                                        <p class="small mb-0">Lihat laporan rekomendasi</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="<?= url('dosen/visualisasi') ?>" class="text-decoration-none">
                                <div class="card bg-info text-white h-100">
                                    <div class="card-body text-center">
                                        <i class="bi bi-graph-up fs-1"></i>
                                        <h6 class="mt-2">Visualisasi</h6>
                                        <p class="small mb-0">Lihat visualisasi AHP</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="<?= url('auth/changePassword') ?>" class="text-decoration-none">
                                <div class="card bg-warning text-dark h-100">
                                    <div class="card-body text-center">
                                        <i class="bi bi-key fs-1"></i>
                                        <h6 class="mt-2">Ubah Password</h6>
                                        <p class="small mb-0">Ganti password akun</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once APP_PATH . '/views/layouts/admin_footer.php'; ?>
