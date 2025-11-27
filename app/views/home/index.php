<?php require_once APP_PATH . '/views/templates/header.php'; ?>

<main class="main">

    <!-- Hero Section -->
    <section id="hero" class="hero section">
      <div class="hero-bg">
        <img src="<?= asset('img/hero-bg-light.webp') ?>" alt="">
      </div>
      <div class="container text-center">
        <div class="d-flex flex-column justify-content-center align-items-center">
          <h1 data-aos="fade-up" class="mb-3">
            <span style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent; font-weight: 700;">
              Sistem Pendukung Keputusan
            </span>
            <br>
            <span style="font-size: 0.9em;">Penentuan Tema Tugas Akhir</span>
          </h1>
          <p data-aos="fade-up" data-aos-delay="100" class="fs-5">
            Menggunakan Metode <strong>AHP (Analytic Hierarchy Process)</strong><br>
            <span class="text-muted">Program Studi PTIK UIN Sjech M. Djamil Djambek Bukittinggi</span>
          </p>
          <div class="d-flex gap-3" data-aos="fade-up" data-aos-delay="200">
            <a href="<?= url('auth/login') ?>" class="btn btn-primary btn-lg px-5 py-3" style="border-radius: 50px; font-weight: 600;">
              <i class="bi bi-person-circle me-2"></i>Login Mahasiswa
            </a>
            <a href="<?= url('auth/login') ?>" class="btn btn-outline-primary btn-lg px-5 py-3" style="border-radius: 50px; font-weight: 600;">
              <i class="bi bi-shield-lock me-2"></i>Login Admin
            </a>
          </div>
          <img src="<?= asset('img/hero-services-img.webp') ?>" class="img-fluid hero-img mt-5" alt="" data-aos="zoom-out"
            data-aos-delay="300" style="max-width: 80%;">
        </div>
      </div>
    </section><!-- /Hero Section -->

    <!-- Stats Section -->
    <section class="section" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 60px 0;">
      <div class="container">
        <div class="row text-center text-white">
          <div class="col-md-3 mb-4 mb-md-0" data-aos="fade-up" data-aos-delay="100">
            <div class="stat-item">
              <i class="bi bi-people-fill" style="font-size: 3rem; margin-bottom: 15px; opacity: 0.9;"></i>
              <h3 style="font-size: 2.5rem; font-weight: 700; margin-bottom: 10px;">4</h3>
              <p style="font-size: 1.1rem; margin: 0;">Tema Alternatif</p>
            </div>
          </div>
          <div class="col-md-3 mb-4 mb-md-0" data-aos="fade-up" data-aos-delay="200">
            <div class="stat-item">
              <i class="bi bi-list-check" style="font-size: 3rem; margin-bottom: 15px; opacity: 0.9;"></i>
              <h3 style="font-size: 2.5rem; font-weight: 700; margin-bottom: 10px;">5</h3>
              <p style="font-size: 1.1rem; margin: 0;">Kriteria AHP</p>
            </div>
          </div>
          <div class="col-md-3 mb-4 mb-md-0" data-aos="fade-up" data-aos-delay="300">
            <div class="stat-item">
              <i class="bi bi-calculator" style="font-size: 3rem; margin-bottom: 15px; opacity: 0.9;"></i>
              <h3 style="font-size: 2.5rem; font-weight: 700; margin-bottom: 10px;">100%</h3>
              <p style="font-size: 1.1rem; margin: 0;">Otomatis</p>
            </div>
          </div>
          <div class="col-md-3" data-aos="fade-up" data-aos-delay="400">
            <div class="stat-item">
              <i class="bi bi-shield-check" style="font-size: 3rem; margin-bottom: 15px; opacity: 0.9;"></i>
              <h3 style="font-size: 2.5rem; font-weight: 700; margin-bottom: 10px;">CR ≤ 0.1</h3>
              <p style="font-size: 1.1rem; margin: 0;">Konsisten</p>
            </div>
          </div>
        </div>
      </div>
    </section><!-- /Stats Section -->

    <!-- Featured Services Section -->
    <section id="featured-services" class="section" style="background-color: #f9fafb; padding: 80px 0;">

      <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
          <h2 class="mb-3" style="font-weight: 700; font-size: 2.5rem; color: #1e1e2d;">Tema Tugas Akhir PTIK</h2>
          <p class="text-muted" style="font-size: 1.1rem;">4 Alternatif tema yang tersedia untuk mahasiswa</p>
        </div>

        <div class="row g-4">

          <div class="col-xl-3 col-lg-6" data-aos="fade-up" data-aos-delay="100">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 15px; transition: transform 0.3s;" onmouseover="this.style.transform='translateY(-10px)'" onmouseout="this.style.transform='translateY(0)'">
              <div class="card-body text-center p-4">
                <div class="mb-4" style="width: 80px; height: 80px; margin: 0 auto; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 20px; display: flex; align-items: center; justify-content: center;">
                  <i class="bi bi-mortarboard text-white" style="font-size: 2.5rem;"></i>
                </div>
                <h4 class="mb-3" style="font-weight: 700; color: #1e1e2d;">Kependidikan</h4>
                <p class="text-muted mb-0">Penelitian di bidang teknologi pendidikan, media pembelajaran, dan e-learning</p>
              </div>
            </div>
          </div>

          <div class="col-xl-3 col-lg-6" data-aos="fade-up" data-aos-delay="200">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 15px; transition: transform 0.3s;" onmouseover="this.style.transform='translateY(-10px)'" onmouseout="this.style.transform='translateY(0)'">
              <div class="card-body text-center p-4">
                <div class="mb-4" style="width: 80px; height: 80px; margin: 0 auto; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); border-radius: 20px; display: flex; align-items: center; justify-content: center;">
                  <i class="bi bi-code-square text-white" style="font-size: 2.5rem;"></i>
                </div>
                <h4 class="mb-3" style="font-weight: 700; color: #1e1e2d;">Pemrograman</h4>
                <p class="text-muted mb-0">Pengembangan aplikasi web, mobile, desktop, dan sistem informasi</p>
              </div>
            </div>
          </div>

          <div class="col-xl-3 col-lg-6" data-aos="fade-up" data-aos-delay="300">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 15px; transition: transform 0.3s;" onmouseover="this.style.transform='translateY(-10px)'" onmouseout="this.style.transform='translateY(0)'">
              <div class="card-body text-center p-4">
                <div class="mb-4" style="width: 80px; height: 80px; margin: 0 auto; background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); border-radius: 20px; display: flex; align-items: center; justify-content: center;">
                  <i class="bi bi-palette text-white" style="font-size: 2.5rem;"></i>
                </div>
                <h4 class="mb-3" style="font-weight: 700; color: #1e1e2d;">Desain Media / Multimedia</h4>
                <p class="text-muted mb-0">Desain grafis, animasi, video editing, dan game development</p>
              </div>
            </div>
          </div>

          <div class="col-xl-3 col-lg-6" data-aos="fade-up" data-aos-delay="400">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 15px; transition: transform 0.3s;" onmouseover="this.style.transform='translateY(-10px)'" onmouseout="this.style.transform='translateY(0)'">
              <div class="card-body text-center p-4">
                <div class="mb-4" style="width: 80px; height: 80px; margin: 0 auto; background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); border-radius: 20px; display: flex; align-items: center; justify-content: center;">
                  <i class="bi bi-diagram-3 text-white" style="font-size: 2.5rem;"></i>
                </div>
                <h4 class="mb-3" style="font-weight: 700; color: #1e1e2d;">Jaringan Komputer</h4>
                <p class="text-muted mb-0">Jaringan, keamanan sistem, IoT, dan cloud computing</p>
              </div>
            </div>
          </div>

        </div>

      </div>

    </section><!-- /Featured Services Section -->

    <!-- About Section -->
    <section id="about" class="section" style="padding: 80px 0;">

      <div class="container">

        <div class="row align-items-center g-5">

          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
            <span class="badge rounded-pill mb-3" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 8px 20px; font-size: 0.9rem;">Tentang Aplikasi</span>
            <h2 class="mb-4" style="font-weight: 700; font-size: 2.5rem; color: #1e1e2d;">Sistem Pendukung Keputusan Berbasis AHP</h2>
            <p class="text-muted mb-4" style="font-size: 1.1rem; line-height: 1.8;">
              SPK AHP adalah aplikasi yang membantu mahasiswa PTIK dalam menentukan tema tugas akhir yang paling sesuai berdasarkan nilai-nilai mata kuliah yang telah ditempuh.
            </p>
            <div class="d-flex flex-column gap-3">
              <div class="d-flex align-items-start">
                <div class="flex-shrink-0">
                  <div style="width: 40px; height: 40px; background: rgba(102, 126, 234, 0.1); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-check-circle-fill" style="color: #667eea; font-size: 1.3rem;"></i>
                  </div>
                </div>
                <div class="ms-3">
                  <h5 style="font-weight: 600; color: #1e1e2d; margin-bottom: 5px;">Metode AHP Terpercaya</h5>
                  <p class="text-muted mb-0">Menggunakan Analytic Hierarchy Process untuk analisis yang objektif dan sistematis</p>
                </div>
              </div>
              
              <div class="d-flex align-items-start">
                <div class="flex-shrink-0">
                  <div style="width: 40px; height: 40px; background: rgba(102, 126, 234, 0.1); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-check-circle-fill" style="color: #667eea; font-size: 1.3rem;"></i>
                  </div>
                </div>
                <div class="ms-3">
                  <h5 style="font-weight: 600; color: #1e1e2d; margin-bottom: 5px;">Perhitungan Otomatis</h5>
                  <p class="text-muted mb-0">Sistem otomatis menghitung prioritas berdasarkan nilai mata kuliah yang dikelompokkan</p>
                </div>
              </div>
              
              <div class="d-flex align-items-start">
                <div class="flex-shrink-0">
                  <div style="width: 40px; height: 40px; background: rgba(102, 126, 234, 0.1); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-check-circle-fill" style="color: #667eea; font-size: 1.3rem;"></i>
                  </div>
                </div>
                <div class="ms-3">
                  <h5 style="font-weight: 600; color: #1e1e2d; margin-bottom: 5px;">Hasil Akurat & Konsisten</h5>
                  <p class="text-muted mb-0">Validasi CR ≤ 0.1 memastikan keakuratan dan keandalan hasil rekomendasi</p>
                </div>
              </div>
            </div>
            <a href="#features" class="btn btn-lg mt-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; padding: 12px 35px; border-radius: 50px; font-weight: 600;">
              Lihat Fitur Lengkap <i class="bi bi-arrow-right ms-2"></i>
            </a>
          </div>

          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
            <div class="row g-3">
              <div class="col-6">
                <img src="<?= asset('img/about-company-1.jpg') ?>" class="img-fluid w-100" style="border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);" alt="">
              </div>
              <div class="col-6">
                <div class="d-flex flex-column gap-3">
                  <img src="<?= asset('img/about-company-2.jpg') ?>" class="img-fluid w-100" style="border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);" alt="">
                  <img src="<?= asset('img/about-company-3.jpg') ?>" class="img-fluid w-100" style="border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);" alt="">
                </div>
              </div>
            </div>
          </div>

        </div>

      </div>
    </section><!-- /About Section -->

    <!-- Features Section -->
    <section id="features" class="section" style="background-color: #f9fafb; padding: 80px 0;">

      <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
          <h2 class="mb-3" style="font-weight: 700; font-size: 2.5rem; color: #1e1e2d;">Fitur & Manfaat</h2>
          <p class="text-muted" style="font-size: 1.1rem;">Kemudahan dan keunggulan yang ditawarkan Sistem Pendukung Keputusan AHP</p>
        </div>

        <div class="row g-4">

          <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 15px;">
              <div class="card-body p-4">
                <div class="mb-3" style="width: 60px; height: 60px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                  <i class="bi bi-person-circle text-white" style="font-size: 1.8rem;"></i>
                </div>
                <h4 class="mb-3" style="font-weight: 700; color: #1e1e2d;">Multi-Level Login</h4>
                <p class="text-muted mb-4">Sistem dengan 3 level akses: Admin (kelola master data), Mahasiswa (input nilai & lihat rekomendasi), dan Dosen (lihat laporan).</p>
                <a href="<?= url('auth/login') ?>" class="text-decoration-none" style="color: #667eea; font-weight: 600;">
                  Login Sekarang <i class="bi bi-arrow-right ms-1"></i>
                </a>
              </div>
            </div>
          </div>

          <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 15px;">
              <div class="card-body p-4">
                <div class="mb-3" style="width: 60px; height: 60px; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                  <i class="bi bi-file-earmark-text text-white" style="font-size: 1.8rem;"></i>
                </div>
                <h4 class="mb-3" style="font-weight: 700; color: #1e1e2d;">Input Nilai Mahasiswa</h4>
                <p class="text-muted mb-4">Mahasiswa dapat menginput nilai mata kuliah yang telah ditempuh, dikelompokkan berdasarkan kriteria tema tugas akhir.</p>
                <a href="#tema" class="text-decoration-none" style="color: #f5576c; font-weight: 600;">
                  Lihat Tema <i class="bi bi-arrow-right ms-1"></i>
                </a>
              </div>
            </div>
          </div>

          <div class="col-lg-4" data-aos="fade-up" data-aos-delay="300">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 15px;">
              <div class="card-body p-4">
                <div class="mb-3" style="width: 60px; height: 60px; background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                  <i class="bi bi-calculator text-white" style="font-size: 1.8rem;"></i>
                </div>
                <h4 class="mb-3" style="font-weight: 700; color: #1e1e2d;">Perhitungan AHP Otomatis</h4>
                <p class="text-muted mb-4">Sistem secara otomatis menghitung prioritas menggunakan metode AHP dengan normalisasi matriks, eigenvector, dan validasi CR.</p>
                <a href="#cara-kerja" class="text-decoration-none" style="color: #00f2fe; font-weight: 600;">
                  Cara Kerja <i class="bi bi-arrow-right ms-1"></i>
                </a>
              </div>
            </div>
          </div>

          <div class="col-lg-4" data-aos="fade-up" data-aos-delay="400">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 15px;">
              <div class="card-body p-4">
                <div class="mb-3" style="width: 60px; height: 60px; background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                  <i class="bi bi-trophy text-white" style="font-size: 1.8rem;"></i>
                </div>
                <h4 class="mb-3" style="font-weight: 700; color: #1e1e2d;">Ranking Rekomendasi</h4>
                <p class="text-muted mb-4">Hasil rekomendasi ditampilkan dalam bentuk ranking dengan persentase prioritas untuk setiap tema tugas akhir.</p>
                <a href="#tema" class="text-decoration-none" style="color: #fa709a; font-weight: 600;">
                  Lihat Hasil <i class="bi bi-arrow-right ms-1"></i>
                </a>
              </div>
            </div>
          </div>

          <div class="col-lg-4" data-aos="fade-up" data-aos-delay="500">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 15px;">
              <div class="card-body p-4">
                <div class="mb-3" style="width: 60px; height: 60px; background: linear-gradient(135deg, #50cd89 0%, #2ecc71 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                  <i class="bi bi-shield-check text-white" style="font-size: 1.8rem;"></i>
                </div>
                <h4 class="mb-3" style="font-weight: 700; color: #1e1e2d;">Validasi Konsistensi</h4>
                <p class="text-muted mb-4">Setiap perhitungan divalidasi dengan Consistency Ratio (CR ≤ 0.1) untuk memastikan keakuratan dan keandalan hasil.</p>
                <a href="#about" class="text-decoration-none" style="color: #50cd89; font-weight: 600;">
                  Pelajari Lebih <i class="bi bi-arrow-right ms-1"></i>
                </a>
              </div>
            </div>
          </div>

          <div class="col-lg-4" data-aos="fade-up" data-aos-delay="600">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 15px;">
              <div class="card-body p-4">
                <div class="mb-3" style="width: 60px; height: 60px; background: linear-gradient(135deg, #7239ea 0%, #5e17eb 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                  <i class="bi bi-graph-up text-white" style="font-size: 1.8rem;"></i>
                </div>
                <h4 class="mb-3" style="font-weight: 700; color: #1e1e2d;">Laporan & Riwayat</h4>
                <p class="text-muted mb-4">Admin dapat melihat laporan lengkap hasil rekomendasi seluruh mahasiswa dan riwayat perhitungan yang telah dilakukan.</p>
                <a href="<?= url('auth/login') ?>" class="text-decoration-none" style="color: #7239ea; font-weight: 600;">
                  Akses Admin <i class="bi bi-arrow-right ms-1"></i>
                </a>
              </div>
            </div>
          </div>

        </div>

      </div>

    </section><!-- /Features Section -->

    <!-- Tema Section -->
    <section id="tema" class="section" style="padding: 80px 0;">

      <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
          <h2 class="mb-3" style="font-weight: 700; font-size: 2.5rem; color: #1e1e2d;">Tema Tugas Akhir</h2>
          <p class="text-muted" style="font-size: 1.1rem;">4 Alternatif Tema yang Tersedia untuk Mahasiswa PTIK</p>
        </div>

        <div class="row g-4 justify-content-center">

          <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="100">
            <div class="card border-0 h-100 text-center" style="border-radius: 15px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 30px 20px; transition: transform 0.3s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
              <div class="mb-3">
                <div style="width: 70px; height: 70px; margin: 0 auto; background: rgba(255,255,255,0.2); border-radius: 15px; display: flex; align-items: center; justify-content: center;">
                  <i class="bi bi-mortarboard text-white" style="font-size: 2.2rem;"></i>
                </div>
              </div>
              <h4 class="text-white mb-3" style="font-weight: 700;">Kependidikan</h4>
              <p class="text-white mb-0" style="opacity: 0.9; font-size: 0.95rem;">Penelitian di bidang teknologi pendidikan, media pembelajaran, dan e-learning</p>
            </div>
          </div>

          <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="200">
            <div class="card border-0 h-100 text-center" style="border-radius: 15px; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); padding: 30px 20px; transition: transform 0.3s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
              <div class="mb-3">
                <div style="width: 70px; height: 70px; margin: 0 auto; background: rgba(255,255,255,0.2); border-radius: 15px; display: flex; align-items: center; justify-content: center;">
                  <i class="bi bi-code-square text-white" style="font-size: 2.2rem;"></i>
                </div>
              </div>
              <h4 class="text-white mb-3" style="font-weight: 700;">Pemrograman</h4>
              <p class="text-white mb-0" style="opacity: 0.9; font-size: 0.95rem;">Pengembangan aplikasi web, mobile, desktop, dan sistem informasi</p>
            </div>
          </div>

          <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="300">
            <div class="card border-0 h-100 text-center" style="border-radius: 15px; background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); padding: 30px 20px; transition: transform 0.3s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
              <div class="mb-3">
                <div style="width: 70px; height: 70px; margin: 0 auto; background: rgba(255,255,255,0.2); border-radius: 15px; display: flex; align-items: center; justify-content: center;">
                  <i class="bi bi-palette text-white" style="font-size: 2.2rem;"></i>
                </div>
              </div>
              <h4 class="text-white mb-3" style="font-weight: 700;">Desain Media / Multimedia</h4>
              <p class="text-white mb-0" style="opacity: 0.9; font-size: 0.95rem;">Desain grafis, animasi, video editing, dan game development</p>
            </div>
          </div>

          <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="400">
            <div class="card border-0 h-100 text-center" style="border-radius: 15px; background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); padding: 30px 20px; transition: transform 0.3s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
              <div class="mb-3">
                <div style="width: 70px; height: 70px; margin: 0 auto; background: rgba(255,255,255,0.2); border-radius: 15px; display: flex; align-items: center; justify-content: center;">
                  <i class="bi bi-diagram-3 text-white" style="font-size: 2.2rem;"></i>
                </div>
              </div>
              <h4 class="text-white mb-3" style="font-weight: 700;">Jaringan Komputer</h4>
              <p class="text-white mb-0" style="opacity: 0.9; font-size: 0.95rem;">Jaringan, keamanan sistem, IoT, dan cloud computing</p>
            </div>
          </div>

        </div>

      </div>

    </section><!-- /Tema Section -->

    <!-- Cara Kerja Section -->
    <section id="cara-kerja" class="section" style="background-color: #f9fafb; padding: 80px 0;">

      <div class="container">

        <div class="row align-items-center g-5">

          <div class="col-lg-6 order-2 order-lg-1" data-aos="fade-up" data-aos-delay="100">
            <span class="badge rounded-pill mb-3" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 8px 20px; font-size: 0.9rem;">Proses Perhitungan</span>
            <h2 class="mb-4" style="font-weight: 700; font-size: 2.5rem; color: #1e1e2d;">Cara Kerja Sistem AHP</h2>
            <p class="text-muted mb-5" style="font-size: 1.1rem; line-height: 1.8;">
              Sistem ini menggunakan metode Analytic Hierarchy Process (AHP) untuk membantu mahasiswa menentukan tema tugas akhir yang paling sesuai berdasarkan nilai akademik.
            </p>

            <div class="row g-4">

              <div class="col-12">
                <div class="d-flex align-items-start">
                  <div class="flex-shrink-0">
                    <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                      <span class="text-white fw-bold" style="font-size: 1.3rem;">1</span>
                    </div>
                  </div>
                  <div class="ms-4">
                    <h5 style="font-weight: 600; color: #1e1e2d; margin-bottom: 8px;">Input Nilai</h5>
                    <p class="text-muted mb-0">Mahasiswa menginput nilai mata kuliah yang telah ditempuh</p>
                  </div>
                </div>
              </div>

              <div class="col-12">
                <div class="d-flex align-items-start">
                  <div class="flex-shrink-0">
                    <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                      <span class="text-white fw-bold" style="font-size: 1.3rem;">2</span>
                    </div>
                  </div>
                  <div class="ms-4">
                    <h5 style="font-weight: 600; color: #1e1e2d; margin-bottom: 8px;">Pairwise Matrix</h5>
                    <p class="text-muted mb-0">Sistem membuat matriks perbandingan berpasangan dari nilai-nilai tersebut</p>
                  </div>
                </div>
              </div>

              <div class="col-12">
                <div class="d-flex align-items-start">
                  <div class="flex-shrink-0">
                    <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                      <span class="text-white fw-bold" style="font-size: 1.3rem;">3</span>
                    </div>
                  </div>
                  <div class="ms-4">
                    <h5 style="font-weight: 600; color: #1e1e2d; margin-bottom: 8px;">Normalisasi & Eigenvector</h5>
                    <p class="text-muted mb-0">Matriks dinormalisasi dan dihitung priority vector untuk setiap alternatif</p>
                  </div>
                </div>
              </div>

              <div class="col-12">
                <div class="d-flex align-items-start">
                  <div class="flex-shrink-0">
                    <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #50cd89 0%, #2ecc71 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                      <span class="text-white fw-bold" style="font-size: 1.3rem;">4</span>
                    </div>
                  </div>
                  <div class="ms-4">
                    <h5 style="font-weight: 600; color: #1e1e2d; margin-bottom: 8px;">Hasil Rekomendasi</h5>
                    <p class="text-muted mb-0">Sistem menampilkan ranking tema dengan persentase prioritas (CR ≤ 0.1)</p>
                  </div>
                </div>
              </div>

            </div>

          </div>

          <div class="col-lg-6 order-1 order-lg-2" data-aos="fade-up" data-aos-delay="200">
            <img src="<?= asset('img/features-3.jpg') ?>" class="img-fluid" style="border-radius: 15px; box-shadow: 0 20px 50px rgba(0,0,0,0.15);" alt="Cara Kerja AHP">
          </div>

        </div>

      </div>

    </section><!-- /Cara Kerja Section -->

   
  </main>

<?php require_once APP_PATH . '/views/templates/footer.php'; ?>
