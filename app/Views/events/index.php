<div class="d-flex justify-content-between align-items-center mb-3">
  <h2>Eventos</h2>
  <a class="btn btn-success" href="<?= url('/events/create') ?>">Novo</a>
</div>
<table class="table table-striped">
  <thead><tr><th>Data</th><th>Título</th><th>Instituição</th><th>Ações</th></tr></thead>
  <tbody>
  <?php foreach ($events as $e): ?>
    <tr>
      <td><?= e($e['event_date']) ?></td>
      <td><?= e($e['title']) ?></td>
      <td><?= e($e['institution_name']) ?></td>
      <td>
        <?php if (!empty($_SESSION['user']) && $_SESSION['user']['role']==='admin'): ?>
        <form method="POST" action="<?= url('/events/delete') ?>" style="display:inline" onsubmit="return confirm('Remover?')">
          <?= csrf_field() ?>
          <input type="hidden" name="id" value="<?= (int)$e['id'] ?>">
          <button class="btn btn-sm btn-danger">Apagar</button>
        </form>
        <?php endif; ?>
      </td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
