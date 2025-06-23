<?php

/**
 * Seznam knih - katalog e-knih
 * 
 * Zobrazuje seznam všech knih v katalogu s možností tisku.
 * Pokud nejsou žádné knihy, zobrazí informační zprávu s odkazem na přidání.
 * 
 * @var array $books Seznam všech knih z databáze
 * @var string $title Název stránky
 * 
 * @package App\Views\Books
 * @author  Radek Procházka
 * @version 1.0
 */
?>

<h2>Knihy</h2>

<?php // Tlačítko pro tisk seznamu knih 
?>
<button id="printListBtn">Tisknout výpis</button>

<?php
/**
 * Kontrola, zda existují nějaké knihy v katalogu
 * Pokud ne, zobrazí informační zprávu s odkazem na přidání
 */
if (empty($books)):
?>
    <!-- Stav prázdného katalogu -->
    <p>V katalogu zatím nejsou žádné knihy. <a href="/books/create">Přidejte nějaké!</a></p>

<?php else: ?>
    <?php
    /**
     * Seznam knih ve formě karet
     * Každá kniha zobrazuje základní informace s odkazem na detail
     */
    ?>
    <div class="book-list">
        <?php foreach ($books as $book): ?>
            <!-- Karta jednotlivé knihy -->
            <div class="book-item">
                <h3>
                    <a href="/books/<?= htmlspecialchars($book['id']) ?>">
                        <?= htmlspecialchars($book['title']) ?>
                    </a>
                </h3>

                <!-- Základní informace o knize -->
                <p><strong>Autor:</strong> <?= htmlspecialchars($book['author']) ?></p>
                <p><strong>Rok vydání:</strong> <?= htmlspecialchars($book['publication_year']) ?></p>

                <?php // Hodnocení knihy (pokud existuje) 
                ?>
                <?php if (!empty($book['rating'])): ?>
                    <p><strong>Hodnocení:</strong> <?= number_format($book['rating'], 1) ?>/5</p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>