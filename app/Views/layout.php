<?php
?><!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title ?? APP_NAME) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= url('/assets/style.css') ?>">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
  <div class="container-fluid">
    <a class="navbar-brand" href="<?= url('/') ?>"><?= e(APP_NAME) ?></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link" href="<?= url('/institutions') ?>">Instituições</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= url('/users') ?>">Doadores/Voluntários</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= url('/donations') ?>">Doações</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= url('/events') ?>">Eventos</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= url('/reports/donations') ?>">Relatórios</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= url('/reports/rankings') ?>">Ranking</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= url('/leaderboard') ?>">Leaderboard</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= url('/transparency') ?>">Transparência</a></li>
      </ul>
      <ul class="navbar-nav">
        <?php if (!empty($_SESSION['user'])): ?>
          <li class="nav-item"><span class="navbar-text me-2">Olá, <?= e($_SESSION['user']['name'] ?? 'Usuário') ?></span></li>
          <li class="nav-item"><a class="btn btn-outline-light" href="<?= url('/logout') ?>">Sair</a></li>
        <?php else: ?>
          <li class="nav-item"><a class="btn btn-outline-light me-2" href="<?= url('/login') ?>">Entrar</a></li>
          <li class="nav-item"><a class="btn btn-primary" href="<?= url('/register') ?>">Registrar</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
  </nav>
  <main class="container">
    <?php if ($msg = get_flash('success')): ?>
      <div class="alert alert-success"><?= e($msg) ?></div>
    <?php endif; ?>
    <?php if ($msg = get_flash('error')): ?>
      <div class="alert alert-danger"><?= e($msg) ?></div>
    <?php endif; ?>
    <?= $content ?>
  </main>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
