<h2>Nova Doação</h2>
<form method="POST" action="<?= url('/donations/store') ?>">
  <?= csrf_field() ?>
  <div class="row">
    <div class="col-md-6 mb-3">
      <label class="form-label">Instituição</label>
      <select name="institution_id" class="form-select" required>
        <option value="">Selecione</option>
        <?php foreach ($institutions as $i): ?>
          <option value="<?= (int)$i['id'] ?>"><?= e($i['name']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-md-6 mb-3">
      <label class="form-label">Valor (R$)</label>
      <input type="number" step="0.01" min="1" name="amount" class="form-control" required>
    </div>
  </div>
  <div class="mb-3">
    <label class="form-label">Descrição (opcional)</label>
    <input type="text" name="description" class="form-control">
  </div>
  <button class="btn btn-primary" type="submit">Doar</button>
  <a href="<?= url('/donations') ?>" class="btn btn-secondary">Cancelar</a>
</form>
