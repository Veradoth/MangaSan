<!doctype html>
<html lang="fr">
    <head>
    <meta charset="UTF-8">
    <title>Modifier un manga</title>
    </head>
    <body>
        <h1>Modifier un manga</h1>
        <p><a href='admin_manga.php'>Retour</a></p>
        <?php

        if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["numManga"]) && isset($_FILES['newImage'])){
            include "../../config/config.php";

            $num = $_POST['numManga'];

            $sql = "SELECT * FROM manga WHERE id = ?";
            $stmt = $connexion->prepare($sql);

            if ($stmt) {
                $stmt->bind_param("i", $num);
                $stmt->execute();
                $result = $stmt->get_result();
                $mangaActuel = $result->fetch_assoc();
                $stmt->close();

                if ($mangaActuel){
                    $nom = $_POST['newManga'] !== '' ? $_POST['newManga'] : $mangaActuel['nom'];
                    $auteur = $_POST['newAuteur'] !== '' ? $_POST['newAuteur'] : $mangaActuel['auteur'];
                    $sortie = $_POST['newSortie'] !== '' ? $_POST['newSortie'] : $mangaActuel['date_sortie'];
                    $descrip = $_POST['newDescription'] !== '' ? $_POST['newDescription'] : $mangaActuel['descrip'];

                    $ancienneImage = $mangaActuel['nom_image'];

                    if (isset($_FILES['newImage']) && $_FILES['newImage']['size'] > 0){
                        $content_dir = '../../catalogue/images/';
                        $cheminAncienneImage = $content_dir . $ancienneImage;

                        if (file_exists($cheminAncienneImage)){
                            unlink($cheminAncienneImage);
                        }

                        $content_dir = '../../catalogue/images/';
                        $nomFichierNouvelleImage = time() . '.jpg';
                        $cheminNouvelleImage = $content_dir . $nomFichierNouvelleImage;

                        if(move_uploaded_file($_FILES['newImage']['tmp_name'], $cheminNouvelleImage)){
                            $sql = "UPDATE manga SET nom = ?, auteur = ?, date_sortie = ?, descrip = ?, nom_image = ? WHERE id = ?";
                            $stmt = $connexion->prepare($sql); 
                            if ($stmt) {
                                $stmt->bind_param("sssssi", $nom, $auteur, $sortie, $descrip, $nomFichierNouvelleImage, $num);
                                if ($stmt->execute()) {
                                    header("Location:admin_manga.php?success=2");
                                } else {
                                    echo 'Erreur lors de la mise à jour du manga : ' . $stmt->error . '<br>';
                                }
                                $stmt->close();
                            }
                        }
                    } else {
                        // Si le champ de fichier image est vide, ne mettez pas à jour l'image
                        $sql = "UPDATE manga SET nom = ?, auteur = ?, date_sortie = ?, descrip = ? WHERE id = ?";
                        $stmt = $connexion->prepare($sql); 
                        if ($stmt) {
                            $stmt->bind_param("ssssi", $nom, $auteur, $sortie, $descrip, $num);
                            if ($stmt->execute()) {
                                header("Location:admin_manga.php?success=2");
                            } else {
                                echo 'Erreur lors de la mise à jour du manga : ' . $stmt->error . '<br>';
                            }
                            $stmt->close();
                        }
                    }
                }
            }
            mysqli_close($connexion);
        }
        ?>
    </body>
</html>
