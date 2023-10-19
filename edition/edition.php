<!doctype html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Edition</title>
</head>
<body><h1>Donnner ses impressions</h1>
<p><a href='../accueil.php'>Retour</a></p>
<form action = 'editer.php' method ='POST'>
Manga : <select name='numManga' id="mangaSelect" onchange="showFields()">
    <option value="0">Sélectionnez un manga</option>
<?php
    require_once ("../config/pdo.php");

    $sql = 'SELECT id, nom FROM manga';
    $stmt = $connexion->prepare($sql);
    $stmt->execute();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
	    echo "<option value='".$row['id']."'>".$row['nom']. '</option>';
    }
?>
</select><br>
<div class="conditional-fields" style="display: none;">
    <input type="text" name="graph" placeholder="Graphisme" required/><br>
    <input type="text" name="theme" placeholder="Thème" required/><br>
    <input type="text" name="pp" placeholder="Personnages principaux" required/><br>
    <input type="text" name="bon" placeholder="Ce que j'aime" required/><br>
    <input type="text" name="mauvais" placeholder="Ce que je n'aime pas" required/><br>
    <input type="text" name="appre" placeholder="Appréciation" required/><br>
</div>

<?php $connexion = null;?>
<input type = 'submit' Value="Valider"/>
</form>

<script src="edition.js"></script>
</body></html>

