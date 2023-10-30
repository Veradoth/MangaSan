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

// Récupérez la date actuelle
$dateActuelle = date('Y-m-d H:i:s');

// Sélectionnez tous les noms de votes uniques
$sqlNomsUniques = 'SELECT DISTINCT nom FROM vote';
$stmtNomsUniques = $connexion->prepare($sqlNomsUniques);
$stmtNomsUniques->execute();

while ($rowNomUnique = $stmtNomsUniques->fetch(PDO::FETCH_ASSOC)) {
    // Échappez le nom du vote
    $nomUnique = htmlspecialchars($rowNomUnique['nom']);

    // Sélectionnez un exemple de ce vote (peu importe lequel) parmi ceux ayant le même nom
    $sqlExempleVote = 'SELECT * FROM vote WHERE nom = ? LIMIT 1';
    $stmtExempleVote = $connexion->prepare($sqlExempleVote);
    $stmtExempleVote->execute([$nomUnique]);
    $rowExempleVote = $stmtExempleVote->fetch(PDO::FETCH_ASSOC);

    // Vérifiez si le vote est ouvert
    if ($rowExempleVote && $rowExempleVote['duree'] > $dateActuelle) {
        // Vote ouvert
        $duree = htmlspecialchars($rowExempleVote['duree']);
        $id = $rowExempleVote['id']; // Utilisez l'ID pour créer un lien sécurisé

        // Affichez le vote ouvert
        echo '<div class="card" style="width: 18rem;">';
        echo '<div class="card-body">';
        echo '<h5 class="card-title">' . $nomUnique . '</h5>';
        echo '<p class="card-text">Date limite : ' . $duree . '</p>';
        echo '<a href="info.php?id=' . $id . '" class="btn btn-primary">Voir informations</a>';
        echo '</div>';
        echo '</div>';
    }
}
?>

        </div>

        <h1>Liste des votes fermés</h1>
        <div class="voiture">
            <?php
            require_once("../config/pdo.php");
            
            // Récupérez la date actuelle
            $dateActuelle = date('Y-m-d H:i:s');
            
            // Sélectionnez tous les noms de votes uniques
            $sqlNomsUniques = 'SELECT DISTINCT nom FROM vote';
            $stmtNomsUniques = $connexion->prepare($sqlNomsUniques);
            $stmtNomsUniques->execute();
            
            while ($rowNomUnique = $stmtNomsUniques->fetch(PDO::FETCH_ASSOC)) {
                // Échappez le nom du vote
                $nomUnique = htmlspecialchars($rowNomUnique['nom']);
            
                // Sélectionnez un exemple de ce vote (peu importe lequel) parmi ceux ayant le même nom
                $sqlExempleVote = 'SELECT * FROM vote WHERE nom = ? LIMIT 1';
                $stmtExempleVote = $connexion->prepare($sqlExempleVote);
                $stmtExempleVote->execute([$nomUnique]);
                $rowExempleVote = $stmtExempleVote->fetch(PDO::FETCH_ASSOC);
            
                // Vérifiez si le vote est ouvert
                if ($rowExempleVote && $rowExempleVote['duree'] < $dateActuelle) {
                    // Vote ouvert
                    $duree = htmlspecialchars($rowExempleVote['duree']);
                    $id = $rowExempleVote['id']; // Utilisez l'ID pour créer un lien sécurisé
            
                    // Affichez le vote ouvert
                    echo '<div class="card" style="width: 18rem;">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">' . $nomUnique . '</h5>';
                    echo '<p class="card-text">Date limite : ' . $duree . '</p>';
                    echo '<a href="info.php?id=' . $id . '" class="btn btn-primary">Voir informations</a>';
                    echo '</div>';
                    echo '</div>';
                }
            }
            ?>
        </div>
    </div>
</body>
</html>
