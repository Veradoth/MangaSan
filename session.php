<?php
    session_start(); // Démarre la session


    if (isset($_SESSION["admin_id"])){
        $connexion = require __DIR__ ."/config/config.php";

        $sql = "SELECT * FROM administrateur WHERE id = {$_SESSION["admin_id"]}";

        $result = $connexion->query($sql);

        $admin = $result->fetch_assoc();
    }

    if (isset($_SESSION["user_id"])){ // Vérifie si l'ID de l'utilisateur est défini dans la session
        $connexion = require __DIR__ . "/config/config.php"; // Inclut et assigne la connexion à la base de données

        $sql = "SELECT * FROM utilisateur WHERE id = {$_SESSION["user_id"]}"; // Requête SQL pour récupérer un administrateur par son ID

        $result = $connexion->query($sql); // Exécute la requête SQL 

        $user = $result->fetch_assoc(); // Récupère les données de l'administrateur sous forme de tableau associatif
    }
?>