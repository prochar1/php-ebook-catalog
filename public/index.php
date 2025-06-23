<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Router;
use App\Controllers\BookController;
use App\Controllers\AuthController;

$router = new Router();

$router->get('/', [BookController::class, 'index']);
$router->get('/books', [BookController::class, 'index']);

$router->get('/books/{id}', [BookController::class, 'show']);

$router->get('/admin', [BookController::class, 'admin']);
$router->post('/admin/import', [BookController::class, 'import']);

$router->get('/admin/books', [BookController::class, 'manage']);
$router->get('/admin/books/create', [BookController::class, 'create']);
$router->post('/admin/books/create', [BookController::class, 'create']);
$router->get('/admin/books/{id}/edit', [BookController::class, 'update']);
$router->post('/admin/books/{id}/edit', [BookController::class, 'update']);
$router->post('/admin/books/{id}/delete', [BookController::class, 'delete']);

$router->get('/admin/login', [AuthController::class, 'login']);
$router->post('/admin/login', [AuthController::class, 'login']);
$router->get('/admin/logout', [AuthController::class, 'logout']);

$router->dispatch();
