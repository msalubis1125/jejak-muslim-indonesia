<?php

class KategoriKeuanganModel extends Model {
    protected $table = 'kategori_keuangan';

    public function findByMasjid($masjidId) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE (masjid_id = :masjid_id OR is_default = 1) ORDER BY tipe, nama");
        $stmt->execute(['masjid_id' => $masjidId]);
        return $stmt->fetchAll();
    }

    public function findByTipe($tipe, $masjidId = null) {
        $sql = "SELECT * FROM {$this->table} WHERE tipe = :tipe";
        $params = ['tipe' => $tipe];
        
        if ($masjidId !== null) {
            $sql .= " AND (masjid_id = :masjid_id OR is_default = 1)";
            $params['masjid_id'] = $masjidId;
        } else {
            $sql .= " AND is_default = 1";
        }
        $sql .= " ORDER BY nama ASC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function getDefaults() {
        $stmt = $this->db->query("SELECT * FROM {$this->table} WHERE is_default = 1 ORDER BY tipe, nama");
        return $stmt->fetchAll();
    }
}
