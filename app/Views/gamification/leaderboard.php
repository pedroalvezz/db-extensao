<h2>Leaderboard</h2>
<table class="table table-striped">
  <thead><tr><th>#</th><th>Nome</th><th>Pontos</th></tr></thead>
  <tbody>
  <?php $pos=1; foreach ($rows as $r): ?>
    <tr>
      <td><?= $pos++ ?></td>
      <td><?= e($r['name']) ?></td>
      <td><?= (int)$r['points'] ?></td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
