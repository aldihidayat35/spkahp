<?php require_once APP_PATH . '/views/layouts/admin_header.php'; ?>

<?php 
$isEdit = isset($kurikulum);
$title = $isEdit ? 'Edit Kurikulum' : 'Tambah Kurikulum';
$action = $isEdit ? BASE_URL . '/admin/editKurikulum/' . $kurikulum['id'] : BASE_URL . '/admin/addKurikulum';
?>

<div class="container-fluid px-4">
    <h1 class="mt-4"><i class="bi bi-book"></i> <?= $title ?></h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/admin/dashboard">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/admin/kurikulum">Kurikulum</a></li>
        <li class="breadcrumb-item active"><?= $title ?></li>
    </ol>

    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="bi bi-pencil-square"></i> Form <?= $title ?>
                </div>
                <div class="card-body">
                    <form action="<?= $action ?>" method="POST">
                        <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">

                        <div class="mb-3">
                            <label for="angkatan" class="form-label">Angkatan <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control" 
                                   id="angkatan" 
                                   name="angkatan" 
                                   value="<?= $isEdit ? htmlspecialchars($kurikulum['angkatan']) : '' ?>"
                                   placeholder="Contoh: 2024"
                                   pattern="[0-9]{4}"
                                   required>
                            <div class="form-text">Masukkan tahun angkatan (4 digit). Sistem akan otomatis menerapkan kurikulum ini pada mahasiswa dengan angkatan yang sama.</div>
                        </div>

                        <div class="mb-3">
                            <label for="nama_kurikulum" class="form-label">Nama Kurikulum <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control" 
                                   id="nama_kurikulum" 
                                   name="nama_kurikulum" 
                                   value="<?= $isEdit ? htmlspecialchars($kurikulum['nama_kurikulum']) : '' ?>"
                                   placeholder="Contoh: Kurikulum B"
                                   required>
                            <div class="form-text">Contoh: Kurikulum B, Kurikulum C, Kurikulum MBKM 2024</div>
                        </div>

                        <div class="mb-3">
                            <label for="tahun_berlaku" class="form-label">Tahun Berlaku <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control" 
                                   id="tahun_berlaku" 
                                   name="tahun_berlaku" 
                                   value="<?= $isEdit ? htmlspecialchars($kurikulum['tahun_berlaku']) : '' ?>"
                                   placeholder="Contoh: 2024/2025"
                                   required>
                            <div class="form-text">Format: Tahun Ajaran (misal: 2024/2025)</div>
                        </div>

                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea class="form-control" 
                                      id="keterangan" 
                                      name="keterangan" 
                                      rows="3"
                                      placeholder="Deskripsi atau keterangan tambahan tentang kurikulum ini"><?= $isEdit ? htmlspecialchars($kurikulum['keterangan']) : '' ?></textarea>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Simpan
                            </button>
                            <a href="<?= BASE_URL ?>/admin/kurikulum" class="btn btn-secondary">
                                <i class="bi bi-x-circle"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card bg-light">
                <div class="card-header bg-info text-white">
                    <i class="bi bi-info-circle"></i> Panduan Pengisian
                </div>
                <div class="card-body">
                    <h6>Angkatan</h6>
                    <p class="small">Tahun angkatan mahasiswa yang akan menggunakan kurikulum ini. Sistem akan otomatis mencocokkan mahasiswa berdasarkan angkatan.</p>
                    
                    <h6>Nama Kurikulum</h6>
                    <p class="small">Nama identifikasi kurikulum. Gunakan nama yang mudah dikenali seperti "Kurikulum B" atau "Kurikulum C".</p>
                    
                    <h6>Tahun Berlaku</h6>
                    <p class="small">Tahun ajaran berlakunya kurikulum. Format: YYYY/YYYY (contoh: 2024/2025).</p>
                    
                    <div class="alert alert-warning mt-3 small">
                        <i class="bi bi-exclamation-triangle"></i> <strong>Penting:</strong> 
                        Setelah kurikulum dibuat, jangan lupa untuk menambahkan mata kuliah ke kurikulum ini melalui menu Mata Kuliah.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once APP_PATH . '/views/layouts/admin_footer.php'; ?>
