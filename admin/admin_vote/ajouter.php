<?php
if (isset($_POST['submit'])) {
    extract($_POST);
    require_once("../../config/config.php");

    // Vérifiez d'abord si le nom du vote existe déjà
    $check_vote = $connexion->prepare('SELECT COUNT(*) FROM vote WHERE nom = ?');
    $check_vote->bind_param("s", $nom);
    $check_vote->execute();
    $check_vote->bind_result($vote_count);
    $check_vote->fetch();
    $check_vote->close();

    if ($vote_count > 0) {
        // Le nom du vote existe déjà, affichez un message d'erreur ou redirigez vers une page d'erreur
        header("Location: admin_vote.php?error=1");
    } else {
        // Le nom du vote n'existe pas encore, vous pouvez insérer le vote
        $save_vote = $connexion->prepare('INSERT INTO vote(nom, id_manga, duree) VALUES(?,?,?)');

        if ($save_vote) {
            foreach ($mangas as $manga_id) {
                // Exécutez la requête pour chaque manga sélectionné
                $save_vote->bind_param("sds", $nom, $manga_id, $duree);
                $save_vote->execute();
            }

            // Redirigez après avoir ajouté le vote
            header("Location: admin_vote.php?success=4");
        } else {
            // Gérez l'erreur de préparation de la requête ici si nécessaire
            echo "Erreur de préparation de la requête.";
        }
    }
}



?>
