<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
    <title>Nouvelle demande de congé — TechMada RH</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet"/>
    <style>
        :root{--ink:#1c2b1e;--forest:#2d5a3d;--forest2:#3d7a52;--leaf:#5fa876;--mint:#d4ede0;--cream:#f8f6f1;--white:#ffffff;--border:#dde8e1;--muted:#7a8f80;--success:#1e6b3f;--success-bg:#edf7f2;--info:#1a4f7a;--info-bg:#eaf2fb;--sidebar-w:240px;--topbar-h:62px}
        *{box-sizing:border-box}
        body{font-family:'DM Sans',sans-serif;background:var(--cream);color:var(--ink);margin:0}
        h1,h2,h3{font-family:'Playfair Display',serif}
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
        .content{padding:1.75rem;flex:1}
        .form-section{background:var(--white);border:1px solid var(--border);border-radius:12px;padding:1.5rem;margin-bottom:1.5rem}
        .form-section h3{font-family:'Playfair Display',serif;font-size:.95rem;font-weight:600;margin:0 0 1.25rem;color:var(--ink)}
        .form-grid-2{display:grid;grid-template-columns:1fr 1fr;gap:1rem}
        @media(max-width:600px){.form-grid-2{grid-template-columns:1fr}}
        .f-label{font-size:.8rem;font-weight:500;color:var(--ink);margin-bottom:5px;display:block}
        .f-input{width:100%;border:1.5px solid var(--border);border-radius:8px;padding:10px 12px;font-size:.875rem;font-family:'DM Sans',sans-serif;background:var(--white);color:var(--ink)}
        .f-input:focus{border-color:var(--forest);outline:none;box-shadow:0 0 0 3px rgba(45,90,61,.1)}
        .f-textarea{width:100%;border:1.5px solid var(--border);border-radius:8px;padding:10px 12px;font-size:.875rem;font-family:'DM Sans',sans-serif;background:var(--white);color:var(--ink);resize:vertical;min-height:80px}
        .f-textarea:focus{border-color:var(--forest);outline:none;box-shadow:0 0 0 3px rgba(45,90,61,.1)}
        .form-actions{display:flex;gap:10px;flex-wrap:wrap;margin-top:1.25rem;justify-content:flex-end}
        .btn-forest{background:var(--forest);color:var(--white);border:none;border-radius:8px;padding:9px 16px;font-size:.85rem;font-weight:500;cursor:pointer;font-family:'DM Sans',sans-serif;transition:background .15s}
        .btn-forest:hover{background:var(--forest2)}
        .btn-secondary{background:var(--white);color:var(--muted);border:1.5px solid var(--border);border-radius:8px;padding:9px 16px;font-size:.85rem;font-weight:500;cursor:pointer;font-family:'DM Sans',sans-serif;text-decoration:none;transition:all .15s}
        .btn-secondary:hover{border-color:var(--muted);color:var(--ink)}
        .flash{padding:11px 14px;border-radius:8px;font-size:.85rem;font-weight:500;display:flex;align-items:center;gap:9px;margin-bottom:1.25rem;border:1px solid transparent}
        .flash-success{background:var(--success-bg);color:var(--success);border-color:var(--leaf)}
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
                <li><a href="<?= base_url('/employe/dashboard') ?>"><i class="bi bi-grid-1x2"></i> Tableau de bord</a></li>
                <li><a href="<?= base_url('/employe/conges/form') ?>" class="active"><i class="bi bi-plus-circle"></i> Nouvelle demande</a></li>
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
                <div class="topbar-title">Nouvelle demande de congé</div>
                <div style="margin-left:auto">
                    <a href="<?= base_url('/auth/logout') ?>" style="color:var(--muted);text-decoration:none;font-size:.85rem">Déconnexion</a>
                </div>
            </div>
            <!-- CONTENT -->
            <div class="content">
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="flash flash-success">
                        <i class="bi bi-check-circle-fill"></i>
                        <?= esc(session()->getFlashdata('success')) ?>
                    </div>
                <?php endif; ?>
                <div class="form-section">
                    <h3>Remplissez le formulaire</h3>
                    <form action="<?= base_url('/employe/conges/send') ?>" method="POST">
                        <?= csrf_field() ?>
                        <div style="margin-bottom:1rem">
                            <label class="f-label">Type de congé</label>
                            <select name="type_conge" class="f-input" required>
                                <?php foreach ($types_conge as $type): ?>
                                    <option value="<?= esc($type['id']) ?>"><?= esc($type['nom'] ?? $type['libelle'] ?? '—') ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-grid-2">
                            <div>
                                <label class="f-label">Date de début</label>
                                <input type="date" name="date_debut" class="f-input" required/>
                            </div>
                            <div>
                                <label class="f-label">Date de fin</label>
                                <input type="date" name="date_fin" class="f-input" required/>
                            </div>
                        </div>
                        <div style="margin-top:1rem;margin-bottom:1rem">
                            <label class="f-label">Motif (facultatif)</label>
                            <textarea name="commentaire" class="f-textarea" placeholder="Ex : congé annuel, motif personnel..."></textarea>
                        </div>
                        <div class="form-actions">
                            <a href="<?= base_url('/employe/conges') ?>" class="btn-secondary">Annuler</a>
                            <button type="submit" class="btn-forest">Soumettre la demande</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="footer-app"><i class="bi bi-c-circle"></i> 2025 <span style="color:var(--forest);font-weight:500">TechMada RH</span></div>
        </div>
    </div>
</body>
</html>