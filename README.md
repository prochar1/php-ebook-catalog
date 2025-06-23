# PHP E-book Katalog

Jednoduchá webová aplikace pro správu katalogu elektronických knih vytvořená v PHP s využitím MariaDB databáze.

## Funkce

- 📚 **Katalog knih** - Prohlížení seznamu všech knih
- 🔍 **Detail knihy** - Zobrazení podrobných informací o knize
- 🔐 **Administrace** - Zabezpečená správa knih heslem
- ➕ **Přidání knihy** - Formulář pro přidání nových knih
- ✏️ **Úprava knihy** - Editace existujících knih
- 🗑️ **Mazání knih** - Odstranění knih z katalogu
- 📥 **Import dat** - Import knih z JSON souboru
- 📱 **Responzivní design** - Optimalizováno pro všechna zařízení

## Technologie

- **Backend**: PHP 8.3+
- **Databáze**: MariaDB/MySQL
- **Frontend**: HTML5, CSS3 (SASS), Vanilla JavaScript
- **Kontejnerizace**: Docker & Docker Compose
- **Autoloading**: Composer (PSR-4)

## Požadavky

- Docker
- Docker Compose
- Git

## Instalace

### 1. Klonování repozitáře

```bash
git clone git@github.com:prochar1/php-ebook-catalog.git
cd php-ebook-catalog
```

### 2. Spuštění Docker kontejnerů

```bash
docker-compose up -d
```

Tímto se spustí:

- **Web server** (PHP 8.4 + Apache) na portu `8000`
- **MariaDB databáze** na portu `3306`
- **Adminer** (správa DB) na portu `8081`

### 3. Instalace Composer závislostí

```bash
# Vstup do web kontejneru
docker-compose exec web bash

# Instalace Composeru
curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Instalace závislostí
composer install
```

### 4. Kompilace CSS stylů (volitelné)

```bash
# Instalace Node.js závislostí
npm install

# Kompilace SASS → CSS
npm run build-css

# Nebo spuštění watch mode pro vývoj
npm run sass
```

## Konfigurace

### Databázové připojení

Databázové údaje jsou definovány v souboru [`src/config.php`](src/config.php):

```php
define('DB_DRIVER', 'mysql');
define('DB_HOST', 'db');           // Název Docker service
define('DB_NAME', 'ebook');        // Název databáze
define('DB_USER', 'ebook');        // DB uživatel
define('DB_PASS', 'ebook');        // DB heslo
define('DB_CHARSET', 'utf8mb4');
```

### Přihlašovací údaje do administrace

Heslo pro přístup do administrace nastavíte v [`src/config.php`](src/config.php):

```php
define('ADMIN_PASSWORD', 'superTajneHeslo123');
```

**⚠️ DŮLEŽITÉ:** Změňte výchozí heslo před nasazením do produkce!

## Přístup k aplikaci

Po úspěšné instalaci:

- **Hlavní stránka**: http://localhost:8000
- **Administrace**: http://localhost:8000/admin/prihlaseni
- **Správa databáze**: http://localhost:8081 (Adminer)

### Přihlašovací údaje

**Administrace:**

- Heslo: `superTajneHeslo123` (změňte v config.php)

**Databáze (Adminer):**

- Server: `db`
- Uživatel: `ebook`
- Heslo: `ebook`
- Databáze: `ebook`

## Struktura projektu

```
php-ebook-catalog/
├── public/                 # Webroot
│   ├── index.php          # Hlavní entry point
│   └── css/               # Kompilované CSS
├── src/                   # Zdrojové kódy
│   ├── Controllers/       # MVC Controllers
│   ├── Models/           # MVC Models
│   ├── Views/            # MVC Views (šablony)
│   ├── Core/             # Základní třídy (Router, Database, atd.)
│   └── config.php        # Konfigurace aplikace
├── data/                 # Datové soubory
│   └── books.json        # Vzorová data pro import
├── docker-compose.yml    # Docker konfigurace
├── composer.json         # PHP závislosti
└── package.json          # Node.js závislosti (SASS)
```

## Import vzorových dat

Aplikace obsahuje vzorová data v souboru [`data/books.json`](data/books.json).

Pro import dat:

1. Přihlaste se do administrace
2. Přejděte na "Správa knih"
3. Klikněte na tlačítko "Importovat z JSON"

## Vývoj

### Kompilace stylů během vývoje

```bash
npm run sass  # Spustí watch mode pro automatickou kompilaci
```

### Užitečné Docker příkazy

```bash
# Restart kontejnerů
docker-compose restart

# Zobrazení logů
docker-compose logs web

# Zastavení kontejnerů
docker-compose down

# Smazání volumes (databáze)
docker-compose down -v
```

## Licence

Tento projekt je licencován pod MIT licencí.

## Autor

Radek Procházka
prochar1@gmail.com
