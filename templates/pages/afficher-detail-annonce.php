<?php
/*

Rôle : afficher le détail d'une annonce et mise en forme

Paramètres : id de l'annonce

*/

/** @var photo $photoPrincipale */
/** @var string $libelleCategorie */
/** @var object $meilleureEnchere */
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
            <h1>QuiDitMieux</h1>

            <!-- message lié aux encheres -->
            <?php if (!empty($_SESSION["enchere"])): ?>
                <p style="color:red; font-weight:bold;"><?= $_SESSION["enchere"] ?></p>
                <?php unset($_SESSION["enchere"]); ?>
            <?php endif; ?>

            <!-- message lié aux suivi -->
            <?php if (!empty($_SESSION["suivi"])): ?>
                <p style="color:red; font-weight:bold;"><?= $_SESSION["suivi"] ?></p>
                <?php unset($_SESSION["suivi"]); ?>
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

            <p><strong>Description : </strong><br><br>
            <?= $annonce->html("description") ?></p>
            <p><strong>Etat : </strong><?= $annonce->html("etat") ?></p>
            <p><strong>Prix de départ : </strong><?= $annonce->html("prix_depart") ?> €</p>

            <p><strong>Date de fin : </strong><?= $annonce->html("date_fin") ?></p>


            <!-- Infos enchere sur l'annonce -->
             <h2>Enchère sur l'annonce :</h2>
            <?php if ($meilleureEnchere): ?>

                <p>
                    <strong>Meilleure enchère actuelle :</strong>
                    <?= $meilleureEnchere->html("montant") ?> €
                </p>
            <?php else: ?>

                <p>
                    <strong>Prix actuel :</strong>
                    <?= $annonce->html("prix_depart") ?> €
                </p>
                <p>Aucune enchère pour le moment.</p>

            <?php endif; ?>

            <!-- formulaire d'enchère pour l'utilisateur connecté -->
            <!-- formulaire d'enchère pour l'utilisateur connecté -->

            <?php if (!empty($_SESSION["connected"]) && $_SESSION["id"] != $annonce->value("utilisateur_id")): ?>
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

                    <!----- Affichage conditionnel du bouton ----->
                    <?php if ($estSuivie): ?>
                        <button type="button" disabled>
                            ⭐ Déjà suivie
                        </button>
                    <?php else: ?>
                        <button type="submit">
                            ⭐ Suivre cette annonce
                        </button>
                    <?php endif; ?>

                </form>  
                
            <?php endif; ?> 

            <!---------retour------------->

            <?php if (!empty($_SESSION["connected"])): ?>
                <a href="dashboard.php">↩️ Retour</a>
            <?php else: ?>
                <a href="index.php">↩️ Retour</a>
            <?php endif; ?> 

        </main>
    </body>
</html> 