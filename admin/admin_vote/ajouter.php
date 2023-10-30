<?php
if (isset($_POST['submit'])) {
    extract($_POST);
    require_once("../../config/config.php");

    $mangas_ids_array = json_decode($mangas_ids);

    // Itérer sur le tableau des ID des mangas et insérer chaque ID individuellement
    foreach ($mangas_ids_array as $manga_id) {
        $save_vote = $connexion->prepare('INSERT INTO vote(nom, id_manga, duree) VALUES(?,?,?)');
        $save_vote->execute(array($nom, $manga_id, $duree));
    }

    header("Location:admin_vote.php?success=4");
}

?>
