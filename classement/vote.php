<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="visuel.css">
    <title>Vote</title>
</head>
<body>
    <!-- En-tête de la page -->
    <header class="header">
        <nav class="navbar navbar-expand-lg navbar-light bg-primary">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <a class="navbar-brand" href="../index.php">Accueil</a>
                </form>
            </div>
            </div>
        </nav>
    </header>

    <div class="center">
        <h1>Liste des votes ouverts</h1><br><br>
        <div class="voiture">

            <?php
            require_once("../config/pdo.php");

            $sql = 'SELECT * FROM vote';
            $stmt = $connexion->prepare($sql);
            $stmt->execute();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // Échapper les données pour éviter les attaques XSS
                $nom = htmlspecialchars($row['nom']);
                $duree = htmlspecialchars($row['duree']);
                $id = $row['id']; // Utilisez l'ID pour créer un lien sécurisé

            }
            ?>
            <div class="card" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title"><?= $nom ?><?=$duree?></h5>
                    <a href="info.php?id=' . $id . '" class="btn btn-primary">Voir informations</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
