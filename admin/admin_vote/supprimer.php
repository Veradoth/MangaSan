<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Supprimer un vote</title>
</head>
<body>
    <h1>Supprimer un vote</h1>
    <p><a href="admin_vote.php">Retour</a></p>
    <?php
if (isset($_POST['numVote'])) {
    include "../../config/config.php";
    $voteId = $_POST['numVote'];

    // Supprimez d'abord les associations de mangas dans la table de liaison "vote_manga"
    $sqlDeleteMangas = 'DELETE FROM vote_manga WHERE id_vote = ?';
    $stmtDeleteMangas = $connexion->prepare($sqlDeleteMangas);

    if ($stmtDeleteMangas) {
        $stmtDeleteMangas->bind_param("i", $voteId);
        $stmtDeleteMangas->execute();
        $stmtDeleteMangas->close();
    } else {
        echo "Erreur lors de la suppression des mangas associés : " . $connexion->error;
    }

    // Supprimez ensuite le vote de la table "vote"
    $sqlDeleteVote = 'DELETE FROM vote WHERE id = ?';
    $stmtDeleteVote = $connexion->prepare($sqlDeleteVote);

    if ($stmtDeleteVote) {
        $stmtDeleteVote->bind_param("i", $voteId);
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
    echo "Veuillez sélectionner un vote à supprimer.";
}
?>

</body>
</html>
