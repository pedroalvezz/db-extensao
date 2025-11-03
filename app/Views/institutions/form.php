<h2><?= $item ? 'Editar Instituição' : 'Nova Instituição' ?></h2>
<form method="POST" action="<?= $item ? url('/institutions/update') : url('/institutions/store') ?>">
  <?= csrf_field() ?>
  <?php if ($item): ?><input type="hidden" name="id" value="<?= (int)$item['id'] ?>"><?php endif; ?>
  <div class="row">
    <div class="col-md-6 mb-3">
      <label class="form-label">Nome</label>
      <input type="text" name="name" class="form-control" value="<?= e($item['name'] ?? '') ?>" required>
    </div>
    <div class="col-md-6 mb-3">
      <label class="form-label">E-mail</label>
      <input type="email" name="email" class="form-control" value="<?= e($item['email'] ?? '') ?>">
    </div>
  </div>
  <div class="row">
    <div class="col-md-6 mb-3">
      <label class="form-label">Telefone</label>
      <input type="text" name="phone" class="form-control" value="<?= e($item['phone'] ?? '') ?>">
    </div>
    <div class="col-md-6 mb-3">
      <label class="form-label">Endereço</label>
      <input type="text" name="address" class="form-control" value="<?= e($item['address'] ?? '') ?>">
    </div>
  </div>
  <div class="mb-3">
    <label class="form-label">Descrição</label>
    <textarea name="description" class="form-control" rows="3"><?= e($item['description'] ?? '') ?></textarea>
  </div>
  <button class="btn btn-primary" type="submit">Salvar</button>
  <a href="<?= url('/institutions') ?>" class="btn btn-secondary">Cancelar</a>
</form>
