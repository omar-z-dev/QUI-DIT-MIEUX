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
        <a href="dashboard.php">Tableau de bord</a>
        <a href="logout.php">Me déconnecter</a>
    </nav>
</header>

<main>
    <h1>Modifier mon profil</h1>

    <p>Modifiez vos informations personnelles.</p>

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

        <button type="submit">Enregistrer les modifications</button>
    </form>

    <a href="dashboard.php">↩️ Retour</a>
</main>

</body>
</html>