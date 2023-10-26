<?php
require_once("../../config/config.php"); // Inclure votre fichier de configuration MySQLi

if (isset($_GET['id'])) {
    $adminId = $_GET['id'];

    // Récupérer les données de l'utilisateur depuis la table "utilisateurs"
    $sql = "SELECT * FROM administrateur WHERE id = ?";
    $stmt = $connexion->prepare($sql);
    $stmt->bind_param("i", $adminId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($admin = $result->fetch_assoc()) {

        // Insérer l'utilisateur dans la table "administrateurs"
        $sql = "INSERT INTO utilisateur (pseudo, mail, mdp_hash) VALUES (?, ?, ?)";
        $stmt = $connexion->prepare($sql);
        $stmt->bind_param("sss", $admin['nom'], $admin['mail'], $admin['mdp_hash']); // Utilisez "mdp_hash" ici
        
        if ($stmt->execute()) {
            // Supprimer l'utilisateur de la table "utilisateurs"
            $sql = "DELETE FROM administrateur WHERE id = ?";
            $stmt = $connexion->prepare($sql);
            $stmt->bind_param("i", $adminId);

            if ($stmt->execute()) {
                header("Location: membres.php");
                exit;
            } else {
                echo "Erreur lors de la suppression de l'utilisateur.";
            }
        } else {
            echo "Erreur lors de l'insertion de l'utilisateur en tant qu'administrateur.";
        }
    } else {
        echo "Utilisateur non trouvé dans la table utilisateurs.";
    }
} else {
    echo "ID d'utilisateur non spécifié.";
}
?>
