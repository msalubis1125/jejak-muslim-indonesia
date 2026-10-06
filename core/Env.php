<?php

class Env {
    private static $loaded = false;

    public static function load($path = null) {
        if (self::$loaded) {
            return;
        }

        $filePath = $path ?? (defined('ROOT_PATH') ? ROOT_PATH . '/.env' : __DIR__ . '/../.env');

        if (!file_exists($filePath) || !is_readable($filePath)) {
            self::$loaded = true;
            return;
        }

        $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '' || str_starts_with($line, '#') || str_starts_with($line, ';')) {
                continue;
            }

            $parts = explode('=', $line, 2);
            if (count($parts) === 2) {
                $key = trim($parts[0]);
                $val = trim($parts[1]);

                // Strip quotes if wrapped
                if ((str_starts_with($val, '"') && str_ends_with($val, '"')) ||
                    (str_starts_with($val, "'") && str_ends_with($val, "'"))) {
                    $val = substr($val, 1, -1);
                }

                if (!array_key_exists($key, $_SERVER) && !array_key_exists($key, $_ENV)) {
                    putenv("{$key}={$val}");
                    $_ENV[$key] = $val;
                    $_SERVER[$key] = $val;
                }
            }
        }

        self::$loaded = true;
    }

    public static function get($key, $default = null) {
        self::load();
        $value = getenv($key);
        if ($value === false) {
            $value = $_ENV[$key] ?? ($_SERVER[$key] ?? $default);
        }

        if ($value === null) {
            return $default;
        }

        // Cast boolean / null representations
        $lower = strtolower((string)$value);
        if ($lower === 'true' || $lower === '(true)') {
            return true;
        }
        if ($lower === 'false' || $lower === '(false)') {
            return false;
        }
        if ($lower === 'null' || $lower === '(null)') {
            return null;
        }
        if ($lower === 'empty' || $lower === '(empty)') {
            return '';
        }

        return $value;
    }
}
