<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Auth;
use App\Core\Database;
use App\Models\Donation;
use App\Models\Institution;

class DonationController extends Controller
{
    public function index(): void
    {
        $donations = (new Donation())->all();
        $this->view('donations/index', ['title' => 'Doações', 'donations' => $donations]);
    }

    public function create(): void
    {
        if (!Auth::check()) { $this->redirect(url('/login')); }
        $inst = (new Institution())->all();
        $this->view('donations/form', ['title' => 'Nova Doação', 'institutions' => $inst]);
    }

    public function store(): void
    {
        if (!Auth::check() || !verify_csrf()) { set_flash('error', 'Ação inválida'); $this->redirect(url('/donations')); }
        $user = Auth::user();
        $data = [
            'user_id' => $user['id'],
            'institution_id' => (int)($_POST['institution_id'] ?? 0),
            'amount' => (float)($_POST['amount'] ?? 0),
            'description' => trim($_POST['description'] ?? ''),
        ];
        if ($data['institution_id'] <= 0 || $data['amount'] <= 0) {
            set_flash('error', 'Dados inválidos');
            $this->redirect(url('/donations/create'));
        }
        (new Donation())->create($data);
        // Increment points: 1 point per real
        $db = Database::getConnection();
        $stmt = $db->prepare('UPDATE users SET points = points + ? WHERE id = ?');
        $stmt->execute([(int)round($data['amount']), $user['id']]);
        set_flash('success', 'Obrigado pela doação! Você ganhou pontos.');
        $this->redirect(url('/donations'));
    }

    public function delete(): void
    {
        if (!Auth::requireRole('admin') || !verify_csrf()) { set_flash('error', 'Ação inválida'); $this->redirect(url('/donations')); }
        $id = (int)($_POST['id'] ?? 0);
        (new Donation())->delete($id);
        set_flash('success', 'Doação removida.');
        $this->redirect(url('/donations'));
    }
}
