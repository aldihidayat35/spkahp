<?php require_once APP_PATH . '/views/layouts/mahasiswa_header.php'; ?>

<div class="container-fluid px-4">
    <h1 class="mt-4"><i class="bi bi-person-circle me-2"></i>Profil Saya</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?= url('mahasiswa/dashboard') ?>">Dashboard</a></li>
        <li class="breadcrumb-item active">Profil</li>
    </ol>

    <div class="row">
        <!-- Profile Card -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body text-center">
                    <?php if (isset($mahasiswa) && $mahasiswa): ?>
                        <!-- Photo Upload Section -->
                        <div class="position-relative d-inline-block mb-3">
                            <?php 
                            $userModel = new UserModel();
                            $foto_url = $userModel->getFotoPath($_SESSION['user_id']);
                            ?>
                            <img src="<?= $foto_url ?>" 
                                 alt="Foto Profil" 
                                 class="rounded-circle" 
                                 style="width: 150px; height: 150px; object-fit: cover; border: 4px solid #009ef7;"
                                 id="profilePhoto">
                            <button type="button" 
                                    class="btn btn-primary btn-sm rounded-circle position-absolute" 
                                    style="bottom: 0; right: 0; width: 40px; height: 40px; padding: 0;"
                                    data-bs-toggle="modal" 
                                    data-bs-target="#uploadFotoModal">
                                <i class="bi bi-camera"></i>
                            </button>
                        </div>
                        
                        <h4 class="mb-1"><?= escape($mahasiswa['nama'] ?? 'Mahasiswa') ?></h4>
                        <p class="text-muted mb-3"><?= escape($mahasiswa['nim'] ?? '') ?></p>
                        <div class="mb-3">
                            <span class="badge badge-light-primary">
                                <i class="bi bi-calendar3 me-1"></i>Angkatan <?= escape($mahasiswa['angkatan'] ?? '') ?>
                            </span>
                        </div>
                        <div class="separator"></div>
                        <div class="info-list-metronic text-start mt-3">
                            <div class="info-item">
                                <div class="info-label">Username</div>
                                <div class="info-value"><?= escape($mahasiswa['username'] ?? '-') ?></div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Minat Utama</div>
                                <div class="info-value"><?= escape($mahasiswa['minat_utama'] ?? '-') ?></div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Terdaftar Sejak</div>
                                <div class="info-value">
                                    <?php 
                                    if (isset($mahasiswa['created_at'])) {
                                        $date = new DateTime($mahasiswa['created_at']);
                                        echo $date->format('d F Y');
                                    } else {
                                        echo '-';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <p class="text-muted">Data profil tidak ditemukan</p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header bg-light-info">
                    <h6 class="mb-0 text-info"><i class="bi bi-info-circle me-2"></i>Informasi</h6>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-0">
                        <small>Pastikan data profil Anda selalu up to date untuk keperluan akademik dan sistem rekomendasi tema tugas akhir.</small>
                    </p>
                </div>
            </div>
        </div>

        <!-- Edit Form -->
        <div class="col-md-8 mb-4">
            <div class="card">
                <div class="card-header bg-gradient" style="background: linear-gradient(135deg, #009ef7 0%, #7239ea 100%);">
                    <h5 class="mb-0 text-white"><i class="bi bi-pencil-square me-2"></i>Edit Profil</h5>
                </div>
                <div class="card-body">
                    <?php if (isset($mahasiswa) && $mahasiswa): ?>
                        <form action="<?= url('mahasiswa/profil') ?>" method="POST">
                            <?= csrf_field() ?>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">NIM <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" value="<?= escape($mahasiswa['nim'] ?? '') ?>" disabled>
                                    <small class="text-muted">NIM tidak dapat diubah</small>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Username <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" value="<?= escape($mahasiswa['username'] ?? '') ?>" disabled>
                                    <small class="text-muted">Username tidak dapat diubah</small>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" name="nama" class="form-control" 
                                       value="<?= escape($mahasiswa['nama'] ?? '') ?>" required>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Angkatan <span class="text-danger">*</span></label>
                                    <input type="text" name="angkatan" class="form-control" 
                                           value="<?= escape($mahasiswa['angkatan'] ?? '') ?>" 
                                           pattern="[0-9]{4}" 
                                           placeholder="Contoh: 2021"
                                           required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Minat Utama</label>
                                    <select name="minat_utama" class="form-select">
                                        <option value="">-- Pilih Minat --</option>
                                        <option value="Kependidikan" <?= isset($mahasiswa['minat_utama']) && $mahasiswa['minat_utama'] == 'Kependidikan' ? 'selected' : '' ?>>Kependidikan</option>
                                        <option value="Pemrograman" <?= isset($mahasiswa['minat_utama']) && $mahasiswa['minat_utama'] == 'Pemrograman' ? 'selected' : '' ?>>Pemrograman</option>
                                        <option value="Multimedia" <?= isset($mahasiswa['minat_utama']) && $mahasiswa['minat_utama'] == 'Multimedia' ? 'selected' : '' ?>>Multimedia</option>
                                        <option value="Jaringan" <?= isset($mahasiswa['minat_utama']) && $mahasiswa['minat_utama'] == 'Jaringan' ? 'selected' : '' ?>>Jaringan Komputer</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                        <input type="email" name="email" class="form-control" 
                                               value="<?= escape($mahasiswa['email'] ?? '') ?>" 
                                               placeholder="email@example.com"
                                               required>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">No HP</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-phone"></i></span>
                                        <input type="text" name="no_hp" class="form-control" 
                                               value="<?= escape($mahasiswa['no_hp'] ?? '') ?>"
                                               placeholder="08xxxxxxxxxx">
                                    </div>
                                </div>
                            </div>

                            <div class="separator"></div>

                            <div class="d-flex gap-2 mt-4">
                                <button type="submit" class="btn btn-metronic btn-primary-metronic">
                                    <i class="bi bi-save"></i> Simpan Perubahan
                                </button>
                                <a href="<?= url('auth/changePassword') ?>" class="btn btn-warning">
                                    <i class="bi bi-key"></i> Ubah Password
                                </a>
                                <a href="<?= url('mahasiswa/dashboard') ?>" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left"></i> Kembali
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Upload Foto Modal -->
<div class="modal fade" id="uploadFotoModal" tabindex="-1" aria-labelledby="uploadFotoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= url('mahasiswa/uploadFoto') ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadFotoModalLabel">
                        <i class="bi bi-camera"></i> Upload Foto Profil
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="foto" class="form-label">Pilih Foto</label>
                        <input type="file" class="form-control" id="foto" name="foto" 
                               accept="image/jpeg,image/jpg,image/png" required>
                        <small class="text-muted">
                            Format: JPG, JPEG, PNG | Maksimal: 2 MB
                        </small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Preview</label>
                        <div class="text-center">
                            <img id="fotoPreview" src="#" alt="Preview" 
                                 class="img-thumbnail" 
                                 style="max-width: 200px; display: none;">
                        </div>
                    </div>
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i>
                        <small>
                            <strong>Tips:</strong>
                            <ul class="mb-0 mt-1">
                                <li>Gunakan foto dengan pencahayaan yang baik</li>
                                <li>Foto wajah yang jelas dan profesional</li>
                                <li>Ukuran ideal: 500x500 px atau rasio 1:1</li>
                            </ul>
                        </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-upload"></i> Upload
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Preview foto sebelum upload
document.getElementById('foto').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('fotoPreview');
            preview.src = e.target.result;
            preview.style.display = 'block';
        }
        reader.readAsDataURL(file);
    }
});
</script>

<?php require_once APP_PATH . '/views/layouts/footer.php'; ?>

                                </a>
                            </div>
                        </form>
                    <?php else: ?>
                        <div class="alert alert-metronic alert-warning">
                            <i class="bi bi-exclamation-triangle"></i>
                            Data profil tidak ditemukan. Silakan hubungi administrator.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once APP_PATH . '/views/layouts/mahasiswa_footer.php'; ?>
