<?php

/*

CONTROLEUR :

Rôle : afficher la page permettant à l'utilisateur connecté
       de modifier son pseudo et son email

Paramètres : aucun

*/

require_once "libr/init.php";

// Récupérer l'utilisateur connecté
$utilisateur = userConnected();

// Afficher le template
require "templates/pages/afficher-modifier-profil.php";