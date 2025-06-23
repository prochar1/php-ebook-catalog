<?php

/**
 * Admin dashboard - hlavní administrační stránka
 * 
 * Zobrazuje základní přehled admin rozhraní s rychlými akcemi
 * a přehledem knih v katalogu. Výchozí stránka po přihlášení.
 * 
 * @var array $books Seznam všech knih (volitelný)
 * @var string $title Název stránky
 * 
 * @package App\Views\Admin
 * @author  Radek Procházka
 * @version 1.0
 */
?>

<div class="dashboard">
    <h2>Dashboard</h2>

    <?php // Rychlé akce pro administrátora 
    ?>
    <div class="actions">
        <a href="/admin/books" class="btn">Správa knih</a>
        <a href="/admin/books/create" class="btn">Přidat knihu</a>
    </div>

    <?php
    /**
     * Přehled knih v katalogu
     * Zobrazí se pouze pokud existují nějaké knihy
     */
    if (!empty($books)):
    ?>
        <div class="recent-books">
            <h3>Knihy v katalogu (<?= count($books) ?>)</h3>
            <ul>
                <?php foreach ($books as $book): ?>
                    <li>
                        <?= htmlspecialchars($book['title']) ?> - <?= htmlspecialchars($book['author']) ?>
                        <small>(<?= $book['publication_year'] ?>)</small>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php else: ?>
        <!-- Stav prázdného katalogu -->
        <div class="empty-catalog">
            <p>V katalogu zatím nejsou žádné knihy.</p>
            <a href="/admin/books/create" class="btn">Přidat první knihu</a>
        </div>
    <?php endif; ?>

</div>