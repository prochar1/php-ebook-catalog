<?php

namespace App\Core;

use PDO;
use PDOException;
use PDOStatement;
use Exception;

class Database
{
    private PDO $pdo;

    public function __construct()
    {
        $dsn = '';
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Výchozí fetch mód bude asociativní pole
            PDO::ATTR_EMULATE_PREPARES   => false, // Vypnutí emulace prepared statements pro lepší výkon a bezpečnost
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4' // Nastavení znakové sady pro MySQL/MariaDB
        ];

        try {
            if (DB_DRIVER === 'mysql') { // Nyní cílíme na MySQL/MariaDB
                $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;
                $this->pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
            } else {
                // Tato větev by se již neměla spustit, pokud je DB_DRIVER nastaven na 'mysql'
                throw new Exception("Nepodporovaný databázový driver: " . DB_DRIVER);
            }

            // Vytvoření tabulky pro MariaDB
            $this->createTables();
        } catch (PDOException $e) {
            // Zde byste v produkčním prostředí měli chybu logovat, nikoli zobrazovat uživateli
            die("Chyba připojení k databázi: " . $e->getMessage());
        } catch (Exception $e) {
            die("Chyba konfigurace databáze: " . $e->getMessage());
        }
    }

    /**
     * Vrátí instanci PDO připojení.
     */
    public function getConnection(): PDO
    {
        return $this->pdo;
    }

    /**
     * Spustí SQL dotaz s připravenými parametry.
     * @param string $sql SQL dotaz
     * @param array $params Pole parametrů pro dotaz
     * @return PDOStatement
     */
    public function query(string $sql, array $params = []): PDOStatement
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    /**
     * Vytvoří tabulky, pokud neexistují (pro MariaDB).
     */
    private function createTables(): void
    {
        $sql = "
            CREATE TABLE IF NOT EXISTS books (
                id INT AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(255) NOT NULL,
                author VARCHAR(255) NOT NULL,
                publication_year INT NOT NULL,
                annotation TEXT,
                rating DECIMAL(2,1)
            );
        ";
        $this->pdo->exec($sql);
    }
}
