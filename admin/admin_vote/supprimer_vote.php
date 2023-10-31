<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Supprimer un vote</title>
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
            // Récupérer le nom du vote
            ?>
            <div class='form-container'>
                <h3>Informations du vote</h3>
                <p>Nom du vote : <?= $vote['nom'] ?></p>
                <p>Durée : <?= $vote['duree'] ?></p>
                <p>Noms des mangas associés :</p>
                <ul>
                <?php
                // Récupérer les mangas associés à ce vote en utilisant la jointure SQL
                $sqlMangas = 'SELECT manga.id, manga.nom FROM manga
                INNER JOIN vote_manga ON manga.id = vote_manga.id_manga
                WHERE vote_manga.id_vote = ?';
                $stmtMangas = $connexion->prepare($sqlMangas);

                if ($stmtMangas) {
                    $stmtMangas->bind_param("i", $voteId);
                    $stmtMangas->execute();
                    $resultMangas = $stmtMangas->get_result();

                    while ($manga = $resultMangas->fetch_assoc()) {
                        echo $manga['nom']."<br>";
                    }
                    $stmtMangas->close();
                } else {
                    echo "Erreur de préparation de la requête SQL pour les mangas : " . $connexion->error;
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
        } else {
            echo "Vote non trouvé.";
        }
    } else {
        echo "Erreur de préparation de la requête SQL pour le vote : " . $connexion->error;
    }
    $connexion->close();
} else {
    echo "Veuillez sélectionner un vote à afficher.";
}
?>

</body>
</html>
