<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <title>Informations</title>
    </head>
    <body>
        <!-- En-tête de la page-->
        <header class="header">
        <nav class="navbar navbar-expand-lg navbar-light bg-primary">
        <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="visuel.php">Retour</a>
        </form>
        </div>
        </div>
        </nav>
        </header>   

        <div class="center">
            <h1>Informations</h1><br><br>
            <div class="voiture">
            <?php
            require_once("../config/pdo.php");

            if (isset($_GET['id'])) {
                $idManga = $_GET['id'];

                $sql = 'SELECT * FROM manga WHERE id = ?';
                $stmt = $connexion->prepare($sql);
                $stmt->execute([$idManga]);

                if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $nom = htmlspecialchars($row['nom']);
                    $auteur = htmlspecialchars($row['auteur']);
                    $date_sortie = htmlspecialchars($row['date_sortie']);
                    $descrip = htmlspecialchars($row['descrip']);
                    $nom_image = htmlspecialchars($row['nom_image']);
                    ?>
                    <div class="card mb-3">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="images/<?= $nom_image?>" class="img-fluid rounded-start" alt="...">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <p class="card-text">Nom : <?=$nom?></p>
                                    <p class="card-text">Auteur : <?=$auteur?></p>
                                    <p class="card-text">Sortie : <?=$date_sortie?></p>
                                    <p class="card-text">Description : <?=$descrip?></p>
                                </div>
                        </div>
                    </div>
            <?php
                } else {
                    echo "Manga non trouvé.";
                }
            } else {
                echo "L'ID du manga n'est pas spécifié dans l'URL.";
            }
            ?>
                </div>
                <h1>Avis</h1>
                <?php
                    require_once("../config/pdo.php");
                    $idManga = $_GET['id'];

                    $req=$connexion->prepare('SELECT editage.*, manga.nom AS manga_nom FROM editage LEFT JOIN manga ON editage.id_manga = manga.id WHERE editage.id_manga = ?');
                    $req->execute([$idManga]);

                    while ($response=$req->fetch(PDO::FETCH_OBJ)){ 
                        $mangaNom = $response->manga_nom;?>
                    <div class="card" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $response->graphisme; ?>
                                               <?php echo $response->theme; ?></h5>
                            <a href="info.php?graphisme=<?php echo $response->nom; ?>
                                          &theme=<?php echo $response->auteur; ?>
                                          &pp=<?php echo $response->date_sortie; ?>
                                          &bon=<?php echo $response->descrip; ?>
                                          &mauvais=<?php echo $response->nom_image; ?>
                                          &appreciation=<?php echo $response->nom_image; ?>
                                          " class="btn btn-primary">Voir informations</a>
                        </div>
                    </div>
                <?php }
                ?>
            </div>
        </div>
    </body>
</html>