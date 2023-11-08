<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un vote</title>
</head>
<body>
    <h1>Modifier un vote</h1>
    <p><a href='admin_vote.php'>Retour</a></p>
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nomVote'])) {
        include "../../config/config.php";

        $nomVote = $_POST['nomVote'];

        // Récupérer le vote actuel
        $sqlVoteActuel = "SELECT * FROM vote WHERE nom = ?";
        $stmtVoteActuel = $connexion->prepare($sqlVoteActuel);

        if ($stmtVoteActuel) {
            $stmtVoteActuel->bind_param("s", $nomVote);
            $stmtVoteActuel->execute();
            $resultVoteActuel = $stmtVoteActuel->get_result();
            $voteActuel = $resultVoteActuel->fetch_assoc();
            $stmtVoteActuel->close();

            if ($voteActuel) {
                // Récupérer les nouvelles valeurs du formulaire
                $nouveauNom = $_POST['newNom'] ?? $voteActuel['nom'];
                $nouvelleDuree = $_POST['newDuree'] ?? $voteActuel['duree'];

                // Supprimer les anciennes associations entre le vote et les mangas
                $sqlSupprimerMangas = "UPDATE vote SET id_manga = NULL WHERE nom = ?";
                $stmtSupprimerMangas = $connexion->prepare($sqlSupprimerMangas);

                if ($stmtSupprimerMangas) {
                    $stmtSupprimerMangas->bind_param("s", $nomVote);
                    $stmtSupprimerMangas->execute();
                    $stmtSupprimerMangas->close();

                    // Réinsérer les associations avec les mangas sélectionnés
                    $mangasSelectionnes = isset($_POST['mangas']) ? $_POST['mangas'] : [];
                    foreach ($mangasSelectionnes as $mangaId) {
                        $sqlInsererManga = "UPDATE vote SET id_manga = ? WHERE nom = ?";
                        $stmtInsererManga = $connexion->prepare($sqlInsererManga);

                        if ($stmtInsererManga) {
                            $stmtInsererManga->bind_param("ss", $mangaId, $nomVote);
                            $stmtInsererManga->execute();
                            $stmtInsererManga->close();
                        }
                    }

                    // Mettre à jour le nom et la durée du vote
                    $sqlMettreAJourVote = "UPDATE vote SET nom = ?, duree = ? WHERE nom = ?";
                    $stmtMettreAJourVote = $connexion->prepare($sqlMettreAJourVote);

                    if ($stmtMettreAJourVote) {
                        $stmtMettreAJourVote->bind_param("sss", $nouveauNom, $nouvelleDuree, $nomVote);
                        $stmtMettreAJourVote->execute();
                        $stmtMettreAJourVote->close();

                        header("Location: admin_vote.php?success=5");
                    } else {
                        echo 'Erreur lors de la mise à jour du vote.';
                    }
                }
            }
        }

        mysqli_close($connexion);
    }
    ?>
</body>
</html>