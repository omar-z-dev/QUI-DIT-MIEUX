<?php
/*

CONTROLEUR :
Rôle : Afficher le formulaire prerempli de modification d'une annonce 
paramètres :  id de l'annonce

*/

// Initialisation
require_once "libr/init.php";

// Récupération de l'id de l'annonce à modifier
$annonceId = $_GET["id"] ?? "";

// Charger l'annonce
$annonce = new annonce($annonceId);

// Vérifier s'il existe déjà une enchère
$enchere = new enchere();

$meilleureEnchere = $enchere->getMeilleureEnchere($annonceId);

if ($meilleureEnchere) {

    $_SESSION["annonce"] = 'Impossible de modifier l\'annonce " ' . $annonce->html("titre") . ' " car une enchère existe déjà ❌';

    header("Location: dashboard.php");
    exit;
}

// Catégories pour la codelist déroulante
$api = new api();
$categories = $api->getCategoryByCurl();


// Charger les photos de l'annonce à modifier
$photo = new photo();
$photos = $photo->getPhotosByAnnonce($annonceId); 

/*echo "<pre>";
var_dump($photos);
echo "</pre>";*/


// afficher la page de modification d'une annonce
require "templates/pages/afficher-modifier-annonce.php";  


