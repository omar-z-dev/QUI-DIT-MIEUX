<?php
/*

Rôle : afficher le détail d'une annonce et  mise en forme

Paramètres : id de l'annonce

*/

/** @var photo $photoPrincipale */
/** @var string  $libelleCategorie */
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Détail de l'annonce</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <nav>
            <a href="index.php">↩ Accueil</a>
        </nav>
    </header>
    <main>
        <h1>Qui Dit Mieux</h1>
        <h2>Détail de l'annonce :</h2>
        <h3 > <?=$annonce->html("titre") ?></h3>

        <!-- Récuperer la photo principale depuis le dossier img -->
        <?php if ($photoPrincipale): ?>
            <img
                src="img/<?= $photoPrincipale->html("fichier") ?>"
                alt="Photo de l'annonce"
                style="max-width: 400px;">
        <?php else: ?>
            <p>Aucune image disponible pour cette annonce.</p>
        <?php endif; ?>

        <!-- infos de l'annonce -->
         <p><strong>Catégorie : </strong><?= htmlspecialchars($libelleCategorie) ?></p>

        <p><strong>Description : </strong><?= $annonce->html("description") ?></p>
        <p><strong>Description : </strong><?= $annonce->html("etat") ?></p>
        <p><strong>Prix de départ : </strong><?= $annonce->html("prix_depart") ?> €</p>

        <p><strong>Date de fin : </strong><?= $annonce->html("date_fin") ?></p>
    </main>
</body>
</html> 