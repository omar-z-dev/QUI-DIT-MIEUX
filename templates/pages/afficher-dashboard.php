<?php
/*

Rôle : afficher la page dashboard de l'utilisateur connecté elle contient : 
- mes annonces : les annonces de l'utilisateur
- les autres annonces : les annonces des autres utilisateurs
- mes encheres : les encheres de l'utilisateur
- annonces suivies : les annonces suivies de l'utilisateur

Paramètres : $mesAnnonces : annonces de l'utilisateur connecté
             $ListeAnnonces : annonces des autres utilisateurs

*/
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
                    Gérez vos annonces et vos enchères depuis votre espace personnel.
                </p>
            </section>

            <!-- Mes annonces -->
            <section>

                <h2>Mes annonces ✅</h2>
                <p>Liste de mes annonces</p>

                <!-- message apres ajout d'une annonce -->
                <?php if (isset($_SESSION["success_annonce"])): ?>
                    <p style="color:green; font-weight:bold;"><?= $_SESSION["success_annonce"] ?></p>
                    <?php unset($_SESSION["success_annonce"]); ?>
                <?php endif; ?>

                <!--Tables des annonces -->    
            
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
                                        <a href="annonce.php?action=update&id=<?= $annonce->id() ?>">
                                            Modifier 📝
                                        </a>
                                    </td>
                                    <td>
                                        <a href="supprimer-annonce.php?&id=<?= $annonce->id() ?>">
                                            Supprimer ❌
                                        </a>
                                    </td>
                                    <td>
                                        <a href="voir-detail-annonce.php?id=<?= $annonce->id() ?>">
                                            Voir detail 🧐
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        <!-- Deuxième ligne : toujours affichée -->
                        <tr>
                            <td colspan="5" style="text-align: center;">
                                <a href="ajouter-annonce.php">
                                    Créer une annonce ➕
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </section>

            <!-- Autres annonces -->
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
                                            Voir detail 🧐
                                        </a>
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
            
            </section>


            <!-- Mes enchères -->
            <section>
                <h2>Mes enchères 🤑🤑</h2>
                <!-- Les enchères  -->
            </section>

            <!-- Annonces suivies -->
            <section>
                <h2>Annonces suivies 👣</h2>

                <!-- Les annonces suivies  -->
            </section>
        </main>
        <script src="js/fonctions.js"></script>

    </body>

</html>