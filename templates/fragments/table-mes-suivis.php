<?php

/* 

TEMPLATE : 

Rôle : afficher la table des annonces suivis de l'utilisateur connecté

Paramètres : 
$annonces 
$mesSuivis
$vendeurs
$nombreEncheres
$prixCourantsAll

*/
/** @var array $categories */
/** @var array $annonces */
/** @var array $mesSuivis */
/** @var array $vendeurs */
/** @var array $nombreEncheres */
/** @var array $prixCourantsAll */

?>
<section>
    <h2>Mes annonces suivies 👣</h2>
    <p>Retrouvez ici toutes les annonces que vous avez choisi de suivre. Consultez leur évolution, le prix actuel, le nombre d'enchères et la date de fin, puis accédez rapidement au détail de chaque annonce. Si vous avez participé aux enchères d'une annonce, vous pouvez également consulter l'historique des enchères.</p>

    <?php if(empty($mesSuivis)): ?>
        <p>Vous ne suivez aucune annonce.</p>
    <?php else: ?>
        <table border="1" cellpadding="10" cellspacing="0">
            <thead>
                <tr>
                    <th>Vendeur</th>
                    <th>Titre de l'annonce</th>
                    <th>Nombre d'enchères</th>
                    <th>Prix courant</th>
                    <th>Date et heure de fin</th>
                    <th>Détail</th>
                    <th>Historique</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($mesSuivis as $suivi): ?>
                    
                    <!-- On recupere l'objet annonce -->
                    <?php $annonce = $suivi->get("annonce_id"); 
                    $annonceId = $annonce->id();
                    ?>
                    <tr>
                        <!-- Vendeur -->
                        <td>
                            <?=htmlspecialchars( $vendeurs[$annonceId] )?>
                        </td>

                        <!-- Titre de l'annonce -->
                        <td><?= $annonce->html("titre") ?>
                        </td>

                        <!-- Nombre d'enchères -->
                        <td>
                            <?= htmlspecialchars($nombreEncheres[$annonceId]) ?>
                        </td>

                        <!-- Prix courant -->
                        <td> Prix courant :
                            <?= htmlspecialchars($prixCourantsAll[$annonceId]) ?> €
                        </td>
                            
                        <!-- Date heure de fin -->
                        <td> <?= date("Y-m-d à H:i", strtotime($annonce->value("date_fin"))) ?>
                        </td>

                        <!-- Voir l'annonce -->
                        <td>
                            <a href="detail-annonce.php?id=<?= $annonce->id() ?>">
                            Voir l'annonce 🧐</a>
                        </td>

                        <!--Voir historique des encheres-->
                        <td>
                            <a href="historique-encheres.php?id=<?= $annonce->id() ?>">
                            Voir historique des encheres 🧐</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</section>