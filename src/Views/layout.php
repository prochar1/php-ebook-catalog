<!DOCTYPE html>
<html lang="cs">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Katalog e-knih') ?></title>
    <link rel="stylesheet" href="/css/style.css">
</head>

<body>
    <header>
        <h1><?= htmlspecialchars($title ?? 'Katalog e-knih') ?></h1>
        <nav>
            <ul>
                <li><a href="/">Domů</a></li>
                <li><a href="/admin">Administrace</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <?= $content ?>
    </main>

    <script src="/js/main.js"></script>
</body>

</html>