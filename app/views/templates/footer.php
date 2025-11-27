  <footer id="footer" class="footer position-relative light-background">

    <div class="container footer-top">
      <div class="row gy-4">
        <div class="col-lg-4 col-md-6 footer-about">
          <a href="<?= url('home') ?>" class="logo d-flex align-items-center">
            <span class="sitename">SPK AHP</span>
          </a>
          <div class="footer-contact pt-3">
            <p>Sistem Pendukung Keputusan Penentuan Tema Tugas Akhir</p>
            <p>Program Studi Pendidikan Teknologi Informasi dan Komputer</p>
            <p>UIN Sjech M. Djamil Djambek Bukittinggi</p>
            <p class="mt-3"><strong>Alamat:</strong> <span>Jl. Gurun Aur, Kubang Putih, Bukittinggi, Sumatera Barat</span></p>
            <p><strong>Telepon:</strong> <span>+62 752 123456</span></p>
            <p><strong>Email:</strong> <span>ptik@uinbukittinggi.ac.id</span></p>
          </div>
          <div class="social-links d-flex mt-4">
            <a href=""><i class="bi bi-twitter-x"></i></a>
            <a href=""><i class="bi bi-facebook"></i></a>
            <a href=""><i class="bi bi-instagram"></i></a>
            <a href=""><i class="bi bi-linkedin"></i></a>
          </div>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Menu</h4>
          <ul>
            <li><a href="<?= url('home') ?>">Beranda</a></li>
            <li><a href="<?= url('home') ?>#about">Tentang Aplikasi</a></li>
            <li><a href="<?= url('home') ?>#features">Fitur</a></li>
            <li><a href="<?= url('home') ?>#tema">Tema Tugas Akhir</a></li>
            <li><a href="<?= url('auth/login') ?>">Login</a></li>
          </ul>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Tema Tugas Akhir</h4>
          <ul>
            <li><a href="<?= url('home') ?>#tema">Kependidikan</a></li>
            <li><a href="<?= url('home') ?>#tema">Pemrograman</a></li>
            <li><a href="<?= url('home') ?>#tema">Desain Media & Multimedia</a></li>
            <li><a href="<?= url('home') ?>#tema">Jaringan Komputer</a></li>
          </ul>
        </div>

        <div class="col-lg-4 col-md-12 footer-newsletter">
          <h4>Tentang Metode AHP</h4>
          <p>Analytic Hierarchy Process (AHP) adalah metode pengambilan keputusan yang menggunakan perbandingan berpasangan untuk menentukan prioritas berdasarkan kriteria yang telah ditetapkan.</p>
          <p class="mt-3"><strong>Keunggulan:</strong> Objektif, sistematis, dan dapat mengukur konsistensi keputusan.</p>
        </div>

      </div>
    </div>

    <div class="container copyright text-center mt-4">
      <p>© <span>Copyright</span> <strong class="px-1 sitename">SPK AHP PTIK</strong><span>All Rights Reserved</span></p>
      <div class="credits">
        Designed by <a href="https://uinbukittinggi.ac.id/">UIN Sjech M. Djamil Djambek Bukittinggi</a>
      </div>
    </div>

  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
      class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="<?= asset('vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
  <script src="<?= asset('vendor/php-email-form/validate.js') ?>"></script>
  <script src="<?= asset('vendor/aos/aos.js') ?>"></script>
  <script src="<?= asset('vendor/glightbox/js/glightbox.min.js') ?>"></script>
  <script src="<?= asset('vendor/swiper/swiper-bundle.min.js') ?>"></script>

  <!-- Main JS File -->
  <script src="<?= asset('js/main.js') ?>"></script>

</body>

</html>