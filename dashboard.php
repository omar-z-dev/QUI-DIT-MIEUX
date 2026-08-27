<?php
/*

Rôle : afficher la page dashboard de l'utilisateur connecté
param : néant

*/

//Initialisations diverses

require_once "libr/init.php";

//recuperer l'utilisateur connecté
$utilisateur = userConnected();

/*echo "<pre>";
var_dump($utilisateur);
echo "</pre>";*/

//instancier une annonce pour recuperer les annonces de l'utilisateur connecté
$annonce = new annonce();
$mesAnnonces = $annonce->listAll();

// Afficher le template  
require "templates/pages/afficher-dashboard.php";