<?php

class KHSModel {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    /**
     * Get KHS by mahasiswa
     */
    public function getByMahasiswa($mahasiswa_id) {
        try {
            $query = "SELECT k.*, v.nama as verified_by_nama 
                     FROM khs_upload k
                     LEFT JOIN users v ON k.verified_by = v.id
                     WHERE k.mahasiswa_id = :mahasiswa_id
                     ORDER BY k.tahun_akademik DESC, k.semester DESC";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':mahasiswa_id', $mahasiswa_id);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return [];
        }
    }

    /**
     * Get by ID
     */
    public function getById($id) {
        try {
            $query = "SELECT * FROM khs_upload WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch();
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Upload KHS
     */
    public function upload($data) {
        try {
            $query = "INSERT INTO khs_upload 
                     (mahasiswa_id, file_name, file_path, file_size, semester, tahun_akademik) 
                     VALUES (:mahasiswa_id, :file_name, :file_path, :file_size, :semester, :tahun_akademik)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':mahasiswa_id', $data['mahasiswa_id']);
            $stmt->bindParam(':file_name', $data['file_name']);
            $stmt->bindParam(':file_path', $data['file_path']);
            $stmt->bindParam(':file_size', $data['file_size']);
            $stmt->bindParam(':semester', $data['semester']);
            $stmt->bindParam(':tahun_akademik', $data['tahun_akademik']);
            
            if ($stmt->execute()) {
                return $this->db->lastInsertId();
            }
            return false;
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Verify KHS
     */
    public function verify($id, $verified_by, $catatan = null) {
        try {
            $query = "UPDATE khs_upload SET 
                     verified = 1,
                     verified_by = :verified_by,
                     verified_at = NOW(),
                     catatan = :catatan
                     WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':verified_by', $verified_by);
            $stmt->bindParam(':catatan', $catatan);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Delete KHS
     */
    public function delete($id) {
        try {
            // Get file path first
            $khs = $this->getById($id);
            if ($khs) {
                // Delete file
                $filepath = ROOT_PATH . '/' . $khs['file_path'];
                if (file_exists($filepath)) {
                    unlink($filepath);
                }
                
                // Delete from database
                $query = "DELETE FROM khs_upload WHERE id = :id";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':id', $id);
                return $stmt->execute();
            }
            return false;
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Get all KHS for admin/dosen
     */
    public function getAll($verified = null) {
        try {
            $query = "SELECT k.*, u.nama as mahasiswa_nama, u.username, 
                     v.nama as verified_by_nama
                     FROM khs_upload k
                     JOIN users u ON k.mahasiswa_id = u.id
                     LEFT JOIN users v ON k.verified_by = v.id";
            
            if ($verified !== null) {
                $query .= " WHERE k.verified = :verified";
            }
            
            $query .= " ORDER BY k.upload_date DESC";
            
            $stmt = $this->db->prepare($query);
            if ($verified !== null) {
                $stmt->bindParam(':verified', $verified, PDO::PARAM_INT);
            }
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return [];
        }
    }

    /**
     * Check if student has verified KHS
     */
    public function hasVerifiedKHS($mahasiswa_id) {
        try {
            $query = "SELECT COUNT(*) FROM khs_upload 
                     WHERE mahasiswa_id = :mahasiswa_id AND verified = 1";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':mahasiswa_id', $mahasiswa_id);
            $stmt->execute();
            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            return false;
        }
    }
}
