<?php require_once APP_PATH . '/views/layouts/admin_header.php'; ?>

<?php
// Check if fixed weights are enforced
$ahp_settings = require ROOT_PATH . '/config/ahp_settings.php';
$fixed_weights_enabled = !empty($ahp_settings['enforce_fixed_weights']);
?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Data Kriteria</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?= url('admin/dashboard') ?>">Dashboard</a></li>
        <li class="breadcrumb-item active">Kriteria</li>
    </ol>

    <?php if ($fixed_weights_enabled): ?>
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <i class="bi bi-info-circle-fill me-2"></i>
        <strong>Mode Bobot Tetap Aktif!</strong> 
        Bobot kriteria dihitung berdasarkan nilai tetap yang telah ditetapkan:
        <ul class="mb-0 mt-2">
            <?php foreach ($ahp_settings['fixed_kriteria'] as $name => $score): ?>
            <li><strong><?= ucwords($name) ?></strong> = <?= $score ?></li>
            <?php endforeach; ?>
        </ul>
        <small class="d-block mt-2">
            Bobot akhir adalah normalisasi dari nilai-nilai di atas. 
            Pairwise comparison kriteria tidak akan mengubah bobot ketika mode ini aktif.
        </small>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

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
                                <td>
                                    <?= number_format($k['bobot'], 6) ?>
                                    <?php if ($fixed_weights_enabled): ?>
                                    <span class="badge bg-warning text-dark ms-1" title="Bobot tetap dari konfigurasi">
                                        <i class="bi bi-lock-fill"></i> TETAP
                                    </span>
                                    <?php endif; ?>
                                </td>
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
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>
                                        <form action="<?= url('admin/deleteKriteria/' . $k['id']) ?>" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus kriteria ini? Data pairwise terkait juga akan terhapus.')">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="btn btn-danger">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </form>
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
