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
                ?>

                <div class="form-container">
                    <h3>Informations du vote</h3>
                    <form action='modifier.php' method='POST'>
                        <input type="text" name="newNom" placeholder="<?= $vote['nom'] ?>" class="form form-control" autocomplete="off">
                        <input type="datetime-local" name="newDuree" value="<?= $vote['duree'] ?>" class="form form-control" autocomplete="off">
                        <input type='hidden' name='numVote' value='<?= $voteId ?>'>
                        <input type='submit' value='Modifier ce vote'>
                    </form>
                    <button onclick="window.location.href='admin_vote.php'" name="return">Retour</button>
                </div>
            <?php
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
