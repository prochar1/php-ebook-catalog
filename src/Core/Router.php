<?php

namespace App\Core;

/**
 * HTTP Router pro směrování požadavků
 * 
 * Jednoduchý router implementující základní HTTP routing
 * s podporou parametrů v URL a RESTful routes.
 * 
 * @package App\Core
 * @author  Radek Procházka
 * @version 1.0
 */
class Router
{
    /**
     * Pole registrovaných rout
     * 
     * @var array<array{method: string, pattern: string, handler: callable|array}>
     */
    private array $routes = [];

    /**
     * Základní cesta aplikace
     * 
     * @var string
     */
    private string $basePath;

    /**
     * Konstruktor routeru
     * 
     * @param string $basePath Základní cesta aplikace (výchozí prázdná)
     */
    public function __construct(string $basePath = '')
    {
        $this->basePath = rtrim($basePath, '/');
    }

    /**
     * Registruje GET routu
     * 
     * @param string          $pattern URL pattern s volitelnými parametry {param}
     * @param callable|array  $handler Callback funkce nebo [Controller::class, 'method']
     * 
     * @return void
     */
    public function get(string $pattern, callable|array $handler): void
    {
        $this->addRoute('GET', $pattern, $handler);
    }

    /**
     * Registruje POST routu
     * 
     * @param string          $pattern URL pattern s volitelnými parametry {param}
     * @param callable|array  $handler Callback funkce nebo [Controller::class, 'method']
     * 
     * @return void
     */
    public function post(string $pattern, callable|array $handler): void
    {
        $this->addRoute('POST', $pattern, $handler);
    }

    /**
     * Přidá routu do registru
     * 
     * @param string          $method  HTTP metoda (GET, POST, atd.)
     * @param string          $pattern URL pattern
     * @param callable|array  $handler Handler pro zpracování požadavku
     * 
     * @return void
     */
    private function addRoute(string $method, string $pattern, callable|array $handler): void
    {
        $this->routes[] = [
            'method' => $method,
            'pattern' => $pattern,
            'handler' => $handler
        ];
    }

    /**
     * Zpracuje HTTP požadavek a najde odpovídající routu
     * 
     * Projde všechny registrované routy a najde první shodu.
     * Pokud není nalezena žádná routa, zobrazí 404 chybu.
     * 
     * @return void
     */
    public function dispatch(): void
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $requestUri = $_GET['url'] ?? '';
        $requestUri = '/' . trim($requestUri, '/');

        foreach ($this->routes as $route) {
            if ($route['method'] !== $requestMethod) {
                continue;
            }

            $params = $this->matchRoute($route['pattern'], $requestUri);
            if ($params !== false) {
                $this->callHandler($route['handler'], $params);
                return;
            }
        }

        $this->handle404();
    }

    /**
     * Ověří shodu URL s pattern routy
     * 
     * @param string $pattern URL pattern s parametry {param}
     * @param string $uri     Aktuální URI z požadavku
     * 
     * @return array|false Pole parametrů při shodě, false při neshodě
     */
    private function matchRoute(string $pattern, string $uri): array|false
    {
        // Převedeme pattern na regex
        $pattern = preg_replace('/\{([^}]+)\}/', '(?P<$1>[^/]+)', $pattern);
        $pattern = '#^' . $pattern . '$#';

        if (preg_match($pattern, $uri, $matches)) {
            // Filtrujeme pouze pojmenované parametry
            return array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
        }

        return false;
    }

    /**
     * Zavolá handler pro zpracování požadavku
     * 
     * @param callable|array $handler Callback nebo [Controller::class, 'method']
     * @param array          $params  Parametry extrahované z URL
     * 
     * @return void
     */
    private function callHandler(callable|array $handler, array $params): void
    {
        if (is_array($handler)) {
            [$controller, $method] = $handler;
            $controllerInstance = new $controller();
            $controllerInstance->$method($params);
        } else {
            $handler($params);
        }
    }

    /**
     * Zpracuje 404 chybu - stránka nenalezena
     * 
     * @return void
     */
    private function handle404(): void
    {
        http_response_code(404);

        $view404 = __DIR__ . '/../Views/404.php';

        if (file_exists($view404)) {
            require_once $view404;
        } else {
            echo '<h1>404 - Stránka nenalezena</h1>';
            echo '<p><a href="/">Zpět na hlavní stránku</a></p>';
        }
    }
}
