<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choix</title>
</head>
<body>
    <h1>Choix</h1>
    <label for="action">Que voulez-vous faire ?</label>
    <select id="action">
        <option value="manga">Manga</option>
        <option value="membres">Membres</option>
    </select>
    <button id="submit">Confirmer</button>
    <button onclick="window.location.href='../index.php';" class="btnLogin-popup" name="valider">Retour</button>

    <script src="choix.js"></script>
</body>
</html>
