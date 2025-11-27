<?php

class User extends Model {
    protected $table = 'users';

    public function getUserWithMahasiswa($user_id) {
        $query = "SELECT u.*, m.nim, m.angkatan, m.minat_utama 
                 FROM {$this->table} u
                 LEFT JOIN mahasiswa m ON u.id = m.user_id
                 WHERE u.id = :user_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getAllWithRole($role = null) {
        if ($role) {
            $query = "SELECT * FROM {$this->table} WHERE role = :role ORDER BY created_at DESC";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':role', $role);
        } else {
            $query = "SELECT * FROM {$this->table} ORDER BY created_at DESC";
            $stmt = $this->db->prepare($query);
        }
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function toggleActive($id) {
        $query = "UPDATE {$this->table} SET is_active = NOT is_active WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function countByRole() {
        $query = "SELECT role, COUNT(*) as total 
                 FROM {$this->table} 
                 GROUP BY role";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
