<?php
namespace App\Models;

use App\Core\BaseModel;
use PDO;

class Institution extends BaseModel
{
    public function all(): array
    {
        $stmt = $this->db->query('SELECT * FROM institutions ORDER BY created_at DESC');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM institutions WHERE id = ?');
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public function create(array $data): int
    {
        $stmt = $this->db->prepare('INSERT INTO institutions (name, description, email, phone, address) VALUES (:name, :description, :email, :phone, :address)');
        $stmt->execute([
            ':name' => $data['name'],
            ':description' => $data['description'] ?? null,
            ':email' => $data['email'] ?? null,
            ':phone' => $data['phone'] ?? null,
            ':address' => $data['address'] ?? null,
        ]);
        return (int)$this->db->lastInsertId();
    }

    public function update(int $id, array $data): bool
    {
        $stmt = $this->db->prepare('UPDATE institutions SET name=:name, description=:description, email=:email, phone=:phone, address=:address WHERE id=:id');
        return $stmt->execute([
            ':id' => $id,
            ':name' => $data['name'],
            ':description' => $data['description'] ?? null,
            ':email' => $data['email'] ?? null,
            ':phone' => $data['phone'] ?? null,
            ':address' => $data['address'] ?? null,
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM institutions WHERE id = ?');
        return $stmt->execute([$id]);
    }
}
