<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
    <title>Tableau de bord — TechMada RH</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet"/>
    <style>
        :root{--ink:#1c2b1e;--forest:#2d5a3d;--forest2:#3d7a52;--leaf:#5fa876;--mint:#d4ede0;--cream:#f8f6f1;--white:#ffffff;--border:#dde8e1;--muted:#7a8f80;--info:#1a4f7a;--info-bg:#eaf2fb;--sidebar-w:240px;--topbar-h:62px}
        *{box-sizing:border-box}
        body{font-family:'DM Sans',sans-serif;background:var(--cream);color:var(--ink);margin:0}
        h1,h2,h3{font-family:'Playfair Display',serif}
        code,pre,.mono{font-family:'DM Mono',monospace}
        .app-wrap{display:flex;min-height:100vh}
        .sidebar{width:var(--sidebar-w);background:var(--ink);display:flex;flex-direction:column;flex-shrink:0;position:sticky;top:0;height:100vh;overflow-y:auto;color:var(--white)}
        .sidebar-brand{padding:1.4rem 1.2rem 1rem;display:flex;align-items:center;gap:10px;border-bottom:1px solid rgba(255,255,255,.06)}
        .sidebar-logo-icon{width:34px;height:34px;background:var(--forest);border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;color:var(--white)}
        .sidebar-brand-name{font-family:'Playfair Display',serif;font-size:1rem;color:var(--white);line-height:1.2}
        .sidebar-brand-name span{display:block;font-size:.65rem;font-family:'DM Sans',sans-serif;font-weight:400;color:rgba(255,255,255,.35)}
        .sidebar-section{padding:.75rem 1.1rem .3rem;font-size:.62rem;font-weight:500;text-transform:uppercase;color:rgba(255,255,255,.25)}
        .sidebar-nav{list-style:none;padding:0 .75rem;margin:0}
        .sidebar-nav li{margin-bottom:2px}
        .sidebar-nav li a{display:flex;align-items:center;gap:9px;padding:9px 11px;border-radius:7px;color:rgba(255,255,255,.55);text-decoration:none;font-size:.85rem;font-weight:400;transition:all .15s}
        .sidebar-nav li a:hover{background:rgba(255,255,255,.06);color:rgba(255,255,255,.9)}
        .sidebar-nav li a.active{background:var(--forest);color:var(--white)}
        .sidebar-user{padding:.85rem .75rem;border-top:1px solid rgba(255,255,255,.06);margin-top:auto}
        .avatar{width:32px;height:32px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:.7rem;font-weight:500;color:var(--white);flex-shrink:0;background:var(--forest2)}
        .user-name{font-size:.825rem;font-weight:500;color:var(--white)}
        .user-role{font-size:.65rem;color:rgba(255,255,255,.35)}
        .main{flex:1;min-width:0;display:flex;flex-direction:column}
        .topbar{height:var(--topbar-h);background:var(--white);border-bottom:1px solid var(--border);display:flex;align-items:center;padding:0 1.75rem;gap:1rem;position:sticky;top:0;z-index:10}
        .topbar-title{font-family:'Playfair Display',serif;font-size:1.05rem;font-weight:600;color:var(--ink)}
        .topbar-actions{margin-left:auto;display:flex;align-items:center;gap:8px}
        .icon-btn{width:34px;height:34px;border:1.5px solid var(--border);background:var(--white);border-radius:7px;display:flex;align-items:center;justify-content:center;cursor:pointer;color:var(--muted);transition:all .15s;text-decoration:none}
        .icon-btn:hover{border-color:var(--forest);color:var(--forest)}
        .content{padding:1.75rem;flex:1}
        .metrics{display:grid;grid-template-columns:repeat(auto-fit,minmax(170px,1fr));gap:1rem;margin-bottom:1.75rem}
        .metric{background:var(--white);border:1px solid var(--border);border-radius:12px;padding:1.1rem 1.25rem}
        .metric-val{font-family:'DM Mono',monospace;font-size:1.75rem;font-weight:500;color:var(--ink);line-height:1;margin-bottom:8px}
        .metric-label{font-size:.775rem;color:var(--muted)}
        .data-card{background:var(--white);border:1px solid var(--border);border-radius:12px;overflow:hidden;margin-bottom:1.5rem}
        .data-card-head{padding:1.1rem 1.25rem;border-bottom:1px solid var(--border)}
        .data-card-head h3{font-family:'Playfair Display',serif;font-size:.95rem;margin:0;font-weight:600;color:var(--ink)}
        .data-card-body{padding:1.1rem 1.25rem}
        .tile{background:var(--mint);border:1px solid var(--leaf);border-radius:8px;padding:1rem;margin-bottom:1rem}
        .tile-label{font-size:.75rem;color:var(--forest);font-weight:500;margin-bottom:4px}
        .tile-value{font-family:'DM Mono',monospace;font-size:1.5rem;font-weight:600;color:var(--forest)}
        .link-btn{background:var(--white);border:1.5px solid var(--border);border-radius:8px;padding:12px 16px;font-size:.9rem;font-weight:500;cursor:pointer;font-family:'DM Sans',sans-serif;display:inline-flex;align-items:center;gap:6px;text-decoration:none;color:var(--forest);transition:all .15s}
        .link-btn:hover{border-color:var(--forest);background:var(--mint)}
        .footer-app{padding:.75rem 1.75rem;border-top:1px solid var(--border);font-size:.75rem;color:var(--muted);background:var(--white)}
    </style>
</head>
<body>
    <div class="app-wrap">
        <!-- SIDEBAR -->
        <aside class="sidebar">
            <div class="sidebar-brand">
                <div class="sidebar-logo-icon"><i class="bi bi-briefcase"></i></div>
                <div class="sidebar-brand-name">TechMada RH<span>Espace employé</span></div>
            </div>
            <div class="sidebar-section">Menu</div>
            <ul class="sidebar-nav">
                <li><a href="<?= base_url('/employe/dashboard') ?>" class="active"><i class="bi bi-grid-1x2"></i> Tableau de bord</a></li>
                <li><a href="<?= base_url('/employe/conges/form') ?>"><i class="bi bi-plus-circle"></i> Nouvelle demande</a></li>
                <li><a href="<?= base_url('/employe/conges') ?>"><i class="bi bi-calendar3"></i> Mes demandes</a></li>
            </ul>
            <div class="sidebar-user">
                <div style="display:flex;align-items:center;gap:9px;padding:9px 11px;border-radius:7px;cursor:pointer">
                    <div class="avatar"><?= strtoupper(substr(session()->get('user_prenom') ?? 'U', 0, 1)) ?></div>
                    <div style="flex:1">
                        <div class="user-name"><?= esc(session()->get('user_prenom') ?? 'Utilisateur') ?></div>
                        <div class="user-role">Employé</div>
                    </div>
                </div>
            </div>
        </aside>
        <div class="main">
            <!-- TOPBAR -->
            <div class="topbar">
                <div class="topbar-title">Tableau de bord</div>
                <div class="topbar-actions">
                    <a href="<?= base_url('/auth/logout') ?>" class="icon-btn" title="Déconnexion"><i class="bi bi-box-arrow-right"></i></a>
                </div>
            </div>
            <!-- CONTENT -->
            <div class="content">
                <div class="data-card">
                    <div class="data-card-head">
                        <h3>Soldes de congés 2025</h3>
                    </div>
                    <div class="data-card-body">
                        <div class="tile">
                            <div class="tile-label">Congé annuel — Restant</div>
                            <div class="tile-value">20 j</div>
                        </div>
                        <div class="tile">
                            <div class="tile-label">Congé maladie — Restant</div>
                            <div class="tile-value">15 j</div>
                        </div>
                    </div>
                </div>
                <div class="data-card">
                    <div class="data-card-head">
                        <h3>Dernières demandes</h3>
                    </div>
                    <div class="data-card-body">
                        <p style="color:var(--muted);font-size:.85rem;margin-bottom:1rem">Les demandes soumises seront listées ici.</p>
                        <a href="<?= base_url('/employe/conges/form') ?>" class="link-btn">
                            <i class="bi bi-plus-lg"></i> Nouvelle demande
                        </a>
                    </div>
                </div>
            </div>
            <div class="footer-app"><i class="bi bi-c-circle"></i> 2025 <span style="color:var(--forest);font-weight:500">TechMada RH</span></div>
        </div>
    </div>
</body>
</html>
