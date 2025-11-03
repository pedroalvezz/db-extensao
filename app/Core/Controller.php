<?php
namespace App\Core;

class Controller
{
    protected function view(string $template, array $data = []): void
    {
        extract($data);
        $viewFile = BASE_PATH . '/app/Views/' . $template . '.php';
        $layoutFile = BASE_PATH . '/app/Views/layout.php';
        ob_start();
        if (file_exists($viewFile)) {
            include $viewFile;
        } else {
            echo "View $template not found";
        }
        $content = ob_get_clean();
        include $layoutFile;
    }

    protected function redirect(string $path): void
    {
        header('Location: ' . $path);
        exit;
    }
}
