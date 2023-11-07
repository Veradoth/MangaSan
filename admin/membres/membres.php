<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="membres.css">
    <title>Membres</title>
</head>
<body>
<div class="center">
    <h1>Membres</h1><br><br>
    <a href="../choix.php">Retour</a>
    <div class="voiture">
        <?php
        session_start();

        if (isset($_SESSION['admin_email'])) {
            // Adresse e-mail de l'administrateur connecté
            $emailAdministrateurConnecte = $_SESSION['admin_email'];

            // Adresse e-mail de l'administrateur spécial
            $adminSpecialEmail = "admin@gmail.com";

            // Connectez-vous à la base de données (remplacez ces valeurs par les vôtres)
            require_once("../../config/config.php");

            if ($connexion->connect_error) {
                die("Échec de la connexion à la base de données : " . $connexion->connect_error);
            }

            ?>

            <!-- Créez une section pour les administrateurs -->
            <div class='section-administrateurs'>
            <h2>Administrateurs</h2>

            <?php

            if ($emailAdministrateurConnecte === $adminSpecialEmail) {
                $query = "SELECT * FROM administrateur";
            } else {
                $query = "SELECT * FROM administrateur WHERE mail <> ?";
            }

            $stmt = $connexion->prepare($query);

            if ($stmt) {
                if ($emailAdministrateurConnecte !== $adminSpecialEmail) {
                    $stmt->bind_param("s", $adminSpecialEmail);
                }
                $stmt->execute();
                $result = $stmt->get_result();

                while ($row = $result->fetch_assoc()) {
                    $nom = htmlspecialchars($row['nom']);
                    $id = $row['id'];
                ?>

                    <div class='card' style='width: 18rem;'>
                    <div class='card-body'>
                    <h5 class='card-title'><?= $nom ?></h5>
                    <a href='changer_user.php?id=<?= $id ?>' class='btn btn-primary'>Passer en utilisateur</a>
                    </div></div>
                <?php
                }

                $stmt->close();
            }
            ?>
            </div>

            <!-- Créez une section pour les utilisateurs -->
            <div class='section-utilisateurs'>
            <h2>Utilisateurs</h2>

            <?php

            $query = "SELECT * FROM utilisateur";
            $stmt = $connexion->prepare($query);

            if ($stmt) {
                $stmt->execute();
                $result = $stmt->get_result();

                while ($row = $result->fetch_assoc()) {
                    $pseudo = htmlspecialchars($row['pseudo']);
                    $id = $row['id'];

                    ?>

                    <div class='card' style='width: 18rem;'>
                    <div class='card-body'>
                    <h5 class='card-title'><?= $pseudo ?></h5>
                    <a href='changer_admin.php?id=<?= $id ?>' class='btn btn-primary'>Passer en administrateur</a>
                    </div></div>

                    <?php
                }

                $stmt->close();
            }
            echo "</div>";

            // Fermez la connexion à la base de données
            $connexion->close();
        } else {
            // Redirigez vers la page de connexion si l'administrateur n'est pas connecté
            header("Location: connexion.php");
            exit;
        }
        ?>
    </div>
</div>
</body>
</html>
