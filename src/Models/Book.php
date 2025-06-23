<?php

namespace App\Models;

use App\Core\Database;

/**
 * Model pro práci s knihami
 * 
 * Poskytuje metody pro CRUD operace s knihami v databázi
 * včetně importu dat z JSON souboru.
 * 
 * @package App\Models
 * @author  Radek Procházka
 * @version 1.0
 */
class Book
{
    /**
     * Instance databázového připojení
     * 
     * @var Database
     */
    private Database $db;

    /**
     * Konstruktor modelu
     * 
     * @param Database $db Instance databázového připojení
     */
    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    /**
     * Získá všechny knihy z databáze
     * 
     * @return array<array{id: int, title: string, author: string, publication_year: int, annotation: string|null, rating: float|null}>
     */
    public function getAllBooks(): array
    {
        $sql = "SELECT * FROM books ORDER BY title ASC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Získá knihu podle jejího ID
     * 
     * @param int $id ID knihy
     * 
     * @return array{id: int, title: string, author: string, publication_year: int, annotation: string|null, rating: float|null}|null
     */
    public function getBookById(int $id): ?array
    {
        $sql = "SELECT * FROM books WHERE id = ?";
        $stmt = $this->db->query($sql, [$id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    /**
     * Vytvoří novou knihu v databázi
     * 
     * @param array{title: string, author: string, publication_year: int, rating?: float, annotation?: string} $data Data knihy
     * 
     * @return bool True při úspěchu, false při chybě
     */
    public function createBook(array $data): bool
    {
        $sql = "INSERT INTO books (title, author, publication_year, rating, annotation) 
                VALUES (?, ?, ?, ?, ?)";

        // Sanitizace dat - OPRAVA!
        $rating = $this->sanitizeRating($data['rating'] ?? '');
        $annotation = $this->sanitizeAnnotation($data['annotation'] ?? '');

        $stmt = $this->db->query($sql, [
            $data['title'] ?? '',
            $data['author'] ?? '',
            $data['publication_year'] ?? 0,
            $rating,        // NULL nebo float
            $annotation     // NULL nebo string
        ]);

        return $stmt->rowCount() > 0;
    }

    /**
     * Aktualizuje existující knihu
     * 
     * @param int   $id   ID knihy k aktualizaci
     * @param array $data Nová data knihy
     * 
     * @return bool True při úspěchu, false při chybě
     */
    public function updateBook(int $id, array $data): bool
    {
        $sql = "UPDATE books SET title = ?, author = ?, publication_year = ?, 
                rating = ?, annotation = ? WHERE id = ?";

        // Sanitizace dat - OPRAVA!
        $rating = $this->sanitizeRating($data['rating'] ?? '');
        $annotation = $this->sanitizeAnnotation($data['annotation'] ?? '');

        $stmt = $this->db->query($sql, [
            $data['title'] ?? '',
            $data['author'] ?? '',
            $data['publication_year'] ?? 0,
            $rating,        // NULL nebo float
            $annotation,    // NULL nebo string
            $id
        ]);

        return $stmt->rowCount() > 0;
    }

    /**
     * Odstraní knihu z databáze
     * 
     * @param int $id ID knihy k odstranění
     * 
     * @return bool True při úspěchu, false při chybě
     */
    public function deleteBook(int $id): bool
    {
        $sql = "DELETE FROM books WHERE id = ?";
        $stmt = $this->db->query($sql, [$id]);
        return $stmt->rowCount() > 0;
    }

    /**
     * Importuje knihy z JSON souboru do databáze
     * 
     * Načte JSON soubor s knihami a přidá je do databáze.
     * Kontroluje duplicity na základě názvu a autora.
     * 
     * @param string $filePath Cesta k JSON souboru
     * 
     * @return array{success: bool, message: string, added?: int, skipped?: int} Výsledek importu
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
            // Kontrola duplicity podle názvu a autora
            $stmt = $this->db->query(
                "SELECT id FROM books WHERE title = ? AND author = ?",
                [$bookData['title'] ?? '', $bookData['author'] ?? '']
            );
            $existing = $stmt->fetchAll();

            if (empty($existing)) {
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

    /**
     * Sanitizuje hodnotu hodnocení
     * 
     * Převede prázdný string nebo neplatnou hodnotu na NULL,
     * jinak vrátí float hodnotu.
     * 
     * @param mixed $rating Hodnota hodnocení
     * 
     * @return float|null Sanitizované hodnocení
     */
    private function sanitizeRating($rating): ?float
    {
        // Pokud je prázdné, vrať NULL
        if ($rating === '' || $rating === null || $rating === 0) {
            return null;
        }

        // Převeď na float
        $floatRating = (float)$rating;

        // Kontrola rozsahu (0-5)
        if ($floatRating < 0 || $floatRating > 5) {
            return null;
        }

        return $floatRating;
    }

    /**
     * Sanitizuje anotaci
     * 
     * Převede prázdný string na NULL, jinak vrátí trimovaný string.
     * 
     * @param mixed $annotation Hodnota anotace
     * 
     * @return string|null Sanitizovaná anotace
     */
    private function sanitizeAnnotation($annotation): ?string
    {
        if ($annotation === '' || $annotation === null) {
            return null;
        }

        $trimmed = trim((string)$annotation);
        return $trimmed === '' ? null : $trimmed;
    }
}
