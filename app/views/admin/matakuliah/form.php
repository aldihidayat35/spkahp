<?php require_once APP_PATH . '/views/layouts/admin_header.php'; ?>

<div class="container-fluid px-4">
    <h1 class="mt-4"><?= isset($matakuliah) ? 'Edit Mata Kuliah' : 'Tambah Mata Kuliah' ?></h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?= url('admin/dashboard') ?>">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="<?= url('admin/matakuliah') ?>">Mata Kuliah</a></li>
        <li class="breadcrumb-item active"><?= isset($matakuliah) ? 'Edit' : 'Tambah' ?></li>
    </ol>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-book me-1"></i>
                    Form Mata Kuliah
                </div>
                <div class="card-body">
                    <form action="<?= url(isset($matakuliah) ? 'admin/editMatakuliah/' . $matakuliah['id'] : 'admin/addMatakuliah') ?>" method="POST">
                        <?= csrf_field() ?>
                        
                        <div class="mb-3">
                            <label class="form-label">Kode Mata Kuliah <span class="text-danger">*</span></label>
                            <input type="text" name="kode" class="form-control" 
                                   value="<?= old('kode', $matakuliah['kode'] ?? '') ?>" 
                                   placeholder="Contoh: MK01" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nama Mata Kuliah <span class="text-danger">*</span></label>
                            <input type="text" name="nama_matkul" class="form-control" 
                                   value="<?= old('nama_matkul', $matakuliah['nama_matkul'] ?? '') ?>" 
                                   placeholder="Contoh: Pemrograman Web" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kurikulum <span class="text-danger">*</span></label>
                            <select name="kurikulum_id" class="form-select" required>
                                <option value="">-- Pilih Kurikulum --</option>
                                <?php if (!empty($kurikulum)): ?>
                                    <?php foreach ($kurikulum as $kur): ?>
                                        <option value="<?= $kur['id'] ?>" 
                                                <?= old('kurikulum_id', $matakuliah['kurikulum_id'] ?? '') == $kur['id'] ? 'selected' : '' ?>>
                                            <?= escape($kur['nama_kurikulum']) ?> (Angkatan <?= escape($kur['angkatan']) ?>)
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                            <small class="text-muted">Pilih kurikulum yang sesuai dengan mata kuliah ini</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kriteria <span class="text-danger">*</span></label>
                            <select name="kriteria_id" class="form-select" required>
                                <option value="">-- Pilih Kriteria --</option>
                                <?php if (!empty($kriteria)): ?>
                                    <?php foreach ($kriteria as $k): ?>
                                        <option value="<?= $k['id'] ?>" 
                                                <?= old('kriteria_id', $matakuliah['kriteria_id'] ?? '') == $k['id'] ? 'selected' : '' ?>>
                                            <?= escape($k['kode']) ?> - <?= escape($k['nama_kriteria']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Bobot</label>
                            <input type="number" step="0.01" name="bobot_matkul" class="form-control" 
                                   value="<?= old('bobot_matkul', $matakuliah['bobot_matkul'] ?? '1') ?>" 
                                   placeholder="1.00">
                            <small class="text-muted">Default: 1.00</small>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" name="is_active" value="1" class="form-check-input" 
                                       <?= old('is_active', $matakuliah['is_active'] ?? 1) ? 'checked' : '' ?>>
                                <label class="form-check-label">Aktif</label>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Simpan
                            </button>
                            <a href="<?= url('admin/matakuliah') ?>" class="btn btn-secondary">
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
