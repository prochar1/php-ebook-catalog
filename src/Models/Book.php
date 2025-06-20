<?php

namespace App\Models;

use App\Core\Database;

class Book
{
    private Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    /**
     * Získá všechny knihy z databáze.
     */
    public function getAllBooks(): array
    {
        $sql = "SELECT * FROM books ORDER BY title ASC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Získá knihu podle jejího ID.
     */
    public function getBookById(int $id): ?array
    {
        $sql = "SELECT * FROM books WHERE id = ?";
        $stmt = $this->db->query($sql, [$id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    /**
     * Vytvoří novou knihu.
     */
    public function createBook(array $data): bool
    {
        $sql = "INSERT INTO books (title, author, publication_year, rating, annotation) 
                VALUES (?, ?, ?, ?, ?)";

        $stmt = $this->db->query($sql, [
            $data['title'] ?? '',
            $data['author'] ?? '',
            $data['publication_year'] ?? 0,
            $data['rating'] ?? 0.0,
            $data['annotation'] ?? ''
        ]);

        return $stmt->rowCount() > 0;
    }

    /**
     * Aktualizuje existující knihu.
     */
    public function updateBook(int $id, array $data): bool
    {
        $sql = "UPDATE books SET title = ?, author = ?, publication_year = ?, 
                rating = ?, annotation = ? WHERE id = ?";

        $stmt = $this->db->query($sql, [
            $data['title'] ?? '',
            $data['author'] ?? '',
            $data['publication_year'] ?? 0,
            $data['rating'] ?? 0.0,
            $data['annotation'] ?? '',
            $id
        ]);

        return $stmt->rowCount() > 0;
    }

    /**
     * Odstraní knihu z databáze.
     */
    public function deleteBook(int $id): bool
    {
        $sql = "DELETE FROM books WHERE id = ?";
        $stmt = $this->db->query($sql, [$id]);
        return $stmt->rowCount() > 0;
    }

    /**
     * Importuje knihy z JSON souboru do databáze.
     */
    public function importBooksFromJson(string $filePath): array
    {
        if (!file_exists($filePath)) {
            return ['success' => false, 'message' => "Soubor '$filePath' nebyl nalezen."];
        }

        $jsonData = file_get_contents($filePath);
        $books = json_decode($jsonData, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return ['success' => false, 'message' => "Chyba při parsování JSON souboru: " . json_last_error_msg()];
        }

        if (!is_array($books)) {
            return ['success' => false, 'message' => "JSON soubor neobsahuje platné pole knih."];
        }

        $addedCount = 0;
        $skippedCount = 0;

        foreach ($books as $bookData) {
            // Jednoduchá kontrola duplicity (podle názvu a autora)
            $stmt = $this->db->query(
                "SELECT id FROM books WHERE title = ? AND author = ?",
                [$bookData['title'] ?? '', $bookData['author'] ?? '']
            );
            $existing = $stmt->fetchAll();

            if (empty($existing)) {
                // Přidání knihy, pokud neexistuje
                $this->createBook($bookData);
                $addedCount++;
            } else {
                $skippedCount++;
            }
        }

        return [
            'success' => true,
            'message' => "Import dokončen. Přidáno $addedCount nových knih, $skippedCount již existovalo.",
            'added' => $addedCount,
            'skipped' => $skippedCount
        ];
    }
}
