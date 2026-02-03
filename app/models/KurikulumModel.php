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
            $query = "SELECT * FROM kurikulum ORDER BY tahun_mulai DESC";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return [];
        }
    }

    /**
     * Get active kurikulum
     */
    public function getAllActive() {
        try {
            $query = "SELECT * FROM kurikulum WHERE is_active = 1 ORDER BY tahun_mulai DESC";
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
     * Get kurikulum by angkatan
     */
    public function getByAngkatan($angkatan) {
        try {
            $query = "SELECT * FROM kurikulum 
                     WHERE tahun_mulai <= :angkatan 
                     AND (tahun_akhir IS NULL OR tahun_akhir >= :angkatan)
                     AND is_active = 1
                     LIMIT 1";
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
    public function create($data) {
        try {
            $query = "INSERT INTO kurikulum (nama_kurikulum, tahun_mulai, tahun_akhir, deskripsi, is_active) 
                     VALUES (:nama, :tahun_mulai, :tahun_akhir, :deskripsi, :is_active)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':nama', $data['nama_kurikulum']);
            $stmt->bindParam(':tahun_mulai', $data['tahun_mulai']);
            $stmt->bindParam(':tahun_akhir', $data['tahun_akhir']);
            $stmt->bindParam(':deskripsi', $data['deskripsi']);
            $stmt->bindParam(':is_active', $data['is_active']);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Update kurikulum
     */
    public function update($id, $data) {
        try {
            $query = "UPDATE kurikulum SET 
                     nama_kurikulum = :nama,
                     tahun_mulai = :tahun_mulai,
                     tahun_akhir = :tahun_akhir,
                     deskripsi = :deskripsi,
                     is_active = :is_active,
                     updated_at = NOW()
                     WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':nama', $data['nama_kurikulum']);
            $stmt->bindParam(':tahun_mulai', $data['tahun_mulai']);
            $stmt->bindParam(':tahun_akhir', $data['tahun_akhir']);
            $stmt->bindParam(':deskripsi', $data['deskripsi']);
            $stmt->bindParam(':is_active', $data['is_active']);
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
            $query = "SELECT mk.*, mkk.semester, mkk.is_wajib, mkk.id as matkul_kurikulum_id
                     FROM matkul_kurikulum mkk
                     JOIN mata_kuliah mk ON mkk.matkul_id = mk.id
                     WHERE mkk.kurikulum_id = :kurikulum_id
                     ORDER BY mkk.semester ASC, mk.nama_matkul ASC";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':kurikulum_id', $kurikulum_id);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return [];
        }
    }

    /**
     * Add mata kuliah to kurikulum
     */
    public function addMataKuliah($kurikulum_id, $matkul_id, $semester, $is_wajib = 1) {
        try {
            $query = "INSERT INTO matkul_kurikulum (kurikulum_id, matkul_id, semester, is_wajib) 
                     VALUES (:kurikulum_id, :matkul_id, :semester, :is_wajib)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':kurikulum_id', $kurikulum_id);
            $stmt->bindParam(':matkul_id', $matkul_id);
            $stmt->bindParam(':semester', $semester);
            $stmt->bindParam(':is_wajib', $is_wajib);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Remove mata kuliah from kurikulum
     */
    public function removeMataKuliah($matkul_kurikulum_id) {
        try {
            $query = "DELETE FROM matkul_kurikulum WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $matkul_kurikulum_id);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }
}
