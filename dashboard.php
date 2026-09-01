<?php
/*

CONTROLEUR :
Rôle : afficher la page dashboard de l'utilisateur connecté
param : néant

*/

//Initialisations diverses
require_once "libr/init.php";

//Charger l'utilisateur connecté
$utilisateur = userConnected();

/*================================================================
Récupérer de toutes les annonces sauf celles de l'utilisateur connecté
==================================================================*/
$annonce = new annonce();
$ListeAnnonces = $annonce->listOtherAnnonces($utilisateur->id());


/*==============================================
Récupérer les enchères de l'utilisateur connecté
================================================*/
$enchere     = new enchere();
$mesEncheres = $enchere->getEncheresByUtilisateur($utilisateur->id());


/*======================================================
Instancier un objet api pour recuperer les libellé 
des categories dans listes des autres annonces
=======================================================*/
$api = new api();

//Récupérer ttes les categories
$categories = $api->getCategoryByCurl();

/*======================================================
Récupérer les annonces suivi  de l'utilisateur connecté
======================================================*/
$suivi     = new suivi();
$mesSuivis = $suivi->getSuivisByUtilisateur($utilisateur->id()
);

//Afficher le template afficher dashboard (page dashboard de l'utilisateur connecté)  
require "templates/pages/afficher-dashboard.php";