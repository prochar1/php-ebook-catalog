<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Router;
use App\Controllers\BookController;

$router = new Router();

$router->get('/', [BookController::class, 'index']);
$router->get('/books', [BookController::class, 'index']);
$router->get('/books/{id}', [BookController::class, 'show']);

$router->get('/admin', [BookController::class, 'admin']);
$router->post('/admin/import', [BookController::class, 'import']);

$router->get('/books/create', [BookController::class, 'create']);
$router->post('/books/create', [BookController::class, 'create']);

$router->get('/books/{id}/edit', [BookController::class, 'update']);
$router->post('/books/{id}/edit', [BookController::class, 'update']);

$router->post('/books/{id}/delete', [BookController::class, 'delete']);

$router->dispatch();
