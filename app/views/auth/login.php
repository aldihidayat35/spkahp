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
        }
        .login-card {
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        }
        .login-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px 15px 0 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card login-card">
                    <div class="login-header text-center py-4">
                        <h3><i class="bi bi-mortarboard-fill"></i> <?= APP_NAME ?></h3>
                        <p class="mb-0">Sistem Pendukung Keputusan Tema Tugas Akhir</p>
                    </div>
                    <div class="card-body p-5">
                        <?php if (hasFlash('error')): ?>
                            <?php $flash = getFlash('error'); ?>
                            <div class="alert alert-danger">
                                <i class="bi bi-exclamation-circle"></i> <?= escape($flash['message']) ?>
                            </div>
                        <?php endif; ?>

                        <?php if (hasFlash('success')): ?>
                            <?php $flash = getFlash('success'); ?>
                            <div class="alert alert-success">
                                <i class="bi bi-check-circle"></i> <?= escape($flash['message']) ?>
                            </div>
                        <?php endif; ?>

                        <h4 class="text-center mb-4">Login</h4>

                        <form action="<?= url('auth/login') ?>" method="POST">
                            <?= csrf_field() ?>

                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="bi bi-person"></i> Username / NIM
                                </label>
                                <input type="text" name="username" class="form-control form-control-lg" 
                                       placeholder="Masukkan username atau NIM" required autofocus>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="bi bi-lock"></i> Password
                                </label>
                                <input type="password" name="password" class="form-control form-control-lg" 
                                       placeholder="Masukkan password" required>
                            </div>

                            <div class="d-grid gap-2 mt-4">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="bi bi-box-arrow-in-right"></i> Login
                                </button>
                            </div>
                        </form>

                        <hr class="my-4">

                        <div class="text-center">
                            <p class="text-muted mb-2">Belum punya akun?</p>
                            <a href="<?= url('auth/register') ?>" class="btn btn-outline-primary">
                                <i class="bi bi-person-plus"></i> Registrasi Mahasiswa
                            </a>
                        </div>

                        <div class="text-center mt-3">
                            <a href="<?= url('home') ?>" class="text-muted">
                                <i class="bi bi-arrow-left"></i> Kembali ke Beranda
                            </a>
                        </div>

                        <div class="mt-4 p-3 bg-light rounded">
                            <small class="text-muted">
                                <strong>Demo Akun:</strong><br>
                                Admin: <code>admin</code> / <code>password</code><br>
                                Mahasiswa: <code>2021001</code> / <code>password</code>
                            </small>
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
