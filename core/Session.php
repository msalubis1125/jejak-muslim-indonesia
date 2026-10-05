<?php
class Session {
    public static function start() {
        if (session_status() === PHP_SESSION_NONE) {
            session_set_cookie_params([
                'lifetime' => 0,
                'path' => '/',
                'domain' => '',
                'secure' => isset($_SERVER['HTTPS']),
                'httponly' => true,
                'samesite' => 'Lax'
            ]);
            session_start();
        }
    }

    public static function set($key, $value) {
        $_SESSION[$key] = $value;
    }

    public static function get($key, $default = null) {
        return $_SESSION[$key] ?? $default;
    }

    public static function has($key) {
        return isset($_SESSION[$key]);
    }

    public static function remove($key) {
        if (self::has($key)) {
            unset($_SESSION[$key]);
        }
    }

    public static function flash($key, $value = null) {
        if ($value !== null) {
            self::set('flash_' . $key, $value);
        } else {
            $val = self::get('flash_' . $key);
            self::remove('flash_' . $key);
            return $val;
        }
    }

    public static function regenerate() {
        session_regenerate_id(true);
    }

    public static function destroy() {
        session_unset();
        session_destroy();
    }

    public static function setUser($user) {
        self::set('user', $user);
    }

    public static function getUser() {
        return self::get('user');
    }

    public static function isLoggedIn() {
        return self::has('user');
    }
}
