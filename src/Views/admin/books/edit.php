<?php

/**
 * Formulář pro editaci existující knihy
 * 
 * Admin formulář pro úpravu existující knihy s předvyplněnými hodnotami.
 * Obsahuje validaci, dirty state tracking a možnost smazání knihy.
 * 
 * @var array $book Data editované knihy (id, title, author, publication_year, rating, annotation)
 * @var array $errors Pole chybových zpráv z validace (volitelné)
 * @var string $title Název stránky
 * 
 * @package App\Views\Admin\Books
 * @author  Radek Procházka
 * @version 1.0
 */
?>

<div class="book-form-container">

    <?php // Hlavička formuláře s navigačními odkazy 
    ?>
    <div class="form-header">
        <h2>Upravit knihu</h2>
        <div class="header-actions">
            <a href="/admin/books" class="btn">← Zpět na seznam</a>
            <a href="/books/<?= $book['id'] ?>" target="_blank" class="btn" title="Zobrazit na webu">
                Náhled
            </a>
        </div>
    </div>

    <?php
    /**
     * Zobrazení chybových zpráv z validace
     * Zobrazí se pouze pokud existují chyby
     */
    if (!empty($errors)):
    ?>
        <div class="alert alert-error">
            <h4>Opravte následující chyby:</h4>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php
    /**
     * Hlavní formulář pro editaci knihy
     * - Obsahuje dirty state tracking
     * - Všechna pole jsou předvyplněná aktuálními hodnotami
     * - Validace na frontend i backend straně
     */
    ?>
    <form method="POST" action="/admin/books/<?= $book['id'] ?>/edit" class="book-form" id="edit-book-form">

        <!-- Grid layout pro základní informace o knize -->
        <div class="form-grid">

            <?php // Pole pro název knihy - povinné 
            ?>
            <div class="form-group">
                <label for="title" class="form-label">Název knihy *</label>
                <input type="text"
                    id="title"
                    name="title"
                    class="form-input"
                    value="<?= htmlspecialchars($book['title']) ?>"
                    required
                    placeholder="Zadejte název knihy">
            </div>

            <?php // Pole pro autora - povinné 
            ?>
            <div class="form-group">
                <label for="author" class="form-label">Autor *</label>
                <input type="text"
                    id="author"
                    name="author"
                    class="form-input"
                    value="<?= htmlspecialchars($book['author']) ?>"
                    required
                    placeholder="Zadejte jméno autora">
            </div>

            <?php // Rok vydání - číselné pole s validací 
            ?>
            <div class="form-group">
                <label for="publication_year" class="form-label">Rok vydání *</label>
                <input type="number"
                    id="publication_year"
                    name="publication_year"
                    class="form-input"
                    value="<?= htmlspecialchars($book['publication_year']) ?>"
                    min="1000"
                    max="<?= date('Y') ?>"
                    required>
            </div>

            <?php
            /**
             * Hodnocení knihy - volitelné pole
             * Podporuje desetinná čísla (např. 4.5)
             * Pokud není hodnocení, pole zůstane prázdné
             */
            ?>
            <div class="form-group">
                <label for="rating" class="form-label">Hodnocení (0-5)</label>
                <input type="number"
                    id="rating"
                    name="rating"
                    class="form-input"
                    value="<?= $book['rating'] ?? '' ?>"
                    min="0"
                    max="5"
                    step="0.1"
                    placeholder="např. 4.5">
                <small class="form-help">Můžete zadat hodnocení s desetinným místem (např. 4.5)</small>
            </div>

        </div>

        <?php // Anotace - velké textové pole 
        ?>
        <div class="form-group">
            <label for="annotation" class="form-label">Anotace</label>
            <textarea id="annotation"
                name="annotation"
                class="form-textarea"
                rows="6"
                placeholder="Stručný popis knihy, děj, hlavní postavy..."><?= htmlspecialchars($book['annotation'] ?? '') ?></textarea>
        </div>

        <?php
        /**
         * Akční tlačítka formuláře
         * - Uložit změny (submit)
         * - Zrušit (návrat zpět)
         * - Smazat knihu (s potvrzením přes JavaScript)
         */
        ?>
        <div class="form-actions">
            <button type="submit" class="btn">
                <i class="icon-save"></i> Uložit změny
            </button>

            <a href="/admin/books" class="btn">Zrušit</a>

            <!-- Tlačítko pro smazání s data atributy pro JavaScript -->
            <button type="button"
                data-delete-book
                data-book-id="<?= $book['id'] ?>"
                data-book-title="<?= htmlspecialchars($book['title']) ?>"
                class="btn btn-danger">
                <i class="icon-trash"></i> Smazat knihu
            </button>
        </div>

    </form>
</div>