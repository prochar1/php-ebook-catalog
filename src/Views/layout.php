<?php

/**
 * Hlavní layout template pro veřejnou část webu
 * 
 * Základní layout používaný pro všechny veřejné stránky katalogu knih.
 * Obsahuje hlavičku s navigací, obsah stránky a jednoduchou strukturu.
 * 
 * @var string $content Obsah stránky (vložený template)
 * @var string $title Název stránky pro <title> tag a hlavičku
 * 
 * @package App\Views
 * @author  Radek Procházka
 * @version 1.0
 */
?>
<!DOCTYPE html>
<html lang="cs">

<head>
    <?php // Meta tagy a základní nastavení pro SEO 
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Katalog e-knih') ?></title>

    <?php // CSS soubory pro styling 
    ?>
    <link rel="stylesheet" href="/css/style.css">
</head>

<body>
    <?php // Hlavička s navigací pro veřejnou část 
    ?>
    <header>
        <h1><?= htmlspecialchars($title ?? 'Katalog e-knih') ?></h1>

        <!-- Hlavní navigace -->
        <nav>
            <ul>
                <li><a href="/">Domů</a></li>
                <li><a href="/admin">Administrace</a></li>
            </ul>
        </nav>
    </header>

    <?php // Hlavní obsah stránky - vkládá se konkrétní template 
    ?>
    <main>
        <?= $content ?>
    </main>

    <?php // JavaScript soubory 
    ?>
    <script src="/js/main.js"></script>
</body>

</html>