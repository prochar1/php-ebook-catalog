<?php

/**
 * Detail knihy
 * 
 * Zobrazuje detailní informace o konkrétní knize včetně všech metadat.
 * Obsahuje název, autora, rok vydání, hodnocení a anotaci.
 * 
 * @var array $book Data konkrétní knihy (id, title, author, publication_year, rating, annotation)
 * @var string $title Název stránky
 * 
 * @package App\Views\Books
 * @author  Radek Procházka
 * @version 1.0
 */
?>

<div class="book-detail">
    <?php // Hlavní název knihy 
    ?>
    <h2><?= htmlspecialchars($book['title']) ?></h2>

    <?php // Základní metadata knihy 
    ?>
    <p><strong>Autor:</strong> <?= htmlspecialchars($book['author']) ?></p>
    <p><strong>Rok vydání:</strong> <?= htmlspecialchars($book['publication_year']) ?></p>

    <?php
    /**
     * Hodnocení knihy - zobrazí se pouze pokud existuje
     * Formátuje hodnocení na 1 desetinné místo
     */
    if (!empty($book['rating'])):
    ?>
        <p><strong>Hodnocení:</strong> <?= number_format($book['rating'], 1) ?> / 5</p>
    <?php endif; ?>

    <?php
    /**
     * Anotace knihy - zobrazí se pouze pokud existuje
     * Konvertuje nové řádky na HTML <br> tagy
     */
    if (!empty($book['annotation'])):
    ?>
        <p><strong>Anotace:</strong></p>
        <div class="book-annotation">
            <?= nl2br(htmlspecialchars($book['annotation'])) ?>
        </div>
    <?php endif; ?>

    <?php // Navigační tlačítko zpět 
    ?>
    <p><a href="/" class="btn">← Zpět na výpis knih</a></p>
</div>