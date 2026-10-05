<?php

class JamaahModel extends Model {
    protected $table = 'pendaftaran_kegiatan';

    public function getAllByMasjid($masjidId) {
        if ($masjidId) {
            $stmt = $this->db->prepare("
                SELECT pk.nama_peserta as nama, pk.no_hp, k.judul as kegiatan_terakhir, MAX(pk.created_at) as tanggal_terakhir, COUNT(pk.id) as total_partisipasi
                FROM pendaftaran_kegiatan pk
                JOIN kegiatan k ON pk.kegiatan_id = k.id
                WHERE k.masjid_id = :masjid_id
                GROUP BY pk.nama_peserta, pk.no_hp
                ORDER BY tanggal_terakhir DESC
            ");
            $stmt->execute(['masjid_id' => $masjidId]);
        } else {
            $stmt = $this->db->query("
                SELECT pk.nama_peserta as nama, pk.no_hp, k.judul as kegiatan_terakhir, MAX(pk.created_at) as tanggal_terakhir, COUNT(pk.id) as total_partisipasi
                FROM pendaftaran_kegiatan pk
                JOIN kegiatan k ON pk.kegiatan_id = k.id
                GROUP BY pk.nama_peserta, pk.no_hp
                ORDER BY tanggal_terakhir DESC
            ");
        }
        return $stmt->fetchAll();
    }

    public function countByMasjid($masjidId = null) {
        $sql = "
            SELECT COUNT(DISTINCT pk.no_hp) as total
            FROM pendaftaran_kegiatan pk
            JOIN kegiatan k ON pk.kegiatan_id = k.id
        ";
        $params = [];
        if ($masjidId) {
            $sql .= " WHERE k.masjid_id = :masjid_id";
            $params['masjid_id'] = $masjidId;
        }
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $res = $stmt->fetch();
        return $res ? (int)($res['total'] ?? 0) : 0;
    }
}
