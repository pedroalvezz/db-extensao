<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Auth;
use App\Models\Event;
use App\Models\Institution;

class EventController extends Controller
{
    public function index(): void
    {
        $events = (new Event())->all();
        $this->view('events/index', ['title' => 'Eventos', 'events' => $events]);
    }

    public function create(): void
    {
        if (!Auth::check()) { $this->redirect(url('/login')); }
        $inst = (new Institution())->all();
        $this->view('events/form', ['title' => 'Novo Evento', 'institutions' => $inst]);
    }

    public function store(): void
    {
        if (!Auth::check() || !verify_csrf()) { set_flash('error', 'Ação inválida'); $this->redirect(url('/events')); }
        $data = [
            'institution_id' => (int)($_POST['institution_id'] ?? 0),
            'title' => trim($_POST['title'] ?? ''),
            'description' => trim($_POST['description'] ?? ''),
            'event_date' => $_POST['event_date'] ?? '',
        ];
        if ($data['institution_id'] <= 0 || !$data['title'] || !$data['event_date']) {
            set_flash('error', 'Dados inválidos');
            $this->redirect(url('/events/create'));
        }
        (new Event())->create($data);
        set_flash('success', 'Evento criado.');
        $this->redirect(url('/events'));
    }

    public function delete(): void
    {
        if (!Auth::requireRole('admin') || !verify_csrf()) { set_flash('error', 'Ação inválida'); $this->redirect(url('/events')); }
        $id = (int)($_POST['id'] ?? 0);
        (new Event())->delete($id);
        set_flash('success', 'Evento removido.');
        $this->redirect(url('/events'));
    }
}
