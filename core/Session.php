<?php

namespace Sakuci;

/**
 * Pembungkus $_SESSION lengkap dengan flash data (sekali pakai),
 * old input, dan token CSRF.
 */
class Session
{
    public static function start(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            $https = ($_SERVER['HTTPS'] ?? 'off') !== 'off';

            ini_set('session.use_strict_mode', '1');   // tolak ID session yang tidak dikenal server
            session_set_cookie_params([
                'lifetime' => 0,
                'path'     => '/',
                'httponly' => true,                    // tidak bisa dibaca JavaScript
                'samesite' => 'Lax',                   // ikut membantu mencegah CSRF
                'secure'   => $https,
            ]);

            session_name(Config::get('app.session_name', 'batara_session'));
            session_start();
        }

        // Flash data yang dibuat di request sebelumnya dipindah ke "old",
        // supaya hanya bisa dibaca satu kali pada request ini.
        $_SESSION['_flash_old'] = $_SESSION['_flash_new'] ?? [];
        $_SESSION['_flash_new'] = [];

        if (empty($_SESSION['_token'])) {
            $_SESSION['_token'] = bin2hex(random_bytes(32));
        }
    }

    public static function token(): string
    {
        return $_SESSION['_token'] ?? '';
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        return $_SESSION[$key] ?? $default;
    }

    public static function put(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    public static function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    public static function forget(string $key): void
    {
        unset($_SESSION[$key]);
    }

    public static function all(): array
    {
        return $_SESSION ?? [];
    }

    public static function flush(): void
    {
        $_SESSION = [];
    }

    /** Simpan data untuk dibaca pada request berikutnya saja. */
    public static function flash(string $key, mixed $value): void
    {
        $_SESSION['_flash_new'][$key] = $value;
    }

    public static function getFlash(string $key, mixed $default = null): mixed
    {
        return $_SESSION['_flash_old'][$key] ?? $default;
    }

    public static function hasFlash(string $key): bool
    {
        return isset($_SESSION['_flash_old'][$key]);
    }

    /** Simpan seluruh input request untuk diisi ulang ke form. */
    public static function flashInput(array $input): void
    {
        static::flash('_old_input', $input);
    }

    public static function old(string $key, mixed $default = ''): mixed
    {
        $old = static::getFlash('_old_input', []);

        return $old[$key] ?? $default;
    }

    public static function errors(): MessageBag
    {
        $errors = static::getFlash('_errors', []);

        return $errors instanceof MessageBag ? $errors : new MessageBag((array) $errors);
    }
}

