<?php

class MataKuliahModel extends Model {
    protected $table = 'mata_kuliah';

    public function getAllActive() {
        $query = "SELECT mk.*, k.nama_kriteria, k.kode as kode_kriteria, ku.nama_kurikulum
                  FROM {$this->table} mk
                  LEFT JOIN kriteria k ON mk.kriteria_id = k.id
                  LEFT JOIN kurikulum ku ON mk.kurikulum_id = ku.id
                  WHERE mk.is_active = 1
                  ORDER BY ku.angkatan DESC, mk.kode";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getByKriteria($kriteria_id) {
        $query = "SELECT * FROM {$this->table} 
                  WHERE kriteria_id = :kriteria_id AND is_active = 1
                  ORDER BY kode";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':kriteria_id', $kriteria_id);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getByKurikulum($kurikulum_id) {
        $query = "SELECT mk.*, k.nama_kriteria 
                  FROM {$this->table} mk
                  LEFT JOIN kriteria k ON mk.kriteria_id = k.id
                  WHERE mk.kurikulum_id = :kurikulum_id AND mk.is_active = 1
                  ORDER BY mk.kode";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':kurikulum_id', $kurikulum_id);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function create($data) {
        try {
            $query = "INSERT INTO {$this->table} (kode, nama_matkul, kurikulum_id, kriteria_id, bobot_matkul) 
                     VALUES (:kode, :nama_matkul, :kurikulum_id, :kriteria_id, :bobot_matkul)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':kode', $data['kode']);
            $stmt->bindParam(':nama_matkul', $data['nama_matkul']);
            $stmt->bindParam(':kurikulum_id', $data['kurikulum_id']);
            $stmt->bindParam(':kriteria_id', $data['kriteria_id']);
            $stmt->bindParam(':bobot_matkul', $data['bobot_matkul']);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function update($id, $data) {
        try {
            $query = "UPDATE {$this->table} SET 
                     kode = :kode, 
                     nama_matkul = :nama_matkul, 
                     kurikulum_id = :kurikulum_id,
                     kriteria_id = :kriteria_id, 
                     bobot_matkul = :bobot_matkul 
                     WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':kode', $data['kode']);
            $stmt->bindParam(':nama_matkul', $data['nama_matkul']);
            $stmt->bindParam(':kurikulum_id', $data['kurikulum_id']);
            $stmt->bindParam(':kriteria_id', $data['kriteria_id']);
            $stmt->bindParam(':bobot_matkul', $data['bobot_matkul']);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function toggleActive($id) {
        $query = "UPDATE {$this->table} SET is_active = NOT is_active WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
