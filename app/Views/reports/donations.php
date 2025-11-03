<h2>Relatório de Doações</h2>
<form class="row g-2 mb-3" method="GET" action="<?= url('/reports/donations') ?>">
  <div class="col-auto">
    <label class="form-label">De</label>
    <input type="date" class="form-control" name="from" value="<?= e($from) ?>">
  </div>
  <div class="col-auto">
    <label class="form-label">Até</label>
    <input type="date" class="form-control" name="to" value="<?= e($to) ?>">
  </div>
  <div class="col-auto align-self-end">
    <button class="btn btn-primary" type="submit">Filtrar</button>
  </div>
  </form>
<table class="table table-striped">
  <thead><tr><th>Data</th><th>Quantidade</th><th>Total (R$)</th></tr></thead>
  <tbody>
  <?php foreach ($rows as $r): ?>
    <tr>
      <td><?= e($r['date']) ?></td>
      <td><?= (int)$r['count'] ?></td>
      <td>R$ <?= number_format((float)$r['total'], 2, ',', '.') ?></td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
