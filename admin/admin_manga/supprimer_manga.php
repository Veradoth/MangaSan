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

        if ($manga) {
            // Formate la date de sortie en JJ--MM--AAAA
            $dateSortie = date('d-m-Y', strtotime($manga['date_sortie']));

            ?>
            <div class='form-container'>
                <h3>Informations du manga</h3>
                <form action='supprimer.php' method='POST'>
                    <p>Nom du manga :  <?= $manga['nom'] ?></p>
                    <p>Nom de l'auteur : <?= $manga['auteur'] ?></p>
                    <p>Date de sortie : <?= $dateSortie ?></p>
                    <p>Description : <?= $manga['descrip'] ?></p>
                    <img src="../../catalogue/images/<?= $manga['nom_image'] ?>" alt="Image du manga" width="200">
                    <input type='hidden' name='numManga' value=<?= $mangaId ?>>
                    <br>
                    <input type='submit' value='Supprimer ce manga'>
                </form>
                <button onclick="window.location.href= 'admin_manga.php';" name="return">Retour</button>
            </div>
        <?php
        } else {
            echo "Manga non trouvé.";
        }
    }
    $connexion->close();
} else {
    echo "Veuillez sélectionner un manga à afficher.";
}
?>
</body>
</html>
