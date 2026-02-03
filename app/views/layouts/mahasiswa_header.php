<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? APP_NAME ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= asset('css/style.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/admin.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/metronic.css') ?>">
</head>
<body>

<!-- Sidebar -->
<nav class="sidebar d-md-block" id="sidebarMenu" style="background: linear-gradient(180deg, #009ef7 0%, #7239ea 100%);">
    <div class="position-sticky">
        <div class="text-center">
            <h5 class="text-white"><?= APP_NAME ?></h5>
            <small class="text-white-50">Dashboard Mahasiswa</small>
        </div>
                
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="<?= url('mahasiswa/dashboard') ?>">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="<?= url('mahasiswa/inputNilai') ?>">
                            <i class="bi bi-pencil-square"></i> Input Nilai
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="<?= url('mahasiswa/hasilRekomendasi') ?>">
                            <i class="bi bi-trophy"></i> Hasil Rekomendasi
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="<?= url('mahasiswa/profil') ?>">
                            <i class="bi bi-person"></i> Profil Saya
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="<?= url('mahasiswa/caraKerjaAHP') ?>">
                            <i class="bi bi-question-circle"></i> Cara Kerja AHP
                        </a>
                    </li>
                </ul>
                
                <hr class="text-white">
                
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link text-white" href="<?= url('auth/changePassword') ?>">
                    <i class="bi bi-key"></i> Ubah Password
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-danger" href="<?= url('auth/logout') ?>" 
                   onclick="return confirm('Yakin ingin logout?')">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>
            </li>
        </ul>
    </div>
</nav>

<!-- Main content -->
<main>
    <!-- Top Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
                <div class="container-fluid">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <span class="navbar-brand mb-0 h1">Portal Mahasiswa</span>
                    <div class="ms-auto">
                        <span class="me-3">
                            <i class="bi bi-person-circle"></i> <?= $_SESSION['nama'] ?? 'Mahasiswa' ?>
                            (<?= $_SESSION['nim'] ?? '' ?>)
                        </span>
                    </div>
                </div>
            </nav>

    <!-- Flash Messages -->
    <?php if (hasFlash('success')): ?>
        <?php $flash = getFlash('success'); ?>
        <div class="alert alert-metronic alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle"></i> <?= escape($flash['message']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (hasFlash('error')): ?>
        <?php $flash = getFlash('error'); ?>
        <div class="alert alert-metronic alert-danger alert-dismissible fade show" role="alert" style="background-color: rgba(241, 65, 108, 0.1); border-left-color: var(--bs-danger); color: var(--bs-danger);">
            <i class="bi bi-exclamation-circle"></i> <?= escape($flash['message']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (hasFlash('info')): ?>
        <?php $flash = getFlash('info'); ?>
        <div class="alert alert-metronic alert-info alert-dismissible fade show" role="alert">
            <i class="bi bi-info-circle"></i> <?= escape($flash['message']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Page Content -->
    <div class="content-wrapper">
