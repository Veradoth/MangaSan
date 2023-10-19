<?php
    require_once("style.php");
?>

<!doctype html>
<html lang="fr">
    <head>
    <meta charset="UTF-8">
    <title>Supprimer un manga</title>
    </head>
    <body>
        <h1>Supprimer un manga</h1>
        <p><a href ="admin.php">Retour</a></p>
        <?php

        if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["numManga"])){
            include "../config/config.php";
        
            $num = $_POST['numManga'];

            $sql = "SELECT nom_image FROM manga WHERE id = $num;";
            $result = $connexion->query($sql);

            if ($result->num_rows > 0){
                $row = $result->fetch_assoc();
                $nomFichier = $row['nom_image'];

                $content_dir = '../catalogue/images/';
                $cheminFichier = $content_dir . $nomFichier;

                if (unlink($cheminFichier)){
                    $sql = "DELETE FROM manga WHERE id = $num;";
                    $connexion->query($sql); 
                    if(!$connexion->errno){
                        header("Location:admin.php");
                    }
                }
            }
            mysqli_close($connexion) ;
        }
        ?>
        
    </body>
</html>
