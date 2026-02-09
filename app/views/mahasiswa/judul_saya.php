<?php require_once APP_PATH . '/views/layouts/mahasiswa_header.php'; ?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Judul Tugas Akhir Saya</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?= url('mahasiswa/dashboard') ?>">Dashboard</a></li>
        <li class="breadcrumb-item active">Judul Saya</li>
    </ol>

    <div class="alert alert-info">
        <i class="bi bi-info-circle"></i>
        <strong>Petunjuk:</strong>
        <ul class="mb-0 mt-2">
            <li>Input judul tugas akhir yang sesuai dengan tema rekomendasi Anda</li>
            <li>Anda dapat menyimpan sebagai draft atau langsung mengajukan untuk persetujuan</li>
            <li>Judul yang sudah diajukan akan direview oleh dosen pembimbing</li>
            <li>Anda dapat melihat referensi judul di menu "Judul Kakak Tingkat"</li>
        </ul>
    </div>

    <!-- Input Form -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <i class="bi bi-plus-circle"></i> Tambah Judul Baru
        </div>
        <div class="card-body">
            <form action="<?= url('mahasiswa/submitJudul') ?>" method="POST">
                <?= csrf_field() ?>
                
                <div class="mb-3">
                    <label for="tema_id" class="form-label">Tema <span class="text-danger">*</span></label>
                    <select class="form-select" id="tema_id" name="tema_id" required>
                        <option value="">-- Pilih Tema --</option>
                        <?php foreach ($tema_list as $tema): ?>
                        <option value="<?= $tema['id'] ?>">
                            <?= escape($tema['nama_tema']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                    <small class="text-muted">Pilih tema sesuai hasil rekomendasi Anda</small>
                </div>

                <div class="mb-3">
                    <label for="judul" class="form-label">Judul Tugas Akhir <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="judul" name="judul" rows="3" 
                              placeholder="Masukkan judul tugas akhir yang spesifik dan jelas" required></textarea>
                    <small class="text-muted">Contoh: Sistem Informasi Manajemen Perpustakaan Berbasis Web dengan Metode...</small>
                </div>

                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi (Opsional)</label>
                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" 
                              placeholder="Jelaskan secara singkat tentang rencana tugas akhir Anda"></textarea>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Simpan Judul
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Judul List -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="bi bi-list-ul"></i> Daftar Judul Saya</span>
        </div>
        <div class="card-body">
            <?php if (!empty($judul_list)): ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul</th>
                            <th>Tema</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($judul_list as $judul): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td>
                                <strong><?= escape($judul['judul']) ?></strong>
                                <?php if (!empty($judul['deskripsi'])): ?>
                                <br><small class="text-muted"><?= nl2br(escape($judul['deskripsi'])) ?></small>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($judul['tema_nama']): ?>
                                <span class="badge bg-info"><?= escape($judul['tema_nama']) ?></span>
                                <?php else: ?>
                                <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php
                                $status_badges = [
                                    'draft' => '<span class="badge bg-secondary"><i class="bi bi-pencil"></i> Draft</span>',
                                    'submitted' => '<span class="badge bg-warning text-dark"><i class="bi bi-clock"></i> Menunggu Review</span>',
                                    'approved' => '<span class="badge bg-success"><i class="bi bi-check-circle"></i> Disetujui</span>',
                                    'rejected' => '<span class="badge bg-danger"><i class="bi bi-x-circle"></i> Ditolak</span>'
                                ];
                                echo $status_badges[$judul['status']] ?? $judul['status'];
                                ?>
                            </td>
                            <td><?= date('d/m/Y', strtotime($judul['created_at'])) ?></td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <?php if ($judul['status'] == 'draft'): ?>
                                    <!-- Edit Modal Trigger -->
                                    <button type="button" class="btn btn-warning" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editModal<?= $judul['id'] ?>">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <a href="<?= url('mahasiswa/ajukanJudul/' . $judul['id']) ?>" 
                                       class="btn btn-success"
                                       onclick="return confirm('Ajukan judul ini untuk persetujuan?')"
                                       title="Ajukan">
                                        <i class="bi bi-send"></i>
                                    </a>
                                    <a href="<?= url('mahasiswa/deleteJudul/' . $judul['id']) ?>" 
                                       class="btn btn-danger"
                                       onclick="return confirm('Yakin ingin menghapus judul ini?')"
                                       title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php if (!empty($judul['catatan'])): ?>
                        <tr>
                            <td colspan="6" class="bg-light">
                                <small><strong>Catatan Dosen:</strong> <?= nl2br(escape($judul['catatan'])) ?></small>
                            </td>
                        </tr>
                        <?php endif; ?>

                        <!-- Edit Modal -->
                        <?php if ($judul['status'] == 'draft'): ?>
                        <div class="modal fade" id="editModal<?= $judul['id'] ?>" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form action="<?= url('mahasiswa/editJudul/' . $judul['id']) ?>" method="POST">
                                        <?= csrf_field() ?>
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Judul</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">Tema</label>
                                                <select class="form-select" name="tema_id" required>
                                                    <?php foreach ($tema_list as $tema): ?>
                                                    <option value="<?= $tema['id'] ?>" 
                                                            <?= $tema['id'] == $judul['tema_id'] ? 'selected' : '' ?>>
                                                        <?= escape($tema['nama_tema']) ?>
                                                    </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Judul</label>
                                                <textarea class="form-control" name="judul" rows="3" required><?= escape($judul['judul']) ?></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Deskripsi</label>
                                                <textarea class="form-control" name="deskripsi" rows="4"><?= escape($judul['deskripsi']) ?></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
            <div class="text-center py-4 text-muted">
                <i class="bi bi-journal-x" style="font-size: 3rem;"></i>
                <p class="mt-2">Belum ada judul yang dibuat.</p>
                <p><small>Tambahkan judul tugas akhir Anda menggunakan form di atas.</small></p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once APP_PATH . '/views/layouts/mahasiswa_footer.php'; ?>
