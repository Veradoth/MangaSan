<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Réception des données</title>
</head>
<body>
    <h1>Données de contact</h1>

    <?php
    // Connexion à la base de données
    require_once "../config/config.php"; // Fichier de configuration de la base de données

    // Vérification de la connexion
    if ($connexion === false) {
        die("Erreur de connexion : " . mysqli_connect_error());
    }

    // Requête pour récupérer les données de la table 'contact'
    $sql = "SELECT id, objet, description FROM contact";

    // Exécution de la requête
    $resultat = mysqli_query($connexion, $sql);

    // Vérification et affichage des données
    if (mysqli_num_rows($resultat) > 0) {
        // Affichage des données dans un tableau
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Objet</th><th>Description</th></tr>";

        while ($row = mysqli_fetch_assoc($resultat)) {
            echo "<tr>";
            echo "<td>" . $row["id"] . "</td>";
            echo "<td>" . $row["objet"] . "</td>";
            echo "<td>" . $row["description"] . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "Aucune donnée trouvée dans la table 'contact'.";
    }

    // Fermeture de la connexion
    mysqli_close($connexion);
    ?>
</body>
</html>
