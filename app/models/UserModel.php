<?php

class UserModel {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    /**
     * Get user by ID
     */
    public function getUserById($id) {
        try {
            $query = "SELECT * FROM users WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch();
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Update user profile
     */
    public function updateProfile($id, $data) {
        try {
            $query = "UPDATE users SET 
                     nama = :nama,
                     email = :email,
                     updated_at = NOW()
                     WHERE id = :id";
            
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':nama', $data['nama']);
            $stmt->bindParam(':email', $data['email']);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Update user photo
     */
    public function updateFoto($id, $foto_filename) {
        try {
            $query = "UPDATE users SET foto = :foto, updated_at = NOW() WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':foto', $foto_filename);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Get user photo path
     */
    public function getFotoPath($id) {
        $user = $this->getUserById($id);
        if ($user && !empty($user['foto'])) {
            $path = ROOT_PATH . '/uploads/foto_user/' . $user['foto'];
            if (file_exists($path)) {
                return url('uploads/foto_user/' . $user['foto']);
            }
        }
        // Default avatar
        return url('assets/img/default-avatar.svg');
    }

    /**
     * Change password
     */
    public function changePassword($id, $new_password) {
        try {
            $hashed = password_hash($new_password, PASSWORD_DEFAULT);
            $query = "UPDATE users SET password = :password, updated_at = NOW() WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':password', $hashed);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Update angkatan for mahasiswa
     */
    public function updateAngkatan($id, $angkatan) {
        try {
            $query = "UPDATE users SET angkatan = :angkatan WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':angkatan', $angkatan);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }
}
