<?php
class Auth {
    public static function check() {
        return Session::isLoggedIn();
    }

    public static function user() {
        return Session::getUser();
    }

    public static function role() {
        $user = self::user();
        if (!$user) return null;
        return is_array($user) ? ($user['role'] ?? null) : ($user->role ?? null);
    }

    public static function isSuperAdmin() {
        return self::role() === ROLE_SUPER_ADMIN;
    }

    public static function isTakmir() {
        return self::role() === ROLE_TAKMIR;
    }

    public static function isJamaah() {
        return self::role() === ROLE_JAMAAH;
    }

    public static function requireLogin() {
        if (!self::check()) {
            header('Location: ' . BASE_URL . '/auth/login');
            exit;
        }
    }

    public static function requireRole($role) {
        self::requireLogin();
        if (self::role() !== $role) {
            http_response_code(403);
            die('Forbidden: Anda tidak memiliki akses ke halaman ini.');
        }
    }

    public static function requireRoles($roles) {
        self::requireLogin();
        if (!in_array(self::role(), $roles)) {
            http_response_code(403);
            die('Forbidden: Anda tidak memiliki akses ke halaman ini.');
        }
    }

    public static function getMasjidId() {
        $user = self::user();
        if (!$user) return null;
        return is_array($user) ? ($user['masjid_id'] ?? null) : ($user->masjid_id ?? null);
    }

    public static function name() {
        $user = self::user();
        if (!$user) return 'User';
        return is_array($user) ? ($user['nama'] ?? 'User') : ($user->nama ?? 'User');
    }

    public static function email() {
        $user = self::user();
        if (!$user) return '';
        return is_array($user) ? ($user['email'] ?? '') : ($user->email ?? '');
    }
}
