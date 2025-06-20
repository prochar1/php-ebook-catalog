<?php

namespace App\Core;

class Router
{
    private array $routes = [];
    private string $basePath;

    public function __construct(string $basePath = '')
    {
        $this->basePath = rtrim($basePath, '/');
    }

    public function get(string $pattern, callable|array $handler): void
    {
        $this->addRoute('GET', $pattern, $handler);
    }

    public function post(string $pattern, callable|array $handler): void
    {
        $this->addRoute('POST', $pattern, $handler);
    }

    private function addRoute(string $method, string $pattern, callable|array $handler): void
    {
        $this->routes[] = [
            'method' => $method,
            'pattern' => $pattern,
            'handler' => $handler
        ];
    }

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

        // 404 Not Found
        $this->handle404();
    }

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

    private function handle404(): void
    {
        header("HTTP/1.0 404 Not Found");
        require_once __DIR__ . '/Views/404.php';
    }
}
