<?php

class DonasiModel extends Model {
    protected $table = 'rekening';

    public function getRekeningByMasjid($masjidId) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE masjid_id = :masjid_id ORDER BY is_active DESC, id ASC");
        $stmt->execute(['masjid_id' => $masjidId]);
        return $stmt->fetchAll();
    }

    public function getQrisByMasjid($masjidId) {
        $stmt = $this->db->prepare("SELECT qris_path FROM {$this->table} WHERE masjid_id = :masjid_id AND qris_path IS NOT NULL AND qris_path != '' LIMIT 1");
        $stmt->execute(['masjid_id' => $masjidId]);
        $res = $stmt->fetch();
        return $res ? ($res['qris_path'] ?? null) : null;
    }

    public function createRekening($data) {
        $mapped = [
            'masjid_id' => $data['masjid_id'],
            'nama_bank' => $data['bank'] ?? $data['nama_bank'] ?? '',
            'no_rekening' => $data['nomor_rekening'] ?? $data['no_rekening'] ?? '',
            'atas_nama' => $data['atas_nama'] ?? '',
            'is_active' => $data['is_active'] ?? 1
        ];
        return $this->create($mapped);
    }

    public function updateRekening($id, $masjidId, $data) {
        $mapped = [
            'nama_bank' => $data['bank'] ?? $data['nama_bank'] ?? '',
            'no_rekening' => $data['nomor_rekening'] ?? $data['no_rekening'] ?? '',
            'atas_nama' => $data['atas_nama'] ?? '',
            'is_active' => $data['is_active'] ?? 1
        ];
        $stmt = $this->db->prepare("UPDATE {$this->table} SET nama_bank = :bank, no_rekening = :norek, atas_nama = :atas_nama, is_active = :is_active WHERE id = :id AND masjid_id = :masjid_id");
        return $stmt->execute([
            'bank' => $mapped['nama_bank'],
            'norek' => $mapped['no_rekening'],
            'atas_nama' => $mapped['atas_nama'],
            'is_active' => $mapped['is_active'],
            'id' => $id,
            'masjid_id' => $masjidId
        ]);
    }

    public function deleteRekening($id, $masjidId = null) {
        $sql = "UPDATE {$this->table} SET is_active = 0 WHERE id = :id";
        $params = ['id' => $id];
        if ($masjidId !== null) {
            $sql .= " AND masjid_id = :masjid_id";
            $params['masjid_id'] = $masjidId;
        }
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

    public function updateQris($masjidId, $filename) {
        // Set on existing active rekening or create one placeholder
        $stmt = $this->db->prepare("SELECT id FROM {$this->table} WHERE masjid_id = :masjid_id LIMIT 1");
        $stmt->execute(['masjid_id' => $masjidId]);
        $rek = $stmt->fetch();
        if ($rek) {
            $stmtUpdate = $this->db->prepare("UPDATE {$this->table} SET qris_path = :path WHERE id = :id");
            return $stmtUpdate->execute(['path' => $filename, 'id' => $rek['id']]);
        } else {
            return $this->create([
                'masjid_id' => $masjidId,
                'nama_bank' => 'QRIS',
                'no_rekening' => '-',
                'atas_nama' => 'Masjid',
                'qris_path' => $filename,
                'is_active' => 1
            ]);
        }
    }

    public function removeQris($masjidId) {
        $stmt = $this->db->prepare("UPDATE {$this->table} SET qris_path = NULL WHERE masjid_id = :masjid_id");
        return $stmt->execute(['masjid_id' => $masjidId]);
    }
}
