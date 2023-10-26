<?php
    require_once("style_manga.php"); // Inclusion du fichier header.php (probablement contenant la structure de l'en-tête de la page)
?>

<!--Champ ajouter un manga-->

<?php
// Vérifiez si le paramètre "success" est présent dans l'URL
if (isset($_GET['success']) && $_GET['success'] == 1) {
    echo '<p class="success-message">Le manga a été ajouté.</p>';
}
?>

    <?php
        if(isset($_GET['action'])){ // Vérifie si le paramètre 'action' est présent dans l'URL
            if($_GET['action'] == 'add_manga'){ // Vérifie si la valeur du paramètre 'action' est égale à 'add_manga'
                require_once("../../config/config.php"); // Inclusion du fichier connexion.php pour établir une connexion à la base de données
    ?>

    <div class="form-container">
        <h3>Ajouter un Manga</h3>
        <form method="post" action="ajouter.php" enctype="multipart/form-data"><br>
            <input type="text" name="nom" placeholder="Nom du manga" required="" class="form form-control"><br>
            <input type="text" name="auteur" placeholder="Auteur" required="" class="form form-control"><br>
            <input type="date" name="sortie" placeholder="Date de sortie" required="" class="form form-control"><br>
            <textarea name="descrip" placeholder="Description" class="form form-control"></textarea><br>
            <input type="file" name="fichier"><br><br>
            <input type="submit" name="submit" class="btn btn-primary"><br><br>
        </form>
    </div>
    <?php
    }
    }

    ?>

</div>

<!--Champ supprimer un manga-->

<?php
// Vérifiez si le paramètre "success" est présent dans l'URL
if (isset($_GET['success']) && $_GET['success'] == 3) {
    echo '<p class="success-message">Le manga a été supprimé avec succès.</p>';
}
?>

<?php
    if(isset($_GET['action'])){ // Vérifie si la variable GET 'action' est définie
        if($_GET['action'] == 'suppr_manga'){ // Vérifie si la valeur de 'action' est égale à 'suppr_manga'
            require_once("../../config/config.php"); // Inclut et exécute le fichier de connexion à la base de données
            ?>

    <div class="form-container">
        <h3>Supprimer un Manga</h3> 
        <form action="supprimer_manga.php" method='POST'>
        Manga : <select name='numManga'> 
        <?php
            $sql = 'SELECT * FROM manga'; 
            $listeManga = $connexion->query($sql); 
            while ($manga = $listeManga->fetch_assoc()) {
                echo "<option value='".$manga['id']."'>".$manga['nom'];
                echo '</option>'; 
            }
        ?>
    </select><br> <!-- Fin de l'élément de sélection -->
    <?php $connexion->close();?> <!-- Ferme la connexion à la base de données -->
    <br>
    <input type='submit' Value="Voir les informations"/> <!-- Bouton de soumission du formulaire -->
    </form> <!-- Fin du formulaire -->
    </div>
    <?php
    }
}
?>

<!--Champ modifier un manga-->

<?php
// Vérifiez si le paramètre "success" est présent dans l'URL
if (isset($_GET['success']) && $_GET['success'] == 2) {
    echo '<p class="success-message">Le manga a été modifié avec succès.</p>';
}
?>


<?php
    if(isset($_GET['action'])){
        if($_GET['action'] == 'mod_manga'){
            require_once("../../config/config.php");
            ?>
        
        <div class="form-container">
            <h1>Modifier un manga</h1>
            <form action = 'modifier_manga.php' method ='POST' enctype="multipart/form-data">
            Manga : <select name='numManga'>
            <?php
                $sql = 'SELECT * FROM manga';
                $listeManga = $connexion->query($sql);
                while ($manga = $listeManga->fetch_assoc()) {
	                echo "<option value='".$manga['id']."'>".$manga['nom'];
                    echo '</option>';
                }
            ?>
            </select>
            <?php $connexion->close(); ?>
            <br>
            <br>
            <input type="submit" name="submit" class="btn btn-primary" value="Voir les informations"><br><br>
            </form>
        </div>
    <?php
        }
    }
    ?>
<script src="../choix.js"></script>
