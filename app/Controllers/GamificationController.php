<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;

class GamificationController extends Controller
{
    public function leaderboard(): void
    {
        $db = Database::getConnection();
        $rows = $db->query('SELECT name, points FROM users ORDER BY points DESC, name ASC LIMIT 20')->fetchAll();
        $this->view('gamification/leaderboard', ['title' => 'Leaderboard', 'rows' => $rows]);
    }

    public function transparencyWall(): void
    {
        $db = Database::getConnection();
        $sql = 'SELECT d.donated_at, d.amount, d.description, u.name as user_name, i.name as institution_name
                FROM donations d
                JOIN users u ON u.id = d.user_id
                JOIN institutions i ON i.id = d.institution_id
                ORDER BY d.donated_at DESC LIMIT 50';
        $rows = $db->query($sql)->fetchAll();
        $this->view('gamification/transparency', ['title' => 'Mural da Transparência', 'rows' => $rows]);
    }
}
