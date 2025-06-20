<h2>Knihy</h2>
<button id="printListBtn">Tisknout výpis</button>

<?php if (empty($books)): ?>
    <p>V katalogu zatím nejsou žádné knihy. <a href="/books/create">Přidejte nějaké!</a></p>
<?php else: ?>
    <div class="book-list">
        <?php foreach ($books as $book): ?>
            <div class="book-item">
                <h3><a href="/book/<?= htmlspecialchars($book['id']) ?>"><?= htmlspecialchars($book['title']) ?></a></h3>
                <p><strong>Autor:</strong> <?= htmlspecialchars($book['author']) ?></p>
                <p><strong>Rok vydání:</strong> <?= htmlspecialchars($book['publication_year']) ?></p>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>