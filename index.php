<?php
/*

CONTROLEUR :
Rôle : afficher la page accueil principale de l'application (sans être connecté) )
paramètre : aucun

*/

// Initialisation
require_once "libr/init.php";

//Récupérer ttes les annonces
$annonce = new annonce();
$ListeAnnonces = $annonce->listAll();

//Instacier un objet api
$api = new api();

//Récupérer ttes les categories
$categories = $api->getCategoryByCurl();

/*echo "<pre>";
var_dump($categories);
echo "</pre>";*/

//message de deconnexion
$messageTimeout = "";

if (isset($_GET["timeout"])) {

    $messageTimeout = "Vous avez été déconnecté après une période d'inactivité ⏱️";
}

// Afficher le template  
require "templates/pages/afficher-accueil-principal.php";

