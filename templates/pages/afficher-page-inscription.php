<?php
/*

Rôle : afficher la page d'inscription

Paramètres : aucun

*/
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/style.css">
        <title>Inscription</title>
        
    </head>
    <body>
        <div>

            <!-- creer compte -->
            <h1>QuiDitMieux</h1>
            <h2>Créer un compte</h2>
            <p>Vous pouvez vous inscrire en remplissant le formulaire ci-dessous</p>

            <!-- register : creation de compte-->
            <form method="POST" action="auth.php?action=register" novalidate>
                
                <!-- message d'erreur creation de compte  -->

                <?php if (!empty($_SESSION["error_register"])): ?>
                    <p style="color:red; font-weight:bold;"><?= $_SESSION["error_register"] ?></p>
                    <?php unset($_SESSION["error_register"]); ?>
                <?php endif; ?>

                <!-- message succes de creation de compte  -->
                 
                <?php if (!empty($_SESSION["success_register"])): ?>
                    <p style="color:green; font-weight:bold;"><?= $_SESSION["success_register"] ?></p>
                    <?php unset($_SESSION["success_register"]); ?>
                <?php endif; ?>

                <!-- message erreur recaptcha  -->
                 
                <?php if (!empty($_SESSION["error_recaptcha"])): ?>
                    <p style="color:red; font-weight:bold;"><?= $_SESSION["error_recaptcha"] ?></p>
                    <?php unset($_SESSION["error_recaptcha"]); ?>
                <?php endif; ?>
                <label for="pseudo">Pseudo :</label>
                <input type="text" name="pseudo" placeholder="Votre pseudo" ><br><br>
                <label for="email">Email :</label>
                <input type="email" name="email" placeholder="Email" ><br><br>
                <label for="password">Mot de passe :</label>
                <input type="password" name="password" placeholder="Mot de passe" ><br><br>

                <!-- recaptcha -->
                <div 
                    class="g-recaptcha" data-sitekey="6LcoUZotAAAAAMqyFNFh10UzzSfHlCxVR7bVP1yd">
                </div>
                <button class="login" type="submit">S'inscrire</button>
                <!-- Si vous avez deja un compte Se connecter -->
                <p>
                    Vous avez déjà un compte ?
                    <a href="auth.php?action=login">Se connecter</a>
                </p>
            </form>
        </div>
        
        <!-- bouton retour accueil principal -->
        <a href="index.php"> ↩️ Retour à l'accueil</a>

    <!-- sert à charger le code JavaScript de Google reCAPTCHA dans la page et creer la case -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
       
    </body>
</html>
