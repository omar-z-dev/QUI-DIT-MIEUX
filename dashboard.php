<?php
/*

CONTROLEUR :
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
$mesAnnonces = $annonce->listAllByUser($utilisateur->id());

// recup de toutes les annonces sauf celles de l'utilisateur connecté
$ListeAnnonces = $annonce->listOtherAnnonces($utilisateur->id());

//Instacier un objet api
$api = new api();

//Récupérer ttes les categories
$categories = $api->getCategoryByCurl();

// Récupérer les enchères de l'utilisateur connecté
$enchere = new enchere();

$mesEncheres = $enchere->getEncheresByUtilisateur($_SESSION["id"]
);

// Récupérer les annonces suivi  de l'utilisateur connecté
$suivi = new suivi();
$mesSuivis = $suivi->getSuivisByUtilisateur($_SESSION["id"]
);

// Afficher le template  
require "templates/pages/afficher-dashboard.php";