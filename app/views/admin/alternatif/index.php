<?php require_once APP_PATH . '/views/layouts/admin_header.php'; ?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Data Alternatif Tema</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?= url('admin/dashboard') ?>">Dashboard</a></li>
        <li class="breadcrumb-item active">Alternatif Tema</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="bi bi-lightbulb me-1"></i> Daftar Alternatif Tema</span>
            <a href="<?= url('admin/addAlternatif') ?>" class="btn btn-sm btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah Alternatif
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Nama Tema</th>
                            <th>Deskripsi</th>
                            <th>Icon</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($alternatif)): ?>
                            <?php $no = 1; foreach ($alternatif as $alt): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><strong><?= escape($alt['kode']) ?></strong></td>
                                <td><?= escape($alt['nama_tema']) ?></td>
                                <td><?= str_limit(escape($alt['deskripsi'] ?? ''), 50) ?></td>
                                <td><i class="<?= escape($alt['icon']) ?>"></i> <?= escape($alt['icon']) ?></td>
                                <td>
                                    <?php if ($alt['is_active']): ?>
                                        <span class="badge bg-success">Aktif</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Nonaktif</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= url('admin/editAlternatif/' . $alt['id']) ?>" class="btn btn-warning">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form method="POST" action="<?= url('admin/deleteAlternatif/' . $alt['id']) ?>" style="display: inline;">
                                            <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                                            <button type="submit" class="btn btn-danger" 
                                                    onclick="return confirm('Yakin ingin menghapus alternatif ini?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada data alternatif</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once APP_PATH . '/views/layouts/admin_footer.php'; ?>
