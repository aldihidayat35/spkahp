<?php

class Auth extends Controller {
    private $auth;

    public function __construct() {
        parent::__construct();
        $this->auth = $this->model('AuthModel');
    }

    public function index() {
        // Redirect to login
        $this->login();
    }

    public function login() {
        // If already logged in, redirect to dashboard
        if ($this->auth->isLoggedIn()) {
            $this->redirectToDashboard();
        }

        if ($this->isPost()) {
            $this->validateCSRF();

            $username = trim(post('username'));
            $password = post('password');

            if (empty($username) || empty($password)) {
                setFlash('error', 'Username dan password harus diisi', 'error');
                $this->view('auth/login', [
                    'title' => 'Login - ' . APP_NAME,
                    'csrf_token' => $this->generateCSRF()
                ]);
                return;
            }

            $result = $this->auth->login($username, $password);

            if ($result['success']) {
                setFlash('success', 'Selamat datang, ' . $_SESSION['nama'], 'success');
                $this->redirectToDashboard();
            } else {
                setFlash('error', $result['message'], 'error');
                $this->view('auth/login', [
                    'title' => 'Login - ' . APP_NAME,
                    'csrf_token' => $this->generateCSRF()
                ]);
            }
        } else {
            $this->view('auth/login', [
                'title' => 'Login - ' . APP_NAME,
                'csrf_token' => $this->generateCSRF()
            ]);
        }
    }

    public function register() {
        // Only allow self-registration or admin can create
        if ($this->isPost()) {
            $this->validateCSRF();

            $data = [
                'username' => trim(post('username')),
                'password' => password_hash(post('password'), PASSWORD_DEFAULT),
                'nama' => trim(post('nama')),
                'role' => 'mahasiswa',
                'nim' => trim(post('nim')),
                'angkatan' => trim(post('angkatan')),
                'minat_utama' => trim(post('minat_utama')),
                'email' => trim(post('email')),
                'no_hp' => trim(post('no_hp'))
            ];

            // Validation
            $errors = validate($data, [
                'username' => 'required|min:4',
                'nama' => 'required',
                'nim' => 'required',
                'angkatan' => 'required|numeric',
                'email' => 'required|email'
            ]);

            if (!empty($errors)) {
                setOld($_POST);
                foreach ($errors as $field => $error) {
                    setFlash('error_' . $field, $error[0], 'error');
                }
                $this->redirect('auth/register');
                return;
            }

            $result = $this->auth->register($data);

            if ($result['success']) {
                setFlash('success', 'Registrasi berhasil. Silakan login.', 'success');
                $this->redirect('auth/login');
            } else {
                setFlash('error', $result['message'], 'error');
                setOld($_POST);
                $this->redirect('auth/register');
            }
        } else {
            $this->view('auth/register', [
                'title' => 'Registrasi - ' . APP_NAME,
                'csrf_token' => $this->generateCSRF()
            ]);
        }
    }

    public function logout() {
        $this->auth->logout();
        setFlash('success', 'Anda telah logout', 'success');
        $this->redirect('auth/login');
    }

    private function redirectToDashboard() {
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
            default:
                $this->redirect('home');
        }
    }

    public function changePassword() {
        if (!$this->auth->isLoggedIn()) {
            $this->redirect('auth/login');
            return;
        }

        if ($this->isPost()) {
            $this->validateCSRF();

            $old_password = post('old_password');
            $new_password = post('new_password');
            $confirm_password = post('confirm_password');

            if ($new_password !== $confirm_password) {
                setFlash('error', 'Konfirmasi password tidak sesuai', 'error');
                $this->view('auth/change_password', [
                    'title' => 'Ubah Password',
                    'csrf_token' => $this->generateCSRF()
                ]);
                return;
            }

            $result = $this->auth->changePassword($_SESSION['user_id'], $old_password, $new_password);

            if ($result['success']) {
                setFlash('success', $result['message'], 'success');
                $this->redirectToDashboard();
            } else {
                setFlash('error', $result['message'], 'error');
                $this->view('auth/change_password', [
                    'title' => 'Ubah Password',
                    'csrf_token' => $this->generateCSRF()
                ]);
            }
        } else {
            $this->view('auth/change_password', [
                'title' => 'Ubah Password',
                'csrf_token' => $this->generateCSRF()
            ]);
        }
    }
}
