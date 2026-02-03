<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?> - <?= APP_NAME ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .change-password-card {
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        }
        .change-password-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px 15px 0 0;
        }
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.25);
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.2);
        }
        .password-strength {
            height: 5px;
            border-radius: 5px;
            margin-top: 5px;
            transition: all 0.3s;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card change-password-card">
                    <div class="change-password-header text-center py-4">
                        <h3><i class="bi bi-shield-lock"></i> Ubah Password</h3>
                        <p class="mb-0">Tingkatkan keamanan akun Anda</p>
                    </div>
                    <div class="card-body p-5">
                        <?php if (hasFlash('error')): ?>
                            <?php $flash = getFlash('error'); ?>
                            <div class="alert alert-danger alert-dismissible fade show">
                                <i class="bi bi-exclamation-circle"></i> <?= escape($flash['message']) ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <?php if (hasFlash('success')): ?>
                            <?php $flash = getFlash('success'); ?>
                            <div class="alert alert-success alert-dismissible fade show">
                                <i class="bi bi-check-circle"></i> <?= escape($flash['message']) ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i> <strong>Tips Keamanan:</strong>
                            <ul class="mb-0 mt-2">
                                <li>Gunakan minimal 8 karakter</li>
                                <li>Kombinasikan huruf besar, kecil, angka</li>
                                <li>Jangan gunakan password yang mudah ditebak</li>
                            </ul>
                        </div>

                        <form action="<?= url('auth/changePassword') ?>" method="POST" id="changePasswordForm">
                            <?= csrf_field() ?>

                            <div class="mb-4">
                                <label class="form-label">
                                    <i class="bi bi-lock"></i> Password Lama <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <input type="password" name="old_password" id="old_password" 
                                           class="form-control" placeholder="Masukkan password lama" required>
                                    <button class="btn btn-outline-secondary" type="button" 
                                            onclick="togglePassword('old_password')">
                                        <i class="bi bi-eye" id="old_password_icon"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">
                                    <i class="bi bi-key"></i> Password Baru <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <input type="password" name="new_password" id="new_password" 
                                           class="form-control" placeholder="Masukkan password baru" 
                                           required minlength="6" onkeyup="checkPasswordStrength()">
                                    <button class="btn btn-outline-secondary" type="button" 
                                            onclick="togglePassword('new_password')">
                                        <i class="bi bi-eye" id="new_password_icon"></i>
                                    </button>
                                </div>
                                <div id="password-strength" class="password-strength"></div>
                                <small id="strength-text" class="text-muted"></small>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">
                                    <i class="bi bi-key-fill"></i> Konfirmasi Password Baru <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <input type="password" name="confirm_password" id="confirm_password" 
                                           class="form-control" placeholder="Ulangi password baru" 
                                           required minlength="6" onkeyup="checkPasswordMatch()">
                                    <button class="btn btn-outline-secondary" type="button" 
                                            onclick="togglePassword('confirm_password')">
                                        <i class="bi bi-eye" id="confirm_password_icon"></i>
                                    </button>
                                </div>
                                <small id="match-text" class="text-muted"></small>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="bi bi-check-circle"></i> Ubah Password
                                </button>
                                <a href="<?= url($_SESSION['role'] . '/dashboard') ?>" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
                                </a>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-center text-muted py-3">
                        <small>
                            <i class="bi bi-shield-check"></i> Password Anda terenkripsi dengan aman
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const icon = document.getElementById(fieldId + '_icon');
            
            if (field.type === 'password') {
                field.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                field.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        }

        function checkPasswordStrength() {
            const password = document.getElementById('new_password').value;
            const strengthBar = document.getElementById('password-strength');
            const strengthText = document.getElementById('strength-text');
            
            let strength = 0;
            let text = '';
            let color = '';
            
            if (password.length >= 6) strength++;
            if (password.length >= 10) strength++;
            if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[^a-zA-Z0-9]/.test(password)) strength++;
            
            switch(strength) {
                case 0:
                case 1:
                    color = '#dc3545';
                    text = 'Lemah';
                    break;
                case 2:
                case 3:
                    color = '#ffc107';
                    text = 'Sedang';
                    break;
                case 4:
                case 5:
                    color = '#28a745';
                    text = 'Kuat';
                    break;
            }
            
            strengthBar.style.width = (strength * 20) + '%';
            strengthBar.style.backgroundColor = color;
            strengthText.textContent = text ? 'Kekuatan password: ' + text : '';
            strengthText.style.color = color;
        }

        function checkPasswordMatch() {
            const newPassword = document.getElementById('new_password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            const matchText = document.getElementById('match-text');
            
            if (confirmPassword.length > 0) {
                if (newPassword === confirmPassword) {
                    matchText.textContent = '✓ Password cocok';
                    matchText.style.color = '#28a745';
                } else {
                    matchText.textContent = '✗ Password tidak cocok';
                    matchText.style.color = '#dc3545';
                }
            } else {
                matchText.textContent = '';
            }
        }

        // Form validation
        document.getElementById('changePasswordForm').addEventListener('submit', function(e) {
            const newPassword = document.getElementById('new_password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            
            if (newPassword !== confirmPassword) {
                e.preventDefault();
                alert('Password baru dan konfirmasi password tidak cocok!');
                return false;
            }
            
            if (newPassword.length < 6) {
                e.preventDefault();
                alert('Password minimal 6 karakter!');
                return false;
            }
        });
    </script>
</body>
</html>
