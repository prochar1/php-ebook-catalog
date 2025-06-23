<div class="book-form-container">
    <div class="form-header">
        <h2>Upravit knihu</h2>
        <div class="header-actions">
            <a href="/admin/books" class="btn">← Zpět na seznam</a>
            <a href="/admin/books/<?= $book['id'] ?>" target="_blank" class="btn" title="Zobrazit na webu">
                Náhled
            </a>
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

    <form method="POST" action="/admin/books/<?= $book['id'] ?>/edit" class="book-form">
        <div class="form-grid">
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

            <div class="form-group">
                <label for="rating" class="form-label">Hodnocení (1-5)</label>
                <select id="rating" name="rating" class="form-select">
                    <option value="">-- Bez hodnocení --</option>
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <option value="<?= $i ?>" <?= ($book['rating'] ?? '') == $i ? 'selected' : '' ?>>
                            <?= $i ?> <?= str_repeat('★', $i) ?>
                        </option>
                    <?php endfor; ?>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="annotation" class="form-label">Anotace</label>
            <textarea id="annotation"
                name="annotation"
                class="form-textarea"
                rows="6"
                placeholder="Stručný popis knihy, děj, hlavní postavy..."><?= htmlspecialchars($book['annotation'] ?? '') ?></textarea>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn">
                <i class="icon-save"></i> Uložit změny
            </button>
            <a href="/admin/books" class="btn">Zrušit</a>

            <button type="button"
                data-delete-book
                data-book-id="<?= $book['id'] ?>"
                data-book-title="<?= htmlspecialchars($book['title']) ?>"
                class="btn">
                <i class="icon-trash"></i> Smazat knihu
            </button>
        </div>
    </form>
</div>