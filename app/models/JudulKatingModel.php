<?php

class JudulKatingModel {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    /**
     * Get all judul kating
     */
    public function getAll($tahun = null) {
        try {
            $query = "SELECT jk.*, a.nama_alternatif as tema_nama 
                     FROM judul_kating jk
                     LEFT JOIN alternatif a ON jk.tema_id = a.id";
            
            if ($tahun) {
                $query .= " WHERE jk.tahun = :tahun";
            }
            
            $query .= " ORDER BY jk.tahun DESC, jk.judul ASC";
            
            $stmt = $this->db->prepare($query);
            if ($tahun) {
                $stmt->bindParam(':tahun', $tahun);
            }
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return [];
        }
    }

    /**
     * Search judul kating
     */
    public function search($keyword, $tahun = null) {
        try {
            $query = "SELECT jk.*, a.nama_alternatif as tema_nama 
                     FROM judul_kating jk
                     LEFT JOIN alternatif a ON jk.tema_id = a.id
                     WHERE (jk.judul LIKE :keyword 
                        OR jk.nama_mahasiswa LIKE :keyword
                        OR jk.nim LIKE :keyword)";
            
            if ($tahun) {
                $query .= " AND jk.tahun = :tahun";
            }
            
            $query .= " ORDER BY jk.tahun DESC, jk.judul ASC";
            
            $stmt = $this->db->prepare($query);
            $search_term = "%$keyword%";
            $stmt->bindParam(':keyword', $search_term);
            if ($tahun) {
                $stmt->bindParam(':tahun', $tahun);
            }
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return [];
        }
    }

    /**
     * Get by tema
     */
    public function getByTema($tema_id) {
        try {
            $query = "SELECT * FROM judul_kating 
                     WHERE tema_id = :tema_id
                     ORDER BY tahun DESC, judul ASC";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':tema_id', $tema_id);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return [];
        }
    }

    /**
     * Create judul kating
     */
    public function create($data) {
        try {
            $query = "INSERT INTO judul_kating 
                     (judul, nama_mahasiswa, nim, tahun, tema_id, dosen_pembimbing, nilai) 
                     VALUES (:judul, :nama, :nim, :tahun, :tema_id, :dosen, :nilai)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':judul', $data['judul']);
            $stmt->bindParam(':nama', $data['nama_mahasiswa']);
            $stmt->bindParam(':nim', $data['nim']);
            $stmt->bindParam(':tahun', $data['tahun']);
            $stmt->bindParam(':tema_id', $data['tema_id']);
            $stmt->bindParam(':dosen', $data['dosen_pembimbing']);
            $stmt->bindParam(':nilai', $data['nilai']);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Get years list
     */
    public function getYears() {
        try {
            $query = "SELECT DISTINCT tahun FROM judul_kating ORDER BY tahun DESC";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_COLUMN);
        } catch (PDOException $e) {
            return [];
        }
    }
}
