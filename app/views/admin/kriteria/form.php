<?php require_once APP_PATH . '/views/layouts/admin_header.php'; ?>

<div class="container-fluid px-4">
    <h1 class="mt-4"><?= isset($kriteria) ? 'Edit Kriteria' : 'Tambah Kriteria' ?></h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?= url('admin/dashboard') ?>">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="<?= url('admin/kriteria') ?>">Kriteria</a></li>
        <li class="breadcrumb-item active"><?= isset($kriteria) ? 'Edit' : 'Tambah' ?></li>
    </ol>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-sliders me-1"></i>
                    Form Kriteria
                </div>
                <div class="card-body">
                    <form action="<?= url(isset($kriteria) ? 'admin/editKriteria/' . $kriteria['id'] : 'admin/addKriteria') ?>" method="POST">
                        <?= csrf_field() ?>
                        
                        <div class="mb-3">
                            <label class="form-label">Kode Kriteria <span class="text-danger">*</span></label>
                            <input type="text" name="kode" class="form-control" 
                                   value="<?= old('kode', $kriteria['kode'] ?? '') ?>" 
                                   placeholder="Contoh: K1" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nama Kriteria <span class="text-danger">*</span></label>
                            <input type="text" name="nama_kriteria" class="form-control" 
                                   value="<?= old('nama_kriteria', $kriteria['nama_kriteria'] ?? '') ?>" 
                                   placeholder="Contoh: Kemampuan Pemrograman" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Jenis <span class="text-danger">*</span></label>
                            <select name="jenis" class="form-select" required>
                                <option value="">-- Pilih Jenis --</option>
                                <option value="benefit" <?= old('jenis', $kriteria['jenis'] ?? '') == 'benefit' ? 'selected' : '' ?>>
                                    Benefit (Semakin besar semakin baik)
                                </option>
                                <option value="cost" <?= old('jenis', $kriteria['jenis'] ?? '') == 'cost' ? 'selected' : '' ?>>
                                    Cost (Semakin kecil semakin baik)
                                </option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Keterangan</label>
                            <textarea name="keterangan" class="form-control" rows="3" 
                                      placeholder="Deskripsi kriteria"><?= old('keterangan', $kriteria['keterangan'] ?? '') ?></textarea>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" name="is_active" value="1" class="form-check-input" 
                                       <?= old('is_active', $kriteria['is_active'] ?? 1) ? 'checked' : '' ?>>
                                <label class="form-check-label">Aktif</label>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Simpan
                            </button>
                            <a href="<?= url('admin/kriteria') ?>" class="btn btn-secondary">
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
