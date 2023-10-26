<?php
    if(isset($_POST['submit'])){ // Vérifie si le formulaire a été soumis (le bouton submit a été cliqué)
                extract($_POST); // Extrait les données du formulaire dans des variables distinctes
                require_once("../../config/config.php");

                $save_manga = $connexion->prepare('INSERT INTO vote(nom, duree) VALUES(?,?)'); // Prépare une requête SQL d'insertion dans la table 'voiture'
                $save_manga->execute(array($nom, $duree)); // Exécute la requête d'insertion avec les valeurs fournies
                header("Location:admin_vote.php?success=4");
            }
?>