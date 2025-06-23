<?php

/**
 * Import výsledků - administrace
 * 
 * Zobrazuje výsledky importu knih z JSON souboru.
 * Ukazuje úspěšný/neúspěšný import a statistiky importované dat.
 * 
 * @package    EbookCatalog
 * @subpackage Views
 * @author     Radek Procházka
 * @version    1.0
 * 
 * Používané proměnné:
 * @var array $result - Výsledek importu s klíči: success, message, added, skipped
 */
?>

<!-- Import výsledků - hlavní kontejner -->
<div class="import-result">
    <!-- Záhlaví stránky s navigací zpět -->
    <div class="page-header">
        <h2>Import knih</h2>
        <div class="page-actions">
            <a href="/admin/books" class="btn">← Zpět na správu knih</a>
        </div>
    </div>

    <?php if ($result['success']): ?>
        <!-- Zpráva o úspěšném importu -->
        <div class="alert alert-success">
            <h4>✅ Import byl úspěšný!</h4>
            <p><?= htmlspecialchars($result['message']) ?></p>

            <?php if (isset($result['added']) && isset($result['skipped'])): ?>
                <!-- Statistiky importu - počet přidaných a přeskočených knih -->
                <ul>
                    <li><strong>Přidáno:</strong> <?= $result['added'] ?> nových knih</li>
                    <li><strong>Přeskočeno:</strong> <?= $result['skipped'] ?> již existujících knih</li>
                </ul>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <!-- Chybová zpráva při neúspěšném importu -->
        <div class="alert alert-error">
            <h4>❌ Chyba při importu</h4>
            <p><?= htmlspecialchars($result['message']) ?></p>
        </div>
    <?php endif; ?>

    <!-- Akce po importu -->
    <div class="import-actions">
        <!-- Odkaz na seznam všech knih -->
        <a href="/admin/books" class="btn">Zobrazit všechny knihy</a>

        <?php if ($result['success']): ?>
            <!-- Možnost opětovného importu (pouze při úspěšném importu) -->
            <form action="/admin/import" method="post" style="display: inline;">
                <button type="submit" class="btn btn-secondary" onclick="return confirm('Opravdu chcete znovu importovat?')">
                    Importovat znovu
                </button>
            </form>
        <?php endif; ?>
    </div>
</div>