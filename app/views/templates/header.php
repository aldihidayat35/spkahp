<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title><?= $title ?? 'SPK AHP - Penentuan Tema Tugas Akhir' ?></title>
  <meta name="description" content="Sistem Pendukung Keputusan Penentuan Tema Tugas Akhir dengan Metode AHP - PTIK UIN Sjech M. Djamil Djambek Bukittinggi">
  <meta name="keywords" content="SPK, AHP, Tugas Akhir, PTIK, Bukittinggi">

  <!-- Favicons -->
  <link href="<?= asset('img/favicon.png') ?>" rel="icon">
  <link href="<?= asset('img/apple-touch-icon.png') ?>" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="<?= asset('vendor/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
  <link href="<?= asset('vendor/bootstrap-icons/bootstrap-icons.css') ?>" rel="stylesheet">
  <link href="<?= asset('vendor/aos/aos.css') ?>" rel="stylesheet">
  <link href="<?= asset('vendor/glightbox/css/glightbox.min.css') ?>" rel="stylesheet">
  <link href="<?= asset('vendor/swiper/swiper-bundle.min.css') ?>" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="<?= asset('css/main.css') ?>" rel="stylesheet">
  
  <style>
    .logo-text {
      font-size: 1.5rem;
      font-weight: 700;
      background: linear-gradient(45deg, #4154f1, #2937f0);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }
  </style>

</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">

      <a href="<?= url('home') ?>" class="logo d-flex align-items-center me-auto">
        <i class="bi bi-mortarboard-fill me-2" style="font-size: 2rem; color: #4154f1;"></i>
        <h1 class="sitename logo-text">SPK AHP</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="<?= url('home') ?>#hero" class="active">Beranda</a></li>
          <li><a href="<?= url('home') ?>#about">Tentang</a></li>
          <li><a href="<?= url('home') ?>#features">Fitur</a></li>
          <li><a href="<?= url('home') ?>#tema">Tema</a></li>
          <li><a href="<?= url('home') ?>#cara-kerja">Cara Kerja</a></li>
          <li class="dropdown"><a href="#"><span>Login</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
              <li><a href="<?= url('auth/login') ?>"><i class="bi bi-person"></i> Login Mahasiswa</a></li>
              <li><a href="<?= url('auth/login') ?>"><i class="bi bi-shield-check"></i> Login Admin</a></li>
              <li><a href="<?= url('auth/login') ?>"><i class="bi bi-person-badge"></i> Login Dosen</a></li>
            </ul>
          </li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      <a class="btn-getstarted" href="<?= url('auth/login') ?>">Login</a>

    </div>
  </header>

    <main class="main-content">
        <?php if (hasFlash('success')): ?>
            <?php $flash = getFlash('success'); ?>
            <div class="alert alert-success">
                <?= escape($flash['message']) ?>
            </div>
        <?php endif; ?>

        <?php if (hasFlash('error')): ?>
            <?php $flash = getFlash('error'); ?>
            <div class="alert alert-error">
                <?= escape($flash['message']) ?>
            </div>
        <?php endif; ?>
