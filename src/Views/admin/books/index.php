<div class="books-management">
    <div class="page-header">
        <h2>Správa knih</h2>
        <div class="page-actions">
            <a href="/admin/books/create" class="btn">
                <i class="icon-plus"></i> Přidat novou knihu
            </a>
        </div>
    </div>

    <?php if (empty($books)): ?>
        <div class="empty-state">
            <div class="empty-icon">📚</div>
            <h3>Žádné knihy v katalogu</h3>
            <p>Začněte přidáním své první knihy do katalogu.</p>
            <a href="/admin/books/create" class="btn">Přidat první knihu</a>
        </div>
    <?php else: ?>
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
                        <tr data-book-id="<?= $book['id'] ?>">
                            <td><?= $book['id'] ?></td>
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
                            <td>
                                <?php if ($book['rating']): ?>
                                    <div class="rating">
                                        <span class="stars"><?= str_repeat('★', (int)$book['rating']) ?><?= str_repeat('☆', 5 - (int)$book['rating']) ?></span>
                                        <span class="rating-number"><?= $book['rating'] ?>/5</span>
                                    </div>
                                <?php else: ?>
                                    <span class="no-rating">Nehodnoceno</span>
                                <?php endif; ?>
                            </td>
                            <td class="actions-cell">
                                <div class="action-buttons">
                                    <a href="/admin/books/<?= $book['id'] ?>/edit"
                                        class="btn"
                                        title="Upravit knihu">
                                        <i class="icon-edit"></i> Upravit
                                    </a>
                                    <button
                                        data-delete-book
                                        data-book-id="<?= $book['id'] ?>"
                                        data-book-title="<?= htmlspecialchars($book['title']) ?>"
                                        class="btn"
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