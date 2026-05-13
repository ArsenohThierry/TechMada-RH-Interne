<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inscription — MadaTech</title>
  <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
</head>
<body>
<div class="auth-page">
  <div class="auth-card animate-fade-in" style="max-width:480px;">

    <div class="auth-logo">
      <div class="auth-logo-icon">H</div>
      <span class="auth-logo-text">MadaTech</span>
    </div>

    <h1 class="auth-title">Créer un compte</h1>
    <p class="auth-subtitle">Inscrivez-vous pour accéder à votre espace RH</p>

    <?php if (session()->has('error')): ?>
      <div style="background:rgba(239,68,68,0.1); border:1px solid rgba(239,68,68,0.3); border-radius:10px; padding:12px; margin-bottom:20px; color:#dc2626; font-size:13px;">
        ⚠️ <?= session()->getFlashdata('error') ?>
      </div>
    <?php endif; ?>

    <form method="POST" action="<?= base_url('/auth/register') ?>">
      <?= csrf_field() ?>

      <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
        <div class="form-group">
          <label class="form-label">Prénom <span>*</span></label>
          <input type="text" name="prenom" class="form-control" placeholder="Jean" 
                 value="<?= old('prenom') ?>" required>
          <?php if (isset($errors['prenom'])): ?>
            <div style="font-size:12px; color:#dc2626; margin-top:4px;"><?= $errors['prenom'] ?></div>
          <?php endif; ?>
        </div>

        <div class="form-group">
          <label class="form-label">Nom <span>*</span></label>
          <input type="text" name="nom" class="form-control" placeholder="Dupont" 
                 value="<?= old('nom') ?>" required>
          <?php if (isset($errors['nom'])): ?>
            <div style="font-size:12px; color:#dc2626; margin-top:4px;"><?= $errors['nom'] ?></div>
          <?php endif; ?>
        </div>
      </div>

      <div class="form-group">
        <label class="form-label">Adresse email <span>*</span></label>
        <input type="email" name="email" class="form-control" placeholder="vous@entreprise.com" 
               value="<?= old('email') ?>" required>
        <?php if (isset($errors['email'])): ?>
          <div style="font-size:12px; color:#dc2626; margin-top:4px;"><?= $errors['email'] ?></div>
        <?php endif; ?>
      </div>

      <div class="form-group">
        <label class="form-label">Mot de passe <span>*</span></label>
        <input type="password" name="password" class="form-control" placeholder="••••••••" 
               minlength="6" required>
        <div style="font-size:11px; color:var(--text-muted); margin-top:6px;">Minimum 6 caractères</div>
        <?php if (isset($errors['password'])): ?>
          <div style="font-size:12px; color:#dc2626; margin-top:4px;"><?= $errors['password'] ?></div>
        <?php endif; ?>
      </div>

      <div class="form-group">
        <label class="form-label">Confirmer le mot de passe <span>*</span></label>
        <input type="password" name="password_confirm" class="form-control" placeholder="••••••••" 
               minlength="6" required>
        <?php if (isset($errors['password_confirm'])): ?>
          <div style="font-size:12px; color:#dc2626; margin-top:4px;"><?= $errors['password_confirm'] ?></div>
        <?php endif; ?>
      </div>

      <button type="submit" class="btn btn-primary btn-full btn-lg" style="background:var(--grad-mix); margin-top:8px;">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M12 5v14M5 12h14"/>
        </svg>
        S'inscrire
      </button>
    </form>

    <div class="auth-divider"><span>ou</span></div>

    <div class="auth-footer">
      Vous avez déjà un compte ? <a href="<?= base_url('/auth/login') ?>">Se connecter</a>
    </div>
  </div>
</div>
<script src="<?= base_url('assets/js/app.js') ?>"></script>
</body>
</html>
