<?php
 /*

 TEMPLATE :
 Rôle : afficher les annonces trouvées par la recherche

 Paramètres : $ListeAnnonces : annonces trouvées par la recherche
              $categories : Objet catégories trouvées par l'API
             
 */
/** @var array $ListeAnnonces */
/** @var object  $categories */

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Qui Dit Mieux</title>
</head>
<body>
    <header>
        <nav>
            <a href="auth.php?action=register">Créer un compte</a>
            <a href="auth.php?action=login">Me connecter</a>
        </nav>
    </header>
    <main>
        <h1>Resultats de la recherche</h1>
        <table border="1" cellpadding="10" cellspacing="5" style="border-collapse: collapse;">
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Description</th>
                    <th>Catégorie</th>
                    <th>Montant</th>
                    <th>Etat</th>
                   
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ListeAnnonces as $annonce) : ?>
                    <tr>
                        <td><?= $annonce->html("titre") ?></td>
                        <td><?= $annonce->html("description") ?></td>
                        <td> <?= htmlspecialchars(
                                            $categories->{$annonce->value("categorie")}
                                        ) ?>
                                    </td>
                        <td><?= $annonce->html("prix_depart") ?> €</td>
                        <td><?= $annonce->html("etat") ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="index.php">↩️ Retour</a>
    </main>
</body>
</html>
