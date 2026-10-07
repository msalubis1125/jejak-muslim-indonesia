<?php

class MasjidModel extends Model {
    protected $table = 'masjid';

    public function findVerified() {
        $stmt = $this->db->query("SELECT * FROM {$this->table} WHERE status = 'verified' AND is_deleted = 0 ORDER BY nama ASC");
        return $stmt->fetchAll();
    }

    public function findBySlug($slug) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE slug = :slug AND is_deleted = 0");
        $stmt->execute(['slug' => $slug]);
        return $stmt->fetch();
    }

    public function findBySlugOrId($identifier) {
        if (is_numeric($identifier)) {
            $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE (id = :id OR slug = :slug) AND is_deleted = 0 LIMIT 1");
            $stmt->execute(['id' => $identifier, 'slug' => (string)$identifier]);
            $res = $stmt->fetch();
            if ($res) {
                return $res;
            }
        }
        return $this->findBySlug($identifier);
    }

    public function findByKota($kota) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE kota = :kota AND status = 'verified' AND is_deleted = 0 ORDER BY nama ASC");
        $stmt->execute(['kota' => $kota]);
        return $stmt->fetchAll();
    }

    public function findPending() {
        $stmt = $this->db->query("SELECT * FROM {$this->table} WHERE status = 'pending' AND is_deleted = 0 ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }

    public function findNearby($lat, $lng, $radiusKm = 25) {
        $sql = "
            SELECT *, 
            ( 6371 * acos( cos( radians(:lat) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(:lng) ) + sin( radians(:lat) ) * sin( radians( latitude ) ) ) ) AS distance 
            FROM {$this->table} 
            WHERE status = 'verified' AND is_deleted = 0 AND latitude IS NOT NULL AND longitude IS NOT NULL
            HAVING distance <= :radius 
            ORDER BY distance ASC
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'lat' => $lat,
            'lng' => $lng,
            'radius' => $radiusKm
        ]);
        return $stmt->fetchAll();
    }

    public function getNearby($lat, $lng, $radiusKm = 25) {
        return $this->findNearby($lat, $lng, $radiusKm);
    }

    public function search($keyword) {
        $keyword = "%{$keyword}%";
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE (nama LIKE :k1 OR alamat LIKE :k2 OR kota LIKE :k3) AND status = 'verified' AND is_deleted = 0 ORDER BY nama ASC");
        $stmt->execute(['k1' => $keyword, 'k2' => $keyword, 'k3' => $keyword]);
        return $stmt->fetchAll();
    }

    public function verify($id) {
        return $this->update($id, ['status' => 'verified']);
    }

    public function suspend($id) {
        return $this->update($id, ['status' => 'suspended']);
    }

    public function getFasilitas($id) {
        $stmt = $this->db->prepare("SELECT nama_fasilitas FROM fasilitas_masjid WHERE masjid_id = :masjid_id AND tersedia = 1");
        $stmt->execute(['masjid_id' => $id]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function getFasilitasIds($id) {
        return $this->getFasilitas($id);
    }

    public function getAllFasilitasMaster() {
        require_once ROOT_PATH . '/app/models/FasilitasModel.php';
        $fasModel = new FasilitasModel();
        return $fasModel->getDefaultFasilitas();
    }

    public function syncFasilitas($id, $fasilitasArray) {
        require_once ROOT_PATH . '/app/models/FasilitasModel.php';
        $fasModel = new FasilitasModel();
        return $fasModel->syncFasilitas($id, $fasilitasArray);
    }

    public function getGaleri($id) {
        $stmt = $this->db->prepare("SELECT * FROM galeri_masjid WHERE masjid_id = :masjid_id ORDER BY urutan ASC, created_at DESC");
        $stmt->execute(['masjid_id' => $id]);
        return $stmt->fetchAll();
    }

    public function getGaleriByIdAndMasjid($fotoId, $masjidId) {
        $stmt = $this->db->prepare("SELECT * FROM galeri_masjid WHERE id = :id AND masjid_id = :masjid_id LIMIT 1");
        $stmt->execute(['id' => $fotoId, 'masjid_id' => $masjidId]);
        return $stmt->fetch();
    }

    public function addGaleri($masjidId, $filePath, $caption = '') {
        $stmtUrutan = $this->db->prepare("SELECT COALESCE(MAX(urutan), 0) + 1 AS next_urutan FROM galeri_masjid WHERE masjid_id = :masjid_id");
        $stmtUrutan->execute(['masjid_id' => $masjidId]);
        $row = $stmtUrutan->fetch();
        $urutan = $row ? (int)$row['next_urutan'] : 1;

        $stmt = $this->db->prepare("INSERT INTO galeri_masjid (masjid_id, file_path, caption, urutan, created_at) VALUES (:masjid_id, :file_path, :caption, :urutan, NOW())");
        return $stmt->execute([
            'masjid_id' => $masjidId,
            'file_path' => $filePath,
            'caption'   => $caption,
            'urutan'    => $urutan
        ]);
    }

    public function deleteGaleri($masjidId, $fotoId) {
        $photo = $this->getGaleriByIdAndMasjid($fotoId, $masjidId);
        if ($photo) {
            $filePath = ROOT_PATH . '/public/uploads/masjid/' . $photo['file_path'];
            if (file_exists($filePath) && is_file($filePath)) {
                @unlink($filePath);
            }
            $stmt = $this->db->prepare("DELETE FROM galeri_masjid WHERE id = :id AND masjid_id = :masjid_id");
            return $stmt->execute(['id' => $fotoId, 'masjid_id' => $masjidId]);
        }
        return false;
    }

    public function getWithFasilitas($id) {
        $masjid = $this->findById($id);
        if ($masjid) {
            $masjid['fasilitas'] = $this->getFasilitas($id);
        }
        return $masjid;
    }

    public function getVerifiedWithDonasiInfo() {
        $stmt = $this->db->query("
            SELECT m.*, 
                   (SELECT COUNT(*) FROM rekening r WHERE r.masjid_id = m.id AND r.is_active = 1) as total_rekening,
                   (SELECT qris_path FROM rekening r WHERE r.masjid_id = m.id AND r.qris_path IS NOT NULL AND r.qris_path != '' LIMIT 1) as qris_path
            FROM {$this->table} m
            WHERE m.status = 'verified' AND m.is_deleted = 0
            ORDER BY m.nama ASC
        ");
        return $stmt->fetchAll();
    }

    public function getVerifiedPaginated($search = '', $kota = '', $page = 1, $limit = 10) {
        $offset = ($page - 1) * $limit;
        $sql = "SELECT * FROM {$this->table} WHERE status = 'verified' AND is_deleted = 0";
        $params = [];

        if (!empty($search)) {
            $sql .= " AND (nama LIKE :search OR alamat LIKE :search2)";
            $params['search'] = "%{$search}%";
            $params['search2'] = "%{$search}%";
        }
        if (!empty($kota)) {
            $sql .= " AND kota = :kota";
            $params['kota'] = $kota;
        }

        $sql .= " ORDER BY nama ASC LIMIT :limit OFFSET :offset";
        $stmt = $this->db->prepare($sql);
        foreach ($params as $k => $v) {
            $stmt->bindValue(":$k", $v);
        }
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function generateSlug($nama) {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $nama)));
        $originalSlug = $slug;
        $count = 1;
        while ($this->findBySlug($slug)) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }
        return $slug;
    }

    public function countByStatus($status = null) {
        if ($status !== null) {
            $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM {$this->table} WHERE status = :status AND is_deleted = 0");
            $stmt->execute(['status' => $status]);
            $res = $stmt->fetch();
            return $res ? (int)($res['count'] ?? 0) : 0;
        }
        $stmt = $this->db->query("SELECT status, COUNT(*) as count FROM {$this->table} WHERE is_deleted = 0 GROUP BY status");
        return $stmt->fetchAll();
    }

    public function getAllMarkers() {
        $stmt = $this->db->query("SELECT id, nama, slug, latitude, longitude, foto_utama, status, buka_24jam FROM {$this->table} WHERE status = 'verified' AND is_deleted = 0 AND latitude IS NOT NULL AND longitude IS NOT NULL");
        $markers = $stmt->fetchAll();
        foreach ($markers as &$marker) {
            $marker['fasilitas'] = $this->getFasilitas($marker['id']);
        }
        return $markers;
    }

    public function findAllVerifiedWithFasilitas() {
        return $this->getAllMarkers();
    }

    public function getFiltered($filters) {
        $sql = "SELECT * FROM {$this->table} WHERE status = 'verified' AND is_deleted = 0";
        $params = [];
        
        if (isset($filters['buka_24jam']) && $filters['buka_24jam'] !== '') {
            $sql .= " AND buka_24jam = :buka_24jam";
            $params['buka_24jam'] = $filters['buka_24jam'];
        }
        if (isset($filters['kota']) && !empty($filters['kota'])) {
            $sql .= " AND kota = :kota";
            $params['kota'] = $filters['kota'];
        }
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function getByStatus($status) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE status = :status AND is_deleted = 0 ORDER BY created_at DESC");
        $stmt->execute(['status' => $status]);
        return $stmt->fetchAll();
    }

    public function getAll($limit = null, $offset = 0) {
        $sql = "SELECT * FROM {$this->table} WHERE is_deleted = 0 ORDER BY id DESC";
        if ($limit !== null) {
            $sql .= " LIMIT " . (int)$limit . " OFFSET " . (int)$offset;
        }
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    public function updateStatus($id, $status) {
        return $this->update($id, ['status' => $status]);
    }

    public function getNationalStats() {
        $sql = "SELECT 
                    COUNT(DISTINCT NULLIF(provinsi, '')) as total_provinsi, 
                    COUNT(DISTINCT NULLIF(kota, '')) as total_kota, 
                    COALESCE(SUM(kapasitas), 0) as total_kapasitas 
                FROM {$this->table} 
                WHERE is_deleted = 0";
        $stmt = $this->db->query($sql);
        return $stmt->fetch() ?: ['total_provinsi' => 0, 'total_kota' => 0, 'total_kapasitas' => 0];
    }
}

