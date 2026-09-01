<?php
/*

TEMPLATE :
Rôle : afficher le formulaire de modification du profil

Paramètres : $utilisateur

*/
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier mon profil</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<header>
    <nav>
        <a href="dashboard.php"><Data>Mon Dashboard</Data></a>
        <a href="logout.php">Me déconnecter</a>
    </nav>
</header>

<main>
    <h1>Modifier mon profil</h1>

    <p>Vous pouvez modifier votre pseudo, votre adresse email ou votre mot de passe.</p>
    <p>Vous pouvez modifier une seule information ou plusieurs.
    Laissez simplement vide les champs que vous ne souhaitez pas modifier.</p>

    <form action="valider-modifier-profil.php" method = "POST">

        <div>
            <label for="pseudo">Pseudo :</label>
            <input
                type="text" id = "pseudo" name = "pseudo"
                value="<?= $utilisateur->html("pseudo") ?>">
        </div>

        <div>
            <label for="email">Adresse email :</label>
            <input
                type="email" id = "email" name = "email"
                value="<?= $utilisateur->html("email") ?>">
        </div>

        <div>
            <label for="password">Nouveau mot de passe :</label>
            <input type="password" id="password" name="password" >
        </div>

        <button type="submit">Enregistrer les modifications</button>
    </form>

    <a href="dashboard.php">↩️ Retour</a>
</main>

</body>
</html>