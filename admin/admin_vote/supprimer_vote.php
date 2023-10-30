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
                echo "<div class='form-container'>";
                echo "<h3>Informations du vote</h3>";
                echo "<p>Nom du vote : " . $vote['nom'] . "</p>";
                echo "<p>Nombre de participants : " . $vote['participant'] . "</p>";
                echo "<p>Durée : " . $vote['duree'] . "</p>";
                echo "<form action='supprimer.php' method='POST'>";
                echo "<input type='hidden' name='numVote' value='" . $voteId . "'>";
                echo "<input type='submit' value='Supprimer ce vote'>";
                echo "</form>";
                echo "<button onclick=window.location.href='admin_vote.php'>Retour</button>";
                echo "</div>";
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
