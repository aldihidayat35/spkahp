<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 20px 0;
        }
        .register-card {
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        }
        .register-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px 15px 0 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="card register-card">
                    <div class="register-header text-center py-4">
                        <h3><i class="bi bi-person-plus-fill"></i> Registrasi Mahasiswa</h3>
                        <p class="mb-0"><?= APP_NAME ?></p>
                    </div>
                    <div class="card-body p-5">
                        <?php 
                        $flash_error = getFlash('error');
                        if ($flash_error): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <?= $flash_error['message'] ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        <?php endif; ?>

                        <?php 
                        $flash_success = getFlash('success');
                        if ($flash_success): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            <?= $flash_success['message'] ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        <?php endif; ?>

                        <?php
                        // Show field-specific errors
                        $field_errors = [];
                        foreach (['username', 'nama', 'nim', 'angkatan', 'email'] as $field) {
                            $fe = getFlash('error_' . $field);
                            if ($fe) $field_errors[] = $fe['message'];
                        }
                        if (!empty($field_errors)): ?>
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-circle-fill me-2"></i>
                            <strong>Mohon perbaiki:</strong>
                            <ul class="mb-0 mt-1">
                                <?php foreach ($field_errors as $err): ?>
                                <li><?= $err ?></li>
                                <?php endforeach; ?>
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        <?php endif; ?>

                        <form action="<?= url('auth/register') ?>" method="POST">
                            <?= csrf_field() ?>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        <i class="bi bi-person"></i> Username <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="username" class="form-control" 
                                           value="<?= old('username') ?>"
                                           placeholder="Username untuk login (min. 4 karakter)" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        <i class="bi bi-lock"></i> Password <span class="text-danger">*</span>
                                    </label>
                                    <input type="password" name="password" class="form-control" 
                                           placeholder="Password" required>
                                    <small class="text-muted">Min. 8 karakter, harus mengandung huruf besar, huruf kecil, dan angka</small>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="bi bi-person-badge"></i> Nama Lengkap <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="nama" class="form-control" 
                                       value="<?= old('nama') ?>"
                                       placeholder="Nama lengkap sesuai KTP" required>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        <i class="bi bi-credit-card"></i> NIM <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="nim" class="form-control" 
                                           value="<?= old('nim') ?>"
                                           placeholder="Nomor Induk Mahasiswa" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        <i class="bi bi-calendar"></i> Angkatan <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="angkatan" class="form-control" 
                                           value="<?= old('angkatan', date('Y')) ?>"
                                           placeholder="Tahun angkatan" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="bi bi-heart"></i> Minat Utama
                                </label>
                                <select name="minat_utama" class="form-select">
                                    <option value="">-- Pilih Minat --</option>
                                    <option value="Kependidikan" <?= old('minat_utama') == 'Kependidikan' ? 'selected' : '' ?>>Kependidikan</option>
                                    <option value="Pemrograman" <?= old('minat_utama') == 'Pemrograman' ? 'selected' : '' ?>>Pemrograman</option>
                                    <option value="Multimedia" <?= old('minat_utama') == 'Multimedia' ? 'selected' : '' ?>>Multimedia</option>
                                    <option value="Jaringan" <?= old('minat_utama') == 'Jaringan' ? 'selected' : '' ?>>Jaringan Komputer</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="bi bi-envelope"></i> Email <span class="text-danger">*</span>
                                </label>
                                <input type="email" name="email" class="form-control" 
                                       value="<?= old('email') ?>"
                                       placeholder="email@example.com" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="bi bi-phone"></i> No HP
                                </label>
                                <input type="text" name="no_hp" class="form-control" 
                                       value="<?= old('no_hp') ?>"
                                       placeholder="08xxxxxxxxxx">
                            </div>

                            <div class="d-grid gap-2 mt-4">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="bi bi-check-circle"></i> Daftar
                                </button>
                            </div>
                        </form>

                        <hr class="my-4">

                        <div class="text-center">
                            <p class="text-muted mb-2">Sudah punya akun?</p>
                            <a href="<?= url('auth/login') ?>" class="btn btn-outline-primary">
                                <i class="bi bi-box-arrow-in-right"></i> Login
                            </a>
                        </div>

                        <div class="text-center mt-3">
                            <a href="<?= url('home') ?>" class="text-muted">
                                <i class="bi bi-arrow-left"></i> Kembali ke Beranda
                            </a>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-3 text-white">
                    <small>&copy; <?= date('Y') ?> PTIK UIN Sjech M. Djamil Djambek Bukittinggi</small>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
