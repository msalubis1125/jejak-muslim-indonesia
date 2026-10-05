<?php

class PendaftaranModel extends Model {
    protected $table = 'pendaftaran_kegiatan';

    public function getByUser($userId) {
        $stmt = $this->db->prepare("
            SELECT pk.*, k.judul, k.tanggal_mulai, k.jam_mulai, k.lokasi_detail, m.nama as masjid_nama
            FROM {$this->table} pk
            JOIN kegiatan k ON pk.kegiatan_id = k.id
            JOIN masjid m ON k.masjid_id = m.id
            WHERE pk.user_id = :user_id
            ORDER BY pk.created_at DESC
        ");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll();
    }

    public function countByKegiatan($kegiatanId) {
        $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM {$this->table} WHERE kegiatan_id = :kegiatan_id AND status != 'cancelled'");
        $stmt->execute(['kegiatan_id' => $kegiatanId]);
        $row = $stmt->fetch();
        return $row ? (int)($row['total'] ?? 0) : 0;
    }

    public function getAllByKegiatan($kegiatanId) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE kegiatan_id = :kegiatan_id ORDER BY created_at DESC");
        $stmt->execute(['kegiatan_id' => $kegiatanId]);
        return $stmt->fetchAll();
    }
}
