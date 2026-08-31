<?php
/*

TEMPLATE:
Rôle : afficher la page accueil principale de l'application (sans être connecté)

Paramètres : $ListeAnnonces pour afficher les annonces des utilisateurs

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
        <!-- Navigation creation de compte et connexion -->
        <nav>
            <a href="auth.php?action=register">Créer un compte</a>
            <a href="auth.php?action=login">Me connecter</a>
        </nav>
    </header>

    <main>
        <h1> Bienvenue sur QuiDitMieux  💵💵 </h1>
        <h2>Accueil publique</h2>
        <!-------- message de deconexion  ------->
        <?php if (!empty($messageTimeout)): ?>
            <p style="color:red; font-weight:bold;">
                <?= $messageTimeout ?>
            </p>
        <?php endif; ?>
        <p>
            Nous sommes QuiDitMieux, une plateforme d’enchères entre particulier permettant aux utilisateurs de vendre et acheter des objets.<br><br>

            Pour proposer, encherir ou suivre une annonce, il faut <strong>s'inscrire</strong> ou <strong>se connecter</strong>.
        </p><br>

        <!-- Affichage des objets proposés -->
        <section>
            <h3>Liste des objets proposés :</h3>
            <p>Voici la liste des annonces proposées par les utilisateurs de la plateforme</p>
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
                                    <!--si le champ est un lien alors il retourne l'objet lié -->
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

        <!-- Formulaire de recherche -->
        <?php require "templates/forms/formulaire-recherche.php"; ?>
        
    </main>
</body>
</html>