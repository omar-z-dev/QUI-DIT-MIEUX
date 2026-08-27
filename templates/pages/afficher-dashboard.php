<!DOCTYPE html>
<html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Dashboard - Qui Dit Mieux</title>

        <link rel="stylesheet" href="css/style.css">
    </head>

    <body>

        <!-- =========================
            HEADER
        ========================== -->
        <header>
            <!-- Navigation -->
            <nav>
                <a href="profil.php">Modifier mon profil</a>
                <a href="logout.php">Déconnexion</a>
            </nav>
        </header>

        <!-- =========================
            CONTENU PRINCIPAL
        ========================== -->
        <main>
            <h1>Qui Dit Mieux 💵💵</h1>
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

                <!-- message apres ajout d'une annonce -->
                <?php if (isset($_SESSION["success_annonce"])): ?>
                    <p style="color:green; font-weight:bold;"><?= $_SESSION["success_annonce"] ?></p>
                    <?php unset($_SESSION["success_annonce"]); ?>
                <?php endif; ?>

                <!-- message aucune annonce dispo -->    
            
                <table border="1" cellpadding="10" cellspacing="5" style="border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th>Titre</th>
                            <th>Prix de départ</th>
                            <th>Date de fin</th>
                            <th>Modifier</th>
                            <th>Supprimer</th>
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
                                    <a href="annonce.php?action=delete&id=<?= $annonce->id() ?>">
                                        Supprimer ❌
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                        <!-- Deuxième ligne : toujours affichée -->
                        <tr>
                            <td colspan="5" style="text-align: center;">
                                <a href="ajouter.php">
                                    Créer une annonce ➕
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </section>

            <!-- Mes enchères -->
            <section>
                <h2>Mes enchères 🤑🤑</h2>
                <!-- Les enchères  -->
            </section>

            <!-- Annonces suivies -->
            <section>
                <h2>Annonces suivies</h2>

                <!-- Les annonces suivies  -->
            </section>
        </main>
        <script src="js/fonctions.js"></script>

    </body>

</html>