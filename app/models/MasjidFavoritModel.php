<?php
use PDO;

class MasjidFavoritModel extends Model {
    protected $table = 'masjid_favorit';

    public function findByUser($userId) {
        $stmt = $this->db->prepare("
            SELECT mf.*, m.nama, m.kota, m.alamat, m.foto_utama 
            FROM {$this->table} mf 
            JOIN masjid m ON mf.masjid_id = m.id 
            WHERE mf.user_id = :user_id 
              AND m.is_deleted = 0 
            ORDER BY mf.created_at DESC
        ");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function toggle($userId, $masjidId) {
        if ($this->isFavorited($userId, $masjidId)) {
            $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE user_id = :user_id AND masjid_id = :masjid_id");
            return $stmt->execute(['user_id' => $userId, 'masjid_id' => $masjidId]);
        } else {
            return $this->create([
                'user_id' => $userId,
                'masjid_id' => $masjidId
            ]);
        }
    }

    public function isFavorited($userId, $masjidId) {
        $stmt = $this->db->prepare("SELECT id FROM {$this->table} WHERE user_id = :user_id AND masjid_id = :masjid_id");
        $stmt->execute(['user_id' => $userId, 'masjid_id' => $masjidId]);
        return (bool)$stmt->fetch();
    }

    public function countFavorites($masjidId) {
        $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM {$this->table} WHERE masjid_id = :masjid_id");
        $stmt->execute(['masjid_id' => $masjidId]);
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result->total ?? 0;
    }
}
