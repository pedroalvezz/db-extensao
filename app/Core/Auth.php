<?php
namespace App\Core;

class Auth
{
    public static function check(): bool
    {
        return !empty($_SESSION['user']);
    }

    public static function user(): ?array
    {
        return $_SESSION['user'] ?? null;
    }

    public static function attempt(array $user): void
    {
        // Minimal user data in session
        $_SESSION['user'] = [
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'role' => $user['role'],
        ];
    }

    public static function logout(): void
    {
        unset($_SESSION['user']);
        session_regenerate_id(true);
    }

    public static function requireRole(string $role): bool
    {
        $u = self::user();
        return $u && $u['role'] === $role;
    }
}
