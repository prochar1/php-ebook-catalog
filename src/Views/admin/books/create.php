<div class="book-form-container">
    <div class="form-header">
        <h2>Přidat novou knihu</h2>
        <div class="header-actions">
            <a href="/admin/books" class="btn">← Zpět na seznam</a>
        </div>
    </div>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-error">
            <h4>Opravte následující chyby:</h4>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" action="/admin/books/create" class="book-form">
        <div class="form-grid">
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

        <div class="form-group">
            <label for="annotation" class="form-label">Anotace</label>
            <textarea id="annotation"
                name="annotation"
                class="form-textarea"
                rows="6"
                placeholder="Stručný popis knihy, děj, hlavní postavy..."><?= htmlspecialchars($data['annotation'] ?? '') ?></textarea>
            <small class="form-help">Nepovinné - anotace pomůže čtenářům lépe poznat knihu</small>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn">
                <i class="icon-save"></i> Uložit knihu
            </button>
            <a href="/admin/books" class="btn">Zrušit</a>
        </div>
    </form>
</div>