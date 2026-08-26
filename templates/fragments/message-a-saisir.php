<?php
// fgragment de template : mise en page du formulaire d'envoi d'un message à un artiste

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>
    <body>
        
        <form id="message-a-saisir-select">

            <h2>Ecrire un message à <span style="color: #3f6325;"><?= htmlspecialchars($nom) ?></span></h2>

            <textarea id ="ecrire-message2" name="message" rows="4" cols="50" placeholder="Écrivez votre message"></textarea>
            <br>

            <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">


            <button id ="envoyer" type="submit">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                <path d="M536.4-26.3c9.8-3.5 20.6-1 28 6.3s9.8 18.2 6.3 28l-178 496.9c-5 13.9-18.1 23.1-32.8 23.1-14.2 0-27-8.6-32.3-21.7l-64.2-158c-4.5-11-2.5-23.6 5.2-32.6l94.5-112.4c5.1-6.1 4.7-15-.9-20.6s-14.6-6-20.6-.9L229.2 276.1c-9.1 7.6-21.6 9.6-32.6 5.2L38.1 216.8c-13.1-5.3-21.7-18.1-21.7-32.3 0-14.7 9.2-27.8 23.1-32.8l496.9-178z"/></svg>
            </button>

        </form>
    </body>
</html>