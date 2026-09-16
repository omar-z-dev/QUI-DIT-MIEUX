<?php
/*

TEMPLATE :
Rôle : afficher les annonces trouvées par la recherche

Paramètres :
- $ListeAnnonces : annonces trouvées par la recherche
- $categories : objet catégories trouvées par l'API

*/
/** @var array $ListeAnnonces */
/** @var object $categories */
/** @var array $photosPrincipales */
/** @var array $prixCourants */


?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Résultats de recherche - QuiDitMieux</title>
</head>

<body>
    <header>
        <nav>
            <a href="auth.php?action=register">Créer un compte</a>
            <a href="auth.php?action=login">Me connecter</a>
        </nav>
    </header>

    <main>
        <h1>Résultats de la recherche 🔎</h1>

        <?php if (empty($ListeAnnonces)): ?>
            <p>Aucune annonce trouvée.</p>
        <?php else: ?>
            <div class="allcards">
                <?php foreach ($ListeAnnonces as $annonce): ?>

                    <div class="card-annonce">

                        <!-- image principale -->
                        <?php if($photosPrincipales[$annonce->id()]): ?>

                            <!-- RECUP LOBJET PHOTO PRINCIPALE puis acceder a la valeur de fichier -->
                            <img
                                src="img/<?= $photosPrincipales[$annonce->id()]->html("fichier") ?>"
                                alt="<?= $annonce->html("titre") ?>"
                                class="image-annonce">

                            <?php else: ?>
                                <div class="sans-image">📷 Aucune image</div>

                        <?php endif; ?>

                        <!-- titre -->
                        <h2><?= $annonce->html("titre") ?></h2>

                        <!-- prix courant -->
                        <p class="prix">💰 Prix actuel :  <strong><?= htmlspecialchars($prixCourants[$annonce->id()]) ?> €</strong></p>


                        <!-- date de fin -->
                        <p>📅 Fin :<?= date("d/m/Y à H:i",strtotime($annonce->value("date_fin"))) ?></p>

                        <!-- voir detail -->
                        <a
                            href="detail-annonce.php?id=<?= $annonce->id() ?>"
                            class="btn-detail"> Voir l'annonce 🧐</a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <br>
        <a href="index.php">
            ↩️ Retour
        </a>

    </main>

</body>

</html>