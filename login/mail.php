<?php
    session_start();

    if (isset($_POST['valider'])) {
        require_once("../config/config.php");

        // Récupérer l'adresse e-mail soumise dans le formulaire
        $email = $_POST['mail'];

        // Requête pour vérifier si l'adresse e-mail existe dans la base de données
        $query = "SELECT COUNT(*) FROM utilisateur WHERE mail = ?";
        $stmt = $connexion->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($result);
        $stmt->fetch();

        if ($result > 0) {
            // L'adresse e-mail existe, redirigez vers le formulaire de réinitialisation
            $_SESSION['mail'] = $email;
            header("Location: reinitialiser.php");
            exit;
        } else {
            // L'adresse e-mail n'existe pas, affichez un message d'erreur
            echo "L'adresse e-mail n'existe pas.";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation</title>
</head>
<body>
    <form action="" method="POST">
        <label>Adresse Mail</label>
        <input type="text" name="mail" placeholder="Entrer votre adresse mail"> <!-- Champ de saisie de l'adresse e-mail avec la valeur précédemment saisie -->
        <button type="submit" name="valider"> Valider</button>
        <br>
    </form>
    <button onclick="window.location.href='connexion.php';" class="btnLogin-popup">Retour</button>
</body>
</html>