<h2>Novo Evento</h2>
<form method="POST" action="<?= url('/events/store') ?>">
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
      <label class="form-label">Data do evento</label>
      <input type="date" name="event_date" class="form-control" required>
    </div>
  </div>
  <div class="mb-3">
    <label class="form-label">Título</label>
    <input type="text" name="title" class="form-control" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Descrição</label>
    <textarea name="description" class="form-control" rows="3"></textarea>
  </div>
  <button class="btn btn-primary" type="submit">Salvar</button>
  <a href="<?= url('/events') ?>" class="btn btn-secondary">Cancelar</a>
</form>
