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


/*========================================================
    Récupérer les enchères de l'utilisateur connecté
==========================================================*/

$enchere     = new enchere();
$mesEncheres = $enchere->getEncheresByUtilisateur($utilisateur->id());

//Initialiser les tableaux
$prixCourants       = [];
$statutsEncheres    = [];
$annoncesEncheries  = [];
$encheresRemportees = [];

// Parcourir chaque enchère
foreach($mesEncheres as $uneEnchere){

    // Récupérer l'objet annonce liée à l'enchère
    $annonce   = $uneEnchere->get("annonce_id");

    // ID de cette annonce
    $annonceId = $annonce->id();

    // Éviter les doublons
    if(isset($annoncesEncheries[$annonceId])){
        continue;
    }

    // Mémoriser cette annonce
    $annoncesEncheries[$annonceId] = $annonce;

    // Récupérer la meilleure enchère actuelle
    $meilleureEnchere = $enchere->getMeilleureEnchere($annonceId);

    // Stocker le prix courant
    if($meilleureEnchere){
        $prixCourants[$annonceId] = $meilleureEnchere->value("montant");

        // Vérifier si l'utilisateur est le mieux disant
        if(
            $meilleureEnchere->value("utilisateur_id")== $utilisateur->id()
        ){
            $statutsEncheres[$annonceId] =
                "🟢 <span style='color: green;font-weight: bold;'>Vous êtes le mieux disant</span>";
        }else{
            $statutsEncheres[$annonceId] =
                "🔴 <span style='color: red; font-weight: bold;'>Vous n'êtes plus le mieux disant</span>";
        }
    }
}

/*=========================================================
          Récuperer les encheres remportées
===========================================================*/

foreach($annoncesEncheries as $annonceId => $annonce){

    // Récupérer la meilleure enchère
    $meilleureEnchere = $enchere->getMeilleureEnchere($annonceId);

    // Vérifier que la vente est terminée
    if(strtotime($annonce->value("date_fin")) <= time()){

        /* Vérifier qu'il existe une enchère*/
        if($meilleureEnchere){

            /*Vérifier que le gagnant est l'utilisateur connecté*/
            if(
                $meilleureEnchere->value("utilisateur_id") == $utilisateur->id()
            ){
                /*Ajouter l'annonce aux enchères remportées*/
                $encheresRemportees[$annonceId] = $annonce;
            }
        }
    }
}

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