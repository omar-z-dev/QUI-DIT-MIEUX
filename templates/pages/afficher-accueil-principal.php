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
        <!-- Affichage les objets proposés -->
        <section>
            <h3>Liste des objets proposés :</h3>
            <div class="liste-annonces">
                <?php if (empty($ListeAnnonces)): ?>

                    <p>Aucune annonce disponible</p>

                <?php else: ?>

                <table border="1" cellpadding="10" cellspacing="5" style="border-collapse: collapse;">
                    <thead>
                        <tr>
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
        <section>
            <h3>Rechercher une annonce :</h3>

            <form action="rechercher-annonces.php" method="GET">

                <div>
                    <label for="texte">Texte présent dans le titre ou la description :</label>
                    <input type="text" name="texte" id="texte">
                </div>

                <!--Codelist des catégories qui proviennent de l'API -->
                <div>
                    <label for="categorie">Catégorie :</label>
                    <select name="categorie" id="categorie">
                        <option value="">Toutes les catégories</option>
                        <?php foreach ($categories as $code => $libelle): ?>
                            <option value="<?= htmlspecialchars($code) ?>">
                                <?= htmlspecialchars($libelle) ?>
                            </option>

                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label for="etat">État de l'objet :</label>

                    <select name="etat" id="etat">
                        <option value="">-- Choisir un état --</option>
                        <option value="">Tous</option>
                        <option value="1">Neuf</option>
                        <option value="2">Très bon état</option>
                        <option value="3">Bon état</option>
                        <option value="4">état correct</option>
                    </select>
                </div>

                <div>
                    <label for="prix">Prix maximum :</label>
                    <input type="number" name="prix" id="prix" min="0">
                </div>

                <div>
                    <label for="vente">État de la vente :</label>
                    <select name="vente" id="vente">
                        <option value="">Toutes</option>
                        <option value="en_cours">Ventes en cours</option>
                        <option value="terminee">Ventes terminées</option>
                    </select>
                </div>
                <button type="submit">Rechercher</button>
            </form>
        </section>
    </main>
</body>
</html>