<?php

class MahasiswaJudulModel {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    /**
     * Get judul by mahasiswa
     */
    public function getByMahasiswa($mahasiswa_id) {
        try {
            $query = "SELECT mj.*, a.nama_alternatif as tema_nama 
                     FROM mahasiswa_judul mj
                     LEFT JOIN alternatif a ON mj.tema_id = a.id
                     WHERE mj.mahasiswa_id = :mahasiswa_id
                     ORDER BY mj.created_at DESC";
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
            $query = "SELECT mj.*, a.nama_alternatif as tema_nama 
                     FROM mahasiswa_judul mj
                     LEFT JOIN alternatif a ON mj.tema_id = a.id
                     WHERE mj.id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch();
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Create judul
     */
    public function create($data) {
        try {
            $query = "INSERT INTO mahasiswa_judul 
                     (mahasiswa_id, judul, tema_id, deskripsi, status) 
                     VALUES (:mahasiswa_id, :judul, :tema_id, :deskripsi, :status)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':mahasiswa_id', $data['mahasiswa_id']);
            $stmt->bindParam(':judul', $data['judul']);
            $stmt->bindParam(':tema_id', $data['tema_id']);
            $stmt->bindParam(':deskripsi', $data['deskripsi']);
            $stmt->bindParam(':status', $data['status']);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Update judul
     */
    public function update($id, $data) {
        try {
            $query = "UPDATE mahasiswa_judul SET 
                     judul = :judul,
                     tema_id = :tema_id,
                     deskripsi = :deskripsi,
                     updated_at = NOW()
                     WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':judul', $data['judul']);
            $stmt->bindParam(':tema_id', $data['tema_id']);
            $stmt->bindParam(':deskripsi', $data['deskripsi']);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Update status
     */
    public function updateStatus($id, $status, $catatan = null) {
        try {
            $query = "UPDATE mahasiswa_judul SET 
                     status = :status,
                     catatan = :catatan,
                     updated_at = NOW()
                     WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':catatan', $catatan);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Submit judul (change status to submitted)
     */
    public function submit($id) {
        return $this->updateStatus($id, 'submitted');
    }

    /**
     * Delete judul
     */
    public function delete($id) {
        try {
            $query = "DELETE FROM mahasiswa_judul WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Get all judul for dosen/admin
     */
    public function getAll($status = null) {
        try {
            $query = "SELECT mj.*, u.nama as mahasiswa_nama, u.username, a.nama_alternatif as tema_nama
                     FROM mahasiswa_judul mj
                     JOIN users u ON mj.mahasiswa_id = u.id
                     LEFT JOIN alternatif a ON mj.tema_id = a.id";
            
            if ($status) {
                $query .= " WHERE mj.status = :status";
            }
            
            $query .= " ORDER BY mj.created_at DESC";
            
            $stmt = $this->db->prepare($query);
            if ($status) {
                $stmt->bindParam(':status', $status);
            }
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return [];
        }
    }
}
