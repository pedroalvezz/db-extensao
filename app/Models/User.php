<?php
namespace App\Models;

use App\Core\BaseModel;
use PDO;

class User extends BaseModel
{
    public function findByEmail(string $email): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ?: null;
    }

    public function create(array $data): int
    {
        $stmt = $this->db->prepare('INSERT INTO users (name, email, password_hash, role) VALUES (:name, :email, :password_hash, :role)');
        $stmt->execute([
            ':name' => $data['name'],
            ':email' => $data['email'],
            ':password_hash' => password_hash($data['password'], PASSWORD_BCRYPT),
            ':role' => $data['role'] ?? 'donor',
        ]);
        return (int)$this->db->lastInsertId();
    }
}
