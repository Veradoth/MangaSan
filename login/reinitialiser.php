<?php
session_start(); // Démarrez la session au début du fichier

if (isset($_POST['valider'])) {
    require_once("../config/config.php");
    
    $nouveauMotDePasse = $_POST['password'];
    $confirmationMotDePasse = $_POST['password_confirm'];

    // Vérifiez si les mots de passe correspondent
    if ($nouveauMotDePasse === $confirmationMotDePasse) {
        // Récupérez l'adresse e-mail de la session
        $email = $_SESSION['mail'];

        // Hachez le nouveau mot de passe
        $motDePasseHash = password_hash($nouveauMotDePasse, PASSWORD_DEFAULT);

        // Requête pour mettre à jour le mot de passe dans la base de données
        $sql = "UPDATE utilisateur SET mdp_hash = ? WHERE mail = ?";
        $stmt = $connexion->prepare($sql);
        $stmt->bind_param("ss", $motDePasseHash, $email);
        $stmt->execute();

        unset($_SESSION['mail']);

        if ($stmt->affected_rows > 0) {
            // Mot de passe mis à jour avec succès, redirigez ou affichez un message de succès
            unset($_SESSION['mail']);
            header("Location: connexion.php");
            exit;
        } elseif(!$stmt->execute()) {
            // Erreur lors de la mise à jour du mot de passe
            die ("Erreur lors de la mise à jour du mot de passe : " . $stmt->error);
        }
    } else {
        // Les mots de passe ne correspondent pas, affichez un message d'erreur
        echo "Les mots de passe ne correspondent pas.";
    }
}

?>
<!-- Le reste de votre formulaire et HTML -->


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialiser</title>
</head>
<body>
<form action="" method="POST">
        <label>Nouveau mot de passe</label>
        <input type="password" name="password">
        <label>Confirmer votre nouveau mot de passe</label>
        <input type="password" name="password_confirm">
        <button type="submit" name="valider"> Valider</button>
        <br>
    </form>
    <button onclick="window.location.href='mail.php';" class="btnLogin-popup">Retour</button>
</body>
</html>