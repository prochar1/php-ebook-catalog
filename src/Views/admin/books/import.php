<div class="import-result">
    <div class="page-header">
        <h2>Import knih</h2>
        <div class="page-actions">
            <a href="/admin/books" class="btn">← Zpět na správu knih</a>
        </div>
    </div>

    <?php if ($result['success']): ?>
        <div class="alert alert-success">
            <h4>✅ Import byl úspěšný!</h4>
            <p><?= htmlspecialchars($result['message']) ?></p>

            <?php if (isset($result['added']) && isset($result['skipped'])): ?>
                <ul>
                    <li><strong>Přidáno:</strong> <?= $result['added'] ?> nových knih</li>
                    <li><strong>Přeskočeno:</strong> <?= $result['skipped'] ?> již existujících knih</li>
                </ul>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-error">
            <h4>❌ Chyba při importu</h4>
            <p><?= htmlspecialchars($result['message']) ?></p>
        </div>
    <?php endif; ?>

    <div class="import-actions">
        <a href="/admin/books" class="btn">Zobrazit všechny knihy</a>
        <?php if ($result['success']): ?>
            <form action="/admin/import" method="post" style="display: inline;">
                <button type="submit" class="btn btn-secondary" onclick="return confirm('Opravdu chcete znovu importovat?')">
                    Importovat znovu
                </button>
            </form>
        <?php endif; ?>
    </div>
</div>