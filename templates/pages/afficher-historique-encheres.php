<?php
/*
TEMPLATE :
Rôle : afficher l'historique des enchères
*/

/** @var array $ListeEncheres */
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Historique des enchères</title>
</head>

<body>
    <main>
        <h1>Historique des enchères</h1>

        <?php if(empty($ListeEncheres)): ?>
            <p>Aucune enchère pour cette annonce.</p>
        <?php else: ?>
            <table border="1" cellpadding="10">
                <thead>
                    <tr>
                        <th>Enchérisseur</th>
                        <th>Montant</th>
                        <th>Date de l'enchère</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach($ListeEncheres as $uneEnchere): ?>
                        <?php
                        // Récupérer l'utilisateur (Objet utilisateur chargé) qui a fait l'enchère
                        $encherisseur = $uneEnchere->get("utilisateur_id");
                        ?>

                        <tr>
                            <!-- Pseudo de l'enchérisseur -->
                            <td><?= $encherisseur->html("pseudo") ?></td>

                            <!-- Montant -->
                            <td><?= $uneEnchere->html("montant") ?> €</td>

                            <!-- Date -->
                            <td>
                                <?= date(
                                    "d/m/Y à H:i",
                                    strtotime($uneEnchere->value("date_enchere")))?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

        <br>

        <!-- Retour -->
        <a href="dashboard.php">↩️ Retour au dashboard</a>
    </main>
</body>
</html>