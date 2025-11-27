<?php

class MataKuliahModel extends Model {
    protected $table = 'mata_kuliah';

    public function getAllActive() {
        $query = "SELECT mk.*, k.nama_kriteria, k.kode as kode_kriteria
                  FROM {$this->table} mk
                  LEFT JOIN kriteria k ON mk.kriteria_id = k.id
                  WHERE mk.is_active = 1
                  ORDER BY mk.kode";
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

    public function toggleActive($id) {
        $query = "UPDATE {$this->table} SET is_active = NOT is_active WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
