<?php require_once APP_PATH . '/views/layouts/admin_header.php'; ?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Data Mata Kuliah</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?= url('admin/dashboard') ?>">Dashboard</a></li>
        <li class="breadcrumb-item active">Mata Kuliah</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="bi bi-book me-1"></i> Daftar Mata Kuliah</span>
            <a href="<?= url('admin/addMatakuliah') ?>" class="btn btn-sm btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah Mata Kuliah
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Nama Mata Kuliah</th>
                            <th>Kurikulum</th>
                            <th>Kriteria</th>
                            <th>Bobot</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($matakuliah)): ?>
                            <?php $no = 1; foreach ($matakuliah as $mk): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><strong><?= escape($mk['kode']) ?></strong></td>
                                <td><?= escape($mk['nama_matkul']) ?></td>
                                <td>
                                    <?php if ($mk['nama_kurikulum']): ?>
                                        <span class="badge bg-primary"><?= escape($mk['nama_kurikulum']) ?></span>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($mk['nama_kriteria']): ?>
                                        <span class="badge bg-info"><?= escape($mk['nama_kriteria']) ?></span>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= number_format($mk['bobot_matkul'], 2) ?></td>
                                <td>
                                    <?php if ($mk['is_active']): ?>
                                        <span class="badge bg-success">Aktif</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Nonaktif</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= url('admin/editMatakuliah/' . $mk['id']) ?>" class="btn btn-warning">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form method="POST" action="<?= url('admin/deleteMatakuliah/' . $mk['id']) ?>" style="display: inline;">
                                            <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                                            <button type="submit" class="btn btn-danger" 
                                                    onclick="return confirm('Yakin ingin menghapus mata kuliah ini?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada data mata kuliah</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once APP_PATH . '/views/layouts/admin_footer.php'; ?>
