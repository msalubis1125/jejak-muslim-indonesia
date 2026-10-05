<?php

class JadwalPetugasModel extends Model {
    protected $table = 'jadwal_petugas';

    public function findByMasjid($masjidId = null, $bulan = null, $tahun = null) {
        $sql = "SELECT j.*, m.nama as nama_masjid FROM {$this->table} j LEFT JOIN masjid m ON j.masjid_id = m.id WHERE 1=1";
        $params = [];
        
        if ($masjidId !== null) {
            $sql .= " AND j.masjid_id = :masjid_id";
            $params['masjid_id'] = $masjidId;
        }
        if ($bulan !== null) {
            $sql .= " AND MONTH(j.tanggal) = :bulan";
            $params['bulan'] = (int)$bulan;
        }
        if ($tahun !== null) {
            $sql .= " AND YEAR(j.tanggal) = :tahun";
            $params['tahun'] = (int)$tahun;
        }
        
        $sql .= " ORDER BY j.tanggal ASC, j.id ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function getMonthly($masjidId = null, $bulan = null, $tahun = null) {
        return $this->findByMasjid($masjidId, $bulan, $tahun);
    }

    public function findByIdAndMasjid($id, $masjidId = null) {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        $params = ['id' => $id];
        if ($masjidId !== null) {
            $sql .= " AND masjid_id = :masjid_id";
            $params['masjid_id'] = $masjidId;
        }
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch();
    }

    public function createFlexible($data) {
        $mapped = [
            'masjid_id' => $data['masjid_id'] ?? 1,
            'tanggal' => $data['tanggal'] ?? date('Y-m-d'),
            'tipe' => $data['tipe'] ?? (isset($data['khotib']) || (isset($data['peran']) && $data['peran'] === 'khotib') ? 'jumat' : 'harian'),
            'imam' => $data['imam'] ?? '',
            'muadzin' => $data['muadzin'] ?? '',
            'khotib' => $data['khotib'] ?? '',
            'catatan' => $data['catatan'] ?? ($data['keterangan'] ?? '')
        ];

        // Handle single role input if passed from simple form
        if (isset($data['peran']) && isset($data['nama_petugas'])) {
            $peran = strtolower($data['peran']);
            if (in_array($peran, ['imam', 'muadzin', 'khotib'])) {
                $mapped[$peran] = $data['nama_petugas'];
            }
        }

        return $this->create($mapped);
    }

    public function updateFlexible($id, $masjidId, $data) {
        $mapped = [];
        if (isset($data['tanggal'])) $mapped['tanggal'] = $data['tanggal'];
        if (isset($data['tipe'])) $mapped['tipe'] = $data['tipe'];
        if (isset($data['imam'])) $mapped['imam'] = $data['imam'];
        if (isset($data['muadzin'])) $mapped['muadzin'] = $data['muadzin'];
        if (isset($data['khotib'])) $mapped['khotib'] = $data['khotib'];
        if (isset($data['catatan'])) $mapped['catatan'] = $data['catatan'];

        if (isset($data['peran']) && isset($data['nama_petugas'])) {
            $peran = strtolower($data['peran']);
            if (in_array($peran, ['imam', 'muadzin', 'khotib'])) {
                $mapped[$peran] = $data['nama_petugas'];
            }
        }

        return $this->update($id, $mapped);
    }

    public function findToday($masjidId) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE masjid_id = :masjid_id AND tanggal = CURDATE()");
        $stmt->execute(['masjid_id' => $masjidId]);
        return $stmt->fetchAll();
    }

    public function findJumat($masjidId) {
        $stmt = $this->db->prepare("
            SELECT * FROM {$this->table} 
            WHERE masjid_id = :masjid_id 
              AND tipe = 'jumat' 
              AND tanggal >= CURDATE() 
            ORDER BY tanggal ASC 
            LIMIT 10
        ");
        $stmt->execute(['masjid_id' => $masjidId]);
        return $stmt->fetchAll();
    }

    public function findByDateRange($masjidId, $start, $end) {
        $stmt = $this->db->prepare("
            SELECT * FROM {$this->table} 
            WHERE masjid_id = :masjid_id 
              AND tanggal BETWEEN :start AND :end 
            ORDER BY tanggal ASC
        ");
        $stmt->execute([
            'masjid_id' => $masjidId,
            'start' => $start,
            'end' => $end
        ]);
        return $stmt->fetchAll();
    }
}
