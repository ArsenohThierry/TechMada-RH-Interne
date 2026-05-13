<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
    <title>Validation des demandes — TechMada RH</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet"/>
    <style>
        :root{--ink:#1c2b1e;--forest:#2d5a3d;--forest2:#3d7a52;--leaf:#5fa876;--mint:#d4ede0;--cream:#f8f6f1;--white:#ffffff;--border:#dde8e1;--muted:#7a8f80;--warn:#b8750a;--warn-bg:#fef9ee;--warn-br:#f5d98a;--success:#1e6b3f;--success-bg:#edf7f2;--success-br:#8fd4aa;--danger:#c0392b;--danger-bg:#fdf0ee;--danger-br:#f0b8b2;--sidebar-w:240px;--topbar-h:62px}
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
        .flash{padding:11px 14px;border-radius:8px;font-size:.85rem;font-weight:500;display:flex;align-items:center;gap:9px;margin-bottom:1.25rem;border:1px solid transparent}
        .flash-success{background:var(--success-bg);color:var(--success);border-color:var(--success-br)}
        .flash-error{background:var(--danger-bg);color:var(--danger);border-color:var(--danger-br)}
        .metrics{display:grid;grid-template-columns:repeat(auto-fit,minmax(170px,1fr));gap:1rem;margin-bottom:1.75rem}
        .metric{background:var(--white);border:1px solid var(--border);border-radius:12px;padding:1.1rem 1.25rem}
        .metric-top{display:flex;align-items:center;justify-content:space-between;margin-bottom:.75rem}
        .metric-icon{width:36px;height:36px;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:1rem}
        .mi-amber{background:var(--warn-bg);color:var(--warn)}
        .mi-green{background:var(--success-bg);color:var(--success)}
        .mi-red{background:var(--danger-bg);color:var(--danger)}
        .metric-val{font-family:'DM Mono',monospace;font-size:1.75rem;font-weight:500;color:var(--ink);line-height:1}
        .metric-label{font-size:.775rem;color:var(--muted);margin-top:4px}
        .data-card{background:var(--white);border:1px solid var(--border);border-radius:12px;overflow:hidden;margin-bottom:1.5rem}
        .data-card-head{padding:.9rem 1.25rem;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;gap:.75rem;flex-wrap:wrap}
        .data-card-head h3{font-family:'Playfair Display',serif;font-size:.95rem;margin:0;font-weight:600;color:var(--ink)}
        .filtres{display:flex;gap:12px;align-items:center;flex-wrap:wrap;padding:.9rem 1.25rem;border-bottom:1px solid var(--border)}
        .filtres label{font-size:.8rem;font-weight:500;color:var(--ink)}
        .filtres select{border:1.5px solid var(--border);border-radius:8px;padding:8px 12px;font-size:.85rem;background:var(--white);color:var(--ink);cursor:pointer}
        .filtres select:focus{border-color:var(--forest);outline:none}
        .tbl{width:100%;border-collapse:collapse;font-size:.85rem}
        .tbl thead th{padding:9px 14px;font-size:.68rem;font-weight:500;text-transform:uppercase;letter-spacing:.07em;color:var(--muted);background:var(--cream);border-bottom:1px solid var(--border);text-align:left;white-space:nowrap}
        .tbl tbody tr{border-bottom:1px solid var(--border);transition:background .1s}
        .tbl tbody tr:last-child{border-bottom:none}
        .tbl tbody tr:hover{background:var(--cream)}
        .tbl td{padding:12px 14px;color:var(--ink);vertical-align:middle}
        .td-mono{font-family:'DM Mono',monospace;font-size:.8rem}
        .statut{display:inline-flex;align-items:center;gap:5px;font-size:.7rem;font-weight:500;padding:4px 9px;border-radius:12px}
        .statut::before{content:'';width:5px;height:5px;border-radius:50%;display:inline-block;flex-shrink:0}
        .s-attente{background:var(--warn-bg);color:var(--warn)}
        .s-attente::before{background:var(--warn)}
        .s-approuvee{background:var(--success-bg);color:var(--success)}
        .s-approuvee::before{background:var(--success)}
        .s-refusee{background:var(--danger-bg);color:var(--danger)}
        .s-refusee::before{background:var(--danger)}
        .s-annulee{background:#f1efe8;color:#7a8f80}
        .s-annulee::before{background:#b4b2a9}
        .action-btns{display:flex;gap:5px;flex-wrap:wrap}
        .btn-sm{font-size:.72rem;font-weight:500;padding:5px 10px;border-radius:6px;border:1px solid transparent;cursor:pointer;transition:all .15s;text-decoration:none;display:inline-flex;align-items:center;gap:4px;font-family:'DM Sans',sans-serif}
        .btn-approve{background:var(--success-bg);color:var(--success);border-color:var(--success-br)}
        .btn-approve:hover{background:#d5f0e3}
        .btn-refuse{background:var(--danger-bg);color:var(--danger);border-color:var(--danger-br)}
        .btn-refuse:hover{background:#f8dbd8}
        .empty{text-align:center;padding:30px;color:var(--muted)}
        .modal-overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,.45);z-index:100;justify-content:center;align-items:center}
        .modal-overlay.open{display:flex}
        .modal{background:var(--white);padding:24px;border-radius:6px;width:420px;max-width:95%}
        .modal h3{margin-bottom:14px;font-size:15px;color:var(--ink)}
        .modal textarea{width:100%;padding:8px;border:1px solid var(--border);border-radius:4px;font-size:13px;resize:vertical;min-height:80px;color:var(--ink)}
        .modal-actions{display:flex;justify-content:flex-end;gap:8px;margin-top:14px}
        .modal-actions button[type=button]{background:none;border:1px solid var(--border);padding:6px 14px;border-radius:4px;cursor:pointer;font-size:13px;color:var(--muted)}
        .modal-actions button[type=submit]{background:var(--danger);color:var(--white);border:none;padding:6px 14px;border-radius:4px;cursor:pointer;font-size:13px;font-weight:500}
        .modal-actions button[type=submit]:hover{background:var(--danger-br)}
        .footer-app{padding:.75rem 1.75rem;border-top:1px solid var(--border);font-size:.75rem;color:var(--muted);background:var(--white)}
    </style>
</head>
<body>
    <div class="app-wrap">
        <!-- SIDEBAR -->
        <aside class="sidebar">
            <div class="sidebar-brand">
                <div class="sidebar-logo-icon"><i class="bi bi-person-check"></i></div>
                <div class="sidebar-brand-name">TechMada RH<span>Espace responsable</span></div>
            </div>
            <div class="sidebar-section">Menu</div>
            <ul class="sidebar-nav">
                <li><a href="<?= base_url('/') ?>"><i class="bi bi-grid-1x2"></i> Tableau de bord</a></li>
                <li><a href="<?= base_url('/rh/listeDemandes') ?>" class="active"><i class="bi bi-archive"></i> Validation demandes</a></li>
            </ul>
            <div class="sidebar-user">
                <div style="display:flex;align-items:center;gap:9px;padding:9px 11px;border-radius:7px;cursor:pointer">
                    <div class="avatar"><?= strtoupper(substr(session()->get('user_prenom') ?? 'U', 0, 1)) ?></div>
                    <div style="flex:1">
                        <div class="user-name"><?= esc(session()->get('user_prenom') ?? 'Utilisateur') ?></div>
                        <div class="user-role">RH</div>
                    </div>
                </div>
            </div>
        </aside>
        <div class="main">
            <!-- TOPBAR -->
            <div class="topbar">
                <div class="topbar-title">Validation des demandes</div>
                <div class="topbar-actions">
                    <a href="<?= base_url('/auth/logout') ?>" class="icon-btn" title="Déconnexion"><i class="bi bi-box-arrow-right"></i></a>
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
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="flash flash-error">
                        <i class="bi bi-exclamation-circle-fill"></i>
                        <?= esc(session()->getFlashdata('error')) ?>
                    </div>
                <?php endif; ?>

                <!-- MÉTRIQUES -->
                <div class="metrics">
                    <div class="metric">
                        <div class="metric-top">
                            <div class="metric-icon mi-amber"><i class="bi bi-clock-history"></i></div>
                        </div>
                        <div class="metric-val" id="nbAttente"><?= $nb_en_attente ?></div>
                        <div class="metric-label">En attente</div>
                    </div>
                    <div class="metric">
                        <div class="metric-top">
                            <div class="metric-icon mi-green"><i class="bi bi-check-lg"></i></div>
                        </div>
                        <div class="metric-val" id="nbApprouvees"><?= $nb_approuvees ?></div>
                        <div class="metric-label">Approuvées</div>
                    </div>
                    <div class="metric">
                        <div class="metric-top">
                            <div class="metric-icon mi-red"><i class="bi bi-x-lg"></i></div>
                        </div>
                        <div class="metric-val" id="nbRefusees"><?= $nb_refusees ?></div>
                        <div class="metric-label">Refusées</div>
                    </div>
                    <div class="metric">
                        <div class="metric-top">
                            <div class="metric-icon" style="background:var(--mint);color:var(--forest)"><i class="bi bi-graph-up"></i></div>
                        </div>
                        <div class="metric-val" id="nbTotal"><?= $nb_total ?></div>
                        <div class="metric-label">Total</div>
                    </div>
                </div>

                <!-- TABLE -->
                <div class="data-card">
                    <div class="filtres">
                        <label>Statut</label>
                        <select id="filter-statut">
                            <option value="">Tous</option>
                            <option value="en_attente">En attente</option>
                            <option value="approuvee">Approuvée</option>
                            <option value="refusee">Refusée</option>
                            <option value="annulee">Annulée</option>
                        </select>
                        <label style="margin-left:auto">Département</label>
                        <select id="filter-dept">
                            <option value="">Tous</option>
                            <?php foreach ($departements as $dep): ?>
                                <option value="<?= $dep['id'] ?>">
                                    <?= esc($dep['nom']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <table class="tbl">
                        <thead>
                            <tr>
                                <th>Employé</th>
                                <th>Département</th>
                                <th>Type</th>
                                <th>Du</th>
                                <th>Au</th>
                                <th>Jours</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($conges)): ?>
                                <tr><td colspan="8" class="empty">Aucune demande trouvée.</td></tr>
                            <?php else: ?>
                                <?php foreach ($conges as $c): ?>
                                <tr>
                                    <td><?= esc($c['employe_nom'] . ' ' . $c['employe_prenom']) ?></td>
                                    <td><?= esc($c['departement'] ?? '—') ?></td>
                                    <td><?= esc($c['type_conge_libelle']) ?></td>
                                    <td class="td-mono"><?= esc($c['date_debut']) ?></td>
                                    <td class="td-mono"><?= esc($c['date_fin']) ?></td>
                                    <td class="td-mono"><?= esc($c['nb_jours']) ?> j</td>
                                    <td><span class="statut s-<?= esc($c['statut']) ?>"><?= esc($c['statut']) ?></span></td>
                                    <td>
                                        <?php if ($c['statut'] === 'en_attente'): ?>
                                            <div class="action-btns">
                                                <form method="POST" action="<?= base_url('/rh/conges/approuver/' . $c['id']) ?>" style="display:inline">
                                                    <?= csrf_field() ?>
                                                    <button type="submit" class="btn-sm btn-approve" onclick="return confirm('Approuver cette demande ?')">
                                                        <i class="bi bi-check"></i> Approuver
                                                    </button>
                                                </form>
                                                <button type="button" class="btn-sm btn-refuse" onclick="ouvrirModal(<?= $c['id'] ?>)">
                                                    <i class="bi bi-x"></i> Refuser
                                                </button>
                                            </div>
                                        <?php elseif ($c['statut'] === 'approuvee'): ?>
                                            <form method="POST" action="<?= base_url('/rh/conges/annuler/' . $c['id']) ?>" style="display:inline">
                                                <?= csrf_field() ?>
                                                <button type="submit" class="btn-sm btn-refuse" onclick="return confirm('Annuler cette approbation ? Le solde sera remboursé.')">
                                                    <i class="bi bi-x"></i> Annuler
                                                </button>
                                            </form>
                                        <?php else: ?>
                                            —
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="footer-app"><i class="bi bi-c-circle"></i> 2025 <span style="color:var(--forest);font-weight:500">TechMada RH</span></div>
        </div>
    </div>

    <!-- MODAL REFUS -->
    <div class="modal-overlay" id="modal-overlay">
        <div class="modal">
            <h3>Refuser la demande</h3>
            <form method="POST" id="form-refus" action="">
                <?= csrf_field() ?>
                <label for="commentaire_rh" style="font-size:.8rem;font-weight:500;color:var(--ink);display:block;margin-bottom:8px">
                    Commentaire (optionnel)
                </label>
                <textarea name="commentaire_rh" id="commentaire_rh"
                          placeholder="Ex : Solde insuffisant, période chargée..."></textarea>
                <div class="modal-actions">
                    <button type="button" onclick="fermerModal()">Annuler</button>
                    <button type="submit">Confirmer le refus</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const tousLesConges = <?= json_encode($conges) ?>;
        const filterStatut = document.getElementById('filter-statut');
        const filterDept = document.getElementById('filter-dept');
        const tableBody = document.querySelector('.tbl tbody');

        function appliquerFiltres() {
            const statutSelectionne = filterStatut.value;
            const deptSelectionne = filterDept.value;
            const donneesFiltrees = tousLesConges.filter(c => {
                const matchStatut = !statutSelectionne || c.statut === statutSelectionne;
                const matchDept = !deptSelectionne || (c.departement_id && c.departement_id == deptSelectionne);
                return matchStatut && matchDept;
            });
            afficherTableau(donneesFiltrees);
            mettreAJourCompteurs(donneesFiltrees);
        }

        function afficherTableau(donnees) {
            tableBody.innerHTML = '';
            if (donnees.length === 0) {
                tableBody.innerHTML = '<tr><td colspan="8" class="empty">Aucune demande trouvée.</td></tr>';
                return;
            }
            donnees.forEach(c => {
                const tr = document.createElement('tr');
                const statClass = `s-${escapeHtml(c.statut)}`;
                const actions = genererActions(c);
                tr.innerHTML = `
                    <td>${escapeHtml(c.employe_nom + ' ' + c.employe_prenom)}</td>
                    <td>${escapeHtml(c.departement ?? '—')}</td>
                    <td>${escapeHtml(c.type_conge_libelle)}</td>
                    <td class="td-mono">${escapeHtml(c.date_debut)}</td>
                    <td class="td-mono">${escapeHtml(c.date_fin)}</td>
                    <td class="td-mono">${escapeHtml(c.nb_jours)} j</td>
                    <td><span class="statut ${statClass}">${escapeHtml(c.statut)}</span></td>
                    <td>${actions}</td>
                `;
                tableBody.appendChild(tr);
            });
        }

        function genererActions(c) {
            if (c.statut === 'en_attente') {
                return `
                    <div class="action-btns">
                        <form method="POST" action="/rh/conges/approuver/${c.id}" style="display:inline">
                            <input type="hidden" name="${csrfTokenName()}" value="${csrfTokenHash()}">
                            <button class="btn-sm btn-approve" onclick="return confirm('Approuver cette demande ?')">
                                <i class="bi bi-check"></i> Approuver
                            </button>
                        </form>
                        <button class="btn-sm btn-refuse" onclick="ouvrirModal(${c.id})">
                            <i class="bi bi-x"></i> Refuser
                        </button>
                    </div>
                `;
            } else if (c.statut === 'approuvee') {
                return `
                    <form method="POST" action="/rh/conges/annuler/${c.id}" style="display:inline">
                        <input type="hidden" name="${csrfTokenName()}" value="${csrfTokenHash()}">
                        <button class="btn-sm btn-refuse" onclick="return confirm('Annuler cette approbation ? Le solde sera remboursé.')">
                            <i class="bi bi-x"></i> Annuler
                        </button>
                    </form>
                `;
            }
            return '—';
        }

        function mettreAJourCompteurs(donnees) {
            const nbAttente = donnees.filter(c => c.statut === 'en_attente').length;
            const nbApprouvees = donnees.filter(c => c.statut === 'approuvee').length;
            const nbRefusees = donnees.filter(c => c.statut === 'refusee').length;
            const nbTotal = donnees.length;
            document.getElementById('nbAttente').textContent = nbAttente;
            document.getElementById('nbApprouvees').textContent = nbApprouvees;
            document.getElementById('nbRefusees').textContent = nbRefusees;
            document.getElementById('nbTotal').textContent = nbTotal;
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        function csrfTokenName() { return '<?= csrf_token() ?>'; }
        function csrfTokenHash() { return '<?= csrf_hash() ?>'; }

        filterStatut.addEventListener('change', appliquerFiltres);
        filterDept.addEventListener('change', appliquerFiltres);
        appliquerFiltres();

        function ouvrirModal(congeId) {
            document.getElementById('form-refus').action = '/rh/conges/refuser/' + congeId;
            document.getElementById('modal-overlay').classList.add('open');
        }

        function fermerModal() {
            document.getElementById('modal-overlay').classList.remove('open');
            document.getElementById('commentaire_rh').value = '';
        }

        document.getElementById('modal-overlay').addEventListener('click', function(e) {
            if (e.target === this) fermerModal();
        });
    </script>
</body>
</html>
