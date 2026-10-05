<?php
use PDO;

class LoginAttemptModel extends Model {
    protected $table = 'login_attempts';

    public function record($email, $ip, $success) {
        return $this->create([
            'email' => $email,
            'ip_address' => $ip,
            'success' => $success ? 1 : 0
        ]);
    }

    public function getRecentFailed($email, $minutes = 15) {
        $timeLimit = date('Y-m-d H:i:s', strtotime("-$minutes minutes"));
        $stmt = $this->db->prepare("
            SELECT COUNT(*) as total 
            FROM {$this->table} 
            WHERE email = :email 
              AND success = 0 
              AND created_at >= :time_limit
        ");
        $stmt->execute([
            'email' => $email,
            'time_limit' => $timeLimit
        ]);
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result->total ?? 0;
    }

    public function clearOld($days = 30) {
        $timeLimit = date('Y-m-d H:i:s', strtotime("-$days days"));
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE created_at < :time_limit");
        return $stmt->execute(['time_limit' => $timeLimit]);
    }
}
