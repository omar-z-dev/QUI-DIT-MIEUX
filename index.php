<?php
/*

CONTROLEUR :
Rôle : afficher la page accueil principale de l'application (sans être connecté) )
paramètre : aucun

*/

// Initialisation
require_once "libr/init.php";


//Instancier un objet annonce
$annonce = new annonce();

//Récupérer ttes les annonces
$ListeAnnonces = $annonce->listAll();

//Instacier un objet api
$api = new api();

//Récupérer ttes les categories pour afficher le libellé dans le tableau de liste des objets proposé dans l'accueil publique , car dans la table annonce stocke l'id de la categorie et pas le libellé
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

