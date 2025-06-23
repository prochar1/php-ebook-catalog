<?php

namespace App\Core;

/**
 * Základní controller třída
 * 
 * Poskytuje základní funkcionalitu pro všechny controllery
 * včetně renderování view a helper metod.
 * 
 * @package App\Core
 * @author  Radek Procházka
 * @version 1.0
 */
class Controller
{
    /**
     * Renderuje view s layoutem
     * 
     * @param string $view   Cesta k view souboru (bez .php)
     * @param array  $data   Data pro předání do view
     * @param string $layout Layout soubor (výchozí 'layout')
     * 
     * @return void
     */
    protected function render(string $view, array $data = [], string $layout = 'layout'): void
    {
        // Extrahuj data jako proměnné
        extract($data);

        // Zachyť obsah view
        ob_start();
        require_once __DIR__ . "/../Views/{$view}.php";
        $content = ob_get_clean();

        // Renderuj s layoutem
        require_once __DIR__ . "/../Views/{$layout}.php";
    }

    /**
     * Renderuje admin view s admin layoutem
     * 
     * @param string $view Cesta k view souboru
     * @param array  $data Data pro předání do view
     * 
     * @return void
     */
    protected function renderAdmin(string $view, array $data = []): void
    {
        $this->render($view, $data, 'layout-admin');
    }

    /**
     * Přesměruje na zadanou URL
     * 
     * @param string $url Cílová URL
     * 
     * @return void
     */
    protected function redirect(string $url): void
    {
        header('Location: ' . $url);
        exit;
    }

    /**
     * Vrátí JSON odpověď
     * 
     * @param array $data       Data k vrácení jako JSON
     * @param int   $statusCode HTTP status kod (výchozí 200)
     * 
     * @return void
     */
    protected function json(array $data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    /**
     * Zobrazí 404 chybu
     * 
     * @return void
     */
    protected function notFound(): void
    {
        http_response_code(404);
        $this->render('errors/404', [
            'title' => 'Stránka nenalezena'
        ]);
    }

    /**
     * Zobrazí 403 chybu (zakázaný přístup)
     * 
     * @return void
     */
    protected function forbidden(): void
    {
        http_response_code(403);
        $this->render('errors/403', [
            'title' => 'Přístup zakázán'
        ]);
    }
}
