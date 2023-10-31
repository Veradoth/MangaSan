<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un vote</title>
</head>
<body>
    <h1>Modifier un vote</h1>
    <p><a href='admin_vote.php'>Retour</a></p>
    <?php
    if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["numVote"])) {
        include "../../config/config.php";

        $num = $_POST['numVote'];

        $sql = "SELECT * FROM vote WHERE id = ?";
        $stmt = $connexion->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("i", $num);
            $stmt->execute();
            $result = $stmt->get_result();
            $voteActuel = $result->fetch_assoc();
            $stmt->close();

            if ($voteActuel) {
                $nom = $_POST['newNom'] !== '' ? $_POST['newNom'] : $voteActuel['nom'];
                $duree = $_POST['newDuree'] !== '' ? $_POST['newDuree'] : $voteActuel['duree'];

                // Récupérer la liste des mangas associés au vote
                $sqlMangasActuels = "SELECT id_manga FROM vote_manga WHERE id_vote = ?";
                $stmtMangasActuels = $connexion->prepare($sqlMangasActuels);

                if ($stmtMangasActuels) {
                    $stmtMangasActuels->bind_param("i", $num);
                    $stmtMangasActuels->execute();
                    $resultMangasActuels = $stmtMangasActuels->get_result();
                    $stmtMangasActuels->close();

                    // Récupérer les mangas sélectionnés dans le formulaire
                    $mangasSelectionnes = isset($_POST['mangas']) ? $_POST['mangas'] : [];

                    // Supprimer les anciennes associations entre le vote et les mangas
                    $sqlSupprimerMangas = "DELETE FROM vote_manga WHERE id_vote = ?";
                    $stmtSupprimerMangas = $connexion->prepare($sqlSupprimerMangas);

                    if ($stmtSupprimerMangas) {
                        $stmtSupprimerMangas->bind_param("i", $num);
                        $stmtSupprimerMangas->execute();
                        $stmtSupprimerMangas->close();

                        // Réinsérer les associations avec les mangas sélectionnés
                        foreach ($mangasSelectionnes as $mangaId) {
                            $sqlInsererManga = "INSERT INTO vote_manga (id_vote, id_manga) VALUES (?, ?)";
                            $stmtInsererManga = $connexion->prepare($sqlInsererManga);

                            if ($stmtInsererManga) {
                                $stmtInsererManga->bind_param("ii", $num, $mangaId);
                                $stmtInsererManga->execute();
                                $stmtInsererManga->close();
                            }
                        }

                        // Mettre à jour le nom et la durée du vote
                        $sqlMettreAJourVote = "UPDATE vote SET nom = ?, duree = ? WHERE id = ?";
                        $stmtMettreAJourVote = $connexion->prepare($sqlMettreAJourVote);

                        if ($stmtMettreAJourVote) {
                            $stmtMettreAJourVote->bind_param("ssi", $nom, $duree, $num);
                            $stmtMettreAJourVote->execute();
                            $stmtMettreAJourVote->close();

                            header("Location: admin_vote.php?success=5");
                        } else {
                            echo 'Erreur lors de la mise à jour du vote.';
                        }
                    }
                }
            }
        }
        mysqli_close($connexion);
    }
    ?>
</body>
</html>
