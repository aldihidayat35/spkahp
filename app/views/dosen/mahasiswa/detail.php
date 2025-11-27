<?php require_once APP_PATH . '/views/layouts/dosen_header.php'; ?>

<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="mb-2" style="font-weight: 700; color: #1e1e2d;">
                <i class="bi bi-person-badge me-2" style="color: #009ef7;"></i>Detail Mahasiswa
            </h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="<?= url('dosen/dashboard') ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= url('dosen/mahasiswa') ?>">Data Mahasiswa</a></li>
                    <li class="breadcrumb-item active"><?= escape($mahasiswa['nama'] ?? 'Detail') ?></li>
                </ol>
            </nav>
        </div>
        <a href="<?= url('dosen/mahasiswa') ?>" class="btn btn-light-primary">
            <i class="bi bi-arrow-left me-1"></i>Kembali
        </a>
    </div>

    <div class="row g-4">
        <!-- Profile Card -->
        <div class="col-lg-4">
            <div class="card stat-card-metronic mb-4">
                <div class="card-body text-center p-6">
                    <?php if ($mahasiswa): ?>
                        <div class="mb-5">
                            <div class="symbol symbol-100px symbol-circle mb-4" style="margin: 0 auto;">
                                <div class="symbol-label" style="background: linear-gradient(135deg, #009ef7 0%, #0077b6 100%); font-size: 3rem;">
                                    <i class="bi bi-person-fill text-white"></i>
                                </div>
                            </div>
                            <h3 class="mb-2" style="font-weight: 700; color: #1e1e2d;"><?= escape($mahasiswa['nama']) ?></h3>
                            <p class="text-muted fs-5 mb-3"><?= escape($mahasiswa['nim']) ?></p>
                            <?php if ($mahasiswa['is_active'] ?? false): ?>
                                <span class="badge badge-light-success fs-7 fw-bold">
                                    <i class="bi bi-check-circle me-1"></i>Aktif
                                </span>
                            <?php else: ?>
                                <span class="badge badge-light-danger fs-7 fw-bold">
                                    <i class="bi bi-x-circle me-1"></i>Nonaktif
                                </span>
                            <?php endif; ?>
                        </div>

                        <div class="separator separator-dashed my-5"></div>

                        <div class="d-flex flex-column gap-4">
                            <div class="d-flex align-items-center">
                                <div class="symbol symbol-40px me-3">
                                    <div class="symbol-label bg-light-primary">
                                        <i class="bi bi-calendar3 text-primary fs-4"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 text-start">
                                    <span class="text-muted fs-7 d-block">Angkatan</span>
                                    <span class="text-gray-800 fw-bold fs-6"><?= escape($mahasiswa['angkatan']) ?></span>
                                </div>
                            </div>
                            
                            <div class="d-flex align-items-center">
                                <div class="symbol symbol-40px me-3">
                                    <div class="symbol-label bg-light-success">
                                        <i class="bi bi-star text-success fs-4"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 text-start">
                                    <span class="text-muted fs-7 d-block">Minat Utama</span>
                                    <span class="text-gray-800 fw-bold fs-6"><?= escape($mahasiswa['minat_utama'] ?? '-') ?></span>
                                </div>
                            </div>
                            
                            <div class="d-flex align-items-center">
                                <div class="symbol symbol-40px me-3">
                                    <div class="symbol-label bg-light-info">
                                        <i class="bi bi-envelope text-info fs-4"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 text-start">
                                    <span class="text-muted fs-7 d-block">Email</span>
                                    <span class="text-gray-800 fw-bold fs-6"><?= escape($mahasiswa['email'] ?? '-') ?></span>
                                </div>
                            </div>
                            
                            <div class="d-flex align-items-center">
                                <div class="symbol symbol-40px me-3">
                                    <div class="symbol-label bg-light-warning">
                                        <i class="bi bi-phone text-warning fs-4"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 text-start">
                                    <span class="text-muted fs-7 d-block">No HP</span>
                                    <span class="text-gray-800 fw-bold fs-6"><?= escape($mahasiswa['no_hp'] ?? '-') ?></span>
                                </div>
                            </div>
                            
                            <div class="d-flex align-items-center">
                                <div class="symbol symbol-40px me-3">
                                    <div class="symbol-label bg-light-danger">
                                        <i class="bi bi-person-check text-danger fs-4"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 text-start">
                                    <span class="text-muted fs-7 d-block">Username</span>
                                    <span class="text-gray-800 fw-bold fs-6"><?= escape($mahasiswa['username'] ?? '-') ?></span>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Statistics Card -->
            <div class="card stat-card-metronic">
                <div class="card-body p-6">
                    <h5 class="mb-4" style="font-weight: 700; color: #1e1e2d;">
                        <i class="bi bi-graph-up me-2" style="color: #009ef7;"></i>Statistik
                    </h5>
                    
                    <div class="d-flex flex-column gap-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <div class="symbol symbol-40px me-3">
                                    <div class="symbol-label bg-light-primary">
                                        <i class="bi bi-journal-text text-primary fs-4"></i>
                                    </div>
                                </div>
                                <span class="text-gray-800 fw-semibold">Total Nilai</span>
                            </div>
                            <span class="badge badge-primary fs-6"><?= count($nilai ?? []) ?> Mata Kuliah</span>
                        </div>
                        
                        <div class="separator separator-dashed"></div>
                        
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <div class="symbol symbol-40px me-3">
                                    <div class="symbol-label bg-light-success">
                                        <i class="bi bi-graph-up-arrow text-success fs-4"></i>
                                    </div>
                                </div>
                                <span class="text-gray-800 fw-semibold">Rata-rata Nilai</span>
                            </div>
                            <span class="badge badge-success fs-6">
                                <?php
                                $avg = 0;
                                if (!empty($nilai)) {
                                    $total = array_sum(array_column($nilai, 'nilai'));
                                    $avg = $total / count($nilai);
                                }
                                echo number_format($avg, 2);
                                ?>
                            </span>
                        </div>
                        
                        <div class="separator separator-dashed"></div>
                        
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <div class="symbol symbol-40px me-3">
                                    <div class="symbol-label bg-light-warning">
                                        <i class="bi bi-award text-warning fs-4"></i>
                                    </div>
                                </div>
                                <span class="text-gray-800 fw-semibold">Status Rekomendasi</span>
                            </div>
                            <?php if (!empty($rekomendasi)): ?>
                                <span class="badge badge-success fs-6\">\n                                    <i class=\"bi bi-check-circle me-1\"></i>Sudah\n                                </span>\n                            <?php else: ?>
                                <span class="badge badge-warning fs-6">
                                    <i class="bi bi-clock me-1"></i>Belum
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Nilai Mata Kuliah -->
            <div class="card stat-card-metronic mb-4">
                <div class="card-header border-0 pt-6">
                    <div class="card-title">
                        <h3 class="fw-bold m-0\" style=\"color: #1e1e2d;\">
                            <i class="bi bi-clipboard-data me-2" style="color: #009ef7;\"></i>Nilai Mata Kuliah
                        </h3>
                    </div>
                    <div class="card-toolbar">
                        <span class="badge badge-primary fs-6"><?= count($nilai ?? []) ?> Mata Kuliah</span>
                    </div>
                </div>
                <div class="card-body py-4">
                    <?php if (!empty($nilai)): ?>
                        <div class="table-responsive">
                            <table class="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3">
                                <thead>
                                    <tr class="fw-bold text-muted">
                                        <th class="min-w-50px">No</th>
                                        <th class="min-w-200px">Mata Kuliah</th>
                                        <th class="min-w-120px">Kriteria</th>
                                        <th class="min-w-80px text-center">Nilai</th>
                                        <th class="min-w-80px text-center">Grade</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; foreach ($nilai as $n): ?>
                                    <tr>
                                        <td>
                                            <span class="text-gray-800 fw-bold"><?= $no++ ?></span>
                                        </td>
                                        <td>
                                            <span class="text-gray-800 fw-bold d-block fs-6\"><?= escape($n['nama_matkul']) ?></span>
                                            <span class="text-muted fw-semibold d-block fs-7"><?= escape($n['kode']) ?></span>
                                        </td>
                                        <td>
                                            <span class="badge badge-light-info fw-bold">
                                                <?= escape($n['nama_kriteria'] ?? '-') ?>
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge badge-light-primary fw-bold fs-6"><?= number_format($n['nilai'], 2) ?></span>
                                        </td>
                                        <td class="text-center">
                                            <?php
                                            $gradeBadge = 'badge-light-info';
                                            if (in_array($n['grade'], ['A', 'A-'])) $gradeBadge = 'badge-light-success';
                                            elseif (in_array($n['grade'], ['B+', 'B'])) $gradeBadge = 'badge-light-primary';
                                            elseif (in_array($n['grade'], ['D', 'E'])) $gradeBadge = 'badge-light-danger';
                                            ?>
                                            <span class="badge <?= $gradeBadge ?> fw-bold fs-6"><?= escape($n['grade']) ?></span>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-10">
                            <div class="symbol symbol-100px symbol-circle mb-5\" style=\"margin: 0 auto;\">
                                <div class="symbol-label bg-light-primary">
                                    <i class="bi bi-inbox fs-1 text-primary\"></i>
                                </div>
                            </div>
                            <p class="text-gray-500 fs-4 fw-semibold\">Belum ada data nilai</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Hasil Rekomendasi -->
            <?php if (!empty($rekomendasi)): ?>
            <div class="card stat-card-metronic">
                <div class="card-header border-0 pt-6" style="background: linear-gradient(135deg, #50cd89 0%, #2ecc71 100%);">
                    <h3 class="card-title fw-bold m-0 text-white">
                        <i class="bi bi-award me-2"></i>Hasil Rekomendasi Tema
                    </h3>
                </div>
                <div class="card-body p-0">
                    <?php foreach ($rekomendasi as $index => $r): ?>
                    <div class="d-flex align-items-center p-6 <?= $index < count($rekomendasi) - 1 ? 'border-bottom border-gray-300' : '' ?> <?= $r['ranking'] == 1 ? 'bg-light-success' : '' ?>">
                        <div class="me-5">
                            <?php if ($r['ranking'] == 1): ?>
                                <div class="symbol symbol-50px">
                                    <div class="symbol-label" style="background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);">
                                        <i class="bi bi-trophy-fill text-white fs-2\"></i>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="symbol symbol-50px">
                                    <div class="symbol-label bg-light-primary">
                                        <span class="text-primary fw-bold fs-3\"><?= $r['ranking'] ?></span>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="flex-grow-1">
                            <h4 class="fw-bold mb-1" style="color: #1e1e2d;"><?= escape($r['nama_tema']) ?></h4>
                            <span class="text-muted fw-semibold fs-7"><?= escape($r['kode']) ?></span>
                        </div>
                        <div class="text-end">
                            <div class="mb-1">
                                <span class="fw-bold fs-2" style="color: #009ef7;">
                                    <?= number_format($r['total_score'] * 100, 2) ?>%
                                </span>
                            </div>
                            <span class="text-muted fw-semibold fs-7\">Score: <?= number_format($r['total_score'], 6) ?></span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
.separator {
    height: 1px;
    background-color: #e4e6ef;
}
.separator-dashed {
    background: none;
    border-top: 1px dashed #e4e6ef;
}
.symbol {
    display: inline-flex;
    flex-shrink: 0;
    position: relative;
    border-radius: 0.475rem;
}
.symbol .symbol-label {
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 500;
    color: #3f4254;
    background-color: #f5f8fa;
    border-radius: 0.475rem;
}
.symbol-circle .symbol-label {
    border-radius: 50%;
}
.symbol-40px {
    height: 40px;
    width: 40px;
}
.symbol-40px .symbol-label {
    height: 40px;
    width: 40px;
}
.symbol-50px {
    height: 50px;
    width: 50px;
}
.symbol-50px .symbol-label {
    height: 50px;
    width: 50px;
}
.symbol-100px {
    height: 100px;
    width: 100px;
}
.symbol-100px .symbol-label {
    height: 100px;
    width: 100px;
}
.bg-light-primary {
    background-color: #f1faff !important;
}
.bg-light-success {
    background-color: #e8fff3 !important;
}
.bg-light-info {
    background-color: #f8f5ff !important;
}
.bg-light-warning {
    background-color: #fff8dd !important;
}
.bg-light-danger {
    background-color: #fff5f8 !important;
}
.badge-light-primary {
    color: #009ef7;
    background-color: #f1faff;
}
.badge-light-success {
    color: #50cd89;
    background-color: #e8fff3;
}
.badge-light-info {
    color: #7239ea;
    background-color: #f8f5ff;
}
.badge-light-warning {
    color: #ffc700;
    background-color: #fff8dd;
}
.badge-light-danger {
    color: #f1416c;
    background-color: #fff5f8;
}
.btn-light-primary {
    color: #009ef7;
    background-color: #f1faff;
    border-color: #f1faff;
}
.btn-light-primary:hover {
    color: #fff;
    background-color: #009ef7;
    border-color: #009ef7;
}
</style>

<?php require_once APP_PATH . '/views/layouts/admin_footer.php'; ?>
