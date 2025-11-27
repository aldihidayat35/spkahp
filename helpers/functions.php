<?php

/**
 * Helper Functions
 */

// URL Helper
function url($path = '') {
    return BASE_URL . '/' . ltrim($path, '/');
}

function asset($path = '') {
    // Karena ada .htaccess redirect ke public/, path asset langsung ke assets/
    return BASE_URL . '/assets/' . ltrim($path, '/');
}

function redirect($url) {
    header('Location: ' . url($url));
    exit;
}

// Security Helpers
function escape($string) {
    return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
}

function csrf_field() {
    return '<input type="hidden" name="' . CSRF_TOKEN_NAME . '" value="' . $_SESSION[CSRF_TOKEN_NAME] . '">';
}

function csrf_token() {
    return $_SESSION[CSRF_TOKEN_NAME] ?? '';
}

// Session Helpers
function setFlash($key, $message, $type = 'info') {
    $_SESSION['flash'][$key] = [
        'message' => $message,
        'type' => $type
    ];
}

function getFlash($key) {
    if (isset($_SESSION['flash'][$key])) {
        $flash = $_SESSION['flash'][$key];
        unset($_SESSION['flash'][$key]);
        return $flash;
    }
    return null;
}

function hasFlash($key) {
    return isset($_SESSION['flash'][$key]);
}

// Request Helpers
function old($key, $default = '') {
    return $_SESSION['old'][$key] ?? $default;
}

function setOld($data) {
    $_SESSION['old'] = $data;
}

function clearOld() {
    unset($_SESSION['old']);
}

function request($key = null, $default = null) {
    if ($key === null) {
        return $_REQUEST;
    }
    return $_REQUEST[$key] ?? $default;
}

function post($key = null, $default = null) {
    if ($key === null) {
        return $_POST;
    }
    return $_POST[$key] ?? $default;
}

function get($key = null, $default = null) {
    if ($key === null) {
        return $_GET;
    }
    return $_GET[$key] ?? $default;
}

// Validation Helpers
function validate($data, $rules) {
    $errors = [];
    
    foreach ($rules as $field => $rule) {
        $ruleList = explode('|', $rule);
        
        foreach ($ruleList as $r) {
            $ruleName = $r;
            $ruleValue = null;
            
            if (strpos($r, ':') !== false) {
                list($ruleName, $ruleValue) = explode(':', $r);
            }
            
            switch ($ruleName) {
                case 'required':
                    if (empty($data[$field])) {
                        $errors[$field][] = ucfirst($field) . ' is required';
                    }
                    break;
                    
                case 'email':
                    if (!filter_var($data[$field], FILTER_VALIDATE_EMAIL)) {
                        $errors[$field][] = ucfirst($field) . ' must be a valid email';
                    }
                    break;
                    
                case 'min':
                    if (strlen($data[$field]) < $ruleValue) {
                        $errors[$field][] = ucfirst($field) . ' must be at least ' . $ruleValue . ' characters';
                    }
                    break;
                    
                case 'max':
                    if (strlen($data[$field]) > $ruleValue) {
                        $errors[$field][] = ucfirst($field) . ' must not exceed ' . $ruleValue . ' characters';
                    }
                    break;
                    
                case 'numeric':
                    if (!is_numeric($data[$field])) {
                        $errors[$field][] = ucfirst($field) . ' must be a number';
                    }
                    break;
            }
        }
    }
    
    return $errors;
}

// String Helpers
function str_limit($string, $limit = 100, $end = '...') {
    if (strlen($string) <= $limit) {
        return $string;
    }
    return substr($string, 0, $limit) . $end;
}

function slug($string) {
    $string = preg_replace('/[^A-Za-z0-9-]+/', '-', $string);
    return strtolower(trim($string, '-'));
}

// Date Helpers
function formatDate($date, $format = 'd/m/Y') {
    return date($format, strtotime($date));
}

function formatDateTime($datetime, $format = 'd/m/Y H:i:s') {
    return date($format, strtotime($datetime));
}

function now() {
    return date('Y-m-d H:i:s');
}

// Debug Helper
function dd(...$vars) {
    echo '<pre>';
    foreach ($vars as $var) {
        var_dump($var);
    }
    echo '</pre>';
    die();
}

function dump(...$vars) {
    echo '<pre>';
    foreach ($vars as $var) {
        var_dump($var);
    }
    echo '</pre>';
}

// File Upload Helper
function uploadFile($file, $destination = 'uploads/', $allowedTypes = ['jpg', 'jpeg', 'png', 'pdf']) {
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return ['success' => false, 'message' => 'Upload error'];
    }
    
    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    
    if (!in_array($fileExt, $allowedTypes)) {
        return ['success' => false, 'message' => 'File type not allowed'];
    }
    
    if ($fileSize > 5242880) { // 5MB
        return ['success' => false, 'message' => 'File size too large'];
    }
    
    $newFileName = uniqid('', true) . '.' . $fileExt;
    $uploadPath = ROOT_PATH . '/' . $destination . $newFileName;
    
    if (move_uploaded_file($fileTmpName, $uploadPath)) {
        return ['success' => true, 'filename' => $newFileName, 'path' => $destination . $newFileName];
    }
    
    return ['success' => false, 'message' => 'Failed to move uploaded file'];
}
