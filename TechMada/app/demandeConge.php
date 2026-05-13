<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Nouvelle demande de congé — TechMada</title>
    <style>
        :root{--bg:#0f172a;--card:#0b1220;--accent:#667eea;--muted:#94a3b8;--glass:rgba(255,255,255,0.04)}
        *{box-sizing:border-box}
        body{margin:0;font-family:Inter, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;background:linear-gradient(180deg,#071029 0%, #0f172a 100%);color:#e6eef8;min-height:100vh;padding:28px}
        .wrap{width:100%;max-width:760px;margin:0 auto}
        .card{background:linear-gradient(180deg, rgba(255,255,255,0.02), rgba(255,255,255,0.01));border-radius:12px;padding:22px;box-shadow:0 10px 30px rgba(2,6,23,0.6);border:1px solid rgba(255,255,255,0.03)}
        header{display:flex;align-items:center;justify-content:space-between;margin-bottom:14px}
        header h1{font-size:18px;margin:0}
        header .sub{color:var(--muted);font-size:13px}

        form{display:grid;gap:12px}
        label{font-size:13px;color:var(--muted);display:block}
        select,input[type=date],textarea{width:100%;padding:10px;border-radius:8px;border:1px solid rgba(255,255,255,0.04);background:transparent;color:inherit;font-size:14px}
        textarea{min-height:110px;resize:vertical}
        .row{display:flex;gap:12px}
        .row .col{flex:1}

        .actions{display:flex;gap:10px;justify-content:flex-end;margin-top:8px}
        .btn{padding:10px 14px;border-radius:8px;border:none;cursor:pointer;font-weight:600}
        .btn.primary{background:var(--accent);color:#fff}
        .btn.ghost{background:transparent;border:1px solid rgba(255,255,255,0.06);color:#cfe3ff}

        .hint{font-size:12px;color:var(--muted)}

        @media (max-width:600px){.row{flex-direction:column}}
    </style>
</head>
<body>
    <div class="wrap">
        <div class="card">
            <header>
                <div>
                    <h1>Nouvelle demande de congé</h1>
                    <div class="sub">Remplissez le formulaire pour soumettre une demande</div>
                </div>
                <div class="sub">Mon espace — <a style="color:var(--accent);text-decoration:none" href="<?= base_url('/employe/dashboard') ?>">Retour</a></div>
            </header>

            <?php if (session()->getFlashdata('success')): ?>
                <div style="background:#d1e7dd;color:#0f5132;padding:10px;border-radius:6px;margin-bottom:10px"><?= session()->getFlashdata('success') ?></div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')): ?>
                <div style="background:#f8d7da;color:#842029;padding:10px;border-radius:6px;margin-bottom:10px"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>

            <form action="<?= base_url('/employe/conges/send') ?>" method="POST">
                <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>">

                <div>
                    <label for="type_conge">Type de congé</label>
                    <select id="type_conge" name="type_conge" required>
                        <?php foreach ($types_conge as $type) : ?>
                            <option value="<?= esc($type['id']) ?>"><?= esc($type['nom'] ?? $type['libelle'] ?? '—') ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="row">
                    <div class="col">
                        <label for="date_debut">Date de début</label>
                        <input type="date" id="date_debut" name="date_debut" required>
                    </div>
                    <div class="col">
                        <label for="date_fin">Date de fin</label>
                        <input type="date" id="date_fin" name="date_fin" required>
                    </div>
                </div>

                <div>
                    <label for="commentaire">Commentaire (facultatif)</label>
                    <textarea id="commentaire" name="commentaire" placeholder="Ex : congé annuel, motif personnel..."></textarea>
                    <div class="hint">Les champs marqués d'un astérisque sont obligatoires.</div>
                </div>

                <div class="actions">
                    <a class="btn ghost" href="<?= base_url('/employe/dashboard') ?>">Annuler</a>
                    <button class="btn primary" type="submit">Soumettre la demande</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>