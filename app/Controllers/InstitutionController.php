<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Auth;
use App\Models\Institution;

class InstitutionController extends Controller
{
    public function index(): void
    {
        $model = new Institution();
        $this->view('institutions/index', [
            'title' => 'Instituições',
            'items' => $model->all(),
        ]);
    }

    public function create(): void
    {
        if (!Auth::check()) { $this->redirect(url('/login')); }
        $this->view('institutions/form', [
            'title' => 'Nova Instituição',
            'item' => null,
        ]);
    }

    public function store(): void
    {
        if (!Auth::check() || !verify_csrf()) { set_flash('error', 'Ação inválida'); $this->redirect(url('/institutions')); }
        $data = [
            'name' => trim($_POST['name'] ?? ''),
            'description' => trim($_POST['description'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'phone' => trim($_POST['phone'] ?? ''),
            'address' => trim($_POST['address'] ?? ''),
        ];
        if (!$data['name']) { set_flash('error', 'Nome é obrigatório'); $this->redirect(url('/institutions/create')); }
        (new Institution())->create($data);
        set_flash('success', 'Instituição criada.');
        $this->redirect(url('/institutions'));
    }

    public function edit(): void
    {
        if (!Auth::check()) { $this->redirect(url('/login')); }
        $id = (int)($_GET['id'] ?? 0);
        $item = (new Institution())->find($id);
        if (!$item) { set_flash('error', 'Registro não encontrado'); $this->redirect(url('/institutions')); }
        $this->view('institutions/form', ['title' => 'Editar Instituição', 'item' => $item]);
    }

    public function update(): void
    {
        if (!Auth::check() || !verify_csrf()) { set_flash('error', 'Ação inválida'); $this->redirect(url('/institutions')); }
        $id = (int)($_POST['id'] ?? 0);
        $data = [
            'name' => trim($_POST['name'] ?? ''),
            'description' => trim($_POST['description'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'phone' => trim($_POST['phone'] ?? ''),
            'address' => trim($_POST['address'] ?? ''),
        ];
        (new Institution())->update($id, $data);
        set_flash('success', 'Instituição atualizada.');
        $this->redirect(url('/institutions'));
    }

    public function delete(): void
    {
        if (!Auth::check() || !verify_csrf()) { set_flash('error', 'Ação inválida'); $this->redirect(url('/institutions')); }
        $id = (int)($_POST['id'] ?? 0);
        (new Institution())->delete($id);
        set_flash('success', 'Instituição removida.');
        $this->redirect(url('/institutions'));
    }
}
