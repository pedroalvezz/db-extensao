<div class="d-flex justify-content-between align-items-center mb-3">
  <h2>Doações</h2>
  <a class="btn btn-success" href="<?= url('/donations/create') ?>">Nova</a>
</div>
<table class="table table-striped">
  <thead><tr><th>Data</th><th>Instituição</th><th>Doador</th><th>Valor</th><th>Descrição</th><th>Ações</th></tr></thead>
  <tbody>
  <?php foreach ($donations as $d): ?>
    <tr>
      <td><?= e($d['donated_at']) ?></td>
      <td><?= e($d['institution_name']) ?></td>
      <td><?= e($d['user_name']) ?></td>
      <td>R$ <?= number_format((float)$d['amount'], 2, ',', '.') ?></td>
      <td><?= e($d['description'] ?? '') ?></td>
      <td>
        <?php if (!empty($_SESSION['user']) && $_SESSION['user']['role']==='admin'): ?>
        <form method="POST" action="<?= url('/donations/delete') ?>" style="display:inline" onsubmit="return confirm('Remover?')">
          <?= csrf_field() ?>
          <input type="hidden" name="id" value="<?= (int)$d['id'] ?>">
          <button class="btn btn-sm btn-danger">Apagar</button>
        </form>
        <?php endif; ?>
      </td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
