<h2><?= $user ? 'Editar Usuário' : 'Novo Usuário' ?></h2>
<form method="POST" action="<?= $user ? url('/users/update') : url('/users/store') ?>">
  <?= csrf_field() ?>
  <?php if ($user): ?><input type="hidden" name="id" value="<?= (int)$user['id'] ?>"><?php endif; ?>
  <div class="row">
    <div class="col-md-6 mb-3">
      <label class="form-label">Nome</label>
      <input type="text" name="name" class="form-control" value="<?= e($user['name'] ?? '') ?>" required>
    </div>
    <div class="col-md-6 mb-3">
      <label class="form-label">E-mail</label>
      <input type="email" name="email" class="form-control" value="<?= e($user['email'] ?? '') ?>" <?= $user ? 'readonly' : '' ?> required>
    </div>
  </div>
  <?php if (!$user): ?>
  <div class="row">
    <div class="col-md-6 mb-3">
      <label class="form-label">Senha</label>
      <input type="password" name="password" class="form-control" minlength="6" required>
    </div>
  </div>
  <?php endif; ?>
  <div class="mb-3">
    <label class="form-label">Perfil</label>
    <select name="role" class="form-select">
      <option value="donor" <?= isset($user['role']) && $user['role']==='donor' ? 'selected' : '' ?>>Doador</option>
      <option value="volunteer" <?= isset($user['role']) && $user['role']==='volunteer' ? 'selected' : '' ?>>Voluntário</option>
      <option value="admin" <?= isset($user['role']) && $user['role']==='admin' ? 'selected' : '' ?>>Admin</option>
    </select>
  </div>
  <button class="btn btn-primary" type="submit">Salvar</button>
  <a href="<?= url('/users') ?>" class="btn btn-secondary">Cancelar</a>
</form>
