
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
            <h1> Qui dit mieux</h1>

            <!-- creer compte -->
            <h2>Connexion</h2>

            <!--------------- user et mdp test ----------------------->
            <h3 style = "color: yellowgreen;">mot de passe test et email test</h3>
            <h6>EMAIL omar : r@gmail.com  MDP : 1234</h6>
            <h6>EMAIL doe : gr@gmail.com  MDP : 123</h6>
            <h6>EMAIL alex : grr@gmail.com  MDP : 12</h6>
            <h6>EMAIL jack : rty@gmail.com  MDP : 1</h6>

            <!-- message d'erreur email ou mdp incorrect  -->
            <?php if (!empty($_SESSION["error_login"])): ?>
                <p style="color:red; font-weight:bold;"><?= $_SESSION["error_login"] ?></p>
                <?php unset($_SESSION["error_login"]); ?>
            <?php endif; ?>

            <!-- login : connexion -->
            <form method="POST" action="auth.php?action=login">
                <input type="text" name="identifiant" placeholder="Email ou pseudo"><br><br>
                <input type="password" name="password" placeholder="Mot de passe"><br><br>
                <button type="submit">Se connecter</button>
            </form><br><br>
        </div>

        <!-- bouton retour accueil principal -->
        <a href="index.php">Retour à l'accueil</a>
       
    </body>
</html>
