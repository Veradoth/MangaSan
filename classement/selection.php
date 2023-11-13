<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Vote pour un manga</title>
    <link rel="stylesheet" href="selection.css">
</head>
<body>
    <!-- Bouton de retour -->
    <button onclick="window.location.href='vote.php'">Retour</button>

    <?php
    if (isset($_GET['nom'])) {
        $nomVote = $_GET['nom'];
        require_once("../config/config.php");

        // Récupérez les mangas associés à ce vote depuis la base de données
        $sql = "SELECT id_manga FROM vote WHERE nom = ?";
        $stmt = $connexion->prepare($sql);
        $stmt->bind_param("s", $nomVote);
        $stmt->execute();
        $result = $stmt->get_result();

        $mangas = array();
        while ($row = $result->fetch_assoc()) {
            $mangas[] = $row['id_manga'];
        }

        // Affichez les groupes de mangas
        for ($i = 0; $i < count($mangas); $i += 2) {
            echo "<div class='manga-group'>";
            for ($j = $i; $j < min($i + 2, count($mangas)); $j++) {
                $mangaId = $mangas[$j];

                // Récupérez le nom du manga
                $sqlManga = "SELECT nom FROM manga WHERE id = ?";
                $stmtManga = $connexion->prepare($sqlManga);
                $stmtManga->bind_param("i", $mangaId);
                $stmtManga->execute();
                $resultManga = $stmtManga->get_result();
                $rowManga = $resultManga->fetch_assoc();
                $mangaNom = htmlspecialchars($rowManga['nom']);

                // Affichez le manga
                echo "<div class='manga-item'>";
                echo "<label>$mangaNom</label>";
                echo "<input type='radio' name='manga' value='$mangaId'>";
                echo "</div>";
            }
            echo "</div>";
        }

        // Affichez le groupe de confirmation avec le formulaire
        echo "<div id='confirmationGroup'>";
        echo "<form action='vote.php' method='POST'>";  // Redirection vers vote.php
        echo "<input type='hidden' name='nomVote' value='$nomVote'>";
        echo "<button onclick='confirmVotes()'>Confirmer</button>";
        echo "</form>";
        echo "</div>";
    } else {
        echo "Nom du vote manquant dans l'URL.";
    }
    ?>

    <!-- Boutons de navigation -->
    <button id='backButton' onclick='backMangaGroup()' style='display: none;'>Retour</button>
    <button id='nextButton' onclick='nextMangaGroup()'>Suivant</button>

    <script src="navigation.js"></script>
</body>
</html>
