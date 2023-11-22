<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
            </div>
        </nav>
    </header>

    <a href="../admin/admin_vote/ajouter_vote.php" class="btn btn-primary">Ajouter un vote</a>


    <div class="container mt-4">
        <h1>Liste des votes</h1>

        <div class="row mt-4">
            <!-- Votes ouverts -->
            <div class="col-md-6">
                <h2>Votes ouverts</h2>
                <div class="voiture">
                    <?php
                    require_once("../config/config.php");

                    // Définissez le fuseau horaire pour Paita, Nouvelle-Calédonie
                    date_default_timezone_set('Pacific/Noumea');

                    // Récupérez la date actuelle
                    $dateActuelle = date('Y-m-d H:i:s');

                    // Sélectionnez tous les noms de votes uniques
                    $sqlNomsUniques = 'SELECT DISTINCT nom FROM vote';
                    $stmtNomsUniques = $connexion->query($sqlNomsUniques);

                    while ($rowNomUnique = $stmtNomsUniques->fetch_assoc()) {
                        // Échappez le nom du vote
                        $nomUnique = htmlspecialchars($rowNomUnique['nom']);

                        // Sélectionnez un exemple de ce vote (peu importe lequel) parmi ceux ayant le même nom
                        $sqlExempleVote = 'SELECT * FROM vote WHERE nom = ? LIMIT 1';
                        $stmtExempleVote = $connexion->prepare($sqlExempleVote);
                        $stmtExempleVote->bind_param("s", $nomUnique);
                        $stmtExempleVote->execute();
                        $resultExempleVote = $stmtExempleVote->get_result();
                        $rowExempleVote = $resultExempleVote->fetch_assoc();

                        // Vérifiez si le vote est ouvert
                        if ($rowExempleVote && $rowExempleVote['duree'] > $dateActuelle) {
                            // Vote ouvert
                            $dateLimite = htmlspecialchars($rowExempleVote['duree']);
                            $nomVote = $rowExempleVote['nom'];
                            ?>

                            <!-- Affichez le vote ouvert -->
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title"><?= $nomUnique ?></h5>
                                    <p class="card-text">Date limite : <?= $dateLimite ?></p>
                                    <a href="selection.php?nom=<?= urlencode($nomVote) ?>" class="btn btn-primary">Participer au vote</a>
                                </div>
                            </div>

                            <?php
                        }
                    }
                    ?>
                </div>
            </div>

            <!-- Votes fermés -->
            <div class="col-md-6">
                <h2>Votes fermés</h2>
                <div class="voiture">
                    <?php
                    // Utilisez la même logique que pour les votes ouverts en changeant la condition
                    $stmtNomsUniques = $connexion->query($sqlNomsUniques);

                    while ($rowNomUnique = $stmtNomsUniques->fetch_assoc()) {
                        $nomUnique = htmlspecialchars($rowNomUnique['nom']);
                        $sqlExempleVote = 'SELECT * FROM vote WHERE nom = ? LIMIT 1';
                        $stmtExempleVote = $connexion->prepare($sqlExempleVote);
                        $stmtExempleVote->bind_param("s", $nomUnique);
                        $stmtExempleVote->execute();
                        $resultExempleVote = $stmtExempleVote->get_result();
                        $rowExempleVote = $resultExempleVote->fetch_assoc();

                        // Vérifiez si le vote est fermé
                        if ($rowExempleVote && $rowExempleVote['duree'] < $dateActuelle) {
                            // Vote fermé
                            $duree = htmlspecialchars($rowExempleVote['duree']);
                            $id = $rowExempleVote['id'];
                            ?>

                            <!-- Affichez le vote fermé -->
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title"><?= $nomUnique ?></h5>
                                    <p class="card-text">Date limite : <?= $duree ?></p>
                                    <a href="classement.php?id=<?= $id ?>" class="btn btn-primary">Voir le classement</a>
                                </div>
                            </div>

                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts Bootstrap et autres scripts JS ici -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ZfM+yfUpX5IbDDQO67aAZuzofo2akTV0ffEClBtxzh6fl4z5uZZ1aHc5gW1fKj0" crossorigin="anonymous"></script>
</body>
</html>
