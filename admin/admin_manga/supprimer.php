<?php
require_once("style_manga.php");

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["numManga"])){
    require_once ("../../config/config.php");

    $num = $_POST['numManga'];

    // 1. Supprimer les éditions (editages) associées à ce manga
    $sqlDeleteEditages = "DELETE FROM editage WHERE id_manga = ?";
    $stmtDeleteEditages = $connexion->prepare($sqlDeleteEditages);

    if ($stmtDeleteEditages) {
        $stmtDeleteEditages->bind_param("i", $num);
        $stmtDeleteEditages->execute();
        $stmtDeleteEditages->close();
    }

    // 2. Supprimer le manga
    $sqlSelectImage = "SELECT nom_image FROM manga WHERE id = ?";
    $stmtSelectImage = $connexion->prepare($sqlSelectImage);

    if ($stmtSelectImage) {
        $stmtSelectImage->bind_param("i", $num);
        $stmtSelectImage->execute();
        $stmtSelectImage->store_result();
        
        if ($stmtSelectImage->num_rows > 0) {
            $stmtSelectImage->bind_result($nomFichier);
            $stmtSelectImage->fetch();
            
            $content_dir = '../../catalogue/images/';
            $cheminFichier = $content_dir . $nomFichier;

            if (unlink($cheminFichier)) {
                $sqlDeleteManga = "DELETE FROM manga WHERE id = ?";
                $stmtDeleteManga = $connexion->prepare($sqlDeleteManga);

                if ($stmtDeleteManga) {
                    $stmtDeleteManga->bind_param("i", $num);
                    $stmtDeleteManga->execute();
                    $stmtDeleteManga->close();

                    if (!$connexion->errno) {
                        header("Location: admin_manga.php?success=3");
                    }
                }
            }
        }
    }

    mysqli_close($connexion);
}
?>
