<?php require_once APP_PATH . '/views/layouts/admin_header.php'; ?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Data Kriteria</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?= url('admin/dashboard') ?>">Dashboard</a></li>
        <li class="breadcrumb-item active">Kriteria</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="bi bi-sliders me-1"></i> Daftar Kriteria</span>
            <a href="<?= url('admin/addKriteria') ?>" class="btn btn-sm btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah Kriteria
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Nama Kriteria</th>
                            <th>Jenis</th>
                            <th>Bobot</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($kriteria)): ?>
                            <?php $no = 1; foreach ($kriteria as $k): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><strong><?= escape($k['kode']) ?></strong></td>
                                <td><?= escape($k['nama_kriteria']) ?></td>
                                <td>
                                    <span class="badge bg-<?= $k['jenis'] == 'benefit' ? 'success' : 'warning' ?>">
                                        <?= ucfirst($k['jenis']) ?>
                                    </span>
                                </td>
                                <td><?= number_format($k['bobot'], 6) ?></td>
                                <td>
                                    <?php if ($k['is_active']): ?>
                                        <span class="badge bg-success">Aktif</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Nonaktif</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= url('admin/editKriteria/' . $k['id']) ?>" class="btn btn-warning">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="<?= url('admin/deleteKriteria/' . $k['id']) ?>" 
                                           class="btn btn-danger"
                                           onclick="return confirm('Yakin ingin menghapus kriteria ini?')">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada data kriteria</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once APP_PATH . '/views/layouts/admin_footer.php'; ?>
