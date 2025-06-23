<?php

/**
 * Chybová stránka 404 - Stránka nenalezena
 * 
 * Zobrazuje chybovou stránku pro neexistující URL adresy.
 * Obsahuje uživatelsky přívětivou zprávu a navigaci zpět na hlavní stránku.
 * 
 * @package    EbookCatalog
 * @subpackage Views
 * @author     Radek Procházka
 * @version    1.0
 * 
 * Používané proměnné:
 * Žádné specifické proměnné nejsou potřeba pro tuto stránku.
 */
?>

<!-- Chybová zpráva 404 - kontejner pro chybový obsah -->
<div class="error-message">
    <!-- Hlavní nadpis chyby -->
    <h2>Chyba 404 - Stránka nenalezena</h2>

    <!-- Uživatelsky přívětivé vysvětlení chyby -->
    <p>Požadovaná stránka neexistuje.</p>

    <!-- Navigační odkaz zpět na hlavní stránku -->
    <p><a href="/">Zpět na hlavní stránku</a></p>
</div>