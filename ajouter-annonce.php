<?php
/*
Rôle : afficher la page (formulaire) d'ajout d'annonce
paramètre : l'objet $categories : liste des categories de l'api

*/

// Initialisations diverses
require_once "libr/init.php";

//Instacier un objet api
$api = new api();

//Récupérer ttes les categories
$categories = $api->getCategoryByCurl();

/*echo "<pre>";
var_dump($categories);
echo "</pre>";*/


// Afficher le template  
require "templates/pages/afficher-ajouter-annonce.php";

