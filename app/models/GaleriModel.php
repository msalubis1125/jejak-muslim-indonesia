<?php
use PDO;

class GaleriModel extends Model {
    protected $table = 'galeri_masjid';

    public function findByMasjid($masjidId) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE masjid_id = :masjid_id ORDER BY urutan ASC");
        $stmt->execute(['masjid_id' => $masjidId]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function addPhoto($masjidId, $filePath, $caption) {
        // Get max urutan
        $stmt = $this->db->prepare("SELECT MAX(urutan) as max_urutan FROM {$this->table} WHERE masjid_id = :masjid_id");
        $stmt->execute(['masjid_id' => $masjidId]);
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        $urutan = ($result->max_urutan ?? 0) + 1;

        return $this->create([
            'masjid_id' => $masjidId,
            'file_path' => $filePath,
            'caption' => $caption,
            'urutan' => $urutan
        ]);
    }

    public function deletePhoto($id) {
        $photo = $this->findById($id);
        if ($photo) {
            // Delete actual file if needed
            if (file_exists($photo->file_path)) {
                @unlink($photo->file_path);
            }
            $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = :id");
            return $stmt->execute(['id' => $id]);
        }
        return false;
    }

    public function updateOrder($id, $urutan) {
        $stmt = $this->db->prepare("UPDATE {$this->table} SET urutan = :urutan WHERE id = :id");
        return $stmt->execute(['urutan' => $urutan, 'id' => $id]);
    }
}
