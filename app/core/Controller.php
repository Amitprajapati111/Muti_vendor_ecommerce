<?php

class Controller
{
    protected function view(string $view, array $data = [], bool $useLayout = true): void
    {
        extract($data);
        $viewFile = APP_PATH . '/views/' . $view . '.php';
        if (!file_exists($viewFile)) {
            throw new RuntimeException("View not found: {$view}");
        }
        if ($useLayout) {
            include APP_PATH . '/views/layout/header.php';
            include APP_PATH . '/views/layout/navbar.php';
            include $viewFile;
            include APP_PATH . '/views/layout/footer.php';
            include APP_PATH . '/views/layout/scripts.php';
        } else {
            include $viewFile;
        }
    }
}
