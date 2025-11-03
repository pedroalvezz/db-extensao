<div class="row justify-content-center">
  <div class="col-md-8">
    <h2>Registrar</h2>
    <form method="POST" action="<?= url('/register') ?>">
      <?= csrf_field() ?>
      <div class="row">
        <div class="col-md-6 mb-3">
          <label class="form-label">Nome</label>
          <input type="text" name="name" class="form-control" required>
        </div>
        <div class="col-md-6 mb-3">
          <label class="form-label">E-mail</label>
          <input type="email" name="email" class="form-control" required>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6 mb-3">
          <label class="form-label">Senha</label>
          <input type="password" name="password" class="form-control" minlength="6" required>
        </div>
        <div class="col-md-6 mb-3">
          <label class="form-label">Perfil</label>
          <select name="role" class="form-select">
            <option value="donor">Doador</option>
            <option value="volunteer">Voluntário</option>
            <option value="admin">Admin (teste)</option>
          </select>
        </div>
      </div>
      <button class="btn btn-success" type="submit">Criar conta</button>
    </form>
  </div>
</div>
