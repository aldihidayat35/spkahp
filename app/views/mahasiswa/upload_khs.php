<?php require_once APP_PATH . '/views/layouts/mahasiswa_header.php'; ?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Upload KHS</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?= url('mahasiswa/dashboard') ?>">Dashboard</a></li>
        <li class="breadcrumb-item active">Upload KHS</li>
    </ol>

    <div class="alert alert-info">
        <i class="bi bi-info-circle"></i>
        <strong>Petunjuk Upload KHS:</strong>
        <ul class="mb-0 mt-2">
            <li>Upload Kartu Hasil Studi (KHS) sebagai bukti nilai mata kuliah yang Anda input</li>
            <li>Format file: PDF, JPG, JPEG, atau PNG</li>
            <li>Ukuran maksimal: 5 MB</li>
            <li>KHS akan diverifikasi oleh dosen/admin</li>
        </ul>
    </div>

    <!-- Upload Form -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <i class="bi bi-cloud-upload"></i> Upload KHS Baru
        </div>
        <div class="card-body">
            <form action="<?= url('mahasiswa/prosesUploadKHS') ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="semester" class="form-label">Semester <span class="text-danger">*</span></label>
                            <select class="form-select" id="semester" name="semester" required>
                                <option value="">-- Pilih Semester --</option>
                                <?php for($i=1; $i<=8; $i++): ?>
                                <option value="<?= $i ?>">Semester <?= $i ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="tahun_akademik" class="form-label">Tahun Akademik <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="tahun_akademik" name="tahun_akademik" 
                                   placeholder="Contoh: 2023/2024" required>
                            <small class="text-muted">Format: YYYY/YYYY</small>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="file_khs" class="form-label">File KHS <span class="text-danger">*</span></label>
                    <input type="file" class="form-control" id="file_khs" name="file_khs" 
                           accept=".pdf,.jpg,.jpeg,.png" required>
                    <small class="text-muted">
                        Format: PDF, JPG, JPEG, PNG | Maksimal: 5 MB
                    </small>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-upload"></i> Upload KHS
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- KHS List -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="bi bi-list-ul"></i> Riwayat Upload KHS</span>
        </div>
        <div class="card-body">
            <?php if (!empty($khs_list)): ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Semester</th>
                            <th>Tahun Akademik</th>
                            <th>File</th>
                            <th>Ukuran</th>
                            <th>Tanggal Upload</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($khs_list as $khs): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td>Semester <?= $khs['semester'] ?></td>
                            <td><?= escape($khs['tahun_akademik']) ?></td>
                            <td>
                                <a href="<?= url($khs['file_path']) ?>" target="_blank">
                                    <i class="bi bi-file-earmark-pdf"></i> 
                                    <?= escape($khs['file_name']) ?>
                                </a>
                            </td>
                            <td><?= number_format($khs['file_size'] / 1024, 2) ?> KB</td>
                            <td><?= date('d/m/Y H:i', strtotime($khs['upload_date'])) ?></td>
                            <td>
                                <?php if ($khs['verified']): ?>
                                    <span class="badge bg-success">
                                        <i class="bi bi-check-circle"></i> Terverifikasi
                                    </span>
                                    <?php if (!empty($khs['verified_by_nama'])): ?>
                                    <br><small class="text-muted">
                                        oleh <?= escape($khs['verified_by_nama']) ?>
                                    </small>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <span class="badge bg-warning text-dark">
                                        <i class="bi bi-clock"></i> Menunggu Verifikasi
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="<?= url($khs['file_path']) ?>" 
                                       class="btn btn-info" target="_blank" title="Lihat File">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <?php if (!$khs['verified']): ?>
                                    <a href="<?= url('mahasiswa/deleteKHS/' . $khs['id']) ?>" 
                                       class="btn btn-danger"
                                       onclick="return confirm('Yakin ingin menghapus KHS ini?')"
                                       title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php if (!empty($khs['catatan'])): ?>
                        <tr>
                            <td colspan="8" class="bg-light">
                                <small><strong>Catatan:</strong> <?= escape($khs['catatan']) ?></small>
                            </td>
                        </tr>
                        <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
            <div class="text-center py-4 text-muted">
                <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                <p class="mt-2">Belum ada KHS yang diupload.</p>
                <p><small>Upload KHS Anda menggunakan form di atas.</small></p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once APP_PATH . '/views/layouts/mahasiswa_footer.php'; ?>
