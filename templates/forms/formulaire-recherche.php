<?php
/*

TEMPLATE :
Rôle : afficher le formulaire de recherche des annonces
Paramètres : aucun

*/
?>

<h3>Rechercher une annonce :</h3>

<p>Vous pouvez rechercher une annonce selon plusieurs critères en remplissant le formulaire ci-dessous</p>

<form action="rechercher-annonces.php" method="GET">

    <div>
        <label for="texte">Texte présent dans le titre ou la description :</label>
        <input type="text" name="texte" id="texte">
    </div>

    <!--catégories-->
    <div>
        <label for="recherche_categorie">Catégorie :</label>

        <input type="text" name="recherche_categorie"
            id="recherche_categorie" placeholder="Exemple : jeu vidéo">
    </div>

    <div>
        <label for="etat">État de l'objet :</label>

        <select name="etat" id="etat">
            <option value="">-- Choisir un état --</option>
            <option value="">Tous</option>
            <option value="Neuf">Neuf</option>
            <option value="Très bon état">Très bon état</option>
            <option value="Bon état">Bon état</option>
            <option value="état correct">état correct</option>
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
</form><br><br>