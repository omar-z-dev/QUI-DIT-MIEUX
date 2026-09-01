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

/*=======================================================
Récupérer les annonces suivi  de l'utilisateur connecté
========================================================*/
$suivi     = new suivi();
$mesSuivis = $suivi->getSuivisByUtilisateur($utilisateur->id()
);

// tableaux de donnees pour les afficher sur la page dashboard
$prixCourantsAll     = [];
$nombreEncheres      = [];
$vendeurs            = [];
$historiquesEncheres = [];


// Parcourir chaque suivi
foreach ($mesSuivis as $unSuivi) {
    //Récuperer l'annonce suivie
    $annonceSuivie = $unSuivi->get("annonce_id");

    // ID de cette annonce
    $annonceId = $annonceSuivie->id();

    // Déterminer le prix courant

    $meilleureEnchere = $enchere->getMeilleureEnchere($annonceId);

    /*S'il existe une enchère*/
    if ($meilleureEnchere) {

        /*Le prix courant = meilleure enchère*/
        $prixCourantsAll[$annonceId] = $meilleureEnchere->value("montant");
    } else {

        /*Sinon = prix de départ*/
        $prixCourantsAll[$annonceId] = $annonceSuivie->value("prix_depart");
    }

    // nombre d'enchères
    $nombreEncheres[$annonceId] = $enchere->countEncheresByAnnonce($annonceId);

    // vendeur : recuperer lobjet utilisateur d'un ID donné
    $vendeur = $annonceSuivie->get("utilisateur_id");

    // Stocker son pseudo
    $vendeurs[$annonceId] = $vendeur->value("pseudo");

    // Stocker l'historique des encheres
    $historiquesEncheres[$annonceId] = $enchere->getEncheresByAnnonce($annonceId);


}


//Afficher le template afficher dashboard (page dashboard de l'utilisateur connecté)  
require "templates/pages/afficher-dashboard.php";