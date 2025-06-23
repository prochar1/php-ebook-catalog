<?php

/**
 * Kniha nenalezena - chybová stránka
 * 
 * Zobrazuje chybovou zprávu když je požadována neexistující kniha.
 * Obsahuje informaci o hledaném ID a navigaci zpět.
 * 
 * @var int|string $bookId ID knihy, která nebyla nalezena
 * @var string $title Název chybové stránky
 * 
 * @package App\Views\Books
 * @author  Radek Procházka
 * @version 1.0
 */
?>

<div class="error-message">
    <?php // Chybová zpráva s ID knihy 
    ?>
    <h2>Kniha nenalezena</h2>
    <p>Kniha s ID "<?= htmlspecialchars($bookId) ?>" nebyla nalezena.</p>
    <p>Možné příčiny:</p>
    <ul>
        <li>Kniha byla smazána</li>
        <li>ID knihy je nesprávné</li>
        <li>Odkaz je zastaralý</li>
    </ul>

    <?php // Navigační odkaz zpět 
    ?>
    <p><a href="/" class="btn">← Zpět na výpis knih</a></p>
</div>