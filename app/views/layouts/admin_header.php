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
<body class="bg-light">

<!-- Sidebar -->
<nav class="sidebar d-md-block" id="sidebarMenu">
    <div class="position-sticky">
        <div class="text-center">
            <h5 class="text-white"><?= APP_NAME ?></h5>
            <small>Dashboard Admin</small>
        </div>
                
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="<?= url('admin/dashboard') ?>">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="<?= url('admin/users') ?>">
                            <i class="bi bi-people"></i> Kelola User
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="<?= url('admin/mahasiswa') ?>">
                            <i class="bi bi-person-badge"></i> Data Mahasiswa
                        </a>
                    </li>
                    
                    <li class="nav-item mt-3">
                        <h6 class="sidebar-heading text-muted px-3">
                            <span>Kelola Data AHP</span>
                        </h6>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="<?= url('admin/kriteria') ?>">
                            <i class="bi bi-list-check"></i> Kriteria
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="<?= url('admin/alternatif') ?>">
                            <i class="bi bi-bookmark-star"></i> Alternatif Tema
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="<?= url('admin/matakuliah') ?>">
                            <i class="bi bi-book"></i> Mata Kuliah
                        </a>
                    </li>
                    
                    <li class="nav-item mt-3">
                        <h6 class="sidebar-heading text-muted px-3">
                            <span>AHP Pairwise</span>
                        </h6>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="<?= url('admin/pairwiseKriteria') ?>">
                            <i class="bi bi-diagram-3"></i> Perbandingan Kriteria
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="<?= url('admin/pairwiseAlternatif') ?>">
                            <i class="bi bi-bezier2"></i> Perbandingan Alternatif
                        </a>
                    </li>
                    
                    <li class="nav-item mt-3">
                        <h6 class="sidebar-heading text-muted px-3">
                            <span>Laporan</span>
                        </h6>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="<?= url('admin/visualisasi') ?>">
                            <i class="bi bi-graph-up"></i> Visualisasi AHP
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="<?= url('admin/laporan') ?>">
                            <i class="bi bi-file-earmark-text"></i> Laporan Rekomendasi
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="<?= url('admin/caraKerjaAHP') ?>">
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
                    <span class="navbar-brand mb-0 h1">Admin Panel</span>
                    <div class="ms-auto">
                        <span class="me-3">
                            <i class="bi bi-person-circle"></i> <?= $_SESSION['nama'] ?? 'Admin' ?>
                        </span>
                    </div>
                </div>
            </nav>

            <!-- Flash Messages -->
            <?php if (hasFlash('success')): ?>
                <?php $flash = getFlash('success'); ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle"></i> <?= escape($flash['message']) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (hasFlash('error')): ?>
                <?php $flash = getFlash('error'); ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-circle"></i> <?= escape($flash['message']) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (hasFlash('info')): ?>
                <?php $flash = getFlash('info'); ?>
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <i class="bi bi-info-circle"></i> <?= escape($flash['message']) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

    <!-- Page Content -->
    <div class="content-wrapper">
