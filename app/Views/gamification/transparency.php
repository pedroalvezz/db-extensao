<h2>Mural da Transparência</h2>
<table class="table table-hover">
  <thead><tr><th>Data</th><th>Instituição</th><th>Doador</th><th>Valor</th><th>Descrição</th></tr></thead>
  <tbody>
  <?php foreach ($rows as $r): ?>
    <tr>
      <td><?= e($r['donated_at']) ?></td>
      <td><?= e($r['institution_name']) ?></td>
      <td><?= e($r['user_name']) ?></td>
      <td>R$ <?= number_format((float)$r['amount'], 2, ',', '.') ?></td>
      <td><?= e($r['description'] ?? '') ?></td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
