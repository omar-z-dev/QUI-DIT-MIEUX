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
            <a href="auth.php?action=login">Connexion</a>
        </nav>
    </header>

    <main>
        <h1> Bienvenue sur Qui Dit Mieux</h1>
        <h2>Accueil publique</h2>
        <!-- Affichage les objets proposés -->
        <section>

            <h3>Liste des objets proposés :</h3>
            <?php if (empty($ListeAnnonces)): ?>

                <p>Aucune annonce disponible</p>

            <?php else: ?>

            <table border="1" cellpadding="10" cellspacing="5" style="border-collapse: collapse;">
                <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Catégorie</th>
                        <th>Description</th>
                        <th>État</th>
                        <th>Prix de départ</th>
                        <th>Date de fin</th>
                        <th>Date de création</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($ListeAnnonces as $annonce): ?>
                        <tr>
                            <td><?= $annonce->html("titre") ?>
                            </td>
                            <td><?= $annonce->html("categorie_id") ?>
                            </td>
                            <td><?= $annonce->html("description") ?>
                            </td>
                            <td><?= $annonce->html("etat") ?>
                            </td>
                            <td><?= $annonce->html("prix_depart") ?> €
                            </td>
                            <td><?= $annonce->html("date_fin") ?>
                            </td>
                            <td><?= $annonce->html("date_creation") ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>
        </section>

        <!-- Formulaire de recherche -->
        <section>
            <h3>Rechercher une annonce :</h3>

            <form action="recherche.php" method="GET">

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
                    <input type="number" name="prix" id="prix" min="0" step="0.01">
                </div>

                <div>
                    <label for="vente">État de la vente :</label>
                    <select name="vente" id="vente">
                        <option value="">Toutes</option>
                        <option value="en_cours">Ventes en cours</option>
                        <option value="terminee">Ventes terminées</option>
                    </select>
                </div>
                <button type="submit">Valider</button>
            </form>
        </section>
    </main>
</body>
</html>