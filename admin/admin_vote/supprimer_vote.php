<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Informations du vote</title>
    <link rel="stylesheet" type="text/css" href="afficher_vote.css">
</head>
<body>
    <?php
    if (isset($_POST['numVote'])) {
        include "../../config/config.php";
        $voteId = $_POST['numVote'];

        $sql = 'SELECT * FROM vote WHERE id = ?';
        $stmt = $connexion->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("i", $voteId);
            $stmt->execute();
            $result = $stmt->get_result();
            $vote = $result->fetch_assoc();
            $stmt->close();

            if ($vote) {
                // Récupérer tous les noms des mangas associés à ce vote
                $sqlMangas = 'SELECT manga.nom FROM manga
                INNER JOIN vote ON manga.id = vote.id_manga
                WHERE vote.id = ?';

                $stmtMangas = $connexion->prepare($sqlMangas);
                if ($stmtMangas) {
                    $stmtMangas->bind_param("i", $voteId);
                    $stmtMangas->execute();
                    $resultMangas = $stmtMangas->get_result();

    ?>
                    <div class='form-container'>
                    <h3>Informations du vote</h3>
                    <p>Nom du vote : <?= $vote['nom'] ?></p>
                    <p>Durée : <?= $vote['duree'] ?></p>
                    <p>Noms des mangas associés :</p>
                    <ul>
                    <?php
                    while ($manga = $resultMangas->fetch_assoc()) {
                        echo "<li>" . $manga['nom'] . "</li>";
                    }
                    ?>
                    </ul>
                    <form action='supprimer.php' method='POST'>
                        <input type='hidden' name='numVote' value=<?= $voteId ?>>
                        <input type='submit' value='Supprimer ce vote'>
                    </form>
                    <button onclick="window.location.href='admin_vote.php'" name="return">Retour</button>
                    </div>
                <?php
                    $stmtMangas->close();
                }
            } else {
                echo "Vote non trouvé.";
            }
        }
        $connexion->close();
    } else {
        echo "Veuillez sélectionner un vote à afficher.";
    }
    ?>
</body>
</html>
