<?php
try{
	$connexion = new PDO('mysql:host=localhost;dbname=mangasan;charset=utf8;','aroyer','Adrien1402');
}catch(PDOException $e){
	echo "erreur de la connexion a la base de donnee".$e->getMessage();
}
?>