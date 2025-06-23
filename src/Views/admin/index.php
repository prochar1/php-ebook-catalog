<div class="dashboard">
    <h2>Dashboard</h2>

    <div class="actions">
        <a href="/admin/books" class="btn">Správa knih</a>
        <a href="/admin/books/create" class="btn">Přidat knihu</a>
    </div>

    <?php if (!empty($allBooks)): ?>
        <div class="recent-books">
            <h3>Knihy v katalogu</h3>
            <ul>
                <?php foreach ($allBooks as $book): ?>
                    <li>
                        <?= htmlspecialchars($book['title']) ?> - <?= htmlspecialchars($book['author']) ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>


</div>