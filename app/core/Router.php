<?php

class Router
{
    // Can be a class name (before instantiation) or a controller instance after
    protected $controller = 'HomeController';
    protected string $method = 'index';
    protected array $params = [];

    public function __construct()
    {
        $url = $this->parseUrl();

        // Controller
        if (!empty($url[0])) {
            $candidate = ucfirst($url[0]) . 'Controller';
            if (file_exists(APP_PATH . '/controllers/' . $candidate . '.php')) {
                $this->controller = $candidate;
                unset($url[0]);
            }
        }
        $controllerClass = $this->controller;
        $this->controller = new $controllerClass();

        // Method
        if (!empty($url[1]) && method_exists($this->controller, $url[1])) {
            $this->method = $url[1];
            unset($url[1]);
        }

        // Params
        $this->params = $url ? array_values($url) : [];
    }

    public function dispatch(): void
    {
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    private function parseUrl(): array
    {
        $url = $_GET['url'] ?? '';
        $url = filter_var(rtrim($url, '/'), FILTER_SANITIZE_URL);
        // Support both path and query style
        if ($url === '' && isset($_SERVER['REQUEST_URI'])) {
            $request = strtok($_SERVER['REQUEST_URI'], '?');
            $scriptDir = rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? ''), '/');
            if ($scriptDir && str_starts_with($request, $scriptDir)) {
                $request = substr($request, strlen($scriptDir));
            }
            $url = trim($request, '/');
        }
        return $url ? explode('/', $url) : [];
    }
}
