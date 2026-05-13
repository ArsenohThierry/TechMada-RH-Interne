<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
    <title>TechMada RH — Accueil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet"/>
    <style>
        :root{--ink:#1c2b1e;--forest:#2d5a3d;--forest2:#3d7a52;--leaf:#5fa876;--mint:#d4ede0;--cream:#f8f6f1;--white:#ffffff;--border:#dde8e1;--muted:#7a8f80}
        *{box-sizing:border-box}
        body{font-family:'DM Sans',sans-serif;background:var(--cream);color:var(--ink);margin:0;min-height:100vh;display:flex;flex-direction:column}
        h1,h2,h3{font-family:'Playfair Display',serif}
        .navbar{background:var(--white);border-bottom:1px solid var(--border);padding:1rem 2rem;display:flex;align-items:center;justify-content:space-between;gap:1rem}
        .navbar-brand{display:flex;align-items:center;gap:10px;text-decoration:none;color:var(--ink)}
        .navbar-logo{width:36px;height:36px;background:var(--forest);border-radius:8px;display:flex;align-items:center;justify-content:center;color:var(--white);font-weight:600}
        .navbar-text{font-family:'Playfair Display',serif;font-size:1.1rem;font-weight:600}
        .navbar-text span{display:block;font-family:'DM Sans',sans-serif;font-size:.65rem;font-weight:400;color:var(--muted)}
        .navbar-right{display:flex;align-items:center;gap:12px}
        .user-info{text-align:right;display:flex;align-items:center;gap:12px}
        .user-details{display:flex;flex-direction:column}
        .user-name{font-weight:500;font-size:.9rem}
        .user-role{font-size:.75rem;color:var(--muted)}
        .nav-link{padding:9px 14px;border-radius:7px;text-decoration:none;font-size:.85rem;font-weight:500;transition:all .15s;display:inline-flex;align-items:center;gap:6px}
        .nav-link.primary{background:var(--forest);color:var(--white)}
        .nav-link.primary:hover{background:var(--forest2)}
        .nav-link.secondary{color:var(--forest);background:var(--mint);border:1px solid var(--leaf)}
        .nav-link.secondary:hover{background:var(--leaf);color:var(--white)}
        .logout-btn{background:#c7372f;color:var(--white);padding:8px 12px;border-radius:7px;text-decoration:none;font-size:.8rem;font-weight:500;display:inline-flex;align-items:center;gap:6px}
        .logout-btn:hover{background:#a92824}
        .main-content{flex:1;display:flex;flex-direction:column;padding:2rem;max-width:1200px;margin:0 auto;width:100%}
        .hero-section{background:linear-gradient(135deg, var(--forest) 0%, var(--forest2) 100%);border-radius:14px;padding:3rem;color:var(--white);margin-bottom:2rem;text-align:center}
        .hero-section h1{margin:0 0 1rem 0;font-size:2rem}
        .hero-section p{margin:0;font-size:1rem;opacity:.9;line-height:1.6}
        .welcome-section{background:var(--white);border:1.5px solid var(--border);border-radius:12px;padding:2rem;margin-bottom:2rem;text-align:center}
        .welcome-section h2{margin:0 0 1rem 0;font-size:1.3rem}
        .welcome-section p{color:var(--muted);margin:0 0 1.5rem 0}
        .cta-buttons{display:flex;gap:12px;justify-content:center;flex-wrap:wrap}
        .cta-button{padding:12px 20px;border-radius:8px;text-decoration:none;font-weight:500;font-size:.9rem;display:inline-flex;align-items:center;gap:8px;transition:all .15s}
        .cta-button.primary{background:var(--forest);color:var(--white)}
        .cta-button.primary:hover{background:var(--forest2)}
        .cta-button.secondary{background:var(--white);color:var(--forest);border:1.5px solid var(--forest)}
        .cta-button.secondary:hover{background:var(--mint)}
        .nav-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:1.2rem;margin-bottom:2rem}
        .nav-card{background:var(--white);border:1.5px solid var(--border);border-radius:12px;padding:1.5rem;text-align:center;transition:all .15s;cursor:pointer}
        .nav-card:hover{border-color:var(--forest);box-shadow:0 4px 12px rgba(45,90,61,.1)}
        .nav-card-icon{width:44px;height:44px;background:var(--mint);border-radius:8px;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;font-size:1.5rem;color:var(--forest)}
        .nav-card-title{font-size:.95rem;font-weight:600;margin:0 0 .5rem 0}
        .nav-card-desc{font-size:.8rem;color:var(--muted);margin:0}
        .nav-card a{display:inline-block;margin-top:1rem;padding:8px 14px;background:var(--forest);color:var(--white);border-radius:6px;text-decoration:none;font-size:.8rem;font-weight:500}
        .nav-card a:hover{background:var(--forest2)}
        .divider{display:flex;align-items:center;gap:1rem;margin:1.5rem 0;color:var(--border)}
        .divider::before,.divider::after{content:'';flex:1;height:1px;background:var(--border)}
        .footer{background:var(--white);border-top:1px solid var(--border);padding:1.5rem 2rem;text-align:center;color:var(--muted);font-size:.85rem;margin-top:auto}
        .footer a{color:var(--forest);text-decoration:none;font-weight:500}
        @media (max-width:768px){
            .navbar{flex-direction:column;gap:1rem}
            .navbar-right{flex-direction:column;width:100%}
            .user-info{width:100%;justify-content:space-between}
            .nav-link{width:100%;justify-content:center}
            .hero-section{padding:2rem}
            .hero-section h1{font-size:1.5rem}
            .main-content{padding:1rem}
            .nav-grid{grid-template-columns:1fr}
        }
    </style>
</head>
<body>
    <!-- NAVBAR -->
    <nav class="navbar">
        <a href="<?= base_url('/') ?>" class="navbar-brand">
            <div class="navbar-logo"><i class="bi bi-briefcase"></i></div>
            <div class="navbar-text">TechMada RH<span>Gestion des congés</span></div>
        </a>
        <div class="navbar-right">
            <?php if (session()->get('logged_in')): ?>
                <div class="user-info">
                    <div class="user-details">
                        <div class="user-name"><?= esc(session()->get('user_prenom') ?? session()->get('employe_prenom') ?? 'Utilisateur') ?></div>
                        <div class="user-role"><?= esc(session()->get('user_role') ?? 'employe') ?></div>
                    </div>
                    <a href="<?= base_url('/auth/logout') ?>" class="logout-btn"><i class="bi bi-box-arrow-right"></i> Déconnexion</a>
                </div>
            <?php else: ?>
                <div style="display:flex;gap:12px">
                    <a href="<?= base_url('/auth/login') ?>" class="nav-link primary"><i class="bi bi-box-arrow-in-right"></i> Se connecter</a>
                    <a href="<?= base_url('/auth/register') ?>" class="nav-link secondary"><i class="bi bi-person-plus"></i> S'inscrire</a>
                </div>
            <?php endif; ?>
        </div>
    </nav>

    <!-- MAIN CONTENT -->
    <div class="main-content">
        <?php if (! session()->get('logged_in')): ?>
            <!-- HERO SECTION -->
            <div class="hero-section">
                <h1><i class="bi bi-calendar2-check"></i> Bienvenue sur TechMada RH</h1>
                <p>Plateforme de gestion centralisée de vos congés et absences</p>
            </div>

            <!-- WELCOME SECTION -->
            <div class="welcome-section">
                <h2>Commencez maintenant</h2>
                <p>Connectez-vous pour accéder à votre tableau de bord personnel et soumettre vos demandes de congés.</p>
                <div class="cta-buttons">
                    <a href="<?= base_url('/auth/login') ?>" class="cta-button primary"><i class="bi bi-box-arrow-in-right"></i> Se connecter</a>
                    <a href="<?= base_url('/auth/register') ?>" class="cta-button secondary"><i class="bi bi-person-plus"></i> Créer un compte</a>
                </div>
            </div>

            <!-- FEATURES SECTION -->
            <div class="divider"><span style="font-weight:500">Nos fonctionnalités</span></div>
            <div class="nav-grid">
                <div class="nav-card">
                    <div class="nav-card-icon"><i class="bi bi-calendar3"></i></div>
                    <h3 class="nav-card-title">Demandes de congés</h3>
                    <p class="nav-card-desc">Soumettez vos demandes de manière simple et sécurisée.</p>
                </div>
                <div class="nav-card">
                    <div class="nav-card-icon"><i class="bi bi-graph-up"></i></div>
                    <h3 class="nav-card-title">Suivi des soldes</h3>
                    <p class="nav-card-desc">Consultez vos soldes de congés en temps réel.</p>
                </div>
                <div class="nav-card">
                    <div class="nav-card-icon"><i class="bi bi-check-circle"></i></div>
                    <h3 class="nav-card-title">Validation RH</h3>
                    <p class="nav-card-desc">Processus de validation rapide et transparent.</p>
                </div>
            </div>

        <?php else: ?>
            <!-- LOGGED IN DASHBOARD NAVIGATION -->
            <?php $role = session()->get('user_role') ?? 'employe'; ?>

            <h1 style="margin-bottom:1.5rem">Bienvenue, <?= esc(session()->get('user_prenom') ?? 'Utilisateur') ?> !</h1>

            <!-- DASHBOARD NAVIGATION GRID -->
            <div class="nav-grid">
                <!-- ALL ROLES -->
                <?php if ($role === 'admin'): ?>
                    <div class="nav-card">
                        <div class="nav-card-icon"><i class="bi bi-speedometer2"></i></div>
                        <h3 class="nav-card-title">Dashboard Admin</h3>
                        <p class="nav-card-desc">Administrez le système et les utilisateurs.</p>
                        <a href="<?= base_url('/admin/dashboard') ?>">Accéder</a>
                    </div>
                <?php elseif ($role === 'rh'): ?>
                <?php else: ?>
                    <div class="nav-card">
                        <div class="nav-card-icon"><i class="bi bi-speedometer2"></i></div>
                        <h3 class="nav-card-title">Mon espace</h3>
                        <p class="nav-card-desc">Accédez à votre tableau de bord personnel.</p>
                        <a href="<?= base_url('/employe/dashboard') ?>">Accéder</a>
                    </div>
                <?php endif; ?>

                <!-- EMPLOYE ACTIONS -->
                <?php if ($role === 'employe'): ?>
                    <div class="nav-card">
                        <div class="nav-card-icon"><i class="bi bi-plus-circle"></i></div>
                        <h3 class="nav-card-title">Nouvelle demande</h3>
                        <p class="nav-card-desc">Soumettre une nouvelle demande de congé.</p>
                        <a href="<?= base_url('/employe/conges/form') ?>">Créer</a>
                    </div>
                    <div class="nav-card">
                        <div class="nav-card-icon"><i class="bi bi-calendar3"></i></div>
                        <h3 class="nav-card-title">Mes demandes</h3>
                        <p class="nav-card-desc">Consultez l'historique de vos demandes.</p>
                        <a href="<?= base_url('/employe/conges') ?>">Consulter</a>
                    </div>
                <?php endif; ?>

                <!-- RH ACTIONS -->
                <?php if (in_array($role, ['rh','admin'])): ?>
                    <div class="nav-card">
                        <div class="nav-card-icon"><i class="bi bi-list-check"></i></div>
                        <h3 class="nav-card-title">Demandes RH</h3>
                        <p class="nav-card-desc">Validez les demandes des employés.</p>
                        <a href="<?= base_url('/rh/listeDemandes') ?>">Gérer</a>
                    </div>
                    <div class="nav-card">
                        <div class="nav-card-icon"><i class="bi bi-people"></i></div>
                        <h3 class="nav-card-title">Gestion employés</h3>
                        <p class="nav-card-desc">Administrez les employés de l'entreprise.</p>
                        <a href="<?= base_url('/rh/employes') ?>">Accéder</a>
                    </div>
                <?php endif; ?>

                <!-- ADMIN ACTIONS -->
                <?php if ($role === 'admin'): ?>
                    <div class="nav-card">
                        <div class="nav-card-icon"><i class="bi bi-person-badge"></i></div>
                        <h3 class="nav-card-title">Utilisateurs</h3>
                        <p class="nav-card-desc">Gérez les comptes utilisateurs.</p>
                        <a href="<?= base_url('/admin/utilisateurs') ?>">Gérer</a>
                    </div>
                    <div class="nav-card">
                        <div class="nav-card-icon"><i class="bi bi-sliders"></i></div>
                        <h3 class="nav-card-title">Paramètres</h3>
                        <p class="nav-card-desc">Configuration générale du système.</p>
                        <a href="<?= base_url('/admin/parametres') ?>">Configurer</a>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- FOOTER -->
    <div class="footer">
        <div>© 2026 <strong>TechMada RH</strong> — Tous droits réservés</div>
    </div>
</body>
</html>