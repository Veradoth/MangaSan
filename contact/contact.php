<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>
</head>
<body>

    <h1>Contactez-nous</h1>

    <form action="envoi.php" method="POST">
        <div>
            <label for="objet">Objet :</label>
            <input type="text" id="objet" name="objet" required>
        </div>
        <div>
            <label for="description">Description :</label>
            <textarea id="description" name="description" rows="4" required></textarea>
        </div>
        <div>
            <input type="submit" value="Envoyer">
        </div>
    </form>

</body>
</html>
