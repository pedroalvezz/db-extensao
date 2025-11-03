<?php
use App\Core\Controller;

function csrf_token(): string {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function csrf_field(): string {
    $token = htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8');
    return '<input type="hidden" name="_token" value="' . $token . '">';
}

function verify_csrf(): bool {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $token = $_POST['_token'] ?? '';
        return hash_equals($_SESSION['csrf_token'] ?? '', $token);
    }
    return true;
}

function e(string $value): string {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function url(string $path): string {
    $base = APP_URL;
    if ($path === '/') return $base . '/';
    return rtrim($base, '/') . '/' . ltrim($path, '/');
}

function set_flash(string $key, string $message): void {
    $_SESSION['flash'][$key] = $message;
}

function get_flash(string $key): ?string {
    if (!empty($_SESSION['flash'][$key])) {
        $msg = $_SESSION['flash'][$key];
        unset($_SESSION['flash'][$key]);
        return $msg;
    }
    return null;
}
