<?php
    require_once("../style.php");
?>

<!doctype html>
<html lang="fr">
    <head>
    <meta charset="UTF-8">
    <title>Supprimer un vote</title>
    </head>
    <body>
        <h1>Supprimer un vote</h1>
        <p><a href ="admin_vote.php">Retour</a></p>
        <?php

        if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["numVote"])){
            include "../config/config.php";
        
            $num = $_POST['numVote'];
            $sql = "DELETE FROM vote WHERE id = $num;";
            $connexion->query($sql); 
            if(!$connexion->errno){
                header("Location:admin_vote.php");
            }
            mysqli_close($connexion) ;
        }
        ?>
        
    </body>
</html>
