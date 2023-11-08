<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Supprimer un vote</title>
</head>
<body>
    <h1>Supprimer un vote</h1>
    <p><a href="admin_vote.php">Retour</a></p>
    <?php
    if (isset($_POST['nomVote'])) {
        include "../../config/config.php";
        $voteName = $_POST['nomVote'];

        // Récupérez les informations du vote
        $sqlVote = 'SELECT * FROM vote WHERE nom = ?'; // Utilisez le nom du vote pour la sélection
        $stmtVote = $connexion->prepare($sqlVote);

        if ($stmtVote) {
            $stmtVote->bind_param("s", $voteName);
            $stmtVote->execute();
            $resultVote = $stmtVote->get_result();
            $vote = $resultVote->fetch_assoc();
            $stmtVote->close();

            if ($vote) {
                // Récupérez les mangas associés à ce vote
                $sqlMangas = 'SELECT manga.nom FROM manga
                INNER JOIN vote ON manga.id = vote.id_manga
                WHERE vote.nom = ?';
                $stmtMangas = $connexion->prepare($sqlMangas);

                if ($stmtMangas) {
                    $stmtMangas->bind_param("s", $voteName);
                    $stmtMangas->execute();
                    $resultMangas = $stmtMangas->get_result();

                    echo "<p>Informations du vote à supprimer :</p>";
                    echo "<p>Nom du vote : " . $vote['nom'] . "</p>";
                    echo "<p>Durée : " . $vote['duree'] . "</p>";
                    echo "<p>Mangas associés :</p>";
                    echo "<ul>";

                    while ($manga = $resultMangas->fetch_assoc()) {
                        echo "<li>" . $manga['nom'] . "</li>";
                    }

                    echo "</ul>";
                    $stmtMangas->close();

                    // Supprimez d'abord les associations de mangas dans la table "vote"
                    $sqlDeleteMangas = 'UPDATE vote SET id_manga = NULL WHERE nom = ?'; // Utilisez le nom du vote pour la suppression
                    $stmtDeleteMangas = $connexion->prepare($sqlDeleteMangas);

                    if ($stmtDeleteMangas) {
                        $stmtDeleteMangas->bind_param("s", $voteName);
                        $stmtDeleteMangas->execute();
                        $stmtDeleteMangas->close();
                    } else {
                        echo "Erreur lors de la suppression des mangas associés au vote : " . $connexion->error;
                    }

                    // Supprimez ensuite le vote de la table "vote"
                    $sqlDeleteVote = 'DELETE FROM vote WHERE nom = ?'; // Utilisez le nom du vote pour la suppression
                    $stmtDeleteVote = $connexion->prepare($sqlDeleteVote);

                    if ($stmtDeleteVote) {
                        $stmtDeleteVote->bind_param("s", $voteName);
                        $stmtDeleteVote->execute();

                        if (!$stmtDeleteVote->errno) {
                            header("Location: admin_vote.php?success=6");
                        } else {
                            echo "Erreur lors de la suppression du vote : " . $connexion->error;
                        }

                        $stmtDeleteVote->close();
                    } else {
                        echo "Erreur lors de la suppression du vote : " . $connexion->error;
                    }

                    mysqli_close($connexion);
                } else {
                    echo "Erreur lors de la préparation de la requête pour les mangas associés : " . $connexion->error;
                }
            } else {
                echo "Vote non trouvé.";
            }
        } else {
            echo "Erreur lors de la préparation de la requête pour le vote : " . $connexion->error;
        }
    } else {
        echo "Veuillez sélectionner un vote à supprimer.";
    }
    ?>
</body>
</html>
