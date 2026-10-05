<?php

class AsetModel extends Model {
    protected $table = 'aset';

    public function getAllFiltered($masjidId = null, $kategori = null, $kondisi = null) {
        $sql = "SELECT a.*, m.nama as nama_masjid 
                FROM {$this->table} a 
                LEFT JOIN masjid m ON a.masjid_id = m.id 
                WHERE a.is_deleted = 0";
        $params = [];

        if ($masjidId !== null) {
            $sql .= " AND a.masjid_id = :masjid_id";
            $params['masjid_id'] = $masjidId;
        }
        if (!empty($kategori)) {
            $sql .= " AND a.kategori = :kategori";
            $params['kategori'] = $kategori;
        }
        if (!empty($kondisi)) {
            $sql .= " AND a.kondisi = :kondisi";
            $params['kondisi'] = $kondisi;
        }

        $sql .= " ORDER BY a.nama ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
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

    public function createAset($data) {
        $mapped = [
            'masjid_id' => $data['masjid_id'] ?? 1,
            'nama' => $data['nama'] ?? ($data['nama_aset'] ?? ''),
            'kategori' => $data['kategori'] ?? 'Inventaris',
            'jumlah' => !empty($data['jumlah']) ? (int)$data['jumlah'] : 1,
            'kondisi' => in_array($data['kondisi'] ?? '', ['baik', 'rusak_ringan', 'rusak_berat']) ? $data['kondisi'] : 'baik',
            'tanggal_perolehan' => !empty($data['tanggal_perolehan']) ? $data['tanggal_perolehan'] : (!empty($data['tanggal_diperoleh']) ? $data['tanggal_diperoleh'] : date('Y-m-d')),
            'keterangan' => $data['keterangan'] ?? '',
            'is_deleted' => 0
        ];
        return $this->create($mapped);
    }

    public function updateAset($id, $masjidId, $data) {
        $mapped = [];
        if (isset($data['nama']) || isset($data['nama_aset'])) {
            $mapped['nama'] = $data['nama'] ?? $data['nama_aset'];
        }
        if (isset($data['kategori'])) $mapped['kategori'] = $data['kategori'];
        if (isset($data['jumlah'])) $mapped['jumlah'] = (int)$data['jumlah'];
        if (isset($data['kondisi'])) $mapped['kondisi'] = $data['kondisi'];
        if (isset($data['tanggal_perolehan']) || isset($data['tanggal_diperoleh'])) {
            $mapped['tanggal_perolehan'] = $data['tanggal_perolehan'] ?? $data['tanggal_diperoleh'];
        }
        if (isset($data['keterangan'])) $mapped['keterangan'] = $data['keterangan'];

        if ($masjidId !== null) {
            $existing = $this->findByIdAndMasjid($id, $masjidId);
            if (!$existing) {
                throw new Exception("Aset tidak ditemukan.");
            }
        }
        return $this->update($id, $mapped);
    }

    public function softDeleteWithCheck($id, $masjidId = null) {
        if ($masjidId !== null) {
            $existing = $this->findByIdAndMasjid($id, $masjidId);
            if (!$existing) {
                throw new Exception("Aset tidak ditemukan.");
            }
        }
        return $this->softDelete($id);
    }

    public function getKategoriList($masjidId = null) {
        $sql = "SELECT DISTINCT kategori FROM {$this->table} WHERE is_deleted = 0 AND kategori IS NOT NULL AND kategori != ''";
        $params = [];
        if ($masjidId !== null) {
            $sql .= " AND masjid_id = :masjid_id";
            $params['masjid_id'] = $masjidId;
        }
        $sql .= " ORDER BY kategori ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function getSummaryStats($masjidId = null) {
        $sql = "SELECT 
                    COUNT(*) as total_item,
                    COALESCE(SUM(jumlah), 0) as total_unit,
                    SUM(CASE WHEN kondisi = 'baik' THEN jumlah ELSE 0 END) as baik_unit,
                    SUM(CASE WHEN kondisi = 'rusak_ringan' THEN jumlah ELSE 0 END) as rusak_ringan_unit,
                    SUM(CASE WHEN kondisi = 'rusak_berat' THEN jumlah ELSE 0 END) as rusak_berat_unit
                FROM {$this->table} 
                WHERE is_deleted = 0";
        $params = [];
        if ($masjidId !== null) {
            $sql .= " AND masjid_id = :masjid_id";
            $params['masjid_id'] = $masjidId;
        }
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch();
    }
}
