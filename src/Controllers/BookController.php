<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;
use App\Core\Auth;
use App\Models\Book;

class BookController extends Controller
{
    private Book $bookModel;

    public function __construct()
    {
        $db = new Database();
        $this->bookModel = new Book($db);
    }

    public function index(): void
    {
        $books = $this->bookModel->getAllBooks();

        $this->render('books/index', [
            'books' => $books,
            'title' => 'Katalog e-knih'
        ]);
    }

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

    public function admin(): void
    {
        Auth::requireLogin();

        $books = $this->bookModel->getAllBooks();

        $this->renderAdmin('admin/index', [
            'books' => $books,
            'title' => 'Administrace knih'
        ]);
    }

    public function manage(): void
    {
        Auth::requireLogin();

        $books = $this->bookModel->getAllBooks();

        $this->renderAdmin('admin/books/index', [
            'books' => $books,
            'title' => 'Správa knih'
        ]);
    }

    public function import(): void
    {
        Auth::requireLogin();

        $result = $this->bookModel->importBooksFromJson(__DIR__ . '/../../data/books.json');

        $this->renderAdmin('admin/books/import', [
            'result' => $result,
            'title' => 'Import knih'
        ]);
    }

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

        $this->renderAdmin('admin/books/create', [
            'title' => 'Přidat knihu'
        ]);
    }

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
