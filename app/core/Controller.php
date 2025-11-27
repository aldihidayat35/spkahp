<?php

class Controller {
    protected $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function view($view, $data = []) {
        extract($data);
        
        $viewFile = APP_PATH . '/views/' . $view . '.php';
        
        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            die("View not found: " . $view);
        }
    }

    public function model($model) {
        $modelFile = APP_PATH . '/models/' . $model . '.php';
        
        if (file_exists($modelFile)) {
            require_once $modelFile;
            return new $model();
        } else {
            die("Model not found: " . $model);
        }
    }

    public function redirect($url) {
        header('Location: ' . BASE_URL . '/' . $url);
        exit;
    }

    public function isPost() {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    public function isGet() {
        return $_SERVER['REQUEST_METHOD'] === 'GET';
    }

    protected function validateCSRF() {
        if ($this->isPost()) {
            $token = $_POST[CSRF_TOKEN_NAME] ?? '';
            if (!hash_equals($_SESSION[CSRF_TOKEN_NAME] ?? '', $token)) {
                die('Invalid CSRF token');
            }
        }
    }

    protected function generateCSRF() {
        if (empty($_SESSION[CSRF_TOKEN_NAME])) {
            $_SESSION[CSRF_TOKEN_NAME] = bin2hex(random_bytes(32));
        }
        return $_SESSION[CSRF_TOKEN_NAME];
    }
}
