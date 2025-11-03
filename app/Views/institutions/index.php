<div class="d-flex justify-content-between align-items-center mb-3">
  <h2>Instituições</h2>
  <a class="btn btn-success" href="<?= url('/institutions/create') ?>">Nova</a>
</div>
<table class="table table-striped">
  <thead><tr><th>Nome</th><th>Contato</th><th>Ações</th></tr></thead>
  <tbody>
  <?php foreach ($items as $i): ?>
    <tr>
      <td><?= e($i['name']) ?></td>
      <td><?= e($i['email'] ?: '-') ?> | <?= e($i['phone'] ?: '-') ?></td>
      <td>
        <a class="btn btn-sm btn-primary" href="<?= url('/institutions/edit') . '?id=' . (int)$i['id'] ?>">Editar</a>
        <form method="POST" action="<?= url('/institutions/delete') ?>" style="display:inline" onsubmit="return confirm('Remover?')">
          <?= csrf_field() ?>
          <input type="hidden" name="id" value="<?= (int)$i['id'] ?>">
          <button class="btn btn-sm btn-danger">Apagar</button>
        </form>
      </td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
