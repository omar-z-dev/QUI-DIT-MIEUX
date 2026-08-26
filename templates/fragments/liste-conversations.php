 <!-- afficher la liste des conversations -->


<?php 
// parcourir le tableau des conversations de l'utilisateur connecté
foreach ($listeConversations as $conv): 
    
    // recuperer le nombre de messages non lus
    $messageLu = new message_lu();
    $nbUnread = $messageLu->countUnread($_SESSION["id"] , $conv["id"]);
    ?>
    

    <?php
        // afficher la date en :  par exemple 31/05/2026
        $date = $conv["date"];
        $dateFormatee = date("d/m/Y", strtotime($date));
    ?>

    <li>
        <div
            onclick="detailConversation(<?= $conv['id'] ?>)"
            style="cursor:pointer;color:green;font-weight:bold;">

            <?= htmlspecialchars($conv["nom"]) ?>
        
            
            <?php if($nbUnread > 0): 

                // afficher le nombre de messages non lus?>

                <div class = "nb-non-lus">
                    <?= $nbUnread ?>
                </div>
            <?php endif; ?>


            <!-- afficher la date du dernier message échangé -->
            <span class = "date-in-last-msg"><?= $dateFormatee ?>
            </span>


            <!-- afficher le dernier message de la conversation -->
            
            <div class = "last-msg" style="color:gray ; font: weight 10px; font-size: 13px;">
                <?php
                    $contenu = $conv["dernier_message"];
                    if (strlen($contenu) > 40) {
                    // recup 40 premiers caracteres du message et ajouter "..." à la fin
                    $contenu = substr($contenu, 0, 40) . " ...";
                    }
                ?>
                <?= $contenu ?>

                <div class="heure-msg">
                    <?= 
                    // afficher l'heure du dernier message échangé
                    date("H:i", strtotime($conv["date"])) ?>
                </div>
            </div>
        </div>
        
        <!-- bouton archiver conversation -->   
        <button 
            class ="btn-archiver" onclick="archiverConversation(<?= $conv['conversation_id'] ?>)">
            Archiver
        </button>
    </li>
<?php endforeach; ?>