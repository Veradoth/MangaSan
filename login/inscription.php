<!doctype html>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>S'inscrire</title>
    </head>
    <body>
        <section>
            <h1>S'inscrire</h1>
            <?php 
                if(isset($erreur)){
                    echo "<p class= 'erreur'>".$erreur."</p>";
                }
            ?>
            <form action="inscrire_admin.php" method="POST" novalidate>
                <div>
                    <label>Nom</label>
                    <input type="text" name="nom" id="nom">
                </div>

                <div>
                    <label>Adresse Mail</label>
                    <input type="text" name="mail" id="mail">
                </div>

                <div>
                    <label>Mot de passe</label>
                    <input type="password" name="mdp" id="mdp">
                </div>

                <div>
                    <label>Retaper mot de passe</label>
                    <input type="password" name="mdp_confirm" id="mdp_confirm">
                </div>

                <label>Vous avez déjà un compte ?</label>
                <a href="connexion.php">Se connecter</a>
                <br>
                <button type="submit" name="valider"> Enregistrer</button>
            </form>
            <button onclick="window.location.href='../accueil.php';" class="btnLogin-popup">Retour</button>
        </section>

        <script src="https://unpkg.com/just-validate@latest/dist/just-validate.production.min.js" defer></script>
        <script src= "validation.js" defer></script>
    </body>
</html>