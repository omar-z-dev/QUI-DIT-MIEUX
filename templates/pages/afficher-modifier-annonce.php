<?php
/*
Rôle : afficher le formulaire de modification d'une annonce

Paramètres :
- $annonce : annonce à modifier
- $categories : catégories provenant de l'API
- $photos : photos actuelles de l'annonce
*/
?>

<!DOCTYPE html>
<html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Modifier une annonce - QuiDitMieux</title>

        <link rel="stylesheet" href="css/style.css">
    </head>

    <body>
        <header>
            <nav>
                <a href="dashboard.php">Mon Dashboard</a>
                <a href="logout.php">Me déconnecter</a>
            </nav>
        </header>

        <main>
            <h1>QuiDitMieux</h1>

            <h2>Modifier l'annonce</h2>
            <!-- MESSAGE ERREUR -->

            <?php if (!empty($_SESSION["error_annonce"])): ?>

                <p style="color:red; font-weight:bold;">
                    <?= $_SESSION["error_annonce"] ?></p>

                <?php unset($_SESSION["error_annonce"]); ?>

            <?php endif; ?>

            <form action="modifier-annonce.php"  method="POST" enctype="multipart/form-data">
                <!-- ID DE L'ANNONCE -->
                <input  type="hidden" name="annonce_id" value="<?= $annonce->id() ?>">

                <!-- TITRE -->
                <div>
                    <label for="titre">Titre :</label>

                    <input  type="text" name="titre"  id="titre" value="<?= $annonce->html("titre") ?>">
                </div>
                <!-- CATÉGORIE -->
                <div>

                    <label for="categorie">Catégorie :</label>
                    <select name="categorie" id="categorie">
                        <option value="">-- Choisir une catégorie --</option>

                        <?php foreach ($categories as $code => $libelle): ?>

                            <option
                                value="<?= htmlspecialchars($code) ?>"

                                <?php if ($code == $annonce->value("categorie")): ?>
                                    selected
                                <?php endif; ?> >

                                <?= htmlspecialchars($libelle) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- DESCRIPTION -->
                <div>
                    <label for="description">Description :</label>
                    <textarea name="description" id="description"
                        rows="5" ><?= $annonce->html("description") ?></textarea>
                </div>

                <!-- ÉTAT -->
                <div>
                    <label for="etat">État de l'objet :</label>

                    <select name="etat" id="etat">

                        <option value="">-- Choisir un état --</option>
                        <option
                            value="Neuf" <?= $annonce->value("etat") === "Neuf" ? "selected" : "" ?>>Neuf
                        </option>

                        <option
                            value="Très bon état"
                            <?= $annonce->value("etat") === "Très bon état" ? "selected" : "" ?>>Très bon état
                        </option>

                        <option
                            value="Bon état"
                            <?= $annonce->value("etat") === "Bon état" ? "selected" : "" ?> >Bon état
                        </option>

                        <option
                            value="État correct"
                            <?= $annonce->value("etat") === "État correct" ? "selected" : "" ?>>État correct
                        </option>

                    </select>

                </div>
                <!-- PRIX -->
                <div>
                    <label for="prix_depart"> Prix de départ :</label>
                    <input
                        type="number" name="prix_depart" id="prix_depart"
                        min="0" value="<?= $annonce->html("prix_depart") ?>" > €
                </div>

                <!-- DATE FIN -->

                <div>

                    <label for="date_fin"> Date de fin de l'enchère :</label>
                    <input
                        type="datetime-local" name="date_fin" id="date_fin"
                        value="<?= date("Y-m-d\TH:i",
                            strtotime($annonce->value("date_fin"))) ?>" >
                </div>

                <!-- PHOTOS ACTUELLES -->

                <div>
                    <p>Photo(s) actuelle(s) :</p>
                    <?php if (!empty($photos)): ?>

                        <?php foreach ($photos as $photo): ?>
                            <img
                                src="img/<?= $photo->html("fichier") ?>"
                                alt="Photo de l'annonce"
                                style="max-width:150px;">
                        <?php endforeach; ?>

                    <?php else: ?>
                        <p>Aucune photo actuellement.</p>
                    <?php endif; ?>
                </div>

                <!-- AJOUTER DE NOUVELLES PHOTOS -->
                <div>
                    <label for="photos">Ajouter des photos :</label>
                    <input type="file" name="photos[]"
                        id="photos" multiple accept="image/jpeg,image/png,image/webp">
                </div>
                <!-- VALIDER -->
                <div>
                    <button type="submit">Valider les modifications ✔️
                    </button>
                </div>
            </form>
            <a href="dashboard.php">↩️ Retour</a>
        </main>
    </body>
</html>