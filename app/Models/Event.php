<?php
namespace App\Models;

use App\Core\BaseModel;
use PDO;

class Event extends BaseModel
{
    public function all(): array
    {
        $sql = 'SELECT e.*, i.name as institution_name FROM events e
                JOIN institutions i ON i.id = e.institution_id
                ORDER BY e.event_date DESC';
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create(array $data): int
    {
        $stmt = $this->db->prepare('INSERT INTO events (institution_id, title, description, event_date) VALUES (:institution_id, :title, :description, :event_date)');
        $stmt->execute([
            ':institution_id' => $data['institution_id'],
            ':title' => $data['title'],
            ':description' => $data['description'] ?? null,
            ':event_date' => $data['event_date'],
        ]);
        return (int)$this->db->lastInsertId();
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM events WHERE id = ?');
        return $stmt->execute([$id]);
    }
}
