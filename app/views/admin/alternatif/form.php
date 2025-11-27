<?php require_once APP_PATH . '/views/layouts/admin_header.php'; ?>

<div class="container-fluid px-4">
    <h1 class="mt-4"><?= isset($alternatif) ? 'Edit Alternatif' : 'Tambah Alternatif' ?></h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?= url('admin/dashboard') ?>">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="<?= url('admin/alternatif') ?>">Alternatif</a></li>
        <li class="breadcrumb-item active"><?= isset($alternatif) ? 'Edit' : 'Tambah' ?></li>
    </ol>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-lightbulb me-1"></i>
                    Form Alternatif Tema
                </div>
                <div class="card-body">
                    <form action="<?= url(isset($alternatif) ? 'admin/editAlternatif/' . $alternatif['id'] : 'admin/addAlternatif') ?>" method="POST">
                        <?= csrf_field() ?>
                        
                        <div class="mb-3">
                            <label class="form-label">Kode Alternatif <span class="text-danger">*</span></label>
                            <input type="text" name="kode" class="form-control" 
                                   value="<?= old('kode', $alternatif['kode'] ?? '') ?>" 
                                   placeholder="Contoh: A1" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nama Tema <span class="text-danger">*</span></label>
                            <input type="text" name="nama_tema" class="form-control" 
                                   value="<?= old('nama_tema', $alternatif['nama_tema'] ?? '') ?>" 
                                   placeholder="Contoh: Pemrograman" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control" rows="3" 
                                      placeholder="Deskripsi tema"><?= old('deskripsi', $alternatif['deskripsi'] ?? '') ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Icon (Font Awesome)</label>
                            <input type="text" name="icon" class="form-control" 
                                   value="<?= old('icon', $alternatif['icon'] ?? '') ?>" 
                                   placeholder="Contoh: fa-code atau bi-code-square">
                            <small class="text-muted">Gunakan class Font Awesome atau Bootstrap Icons</small>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" name="is_active" value="1" class="form-check-input" 
                                       <?= old('is_active', $alternatif['is_active'] ?? 1) ? 'checked' : '' ?>>
                                <label class="form-check-label">Aktif</label>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Simpan
                            </button>
                            <a href="<?= url('admin/alternatif') ?>" class="btn btn-secondary">
                                <i class="bi bi-x-circle"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once APP_PATH . '/views/layouts/admin_footer.php'; ?>
