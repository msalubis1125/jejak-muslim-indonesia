<?php

class RekeningModel extends Model {
    protected $table = 'rekening';

    public function findByMasjid($masjidId) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE masjid_id = :masjid_id ORDER BY is_active DESC, nama_bank ASC");
        $stmt->execute(['masjid_id' => $masjidId]);
        return $stmt->fetchAll();
    }

    public function findActive($masjidId) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE masjid_id = :masjid_id AND is_active = 1 ORDER BY nama_bank ASC");
        $stmt->execute(['masjid_id' => $masjidId]);
        return $stmt->fetchAll();
    }
}
