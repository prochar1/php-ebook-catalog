<?php
// Nastavení databáze pro MariaDB / MySQL
define('DB_DRIVER', 'mysql');
define('DB_HOST', 'db');
define('DB_NAME', 'ebook');
define('DB_USER', 'ebook');
define('DB_PASS', 'ebook');
define('DB_CHARSET', 'utf8mb4');

// Administrátorské heslo
define('ADMIN_PASSWORD', 'superTajneHeslo123');

// Spuštění session pro správu přihlášení
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Nastavení pro zobrazení chyb (pouze pro vývoj!)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
