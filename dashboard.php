<?php
/*

Rôle : afficher la page dashboard
param : neant

*/

//Initialisations diverses

require_once "libr/init.php";

//recuperer l'utilisateur connecté
$utilisateur = userConnected();

/*echo "<pre>";
var_dump($utilisateur);
echo "</pre>";*/

//instanceoftier une annonce pour recuperer les annonces de l'utilisateur connecté
$annonce = new annonce();
$mesAnnonces = $annonce->listAll();

// Afficher le template  
require "templates/pages/afficher-dashboard.php";