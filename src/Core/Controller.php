<?php

namespace App\Core;

class Controller
{
    protected function render(string $view, array $data = [], string $layout = 'layout'): void
    {
        extract($data);

        ob_start();
        require_once __DIR__ . "/../Views/{$view}.php";
        $content = ob_get_clean();

        require_once __DIR__ . "/../Views/{$layout}.php";
    }

    protected function renderAdmin(string $view, array $data = []): void
    {
        $this->render($view, $data, 'admin-layout');
    }
}
