<?php
    require_once("../style.php"); // Inclusion du fichier header.php (probablement contenant la structure de l'en-tête de la page)
?>

    <!--Champ ajouter un véhicule-->

<?php
    if(isset($_GET['action'])){ // Vérifie si le paramètre 'action' est présent dans l'URL
        if($_GET['action'] == 'add_vote'){ // Vérifie si la valeur du paramètre 'action' est égale à 'add_vehicule'
            require_once("../../config/config.php"); // Inclusion du fichier connexion.php pour établir une connexion à la base de données

            if(isset($_POST['submit'])){ // Vérifie si le formulaire a été soumis (le bouton submit a été cliqué)
                extract($_POST); // Extrait les données du formulaire dans des variables distinctes

                $save_manga = $connexion->prepare('INSERT INTO vote(nom, participant, duree) VALUES(?,?,?)'); // Prépare une requête SQL d'insertion dans la table 'voiture'
                $save_manga->execute(array($nom, $nombre, $duree)); // Exécute la requête d'insertion avec les valeurs fournies
                echo "Vote enregistré"; // Affiche un message de confirmation d'enregistrement du véhicule
            }
?>

<div class="form-container">
    <h3>Ajouter un vote</h3>
    <form method="post" action="" enctype="multipart/form-data">
        <input type="text" name="nom" placeholder="Nom du vote" required="" class="form form-control">
        <input type="number" name="nombre" placeholder="Nombre de participants" required="" class="form form-control">
        <input type="time" name="duree" placeholder="Durée" required="" class="form form-control">
        <input type="submit" name="submit" class="btn btn-primary">
    </form>
</div>

    <?php
    }
    }

    ?>

</div>

<!--Champ supprimer un véhicule-->

<?php
    if(isset($_GET['action'])){ // Vérifie si la variable GET 'action' est définie
        if($_GET['action'] == 'suppr_vote'){ // Vérifie si la valeur de 'action' est égale à 'suppr_vehicule'
            require_once("../../config/config.php"); // Inclut et exécute le fichier de connexion à la base de données
            ?>

<div class="form-container">
    <h3>Supprimer un vote</h3>
    <form action="afficher_vote.php" method="POST">
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
}
?>

<!--Champ modifier un véhicule-->

<?php
    if(isset($_GET['action'])){
        if($_GET['action'] == 'mod_vote'){
            require_once("../../config/config.php");
            ?>
        
    <div class="form-container">
        <h1>Modifier un vote</h1>
        <form action="modifier.php" method="POST" enctype="multipart/form-data">
            <label for="numVote">Vote :</label>
            <select name="numVote" id="numVote">
            <?php
            include "../config/config.php";
            $sql = 'SELECT * FROM vote';
            $listeVote = $connexion->query($sql);
            while ($vote = $listeVote->fetch_assoc()) {
                echo "<option value='" . $vote['id'] . "'>" . $vote['nom'] . " " . $vote['participant'] . " " . $vote['duree'] . '</option>';
            }
            ?>
        </select>
        <br>
        <br>
        <hr>
        <br>
        <input type="text" name="newNom" placeholder="Nom du vote" autocomplete="off" class="form form-control"><br>
        <input type="number" name="newNombre" placeholder="Nombre de participants" autocomplete="off" class="form form-control"><br>
        <input type="time" name="newDuree" placeholder="Durée" class="form form-control"><br>
        <input type="submit" name="submit" class="btn btn-primary"><br><br>
    </form>
</div>

    <?php
        }
    }
    ?>

