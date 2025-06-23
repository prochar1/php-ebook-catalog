<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;
use App\Core\Auth;
use App\Models\Book;

/**
 * Controller pro správu knih
 * 
 * Zpracovává požadavky související s knihami - zobrazení katalogu,
 * detailu knihy a administrační operace (CRUD).
 * 
 * @package App\Controllers
 * @author  Radek Procházka
 * @version 1.0
 */
class BookController extends Controller
{
    /**
     * Instance modelu pro práci s knihami
     * 
     * @var Book
     */
    private Book $bookModel;

    /**
     * Konstruktor controlleru
     * 
     * Inicializuje databázové připojení a model pro knihy.
     */
    public function __construct()
    {
        $db = new Database();
        $this->bookModel = new Book($db);
    }

    /**
     * Zobrazí katalog všech knih (hlavní stránka)
     * 
     * Veřejná metoda dostupná všem uživatelům.
     * Načte všechny knihy z databáze a zobrazí je v katalogu.
     * 
     * @return void
     */
    public function index(): void
    {
        $books = $this->bookModel->getAllBooks();

        $this->render('books/index', [
            'books' => $books,
            'title' => 'Katalog e-knih'
        ]);
    }

    /**
     * Zobrazí detail konkrétní knihy
     * 
     * Veřejná metoda pro zobrazení podrobností o knize.
     * Pokud kniha neexistuje, zobrazí stránku "kniha nenalezena".
     * 
     * @param array $params URL parametry obsahující 'id' knihy
     * 
     * @return void
     */
    public function show(array $params): void
    {
        $bookId = (int)$params['id'];
        $book = $this->bookModel->getBookById($bookId);

        if (!$book) {
            $this->render('books/not-found', [
                'bookId' => $bookId,
                'title' => 'Kniha nenalezena'
            ]);
            return;
        }

        $this->render('books/show', [
            'book' => $book,
            'title' => $book['title'] . ' - Detail'
        ]);
    }

    /**
     * Zobrazí hlavní administrační rozhraní
     * 
     * Chráněná metoda - vyžaduje přihlášení administrátora.
     * Zobrazí základní admin dashboard se seznamem knih.
     * 
     * @return void
     */
    public function admin(): void
    {
        Auth::requireLogin();

        $books = $this->bookModel->getAllBooks();

        $this->renderAdmin('admin/index', [
            'books' => $books,
            'title' => 'Administrace knih'
        ]);
    }

    /**
     * Zobrazí pokročilou správu knih
     * 
     * Chráněná metoda pro detailní správu knih s více funkcemi.
     * Zobrazí tabulku se všemi knihami a možnostmi úprav.
     * 
     * @return void
     */
    public function manage(): void
    {
        Auth::requireLogin();

        $books = $this->bookModel->getAllBooks();

        $this->renderAdmin('admin/books/index', [
            'books' => $books,
            'title' => 'Správa knih'
        ]);
    }

    /**
     * Spustí import knih z JSON souboru
     * 
     * Chráněná metoda - importuje knihy ze souboru data/books.json.
     * Zobrazí výsledek importu včetně počtu přidaných a přeskočených knih.
     * 
     * @return void
     */
    public function import(): void
    {
        Auth::requireLogin();

        $result = $this->bookModel->importBooksFromJson(__DIR__ . '/../../data/books.json');

        $this->renderAdmin('admin/books/import', [
            'result' => $result,
            'title' => 'Import knih'
        ]);
    }

    /**
     * Vytvoření nové knihy
     * 
     * Chráněná metoda - zpracovává GET (zobrazí formulář) i POST (uloží data).
     * Po úspěšném vytvoření přesměruje zpět do administrace.
     * 
     * @return void
     */
    public function create(): void
    {
        Auth::requireLogin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $result = $this->bookModel->createBook($_POST);

            if ($result) {
                header('Location: /admin');
                exit;
            }
        }

        $this->renderAdmin('admin/books/create');
    }

    /**
     * Úprava existující knihy
     * 
     * Chráněná metoda - zpracovává GET (zobrazí formulář) i POST (uloží změny).
     * Načte existující data knihy a umožní jejich editaci.
     * 
     * @param array $params URL parametry obsahující 'id' knihy k úpravě
     * 
     * @return void
     */
    public function update(array $params): void
    {
        Auth::requireLogin();

        $bookId = (int)$params['id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $result = $this->bookModel->updateBook($bookId, $_POST);

            if ($result) {
                header('Location: /admin/books/' . $bookId);
                exit;
            }
        }

        $book = $this->bookModel->getBookById($bookId);
        $this->renderAdmin('admin/books/edit', [
            'book' => $book,
            'title' => 'Upravit knihu'
        ]);
    }

    /**
     * Smazání knihy z databáze
     * 
     * Chráněná metoda - zpracovává pouze POST požadavky.
     * Smaže knihu podle ID a přesměruje zpět na seznam knih.
     * 
     * @param array $params URL parametry obsahující 'id' knihy ke smazání
     * 
     * @return void
     */
    public function delete(array $params): void
    {
        Auth::requireLogin();

        $bookId = (int)$params['id'];
        $result = $this->bookModel->deleteBook($bookId);

        if ($result) {
            header('Location: /admin/books');
            exit;
        }

        header('Location: /admin/books/' . $bookId);
        exit;
    }
}
