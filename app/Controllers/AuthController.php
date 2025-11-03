<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin(): void
    {
        $this->view('auth/login', ['title' => 'Entrar']);
    }

    public function login(): void
    {
        if (!verify_csrf()) {
            set_flash('error', 'Token CSRF inválido.');
            $this->redirect(url('/login'));
        }
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        $userModel = new User();
        $user = $userModel->findByEmail($email);
        if (!$user || !password_verify($password, $user['password_hash'])) {
            set_flash('error', 'Credenciais inválidas.');
            $this->redirect(url('/login'));
        }
        session_regenerate_id(true);
        Auth::attempt($user);
        set_flash('success', 'Login realizado com sucesso.');
        $this->redirect(url('/'));
    }

    public function showRegister(): void
    {
        $this->view('auth/register', ['title' => 'Registrar']);
    }

    public function register(): void
    {
        if (!verify_csrf()) {
            set_flash('error', 'Token CSRF inválido.');
            $this->redirect(url('/register'));
        }

        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $role = in_array(($_POST['role'] ?? 'donor'), ['admin','donor','volunteer']) ? $_POST['role'] : 'donor';

        if (!$name || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 6) {
            set_flash('error', 'Dados inválidos. Senha deve ter no mínimo 6 caracteres.');
            $this->redirect(url('/register'));
        }

        $userModel = new User();
        if ($userModel->findByEmail($email)) {
            set_flash('error', 'E-mail já cadastrado.');
            $this->redirect(url('/register'));
        }
        $userId = $userModel->create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'role' => $role,
        ]);
        set_flash('success', 'Cadastro realizado! Faça login.');
        $this->redirect(url('/login'));
    }

    public function logout(): void
    {
        Auth::logout();
        set_flash('success', 'Você saiu da sua conta.');
        $this->redirect(url('/'));
    }
}
