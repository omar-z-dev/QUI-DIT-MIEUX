<?php

/* 

TEMPLATE : 

Rôle : afficher la table des annonces de l'utilisateur connecté

Paramètres : $mesAnnonces : annonces de l'utilisateur connecté
$derniersPrix : dernier prix de chaque annonce
$statuts : statut de chaque annonce

*/
/** @var array $mesAnnonces */
/** @var array $derniersPrix */
/** @var array $statuts */

?>

<table border="1" cellpadding="10" cellspacing="5" style="border-collapse: collapse;">
<thead>
    <tr>
        <th>Titre</th>
        <th>Dernier prix proposé</th>
        <th>Date de fin</th>
        <th>Statut</th>
        <th>Modifier</th>
        <th>Supprimer</th>
        <th>Voir</th>
    </tr>
</thead>

<tbody>
    <?php if (empty($mesAnnonces)): ?>
        <!-- Première ligne : aucune annonce -->
        <tr>
            <td colspan="5" style="text-align: center;">
                Vous n'avez aucune annonce.
            </td>
        </tr>
    <?php else: ?>

        <?php foreach ($mesAnnonces as $annonce): ?>
            <tr>
                <td><?= $annonce->html("titre") ?>
                </td>
                <td><?=htmlspecialchars($derniersPrix[$annonce->id()]) ?> €
                </td>
                <td><?= $annonce->html("date_fin") ?>
                </td>
                <td>
                    <?= htmlspecialchars($statuts[$annonce->id()]) ?>
                </td>
                <td>
                    <a href="modifier-annonce.php?&id=<?= $annonce->id() ?>">
                    Modifier 📝</a>
                </td>
                <td>
                    <a href="supprimer-annonce.php?&id=<?= $annonce->id() ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette annonce ?');">
                    Supprimer ❌</a>
                </td>
                <td>
                    <a href="detail-annonce.php?id=<?= $annonce->id() ?>">
                    Voir detail 🧐</a>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    <!-- Deuxième ligne : toujours affichée -->
    <tr>
        <td colspan="5" style="text-align: center;">
            <a href="ajouter-annonce.php">
            Créer une annonce ➕</a>
        </td>
    </tr>
</tbody>
</table>