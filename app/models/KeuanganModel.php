<?php

class KeuanganModel extends Model {
    protected $table = 'keuangan';

    public function findByMasjid($masjidId, $filters = []) {
        $sql = "SELECT k.*, kas.nama_kas, kat.nama as nama_kategori 
                FROM {$this->table} k 
                LEFT JOIN kas ON k.kas_id = kas.id 
                LEFT JOIN kategori_keuangan kat ON k.kategori_id = kat.id 
                WHERE k.masjid_id = :masjid_id AND k.is_deleted = 0";
        $params = ['masjid_id' => $masjidId];

        if (isset($filters['kas_id']) && $filters['kas_id'] !== '') {
            $sql .= " AND k.kas_id = :kas_id";
            $params['kas_id'] = $filters['kas_id'];
        }
        if (isset($filters['kategori_id']) && $filters['kategori_id'] !== '') {
            $sql .= " AND k.kategori_id = :kategori_id";
            $params['kategori_id'] = $filters['kategori_id'];
        }
        if (isset($filters['tipe']) && $filters['tipe'] !== '') {
            $sql .= " AND k.tipe = :tipe";
            $params['tipe'] = $filters['tipe'];
        }
        if (isset($filters['tanggal_dari']) && $filters['tanggal_dari'] !== '') {
            $sql .= " AND k.tanggal >= :tanggal_dari";
            $params['tanggal_dari'] = $filters['tanggal_dari'];
        }
        if (isset($filters['tanggal_sampai']) && $filters['tanggal_sampai'] !== '') {
            $sql .= " AND k.tanggal <= :tanggal_sampai";
            $params['tanggal_sampai'] = $filters['tanggal_sampai'];
        }

        $sql .= " ORDER BY k.tanggal DESC, k.id DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function findByIdAndMasjid($id, $masjidId) {
        $sql = "SELECT k.*, kas.nama_kas, kat.nama as nama_kategori 
                FROM {$this->table} k 
                LEFT JOIN kas ON k.kas_id = kas.id 
                LEFT JOIN kategori_keuangan kat ON k.kategori_id = kat.id 
                WHERE k.id = :id AND (k.masjid_id = :masjid_id OR :masjid_id IS NULL) AND k.is_deleted = 0";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id, 'masjid_id' => $masjidId]);
        return $stmt->fetch();
    }

    public function getKasList($masjidId) {
        require_once ROOT_PATH . '/app/models/KasModel.php';
        $kasModel = new KasModel();
        return $kasModel->findByMasjid($masjidId);
    }

    public function getKategoriList() {
        $stmt = $this->db->query("SELECT * FROM kategori_keuangan ORDER BY tipe ASC, nama ASC");
        return $stmt->fetchAll();
    }

    public function getPaginated($masjidId, $kasId = null, $kategoriId = null, $tipe = null, $page = 1, $limit = 15) {
        $offset = ($page - 1) * $limit;
        $sqlWhere = " WHERE k.masjid_id = :masjid_id AND k.is_deleted = 0";
        $params = ['masjid_id' => $masjidId];

        if (!empty($kasId)) {
            $sqlWhere .= " AND k.kas_id = :kas_id";
            $params['kas_id'] = $kasId;
        }
        if (!empty($kategoriId)) {
            $sqlWhere .= " AND k.kategori_id = :kategori_id";
            $params['kategori_id'] = $kategoriId;
        }
        if (!empty($tipe)) {
            $sqlWhere .= " AND k.tipe = :tipe";
            $params['tipe'] = $tipe;
        }

        // Count total
        $stmtCount = $this->db->prepare("SELECT COUNT(*) as total FROM {$this->table} k " . $sqlWhere);
        $stmtCount->execute($params);
        $total = (int)$stmtCount->fetchColumn();

        // Data query
        $sqlData = "SELECT k.*, kas.nama_kas, kat.nama as nama_kategori 
                    FROM {$this->table} k 
                    LEFT JOIN kas ON k.kas_id = kas.id 
                    LEFT JOIN kategori_keuangan kat ON k.kategori_id = kat.id "
                    . $sqlWhere . 
                    " ORDER BY k.tanggal DESC, k.id DESC LIMIT :limit OFFSET :offset";
        
        $stmtData = $this->db->prepare($sqlData);
        foreach ($params as $k => $v) {
            $stmtData->bindValue(":$k", $v);
        }
        $stmtData->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmtData->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmtData->execute();
        $data = $stmtData->fetchAll();

        return [
            'data' => $data,
            'total' => $total,
            'page' => $page,
            'limit' => $limit,
            'total_pages' => ceil($total / $limit)
        ];
    }

    public function createWithSaldo($data) {
        try {
            $this->beginTransaction();
            $id = $this->create($data);
            
            require_once ROOT_PATH . '/app/models/KasModel.php';
            $kasModel = new KasModel();
            $kasModel->updateSaldo($data['kas_id'], $data['nominal'], $data['tipe']);
            
            $this->commit();
            return $id;
        } catch (Exception $e) {
            $this->rollback();
            throw $e;
        }
    }

    public function updateWithSaldo($id, $arg2, $arg3 = null) {
        $data = is_array($arg2) ? $arg2 : $arg3;
        try {
            $this->beginTransaction();
            $oldData = $this->findById($id);
            
            if ($oldData) {
                require_once ROOT_PATH . '/app/models/KasModel.php';
                $kasModel = new KasModel();
                $oldKasId = is_array($oldData) ? $oldData['kas_id'] : $oldData->kas_id;
                $oldNominal = is_array($oldData) ? $oldData['nominal'] : $oldData->nominal;
                $oldTipe = is_array($oldData) ? $oldData['tipe'] : $oldData->tipe;

                // Reverse old
                $reverseTipe = ($oldTipe == 'masuk') ? 'keluar' : 'masuk';
                $kasModel->updateSaldo($oldKasId, $oldNominal, $reverseTipe);
                
                // Apply new
                $this->update($id, $data);
                $newKasId = $data['kas_id'] ?? $oldKasId;
                $newNominal = $data['nominal'] ?? $oldNominal;
                $newTipe = $data['tipe'] ?? $oldTipe;
                $kasModel->updateSaldo($newKasId, $newNominal, $newTipe);
            }
            
            $this->commit();
            return true;
        } catch (Exception $e) {
            $this->rollback();
            throw $e;
        }
    }

    public function softDeleteWithSaldo($id, $masjidId = null) {
        try {
            $this->beginTransaction();
            $oldData = $this->findById($id);
            
            if ($oldData) {
                $oldIsDeleted = is_array($oldData) ? ($oldData['is_deleted'] ?? 0) : ($oldData->is_deleted ?? 0);
                if ($oldIsDeleted == 0) {
                    require_once ROOT_PATH . '/app/models/KasModel.php';
                    $kasModel = new KasModel();
                    $oldKasId = is_array($oldData) ? $oldData['kas_id'] : $oldData->kas_id;
                    $oldNominal = is_array($oldData) ? $oldData['nominal'] : $oldData->nominal;
                    $oldTipe = is_array($oldData) ? $oldData['tipe'] : $oldData->tipe;

                    $reverseTipe = ($oldTipe == 'masuk') ? 'keluar' : 'masuk';
                    $kasModel->updateSaldo($oldKasId, $oldNominal, $reverseTipe);
                    $this->softDelete($id);
                }
            }
            
            $this->commit();
            return true;
        } catch (Exception $e) {
            $this->rollback();
            throw $e;
        }
    }

    public function getMonthlySummary($masjidId, $bulan, $tahun) {
        $stmt = $this->db->prepare("
            SELECT tipe, SUM(nominal) as total 
            FROM {$this->table} 
            WHERE masjid_id = :masjid_id 
              AND MONTH(tanggal) = :bulan 
              AND YEAR(tanggal) = :tahun 
              AND is_deleted = 0 
            GROUP BY tipe
        ");
        $stmt->execute([
            'masjid_id' => $masjidId,
            'bulan' => $bulan,
            'tahun' => $tahun
        ]);
        $rows = $stmt->fetchAll();
        $totalMasuk = 0;
        $totalKeluar = 0;
        foreach ($rows as $r) {
            $tipe = is_array($r) ? $r['tipe'] : $r->tipe;
            $total = is_array($r) ? $r['total'] : $r->total;
            if ($tipe === 'masuk') $totalMasuk = (float)$total;
            if ($tipe === 'keluar') $totalKeluar = (float)$total;
        }
        return [
            'total_masuk' => $totalMasuk,
            'total_keluar' => $totalKeluar,
            'saldo' => $totalMasuk - $totalKeluar
        ];
    }

    public function getMonthlyTransactions($masjidId, $bulan, $tahun) {
        $stmt = $this->db->prepare("
            SELECT k.*, kas.nama_kas, kat.nama as nama_kategori 
            FROM {$this->table} k 
            LEFT JOIN kas ON k.kas_id = kas.id 
            LEFT JOIN kategori_keuangan kat ON k.kategori_id = kat.id 
            WHERE k.masjid_id = :masjid_id 
              AND MONTH(k.tanggal) = :bulan 
              AND YEAR(k.tanggal) = :tahun 
              AND k.is_deleted = 0 
            ORDER BY k.tanggal ASC, k.id ASC
        ");
        $stmt->execute([
            'masjid_id' => $masjidId,
            'bulan' => $bulan,
            'tahun' => $tahun
        ]);
        return $stmt->fetchAll();
    }

    public function getLaporanBulanan($masjidId, $bulan, $tahun) {
        $stmt = $this->db->prepare("
            SELECT k.tipe, k.kategori_id, kat.nama as nama_kategori, SUM(k.nominal) as total 
            FROM {$this->table} k 
            LEFT JOIN kategori_keuangan kat ON k.kategori_id = kat.id 
            WHERE k.masjid_id = :masjid_id 
              AND MONTH(k.tanggal) = :bulan 
              AND YEAR(k.tanggal) = :tahun 
              AND k.is_deleted = 0 
            GROUP BY k.tipe, k.kategori_id, kat.nama
        ");
        $stmt->execute([
            'masjid_id' => $masjidId,
            'bulan' => $bulan,
            'tahun' => $tahun
        ]);
        return $stmt->fetchAll();
    }

    public function getLaporanTahunan($masjidId, $tahun) {
        $stmt = $this->db->prepare("
            SELECT MONTH(tanggal) as bulan, tipe, SUM(nominal) as total 
            FROM {$this->table} 
            WHERE masjid_id = :masjid_id 
              AND YEAR(tanggal) = :tahun 
              AND is_deleted = 0 
            GROUP BY MONTH(tanggal), tipe
        ");
        $stmt->execute([
            'masjid_id' => $masjidId,
            'tahun' => $tahun
        ]);
        return $stmt->fetchAll();
    }

    public function getTotalByTipe($masjidId, $tipe) {
        $stmt = $this->db->prepare("
            SELECT SUM(nominal) as total 
            FROM {$this->table} 
            WHERE masjid_id = :masjid_id AND tipe = :tipe AND is_deleted = 0
        ");
        $stmt->execute([
            'masjid_id' => $masjidId,
            'tipe' => $tipe
        ]);
        $result = $stmt->fetch();
        return $result ? (float)($result['total'] ?? 0) : 0;
    }

    public function getSummary($masjidId) {
        $masuk = $this->getTotalByTipe($masjidId, 'masuk');
        $keluar = $this->getTotalByTipe($masjidId, 'keluar');
        return [
            'total_masuk' => $masuk,
            'total_keluar' => $keluar,
            'saldo' => $masuk - $keluar
        ];
    }

    public function getRecentTransactions($masjidId, $limit = 10) {
        $sql = "SELECT k.*, kas.nama_kas, kat.nama as nama_kategori 
                FROM {$this->table} k 
                LEFT JOIN kas ON k.kas_id = kas.id 
                LEFT JOIN kategori_keuangan kat ON k.kategori_id = kat.id 
                WHERE k.is_deleted = 0";
        $params = [];
        if ($masjidId !== null) {
            $sql .= " AND k.masjid_id = :masjid_id";
            $params['masjid_id'] = $masjidId;
        }
        $sql .= " ORDER BY k.tanggal DESC, k.id DESC LIMIT :limit";

        $stmt = $this->db->prepare($sql);
        foreach ($params as $k => $v) {
            $stmt->bindValue(":$k", $v);
        }
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getRecent($masjidId = null, $limit = 5) {
        return $this->getRecentTransactions($masjidId, $limit);
    }

    public function getTotalSaldo($masjidId = null) {
        require_once ROOT_PATH . '/app/models/KasModel.php';
        $kasModel = new KasModel();
        if ($masjidId !== null) {
            return $kasModel->getTotalSaldo($masjidId);
        }
        $stmt = $this->db->query("SELECT SUM(saldo) as total FROM kas WHERE is_active = 1");
        $res = $stmt->fetch();
        return $res ? (float)($res['total'] ?? 0) : 0;
    }

    public function createKategori($data) {
        $nama = $data['nama'] ?? $data['nama_kategori'] ?? '';
        $tipe = $data['tipe'] ?? $data['tipe_default'] ?? 'pemasukan';
        if ($tipe === 'masuk') $tipe = 'pemasukan';
        if ($tipe === 'keluar') $tipe = 'pengeluaran';
        $masjidId = $data['masjid_id'] ?? null;
        $isDefault = $data['is_default'] ?? 1;

        $stmt = $this->db->prepare("INSERT INTO kategori_keuangan (nama, tipe, is_default, masjid_id) VALUES (:nama, :tipe, :is_default, :masjid_id)");
        return $stmt->execute([
            'nama' => $nama,
            'tipe' => $tipe,
            'is_default' => $isDefault,
            'masjid_id' => $masjidId
        ]);
    }

    public function updateKategori($id, $data) {
        $nama = $data['nama'] ?? $data['nama_kategori'] ?? '';
        $tipe = $data['tipe'] ?? $data['tipe_default'] ?? 'pemasukan';
        if ($tipe === 'masuk') $tipe = 'pemasukan';
        if ($tipe === 'keluar') $tipe = 'pengeluaran';

        $stmt = $this->db->prepare("UPDATE kategori_keuangan SET nama = :nama, tipe = :tipe WHERE id = :id");
        return $stmt->execute([
            'nama' => $nama,
            'tipe' => $tipe,
            'id' => $id
        ]);
    }

    public function deleteKategori($id) {
        $stmt = $this->db->prepare("DELETE FROM kategori_keuangan WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}

