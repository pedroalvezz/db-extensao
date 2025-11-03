<?php
namespace App\Models;

use App\Core\BaseModel;
use PDO;

class Donation extends BaseModel
{
    public function all(): array
    {
        $sql = 'SELECT d.*, u.name as user_name, i.name as institution_name FROM donations d
                JOIN users u ON u.id = d.user_id
                JOIN institutions i ON i.id = d.institution_id
                ORDER BY d.donated_at DESC';
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create(array $data): int
    {
        $stmt = $this->db->prepare('INSERT INTO donations (user_id, institution_id, amount, description, donated_at) VALUES (:user_id, :institution_id, :amount, :description, NOW())');
        $stmt->execute([
            ':user_id' => $data['user_id'],
            ':institution_id' => $data['institution_id'],
            ':amount' => $data['amount'],
            ':description' => $data['description'] ?? null,
        ]);
        return (int)$this->db->lastInsertId();
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM donations WHERE id = ?');
        return $stmt->execute([$id]);
    }

    public function totalByInstitution(): array
    {
        $sql = 'SELECT i.id, i.name, COUNT(d.id) as donations_count, COALESCE(SUM(d.amount),0) as total_amount
                FROM institutions i
                LEFT JOIN donations d ON d.institution_id = i.id
                GROUP BY i.id, i.name
                ORDER BY total_amount DESC';
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function totalByUser(): array
    {
        $sql = 'SELECT u.id, u.name, COUNT(d.id) as donations_count, COALESCE(SUM(d.amount),0) as total_amount
                FROM users u
                LEFT JOIN donations d ON d.user_id = u.id
                GROUP BY u.id, u.name
                ORDER BY total_amount DESC';
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function totalByDateRange(string $from, string $to): array
    {
        $stmt = $this->db->prepare('SELECT DATE(donated_at) as date, COUNT(*) as count, SUM(amount) as total
                                     FROM donations WHERE donated_at BETWEEN ? AND ?
                                     GROUP BY DATE(donated_at) ORDER BY date');
        $stmt->execute([$from, $to]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
