<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Demande de congé</title>
</head>
<body>

    <h2>Demande de congé</h2>

    <?php if (! empty($error)) : ?>
        <div style="background-color: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; padding: 12px; border-radius: 4px; margin-bottom: 20px;">
            <strong>⚠️ Erreur :</strong> <?= esc($error) ?>
        </div>
    <?php endif; ?>

    <?php if (! empty($success)) : ?>
        <div style="background-color: #d4edda; border: 1px solid #c3e6cb; color: #155724; padding: 12px; border-radius: 4px; margin-bottom: 20px;">
            <strong>✓ Succès :</strong> <?= esc($success) ?>
        </div>
    <?php endif; ?>

    <form action="/conges/send" method="POST">
        <label for="type_conge">Type de congé :</label>
        <select id="type_conge" name="type_conge" required>
            <?php foreach ($types_conge as $type) : ?>
                <option value="<?= esc($type['id']) ?>"><?= esc($type['libelle']) ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <label for="date_debut">Date de début :</label>
        <input type="date" id="date_debut" name="date_debut" required><br><br>

        <label for="date_fin">Date de fin :</label>
        <input type="date" id="date_fin" name="date_fin" required><br><br>

        <label for="commentaire">Motif / commentaire (facultatif) :</label><br>
        <textarea id="commentaire" name="commentaire" rows="4" cols="50"></textarea><br><br>

        <input type="submit" value="Soumettre la demande">
    </form>

</body>
</html>