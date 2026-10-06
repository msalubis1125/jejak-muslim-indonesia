<?php
class RateLimiter {
    public static function check($email, $ip) {
        $db = Database::getInstance()->getConnection();
        
        $stmt = $db->prepare("SELECT locked_until FROM users WHERE email = :email");
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch();
        
        if ($user && !empty($user['locked_until']) && strtotime($user['locked_until']) > time()) {
            return false;
        }

        $timeLimit = date('Y-m-d H:i:s', time() - LOCKOUT_DURATION);
        $stmt = $db->prepare("SELECT COUNT(*) as attempts FROM login_attempts WHERE email = :email AND ip_address = :ip AND success = 0 AND attempted_at > :timeLimit");
        $stmt->execute([':email' => $email, ':ip' => $ip, ':timeLimit' => $timeLimit]);
        
        $result = $stmt->fetch();
        return ($result['attempts'] ?? 0) < MAX_LOGIN_ATTEMPTS;
    }

    public static function record($email, $ip, $success) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("INSERT INTO login_attempts (ip_address, email, success) VALUES (:ip, :email, :success)");
        $stmt->execute([':ip' => $ip, ':email' => $email, ':success' => $success ? 1 : 0]);
        
        if (!$success) {
            $timeLimit = date('Y-m-d H:i:s', time() - LOCKOUT_DURATION);
            $stmt = $db->prepare("SELECT COUNT(*) as attempts FROM login_attempts WHERE email = :email AND success = 0 AND attempted_at > :timeLimit");
            $stmt->execute([':email' => $email, ':timeLimit' => $timeLimit]);
            $row = $stmt->fetch();
            $attempts = (int)($row['attempts'] ?? 0);
            
            if ($attempts >= MAX_LOGIN_ATTEMPTS) {
                $lockUntil = date('Y-m-d H:i:s', time() + LOCKOUT_DURATION);
                $stmt = $db->prepare("UPDATE users SET login_attempts = :attempts, locked_until = :lockUntil WHERE email = :email");
                $stmt->execute([':attempts' => $attempts, ':lockUntil' => $lockUntil, ':email' => $email]);
            }
        }
    }

    public static function getRemainingLockTime($email) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT locked_until FROM users WHERE email = :email");
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch();
        
        if ($user && !empty($user['locked_until'])) {
            $diff = strtotime($user['locked_until']) - time();
            return $diff > 0 ? $diff : 0;
        }
        return 0;
    }

    public static function clearAttempts($email) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("UPDATE users SET login_attempts = 0, locked_until = NULL WHERE email = :email");
        $stmt->execute([':email' => $email]);
    }
}
