<?php

class Home extends Controller {
    public function index() {
        // Check if user already logged in, redirect to dashboard
        $auth = $this->model('AuthModel');
        if ($auth->isLoggedIn()) {
            $role = $_SESSION['role'];
            switch ($role) {
                case 'admin':
                    $this->redirect('admin/dashboard');
                    break;
                case 'mahasiswa':
                    $this->redirect('mahasiswa/dashboard');
                    break;
                case 'dosen':
                    $this->redirect('dosen/dashboard');
                    break;
            }
            return;
        }

        $data = [
            'title' => 'Beranda - ' . APP_NAME,
            'csrf_token' => $this->generateCSRF()
        ];
        
        $this->view('home/index', $data);
    }

    public function about() {
        $data = [
            'title' => 'Tentang - ' . APP_NAME
        ];
        
        $this->view('home/about', $data);
    }
}
