<?php
// Nastavení databáze pro MariaDB / MySQL
define('DB_DRIVER', 'mysql'); // Změna na 'mysql' pro MariaDB
define('DB_HOST', 'db'); // Hostitel databáze (často 'localhost' nebo IP adresa)
define('DB_NAME', 'ebook'); // Název vaší databáze
define('DB_USER', 'ebook'); // Uživatelské jméno pro přístup do DB
define('DB_PASS', 'ebook'); // Heslo pro DB uživatele (pro XAMPP/MAMP 'root' bývá prázdné)
define('DB_CHARSET', 'utf8mb4'); // Znaková sada

// Administrátorské heslo
// POZOR: V reálné aplikaci byste NIKDY neměli ukládat heslo přímo do kódu takto.
// Použili byste hashování (např. password_hash()) a heslo v proměnné prostředí nebo jiném bezpečném úložišti.
// Pro účely tohoto zadání je to akceptovatelné.
define('ADMIN_PASSWORD', 'superTajneHeslo123');

// Spuštění session pro správu přihlášení
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Nastavení pro zobrazení chyb (pouze pro vývoj!)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
