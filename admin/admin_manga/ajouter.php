<?php

if(isset($_POST['submit'])){ 
    require_once("../../config/config.php");
    extract($_POST); 

    $content_dir='../../catalogue/images/'; 

    $tmp_file = $_FILES['fichier']['tmp_name']; 

    if(!is_uploaded_file($tmp_file)) {
        header("Location: maintenance.php");
        exit(); 
    }

    $type_file = $_FILES['fichier']['type']; 

    if(!strstr($type_file,'png') && !strstr($type_file,'jpeg')){
        header("Location: maintenance.php");
        exit(); 
    }

    $name_file = time(). '.jpg'; 

    if(!move_uploaded_file($tmp_file, $content_dir.$name_file)){
        header("Location: maintenance.php");
        exit(); 
    }

    $save_manga = $connexion->prepare('INSERT INTO manga(nom, auteur, date_sortie, descrip, nom_image) VALUES(?,?,?,?,?)'); 
    $save_manga->execute(array($nom, $auteur, $sortie, $descrip, $name_file)); 

    header("Location: admin_manga.php?success=1"); 
}
?>
