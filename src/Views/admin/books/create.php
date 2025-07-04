<?php

/**
 * Formulář pro vytvoření nové knihy
 * 
 * Admin formulář pro přidání nové knihy do katalogu.
 * Obsahuje všechna potřebná pole s validací a dirty state tracking.
 * 
 * @var array $errors Pole chybových zpráv z validace (volitelné)
 * @var array $data Předvyplněná data z předchozího pokusu (volitelné)
 * @var string $title Název stránky
 * 
 * @package App\Views\Admin\Books
 * @author  Radek Procházka
 * @version 1.0
 */
?>

<div class="book-form-container">

    <?php // Hlavička formuláře s navigací 
    ?>
    <div class="form-header">
        <h2>Přidat novou knihu</h2>
        <div class="header-actions">
            <a href="/admin/books" class="btn">← Zpět na seznam</a>
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
     * Hlavní formulář pro vytvoření knihy
     * Obsahuje dirty state tracking a validaci na frontend i backend straně
     */
    ?>
    <form method="POST" action="/admin/books/create" class="book-form" id="create-book-form">

        <!-- Grid layout pro základní informace -->
        <div class="form-grid">

            <?php // Pole pro název knihy - povinné 
            ?>
            <div class="form-group">
                <label for="title" class="form-label">Název knihy *</label>
                <input type="text"
                    id="title"
                    name="title"
                    class="form-input <?= isset($errors) && !empty($errors) ? 'error' : '' ?>"
                    value="<?= htmlspecialchars($data['title'] ?? '') ?>"
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
                    value="<?= htmlspecialchars($data['author'] ?? '') ?>"
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
                    value="<?= htmlspecialchars($data['publication_year'] ?? '') ?>"
                    min="1000"
                    max="<?= date('Y') ?>"
                    required
                    placeholder="<?= date('Y') ?>">
            </div>

            <?php
            /**
             * Hodnocení knihy - volitelné pole
             * Podporuje desetinná čísla (např. 4.5)
             */
            ?>
            <div class="form-group">
                <label for="rating" class="form-label">Hodnocení (0-5)</label>
                <input type="number"
                    id="rating"
                    name="rating"
                    class="form-input"
                    value="<?= $data['rating'] ?? '' ?>"
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
                placeholder="Stručný popis knihy, děj, hlavní postavy..."><?= htmlspecialchars($data['annotation'] ?? '') ?></textarea>
            <small class="form-help">Nepovinné - anotace pomůže čtenářům lépe poznat knihu</small>
        </div>

        <?php // Akční tlačítka formuláře 
        ?>
        <div class="form-actions">
            <button type="submit" class="btn">
                <i class="icon-save"></i> Uložit knihu
            </button>
            <a href="/admin/books" class="btn">Zrušit</a>
        </div>
    </form>
</div>