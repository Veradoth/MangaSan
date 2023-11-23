<?php
require_once("session.php");

$showAdminLink = false; // Par défaut, ne pas afficher le lien "Administration" s'il n'y a pas de connexion.

if (isset($_SESSION["user_id"])) {
    // L'utilisateur est connecté, donc le lien "Administration" doit être caché
    $showAdminLink = false;
}

elseif (isset($_SESSION["admin_id"])){
    $showAdminLink = true;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="test.css">
    <title>MangaSan</title>
</head>
<body>
    <header class="header-up"> <!-- En-tête en haut du site -->
        <h2 class="logo">MangaSan</h2>
        <nav class="navigation">
            <a href="index.php">Accueil</a>
            <a href="#">A propos</a>
            <a href="#">Service</a>
            <a href="contact/contact.php">Contact</a>
            <?php if ($showAdminLink): ?>
            <a href="contact/reception.php">Réception</a>
            <?php endif; ?>
            <?php if ($showAdminLink): ?>
            <a href="admin/choix.php">Administration</a>
            <?php endif; ?>
            <?php if (isset($user)): ?> <!-- Vérifie si l'utilisateur est connecté -->
                <button onclick="window.location.href='login/deconnexion.php';" class="btnLogin-popup" name="valider"><?= htmlspecialchars($user["pseudo"]) ?></button> <!-- Affiche le bouton de déconnexion -->
            <?php elseif (isset($_SESSION["admin_id"])): ?>
                <button onclick="window.location.href='login/deconnexion.php';" class="btnLogin-popup" name="valider"><?= htmlspecialchars($admin["nom"]) ?></button> <!-- Affiche le bouton de déconnexion -->
                <?php else: ?>
                <button onclick="window.location.href='login/connexion.php';" class="btnLogin-popup" name="valider">Se connecter</button> <!-- Affiche le bouton de connexion -->
            <?php endif; ?>
        </nav>
    </header>
    <div class="fenetre-options">
            <div class="fenetre-location">
            <button onclick="window.location.href='catalogue/visuel.php';" class="bouton">Voir les mangas</button> <!-- Affiche le lien de location -->
            <button onclick="window.location.href='edition/edition.php';" class="bouton">Donner impressions</button>
            <button onclick="window.location.href='classement/vote.php';" class="bouton">Vote</button>
            </div>
    </div>
</body>
</html>
