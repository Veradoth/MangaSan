<?php
    require_once("style_vote.php"); // Inclusion du fichier header.php (probablement contenant la structure de l'en-tête de la page)
?>

<!--Champ ajouter un véhicule-->

<?php

//Envoie un message comme quoi le nom existe déjà

if(isset($_GET['error']) && $_GET['error'] == 1){
    echo '<p class="error-message">Le nom est déjà pris !</p>';
}

// Vérifiez si le paramètre "success" est présent dans l'URL
if (isset($_GET['success']) && $_GET['success'] == 4) {
    echo '<p class="success-message">Le vote a été ajouté.</p>';
}
?>

<?php
    if(isset($_GET['action'])){ // Vérifie si le paramètre 'action' est présent dans l'URL
        if($_GET['action'] == 'add_vote'){ // Vérifie si la valeur du paramètre 'action' est égale à 'add_vehicule'
            require_once("../../config/config.php"); // Inclusion du fichier connexion.php pour établir une connexion à la base de données
?>

<div class="form-container">
    <h3>Ajouter un vote</h3>
    <form method="post" action="ajouter.php" enctype="multipart/form-data">
        <input type="text" name="nom" placeholder="Nom du vote" required="" class="form form-control">
        <label for="mangas">Sélectionnez les mangas :</label>
        <select name="mangas[]" multiple>
            <?php
            $sql = "SELECT id, nom FROM manga";
            $listeManga = $connexion->query($sql);
            while ($manga = $listeManga->fetch_assoc()) {
                echo '<option value="' . $manga['id'] . '">' . $manga['nom'] . '</option>';
            }
            ?>
        </select>
        <input type="datetime-local" name="duree" required="" class="form form-control">
        <br>
        <input type="submit" name="submit" class="btn btn-primary">
    </form>
</div>


    <?php
    }
    }

    ?>

</div>

<script src="ChangeIdManga.js"></script>

<!--Champ supprimer un véhicule-->

<?php
// Vérifiez si le paramètre "success" est présent dans l'URL
if (isset($_GET['success']) && $_GET['success'] == 6) {
    echo '<p class="success-message">Le vote a été supprimé avec succès.</p>';
}
?>

<?php
    if(isset($_GET['action'])){ // Vérifie si la variable GET 'action' est définie
        if($_GET['action'] == 'suppr_vote'){ // Vérifie si la valeur de 'action' est égale à 'suppr_vehicule'
            require_once("../../config/config.php"); // Inclut et exécute le fichier de connexion à la base de données
            ?>

<div class="form-container">
    <h3>Supprimer un vote</h3>
    <form action="supprimer_vote.php" method="POST">
        <label for="numVote">Vote :</label>
        <select name="numVote" id="numVote">
            <?php
                $sql = 'SELECT id, nom FROM vote GROUP BY nom'; // Regroupe les votes par nom
                $listeVote = $connexion->query($sql);
                while ($vote = $listeVote->fetch_assoc()) {
                    echo "<option value='" . $vote['id'] . "'>" . $vote['nom']. '</option>';
                }
            ?>
        </select>
        <?php $connexion->close(); ?>
        <br>
        <br>
        <input type="submit" value="Supprimer le vote"/>
    </form>
</div>


    <?php
    }
}
?>

<!--Champ modifier un véhicule-->

<?php
// Vérifiez si le paramètre "success" est présent dans l'URL
if (isset($_GET['success']) && $_GET['success'] == 5) {
    echo '<p class="success-message">Le vote a été modifié avec succès.</p>';
}
?>

<?php
    if (isset($_GET['action']) && $_GET['action'] == 'mod_vote') {
        require_once("../../config/config.php");
?>
        
    <div class="form-container">
        <h3>Modifier un vote</h3>
        <form action="modifier_vote.php" method="POST">
            <label for="numVote">Vote :</label>
            <select name="numVote" id="numVote">
            <?php
                $sql = 'SELECT * FROM vote';
                $listeVote = $connexion->query($sql);
                while ($vote = $listeVote->fetch_assoc()) {
                    echo "<option value='" . $vote['id'] . "'>" . $vote['nom']. '</option>';
                }
            ?>
        </select>
        <?php $connexion->close(); ?>
        <br>
        <br>
        <input type="submit" value="Voir les informations"/>
    </form>
</div>

    <?php
        }
    ?>
<script src="../style.js"></script>

