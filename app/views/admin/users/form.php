<?php require_once APP_PATH . '/views/layouts/admin_header.php'; ?>

<div class="container-fluid px-4">
    <h1 class="mt-4"><?= isset($user) ? 'Edit User' : 'Tambah User' ?></h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?= url('admin/dashboard') ?>">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="<?= url('admin/users') ?>">Users</a></li>
        <li class="breadcrumb-item active"><?= isset($user) ? 'Edit' : 'Tambah' ?></li>
    </ol>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-person me-1"></i>
                    Form User
                </div>
                <div class="card-body">
                    <form action="<?= url(isset($user) ? 'admin/editUser/' . $user['id'] : 'admin/addUser') ?>" method="POST">
                        <?= csrf_field() ?>
                        
                        <div class="mb-3">
                            <label class="form-label">Username <span class="text-danger">*</span></label>
                            <input type="text" name="username" class="form-control" 
                                   value="<?= old('username', $user['username'] ?? '') ?>" 
                                   placeholder="Username" required>
                        </div>

                        <?php if (!isset($user)): ?>
                        <div class="mb-3">
                            <label class="form-label">Password <span class="text-danger">*</span></label>
                            <input type="password" name="password" class="form-control" 
                                   placeholder="Password" required>
                        </div>
                        <?php endif; ?>

                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="nama" class="form-control" 
                                   value="<?= old('nama', $user['nama'] ?? '') ?>" 
                                   placeholder="Nama Lengkap" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Role <span class="text-danger">*</span></label>
                            <select name="role" class="form-select" id="roleSelect" required>
                                <option value="">-- Pilih Role --</option>
                                <option value="admin" <?= old('role', $user['role'] ?? '') == 'admin' ? 'selected' : '' ?>>
                                    Admin
                                </option>
                                <option value="dosen" <?= old('role', $user['role'] ?? '') == 'dosen' ? 'selected' : '' ?>>
                                    Dosen
                                </option>
                                <option value="mahasiswa" <?= old('role', $user['role'] ?? '') == 'mahasiswa' ? 'selected' : '' ?>>
                                    Mahasiswa
                                </option>
                            </select>
                        </div>

                        <div id="mahasiswaFields" style="display: none;">
                            <div class="card bg-light mb-3">
                                <div class="card-body">
                                    <h6>Data Mahasiswa</h6>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">NIM</label>
                                        <input type="text" name="nim" class="form-control" 
                                               value="<?= old('nim', $mahasiswa['nim'] ?? '') ?>" 
                                               placeholder="NIM">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Angkatan</label>
                                        <input type="text" name="angkatan" class="form-control" 
                                               value="<?= old('angkatan', $mahasiswa['angkatan'] ?? date('Y')) ?>" 
                                               placeholder="2024">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Minat Utama</label>
                                        <input type="text" name="minat_utama" class="form-control" 
                                               value="<?= old('minat_utama', $mahasiswa['minat_utama'] ?? '') ?>" 
                                               placeholder="Contoh: Pemrograman">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" name="email" class="form-control" 
                                               value="<?= old('email', $mahasiswa['email'] ?? '') ?>" 
                                               placeholder="email@example.com">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">No HP</label>
                                        <input type="text" name="no_hp" class="form-control" 
                                               value="<?= old('no_hp', $mahasiswa['no_hp'] ?? '') ?>" 
                                               placeholder="08xxxxxxxxxx">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" name="is_active" value="1" class="form-check-input" 
                                       <?= old('is_active', $user['is_active'] ?? 1) ? 'checked' : '' ?>>
                                <label class="form-check-label">Aktif</label>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Simpan
                            </button>
                            <a href="<?= url('admin/users') ?>" class="btn btn-secondary">
                                <i class="bi bi-x-circle"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('roleSelect').addEventListener('change', function() {
    const mahasiswaFields = document.getElementById('mahasiswaFields');
    if (this.value === 'mahasiswa') {
        mahasiswaFields.style.display = 'block';
    } else {
        mahasiswaFields.style.display = 'none';
    }
});

// Trigger on load
window.addEventListener('load', function() {
    const roleSelect = document.getElementById('roleSelect');
    if (roleSelect.value === 'mahasiswa') {
        document.getElementById('mahasiswaFields').style.display = 'block';
    }
});
</script>

<?php require_once APP_PATH . '/views/layouts/admin_footer.php'; ?>
