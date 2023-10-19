<?php
    if(empty($_POST["nom"])){
        die("Le nom est requis"); // Si le champ "nom" est vide, affiche un message d'erreur et arrête l'exécution
    }

    if(! filter_var($_POST["mail"], FILTER_VALIDATE_EMAIL)){
        die("Mail valide requis"); // Si le champ "mail" n'est pas un email valide, affiche un message d'erreur et arrête l'exécution
    }

    if(strlen($_POST["mdp"]) < 8){
        die("Mot de passe doit contenir au moins 8 caractères !"); // Si le champ "mdp" contient moins de 8 caractères, affiche un message d'erreur et arrête l'exécution
    }

    if(! preg_match("/[a-z]/i", $_POST["mdp"])){
        die("Le mot de passe doit contenir au moins 1 lettre"); // Si le champ "mdp" ne contient pas au moins une lettre, affiche un message d'erreur et arrête l'exécution
    }

    if(! preg_match("/[0-9]/i", $_POST["mdp"])){
        die("Le mot de passe doit contenir au moins 1 chiffre !"); // Si le champ "mdp" ne contient pas au moins un chiffre, affiche un message d'erreur et arrête l'exécution
    }

    if($_POST["mdp"] !== $_POST["mdp_confirm"]){
        die("Les mots de passe ne sont pas identiques !"); // Si les champs "mdp" et "mdp_confirm" ne sont pas identiques, affiche un message d'erreur et arrête l'exécution
    }

    $password_hash = password_hash($_POST["mdp"], PASSWORD_DEFAULT); // Génère le hash du mot de passe à partir du champ "mdp"

    $connexion = require __DIR__. "/../config/config.php"; // Établit la connexion à la base de données

    $sql = "INSERT INTO utilisateur (pseudo, mail, mdp_hash) VALUES (?, ?, ?)"; // Requête SQL pour insérer les données dans la table "administrateur"

    $stmt = $connexion->stmt_init(); // Initialise une nouvelle requête préparée

    if( ! $stmt->prepare($sql)){
        die("SQL error: ". $connexion->error); // Si la préparation de la requête échoue, affiche un message d'erreur avec l'erreur de la connexion et arrête l'exécution
    }

    $stmt->bind_param("sss",
                        $_POST["nom"],
                        $_POST["mail"],
                        $password_hash); // Lie les valeurs des paramètres à la requête préparée

    if($stmt->execute()){
        header("Location: connexion.php"); // Redirige l'utilisateur vers la page "reussie.php" si l'exécution de la requête est réussie
        exit; // Arrête l'exécution du script
    }
    

?>
