<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Informations du manga</title>
    <link rel="stylesheet" type="text/css" href="afficher_manga.css">
</head>
<body>
    <?php
        if (isset($_POST['numManga'])) {
            include "../../config/config.php";
            $mangaId = $_POST['numManga'];

            $sql = 'SELECT * FROM manga WHERE id = ?';
            $stmt = $connexion->prepare($sql);

            if ($stmt) {
                $stmt->bind_param("i", $mangaId);
                $stmt->execute();
                $result = $stmt->get_result();
                $manga = $result->fetch_assoc();
                $stmt->close();

    ?>

                <div class="form-container">
                    <h3>Informations du manga</h3>
                    <form action='modifier.php' method='POST' enctype="multipart/form-data">
                        <input type="text" name="newManga" placeholder="<?= $manga['nom'] ?>" class="form form-control" autocomplete="off">
                        <input type="text" name="newAuteur" placeholder="<?= $manga['auteur'] ?>" class="form form-control" autocomplete="off">
                        <input type="date" name="newSortie" value="<?= $manga['date_sortie'] ?>" class="form form-control" autocomplete="off">
                        <input type="text" name="newDescription" placeholder="<?= $manga['descrip'] ?>" class="form form-control" autocomplete="off">

                         <!-- Afficher l'image du manga -->
                         <img src="../../catalogue/images/<?= $manga['nom_image'] ?>" alt="Image du manga" width="200">

                        <input type="file" name="newImage" class="form form-control">
                        <input type='hidden' name='numManga' value='<?= $mangaId ?>'>
                        <input type='submit' value='Modifier ce manga'>
                    </form>
                    <button onclick="window.location.href='admin_manga.php'" name="return">Retour</button>
                </div>
            <?php
            } else {
                echo "Manga non trouvé.";
            
        }
        $connexion->close();
    } else {
        echo "Veuillez sélectionner un manga à afficher.";
    }
    ?>
</body>
</html>
