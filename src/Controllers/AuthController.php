<?php

namespace App\Controllers;

use App\Core\Controller;

/**
 * Controller pro autentizaci administrátora
 * 
 * Zpracovává přihlašování a odhlašování do administrace aplikace.
 * Poskytuje zabezpečení přístupu do admin sekce pomocí hesla.
 * 
 * @package App\Controllers
 * @author  Radek Procházka
 * @version 1.0
 */
class AuthController extends Controller
{
    /**
     * Přihlášení administrátora
     * 
     * Zpracovává GET (zobrazí login formulář) i POST (ověří heslo) požadavky.
     * Při správném heslu vytvoří admin session a přesměruje do administrace.
     * Při chybném heslu zobrazí chybovou zprávu.
     * 
     * @param array $params URL parametry (nevyužité)
     * 
     * @return void
     */
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
                $this->renderAdmin('admin/login', [
                    'error' => 'Nesprávné heslo',
                    'title' => 'Přihlášení'
                ]);
                return;
            }
        }

        // GET request - zobraz login formulář
        $this->renderAdmin('admin/login', [
            'title' => 'Přihlášení'
        ]);
    }

    /**
     * Odhlášení administrátora
     * 
     * Zruší admin session, ukončí celou session a přesměruje
     * uživatele zpět na hlavní stránku aplikace.
     * 
     * @param array $params URL parametry (nevyužité)
     * 
     * @return void
     */
    public function logout(array $params): void
    {
        unset($_SESSION['admin_logged_in']);
        session_destroy();
        $this->redirect('/');
    }
}
