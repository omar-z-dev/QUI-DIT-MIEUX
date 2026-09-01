<?php

/*

CONTROLEUR :
Rôle : afficher la page voir-historique-encheres.php
param : annonce_id

*/

// Initialisation
require_once "libr/init.php";

// Récupérer l'id de l'annonce
$annonceId = $_GET["id"] ?? "";

// Instancier un objet enchere
$enchere = new enchere();
$ListeEncheres = $enchere->getEncheresByAnnonce($annonceId);


// Affichage
require_once "templates/pages/afficher-historique-encheres.php";