<?php
/*

TEMPLATE :
Rôle : afficher la page de connexion

Paramètres : aucun

*/
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/style.css">
        <title>Connexion</title>
       
    </head>
    <body>
        <div>
            <h1>QuiDitMieux</h1>

            <!--------------- user et mdp test ----------------------->
            <h3 style = "color: yellowgreen;">mot de passe test et email test</h3>
            <h6>EMAIL omar : r@gmail.com  MDP : 1234</h6>
            <h6>EMAIL doe : gr@gmail.com  MDP : 123</h6>

            <!-- message d'erreur email ou mdp incorrect  -->
            <?php if (!empty($_SESSION["error_login"])): ?>
                <p style="color:red; font-weight:bold;"><?= $_SESSION["error_login"] ?></p>
                <?php unset($_SESSION["error_login"]); ?>
            <?php endif; ?>

            <!-- connexion-->
            <h2>Se connecter</h2>
            <p>Vous pouvez vous connecter en remplissant le formulaire ci-dessous </p>

            <!-- login : connexion -->
            <form method="POST" action="auth.php?action=login">
                <label for="identifiant">Email ou pseudo :</label>
                <input type="text" name="identifiant" placeholder="Email ou pseudo"><br><br>
                <label for="password">Mot de passe :</label>
                <input type="password" name="password" placeholder="Mot de passe"><br><br>
                <button class="login" type="submit">Se connecter</button>
                <!-- Si vous avez deja un compte Se connecter -->
                <p>
                    Vous n'avez pas de compte ?
                    <a href="auth.php?action=register">Créer un compte</a>
                </p>
            </form><br><br>
        </div>

        <!-- bouton retour accueil principal -->
        <a href="index.php"> ↩️ Retour à l'accueil</a>
       
    </body>
</html>
