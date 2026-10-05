<?php

class PendaftaranKegiatanModel extends Model {
    protected $table = 'pendaftaran_kegiatan';

    public function findByKegiatan($kegiatanId) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE kegiatan_id = :kegiatan_id ORDER BY created_at DESC");
        $stmt->execute(['kegiatan_id' => $kegiatanId]);
        return $stmt->fetchAll();
    }

    public function findByUser($userId) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE user_id = :user_id ORDER BY created_at DESC");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll();
    }

    public function isRegistered($kegiatanId, $userId) {
        $stmt = $this->db->prepare("SELECT id FROM {$this->table} WHERE kegiatan_id = :kegiatan_id AND user_id = :user_id");
        $stmt->execute(['kegiatan_id' => $kegiatanId, 'user_id' => $userId]);
        return (bool)$stmt->fetch();
    }

    public function countByKegiatan($kegiatanId) {
        $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM {$this->table} WHERE kegiatan_id = :kegiatan_id AND status != 'cancelled'");
        $stmt->execute(['kegiatan_id' => $kegiatanId]);
        $result = $stmt->fetch();
        return $result ? (int)($result['total'] ?? 0) : 0;
    }

    public function register($data) {
        try {
            $this->beginTransaction();
            
            if (!empty($data['user_id']) && $this->isRegistered($data['kegiatan_id'], $data['user_id'])) {
                throw new Exception("Anda sudah terdaftar untuk kegiatan ini.");
            }
            
            $kegiatanModel = new KegiatanModel();
            $kegiatan = $kegiatanModel->findById($data['kegiatan_id']);
            $kuota = is_array($kegiatan) ? ($kegiatan['kuota'] ?? 0) : ($kegiatan->kuota ?? 0);
            if ($kegiatan && $kuota > 0) {
                $currentCount = $this->countByKegiatan($data['kegiatan_id']);
                if ($currentCount >= $kuota) {
                    throw new Exception("Kuota pendaftaran untuk kegiatan ini sudah penuh.");
                }
            }
            
            $id = $this->create($data);
            $this->commit();
            return $id;
        } catch (Exception $e) {
            $this->rollback();
            throw $e;
        }
    }
}
