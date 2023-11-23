<?php
    require_once("../../session.php");
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
            <button onclick="window.location.href='../../classement/vote.php';" class="btnLogin-popup" name="valider">Retour <!-- Affiche le bouton de déconnexion -->
        </nav>
    </header>
    <script src="choix.js"></script>
</body>
</html>