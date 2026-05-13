<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
    <title>Inscription — TechMada RH</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet"/>
    <style>
        :root{--ink:#1c2b1e;--forest:#2d5a3d;--forest2:#3d7a52;--leaf:#5fa876;--mint:#d4ede0;--cream:#f8f6f1;--white:#ffffff;--border:#dde8e1;--muted:#7a8f80;--error:#c7372f}
        *{box-sizing:border-box}
        body{font-family:'DM Sans',sans-serif;background:var(--cream);color:var(--ink);margin:0;min-height:100vh;display:flex;align-items:center;justify-content:center;padding:16px}
        h1,h2,h3{font-family:'Playfair Display',serif}
        .auth-wrap{display:flex;width:100%;max-width:1000px;height:auto;min-height:500px;border-radius:14px;overflow:hidden;box-shadow:0 10px 30px rgba(0,0,0,.08);border:1px solid var(--border)}
        .auth-left{background:linear-gradient(135deg, var(--forest) 0%, var(--forest2) 100%);flex:1;display:flex;flex-direction:column;align-items:flex-start;justify-content:center;padding:2.5rem;color:var(--white)}
        .auth-left h2{font-size:1.8rem;margin:0 0 1rem 0;line-height:1.2}
        .auth-left p{font-size:.95rem;opacity:.85;line-height:1.6;margin:0}
        .auth-right{background:var(--white);flex:1;padding:2.5rem;display:flex;flex-direction:column;justify-content:center}
        .auth-form-head h1{font-size:1.2rem;margin:0 0 .3rem 0}
        .auth-form-head p{font-size:.85rem;color:var(--muted);margin:0 0 1.5rem 0}
        .form-group{margin-bottom:1.1rem}
        label{display:block;font-size:.8rem;font-weight:500;color:var(--ink);margin-bottom:6px}
        label span{color:var(--error)}
        input[type="text"],input[type="email"],input[type="password"]{width:100%;padding:11px 12px;border:1.5px solid var(--border);border-radius:8px;font-family:inherit;font-size:.9rem;background:var(--white);color:var(--ink);transition:all .15s}
        input:focus{outline:none;border-color:var(--forest);box-shadow:0 0 0 3px rgba(45,90,61,.08)}
        .grid-2{display:grid;grid-template-columns:1fr 1fr;gap:12px}
        .error-msg{font-size:.775rem;color:var(--error);margin-top:4px}
        .alert{background:rgba(199,55,47,.08);border:1.5px solid rgba(199,55,47,.2);border-radius:8px;padding:11px 12px;margin-bottom:1rem;color:var(--error);font-size:.85rem;display:flex;gap:8px;align-items:flex-start}
        .alert i{flex-shrink:0}
        .submit-btn{width:100%;padding:12px;background:var(--forest);color:var(--white);border:none;border-radius:8px;font-family:'DM Sans',sans-serif;font-size:.9rem;font-weight:500;cursor:pointer;transition:all .15s;margin-top:8px;display:flex;align-items:center;justify-content:center;gap:8px}
        .submit-btn:hover{background:var(--forest2)}
        .hint{font-size:.75rem;color:var(--muted);margin-top:5px}
        .divider{display:flex;align-items:center;gap:12px;margin:1.5rem 0;color:var(--border)}
        .divider::before,.divider::after{content:'';flex:1;height:1px;background:var(--border)}
        .auth-footer{font-size:.85rem;text-align:center;color:var(--muted);margin-top:1.5rem}
        .auth-footer a{color:var(--forest);text-decoration:none;font-weight:500}
        .auth-footer a:hover{text-decoration:underline}
        @media (max-width:768px){
            .auth-wrap{flex-direction:column;min-height:auto}
            .auth-left{padding:2rem;min-height:auto}
            .auth-left h2{font-size:1.4rem}
            .auth-right{padding:2rem}
            .grid-2{grid-template-columns:1fr}
        }
    </style>
</head>
<body>
    <div class="auth-wrap">
        <div class="auth-left">
            <div>
                <h2>Rejoignez TechMada</h2>
                <p>Créez votre compte pour accéder à votre espace de gestion de congés. Accès sécurisé et instantané à votre dashboard personnel.</p>
            </div>
        </div>
        <div class="auth-right">
            <div class="auth-form-head">
                <h1>Inscription</h1>
                <p>Remplissez le formulaire ci-dessous pour créer votre compte</p>
            </div>

            <?php if (session()->has('error')): ?>
                <div class="alert">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <span><?= session()->getFlashdata('error') ?></span>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?= base_url('/auth/register') ?>">
                <?= csrf_field() ?>

                <div class="grid-2">
                    <div class="form-group">
                        <label>Prénom <span>*</span></label>
                        <input type="text" name="prenom" placeholder="Jean" value="<?= old('prenom') ?>" required/>
                        <?php if (isset($errors['prenom'])): ?>
                            <div class="error-msg"><?= $errors['prenom'] ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label>Nom <span>*</span></label>
                        <input type="text" name="nom" placeholder="Dupont" value="<?= old('nom') ?>" required/>
                        <?php if (isset($errors['nom'])): ?>
                            <div class="error-msg"><?= $errors['nom'] ?></div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="form-group">
                    <label>Adresse email <span>*</span></label>
                    <input type="email" name="email" placeholder="vous@entreprise.com" value="<?= old('email') ?>" required/>
                    <?php if (isset($errors['email'])): ?>
                        <div class="error-msg"><?= $errors['email'] ?></div>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label>Mot de passe <span>*</span></label>
                    <input type="password" name="password" placeholder="••••••••" minlength="6" required/>
                    <div class="hint">Minimum 6 caractères</div>
                    <?php if (isset($errors['password'])): ?>
                        <div class="error-msg"><?= $errors['password'] ?></div>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label>Confirmer le mot de passe <span>*</span></label>
                    <input type="password" name="password_confirm" placeholder="••••••••" minlength="6" required/>
                    <?php if (isset($errors['password_confirm'])): ?>
                        <div class="error-msg"><?= $errors['password_confirm'] ?></div>
                    <?php endif; ?>
                </div>

                <button type="submit" class="submit-btn">
                    <i class="bi bi-person-plus"></i> S'inscrire
                </button>
            </form>

            <div class="auth-footer">
                Vous avez déjà un compte ? <a href="<?= base_url('/auth/login') ?>">Se connecter</a>
            </div>
        </div>
    </div>
</body>
</html>
