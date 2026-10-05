<?php

class JamaahModel extends Model {
    protected $table = 'users';

    public function getAllByMasjid($masjidId) {
        if ($masjidId) {
            $stmt = $this->db->prepare("SELECT id, nama, email, no_hp, is_active, created_at FROM {$this->table} WHERE role = 'jamaah' AND masjid_id = :masjid_id ORDER BY nama ASC");
            $stmt->execute(['masjid_id' => $masjidId]);
        } else {
            $stmt = $this->db->query("SELECT id, nama, email, no_hp, is_active, created_at FROM {$this->table} WHERE role = 'jamaah' ORDER BY nama ASC");
        }
        return $stmt->fetchAll();
    }

    public function countByMasjid($masjidId = null) {
        $sql = "SELECT COUNT(*) as total FROM {$this->table} WHERE role = 'jamaah'";
        $params = [];
        if ($masjidId) {
            $sql .= " AND masjid_id = :masjid_id";
            $params['masjid_id'] = $masjidId;
        }
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $res = $stmt->fetch();
        return $res ? (int)($res['total'] ?? 0) : 0;
    }
}
