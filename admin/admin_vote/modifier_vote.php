<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un vote</title>
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
                    <h3>Modifier le vote</h3>
                    <form action='modifier.php' method='POST'>
                        <label for="newNom">Nouveau nom du vote:</label>
                        <input type="text" name="newNom" placeholder="<?= $vote['nom'] ?>" class="form form-control" autocomplete="off">

                        <?php
                            function isMangaSelected($mangaId, $voteId, $connexion) {
                            $sql = 'SELECT id_vote FROM vote_manga WHERE id_manga = ? AND id_vote = ?';
                            $stmt = $connexion->prepare($sql);

                            if ($stmt) {
                                $stmt->bind_param("ii", $mangaId, $voteId);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                $stmt->close();
                                return $result->num_rows > 0;
                            }
                            return false;
                            }
                        ?>
                        <label for="mangas">Sélectionnez les mangas :</label>
                        <select name="mangas[]" multiple>
                        <?php
                            $sql = "SELECT id, nom FROM manga";
                            $listeManga = $connexion->query($sql);
                            while ($manga = $listeManga->fetch_assoc()) {
                                $isSelected = isMangaSelected($manga['id'], $voteId, $connexion) ? 'selected' : '';
                                echo '<option value="' . $manga['id'] . '" ' . $isSelected . '>' . $manga['nom'] . '</option>';
                            }
                        ?>
                        </select>
                        <label for="newDuree">Nouvelle durée:</label>
                        <input type="datetime-local" name="newDuree" value="<?= date('Y-m-d\TH:i', strtotime($vote['duree'])) ?>" class="form form-control" autocomplete="off" required>
                        
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
        echo "Veuillez sélectionner un vote à modifier.";
    }
    ?>
</body>
</html>
