<?php require_once APP_PATH . '/views/layouts/mahasiswa_header.php'; ?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Kurikulum Saya</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?= url('mahasiswa/dashboard') ?>">Dashboard</a></li>
        <li class="breadcrumb-item active">Kurikulum</li>
    </ol>

    <?php if ($kurikulum): ?>
    <!-- Kurikulum Info -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <i class="bi bi-book"></i> Informasi Kurikulum
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <strong>Nama Kurikulum:</strong>
                    <p><?= escape($kurikulum['nama_kurikulum']) ?></p>
                </div>
                <div class="col-md-4">
                    <strong>Angkatan Anda:</strong>
                    <p><span class="badge bg-info"><?= $angkatan ?></span></p>
                </div>
                <div class="col-md-4">
                    <strong>Tahun Berlaku:</strong>
                    <p><?= escape($kurikulum['tahun_berlaku'] ?? '-') ?></p>
                </div>
            </div>
            <?php if (!empty($kurikulum['keterangan'])): ?>
            <hr>
            <div>
                <strong>Keterangan:</strong>
                <p class="mb-0"><?= nl2br(escape($kurikulum['keterangan'])) ?></p>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Mata Kuliah per Semester -->
    <?php if (!empty($matakuliah)): ?>
    <?php 
    // Group by semester
    $matkul_by_semester = [];
    foreach ($matakuliah as $mk) {
        $matkul_by_semester[$mk['semester']][] = $mk;
    }
    ksort($matkul_by_semester);
    ?>

    <?php foreach ($matkul_by_semester as $semester => $matkul_list): ?>
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>
                <i class="bi bi-calendar"></i> <strong>Semester <?= $semester ?></strong>
            </span>
            <span class="badge bg-primary"><?= count($matkul_list) ?> Mata Kuliah</span>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th width="10%">Kode</th>
                            <th width="40%">Nama Mata Kuliah</th>
                            <th width="10%">SKS</th>
                            <th width="20%">Dosen Pengampu</th>
                            <th width="10%">Jenis</th>
                            <th width="10%">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($matkul_list as $mk): ?>
                        <tr>
                            <td><code><?= escape($mk['kode_matkul']) ?></code></td>
                            <td><?= escape($mk['nama_matkul']) ?></td>
                            <td><span class="badge bg-secondary"><?= $mk['sks'] ?> SKS</span></td>
                            <td>
                                <?php if (!empty($mk['dosen_pengampu'])): ?>
                                <small><?= escape($mk['dosen_pengampu']) ?></small>
                                <?php else: ?>
                                <small class="text-muted">-</small>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($mk['is_wajib']): ?>
                                <span class="badge bg-danger">Wajib</span>
                                <?php else: ?>
                                <span class="badge bg-info">Pilihan</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($mk['is_active']): ?>
                                <span class="badge bg-success"><i class="bi bi-check-circle"></i></span>
                                <?php else: ?>
                                <span class="badge bg-secondary"><i class="bi bi-x-circle"></i></span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Summary per semester -->
            <div class="row mt-3">
                <div class="col-md-12">
                    <div class="alert alert-light mb-0">
                        <strong><i class="bi bi-calculator"></i> Total SKS Semester <?= $semester ?>:</strong>
                        <?php 
                        $total_sks = array_sum(array_column($matkul_list, 'sks'));
                        $wajib_count = count(array_filter($matkul_list, function($m) { return $m['is_wajib']; }));
                        $pilihan_count = count($matkul_list) - $wajib_count;
                        ?>
                        <span class="badge bg-primary ms-2"><?= $total_sks ?> SKS</span>
                        <span class="ms-3">
                            <i class="bi bi-check-square text-danger"></i> <?= $wajib_count ?> Wajib
                        </span>
                        <span class="ms-2">
                            <i class="bi bi-square text-info"></i> <?= $pilihan_count ?> Pilihan
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>

    <!-- Overall Summary -->
    <div class="card border-info">
        <div class="card-header bg-info text-white">
            <i class="bi bi-clipboard-data"></i> Ringkasan Kurikulum
        </div>
        <div class="card-body">
            <div class="row text-center">
                <div class="col-md-3">
                    <div class="p-3">
                        <h3 class="text-primary"><?= count($matakuliah) ?></h3>
                        <small class="text-muted">Total Mata Kuliah</small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="p-3">
                        <h3 class="text-success"><?= array_sum(array_column($matakuliah, 'sks')) ?></h3>
                        <small class="text-muted">Total SKS</small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="p-3">
                        <h3 class="text-danger">
                            <?= count(array_filter($matakuliah, function($m) { return $m['is_wajib']; })) ?>
                        </h3>
                        <small class="text-muted">Mata Kuliah Wajib</small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="p-3">
                        <h3 class="text-info">
                            <?= count(array_filter($matakuliah, function($m) { return !$m['is_wajib']; })) ?>
                        </h3>
                        <small class="text-muted">Mata Kuliah Pilihan</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php else: ?>
    <div class="alert alert-warning">
        <i class="bi bi-exclamation-triangle"></i>
        <strong>Belum ada mata kuliah</strong> yang terdaftar dalam kurikulum ini.
        Hubungi admin untuk informasi lebih lanjut.
    </div>
    <?php endif; ?>

    <?php else: ?>
    <!-- No Kurikulum Found -->
    <div class="card">
        <div class="card-body text-center py-5">
            <i class="bi bi-book text-muted" style="font-size: 4rem;"></i>
            <h4 class="mt-3">Kurikulum Tidak Ditemukan</h4>
            <p class="text-muted">
                Tidak ada kurikulum yang sesuai dengan angkatan Anda (<?= $angkatan ?>).
                <br>Hubungi admin untuk informasi lebih lanjut.
            </p>
        </div>
    </div>
    <?php endif; ?>
</div>

<?php require_once APP_PATH . '/views/layouts/mahasiswa_footer.php'; ?>
