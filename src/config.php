<?php

/**
 * Konfigurační soubor aplikace
 * 
 * Obsahuje všechna základní nastavení aplikace včetně databázového připojení,
 * administrátorských přístupů a vývojářských nastavení.
 * 
 * BEZPEČNOST: Tento soubor obsahuje citlivé údaje a nesmí být dostupný veřejně!
 * Ujistěte se, že je umístěn mimo document root nebo chráněn .htaccess souborem.
 * 
 * @package App\Config
 * @author  Radek Procházka
 * @version 1.0
 * @since   1.0
 */

// =============================================================================
// DATABÁZOVÉ PŘIPOJENÍ
// =============================================================================

/**
 * Typ databázového ovladače
 * Podporované hodnoty: 'mysql', 'pgsql', 'sqlite'
 */
define('DB_DRIVER', 'mysql');

/**
 * Hostname nebo IP adresa databázového serveru
 * Pro Docker kontejnery obvykle název služby (např. 'db')
 * Pro localhost obvykle '127.0.0.1' nebo 'localhost'
 */
define('DB_HOST', 'db');

/**
 * Název databáze pro e-book katalog
 * Databáze musí existovat před spuštěním aplikace
 */
define('DB_NAME', 'ebook');

/**
 * Uživatelské jméno pro připojení k databázi
 * Uživatel musí mít oprávnění CREATE, SELECT, INSERT, UPDATE, DELETE
 */
define('DB_USER', 'ebook');

/**
 * Heslo pro databázového uživatele
 * BEZPEČNOST: V produkci použijte silné heslo!
 */
define('DB_PASS', 'ebook');

/**
 * Kódování znaků pro databázové připojení
 * utf8mb4 podporuje všechny Unicode znaky včetně emoji
 */
define('DB_CHARSET', 'utf8mb4');

// =============================================================================
// ADMINISTRÁTORSKÉ NASTAVENÍ
// =============================================================================

/**
 * Heslo pro přístup do administrace
 * 
 * BEZPEČNOST: 
 * - V produkci změňte na silné heslo (min. 12 znaků)
 * - Použijte kombinaci velkých/malých písmen, číslic a speciálních znaků
 * - Pravidelně heslo měňte
 * - Zvažte implementaci hash-ovaného hesla místo plain textu
 * 
 * @todo Implementovat hash-ované heslo a salt pro lepší bezpečnost
 */
define('ADMIN_PASSWORD', 'superTajneHeslo123');

// =============================================================================
// SESSION MANAGEMENT
// =============================================================================

/**
 * Inicializace PHP session pro správu přihlášení
 * 
 * Kontrolujeme, zda session již není spuštěná, abychom předešli chybám.
 * Session se používá pro:
 * - Správu přihlášení administrátora
 * - Flash zprávy (úspěch/chyba)
 * - CSRF ochranu (v budoucích verzích)
 */
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// =============================================================================
// VÝVOJÁŘSKÉ NASTAVENÍ
// =============================================================================

/**
 * Nastavení zobrazování chyb
 * 
 * DŮLEŽITÉ: Tato nastavení jsou určena POUZE pro vývojové prostředí!
 * V produkci musí být vypnuta z bezpečnostních důvodů.
 * 
 * @warning V produkci nastavte display_errors na 0 a error_reporting na 0
 * @todo Implementovat detekci prostředí (dev/staging/production)
 */

// Zobrazování chyb na obrazovce (POUZE PRO VÝVOJ!)
ini_set('display_errors', 1);

// Zobrazování startup chyb (POUZE PRO VÝVOJ!)  
ini_set('display_startup_errors', 1);

// Reportování všech typů chyb (POUZE PRO VÝVOJ!)
error_reporting(E_ALL);

// =============================================================================
// APLIKAČNÍ KONSTANTY
// =============================================================================

/**
 * Verze aplikace
 * Používá se pro cache busting CSS/JS souborů a API versioning
 */
define('APP_VERSION', '1.0.0');

/**
 * Název aplikace
 * Zobrazuje se v title tag a navigaci
 */
define('APP_NAME', 'E-book Katalog');

/**
 * Vývojářský režim
 * V produkci nastavte na false
 */
define('DEBUG_MODE', true);

/**
 * Timezone aplikace
 * Nastavuje časové pásmo pro všechny datum/čas operace
 */
date_default_timezone_set('Europe/Prague');

// =============================================================================
// PRODUKČNÍ CHECKLIST
// =============================================================================

/**
 * PŘED NASAZENÍM DO PRODUKCE ZKONTROLUJTE:
 * 
 * ✅ DB_PASS - změňte na silné heslo
 * ✅ ADMIN_PASSWORD - změňte na silné heslo  
 * ✅ display_errors - nastavte na 0
 * ✅ display_startup_errors - nastavte na 0
 * ✅ error_reporting - nastavte na 0 nebo E_ERROR
 * ✅ DEBUG_MODE - nastavte na false
 * ✅ Ověřte, že config.php není přístupný z webu
 * ✅ Implementujte HTTPS
 * ✅ Nastavte správná oprávnění souborů (644 pro PHP, 755 pro složky)
 * 
 * DOPORUČENÁ VYLEPŠENÍ PRO PRODUKCI:
 * □ Implementovat environment variables místo konstant
 * □ Použít hash-ované heslo pro admina
 * □ Přidat CSRF ochranu
 * □ Implementovat rate limiting pro login
 * □ Přidat logging chyb do souboru
 * □ Nastavit HTTP security headers
 */

// =============================================================================
// KONEC KONFIGURACE
// =============================================================================
