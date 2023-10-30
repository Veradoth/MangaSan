<?php
session_start(); // Démarre la session

require_once __DIR__ . "/config/config.php"; // Inclut le fichier de configuration une seule fois

if (isset($_SESSION["admin_id"])) {
    // Validation de l'ID de l'administrateur
    $admin_id = intval($_SESSION["admin_id"]);

    if ($admin_id > 0) {
        // Utilisation de requêtes préparées pour éviter les injections SQL
        $stmt = $connexion->prepare("SELECT * FROM administrateur WHERE id = ?");
        $stmt->bind_param("i", $admin_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $admin = $result->fetch_assoc();
        }
    }
}

if (isset($_SESSION["user_id"])) {
    // Validation de l'ID de l'utilisateur
    $user_id = intval($_SESSION["user_id"]);

    if ($user_id > 0) {
        // Utilisation de requêtes préparées pour éviter les injections SQL
        $stmt = $connexion->prepare("SELECT * FROM utilisateur WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
        }
    }
}
?>
