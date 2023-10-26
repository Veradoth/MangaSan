<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Membres</title>
</head>
<body>
<div class="center">
        <h1>Membres</h1><br><br>
        <a href="../choix.php">Retour</a>
        <div class="voiture">
            <h2>Utilisateurs</h2>
            <?php
            require_once("../../config/pdo.php");

            $sql = 'SELECT * FROM utilisateur';
            $stmt = $connexion->prepare($sql);
            $stmt->execute();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // Échapper les données pour éviter les attaques XSS
                $nom = htmlspecialchars($row['pseudo']);
                $id = $row['id']; // Utilisez l'ID pour créer un lien sécurisé

                // Utilisez l'ID dans l'URL pour afficher les détails du manga en toute sécurité
                echo '<div class="card" style="width: 18rem;">';
                echo '<div class="card-body">';
                echo '<h5 class="card-title">' . $nom . '</h5>';
                echo '<a href="changer_admin.php?id=' . $id . '" class="btn btn-primary">Passer en admin</a>';
                echo '</div>';
                echo '</div>';
            }
            ?>

            <h2>Administrateurs</h2>
            <?php
            require_once("../../config/pdo.php");

            $sql = 'SELECT * FROM administrateur';
            $stmt = $connexion->prepare($sql);
            $stmt->execute();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // Échapper les données pour éviter les attaques XSS
                $nom = htmlspecialchars($row['nom']);
                $id = $row['id']; // Utilisez l'ID pour créer un lien sécurisé

                // Utilisez l'ID dans l'URL pour afficher les détails du manga en toute sécurité
                echo '<div class="card" style="width: 18rem;">';
                echo '<div class="card-body">';
                echo '<h5 class="card-title">' . $nom . '</h5>';
                echo '<a href="changer_user.php?id=' . $id . '" class="btn btn-primary">Passer en utilisateur</a>';
                echo '</div>';
                echo '</div>';
            }
            ?>
        </div>
    </div>
</body>
</html>