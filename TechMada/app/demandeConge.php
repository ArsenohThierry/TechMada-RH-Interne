<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Demande de congé</title>
</head>
<body>

    <h2>Demande de congé</h2>

    <form action="/conges/send" method="POST">
        <label for="type_conge">Type de congé :</label>
        <select id="type_conge" name="type_conge" required>
            <?php foreach ($types_conge as $type) : ?>
                <option value="<?= $type['id'] ?>"><?= $type['nom'] ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <label for="date_debut">Date de début :</label>
        <input type="date" id="date_debut" name="date_debut" required><br><br>

        <label for="date_fin">Date de fin :</label>
        <input type="date" id="date_fin" name="date_fin" required><br><br>

        <label for="commentaire">Commentaire (facultatif) :</label><br>
        <textarea id="commentaire" name="commentaire" rows="4" cols="50"></textarea><br><br>

        <input type="submit" value="Soumettre la demande">
    </form>

</body>
</html>