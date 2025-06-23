<?php

/**
 * Admin přihlašovací formulář
 * 
 * Zobrazuje formulář pro přihlášení do administrace.
 * Obsahuje pole pro heslo a zpracování chybových zpráv.
 * Používá speciální styling pro login stránku.
 * 
 * @var string $error Chybová zpráva při neúspěšném přihlášení (volitelná)
 * @var string $title Název stránky
 * 
 * @package App\Views\Admin
 * @author  Radek Procházka
 * @version 1.0
 */
?>

<body class="login-page">
    <div class="login-container">
        <div class="login-card">

            <?php // Hlavička přihlašovacího formuláře 
            ?>
            <div class="login-header">
                <h1>🔐</h1>
                <h2>Přihlášení do administrace</h2>
                <p>Zadejte heslo pro přístup do administrace</p>
            </div>

            <?php
            /**
             * Zobrazení chybové zprávy
             * Zobrazí se pouze při neúspěšném přihlášení
             */
            if (!empty($error)):
            ?>
                <div class="alert alert--error">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <?php // Přihlašovací formulář 
            ?>
            <form method="POST" action="/admin/login" class="login-form">
                <div class="form-group">
                    <label for="password">Heslo</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        required
                        autofocus
                        class="form-input"
                        placeholder="Zadejte heslo">
                </div>

                <button type="submit" class="btn">
                    Přihlásit se
                </button>
            </form>

            <?php // Navigace zpět 
            ?>
            <div class="login-footer">
                <p><a href="/" class="text-link">← Zpět na hlavní stránku</a></p>
            </div>
        </div>
    </div>