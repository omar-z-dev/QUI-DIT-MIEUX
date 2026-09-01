<?php
/*

CONTROLEUR :
Rôle : déconnecter l'utilisateur connecté et rediriger vers la page d'accueil
paramètres : aucun

*/

// Initialisation
require_once "libr/init.php";

// deconnecter l'utilisateur
deconnect();

//debug
/*echo "<pre>"; echo "session ds logout doit etre vide: ";
print_r($_SESSION);
echo "</pre>";*/

//var_dump(isConnected());

// Retour a l'accueil  
header("Location: index.php");
exit;

