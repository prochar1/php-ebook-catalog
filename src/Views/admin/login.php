<body class="login-page">
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <h1>🔐</h1>
                <h2>Přihlášení do administrace</h2>
                <p>Zadejte heslo pro přístup do administrace</p>
            </div>

            <?php if (!empty($error)): ?>
                <div class="alert alert--error">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

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

            <div class="login-footer">
                <p><a href="/" class="text-link">← Zpět na hlavní stránku</a></p>
            </div>
        </div>
    </div>