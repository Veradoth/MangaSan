<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edition</title>
</head>
<body>
<p><a href='edition.php'>Retour</a></p>
<?php

require_once("../config/config.php");

if(isset($_POST['graph']) && isset($_POST['theme']) && isset($_POST['pp']) && isset($_POST['bon']) && isset($_POST['mauvais']) && isset($_POST['appre']) && isset($_POST['numManga'])) {
    $numManga = $_POST['numManga'];
    $graph = $_POST['graph'];
    $theme = $_POST['theme'];
    $pp = $_POST['pp'];
    $bon = $_POST['bon'];
    $mauvais = $_POST['mauvais'];
    $appre = $_POST['appre'];

    // Utilisez des requêtes préparées avec MySQLi pour empêcher les injections SQL
    $sql = "INSERT INTO editage (id_manga, graphisme, theme, PP, bon, mauvais, appreciation) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $connexion->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ssssssi", $numManga, $graph, $theme, $pp, $bon, $mauvais, $appre);

        if ($stmt->execute()) {
            echo 'Vos informations ont bien été enregistrées.<br>';
        } else {
            echo 'Une erreur est survenue lors de l\'enregistrement de vos informations.<br>';
        }

        $stmt->close();
    } else {
        echo 'Une erreur est survenue lors de la préparation de la requête.<br>';
    }
} else {
    echo 'Les données de formulaire sont manquantes.';
}

mysqli_close($connexion);
?>
</body>
</html>
