<?php

class KurikulumModel {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    /**
     * Get all kurikulum
     */
    public function getAll() {
        try {
            $query = "SELECT * FROM kurikulum ORDER BY angkatan DESC";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return [];
        }
    }

    /**
     * Get kurikulum by ID
     */
    public function getById($id) {
        try {
            $query = "SELECT * FROM kurikulum WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch();
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Get kurikulum by angkatan (auto-assign logic)
     */
    public function getByAngkatan($angkatan) {
        try {
            $query = "SELECT * FROM kurikulum WHERE angkatan = :angkatan LIMIT 1";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':angkatan', $angkatan);
            $stmt->execute();
            return $stmt->fetch();
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Create kurikulum
     */
    private $lastError = '';

    public function getLastError() {
        return $this->lastError;
    }

    public function create($data) {
        try {
            // Ensure tahun_berlaku column exists, try with it first
            $query = "INSERT INTO kurikulum (angkatan, nama_kurikulum, tahun_berlaku, keterangan) 
                     VALUES (:angkatan, :nama_kurikulum, :tahun_berlaku, :keterangan)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':angkatan', $data['angkatan']);
            $stmt->bindParam(':nama_kurikulum', $data['nama_kurikulum']);
            $tahun_berlaku = $data['tahun_berlaku'] ?? '';
            $stmt->bindParam(':tahun_berlaku', $tahun_berlaku);
            $keterangan = $data['keterangan'] ?? '';
            $stmt->bindParam(':keterangan', $keterangan);
            
            if ($stmt->execute()) {
                return $this->db->lastInsertId();
            }
            return false;
        } catch (PDOException $e) {
            // If tahun_berlaku column doesn't exist, try without it
            if (strpos($e->getMessage(), 'tahun_berlaku') !== false) {
                try {
                    $query = "INSERT INTO kurikulum (angkatan, nama_kurikulum, keterangan) 
                             VALUES (:angkatan, :nama_kurikulum, :keterangan)";
                    $stmt = $this->db->prepare($query);
                    $stmt->bindParam(':angkatan', $data['angkatan']);
                    $stmt->bindParam(':nama_kurikulum', $data['nama_kurikulum']);
                    $keterangan = $data['keterangan'] ?? '';
                    $stmt->bindParam(':keterangan', $keterangan);
                    
                    if ($stmt->execute()) {
                        return $this->db->lastInsertId();
                    }
                    return false;
                } catch (PDOException $e2) {
                    $this->lastError = $e2->getMessage();
                    return false;
                }
            }
            $this->lastError = $e->getMessage();
            return false;
        }
    }

    /**
     * Update kurikulum
     */
    public function update($id, $data) {
        try {
            $query = "UPDATE kurikulum SET 
                     angkatan = :angkatan,
                     nama_kurikulum = :nama_kurikulum,
                     tahun_berlaku = :tahun_berlaku,
                     keterangan = :keterangan,
                     updated_at = NOW()
                     WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':angkatan', $data['angkatan']);
            $stmt->bindParam(':nama_kurikulum', $data['nama_kurikulum']);
            $stmt->bindParam(':tahun_berlaku', $data['tahun_berlaku']);
            $stmt->bindParam(':keterangan', $data['keterangan']);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Delete kurikulum
     */
    public function delete($id) {
        try {
            // Check if used by mahasiswa or mata kuliah
            $query = "SELECT COUNT(*) as count FROM mahasiswa WHERE kurikulum_id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $result = $stmt->fetch();
            
            if ($result['count'] > 0) {
                return false; // Cannot delete, used by mahasiswa
            }
            
            $query = "SELECT COUNT(*) as count FROM mata_kuliah WHERE kurikulum_id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $result = $stmt->fetch();
            
            if ($result['count'] > 0) {
                return false; // Cannot delete, used by mata kuliah
            }
            
            $query = "DELETE FROM kurikulum WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Get mata kuliah by kurikulum
     */
    public function getMataKuliah($kurikulum_id) {
        try {
            $query = "SELECT mk.* 
                     FROM mata_kuliah mk
                     WHERE mk.kurikulum_id = :kurikulum_id AND mk.is_active = 1
                     ORDER BY mk.nama_matkul ASC";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':kurikulum_id', $kurikulum_id);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return [];
        }
    }

    /**
     * Count mata kuliah in kurikulum
     */
    public function countMataKuliah($kurikulum_id) {
        try {
            $query = "SELECT COUNT(*) as count FROM mata_kuliah WHERE kurikulum_id = :kurikulum_id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':kurikulum_id', $kurikulum_id);
            $stmt->execute();
            $result = $stmt->fetch();
            return $result['count'];
        } catch (PDOException $e) {
            return 0;
        }
    }

    /**
     * Count mahasiswa in kurikulum
     */
    public function countMahasiswa($kurikulum_id) {
        try {
            $query = "SELECT COUNT(*) as count FROM mahasiswa WHERE kurikulum_id = :kurikulum_id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':kurikulum_id', $kurikulum_id);
            $stmt->execute();
            $result = $stmt->fetch();
            return $result['count'];
        } catch (PDOException $e) {
            return 0;
        }
    }
}
