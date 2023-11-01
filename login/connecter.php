<?php
    session_start();
?>

<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    require __DIR__ . "/../config/config.php"; // Inclut la connexion à la base de données

    $mail = filter_var($_POST["mail"], FILTER_VALIDATE_EMAIL);

    if ($mail) {
        $sql = "SELECT * FROM administrateur WHERE mail = ?";
        $stmt = $connexion->prepare($sql);
        $stmt->bind_param("s", $mail);
        $stmt->execute();
        $adminResult = $stmt->get_result();
        $stmt->close();

        if ($admin = $adminResult->fetch_assoc()) {
            if (password_verify($_POST["mdp"], $admin["mdp_hash"])) {
                // Connexion réussie pour l'administrateur
                startSessionAndRedirect($admin["id"], "admin", $admin["mail"]);
            }
        }

        // Si l'utilisateur n'est pas un administrateur, vérifiez s'il est un utilisateur normal
        $sql = "SELECT * FROM utilisateur WHERE mail = ?";
        $stmt = $connexion->prepare($sql);
        $stmt->bind_param("s", $mail);
        $stmt->execute();
        $userResult = $stmt->get_result();
        $stmt->close();

        if ($user = $userResult->fetch_assoc()) {
            if (password_verify($_POST["mdp"], $user["mdp_hash"])) {
                // Connexion réussie pour l'utilisateur
                startSessionAndRedirect($user["id"], "user");
            }
        }
    }

    // Marquer la connexion comme invalide si aucune correspondance n'est trouvée
    $_SESSION["is_invalid"] = true;
    header("Location: connexion.php");
    exit;
}

function startSessionAndRedirect($id, $role, $email = null) {
    session_start();
    session_regenerate_id();
    
    if ($role === "user") {
        $_SESSION["user_id"] = $id;
    } elseif ($role === "admin") {
        $_SESSION["admin_id"] = $id;
        $_SESSION["admin_email"] = $email;
    }

    $_SESSION["is_invalid"] = false;
    header("Location: ../index.php");
    exit;
}
?>
