<?php
//role : fermer la session et rediriger vers la page d'accueil

// deconnecter l'utilisateur

deconnect();

//debug
/*echo "<pre>"; echo "session ds logout doit etre vide: ";
print_r($_SESSION);
echo "</pre>";*/

//var_dump(isConnected());

// Afficher le template  
require "accueil.php";

