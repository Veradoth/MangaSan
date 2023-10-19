<?php
    require_once("../style.php"); // Inclusion du fichier header.php (probablement contenant la structure de l'en-tête de la page)
?>

    <!--Champ ajouter un véhicule-->

    <?php
        if(isset($_GET['action'])){ // Vérifie si le paramètre 'action' est présent dans l'URL
            if($_GET['action'] == 'add_manga'){ // Vérifie si la valeur du paramètre 'action' est égale à 'add_vehicule'
                require_once("../../config/config.php"); // Inclusion du fichier connexion.php pour établir une connexion à la base de données

                if(isset($_POST['submit'])){ // Vérifie si le formulaire a été soumis (le bouton submit a été cliqué)
                    extract($_POST); // Extrait les données du formulaire dans des variables distinctes

                    $content_dir='../catalogue/images/'; // Chemin du répertoire où les images seront stockées

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
                        exit('Impossible de copier le fichier'); // Arrête l'exécution du code et affiche un message d'erreur si le fichier ne peut pas être copié
                    }

                    $save_manga = $connexion->prepare('INSERT INTO manga(nom, auteur, date_sortie, descrip, nom_image) VALUES(?,?,?,?,?)'); // Prépare une requête SQL d'insertion dans la table 'voiture'
                    $save_manga->execute(array($nom, $auteur, $sortie, $descrip, $name_file)); // Exécute la requête d'insertion avec les valeurs fournies
                    echo "Manga enregistré"; // Affiche un message de confirmation d'enregistrement du véhicule
                }
    ?>

    <h3>Ajouter un Manga</h3>
    <form method="post" action="" enctype="multipart/form-data"><br>
        <input type="text" name="nom" placeholder="Nom du manga" required="" class="form form-control"><br>
        <input type="text" name="auteur" placeholder="Auteur" required="" class="form form-control"><br>
        <input type="date" name="sortie" placeholder="Date de sortie" required="" class="form form-control"><br>
        <textarea name="descrip" placeholder="Description" class="form form-control"></textarea><br>
        <input type="file" name="fichier"><br><br>
        <input type="submit" name="submit" class="btn btn-primary"><br><br>
    </form>
    <?php
    }
    }

    ?>

</div>

<!--Champ supprimer un véhicule-->

<?php
    if(isset($_GET['action'])){ // Vérifie si la variable GET 'action' est définie
        if($_GET['action'] == 'suppr_manga'){ // Vérifie si la valeur de 'action' est égale à 'suppr_vehicule'
            require_once("../../config/config.php"); // Inclut et exécute le fichier de connexion à la base de données
            ?>

    <h3>Supprimer un Manga</h3> <!-- Titre "Supprimer un véhicule" -->
    <form action="supprimer.php" method='POST'> <!-- Formulaire avec action 'supprimer.php' et méthode POST -->
    Manga : <select name='numManga'> <!-- Élément de sélection avec le nom 'numVoiture' -->
    <?php
    include "../config/config.php"; // Inclut et exécute à nouveau le fichier de connexion à la base de données
    $sql = 'SELECT * FROM manga'; // Requête SQL pour sélectionner toutes les voitures
    $listeManga = $connexion->query($sql); // Exécute la requête SQL et assigne le résultat à la variable $listeVoiture
    while ($manga = $listeManga->fetch_assoc()) { // Boucle while pour parcourir chaque ligne de résultat
        echo "<option value='".$manga['id']."'>".$manga['nom']." ".$manga['auteur']." ".$manga['date_sortie']." ".$manga['descrip']." ".$manga["nom_image"];
        echo '</option>'; // Affiche chaque option dans le menu déroulant avec les informations de la voiture
    }
    ?>
    </select><br> <!-- Fin de l'élément de sélection -->
    <?php $connexion->close();?> <!-- Ferme la connexion à la base de données -->
    <input type='submit' Value="Supprimer ce manga"/> <!-- Bouton de soumission du formulaire -->
    </form> <!-- Fin du formulaire -->
    <?php
    }
}
?>

<!--Champ modifier un véhicule-->

<?php
    if(isset($_GET['action'])){
        if($_GET['action'] == 'mod_manga'){
            require_once("../../config/config.php");
            ?>
        
        <h1>Modifier le manga</h1>
        <form action = 'modifier.php' method ='POST' enctype="multipart/form-data">
        Manga : <select name='numManga'>
        <?php
        include "../config/config.php";
        $sql = 'SELECT * FROM manga';
        $listeManga = $connexion->query($sql);
        while ($manga = $listeManga->fetch_assoc()) {
	        echo "<option value='".$manga['id']."'>".$manga['nom']." ".$manga['auteur']." ".$manga['date_sortie']." ".$manga['descrip']." ".$manga['nom_image'];
            echo '</option>';
        }
        ?>
        <hr>
        </select><br>
        <input type="text" name="newManga" placeholder="Nom du manga" class="form form-control"><br>
        <input type="text" name="newAuteur" placeholder="Auteur" class="form form-control"><br>
        <input type="date" name="newSortie" placeholder="Date de sortie" class="form form-control"><br>
        <textarea name="newDescription" placeholder="Description" class="form form-control"></textarea><br>
        <input type="file" name="newImage"><br>
        <input type="submit" name="submit" class="btn btn-primary"><br><br>
        </form>
    <?php
        }
    }
    ?>
