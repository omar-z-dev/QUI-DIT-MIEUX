<?php
/*

TEMPLATE :
Rôle : afficher la page dashboard de l'utilisateur connecté elle contient : 
- mes annonces : les annonces de l'utilisateur
- les autres annonces : les annonces des autres utilisateurs
- mes encheres : les encheres de l'utilisateur
- annonces suivies : les annonces suivies de l'utilisateur

Paramètres : $mesAnnonces : annonces de l'utilisateur connecté
             $ListeAnnonces : annonces des autres utilisateurs


*/
/** @var object $categories */

?>
<!DOCTYPE html>
<html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Dashboard-QuiDitMieux</title>

        <link rel="stylesheet" href="css/style.css">
    </head>

    <body>
        <header>
            <!-- Navigation -->
            <nav>
                <a href="profil.php">Modifier mon profil</a>
                <a href="logout.php">Me deconnecter</a>
            </nav>
        </header>
        <main>
            <h1>QuiDitMieux 💵💵</h1>
            <section>
                <h2>
                    Bienvenue sur votre dashboard
                    <?= $utilisateur->html("pseudo") ?> 👋
                </h2>
                <p>
                    Gérez vos annonces, enchères et annonces suivies depuis votre espace personnel.
                </p>
            </section>

            <!-- Mes annonces -->
            <section>

                <h2>Mes annonces ✅</h2>
                <p>Retrouvez ci-dessous la liste de vos annonces.<br><br>
                Vous pouvez modifier ou supprimer une annonce tant qu'aucune enchère n'a été enregistrée.</p>
                <p>Vous pouvez aussi ajouter une annonce en cliquant sur le bouton Créer une annonce.</p>

                <!-- message apres ajout d'une annonce -->
                <?php if (isset($_SESSION["success_annonce"])): ?>
                    <p style="color:green; font-weight:bold;"><?= $_SESSION["success_annonce"] ?></p>
                    <?php unset($_SESSION["success_annonce"]); ?>
                <?php endif; ?>

                <!-- message pour modification d'annonce -->
                <?php if (isset($_SESSION["annonce"])): ?>
                    <p style="color:red; font-weight:bold;"><?= $_SESSION["annonce"] ?></p>
                    <?php unset($_SESSION["annonce"]); ?>
                <?php endif; ?>

                <!------------Tables de mes annonces ---------->
                <!------------Tables de mes annonces ---------->    
            
                <table border="1" cellpadding="10" cellspacing="5" style="border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th>Titre</th>
                            <th>Prix de départ</th>
                            <th>Date de fin</th>
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
                                    <td><?= $annonce->html("prix_depart") ?> €
                                    </td>
                                    <td><?= $annonce->html("date_fin") ?>
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
                                        <a href="voir-detail-annonce.php?id=<?= $annonce->id() ?>">
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
            </section>

            <!----------- Liste desAutres annonces ---------->
            <!----------- Liste desAutres annonces ---------->

            <section>
                <h2>Liste des autres annonces 📋</h2>
                <p>Vous pouvez consulter le détail d'une annonce, puis enchérir ou la suivre.</p>
                <div class="liste-annonces">
                    <?php if (empty($ListeAnnonces)): ?>

                        <p>Aucune annonce disponible</p>

                    <?php else: ?>

                    <table border="1" cellpadding="10" cellspacing="5" style="border-collapse: collapse;">
                        <thead>
                            <tr>
                                <th>Propriétaire</th>
                                <th>Titre</th>
                                <th>Catégorie</th>
                                <th>Prix de départ</th>
                                <th>Date de fin</th>
                                <th>Voir l'annonce</th>
                                
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($ListeAnnonces as $annonce): ?>
                                <tr>
                                    <td>
                                        <?= $annonce->get("utilisateur_id")->html("pseudo") ?>
                                    </td>
                                    <td><?= $annonce->html("titre") ?>
                                    </td>
                                    <td> <?= htmlspecialchars(
                                            $categories->{$annonce->value("categorie")}
                                        ) ?>
                                    </td>
                                    <td><?= $annonce->html("prix_depart") ?> €
                                    </td>
                                    <td> <?= date("Y-m-d à H:i", strtotime($annonce->value("date_fin"))) ?>
                                    </td>
                                    <td>
                                        <a href="voir-detail-annonce.php?id=<?= $annonce->id() ?>">
                                        Voir detail 🧐</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php endif; ?>
                </div>
            </section>
            <section>

            <h2>Rechercher une annonce 🔍</h2> 

            <!--------------- Formulaire de recherche ------------->
            <!--------------- Formulaire de recherche ------------->

            <?php require "templates/forms/formulaire-recherche.php"; ?>
            
            </section>


            <!------------------- Mes enchères ------------------->
            <!------------------- Mes enchères ------------------->

            <section>
            <h2>Mes enchères 🤑🤑</h2>

            <?php if(empty($mesEncheres)): ?>
                <p>Vous n'avez effectué aucune enchère.</p>
            <?php else: ?>
                <table border="1" cellpadding="10" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Titre</th>
                            <th>Montant</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($mesEncheres as $enchere): ?>
                            <?php $annonce = $enchere->get("annonce_id"); ?>
                            <tr>
                                <td><?= $annonce->html("titre") ?></td>
                                <td><?= $enchere->html("montant") ?> €</td>
                                <td><?= $enchere->html("date_enchere") ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </section>

            <!----------------- Annonces suivies -------------------->
            <!----------------- Annonces suivies -------------------->

            <section>
                <h2>Mes annonces suivies 👣</h2>

                <?php if(empty($mesSuivis)): ?>
                    <p>Vous ne suivez aucune annonce.</p>
                <?php else: ?>
                    <table border="1" cellpadding="10" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Titre de l'annonce</th>
                                <th>Détail</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($mesSuivis as $suivi): ?>
                                <!-- On recupere l'objet annonce -->
                                <?php $annonce = $suivi->get("annonce_id"); ?>
                                <tr>
                                    <td><?= $annonce->html("titre") ?></td>
                                    <td>
                                        <a href="voir-detail-annonce.php?id=<?= $annonce->id() ?>">
                                            Voir l'annonce 🧐
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </section>
        </main>
        <script src="js/fonctions.js"></script>

    </body>

</html>