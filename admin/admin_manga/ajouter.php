<?php

    if(isset($_POST['submit'])){ // Vérifie si le formulaire a été soumis (le bouton submit a été cliqué)
        require_once("../../config/config.php");
        extract($_POST); // Extrait les données du formulaire dans des variables distinctes

        $content_dir='../../catalogue/images/'; // Chemin du répertoire où les images seront stockées

        $tmp_file = $_FILES['fichier']['tmp_name']; // Récupère le chemin temporaire du fichier uploadé

        if(!is_uploaded_file($tmp_file)) {
            exit('le fichier est introuvable'); // Arrête l'exécution du code et affiche un message d'erreur si le fichier est introuvable
        }

        $type_file = $_FILES['fichier']['type']; // Récupère le type de fichier uploadé

        if(!strstr($type_file,'png') && !strstr($type_file,'jpeg')){
            exit('Le fichier n\'est pas une image'); // Arrête l'exécution du code et affiche un message d'erreur si le fichier n'est pas une image
        }

        $name_file = time(). '.jpg'; // Génère un nom unique pour le fichier en utilisant le timestamp actuel

        if(!move_uploaded_file($tmp_file, $content_dir.$name_file)){
            echo "Erreur de téléchargement : " . $_FILES['fichier']['error'];
            exit('Impossible de copier le fichier'); // Arrête l'exécution du code et affiche un message d'erreur si le fichier ne peut pas être copié
        }

        $save_manga = $connexion->prepare('INSERT INTO manga(nom, auteur, date_sortie, descrip, nom_image) VALUES(?,?,?,?,?)'); // Prépare une requête SQL d'insertion dans la table 'voiture'
        $save_manga->execute(array($nom, $auteur, $sortie, $descrip, $name_file)); // Exécute la requête d'insertion avec les valeurs fournies
        header ("Location:admin_manga.php?success=1"); // Affiche un message de confirmation d'enregistrement du véhicule
    }
?>