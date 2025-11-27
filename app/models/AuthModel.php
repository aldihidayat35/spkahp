<?php

class AuthModel {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function login($username, $password) {
        try {
            $query = "SELECT u.*, m.id as mahasiswa_id, m.nim, m.nama as nama_mahasiswa 
                     FROM users u 
                     LEFT JOIN mahasiswa m ON u.id = m.user_id 
                     WHERE u.username = :username AND u.is_active = 1";
            
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':username', $username);
            $stmt->execute();

            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                // Set session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['nama'] = $user['nama'];
                $_SESSION['role'] = $user['role'];
                
                if ($user['role'] === 'mahasiswa' && $user['mahasiswa_id']) {
                    $_SESSION['mahasiswa_id'] = $user['mahasiswa_id'];
                    $_SESSION['nim'] = $user['nim'];
                }

                $_SESSION['logged_in'] = true;
                $_SESSION['last_activity'] = time();

                return [
                    'success' => true,
                    'role' => $user['role'],
                    'message' => 'Login berhasil'
                ];
            }

            return [
                'success' => false,
                'message' => 'Username atau password salah'
            ];

        } catch (PDOException $e) {
            return [
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ];
        }
    }

    public function logout() {
        session_unset();
        session_destroy();
        return true;
    }

    public function isLoggedIn() {
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
            // Check session timeout (1 hour)
            if (time() - $_SESSION['last_activity'] > SESSION_LIFETIME) {
                $this->logout();
                return false;
            }
            $_SESSION['last_activity'] = time();
            return true;
        }
        return false;
    }

    public function hasRole($role) {
        if (!$this->isLoggedIn()) {
            return false;
        }

        if (is_array($role)) {
            return in_array($_SESSION['role'], $role);
        }

        return $_SESSION['role'] === $role;
    }

    public function register($data) {
        try {
            $this->db->beginTransaction();

            // Insert user
            $query = "INSERT INTO users (username, password, nama, role) 
                     VALUES (:username, :password, :nama, :role)";
            
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':username', $data['username']);
            $stmt->bindParam(':password', $data['password']);
            $stmt->bindParam(':nama', $data['nama']);
            $stmt->bindParam(':role', $data['role']);
            $stmt->execute();

            $user_id = $this->db->lastInsertId();

            // If mahasiswa, insert to mahasiswa table
            if ($data['role'] === 'mahasiswa') {
                $query = "INSERT INTO mahasiswa (user_id, nim, nama, angkatan, minat_utama, email, no_hp) 
                         VALUES (:user_id, :nim, :nama, :angkatan, :minat_utama, :email, :no_hp)";
                
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':user_id', $user_id);
                $stmt->bindParam(':nim', $data['nim']);
                $stmt->bindParam(':nama', $data['nama']);
                $stmt->bindParam(':angkatan', $data['angkatan']);
                $stmt->bindParam(':minat_utama', $data['minat_utama']);
                $stmt->bindParam(':email', $data['email']);
                $stmt->bindParam(':no_hp', $data['no_hp']);
                $stmt->execute();
            }

            $this->db->commit();

            return [
                'success' => true,
                'message' => 'Registrasi berhasil'
            ];

        } catch (PDOException $e) {
            $this->db->rollBack();
            return [
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ];
        }
    }

    public function changePassword($user_id, $old_password, $new_password) {
        try {
            $query = "SELECT password FROM users WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $user_id);
            $stmt->execute();
            $user = $stmt->fetch();

            if (!$user || !password_verify($old_password, $user['password'])) {
                return [
                    'success' => false,
                    'message' => 'Password lama tidak sesuai'
                ];
            }

            $hashed = password_hash($new_password, PASSWORD_DEFAULT);
            $query = "UPDATE users SET password = :password WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':password', $hashed);
            $stmt->bindParam(':id', $user_id);
            $stmt->execute();

            return [
                'success' => true,
                'message' => 'Password berhasil diubah'
            ];

        } catch (PDOException $e) {
            return [
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ];
        }
    }

    public function resetPassword($user_id, $new_password) {
        try {
            $hashed = password_hash($new_password, PASSWORD_DEFAULT);
            $query = "UPDATE users SET password = :password WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':password', $hashed);
            $stmt->bindParam(':id', $user_id);
            $stmt->execute();

            return [
                'success' => true,
                'message' => 'Password berhasil direset'
            ];

        } catch (PDOException $e) {
            return [
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ];
        }
    }
}
