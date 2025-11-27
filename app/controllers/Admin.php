<?php

class Admin extends Controller {
    private $auth;

    public function __construct() {
        parent::__construct();
        $this->auth = $this->model('AuthModel');
        
        // Check if user is admin
        if (!$this->auth->hasRole('admin')) {
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
        $kriteriaModel = $this->model('KriteriaModel');

        // Get statistics
        $stats = [
            'total_mahasiswa' => count($mahasiswaModel->findAll()),
            'total_kriteria' => count($kriteriaModel->getAllActive()),
            'total_alternatif' => count($alternatifModel->getAllActive()),
            'mahasiswa_sudah_rekomendasi' => 0 // Will be calculated
        ];

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

        // Count mahasiswa yang sudah mendapat rekomendasi
        $query = "SELECT COUNT(DISTINCT mahasiswa_id) as total FROM hasil_rekomendasi";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch();
        $stats['mahasiswa_sudah_rekomendasi'] = $result['total'];

        $data = [
            'title' => 'Dashboard Admin - ' . APP_NAME,
            'csrf_token' => $this->generateCSRF(),
            'stats' => $stats,
            'recent_mahasiswa' => $recent_mahasiswa,
            'statistik_tema' => $statistik_tema
        ];

        $this->view('admin/dashboard', $data);
    }

    // ========================================
    // KELOLA USER & MAHASISWA
    // ========================================

    public function users() {
        $query = "SELECT u.*, m.nim, m.angkatan 
                 FROM users u
                 LEFT JOIN mahasiswa m ON u.id = m.user_id
                 ORDER BY u.created_at DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $users = $stmt->fetchAll();

        $data = [
            'title' => 'Kelola User - ' . APP_NAME,
            'csrf_token' => $this->generateCSRF(),
            'users' => $users
        ];

        $this->view('admin/users/index', $data);
    }

    public function addUser() {
        if ($this->isPost()) {
            $this->validateCSRF();

            $role = post('role');
            $userData = [
                'username' => trim(post('username')),
                'password' => password_hash(post('password'), PASSWORD_DEFAULT),
                'nama' => trim(post('nama')),
                'role' => $role
            ];

            if ($role === 'mahasiswa') {
                $userData['nim'] = trim(post('nim'));
                $userData['angkatan'] = trim(post('angkatan'));
                $userData['minat_utama'] = trim(post('minat_utama'));
                $userData['email'] = trim(post('email'));
                $userData['no_hp'] = trim(post('no_hp'));
            }

            $auth = $this->model('AuthModel');
            $result = $auth->register($userData);

            if ($result['success']) {
                setFlash('success', 'User berhasil ditambahkan', 'success');
            } else {
                setFlash('error', $result['message'], 'error');
            }

            $this->redirect('admin/users');
        } else {
            $data = [
                'title' => 'Tambah User - ' . APP_NAME,
                'csrf_token' => $this->generateCSRF()
            ];

            $this->view('admin/users/form', $data);
        }
    }

    public function editUser($id) {
        if ($this->isPost()) {
            $this->validateCSRF();

            $data = [
                'nama' => trim(post('nama')),
                'role' => post('role')
            ];

            // Update password if provided
            $new_password = post('new_password');
            if (!empty($new_password)) {
                $data['password'] = password_hash($new_password, PASSWORD_DEFAULT);
            }

            $userModel = $this->model('User');
            if ($userModel->update($id, $data)) {
                setFlash('success', 'User berhasil diupdate', 'success');
            } else {
                setFlash('error', 'Gagal mengupdate user', 'error');
            }

            $this->redirect('admin/users');
        } else {
            $userModel = $this->model('User');
            $user = $userModel->findById($id);

            $data = [
                'title' => 'Edit User - ' . APP_NAME,
                'csrf_token' => $this->generateCSRF(),
                'user' => $user
            ];

            $this->view('admin/users/form', $data);
        }
    }

    public function deleteUser($id) {
        if ($this->isPost()) {
            $this->validateCSRF();

            // Don't allow deleting own account
            if ($id == $_SESSION['user_id']) {
                setFlash('error', 'Tidak dapat menghapus akun sendiri', 'error');
                $this->redirect('admin/users');
                return;
            }

            $userModel = $this->model('User');
            if ($userModel->delete($id)) {
                setFlash('success', 'User berhasil dihapus', 'success');
            } else {
                setFlash('error', 'Gagal menghapus user', 'error');
            }
        }

        $this->redirect('admin/users');
    }

    public function resetPassword($id) {
        if ($this->isPost()) {
            $this->validateCSRF();

            $auth = $this->model('AuthModel');
            $new_password = 'password'; // Default password
            $result = $auth->resetPassword($id, $new_password);

            if ($result['success']) {
                setFlash('success', 'Password berhasil direset menjadi: password', 'success');
            } else {
                setFlash('error', $result['message'], 'error');
            }
        }

        $this->redirect('admin/users');
    }

    // ========================================
    // KELOLA MAHASISWA
    // ========================================

    public function mahasiswa() {
        $mahasiswaModel = $this->model('MahasiswaModel');
        $mahasiswa = $mahasiswaModel->getAllWithUser();

        $data = [
            'title' => 'Data Mahasiswa - ' . APP_NAME,
            'csrf_token' => $this->generateCSRF(),
            'mahasiswa' => $mahasiswa
        ];

        $this->view('admin/mahasiswa/index', $data);
    }

    public function detailMahasiswa($id) {
        $mahasiswaModel = $this->model('MahasiswaModel');
        $mahasiswa = $mahasiswaModel->findByIdWithUser($id);
        
        if (!$mahasiswa) {
            setFlash('error', 'Mahasiswa tidak ditemukan', 'error');
            $this->redirect('admin/mahasiswa');
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

        $this->view('admin/mahasiswa/detail', $data);
    }

    // ========================================
    // KELOLA KRITERIA
    // ========================================

    public function kriteria() {
        $kriteriaModel = $this->model('KriteriaModel');
        $kriteria = $kriteriaModel->findAll();

        $data = [
            'title' => 'Kelola Kriteria - ' . APP_NAME,
            'csrf_token' => $this->generateCSRF(),
            'kriteria' => $kriteria
        ];

        $this->view('admin/kriteria/index', $data);
    }

    public function addKriteria() {
        if ($this->isPost()) {
            $this->validateCSRF();

            $data = [
                'kode' => strtoupper(trim(post('kode'))),
                'nama_kriteria' => trim(post('nama_kriteria')),
                'jenis' => post('jenis'),
                'keterangan' => trim(post('keterangan'))
            ];

            $kriteriaModel = $this->model('KriteriaModel');
            if ($kriteriaModel->create($data)) {
                setFlash('success', 'Kriteria berhasil ditambahkan', 'success');
            } else {
                setFlash('error', 'Gagal menambahkan kriteria', 'error');
            }

            $this->redirect('admin/kriteria');
        } else {
            $data = [
                'title' => 'Tambah Kriteria - ' . APP_NAME,
                'csrf_token' => $this->generateCSRF()
            ];

            $this->view('admin/kriteria/form', $data);
        }
    }

    public function editKriteria($id) {
        $kriteriaModel = $this->model('KriteriaModel');

        if ($this->isPost()) {
            $this->validateCSRF();

            $data = [
                'kode' => strtoupper(trim(post('kode'))),
                'nama_kriteria' => trim(post('nama_kriteria')),
                'jenis' => post('jenis'),
                'keterangan' => trim(post('keterangan'))
            ];

            if ($kriteriaModel->update($id, $data)) {
                setFlash('success', 'Kriteria berhasil diupdate', 'success');
            } else {
                setFlash('error', 'Gagal mengupdate kriteria', 'error');
            }

            $this->redirect('admin/kriteria');
        } else {
            $kriteria = $kriteriaModel->findById($id);

            $data = [
                'title' => 'Edit Kriteria - ' . APP_NAME,
                'csrf_token' => $this->generateCSRF(),
                'kriteria' => $kriteria
            ];

            $this->view('admin/kriteria/form', $data);
        }
    }

    public function deleteKriteria($id) {
        if ($this->isPost()) {
            $this->validateCSRF();

            $kriteriaModel = $this->model('KriteriaModel');
            if ($kriteriaModel->delete($id)) {
                setFlash('success', 'Kriteria berhasil dihapus', 'success');
            } else {
                setFlash('error', 'Gagal menghapus kriteria', 'error');
            }
        }

        $this->redirect('admin/kriteria');
    }

    // ========================================
    // KELOLA ALTERNATIF TEMA
    // ========================================

    public function alternatif() {
        $alternatifModel = $this->model('AlternatifModel');
        $alternatif = $alternatifModel->findAll();

        $data = [
            'title' => 'Kelola Alternatif Tema - ' . APP_NAME,
            'csrf_token' => $this->generateCSRF(),
            'alternatif' => $alternatif
        ];

        $this->view('admin/alternatif/index', $data);
    }

    public function addAlternatif() {
        if ($this->isPost()) {
            $this->validateCSRF();

            $data = [
                'kode' => strtoupper(trim(post('kode'))),
                'nama_tema' => trim(post('nama_tema')),
                'deskripsi' => trim(post('deskripsi')),
                'icon' => trim(post('icon'))
            ];

            $alternatifModel = $this->model('AlternatifModel');
            if ($alternatifModel->create($data)) {
                setFlash('success', 'Alternatif tema berhasil ditambahkan', 'success');
            } else {
                setFlash('error', 'Gagal menambahkan alternatif tema', 'error');
            }

            $this->redirect('admin/alternatif');
        } else {
            $data = [
                'title' => 'Tambah Alternatif Tema - ' . APP_NAME,
                'csrf_token' => $this->generateCSRF()
            ];

            $this->view('admin/alternatif/form', $data);
        }
    }

    public function editAlternatif($id) {
        $alternatifModel = $this->model('AlternatifModel');

        if ($this->isPost()) {
            $this->validateCSRF();

            $data = [
                'kode' => strtoupper(trim(post('kode'))),
                'nama_tema' => trim(post('nama_tema')),
                'deskripsi' => trim(post('deskripsi')),
                'icon' => trim(post('icon'))
            ];

            if ($alternatifModel->update($id, $data)) {
                setFlash('success', 'Alternatif tema berhasil diupdate', 'success');
            } else {
                setFlash('error', 'Gagal mengupdate alternatif tema', 'error');
            }

            $this->redirect('admin/alternatif');
        } else {
            $alternatif = $alternatifModel->findById($id);

            $data = [
                'title' => 'Edit Alternatif Tema - ' . APP_NAME,
                'csrf_token' => $this->generateCSRF(),
                'alternatif' => $alternatif
            ];

            $this->view('admin/alternatif/form', $data);
        }
    }

    public function deleteAlternatif($id) {
        if ($this->isPost()) {
            $this->validateCSRF();

            $alternatifModel = $this->model('AlternatifModel');
            if ($alternatifModel->delete($id)) {
                setFlash('success', 'Alternatif tema berhasil dihapus', 'success');
            } else {
                setFlash('error', 'Gagal menghapus alternatif tema', 'error');
            }
        }

        $this->redirect('admin/alternatif');
    }

    // ========================================
    // KELOLA MATA KULIAH
    // ========================================

    public function matakuliah() {
        $matkulModel = $this->model('MataKuliahModel');
        $matakuliah = $matkulModel->getAllActive();

        $data = [
            'title' => 'Kelola Mata Kuliah - ' . APP_NAME,
            'csrf_token' => $this->generateCSRF(),
            'matakuliah' => $matakuliah
        ];

        $this->view('admin/matakuliah/index', $data);
    }

    public function addMatakuliah() {
        if ($this->isPost()) {
            $this->validateCSRF();

            $data = [
                'kode' => strtoupper(trim(post('kode'))),
                'nama_matkul' => trim(post('nama_matkul')),
                'kriteria_id' => post('kriteria_id'),
                'bobot_matkul' => post('bobot_matkul') ?: 1
            ];

            $matkulModel = $this->model('MataKuliahModel');
            if ($matkulModel->create($data)) {
                setFlash('success', 'Mata kuliah berhasil ditambahkan', 'success');
            } else {
                setFlash('error', 'Gagal menambahkan mata kuliah', 'error');
            }

            $this->redirect('admin/matakuliah');
        } else {
            $kriteriaModel = $this->model('KriteriaModel');
            $kriteria = $kriteriaModel->getAllActive();

            $data = [
                'title' => 'Tambah Mata Kuliah - ' . APP_NAME,
                'csrf_token' => $this->generateCSRF(),
                'kriteria' => $kriteria
            ];

            $this->view('admin/matakuliah/form', $data);
        }
    }

    // ========================================
    // PAIRWISE COMPARISON
    // ========================================

    public function pairwiseKriteria() {
        require_once ROOT_PATH . '/helpers/ahp.php';
        
        $kriteriaModel = $this->model('KriteriaModel');
        $kriteria = $kriteriaModel->getAllActive();
        $pairwise = $kriteriaModel->getPairwiseComparisons();

        // Calculate AHP if data exists
        $ahp_result = null;
        if (count($kriteria) > 1) {
            // Build comparisons array
            $comparisons = [];
            foreach ($pairwise as $pw) {
                $comparisons[] = [
                    'item1' => $pw['kriteria_1'],
                    'item2' => $pw['kriteria_2'],
                    'value' => $pw['nilai']
                ];
            }

            $items = array_column($kriteria, 'id');
            $ahp_result = AHP::processAHP($items, $comparisons);

            // Update bobot kriteria
            foreach ($kriteria as $index => $k) {
                if (isset($ahp_result['weights'][$index])) {
                    $kriteriaModel->updateBobot($k['id'], $ahp_result['weights'][$index]);
                }
            }
        }

        $data = [
            'title' => 'Perbandingan Berpasangan Kriteria - ' . APP_NAME,
            'csrf_token' => $this->generateCSRF(),
            'kriteria' => $kriteria,
            'pairwise' => $pairwise,
            'ahp_result' => $ahp_result
        ];

        $this->view('admin/pairwise/kriteria', $data);
    }

    public function savePairwiseKriteria() {
        if ($this->isPost()) {
            $this->validateCSRF();

            $kriteria_1 = post('kriteria_1');
            $kriteria_2 = post('kriteria_2');
            $nilai = post('nilai');

            $kriteriaModel = $this->model('KriteriaModel');
            if ($kriteriaModel->savePairwise($kriteria_1, $kriteria_2, $nilai)) {
                setFlash('success', 'Perbandingan berhasil disimpan', 'success');
            } else {
                setFlash('error', 'Gagal menyimpan perbandingan', 'error');
            }
        }

        $this->redirect('admin/pairwiseKriteria');
    }

    public function pairwiseAlternatif($kriteria_id = null) {
        require_once ROOT_PATH . '/helpers/ahp.php';
        
        $kriteriaModel = $this->model('KriteriaModel');
        $alternatifModel = $this->model('AlternatifModel');
        
        $kriteria_list = $kriteriaModel->getAllActive();
        $alternatif = $alternatifModel->getAllActive();

        // Get kriteria_id from GET parameter if not from URL
        if (!$kriteria_id && isset($_GET['kriteria_id'])) {
            $kriteria_id = $_GET['kriteria_id'];
        }

        if ($kriteria_id) {
            $kriteria_selected = $kriteriaModel->findById($kriteria_id);
            $pairwise = $alternatifModel->getPairwiseByKriteria($kriteria_id);

            // Calculate AHP
            $ahp_result = null;
            if (count($alternatif) > 1 && !empty($pairwise)) {
                $comparisons = [];
                foreach ($pairwise as $pw) {
                    $comparisons[] = [
                        'item1' => $pw['alternatif_1'],
                        'item2' => $pw['alternatif_2'],
                        'value' => $pw['nilai']
                    ];
                }

                $items = array_column($alternatif, 'id');
                $ahp_result = AHP::processAHP($items, $comparisons);
            }
        } else {
            $kriteria_selected = null;
            $pairwise = [];
            $ahp_result = null;
        }

        $data = [
            'title' => 'Perbandingan Berpasangan Alternatif - ' . APP_NAME,
            'csrf_token' => $this->generateCSRF(),
            'kriteria' => $kriteria_list,
            'kriteria_info' => $kriteria_selected,
            'selected_kriteria' => $kriteria_id,
            'alternatif' => $alternatif,
            'pairwise' => $pairwise,
            'hasil' => $ahp_result
        ];

        $this->view('admin/pairwise/alternatif', $data);
    }

    public function savePairwiseAlternatif() {
        if ($this->isPost()) {
            $this->validateCSRF();

            $kriteria_id = post('kriteria_id');
            $alternatif_1 = post('alternatif_1');
            $alternatif_2 = post('alternatif_2');
            $nilai = post('nilai');

            $alternatifModel = $this->model('AlternatifModel');
            if ($alternatifModel->savePairwise($kriteria_id, $alternatif_1, $alternatif_2, $nilai)) {
                setFlash('success', 'Perbandingan berhasil disimpan', 'success');
                $this->redirect('admin/pairwiseAlternatif?kriteria_id=' . $kriteria_id);
            } else {
                setFlash('error', 'Gagal menyimpan perbandingan', 'error');
                $this->redirect('admin/pairwiseAlternatif?kriteria_id=' . $kriteria_id);
            }
        }
    }

    // ========================================
    // LAPORAN
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

        $this->view('admin/laporan/index', $data);
    }

    // ========================================
    // VISUALISASI AHP
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

        $this->view('admin/visualisasi/index', $data);
    }
}
