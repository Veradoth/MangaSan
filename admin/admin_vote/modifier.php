
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
                    $nombre = $_POST['newNombre'] !== '' ? $_POST['newNombre'] : $voteActuel['nombre'];
                    $duree = $_POST['newDuree'] !== '' ? $_POST['newDuree'] : $voteActuel['duree'];

                    
                        $sql = "UPDATE vote SET nom = ?, participant = ?, duree = ? WHERE id = ?";
                        $stmt = $connexion->prepare($sql); 
                        if ($stmt) {
                            $stmt->bind_param("sssi", $nom, $nombre, $duree, $num);
                            if ($stmt->execute()) {
                                echo 'Le vote a été modifié avec succès.<br>';
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
