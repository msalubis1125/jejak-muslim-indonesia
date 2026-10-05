<?php

class KegiatanModel extends Model {
    protected $table = 'kegiatan';

    public function findByMasjid($masjidId) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE masjid_id = :masjid_id AND is_deleted = 0 ORDER BY tanggal_mulai DESC");
        $stmt->execute(['masjid_id' => $masjidId]);
        return $stmt->fetchAll();
    }

    public function getAllByMasjid($masjidId = null) {
        if ($masjidId !== null) {
            return $this->findByMasjid($masjidId);
        }
        $stmt = $this->db->query("SELECT k.*, m.nama as nama_masjid FROM {$this->table} k LEFT JOIN masjid m ON k.masjid_id = m.id WHERE k.is_deleted = 0 ORDER BY k.tanggal_mulai DESC");
        return $stmt->fetchAll();
    }

    public function findByIdAndMasjid($id, $masjidId = null) {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id AND is_deleted = 0";
        $params = ['id' => $id];
        if ($masjidId !== null) {
            $sql .= " AND masjid_id = :masjid_id";
            $params['masjid_id'] = $masjidId;
        }
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch();
    }

    public function updateAndCheckMasjid($id, $masjidId, $data) {
        if ($masjidId !== null) {
            $existing = $this->findByIdAndMasjid($id, $masjidId);
            if (!$existing) {
                throw new Exception("Kegiatan tidak ditemukan untuk masjid ini.");
            }
        }
        return $this->update($id, $data);
    }

    public function findUpcoming($masjidId = null) {
        $sql = "SELECT k.*, m.nama as masjid_nama FROM {$this->table} k JOIN masjid m ON k.masjid_id = m.id WHERE k.status = 'upcoming' AND k.tanggal_mulai >= CURDATE() AND k.is_deleted = 0";
        $params = [];
        if ($masjidId !== null) {
            $sql .= " AND k.masjid_id = :masjid_id";
            $params['masjid_id'] = $masjidId;
        }
        $sql .= " ORDER BY k.tanggal_mulai ASC, k.jam_mulai ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function getUpcomingAcrossVerified($limit = 5) {
        $stmt = $this->db->prepare("
            SELECT k.*, m.nama as masjid_nama, m.slug as masjid_slug 
            FROM {$this->table} k 
            JOIN masjid m ON k.masjid_id = m.id 
            WHERE m.status = 'verified' AND k.is_deleted = 0 AND k.tanggal_mulai >= CURDATE()
            ORDER BY k.tanggal_mulai ASC, k.jam_mulai ASC 
            LIMIT :limit
        ");
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getUpcomingByMasjid($masjidId, $limit = 5) {
        $stmt = $this->db->prepare("
            SELECT * FROM {$this->table} 
            WHERE masjid_id = :masjid_id AND is_deleted = 0 AND tanggal_mulai >= CURDATE()
            ORDER BY tanggal_mulai ASC, jam_mulai ASC 
            LIMIT :limit
        ");
        $stmt->bindValue(':masjid_id', (int)$masjidId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getUpcomingPaginated($masjidId = null, $page = 1, $limit = 10) {
        $offset = ($page - 1) * $limit;
        $sql = "SELECT k.*, m.nama as masjid_nama FROM {$this->table} k JOIN masjid m ON k.masjid_id = m.id WHERE k.is_deleted = 0 AND k.tanggal_mulai >= CURDATE()";
        $params = [];
        if ($masjidId !== null) {
            $sql .= " AND k.masjid_id = :masjid_id";
            $params['masjid_id'] = $masjidId;
        }
        $sql .= " ORDER BY k.tanggal_mulai ASC, k.jam_mulai ASC LIMIT :limit OFFSET :offset";
        $stmt = $this->db->prepare($sql);
        foreach ($params as $k => $v) {
            $stmt->bindValue(":$k", $v);
        }
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function findToday() {
        $stmt = $this->db->query("SELECT * FROM {$this->table} WHERE CURDATE() BETWEEN tanggal_mulai AND IFNULL(tanggal_selesai, tanggal_mulai) AND is_deleted = 0 ORDER BY jam_mulai ASC");
        return $stmt->fetchAll();
    }

    public function findBySlugOrId($identifier) {
        if (is_numeric($identifier)) {
            return $this->findById($identifier);
        }
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = :id AND is_deleted = 0");
        $stmt->execute(['id' => $identifier]);
        return $stmt->fetch();
    }

    public function updateStatus() {
        $stmt1 = $this->db->prepare("UPDATE {$this->table} SET status = 'ongoing' WHERE status = 'upcoming' AND CURDATE() >= tanggal_mulai AND is_deleted = 0");
        $stmt1->execute();
        
        $stmt2 = $this->db->prepare("UPDATE {$this->table} SET status = 'done' WHERE status = 'ongoing' AND CURDATE() > IFNULL(tanggal_selesai, tanggal_mulai) AND is_deleted = 0");
        $stmt2->execute();
    }

    public function getWithRegistrationCount($id) {
        $stmt = $this->db->prepare("
            SELECT k.*, (SELECT COUNT(*) FROM pendaftaran_kegiatan pk WHERE pk.kegiatan_id = k.id AND pk.status != 'cancelled') as jumlah_pendaftar
            FROM {$this->table} k
            WHERE k.id = :id AND k.is_deleted = 0
        ");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function countThisMonth($masjidId = null) {
        $sql = "SELECT COUNT(*) as total FROM {$this->table} WHERE MONTH(tanggal_mulai) = MONTH(CURDATE()) AND YEAR(tanggal_mulai) = YEAR(CURDATE()) AND is_deleted = 0";
        $params = [];
        if ($masjidId !== null) {
            $sql .= " AND masjid_id = :masjid_id";
            $params['masjid_id'] = $masjidId;
        }
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $res = $stmt->fetch();
        return $res ? (int)($res['total'] ?? 0) : 0;
    }
}
