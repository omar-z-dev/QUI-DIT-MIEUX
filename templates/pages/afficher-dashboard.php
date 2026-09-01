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
                
                <!-- message erreur pas acces historique encheres -->
                <?php if (isset($_SESSION["error"])): ?>
                    <p style="color:red; font-weight:bold;"><?= $_SESSION["error"] ?></p>
                    <?php unset($_SESSION["error"]); ?>
                <?php endif; ?>

                <p>
                    Gérez vos annonces, enchères et annonces suivies depuis votre espace personnel.
                </p>
            </section>

            <!------------------ Mes annonces ---------------->
            <!------------------ Mes annonces ---------------->
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
            
                <div id="bloc-mes-annonces">
                </div>
            
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
                                        <a href="detail-annonce.php?id=<?= $annonce->id() ?>">
                                        Voir detail 🧐</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php endif; ?>
                </div>
            </section>

            <h2>Rechercher une annonce 🔍</h2> 

            <!--------------- Formulaire de recherche ------------->
            <!--------------- Formulaire de recherche ------------->

            <?php require "templates/forms/formulaire-recherche.php"; ?>
    
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
                            <th>Annonce</th>
                            <th>Dernier prix proposé</th>
                            <th>Statut</th>
                            <th>Fin de l'enchère</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($annoncesEncheries as $annonceId => $annonce): ?>
                            <tr>
                                <td><?= $annonce->html("titre") ?></td>

                                <td><?= $prixCourants[$annonceId] ?> €</td>

                                <td><?= $statutsEncheres[$annonceId] ?></td>

                                <td>
                                    <?= date(
                                        "d/m/Y H:i",
                                        strtotime($annonce->value("date_fin"))
                                    ) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </section><br><br>


            <!------------ Mes enchères remportées ---------------->
            <!------------ Mes enchères remportées ---------------->

            <section>
                <h2> Mes enchères remportées 🏆</h2>

                <?php if(empty($encheresRemportees)): ?>
                    <p>Vous n'avez remporté aucune enchère.</p>
                <?php else: ?>
                    <table border="1" cellpadding="10" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Annonce</th>
                                <th>Date et heure de fin</th>
                                <th>Prix remporté</th>
                                <th>Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($encheresRemportees as $annonceId => $annonce): ?>
                                <tr>
                                    <!-- Annonce -->
                                    <td><?= $annonce->html("titre") ?></td>

                                    <!-- Date et heure de fin -->
                                    <td>
                                        <?= date(
                                            "d/m/Y H:i",
                                            strtotime($annonce->value("date_fin")))?>
                                    </td>

                                    <!-- Prix remporté -->
                                    <td><?= $prixCourants[$annonceId] ?> €</td>

                                    <!-- Statut -->
                                    <td>🏆 Remportée</td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </section><br><br>

            <!----------------- Annonces suivies -------------------->
            <!----------------- Annonces suivies -------------------->

            <div id="bloc-mes-suivis"></div>

        </main>

        <!-- js scripts-->
        <script src="js/fonctions.js"></script>

    </body>

</html>