
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
          
        <div class ="container-principal">  

            <div>        
                <h2>Bienvenue sur votre dashboard <?= $user->html("pseudo") ?> 👋</h2>     
                
                <!-- formulaire ajouter une recette -->
                <div id="liste-recettes">
                    <?php require "templates/fragments/liste-recettes.php"; ?>
                </div>
                
                <div>
                    <!-- formulaire modifier une recette -->
                    <div id="modifier-recette"></div>

                    <!-- formulaire ajouter une recette -->
                    <div id="zone-ajout-recette"></div>


                    <!-- message recette existante -->
                    <div id="msg-ajout-recette"></div>

                    <!-- rechercher recette formulaire -->
                    <div>
                        <h2>🔍 Rechercher une recette</h2>

                        <form id ="searchForm">

                            <!-- titre -->
                            <label for="titre">Nom de la recette :</label><br>
                            <input type="text" name="titre" id="titre" placeholder="Ex : Crêpes"><br><br>

                            <!-- difficulté -->
                            <label for="difficulte">Difficulté :</label><br>
                            <select name="difficulte" id="difficulte">
                                <option value="">-- Toutes --</option>
                                <option value="très facile">Très facile</option>
                                <option value="facile">Facile</option>
                                <option value="difficile">Difficile</option>
                            </select><br><br>

                            <!-- durée -->
                            <label for="duree_max">Durée maximale (minutes) :</label><br>
                            <input type="number" name="duree_max" id="duree_max" min="0"><br><br>

                            <!-- farine -->
                            <label for="farine">Type de farine :</label><br>
                            
                            <!-- remplir dynamiquement depuis l api-->
                            <select name="farine" id="farine">

                                <option value="">-- Toutes les farines --</option>

                                <?php foreach ($catalogueFarines as $reference => $nom): ?>

                                    <option value="<?= $nom ?>">
                                        <?= htmlspecialchars($nom) ?>
                                    </option>

                                <?php endforeach; ?>

                            </select>

                            <br><br>

                            <button type="submit">
                                Rechercher
                            </button>

                        </form>
                        <!-- message erreur deja commenté-->
                        <?php if (!empty($_SESSION["error_note"])): ?>
                            <p style="color:red; font-weight:bold;"><?= $_SESSION["error_note"] ?></p>
                            <?php unset($_SESSION["error_note"]); ?>
                        <?php endif; ?>
                    </div>

                    <!-- affichage des recettes : -->

                    <div id="resultat-recherche-recette"></div>
                </div>
            </div>
            <div>
                <!-- affichage de mes commentaires -->
                <h2  style="color: red;"> Mes commentaires : </h2>

                <?php foreach ($mesCommentaires as $commentaire): ?>

                    <div class="bloc-commentaire">
                        <h3 style="text-decoration: underline">
                            Recette : <?= htmlspecialchars($commentaire["titre"]) ?>
                        </h3>
                        <p>
                            <?= htmlspecialchars($commentaire["commentaire"]) ?>
                        </p>
                        <p style="font-size: 12px;"><?= date("d/m/Y \à H:i", strtotime($commentaire["date_maj"])) ?></p>
                        <button>Modifier</button>
                    </div>

                <?php endforeach; ?>


                <!-- affichage de mes notes -->

                <h2 style="color: red;">Mes notes :</h2>

                <?php if (empty($mesNotes)): ?>

                    <p>Vous n'avez donné aucune note.</p>

                <?php else: ?>

                    <?php foreach ($mesNotes as $note): ?>

                        <div class="bloc-note">

                            <h3 style="text-decoration: underline">Recette : <?= htmlspecialchars($note["titre"]) ?></h3>

                            <p>Note donnée :
                                <?= htmlspecialchars($note["type"]) ?>
                            </p>

                            <p style="font-size: 12px;"><?= date("d/m/Y \à H:i", strtotime($note["date_maj"])) ?></p>

                            <button>Modifier</button>
                        </div>

                    <?php endforeach; ?>

                <?php endif; ?>

                <!--bouton de deconnexion : -->
                <div>
                    <a href="index.php?page=logout">
                        <button id="disconnect" style ="font-weight:800;padding: 10px; border-radius: 5px; cursor: pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M288 0c0-17.7-14.3-32-32-32S224-17.7 224 0l0 256c0 17.7 14.3 32 32 32s32-14.3 32-32L288 0zM146.3 98.4c14.5-10.1 18-30.1 7.9-44.6s-30.1-18-44.6-7.9C43.4 92.1 0 169 0 256 0 397.4 114.6 512 256 512S512 397.4 512 256c0-87-43.4-163.9-109.7-210.1-14.5-10.1-34.4-6.6-44.6 7.9s-6.6 34.4 7.9 44.6c49.8 34.8 82.3 92.4 82.3 157.6 0 106-86 192-192 192S64 362 64 256c0-65.2 32.5-122.9 82.3-157.6z"/></svg>
                        </button>
                    </a>
                
                </div>
            <div>
            
        </div> 


        <script src="js/fonctions.js" ></script>


    </body>
</html>
