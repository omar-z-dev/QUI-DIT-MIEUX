
   <!-- colonne de discussion-->

    <!--Template de fragment : mise en page de la conversation entre deux utilisateurs-->

    <?php 
        // verifier quel utilisateur est connecte (artiste ou organisateur) 
        $idConversation = $_GET["id"];

        $utilisateurConv = new utilisateur();
        $utilisateurConv->load($idConversation);

        if ($utilisateurConv->get("role") == "artiste") {

            $userConvDetail = new artiste();
            $userConvDetail->load($idConversation);

            $nom = $userConvDetail->get("nom_scene");

        } else {

            $userConvDetail = new organisateur();
            $userConvDetail->load($idConversation);

            $nom = $userConvDetail->get("nom");
        }

    ?>

    <h3>Discussion avec <?= htmlspecialchars($nom) ?></h3>

    <div class="conversation">
        
        <?php foreach($result as $message): ?>

            <!-- calcule heure miniute et affiche heure minute pour chaque message-->
            <?php $date = $message-> value("date_msg"); 
               $hourMinute =date("H:i", strtotime($date));
            ?>

            <!-- afficher message de l'utilisateur 1  -->
            <!------------------------------------------>

            <?php if($message-> value("expediteur") == $_SESSION["id"]): ?>
                
                <div class ="message-me">

                    <?= $message-> value("contenu") ?>
                    <div class ="hour-minute"><?= $hourMinute ?></div>
                    <!--<div class ="hour-minute"><?=$message->value("date_msg")?></div>-->

                </div>

            <!-- afficher message de l'utilisateur 2   -->
            <!------------------------------------------>

            <?php else: ?>

                <div  class ="message-him">

                    <?= $message-> value("contenu") ?>
                    <div class ="hour-minute"><?= $hourMinute ?></div>
                    <!--<div class ="hour-minute"><?=$message->value("date")?></div>-->

                </div>

            <?php endif; ?>
        <?php endforeach; ?>
    </div>     

    <!-- envoie message pour l'utilisateur de la conversation en cours-->

    <form id="message-a-saisir">
        <!-- zone message a saisir  colonne de discussion-->
        <textarea id ="ecrire-message" name="message" rows="4" cols="40" placeholder="Écrivez votre message"></textarea>
        <br>

        <input type="hidden" name="id" value="<?= $userConvDetail->id() ?>">
        
        <!-- bouton envoyer -->
        <button id="envoyer" type="submit">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
            <path d="M536.4-26.3c9.8-3.5 20.6-1 28 6.3s9.8 18.2 6.3 28l-178 496.9c-5 13.9-18.1 23.1-32.8 23.1-14.2 0-27-8.6-32.3-21.7l-64.2-158c-4.5-11-2.5-23.6 5.2-32.6l94.5-112.4c5.1-6.1 4.7-15-.9-20.6s-14.6-6-20.6-.9L229.2 276.1c-9.1 7.6-21.6 9.6-32.6 5.2L38.1 216.8c-13.1-5.3-21.7-18.1-21.7-32.3 0-14.7 9.2-27.8 23.1-32.8l496.9-178z"/></svg>
        </button>
    </form>


