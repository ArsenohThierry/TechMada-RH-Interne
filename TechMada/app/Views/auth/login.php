<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
    <title>Connexion — TechMada RH</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet"/>
    <style>
        :root{--ink:#1c2b1e;--forest:#2d5a3d;--forest2:#3d7a52;--leaf:#5fa876;--mint:#d4ede0;--cream:#f8f6f1;--white:#ffffff;--border:#dde8e1;--muted:#7a8f80;--danger:#c0392b;--danger-bg:#fdf0ee;--danger-br:#f0b8b2}
        *{box-sizing:border-box;margin:0;padding:0}
        body{font-family:'DM Sans',sans-serif;background:var(--ink)}
        h1,h2,h3{font-family:'Playfair Display',serif}
        .auth-page{min-height:100vh;display:flex;align-items:center;justify-content:center;padding:2rem}
        .auth-split{display:grid;grid-template-columns:1fr 420px;max-width:900px;width:100%;border-radius:16px;overflow:hidden;background:var(--white)}
        @media(max-width:900px){.auth-split{grid-template-columns:1fr}}
        .auth-left{background:var(--forest);padding:3rem;display:flex;flex-direction:column;justify-content:space-between;color:var(--white)}
        .auth-left-brand{font-family:'Playfair Display',serif;font-size:1.6rem;color:var(--white);letter-spacing:-.5px;margin:0}
        .auth-left-brand span{display:block;font-size:.85rem;font-weight:300;font-family:'DM Sans',sans-serif;color:rgba(255,255,255,.5);margin-top:4px}
        .auth-left-text{color:rgba(255,255,255,.6);font-size:.875rem;line-height:1.7;margin-top:2rem}
        .auth-left-text strong{color:var(--white);display:block;font-size:1.25rem;font-family:'Playfair Display',serif;margin-bottom:.5rem}
        .auth-right{padding:2.5rem}
        .auth-title{font-size:1.3rem;font-weight:700;margin:0 0 .25rem;color:var(--ink)}
        .auth-sub{font-size:.85rem;color:var(--muted);margin:0 0 1.75rem}
        .f-label{font-size:.8rem;font-weight:500;color:var(--ink);margin-bottom:5px;display:block}
        .f-input{width:100%;border:1.5px solid var(--border);border-radius:8px;padding:10px 12px;font-size:.875rem;font-family:'DM Sans',sans-serif;background:var(--white);color:var(--ink);transition:border-color .15s,box-shadow .15s}
        .f-input:focus{border-color:var(--forest);box-shadow:0 0 0 3px rgba(45,90,61,.1);outline:none}
        .f-group{margin-bottom:1rem}
        .f-error{font-size:.75rem;color:var(--danger);margin-top:4px}
        .btn-primary{background:var(--forest);color:var(--white);border:none;border-radius:8px;padding:11px 20px;font-weight:500;font-size:.9rem;cursor:pointer;transition:background .15s;font-family:'DM Sans',sans-serif;width:100%}
        .btn-primary:hover{background:var(--forest2)}
        .flash{padding:11px 14px;border-radius:8px;font-size:.85rem;font-weight:500;display:flex;align-items:center;gap:9px;margin-bottom:1.25rem;border:1px solid transparent}
        .flash-error{background:var(--danger-bg);color:var(--danger);border-color:var(--danger-br)}
        .auth-footer{text-align:center;margin-top:1.25rem;font-size:.8rem;color:var(--muted)}
        .auth-footer a{color:var(--forest);text-decoration:none;font-weight:500}
    </style>
</head>
<body>
    <div class="auth-page">
        <div class="auth-split">
            <!-- Panneau gauche -->
            <div class="auth-left">
                <div>
                    <p class="auth-left-brand">TechMada RH<span>Gestion des congés</span></p>
                    <p class="auth-left-text">
                        <strong>Bienvenue sur votre espace RH.</strong>
                        Gérez vos demandes de congés, consultez votre solde et suivez l'état de vos demandes en temps réel.
                    </p>
                </div>
            </div>
            <!-- Panneau droit -->
            <div class="auth-right">
                <p class="auth-title">Connexion</p>
                <p class="auth-sub">Entrez vos identifiants pour accéder à votre espace.</p>
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="flash flash-error">
                        <i class="bi bi-exclamation-circle-fill"></i>
                        <?= esc(session()->getFlashdata('error')) ?>
                    </div>
                <?php endif; ?>
                <form method="POST" action="<?= base_url('/auth/login') ?>">
                    <?= csrf_field() ?>
                    <div class="f-group">
                        <label class="f-label">Adresse email</label>
                        <input type="email" name="email" class="f-input" placeholder="vous@techmada.mg" value="<?= old('email') ?>" required/>
                        <?php if (isset($errors['email'])): ?>
                            <div class="f-error"><?= esc($errors['email']) ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="f-group">
                        <label class="f-label">Mot de passe</label>
                        <input type="password" name="password" class="f-input" placeholder="••••••••" required/>
                        <?php if (isset($errors['password'])): ?>
                            <div class="f-error"><?= esc($errors['password']) ?></div>
                        <?php endif; ?>
                    </div>
                    <button type="submit" class="btn-primary" style="margin-top:.5rem">
                        Se connecter <i class="bi bi-arrow-right-short"></i>
                    </button>
                </form>
                <div class="auth-footer">
                    Pas encore de compte ? <a href="<?= base_url('/auth/register') ?>">Créer un compte</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>