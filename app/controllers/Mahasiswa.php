<?php

class Mahasiswa extends Controller {
    private $auth;
    private $mahasiswaModel;

    public function __construct() {
        parent::__construct();
        $this->auth = $this->model('AuthModel');
        
        // Check if user is mahasiswa
        if (!$this->auth->hasRole('mahasiswa')) {
            setFlash('error', 'Akses ditolak. Halaman khusus mahasiswa.', 'error');
            redirect('auth/login');
            exit;
        }

        $this->mahasiswaModel = $this->model('MahasiswaModel');
    }

    public function index() {
        $this->dashboard();
    }

    public function dashboard() {
        $mahasiswa_id = $_SESSION['mahasiswa_id'];
        $mahasiswa = $this->mahasiswaModel->findById($mahasiswa_id);
        
        // Get nilai mata kuliah
        $nilai_matkul = $this->mahasiswaModel->getNilaiMatkul($mahasiswa_id);
        
        // Get hasil rekomendasi
        $hasil_rekomendasi = $this->mahasiswaModel->getHasilRekomendasi($mahasiswa_id);
        
        // Get riwayat perhitungan
        $riwayat = $this->mahasiswaModel->getRiwayatPerhitungan($mahasiswa_id);

        // Statistics
        $stats = [
            'total_matkul' => count($nilai_matkul),
            'rata_rata_nilai' => 0,
            'has_rekomendasi' => count($hasil_rekomendasi) > 0,
            'tema_rekomendasi' => null
        ];

        if (count($nilai_matkul) > 0) {
            $total = 0;
            foreach ($nilai_matkul as $nm) {
                $total += $nm['nilai'];
            }
            $stats['rata_rata_nilai'] = $total / count($nilai_matkul);
        }

        if (count($hasil_rekomendasi) > 0) {
            $stats['tema_rekomendasi'] = $hasil_rekomendasi[0]['nama_tema'];
        }

        $data = [
            'title' => 'Dashboard Mahasiswa - ' . APP_NAME,
            'csrf_token' => $this->generateCSRF(),
            'mahasiswa' => $mahasiswa,
            'nilai_matkul' => $nilai_matkul,
            'hasil_rekomendasi' => $hasil_rekomendasi,
            'riwayat' => $riwayat,
            'stats' => $stats
        ];

        $this->view('mahasiswa/dashboard', $data);
    }

    public function inputNilai() {
        $mahasiswa_id = $_SESSION['mahasiswa_id'];
        
        // Get mahasiswa data to get kurikulum_id
        $mahasiswa = $this->mahasiswaModel->findById($mahasiswa_id);
        
        // Get mata kuliah filtered by kurikulum
        $matkulModel = $this->model('MataKuliahModel');
        if ($mahasiswa && $mahasiswa['kurikulum_id']) {
            // Filter by kurikulum
            $matakuliah = $matkulModel->getByKurikulum($mahasiswa['kurikulum_id']);
        } else {
            // Fallback: show all if no kurikulum assigned
            $matakuliah = $matkulModel->getAllActive();
        }

        // Get existing nilai
        $nilai_existing = $this->mahasiswaModel->getNilaiMatkul($mahasiswa_id);
        $nilai_map = [];
        foreach ($nilai_existing as $ne) {
            $nilai_map[$ne['matkul_id']] = $ne['nilai'];
        }

        if ($this->isPost()) {
            $this->validateCSRF();

            $nilai_input = post('nilai');
            $success_count = 0;

            foreach ($nilai_input as $matkul_id => $nilai) {
                if (!empty($nilai) && is_numeric($nilai)) {
                    if ($this->mahasiswaModel->saveNilaiMatkul($mahasiswa_id, $matkul_id, $nilai)) {
                        $success_count++;
                    }
                }
            }

            if ($success_count > 0) {
                setFlash('success', "Berhasil menyimpan {$success_count} nilai mata kuliah", 'success');
            } else {
                setFlash('error', 'Tidak ada nilai yang disimpan', 'error');
            }

            $this->redirect('mahasiswa/inputNilai');
        } else {
            // Group matakuliah by kriteria
            $kriteriaModel = $this->model('KriteriaModel');
            $kriteria = $kriteriaModel->getAllActive();
            
            $matkul_by_kriteria = [];
            foreach ($matakuliah as $mk) {
                $kriteria_id = $mk['kriteria_id'] ?? 'lainnya';
                if (!isset($matkul_by_kriteria[$kriteria_id])) {
                    $matkul_by_kriteria[$kriteria_id] = [
                        'nama' => $mk['nama_kriteria'] ?? 'Lainnya',
                        'matakuliah' => []
                    ];
                }
                $matkul_by_kriteria[$kriteria_id]['matakuliah'][] = $mk;
            }

            // Get kurikulum info
            $kurikulumModel = $this->model('KurikulumModel');
            $kurikulum = null;
            if ($mahasiswa && $mahasiswa['kurikulum_id']) {
                $kurikulum = $kurikulumModel->getById($mahasiswa['kurikulum_id']);
            }

            $data = [
                'title' => 'Input Nilai Mata Kuliah - ' . APP_NAME,
                'csrf_token' => $this->generateCSRF(),
                'matakuliah' => $matakuliah,
                'nilai_map' => $nilai_map,
                'matkul_by_kriteria' => $matkul_by_kriteria,
                'kurikulum' => $kurikulum,
                'mahasiswa' => $mahasiswa
            ];

            $this->view('mahasiswa/input_nilai', $data);
        }
    }

    public function prosesRekomendasi() {
        require_once ROOT_PATH . '/helpers/ahp.php';
        
        $mahasiswa_id = $_SESSION['mahasiswa_id'];
        
        // Get data yang diperlukan
        $kriteriaModel = $this->model('KriteriaModel');
        $alternatifModel = $this->model('AlternatifModel');
        
        $kriteria = $kriteriaModel->getAllActive();
        $alternatif = $alternatifModel->getAllActive();
        
        if (empty($kriteria)) {
            setFlash('error', 'Belum ada kriteria. Hubungi admin.', 'error');
            $this->redirect('mahasiswa/dashboard');
            return;
        }

        if (empty($alternatif)) {
            setFlash('error', 'Belum ada alternatif tema. Hubungi admin.', 'error');
            $this->redirect('mahasiswa/dashboard');
            return;
        }

        // Get nilai mahasiswa per kriteria
        $nilai_per_kriteria = $this->mahasiswaModel->getNilaiPerKriteria($mahasiswa_id);
        
        if (empty($nilai_per_kriteria)) {
            setFlash('error', 'Anda belum menginput nilai mata kuliah. Silakan input nilai terlebih dahulu.', 'error');
            $this->redirect('mahasiswa/inputNilai');
            return;
        }

        // ENFORCED FIXED WEIGHTS: Load from settings if enabled
        $ahp_settings = require ROOT_PATH . '/config/ahp_settings.php';
        $criteriaWeights = [];
        $cr_kriteria = 0;
        
        if (!empty($ahp_settings['enforce_fixed_weights'])) {
            // Use fixed weights from config
            $fixedScores = $ahp_settings['fixed_kriteria'];
            $scoreMap = [];
            
            foreach ($kriteria as $k) {
                $name = strtolower(trim($k['nama_kriteria']));
                $score = null;
                
                // Try exact match
                if (isset($fixedScores[$name])) {
                    $score = $fixedScores[$name];
                } else {
                    // Try partial match
                    foreach ($fixedScores as $key => $val) {
                        if (stripos($name, $key) !== false || stripos($key, $name) !== false) {
                            $score = $val;
                            break;
                        }
                    }
                }
                
                if ($score === null) {
                    $score = 5; // default
                }
                
                $scoreMap[$k['id']] = $score;
            }
            
            // Normalize to weights
            $totalScore = array_sum($scoreMap);
            foreach ($scoreMap as $id => $score) {
                $criteriaWeights[$id] = $score / $totalScore;
            }
            
            $cr_kriteria = 0; // Fixed weights are assumed consistent
            
        } else {
            // Original dynamic calculation
            $pairwise_kriteria = [];
            $query = "SELECT kriteria_1, kriteria_2, nilai FROM pairwise_kriteria";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $pairwise_data = $stmt->fetchAll();
            
            if (!empty($pairwise_data)) {
                // Build pairwise matrix untuk kriteria
                $comparisons = [];
                foreach ($pairwise_data as $pw) {
                    $comparisons[] = [
                        'item1' => $pw['kriteria_1'],
                        'item2' => $pw['kriteria_2'],
                        'value' => $pw['nilai']
                    ];
                }

                $kriteria_ids = array_column($kriteria, 'id');
                $ahp_kriteria = AHP::processAHP($kriteria_ids, $comparisons);
                
                // Map bobot kriteria
                foreach ($kriteria as $index => $k) {
                    $criteriaWeights[$k['id']] = $ahp_kriteria['weights'][$index] ?? (1 / count($kriteria));
                }
                
                $cr_kriteria = $ahp_kriteria['cr'];
            } else {
                // Jika tidak ada pairwise, gunakan equal weight
                foreach ($kriteria as $k) {
                    $criteriaWeights[$k['id']] = 1 / count($kriteria);
                }
                $cr_kriteria = 0;
            }
        }

        // Define relevance mapping between criteria and alternatives
        // 1=Pemrograman, 2=Multimedia, 3=Jaringan, 4=Kependidikan, 5=Minat
        // 1=Kependidikan, 2=Pemrograman, 3=Desain Media/Multimedia, 4=Jaringan Komputer
        $relevanceMap = [
            1 => [2 => 1.0, 1 => 0.3, 3 => 0.5, 4 => 0.2], // Kemampuan Pemrograman -> Pemrograman(1.0), Kependidikan(0.3), Multimedia(0.5), Jaringan(0.2)
            2 => [3 => 1.0, 2 => 0.4, 1 => 0.2, 4 => 0.1], // Kemampuan Multimedia -> Multimedia(1.0), Pemrograman(0.4), Kependidikan(0.2), Jaringan(0.1)
            3 => [4 => 1.0, 2 => 0.5, 3 => 0.3, 1 => 0.1], // Kemampuan Jaringan -> Jaringan(1.0), Pemrograman(0.5), Multimedia(0.3), Kependidikan(0.1)
            4 => [1 => 1.0, 3 => 0.4, 2 => 0.2, 4 => 0.3], // Kemampuan Kependidikan -> Kependidikan(1.0), Multimedia(0.4), Pemrograman(0.2), Jaringan(0.3)
            5 => [1 => 0.25, 2 => 0.25, 3 => 0.25, 4 => 0.25] // Minat -> Equal distribution
        ];
        
        // Calculate alternative scores for each criteria
        $alternativeScores = [];
        
        foreach ($kriteria as $k) {
            $kriteria_id = $k['id'];
            
            // Get nilai mahasiswa untuk kriteria ini
            $nilai_kriteria = 0;
            foreach ($nilai_per_kriteria as $npk) {
                if ($npk['kriteria_id'] == $kriteria_id) {
                    $nilai_kriteria = $npk['rata_rata_nilai'] ?? 0;
                    break;
                }
            }

            // Get pairwise alternatif untuk kriteria ini
            $pairwise_alt = $alternatifModel->getPairwiseByKriteria($kriteria_id);
            
            if (!empty($pairwise_alt)) {
                // Ada pairwise comparison
                $comparisons = [];
                foreach ($pairwise_alt as $pa) {
                    $comparisons[] = [
                        'item1' => $pa['alternatif_1'],
                        'item2' => $pa['alternatif_2'],
                        'value' => $pa['nilai']
                    ];
                }

                $alt_ids = array_column($alternatif, 'id');
                $ahp_alt = AHP::processAHP($alt_ids, $comparisons);
                
                // Kalikan dengan nilai mahasiswa (normalisasi 0-1)
                $nilai_normalized = $nilai_kriteria / 100;
                
                foreach ($alternatif as $index => $alt) {
                    $alt_id = $alt['id'];
                    $alt_weight = $ahp_alt['weights'][$index] ?? (1 / count($alternatif));
                    
                    // Score = bobot alternatif × nilai mahasiswa (dinormalisasi)
                    $score = $alt_weight * $nilai_normalized;
                    
                    if (!isset($alternativeScores[$alt_id])) {
                        $alternativeScores[$alt_id] = 0;
                    }
                    
                    // Tambahkan dengan bobot kriteria
                    $alternativeScores[$alt_id] += $score * $criteriaWeights[$kriteria_id];
                }
            } else {
                // Tidak ada pairwise, gunakan relevance mapping
                $nilai_normalized = $nilai_kriteria / 100;
                
                foreach ($alternatif as $alt) {
                    $alt_id = $alt['id'];
                    
                    if (!isset($alternativeScores[$alt_id])) {
                        $alternativeScores[$alt_id] = 0;
                    }
                    
                    // Get relevance weight dari mapping
                    $relevance = $relevanceMap[$kriteria_id][$alt_id] ?? 0.1;
                    
                    // Score = nilai mahasiswa × relevance × bobot kriteria
                    $alternativeScores[$alt_id] += $nilai_normalized * $relevance * $criteriaWeights[$kriteria_id];
                }
            }
        }

        // Rank alternatives
        arsort($alternativeScores);
        
        $results = [];
        $rank = 1;
        foreach ($alternativeScores as $alt_id => $score) {
            // Find alternatif name
            $alt_name = '';
            foreach ($alternatif as $alt) {
                if ($alt['id'] == $alt_id) {
                    $alt_name = $alt['nama_tema'];
                    break;
                }
            }

            $keterangan = "Tema {$alt_name} mendapat skor " . number_format($score, 4);
            
            $results[] = [
                'alternatif_id' => $alt_id,
                'score' => $score,
                'ranking' => $rank,
                'keterangan' => $keterangan
            ];
            
            $rank++;
        }

        // Save to database
        if ($this->mahasiswaModel->saveHasilRekomendasi($mahasiswa_id, $results)) {
            // Save riwayat perhitungan
            $detail = [
                'criteria_weights' => $criteriaWeights,
                'alternative_scores' => $alternativeScores,
                'nilai_per_kriteria' => $nilai_per_kriteria,
                'cr_kriteria' => $cr_kriteria
            ];
            $this->mahasiswaModel->saveRiwayatPerhitungan($mahasiswa_id, $cr_kriteria, ($cr_kriteria <= 0.1), $detail);

            setFlash('success', 'Proses perhitungan rekomendasi berhasil!', 'success');
            $this->redirect('mahasiswa/hasilRekomendasi');
        } else {
            setFlash('error', 'Gagal menyimpan hasil rekomendasi', 'error');
            $this->redirect('mahasiswa/dashboard');
        }
    }

    public function hasilRekomendasi() {
        $mahasiswa_id = $_SESSION['mahasiswa_id'];
        $mahasiswa = $this->mahasiswaModel->findById($mahasiswa_id);
        
        // Get hasil rekomendasi
        $hasil_rekomendasi = $this->mahasiswaModel->getHasilRekomendasi($mahasiswa_id);
        
        if (empty($hasil_rekomendasi)) {
            setFlash('info', 'Anda belum melakukan proses rekomendasi. Silakan input nilai dan proses terlebih dahulu.', 'info');
            $this->redirect('mahasiswa/dashboard');
            return;
        }

        // Get riwayat perhitungan
        $riwayat = $this->mahasiswaModel->getRiwayatPerhitungan($mahasiswa_id);

        // Get nilai per kriteria
        $nilai_per_kriteria = $this->mahasiswaModel->getNilaiPerKriteria($mahasiswa_id);

        $data = [
            'title' => 'Hasil Rekomendasi Tema - ' . APP_NAME,
            'csrf_token' => $this->generateCSRF(),
            'mahasiswa' => $mahasiswa,
            'hasil_rekomendasi' => $hasil_rekomendasi,
            'riwayat' => $riwayat,
            'nilai_per_kriteria' => $nilai_per_kriteria
        ];

        $this->view('mahasiswa/hasil_rekomendasi', $data);
    }

    public function profil() {
        $mahasiswa_id = $_SESSION['mahasiswa_id'];
        
        // Get mahasiswa data with user info
        $query = "SELECT m.*, u.username, u.created_at 
                  FROM mahasiswa m
                  JOIN users u ON m.user_id = u.id
                  WHERE m.id = :mahasiswa_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':mahasiswa_id', $mahasiswa_id);
        $stmt->execute();
        $mahasiswa = $stmt->fetch();

        if ($this->isPost()) {
            $this->validateCSRF();

            $data = [
                'nama' => trim(post('nama')),
                'angkatan' => trim(post('angkatan')),
                'minat_utama' => trim(post('minat_utama')),
                'email' => trim(post('email')),
                'no_hp' => trim(post('no_hp'))
            ];

            if ($this->mahasiswaModel->update($mahasiswa_id, $data)) {
                setFlash('success', 'Profil berhasil diupdate', 'success');
            } else {
                setFlash('error', 'Gagal mengupdate profil', 'error');
            }

            $this->redirect('mahasiswa/profil');
        } else {
            $data = [
                'title' => 'Profil Mahasiswa - ' . APP_NAME,
                'csrf_token' => $this->generateCSRF(),
                'mahasiswa' => $mahasiswa
            ];

            $this->view('mahasiswa/profil', $data);
        }
    }

    // ========================================
    // CARA KERJA AHP
    // ========================================

    public function caraKerjaAHP() {
        $data = [
            'title' => 'Cara Kerja Metode AHP - ' . APP_NAME,
            'csrf_token' => $this->generateCSRF()
        ];

        $this->view('mahasiswa/cara_kerja_ahp', $data);
    }

    // ========================================
    // UPLOAD FOTO PROFIL
    // ========================================

    public function uploadFoto() {
        if ($this->isPost()) {
            $this->validateCSRF();
            $userModel = $this->model('UserModel');
            
            if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
                $file = $_FILES['foto'];
                $allowed_types = ['image/jpeg', 'image/jpg', 'image/png'];
                $max_size = 2 * 1024 * 1024; // 2MB
                
                // Validate file type
                if (!in_array($file['type'], $allowed_types)) {
                    setFlash('error', 'Format file tidak valid. Gunakan JPG, JPEG, atau PNG.', 'error');
                    redirect('mahasiswa/profil');
                    return;
                }
                
                // Validate file size
                if ($file['size'] > $max_size) {
                    setFlash('error', 'Ukuran file maksimal 2MB.', 'error');
                    redirect('mahasiswa/profil');
                    return;
                }
                
                // Generate unique filename
                $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                $filename = 'user_' . $_SESSION['user_id'] . '_' . time() . '.' . $ext;
                $upload_path = ROOT_PATH . '/uploads/foto_user/' . $filename;
                
                // Delete old photo if exists
                $old_user = $userModel->getUserById($_SESSION['user_id']);
                if ($old_user && !empty($old_user['foto'])) {
                    $old_path = ROOT_PATH . '/uploads/foto_user/' . $old_user['foto'];
                    if (file_exists($old_path)) {
                        unlink($old_path);
                    }
                }
                
                // Upload new photo
                if (move_uploaded_file($file['tmp_name'], $upload_path)) {
                    if ($userModel->updateFoto($_SESSION['user_id'], $filename)) {
                        setFlash('success', 'Foto profil berhasil diupdate.', 'success');
                    } else {
                        setFlash('error', 'Gagal menyimpan foto ke database.', 'error');
                    }
                } else {
                    setFlash('error', 'Gagal mengupload foto.', 'error');
                }
            } else {
                setFlash('error', 'Tidak ada file yang diupload.', 'error');
            }
        }
        
        redirect('mahasiswa/profil');
    }

    // ========================================
    // KURIKULUM
    // ========================================

    public function kurikulum() {
        $userModel = $this->model('UserModel');
        $kurikulumModel = $this->model('KurikulumModel');
        
        $user = $userModel->getUserById($_SESSION['user_id']);
        $angkatan = $user['angkatan'] ?? date('Y');
        
        // Get kurikulum for user's angkatan
        $kurikulum = $kurikulumModel->getByAngkatan($angkatan);
        $matakuliah = [];
        
        if ($kurikulum) {
            $matakuliah = $kurikulumModel->getMataKuliah($kurikulum['id']);
        }
        
        $data = [
            'title' => 'Kurikulum Saya - ' . APP_NAME,
            'csrf_token' => $this->generateCSRF(),
            'angkatan' => $angkatan,
            'kurikulum' => $kurikulum,
            'matakuliah' => $matakuliah
        ];
        
        $this->view('mahasiswa/kurikulum', $data);
    }

    // ========================================
    // JUDUL TUGAS AKHIR
    // ========================================

    public function judulSaya() {
        $judulModel = $this->model('MahasiswaJudulModel');
        $alternatifModel = $this->model('AlternatifModel');
        
        $judul_list = $judulModel->getByMahasiswa($_SESSION['user_id']);
        $tema_list = $alternatifModel->getAllActive();
        
        $data = [
            'title' => 'Judul Tugas Akhir Saya - ' . APP_NAME,
            'csrf_token' => $this->generateCSRF(),
            'judul_list' => $judul_list,
            'tema_list' => $tema_list
        ];
        
        $this->view('mahasiswa/judul_saya', $data);
    }

    public function submitJudul() {
        if ($this->isPost()) {
            $this->validateCSRF();
            $judulModel = $this->model('MahasiswaJudulModel');
            
            $data = [
                'mahasiswa_id' => $_SESSION['user_id'],
                'judul' => post('judul'),
                'tema_id' => post('tema_id'),
                'deskripsi' => post('deskripsi'),
                'status' => 'draft'
            ];
            
            if ($judulModel->create($data)) {
                setFlash('success', 'Judul berhasil disimpan.', 'success');
            } else {
                setFlash('error', 'Gagal menyimpan judul.', 'error');
            }
        }
        
        redirect('mahasiswa/judulSaya');
    }

    public function editJudul($id) {
        $judulModel = $this->model('MahasiswaJudulModel');
        
        if ($this->isPost()) {
            $this->validateCSRF();
            
            $data = [
                'judul' => post('judul'),
                'tema_id' => post('tema_id'),
                'deskripsi' => post('deskripsi')
            ];
            
            if ($judulModel->update($id, $data)) {
                setFlash('success', 'Judul berhasil diupdate.', 'success');
            } else {
                setFlash('error', 'Gagal mengupdate judul.', 'error');
            }
            
            redirect('mahasiswa/judulSaya');
        }
    }

    public function ajukanJudul($id) {
        $judulModel = $this->model('MahasiswaJudulModel');
        
        if ($judulModel->submit($id)) {
            setFlash('success', 'Judul berhasil diajukan untuk persetujuan.', 'success');
        } else {
            setFlash('error', 'Gagal mengajukan judul.', 'error');
        }
        
        redirect('mahasiswa/judulSaya');
    }

    public function deleteJudul($id) {
        $judulModel = $this->model('MahasiswaJudulModel');
        
        if ($judulModel->delete($id)) {
            setFlash('success', 'Judul berhasil dihapus.', 'success');
        } else {
            setFlash('error', 'Gagal menghapus judul.', 'error');
        }
        
        redirect('mahasiswa/judulSaya');
    }

    // ========================================
    // CARI JUDUL KATING
    // ========================================

    public function cariJudulKating() {
        $judulKatingModel = $this->model('JudulKatingModel');
        
        $keyword = get('q', '');
        $tahun = get('tahun', '2021');
        
        if (!empty($keyword)) {
            $results = $judulKatingModel->search($keyword, $tahun);
        } else {
            $results = $judulKatingModel->getAll($tahun);
        }
        
        $years = $judulKatingModel->getYears();
        
        $data = [
            'title' => 'Cari Judul Kakak Tingkat - ' . APP_NAME,
            'csrf_token' => $this->generateCSRF(),
            'results' => $results,
            'keyword' => $keyword,
            'tahun' => $tahun,
            'years' => $years
        ];
        
        $this->view('mahasiswa/cari_judul_kating', $data);
    }

    // ========================================
    // UPLOAD KHS
    // ========================================

    public function uploadKHS() {
        $khsModel = $this->model('KHSModel');
        $khs_list = $khsModel->getByMahasiswa($_SESSION['user_id']);
        
        $data = [
            'title' => 'Upload KHS - ' . APP_NAME,
            'csrf_token' => $this->generateCSRF(),
            'khs_list' => $khs_list
        ];
        
        $this->view('mahasiswa/upload_khs', $data);
    }

    public function prosesUploadKHS() {
        if ($this->isPost()) {
            $this->validateCSRF();
            $khsModel = $this->model('KHSModel');
            
            if (isset($_FILES['file_khs']) && $_FILES['file_khs']['error'] == 0) {
                $file = $_FILES['file_khs'];
                $allowed_types = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'];
                $max_size = 5 * 1024 * 1024; // 5MB
                
                // Validate
                if (!in_array($file['type'], $allowed_types)) {
                    setFlash('error', 'Format file tidak valid. Gunakan PDF, JPG, JPEG, atau PNG.', 'error');
                    redirect('mahasiswa/uploadKHS');
                    return;
                }
                
                if ($file['size'] > $max_size) {
                    setFlash('error', 'Ukuran file maksimal 5MB.', 'error');
                    redirect('mahasiswa/uploadKHS');
                    return;
                }
                
                // Generate filename
                $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                $filename = 'khs_' . $_SESSION['user_id'] . '_' . time() . '.' . $ext;
                $upload_path = 'uploads/khs/' . $filename;
                $full_path = ROOT_PATH . '/' . $upload_path;
                
                // Upload file
                if (move_uploaded_file($file['tmp_name'], $full_path)) {
                    $data = [
                        'mahasiswa_id' => $_SESSION['user_id'],
                        'file_name' => $file['name'],
                        'file_path' => $upload_path,
                        'file_size' => $file['size'],
                        'semester' => post('semester'),
                        'tahun_akademik' => post('tahun_akademik')
                    ];
                    
                    if ($khsModel->upload($data)) {
                        setFlash('success', 'KHS berhasil diupload. Menunggu verifikasi.', 'success');
                    } else {
                        setFlash('error', 'Gagal menyimpan data KHS.', 'error');
                        unlink($full_path);
                    }
                } else {
                    setFlash('error', 'Gagal mengupload file.', 'error');
                }
            } else {
                setFlash('error', 'Tidak ada file yang diupload.', 'error');
            }
        }
        
        redirect('mahasiswa/uploadKHS');
    }

    public function deleteKHS($id) {
        $khsModel = $this->model('KHSModel');
        
        // Check ownership
        $khs = $khsModel->getById($id);
        if ($khs && $khs['mahasiswa_id'] == $_SESSION['user_id']) {
            if ($khsModel->delete($id)) {
                setFlash('success', 'KHS berhasil dihapus.', 'success');
            } else {
                setFlash('error', 'Gagal menghapus KHS.', 'error');
            }
        } else {
            setFlash('error', 'Akses ditolak.', 'error');
        }
        
        redirect('mahasiswa/uploadKHS');
    }
}
