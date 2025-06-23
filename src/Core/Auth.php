<?php

namespace App\Core;

class Auth
{
    public static function isLoggedIn(): bool
    {
        return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
    }

    public static function requireLogin(): void
    {
        if (!self::isLoggedIn()) {
            header('Location: /admin/login');
            exit;
        }
    }
}
