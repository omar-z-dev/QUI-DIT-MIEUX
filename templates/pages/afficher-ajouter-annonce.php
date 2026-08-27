<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer une annonce - Qui Dit Mieux</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <nav>
            <a href="dashboard.php">Mon Dashboard</a>

            <a href="logout.php">
                Déconnexion
            </a>
        </nav>
    </header>
    <main>
        <h1>Qui Dit Mieux</h1>
        <h2>Créer une annonce</h2>
        <!-- message d'erreur -->
        <?php if (!empty($_SESSION["error_annonce"])): ?>
            <p style="color:red; font-weight:bold;"><?= $_SESSION["error_annonce"] ?></p>
            <?php unset($_SESSION["error_annonce"]); ?>
        <?php endif; ?>

        <!-- FORMULAIRE D'AJOUT D'UNE ANNONCE -->

        <form action="valider-ajout-annonce.php"method="POST"  enctype="multipart/form-data">
            <!-- Titre -->
            <div>
                <label for="titre">Titre :</label>
                <input type="text" name="titre" id="titre">
            </div>
            <!-- Catégorie -->
            <div>
                <label for="categorie">Catégorie :</label>
                <select name="categorie" id="categorie">
                    <option value="">-- Choisir une catégorie --</option>
                        <?php foreach ($categories as $code => $libelle): ?>
                            <option value="<?= htmlspecialchars($code) ?>">
                                <?= htmlspecialchars($libelle) ?>
                            </option>

                        <?php endforeach; ?>
                </select>
            </div>
            <!-- Description -->
            <div>
                <label for="description">Description :</label>
                <textarea name="description" id="description" rows="5"
                ></textarea>
            </div>
            <!-- État -->
            <div>
                <label for="etat">État de l'objet :</label>
                <select name="etat" id="etat">
                    <option value="">-- Choisir un état --</option>
                    <option value="1">Neuf</option>
                    <option value="2">Très bon état</option>
                    <option value="3">Bon état</option>
                    <option value="4">état correct</option>
                </select>
            </div>
            <!-- Prix de départ -->
            <div>
                <label for="prix_depart">Prix de départ :</label>
                <input type="number" name="prix_depart" id="prix_depart" min="0"
                >€
            </div>
            <!-- Date de fin -->
            <div>
                <label for="date_fin">Date de fin de l'enchère :</label>
                <input type="datetime-local" name="date_fin" id="date_fin">
            </div>
            <!-- Photo -->
            <div>
                <label for="photo">Photo :</label>
                <input type="file" name="photo" id="photo">
            </div>
            <!-- Validation button -->
            <div>
                <button type="submit">Valider ✔️</button>
            </div>
        </form>
        <!-- bouton retour accueil principal -->
        <a href="dashboard.php"> ↩️ Retour</a>
    </main>
</body>

</html>