<div class="row justify-content-center">
  <div class="col-md-6">
    <h2>Entrar</h2>
    <form method="POST" action="<?= url('/login') ?>">
      <?= csrf_field() ?>
      <div class="mb-3">
        <label class="form-label">E-mail</label>
        <input type="email" name="email" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Senha</label>
        <input type="password" name="password" class="form-control" required>
      </div>
      <button class="btn btn-primary" type="submit">Entrar</button>
    </form>
  </div>
</div>
