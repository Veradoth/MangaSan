<?php
$server = "localhost:3307"; // Adresse du serveur MySQL
$userdb = "aroyer"; // Nom d'utilisateur de la base de données
$userpwd = "Adrien1402"; // Mot de passe de la base de données
$base = "mangasan"; // Nom de la base de données

$connexion=new mysqli($server,$userdb,$userpwd,$base); // Établir une connexion à la base de données MySQL

if($connexion->connect_errno){ // Vérifier s'il y a une erreur de connexion
    die("Erreur de connexion : ".$connexion->connect_error); // Afficher un message d'erreur et arrêter l'exécution du script
} 

return $connexion; // Retourner l'objet de connexion à la base de données
?>
