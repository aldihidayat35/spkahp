<?php

class AlternatifModel extends Model {
    protected $table = 'alternatif_tema';

    public function getAllActive() {
        $query = "SELECT * FROM {$this->table} WHERE is_active = 1 ORDER BY kode";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getPairwiseByKriteria($kriteria_id) {
        $query = "SELECT pa.*, 
                  a1.kode as kode_1, a1.nama_tema as nama_1,
                  a2.kode as kode_2, a2.nama_tema as nama_2
                  FROM pairwise_alternatif pa
                  JOIN alternatif_tema a1 ON pa.alternatif_1 = a1.id
                  JOIN alternatif_tema a2 ON pa.alternatif_2 = a2.id
                  WHERE pa.kriteria_id = :kriteria_id
                  ORDER BY a1.kode, a2.kode";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':kriteria_id', $kriteria_id);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function savePairwise($kriteria_id, $alternatif_1, $alternatif_2, $nilai) {
        $query = "INSERT INTO pairwise_alternatif (kriteria_id, alternatif_1, alternatif_2, nilai) 
                 VALUES (:kriteria_id, :a1, :a2, :nilai)
                 ON DUPLICATE KEY UPDATE nilai = :nilai";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':kriteria_id', $kriteria_id);
        $stmt->bindParam(':a1', $alternatif_1);
        $stmt->bindParam(':a2', $alternatif_2);
        $stmt->bindParam(':nilai', $nilai);
        return $stmt->execute();
    }

    public function deletePairwise($kriteria_id, $alternatif_1, $alternatif_2) {
        $query = "DELETE FROM pairwise_alternatif 
                 WHERE kriteria_id = :kriteria_id 
                 AND ((alternatif_1 = :a1 AND alternatif_2 = :a2)
                 OR (alternatif_1 = :a2 AND alternatif_2 = :a1))";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':kriteria_id', $kriteria_id);
        $stmt->bindParam(':a1', $alternatif_1);
        $stmt->bindParam(':a2', $alternatif_2);
        return $stmt->execute();
    }

    public function toggleActive($id) {
        $query = "UPDATE {$this->table} SET is_active = NOT is_active WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function getStatistik() {
        $query = "SELECT at.*, 
                  COUNT(DISTINCT hr.mahasiswa_id) as jumlah_mahasiswa,
                  AVG(hr.total_score) as rata_rata_score,
                  SUM(CASE WHEN hr.ranking = 1 THEN 1 ELSE 0 END) as jumlah_ranking_1
                  FROM alternatif_tema at
                  LEFT JOIN hasil_rekomendasi hr ON at.id = hr.alternatif_id
                  GROUP BY at.id
                  ORDER BY jumlah_ranking_1 DESC, rata_rata_score DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
