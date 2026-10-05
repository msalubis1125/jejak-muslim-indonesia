<?php

class ArtikelModel extends Model {
    protected $table = 'artikel';

    public function findPublished($masjidId = null) {
        $sql = "SELECT * FROM {$this->table} WHERE is_published = 1 AND is_deleted = 0";
        $params = [];
        if ($masjidId !== null) {
            $sql .= " AND masjid_id = :masjid_id";
            $params['masjid_id'] = $masjidId;
        }
        $sql .= " ORDER BY published_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function findBySlug($slug) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE slug = :slug AND is_deleted = 0");
        $stmt->execute(['slug' => $slug]);
        return $stmt->fetch();
    }

    public function findByKategori($kategori, $masjidId = null) {
        $sql = "SELECT * FROM {$this->table} WHERE kategori = :kategori AND is_published = 1 AND is_deleted = 0";
        $params = ['kategori' => $kategori];
        if ($masjidId !== null) {
            $sql .= " AND masjid_id = :masjid_id";
            $params['masjid_id'] = $masjidId;
        }
        $sql .= " ORDER BY published_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function findRecent($limit = 5) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE is_published = 1 AND is_deleted = 0 ORDER BY published_at DESC LIMIT :limit");
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getRecent($limit = 5) {
        return $this->findRecent($limit);
    }

    public function getPublishedPaginated($kategori = '', $page = 1, $limit = 10) {
        $offset = ($page - 1) * $limit;
        $where = "WHERE is_published = 1 AND is_deleted = 0";
        $params = [];
        if (!empty($kategori)) {
            $where .= " AND kategori = :kategori";
            $params['kategori'] = $kategori;
        }
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} $where ORDER BY published_at DESC LIMIT :limit OFFSET :offset");
        foreach ($params as $k => $v) {
            $stmt->bindValue(":$k", $v);
        }
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function publish($id) {
        $stmt = $this->db->prepare("UPDATE {$this->table} SET is_published = 1, published_at = NOW() WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function unpublish($id) {
        $stmt = $this->db->prepare("UPDATE {$this->table} SET is_published = 0, published_at = NULL WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
