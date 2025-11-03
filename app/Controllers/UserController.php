<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Auth;
use App\Models\User;
use App\Core\Database;

class UserController extends Controller
{
    public function index(): void
    {
        $db = Database::getConnection();
        $users = $db->query('SELECT id, name, email, role, points, created_at FROM users ORDER BY created_at DESC')->fetchAll();
        $this->view('users/index', ['title' => 'Usuários', 'users' => $users]);
    }

    public function create(): void
    {
        if (!Auth::requireRole('admin')) { set_flash('error', 'Acesso negado'); $this->redirect(url('/users')); }
        $this->view('users/form', ['title' => 'Novo Usuário', 'user' => null]);
    }

    public function store(): void
    {
        if (!Auth::requireRole('admin') || !verify_csrf()) { set_flash('error', 'Ação inválida'); $this->redirect(url('/users')); }
        $data = [
            'name' => trim($_POST['name'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'password' => $_POST['password'] ?? '',
            'role' => $_POST['role'] ?? 'donor',
        ];
        (new User())->create($data);
        set_flash('success', 'Usuário criado.');
        $this->redirect(url('/users'));
    }

    public function edit(): void
    {
        if (!Auth::requireRole('admin')) { set_flash('error', 'Acesso negado'); $this->redirect(url('/users')); }
        $id = (int)($_GET['id'] ?? 0);
        $db = Database::getConnection();
        $stmt = $db->prepare('SELECT id, name, email, role FROM users WHERE id=?');
        $stmt->execute([$id]);
        $user = $stmt->fetch();
        $this->view('users/form', ['title' => 'Editar Usuário', 'user' => $user]);
    }

    public function update(): void
    {
        if (!Auth::requireRole('admin') || !verify_csrf()) { set_flash('error', 'Ação inválida'); $this->redirect(url('/users')); }
        $id = (int)($_POST['id'] ?? 0);
        $name = trim($_POST['name'] ?? '');
        $role = $_POST['role'] ?? 'donor';
        $db = Database::getConnection();
        $stmt = $db->prepare('UPDATE users SET name=?, role=? WHERE id=?');
        $stmt->execute([$name, $role, $id]);
        set_flash('success', 'Usuário atualizado.');
        $this->redirect(url('/users'));
    }

    public function delete(): void
    {
        if (!Auth::requireRole('admin') || !verify_csrf()) { set_flash('error', 'Ação inválida'); $this->redirect(url('/users')); }
        $id = (int)($_POST['id'] ?? 0);
        $db = Database::getConnection();
        $stmt = $db->prepare('DELETE FROM users WHERE id=?');
        $stmt->execute([$id]);
        set_flash('success', 'Usuário removido.');
        $this->redirect(url('/users'));
    }
}
