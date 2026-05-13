<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechMada RH - Gestion des Congés</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #0F172A;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            background: #080E1C;
            border-radius: 10px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            padding: 60px;
            max-width: 600px;
            text-align: center;
        }

        h1 {
            color: #F8FAFC;
            font-size: 48px;
            margin-bottom: 20px;
        }

        .subtitle {
            color: #94A3B8;
            font-size: 18px;
            margin-bottom: 40px;
        }

        .button-group {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 40px;
        }

        .btn {
            padding: 15px 40px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
            transition: transform 0.2s;
            text-decoration: none;
            display: inline-block;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-secondary {
            background: white;
            color: #667eea;
            border: 2px solid #667eea;
        }

        .logout-btn {
            background: #f44336;
            color: white;
        }

        .features {
            margin-top: 50px;
            text-align: left;
            padding-top: 40px;
            border-top: 1px solid #eee;
        }

        .features h3 {
            color: #94A3B8;
            margin-bottom: 20px;
        }

        .feature-list {
            list-style: none;
        }

        .feature-list li {
            color: #94A3B8;
            margin-bottom: 12px;
            padding-left: 30px;
            position: relative;
        }

        .feature-list li:before {
            content: "✓";
            position: absolute;
            left: 0;
            color: #667eea;
            font-weight: bold;
        }

        .user-greeting {
            background: #080E1C;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 30px;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1> TechMada RH</h1>
        <p class="subtitle">Système de Gestion des Congés</p>

        <?php if (session()->get('logged_in')): ?>
            <div class="user-greeting">
                Bienvenue <strong><?= session()->get('user_prenom') ?></strong>!
            </div>

            <div class="button-group">
                <a href="<?= base_url('/dashboard') ?>" class="btn btn-primary">
                     Accéder au Dashboard
                </a>
                <a href="<?= base_url('/auth/logout') ?>" class="btn logout-btn">
                     Se déconnecter
                </a>
            </div>
        <?php else: ?>
            <p style="color: #666; margin-bottom: 30px;">
                Connectez-vous pour gérer vos congés et demandes d'absence
            </p>

            <div class="button-group">
                <a href="<?= base_url('/auth/login') ?>" class="btn btn-primary">
                     Se Connecter
                </a>
                <a href="<?= base_url('/auth/register') ?>" class="btn btn-secondary">
                     Créer un Compte
                </a>
            </div>

            <div class="features">
                <h3>Fonctionnalités</h3>
                <ul class="feature-list">
                    <li>Demander des congés facilement</li>
                    <li>Consulter vos soldes de congés</li>
                    <li>Historique de vos congés</li>
                    <li>Approvals et notifications</li>
                </ul>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>