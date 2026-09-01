<?php

/*

CONTROLEUR :

Rôle : afficher la page permettant à l'utilisateur connecté
       de modifier son pseudo et son email

Paramètres : aucun

*/

// Initialisation
require_once "libr/init.php";

// Connexion requise
require "libr/require_login.php";

// Récupérer l'utilisateur connecté
$utilisateur = userConnected();

// Afficher le template
require "templates/pages/afficher-modifier-profil.php";