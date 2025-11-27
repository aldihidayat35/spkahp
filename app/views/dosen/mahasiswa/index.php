<?php require_once APP_PATH . '/views/layouts/dosen_header.php'; ?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Data Mahasiswa</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?= url('dosen/dashboard') ?>">Dashboard</a></li>
        <li class="breadcrumb-item active">Mahasiswa</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="bi bi-people me-1"></i> Daftar Mahasiswa
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover" id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIM</th>
                            <th>Nama</th>
                            <th>Angkatan</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($mahasiswa)): ?>
                            <?php $no = 1; foreach ($mahasiswa as $mhs): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><strong><?= escape($mhs['nim']) ?></strong></td>
                                <td><?= escape($mhs['nama']) ?></td>
                                <td><span class="badge bg-primary"><?= escape($mhs['angkatan']) ?></span></td>
                                <td><?= escape($mhs['email']) ?></td>
                                <td>
                                    <?php if ($mhs['is_active']): ?>
                                        <span class="badge bg-success">Aktif</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Nonaktif</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="<?= url('dosen/detailMahasiswa/' . $mhs['id']) ?>" class="btn btn-sm btn-info">
                                        <i class="bi bi-eye"></i> Detail
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada data mahasiswa</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once APP_PATH . '/views/layouts/admin_footer.php'; ?>
