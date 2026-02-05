<?php require_once APP_PATH . '/views/layouts/admin_header.php'; ?>

<div class="container-fluid px-4">
    <h1 class="mt-4"><i class="bi bi-book"></i> Detail Kurikulum</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/admin/dashboard">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/admin/kurikulum">Kurikulum</a></li>
        <li class="breadcrumb-item active">Detail</li>
    </ol>

    <!-- Info Kurikulum -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <div>
                <i class="bi bi-info-circle"></i> Informasi Kurikulum
            </div>
            <a href="<?= BASE_URL ?>/admin/editKurikulum/<?= $kurikulum['id'] ?>" class="btn btn-light btn-sm">
                <i class="bi bi-pencil"></i> Edit
            </a>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <th width="40%">Nama Kurikulum</th>
                            <td><strong><?= htmlspecialchars($kurikulum['nama_kurikulum']) ?></strong></td>
                        </tr>
                        <tr>
                            <th>Angkatan</th>
                            <td><span class="badge bg-primary"><?= htmlspecialchars($kurikulum['angkatan']) ?></span></td>
                        </tr>
                        <tr>
                            <th>Tahun Berlaku</th>
                            <td><?= htmlspecialchars($kurikulum['tahun_berlaku']) ?></td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <th width="40%">Keterangan</th>
                            <td><?= htmlspecialchars($kurikulum['keterangan']) ?></td>
                        </tr>
                        <tr>
                            <th>Dibuat</th>
                            <td><?= date('d M Y H:i', strtotime($kurikulum['created_at'])) ?></td>
                        </tr>
                        <tr>
                            <th>Terakhir Update</th>
                            <td><?= date('d M Y H:i', strtotime($kurikulum['updated_at'])) ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Mata Kuliah -->
        <div class="col-lg-7 mb-4">
            <div class="card h-100">
                <div class="card-header bg-success text-white">
                    <i class="bi bi-journal-bookmark"></i> Mata Kuliah dalam Kurikulum 
                    <span class="badge bg-light text-dark"><?= count($mataKuliah) ?></span>
                </div>
                <div class="card-body">
                    <?php if (empty($mataKuliah)): ?>
                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-triangle"></i> Belum ada mata kuliah dalam kurikulum ini.
                            <hr>
                            <a href="<?= BASE_URL ?>/admin/matakuliah" class="btn btn-sm btn-primary">
                                <i class="bi bi-plus-circle"></i> Tambah Mata Kuliah
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-sm table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="15%">Kode</th>
                                        <th width="60%">Nama Mata Kuliah</th>
                                        <th width="20%">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; foreach ($mataKuliah as $mk): ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><code><?= htmlspecialchars($mk['kode']) ?></code></td>
                                        <td><?= htmlspecialchars($mk['nama_matkul']) ?></td>
                                        <td>
                                            <?php if ($mk['is_active']): ?>
                                                <span class="badge bg-success">Aktif</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary">Tidak Aktif</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Mahasiswa -->
        <div class="col-lg-5 mb-4">
            <div class="card h-100">
                <div class="card-header bg-info text-white">
                    <i class="bi bi-people"></i> Mahasiswa Menggunakan Kurikulum Ini 
                    <span class="badge bg-light text-dark"><?= count($mahasiswa) ?></span>
                </div>
                <div class="card-body">
                    <?php if (empty($mahasiswa)): ?>
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i> Belum ada mahasiswa yang menggunakan kurikulum ini.
                        </div>
                    <?php else: ?>
                        <div class="list-group" style="max-height: 500px; overflow-y: auto;">
                            <?php foreach ($mahasiswa as $mhs): ?>
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="mb-1"><?= htmlspecialchars($mhs['nama']) ?></h6>
                                        <small class="text-muted">
                                            <i class="bi bi-card-text"></i> <?= htmlspecialchars($mhs['nim']) ?> | 
                                            <i class="bi bi-calendar"></i> Angkatan <?= htmlspecialchars($mhs['angkatan']) ?>
                                        </small>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="mb-3">
        <a href="<?= BASE_URL ?>/admin/kurikulum" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<?php require_once APP_PATH . '/views/layouts/admin_footer.php'; ?>
