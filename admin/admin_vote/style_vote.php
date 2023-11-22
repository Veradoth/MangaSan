<?php
    require_once("../../session.php");

    if (!isset($_SESSION["admin_id"])) {
        // L'utilisateur n'est pas connecté en tant qu'administrateur, redirigez-le vers la page d'accueil.
        header("Location: ../accueil.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../style.css">
    <title>Vote</title>
</head>
<body>
    <header class="header-up"> <!-- En-tête en haut du site -->
        <h2 class="logo">Vote</h2>
        <nav class="navigation">
            <a href="?action=add_vote">Ajouter un vote</a>
            <a href="?action=mod_vote">Modifier un vote</a>
            <a href="?action=suppr_vote">Supprimer un vote</a>
            <button onclick="window.location.href='../choix.php';" class="btnLogin-popup" name="valider">Retour <!-- Affiche le bouton de déconnexion -->
        </nav>
    </header>
    <script src="choix.js"></script>
</body>
</html>