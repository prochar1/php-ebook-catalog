<?php

namespace App\Controllers;

use App\Core\Controller;

class AuthController extends Controller
{
    public function login(array $params): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $password = $_POST['password'] ?? '';

            // Heslo z config.php
            if ($password === ADMIN_PASSWORD) {
                $_SESSION['admin_logged_in'] = true;
                $this->redirect('/admin');
                return;
            } else {
                $this->render('admin/login', [
                    'error' => 'Nesprávné heslo',
                    'title' => 'Přihlášení'
                ]);
                return;
            }
        }

        // GET request - zobraz login formulář
        $this->render('admin/login', [
            'title' => 'Přihlášení'
        ]);
    }

    public function logout(array $params): void
    {
        unset($_SESSION['admin_logged_in']);
        session_destroy();
        $this->redirect('/');
    }
}
