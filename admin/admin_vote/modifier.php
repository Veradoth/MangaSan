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

        if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["numVote"])){
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

                if ($voteActuel){
                    $nom = $_POST['newNom'] !== '' ? $_POST['newNom'] : $voteActuel['nom'];
                    $duree = $_POST['newDuree'] !== '' ? $_POST['newDuree'] : $voteActuel['duree'];

                    
                        $sql = "UPDATE vote SET nom = ?, duree = ? WHERE id = ?";
                        $stmt = $connexion->prepare($sql); 
                        if ($stmt) {
                            $stmt->bind_param("ssi", $nom, $duree, $num);
                            if ($stmt->execute()) {
                                header("Location:admin_vote.php?success=5");
                            } else {
                                echo 'Erreur lors de la mise à jour du vote : ' . $stmt->error . '<br>';
                            }
                            $stmt->close();
                        }
                }
            }
            mysqli_close($connexion);
        }
        ?>
        
    </body>
</html>
