<?php
class Model {
    protected $db;
    protected $table;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function query($sql, $params = []) {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public function findAll($conditions = [], $orderBy = '', $limit = '', $offset = '') {
        $sql = "SELECT * FROM {$this->table}";
        $params = [];
        
        if (!empty($conditions)) {
            $where = [];
            foreach ($conditions as $key => $value) {
                $where[] = "$key = :$key";
                $params[":$key"] = $value;
            }
            $sql .= " WHERE " . implode(' AND ', $where);
        }

        if (!empty($orderBy)) {
            $sql .= " ORDER BY $orderBy";
        }

        if (!empty($limit)) {
            $sql .= " LIMIT " . (int)$limit;
            if ($offset !== '') {
                $sql .= " OFFSET " . (int)$offset;
            }
        }

        return $this->query($sql, $params)->fetchAll();
    }

    public function findById($id) {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id LIMIT 1";
        return $this->query($sql, [':id' => $id])->fetch();
    }

    public function findOne($conditions = []) {
        $result = $this->findAll($conditions, '', 1);
        return $result ? $result[0] : null;
    }

    public function create($data) {
        $keys = array_keys($data);
        $fields = implode(', ', $keys);
        $placeholders = ':' . implode(', :', $keys);
        
        $sql = "INSERT INTO {$this->table} ($fields) VALUES ($placeholders)";
        $params = [];
        foreach ($data as $key => $value) {
            $params[":$key"] = $value;
        }

        $this->query($sql, $params);
        return $this->db->lastInsertId();
    }

    public function update($id, $data) {
        $set = [];
        $params = [':id' => $id];
        foreach ($data as $key => $value) {
            $set[] = "$key = :$key";
            $params[":$key"] = $value;
        }
        
        $sql = "UPDATE {$this->table} SET " . implode(', ', $set) . " WHERE id = :id";
        $this->query($sql, $params);
        return $this->db->lastInsertId();
    }

    public function softDelete($id) {
        return $this->update($id, ['is_deleted' => 1]);
    }

    public function restore($id) {
        return $this->update($id, ['is_deleted' => 0]);
    }

    public function count($conditions = []) {
        $sql = "SELECT COUNT(*) as total FROM {$this->table}";
        $params = [];
        
        if (!empty($conditions)) {
            $where = [];
            foreach ($conditions as $key => $value) {
                $where[] = "$key = :$key";
                $params[":$key"] = $value;
            }
            $sql .= " WHERE " . implode(' AND ', $where);
        }

        $result = $this->query($sql, $params)->fetch();
        if (!$result) return 0;
        return (int)(is_array($result) ? ($result['total'] ?? 0) : ($result->total ?? 0));
    }

    public function countAll($conditions = []) {
        return $this->count($conditions);
    }

    public function paginate($conditions, $page, $perPage, $orderBy = '') {
        $offset = ($page - 1) * $perPage;
        $data = $this->findAll($conditions, $orderBy, $perPage, $offset);
        $total = $this->count($conditions);
        
        return [
            'data' => $data,
            'total' => $total,
            'page' => $page,
            'per_page' => $perPage,
            'total_pages' => ceil($total / $perPage)
        ];
    }

    public function beginTransaction() {
        $this->db->beginTransaction();
    }

    public function commit() {
        $this->db->commit();
    }

    public function rollback() {
        $this->db->rollBack();
    }
}
