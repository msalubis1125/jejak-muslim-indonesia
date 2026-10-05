<?php

class KasModel extends Model {
    protected $table = 'kas';

    public function findByMasjid($masjidId) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE masjid_id = :masjid_id AND is_active = 1 ORDER BY id ASC");
        $stmt->execute(['masjid_id' => $masjidId]);
        return $stmt->fetchAll();
    }

    public function updateSaldo($id, $amount, $tipe) {
        $operator = $tipe == 'masuk' ? '+' : '-';
        $stmt = $this->db->prepare("UPDATE {$this->table} SET saldo = saldo {$operator} :amount WHERE id = :id");
        return $stmt->execute(['amount' => $amount, 'id' => $id]);
    }

    public function getTotalSaldo($masjidId) {
        $stmt = $this->db->prepare("SELECT SUM(saldo) as total FROM {$this->table} WHERE masjid_id = :masjid_id AND is_active = 1");
        $stmt->execute(['masjid_id' => $masjidId]);
        $result = $stmt->fetch();
        return $result ? (float)($result['total'] ?? 0) : 0;
    }

    public function createDefaultKas($masjidId) {
        return $this->create([
            'masjid_id' => $masjidId,
            'nama_kas' => 'Kas Umum',
            'saldo' => 0,
            'deskripsi' => 'Kas utama operasional masjid',
            'is_active' => 1
        ]);
    }
}
