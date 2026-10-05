<?php

class FasilitasModel extends Model {
    protected $table = 'fasilitas_masjid';

    public function findByMasjid($masjidId) {
        $stmt = $this->db->prepare("SELECT nama_fasilitas FROM {$this->table} WHERE masjid_id = :masjid_id AND tersedia = 1");
        $stmt->execute(['masjid_id' => $masjidId]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function syncFasilitas($masjidId, $fasilitasArray) {
        try {
            $this->beginTransaction();
            
            $stmtDel = $this->db->prepare("DELETE FROM {$this->table} WHERE masjid_id = :masjid_id");
            $stmtDel->execute(['masjid_id' => $masjidId]);
            
            if (!empty($fasilitasArray)) {
                $stmtIns = $this->db->prepare("INSERT INTO {$this->table} (masjid_id, nama_fasilitas, tersedia) VALUES (:masjid_id, :nama_fasilitas, 1)");
                foreach ($fasilitasArray as $fasilitas) {
                    $stmtIns->execute([
                        'masjid_id' => $masjidId,
                        'nama_fasilitas' => $fasilitas
                    ]);
                }
            }
            
            $this->commit();
            return true;
        } catch (Exception $e) {
            $this->rollback();
            throw $e;
        }
    }

    public function getDefaultFasilitas() {
        return [
            'Area Parkir Luas',
            'Pendingin Ruangan (AC)',
            'Ramah Disabilitas / Kursi Roda',
            'Tempat Wudhu Nyaman',
            'Toilet Bersih',
            'Ruang Laktasi / Ibu Menyusui',
            'Kantin / Koperasi Syariah',
            'Ambulans Gratis',
            'Perpustakaan Islam',
            'Wi-Fi Gratis',
            'Asrama / Penginapan Musafir'
        ];
    }
}

