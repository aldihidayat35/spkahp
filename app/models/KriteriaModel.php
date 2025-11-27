<?php

class KriteriaModel extends Model {
    protected $table = 'kriteria';

    public function getAllActive() {
        $query = "SELECT * FROM {$this->table} WHERE is_active = 1 ORDER BY kode";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getWithBobot() {
        $query = "SELECT * FROM {$this->table} WHERE is_active = 1 ORDER BY bobot DESC, kode";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function updateBobot($id, $bobot) {
        $query = "UPDATE {$this->table} SET bobot = :bobot WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':bobot', $bobot);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function getPairwiseComparisons() {
        $query = "SELECT pk.*, 
                  k1.kode as kode_1, k1.nama_kriteria as nama_1,
                  k2.kode as kode_2, k2.nama_kriteria as nama_2
                  FROM pairwise_kriteria pk
                  JOIN kriteria k1 ON pk.kriteria_1 = k1.id
                  JOIN kriteria k2 ON pk.kriteria_2 = k2.id
                  ORDER BY k1.kode, k2.kode";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function savePairwise($kriteria_1, $kriteria_2, $nilai) {
        $query = "INSERT INTO pairwise_kriteria (kriteria_1, kriteria_2, nilai) 
                 VALUES (:k1, :k2, :nilai)
                 ON DUPLICATE KEY UPDATE nilai = :nilai";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':k1', $kriteria_1);
        $stmt->bindParam(':k2', $kriteria_2);
        $stmt->bindParam(':nilai', $nilai);
        return $stmt->execute();
    }

    public function deletePairwise($kriteria_1, $kriteria_2) {
        $query = "DELETE FROM pairwise_kriteria 
                 WHERE (kriteria_1 = :k1 AND kriteria_2 = :k2)
                 OR (kriteria_1 = :k2 AND kriteria_2 = :k1)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':k1', $kriteria_1);
        $stmt->bindParam(':k2', $kriteria_2);
        return $stmt->execute();
    }

    public function toggleActive($id) {
        $query = "UPDATE {$this->table} SET is_active = NOT is_active WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
