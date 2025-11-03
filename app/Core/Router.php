<?php
namespace App\Core;

class Router
{
    private array $routes = [
        'GET' => [],
        'POST' => [],
    ];

    public function get(string $path, string $handler): void
    {
        $this->routes['GET'][$this->normalize($path)] = $handler;
    }

    public function post(string $path, string $handler): void
    {
        $this->routes['POST'][$this->normalize($path)] = $handler;
    }

    public function dispatch(string $method, string $path): void
    {
        $method = strtoupper($method);
        // Strip base path if app is running under a subdirectory (APP_URL)
        $base = parse_url(APP_URL, PHP_URL_PATH) ?: '/';
        if ($base !== '/' && str_starts_with($path, $base)) {
            $path = substr($path, strlen($base)) ?: '/';
        }
        $path = $this->normalize($path);
        $handler = $this->routes[$method][$path] ?? null;
        if (!$handler) {
            http_response_code(404);
            echo "404 Not Found";
            return;
        }
        [$controllerName, $action] = explode('@', $handler);
        $controllerClass = 'App\\Controllers\\' . $controllerName;
        if (!class_exists($controllerClass)) {
            http_response_code(500);
            echo "Controller $controllerClass not found";
            return;
        }
        $controller = new $controllerClass();
        if (!method_exists($controller, $action)) {
            http_response_code(500);
            echo "Action $action not found in $controllerClass";
            return;
        }
        $controller->$action();
    }

    private function normalize(string $path): string
    {
        if ($path === '' || $path === false) return '/';
        $path = '/' . trim($path, '/');
        return $path === '' ? '/' : $path;
    }
}
