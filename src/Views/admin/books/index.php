<?php

/**
 * Správa knih - administrační přehled
 * 
 * Zobrazuje tabulku se všemi knihami v katalogu s možnostmi správy.
 * Obsahuje tlačítka pro přidání, editaci, smazání a import knih.
 * Pokud nejsou knihy, zobrazí prázdný stav s akcemi.
 * 
 * @var array $books Seznam všech knih z databáze
 * @var string $title Název stránky
 * 
 * @package App\Views\Admin\Books
 * @author  Radek Procházka
 * @version 1.0
 */
?>

<div class="books-management">

    <?php // Hlavička stránky s rychlými akcemi 
    ?>
    <div class="page-header">
        <h2>Správa knih</h2>
        <div class="page-actions">
            <a href="/admin/books/create" class="btn">
                <i class="icon-plus"></i> Přidat novou knihu
            </a>
            <form action="/admin/import" method="post" style="display: inline;">
                <button type="submit" class="btn btn-secondary" onclick="return confirm('Opravdu chcete importovat knihy z JSON souboru?')">
                    <i class="icon-upload"></i> Importovat z JSON
                </button>
            </form>
        </div>
    </div>

    <?php
    /**
     * Kontrola, zda existují nějaké knihy
     * Pokud ne, zobrazí prázdný stav s akcemi
     */
    if (empty($books)):
    ?>
        <!-- Prázdný stav katalogu -->
        <div class="empty-state">
            <div class="empty-icon">📚</div>
            <h3>Žádné knihy v katalogu</h3>
            <p>Začněte přidáním své první knihy do katalogu nebo importem existujících dat.</p>
            <div class="empty-actions">
                <a href="/admin/books/create" class="btn">Přidat první knihu</a>
                <form action="/admin/import" method="post" style="display: inline;">
                    <button type="submit" class="btn btn-secondary" onclick="return confirm('Opravdu chcete importovat knihy z JSON souboru?')">
                        Importovat z JSON
                    </button>
                </form>
            </div>
        </div>

    <?php else: ?>
        <?php
        /**
         * Tabulka se seznamem všech knih
         * Každý řádek obsahuje základní informace a akce pro správu
         */
        ?>
        <div class="table-container">
            <table class="books-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Název</th>
                        <th>Autor</th>
                        <th>Rok vydání</th>
                        <th>Hodnocení</th>
                        <th>Akce</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($books as $book): ?>
                        <!-- Řádek s informacemi o knize -->
                        <tr data-book-id="<?= $book['id'] ?>">
                            <td><?= $book['id'] ?></td>

                            <?php // Název knihy s odkazem a náhledem anotace 
                            ?>
                            <td class="book-title">
                                <a href="/books/<?= $book['id'] ?>" target="_blank" title="Zobrazit na webu">
                                    <?= htmlspecialchars($book['title']) ?>
                                </a>
                                <?php if (!empty($book['annotation'])): ?>
                                    <div class="book-annotation">
                                        <?= htmlspecialchars(mb_substr($book['annotation'], 0, 100)) ?>
                                        <?= mb_strlen($book['annotation']) > 100 ? '...' : '' ?>
                                    </div>
                                <?php endif; ?>
                            </td>

                            <td><?= htmlspecialchars($book['author']) ?></td>
                            <td><?= $book['publication_year'] ?></td>

                            <?php // Hodnocení knihy s vizuálním zobrazením 
                            ?>
                            <td>
                                <?php if ($book['rating']): ?>
                                    <div class="rating">
                                        <span class="stars">
                                            <?= str_repeat('★', (int)$book['rating']) ?>
                                            <?= str_repeat('☆', 5 - (int)$book['rating']) ?>
                                        </span>
                                        <span class="rating-number"><?= number_format($book['rating'], 1) ?>/5</span>
                                    </div>
                                <?php else: ?>
                                    <span class="no-rating">Nehodnoceno</span>
                                <?php endif; ?>
                            </td>

                            <?php // Akční tlačítka pro správu knihy 
                            ?>
                            <td class="actions-cell">
                                <div class="action-buttons">
                                    <a href="/admin/books/<?= $book['id'] ?>/edit"
                                        class="btn"
                                        title="Upravit knihu">
                                        <i class="icon-edit"></i> Upravit
                                    </a>

                                    <!-- Tlačítko pro smazání s JavaScript potvrzením -->
                                    <button
                                        data-delete-book
                                        data-book-id="<?= $book['id'] ?>"
                                        data-book-title="<?= htmlspecialchars($book['title']) ?>"
                                        class="btn btn-danger"
                                        title="Smazat knihu">
                                        <i class="icon-trash"></i> Smazat
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>