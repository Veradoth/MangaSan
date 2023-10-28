<?php
session_start(); // Démarre la session

session_destroy(); // Détruit la session actuelle

header("Location: ../index.php"); // Redirige vers la page d'accueil
exit; // Termine l'exécution du script
?>