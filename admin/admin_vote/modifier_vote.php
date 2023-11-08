<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un vote</title>
    <link rel="stylesheet" type="text/css" href="afficher_vote.css">
</head>
<body>
    <?php
    if (isset($_POST['nomVote'])) {
        include "../../config/config.php";
        $voteName = $_POST['nomVote'];

        // Modifier la requête SQL pour obtenir l'ID du vote en fonction de son nom
        $sql = 'SELECT * FROM vote WHERE nom = ?';
        $stmt = $connexion->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("s", $voteName);
            $stmt->execute();
            $result = $stmt->get_result();
            $vote = $result->fetch_assoc();
            $stmt->close();

            if ($vote) {
                // Récupérer l'ID du vote
                $voteId = $vote['id'];

                // Obtenir la liste des mangas liés à ce vote
                $sqlMangas = 'SELECT id_manga FROM vote WHERE id = ?';
                $stmtMangas = $connexion->prepare($sqlMangas);
                $stmtMangas->bind_param("i", $voteId);
                $stmtMangas->execute();
                $resultMangas = $stmtMangas->get_result();
                $selectedMangas = array();

                while ($rowManga = $resultMangas->fetch_assoc()) {
                    $mangaIds = explode(',', $rowManga['id_manga']);
                    $selectedMangas = array_merge($selectedMangas, $mangaIds);
                }
                $stmtMangas->close();
                ?>

                <div class="form-container">
                    <h3>Modifier le vote</h3>
                    <form action='modifier.php' method='POST'>
                        <label for="newNom">Nouveau nom du vote:</label>
                        <input type="text" name="newNom" value="<?= $vote['nom'] ?>" class="form form-control" autocomplete="off">
                        
                        <label for="mangas">Sélectionnez les mangas :</label>
                        <select name="mangas[]" multiple>
                        <?php
                            $sql = "SELECT id, nom FROM manga";
                            $listeManga = $connexion->query($sql);

                            while ($manga = $listeManga->fetch_assoc()) {
                                $isSelected = in_array($manga['id'], $selectedMangas) ? 'selected' : '';
                                $highlightClass = $isSelected ? 'selected-manga' : '';
                                echo '<option value="' . $manga['id'] . '" ' . $isSelected . ' class="' . $highlightClass . '">' . $manga['nom'] . '</option>';
                            }
                        ?>

                        </select>
                        <label for="newDuree">Nouvelle durée:</label>
                        <input type="datetime-local" name="newDuree" value="<?= $vote['duree'] ?>" class="form form-control" autocomplete="off">
                        
                        <input type='hidden' name='nomVote' value='<?= $voteName ?>'>
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
