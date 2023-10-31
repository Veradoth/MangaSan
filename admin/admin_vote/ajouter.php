<?php
if (isset($_POST['submit'])) {
    extract($_POST);
    require_once("../../config/config.php");

    // Insérez d'abord le vote
    $save_vote = $connexion->prepare('INSERT INTO vote(nom, duree) VALUES(?,?)');
    $save_vote->execute(array($nom, $duree));
    $voteId = $connexion->insert_id; // Récupérer l'ID du vote inséré

    // Récupérer les mangas sélectionnés depuis le tableau "mangas"
    if (isset($mangas) && is_array($mangas)) {
        // Itérer sur les mangas sélectionnés et les associer au vote dans la table de liaison "vote_manga"
        foreach ($mangas as $manga_id) {
            $insert_vote_manga = $connexion->prepare('INSERT INTO vote_manga(id_vote, id_manga) VALUES(?, ?)');
            $insert_vote_manga->execute(array($voteId, $manga_id));
        }
    }

    header("Location: admin_vote.php?success=4");
}
?>
