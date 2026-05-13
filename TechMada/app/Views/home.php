<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechMada — Accueil</title>
    <style>
        :root{--bg:#0f172a;--card:#0b1220;--accent:#667eea;--muted:#94a3b8;--glass:rgba(255,255,255,0.04)}
        *{box-sizing:border-box}
        body{margin:0;font-family:Inter, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;background:linear-gradient(180deg,#071029 0%, #0f172a 100%);color:#e6eef8;min-height:100vh;display:flex;align-items:center;justify-content:center;padding:28px}
        .wrap{width:100%;max-width:980px}
        .card{background:linear-gradient(180deg, rgba(255,255,255,0.02), rgba(255,255,255,0.01));border-radius:12px;padding:28px;box-shadow:0 10px 30px rgba(2,6,23,0.6);border:1px solid rgba(255,255,255,0.03)}
        header{display:flex;align-items:center;justify-content:space-between;margin-bottom:18px}
        header h1{font-size:20px;margin:0}
        header .sub{color:var(--muted);font-size:13px}
        nav{display:flex;gap:12px;flex-wrap:wrap;margin:18px 0}
        .link{display:inline-block;padding:12px 16px;border-radius:8px;background:var(--glass);color:var(--accent);text-decoration:none;font-weight:600;border:1px solid rgba(102,126,234,0.12)}
        .link.secondary{background:transparent;color:#cfe3ff;border:1px solid rgba(255,255,255,0.04)}
        .links-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:12px;margin-top:12px}
        .tile{background:rgba(255,255,255,0.02);padding:16px;border-radius:10px;border:1px solid rgba(255,255,255,0.02)}
        .tile h3{margin:0 0 8px 0;font-size:14px}
        .tile p{margin:0;color:var(--muted);font-size:13px}
        .footer{display:flex;justify-content:space-between;align-items:center;margin-top:18px;color:var(--muted);font-size:13px}
        .logout{background:#ef4444;padding:8px 12px;border-radius:8px;color:#fff;text-decoration:none}
        @media (max-width:560px){.card{padding:16px}.link{padding:10px 12px}}
    </style>
</head>
<body>
    <div class="wrap">
        <div class="card">
            <header>
                <div>
                    <h1>TechMada RH</h1>
                    <div class="sub">Espace de gestion des congés</div>
                </div>
                <div>
                    <?php if (session()->get('logged_in')): ?>
                        <div style="text-align:right">
                            <div style="font-weight:600"><?= esc(session()->get('user_prenom') ?? session()->get('employe_prenom') ?? 'Utilisateur') ?></div>
                            <div style="font-size:12px;color:var(--muted)"><?= esc(session()->get('user_role') ?? 'employe') ?></div>
                        </div>
                    <?php else: ?>
                        <a class="link" href="<?= base_url('/auth/login') ?>">Se connecter</a>
                    <?php endif; ?>
                </div>
            </header>

            <?php if (! session()->get('logged_in')): ?>
                <div class="tile">
                    <h3>Bienvenue</h3>
                    <p>Connectez-vous pour gérer vos demandes de congé et accéder à votre tableau de bord.</p>
                </div>
            <?php else: ?>

                <?php $role = session()->get('user_role') ?? 'employe'; ?>

                <nav>
                    <!-- dashboard link for all roles -->
                    <?php if ($role === 'admin'): ?>
                        <a class="link" href="<?= base_url('/admin/dashboard') ?>">Dashboard Admin</a>
                    <?php elseif ($role === 'rh'): ?>
                        <a class="link" href="<?= base_url('/rh/dashboard') ?>">Dashboard RH</a>
                    <?php else: ?>
                        <a class="link" href="<?= base_url('/employe/dashboard') ?>">Mon espace</a>
                    <?php endif; ?>

                    <!-- employe-only actions (visible only to employe role) -->
                    <?php if ($role === 'employe'): ?>
                        <a class="link secondary" href="<?= base_url('/employe/conges/form') ?>">Nouvelle demande</a>
                        <a class="link secondary" href="<?= base_url('/employe/conges') ?>">Mes demandes</a>
                    <?php endif; ?>

                    <!-- rh-only actions -->
                    <?php if (in_array($role, ['rh','admin'])): ?>
                        <a class="link" href="<?= base_url('/rh/listeDemandes') ?>">Demandes RH</a>
                        <a class="link" href="<?= base_url('/rh/employes') ?>">Gestion employés</a>
                    <?php endif; ?>

                    <!-- admin actions -->
                    <?php if ($role === 'admin'): ?>
                        <a class="link" href="<?= base_url('/admin/utilisateurs') ?>">Utilisateurs</a>
                        <a class="link" href="<?= base_url('/admin/parametres') ?>">Paramètres</a>
                    <?php endif; ?>
                </nav>

                <div class="links-grid">
                    <div class="tile">
                        <h3>Demandes récentes</h3>
                        <p>Consultez et suivez les dernières demandes traitées.</p>
                    </div>
                    <div class="tile">
                        <h3>Soldes</h3>
                        <p>Consultez vos soldes annuels et historiques.</p>
                    </div>
                    <div class="tile">
                        <h3>Rapports</h3>
                        <p>Accédez aux rapports d'absences et performances.</p>
                    </div>
                </div>

            <?php endif; ?>

            <div class="footer">
                <div>© TechMada — <?= date('Y') ?></div>
                <div>
                    <?php if (session()->get('logged_in')): ?>
                        <a class="logout" href="<?= base_url('/auth/logout') ?>">Se déconnecter</a>
                    <?php else: ?>
                        <a class="link" href="<?= base_url('/auth/register') ?>">Créer un compte</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>