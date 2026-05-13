<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Connexion — MadaTech</title>
  <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
</head>
<body>
<div class="auth-page">
  <div class="auth-card animate-fade-in">

    <div class="auth-logo">
      <div class="auth-logo-icon">H</div>
      <span class="auth-logo-text">MadaTech</span>
    </div>

    <h1 class="auth-title">Bon retour</h1>
    <p class="auth-subtitle">Connectez-vous à votre espace de gestion RH</p>

    <?php if (session()->has('error')): ?>
      <div style="background:rgba(239,68,68,0.1); border:1px solid rgba(239,68,68,0.3); border-radius:10px; padding:12px; margin-bottom:20px; color:#dc2626; font-size:13px;">
        ⚠️ <?= session()->getFlashdata('error') ?>
      </div>
    <?php endif; ?>

    <?php if (session()->has('success')): ?>
      <div style="background:rgba(34,197,94,0.1); border:1px solid rgba(34,197,94,0.3); border-radius:10px; padding:12px; margin-bottom:20px; color:#16a34a; font-size:13px;">
        ✓ <?= session()->getFlashdata('success') ?>
      </div>
    <?php endif; ?>

    <form method="POST" action="<?= base_url('/auth/login') ?>">
      <?= csrf_field() ?>

      <div class="form-group">
        <label class="form-label">Adresse email <span>*</span></label>
        <input type="email" name="email" class="form-control" placeholder="vous@entreprise.com" 
               value="<?= old('email') ?>" required>
        <?php if (isset($errors['email'])): ?>
          <div style="font-size:12px; color:#dc2626; margin-top:4px;"><?= $errors['email'] ?></div>
        <?php endif; ?>
      </div>

      <div class="form-group">
        <div class="flex items-center justify-between mb-2">
          <label class="form-label" style="margin-bottom:0">Mot de passe <span>*</span></label>
          <a href="<?= base_url('/auth/forgot-password') ?>" style="font-size:12px; color:var(--blue-light);">Oublié ?</a>
        </div>
        <input type="password" name="password" class="form-control" placeholder="••••••••" required>
        <?php if (isset($errors['password'])): ?>
          <div style="font-size:12px; color:#dc2626; margin-top:4px;"><?= $errors['password'] ?></div>
        <?php endif; ?>
      </div>

      <div class="check-group mb-5">
        <div class="custom-check" id="remember-me"></div>
        <label for="remember-me" style="font-size:13px; color:var(--text-sec); cursor:pointer;">Se souvenir de moi</label>
      </div>

      <button type="submit" class="btn btn-primary btn-full btn-lg" style="background:var(--grad-mix);">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
          <polyline points="10 17 15 12 10 7"/>
          <line x1="15" x2="3" y1="12" y2="12"/>
        </svg>
        Se connecter
      </button>
    </form>

    <div class="auth-divider"><span>ou</span></div>

    <div class="auth-footer">
      Pas encore de compte ? <a href="<?= base_url('/auth/register') ?>">Créer un compte</a>
    </div>
  </div>
</div>
<script src="<?= base_url('assets/js/app.js') ?>"></script>
</body>
</html>