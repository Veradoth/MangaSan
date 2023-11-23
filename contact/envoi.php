<?php
// Vérification si la méthode est POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données du formulaire
    $objet = $_POST["objet"] ?? "";
    $description = $_POST["description"] ?? "";

    // Connexion à la base de données
    require_once "../config/config.php"; // Fichier de configuration de la base de données

    // Requête d'insertion des données dans la table 'contact'
    $sql = "INSERT INTO contact (objet, description) VALUES (?, ?)";
    
    // Préparation de la requête
    $stmt = mysqli_prepare($connexion, $sql);

    // Vérification de la préparation de la requête
    if ($stmt) {
        // Liaison des paramètres avec la requête
        mysqli_stmt_bind_param($stmt, "ss", $objet, $description);

        // Exécution de la requête
        if (mysqli_stmt_execute($stmt)) {
            // Redirection vers une page de confirmation si l'insertion est réussie
            header("Location: contact.php");
            exit();
        } else {
            // Redirection vers une page d'erreur en cas d'échec de l'insertion
            header("Location: erreur_envoi.html");
            exit();
        }
    } else {
        // Redirection vers une page d'erreur si la préparation de la requête a échoué
        header("Location: erreur_envoi.html");
        exit();
    }

    // Fermeture de la requête préparée
    mysqli_stmt_close($stmt);
} else {
    // Redirection si la méthode de requête n'est pas POST
    header("Location: erreur_envoi.html");
    exit();
}
?>
