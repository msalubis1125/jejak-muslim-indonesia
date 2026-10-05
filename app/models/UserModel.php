<?php

class UserModel extends Model {
    protected $table = 'users';

    public function findByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch();
    }

    public function authenticate($email, $password) {
        $user = $this->findByEmail($email);
        if ($user) {
            $hash = $user['password_hash'] ?? $user['password'] ?? '';
            if (password_verify($password, $hash)) {
                return $user;
            }
        }
        return false;
    }

    public function register($data) {
        if (isset($data['password'])) {
            $data['password_hash'] = password_hash($data['password'], PASSWORD_BCRYPT);
            unset($data['password']);
        }
        return $this->create($data);
    }

    public function updateProfile($id, $data) {
        unset($data['password'], $data['password_hash'], $data['role']); 
        return $this->update($id, $data);
    }

    public function changePassword($id, $newPassword) {
        $hashed = password_hash($newPassword, PASSWORD_BCRYPT);
        return $this->update($id, ['password_hash' => $hashed]);
    }

    public function findByRole($role) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE role = :role ORDER BY nama ASC");
        $stmt->execute(['role' => $role]);
        return $stmt->fetchAll();
    }

    public function findTakmirByMasjid($masjidId) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE masjid_id = :masjid_id AND role = 'takmir' ORDER BY nama ASC");
        $stmt->execute(['masjid_id' => $masjidId]);
        return $stmt->fetchAll();
    }

    public function setActive($id, $active) {
        return $this->update($id, ['is_active' => $active ? 1 : 0]);
    }

    public function incrementLoginAttempts($id) {
        $stmt = $this->db->prepare("UPDATE {$this->table} SET login_attempts = login_attempts + 1 WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function resetLoginAttempts($id) {
        $stmt = $this->db->prepare("UPDATE {$this->table} SET login_attempts = 0, locked_until = NULL WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function lockAccount($id, $minutes = 15) {
        $lockedUntil = date('Y-m-d H:i:s', strtotime("+$minutes minutes"));
        $stmt = $this->db->prepare("UPDATE {$this->table} SET locked_until = :locked_until WHERE id = :id");
        return $stmt->execute(['locked_until' => $lockedUntil, 'id' => $id]);
    }

    public function isLocked($id) {
        $stmt = $this->db->prepare("SELECT locked_until FROM {$this->table} WHERE id = :id AND locked_until > NOW()");
        $stmt->execute(['id' => $id]);
        return (bool) $stmt->fetch();
    }

    public function findById($id) {
        $user = parent::findById($id);
        if ($user) {
            $user['status'] = (!empty($user['is_active'])) ? 'active' : 'inactive';
        }
        return $user;
    }

    public function getAllFiltered($role = null, $search = null) {
        $sql = "SELECT u.*, m.nama as nama_masjid 
                FROM {$this->table} u 
                LEFT JOIN masjid m ON u.masjid_id = m.id 
                WHERE 1=1";
        $params = [];
        if (!empty($role)) {
            $sql .= " AND u.role = :role";
            $params['role'] = $role;
        }
        if (!empty($search)) {
            $sql .= " AND (u.nama LIKE :s1 OR u.email LIKE :s2)";
            $params['s1'] = "%$search%";
            $params['s2'] = "%$search%";
        }
        $sql .= " ORDER BY u.id DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $rows = $stmt->fetchAll();
        foreach ($rows as &$row) {
            $row['status'] = (!empty($row['is_active'])) ? 'active' : 'inactive';
        }
        return $rows;
    }

    public function updateStatus($id, $status) {
        $isActive = ($status === 'active' || $status === 1 || $status === true || $status === '1') ? 1 : 0;
        return $this->update($id, ['is_active' => $isActive]);
    }

    public function updatePassword($id, $hashedPassword) {
        return $this->update($id, ['password_hash' => $hashedPassword]);
    }
}

