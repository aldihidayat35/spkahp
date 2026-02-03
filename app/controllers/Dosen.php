<?php

class Dosen extends Controller {
    private $auth;

    public function __construct() {
        parent::__construct();
        $this->auth = $this->model('AuthModel');
        
        // Check if user is dosen
        if (!$this->auth->hasRole('dosen')) {
            setFlash('error', 'Akses ditolak. Anda tidak memiliki hak akses.', 'error');
            redirect('auth/login');
            exit;
        }
    }

    public function index() {
        $this->dashboard();
    }

    public function dashboard() {
        $mahasiswaModel = $this->model('MahasiswaModel');
        $alternatifModel = $this->model('AlternatifModel');

        // Get statistics
        $stats = [
            'total_mahasiswa' => count($mahasiswaModel->findAll()),
            'total_tema' => count($alternatifModel->getAllActive()),
            'mahasiswa_sudah_rekomendasi' => 0
        ];

        // Count mahasiswa yang sudah mendapat rekomendasi
        $query = "SELECT COUNT(DISTINCT mahasiswa_id) as total FROM hasil_rekomendasi";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch();
        $stats['mahasiswa_sudah_rekomendasi'] = $result['total'];

        // Get recent mahasiswa
        $query = "SELECT m.*, u.created_at 
                 FROM mahasiswa m
                 JOIN users u ON m.user_id = u.id
                 ORDER BY u.created_at DESC
                 LIMIT 5";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $recent_mahasiswa = $stmt->fetchAll();

        // Get statistik tema
        $statistik_tema = $alternatifModel->getStatistik();

        $data = [
            'title' => 'Dashboard Dosen - ' . APP_NAME,
            'csrf_token' => $this->generateCSRF(),
            'stats' => $stats,
            'recent_mahasiswa' => $recent_mahasiswa,
            'statistik_tema' => $statistik_tema
        ];

        $this->view('dosen/dashboard', $data);
    }

    // ========================================
    // LIHAT DATA MAHASISWA
    // ========================================

    public function mahasiswa() {
        $mahasiswaModel = $this->model('MahasiswaModel');
        $mahasiswa = $mahasiswaModel->getAllWithUser();

        $data = [
            'title' => 'Data Mahasiswa - ' . APP_NAME,
            'csrf_token' => $this->generateCSRF(),
            'mahasiswa' => $mahasiswa
        ];

        $this->view('dosen/mahasiswa/index', $data);
    }

    public function detailMahasiswa($id) {
        $mahasiswaModel = $this->model('MahasiswaModel');
        $mahasiswa = $mahasiswaModel->findByIdWithUser($id);
        
        if (!$mahasiswa) {
            setFlash('error', 'Mahasiswa tidak ditemukan', 'error');
            $this->redirect('dosen/mahasiswa');
            return;
        }

        $nilai_matkul = $mahasiswaModel->getNilaiMatkul($id);
        $hasil_rekomendasi = $mahasiswaModel->getHasilRekomendasi($id);
        $riwayat = $mahasiswaModel->getRiwayatPerhitungan($id);

        $data = [
            'title' => 'Detail Mahasiswa - ' . APP_NAME,
            'csrf_token' => $this->generateCSRF(),
            'mahasiswa' => $mahasiswa,
            'nilai' => $nilai_matkul,
            'rekomendasi' => $hasil_rekomendasi,
            'riwayat' => $riwayat
        ];

        $this->view('dosen/mahasiswa/detail', $data);
    }

    // ========================================
    // LAPORAN REKOMENDASI
    // ========================================

    public function laporan() {
        $mahasiswaModel = $this->model('MahasiswaModel');
        $alternatifModel = $this->model('AlternatifModel');

        // Get all hasil rekomendasi
        $query = "SELECT hr.*, m.nim, m.nama, at.nama_tema
                 FROM hasil_rekomendasi hr
                 JOIN mahasiswa m ON hr.mahasiswa_id = m.id
                 JOIN alternatif_tema at ON hr.alternatif_id = at.id
                 WHERE hr.ranking = 1
                 ORDER BY hr.created_at DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $rekomendasi = $stmt->fetchAll();

        // Statistik tema
        $statistik_tema = $alternatifModel->getStatistik();

        $data = [
            'title' => 'Laporan Rekomendasi - ' . APP_NAME,
            'csrf_token' => $this->generateCSRF(),
            'rekomendasi' => $rekomendasi,
            'statistik_tema' => $statistik_tema
        ];

        $this->view('dosen/laporan/index', $data);
    }

    // ========================================
    // VISUALISASI
    // ========================================

    public function visualisasi() {
        $kriteriaModel = $this->model('KriteriaModel');
        $alternatifModel = $this->model('AlternatifModel');
        $mahasiswaModel = $this->model('MahasiswaModel');

        // Get data
        $kriteria = $kriteriaModel->getAllActive();
        $alternatif = $alternatifModel->getAllActive();
        
        // Count mahasiswa
        $total_mahasiswa = count($mahasiswaModel->findAll());
        
        // Count rekomendasi
        $query = "SELECT COUNT(DISTINCT mahasiswa_id) as total FROM hasil_rekomendasi";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch();
        $total_rekomendasi = $result['total'] ?? 0;

        // Get recent recommendations
        $query = "SELECT m.nama as nama_mahasiswa, m.nim, 
                         at.nama_tema as tema_top, 
                         hr.total_score as score_top,
                         hr.created_at
                  FROM hasil_rekomendasi hr
                  JOIN mahasiswa m ON hr.mahasiswa_id = m.id
                  JOIN alternatif_tema at ON hr.alternatif_id = at.id
                  WHERE hr.ranking = 1
                  ORDER BY hr.created_at DESC
                  LIMIT 10";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $recent_recommendations = $stmt->fetchAll();

        $data = [
            'title' => 'Visualisasi AHP - ' . APP_NAME,
            'csrf_token' => $this->generateCSRF(),
            'kriteria' => $kriteria,
            'alternatif' => $alternatif,
            'total_mahasiswa' => $total_mahasiswa,
            'total_rekomendasi' => $total_rekomendasi,
            'recent_recommendations' => $recent_recommendations
        ];

        $this->view('dosen/visualisasi/index', $data);
    }

    // ========================================
    // CARA KERJA AHP
    // ========================================

    public function caraKerjaAHP() {
        $data = [
            'title' => 'Cara Kerja Metode AHP - ' . APP_NAME,
            'csrf_token' => $this->generateCSRF()
        ];

        $this->view('dosen/cara_kerja_ahp', $data);
    }
}
