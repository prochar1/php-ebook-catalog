<?php

namespace App\Core;

use PDO;
use PDOException;
use PDOStatement;
use Exception;

/**
 * Třída pro správu databázového připojení a operací
 * 
 * Poskytuje PDO připojení k MySQL/MariaDB databázi
 * a základní metody pro práci s databází.
 * 
 * @package App\Core
 * @author  Radek Procházka
 * @version 1.0
 */
class Database
{
    /**
     * Instance PDO připojení
     * 
     * @var PDO
     */
    private PDO $pdo;

    /**
     * Konstruktor - inicializuje databázové připojení
     * 
     * Vytvoří PDO připojení na základě konstant definovaných v config.php.
     * Automaticky vytvoří tabulky pokud neexistují.
     * 
     * @throws PDOException Pokud se nepodaří připojit k databázi
     * @throws Exception    Pokud je použit nepodporovaný databázový driver
     */
    public function __construct()
    {
        $dsn = '';
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4'
        ];

        try {
            if (DB_DRIVER === 'mysql') {
                $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;
                $this->pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
            } else {
                throw new Exception("Nepodporovaný databázový driver: " . DB_DRIVER);
            }

            $this->createTables();
        } catch (PDOException $e) {
            die("Chyba připojení k databázi: " . $e->getMessage());
        } catch (Exception $e) {
            die("Chyba konfigurace databáze: " . $e->getMessage());
        }
    }

    /**
     * Vrátí instanci PDO připojení
     * 
     * @return PDO Instance databázového připojení
     */
    public function getConnection(): PDO
    {
        return $this->pdo;
    }

    /**
     * Spustí SQL dotaz s připravenými parametry
     * 
     * @param string $sql    SQL dotaz s placeholdery
     * @param array  $params Pole parametrů pro dotaz
     * 
     * @return PDOStatement Připravený statement s výsledky
     * @throws PDOException Pokud dojde k chybě při vykonávání dotazu
     */
    public function query(string $sql, array $params = []): PDOStatement
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    /**
     * Vytvoří tabulky pokud neexistují
     * 
     * Definuje a vytvoří strukturu tabulky 'books' pro MariaDB/MySQL.
     * 
     * @return void
     * @throws PDOException Pokud dojde k chybě při vytváření tabulek
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
