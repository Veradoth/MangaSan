<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Supprimer un vote</title>
    <link rel="stylesheet" type="text/css" href="afficher_vote.css">
</head>
<body>
<?php
if (isset($_POST['nomVote'])) {
    include "../../config/config.php";
    $voteName = $_POST['nomVote'];

    // Sélectionnez tous les votes ayant le même nom
    $sql = 'SELECT * FROM vote WHERE nom = ?';
    $stmt = $connexion->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("s", $voteName);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Affichez une seule fiche d'informations pour le vote
            $vote = $result->fetch_assoc();

            ?>
            <div class='form-container'>
                <h3>Informations du vote</h3>
                <p>Nom du vote : <?= $vote['nom'] ?></p>
                <p>Durée : <?= $vote['duree'] ?></p>
                <p>Noms des mangas associés :</p>
                <ul>
                <?php
                // Récupérez les mangas associés à ce vote en utilisant une requête SQL
                $sqlMangas = 'SELECT manga.nom FROM manga
                INNER JOIN vote ON manga.id = vote.id_manga
                WHERE vote.nom = ?';
                $stmtMangas = $connexion->prepare($sqlMangas);

                if ($stmtMangas) {
                    $stmtMangas->bind_param("s", $voteName);
                    $stmtMangas->execute();
                    $resultMangas = $stmtMangas->get_result();

                    while ($manga = $resultMangas->fetch_assoc()) {
                        echo "<li>" . $manga['nom'] . "</li>";
                    }
                    $stmtMangas->close();
                } else {
                    echo "Erreur de préparation de la requête SQL pour les mangas : " . $connexion->error;
                }
                ?>
                </ul>
                <form action='supprimer.php' method='POST'>
                    <input type='hidden' name='nomVote' value="<?= $voteName ?>">
                    <input type='submit' value='Supprimer ce vote'>
                </form>
                <button onclick="window.location.href='admin_vote.php'" name="return">Retour</button>
            </div>
            <?php
        } else {
            echo "Aucun vote trouvé avec le nom : " . $voteName;
        }
        $stmt->close();
    } else {
        echo "Erreur de préparation de la requête SQL pour les votes : " . $connexion->error;
    }

    $connexion->close();
} else {
    echo "Veuillez sélectionner un vote à afficher.";
}
?>

</body>
</html>
