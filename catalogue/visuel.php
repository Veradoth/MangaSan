<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="visuel.css">
    <title>Catalogue</title>
</head>
<body>
    <!-- En-tête de la page -->
    <header class="header">
        <nav class="navbar navbar-expand-lg navbar-light bg-primary">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <a class="navbar-brand" href="../accueil.php">Accueil</a>
                </form>
            </div>
            </div>
        </nav>
    </header>

    <div class="center">
        <h1>Liste des mangas</h1><br><br>
        <div class="voiture">

            <?php
            require_once("../config/pdo.php");

            $sql = 'SELECT * FROM manga';
            $stmt = $connexion->prepare($sql);
            $stmt->execute();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // Échapper les données pour éviter les attaques XSS
                $nom = htmlspecialchars($row['nom']);
                $auteur = htmlspecialchars($row['auteur']);
                $date_sortie = htmlspecialchars($row['date_sortie']);
                $descrip = htmlspecialchars($row['descrip']);
                $nom_image = htmlspecialchars($row['nom_image']);
                $id = $row['id']; // Utilisez l'ID pour créer un lien sécurisé

                // Utilisez l'ID dans l'URL pour afficher les détails du manga en toute sécurité
                echo '<div class="card" style="width: 18rem;">';
                echo '<img src="images/' . $nom_image . '" class="card-img-top" alt="...">';
                echo '<div class="card-body">';
                echo '<h5 class="card-title">' . $nom . '</h5>';
                echo '<a href="info.php?id=' . $id . '" class="btn btn-primary">Voir informations</a>';
                echo '</div>';
                echo '</div>';
            }
            ?>
        </div>
    </div>
</body>
</html>
