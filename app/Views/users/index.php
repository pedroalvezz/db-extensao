<div class="d-flex justify-content-between align-items-center mb-3">
  <h2>Usuários</h2>
  <a class="btn btn-success" href="<?= url('/users/create') ?>">Novo</a>
</div>
<table class="table table-striped">
  <thead><tr><th>Nome</th><th>Email</th><th>Perfil</th><th>Pontos</th><th>Ações</th></tr></thead>
  <tbody>
  <?php foreach ($users as $u): ?>
    <tr>
      <td><?= e($u['name']) ?></td>
      <td><?= e($u['email']) ?></td>
      <td><?= e($u['role']) ?></td>
      <td><?= (int)($u['points'] ?? 0) ?></td>
      <td>
        <a class="btn btn-sm btn-primary" href="<?= url('/users/edit') . '?id=' . (int)$u['id'] ?>">Editar</a>
        <form method="POST" action="<?= url('/users/delete') ?>" style="display:inline" onsubmit="return confirm('Remover?')">
          <?= csrf_field() ?>
          <input type="hidden" name="id" value="<?= (int)$u['id'] ?>">
          <button class="btn btn-sm btn-danger">Apagar</button>
        </form>
      </td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
