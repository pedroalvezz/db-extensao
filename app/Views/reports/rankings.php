<div class="row">
  <div class="col-md-6">
    <h3>Instituições por Total Doado</h3>
    <table class="table table-striped">
      <thead><tr><th>Instituição</th><th>Doações</th><th>Total (R$)</th></tr></thead>
      <tbody>
        <?php foreach ($byInstitution as $r): ?>
          <tr>
            <td><?= e($r['name']) ?></td>
            <td><?= (int)$r['donations_count'] ?></td>
            <td>R$ <?= number_format((float)$r['total_amount'], 2, ',', '.') ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <div class="col-md-6">
    <h3>Doadores por Total Doado</h3>
    <table class="table table-striped">
      <thead><tr><th>Nome</th><th>Doações</th><th>Total (R$)</th></tr></thead>
      <tbody>
        <?php foreach ($byUser as $r): ?>
          <tr>
            <td><?= e($r['name']) ?></td>
            <td><?= (int)$r['donations_count'] ?></td>
            <td>R$ <?= number_format((float)$r['total_amount'], 2, ',', '.') ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
