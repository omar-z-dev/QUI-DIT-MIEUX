<?php
/*

Rôle : afficher le détail d'une annonce et mise en forme

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
             
            </nav>
        </header>
        <main>
            <h1>Qui Dit Mieux</h1>
              <!-- message  -->
            <?php if (!empty($_SESSION["enchere"])): ?>
                <p style="color:red; font-weight:bold;"><?= $_SESSION["enchere"] ?></p>
                <?php unset($_SESSION["enchere"]); ?>
            <?php endif; ?>

            <!-------- detail de l'annonce ---------->
            <!-------- detail de l'annonce ---------->

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

            <p><strong>Description : </strong><br>
            <?= $annonce->html("description") ?></p>
            <p><strong>Etat : </strong><?= $annonce->html("etat") ?></p>
            <p><strong>Prix de départ : </strong><?= $annonce->html("prix_depart") ?> €</p>

            <p><strong>Date de fin : </strong><?= $annonce->html("date_fin") ?></p>

            
            <!-- formulaire d'enchère pour l'utilisateur connecté -->
            <!-- formulaire d'enchère pour l'utilisateur connecté -->

            <?php if (!empty($_SESSION["connected"])): ?>
                <h2>Enchérir :</h2>
                <form action="encherir.php" method="POST">

                    <input type="hidden" name="annonce_id" value="<?= $annonce->id() ?>">

                    <label for="montant">Votre enchère :</label>
                    <input
                        type="number" name="montant"
                        id="montant"
                        min="0">
                    <button type="submit">Enchérir 💰💰</button>

                </form>

                <!--------------- SUIVRE L'ANNONCE ----------------->
                <!--------------- SUIVRE L'ANNONCE ----------------->
                <h2>Suivre l'annonce :</h2>
                <form action="suivre-annonce.php" method="POST">

                    <input type="hidden" name="annonce_id" value="<?= $annonce->id() ?>">

                    <button type="submit">⭐ Suivre cette annonce
                    </button>

                </form>  
            <?php endif; ?>  
        </main>
    </body>
</html> 