<!DOCTYPE html>
<html lang="cs">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Administrace') ?></title>
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/admin.css">
</head>

<body>

    <header>
        <h1><?= htmlspecialchars($title ?? 'Administrace') ?></h1>
        <nav class="admin-nav">
            <ul>
                <?php if (true): ?>
                    <li><a href="/admin">Dashboard</a></li>
                    <li><a href="/admin/knihy">Správa knih</a></li>
                    <li><a href="/">Návrat na web</a></li>
                    <li><a href="/admin/odhlaseni">Odhlásit se</a></li>
                <?php else: ?>
                    <li><a href="/admin/prihlaseni">Přihlásit se</a></li>
                    <li><a href="/">Návrat na web</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <main>

        <div>
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success">
                    <?= htmlspecialchars($_SESSION['success']) ?>
                    <?php unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-error">
                    <?= htmlspecialchars($_SESSION['error']) ?>
                    <?php unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <?= $content ?>
        </div>
    </main>

    <script src="/js/admin.js"></script>
</body>

</html>