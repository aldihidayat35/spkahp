<?php require_once APP_PATH . '/views/layouts/admin_header.php'; ?>

<div class="container-fluid px-4">
    <h1 class="mt-4"><i class="bi bi-book"></i> Kelola Kurikulum</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/admin/dashboard">Dashboard</a></li>
        <li class="breadcrumb-item active">Kurikulum</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="bi bi-table"></i> Daftar Kurikulum
            </div>
            <a href="<?= BASE_URL ?>/admin/addKurikulum" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle"></i> Tambah Kurikulum
            </a>
        </div>
        <div class="card-body">
            <div class="alert alert-info">
                <i class="bi bi-info-circle"></i> <strong>Informasi:</strong> 
                Kurikulum otomatis diterapkan pada mahasiswa berdasarkan angkatan. 
                Misalnya, Angkatan 2024 → Kurikulum B, Angkatan 2025 → Kurikulum C.
            </div>

            <?php if (empty($kurikulum)): ?>
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle"></i> Belum ada data kurikulum.
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover" id="kurikulumTable">
                        <thead class="table-dark">
                            <tr>
                                <th width="5%">No</th>
                                <th width="10%">Angkatan</th>
                                <th width="20%">Nama Kurikulum</th>
                                <th width="15%">Tahun Berlaku</th>
                                <th width="10%" class="text-center">Jumlah Matkul</th>
                                <th width="10%" class="text-center">Jumlah Mahasiswa</th>
                                <th width="25%">Keterangan</th>
                                <th width="15%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($kurikulum as $k): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><span class="badge bg-primary"><?= htmlspecialchars($k['angkatan']) ?></span></td>
                                <td><strong><?= htmlspecialchars($k['nama_kurikulum']) ?></strong></td>
                                <td><?= htmlspecialchars($k['tahun_berlaku']) ?></td>
                                <td class="text-center">
                                    <span class="badge bg-info"><?= $k['jumlah_matkul'] ?> Matkul</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-success"><?= $k['jumlah_mahasiswa'] ?> Mahasiswa</span>
                                </td>
                                <td><?= htmlspecialchars($k['keterangan']) ?></td>
                                <td class="text-center">
                                    <a href="<?= BASE_URL ?>/admin/detailKurikulum/<?= $k['id'] ?>" 
                                       class="btn btn-info btn-sm" title="Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="<?= BASE_URL ?>/admin/editKurikulum/<?= $k['id'] ?>" 
                                       class="btn btn-warning btn-sm" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <?php if ($k['jumlah_matkul'] == 0 && $k['jumlah_mahasiswa'] == 0): ?>
                                    <a href="<?= BASE_URL ?>/admin/deleteKurikulum/<?= $k['id'] ?>" 
                                       class="btn btn-danger btn-sm" 
                                       onclick="return confirm('Yakin ingin menghapus kurikulum ini?')"
                                       title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                    <?php else: ?>
                                    <button class="btn btn-secondary btn-sm" disabled title="Tidak dapat dihapus (masih digunakan)">
                                        <i class="bi bi-trash"></i>
                                    </button>
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

    <!-- Informasi Tambahan -->
    <div class="card">
        <div class="card-header bg-success text-white">
            <i class="bi bi-lightbulb"></i> Cara Kerja Sistem Kurikulum
        </div>
        <div class="card-body">
            <h6>Logika Auto-Assign Kurikulum:</h6>
            <ol>
                <li>Admin membuat kurikulum dengan menentukan <strong>angkatan</strong> dan <strong>nama kurikulum</strong></li>
                <li>Ketika mahasiswa didaftarkan dengan angkatan tertentu, sistem otomatis mencocokkan dengan kurikulum yang sesuai</li>
                <li>Mata kuliah yang ditampilkan pada mahasiswa akan <strong>difilter berdasarkan kurikulum</strong> mereka</li>
                <li>Mahasiswa <strong>tidak dapat memilih kurikulum manual</strong> untuk menghindari kesalahan</li>
            </ol>
            
            <h6 class="mt-3">Contoh Implementasi:</h6>
            <ul>
                <li>Angkatan <strong>2024</strong> → otomatis menggunakan <strong>Kurikulum B</strong></li>
                <li>Angkatan <strong>2025</strong> → otomatis menggunakan <strong>Kurikulum C</strong></li>
            </ul>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#kurikulumTable').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json"
        },
        "order": [[1, 'desc']] // Sort by angkatan descending
    });
});
</script>

<?php require_once APP_PATH . '/views/layouts/admin_footer.php'; ?>
