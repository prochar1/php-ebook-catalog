<?php

/**
 * Admin layout template
 * 
 * Základní layout pro všechny administrační stránky.
 * Obsahuje admin navigaci, hlavičku a prostor pro obsah.
 * Zobrazuje flash zprávy a je přizpůsoben pro admin rozhraní.
 * Používá Auth třídu pro kontrolu přihlášení.
 * 
 * @var string $content Obsah stránky (vložený template)
 * @var string $title Název stránky pro <title> tag
 * 
 * @package App\Views
 * @author  Radek Procházka
 * @version 1.0
 */

// Make sure the Auth class is available
use App\Core\Auth;
?>
<!DOCTYPE html>
<html lang="cs">

<head>
    <?php // Meta tagy a základní nastavení 
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Administrace') ?></title>

    <?php // CSS soubory pro admin rozhraní 
    ?>
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/admin.css">
</head>

<body>

    <?php // Hlavička s admin navigací 
    ?>
    <header>
        <h1><?= htmlspecialchars($title ?? 'Administrace') ?></h1>

        <!-- Admin navigační menu s podmíněným zobrazením dle přihlášení -->
        <nav class="admin-nav">
            <ul>
                <?php if (Auth::isLoggedIn()): ?>
                    <?php // Navigace pro přihlášeného administrátora 
                    ?>
                    <li><a href="/admin">Správa knih</a></li>
                    <li><a href="/">Návrat na web</a></li>
                    <li><a href="/admin/logout">Odhlásit se</a></li>
                <?php else: ?>
                    <?php // Navigace pro nepřihlášeného uživatele 
                    ?>
                    <li><a href="/admin/login">Přihlásit se</a></li>
                    <li><a href="/">Návrat na web</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <?php // Hlavní obsah admin stránky 
    ?>
    <main>

        <div>
            <?php
            /**
             * Flash zprávy - zobrazení a automatické smazání
             * Úspěšné akce zobrazí zelenou zprávu
             */
            if (isset($_SESSION['success'])):
            ?>
                <div class="alert alert-success">
                    <?= htmlspecialchars($_SESSION['success']) ?>
                    <?php unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>

            <?php
            /**
             * Chybové zprávy - zobrazení a automatické smazání
             * Neúspěšné akce zobrazí červenou zprávu
             */
            if (isset($_SESSION['error'])):
            ?>
                <div class="alert alert-error">
                    <?= htmlspecialchars($_SESSION['error']) ?>
                    <?php unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <?php // Vložený obsah konkrétní admin stránky 
            ?>
            <?= $content ?>
        </div>
    </main>

    <?php // JavaScript soubory pro admin funkcionalitu 
    ?>
    <script src="/js/admin.js"></script>
</body>

</html>