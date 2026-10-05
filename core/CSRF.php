<?php
class CSRF {
    public static function token() {
        if (!Session::has('_csrf_token')) {
            Session::set('_csrf_token', bin2hex(random_bytes(32)));
        }
        return Session::get('_csrf_token');
    }

    public static function generate() {
        return self::token();
    }

    public static function field() {
        return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars(self::token()) . '">';
    }

    public static function verify($token = null) {
        $submitted = $token ?? $_POST['csrf_token'] ?? $_POST['_csrf_token'] ?? '';
        $sessionToken = Session::get('_csrf_token');
        if (empty($submitted) || empty($sessionToken) || !hash_equals($sessionToken, $submitted)) {
            return false;
        }
        return true;
    }
}
