<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Qui Dit Mieux</title>
</head>
<body>

    <header>
        <h1>Accueil Qui Dit Mieux</h1>

        <!-- Navigation creation de compte et connexion -->
        <nav>
            <a href="auth.php?action=register">Créer un compte</a>
            <a href="auth.php?action=login">Connexion</a>
        </nav>
    </header>

    <main>
        <!-- Affichage les objets proposés -->
        <section>
            <h2>Objets proposés :</h2>

            <ul>
                <li>Obj 1</li>
                <li>Obj 2</li>
                <li>Obj n</li>
            </ul>
        </section>

        <!-- Formulaire de recherche -->
        <section>
            <h2>Recherche :</h2>

            <form action="recherche.php" method="GET">

                <div>
                    <label for="texte">Texte présent dans le titre ou la description :</label>
                    <input type="text" name="texte" id="texte">
                </div>

                <div>
                    <label for="categorie">Catégorie :</label>

                    <select name="categorie" id="categorie">
                        <option value="">Toutes les catégories</option>
                        <option value="informatique">Informatique</option>
                        <option value="meuble">Meuble</option>
                        <option value="vehicule">Véhicule</option>
                    </select>
                </div>

                <div>
                    <label for="etat">État de l'objet :</label>

                    <select name="etat" id="etat">
                        <option value="">Tous</option>
                        <option value="neuf">Neuf</option>
                        <option value="bon">Bon état</option>
                        <option value="use">Usé</option>
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