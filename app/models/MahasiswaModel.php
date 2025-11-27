<?php

class MahasiswaModel extends Model {
    protected $table = 'mahasiswa';

    public function getAllWithUser() {
        $query = "SELECT m.*, u.username, u.is_active, u.created_at as tanggal_daftar
                  FROM {$this->table} m
                  JOIN users u ON m.user_id = u.id
                  ORDER BY m.nim DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getByUserId($user_id) {
        $query = "SELECT * FROM {$this->table} WHERE user_id = :user_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getByNim($nim) {
        $query = "SELECT * FROM {$this->table} WHERE nim = :nim";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':nim', $nim);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function findByIdWithUser($id) {
        $query = "SELECT m.*, u.username, u.is_active, u.created_at as tanggal_daftar
                  FROM {$this->table} m
                  JOIN users u ON m.user_id = u.id
                  WHERE m.id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getNilaiMatkul($mahasiswa_id) {
        $query = "SELECT nm.*, mk.kode, mk.nama_matkul, mk.kriteria_id, k.nama_kriteria
                  FROM nilai_matkul nm
                  JOIN mata_kuliah mk ON nm.matkul_id = mk.id
                  LEFT JOIN kriteria k ON mk.kriteria_id = k.id
                  WHERE nm.mahasiswa_id = :mahasiswa_id
                  ORDER BY mk.kode";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':mahasiswa_id', $mahasiswa_id);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function saveNilaiMatkul($mahasiswa_id, $matkul_id, $nilai) {
        // Calculate grade
        $grade = $this->calculateGrade($nilai);

        $query = "INSERT INTO nilai_matkul (mahasiswa_id, matkul_id, nilai, grade) 
                 VALUES (:mahasiswa_id, :matkul_id, :nilai, :grade)
                 ON DUPLICATE KEY UPDATE nilai = :nilai, grade = :grade";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':mahasiswa_id', $mahasiswa_id);
        $stmt->bindParam(':matkul_id', $matkul_id);
        $stmt->bindParam(':nilai', $nilai);
        $stmt->bindParam(':grade', $grade);
        return $stmt->execute();
    }

    public function getNilaiPerKriteria($mahasiswa_id) {
        $query = "SELECT k.id as kriteria_id, k.nama_kriteria,
                  AVG(nm.nilai) as rata_rata_nilai,
                  COUNT(nm.id) as jumlah_matkul
                  FROM kriteria k
                  LEFT JOIN mata_kuliah mk ON k.id = mk.kriteria_id
                  LEFT JOIN nilai_matkul nm ON mk.id = nm.matkul_id AND nm.mahasiswa_id = :mahasiswa_id
                  WHERE k.is_active = 1
                  GROUP BY k.id
                  ORDER BY k.kode";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':mahasiswa_id', $mahasiswa_id);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getHasilRekomendasi($mahasiswa_id) {
        $query = "SELECT hr.*, at.kode, at.nama_tema, at.deskripsi, at.icon
                  FROM hasil_rekomendasi hr
                  JOIN alternatif_tema at ON hr.alternatif_id = at.id
                  WHERE hr.mahasiswa_id = :mahasiswa_id
                  ORDER BY hr.ranking ASC";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':mahasiswa_id', $mahasiswa_id);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getRiwayatPerhitungan($mahasiswa_id) {
        $query = "SELECT * FROM riwayat_perhitungan 
                  WHERE mahasiswa_id = :mahasiswa_id 
                  ORDER BY created_at DESC 
                  LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':mahasiswa_id', $mahasiswa_id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function saveHasilRekomendasi($mahasiswa_id, $results) {
        try {
            $this->db->beginTransaction();

            // Delete old results
            $query = "DELETE FROM hasil_rekomendasi WHERE mahasiswa_id = :mahasiswa_id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':mahasiswa_id', $mahasiswa_id);
            $stmt->execute();

            // Insert new results
            $query = "INSERT INTO hasil_rekomendasi 
                     (mahasiswa_id, alternatif_id, total_score, ranking, keterangan) 
                     VALUES (:mahasiswa_id, :alternatif_id, :score, :ranking, :keterangan)";
            $stmt = $this->db->prepare($query);

            foreach ($results as $result) {
                $stmt->bindParam(':mahasiswa_id', $mahasiswa_id);
                $stmt->bindParam(':alternatif_id', $result['alternatif_id']);
                $stmt->bindParam(':score', $result['score']);
                $stmt->bindParam(':ranking', $result['ranking']);
                $stmt->bindParam(':keterangan', $result['keterangan']);
                $stmt->execute();
            }

            $this->db->commit();
            return true;

        } catch (PDOException $e) {
            $this->db->rollBack();
            return false;
        }
    }

    public function saveRiwayatPerhitungan($mahasiswa_id, $cr, $is_consistent, $detail) {
        $query = "INSERT INTO riwayat_perhitungan 
                 (mahasiswa_id, consistency_ratio, is_consistent, detail_perhitungan) 
                 VALUES (:mahasiswa_id, :cr, :is_consistent, :detail)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':mahasiswa_id', $mahasiswa_id);
        $stmt->bindParam(':cr', $cr);
        $stmt->bindParam(':is_consistent', $is_consistent);
        $detail_json = json_encode($detail);
        $stmt->bindParam(':detail', $detail_json);
        return $stmt->execute();
    }

    private function calculateGrade($nilai) {
        if ($nilai >= 85) return 'A';
        if ($nilai >= 80) return 'A-';
        if ($nilai >= 75) return 'B+';
        if ($nilai >= 70) return 'B';
        if ($nilai >= 65) return 'B-';
        if ($nilai >= 60) return 'C+';
        if ($nilai >= 55) return 'C';
        if ($nilai >= 50) return 'C-';
        if ($nilai >= 45) return 'D';
        return 'E';
    }

    public function getStatistikAngkatan() {
        $query = "SELECT angkatan, COUNT(*) as jumlah
                  FROM {$this->table}
                  GROUP BY angkatan
                  ORDER BY angkatan DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getStatistikMinat() {
        $query = "SELECT minat_utama, COUNT(*) as jumlah
                  FROM {$this->table}
                  WHERE minat_utama IS NOT NULL AND minat_utama != ''
                  GROUP BY minat_utama
                  ORDER BY jumlah DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
