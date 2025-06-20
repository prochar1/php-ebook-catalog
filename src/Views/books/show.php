<div class="book-detail">
    <h2><?= htmlspecialchars($book['title']) ?></h2>
    <p><strong>Autor:</strong> <?= htmlspecialchars($book['author']) ?></p>
    <p><strong>Rok vydání:</strong> <?= htmlspecialchars($book['publication_year']) ?></p>
    <?php if (!empty($book['rating'])): ?>
        <p><strong>Hodnocení:</strong> <?= htmlspecialchars($book['rating']) ?> / 5</p>
    <?php endif; ?>
    <?php if (!empty($book['annotation'])): ?>
        <p><strong>Anotace:</strong> <?= nl2br(htmlspecialchars($book['annotation'])) ?></p>
    <?php endif; ?>
    <p><a href="/" class="btn">← Zpět na výpis knih</a></p>
</div>